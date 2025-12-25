<?php



header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


$apiUrl = 'https://api.pearktrue.cn/api/website/domain/';

$alternativeApiUrls = [
    'https://api.pearktrue.cn/api/website/domain/index.php',
    'https://api.pearktrue.cn/api/website/domain/',
    'https://api.pearktrue.cn/domain/index.php',
    'https://api.pearktrue.cn/domain/'
];


$domain = isset($_GET['domain']) ? $_GET['domain'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : 'new'; 


if (empty($domain)) {
    echo json_encode([
        'code' => 400,
        'msg' => '域名后缀不能为空',
        'data' => []
    ]);
    exit;
}


$requestUrl = $apiUrl . '?domain=' . urlencode($domain) . '&type=' . urlencode($type);


$debugInfo = [
    'original_request_url' => $requestUrl,
    'domain' => $domain,
    'type' => $type
];


$response = false;
$httpCode = 0;
$curlError = 0;
$curlErrorMsg = '';
$verboseLog = '';
$success = false;


$startTime = microtime(true);


$maxRetries = 3;
$retryDelay = 1;


foreach ($alternativeApiUrls as $currentApiUrl) {

    $currentResponse = false;
    $currentHttpCode = 0;
    $currentCurlError = 0;
    $currentCurlErrorMsg = '';
    $currentLog = '';
    

    for ($retry = 0; $retry < $maxRetries; $retry++) {
        if ($success) break;
        
        $retryLog = $retry > 0 ? " (重试 {$retry}/{$maxRetries})" : "";
        
        try {

            $currentRequestUrl = $currentApiUrl . '?domain=' . urlencode($domain) . '&type=' . urlencode($type);
            

            $curl = curl_init();
            if ($curl === false) {
                $currentLog .= "Failed to initialize curl{$retryLog}\n";
                break;
            }
            

            $curlOptions = [
                CURLOPT_URL => $currentRequestUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Accept: application/json",
                    "Accept-Language: zh-CN,zh;q=0.9,en;q=0.8",
                    "Cache-Control: no-cache",
                    "Connection: keep-alive",
                    "Pragma: no-cache",
                    "Referer: https://api.pearktrue.cn/",
                    "Origin: https://api.pearktrue.cn/",
                    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36"
                ],
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_VERBOSE => false,
            ];
            

            if (!curl_setopt_array($curl, $curlOptions)) {
                $currentLog .= "Failed to set curl options{$retryLog}: " . curl_error($curl) . "\n";
                curl_close($curl);
                break;
            }
            

            $currentResponse = curl_exec($curl);
            

            $currentLog = "curl request initiated{$retryLog}\n";
            

            $currentHttpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $currentCurlError = curl_errno($curl);
            $currentCurlErrorMsg = curl_error($curl);
            

            curl_close($curl);
            

            $responseIsString = is_string($currentResponse);
            $currentLog .= "\ncurl request completed{$retryLog}\n";
            $currentLog .= "URL: {$currentRequestUrl}\n";
            $currentLog .= "HTTP Code: {$currentHttpCode}\n";
            $currentLog .= "curl Error: {$currentCurlErrorMsg} ({$currentCurlError})\n";
            $currentLog .= "Response Type: " . gettype($currentResponse) . "\n";
            $currentLog .= "Response Length: " . ($responseIsString ? strlen($currentResponse) : 0) . " bytes\n";
            

            $responseSample = "N/A";
            if ($responseIsString) {

                $isHtml = strpos(trim($currentResponse), '<!DOCTYPE') === 0 || 
                          strpos(trim($currentResponse), '<html') === 0 ||
                          strpos(trim($currentResponse), '<head') === 0;
                
                if ($isHtml) {
                    $responseSample = "HTML Response Detected: " . substr($currentResponse, 0, 200) . "...";
                } else {
                    $responseSample = substr($currentResponse, 0, 200) . "...";
                }
            }
            $currentLog .= "Response Sample: {$responseSample}\n";
            

            if ($currentCurlError === 0 && $currentHttpCode === 200 && $responseIsString) {

                $json = json_decode($currentResponse, true);
                $jsonError = json_last_error();
                
                if ($jsonError === JSON_ERROR_NONE) {

                    $response = $currentResponse;
                    $httpCode = $currentHttpCode;
                    $verboseLog = $currentLog;
                    $success = true;
                    break;
                } else {
                    $currentLog .= "JSON Error{$retryLog}: " . json_last_error_msg() . "\n";
                }
            } else {

                $currentLog .= "Request failed{$retryLog}\n";
                

                $shouldRetry = false;
                if ($currentCurlError === CURLE_OPERATION_TIMEDOUT || $currentCurlError === CURLE_GOT_NOTHING) {
                    $shouldRetry = true;
                    $currentLog .= "Retrying due to timeout{$retryLog}...\n";
                } elseif ($currentHttpCode === 504 || $currentHttpCode === 502 || $currentHttpCode === 503) {
                    $shouldRetry = true;
                    $currentLog .= "Retrying due to HTTP {$currentHttpCode} error{$retryLog}...\n";
                }
                
                if (!$shouldRetry) {
                    break;
                }
                

                if ($retry < $maxRetries - 1) {
                    sleep($retryDelay);
                }
            }
            
        } catch (Exception $e) {
            $currentLog .= "\n=== 尝试路径 {$currentApiUrl}{$retryLog} 异常 ===\n";
            $currentLog .= "Error: {$e->getMessage()}\n";
            

            if ($retry < $maxRetries - 1) {
                sleep($retryDelay);
            }
        }
    }
    

    if (!$success) {
        $verboseLog .= "\n=== 尝试路径 {$currentApiUrl} 所有重试都失败 ===\n";
        $verboseLog .= $currentLog;
    } else {
        break;
    }
}


$endTime = microtime(true);
$verboseLog .= "Execution Time: " . round(($endTime - $startTime) * 1000, 2) . " ms\n";


if ($success && $response !== false) {

    echo $response;
} else {

    $errorResponse = [
        'code' => 500,
        'msg' => "API请求失败: 所有备选路径都无法返回有效数据",
        'debug' => [
            'original_api_url' => $requestUrl,
            'tried_urls' => $alternativeApiUrls,
            'last_http_code' => $httpCode,
            'last_curl_error' => $curlErrorMsg,
            'curl_log' => $verboseLog,
            'additional_debug' => $debugInfo
        ]
    ];
    

    echo json_encode($errorResponse, JSON_UNESCAPED_UNICODE);
}
?>