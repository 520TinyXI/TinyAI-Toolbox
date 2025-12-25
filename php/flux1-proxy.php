<?php



header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');


$prompt = $_REQUEST['prompt'] ?? '';
$size = $_REQUEST['size'] ?? '1024*1024';
$steps = $_REQUEST['steps'] ?? '4';
$type = $_REQUEST['type'] ?? 'json';


if (empty($prompt)) {
    echo json_encode([
        'error' => true,
        'message' => '缺少必填参数prompt',
        'data' => []
    ]);
    exit;
}


$allowedSizes = ['512*1024', '768*512', '768*1024', '1024*576', '576*1024', '1024*1024'];
if (!in_array($size, $allowedSizes)) {
    $size = '1024*1024';
}

$steps = intval($steps);
if ($steps < 1 || $steps > 10) {
    $steps = 4;
}


$apiUrl = 'https://api.jkyai.top/API/flux.1/';
$params = [
    'prompt' => $prompt,
    'size' => $size,
    'steps' => $steps,
    'type' => $type
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
    echo json_encode([
        'error' => true,
        'message' => '请求失败: ' . $curlError,
        'data' => []
    ]);
    exit;
}

if ($httpCode != 200) {
    echo json_encode([
        'error' => true,
        'message' => 'HTTP错误! 状态码: ' . $httpCode,
        'data' => []
    ]);
    exit;
}


if ($type === 'json') {
    
    $jsonResponse = json_decode($response, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo json_encode($jsonResponse);
    } else {
        echo json_encode([
            'error' => true,
            'message' => 'API返回格式错误',
            'data' => []
        ]);
    }
} else {
    
    echo $response;
}
?>