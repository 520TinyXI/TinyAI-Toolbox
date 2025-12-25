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
    <title>知乎热搜榜 - <?php echo $siteConfig['name']; ?></title>
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
        

        .hot-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .hot-date {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .hot-fresh-text {
            font-size: 14px;
            color: #666;
            background-color: #f0f7ff;
            padding: 6px 12px;
            border-radius: 16px;
        }
        

        .btn-refresh {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #1a1a1a;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-refresh:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        

        .hot-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .hot-item {
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin-bottom: 8px;
        }
        
        .hot-item:last-child {
            border-bottom: none;
        }
        
        .hot-item:hover {
            background-color: #fafafa;
            transform: translateX(4px);
        }
        
        .hot-item-top {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 12px;
        }
        
        .hot-rank {
            font-size: 24px;
            font-weight: 700;
            color: #ff4d4f;
            min-width: 32px;
            text-align: center;
            line-height: 1;
        }
        
        .hot-rank:nth-child(n+11) {
            font-size: 18px;
            color: #999;
        }
        
        .hot-content {
            flex: 1;
        }
        
        .hot-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
            line-height: 1.5;
        }
        
        .hot-excerpt {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .hot-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        
        .hot-meta {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .hot-hot {
            font-size: 14px;
            font-weight: 600;
            color: #ff7875;
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
            display: none;
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        
        .empty-state.visible {
            display: block;
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
            
            .hot-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .hot-rank {
                font-size: 20px;
            }
            
            .hot-rank:nth-child(n+11) {
                font-size: 16px;
            }
            
            .hot-title {
                font-size: 15px;
            }
            
            .hot-excerpt {
                font-size: 13px;
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
                    <h2>知乎热搜榜</h2>
                    <p>实时获取知乎热搜榜数据，了解热门话题</p>
                </div>
            </header>
            
            <div class="tool-container">

                <div class="tool-content">

                    <div class="error-message" id="error-message"></div>
                    

                    <div class="empty-state" id="empty-state">
                        <div class="empty-icon">🔍</div>
                        <div>暂无热搜数据，请点击刷新按钮获取</div>
                    </div>
                    

                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div>正在获取知乎热搜榜数据，请稍候...</div>
                    </div>
                    

                    <div class="hot-header" id="hot-header" style="display: none;">
                        <div>
                            <div class="hot-date" id="hot-date"></div>
                            <div class="hot-fresh-text" id="hot-fresh-text"></div>
                        </div>
                        <button class="btn-refresh" id="refresh-btn">
                            <span class="loading-icon" style="display: none;">🔄</span>
                            <span>刷新数据</span>
                        </button>
                    </div>
                    

                    <ul class="hot-list" id="hot-list"></ul>
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
                        tool_id: 'zhihu-hot',
                        action: action,
                        content: content,
                        result: {
                            status: status
                        },
                        response_time: responseTime
                    })
                });
            } catch (error) {
                console.error('Failed to record tool usage:', error);
            }
        }

        class ZhihuHotSearch {
            constructor() {
                this.init();
                this.getData();
            }
            
            init() {
                this.bindEvents();
            }
            
            bindEvents() {
                const refreshBtn = document.getElementById('refresh-btn');
                refreshBtn.addEventListener('click', () => {
                    this.getData();
                });
            }
            
            async getData() {
                this.showLoading();
                this.hideError();
                this.hideEmptyState();
                this.hideHotData();
                this.disableRefreshBtn();
                
                const startTime = Date.now();
                
                try {
        
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 30000);
                    
                    const response = await fetch('../php/zhihu-hot-proxy.php', {
                        method: 'GET',
                        signal: controller.signal
                    });
                    
                    clearTimeout(timeoutId);
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    if (data.code === '200' || data.code === 200) {
                        this.displayData(data);
                        await recordToolUsage('fetch_hot_search', 'success', { 
                            api_code: data.code,
                            day: data.day || '未知时间' 
                        }, responseTime);
                    } else {
                        throw new Error(data.msg || '获取数据失败');
                    }
                } catch (error) {
                    const responseTime = (Date.now() - startTime) / 1000;
                    let errorMsg = `获取失败: ${error.message}`;
                    if (error.name === 'AbortError') {
                        errorMsg = '获取超时，请稍后重试';
                    }
                    this.showError(errorMsg);
                    this.showEmptyState();
                    console.error('获取数据失败:', error);
                    await recordToolUsage('fetch_hot_search', 'error', { 
                        exception: error.message
                    }, responseTime);
                } finally {
                    this.hideLoading();
                    this.enableRefreshBtn();
                }
            }
            
            displayData(data) {

                const hotDate = document.getElementById('hot-date');
                const hotFreshText = document.getElementById('hot-fresh-text');
                
                hotDate.textContent = data.day || '未知时间';
                hotFreshText.textContent = data.fresh_text || '热榜数据';
                

                this.showHotData();
                

                const hotList = document.getElementById('hot-list');
                hotList.innerHTML = '';
                

                let count = 0;
                for (let i = 1; i <= 50; i++) {
                    const key = `Top_${i}`;
                    if (data[key]) {
                        const hotItem = data[key];
                        if (hotItem.title && hotItem.title !== null) {
                            count++;
                            const listItem = this.createHotItem(i, hotItem);
                            hotList.appendChild(listItem);
                        }
                    }
                }
                
                if (count === 0) {
                    this.showEmptyState();
                    this.hideHotData();
                }
            }
            
            createHotItem(rank, hotItem) {
                const listItem = document.createElement('li');
                listItem.className = 'hot-item';
                
                const excerpt = hotItem.excerpt || '';
                
                listItem.innerHTML = `
                    <div class="hot-item-top">
                        <div class="hot-rank">${rank}</div>
                        <div class="hot-content">
                            <div class="hot-title">${this.escapeHtml(hotItem.title)}</div>
                            ${excerpt ? `<div class="hot-excerpt">${this.escapeHtml(excerpt)}</div>` : ''}
                            <div class="hot-footer">
                                <div class="hot-meta">
                                    <div class="hot-hot">${hotItem.hot || '未知热度'}</div>
                                </div>
                            </div>
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
            
            showEmptyState() {
                document.getElementById('empty-state').classList.add('visible');
            }
            
            hideEmptyState() {
                document.getElementById('empty-state').classList.remove('visible');
            }
            
            showHotData() {
                document.getElementById('hot-header').style.display = 'flex';
            }
            
            hideHotData() {
                document.getElementById('hot-header').style.display = 'none';
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
                refreshBtn.querySelector('span:last-child').textContent = '刷新数据';
            }
            

            escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new ZhihuHotSearch();
        });
    </script>
</body>
</html>