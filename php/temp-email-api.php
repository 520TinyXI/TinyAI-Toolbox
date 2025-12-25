<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');

ini_set('display_errors', 1);
error_reporting(E_ALL);

class TempEmailAPI {
    private $countFile;
    
    public function __construct() {
        $this->countFile = __DIR__ . '/temp-email-count.txt';
        
        if (!file_exists($this->countFile)) {
            file_put_contents($this->countFile, '0');
        }
    }
    
    public function handleRequest() {
        $action = $_GET['action'] ?? '';
        
        switch ($action) {
            case 'generate':
                return $this->generateEmail();
            case 'check':
                $email = $_GET['email'] ?? '';
                return $this->checkEmails($email);
            case 'stats':
                return $this->getStats();
            default:
                return $this->json(['code' => 400, 'msg' => '无效操作']);
        }
    }
    
    private function generateEmail() {
        try {
            $apiUrl = 'https://api.pearktrue.cn/api/email/?type=get';
            $response = $this->curlRequest($apiUrl);
            
            if ($response && $response['code'] == 200) {
                if (isset($response['email'])) {
                    $this->incrementCount();
                    
                    return $this->json([
                        'code' => 200,
                        'email' => $response['email'],
                        'expires' => time() + 600,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                } else {
                    return $this->json(['code' => 500, 'msg' => '生成邮箱失败', 'error' => 'API未返回有效邮箱地址']);
                }
            } else {
                return $this->json(['code' => 500, 'msg' => '生成邮箱失败', 'error' => $response['msg'] ?? '未知错误']);
            }
        } catch (Exception $e) {
            return $this->json(['code' => 500, 'msg' => '生成邮箱失败', 'error' => $e->getMessage()]);
        }
    }
    
    private function checkEmails($email) {
        if (empty($email)) {
            return $this->json(['code' => 400, 'msg' => '邮箱地址不能为空']);
        }
        
        try {
            $apiUrl = 'https://api.pearktrue.cn/api/email/?type=receive&email=' . urlencode($email);
            $response = $this->curlRequest($apiUrl);
            
            error_log('第三方API完整响应: ' . json_encode($response));
            
            if ($response && $response['code'] == 200) {
                $emailsData = $response['receivedata'] ?? [];
                error_log('原始邮件数据: ' . json_encode($emailsData));
                
                if (!is_array($emailsData)) {
                    $emailsData = [];
                }
                
                error_log('处理后邮件数据: ' . json_encode($emailsData));
                error_log('邮件数量: ' . count($emailsData));
                
                return $this->json([
                    'code' => 200,
                    'email' => $email,
                    'count' => count($emailsData),
                    'emails' => $emailsData,
                    'debug' => [
                        'api_url' => $apiUrl,
                        'raw_response' => $response,
                        'processed_emails' => $emailsData
                    ]
                ]);
            } else {
                return $this->json(['code' => 500, 'msg' => '检查邮件失败', 'error' => $response['msg'] ?? '未知错误', 'debug' => [
                    'api_url' => $apiUrl,
                    'raw_response' => $response
                ]]);
            }
        } catch (Exception $e) {
            return $this->json(['code' => 500, 'msg' => '检查邮件失败', 'error' => $e->getMessage(), 'debug' => [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]]);
        }
    }
    
    private function getStats() {
        $count = (int)file_get_contents($this->countFile);
        return $this->json([
            'code' => 200,
            'total_generated' => $count,
            'active_emails' => 0,
            'server_time' => date('Y-m-d H:i:s')
        ]);
    }
    
    private function curlRequest($url) {
        if (!function_exists('curl_init')) {
            throw new Exception('CURL扩展未安装或未启用');
        }
        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
        
        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        error_log('CURL请求URL: ' . $url);
        error_log('CURL响应状态码: ' . $httpCode);
        error_log('CURL响应内容: ' . $response);
        
        if ($curlError) {
            throw new Exception('CURL请求失败: ' . $curlError . ', HTTP状态码: ' . $httpCode);
        }
        
        if ($httpCode !== 200) {
            throw new Exception('HTTP请求失败，状态码: ' . $httpCode);
        }
        
        if (empty($response)) {
            throw new Exception('API返回空响应');
        }
        
        $jsonResponse = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('JSON解析失败: ' . json_last_error_msg());
            return ['code' => 500, 'msg' => 'JSON解析失败', 'raw_response' => $response];
        }
        
        return $jsonResponse;
    }
    
    private function incrementCount() {
        $count = (int)file_get_contents($this->countFile);
        $count++;
        file_put_contents($this->countFile, (string)$count);
    }
    
    private function json($data) {
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }
}

$api = new TempEmailAPI();
$api->handleRequest();
