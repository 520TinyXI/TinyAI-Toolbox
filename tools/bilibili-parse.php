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
    <title>B站视频解析 - <?php echo $siteConfig['name']; ?></title>
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
        
        
        .query-section {
            margin-bottom: 30px;
        }
        
        .query-form {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            align-items: flex-end;
        }
        
        .form-group {
            flex: 1;
            min-width: 300px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
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
        
        .btn:active {
            transform: translateY(0);
        }
        
        
        .results-section {
            margin-top: 30px;
            display: none;
        }
        
        .results-section.visible {
            display: block;
        }
        
        .result-card {
            background-color: #fafafa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .result-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .result-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 4px;
        }
        
        .info-value {
            font-size: 16px;
            color: #1a1a1a;
            word-break: break-all;
        }
        
        
        .video-preview {
            margin: 20px 0;
        }
        
        .video-cover {
            width: 100%;
            max-width: 500px;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .video-cover:hover {
            transform: scale(1.02);
        }
        
        
        .stats-section {
            background-color: #fafafa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-value {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .stat-label {
            font-size: 14px;
            color: #666;
            margin-top: 4px;
        }
        
        
        .button-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        
        .btn-secondary {
            background-color: #f0f0f0;
            color: #1a1a1a;
        }
        
        .btn-secondary:hover {
            background-color: #e0e0e0;
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
        
        .error-message.success {
            background-color: #e8f5e8;
            border-color: #c8e6c9;
            color: #2e7d32;
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
        
        
        .platforms-section {
            margin-top: 20px;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 8px;
        }
        
        .platforms-title {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 12px;
        }
        
        .platforms-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .platform-tag {
            background-color: #e0e0e0;
            color: #666;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 14px;
        }
        
        
        @media (max-width: 768px) {
            .tool-container {
                padding: 20px 16px;
            }
            
            .tool-content {
                padding: 20px;
            }
            
            .query-form {
                flex-direction: column;
                align-items: stretch;
            }
            
            .form-group {
                min-width: auto;
            }
            
            .result-info {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- 左侧菜单栏 -->
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

        <!-- 主内容区 -->
        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h2>B站视频解析</h2>
                    <p>解析B站视频链接，获取无水印视频地址和视频信息</p>
                </div>
            </header>
            
            <div class="tool-container">

                <div class="tool-content">

                    <div class="error-message" id="error-message"></div>
                    

                    <div class="empty-state" id="empty-state">
                        <div class="empty-icon">📺</div>
                        <div>请输入B站视频链接开始解析</div>
                    </div>
                    

                    <div class="query-section">
                        <form class="query-form" id="query-form">
                            <div class="form-group">
                                <label class="form-label" for="video-url">B站视频链接</label>
                                <input type="text" id="video-url" class="form-input" placeholder="请输入B站视频链接，如：https://www.bilibili.com/video/BV1MwmEBDEiR/" required>
                            </div>
                            <button type="submit" class="btn" id="query-btn">
                                <span class="loading-icon" style="display: none;">🔄</span>
                                <span>解析视频</span>
                            </button>
                        </form>
                    </div>
                    

                    <div class="platforms-section">
                        <div class="platforms-title">支持的链接格式：</div>
                        <div class="platforms-list">
                            <span class="platform-tag">https://www.bilibili.com/video/BV1xx411c7mS/</span>
                            <span class="platform-tag">https://b23.tv/BV1xx411c7mS</span>
                        </div>
                    </div>
                    

                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div>正在解析视频，请稍候...</div>
                    </div>
                    

                    <div class="results-section" id="results-section">

                        <div class="result-card">
                            <h3 class="result-title">视频信息</h3>
                            <div class="result-info">
                                <div class="info-item">
                                    <span class="info-label">平台</span>
                                    <span class="info-value" id="platform">哔哩哔哩</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">视频标题</span>
                                    <span class="info-value" id="title"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">无水印视频</span>
                                    <span class="info-value" id="video-url-result"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">视频封面</span>
                                    <span class="info-value" id="cover-url"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">UP主</span>
                                    <span class="info-value" id="author"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">发布时间</span>
                                    <span class="info-value" id="pubdate"></span>
                                </div>
                            </div>
                            

                            <div class="button-group">
                                <button class="btn btn-secondary" id="copy-video-btn">复制视频链接</button>
                                <button class="btn btn-secondary" id="download-video-btn">下载视频</button>
                                <button class="btn btn-secondary" id="copy-cover-btn">复制封面链接</button>
                            </div>
                        </div>
                        

                        <div class="stats-section" id="stats-section" style="display: none;">
                            <h3 class="result-title">视频统计</h3>
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <div class="stat-value" id="view-count"></div>
                                    <div class="stat-label">播放量</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value" id="danmaku-count"></div>
                                    <div class="stat-label">弹幕数</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value" id="reply-count"></div>
                                    <div class="stat-label">评论数</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value" id="like-count"></div>
                                    <div class="stat-label">点赞数</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value" id="coin-count"></div>
                                    <div class="stat-label">投币数</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value" id="favorite-count"></div>
                                    <div class="stat-label">收藏数</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="../js/main.js"></script>
    
    <script>

        async function recordToolUsage(toolId, action, statusValue, responseTime = 0, content = '') {
            try {
                await fetch('../php/record-tool-usage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        tool_id: toolId,
                        content: content,
                        status: statusValue,
                        response_time: responseTime
                    })
                });
            } catch (error) {
                console.error('Failed to record tool usage:', error);
            }
        }
        
        class BilibiliParser {
            constructor() {
                this.init();
            }
            
            init() {
                this.bindEvents();
            }
            
            bindEvents() {
                const queryForm = document.getElementById('query-form');
                queryForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.parseVideo();
                });
                
    
                document.getElementById('copy-video-btn').addEventListener('click', () => {
                    this.copyToClipboard(document.getElementById('video-url-result').textContent);
                });
                
                document.getElementById('copy-cover-btn').addEventListener('click', () => {
                    this.copyToClipboard(document.getElementById('cover-url').textContent);
                });
                
    
                document.getElementById('download-video-btn').addEventListener('click', () => {
                    this.downloadVideo();
                });
            }
            
            async parseVideo() {
                let inputUrl = document.getElementById('video-url').value.trim();
                

                const url = this.extractLink(inputUrl);
                

                document.getElementById('video-url').value = url;
                
                this.showLoading();
                this.hideError();
                this.hideResults();
                this.hideEmptyState();
                this.disableQueryBtn();
                

                const startTime = Date.now();
                
                try {
    
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 30000); // 30秒超时
                    
    
                    const requestUrl = `../php/video-parse-proxy.php?url=${encodeURIComponent(url)}`;
                    console.log('请求URL:', requestUrl);
                    
                    const response = await fetch(requestUrl, {
                        method: 'GET',
                        signal: controller.signal
                    });
                    
                    clearTimeout(timeoutId);
                    
                    // 获取原始响应文本，以便在HTTP错误时进行调试
                    const responseText = await response.text();
                    console.log('原始响应:', responseText);
                    
    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    // 尝试解析JSON
                    let data;
                    try {
                        data = JSON.parse(responseText);
                    } catch (jsonError) {
        
                        await recordToolUsage('bilibili-parse', '解析视频', 'error', responseTime, `JSON解析失败: ${jsonError.message}`);
                        throw new Error(`JSON解析失败: ${jsonError.message}`);
                    }
                    
                    console.log('解析后数据:', data);
                    
                    if (data.code === 200) {
                        this.displayResults(data);
                        // 记录API调用成功
                        await recordToolUsage('bilibili-parse', '解析视频', 'success', responseTime);
                    } else {
        
                        let errorMsg = data.msg || '解析失败';
                        
        
                        console.log('API响应:', data);
                        
        
                        errorMsg += '<br><br>';
                        errorMsg += '<strong>调试信息：</strong><br>';
                        errorMsg += `状态码: ${data.code}<br>`;
                        
        
                        if (data.debug) {
                            errorMsg += `原始URL: ${data.debug.original_url}<br>`;
                            errorMsg += `请求URL: ${data.debug.request_url}<br>`;
                        }
                        
                        errorMsg += '<br>';
                        errorMsg += '如果问题持续存在，可能是API服务器问题或视频链接无效。';
                        errorMsg += '<br>';
                        errorMsg += '请确保您输入的是有效的B站视频链接，例如：https://www.bilibili.com/video/BV1MwmEBDEiR/';
                        
        
                        this.showError(errorMsg);
                        
        
                        await recordToolUsage('bilibili-parse', '解析视频', 'error', responseTime, data.msg || '解析失败');
                    }
                } catch (error) {
                    let errorMsg = `解析失败: ${error.message}`;
                    if (error.name === 'AbortError') {
                        errorMsg = '解析超时，请稍后重试';
                    }
                    this.showError(errorMsg);
                    console.error('API请求错误:', error);
                    
                    // 计算响应时间
                    const responseTime = (Date.now() - startTime) / 1000;
                    
    
                    await recordToolUsage('bilibili-parse', '解析视频', 'error', responseTime, error.message);
                } finally {
                    this.hideLoading();
                    this.enableQueryBtn();
                }
            }
            
            displayResults(data) {
                const resultData = data.data || {};
                
              
                const resultsSection = document.getElementById('results-section');
                resultsSection.classList.add('visible');
                
              
                document.getElementById('title').textContent = resultData.title || '无标题';
                document.getElementById('video-url-result').textContent = resultData.video_url || resultData.url || '无';
                document.getElementById('cover-url').textContent = resultData.cover_url || resultData.cover || '无';
                
             
                if (resultData.user && resultData.user.name) {
                    document.getElementById('author').textContent = resultData.user.name;
                } else {
                    document.getElementById('author').textContent = '未知';
                }
                
                
                document.getElementById('pubdate').textContent = resultData.pubdate || '未知';
                

                if (resultData.stats) {
                    const statsSection = document.getElementById('stats-section');
                    statsSection.style.display = 'block';
                    
                 
                    document.getElementById('view-count').textContent = resultData.stats.view || 0;
                    document.getElementById('danmaku-count').textContent = resultData.stats.danmaku || 0;
                    document.getElementById('reply-count').textContent = resultData.stats.reply || 0;
                    document.getElementById('like-count').textContent = resultData.stats.like || 0;
                    document.getElementById('coin-count').textContent = resultData.stats.coin || 0;
                    document.getElementById('favorite-count').textContent = resultData.stats.favorite || 0;
                } else {
                   
                    document.getElementById('stats-section').style.display = 'none';
                }
            }
            
            copyToClipboard(text) {
                if (!text || text === '无') {
                    this.showError('没有可复制的内容');
                    return;
                }
                
                navigator.clipboard.writeText(text)
                    .then(() => {
                        this.showError('复制成功！', 'success');
                    })
                    .catch(err => {
                        this.showError('复制失败，请手动复制');
                    });
            }
            
            downloadVideo() {
               
                const videoUrl = document.getElementById('video-url-result').textContent;
                if (!videoUrl || videoUrl === '无') {
                    this.showError('没有可下载的视频链接');
                    return;
                }
                
                try {
                   
                    const link = document.createElement('a');
                    link.href = videoUrl;
                    link.download = `bilibili-${Date.now()}.mp4`;
                    link.target = '_blank';
                    
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    
                  
                    this.showError('正在准备下载，请稍候...', 'success');
                    
                } catch (error) {
                   
                    this.showError('下载失败，请复制视频链接到浏览器中打开下载');
                    console.error('下载错误:', error);
                }
            }
            
            showLoading() {
                document.getElementById('loading').classList.add('visible');
            }
            
            hideLoading() {
                document.getElementById('loading').classList.remove('visible');
            }
            
            showError(message, type = 'error') {
                const errorElement = document.getElementById('error-message');
                errorElement.innerHTML = message; 
                errorElement.className = `error-message ${type}`;
                errorElement.classList.add('visible');
                
              
                if (type === 'success') {
                    setTimeout(() => {
                        this.hideError();
                    }, 3000);
                }
            }
            
            hideError() {
                document.getElementById('error-message').classList.remove('visible');
            }
            
            showResults() {
                document.getElementById('results-section').classList.add('visible');
            }
            
            hideResults() {
                document.getElementById('results-section').classList.remove('visible');
            }
            
            showEmptyState() {
                document.getElementById('empty-state').classList.remove('hidden');
            }
            
            hideEmptyState() {
                document.getElementById('empty-state').classList.add('hidden');
            }
            
            disableQueryBtn() {
                const queryBtn = document.getElementById('query-btn');
                queryBtn.disabled = true;
                queryBtn.querySelector('.loading-icon').style.display = 'inline-block';
                queryBtn.querySelector('span:last-child').textContent = '解析中...';
            }
            
            enableQueryBtn() {
                const queryBtn = document.getElementById('query-btn');
                queryBtn.disabled = false;
                queryBtn.querySelector('.loading-icon').style.display = 'none';
                queryBtn.querySelector('span:last-child').textContent = '解析视频';
            }
            
            /**
             
             * @param {string} text 输入文本
             * @returns {string} 提取到的B站视频链接
             */
            extractLink(text) {
                const bilibiliRegex = /(https?:\/\/(?:www\.)?bilibili\.com\/video\/BV[^\s]+|https?:\/\/b23\.tv\/[^\s]+)/gi;
                
                const matches = text.match(bilibiliRegex);
                
                if (matches && matches.length > 0) {
                    return matches[0].trim();
                }
                
                return text;
            }
        }
        

        document.addEventListener('DOMContentLoaded', () => {
            new BilibiliParser();
        });
    </script>
</body>
</html>