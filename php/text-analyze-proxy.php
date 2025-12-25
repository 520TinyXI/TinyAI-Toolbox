<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!isset($data['text']) || empty(trim($data['text']))) {
        http_response_code(400);
        echo json_encode([
            'code' => 'INVALID_ARGUMENT',
            'message' => 'Request body is invalid or text is empty.'
        ]);
        exit();
    }
    
    $apiUrl = 'https://uapis.cn/api/v1/text/analyze';
    $postData = json_encode(['text' => $data['text']]);
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postData),
            'Accept: application/json',
            'User-Agent: TextAnalyzerClient/1.0'
        ],
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => false
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($response === false) {
        http_response_code(500);
        echo json_encode([
            'code' => 'REQUEST_FAILED',
            'message' => 'Request to API failed: ' . $error
        ]);
        exit();
    }
    
    if ($httpCode >= 400) {
        http_response_code(500);
        echo json_encode([
            'code' => 'API_ERROR',
            'message' => 'API returned error status code: ' . $httpCode,
            'api_response' => $response
        ]);
        exit();
    }
    
    http_response_code(200);
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