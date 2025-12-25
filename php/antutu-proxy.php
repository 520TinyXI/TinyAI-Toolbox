<?php



header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}


$api_url = 'https://api.jkyai.top/API/attxnb.php';


$allowed_systems = ['android', 'ios', 'pc', 'pad'];


$system = isset($_GET['msg']) ? $_GET['msg'] : (isset($_POST['msg']) ? $_POST['msg'] : '');
$type = isset($_GET['type']) ? $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : 'json');
$number = isset($_GET['number']) ? $_GET['number'] : (isset($_POST['number']) ? $_POST['number'] : '');


if (empty($system)) {
    sendResponse(false, '系统类型参数不能为空');
}

if (!in_array($system, $allowed_systems)) {
    sendResponse(false, '无效的系统类型，支持android、ios、pc、pad');
}


$request_url = $api_url . '?msg=' . urlencode($system);
if ($type) {
    $request_url .= '&type=' . urlencode($type);
}
if ($number) {
    $request_url .= '&number=' . urlencode($number);
}


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $request_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$curl_error = curl_error($ch);
curl_close($ch);

if ($response === false) {
    sendResponse(false, 'API请求失败: ' . $curl_error);
}


$data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    sendResponse(false, 'API返回数据格式错误');
}


if (!isset($data['success']) || !$data['success'] || !isset($data['data']) || !isset($data['data']['rankings'])) {
    sendResponse(false, 'API返回数据结构错误');
}


sendResponse(true, '数据获取成功', $data);


function sendResponse($success, $message, $data = null) {
    $response = [
        'success' => $success,
        'message' => $message
    ];
    
    if ($data !== null) {
        $response['data'] = $data;
    }
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}
