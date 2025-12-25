<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $server = isset($_GET['server']) ? trim($_GET['server']) : '';
    
    if (empty($server)) {
        http_response_code(400);
        echo json_encode([
            'code' => 'INVALID_ARGUMENT',
            'message' => 'Missing \'server\' parameter.'
        ]);
        exit();
    }
    
    $apiUrl = 'https://uapis.cn/api/v1/game/minecraft/serverstatus';
    $queryParams = http_build_query(['server' => $server]);
    $fullUrl = "{$apiUrl}?{$queryParams}";
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $fullUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'User-Agent: MinecraftServerStatus/1.0'
        ]
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($response === false) {
        http_response_code(502);
        echo json_encode([
            'code' => 'UPSTREAM_ERROR',
            'message' => 'Failed to query server status.'
        ]);
        exit();
    }
    
    http_response_code($httpCode);
    header('Content-Type: application/json');
    echo $response;
    exit();
}

http_response_code(405);
echo json_encode([
    'code' => 'METHOD_NOT_ALLOWED',
    'message' => 'Method not allowed'
]);
?>