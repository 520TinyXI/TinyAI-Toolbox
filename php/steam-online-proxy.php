<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

ini_set('display_errors', 0);
error_reporting(E_ALL);

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$num = isset($_GET['num']) ? intval($_GET['num']) : 10;

$apiUrl = 'http://api.xingchenfu.xyz/API/steam.php?page=' . $page . '&num=' . $num;

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HEADER, false);

$response = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($curlError) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'API请求失败: ' . $curlError,
        'code' => 500,
        'debug' => [
            'api_url' => $apiUrl,
            'curl_error' => $curlError,
            'http_code' => $httpCode
        ]
    ]);
} else {
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'code' => $httpCode,
        'message' => '获取成功',
        'raw_response' => $response,
        'http_code' => $httpCode
    ]);
}

function parseSteamResponse($response) {
    if (strpos($response, 'Steam游戏在线人数统计') === false) {
        return false;
    }
    
    $result = [
        'total_games' => 0,
        'current_page' => '1/1',
        'per_page' => 10,
        'games' => []
    ];
    
    if (preg_match('/总游戏数: ([\d,]+)/', $response, $matches)) {
        $result['total_games'] = str_replace(',', '', $matches[1]);
    }
    
    if (preg_match('/当前页码: ([\d\/]+)/', $response, $matches)) {
        $result['current_page'] = $matches[1];
    }
    
    if (preg_match('/每页数量: (\d+)/', $response, $matches)) {
        $result['per_page'] = intval($matches[1]);
    }
    
    $games = [];
    $gamePattern = '/\d+\. (.+?)\n当前在线: ([\d,]+) 人\n历史峰值: ([\d,]+) 人\n峰值时间: (.+?)\nSteam ID: (\d+)/';
    
    preg_match_all($gamePattern, $response, $matches, PREG_SET_ORDER);
    
    foreach ($matches as $match) {
        $games[] = [
            'name' => trim($match[1]),
            'current_online' => trim($match[2]),
            'peak_online' => trim($match[3]),
            'peak_time' => trim($match[4]),
            'steam_id' => trim($match[5])
        ];
    }
    
    $result['games'] = $games;
    return $result;
}
