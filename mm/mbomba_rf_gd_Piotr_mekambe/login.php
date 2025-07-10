<?php

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$licenseKey = $data['licenseKey'] ?? '';
$deviceId = $data['deviceId'] ?? null;

if (!$licenseKey || !$deviceId) {
    http_response_code(400);
    echo json_encode(['message' => 'Brak danych lub brak identyfikatora urządzenia']);
    exit;
}

$usersFile = __DIR__ . '/users.json';
$users = json_decode(file_get_contents($usersFile), true);

if (!isset($users[$licenseKey])) {
    http_response_code(401);
    echo json_encode(['message' => 'Nieprawidłowy klucz licencyjny']);
    exit;
}

if ($users[$licenseKey]['deviceId']) {
    if ($users[$licenseKey]['deviceId'] !== $deviceId) {
        http_response_code(403);
        echo json_encode([
            'message' => 'Ten klucz licencyjny jest już przypisany do innego urządzenia.'
        ]);
        exit;
    }
} else {
    $users[$licenseKey]['deviceId'] = $deviceId;
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
}

echo json_encode(['message' => 'Dostęp przyznany']);
