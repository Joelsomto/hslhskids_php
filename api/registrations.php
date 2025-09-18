<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../include/Controller.php';
require_once __DIR__ . '/../include/ApiAuth.php';
require_once __DIR__ . '/../include/Dbconfig.php';

ApiAuth::requireApiKey();

$controller = new Controller();
$crud = new Crud();

function respond($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET') {
        // List registrations with filters
        $zoneId = isset($_GET['zone_id']) ? (int)$_GET['zone_id'] : null;
        $month = isset($_GET['month']) ? substr(preg_replace('/[^A-Za-z]/', '', $_GET['month']), 0, 3) : null;
        $type = isset($_GET['type']) && in_array($_GET['type'], ['email','phone'], true) ? $_GET['type'] : null;
        $limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 100;
        $offset = isset($_GET['offset']) ? max(0, (int)$_GET['offset']) : 0;

        $params = [];
        $joins = '';
        $wheres = [];

        if ($month) {
            $joinsEmail = "INNER JOIN hslhs_kids_registration_meta m1 ON m1.reg_table='email' AND m1.reg_id=e.id AND m1.reg_month = :m";
            $joinsPhone = "INNER JOIN hslhs_kids_registration_meta m2 ON m2.reg_table='phone' AND m2.reg_id=p.id AND m2.reg_month = :m";
            $params[':m'] = $month;
        } else {
            $joinsEmail = '';
            $joinsPhone = '';
        }

        $zoneFilter = $zoneId ? ' WHERE zone_id = :z' : '';
        if ($zoneId) $params[':z'] = $zoneId;

        $limitClause = " LIMIT $offset, $limit";

        if ($type === 'email') {
            $sql = "SELECT e.*,'email' as contact_type FROM hslhs_kids_email e $joinsEmail" . $zoneFilter . $limitClause;
        } elseif ($type === 'phone') {
            $sql = "SELECT p.*,'phone' as contact_type FROM hslhs_kids_phone p $joinsPhone" . $zoneFilter . $limitClause;
        } else {
            $sql = "SELECT * FROM (
                SELECT e.*,'email' as contact_type FROM hslhs_kids_email e $joinsEmail
                UNION ALL
                SELECT p.*,'phone' as contact_type FROM hslhs_kids_phone p $joinsPhone
            ) as combined" . ($zoneId ? ' WHERE zone_id = :z' : '') . $limitClause;
        }

        $rows = $crud->read($sql, $params);
        respond(['success' => true, 'data' => $rows]);
    }

    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) { $input = []; }

    if ($method === 'POST') {
        // Create new registration via existing controller
        $data = [
            'fullname' => $input['fullname'] ?? null,
            'zone_id' => isset($input['zone_id']) ? (int)$input['zone_id'] : null,
            'age' => isset($input['age']) ? (int)$input['age'] : null,
            'country_id' => isset($input['country_id']) ? (int)$input['country_id'] : null,
            'state_id' => isset($input['state_id']) ? (int)$input['state_id'] : null,
            'city' => $input['city'] ?? null,
            'created_at' => date('Y-m-d H:i:s')
        ];
        if (!empty($input['email'])) {
            $data['email'] = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
        } elseif (!empty($input['phone'])) {
            $data['phone'] = preg_replace('/[^0-9]/', '', $input['phone']);
            $data['country_code'] = isset($input['country_code']) ? preg_replace('/[^0-9+]/', '', $input['country_code']) : null;
        } else {
            respond(['success' => false, 'message' => 'email or phone required'], 400);
        }

        foreach (['fullname','zone_id','age','country_id','state_id','city'] as $f) {
            if ($data[$f] === null || $data[$f] === '') {
                respond(['success' => false, 'message' => "Missing field: $f"], 400);
            }
        }

        $id = $controller->registerKIds($data);
        respond(['success' => true, 'id' => $id]);
    }

    if ($method === 'PUT' || $method === 'PATCH') {
        $table = ($input['type'] ?? '') === 'email' ? 'hslhs_kids_email' : (($input['type'] ?? '') === 'phone' ? 'hslhs_kids_phone' : null);
        $id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($input['id']) ? (int)$input['id'] : 0);
        if (!$table || !$id) respond(['success' => false, 'message' => 'type (email|phone) and id required'], 400);

        $allowed = ['fullname','zone_id','age','country_id','state_id','city'];
        $set = [];
        $params = [':id' => $id];
        foreach ($allowed as $f) {
            if (array_key_exists($f, $input)) {
                $set[] = "$f = :$f";
                $params[":$f"] = $input[$f];
            }
        }
        if (!$set) respond(['success' => false, 'message' => 'No fields to update'], 400);
        $sql = "UPDATE $table SET " . implode(',', $set) . " WHERE id = :id";
        $ok = $crud->update($sql, $params);
        respond(['success' => $ok]);
    }

    if ($method === 'DELETE') {
        $type = isset($_GET['type']) ? $_GET['type'] : null;
        $table = $type === 'email' ? 'hslhs_kids_email' : ($type === 'phone' ? 'hslhs_kids_phone' : null);
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if (!$table || !$id) respond(['success' => false, 'message' => 'type (email|phone) and id required'], 400);
        $crud->delete("DELETE FROM $table WHERE id = :id", [':id' => $id]);
        respond(['success' => true]);
    }

    respond(['success' => false, 'message' => 'Method not allowed'], 405);
} catch (Exception $e) {
    respond(['success' => false, 'message' => $e->getMessage()], 500);
}

?>
