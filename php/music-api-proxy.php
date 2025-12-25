<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');

ini_set('display_errors', 1);
error_reporting(E_ALL);

class MusicAPIProxy {
    private $apiKey;
    private $apiUrl;
    
    public function __construct() {
        $this->apiKey = 'dd6f62de-7619-e3ac-03c0-0777847baeb56e5b714e';
        $this->apiUrl = 'https://api.yyy001.com/api/mgmuisc';
    }
    
    public function handleRequest() {
        $action = $_GET['action'] ?? '';
        
        switch ($action) {
            case 'search':
                $keyword = $_GET['keyword'] ?? '';
                return $this->searchMusic($keyword);
            case 'get':
                $keyword = $_GET['keyword'] ?? '';
                $index = $_GET['n'] ?? 1;
                return $this->getMusicDetail($keyword, $index);
            default:
                return $this->json(['code' => 400, 'msg' => '无效操作']);
        }
    }
    
    private function searchMusic($keyword) {
        if (empty($keyword)) {
            return $this->json(['code' => 400, 'msg' => '搜索关键词不能为空']);
        }
        
        try {
            $apiUrl = $this->apiUrl . '?apikey=' . $this->apiKey . '&msg=' . urlencode($keyword) . '&type=json&num=20';
            
            $options = [
                'http' => [
                    'method' => 'GET',
                    'header' => 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'timeout' => 15
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false
                ]
            ];
            
            $context = stream_context_create($options);
            $responseText = file_get_contents($apiUrl, false, $context);
            
            error_log('API响应文本: ' . $responseText);
            
            if ($responseText === false) {
                return $this->json([
                    'code' => 500,
                    'msg' => 'API请求失败',
                    'error' => 'file_get_contents请求失败',
                    'request_url' => $apiUrl
                ]);
            }
            
            $response = json_decode($responseText, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->json([
                    'code' => 500,
                    'msg' => 'JSON解析失败',
                    'error' => json_last_error_msg(),
                    'raw_response' => $responseText,
                    'request_url' => $apiUrl
                ]);
            }
            
            if (isset($response['code']) && $response['code'] == 200) {
                $data = isset($response['data']) ? $response['data'] : [];
                
                if (!is_array($data)) {
                    $data = [];
                }
                
                return $this->json([
                    'code' => 200,
                    'msg' => '搜索成功',
                    'count' => count($data),
                    'data' => $data
                ]);
            } else {
                return $this->json([
                    'code' => isset($response['code']) ? $response['code'] : 500,
                    'msg' => '搜索失败',
                    'error' => isset($response['msg']) ? $response['msg'] : '未知错误',
                    'api_response' => $response,
                    'request_url' => $apiUrl
                ]);
            }
        } catch (Exception $e) {
            return $this->json([
                'code' => 500,
                'msg' => '搜索失败',
                'error' => $e->getMessage(),
                'exception' => $e->__toString(),
                'request_url' => isset($apiUrl) ? $apiUrl : '未生成',
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    
    private function getMusicDetail($keyword, $index) {
        if (empty($keyword)) {
            return $this->json(['code' => 400, 'msg' => '搜索关键词不能为空']);
        }
        
        try {
            $apiUrl = $this->apiUrl . '?apikey=' . $this->apiKey . '&msg=' . urlencode($keyword) . '&n=' . $index . '&type=json&br=1';
            
            $options = [
                'http' => [
                    'method' => 'GET',
                    'header' => 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'timeout' => 15
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false
                ]
            ];
            
            $context = stream_context_create($options);
            $responseText = file_get_contents($apiUrl, false, $context);
            
            error_log('API响应文本: ' . $responseText);
            
            if ($responseText === false) {
                return $this->json([
                    'code' => 500,
                    'msg' => 'API请求失败',
                    'error' => 'file_get_contents请求失败',
                    'request_url' => $apiUrl
                ]);
            }
            
            $response = json_decode($responseText, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->json([
                    'code' => 500,
                    'msg' => 'JSON解析失败',
                    'error' => json_last_error_msg(),
                    'raw_response' => $responseText,
                    'request_url' => $apiUrl
                ]);
            }
            
            if (isset($response['code']) && $response['code'] == 200) {
                unset($response['code']);
                
                return $this->json(array_merge([
                    'code' => 200,
                    'msg' => '获取成功'
                ], $response));
            } else {
                return $this->json([
                    'code' => isset($response['code']) ? $response['code'] : 500,
                    'msg' => '获取失败',
                    'error' => isset($response['msg']) ? $response['msg'] : '未知错误',
                    'api_response' => $response,
                    'request_url' => $apiUrl
                ]);
            }
        } catch (Exception $e) {
            return $this->json([
                'code' => 500,
                'msg' => '获取失败',
                'error' => $e->getMessage(),
                'exception' => $e->__toString(),
                'request_url' => isset($apiUrl) ? $apiUrl : '未生成',
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    
    private function curlRequest($url) {
        if (!function_exists('curl_init')) {
            throw new Exception('CURL扩展未安装或未启用');
        }
        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        
        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        error_log('CURL请求URL: ' . $url);
        error_log('CURL响应状态码: ' . $httpCode);
        error_log('CURL响应内容: ' . $response);
        
        if ($curlError) {
            return ['code' => 500, 'msg' => 'CURL请求失败', 'error' => $curlError, 'http_code' => $httpCode, 'request_url' => $url];
        }
        
        if ($httpCode !== 200) {
            return ['code' => $httpCode, 'msg' => 'HTTP请求失败', 'http_code' => $httpCode, 'raw_response' => $response, 'request_url' => $url];
        }
        
        if (empty($response)) {
            return ['code' => 500, 'msg' => 'API返回空响应', 'request_url' => $url];
        }
        
        $jsonResponse = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['code' => 500, 'msg' => 'JSON解析失败', 'json_error' => json_last_error_msg(), 'raw_response' => $response, 'request_url' => $url];
        }
        
        return $jsonResponse;
    }
    
    private function json($data) {
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }
}

$proxy = new MusicAPIProxy();
$proxy->handleRequest();
