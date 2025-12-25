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
    <title>人品运势 - <?php echo $siteConfig['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .tool-content {
            background-color: #fff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }
        
        .tool-title {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .tool-title h2 {
            font-size: 24px;
            color: #1a1a1a;
            margin-bottom: 10px;
        }
        
        .tool-title p {
            font-size: 14px;
            color: #666;
        }
        
        .form-section {
            margin-bottom: 30px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 16px;
            align-items: end;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-label {
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
            padding: 12px 32px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #1a1a1a;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .result-section {
            margin-top: 30px;
        }
        
        .result-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .luck-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border-radius: 12px;
            padding: 40px 30px;
            text-align: center;
            margin-top: 30px;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .luck-text {
            font-size: 24px;
            font-weight: 600;
            line-height: 1.5;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        
        @media (max-width: 768px) {
            .tool-container {
                padding: 20px 16px;
            }
            
            .tool-content {
                padding: 20px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .luck-card {
                padding: 30px 20px;
            }
            
            .luck-text {
                font-size: 20px;
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
                    <h2>人品运势</h2>
                    <p>输入你的名字，查询今日人品运势</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">
                    <div class="error-message" id="error-message"></div>
                    
                    <div class="form-section">
                        <form id="rp-luck-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="name-input">你的名字</label>
                                    <input type="text" class="form-input" id="name-input" name="name" placeholder="请输入你的名字" value="张三">
                                </div>
                                <button type="submit" class="btn" id="query-btn">
                                    <span class="loading-icon" style="display: none;">🔄</span>
                                    <span>查询运势</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div>正在查询人品运势，请稍候...</div>
                    </div>
                    
                    <div class="result-section" id="result-section" style="display: none;">
                        <h3 class="result-title">你的人品运势</h3>
                        <div class="luck-card">
                            <div class="luck-text" id="luck-text">
                                <!-- 运势结果将通过JavaScript动态生成 -->
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
                console.error('记录工具使用情况失败:', error);
            }
        }
        
        class RPLuckQuery {
            constructor() {
                this.init();
            }
            
            init() {
                this.bindEvents();
            }
            
            bindEvents() {
                const form = document.getElementById('rp-luck-form');
                
                form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.queryRPLuck();
            });
            }
            
            async queryRPLuck() {
                const name = document.getElementById('name-input').value.trim();
            
            if (!name) {
                this.showError('请输入你的名字');
                return;
            }
            
            this.showLoading();
            this.hideError();
            
            const startTime = Date.now();
                
                try {
                    const params = new URLSearchParams({ name: name });
                    const requestUrl = `../php/rp-luck-proxy.php?${params.toString()}`;
                    
                    const response = await fetch(requestUrl);
                    
                    if (!response.ok) {
                        const errorData = await response.json().catch(() => ({}));
                        throw new Error(errorData.message || `HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.code !== 1) {
                        throw new Error(data.text || '查询失败');
                    }
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.displayResult(data.text);
                    
                    const content = JSON.stringify({ action: 'query_rp_luck', name: name });
                    await recordToolUsage('rp-luck', 'query_rp_luck', 'success', responseTime, content);
                } catch (error) {
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.showError(`查询失败: ${error.message}`);
                    console.error('API请求错误:', error);
                    
                    const content = JSON.stringify({ action: 'query_rp_luck', name: name, error: error.message });
                    await recordToolUsage('rp-luck', 'query_rp_luck', 'error', responseTime, content);
                } finally {
                    this.hideLoading();
                }
            }
            
            displayResult(luckText) {
                const resultSection = document.getElementById('result-section');
                const luckTextElement = document.getElementById('luck-text');
                
                luckTextElement.textContent = luckText;
            
            resultSection.style.display = 'block';
            }
            
            showLoading() {
                const loading = document.getElementById('loading');
                const queryBtn = document.getElementById('query-btn');
                
                loading.classList.add('visible');
                queryBtn.disabled = true;
                queryBtn.querySelector('.loading-icon').style.display = 'inline-block';
                queryBtn.querySelector('span:last-child').textContent = '查询中...';
            }
            
            hideLoading() {
                const loading = document.getElementById('loading');
                const queryBtn = document.getElementById('query-btn');
                
                loading.classList.remove('visible');
                queryBtn.disabled = false;
                queryBtn.querySelector('.loading-icon').style.display = 'none';
                queryBtn.querySelector('span:last-child').textContent = '查询运势';
            }
            
            showError(message) {
                const errorElement = document.getElementById('error-message');
                errorElement.textContent = message;
                errorElement.classList.add('visible');
            }
            
            hideError() {
                const errorElement = document.getElementById('error-message');
                errorElement.classList.remove('visible');
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new RPLuckQuery();
        });
    </script>
</body>
</html>