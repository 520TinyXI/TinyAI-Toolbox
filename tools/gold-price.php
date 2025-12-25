<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>今日黄金价格 - 工具箱</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
            position: relative;
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
        
        
        .overview-section {
            background-color: #fafafa;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
            text-align: center;
        }
        
        .price-title {
            font-size: 18px;
            font-weight: 600;
            color: #666;
            margin-bottom: 16px;
        }
        
        .current-price {
            font-size: 48px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 12px;
        }
        
        .update-time {
            font-size: 14px;
            color: #999;
        }
        
        
        .action-section {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
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
        
        
        .table-section {
            margin-bottom: 20px;
        }
        
        .table-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
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
            border-bottom: 1px solid #e0e0e0;
        }
        
        .price-table th {
            background-color: #fafafa;
            font-weight: 600;
            color: #1a1a1a;
            font-size: 14px;
        }
        
        .price-table tr:last-child td {
            border-bottom: none;
        }
        
        .price-table tr:hover {
            background-color: #fafafa;
        }
        
        .gold-name {
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .change-percent {
            font-weight: 600;
        }
        
        .change-positive {
            color: #d63031;
        }
        
        .change-negative {
            color: #2e7d32;
        }
        
        
        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        
        .error {
            padding: 16px;
            background-color: #fff3f3;
            border: 1px solid #ffe0e0;
            border-radius: 8px;
            color: #d63031;
            text-align: center;
        }
        
        
        .shop-price-window {
            position: fixed;
            right: 50px;
            bottom: 150px;
            width: 300px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .shop-price-window:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }
        
        .shop-price-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            text-align: center;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .shop-price-item {
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .shop-price-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .shop-brand {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 4px;
        }
        
        .shop-gold-price {
            font-size: 18px;
            font-weight: 700;
            color: #d63031;
        }
        
        
        .shop-price-hidden {
            max-height: 40px;
            overflow: hidden;
            position: relative;
        }
        
        .shop-price-hidden::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 20px;
            background: linear-gradient(to bottom, transparent, #fff);
        }
        
        
        .ai-analysis-window {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 350px;
            height: 400px;
            background-color: #fff;
            border-radius: 12px 0 0 12px;
            box-shadow: -4px 0 16px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
            border-right: none;
            padding: 20px;
            z-index: 999;
            display: flex;
            flex-direction: column;
        }
        
        .ai-analysis-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            text-align: center;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .ai-analysis-content {
            flex: 1;
            overflow-y: auto;
            font-size: 14px;
            line-height: 1.6;
            color: #666;
        }
        
        
        @media (max-width: 768px) {
            .tool-container {
                padding: 20px 16px;
            }
            
            .tool-title {
                font-size: 24px;
            }
            
            .tool-content {
                padding: 20px;
            }
            
            .overview-section {
                padding: 20px;
            }
            
            .current-price {
                font-size: 32px;
            }
            
            .price-table {
                font-size: 14px;
            }
            
            .price-table th,
            .price-table td {
                padding: 12px 8px;
            }
            
            
            .shop-price-window {
                right: 20px;
                bottom: 100px;
                width: calc(100% - 40px);
                max-width: 300px;
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
                
                require_once '../php/framework.php';
                
                
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
                    <h2>今日黄金价格</h2>
                    <p>获取最新的黄金价格以及各种黄金的详细信息</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    
                    <div class="overview-section">
                        <div class="price-title">今日黄金价格</div>
                        <div class="current-price" id="current-price">--</div>
                        <div class="update-time" id="update-time"></div>
                    </div>
                    
                    
                    <div class="action-section">
                        <button class="btn btn-primary" id="refresh-btn">刷新数据</button>
                    </div>
                    
                    
                    <div class="table-section">
                        <div class="table-title" id="table-title">详细价格列表</div>
                        <table class="price-table" id="price-table">
                            <thead>
                                <tr>
                                    <th>序号</th>
                                    <th id="th-2">黄金名称</th>
                                    <th id="th-3">目录</th>
                                    <th id="th-4">涨跌幅</th>
                                    <th id="th-5">最高价</th>
                                    <th id="th-6">最低价</th>
                                    <th id="th-7">最高买入价</th>
                                    <th id="th-8">最低卖出价</th>
                                    <th id="th-9">日期</th>
                                </tr>
                            </thead>
                            <tbody id="price-table-body">
                                
                            </tbody>
                        </table>
                    </div>
                    
                    
                    <div id="loading" class="loading" style="display: none;">
                        正在获取黄金价格数据，请稍候...
                    </div>
                    
                    
                    <div id="error" class="error" style="display: none;"></div>
                </div>
            </div>
        </main>
        
        
        <div class="shop-price-window" id="shop-price-window">
            <div class="shop-price-title">点击切换金店价格</div>
            <div id="shop-price-content">
                
            </div>
        </div>
        
        
        <div class="ai-analysis-window">
            <div class="ai-analysis-title">AI数据分析（AI数据仅供参考）</div>
            <div class="ai-analysis-content">
                
                <p>AI数据分析区域，后续将展示数据分析结果。</p>
            </div>
        </div>
    </div>
    
    <script>
        
        function recordToolUsage(action, status = 'success', content = null, responseTime = null) {
            fetch('../php/record-tool-usage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tool_id: 'gold-price',
                    action: action,
                    content: content,
                    result: {
                        status: status
                    },
                    response_time: responseTime
                })
            }).catch(error => {
                console.error('记录使用量失败:', error);
            });
        }

        
        class GoldPrice {
            constructor() {
                this.currentPriceElement = document.getElementById('current-price');
                this.updateTimeElement = document.getElementById('update-time');
                this.refreshBtn = document.getElementById('refresh-btn');
                this.priceTableBody = document.getElementById('price-table-body');
                this.loading = document.getElementById('loading');
                this.error = document.getElementById('error');
                
                
                this.shopPriceWindow = document.getElementById('shop-price-window');
                this.shopPriceContent = document.getElementById('shop-price-content');
                
                
                this.apiUrl = '../php/gold-proxy.php';
                
                
                this.showTodayPrice = true;
                
                
                this.todayPriceData = [];
                this.shopPriceData = [];
                
                
                this.init();
            }
            
            
            init() {
                
                this.initEventListeners();
                
                
                this.fetchGoldPrice();
                this.fetchShopPrice();
            }
            
            
            initEventListeners() {
                
                this.refreshBtn.addEventListener('click', () => {
                    this.fetchGoldPrice();
                    this.fetchShopPrice();
                });
                
                
                this.shopPriceWindow.addEventListener('click', () => {
                    this.togglePriceDisplay();
                });
            }
            
            
            async fetchGoldPrice() {
                
                this.showLoading();
                
                
                const startTime = Date.now();
                
                try {
                    
                    const response = await fetch(`${this.apiUrl}?type=today`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    
                    if (data.code === 200) {
                        if (this.showTodayPrice) {
                            this.showGoldPrice(data);
                        }
                        
                        recordToolUsage('fetch_gold_price', 'success', {
                            api_code: data.code,
                            price: data.price,
                            data_count: data.data ? data.data.length : 0
                        }, responseTime);
                    } else {
                        if (this.showTodayPrice) {
                            this.showError(data.msg || '获取数据失败');
                        }
                        
                        recordToolUsage('fetch_gold_price', 'error', {
                            api_code: data.code || 500,
                            error_msg: data.msg || '获取数据失败'
                        }, responseTime);
                    }
                } catch (error) {
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    if (this.showTodayPrice) {
                        this.showError(`获取数据失败: ${error.message}`);
                        console.error('API请求错误:', error);
                    }
                    
                    recordToolUsage('fetch_gold_price', 'error', {
                        error_msg: error.message,
                        exception: error.message
                    }, responseTime);
                }
            }
            
            
            async fetchShopPrice() {
                
                const startTime = Date.now();
                
                try {
                    
                    const response = await fetch(`${this.apiUrl}?type=shop`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    
                    if (data.code === 200) {
                        this.shopPriceData = data.data;
                        this.updateShopPriceWindow();
                        
                        if (!this.showTodayPrice) {
                            this.showShopPriceInMain();
                        }
                        
                        
                        recordToolUsage('fetch_shop_price', 'success', {
                            api_code: data.code,
                            shop_count: data.data ? data.data.length : 0
                        }, responseTime);
                    } else {
                        
                        recordToolUsage('fetch_shop_price', 'error', {
                            api_code: data.code || 500,
                            error_msg: data.msg || '获取金店价格数据失败'
                        }, responseTime);
                    }
                } catch (error) {
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    console.error('金店价格API请求错误:', error);
                    
                    recordToolUsage('fetch_shop_price', 'error', {
                        error_msg: error.message,
                        exception: error.message
                    }, responseTime);
                }
            }
            
            
            showGoldPrice(data) {
                
                this.todayPriceData = data;
                
                
                this.currentPriceElement.textContent = `${data.price} 元/克`;
                this.updateTimeElement.textContent = `更新时间: ${data.time}`;
                
                
                document.getElementById('table-title').textContent = '详细价格列表';
                document.getElementById('th-2').textContent = '黄金名称';
                document.getElementById('th-3').textContent = '目录';
                document.getElementById('th-4').textContent = '涨跌幅';
                document.getElementById('th-5').textContent = '最高价';
                document.getElementById('th-6').textContent = '最低价';
                document.getElementById('th-7').textContent = '最高买入价';
                document.getElementById('th-8').textContent = '最低卖出价';
                document.getElementById('th-9').textContent = '日期';
                
                
                this.priceTableBody.innerHTML = '';
                
                
                data.data.forEach(item => {
                    const row = this.createPriceRow(item);
                    this.priceTableBody.appendChild(row);
                });
                
                
                this.hideLoading();
            }
            
            
            updateShopPriceWindow() {
                
                this.shopPriceContent.innerHTML = '';
                
                if (this.showTodayPrice) {
                    if (this.shopPriceData.length > 0) {
                        const shopsToShow = this.shopPriceData.slice(0, 2);
                        
                        shopsToShow.forEach((shop, index) => {
                            const shopItem = document.createElement('div');
                            shopItem.className = `shop-price-item ${index === 1 ? 'shop-price-hidden' : ''}`;
                            
                            shopItem.innerHTML = `
                                <div class="shop-brand">${shop.brand}</div>
                                <div class="shop-gold-price">${shop.gold_price}</div>
                            `;
                            
                            this.shopPriceContent.appendChild(shopItem);
                        });
                    } else {
                        this.shopPriceContent.innerHTML = '<div style="text-align: center; color: #999; padding: 10px 0;">加载中...</div>';
                    }
                } else {
                    if (this.todayPriceData && this.todayPriceData.data && this.todayPriceData.data.length > 0) {
                        const todayItemsToShow = this.todayPriceData.data.slice(0, 2);
                        
                        todayItemsToShow.forEach((item, index) => {
                            const shopItem = document.createElement('div');
                            shopItem.className = `shop-price-item ${index === 1 ? 'shop-price-hidden' : ''}`;
                            
                            shopItem.innerHTML = `
                                <div class="shop-brand">${item.title}</div>
                                <div class="shop-gold-price">${item.maxprice || '--'} 元/克</div>
                            `;
                            
                            this.shopPriceContent.appendChild(shopItem);
                        });
                    } else {
                        this.shopPriceContent.innerHTML = `
                            <div class="shop-price-item">
                                <div class="shop-brand" style="color: #666;">今日金价</div>
                                <div class="shop-gold-price" style="color: #1a1a1a;">点击查看详细信息</div>
                            </div>
                        `;
                    }
                }
            }
            
            
            showShopPriceInMain() {
                
                this.currentPriceElement.textContent = `${this.shopPriceData[0].gold_price}`;
                this.updateTimeElement.textContent = `更新时间: ${this.shopPriceData[0].update_time}`;
                
                
                document.getElementById('table-title').textContent = '金店价格列表';
                document.getElementById('th-2').textContent = '金店名称';
                document.getElementById('th-3').textContent = '黄金价格';
                document.getElementById('th-4').textContent = '铂金价格';
                document.getElementById('th-5').textContent = '金条价格';
                document.getElementById('th-6').textContent = '更新时间';
                document.getElementById('th-7').textContent = '-';
                document.getElementById('th-8').textContent = '-';
                document.getElementById('th-9').textContent = '-';
                
                
                this.priceTableBody.innerHTML = '';
                
                
                this.shopPriceData.forEach((item, index) => {
                    const row = this.createShopPriceRow(item, index + 1);
                    this.priceTableBody.appendChild(row);
                });
                
                
                this.hideLoading();
            }
            
            
            createPriceRow(item) {
                const row = document.createElement('tr');
                
                
                const changeClass = item.changepercent.includes('+') ? 'change-positive' : 'change-negative';
                
                row.innerHTML = `
                    <td>${item.id}</td>
                    <td class="gold-name">${item.title}</td>
                    <td>${item.dir}</td>
                    <td class="change-percent ${changeClass}">${item.changepercent}</td>
                    <td>${item.maxprice || '--'}</td>
                    <td>${item.minprice || '--'}</td>
                    <td>${item.buyprice || '--'}</td>
                    <td>${item.recycleprice || '--'}</td>
                    <td>${item.date}</td>
                `;
                
                return row;
            }
            
            
            createShopPriceRow(item, index) {
                const row = document.createElement('tr');
                
                row.innerHTML = `
                    <td>${index}</td>
                    <td class="gold-name">${item.brand}</td>
                    <td>${item.gold_price}</td>
                    <td>${item.platinum_price}</td>
                    <td>${item.bar_price}</td>
                    <td>${item.update_time}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                `;
                
                return row;
            }
            
            
            togglePriceDisplay() {
                this.showTodayPrice = !this.showTodayPrice;
                
                if (this.showTodayPrice) {
                    
                    this.fetchGoldPrice();
                } else {
                    
                    this.showShopPriceInMain();
                }
                
                
                this.updateShopPriceWindow();
            }
            
            
            showLoading() {
                this.loading.style.display = 'block';
                this.error.style.display = 'none';
            }
            
            
            hideLoading() {
                this.loading.style.display = 'none';
                this.error.style.display = 'none';
            }
            
            
            showError(message) {
                this.error.textContent = message;
                this.loading.style.display = 'none';
                this.error.style.display = 'block';
            }
            
            
            async analyzeGoldPrice() {
                try {
                    const aiContent = document.querySelector('.ai-analysis-content');
                    aiContent.innerHTML = `<div style="text-align: center; color: #666; padding: 40px 0;"><div class="loading"></div> 正在分析金价数据...</div>`;
                    
                    
                    await Promise.all([this.fetchGoldPrice(), this.fetchShopPrice()]);
                    
                    
                    const keywords = this.generateKeywords();
                    aiContent.innerHTML = `<div style="text-align: center; color: #666; padding: 40px 0;"><div class="loading"></div> 正在搜索相关文章...</div>`;
                    
                    
                    const searchResults = await this.searchRelatedArticles(keywords);
                    aiContent.innerHTML = `<div style="text-align: center; color: #666; padding: 40px 0;"><div class="loading"></div> 正在调用AI分析...</div>`;
                    
                    
                    const aiAnalysis = await this.callAIForAnalysis(keywords, searchResults);
                    
                    
                    this.displayAIAnalysis(aiAnalysis);
                } catch (error) {
                    console.error('数据分析失败详情:', error);
                    const errorMsg = error.message || '未知错误';
                    this.displayAIAnalysis({ 
                        error: `数据分析失败: ${errorMsg}，请稍后重试` 
                    });
                }
            }
            
            
            generateKeywords() {
                const keywords = [];
                
                
                const investmentPrices = this.todayPriceData.data || [];
                if (investmentPrices.length > 0) {
                    
                    const avgChangePercent = investmentPrices.reduce((sum, item) => {
                        const change = parseFloat(item.changepercent) || 0;
                        return sum + change;
                    }, 0) / investmentPrices.length;
                    
                    
                    if (Math.abs(avgChangePercent) > 1) {
                        
                        const trendKeywords = ['美联储', '通胀', '非农数据', '避险情绪'];
                        while (keywords.length < 3 && trendKeywords.length > 0) {
                            const randomIndex = Math.floor(Math.random() * trendKeywords.length);
                            const keyword = trendKeywords.splice(randomIndex, 1)[0];
                            keywords.push(keyword);
                        }
                    }
                }
                
                
                const shopPrices = this.shopPriceData || [];
                if (shopPrices.length > 0 && this.todayPriceData.price) {
                    
                    const avgShopPrice = shopPrices.reduce((sum, shop) => {
                        
                        const priceStr = shop.gold_price;
                        const price = parseFloat(priceStr.replace(/[^0-9.]/g, '')) || 0;
                        return sum + price;
                    }, 0) / shopPrices.length;
                    
                    
                    const investmentPrice = parseFloat(this.todayPriceData.price) || 0;
                    
                    
                    const premiumRate = ((avgShopPrice - investmentPrice) / investmentPrice) * 100;
                    
                    
                    if (premiumRate > 20) {
                        keywords.push('黄金首饰需求');
                    }
                }
                
                
                if (keywords.length === 0) {
                    keywords.push('黄金市场');
                }
                
                return keywords;
            }
            
            
            async searchRelatedArticles(keywords) {
                const searchResults = [];
                
                
                const keywordsToSearch = keywords.slice(0, 3);
                
                for (const keyword of keywordsToSearch) {
                    try {
                        const response = await fetch(`../php/universal-search-proxy.php?search=${encodeURIComponent(keyword)}&page=1`);
                        const data = await response.json();
                        
                        if (data.code === 200 && data.data && data.data.length > 0) {
                            
                            searchResults.push(...data.data.slice(0, 4));
                        }
                    } catch (error) {
                        console.error(`搜索关键词"${keyword}"失败:`, error);
                    }
                }
                
                
                return searchResults.slice(0, 10);
            }
            
            
            async callAIForAnalysis(keywords, searchResults) {
                
                const question = `你是一位专业的黄金市场分析师。请严格按以下步骤，对提供的黄金价格数据进行深入分析，并提出你对今日金价的看法和建议

1. 金价数据：
投资金价：${this.todayPriceData.price || '--'} 元/克

详细投资金价列表：
${this.todayPriceData.data.map(item => `${item.title}: ${item.maxprice || '--'}/${item.minprice || '--'} 元/克 (${item.changepercent})`).join('\n')}

金店价格数据：
${this.shopPriceData.map(shop => `${shop.brand}: ${shop.gold_price} (铂金: ${shop.platinum_price}, 金条: ${shop.bar_price})`).join('\n')}

2. 相关关键词：${keywords.join(', ')}

3. 相关文章：
${searchResults.slice(0, 10).map((article, index) => `${index + 1}. ${article.title}\n${article.abstract || ''}`).join('\n\n')}

请以专业JSON格式输出分析结果，包含以下字段：
- trend: 金价趋势（上涨/下跌/震荡）
- factors: 影响因素数组
- analysis: 详细分析
- advice: 投资建议
- confidence: 置信度（0-100）`;
                
                try {
                    const response = await fetch('https://api.jkyai.top/API/depsek3.2.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `question=${encodeURIComponent(question)}&type=json`
                    });
                    
                    const data = await response.json();
                    
                    
                    if (data.response) {
                        try {
                            
                            const aiAnalysis = JSON.parse(data.response);
                            
                            recordToolUsage('call_ai_analysis', 'success', {
                                keywords: keywords,
                                response_parsed: true
                            });
                            return aiAnalysis;
                        } catch (parseError) {
                            console.error('解析AI响应失败:', parseError);
                            console.error('原始AI响应:', data.response);
                            
                            recordToolUsage('call_ai_analysis', 'error', {
                                keywords: keywords,
                                error_msg: '解析AI响应失败',
                                exception: parseError.message
                            });
                            return { error: '解析AI响应失败，请稍后重试' };
                        }
                    } else {
                        
                        
                        recordToolUsage('call_ai_analysis', 'success', {
                            keywords: keywords,
                            response_parsed: false
                        });
                        return data;
                    }
                } catch (error) {
                    console.error('调用AI失败:', error);
                    
                    recordToolUsage('call_ai_analysis', 'error', {
                        keywords: keywords,
                        error_msg: error.message,
                        exception: error.message
                    });
                    return { error: '调用AI失败，请稍后重试' };
                }
            }
            
            
            displayAIAnalysis(analysis) {
                const aiContent = document.querySelector('.ai-analysis-content');
                
                if (analysis.error) {
                    aiContent.innerHTML = `<div style="color: #d63031; text-align: center; padding: 20px 0;">${analysis.error}</div>`;
                } else {
                    
                    const trend = analysis.trend || '未知';
                    const factors = Array.isArray(analysis.factors) ? analysis.factors : [];
                    const analysisText = analysis.analysis || '暂无详细分析';
                    const advice = analysis.advice || '暂无投资建议';
                    const confidence = typeof analysis.confidence === 'number' ? analysis.confidence : 0;
                    
                    
                    aiContent.innerHTML = `
                        <div class="analysis-result">
                            
                            <div class="analysis-section">
                                <div class="section-label">金价趋势</div>
                                <div class="trend-value ${this.getTrendClass(trend)}">${trend}</div>
                            </div>
                            
                            
                            <div class="analysis-section">
                                <div class="section-label">影响因素</div>
                                <ul class="factors-list">
                                    ${factors.map(factor => `<li>${factor}</li>`).join('') || '<li>暂无影响因素</li>'}
                                </ul>
                            </div>
                            
                            
                            <div class="analysis-section">
                                <div class="section-label">详细分析</div>
                                <div class="analysis-text">${this.formatAnalysisText(analysisText)}</div>
                            </div>
                            
                            
                            <div class="analysis-section">
                                <div class="section-label">投资建议</div>
                                <div class="analysis-text">${this.formatAnalysisText(advice)}</div>
                            </div>
                        </div>
                        <style>
                            .analysis-result {
                                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                            }
                            
                            .analysis-section {
                                margin-bottom: 24px;
                                padding-bottom: 16px;
                                border-bottom: 1px solid #f0f0f0;
                            }
                            
                            .analysis-section:last-child {
                                margin-bottom: 0;
                                padding-bottom: 0;
                                border-bottom: none;
                            }
                            
                            .section-label {
                                font-size: 16px;
                                font-weight: 600;
                                color: #1a1a1a;
                                margin-bottom: 12px;
                            }
                            
                            .trend-value {
                                font-size: 24px;
                                font-weight: 700;
                            }
                            
                            .trend-value.上涨, .trend-value.震荡上行 {
                                color: #d63031;
                            }
                            
                            .trend-value.下跌, .trend-value.震荡下行 {
                                color: #2e7d32;
                            }
                            
                            .trend-value.震荡 {
                                color: #1565c0;
                            }
                            
                            .factors-list {
                                margin: 0;
                                padding-left: 20px;
                            }
                            
                            .factors-list li {
                                margin-bottom: 8px;
                                color: #666;
                                line-height: 1.6;
                            }
                            
                            .analysis-text {
                                color: #666;
                                line-height: 1.6;
                                white-space: pre-wrap;
                            }
                            
                            .confidence-container {
                                width: 100%;
                            }
                            
                            .confidence-bar {
                                height: 20px;
                                background-color: #f0f0f0;
                                border-radius: 10px;
                                overflow: hidden;
                                position: relative;
                            }
                            
                            .confidence-fill {
                                height: 100%;
                                background-color: #1a1a1a;
                                border-radius: 10px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                font-size: 12px;
                                font-weight: 600;
                                color: #fff;
                                transition: width 0.5s ease;
                            }
                        </style>
                    `;
                }
            }
            
            
            getTrendClass(trend) {
                
                trend = trend || '';
                
                if (trend.includes('上涨')) {
                    return '上涨';
                } else if (trend.includes('下跌')) {
                    return '下跌';
                } else {
                    return '震荡';
                }
            }
            
            
            formatAnalysisText(text) {
                
                return text
                    .replace(/\n\n+/g, '\n\n')
                    .replace(/^\n+|\n+$/g, '')
                    .trim();
            }
        }
        
        
        document.addEventListener('DOMContentLoaded', () => {
            const goldPrice = new GoldPrice();
            
            
            setTimeout(() => {
                goldPrice.analyzeGoldPrice();
            }, 1000);
        });
    </script>
</body>
</html>