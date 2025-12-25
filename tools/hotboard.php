<?php

require_once '../php/framework.php';


$toolbox = new ToolboxFramework();


$siteConfig = $toolbox->getSiteConfig();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>多平台实时热榜 - <?php echo $siteConfig['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .tool-content {
            background-color: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }
        
        
        .controls {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            align-items: flex-end;
            margin-bottom: 30px;
        }
        
        .form-group {
            flex: 1;
            min-width: 250px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .platform-select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #fff;
            cursor: pointer;
        }
        
        .platform-select:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.05);
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #1a1a1a;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        
        .update-info {
            margin-bottom: 20px;
            font-size: 14px;
            color: #666;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .update-time {
            font-weight: 500;
        }
        
        
        .hotboard-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .hotboard-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 8px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .hotboard-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .hotboard-rank {
            font-size: 24px;
            font-weight: 700;
            color: #ff4d4f;
            min-width: 32px;
            text-align: center;
            line-height: 1;
            margin-top: 4px;
        }
        
        .hotboard-content {
            flex: 1;
        }
        
        .hotboard-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
            text-decoration: none;
        }
        
        .hotboard-title:hover {
            text-decoration: underline;
        }
        
        .hotboard-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            color: #666;
        }
        
        .hotboard-hot {
            color: #ff7875;
            font-weight: 500;
        }
        
        
        .loading {
            display: none;
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        .loading.visible {
            display: block;
        }
        
        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #1a1a1a;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 16px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        
        .error-message {
            display: none;
            background-color: #fff3f3;
            border: 1px solid #ffe0e0;
            border-radius: 8px;
            padding: 16px;
            color: #d63031;
            margin-bottom: 20px;
        }
        
        .error-message.visible {
            display: block;
        }
        
        
        .empty-state {
            display: block;
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        
        .empty-state.hidden {
            display: none;
        }
        
        .empty-icon {
            font-size: 64px;
            margin-bottom: 16px;
        }
        
        
        @media (max-width: 768px) {
            .tool-container {
                padding: 20px 16px;
            }
            
            .tool-content {
                padding: 20px;
            }
            
            .controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .form-group {
                min-width: auto;
            }
            
            .hotboard-item {
                padding: 16px;
            }
            
            .hotboard-rank {
                font-size: 20px;
            }
            
            .hotboard-title {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 class="logo"><?php echo $siteConfig['name']; ?></h1>
            </div>
            <nav class="menu">
                <?php echo $toolbox->renderMenu(); ?>
            </nav>
            <div class="sidebar-footer">
                <p class="copyright">© 2025 <?php echo $siteConfig['name']; ?></p>
            </div>
        </aside>

        
        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h2>多平台实时热榜</h2>
                    <p>一网打尽各大主流平台的实时热榜/热搜，快速跟上网络热点</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    
                    <div class="error-message" id="error-message"></div>
                    
                    
                    <div class="empty-state" id="empty-state">
                        <div class="empty-icon">📊</div>
                        <div>请选择平台，获取实时热榜数据</div>
                    </div>
                    
                    
                    <div class="controls">
                        <div class="form-group">
                            <label class="form-label" for="platform">选择平台</label>
                            <select class="platform-select" id="platform">
                                
                                <optgroup label="视频/社区">
                                    <option value="bilibili">哔哩哔哩弹幕网</option>
                                    <option value="acfun">A站弹幕视频网站</option>
                                    <option value="weibo" selected>新浪微博热搜</option>
                                    <option value="zhihu">知乎热榜</option>
                                    <option value="zhihu-daily">知乎日报热榜</option>
                                    <option value="douyin">抖音热榜</option>
                                    <option value="kuaishou">快手热榜</option>
                                    <option value="douban-movie">豆瓣电影榜单</option>
                                    <option value="douban-group">豆瓣小组话题</option>
                                    <option value="tieba">百度贴吧热帖</option>
                                    <option value="hupu">虎扑热帖</option>
                                    <option value="miyoushe">米游社话题榜</option>
                                    <option value="ngabbs">NGA游戏论坛热帖</option>
                                    <option value="v2ex">V2EX技术社区热帖</option>
                                    <option value="52pojie">吾爱破解热帖</option>
                                    <option value="hostloc">全球主机交流论坛</option>
                                    <option value="coolapk">酷安热榜</option>
                                </optgroup>
                                
                                <optgroup label="新闻/资讯">
                                    <option value="baidu">百度热搜</option>
                                    <option value="thepaper">澎湃新闻热榜</option>
                                    <option value="toutiao">今日头条热榜</option>
                                    <option value="qq-news">腾讯新闻热榜</option>
                                    <option value="sina">新浪热搜</option>
                                    <option value="sina-news">新浪新闻热榜</option>
                                    <option value="netease-news">网易新闻热榜</option>
                                    <option value="huxiu">虎嗅网热榜</option>
                                    <option value="ifanr">爱范儿热榜</option>
                                </optgroup>
                                
                                <optgroup label="技术/IT">
                                    <option value="sspai">少数派热榜</option>
                                    <option value="ithome">IT之家热榜</option>
                                    <option value="ithome-xijiayi">IT之家·喜加一栏目</option>
                                    <option value="juejin">掘金社区热榜</option>
                                    <option value="jianshu">简书热榜</option>
                                    <option value="guokr">果壳热榜</option>
                                    <option value="36kr">36氪热榜</option>
                                    <option value="51cto">51CTO热榜</option>
                                    <option value="csdn">CSDN博客热榜</option>
                                    <option value="nodeseek">NodeSeek 技术社区</option>
                                    <option value="hellogithub">HelloGitHub 项目推荐</option>
                                </optgroup>
                                
                                <optgroup label="游戏">
                                    <option value="lol">英雄联盟热帖</option>
                                    <option value="genshin">原神热榜</option>
                                    <option value="honkai">崩坏3热榜</option>
                                    <option value="starrail">星穹铁道热榜</option>
                                </optgroup>
                                
                                <optgroup label="其他">
                                    <option value="weread">微信读书热门书籍</option>
                                    <option value="weatheralarm">天气预警信息</option>
                                    <option value="earthquake">地震速报</option>
                                    <option value="history">历史上的今天</option>
                                </optgroup>
                            </select>
                        </div>
                        <button class="btn" id="refresh-btn">
                            <span class="loading-icon" style="display: none;">🔄</span>
                            <span>获取热榜</span>
                        </button>
                    </div>
                    
                    
                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div>正在获取热榜数据，请稍候...</div>
                    </div>
                    
                    
                    <div class="update-info" id="update-info" style="display: none;">
                        <span>更新时间:</span>
                        <span class="update-time" id="update-time"></span>
                    </div>
                    
                    
                    <ul class="hotboard-list" id="hotboard-list"></ul>
                </div>
            </div>
        </main>
    </div>
    
    <script src="../js/main.js"></script>
    
    <script>
        
        async function recordToolUsage(action, status = 'success', content = null, responseTime = null) {
            try {
                await fetch('../php/record-tool-usage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        tool_id: 'hotboard',
                        action: action,
                        content: content,
                        result: {
                            status: status
                        },
                        response_time: responseTime
                    })
                });
            } catch (error) {
                console.error('记录工具使用情况失败:', error);
            }
        }
        
        class Hotboard {
            constructor() {
                this.init();
                this.getData();
            }
            
            init() {
                this.bindEvents();
            }
            
            bindEvents() {
                const refreshBtn = document.getElementById('refresh-btn');
                const platformSelect = document.getElementById('platform');
                
                refreshBtn.addEventListener('click', () => {
                    this.getData();
                });
                
                platformSelect.addEventListener('change', () => {
                    this.getData();
                });
            }
            
            async getData() {
                const platform = document.getElementById('platform').value;
                
                this.showLoading();
                this.hideError();
                this.hideEmptyState();
                this.hideUpdateInfo();
                this.hideHotboard();
                this.disableRefreshBtn();
                
                const startTime = Date.now();
                
                try {
                    
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 30000); 
                    
                    
                    const requestUrl = `../php/hotboard-proxy.php?type=${encodeURIComponent(platform)}`;
                    
                    const response = await fetch(requestUrl, {
                        method: 'GET',
                        signal: controller.signal
                    });
                    
                    clearTimeout(timeoutId);
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    if (data.code === 200 || !data.code) {
                        
                        this.displayResults(data);
                        await recordToolUsage('fetch_hotboard', 'success', { 
                            api_code: data.code || 200, 
                            platform: platform, 
                            result_count: data.list ? data.list.length : 0, 
                            update_time: data.update_time || '未知'
                        }, responseTime);
                    } else {
                        
                        let errorMsg = data.msg || '获取热榜失败';
                        this.showError(errorMsg);
                        this.showEmptyState();
                        await recordToolUsage('fetch_hotboard', 'error', { 
                            api_code: data.code || 500, 
                            platform: platform, 
                            error_msg: errorMsg 
                        }, responseTime);
                    }
                } catch (error) {
                    const responseTime = (Date.now() - startTime) / 1000;
                    let errorMsg = `获取热榜失败: ${error.message}`;
                    if (error.name === 'AbortError') {
                        errorMsg = '获取超时，请稍后重试';
                    }
                    this.showError(errorMsg);
                    this.showEmptyState();
                    console.error('API请求错误:', error);
                    await recordToolUsage('fetch_hotboard', 'error', { 
                        exception: error.message,
                        platform: platform,
                        error_msg: errorMsg
                    }, responseTime);
                } finally {
                    this.hideLoading();
                    this.enableRefreshBtn();
                }
            }
            
            displayResults(data) {
                
                const platform = document.getElementById('platform').value;
                
                
                this.showUpdateInfo();
                const updateTime = document.getElementById('update-time');
                updateTime.textContent = data.update_time || '未知';
                
                
                const hotboardList = document.getElementById('hotboard-list');
                hotboardList.innerHTML = '';
                
                if (data.list && data.list.length > 0) {
                    
                    data.list.forEach((item, index) => {
                        const listItem = this.createHotboardItem(item, index + 1);
                        hotboardList.appendChild(listItem);
                    });
                    this.showHotboard();
                } else {
                    this.showEmptyState();
                }
            }
            
            createHotboardItem(item, index) {
                const listItem = document.createElement('li');
                listItem.className = 'hotboard-item';
                
                listItem.innerHTML = `
                    <div class="hotboard-rank">${index}</div>
                    <div class="hotboard-content">
                        <a href="${this.escapeHtml(item.url)}" class="hotboard-title" target="_blank" rel="noopener noreferrer">${this.escapeHtml(item.title)}</a>
                        <div class="hotboard-meta">
                            ${item.hot_value ? `<span class="hotboard-hot">🔥 ${item.hot_value}</span>` : ''}
                        </div>
                    </div>
                `;
                
                return listItem;
            }
            
            showLoading() {
                document.getElementById('loading').classList.add('visible');
            }
            
            hideLoading() {
                document.getElementById('loading').classList.remove('visible');
            }
            
            showError(message) {
                const errorElement = document.getElementById('error-message');
                errorElement.textContent = message;
                errorElement.classList.add('visible');
            }
            
            hideError() {
                document.getElementById('error-message').classList.remove('visible');
            }
            
            showUpdateInfo() {
                document.getElementById('update-info').style.display = 'flex';
            }
            
            hideUpdateInfo() {
                document.getElementById('update-info').style.display = 'none';
            }
            
            showHotboard() {
                document.getElementById('hotboard-list').style.display = 'block';
            }
            
            hideHotboard() {
                document.getElementById('hotboard-list').innerHTML = '';
                document.getElementById('hotboard-list').style.display = 'none';
            }
            
            showEmptyState() {
                document.getElementById('empty-state').classList.remove('hidden');
            }
            
            hideEmptyState() {
                document.getElementById('empty-state').classList.add('hidden');
            }
            
            disableRefreshBtn() {
                const refreshBtn = document.getElementById('refresh-btn');
                refreshBtn.disabled = true;
                refreshBtn.querySelector('.loading-icon').style.display = 'inline-block';
                refreshBtn.querySelector('span:last-child').textContent = '获取中...';
            }
            
            enableRefreshBtn() {
                const refreshBtn = document.getElementById('refresh-btn');
                refreshBtn.disabled = false;
                refreshBtn.querySelector('.loading-icon').style.display = 'none';
                refreshBtn.querySelector('span:last-child').textContent = '获取热榜';
            }
            
            
            escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
        }
        
        
        document.addEventListener('DOMContentLoaded', () => {
            new Hotboard();
        });
    </script>
</body>
</html>