<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

$word = isset($_GET['word']) ? $_GET['word'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : '1';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

if (empty($word)) {
    echo json_encode([
        'code' => 400,
        'msg' => '台词不能为空',
        'data' => []
    ]);
    exit;
}

$apiUrl = 'https://api.pearktrue.cn/api/media/lines.php';

$requestUrl = $apiUrl . '?word=' . urlencode($word) . '&page=' . urlencode($page);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $requestUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json,text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
    'Accept-Language: zh-CN,zh;q=0.9,en;q=0.8',
    'Cache-Control: no-cache',
    'Connection: keep-alive',
    'Pragma: no-cache',
    'Referer: https://api.pearktrue.cn/',
    'Origin: https://api.pearktrue.cn/',
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
        'debug' => [
            'api_url' => $apiUrl,
            'curl_error' => $curlError,
            'http_code' => $httpCode
        ]
    ]);
} else {
    $json = json_decode($response, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        http_response_code($httpCode);
        echo $response;
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