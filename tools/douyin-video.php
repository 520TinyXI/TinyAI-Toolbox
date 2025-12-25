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
    <title>抖音单视频解析 - <?php echo $siteConfig['name']; ?></title>
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
                    <h2>抖音单视频解析</h2>
                    <p>通过抖音分享链接获取抖音视频信息，包括无水印视频链接、音乐链接等</p>
                </div>
            </header>
            
            <div class="tool-container">

                <div class="tool-content">

                    <div class="error-message" id="error-message"></div>
                    

                    <div class="empty-state" id="empty-state">
                        <div class="empty-icon">🎬</div>
                        <div>请输入抖音视频链接开始解析</div>
                    </div>
                    

                    <div class="query-section">
                        <form class="query-form" id="query-form">
                            <div class="form-group">
                                <label class="form-label" for="video-url">抖音视频链接</label>
                                <input type="text" id="video-url" class="form-input" placeholder="请输入抖音视频链接，如：https://v.douyin.com/xxx/" required>
                            </div>
                            <button type="submit" class="btn" id="query-btn">
                                <span class="loading-icon" style="display: none;">🔄</span>
                                <span>解析视频</span>
                            </button>
                        </form>
                    </div>
                    

                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div>正在解析视频，请稍候...</div>
                    </div>
                    

                    <div class="results-section" id="results-section">
    
                        <div class="video-preview" id="video-preview"></div>
                        
    
                        <div class="result-card">
                            <h3 class="result-title">视频信息</h3>
                            <div class="result-info">
                                <div class="info-item">
                                    <span class="info-label">作者</span>
                                    <span class="info-value" id="author"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">作者ID</span>
                                    <span class="info-value" id="author-id"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">视频标题</span>
                                    <span class="info-value" id="title"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">无水印视频</span>
                                    <span class="info-value" id="result-video-url"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">音乐链接</span>
                                    <span class="info-value" id="music-url"></span>
                                </div>
                            </div>
                            
        
                            <div class="button-group">
                                <button class="btn btn-secondary" id="copy-video-btn">复制视频链接</button>
                                <button class="btn btn-secondary" id="copy-music-btn">复制音乐链接</button>
                                <button class="btn btn-secondary" id="download-video-btn">下载视频</button>
                            </div>
                        </div>
                    </div>
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
                        tool_id: 'douyin-video',
                        action: action,
                        content: content,
                        result: {
                            status: status
                        },
                        response_time: responseTime
                    })
                });
            } catch (error) {
                console.error('Failed to record usage:', error);
            }
        }

        class DouyinVideoParser {
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
                    this.copyToClipboard(document.getElementById('result-video-url').textContent);
                });
                
                document.getElementById('copy-music-btn').addEventListener('click', () => {
                    this.copyToClipboard(document.getElementById('music-url').textContent);
                });
                

                document.getElementById('download-video-btn').addEventListener('click', () => {
                    this.downloadVideo();
                });
            }
            
            async parseVideo() {
                const url = document.getElementById('video-url').value.trim();
                
                this.showLoading();
                this.hideError();
                this.hideResults();
                this.hideEmptyState();
                this.disableQueryBtn();
                
                const startTime = Date.now();
                
                try {
    
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 30000);
                    
                    const response = await fetch(`../php/douyin-proxy.php?url=${encodeURIComponent(url)}`, {
                        method: 'GET',
                        signal: controller.signal
                    });
                    
                    clearTimeout(timeoutId);
                    
    
                    const responseText = await response.text();
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}\n\n响应内容: ${responseText.substring(0, 300)}...`);
                    }
                    
    
                    let data;
                    try {
                        data = JSON.parse(responseText);
                    } catch (jsonError) {
                        throw new Error(`JSON解析失败: ${jsonError.message}\n\n响应内容: ${responseText.substring(0, 300)}...`);
                    }
                    
                    if (data.code === 200) {
                        this.displayResults(data);
                        const responseTime = (Date.now() - startTime) / 1000;
                        await recordToolUsage('parse_video', 'success', {
                            api_code: data.code,
                            video_url: url
                        }, responseTime);
                    } else {
        
                        let errorMsg = data.msg || '解析失败';
        
                        console.log('API响应:', data);
                        
        
                        errorMsg += '<br><br>';
                        errorMsg += '<strong>调试信息：</strong><br>';
                        errorMsg += `状态码: ${data.code}<br>`;
                        errorMsg += '<br>';
                        errorMsg += '如果问题持续存在，可能是API服务器问题或视频链接无效。';
                        

                        this.showError(errorMsg);
                        const responseTime = (Date.now() - startTime) / 1000;
                        await recordToolUsage('parse_video', 'error', {
                            api_code: data.code || 500,
                            video_url: url,
                            error_msg: data.msg || '解析失败'
                        }, responseTime);
                    }
                } catch (error) {
                    let errorMsg = `解析失败: ${error.message}`;
                    if (error.name === 'AbortError') {
                        errorMsg = '解析超时，请稍后重试';
                    }
                    this.showError(errorMsg);
                    console.error('API请求错误:', error);
                    const responseTime = (Date.now() - startTime) / 1000;
                    await recordToolUsage('parse_video', 'error', {
                        video_url: url,
                        error_msg: errorMsg,
                        exception: error.message
                    }, responseTime);
                } finally {
                    this.hideLoading();
                    this.enableQueryBtn();
                }
            }
            
            displayResults(data) {
                const resultData = data.data;
                

                const resultsSection = document.getElementById('results-section');
                resultsSection.classList.add('visible');
                

                const videoPreview = document.getElementById('video-preview');
                videoPreview.innerHTML = `
                    <img src="${resultData.cover}" alt="视频封面" class="video-cover" id="video-cover">
                `;
                

                document.getElementById('author').textContent = resultData.author || '未知';
                document.getElementById('author-id').textContent = resultData.author_id || '未知';
                document.getElementById('title').textContent = resultData.title || '无标题';
                document.getElementById('result-video-url').textContent = resultData.url || '无';
                document.getElementById('music-url').textContent = resultData.music_url || '无';
            }
            
            copyToClipboard(text) {
                if (!text || text === '无') {
                    this.showError('No content to copy');
                    return;
                }
                
                navigator.clipboard.writeText(text)
                    .then(() => {
                        this.showError('Copied successfully!', 'success');
                    })
                    .catch(err => {
                        this.showError('Failed to copy, please copy manually');
                    });
            }
            
            downloadVideo() {
                const videoUrl = document.getElementById('result-video-url').textContent;
                if (!videoUrl || videoUrl === '无') {
                    this.showError('No downloadable video link');
                    return;
                }
                
                try {
                    this.showLoading();
                    
                    const downloadUrl = `../php/douyin-proxy.php?action=download&url=${encodeURIComponent(videoUrl)}`;
                    
                    const link = document.createElement('a');
                    link.href = downloadUrl;
                    link.download = `douyin-video-${Date.now()}.mp4`;
                    link.target = '_blank';
                    
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    
                    this.hideLoading();
                    
    
                    this.showError('正在准备下载，请稍候...', 'success');
                    
                    setTimeout(() => {
                        this.hideError();
                    }, 3000);
                    
                } catch (error) {
                    this.hideLoading();
                    
                  
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
        }
        

        document.addEventListener('DOMContentLoaded', () => {
            new DouyinVideoParser();
        });
    </script>
</body>
</html>