<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>实时科技资讯 - 工具箱</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .tool-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .tool-icon {
            font-size: 48px;
            margin-bottom: 16px;
        }
        
        .tool-title {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .tool-desc {
            font-size: 16px;
            color: #666;
        }
        
        .tool-content {
            background-color: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }
        
        .news-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .news-title {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .news-update-time {
            font-size: 14px;
            color: #999;
        }
        
        .action-section {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        
        .btn {
            padding: 12px 24px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #fafafa;
            color: #1a1a1a;
        }
        
        .btn:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
        }
        
        .btn-primary {
            background-color: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
        }
        
        .btn-primary:hover {
            background-color: #333;
        }
        
        .news-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        .news-item {
            padding: 20px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .news-item:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
            transform: translateX(4px);
        }
        
        .news-item-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            flex-wrap: wrap;
        }
        
        .news-item-title {
            flex: 1;
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            line-height: 1.6;
            min-width: 250px;
        }
        
        .news-item-time {
            font-size: 14px;
            color: #999;
            white-space: nowrap;
        }
        
        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        .error {
            padding: 16px;
            background-color: #fff3f3;
            border: 1px solid #ffe0e0;
            border-radius: 8px;
            color: #d63031;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .tool-container {
                padding: 20px 16px;
            }
            
            .tool-title {
                font-size: 24px;
            }
            
            .tool-content {
                padding: 20px;
            }
            
            .news-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .news-item-content {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .news-item-time {
                align-self: flex-end;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 class="logo">工具箱</h1>
            </div>
            <nav class="menu">
                <?php
                require_once '../php/framework.php';
                
                echo $toolbox->renderMenu();
                ?>
            </nav>
            <div class="sidebar-footer">
                <p class="copyright">© 2025 工具箱</p>
            </div>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h2>实时科技资讯</h2>
                    <p>获取当前时间的最新实时科技资讯信息</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    <div class="news-header">
                        <div class="news-title">最新科技资讯</div>
                        <div class="news-update-time" id="update-time"></div>
                    </div>
                    
                    <div class="action-section">
                        <button class="btn btn-primary" id="refresh-btn">刷新资讯</button>
                    </div>
                    
                    <div class="news-list" id="news-list">
                    </div>
                    
                    <div id="loading" class="loading" style="display: none;">
                        正在获取实时科技资讯，请稍候...
                    </div>
                    
                    <div id="error" class="error" style="display: none;"></div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        function recordToolUsage(action, status = 'success', content = null, responseTime = null) {
            fetch('../php/record-tool-usage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tool_id: 'tech-news',
                    action: action,
                    content: content,
                    result: {
                        status: status
                    },
                    response_time: responseTime
                })
            }).catch(error => {
                console.error('记录使用量失败:', error);
            });
        }

        class TechNews {
            constructor() {
                this.refreshBtn = document.getElementById('refresh-btn');
                this.updateTime = document.getElementById('update-time');
                this.newsList = document.getElementById('news-list');
                this.loading = document.getElementById('loading');
                this.error = document.getElementById('error');
                
                this.apiUrl = '../php/tech-news-proxy.php';
                
                this.init();
            }
            
            init() {
                this.initEventListeners();
                
                this.fetchNews();
            }
            
            initEventListeners() {
                this.refreshBtn.addEventListener('click', () => {
                    this.fetchNews();
                });
            }
            
            async fetchNews() {
                this.showLoading();
                
                const startTime = Date.now();
                
                try {
                    const response = await fetch(this.apiUrl, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    if (data.code === 200) {
                        this.showNews(data);
                        recordToolUsage('fetch_news', 'success', {
                            api_code: data.code,
                            news_count: data.data ? data.data.length : 0,
                            update_time: data.update || ''
                        }, responseTime);
                    } else {
                        this.showError(data.msg || '获取数据失败');
                        recordToolUsage('fetch_news', 'error', {
                            api_code: data.code || 500,
                            error_msg: data.msg || '获取数据失败'
                        }, responseTime);
                    }
                } catch (error) {
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.showError(`获取数据失败: ${error.message}`);
                    console.error('API请求错误:', error);
                    recordToolUsage('fetch_news', 'error', {
                        error_msg: error.message,
                        exception: error.message
                    }, responseTime);
                }
            }
            
            showNews(data) {
                this.updateTime.textContent = `更新时间: ${data.update}`;
                
                this.newsList.innerHTML = '';
                
                data.data.forEach(news => {
                    const newsItem = this.createNewsItem(news);
                    this.newsList.appendChild(newsItem);
                });
                
                this.hideLoading();
            }
            
            createNewsItem(news) {
                const item = document.createElement('div');
                item.className = 'news-item';
                
                item.innerHTML = `
                    <div class="news-item-content">
                        <div class="news-item-title">${news.title}</div>
                        <div class="news-item-time">${news.time}</div>
                    </div>
                `;
                
                return item;
            }
            
            showLoading() {
                this.loading.style.display = 'block';
                this.error.style.display = 'none';
                this.newsList.innerHTML = '';
            }
            
            hideLoading() {
                this.loading.style.display = 'none';
                this.error.style.display = 'none';
            }
            
            showError(message) {
                this.error.textContent = message;
                this.loading.style.display = 'none';
                this.newsList.innerHTML = '';
                this.error.style.display = 'block';
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new TechNews();
        });
    </script>
</body>
</html>