<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

ini_set('display_errors', 0);
error_reporting(E_ALL);

$apiUrl = 'https://api.pearktrue.cn/api/maoyan/';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HEADER, false);

$response = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($curlError) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'API请求失败: ' . $curlError,
        'code' => 500,
        'debug' => [
            'api_url' => $apiUrl,
            'curl_error' => $curlError,
            'http_code' => $httpCode
        ]
    ]);
} else {
    $apiResponse = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code($httpCode);
        echo json_encode([
            'success' => false,
            'message' => 'API返回无效响应',
            'code' => $httpCode,
            'raw_response' => $response
        ]);
    } else {
        http_response_code($httpCode);
        echo json_encode([
            'success' => true,
            'code' => $apiResponse['code'] ?? $httpCode,
            'message' => $apiResponse['msg'] ?? '获取成功',
            'time' => $apiResponse['time'] ?? '',
            'data' => $apiResponse['data'] ?? []
        ]);
    }
}
