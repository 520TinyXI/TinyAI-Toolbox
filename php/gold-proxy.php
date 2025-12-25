<?php


header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');


ini_set('display_errors', 0);
error_reporting(E_ALL);


$type = isset($_GET['type']) ? $_GET['type'] : 'today';


if ($type === 'shop') {

    $apiUrl = 'http://api.xingchenfu.xyz/API/jinjia.php';
} else {

    $apiUrl = 'https://api.pearktrue.cn/api/goldprice/';
}


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
            'http_code' => $httpCode,
            'type' => $type
        ]
    ]);
} else {

    if ($type === 'shop') {

        $shopData = [];
        $lines = explode('------------------------', $body);
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || strpos($line, 'Tips:') !== false) {
                continue;
            }
            
            $shopInfo = [];
            $shopLines = explode("\n", $line);
            foreach ($shopLines as $shopLine) {
                $shopLine = trim($shopLine);
                if (empty($shopLine)) {
                    continue;
                }
                

                if (strpos($shopLine, '品牌:') === 0) {
                    $shopInfo['brand'] = trim(str_replace('品牌:', '', $shopLine));
                }

                if (strpos($shopLine, '黄金价格:') === 0) {
                    $shopInfo['gold_price'] = trim(str_replace('黄金价格:', '', $shopLine));
                }

                if (strpos($shopLine, '铂金价格:') === 0) {
                    $shopInfo['platinum_price'] = trim(str_replace('铂金价格:', '', $shopLine));
                }

                if (strpos($shopLine, '金条价格:') === 0) {
                    $shopInfo['bar_price'] = trim(str_replace('金条价格:', '', $shopLine));
                }

                if (strpos($shopLine, '报价时间:') === 0) {
                    $shopInfo['update_time'] = trim(str_replace('报价时间:', '', $shopLine));
                }
            }
            
            if (!empty($shopInfo)) {
                $shopData[] = $shopInfo;
            }
        }
        

        http_response_code(200);
        echo json_encode([
            'code' => 200,
            'msg' => 'success',
            'data' => $shopData
        ]);
    } else {

        http_response_code($httpCode);
        echo $body;
    }
}
