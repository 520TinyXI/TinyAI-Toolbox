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
    <title>足球赛事热点 - <?php echo $siteConfig['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 1000px;
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
        

        .refresh-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 24px;
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
        

        .news-list {
            margin-bottom: 30px;
        }
        

        .news-card {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 16px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .news-card:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .news-card.headline {
            background-color: #fff3f3;
            border-color: #ffe0e0;
        }
        
        .news-card.headline:hover {
            background-color: #fff0f0;
            border-color: #ffcccc;
        }
        
        .news-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .news-type {
            font-size: 12px;
            padding: 2px 8px;
            border-radius: 4px;
            background-color: #1a1a1a;
            color: #fff;
            display: inline-block;
            margin-bottom: 8px;
        }
        
        .news-type.headline {
            background-color: #d63031;
        }
        

        .news-detail {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 24px;
        }
        
        .detail-header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .detail-title {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 12px;
        }
        
        .detail-info {
            display: flex;
            gap: 16px;
            font-size: 14px;
            color: #666;
        }
        
        .detail-content {
            font-size: 16px;
            line-height: 1.8;
            color: #1a1a1a;
            margin-bottom: 24px;
        }
        
        .detail-content p {
            margin-bottom: 16px;
        }
        
        .detail-tags {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        
        .tag {
            padding: 4px 12px;
            border-radius: 16px;
            background-color: #e0e0e0;
            color: #1a1a1a;
            font-size: 12px;
            font-weight: 500;
        }
        
        .back-btn {
            background-color: #fafafa;
            color: #1a1a1a;
            border-color: #e0e0e0;
        }
        
        .back-btn:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
        }
        

        .detail-images {
            margin-bottom: 24px;
        }
        
        .detail-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 16px;
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
            
            .refresh-section {
                justify-content: center;
            }
            
            .news-card {
                padding: 16px;
            }
            
            .news-title {
                font-size: 15px;
            }
            
            .detail-title {
                font-size: 18px;
            }
            
            .detail-info {
                flex-direction: column;
                gap: 8px;
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
                    <h2>足球赛事热点</h2>
                    <p>获取最新的足球赛事热点新闻</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">

                    <div class="error-container" id="error-container" style="display: none;">
                        <div class="error-message" id="error-message">获取新闻失败，请稍后重试</div>
                    </div>
                    

                    <div class="news-detail" id="news-detail" style="display: none;">
                        <button type="button" class="btn back-btn" id="back-btn">
                            ← 返回列表
                        </button>
                        <div class="detail-header">
                            <h3 class="detail-title" id="detail-title"></h3>
                            <div class="detail-info">
                                <span id="detail-timestamp"></span>
                            </div>
                        </div>
                        <div class="detail-images" id="detail-images"></div>
                        <div class="detail-content" id="detail-content"></div>
                        <div class="detail-tags" id="detail-tags"></div>
                    </div>
                    

                    <div class="refresh-section">
                        <span style="font-size: 14px; color: #666; margin-right: 16px; line-height: 36px;">点击查看详细</span>
                        <button type="button" class="btn btn-primary" id="refresh-btn">
                            <span class="loading-icon" style="display: none;">🔄</span>
                            刷新热点
                        </button>
                    </div>
                    

                    <div class="news-list" id="news-list"></div>
                    

                    <div class="loading-container" id="loading-container" style="display: none;">
                        <div class="loading"></div>
                        <p>正在获取足球赛事热点，请稍候...</p>
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
                console.error('记录工具使用情况失败:', error);
            }
        }
        

        class FootballNews {
            constructor() {

                this.refreshBtn = document.getElementById('refresh-btn');
                this.loadingIcon = this.refreshBtn.querySelector('.loading-icon');
                this.newsList = document.getElementById('news-list');
                this.newsDetail = document.getElementById('news-detail');
                this.backBtn = document.getElementById('back-btn');
                this.detailTitle = document.getElementById('detail-title');
                this.detailContent = document.getElementById('detail-content');
                this.detailImages = document.getElementById('detail-images');
                this.detailTags = document.getElementById('detail-tags');
                this.detailTimestamp = document.getElementById('detail-timestamp');
                this.loadingContainer = document.getElementById('loading-container');
                this.errorContainer = document.getElementById('error-container');
                this.errorMessage = document.getElementById('error-message');
                

                this.apiUrl = 'https://api.jkyai.top/API/zqssrd.php';
                

                this.currentNewsList = [];
                

                this.init();
            }
            

            init() {

                this.initEventListeners();
                

                this.fetchNewsList();
            }
            

            initEventListeners() {

                this.refreshBtn.addEventListener('click', () => {
                    this.fetchNewsList();
                });
                

                this.backBtn.addEventListener('click', () => {
                    this.showNewsList();
                });
            }
            
            
            async fetchNewsList() {

                this.showLoading();
                

                const startTime = Date.now();
                
                try {
    
                    const requestUrl = `${this.apiUrl}?type=json`;
                    console.log('请求URL:', requestUrl);
                    
    
                    const response = await fetch(requestUrl, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                    
    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
    
                    const data = await response.json();
                    console.log('响应数据:', data);
                    
    
                    const responseTime = Date.now() - startTime;
                    
    
                    if (data.success && data.data) {
                        this.currentNewsList = data.data;
                        this.showNewsList();
        
                        await recordToolUsage('football-news', 'fetch_news_list', 1, responseTime, '获取新闻列表');
                    } else {
                        this.showError(data.message || '获取新闻失败');
        
                        await recordToolUsage('football-news', 'fetch_news_list', 0, responseTime, '获取新闻列表');
                    }
                } catch (error) {
                    console.error('获取新闻失败:', error);
                    this.showError(`获取新闻失败: ${error.message}`);
    
                    const responseTime = Date.now() - startTime;
    
                    await recordToolUsage('football-news', 'fetch_news_list', 0, responseTime, '获取新闻列表');
                }
            }
            
            
            async fetchNewsDetail(docId) {

                this.showLoading();
                

                const startTime = Date.now();
                
                try {
    
                    const requestUrl = `${this.apiUrl}?doc=${docId}&type=json`;
                    console.log('请求URL:', requestUrl);
                    
    
                    const response = await fetch(requestUrl, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                    
    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
    
                    const data = await response.json();
                    console.log('响应数据:', data);
                    
    
                    const responseTime = Date.now() - startTime;
                    
    
                    if (data.success) {
                        this.showNewsDetail(data);
        
                        await recordToolUsage('football-news', 'fetch_news_detail', 1, responseTime, `获取新闻详情: ${docId}`);
                    } else {
                        this.showError(data.message || '获取新闻详情失败');
        
                        await recordToolUsage('football-news', 'fetch_news_detail', 0, responseTime, `获取新闻详情: ${docId}`);
                    }
                } catch (error) {
                    console.error('获取新闻详情失败:', error);
                    this.showError(`获取新闻详情失败: ${error.message}`);
    
                    const responseTime = Date.now() - startTime;
    
                    await recordToolUsage('football-news', 'fetch_news_detail', 0, responseTime, `获取新闻详情: ${docId}`);
                }
            }
            
            
            showNewsList() {

                this.newsDetail.style.display = 'none';
                this.newsList.style.display = 'block';
                

                this.newsList.innerHTML = '';
                

                if (this.currentNewsList.length > 0) {
                    this.currentNewsList.forEach(news => {
                        const card = this.createNewsCard(news);
                        this.newsList.appendChild(card);
                    });
                } else {
    
                    this.newsList.innerHTML = '<div style="text-align: center; padding: 40px; color: #666;">暂无新闻数据</div>';
                }
                

                this.hideLoading();
            }
            
            
            showNewsDetail(data) {

                this.newsList.style.display = 'none';
                this.newsDetail.style.display = 'block';
                

                this.detailTitle.textContent = data.title || '新闻详情';
                

                this.detailContent.innerHTML = data.content ? this.formatContent(data.content) : '暂无内容';
                

                this.detailImages.innerHTML = '';
                if (data.images && data.images.length > 0) {
                    data.images.forEach(image => {
                        const img = document.createElement('img');
                        img.src = image;
                        img.className = 'detail-image';
                        img.alt = '新闻图片';
                        this.detailImages.appendChild(img);
                    });
                }
                

                this.detailTags.innerHTML = '';
                if (data.tags && data.tags.length > 0) {
                    data.tags.forEach(tag => {
                        const tagElement = document.createElement('span');
                        tagElement.className = 'tag';
                        tagElement.textContent = tag;
                        this.detailTags.appendChild(tagElement);
                    });
                }
                

                this.detailTimestamp.textContent = data.timestamp || new Date().toLocaleString();
                

                this.hideLoading();
            }
            
            
            formatContent(content) {

                return content.replace(/\n/g, '<br>');
            }
            
            
            createNewsCard(news) {
                const card = document.createElement('div');
                card.className = `news-card ${news.type === 'headline' ? 'headline' : ''}`;
                

                const docId = this.extractDocId(news.url);
                

                card.addEventListener('click', () => {
                    if (docId) {
                        this.fetchNewsDetail(docId);
                    }
                });
                

                card.innerHTML = `
                    <span class="news-type ${news.type === 'headline' ? 'headline' : ''}">
                        ${news.type === 'headline' ? '头条' : '新闻'}
                    </span>
                    <div class="news-title">${news.title}</div>
                `;
                
                return card;
            }
            

            extractDocId(url) {
                const match = url.match(/doc=(\d+)/);
                return match ? match[1] : null;
            }
            

            showLoading() {
                this.refreshBtn.disabled = true;
                this.loadingIcon.style.display = 'inline';
                this.loadingContainer.style.display = 'block';
                this.errorContainer.style.display = 'none';
            }
            

            hideLoading() {
                this.refreshBtn.disabled = false;
                this.loadingIcon.style.display = 'none';
                this.loadingContainer.style.display = 'none';
            }
            
            
            showError(message) {
                this.errorMessage.textContent = message;
                this.errorContainer.style.display = 'block';
                this.newsList.style.display = 'block';
                this.newsDetail.style.display = 'none';
                this.loadingContainer.style.display = 'none';
                this.refreshBtn.disabled = false;
                this.loadingIcon.style.display = 'none';
            }
        }
        

        document.addEventListener('DOMContentLoaded', () => {
            new FootballNews();
        });
    </script>
</body>
</html>