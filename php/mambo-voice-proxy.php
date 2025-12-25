<?php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$text = $_REQUEST['text'] ?? '';
$format = $_REQUEST['format'] ?? 'mp3';

if (empty($text)) {
    echo json_encode(['code' => 400, 'msg' => '缺少必填参数text']);
    exit;
}

$apiUrl = 'https://api.milorapart.top/apis/mbAIsc';
$params = [
    'text' => $text,
    'format' => $format
];

$requestUrl = $apiUrl . '?' . http_build_query($params);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $requestUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);

curl_close($ch);

if ($curlError) {
    echo json_encode(['code' => 500, 'msg' => '请求失败: ' . $curlError]);
    exit;
}

if ($httpCode != 200) {
    echo json_encode(['code' => $httpCode, 'msg' => 'HTTP错误: ' . $httpCode]);
    exit;
}

echo $response;
?>