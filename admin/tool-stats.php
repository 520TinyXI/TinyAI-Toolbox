


<?php
require_once 'php/auth.php';
require_once '../php/framework.php';

requireAdminLogin();

$admin = getCurrentAdmin();

$toolbox = new ToolboxFramework();
$db = $toolbox->getDb();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$pageSize = isset($_GET['page_size']) ? (int)$_GET['page_size'] : 20;
$offset = ($page - 1) * $pageSize;

$toolFilter = isset($_GET['tool_id']) ? $_GET['tool_id'] : '';
$actionFilter = isset($_GET['action']) ? $_GET['action'] : '';
$dateStart = isset($_GET['date_start']) ? $_GET['date_start'] : '';
$dateEnd = isset($_GET['date_end']) ? $_GET['date_end'] : '';

$config = require '../php/config.php';
$tools = array();
$toolNames = array();

foreach ($config['tools'] as $tool) {
    $tools[] = $tool['id'];
    $toolNames[$tool['id']] = $tool['name'];
}

$whereClause = "WHERE 1=1";
$params = array();

if ($toolFilter) {
    $whereClause .= " AND tool_id = ?";
    $params[] = $toolFilter;
}

if ($actionFilter) {
    $whereClause .= " AND content LIKE ?";
    $params[] = '%"action":"' . $actionFilter . '"%';
}

if ($dateStart) {
    $whereClause .= " AND created_at >= ?";
    $params[] = $dateStart;
}

if ($dateEnd) {
    $whereClause .= " AND created_at <= ?";
    $params[] = $dateEnd . ' 23:59:59';
}

$sql = "SELECT COUNT(*) as total FROM history " . $whereClause;
$totalResult = $db->fetchOne($sql, $params);
$totalRecords = $totalResult['total'];
$totalPages = ceil($totalRecords / $pageSize);

$paramsCopy = $params;
$paramsCopy[] = $pageSize;
$paramsCopy[] = $offset;
$sql = "SELECT * FROM history " . $whereClause . " ORDER BY created_at DESC LIMIT ? OFFSET ?";
$records = $db->fetchAll($sql, $paramsCopy);

$toolStats = array();
foreach ($tools as $toolId) {
    $sql = "SELECT COUNT(*) as total, 
               SUM(CASE WHEN status = 'success' THEN 1 ELSE 0 END) as success, 
               SUM(CASE WHEN status = 'error' THEN 1 ELSE 0 END) as error
           FROM history WHERE tool_id = ?";
    $result = $db->fetchOne($sql, array($toolId));
    $result['tool_id'] = $toolId;
    $result['tool_name'] = $toolNames[$toolId];
    $result['success_rate'] = $result['total'] > 0 ? round(($result['success'] / $result['total']) * 100, 2) : 0;
    $toolStats[] = $result;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>工具调用数据 - 工具箱后台</title>
    <link rel="stylesheet" href="css/admin.css">
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background-color: #f8f9fa;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        .stat-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }
        .stat-value {
            font-size: 24px;
            font-weight: 600;
            color: #1a1a1a;
        }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .filter-section {
            background-color: #f8f9fa;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            margin-bottom: 24px;
        }
        .filter-row {
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
        }
        .filter-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
        }
        .status {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .status.success {
            background-color: #d4edda;
            color: #155724;
        }
        .status.error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .action {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            background-color: #e3f2fd;
            color: #1565c0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }
        th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
    </style>
    <script>
        
        const toolActions = {
            json: [
                { value: 'format', text: 'JSON格式化' },
                { value: 'compress', text: 'JSON压缩' },
                { value: 'validate_success', text: 'JSON验证成功' },
                { value: 'validate_error', text: 'JSON验证失败' },
                { value: 'fix_success', text: 'JSON修复成功' },
                { value: 'fix_error', text: 'JSON修复失败' }
            ],
            base64: [
                { value: 'encode', text: 'Base64编码' },
                { value: 'decode_success', text: 'Base64解码成功' },
                { value: 'decode_error', text: 'Base64解码失败' }
            ],
            url: [
                { value: 'encode', text: 'URL编码' },
                { value: 'decode', text: 'URL解码' }
            ],
            md5: [
                { value: 'encrypt', text: 'MD5加密' }
            ],
            timestamp: [
                { value: 'convert_to_timestamp', text: '日期转时间戳' },
                { value: 'convert_to_date', text: '时间戳转日期' }
            ],
            qrcode: [
                { value: 'generate', text: '生成二维码' }
            ],
            color: [
                { value: 'convert_color', text: '颜色转换' }
            ],
            regex: [
                { value: 'test', text: '正则测试' }
            ],
            calculator: [
                { value: 'calculate', text: '计算' }
            ],
            unit: [
                { value: 'convert', text: '单位转换' }
            ],
            password: [
                { value: 'generate', text: '生成密码' }
            ],
            diff: [
                { value: 'compare', text: '文本对比' }
            ],
            minify: [
                { value: 'minify', text: 'HTML压缩' }
            ],
            bmi: [
                { value: 'calculate', text: '计算BMI' }
            ],
            hmac: [
                { value: 'generate', text: '生成HMAC' }
            ],
            'html-entity': [
                { value: 'escape', text: 'HTML实体转义' },
                { value: 'unescape', text: 'HTML实体反转义' }
            ],
            'js-encrypt': [
                { value: 'encrypt', text: 'JS代码加密' }
            ],
            ulid: [
                { value: 'generate', text: '生成ULID' }
            ],
            expiry: [
                { value: 'calculate', text: '计算保质期' }
            ],
            wzry: [
                { value: 'power_query', text: '战力查询' }
            ],
            'history-today': [
                { value: 'fetch_events', text: '获取历史事件' }
            ],
            trademark: [
                { value: 'search_trademark', text: '查询商标' }
            ],
            'gold-price': [
                { value: 'call_ai_analysis', text: '调用AI分析' },
                { value: 'fetch_gold_price', text: '获取黄金价格' },
                { value: 'fetch_shop_price', text: '获取金店价格' }
            ],
            'history-person': [
                { value: 'search_person', text: '查询历史人物' }
            ],
            'car-price': [
                { value: 'search_car', text: '查询车辆价格' }
            ],
            'city-route': [
                { value: 'search_route', text: '查询城市路线' }
            ],
            'tech-news': [
                { value: 'fetch_news', text: '获取科技资讯' }
            ],
            'epic-free': [
                { value: 'fetch_games', text: '获取Epic喜加一游戏' }
            ],
            'horoscope': [
                { value: 'query_horoscope', text: '查询星座运势' }
            ],
            'movie-box-office': [
                { value: 'fetch_box_office', text: '获取票房数据' }
            ],
            'domain-price': [
                { value: 'query_domain_price', text: '查询域名价格' }
            ],
            'douyin-video': [
                { value: 'parse_video', text: '解析抖音视频' }
            ],
            'movie-lines': [
                { value: 'search_lines', text: '搜寻影视台词' }
            ],
            'ip-location': [
                { value: 'search_location', text: '查询IP位置' }
            ],
            'ip-details': [
                { value: 'search_details', text: '查询IP详情' }
            ],
            'zhihu-hot': [
                { value: 'fetch_hot_search', text: '获取热搜榜数据' }
            ],
            'llm-reader': [
                { value: 'read_content', text: '读取网页内容' }
            ],
            'universal-search': [
                { value: 'search', text: '搜索内容' }
            ],
            'hotboard': [
                { value: 'fetch_hotboard', text: '获取热榜数据' }
            ],
            'random-number': [
                { value: 'generate', text: '生成随机数' }
            ],
            'text-analyze': [
                { value: 'analyze', text: '分析文本' }
            ],
            'minecraft-status': [
                { value: 'query_status', text: '查询服务器状态' }
            ],
            'oil-price': [
                { value: 'query_oil_price', text: '查询油价' }
            ],
            'tv-boxoffice': [
                { value: 'fetch_tv_boxoffice', text: '获取电视剧票房' }
            ],
            'rp-luck': [
                { value: 'query_rp_luck', text: '查询人品运势' }
            ],
            'earthquake': [
                { value: 'fetch_earthquake_data', text: '获取地震信息' }
            ],
            'top-movie': [
                { value: 'fetch_top_movie', text: '获取全球票房榜' }
            ],
            'steam-online': [
                { value: '查询游戏在线人数', text: '查询游戏在线人数' }
            ],
            'bilibili-parse': [
                { value: '解析视频', text: '解析视频' }
            ],
            'temp-email': [
                { value: '生成邮箱', text: '生成邮箱' },
                { value: '检查邮件', text: '检查邮件' }
            ],
            'music-aggregator': [
                { value: '搜索音乐', text: '搜索音乐' },
                { value: '获取音乐详情', text: '获取音乐详情' }
            ],
            'beer-query': [
                { value: '关键词搜索', text: '关键词搜索' },
                { value: '按国家搜索', text: '按国家搜索' },
                { value: '按城市搜索', text: '按城市搜索' },
                { value: '按类型搜索', text: '按类型搜索' },
                { value: '获取随机啤酒厂', text: '获取随机啤酒厂' },
                { value: '关键词搜索(分页)', text: '关键词搜索(分页)' },
                { value: '按国家搜索(分页)', text: '按国家搜索(分页)' },
                { value: '按城市搜索(分页)', text: '按城市搜索(分页)' },
                { value: '按类型搜索(分页)', text: '按类型搜索(分页)' },
                { value: '分页加载', text: '分页加载' }
            ],
            'antutu-performance': [
                { value: '获取性能榜数据', text: '获取性能榜数据' }
            ],
            'train-batch-query': [
                { value: 'query', text: '查询火车班次' }
            ],
            'football-news': [
                { value: 'fetch_news_list', text: '获取新闻列表' },
                { value: 'fetch_news_detail', text: '获取新闻详情' }
            ],
            'cctv-news': [
                { value: 'fetch_news', text: '获取新闻数据' }
            ],
            'ks-painting': [
                { value: 'generate_painting', text: '生成绘画' }
            ],
            'car-info': [
                { value: 'query_car_info', text: '查询车辆信息' }
            ],
            'site-ping': [
                { value: 'ping_site', text: '检测站点' }
            ],
            'seo-diagnosis': [
                { value: 'diagnose', text: 'SEO诊断' }
            ],
            'proxy-pool': [
                { value: 'get_proxies', text: '获取代理' }
            ],
            'real-time-ip': [
                { value: 'get_ips', text: '获取IP' }
            ],
            'tiny-music': [
                { value: 'searchMusic', text: '搜索音乐' },
                { value: 'getHotSearchList', text: '获取热搜榜' },
                { value: 'getMusicList', text: '获取音乐列表' },
                { value: 'searchMusicDetail', text: '获取音乐详情' },
                { value: 'getSingerInfo', text: '获取歌手信息' }
            ],
            'gpt5-nano': [
                { value: 'sendMessage', text: '发送消息' }
            ],
            'constellation-pair': [
                { value: 'getConstellationData', text: '获取星座数据' }
            ],
            'ai-model-price': [
                { value: 'loadModelData', text: '获取模型数据' }
            ],
            'flux1': [
                { value: 'generateImage', text: '生成图片' }
            ],
            'kkmh': [
                { value: 'searchComics', text: '搜索漫画' }
            ],
            'mambo-voice': [
                { value: 'generateVoice', text: '生成配音' }
            ]
        };
        

        function getCurrentToolType() {
            return document.getElementById('tool_id').value;
        }
        
        
        function updateActionOptions() {
            const toolType = getCurrentToolType();
            const actionSelect = document.getElementById('action');
            const currentAction = actionSelect.value;
            
            
            actionSelect.innerHTML = '<option value="">全部</option>';
            
            
            if (toolType && toolActions[toolType]) {
                const actions = toolActions[toolType];
                actions.forEach(action => {
                    const option = document.createElement('option');
                    option.value = action.value;
                    option.text = action.text;
                    
                    if (option.value === currentAction) {
                        option.selected = true;
                    }
                    actionSelect.appendChild(option);
                });
            } else {
                
                
                
                
                            const allActions = [
                                { value: 'format', text: 'JSON格式化' },
                                { value: 'compress', text: 'JSON压缩' },
                                { value: 'validate_success', text: 'JSON验证成功' },
                                { value: 'validate_error', text: 'JSON验证失败' },
                                { value: 'fix_success', text: 'JSON修复成功' },
                                { value: 'fix_error', text: 'JSON修复失败' },
                                { value: 'encode', text: '编码' },
                                { value: 'decode', text: '解码' },
                                { value: 'decode_success', text: '解码成功' },
                                { value: 'decode_error', text: '解码失败' },
                                { value: 'encrypt', text: '加密' },
                                { value: 'convert_to_timestamp', text: '日期转时间戳' },
                                { value: 'convert_to_date', text: '时间戳转日期' },
                                { value: 'generate', text: '生成' },
                                { value: 'convert_color', text: '颜色转换' },
                                { value: 'test', text: '正则测试' },
                                { value: 'calculate', text: '计算' },
                                { value: 'convert', text: '转换' },
                                { value: 'compare', text: '文本对比' },
                                { value: 'minify', text: 'HTML压缩' },
                                { value: 'escape', text: 'HTML实体转义' },
                                { value: 'unescape', text: 'HTML实体反转义' },
                                { value: 'search_details', text: '查询IP详情' },
                                { value: 'fetch_hot_search', text: '获取热搜榜数据' },
                                { value: 'read_content', text: '读取网页内容' },
                                { value: 'search', text: '搜索内容' },
                                { value: 'fetch_hotboard', text: '获取热榜数据' },
                                { value: 'analyze', text: '分析文本' }
                            ];
                
                allActions.forEach(action => {
                    const option = document.createElement('option');
                    option.value = action.value;
                    option.text = action.text;
                    if (option.value === currentAction) {
                        option.selected = true;
                    }
                    actionSelect.appendChild(option);
                });
            }
        }
        
        
        document.addEventListener('DOMContentLoaded', function() {
            updateActionOptions();
            
            
            document.getElementById('tool_id').addEventListener('change', updateActionOptions);
        });
    </script>
</head>
<body>
    <div class="admin-container">
        
        <aside class="admin-sidebar">
            <div class="admin-sidebar-header">
                <h1 class="admin-logo">工具箱后台</h1>
            </div>
            
            <nav class="admin-menu">
                <ul class="admin-menu-list">
                    <li class="admin-menu-item">
                        <a href="index.php" class="admin-menu-link">
                            <span class="admin-menu-icon">📊</span>
                            <span class="admin-menu-text">仪表盘</span>
                        </a>
                    </li>
                    <li class="admin-menu-item">
                        <a href="tools.php" class="admin-menu-link">
                            <span class="admin-menu-icon">🔧</span>
                            <span class="admin-menu-text">工具管理</span>
                        </a>
                    </li>
                    <li class="admin-menu-item">
                        <a href="categories.php" class="admin-menu-link">
                            <span class="admin-menu-icon">📁</span>
                            <span class="admin-menu-text">分类管理</span>
                        </a>
                    </li>
                    <li class="admin-menu-item active">
                        <a href="tool-stats.php" class="admin-menu-link">
                            <span class="admin-menu-icon">📈</span>
                            <span class="admin-menu-text">工具调用数据</span>
                        </a>
                    </li>
                    <li class="admin-menu-item">
                        <a href="settings.php" class="admin-menu-link">
                            <span class="admin-menu-icon">⚙️</span>
                            <span class="admin-menu-text">系统设置</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="admin-sidebar-footer">
                <div class="admin-user-info">
                    <div class="admin-user-avatar">
                        <?php echo substr($admin['username'], 0, 1); ?>
                    </div>
                    <div class="admin-user-details">
                        <div class="admin-username"><?php echo $admin['username']; ?></div>
                        <div class="admin-role">管理员</div>
                    </div>
                </div>
                <div style="margin-top: 12px; text-align: center;">
                    <form action="php/logout.php" method="POST" style="display: inline;">
                        <button type="submit" class="admin-logout">退出登录</button>
                    </form>
                </div>
            </div>
        </aside>
        
        
        <main class="admin-main">
            <header class="admin-header">
                <div>
                    <h1 class="admin-page-title">工具调用数据</h1>
                    <div class="admin-breadcrumb">
                        <span class="breadcrumb-item">后台管理</span>
                        <span class="breadcrumb-separator">/</span>
                        <span class="breadcrumb-item">工具调用数据</span>
                    </div>
                </div>
                <div class="admin-current-time">
                    <?php echo date('Y年m月d日 H:i:s'); ?>
                </div>
            </header>
            
            
            <div class="dashboard-card">
                <div class="card-header">
                    <h2 class="card-title">工具调用总览</h2>
                </div>
                <div class="card-content">
                    <div class="stats-grid">
                        
                        <div class="stat-card">
                            <div class="stat-label">工具调用总数</div>
                            <div class="stat-value"><?php 
                                $totalAll = 0;
                                foreach ($toolStats as $stat) {
                                    $totalAll += $stat['total'];
                                }
                                echo $totalAll;
                            ?></div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-label">今日调用总数</div>
                            <div class="stat-value"><?php 

                                $today = date('Y-m-d');
                                $sql = "SELECT COUNT(*) as today_total FROM history WHERE DATE(created_at) = ?";
                                $todayResult = $db->fetchOne($sql, array($today));
                                echo $todayResult['today_total'];
                            ?></div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-label">总失败数</div>
                            <div class="stat-value error"><?php 
                                $errorAll = 0;
                                foreach ($toolStats as $stat) {
                                    $errorAll += $stat['error'];
                                }
                                echo $errorAll;
                            ?></div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-label">今日失败数</div>
                            <div class="stat-value error"><?php 

                                $today = date('Y-m-d');
                                $sql = "SELECT COUNT(*) as today_error FROM history WHERE DATE(created_at) = ? AND status = 'error'";
                                $todayErrorResult = $db->fetchOne($sql, array($today));
                                echo $todayErrorResult['today_error'];
                            ?></div>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="dashboard-card">
                <div class="card-header">
                    <h2 class="card-title">工具调用明细</h2>
                </div>
                <div class="card-content">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>工具类型</th>
                                <th>调用总数</th>
                                <th>成功数</th>
                                <th>失败数</th>
                                <th>今日调用数</th>
                                <th>平均响应时间(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($toolStats as $index => $stat): ?>
                            <?php

                                $today = date('Y-m-d');
                                $sql = "SELECT COUNT(*) as today_count FROM history WHERE tool_id = ? AND DATE(created_at) = ?";
                                $todayResult = $db->fetchOne($sql, array($stat['tool_id'], $today));
                                $todayCount = $todayResult['today_count'];
                                

                                $sql = "SELECT AVG(response_time) as avg_time FROM history WHERE tool_id = ? AND response_time IS NOT NULL";
                                $timeResult = $db->fetchOne($sql, array($stat['tool_id']));
                                $avgResponseTime = $timeResult['avg_time'] ? round($timeResult['avg_time'], 3) : 0;
                            ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo $stat['tool_name']; ?></td>
                                <td><?php echo $stat['total']; ?></td>
                                <td><?php echo $stat['success']; ?></td>
                                <td><?php echo $stat['error']; ?></td>
                                <td><?php echo $todayCount; ?></td>
                                <td><?php echo $avgResponseTime; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            

            <div class="dashboard-card">
                <div class="card-header">
                    <h2 class="card-title">调用记录列表</h2>
                    <div style="font-size: 14px; color: #666;">
                        共 <?php echo $totalRecords; ?> 条记录，第 <?php echo $page; ?>/<?php echo $totalPages; ?> 页
                    </div>
                </div>
                <div class="card-content">

                    <div class="filter-section" style="margin-bottom: 20px;">
                        <form method="GET" class="filter-form">
                            <div class="filter-row">
                                <div class="filter-item">
                                    <label for="tool_id">工具类型：</label>
                                    <select name="tool_id" id="tool_id">
                                        <option value="">全部</option>
                                        <?php foreach ($tools as $toolId): ?>
                                        <option value="<?php echo $toolId; ?>" <?php echo $toolFilter === $toolId ? 'selected' : ''; ?>>
                                            <?php echo $toolNames[$toolId]; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="filter-item">
                                    <label for="action">操作类型：</label>
                                    <select name="action" id="action">
                                        <option value="">全部</option>

                                    </select>
                                </div>
                                <div class="filter-item">
                                    <label for="date_start">开始日期：</label>
                                    <input type="date" name="date_start" id="date_start" value="<?php echo $dateStart; ?>">
                                </div>
                                <div class="filter-item">
                                    <label for="date_end">结束日期：</label>
                                    <input type="date" name="date_end" id="date_end" value="<?php echo $dateEnd; ?>">
                                </div>
                                <div class="filter-item">
                                    <label for="page_size">每页条数：</label>
                                    <select name="page_size" id="page_size">
                                        <option value="20" <?php echo $pageSize === 20 ? 'selected' : ''; ?>>20</option>
                                        <option value="50" <?php echo $pageSize === 50 ? 'selected' : ''; ?>>50</option>
                                        <option value="100" <?php echo $pageSize === 100 ? 'selected' : ''; ?>>100</option>
                                    </select>
                                </div>
                                <div class="filter-item">
                                    <button type="submit" class="btn btn-primary">筛选</button>
                                    <button type="button" class="btn btn-secondary" onclick="window.location.href='tool-stats.php'">重置</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>工具类型</th>
                                <th>操作类型</th>
                                <th>状态</th>
                                <th>响应时间(s)</th>
                                <th>创建时间</th>
                                <th>IP地址</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($records)): ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px; color: #666;">
                                    没有找到调用记录
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($records as $record): ?>
                            <?php

                                $action = 'unknown';
                                $content = json_decode($record['content'], true);
                                if (isset($content['action'])) {
                                    $action = $content['action'];
                                }
                            ?>
                            <tr>
                                <td><?php echo $record['id']; ?></td>
                                <td><?php echo $toolNames[$record['tool_id']] ?? $record['tool_id']; ?></td>
                                <td><span class="action"><?php echo $action; ?></span></td>
                                <td>
                                    <span class="status <?php echo $record['status']; ?>">
                                        <?php echo $record['status'] === 'success' ? '成功' : '失败'; ?>
                                    </span>
                                </td>
                                <td><?php echo $record['response_time']; ?></td>
                                <td><?php echo $record['created_at']; ?></td>
                                <td><?php echo $record['ip_address']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    

                    <div class="pagination">
                        <button 
                            class="btn btn-secondary" 
                            <?php echo $page <= 1 ? 'disabled' : ''; ?>
                            onclick="window.location.href='tool-stats.php?page=<?php echo $page - 1; ?>&tool_id=<?php echo $toolFilter; ?>&action=<?php echo $actionFilter; ?>&date_start=<?php echo $dateStart; ?>&date_end=<?php echo $dateEnd; ?>&page_size=<?php echo $pageSize; ?>'"
                        >
                            上一页
                        </button>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <button 
                            class="btn <?php echo $i === $page ? 'btn-primary' : 'btn-secondary'; ?>"
                            onclick="window.location.href='tool-stats.php?page=<?php echo $i; ?>&tool_id=<?php echo $toolFilter; ?>&action=<?php echo $actionFilter; ?>&date_start=<?php echo $dateStart; ?>&date_end=<?php echo $dateEnd; ?>&page_size=<?php echo $pageSize; ?>'"
                        >
                            <?php echo $i; ?>
                        </button>
                        <?php endfor; ?>
                        <button 
                            class="btn btn-secondary" 
                            <?php echo $page >= $totalPages ? 'disabled' : ''; ?>
                            onclick="window.location.href='tool-stats.php?page=<?php echo $page + 1; ?>&tool_id=<?php echo $toolFilter; ?>&action=<?php echo $actionFilter; ?>&date_start=<?php echo $dateStart; ?>&date_end=<?php echo $dateEnd; ?>&page_size=<?php echo $pageSize; ?>'"
                        >
                            下一页
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>