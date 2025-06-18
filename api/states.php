<?php
// states.php
header('Content-Type: application/json');

$dir = __DIR__;
$statesFile = $dir . '/../data/states.json';

if (isset($_GET['country_id'])) {
    $statesRaw = json_decode(file_get_contents($statesFile), true);

    $statesData = [];
    if (is_array($statesRaw)) {
        foreach ($statesRaw as $item) {
            if (
                isset($item['type'], $item['name']) &&
                $item['type'] === 'table' &&
                $item['name'] === 'states' &&
                isset($item['data']) &&
                is_array($item['data'])
            ) {
                $statesData = $item['data'];
                break;
            }
        }
    }

    if (!empty($statesData)) {
        $filteredStates = array_filter($statesData, function ($state) {
            return $state['country_id'] == $_GET['country_id'];
        });

        echo json_encode(array_values($filteredStates));
        exit;
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'States data not found.']);
        exit;
    }
}

// Return error if invalid request
http_response_code(400);
echo json_encode(['error' => 'Invalid request']);
