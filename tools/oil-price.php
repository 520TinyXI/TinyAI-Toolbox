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
    <title>全国油价查询 - <?php echo $siteConfig['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 900px;
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
        
        .form-section {
            margin-bottom: 30px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 16px;
            align-items: end;
            margin-bottom: 20px;
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
            display: flex;
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
        
        .hot-cities {
            margin-top: 20px;
        }
        
        .hot-cities-title {
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 12px;
        }
        
        .city-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .city-btn {
            padding: 8px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 20px;
            background-color: #f5f5f5;
            color: #1a1a1a;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .city-btn:hover {
            background-color: #e0e0e0;
            transform: translateY(-1px);
        }
        
        .result-section {
            margin-top: 30px;
        }
        
        .result-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 20px;
        }
        
        .oil-card {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
        }
        
        .trend-section {
            background-color: #fff3f3;
            border: 1px solid #ffe0e0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
        }
        
        .trend-title {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .trend-content {
            font-size: 14px;
            color: #d63031;
            line-height: 1.5;
        }
        
        .oil-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .oil-table th,
        .oil-table td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .oil-table th {
            background-color: #f5f5f5;
            font-weight: 600;
            color: #1a1a1a;
            font-size: 14px;
        }
        
        .oil-table td {
            font-size: 16px;
            color: #1a1a1a;
        }
        
        .oil-type {
            font-weight: 500;
        }
        
        .oil-price {
            font-weight: 600;
            color: #e74c3c;
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
            
            .oil-table th,
            .oil-table td {
                padding: 12px 8px;
                font-size: 14px;
            }
            
            .city-buttons {
                gap: 8px;
            }
            
            .city-btn {
                font-size: 13px;
                padding: 6px 12px;
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
                    <h2>全国油价查询</h2>
                    <p>查询全国各城市的最新油价信息，包括92#、95#、98#汽油和0#柴油价格</p>
                </div>
            </header>
            
            <div class="tool-container">
                <!-- 工具内容 -->
                <div class="tool-content">
                    <!-- 错误信息 -->
                    <div class="error-message" id="error-message"></div>
                    
                    <!-- 查询表单 -->
                    <div class="form-section">
                        <form id="oil-price-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="city-input">城市名称</label>
                                    <input type="text" class="form-input" id="city-input" name="city" placeholder="请输入城市名称，如 北京、上海、广州" value="北京">
                                    
                                    <!-- 热门城市快捷按钮 -->
                                    <div class="hot-cities">
                                        <div class="hot-cities-title">热门城市</div>
                                        <div class="city-buttons">
                                            <button type="button" class="city-btn" data-city="北京">北京</button>
                                            <button type="button" class="city-btn" data-city="上海">上海</button>
                                            <button type="button" class="city-btn" data-city="广州">广州</button>
                                            <button type="button" class="city-btn" data-city="深圳">深圳</button>
                                            <button type="button" class="city-btn" data-city="杭州">杭州</button>
                                            <button type="button" class="city-btn" data-city="成都">成都</button>
                                            <button type="button" class="city-btn" data-city="重庆">重庆</button>
                                            <button type="button" class="city-btn" data-city="武汉">武汉</button>
                                            <button type="button" class="city-btn" data-city="西安">西安</button>
                                            <button type="button" class="city-btn" data-city="天津">天津</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn" id="query-btn">
                                    <span class="loading-icon" style="display: none;">🔄</span>
                                    <span>查询油价</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- 加载状态 -->
                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div>正在查询油价，请稍候...</div>
                    </div>
                    
                    <!-- 结果区域 -->
                    <div class="result-section" id="result-section" style="display: none;">
                        <h3 class="result-title">查询结果</h3>
                        
                        <!-- 油价趋势 -->
                        <div class="trend-section" id="trend-section" style="display: none;">
                            <div class="trend-title">价格趋势</div>
                            <div class="trend-content" id="trend-content"></div>
                        </div>
                        
                        <!-- 油价表格 -->
                        <div class="oil-card">
                            <table class="oil-table" id="oil-table">
                                <thead>
                                    <tr>
                                        <th>油品类型</th>
                                        <th>价格(元/升)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- 结果将通过JavaScript动态生成 -->
                                </tbody>
                            </table>
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
        
        class OilPriceQuery {
            constructor() {
                this.init();
            }
            
            init() {
                this.bindEvents();
            }
            
            bindEvents() {
                const form = document.getElementById('oil-price-form');
                const cityInput = document.getElementById('city-input');
                
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.queryOilPrice();
                });
                
                document.querySelectorAll('.city-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const city = e.target.dataset.city;
                        cityInput.value = city;
                        this.queryOilPrice();
                    });
                });
            }
            
            async queryOilPrice() {
                const city = document.getElementById('city-input').value.trim();
                
                if (!city) {
                    this.showError('请输入城市名称');
                    return;
                }
                
                this.showLoading();
                this.hideError();
                
                const startTime = Date.now();
                
                try {
                    const params = new URLSearchParams({ city: city });
                    const requestUrl = `../php/oil-price-proxy.php?${params.toString()}`;
                    
                    const response = await fetch(requestUrl);
                    
                    if (!response.ok) {
                        const errorData = await response.json().catch(() => ({}));
                        throw new Error(data.message || `HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.code !== 1) {
                        throw new Error(data.message || '查询失败');
                    }
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.displayResults(data);
                    
                    const content = JSON.stringify({ action: 'query_oil_price', city: city });
                    await recordToolUsage('oil-price', 'query_oil_price', 'success', responseTime, content);
                } catch (error) {
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.showError(`查询失败: ${error.message}`);
                    console.error('API请求错误:', error);
                    
                    const content = JSON.stringify({ action: 'query_oil_price', city: city, error: error.message });
                    await recordToolUsage('oil-price', 'query_oil_price', 'error', responseTime, content);
                } finally {
                    this.hideLoading();
                }
            }
            
            displayResults(results) {
                const resultSection = document.getElementById('result-section');
                const oilTable = document.getElementById('oil-table').querySelector('tbody');
                const trendSection = document.getElementById('trend-section');
                const trendContent = document.getElementById('trend-content');
                
                oilTable.innerHTML = '';
                
                if (results.qushi && results.qushi.trim()) {
                    trendContent.textContent = results.qushi;
                    trendSection.style.display = 'block';
                } else {
                    trendSection.style.display = 'none';
                }
                
                if (results.data && Array.isArray(results.data) && results.data.length > 0) {
                    results.data.forEach(item => {
                        const oilType = item.type;
                        
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="oil-type">${oilType}</td>
                            <td class="oil-price">${item.price}</td>
                        `;
                        
                        oilTable.appendChild(row);
                    });
                } else {
                    oilTable.innerHTML = '<tr><td colspan="2" style="text-align: center; color: #666; padding: 40px;">未找到该城市的油价数据</td></tr>';
                }
                
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
                queryBtn.querySelector('span:last-child').textContent = '查询油价';
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
            new OilPriceQuery();
        });
    </script>
</body>
</html>