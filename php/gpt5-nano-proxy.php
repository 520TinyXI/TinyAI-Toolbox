<?php



header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');


$question = $_REQUEST['question'] ?? '';
$uid = $_REQUEST['uid'] ?? '';
$type = $_REQUEST['type'] ?? 'text';
$system = $_REQUEST['system'] ?? '';


if (empty($question)) {
    echo json_encode(['success' => 'error', 'content' => '缺少必填参数question']);
    exit;
}


$apiUrl = 'https://api.jkyai.top/API/gpt5-nano/index.php';
$params = [
    'question' => $question,
    'uid' => $uid,
    'type' => $type,
    'system' => $system
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
    echo json_encode(['success' => 'error', 'content' => '请求失败: ' . $curlError]);
    exit;
}

if ($httpCode != 200) {
    echo json_encode(['success' => 'error', 'content' => 'HTTP错误: ' . $httpCode]);
    exit;
}


if ($type === 'json') {

    $jsonResponse = json_decode($response, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo json_encode($jsonResponse);
    } else {
        echo json_encode(['success' => 'error', 'content' => 'API返回格式错误']);
    }
} else {

    echo $response;
}
?>