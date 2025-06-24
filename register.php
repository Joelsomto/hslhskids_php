<?php
// Absolute first line - no whitespace before!
header('Content-Type: application/json');
ob_start();

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Session handling
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include files
require_once __DIR__ . '/include/Session.php';
require_once __DIR__ . '/include/Functions.php';
require_once __DIR__ . '/include/Controller.php';

try {
    // Clean output buffer before processing
    ob_get_clean();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       

    $data = validateInput();
    $Controller = new Controller();
    
    // Check if user already exists
    $existingUser = $Controller->checkExistingUser($data['email'] ?? null, $data['phone'] ?? null,  $data['country_code'] ?? null);

    if ($existingUser) {
        throw new Exception(json_encode([
            'errors' => ['general' => 'You are already registered!'],
            'message' => 'This email or phone number is already registered'
        ]), 409); // 409 Conflict status code
    }
    
    $registrationId = $Controller->registerKIds($data);

    echo json_encode([
        'success' => true,
        'message' => 'Registration successful',
        'registration_id' => $registrationId
    ]);
    exit;
}

} catch (Exception $e) {
    // Clean any output
    ob_end_clean();

    $code = $e->getCode() ?: 400;
    http_response_code($code);
    
    $message = $e->getMessage();
    $decoded = json_decode($message, true);
    
    echo json_encode([
        'success' => false,
        'message' => $decoded ?: ['message' => $message]
    ]);
    exit;
}

function validateInput() {
    $requiredFields = ['fullname', 'zone_id', 'age', 'country_id', 'state_id', 'city'];
    $data = [];
    $errors = [];

    // Check if using email or phone
    $usingEmail = !empty($_POST['email']);
    $usingPhone = !empty($_POST['phone']);

    if (!$usingEmail && !$usingPhone) {
        $errors['general'] = "Either email or phone number is required";
    }

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = "This field is required";
        }
    }

    if ($usingEmail) {
        $data['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    }

    if ($usingPhone) {
        $phone = preg_replace('/[^0-9]/', '', $_POST['phone']);
        $data['phone'] = $phone;

        // Only add country_code if phone is used
        if (!empty($_POST['country_code'])) {
            $data['country_code'] = filter_var($_POST['country_code'], FILTER_SANITIZE_STRING);
        }
    }

    $data['fullname'] = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
    $data['zone_id'] = filter_var($_POST['zone_id'], FILTER_VALIDATE_INT);
    $data['age'] = filter_var($_POST['age'], FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 12]
    ]);
    $data['country_id'] = filter_var($_POST['country_id'], FILTER_VALIDATE_INT);
    $data['state_id'] = filter_var($_POST['state_id'], FILTER_VALIDATE_INT);
    $data['city'] = filter_var($_POST['city'], FILTER_SANITIZE_STRING);

    if (!empty($errors)) {
        throw new Exception(json_encode([
            'errors' => $errors,
            'message' => 'Validation failed'
        ]), 400);
    }

    $data['created_at'] = date('Y-m-d H:i:s');
    return $data;
}
