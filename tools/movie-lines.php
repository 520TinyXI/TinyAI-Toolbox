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
    <title>影视台词搜寻 - <?php echo $siteConfig['name']; ?></title>
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
        
        .results-summary {
            font-size: 14px;
            color: #666;
        }
        
        .results-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .result-card {
            background-color: #fafafa;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        
        .result-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .result-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .result-content {
            padding: 16px;
        }
        
        .result-title {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .result-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 12px;
            font-size: 12px;
            color: #666;
        }
        
        .result-meta span {
            background-color: #e0e0e0;
            padding: 2px 8px;
            border-radius: 12px;
        }
        
        .result-line {
            font-size: 14px;
            color: #333;
            margin-bottom: 12px;
            padding: 8px;
            background-color: #fff;
            border-left: 3px solid #1a1a1a;
        }
        
        .result-all-lines {
            font-size: 13px;
            color: #666;
            max-height: 100px;
            overflow-y: auto;
        }
        
        .result-all-lines ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .result-all-lines li {
            margin-bottom: 4px;
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
        
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 30px;
        }
        
        .pagination-btn {
            padding: 8px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            background-color: #fff;
            color: #1a1a1a;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .pagination-btn:hover {
            background-color: #f0f0f0;
        }
        
        .pagination-btn.active {
            background-color: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
        }
        
        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
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
            
            .results-list {
                grid-template-columns: 1fr;
            }
            
            .results-header {
                flex-direction: column;
                align-items: flex-start;
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
                    <h2>影视台词搜寻</h2>
                    <p>通过台词搜寻存在的电影，获取电影信息和相关台词</p>
                </div>
            </header>
            
            <div class="tool-container">
                <!-- 工具内容 -->
                <div class="tool-content">
                    <!-- 错误信息 -->
                    <div class="error-message" id="error-message"></div>
                    
                    <!-- 空状态 -->
                    <div class="empty-state" id="empty-state">
                        <div class="empty-icon">🎬</div>
                        <div>请输入影视台词开始搜寻</div>
                    </div>
                    
                    <!-- 查询区域 -->
                    <div class="query-section">
                        <form class="query-form" id="query-form">
                            <div class="form-group">
                                <label class="form-label" for="word">影视台词</label>
                                <input type="text" id="word" class="form-input" placeholder="请输入影视台词，如：你还爱我吗" required>
                            </div>
                            <button type="submit" class="btn" id="query-btn">
                                <span class="loading-icon" style="display: none;">🔄</span>
                                <span>搜寻影视</span>
                            </button>
                        </form>
                    </div>
                    
                    <!-- 加载状态 -->
                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div>正在搜寻影视，请稍候...</div>
                    </div>
                    
                    <!-- 结果区域 -->
                    <div class="results-section" id="results-section">
                        <!-- 结果头部 -->
                        <div class="results-header">
                            <h3 class="results-title">搜寻结果</h3>
                            <div class="results-summary" id="results-summary"></div>
                        </div>
                        
                        <!-- 结果列表 -->
                        <div class="results-list" id="results-list"></div>
                        
                        <!-- 分页 -->
                        <div class="pagination" id="pagination"></div>
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
                        tool_id: 'movie-lines',
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

        class MovieLinesSearch {
            constructor() {
                this.currentPage = 1;
                this.lastPage = 1;
                this.currentWord = '';
                this.init();
            }
            
            init() {
                this.bindEvents();
            }
            
            bindEvents() {
                const queryForm = document.getElementById('query-form');
                queryForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.currentPage = 1;
                    this.searchLines();
                });
            }
            
            async searchLines() {
                const word = document.getElementById('word').value.trim();
                this.currentWord = word;
                
                this.showLoading();
                this.hideError();
                this.hideResults();
                this.hideEmptyState();
                this.disableQueryBtn();
                
                const startTime = Date.now();
                let finalStatus = 'success';
                let error = null;
                
                const maxRetries = 2;
                let retryCount = 0;
                let success = false;
                
                while (retryCount <= maxRetries && !success) {
                    try {
                        const controller = new AbortController();
                        const timeoutId = setTimeout(() => controller.abort(), 60000);
                        
                        const response = await fetch(`../php/movie-lines-proxy.php?word=${encodeURIComponent(word)}&page=${this.currentPage}`, {
                            method: 'GET',
                            signal: controller.signal,
                            headers: {
                                'Accept': 'application/json',
                                'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
                            }
                        });
                        
                        clearTimeout(timeoutId);
                        
                        const responseText = await response.text();
                        
                        if (!response.ok) {
                            throw new Error(`HTTP错误! 状态码: ${response.status}`);
                        }
                        
                        let data;
                        try {
                            data = JSON.parse(responseText);
                        } catch (jsonError) {
                            throw new Error(`JSON解析失败: ${jsonError.message}`);
                        }
                        
                        if (data.code === 200) {
                            this.displayResults(data);
                            success = true;
                        } else {
                            let errorMsg = data.msg || '搜寻失败';
                            console.log('API响应:', data);
                            
                            this.showError(errorMsg);
                            finalStatus = 'error';
                            error = new Error(errorMsg);
                            success = true;
                        }
                    } catch (err) {
                        error = err;
                        retryCount++;
                        
                        if (retryCount > maxRetries) {
                            let errorMsg = `搜寻失败: ${error.message}`;
                            if (error.name === 'AbortError') {
                                errorMsg = `搜寻超时，请稍后重试\n\n(已尝试 ${maxRetries + 1} 次)`;
                            } else {
                                errorMsg = `搜寻失败: ${error.message}\n\n(已尝试 ${maxRetries + 1} 次)`;
                            }
                            this.showError(errorMsg);
                            console.error('API请求错误:', error);
                            finalStatus = 'error';
                        } else {
                            await new Promise(resolve => setTimeout(resolve, 1000));
                        }
                    }
                }
                
                const responseTime = (Date.now() - startTime) / 1000;
                
                if (finalStatus === 'success') {
                    await recordToolUsage('search_lines', finalStatus, {
                        search_word: this.currentWord,
                        page: this.currentPage,
                        retry_count: retryCount
                    }, responseTime);
                } else {
                    await recordToolUsage('search_lines', finalStatus, {
                        search_word: this.currentWord,
                        page: this.currentPage,
                        retry_count: retryCount,
                        error_message: error?.message || '未知错误'
                    }, responseTime);
                }
                
                this.hideLoading();
                this.enableQueryBtn();
            }
            
            displayResults(data) {
                this.lastPage = parseInt(data.last_page) || 1;
                
                const resultsSection = document.getElementById('results-section');
                resultsSection.classList.add('visible');
                
                const resultsSummary = document.getElementById('results-summary');
                resultsSummary.textContent = `共找到 ${data.count} 部影视，当前第 ${data.now_page} 页，共 ${data.last_page} 页`;
                
                const resultsList = document.getElementById('results-list');
                
                if (data.data && data.data.length > 0) {
                    resultsList.innerHTML = data.data.map(item => `
                        <div class="result-card">
                            <img src="${item.local_img || 'https://via.placeholder.com/350x200?text=No+Image'}" alt="${item.title}" class="result-image">
                            <div class="result-content">
                                <h4 class="result-title">${item.title}</h4>
                                <div class="result-meta">
                                    ${item.area ? `<span>${item.area}</span>` : ''}
                                    ${item.tags ? `<span>${item.tags}</span>` : ''}
                                    ${item.directors ? `<span>${item.directors}</span>` : ''}
                                </div>
                                <div class="result-line">
                                    <strong>台词：</strong>${item.zh_word || ''}
                                </div>
                                ${item.all_zh_word && item.all_zh_word.length > 0 ? `
                                    <div class="result-all-lines">
                                        <strong>更多台词：</strong>
                                        <ul>
                                            ${item.all_zh_word.slice(0, 5).map(line => `<li>${line}</li>`).join('')}
                                            ${item.all_zh_word.length > 5 ? `<li>...</li>` : ''}
                                        </ul>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    `).join('');
                    
                    this.renderPagination();
                } else {
                    resultsList.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-icon">🔍</div>
                            <div>未找到相关影视</div>
                        </div>
                    `;
                    document.getElementById('pagination').innerHTML = '';
                }
            }
            
            renderPagination() {
                const pagination = document.getElementById('pagination');
                
                if (this.lastPage <= 1) {
                    pagination.innerHTML = '';
                    return;
                }
                
                let paginationHTML = '';
                
                paginationHTML += `<button class="pagination-btn" id="prev-btn" ${this.currentPage === 1 ? 'disabled' : ''}>
                    上一页
                </button>`;
                
                const startPage = Math.max(1, this.currentPage - 2);
                const endPage = Math.min(this.lastPage, startPage + 4);
                
                if (startPage > 1) {
                    paginationHTML += `<button class="pagination-btn" onclick="movieLinesSearch.goToPage(1)">1</button>`;
                    if (startPage > 2) {
                        paginationHTML += `<span>...</span>`;
                    }
                }
                
                for (let i = startPage; i <= endPage; i++) {
                    paginationHTML += `<button class="pagination-btn ${i === this.currentPage ? 'active' : ''}" onclick="movieLinesSearch.goToPage(${i})">
                        ${i}
                    </button>`;
                }
                
                if (endPage < this.lastPage) {
                    if (endPage < this.lastPage - 1) {
                        paginationHTML += `<span>...</span>`;
                    }
                    paginationHTML += `<button class="pagination-btn" onclick="movieLinesSearch.goToPage(${this.lastPage})">
                        ${this.lastPage}
                    </button>`;
                }
                
                paginationHTML += `<button class="pagination-btn" id="next-btn" ${this.currentPage === this.lastPage ? 'disabled' : ''}>
                    下一页
                </button>`;
                
                pagination.innerHTML = paginationHTML;
                
                document.getElementById('prev-btn')?.addEventListener('click', () => {
                    this.goToPage(this.currentPage - 1);
                });
                
                document.getElementById('next-btn')?.addEventListener('click', () => {
                    this.goToPage(this.currentPage + 1);
                });
            }
            
            goToPage(page) {
                if (page < 1 || page > this.lastPage) {
                    return;
                }
                
                this.currentPage = page;
                this.searchLines();
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
                queryBtn.querySelector('span:last-child').textContent = '搜寻中...';
            }
            
            enableQueryBtn() {
                const queryBtn = document.getElementById('query-btn');
                queryBtn.disabled = false;
                queryBtn.querySelector('.loading-icon').style.display = 'none';
                queryBtn.querySelector('span:last-child').textContent = '搜寻影视';
            }
        }
        
        let movieLinesSearch;
        document.addEventListener('DOMContentLoaded', () => {
            movieLinesSearch = new MovieLinesSearch();
        });
    </script>
</body>
</html>