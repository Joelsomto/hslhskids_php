<?php
require_once('Crud.php');

class Controller
{
    private $crud;

    public function __construct()
    {
        $this->crud = new Crud();
        $this->ensureRegistrationMetaTable();
    }

    public function registerUser($data)
    {
        $table = "users";
        $lastInsertedId = $this->crud->create($data, $table);
        return $lastInsertedId;
    }
    public function participants($data)
    {
        $table = "hslhs_kids_participants";
        $lastInsertedId = $this->crud->create($data, $table);
        return $lastInsertedId;
    }

    public function getUserIdByEmail($email)
    {
        $sql = "SELECT id FROM hslhs_kids_email WHERE email = :email LIMIT 1";
        $result = $this->crud->read($sql, [':email' => $email]);
        return $result[0]['id'] ?? null;
    }

    public function getTodaysParticipation($userId, $userType)
    {
        $today = date('Y-m-d');
        $sql = "SELECT id FROM hslhs_kids_participants 
            WHERE user_id = :user_id 
            AND user_type = :user_type 
            AND participation_date = :today 
            LIMIT 1";

        $params = [
            ':user_id' => $userId,
            ':user_type' => $userType,
            ':today' => $today
        ];

        $result = $this->crud->read($sql, $params);
        return $result[0] ?? null;
    }

    public function updateParticipation($id, $data)
    {
        // Prepare the SET part of the SQL query
        $setParts = [];
        $params = [':id' => $id];
        
        foreach ($data as $key => $value) {
            $paramName = ':' . $key;
            $setParts[] = "`$key` = $paramName";
            $params[$paramName] = $value;
        }
        
        $setClause = implode(', ', $setParts);
        
        $sql = "UPDATE hslhs_kids_participants SET $setClause WHERE id = :id";
        
        return $this->crud->update($sql, $params);
    }
    public function registerKIds($data)
    {
        if (isset($data['email'])) {
            unset($data['phone'], $data['country_code']);
            $table = "hslhs_kids_email";
        } elseif (isset($data['phone'])) {
            unset($data['email']); // if not needed
            $table = "hslhs_kids_phone";
        } else {
            throw new Exception("No valid contact method found.");
        }

        $insertId = $this->crud->create($data, $table);

        // Save registration month meta
        try {
            $regMonth = date('M'); 
            $this->addRegistrationMeta($table === 'hslhs_kids_email' ? 'email' : 'phone', (int)$insertId, $regMonth);
        } catch (Exception $e) {
            // swallow meta errors to not block registration
        }

        return $insertId;
    }

    public function addRegistrationMeta($regTable, $regId, $regMonth)
    {
        $meta = [
            'reg_table' => $regTable,
            'reg_id' => (int)$regId,
            'reg_month' => $regMonth,
        ];
        return $this->crud->create($meta, 'hslhs_kids_registration_meta');
    }

    private function ensureRegistrationMetaTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS hslhs_kids_registration_meta (
            id INT AUTO_INCREMENT PRIMARY KEY,
            reg_table ENUM('email','phone') NOT NULL,
            reg_id INT NOT NULL,
            reg_month CHAR(3) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            KEY idx_reg (reg_table, reg_id),
            KEY idx_month (reg_month)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $this->crud->update($sql, []);
    }



    public function checkExistingUser($email = null, $phone = null, $countryCode = null)
    {
        if ($email) {
            // Check in hslhs_kids_email table
            $sql = "SELECT id FROM hslhs_kids_email WHERE email = :email LIMIT 1";
            $params = [':email' => $email];
        } elseif ($phone && $countryCode) {
            // Check in hslhs_kids_phone table
            $sql = "SELECT id FROM hslhs_kids_phone WHERE phone = :phone AND country_code = :country_code LIMIT 1";
            $params = [
                ':phone' => $phone,
                ':country_code' => $countryCode
            ];
        } else {
            // Neither email nor phone provided
            return false;
        }

        $result = $this->crud->read($sql, $params);
        return !empty($result); // true if exists
    }

    public function getReports($filterMonth = null)
    {
        // Initialize the reports data array
        $reportsData = [];

        // 1. Get total summary statistics (combining both email and phone tables)
        $whereMonthEmail = '';
        $whereMonthPhone = '';
        $params = [];
        if ($filterMonth) {
            $whereMonthEmail = "INNER JOIN hslhs_kids_registration_meta m1 ON m1.reg_table='email' AND m1.reg_id=e.id AND m1.reg_month = :m";
            $whereMonthPhone = "INNER JOIN hslhs_kids_registration_meta m2 ON m2.reg_table='phone' AND m2.reg_id=p.id AND m2.reg_month = :m";
            $params[':m'] = $filterMonth;
        }

        $summaryQuery = "
        SELECT 
            COUNT(*) as total_registrations,
            COUNT(DISTINCT country_id) as total_countries,
            COUNT(DISTINCT state_id) as total_states,
            COUNT(DISTINCT city) as total_cities
        FROM (
            SELECT e.country_id, e.state_id, e.city FROM hslhs_kids_email e $whereMonthEmail
            UNION ALL
            SELECT p.country_id, p.state_id, p.city FROM hslhs_kids_phone p $whereMonthPhone
        ) as combined
    ";

        $summaryResult = $this->crud->read($summaryQuery, $params);
        if (!empty($summaryResult)) {
            $reportsData = array_merge($reportsData, $summaryResult[0]);
        }

        // 2. Get breakdown by zones
        $zonesQuery = "
        SELECT 
            zone_id,
            COUNT(*) as total_registrations,
            COUNT(DISTINCT country_id) as total_countries,
            COUNT(DISTINCT state_id) as total_states,
            COUNT(DISTINCT city) as total_cities
        FROM (
            SELECT e.zone_id, e.country_id, e.state_id, e.city FROM hslhs_kids_email e $whereMonthEmail
            UNION ALL
            SELECT p.zone_id, p.country_id, p.state_id, p.city FROM hslhs_kids_phone p $whereMonthPhone
        ) as combined
        GROUP BY zone_id
        ORDER BY total_registrations DESC
    ";

        $zonesResult = $this->crud->read($zonesQuery, $params);
        if (!empty($zonesResult)) {
            $reportsData['zones'] = $zonesResult;
        }

        // 3. Get breakdown by countries
        $countriesQuery = "
        SELECT 
            country_id,
            zone_id,
            COUNT(*) as total_registrations,
            COUNT(DISTINCT state_id) as total_states,
            COUNT(DISTINCT city) as total_cities
        FROM (
            SELECT e.country_id, e.zone_id, e.state_id, e.city FROM hslhs_kids_email e $whereMonthEmail
            UNION ALL
            SELECT p.country_id, p.zone_id, p.state_id, p.city FROM hslhs_kids_phone p $whereMonthPhone
        ) as combined
        GROUP BY country_id, zone_id
        ORDER BY total_registrations DESC
    ";

        $countriesResult = $this->crud->read($countriesQuery, $params);
        if (!empty($countriesResult)) {
            $reportsData['countries'] = $countriesResult;
        }

        return $reportsData;
    }
    // public function getReports()
    // {
    //     // Load JSON data with error handling
    //     $dir = __DIR__;
    //     $zones = $this->loadJsonData($dir . '/../data/zones.json', 'zones');
    //     $countries = $this->loadJsonData($dir . '/../data/countries.json', 'countries');
    //     $states = $this->loadJsonData($dir . '/../data/states.json', 'states');

    //     // Create lookup arrays
    //     $zoneLookup = array_column($zones, 'zone_name', 'zone_id');
    //     $countryLookup = array_column($countries, 'country_name', 'country_id');
    //     $stateLookup = array_column($states, 'state_name', 'state_id');

    //     // Get aggregated counts (optimized queries)
    //     $totals = $this->getRegistrationTotals();

    //     // Get zone statistics with country breakdown
    //     $zoneStats = $this->getZoneStatisticsWithCountries($zones, $countryLookup);

    //     // Get top countries
    //     $topCountries = $this->getTopCountries(7);

    //     return [
    //         'total_registrations' => $totals['total_registrations'],
    //         'registration_growth' => rand(5, 20),
    //         'total_countries' => $totals['total_countries'],
    //         'new_countries' => rand(1, 5),
    //         'total_states' => $totals['total_states'],
    //         'state_growth' => rand(5, 15),
    //         'total_cities' => $totals['total_cities'],
    //         'city_growth' => rand(10, 20),
    //         'zones' => $zoneStats['zones'],
    //         'zone_countries' => $zoneStats['zone_countries'],
    //         'top_countries' => $topCountries
    //     ];
    // }

    // private function getRegistrationTotals()
    // {
    //     // Optimized query to get all counts in one go
    //     $sql = "
    //         SELECT 
    //             (SELECT COUNT(*) FROM hslhs_kids_email) + 
    //             (SELECT COUNT(*) FROM hslhs_kids_phone) as total_registrations,

    //             (SELECT COUNT(DISTINCT country_id) FROM (
    //                 SELECT country_id FROM hslhs_kids_email
    //                 UNION
    //                 SELECT country_id FROM hslhs_kids_phone
    //             ) as countries) as total_countries,

    //             (SELECT COUNT(DISTINCT state_id) FROM (
    //                 SELECT state_id FROM hslhs_kids_email
    //                 UNION
    //                 SELECT state_id FROM hslhs_kids_phone
    //             ) as states) as total_states,

    //             (SELECT COUNT(DISTINCT city) FROM (
    //                 SELECT city FROM hslhs_kids_email
    //                 UNION
    //                 SELECT city FROM hslhs_kids_phone
    //             ) as cities) as total_cities
    //     ";

    //     $result = $this->crud->read($sql);
    //     return $result[0] ?? [
    //         'total_registrations' => 0,
    //         'total_countries' => 0,
    //         'total_states' => 0,
    //         'total_cities' => 0
    //     ];
    // }

    // private function getTopCountries($limit)
    // {
    //     $limit = (int) $limit; // Ensure it's an integer
    //     $sql = "
    //         SELECT 
    //             country_id,
    //             COUNT(*) as registrations
    //         FROM (
    //             SELECT country_id FROM hslhs_kids_email
    //             UNION ALL
    //             SELECT country_id FROM hslhs_kids_phone
    //         ) as combined
    //         GROUP BY country_id
    //         ORDER BY registrations DESC
    //         LIMIT $limit
    //     ";

    //     $topCountries = $this->crud->read($sql) ?: [];


    //     // Get country names from JSON data
    //     $countries = $this->loadJsonData(__DIR__ . '/../data/countries.json', 'countries');
    //     $countryLookup = array_column($countries, 'country_name', 'country_id');

    //     // Prepare final output
    //     $result = [];
    //     foreach ($topCountries as $country) {
    //         $result[] = [
    //             'country_id' => $country['country_id'],
    //             'country_name' => $countryLookup[$country['country_id']] ?? 'Unknown',
    //             'registrations' => $country['registrations']
    //         ];
    //     }

    //     return $result;
    // }

    // private function getZoneStatisticsWithCountries($zones, $countryLookup)
    // {
    //     // Get registration counts by zone and country
    //     $sql = "
    //         SELECT 
    //             zone_id,
    //             country_id,
    //             COUNT(*) as registrations,
    //             COUNT(DISTINCT state_id) as states,
    //             COUNT(DISTINCT city) as cities
    //         FROM (
    //             SELECT zone_id, country_id, state_id, city FROM hslhs_kids_email
    //             UNION ALL
    //             SELECT zone_id, country_id, state_id, city FROM hslhs_kids_phone
    //         ) as combined
    //         GROUP BY zone_id, country_id
    //         ORDER BY zone_id, registrations DESC
    //     ";

    //     $zoneCountryCounts = $this->crud->read($sql) ?: [];

    //     // Organize by zone
    //     $zoneCountryStats = [];
    //     foreach ($zoneCountryCounts as $item) {
    //         $zoneId = $item['zone_id'];
    //         if (!isset($zoneCountryStats[$zoneId])) {
    //             $zoneCountryStats[$zoneId] = [];
    //         }

    //         $zoneCountryStats[$zoneId][] = [
    //             'country_id' => $item['country_id'],
    //             'country_name' => $countryLookup[$item['country_id']] ?? 'Unknown',
    //             'registrations' => $item['registrations'],
    //             'states' => $item['states'],
    //             'cities' => $item['cities']
    //         ];
    //     }

    //     // Prepare zone summary data
    //     $zoneStats = [];
    //     foreach ($zones as $zone) {
    //         $zoneId = $zone['zone_id'];
    //         $countryStats = $zoneCountryStats[$zoneId] ?? [];

    //         $totalReg = array_sum(array_column($countryStats, 'registrations'));
    //         $totalCountries = count($countryStats);
    //         $totalStates = array_sum(array_column($countryStats, 'states'));
    //         $totalCities = array_sum(array_column($countryStats, 'cities'));

    //         $zoneStats[] = [
    //             'zone_id' => $zoneId,
    //             'zone_name' => $zone['zone_name'],
    //             'registrations' => $totalReg,
    //             'countries' => $totalCountries,
    //             'states' => $totalStates,
    //             'cities' => $totalCities,
    //             'growth' => rand(5, 20)
    //         ];
    //     }

    //     return [
    //         'zones' => $zoneStats,
    //         'zone_countries' => $zoneCountryStats
    //     ];
    // }

    // private function loadJsonData($file, $tableName)
    // {
    //     if (!file_exists($file)) {
    //         throw new Exception("JSON file not found: " . $file);
    //     }

    //     $data = json_decode(file_get_contents($file), true);
    //     if (json_last_error() !== JSON_ERROR_NONE) {
    //         throw new Exception("Invalid JSON in file: " . $file);
    //     }

    //     return $this->extractTableData($data, $tableName) ?: [];
    // }

    // private function extractTableData($jsonArray, $tableName)
    // {
    //     if (is_array($jsonArray)) {
    //         foreach ($jsonArray as $item) {
    //             if (
    //                 isset($item['type'], $item['name'], $item['data']) &&
    //                 $item['type'] === 'table' &&
    //                 $item['name'] === $tableName
    //             ) {
    //                 return $item['data'];
    //             }
    //         }
    //     }
    //     return null;
    // }

    public function getStreams()
    {
        date_default_timezone_set('Africa/Lagos');

        $current_time = date("Y-m-d H:i:s");

        // Fetch video names and episodes from the database
        $sql = "SELECT * FROM stream WHERE '$current_time'  > time ORDER BY id DESC LIMIT 1  ";
        $result = $this->crud->read($sql);
        return !empty($result); // true if exists
    }
}
