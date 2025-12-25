<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

ini_set('display_errors', 0);
error_reporting(E_ALL);

$apiBaseUrl = 'https://api.waifu.pics';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$type = $_GET['type'] ?? 'sfw';
$category = $_GET['category'] ?? 'waifu';
$count = (int)($_GET['count'] ?? 1);

$validTypes = ['sfw', 'nsfw'];
$validCategories = [
    'sfw' => ['waifu', 'neko', 'shinobu', 'megumin', 'bully', 'cuddle', 'cry', 'hug', 'awoo', 'kiss', 'lick', 'pat', 'smug', 'bonk', 'yeet', 'blush', 'smile', 'wave', 'highfive', 'handhold', 'nom', 'bite', 'glomp', 'slap', 'kill', 'kick', 'happy', 'wink', 'poke', 'dance', 'cringe'],
    'nsfw' => ['waifu', 'neko', 'trap', 'blowjob']
];

if (!in_array($type, $validTypes)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => '无效的类型参数',
        'valid_types' => $validTypes
    ]);
    exit;
}

if (!in_array($category, $validCategories[$type])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => '无效的分类参数',
        'valid_categories' => $validCategories[$type]
    ]);
    exit;
}

if ($count < 1 || $count > 20) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => '无效的数量参数，范围1-20'
    ]);
    exit;
}

$ch = curl_init();

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HEADER, false);

$images = [];

for ($i = 0; $i < $count; $i++) {
    $apiUrl = "{$apiBaseUrl}/{$type}/{$category}";
    
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    
    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if ($curlError) {
        $images[] = [
            'success' => false,
            'error' => $curlError
        ];
    } else {
        $apiResponse = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $images[] = [
                'success' => false,
                'error' => 'API返回无效响应',
                'raw_response' => $response
            ];
        } else {
            $images[] = [
                'success' => true,
                'url' => $apiResponse['url']
            ];
        }
    }
}

curl_close($ch);

echo json_encode([
    'success' => true,
    'type' => $type,
    'category' => $category,
    'count' => $count,
    'data' => $images
]);
