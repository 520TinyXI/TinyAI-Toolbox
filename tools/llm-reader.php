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
    <title>基于LLM模型网页读取 - <?php echo $siteConfig['name']; ?></title>
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
        
        .type-select {
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            background-color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .type-select:focus {
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
        
        .results-section {
            margin-top: 30px;
            display: none;
        }
        
        .results-section.visible {
            display: block;
        }
        
        .results-header {
            margin-bottom: 20px;
        }
        
        .results-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .results-subtitle {
            font-size: 14px;
            color: #666;
        }
        
        .result-content {
            background-color: #fafafa;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            max-height: 600px;
            overflow-y: auto;
        }
        
        .result-content.json {
            font-family: 'Courier New', Courier, monospace;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        
        .result-content.text {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
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
                    <h2>基于LLM模型网页读取</h2>
                    <p>通过LLM模型读取网页内容，支持JSON和文本格式返回</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">
                    <div class="error-message" id="error-message"></div>
                    
                    <div class="empty-state" id="empty-state">
                        <div class="empty-icon">📄</div>
                        <div>请输入网页链接，使用LLM模型读取其内容</div>
                    </div>
                    
                    <div class="query-section">
                        <form class="query-form" id="query-form">
                            <div class="form-group">
                                <label class="form-label" for="url">网页链接</label>
                                <input type="url" id="url" class="form-input" placeholder="请输入完整的网页链接，如：https://example.com" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="type">返回格式</label>
                                <select class="type-select" id="type">
                                    <option value="json">JSON格式</option>
                                    <option value="text">文本格式</option>
                                </select>
                            </div>
                            <button type="submit" class="btn" id="query-btn">
                                <span class="loading-icon" style="display: none;">🔄</span>
                                <span>读取内容</span>
                            </button>
                        </form>
                    </div>
                    
                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div>正在使用LLM模型读取网页内容，请稍候...</div>
                    </div>
                    
                    <div class="results-section" id="results-section">
                        <div class="results-header">
                            <h3 class="results-title">读取结果</h3>
                            <div class="results-subtitle" id="results-subtitle"></div>
                        </div>
                        
                        <div class="result-content" id="result-content"></div>
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
                        tool_id: 'llm-reader',
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

        class LLMReader {
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
                    this.readContent();
                });
            }
            
            async readContent() {
                const url = document.getElementById('url').value.trim();
                const type = document.getElementById('type').value;
                
                this.showLoading();
                this.hideError();
                this.hideEmptyState();
                this.hideResults();
                this.disableQueryBtn();
                
                const startTime = Date.now();
                
                try {
                    const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 60000); // 60秒超时
                
                const requestUrl = `../php/llm-reader-proxy.php?url=${encodeURIComponent(url)}&type=${encodeURIComponent(type)}`;
                    
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
                    
                    if (data.code === 200) {
                        this.displayResults(data, type);
                        await recordToolUsage('read_content', 'success', { 
                            api_code: data.code, 
                            url: url, 
                            return_type: type 
                        }, responseTime);
                    } else {
                        let errorMsg = data.msg || '读取失败';
                this.showError(errorMsg);
                        await recordToolUsage('read_content', 'error', { 
                            api_code: data.code || 500, 
                            url: url, 
                            return_type: type, 
                            error_msg: errorMsg 
                        }, responseTime);
                    }
                } catch (error) {
                    const responseTime = (Date.now() - startTime) / 1000;
                    let errorMsg = `读取失败: ${error.message}`;
                    if (error.name === 'AbortError') {
                        errorMsg = '读取超时，请稍后重试';
                    }
                    this.showError(errorMsg);
                    console.error('API请求错误:', error);
                    await recordToolUsage('read_content', 'error', { 
                        exception: error.message,
                        url: url,
                        return_type: type,
                        error_msg: errorMsg
                    }, responseTime);
                } finally {
                    this.hideLoading();
                    this.enableQueryBtn();
                }
            }
            
            displayResults(data, type) {
                const resultsSection = document.getElementById('results-section');
                resultsSection.classList.add('visible');
                
                const resultsSubtitle = document.getElementById('results-subtitle');
                resultsSubtitle.textContent = `读取链接: ${data.url}`;
                
                const resultContent = document.getElementById('result-content');
                
                resultContent.className = 'result-content';
                
                resultContent.classList.add(type);
                
                if (type === 'json') {
                    try {
                        let jsonData = data.data;
                        if (typeof jsonData === 'string') {
                            jsonData = JSON.parse(jsonData);
                        }
                        resultContent.textContent = JSON.stringify(jsonData, null, 2);
                    } catch (e) {
                        resultContent.textContent = data.data;
                    }
                } else {
                    resultContent.textContent = data.data;
                }
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
                queryBtn.querySelector('span:last-child').textContent = '读取中...';
            }
            
            enableQueryBtn() {
                const queryBtn = document.getElementById('query-btn');
                queryBtn.disabled = false;
                queryBtn.querySelector('.loading-icon').style.display = 'none';
                queryBtn.querySelector('span:last-child').textContent = '读取内容';
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new LLMReader();
        });
    </script>
</body>
</html>