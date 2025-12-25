<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');

ini_set('display_errors', 1);
error_reporting(E_ALL);

class TinyMusicAPIProxy {
    private $getMusicIdApi;
    private $musicSearchApi;
    private $qqHotSongApi;
    private $miguMusicApi;
    private $singerInfoApi;
    
    public function __construct() {
        $this->getMusicIdApi = 'https://api.jkyai.top/API/hqyyid.php';
        $this->musicSearchApi = 'https://api.jkyai.top/API/yyjhss.php';
        $this->qqHotSongApi = 'https://api.jkyai.top/API/qqrgbd.php';
        $this->miguMusicApi = 'https://api.jkyai.top/API/mgyyjs.php';
        $this->singerInfoApi = 'https://api.jkyai.top/API/gsxxss.php';
    }
    
    public function handleRequest() {
        $action = $_GET['action'] ?? '';
        
        switch ($action) {
            case 'getMusicId':
                $keyword = $_GET['keyword'] ?? '';
                $type = $_GET['type'] ?? 'wy';
                $num = $_GET['num'] ?? 99;
                return $this->getMusicId($keyword, $type, $num);
            case 'searchMusic':
                $id = $_GET['id'] ?? '';
                $type = $_GET['type'] ?? 'wy';
                return $this->searchMusic($id, $type);
            case 'getHotSearch':
                $num = $_GET['num'] ?? 99;
                $type = $_GET['type'] ?? 'wy';
                return $this->getHotSearch($num, $type);
            case 'getSingerInfo':
                $singerName = $_GET['singerName'] ?? '';
                return $this->getSingerInfo($singerName);
            default:
                return $this->json(['code' => 400, 'msg' => '无效操作']);
        }
    }
    
    private function getMusicId($keyword, $type, $num) {
        if (empty($keyword)) {
            return $this->json(['code' => 400, 'msg' => '搜索关键词不能为空']);
        }
        
        try {
            if ($type === 'mgyy') {
                return $this->getMiguMusicList($keyword, $num);
            }
            
            $page = 1;
            
            $apiUrl = $this->getMusicIdApi . '?name=' . urlencode($keyword) . '&type=' . $type . '&page=' . $page . '&limit=' . $num;
            
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
            
            error_log('TINY音乐代理 - 请求URL: ' . $apiUrl);
            error_log('TINY音乐代理 - 响应内容: ' . $responseText);
            
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
            
            if (isset($response['code']) && $response['code'] === 1) {
                $data = $response['data'] ?? [];
                
                $musicList = [];
                foreach ($data as $song) {
                    $musicList[] = [
                        'id' => $song['id'] ?? '',
                        'title' => $song['name'] ?? '未知歌曲',
                        'singer' => $song['artist'] ?? '未知歌手',
                        'album' => $song['album'] ?? '未知专辑',
                        'type' => $song['type'] ?? 'qq'
                    ];
                }
                
                return $this->json([
                    'code' => 200,
                    'msg' => '获取成功',
                    'count' => count($musicList),
                    'data' => $musicList
                ]);
            } else {
                return $this->json([
                    'code' => isset($response['code']) ? $response['code'] : 500,
                    'msg' => $response['msg'] ?? '获取失败',
                    'request_url' => $apiUrl
                ]);
            }
        } catch (Exception $e) {
            return $this->json([
                'code' => 500,
                'msg' => '获取失败',
                'error' => $e->getMessage()
            ]);
        }
    }
    
    private function searchMusic($id, $type = 'qq') {
        if (empty($id)) {
            return $this->json(['code' => 400, 'msg' => '音乐ID不能为空']);
        }
        
        try {
            if ($type === 'mgyy') {
                return $this->getMiguMusicDetail($id);
            }
            
            $apiUrl = $this->musicSearchApi . '?id=' . $id . '&type=' . $type;
            
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
            
            error_log('TINY音乐代理 - 请求URL: ' . $apiUrl);
            error_log('TINY音乐代理 - 响应内容: ' . $responseText);
            
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
            
            if (isset($response['code']) && $response['code'] === 1) {
                $data = $response['data'] ?? [];
                
                $musicDetail = [
                    'title' => $data['name'] ?? '未知歌曲',
                    'singer' => $data['artist'] ?? '未知歌手',
                    'album' => $data['album'] ?? '未知专辑',
                    'cover' => $data['pic'] ?? 'https://via.placeholder.com/200',
                    'url' => $data['url'] ?? '',
                    'lrc' => $data['lrc'] ?? ''
                ];
                
                return $this->json([
                    'code' => 200,
                    'msg' => '获取成功',
                    'data' => $musicDetail
                ]);
            } else {
                return $this->json([
                    'code' => isset($response['code']) ? $response['code'] : 500,
                    'msg' => $response['msg'] ?? '获取失败',
                    'request_url' => $apiUrl
                ]);
            }
        } catch (Exception $e) {
            return $this->json([
                'code' => 500,
                'msg' => '获取失败',
                'error' => $e->getMessage()
            ]);
        }
    }
    
    private function getMiguMusicDetail($id) {
        try {
            $parts = explode('-', $id);
            $songNum = array_pop($parts);
            $keyword = implode('-', $parts);
            
            $apiUrl = $this->miguMusicApi . '?gm=' . urlencode($keyword) . '&n=' . $songNum;
            
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
            
            error_log('TINY音乐代理 - 请求URL: ' . $apiUrl);
            error_log('TINY音乐代理 - 响应内容: ' . $responseText);
            
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
            
            if (isset($response['code']) && $response['code'] === 200) {
                $musicDetail = [
                    'title' => $response['title'] ?? '未知歌曲',
                    'singer' => $response['singer'] ?? '未知歌手',
                    'album' => $response['title'] ?? '未知专辑',
                    'cover' => $response['cover'] ?? 'https://via.placeholder.com/200',
                    'url' => $response['music_url'] ?? '',
                    'lrc' => $response['lrc_url'] ?? ''
                ];
                
                return $this->json([
                    'code' => 200,
                    'msg' => '获取成功',
                    'data' => $musicDetail
                ]);
            } else {
                return $this->json([
                    'code' => isset($response['code']) ? $response['code'] : 500,
                    'msg' => $response['msg'] ?? '获取失败',
                    'request_url' => $apiUrl
                ]);
            }
        } catch (Exception $e) {
            return $this->json([
                'code' => 500,
                'msg' => '获取失败',
                'error' => $e->getMessage()
            ]);
        }
    }
    
    private function getHotSearch($num = 99, $type = 'wy') {
        try {
            $apiUrl = $this->qqHotSongApi . '?count=' . $num;
            
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
            
            error_log('TINY音乐代理 - 请求URL: ' . $apiUrl);
            error_log('TINY音乐代理 - 响应内容: ' . $responseText);
            
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
            
            if (isset($response['code']) && $response['code'] === 1) {
                $data = $response['data'] ?? [];
                
                $musicList = [];
                foreach ($data as $song) {
                    $musicList[] = [
                        'id' => $song['songmid'] ?? '',
                        'title' => $song['albumname'] ?? '未知歌曲',
                        'singer' => $song['name'] ?? '未知歌手',
                        'album' => $song['albumname'] ?? '未知专辑',
                        'type' => 'qq'
                    ];
                }
                
                return $this->json([
                    'code' => 200,
                    'msg' => '获取成功',
                    'count' => count($musicList),
                    'data' => $musicList
                ]);
            } else {
                return $this->json([
                    'code' => isset($response['code']) ? $response['code'] : 500,
                    'msg' => $response['msg'] ?? '获取失败',
                    'request_url' => $apiUrl
                ]);
            }
        } catch (Exception $e) {
            return $this->json([
                'code' => 500,
                'msg' => '获取失败',
                'error' => $e->getMessage()
            ]);
        }
    }
    
    private function getSingerInfo($singerName) {
        if (empty($singerName)) {
            return $this->json(['code' => 400, 'msg' => '歌手名称不能为空']);
        }
        
        try {
            $apiUrl = $this->singerInfoApi . '?msg=' . urlencode($singerName);
            
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
            
            error_log('TINY音乐代理 - 请求URL: ' . $apiUrl);
            error_log('TINY音乐代理 - 响应内容: ' . $responseText);
            
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
            
            if (isset($response['code']) && $response['code'] === 200) {
                $data = $response['data'] ?? [];
                
                $singerInfo = [
                    'name' => $data['name'] ?? $singerName,
                    'profile' => $data['profile'] ?? '暂无歌手简介',
                    'img_url' => $data['img_url'] ?? 'https://via.placeholder.com/150'
                ];
                
                return $this->json([
                    'code' => 200,
                    'msg' => '获取成功',
                    'data' => $singerInfo
                ]);
            } else {
                return $this->json([
                    'code' => isset($response['code']) ? $response['code'] : 500,
                    'msg' => $response['message'] ?? $response['msg'] ?? '获取失败',
                    'request_url' => $apiUrl
                ]);
            }
        } catch (Exception $e) {
            return $this->json([
                'code' => 500,
                'msg' => '获取失败',
                'error' => $e->getMessage()
            ]);
        }
    }
    
    private function getMiguMusicList($keyword, $num) {
        try {
            $apiUrl = $this->miguMusicApi . '?gm=' . urlencode($keyword);
            
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
            
            error_log('TINY音乐代理 - 请求URL: ' . $apiUrl);
            error_log('TINY音乐代理 - 响应内容: ' . $responseText);
            
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
            
            if (isset($response['code']) && $response['code'] === 200) {
                $data = $response['data'] ?? [];
                
                $musicList = [];
                foreach ($data as $song) {
                    $musicList[] = [
                        'id' => $song['title'] . '-' . $song['n'],
                        'title' => $song['title'] ?? '未知歌曲',
                        'singer' => $song['singer'] ?? '未知歌手',
                        'album' => $song['title'] ?? '未知专辑',
                        'type' => 'mgyy'
                    ];
                }
                
                $musicList = array_slice($musicList, 0, $num);
                
                return $this->json([
                    'code' => 200,
                    'msg' => '获取成功',
                    'count' => count($musicList),
                    'data' => $musicList
                ]);
            } else {
                return $this->json([
                    'code' => isset($response['code']) ? $response['code'] : 500,
                    'msg' => $response['msg'] ?? '获取失败',
                    'request_url' => $apiUrl
                ]);
            }
        } catch (Exception $e) {
            return $this->json([
                'code' => 500,
                'msg' => '获取失败',
                'error' => $e->getMessage()
            ]);
        }
    }
    
    private function json($data) {
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}

$proxy = new TinyMusicAPIProxy();
$proxy->handleRequest();