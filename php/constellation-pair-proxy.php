<?php



header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');


$msg = $_REQUEST['msg'] ?? '';
$time = $_REQUEST['time'] ?? 'today';
$type = $_REQUEST['type'] ?? 'json';


if (empty($msg)) {
    echo json_encode(['status' => 'error', 'message' => '缺少必填参数msg']);
    exit;
}


$apiUrl = 'https://api.jkyai.top/API/xzyspd.php';
$params = [
    'msg' => $msg,
    'time' => $time,
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
    echo json_encode(['status' => 'error', 'message' => '请求失败: ' . $curlError]);
    exit;
}

if ($httpCode != 200) {
    echo json_encode(['status' => 'error', 'message' => 'HTTP错误: ' . $httpCode]);
    exit;
}


if ($type === 'json') {

    $jsonResponse = json_decode($response, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo json_encode($jsonResponse);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'API返回格式错误']);
    }
} else {

    echo $response;
}
?>