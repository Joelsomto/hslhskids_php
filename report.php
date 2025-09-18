<?php
require_once 'include/Session.php';
require_once 'include/Controller.php';
$Controller = new Controller;

// Month filter from query param ?month=Jan|Feb...
$filterMonth = null;
if (isset($_GET['month'])) {
    $m = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $_GET['month']), 0, 3));
    $valid = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
    if (in_array($m, $valid, true)) {
        // keep original case like Jan
        $map = [
            'JAN'=>'Jan','FEB'=>'Feb','MAR'=>'Mar','APR'=>'Apr','MAY'=>'May','JUN'=>'Jun',
            'JUL'=>'Jul','AUG'=>'Aug','SEP'=>'Sep','OCT'=>'Oct','NOV'=>'Nov','DEC'=>'Dec'
        ];
        $filterMonth = $map[$m];
    }
}

$reportsData = $Controller->getReports($filterMonth);

// Load location data
$dir = __DIR__;
$zonesData = json_decode(file_get_contents($dir . '/./data/zones.json'), true);
$countriesData = json_decode(file_get_contents($dir . '/./data/countries.json'), true);
$statesData = json_decode(file_get_contents($dir . '/./data/states.json'), true);

function extractTableData($jsonArray, $tableName) {
    if (is_array($jsonArray)) {
        foreach ($jsonArray as $item) {
            if (isset($item['type'], $item['name'], $item['data']) && 
                $item['type'] === 'table' && 
                $item['name'] === $tableName) {
                return $item['data'];
            }
        }
    }
    return null;
}

$zones = extractTableData($zonesData, 'zones') ?: [];
$countries = extractTableData($countriesData, 'countries') ?: [];
$states = extractTableData($statesData, 'states') ?: [];

// Create lookup arrays for easier access
$zoneLookup = [];
foreach ($zones as $zone) {
    $zoneLookup[$zone['zone_id']] = $zone['zone_name'];
}

$countryLookup = [];
foreach ($countries as $country) {
    $countryLookup[$country['country_id']] = $country['country_name'];
}

$stateLookup = [];
foreach ($states as $state) {
    $stateLookup[$state['state_id']] = $state['state_name'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HSLHS Kids Registration Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .report-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .report-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .report-section {
            margin-bottom: 40px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .filters { display:flex; align-items:center; gap:12px; margin:10px 0; }
        .filters select { padding:6px 10px; }
        .section-title {
            border-bottom: 2px solid #4a90e2;
            padding-bottom: 10px;
            color: #4a90e2;
        }
        .summary-stats {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin: 20px 0;
        }
        .stat-card {
            background: white;
            border-radius: 5px;
            padding: 15px;
            margin: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
            min-width: 200px;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #4a90e2;
        }
        .stat-label {
            color: #666;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4a90e2;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
            background-color: #e6f0ff !important;
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="report-header">
            <h1>HSLHS Kids Registration Report</h1>
            <p>As of <?php echo date('F j, Y'); ?></p>
        </div>

        <!-- Summary Registration Section -->
        <div class="report-section">
            <h2 class="section-title">1. Summary Registration</h2>
            <div class="filters">
                <form method="get">
                    <label for="month">Filter by month:</label>
                    <select name="month" id="month" onchange="this.form.submit()">
                        <?php $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                        $sel = $filterMonth ?: ''; foreach ($months as $m): ?>
                        <option value="<?php echo $m; ?>" <?php echo ($sel===$m)?'selected':''; ?>><?php echo $m; ?></option>
                        <?php endforeach; ?>
                        <option value="" <?php echo $sel===''?'selected':''; ?>>All</option>
                    </select>
                    <noscript><button type="submit">Apply</button></noscript>
                </form>
            </div>
            <div class="summary-stats">
                <div class="stat-card">
                    <div class="stat-value"><?php echo $reportsData['total_registrations'] ?? 0; ?></div>
                    <div class="stat-label">Total Registrations</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $reportsData['total_countries'] ?? 0; ?></div>
                    <div class="stat-label">Countries</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $reportsData['total_states'] ?? 0; ?></div>
                    <div class="stat-label">States/Provinces</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $reportsData['total_cities'] ?? 0; ?></div>
                    <div class="stat-label">Cities</div>
                </div>
            </div>
        </div>

        <!-- Breakdown by Zones Section -->
        <div class="report-section">
            <h2 class="section-title">2. Breakdown by Zones</h2>
            <table>
                <thead>
                    <tr>
                        <th>Zone</th>
                        <th>Total Registrations</th>
                        <th>Countries</th>
                        <th>States/Provinces</th>
                        <th>Cities</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($reportsData['zones'])): ?>
                        <?php foreach ($reportsData['zones'] as $zone): ?>
                            <tr>
                                <td><?php echo $zoneLookup[$zone['zone_id']] ?? 'Unknown Zone'; ?></td>
                                <td><?php echo $zone['total_registrations']; ?></td>
                                <td><?php echo $zone['total_countries']; ?></td>
                                <td><?php echo $zone['total_states']; ?></td>
                                <td><?php echo $zone['total_cities']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="total-row">
                            <td>Total</td>
                            <td><?php echo array_sum(array_column($reportsData['zones'], 'total_registrations')); ?></td>
                            <td><?php echo array_sum(array_column($reportsData['zones'], 'total_countries')); ?></td>
                            <td><?php echo array_sum(array_column($reportsData['zones'], 'total_states')); ?></td>
                            <td><?php echo array_sum(array_column($reportsData['zones'], 'total_cities')); ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">No zone data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Breakdown by Countries Section -->
        <div class="report-section">
            <h2 class="section-title">3. Breakdown by Countries</h2>
            <table>
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>Zone</th>
                        <th>Total Registrations</th>
                        <th>States/Provinces</th>
                        <th>Cities</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($reportsData['countries'])): ?>
                        <?php foreach ($reportsData['countries'] as $country): ?>
                            <tr>
                                <td><?php echo $countryLookup[$country['country_id']] ?? 'Unknown Country'; ?></td>
                                <td><?php echo $zoneLookup[$country['zone_id']] ?? 'Unknown Zone'; ?></td>
                                <td><?php echo $country['total_registrations']; ?></td>
                                <td><?php echo $country['total_states']; ?></td>
                                <td><?php echo $country['total_cities']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="total-row">
                            <td colspan="2">Total</td>
                            <td><?php echo array_sum(array_column($reportsData['countries'], 'total_registrations')); ?></td>
                            <td><?php echo array_sum(array_column($reportsData['countries'], 'total_states')); ?></td>
                            <td><?php echo array_sum(array_column($reportsData['countries'], 'total_cities')); ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">No country data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>