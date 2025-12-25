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
    <title>全球啤酒厂查询 - <?php echo $siteConfig['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 1200px;
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
            padding: 24px;
            background-color: #fafafa;
            border-radius: 8px;
        }
        
        .query-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .tab-btn {
            padding: 10px 20px;
            border: 1px solid #e0e0e0;
            background-color: #fff;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        }
        
        .tab-btn.active {
            background-color: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
        }
        
        .tab-btn:hover {
            background-color: #f0f0f0;
        }
        
        .tab-btn.active:hover {
            background-color: #333;
        }
        
        .query-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }
        
        .form-input,
        .form-select {
            padding: 10px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.1);
        }
        
        .search-btn {
            grid-column: 1 / -1;
            background-color: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
        }
        
        .search-btn:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .search-btn:active {
            transform: translateY(0);
        }
        
        
        .results-section {
            margin-bottom: 30px;
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
        
        .results-count {
            font-size: 14px;
            color: #666;
        }
        
        
        .brewery-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .brewery-card {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .brewery-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            border-color: #1a1a1a;
        }
        
        .brewery-name {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .brewery-type {
            display: inline-block;
            background-color: #e0f2fe;
            color: #0284c7;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 12px;
        }
        
        .brewery-info {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
        }
        
        .brewery-info div {
            margin-bottom: 6px;
        }
        
        .brewery-info i {
            margin-right: 8px;
            width: 16px;
            text-align: center;
        }
        
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 30px;
        }
        
        .page-btn {
            padding: 8px 16px;
            border: 1px solid #e0e0e0;
            background-color: #fff;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .page-btn:hover {
            background-color: #f0f0f0;
        }
        
        .page-btn.active {
            background-color: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
        }
        
        .page-btn:disabled {
            background-color: #f5f5f5;
            color: #999;
            cursor: not-allowed;
        }
        
        
        .detail-section {
            background-color: #fafafa;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 30px;
        }
        
        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .detail-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .close-detail-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .close-detail-btn:hover {
            background-color: #e0e0e0;
            color: #1a1a1a;
        }
        
        .detail-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .detail-item {
            background-color: #fff;
            padding: 16px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
        }
        
        .detail-item-label {
            font-size: 12px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        
        .detail-item-value {
            font-size: 16px;
            color: #1a1a1a;
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
        
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        
        .empty-icon {
            font-size: 64px;
            margin-bottom: 16px;
        }
        
        .empty-text {
            font-size: 16px;
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
            
            .query-form {
                grid-template-columns: 1fr;
            }
            
            .brewery-list {
                grid-template-columns: 1fr;
            }
            
            .results-header {
                flex-direction: column;
                align-items: stretch;
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
                    <h2>全球啤酒厂查询</h2>
                    <p>查询全球啤酒厂信息，支持按国家、城市、类型等筛选（中文或其他语言可能过慢，因为要翻译所以会慢一点）</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
    
                    <div class="error-message" id="error-message"></div>
                    

                    <div class="query-section">
                        <div class="query-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 16px;">
                            <div class="query-tabs">
                                <button class="tab-btn active" data-tab="search">关键词搜索</button>
                                <button class="tab-btn" data-tab="country">按国家</button>
                                <button class="tab-btn" data-tab="city">按城市</button>
                                <button class="tab-btn" data-tab="type">按类型</button>
                                <button class="tab-btn" data-tab="random">随机啤酒厂</button>
                            </div>
                            <div class="form-group" style="margin: 0; flex-direction: row; align-items: center; gap: 12px;">
                                <label class="form-label" style="margin: 0;">语言选择：</label>
                                <select class="form-select" id="language-select" style="min-width: 150px;">
                                    <option value="en">English</option>
                                    <option value="zh" selected>中文</option>
                                    <option value="es">Español (西班牙语)</option>
                                    <option value="fr">Français (法语)</option>
                                    <option value="de">Deutsch (德语)</option>
                                    <option value="ja">日本語 (日语)</option>
                                    <option value="ko">한국어 (韩语)</option>
                                    <option value="pt">Português (葡萄牙语)</option>
                                    <option value="ru">Русский (俄语)</option>
                                    <option value="ar">العربية (阿拉伯语)</option>
                                </select>
                            </div>
                        </div>
                        
                       
                        <div class="query-form" id="search-form" style="display: block;">
                            <div class="form-group">
                                <label class="form-label">搜索关键词</label>
                                <input type="text" class="form-input" id="search-keyword" placeholder="输入啤酒厂名称或关键词">
                            </div>
                            <button class="search-btn" id="search-submit">搜索啤酒厂</button>
                        </div>
                        
                      
                        <div class="query-form" id="country-form" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">选择国家</label>
                                <select class="form-select" id="country-select">
                                    <option value="">请选择国家</option>
                                    <option value="united_states">美国</option>
                                    <option value="canada">加拿大</option>
                                    <option value="united_kingdom">英国</option>
                                    <option value="germany">德国</option>
                                    <option value="france">法国</option>
                                    <option value="japan">日本</option>
                                    <option value="south_korea">韩国</option>
                                    <option value="australia">澳大利亚</option>
                                    <option value="china">中国</option>
                                </select>
                            </div>
                            <button class="search-btn" id="country-submit">查询啤酒厂</button>
                        </div>
                        
                       
                        <div class="query-form" id="city-form" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">城市名称</label>
                                <input type="text" class="form-input" id="city-name" placeholder="输入城市名称">
                            </div>
                            <button class="search-btn" id="city-submit">查询啤酒厂</button>
                        </div>
                        
                        
                        <div class="query-form" id="type-form" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">啤酒厂类型</label>
                                <select class="form-select" id="type-select">
                                    <option value="">请选择类型</option>
                                    <option value="micro">精酿啤酒厂</option>
                                    <option value="nano">小型啤酒厂</option>
                                    <option value="regional">区域分店</option>
                                    <option value="brewpub">啤酒餐厅/酒吧</option>
                                    <option value="planning">未开放/规划中的啤酒厂</option>
                                    <option value="contract">空壳啤酒厂</option>
                                    <option value="proprietor">合同啤酒厂</option>
                                </select>
                            </div>
                            <button class="search-btn" id="type-submit">查询啤酒厂</button>
                        </div>
                        
                        
                        <div class="query-form" id="random-form" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">随机数量</label>
                                <select class="form-select" id="random-count">
                                    <option value="1">1个</option>
                                    <option value="3">3个</option>
                                    <option value="5">5个</option>
                                    <option value="10">10个</option>
                                </select>
                            </div>
                            <button class="search-btn" id="random-submit">获取随机啤酒厂</button>
                        </div>
                    </div>
                    

                    <div class="detail-section" id="detail-section" style="display: none;">
                        <div class="detail-header">
                            <div class="detail-title" id="detail-name"></div>
                            <button class="close-detail-btn" id="close-detail-btn">✕</button>
                        </div>
                        <div class="detail-content" id="detail-content"></div>
                    </div>
                    

                    <div class="results-section" id="results-section" style="display: none;">
                        <div class="results-header">
                            <div class="results-title">搜索结果</div>
                            <div class="results-count" id="results-count">共 0 家啤酒厂</div>
                        </div>
                        

                        <div class="loading" id="loading">
                            <div class="loading-spinner"></div>
                            <div>正在查询啤酒厂，请稍候...</div>
                        </div>
                        

                        <div class="brewery-list" id="brewery-list"></div>
                        

                        <div class="empty-state" id="empty-results">
                            <div class="empty-icon">🍺</div>
                            <div>暂无搜索结果</div>
                            <div style="margin-top: 12px; font-size: 14px;">请尝试其他搜索条件</div>
                        </div>
                        

                        <div class="pagination" id="pagination"></div>
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
        
        class BeerQuery {
            constructor() {
                this.currentPage = 1;
                this.perPage = 12;
                this.totalResults = 0;
                this.breweries = [];
                this.currentTab = 'search';
                this.currentLanguage = 'zh'; // 默认中文
                this.init();
            }
            
            init() {
                this.bindEvents();
            }
            
            bindEvents() {
                
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        this.switchTab(btn.dataset.tab);
                    });
                });
                
               
                document.getElementById('language-select').addEventListener('change', (e) => {
                    this.currentLanguage = e.target.value;
                });
                
              
                document.getElementById('search-submit').addEventListener('click', () => {
                    this.searchBreweries();
                });
                
                
                document.getElementById('country-submit').addEventListener('click', () => {
                    this.searchByCountry();
                });
                
                
                document.getElementById('city-submit').addEventListener('click', () => {
                    this.searchByCity();
                });
                
               
                document.getElementById('type-submit').addEventListener('click', () => {
                    this.searchByType();
                });
                
                
                document.getElementById('random-submit').addEventListener('click', () => {
                    this.getRandomBreweries();
                });
                
                
                document.getElementById('close-detail-btn').addEventListener('click', () => {
                    this.closeDetail();
                });
                
                
                document.getElementById('search-keyword').addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        this.searchBreweries();
                    }
                });
                
                document.getElementById('city-name').addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        this.searchByCity();
                    }
                });
            }
            
            
            switchTab(tab) {
                this.currentTab = tab;
                

                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                document.querySelector(`[data-tab="${tab}"]`).classList.add('active');
                

                document.querySelectorAll('.query-form').forEach(form => {
                    form.style.display = 'none';
                });
                document.getElementById(`${tab}-form`).style.display = 'grid';
            }
            
            
            showLoading() {
                document.getElementById('loading').classList.add('visible');
                document.getElementById('brewery-list').innerHTML = '';
                document.getElementById('empty-results').style.display = 'none';
                document.getElementById('pagination').innerHTML = '';
            }
            
            
            hideLoading() {
                document.getElementById('loading').classList.remove('visible');
            }
            
            
            showError(message) {
                const errorEl = document.getElementById('error-message');
                errorEl.textContent = message;
                errorEl.classList.add('visible');
            }
            
            
            hideError() {
                document.getElementById('error-message').classList.remove('visible');
            }
            
            
            async searchBreweries() {
                const keyword = document.getElementById('search-keyword').value.trim();
                if (!keyword) {
                    this.showError('Please enter search keyword');
                    return;
                }
                
                this.hideError();
                this.showLoading();
                this.currentPage = 1;
                

                const startTime = Date.now();
                
                try {
                    const response = await fetch(`../php/beer-api-proxy.php?action=search&query=${encodeURIComponent(keyword)}&page=${this.currentPage}&per_page=${this.perPage}&target_lang=${this.currentLanguage}`);
                    
    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    const data = await response.json();
                    
                    if (data.code === 200) {
                        this.breweries = data.data;
                        this.totalResults = data.total || data.data.length;
                        this.renderBreweries();
                        this.renderPagination();
                        document.getElementById('results-section').style.display = 'block';
                        document.getElementById('results-count').textContent = `共 ${this.totalResults} 家啤酒厂`;
        
                        await recordToolUsage('beer-query', '关键词搜索', 'success', responseTime, keyword);
                    } else {
                        this.showError(data.msg || '搜索失败');
        
                        await recordToolUsage('beer-query', '关键词搜索', 'error', responseTime, `${keyword} - ${data.msg || '搜索失败'}`);
                    }
                } catch (error) {
                    this.showError(`搜索失败: ${error.message}`);
                    console.error('搜索啤酒厂失败:', error);
    
                    const responseTime = (Date.now() - startTime) / 1000;
    
                    await recordToolUsage('beer-query', '关键词搜索', 'error', responseTime, `${keyword} - ${error.message}`);
                } finally {
                    this.hideLoading();
                }
            }
            
            
            async searchByCountry() {
                const country = document.getElementById('country-select').value;
                if (!country) {
                    this.showError('Please select a country');
                    return;
                }
                
                this.hideError();
                this.showLoading();
                this.currentPage = 1;
                

                const startTime = Date.now();
                
                try {
                    const response = await fetch(`../php/beer-api-proxy.php?action=by_country&country=${country}&page=${this.currentPage}&per_page=${this.perPage}&target_lang=${this.currentLanguage}`);
                    
    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    const data = await response.json();
                    
                    if (data.code === 200) {
                        this.breweries = data.data;
                        this.totalResults = data.total || data.data.length;
                        this.renderBreweries();
                        this.renderPagination();
                        document.getElementById('results-section').style.display = 'block';
                        document.getElementById('results-count').textContent = `共 ${this.totalResults} 家啤酒厂`;
        
                        await recordToolUsage('beer-query', '按国家搜索', 'success', responseTime, country);
                    } else {
                        this.showError(data.msg || '查询失败');
        
                        await recordToolUsage('beer-query', '按国家搜索', 'error', responseTime, `${country} - ${data.msg || '查询失败'}`);
                    }
                } catch (error) {
                    this.showError(`查询失败: ${error.message}`);
                    console.error('按国家查询啤酒厂失败:', error);
    
                    const responseTime = (Date.now() - startTime) / 1000;
    
                    await recordToolUsage('beer-query', '按国家搜索', 'error', responseTime, `${country} - ${error.message}`);
                } finally {
                    this.hideLoading();
                }
            }
            
            
            async searchByCity() {
                const city = document.getElementById('city-name').value.trim();
                if (!city) {
                    this.showError('Please enter city name');
                    return;
                }
                
                this.hideError();
                this.showLoading();
                this.currentPage = 1;
                

                const startTime = Date.now();
                
                try {
                    const response = await fetch(`../php/beer-api-proxy.php?action=by_city&city=${encodeURIComponent(city)}&page=${this.currentPage}&per_page=${this.perPage}&target_lang=${this.currentLanguage}`);
                    
    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    const data = await response.json();
                    
                    if (data.code === 200) {
                        this.breweries = data.data;
                        this.totalResults = data.total || data.data.length;
                        this.renderBreweries();
                        this.renderPagination();
                        document.getElementById('results-section').style.display = 'block';
                        document.getElementById('results-count').textContent = `共 ${this.totalResults} 家啤酒厂`;
        
                        await recordToolUsage('beer-query', '按城市搜索', 'success', responseTime, city);
                    } else {
                        this.showError(data.msg || '查询失败');
        
                        await recordToolUsage('beer-query', '按城市搜索', 'error', responseTime, `${city} - ${data.msg || '查询失败'}`);
                    }
                } catch (error) {
                    this.showError(`查询失败: ${error.message}`);
                    console.error('按城市查询啤酒厂失败:', error);
    
                    const responseTime = (Date.now() - startTime) / 1000;
    
                    await recordToolUsage('beer-query', '按城市搜索', 'error', responseTime, `${city} - ${error.message}`);
                } finally {
                    this.hideLoading();
                }
            }
            
            
            async searchByType() {
                const type = document.getElementById('type-select').value;
                if (!type) {
                    this.showError('Please select brewery type');
                    return;
                }
                
                this.hideError();
                this.showLoading();
                this.currentPage = 1;
                

                const startTime = Date.now();
                
                try {
                    const response = await fetch(`../php/beer-api-proxy.php?action=by_type&type=${type}&page=${this.currentPage}&per_page=${this.perPage}&target_lang=${this.currentLanguage}`);
                    
    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    const data = await response.json();
                    
                    if (data.code === 200) {
                        this.breweries = data.data;
                        this.totalResults = data.total || data.data.length;
                        this.renderBreweries();
                        this.renderPagination();
                        document.getElementById('results-section').style.display = 'block';
                        document.getElementById('results-count').textContent = `共 ${this.totalResults} 家啤酒厂`;
        
                        await recordToolUsage('beer-query', '按类型搜索', 'success', responseTime, type);
                    } else {
                        this.showError(data.msg || '查询失败');
        
                        await recordToolUsage('beer-query', '按类型搜索', 'error', responseTime, `${type} - ${data.msg || '查询失败'}`);
                    }
                } catch (error) {
                    this.showError(`查询失败: ${error.message}`);
                    console.error('按类型查询啤酒厂失败:', error);
    
                    const responseTime = (Date.now() - startTime) / 1000;
    
                    await recordToolUsage('beer-query', '按类型搜索', 'error', responseTime, `${type} - ${error.message}`);
                } finally {
                    this.hideLoading();
                }
            }
            
            
            async getRandomBreweries() {
                const count = document.getElementById('random-count').value;
                
                this.hideError();
                this.showLoading();
                

                const startTime = Date.now();
                
                try {
                    const response = await fetch(`../php/beer-api-proxy.php?action=random&count=${count}&target_lang=${this.currentLanguage}`);
                    
    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    const data = await response.json();
                    
                    if (data.code === 200) {
                        this.breweries = data.data;
                        this.totalResults = data.data.length;
                        this.renderBreweries();
                        document.getElementById('pagination').innerHTML = '';
                        document.getElementById('results-section').style.display = 'block';
                        document.getElementById('results-count').textContent = `共 ${this.totalResults} 家啤酒厂`;
        
                        await recordToolUsage('beer-query', '获取随机啤酒厂', 'success', responseTime, count);
                    } else {
                        this.showError(data.msg || '获取失败');
        
                        await recordToolUsage('beer-query', '获取随机啤酒厂', 'error', responseTime, `${count} - ${data.msg || '获取失败'}`);
                    }
                } catch (error) {
                    this.showError(`获取失败: ${error.message}`);
                    console.error('获取随机啤酒厂失败:', error);
    
                    const responseTime = (Date.now() - startTime) / 1000;
    
                    await recordToolUsage('beer-query', '获取随机啤酒厂', 'error', responseTime, `${count} - ${error.message}`);
                } finally {
                    this.hideLoading();
                }
            }
            
            
            renderBreweries() {
                const breweryList = document.getElementById('brewery-list');
                
                if (this.breweries.length === 0) {
                    breweryList.innerHTML = '';
                    document.getElementById('empty-results').style.display = 'block';
                    return;
                }
                
                document.getElementById('empty-results').style.display = 'none';
                
                breweryList.innerHTML = this.breweries.map(brewery => {
                    return `
                        <div class="brewery-card" data-id="${brewery.id}">
                            <div class="brewery-name">${brewery.name}</div>
                            <div class="brewery-type">${this.getBreweryTypeLabel(brewery.brewery_type)}</div>
                            <div class="brewery-info">
                                <div><i>📍</i>${brewery.city}, ${brewery.state_province}, ${brewery.country}</div>
                                ${brewery.address_1 ? `<div><i>🏠</i>${brewery.address_1}</div>` : ''}
                                ${brewery.phone ? `<div><i>📞</i>${brewery.phone}</div>` : ''}
                                ${brewery.website_url ? `<div><i>🌐</i>${brewery.website_url}</div>` : ''}
                            </div>
                        </div>
                    `;
                }).join('');
                
                
                breweryList.querySelectorAll('.brewery-card').forEach(card => {
                    card.addEventListener('click', () => {
                        const id = card.dataset.id;
                        const brewery = this.breweries.find(b => b.id === id);
                        if (brewery) {
                            this.showBreweryDetail(brewery);
                        }
                    });
                });
            }
            
            
            getBreweryTypeLabel(type) {
                const typeMap = {
                    'micro': '精酿啤酒厂',
                    'nano': '小型啤酒厂',
                    'regional': '区域分店',
                    'brewpub': '啤酒餐厅/酒吧',
                    'large': '大型啤酒厂',
                    'planning': '未开放/规划中的啤酒厂',
                    'contract': '空壳啤酒厂',
                    'proprietor': '合同啤酒厂',
                    'closed': '已关闭'
                };
                return typeMap[type] || type;
            }
            
            
            showBreweryDetail(brewery) {
                document.getElementById('detail-name').textContent = brewery.name;
                
                const detailContent = `
                    <div class="detail-item">
                        <div class="detail-item-label">啤酒厂类型</div>
                        <div class="detail-item-value">${this.getBreweryTypeLabel(brewery.brewery_type)}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item-label">国家</div>
                        <div class="detail-item-value">${brewery.country}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item-label">地区</div>
                        <div class="detail-item-value">${brewery.state_province}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item-label">城市</div>
                        <div class="detail-item-value">${brewery.city}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item-label">地址</div>
                        <div class="detail-item-value">${brewery.address_1 || '暂无'}</div>
                    </div>
                    ${brewery.address_2 ? `
                    <div class="detail-item">
                        <div class="detail-item-label">地址2</div>
                        <div class="detail-item-value">${brewery.address_2}</div>
                    </div>` : ''}
                    <div class="detail-item">
                        <div class="detail-item-label">邮政编码</div>
                        <div class="detail-item-value">${brewery.postal_code || '暂无'}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item-label">联系电话</div>
                        <div class="detail-item-value">${brewery.phone || '暂无'}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item-label">网站</div>
                        <div class="detail-item-value">${brewery.website_url ? `<a href="${brewery.website_url}" target="_blank">${brewery.website_url}</a>` : '暂无'}</div>
                    </div>
                    ${brewery.latitude && brewery.longitude ? `
                    <div class="detail-item">
                        <div class="detail-item-label">坐标</div>
                        <div class="detail-item-value">${brewery.latitude}, ${brewery.longitude}</div>
                    </div>` : ''}
                `;
                
                document.getElementById('detail-content').innerHTML = detailContent;
                document.getElementById('detail-section').style.display = 'block';
                

                document.getElementById('detail-section').scrollIntoView({ behavior: 'smooth' });
            }
            
            
            closeDetail() {
                document.getElementById('detail-section').style.display = 'none';
            }
            
            
            renderPagination() {
                const totalPages = Math.ceil(this.totalResults / this.perPage);
                const pagination = document.getElementById('pagination');
                
                if (totalPages <= 1) {
                    pagination.innerHTML = '';
                    return;
                }
                
                let html = '';
                
                
                html += `<button class="page-btn" id="prev-btn" ${this.currentPage === 1 ? 'disabled' : ''}>上一页</button>`;
                
                
                for (let i = 1; i <= totalPages; i++) {
                    if (i <= 3 || i >= totalPages - 2 || (i >= this.currentPage - 1 && i <= this.currentPage + 1)) {
                        html += `<button class="page-btn ${i === this.currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
                    } else if (i === 4 || i === totalPages - 3) {
                        html += `<span class="page-ellipsis">...</span>`;
                    }
                }
                
                
                html += `<button class="page-btn" id="next-btn" ${this.currentPage === totalPages ? 'disabled' : ''}>下一页</button>`;
                
                pagination.innerHTML = html;
                
                
                pagination.querySelectorAll('.page-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const page = parseInt(btn.dataset.page) || (btn.id === 'prev-btn' ? this.currentPage - 1 : this.currentPage + 1);
                        this.currentPage = page;
                        this.loadPage(page);
                    });
                });
            }
            
            
            async loadPage(page) {
                this.currentPage = page;
                this.showLoading();
                

                const startTime = Date.now();
                
                try {
                    let url = '';
                    let action = '';
                    let content = '';
                    
                    
                    switch (this.currentTab) {
                        case 'search':
                            const keyword = document.getElementById('search-keyword').value.trim();
                            url = `../php/beer-api-proxy.php?action=search&query=${encodeURIComponent(keyword)}&page=${page}&per_page=${this.perPage}&target_lang=${this.currentLanguage}`;
                            action = '关键词搜索(分页)';
                            content = `${keyword} - 第${page}页`;
                            break;
                        case 'country':
                            const country = document.getElementById('country-select').value;
                            url = `../php/beer-api-proxy.php?action=by_country&country=${country}&page=${page}&per_page=${this.perPage}&target_lang=${this.currentLanguage}`;
                            action = '按国家搜索(分页)';
                            content = `${country} - 第${page}页`;
                            break;
                        case 'city':
                            const city = document.getElementById('city-name').value.trim();
                            url = `../php/beer-api-proxy.php?action=by_city&city=${encodeURIComponent(city)}&page=${page}&per_page=${this.perPage}&target_lang=${this.currentLanguage}`;
                            action = '按城市搜索(分页)';
                            content = `${city} - 第${page}页`;
                            break;
                        case 'type':
                            const type = document.getElementById('type-select').value;
                            url = `../php/beer-api-proxy.php?action=by_type&type=${type}&page=${page}&per_page=${this.perPage}&target_lang=${this.currentLanguage}`;
                            action = '按类型搜索(分页)';
                            content = `${type} - 第${page}页`;
                            break;
                    }
                    
                    const response = await fetch(url);
                    
    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    const data = await response.json();
                    
                    if (data.code === 200) {
                        this.breweries = data.data;
                        this.renderBreweries();
                        this.renderPagination();
        
                        await recordToolUsage('beer-query', action, 'success', responseTime, content);
                    } else {
                        this.showError(data.msg || '加载失败');
        
                        await recordToolUsage('beer-query', action, 'error', responseTime, `${content} - ${data.msg || '加载失败'}`);
                    }
                } catch (error) {
                    this.showError(`加载失败: ${error.message}`);
                    console.error('加载页面失败:', error);
    
                    const responseTime = (Date.now() - startTime) / 1000;
    
                    await recordToolUsage('beer-query', '分页加载', 'error', responseTime, `第${page}页 - ${error.message}`);
                } finally {
                    this.hideLoading();
                }
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new BeerQuery();
        });
    </script>
</body>
</html>