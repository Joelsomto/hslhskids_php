<?php
header('Content-Type: application/json');
require_once __DIR__ . '/include/Controller.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['id']) && isset($data['is_email'])) {
    $controller = new Controller();
    $success = $controller->markMagazineDownloaded($data['id'], $data['is_email']);
    
    echo json_encode(['success' => $success]);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}