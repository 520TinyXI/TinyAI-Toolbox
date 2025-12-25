<?php


header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');


ini_set('display_errors', 0);
error_reporting(E_ALL);


$apiUrl = 'https://api.pearktrue.cn/api/steamplusone/';

$translateApiUrl = 'https://api.pearktrue.cn/api/translate/ai/';


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

    $apiResponse = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        
        http_response_code($httpCode);
        echo json_encode([
            'success' => false,
            'message' => 'API返回无效响应',
            'code' => $httpCode,
            'raw_response' => $response
        ]);
    } else {
        
        $games = $apiResponse['data'] ?? [];
        
        
        if (!empty($games)) {
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            
            
            $apiResponse['debug'] = [
                'translation_results' => []
            ];
            
            
            foreach ($games as &$game) {
                if (!empty($game['name'])) {
                    $gameName = $game['name'];
                    $encodedGameName = urlencode($gameName);
                    $translateUrl = "{$translateApiUrl}?text={$encodedGameName}&source_lang=en&target_lang=zh";
                    

                    curl_setopt($ch, CURLOPT_URL, $translateUrl);
                    

                    $translateResponse = curl_exec($ch);
                    $translateCurlError = curl_error($ch);
                    $translateHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    
                    
                    $translationDebug = [
                        'game_name' => $gameName,
                        'translate_url' => $translateUrl,
                        'http_code' => $translateHttpCode,
                        'curl_error' => $translateCurlError
                    ];
                    
                    if (!$translateCurlError) {

                        $translationDebug['raw_response'] = $translateResponse;
                        

                        $translateResult = json_decode($translateResponse, true);
                        $translationDebug['json_error_code'] = json_last_error();
                        $translationDebug['json_error_msg'] = json_last_error_msg();
                        
                        if (json_last_error() === JSON_ERROR_NONE) {
                            
                            $translationDebug['parsed_result'] = $translateResult;
                            
                            if (isset($translateResult['code']) && $translateResult['code'] === 200) {
                                
                                $translatedName = $translateResult['data'] ?? '';
                                $game['translated_name'] = trim($translatedName);
                                $translationDebug['translated_name'] = $translatedName;
                            } else {
                                
                                $translationDebug['error_message'] = $translateResult['msg'] ?? '未知错误';
                            }
                        } else {
                            
                            $translationDebug['fallback_attempt'] = true;
                            $game['translated_name'] = trim($translateResponse);
                        }
                    } else {
                        
                        $translationDebug['fallback_to_original'] = true;
                    }
                    
                    
                    $apiResponse['debug']['translation_results'][] = $translationDebug;
                }
            }
            
            
            curl_close($ch);
        }
        
        
        http_response_code($httpCode);
        echo json_encode([
            'success' => true,
            'code' => $apiResponse['code'] ?? $httpCode,
            'message' => $apiResponse['msg'] ?? '获取成功',
            'time' => $apiResponse['time'] ?? '',
            'count' => $apiResponse['count'] ?? '0',
            'data' => $games
        ]);
    }
}
