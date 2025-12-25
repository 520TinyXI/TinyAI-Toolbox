<?php


header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');


ini_set('display_errors', 0);
error_reporting(E_ALL);


if (!isset($_GET['from']) || !isset($_GET['to'])) {
    http_response_code(400);
    echo json_encode([
        'code' => 400,
        'msg' => '缺少必填参数from或to'
    ]);
    exit;
}

$from = $_GET['from'];
$to = $_GET['to'];


$apiUrl = 'https://api.pearktrue.cn/api/citytravelroutes/?from=' . urlencode($from) . '&to=' . urlencode($to);


$ch = curl_init();


curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HEADER, true);


$response = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
curl_close($ch);


$header = substr($response, 0, $headerSize);
$body = substr($response, $headerSize);


if ($curlError) {
    http_response_code(500);
    echo json_encode([
        'code' => 500,
        'msg' => 'API请求失败: ' . $curlError,
        'debug' => [
            'api_url' => $apiUrl,
            'curl_error' => $curlError,
            'http_code' => $httpCode
        ]
    ]);
} else {

    http_response_code($httpCode);
    echo $body;
}