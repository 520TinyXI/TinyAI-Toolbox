<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$min = isset($_REQUEST['min']) ? $_REQUEST['min'] : 1;
$max = isset($_REQUEST['max']) ? $_REQUEST['max'] : 100;
$count = isset($_REQUEST['count']) ? $_REQUEST['count'] : 1;
$allowRepeat = isset($_REQUEST['allow_repeat']) ? ($_REQUEST['allow_repeat'] === 'true' ? true : false) : true;
$allowDecimal = isset($_REQUEST['allow_decimal']) ? ($_REQUEST['allow_decimal'] === 'true' ? true : false) : false;
$decimalPlaces = isset($_REQUEST['decimal_places']) ? $_REQUEST['decimal_places'] : 2;

$apiUrl = 'https://uapis.cn/api/v1/misc/randomnumber';

$params = [
    'min' => $min,
    'max' => $max,
    'count' => $count,
    'allow_repeat' => $allowRepeat,
    'allow_decimal' => $allowDecimal,
    'decimal_places' => $decimalPlaces
];

$requestUrl = $apiUrl . '?' . http_build_query($params);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $requestUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
]);

$response = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($curlError) {
    echo json_encode([
        'code' => 500,
        'msg' => 'API请求失败: ' . $curlError,
        'data' => []
    ]);
} else {
    $json = json_decode($response, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        if ($httpCode >= 400) {
            http_response_code(500);
            echo json_encode([
                'code' => 500,
                'msg' => 'API请求失败: ' . ($json['message'] ?? 'Unknown error'),
                'debug' => [
                    'api_url' => $apiUrl,
                    'http_code' => $httpCode
                ]
            ]);
        } else {
            http_response_code($httpCode);
            echo $response;
        }
    } else {
        http_response_code(500);
        echo json_encode([
            'code' => 500,
            'msg' => 'API返回无效JSON格式',
            'debug' => [
                'api_url' => $apiUrl,
                'http_code' => $httpCode,
                'response_sample' => substr($response, 0, 200) . '...',
                'json_error' => json_last_error_msg()
            ]
        ]);
    }
}