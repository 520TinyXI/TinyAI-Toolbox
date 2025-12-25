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
    <title>域名比价查询 - <?php echo $siteConfig['name']; ?></title>
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
            min-width: 200px;
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
            min-width: 150px;
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
        
        .btn:active {
            transform: translateY(0);
        }
        

        .results-section {
            margin-top: 30px;
        }
        
        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .results-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .result-summary {
            font-size: 14px;
            color: #666;
        }
        
        .price-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .price-table th,
        .price-table td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .price-table th {
            background-color: #fafafa;
            font-weight: 600;
            color: #1a1a1a;
            font-size: 14px;
        }
        
        .price-table td {
            color: #333;
            font-size: 14px;
        }
        
        .price-table tbody tr:hover {
            background-color: #fafafa;
        }
        
        .price-table tbody tr:last-child td {
            border-bottom: none;
        }
        

        .price-table tbody tr:first-child td {
            font-weight: 600;
            background-color: #f0f7ff;
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
            padding: 40px;
            color: #999;
        }
        
        .empty-state.visible {
            display: block;
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
            
            .results-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .price-table th,
            .price-table td {
                padding: 12px 8px;
                font-size: 12px;
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
                    <h2>域名比价查询</h2>
                    <p>查询域名后缀在各平台的注册、续费、转入价格排行</p>
                </div>
            </header>
            
            <div class="tool-container">

                <div class="tool-content">

                    <div class="error-message" id="error-message"></div>
                    

                    <div class="query-section">
                        <form class="query-form" id="query-form">
                            <div class="form-group">
                                <label class="form-label" for="domain">域名后缀</label>
                                <input type="text" id="domain" class="form-input" placeholder="请输入域名后缀，如：cn、com、net" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="type">查询类型</label>
                                <select class="type-select" id="type">
                                    <option value="new">注册价格</option>
                                    <option value="renew">续费价格</option>
                                    <option value="transfer">转入价格</option>
                                </select>
                            </div>
                            <button type="submit" class="btn" id="query-btn">
                                <span class="loading-icon" style="display: none;">🔄</span>
                                <span>查询价格</span>
                            </button>
                        </form>
                    </div>
                    

                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div>正在查询域名价格，请稍候...</div>
                    </div>
                    

                    <div class="empty-state" id="empty-state">
                        <div style="font-size: 64px; margin-bottom: 16px;">🌐</div>
                        <div>请输入域名后缀并选择查询类型开始查询</div>
                    </div>
                    

                    <div class="results-section" id="results-section" style="display: none;">
                        <div class="results-header">
                            <h3 class="results-title">比价结果</h3>
                            <div class="result-summary" id="result-summary"></div>
                        </div>
                        <table class="price-table" id="price-table">
                            <thead>
                                <tr>
                                    <th>排名</th>
                                    <th>平台</th>
                                    <th>价格</th>
                                </tr>
                            </thead>
                            <tbody id="price-table-body">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="../js/main.js"></script>
    
    <script>

        function recordToolUsage(action, status = 'success', content = null, responseTime = null) {
            fetch('../php/record-tool-usage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tool_id: 'domain-price',
                    action: action,
                    content: content,
                    result: {
                        status: status
                    },
                    response_time: responseTime
                })
            }).catch(error => {
                console.error('Failed to record usage:', error);
            });
        }

        class DomainPriceComparison {
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
                    this.queryDomainPrice();
                });
            }
            
            async queryDomainPrice() {
                const domain = document.getElementById('domain').value.trim();
                const type = document.getElementById('type').value;
                
                this.showLoading();
                this.hideError();
                this.hideEmptyState();
                this.hideResults();
                this.disableQueryBtn();
                

                const startTime = Date.now();
                

                const maxRetries = 3;
                const retryDelay = 1000; // 毫秒
                let success = false;
                let lastError = null;
                

                const requestUrl = `../php/domain-proxy.php?domain=${encodeURIComponent(domain)}&type=${encodeURIComponent(type)}`;
                
                try {
                    for (let retry = 0; retry < maxRetries; retry++) {
                        if (success) break;
                        
                        const retryText = retry > 0 ? `(重试 ${retry}/${maxRetries})` : '';
                        this.updateQueryBtnText(`查询中${retryText}...`);
                        
                        try {
                            
                            const controller = new AbortController();
                            const timeoutId = setTimeout(() => controller.abort(), 30000); 
                            
                            const response = await fetch(requestUrl, {
                                method: 'GET',
                                signal: controller.signal
                            });
                            
                            clearTimeout(timeoutId);
                            
                            if (!response.ok) {
                
                                const responseText = await response.text();
                                throw new Error(`HTTP错误! 状态码: ${response.status}`);
                            }
                            
            
                            const responseText = await response.text();
                            
            
                            let data;
                            try {
                                data = JSON.parse(responseText);
                            } catch (jsonError) {
                                throw new Error(`JSON解析失败: ${jsonError.message}`);
                            }
                            
                            if (data.code === 200) {
                                this.displayResults(data);
                                success = true;
                                
                                const responseTime = (Date.now() - startTime) / 1000;
                                
                                recordToolUsage('query_domain_price', 'success', {
                                    api_code: data.code,
                                    domain: domain,
                                    type: type,
                                    result_count: data.data ? data.data.length : 0
                                }, responseTime);
                            } else {
                
                                let errorMsg = data.msg || '查询失败';
                                if (data.debug) {
                    
                                    errorMsg += `<br><br>服务器返回错误: ${data.debug.last_http_code || '未知'}`;
                                    if (data.debug.last_curl_error) {
                                        errorMsg += `<br>错误信息: ${this.escapeHtml(data.debug.last_curl_error)}`;
                                    }
                                }
                               
                                const responseTime = (Date.now() - startTime) / 1000;
                               
                                recordToolUsage('query_domain_price', 'error', {
                                    api_code: data.code || 500,
                                    domain: domain,
                                    type: type,
                                    error_msg: data.msg || '查询失败'
                                }, responseTime);
                                throw new Error(errorMsg);
                            }
                        } catch (error) {
                            lastError = error;
                            
            
                            if (retry < maxRetries - 1) {
                
                                const shouldRetry = error.name === 'AbortError' || 
                                                 error.message.includes('HTTP错误! 状态码: 504') ||
                                                 error.message.includes('HTTP错误! 状态码: 502') ||
                                                 error.message.includes('HTTP错误! 状态码: 503');
                                
                                if (shouldRetry) {
                                   
                                    await new Promise(resolve => setTimeout(resolve, retryDelay));
                                    continue;
                                }
                            }
                            
            
                            throw error;
                        }
                    }
                } catch (error) {
                   
                    const responseTime = (Date.now() - startTime) / 1000;
                    let errorMsg = `查询失败: ${error.message}`;
                    if (error.name === 'AbortError') {
                        errorMsg = '查询超时，请稍后重试';
                    } else if (error.message.includes('HTTP错误! 状态码: 504')) {
                        errorMsg = '服务器响应超时，请稍后重试';
                    } else if (error.message.includes('HTTP错误! 状态码: 502') || error.message.includes('HTTP错误! 状态码: 503')) {
                        errorMsg = '服务器暂时不可用，请稍后重试';
                    }
                    this.showError(errorMsg);
                    console.error('API请求错误:', error);
                  
                    recordToolUsage('query_domain_price', 'error', {
                        domain: domain,
                        type: type,
                        error_msg: errorMsg,
                        exception: error.message
                    }, responseTime);
                } finally {
                    this.hideLoading();
                    this.enableQueryBtn();
                }
            }
            
            updateQueryBtnText(text) {
                const queryBtn = document.getElementById('query-btn');
                const textSpan = queryBtn.querySelector('span:last-child');
                if (textSpan) {
                    textSpan.textContent = text;
                }
            }
            
            displayResults(data) {
                const resultsSection = document.getElementById('results-section');
                const resultSummary = document.getElementById('result-summary');
                const tableBody = document.getElementById('price-table-body');
                
              
                resultsSection.style.display = 'block';
                
               
                const typeMap = {
                    'new': '注册',
                    'renew': '续费',
                    'transfer': '转入'
                };
                resultSummary.textContent = `${data.domain} 后缀 ${typeMap[data.type]}价格比较`;
                
                
                tableBody.innerHTML = '';
                
                
                if (data.data && data.data.length > 0) {
                    data.data.forEach((item, index) => {
                        const row = this.createTableRow(index + 1, item.server, item.price);
                        tableBody.appendChild(row);
                    });
                } else {
                    this.showEmptyState();
                    resultsSection.style.display = 'none';
                }
            }
            
            createTableRow(rank, server, price) {
                const row = document.createElement('tr');
                
                row.innerHTML = `
                    <td>${rank}</td>
                    <td>${server}</td>
                    <td>${price}</td>
                `;
                
                return row;
            }
            
            showLoading() {
                document.getElementById('loading').classList.add('visible');
            }
            
            hideLoading() {
                document.getElementById('loading').classList.remove('visible');
            }
            
            showError(message) {
                const errorElement = document.getElementById('error-message');
                errorElement.innerHTML = message; // 使用innerHTML支持HTML格式化
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
            
            showResults() {
                document.getElementById('results-section').style.display = 'block';
            }
            
            hideResults() {
                document.getElementById('results-section').style.display = 'none';
            }
            
            disableQueryBtn() {
                const queryBtn = document.getElementById('query-btn');
                queryBtn.disabled = true;
                queryBtn.querySelector('.loading-icon').style.display = 'inline-block';
                queryBtn.querySelector('span:last-child').textContent = '查询中...';
            }
            
            enableQueryBtn() {
                const queryBtn = document.getElementById('query-btn');
                queryBtn.disabled = false;
                queryBtn.querySelector('.loading-icon').style.display = 'none';
                queryBtn.querySelector('span:last-child').textContent = '查询价格';
            }
            



            escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
        }
        

        document.addEventListener('DOMContentLoaded', () => {
            new DomainPriceComparison();
        });
    </script>
</body>
</html>