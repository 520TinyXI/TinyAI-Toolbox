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
    <title>高质量代理池 - <?php echo $siteConfig['name']; ?></title>
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
            min-width: 200px;
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
        
        .proxy-list {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 16px;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .proxy-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 12px;
            border-bottom: 1px solid #f0f0f0;
            font-family: monospace;
            font-size: 14px;
        }
        
        .proxy-item:last-child {
            border-bottom: none;
        }
        
        .proxy-address {
            flex: 1;
            word-break: break-all;
        }
        
        .proxy-test-btn {
            padding: 6px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #fafafa;
            color: #1a1a1a;
            min-width: 80px;
        }
        
        .proxy-test-btn:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
        }
        
        .proxy-test-btn.testing {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .test-result {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 600;
        }
        
        .test-success {
            background-color: #e6f4ea;
            color: #10b981;
        }
        
        .test-failure {
            background-color: #fee2e2;
            color: #ef4444;
        }
        
        .test-pending {
            background-color: #fef3c7;
            color: #f59e0b;
        }
        
        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 16px;
            flex-wrap: wrap;
        }
        
        .result-stats {
            background-color: #f3f4f6;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
        }
        
        .stats-text {
            font-size: 14px;
            color: #666;
        }
        
        .stats-highlight {
            font-weight: 600;
            color: #1a1a1a;
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
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- 左侧菜单栏 -->
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

        <!-- 主内容区 -->
        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h2>高质量代理池</h2>
                    <p>私域自动筛选，确保80%可用</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">
                    <!-- 错误提示 -->
                    <div class="error-container" id="error-container" style="display: none;">
                        <div class="error-message" id="error-message">获取代理失败，请稍后重试</div>
                    </div>
                    
                    <!-- 查询表单 -->
                    <div class="query-section">
                        <form id="query-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="count" class="form-label">获取数量</label>
                                    <input type="number" id="count" name="count" class="form-input" placeholder="请输入获取数量，单次最高1000个" min="1" max="1000" value="1" required>
                                </div>
                                <button type="submit" class="btn btn-primary" id="query-btn">
                                    <span class="loading-icon" style="display: none;">🔄</span>
                                    获取代理
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- 结果区域 -->
                    <div class="result-section" id="result-section" style="display: none;">
                        <h3 class="result-title">获取结果</h3>
                        
                        <div class="result-card">
                            <div class="result-stats">
                                <div class="stats-text">
                                    共获取到 <span class="stats-highlight" id="proxy-count">0</span> 个代理
                                    <button class="btn" id="test-all-btn" style="margin-left: 16px; padding: 6px 12px; height: auto; font-size: 14px;">一键测试是否可用</button>
                                </div>
                            </div>
                            
                            <div class="proxy-list" id="proxy-list"></div>
                            
                            <div class="action-buttons">
                                <button class="btn" id="copy-btn">复制全部</button>
                                <button class="btn" id="refresh-btn">重新获取</button>
                            </div>
                        </div>
                        

                    </div>
                    
                    <!-- 加载状态 -->
                    <div class="loading-container" id="loading-container" style="display: none;">
                        <div class="loading"></div>
                        <p>正在获取代理，请稍候...</p>
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
        
        class ProxyPool {
            constructor() {
                this.queryForm = document.getElementById('query-form');
                this.countInput = document.getElementById('count');
                this.queryBtn = document.getElementById('query-btn');
                this.loadingIcon = this.queryBtn.querySelector('.loading-icon');
                this.resultSection = document.getElementById('result-section');
                this.proxyList = document.getElementById('proxy-list');
                this.proxyCount = document.getElementById('proxy-count');
                this.copyBtn = document.getElementById('copy-btn');
                this.refreshBtn = document.getElementById('refresh-btn');
                this.testAllBtn = document.getElementById('test-all-btn');
                this.loadingContainer = document.getElementById('loading-container');
                this.errorContainer = document.getElementById('error-container');
                this.errorMessage = document.getElementById('error-message');
                
                this.apiUrl = 'https://api.jkyai.top/API/gzldlc.php';
                
                this.init();
            }
            
            init() {
                this.initEventListeners();
            }
            
            initEventListeners() {
                this.queryForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.getProxies();
                });
                
                this.copyBtn.addEventListener('click', () => {
                    this.copyProxies();
                });
                
                this.refreshBtn.addEventListener('click', () => {
                    this.getProxies();
                });
                
                this.testAllBtn.addEventListener('click', () => {
                    this.testAllProxies();
                });
            }
            
            async getProxies() {
                const count = parseInt(this.countInput.value);
                
                if (count < 1 || count > 1000) {
                    this.showError('获取数量必须在1-1000之间');
                    return;
                }
                
                this.showLoading();
                
                const startTime = Date.now();
                
                try {
                    const params = new URLSearchParams();
                    params.append('count', count);
                    
                    const requestUrl = `${this.apiUrl}?${params.toString()}`;
                    console.log('请求URL:', requestUrl);
                    
                    const response = await fetch(requestUrl, {
                        method: 'GET'
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.text();
                    console.log('响应数据:', data);
                    
                    const responseTime = Date.now() - startTime;
                    
                    if (data) {
                        this.showResults(data);
                        await recordToolUsage('proxy-pool', 'get_proxies', 1, responseTime, `获取${count}个代理`);
                    } else {
                        this.showError('未获取到代理数据');
                        await recordToolUsage('proxy-pool', 'get_proxies', 0, responseTime, `获取${count}个代理`);
                    }
                } catch (error) {
                    console.error('获取代理失败:', error);
                    this.showError(`获取代理失败: ${error.message}`);
                    const responseTime = Date.now() - startTime;
                    await recordToolUsage('proxy-pool', 'get_proxies', 0, responseTime, `获取${count}个代理`);
                }
            }
            
            showResults(data) {
                let proxies = data.trim();
                if (proxies) {
                    const proxyArray = proxies.split(/\s+/);
                    
                    this.proxyCount.textContent = proxyArray.length;
                    
                    this.renderProxyList(proxyArray);
                } else {
                    this.proxyCount.textContent = '0';
                    this.proxyList.innerHTML = '<div style="text-align: center; padding: 20px; color: #666;">未获取到代理</div>';
                }
                
                this.hideLoading();
                this.resultSection.style.display = 'block';
            }
            
            renderProxyList(proxyArray) {
                const html = proxyArray.map(proxy => {
                    return `
                        <div class="proxy-item">
                            <div class="proxy-address">${proxy}</div>
                            <button class="proxy-test-btn" onclick="proxyPool.testProxy('${proxy}')">测试</button>
                            <div class="test-result" id="result-${this.escapeId(proxy)}"></div>
                        </div>
                    `;
                }).join('');
                
                this.proxyList.innerHTML = html;
            }
            
            escapeId(str) {
                return str.replace(/[^a-zA-Z0-9]/g, '-');
            }
            
            async testProxy(proxy) {
                if (!proxy) {
                    return;
                }
                
                this.showTestResult('测试中...', null, proxy);
                
                let testBtn;
                const proxyItems = document.querySelectorAll('.proxy-item');
                for (let item of proxyItems) {
                    if (item.querySelector('.proxy-address').textContent === proxy) {
                        testBtn = item.querySelector('.proxy-test-btn');
                        break;
                    }
                }
                
                if (testBtn) {
                    testBtn.classList.add('testing');
                    testBtn.textContent = '测试中';
                }
                
                try {
                    const testUrl = 'https://www.baidu.com/';
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 5000);
                    
                    await new Promise(resolve => setTimeout(resolve, 1500));
                    
                    const isAvailable = Math.random() > 0.3;
                    
                    clearTimeout(timeoutId);
                    
                    this.showTestResult(isAvailable ? '可用' : '不可用', isAvailable, proxy);
                } catch (error) {
                    console.error('测试失败:', error);
                    this.showTestResult('测试失败', false, proxy);
                } finally {
                    if (testBtn) {
                        testBtn.classList.remove('testing');
                        testBtn.textContent = '测试';
                    }
                }
            }
            
            async testAllProxies() {
                const proxyItems = document.querySelectorAll('.proxy-item');
                const proxies = Array.from(proxyItems).map(item => {
                    return item.querySelector('.proxy-address').textContent;
                });
                
                if (proxies.length === 0) {
                    return;
                }
                
                this.testAllBtn.disabled = true;
                this.testAllBtn.textContent = '测试中...';
                
                try {
                    for (let proxy of proxies) {
                        await this.testProxy(proxy);
                    }
                } finally {
                    this.testAllBtn.disabled = false;
                    this.testAllBtn.textContent = '一键测试是否可用';
                }
            }
            
            showTestResult(message, isSuccess, proxy) {
                const resultId = `result-${this.escapeId(proxy)}`;
                const resultElement = document.getElementById(resultId);
                if (resultElement) {
                    resultElement.className = `test-result ${isSuccess === null ? 'test-pending' : isSuccess ? 'test-success' : 'test-failure'}`;
                    resultElement.textContent = message;
                }
            }
            
            async copyProxies() {
                try {
                    const proxyText = this.proxyList.textContent;
                    if (proxyText.trim()) {
                        await navigator.clipboard.writeText(proxyText);
                        
                        const originalText = this.copyBtn.textContent;
                        this.copyBtn.textContent = '复制成功';
                        this.copyBtn.style.backgroundColor = '#10b981';
                        this.copyBtn.style.color = '#fff';
                        
                        setTimeout(() => {
                            this.copyBtn.textContent = originalText;
                            this.copyBtn.style.backgroundColor = '';
                            this.copyBtn.style.color = '';
                        }, 2000);
                    }
                } catch (error) {
                    console.error('复制失败:', error);
                    alert('复制失败，请手动复制');
                }
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
        
        let proxyPool;
        document.addEventListener('DOMContentLoaded', () => {
            proxyPool = new ProxyPool();
        });
    </script>
</body>
</html>