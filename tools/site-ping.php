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
    <title>站点超级Ping - <?php echo $siteConfig['name']; ?></title>
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
            align-items: flex-end;
            flex-wrap: wrap;
        }
        
        .form-group {
            flex: 1;
            min-width: 300px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            box-sizing: border-box;
            height: 48px;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 2px rgba(26, 26, 26, 0.1);
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
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 48px;
            box-sizing: border-box;
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
        
        .result-section {
            margin-bottom: 30px;
        }
        
        .result-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .result-card {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 20px;
        }
        
        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .domain-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .domain-name {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .domain-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-success {
            background-color: #e6f4ea;
            color: #10b981;
        }
        
        .status-error {
            background-color: #fef2f2;
            color: #ef4444;
        }
        
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .detail-card {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 16px;
        }
        
        .detail-title {
            font-size: 14px;
            font-weight: 600;
            color: #666;
            margin-bottom: 12px;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-size: 14px;
            color: #666;
        }
        
        .detail-value {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .speed-test {
            background-color: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            color: #92400e;
        }
        
        .list-item {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #666;
        }
        
        .list-item:last-child {
            border-bottom: none;
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
            
            .form-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .form-group {
                min-width: auto;
            }
            
            .detail-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            
            .result-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
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
                    <h2>站点超级Ping</h2>
                    <p>一键检测网站速度、状态和性能</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">
                    <div class="error-container" id="error-container" style="display: none;">
                        <div class="error-message" id="error-message">查询失败，请稍后重试</div>
                    </div>
                    
                    <div class="query-section">
                        <form id="query-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="url" class="form-label">网站域名</label>
                                    <input type="text" id="url" name="url" class="form-input" placeholder="请输入网站域名，例如：ctsqnb.xyz" required>
                                </div>
                                <button type="submit" class="btn btn-primary" id="query-btn">
                                    <span class="loading-icon" style="display: none;">🔄</span>
                                    检测站点
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="result-section" id="result-section" style="display: none;">
                        <h3 class="result-title">检测结果</h3>
                        
                        <div class="result-card" id="result-card"></div>
                    </div>
                    
                    <div class="loading-container" id="loading-container" style="display: none;">
                        <div class="loading"></div>
                        <p>正在检测站点，请稍候...</p>
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
        
        class SitePing {
            constructor() {
                this.queryForm = document.getElementById('query-form');
                this.urlInput = document.getElementById('url');
                this.queryBtn = document.getElementById('query-btn');
                this.loadingIcon = this.queryBtn.querySelector('.loading-icon');
                this.resultSection = document.getElementById('result-section');
                this.resultCard = document.getElementById('result-card');
                this.loadingContainer = document.getElementById('loading-container');
                this.errorContainer = document.getElementById('error-container');
                this.errorMessage = document.getElementById('error-message');
                
                
                this.apiUrl = 'https://api.jkyai.top/API/cjping.php';
                
                this.init();
            }
            
            init() {
                this.initEventListeners();
            }
            
            initEventListeners() {
                this.queryForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.pingSite();
                });
            }
            
            async pingSite() {
                let url = this.urlInput.value.trim();
                
                url = url.replace(/^https?:\/\//, '');
                
                if (!url) {
                    this.showError('请输入网站域名');
                    return;
                }
                
                this.showLoading();
                
                const startTime = Date.now();
                
                try {
                    const params = new URLSearchParams();
                    params.append('url', url);
                    params.append('type', 'json');
                    
                    const requestUrl = `${this.apiUrl}?${params.toString()}`;
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
                        this.showResults(data.data);
                        await recordToolUsage('site-ping', 'ping_site', 1, responseTime, `检测站点: ${url}`);
                    } else {
                        this.showError('检测失败，请检查域名是否正确');
                        await recordToolUsage('site-ping', 'ping_site', 0, responseTime, `检测站点: ${url}`);
                    }
                } catch (error) {
                    console.error('检测失败:', error);
                    this.showError(`检测失败: ${error.message}`);
                    const responseTime = Date.now() - startTime;
                    await recordToolUsage('site-ping', 'ping_site', 0, responseTime, `检测站点: ${url}`);
                }
            }
            
            showResults(result) {
                const html = `
                    <div class="result-header">
                        <div class="domain-info">
                            <div class="domain-name">${result.域名 || '未知域名'}</div>
                            <span class="domain-status ${result.状态 === '成功' ? 'status-success' : 'status-error'}">${result.状态 || '未知状态'}</span>
                        </div>
                    </div>
                    
                    <div class="detail-grid">
                        <div class="detail-card">
                            <div class="detail-title">速度测试</div>
                            ${this.renderSpeedTest(result.速度测试 || {})}
                        </div>
                        
                        <div class="detail-card">
                            <div class="detail-title">SSL信息</div>
                            ${this.renderSSLInfo(result.SSL信息 || {})}
                        </div>
                        
                        <div class="detail-card">
                            <div class="detail-title">IP列表</div>
                            ${this.renderIPList(result.IP列表 || [])}
                        </div>
                        
                        <div class="detail-card">
                            <div class="detail-title">Whois信息</div>
                            ${this.renderWhoisInfo(result.Whois信息 || {})}
                        </div>
                        
                        
                        <div class="detail-card">
                            <div class="detail-title">性能指标</div>
                            ${this.renderPerformance(result.性能指标 || {})}
                        </div>
                    </div>
                `;
                
                this.resultCard.innerHTML = html;
                
                this.hideLoading();
                this.resultSection.style.display = 'block';
            }
            
            renderSpeedTest(speedTest) {
                if (speedTest.错误) {
                    return `<div class="speed-test">${speedTest.错误}</div>`;
                }
                
                return Object.entries(speedTest).map(([key, value]) => {
                    return `<div class="detail-item">
                        <span class="detail-label">${key}</span>
                        <span class="detail-value">${value}</span>
                    </div>`;
                }).join('');
            }
            
            renderSSLInfo(sslInfo) {
                return Object.entries(sslInfo).map(([key, value]) => {
                    return `<div class="detail-item">
                        <span class="detail-label">${key}</span>
                        <span class="detail-value">${value}</span>
                    </div>`;
                }).join('');
            }
            
            renderIPList(ipList) {
                if (ipList.length === 0) {
                    return '<div class="list-item">无IP信息</div>';
                }
                
                return ipList.map(ip => {
                    return `<div class="list-item">${ip}</div>`;
                }).join('');
            }
            
            renderWhoisInfo(whoisInfo) {
                return Object.entries(whoisInfo).map(([key, value]) => {
                    return `<div class="detail-item">
                        <span class="detail-label">${key}</span>
                        <span class="detail-value">${value}</span>
                    </div>`;
                }).join('');
            }
            
            renderPerformance(performance) {
                return Object.entries(performance).map(([key, value]) => {
                    return `<div class="detail-item">
                        <span class="detail-label">${key}</span>
                        <span class="detail-value">${value}</span>
                    </div>`;
                }).join('');
            }
            
            showLoading() {
                this.queryBtn.disabled = true;
                this.loadingIcon.style.display = 'inline';
                this.loadingContainer.style.display = 'block';
                this.resultSection.style.display = 'none';
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
                this.resultSection.style.display = 'none';
                this.loadingContainer.style.display = 'none';
                this.queryBtn.disabled = false;
                this.loadingIcon.style.display = 'none';
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new SitePing();
        });
    </script>
</body>
</html>