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
    <title>万能搜索引擎 - <?php echo $siteConfig['name']; ?></title>
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
        

        .search-section {
            margin-bottom: 30px;
        }
        
        .search-form {
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
        

        .results-stats {
            margin-bottom: 20px;
            font-size: 14px;
            color: #666;
        }
        

        .results-list {
            list-style: none;
            padding: 0;
            margin: 0 0 30px 0;
        }
        
        .result-item {
            background-color: #fafafa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .result-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .result-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
            text-decoration: none;
        }
        
        .result-title:hover {
            text-decoration: underline;
        }
        
        .result-url {
            font-size: 14px;
            color: #006621;
            margin-bottom: 8px;
            text-decoration: none;
        }
        
        .result-url:hover {
            text-decoration: underline;
        }
        
        .result-cache {
            font-size: 12px;
            color: #666;
            margin-left: 12px;
            text-decoration: none;
        }
        
        .result-cache:hover {
            text-decoration: underline;
        }
        
        .result-abstract {
            font-size: 14px;
            color: #333;
            line-height: 1.6;
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
            border-radius: 6px;
            background-color: #fff;
            color: #333;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .page-btn:hover:not(:disabled) {
            background-color: #f0f0f0;
        }
        
        .page-btn.active {
            background-color: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
        }
        
        .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
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
            
            .search-form {
                flex-direction: column;
                align-items: stretch;
            }
            
            .form-group {
                min-width: auto;
            }
            
            .result-item {
                padding: 16px;
            }
            
            .result-title {
                font-size: 15px;
            }
            
            .result-url {
                font-size: 13px;
            }
            
            .result-abstract {
                font-size: 13px;
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
                    <h2>万能搜索引擎</h2>
                    <p>通过内部搜索引擎接口返回搜索结果，支持分页查询</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">

                    <div class="error-message" id="error-message"></div>
                    

                    <div class="empty-state" id="empty-state">
                        <div class="empty-icon">🔍</div>
                        <div>请输入搜索内容，使用万能搜索引擎获取结果</div>
                    </div>
                    

                    <div class="search-section">
                        <form class="search-form" id="search-form">
                            <div class="form-group">
                                <label class="form-label" for="search">搜索内容</label>
                                <input type="text" id="search" class="form-input" placeholder="请输入搜索内容，如：PearNo" required>
                            </div>
                            <button type="submit" class="btn" id="search-btn">
                                <span class="loading-icon" style="display: none;">🔄</span>
                                <span>搜索</span>
                            </button>
                        </form>
                    </div>
                    

                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div>正在搜索内容，请稍候...</div>
                    </div>
                    

                    <div class="results-stats" id="results-stats" style="display: none;"></div>
                    

                    <ul class="results-list" id="results-list"></ul>
                    

                    <div class="pagination" id="pagination" style="display: none;"></div>
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
                        tool_id: 'universal-search',
                        action: action,
                        content: content,
                        result: {
                            status: status
                        },
                        response_time: responseTime
                    })
                });
            } catch (error) {
                console.error('Failed to record tool usage:', error);
            }
        }
        
        class UniversalSearch {
            constructor() {
                this.init();
                this.currentPage = 1;
                this.currentSearch = '';
            }
            
            init() {
                this.bindEvents();
            }
            
            bindEvents() {
                const searchForm = document.getElementById('search-form');
                searchForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.search();
                });
            }
            
            async search() {
                const search = document.getElementById('search').value.trim();
                this.currentSearch = search;
                this.currentPage = 1;
                await this.getData(search, this.currentPage);
            }
            
            async getData(search, page) {
                this.showLoading();
                this.hideError();
                this.hideEmptyState();
                this.hideResults();
                this.hidePagination();
                this.disableSearchBtn();
                
                const startTime = Date.now();
                
                try {

                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 30000);
                    

                    const requestUrl = `../php/universal-search-proxy.php?search=${encodeURIComponent(search)}&page=${page}`;
                    
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
                        this.displayResults(data);
                        await recordToolUsage('search', 'success', { 
                            api_code: data.code, 
                            search_term: search, 
                            page: page, 
                            result_count: data.data ? data.data.length : 0 
                        }, responseTime);
                    } else {

                        let errorMsg = data.msg || '搜索失败';
                        this.showError(errorMsg);
                        this.showEmptyState();
                        await recordToolUsage('search', 'error', { 
                            api_code: data.code || 500, 
                            search_term: search, 
                            page: page, 
                            error_msg: errorMsg 
                        }, responseTime);
                    }
                } catch (error) {
                    const responseTime = (Date.now() - startTime) / 1000;
                    let errorMsg = `搜索失败: ${error.message}`;
                    if (error.name === 'AbortError') {
                        errorMsg = '搜索超时，请稍后重试';
                    }
                    this.showError(errorMsg);
                    this.showEmptyState();
                    console.error('API请求错误:', error);
                    await recordToolUsage('search', 'error', { 
                        exception: error.message,
                        search_term: search,
                        page: page,
                        error_msg: errorMsg
                    }, responseTime);
                } finally {
                    this.hideLoading();
                    this.enableSearchBtn();
                }
            }
            
            displayResults(data) {

                this.currentPage = data.page || 1;
                

                const resultsStats = document.getElementById('results-stats');
                resultsStats.textContent = `搜索结果: "${data.search}" (第 ${data.page} 页)`;
                resultsStats.style.display = 'block';
                

                const resultsList = document.getElementById('results-list');
                resultsList.innerHTML = '';
                
                if (data.data && data.data.length > 0) {

                    data.data.forEach((item, index) => {
                        const listItem = this.createResultItem(item);
                        resultsList.appendChild(listItem);
                    });
                    

                    this.showPagination();
                    this.renderPagination();
                } else {

                    this.showEmptyState();
                    resultsStats.style.display = 'none';
                }
            }
            
            createResultItem(item) {
                const listItem = document.createElement('li');
                listItem.className = 'result-item';
                
                listItem.innerHTML = `
                    <h3 class="result-title"><a href="${this.escapeHtml(item.href)}" target="_blank" rel="noopener noreferrer">${this.escapeHtml(item.title)}</a></h3>
                    <div class="result-url">
                        <a href="${this.escapeHtml(item.href)}" target="_blank" rel="noopener noreferrer">${this.escapeHtml(item.href)}</a>
                        ${item.cache_link ? `<a href="${this.escapeHtml(item.cache_link)}" class="result-cache" target="_blank" rel="noopener noreferrer">快照</a>` : ''}
                    </div>
                    <div class="result-abstract">${this.escapeHtml(item.abstract || '')}</div>
                `;
                
                return listItem;
            }
            
            renderPagination() {
                const pagination = document.getElementById('pagination');
                pagination.innerHTML = '';
                

                const prevBtn = document.createElement('button');
                prevBtn.className = 'page-btn';
                prevBtn.textContent = '上一页';
                prevBtn.disabled = this.currentPage === 1;
                prevBtn.addEventListener('click', () => {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                        this.getData(this.currentSearch, this.currentPage);
                    }
                });
                pagination.appendChild(prevBtn);
                

                const currentBtn = document.createElement('button');
                currentBtn.className = 'page-btn active';
                currentBtn.textContent = this.currentPage;
                currentBtn.disabled = true;
                pagination.appendChild(currentBtn);
                

                const nextBtn = document.createElement('button');
                nextBtn.className = 'page-btn';
                nextBtn.textContent = '下一页';
                nextBtn.addEventListener('click', () => {
                    this.currentPage++;
                    this.getData(this.currentSearch, this.currentPage);
                });
                pagination.appendChild(nextBtn);
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
                document.getElementById('results-stats').style.display = 'block';
                document.getElementById('results-list').style.display = 'block';
            }
            
            hideResults() {
                document.getElementById('results-stats').style.display = 'none';
                document.getElementById('results-list').innerHTML = '';
            }
            
            showPagination() {
                document.getElementById('pagination').style.display = 'flex';
            }
            
            hidePagination() {
                document.getElementById('pagination').style.display = 'none';
            }
            
            showEmptyState() {
                document.getElementById('empty-state').classList.remove('hidden');
            }
            
            hideEmptyState() {
                document.getElementById('empty-state').classList.add('hidden');
            }
            
            disableSearchBtn() {
                const searchBtn = document.getElementById('search-btn');
                searchBtn.disabled = true;
                searchBtn.querySelector('.loading-icon').style.display = 'inline-block';
                searchBtn.querySelector('span:last-child').textContent = '搜索中...';
            }
            
            enableSearchBtn() {
                const searchBtn = document.getElementById('search-btn');
                searchBtn.disabled = false;
                searchBtn.querySelector('.loading-icon').style.display = 'none';
                searchBtn.querySelector('span:last-child').textContent = '搜索';
            }
            
            escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new UniversalSearch();
        });
    </script>
</body>
</html>