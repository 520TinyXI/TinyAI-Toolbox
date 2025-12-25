<?php



ini_set('display_errors', 0);
error_reporting(E_ALL);


$url = isset($_GET['url']) ? $_GET['url'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : 'parse';


if ($action === 'download') {

    header('Access-Control-Allow-Origin: *');
    

    if (empty($url)) {
        http_response_code(400);
        echo '视频链接不能为空';
        exit;
    }
    

    $ch = curl_init();
    

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: */*',
        'Referer: https://www.douyin.com/',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
    ]);
    

    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    curl_close($ch);
    
    if ($curlError) {
        http_response_code(500);
        echo '下载失败: ' . $curlError;
        exit;
    }
    

    $headers = substr($response, 0, $headerSize);
    $body = substr($response, $headerSize);
    

    $contentType = 'application/octet-stream';
    if (preg_match('/Content-Type:\s*(.*?);?\s*$/im', $headers, $matches)) {
        $contentType = trim($matches[1]);
    }
    

    $fileName = 'douyin-video-' . time() . '.mp4';
    if (preg_match('/Content-Disposition:\s*attachment;\s*filename="?(.*?)"?\s*$/im', $headers, $matches)) {
        $fileName = urldecode(trim($matches[1], '"'));
    }
    

    header('Content-Type: ' . $contentType);
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Content-Length: ' . strlen($body));
    header('Cache-Control: no-cache');
    

    echo $body;
    exit;
}



header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');


$apiUrl = 'https://api.pearktrue.cn/api/video/douyin/';


if (empty($url)) {
    echo json_encode([
        'code' => 400,
        'msg' => '视频链接不能为空',
        'data' => []
    ]);
    exit;
}


$requestUrl = $apiUrl . '?url=' . urlencode($url);


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