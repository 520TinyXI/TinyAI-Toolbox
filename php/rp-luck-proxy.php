<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $name = isset($_GET['name']) ? trim($_GET['name']) : '';
    
    if (empty($name)) {
        http_response_code(400);
        echo json_encode([
            'code' => -1,
            'message' => 'Missing \'name\' parameter.'
        ]);
        exit();
    }
    
    $apiUrl = 'https://api.lolimi.cn/API/Ren/api.php';
    $queryParams = http_build_query(['name' => $name, 'type' => 'json']);
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
            'User-Agent: RPLuckQuery/1.0'
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
            'message' => 'Failed to query luck data.'
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