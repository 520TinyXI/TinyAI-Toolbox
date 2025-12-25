<?php


header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}


$BASE_URL = 'https://api.openbrewerydb.org/v1/breweries';
$TRANSLATE_API_URL = 'https://api.pearktrue.cn/api/translate/ai/';


$action = $_GET['action'] ?? '';
$page = $_GET['page'] ?? 1;
$per_page = $_GET['per_page'] ?? 12;
$targetLang = $_GET['target_lang'] ?? '';


function response($code, $msg, $data = [], $total = 0) {
    echo json_encode([
        'code' => $code,
        'msg' => $msg,
        'data' => $data,
        'total' => $total
    ], JSON_UNESCAPED_UNICODE);
    exit;
}


function fetchApi($url) {
    
    $options = [
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\nContent-Type: application/json",
            'timeout' => 15
        ],
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false
        ]
    ];
    
    $context = stream_context_create($options);

    $result = @file_get_contents($url, false, $context);
    
    if ($result === false) {
        return false;
    }
    
    return json_decode($result, true);
}


function translateText($text, $sourceLang = 'en', $targetLang = 'zh') {
    global $TRANSLATE_API_URL;
    

    if (empty($text) || $sourceLang === $targetLang) {
        return $text;
    }
    

    $countryMap = [
        'United States' => '美国',
        'Canada' => '加拿大',
        'United Kingdom' => '英国',
        'Germany' => '德国',
        'France' => '法国',
        'Japan' => '日本',
        'South Korea' => '韩国',
        'Australia' => '澳大利亚',
        'China' => '中国',
        'India' => '印度',
        'Brazil' => '巴西',
        'Mexico' => '墨西哥',
        'Russia' => '俄罗斯',
        'Italy' => '意大利',
        'Spain' => '西班牙',
        'Netherlands' => '荷兰',
        'Belgium' => '比利时',
        'Switzerland' => '瑞士',
        'Sweden' => '瑞典',
        'Norway' => '挪威',
        'Denmark' => '丹麦',
        'Finland' => '芬兰',
        'Ireland' => '爱尔兰',
        'Portugal' => '葡萄牙',
        'Austria' => '奥地利',
        'Poland' => '波兰',
        'Czech Republic' => '捷克共和国',
        'Hungary' => '匈牙利',
        'Greece' => '希腊',
        'Turkey' => '土耳其',
        'South Africa' => '南非',
        'New Zealand' => '新西兰'
    ];
    

    if (isset($countryMap[$text])) {
        return $countryMap[$text];
    }
    


    $url = "{$TRANSLATE_API_URL}?text=" . urlencode($text) . "&source_lang={$sourceLang}&target_lang={$targetLang}";
    $data = fetchApi($url);
    

    if ($data) {

        if (isset($data['code']) && $data['code'] === 200) {

            if (isset($data['data'])) {
                return $data['data'];
            }

            if (isset($data['msg']) && $data['msg'] === '翻译成功' && isset($data['data'])) {
                return $data['data'];
            }
        }

        if (isset($data['status']) && $data['status'] === 'success' && isset($data['data'])) {
            return $data['data'];
        }

        if (isset($data['text'])) {
            return $data['text'];
        }
    }
    


    $baiduTranslateUrl = "https://fanyi.baidu.com/sug?q=" . urlencode($text) . "&kw=" . urlencode($text) . "&from=en&to=zh";
    $baiduData = fetchApi($baiduTranslateUrl);
    
    if ($baiduData && isset($baiduData['data']) && is_array($baiduData['data']) && count($baiduData['data']) > 0) {
        return $baiduData['data'][0]['v'];
    }
    

    return $text;
}


function translateBreweryData($breweries, $targetLang) {
    if (empty($breweries)) {
        return $breweries;
    }
    

    if ($targetLang === 'en') {
        return $breweries;
    }
    

    $textToTranslate = [];
    $fieldMapping = [];
    
    foreach ($breweries as &$brewery) {

        $fieldsToTranslate = ['name', 'brewery_type', 'city', 'state_province', 'country', 'address_1', 'address_2', 'address_3'];
        
        foreach ($fieldsToTranslate as $field) {
            if (isset($brewery[$field])) {
                $text = $brewery[$field];
                
    
                if ($targetLang === 'zh') {

                    $countryMap = [
                        'United States' => '美国',
                        'Canada' => '加拿大',
                        'United Kingdom' => '英国',
                        'Germany' => '德国',
                        'France' => '法国',
                        'Japan' => '日本',
                        'South Korea' => '韩国',
                        'Australia' => '澳大利亚',
                        'China' => '中国',
                        'India' => '印度',
                        'Brazil' => '巴西',
                        'Mexico' => '墨西哥',
                        'Russia' => '俄罗斯',
                        'Italy' => '意大利',
                        'Spain' => '西班牙',
                        'Netherlands' => '荷兰',
                        'Belgium' => '比利时',
                        'Switzerland' => '瑞士',
                        'Sweden' => '瑞典',
                        'Norway' => '挪威',
                        'Denmark' => '丹麦',
                        'Finland' => '芬兰',
                        'Ireland' => '爱尔兰',
                        'Portugal' => '葡萄牙',
                        'Austria' => '奥地利',
                        'Poland' => '波兰',
                        'Czech Republic' => '捷克共和国',
                        'Hungary' => '匈牙利',
                        'Greece' => '希腊',
                        'Turkey' => '土耳其',
                        'South Africa' => '南非',
                        'New Zealand' => '新西兰'
                    ];
                    
                    if (isset($countryMap[$text])) {

                        $brewery[$field] = $countryMap[$text];
                    } else {

                        $textToTranslate[] = $text;

                        $fieldMapping[] = [
                            'brewery' => &$brewery,
                            'field' => $field
                        ];
                    }
                } else {
    
                    $textToTranslate[] = $text;
    
                    $fieldMapping[] = [
                        'brewery' => &$brewery,
                        'field' => $field
                    ];
                }
            }
        }
    }
    

    if (!empty($textToTranslate)) {
        
        $batchText = implode('!', $textToTranslate);
        $batchTranslation = translateBatchText($batchText, 'en', $targetLang);
        
        if ($batchTranslation) {


            $delimiter = ($targetLang === 'zh') ? '！' : '!';
            $translatedTexts = explode($delimiter, $batchTranslation);
            

            foreach ($fieldMapping as $i => &$mapping) {
                if (isset($translatedTexts[$i])) {
                    $mapping['brewery'][$mapping['field']] = $translatedTexts[$i];
                }
            }
        } else {

            foreach ($fieldMapping as &$mapping) {
                $brewery = &$mapping['brewery'];
                $field = $mapping['field'];
                $brewery[$field] = translateText($brewery[$field], 'en', $targetLang);
            }
        }
    }
    
    return $breweries;
}


function translateBatchText($text, $sourceLang = 'en', $targetLang = 'zh') {
    global $TRANSLATE_API_URL;
    

    if (empty($text) || $sourceLang === $targetLang) {
        return $text;
    }
    

    $url = "{$TRANSLATE_API_URL}?text=" . urlencode($text) . "&source_lang={$sourceLang}&target_lang={$targetLang}";
    $data = fetchApi($url);
    

    if ($data) {

        if (isset($data['code']) && $data['code'] === 200) {

            if (isset($data['data'])) {
                return $data['data'];
            }

            if (isset($data['msg']) && $data['msg'] === '翻译成功' && isset($data['data'])) {
                return $data['data'];
            }
        }

        if (isset($data['status']) && $data['status'] === 'success' && isset($data['data'])) {
            return $data['data'];
        }

        if (isset($data['text'])) {
            return $data['text'];
        }
    }
    

    return false;
}


try {
    switch ($action) {
        case 'search':

            $query = $_GET['query'] ?? '';
            if (empty($query)) {
                response(400, '搜索关键词不能为空');
            }
            

            $url = "{$BASE_URL}/search?query=" . urlencode($query) . "&page={$page}&per_page={$per_page}";
            $data = fetchApi($url);
            
            if ($data === false) {
    
                $error = error_get_last();
                response(500, "API请求失败: {$url} - " . ($error['message'] ?? '未知错误'));
            }
            

            $translatedData = translateBreweryData($data, $targetLang);
            

            response(200, '搜索成功', $translatedData, count($translatedData));
            break;
            
        case 'by_country':

            $country = $_GET['country'] ?? '';
            if (empty($country)) {
                response(400, '国家参数不能为空');
            }
            

            $countryMap = [
                'united_states' => 'United States',
                'canada' => 'Canada',
                'united_kingdom' => 'United Kingdom',
                'germany' => 'Germany',
                'france' => 'France',
                'japan' => 'Japan',
                'south_korea' => 'South Korea',
                'australia' => 'Australia',
                'china' => 'China'
            ];
            
            $countryName = $countryMap[$country] ?? $country;

            $url = "{$BASE_URL}?by_country=" . urlencode($countryName) . "&page={$page}&per_page={$per_page}";
            $data = fetchApi($url);
            
            if ($data === false) {
    
                $error = error_get_last();
                response(500, "API请求失败: {$url} - " . ($error['message'] ?? '未知错误'));
            }
            

            $translatedData = translateBreweryData($data, $targetLang);
            
            response(200, '查询成功', $translatedData, count($translatedData));
            break;
            
        case 'by_city':

            $city = $_GET['city'] ?? '';
            if (empty($city)) {
                response(400, '城市参数不能为空');
            }
            

            $url = "{$BASE_URL}?by_city=" . urlencode($city) . "&page={$page}&per_page={$per_page}";
            $data = fetchApi($url);
            
            if ($data === false) {

                $error = error_get_last();
                response(500, "API请求失败: {$url} - " . ($error['message'] ?? '未知错误'));
            }
            

            $translatedData = translateBreweryData($data, $targetLang);
            
            response(200, '查询成功', $translatedData, count($translatedData));
            break;
            
        case 'by_type':

            $type = $_GET['type'] ?? '';
            if (empty($type)) {
                response(400, '类型参数不能为空');
            }
            

            $url = "{$BASE_URL}?by_type={$type}&page={$page}&per_page={$per_page}";
            $data = fetchApi($url);
            
            if ($data === false) {

                $error = error_get_last();
                response(500, "API请求失败: {$url} - " . ($error['message'] ?? '未知错误'));
            }
            

            $translatedData = translateBreweryData($data, $targetLang);
            
            response(200, '查询成功', $translatedData, count($translatedData));
            break;
            
        case 'random':

            $count = $_GET['count'] ?? 1;
            $count = min(max(1, intval($count)), 50);
            

            $url = "{$BASE_URL}/random?size={$count}";
            $data = fetchApi($url);
            
            if ($data === false) {

                $error = error_get_last();
                response(500, "API请求失败: {$url} - " . ($error['message'] ?? '未知错误'));
            }
            

            $translatedData = translateBreweryData($data, $targetLang);
            
            response(200, '获取成功', $translatedData);
            break;
            
        default:
            response(400, '无效的请求类型');
            break;
    }
} catch (Exception $e) {
    response(500, '服务器内部错误: ' . $e->getMessage());
}
