<?php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$search = $_REQUEST['search'] ?? '';
$type = $_REQUEST['type'] ?? 'json';

if (empty($search)) {
    echo json_encode([
        'success' => false,
        'message' => '缺少必填参数search'
    ]);
    exit;
}

$apiUrl = 'https://api.jkyai.top/API/kkmhss.php';
$params = [
    'search' => $search,
    'type' => $type
];

$requestUrl = $apiUrl . '?' . http_build_query($params);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $requestUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);

curl_close($ch);

if ($curlError) {
    echo json_encode([
        'success' => false,
        'message' => '请求失败: ' . $curlError
    ]);
    exit;
}

if ($httpCode != 200) {
    echo json_encode([
        'success' => false,
        'message' => 'HTTP错误! 状态码: ' . $httpCode
    ]);
    exit;
}

if ($type === 'json') {
    $jsonResponse = json_decode($response, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo json_encode($jsonResponse);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'API返回格式错误'
        ]);
    }
} else {
    echo $response;
}
?>