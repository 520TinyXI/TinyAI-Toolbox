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
    <title>央视新闻热点 - <?php echo $siteConfig['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 1200px;
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
        

        .query-section {
            background-color: #fafafa;
            padding: 24px;
            border-radius: 8px;
            margin-bottom: 24px;
            border: 1px solid #e0e0e0;
        }
        
        .form-row {
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .form-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .form-input {
            padding: 10px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            width: 120px;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 2px rgba(26, 26, 26, 0.1);
        }
        

        .btn {
            padding: 10px 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #fafafa;
            color: #1a1a1a;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        

        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        

        .news-card {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .news-card:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .news-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
        }
        
        .news-content {
            padding: 16px;
        }
        
        .news-time {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
            display: block;
        }
        
        .news-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
            line-height: 1.4;
        }
        
        .news-brief {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .news-link {
            font-size: 14px;
            color: #1a1a1a;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .news-link:hover {
            text-decoration: underline;
        }
        

        .loading-container {
            text-align: center;
            padding: 60px 0;
            color: #666;
        }
        
        .loading {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 3px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top-color: #1a1a1a;
            animation: spin 1s ease-in-out infinite;
            margin-bottom: 16px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        

        .error-container {
            background-color: #fff3f3;
            border: 1px solid #ffe0e0;
            border-radius: 8px;
            padding: 20px;
            color: #d63031;
            margin-bottom: 30px;
        }
        
        .error-message {
            font-size: 16px;
        }
        

        @media (max-width: 768px) {
            .tool-container {
                padding: 20px 16px;
            }
            
            .tool-content {
                padding: 20px;
            }
            
            .news-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            
            .form-row {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .form-group {
                width: 100%;
            }
            
            .form-input {
                width: 100%;
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
                    <h2>央视新闻热点</h2>
                    <p>获取最新的央视新闻热点资讯</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">

                    <div class="error-container" id="error-container" style="display: none;">
                        <div class="error-message" id="error-message">获取新闻失败，请稍后重试</div>
                    </div>
                    

                    <div class="query-section">
                        <form id="query-form" class="form-row">
                            <div class="form-group">
                                <label for="count" class="form-label">新闻数量：</label>
                                <input type="number" id="count" name="count" class="form-input" min="1" max="50" value="10">
                            </div>
                            <button type="submit" class="btn btn-primary" id="query-btn">
                                <span class="loading-icon" style="display: none;">🔄</span>
                                获取新闻
                            </button>
                        </form>
                    </div>
                    

                    <div class="news-grid" id="news-grid"></div>
                    

                    <div class="loading-container" id="loading-container" style="display: none;">
                        <div class="loading"></div>
                        <p>正在获取央视新闻热点，请稍候...</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        async function recordToolUsage(toolId, action, statusValue, responseTime = 0, content = '') {
            try {
                const status = statusValue === 1 ? 'success' : 'error';
                
                const contentObj = {
                    action: action
                };
                
                const responseTimeSeconds = responseTime / 1000;
                
                await fetch('../php/record-tool-usage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        tool_id: toolId,
                        content: contentObj,
                        status: status,
                        response_time: responseTimeSeconds
                    })
                });
            } catch (error) {
                console.error('Failed to record tool usage:', error);
            }
        }
        
        class CCTVNews {
            constructor() {
                this.queryForm = document.getElementById('query-form');
                this.countInput = document.getElementById('count');
                this.queryBtn = document.getElementById('query-btn');
                this.loadingIcon = this.queryBtn.querySelector('.loading-icon');
                this.newsGrid = document.getElementById('news-grid');
                this.loadingContainer = document.getElementById('loading-container');
                this.errorContainer = document.getElementById('error-container');
                this.errorMessage = document.getElementById('error-message');
                
                this.apiUrl = 'https://api.jkyai.top/API/ysxwrd.php';
                
                this.init();
            }
            
            init() {
                this.initEventListeners();
                
                this.fetchNews();
            }
            
            initEventListeners() {
                this.queryForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.fetchNews();
                });
            }
            
            async fetchNews() {
                const count = this.countInput.value || 10;
                
                this.showLoading();
                
                const startTime = Date.now();
                
                try {
                    const requestUrl = `${this.apiUrl}?count=${count}&type=json`;
                    console.log('Request URL:', requestUrl);
                    
                    const response = await fetch(requestUrl, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP Error! Status code: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    console.log('Response data:', data);
                    
                    const responseTime = Date.now() - startTime;
                    
                    if (data.code === 200 && data.data) {
                        this.showNews(data.data);
                        await recordToolUsage('cctv-news', 'fetch_news', 1, responseTime, `Fetched ${count} news items`);
                    } else {
                        this.showError(data.message || 'Failed to fetch news');
                        await recordToolUsage('cctv-news', 'fetch_news', 0, responseTime, `Fetched ${count} news items`);
                    }
                } catch (error) {
                    console.error('Failed to fetch news:', error);
                    this.showError(`Failed to fetch news: ${error.message}`);
                    const responseTime = Date.now() - startTime;
                    await recordToolUsage('cctv-news', 'fetch_news', 0, responseTime, `Fetched ${count} news items`);
                }
            }
            
            showNews(newsList) {
                this.newsGrid.innerHTML = '';
                
                if (newsList.length > 0) {
                    newsList.forEach(news => {
                        const card = this.createNewsCard(news);
                        this.newsGrid.appendChild(card);
                    });
                } else {
                    this.newsGrid.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">No news data available</div>';
                }
                
                this.hideLoading();
            }
            
            createNewsCard(news) {
                const card = document.createElement('div');
                card.className = 'news-card';
                
                card.innerHTML = `
                    <img src="${news.image || 'https://via.placeholder.com/320x180'}" alt="News Image" class="news-image">
                    <div class="news-content">
                        <span class="news-time">${news.time}</span>
                        <h3 class="news-title">${news.title}</h3>
                        <p class="news-brief">${news.brief}</p>
                        <a href="${news.url}" target="_blank" class="news-link">
                            View Details →
                        </a>
                    </div>
                `;
                
                return card;
            }
            
            showLoading() {
                this.queryBtn.disabled = true;
                this.loadingIcon.style.display = 'inline';
                this.loadingContainer.style.display = 'block';
                this.errorContainer.style.display = 'none';
            }
            
            hideLoading() {
                this.queryBtn.disabled = false;
                this.loadingIcon.style.display = 'none';
                this.loadingContainer.style.display = 'none';
            }
            
            showError(message) {
                this.errorMessage.textContent = message;
                this.errorContainer.style.display = 'block';
                this.loadingContainer.style.display = 'none';
                this.queryBtn.disabled = false;
                this.loadingIcon.style.display = 'none';
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new CCTVNews();
        });
    </script>
</body>
</html>