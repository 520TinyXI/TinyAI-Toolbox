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
    <title>猫眼电影实时票房排行 - <?php echo $siteConfig['name']; ?></title>
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
        
        .data-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .data-info {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            font-size: 14px;
            color: #666;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .refresh-btn {
            background-color: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .refresh-btn:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .refresh-btn:active {
            transform: translateY(0);
        }
        
        .refresh-btn.loading {
            cursor: not-allowed;
            opacity: 0.7;
        }
        
        .refresh-btn.loading .refresh-icon {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            background-color: #fff;
        }
        
        .box-office-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            min-width: 1000px;
        }
        
        .box-office-table thead {
            background-color: #fafafa;
            border-bottom: 2px solid #e0e0e0;
        }
        
        .box-office-table th {
            padding: 16px;
            text-align: left;
            font-weight: 700;
            color: #1a1a1a;
            border-bottom: 1px solid #e0e0e0;
            white-space: nowrap;
        }
        
        .box-office-table th:first-child {
            border-top-left-radius: 8px;
        }
        
        .box-office-table th:last-child {
            border-top-right-radius: 8px;
        }
        
        .box-office-table td {
            padding: 16px;
            border-bottom: 1px solid #f0f0f0;
            color: #1a1a1a;
            vertical-align: top;
        }
        
        .box-office-table tbody tr {
            transition: all 0.2s ease;
        }
        
        .box-office-table tbody tr:hover {
            background-color: #fafafa;
        }
        
        .box-office-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .rank-number {
            font-weight: 700;
            color: #1a1a1a;
            min-width: 40px;
        }
        
        .movie-name {
            font-weight: 600;
            color: #1a1a1a;
            min-width: 180px;
        }
        
        .box-office-data {
            font-family: 'Courier New', Courier, monospace;
            font-weight: 600;
        }
        
        .highlight {
            color: #d32f2f;
            font-weight: 700;
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 60px 20px;
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
        
        .loading-text {
            font-size: 16px;
            color: #666;
        }
        
        .error-message {
            display: none;
            background-color: #fff5f5;
            border: 1px solid #ffcccc;
            border-radius: 8px;
            padding: 16px;
            color: #d32f2f;
            margin-bottom: 20px;
        }
        
        .error-message.visible {
            display: block;
        }
        
        .empty-state {
            display: none;
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        
        .empty-state.visible {
            display: block;
        }
        
        .empty-icon {
            font-size: 64px;
            margin-bottom: 16px;
        }
        
        .empty-text {
            font-size: 16px;
        }
        
        .data-stats {
            margin-top: 20px;
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        
        .stat-item {
            text-align: center;
            padding: 16px;
            min-width: 120px;
        }
        
        .stat-label {
            font-size: 14px;
            color: #999;
            margin-bottom: 8px;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        @media (max-width: 768px) {
            .tool-container {
                padding: 20px 16px;
            }
            
            .tool-content {
                padding: 20px;
            }
            
            .data-header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .data-info {
                gap: 12px;
            }
            
            .box-office-table {
                font-size: 12px;
                min-width: 800px;
            }
            
            .box-office-table th,
            .box-office-table td {
                padding: 12px 8px;
            }
            
            .data-stats {
                gap: 16px;
                padding: 16px;
            }
            
            .stat-item {
                min-width: 100px;
                padding: 12px;
            }
            
            .stat-value {
                font-size: 20px;
            }
        }
        
        @media (max-width: 480px) {
            .box-office-table {
                min-width: 600px;
            }
            
            .data-info {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .data-stats {
                flex-direction: column;
                align-items: center;
            }
            
            .stat-item {
                min-width: auto;
                width: 100%;
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
                    <h2>猫眼电影实时票房排行</h2>
                    <p>获取最新猫眼电影实时票房名单，包括电影名称、票房、排片率等信息</p>
                </div>
            </header>

            <!-- 工具容器 -->
            <div class="tool-container">
                <!-- 工具内容 -->
                <div class="tool-content">
                    <!-- 错误信息 -->
                    <div class="error-message" id="error-message"></div>
                    
                    <!-- 数据头部 -->
                    <div class="data-header" id="data-header" style="display: none;">
                        <div class="data-info">
                            <div class="info-item">
                                <span class="info-label">更新时间:</span>
                                <span class="info-value" id="update-time"></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">电影数量:</span>
                                <span class="info-value" id="movie-count"></span>
                            </div>
                        </div>
                        <button class="refresh-btn" id="refresh-btn">
                            <span class="refresh-icon">🔄</span>
                            <span>刷新数据</span>
                        </button>
                    </div>
                    
                    <!-- 加载状态 -->
                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div class="loading-text">正在获取票房数据，请稍候...</div>
                    </div>
                    
                    <!-- 空状态 -->
                    <div class="empty-state" id="empty-state">
                        <div class="empty-icon">🎬</div>
                        <div class="empty-text">暂无票房数据</div>
                    </div>
                    
                    <!-- 表格容器 -->
                    <div class="table-container" id="table-container" style="display: none;">
                        <table class="box-office-table">
                            <thead>
                                <tr>
                                    <th>排名</th>
                                    <th>电影名称</th>
                                    <th>上映天数</th>
                                    <th>总票房</th>
                                    <th>票房占比</th>
                                    <th>排场次数</th>
                                    <th>排片占比</th>
                                    <th>场均人次</th>
                                    <th>上座率</th>
                                </tr>
                            </thead>
                            <tbody id="table-body"></tbody>
                        </table>
                    </div>
                    
                    <!-- 数据统计 -->
                    <div class="data-stats" id="data-stats" style="display: none;">
                        <div class="stat-item">
                            <div class="stat-label">总电影数</div>
                            <div class="stat-value" id="total-movies"></div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">票房冠军</div>
                            <div class="stat-value" id="box-office-champion"></div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">平均票房</div>
                            <div class="stat-value" id="avg-box-office"></div>
                        </div>
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
                    tool_id: 'movie-box-office',
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

        class MovieBoxOffice {
            constructor() {
                this.init();
            }
            
            init() {
                this.bindEvents();
                this.fetchBoxOfficeData();
            }
            
            bindEvents() {
                const refreshBtn = document.getElementById('refresh-btn');
                refreshBtn.addEventListener('click', () => {
                    this.fetchBoxOfficeData();
                });
            }
            
            async fetchBoxOfficeData() {
                this.showLoading();
                this.hideError();
                this.hideEmptyState();
                this.hideTable();
                this.hideStats();
                this.hideHeader();
                this.disableRefreshBtn();
                
                const startTime = Date.now();
                
                try {
                    const response = await fetch('../php/movie-box-office-proxy.php', {
                        method: 'GET',
                        timeout: 15000
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    if (data.success && data.code === 200) {
                        this.displayBoxOfficeData(data);
                        recordToolUsage('fetch_box_office', 'success', {
                            api_code: data.code,
                            movie_count: data.data ? data.data.length : 0,
                            update_time: data.time || ''
                        }, responseTime);
                    } else {
                        this.showError(data.message || '获取票房数据失败');
                        recordToolUsage('fetch_box_office', 'error', {
                            api_code: data.code || 500,
                            error_msg: data.message || '获取票房数据失败'
                        }, responseTime);
                    }
                } catch (error) {
                    const responseTime = (Date.now() - startTime) / 1000;
                    this.showError(`获取票房数据失败: ${error.message}`);
                    console.error('API请求错误:', error);
                    recordToolUsage('fetch_box_office', 'error', {
                        error_msg: error.message,
                        exception: error.message
                    }, responseTime);
                } finally {
                    this.hideLoading();
                    this.enableRefreshBtn();
                }
            }
            
            displayBoxOfficeData(data) {
                if (!data.data || data.data.length === 0) {
                    this.showEmptyState();
                    return;
                }
                
                this.updateHeader(data);
                
                this.renderTable(data.data);
                
                this.showStats(data.data);
                
                this.showTable();
                this.showHeader();
                this.showStats();
            }
            
            updateHeader(data) {
                const updateTime = document.getElementById('update-time');
                const movieCount = document.getElementById('movie-count');
                
                updateTime.textContent = data.time || new Date().toLocaleString();
                movieCount.textContent = data.data.length || 0;
            }
            
            renderTable(movies) {
                const tableBody = document.getElementById('table-body');
                tableBody.innerHTML = '';
                
                movies.forEach(movie => {
                    const row = this.createTableRow(movie);
                    tableBody.appendChild(row);
                });
            }
            
            createTableRow(movie) {
                const row = document.createElement('tr');
                
                row.innerHTML = `
                    <td><span class="rank-number">${movie.top || ''}</span></td>
                    <td><span class="movie-name">${this.escapeHtml(movie.movieName || '')}</span></td>
                    <td>${this.escapeHtml(movie.releaseInfo || '-')}</td>
                    <td><span class="box-office-data">${this.escapeHtml(movie.sumBoxDesc || '')}</span></td>
                    <td>${this.escapeHtml(movie.boxRate || '')}</td>
                    <td>${movie.showCount || ''}</td>
                    <td>${this.escapeHtml(movie.showCountRate || '')}</td>
                    <td>${this.escapeHtml(movie.avgShowView || '')}</td>
                    <td>${this.escapeHtml(movie.avgSeatView || '')}</td>
                `;
                
                return row;
            }
            
            showStats(movies) {
                document.getElementById('total-movies').textContent = movies.length;
                
                if (movies.length > 0) {
                    const champion = movies[0];
                    document.getElementById('box-office-champion').textContent = champion.movieName || '';
                    
                    const topMovies = movies.slice(0, 10);
                    const avgBoxOffice = this.calculateAverageBoxOffice(topMovies);
                    document.getElementById('avg-box-office').textContent = avgBoxOffice;
                }
            }
            
            calculateAverageBoxOffice(movies) {
                if (movies.length === 0) return '0.00亿';
                
                return movies[0].sumBoxDesc || '0.00亿';
            }
            
            escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
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
            
            showEmptyState() {
                document.getElementById('empty-state').classList.add('visible');
            }
            
            hideEmptyState() {
                document.getElementById('empty-state').classList.remove('visible');
            }
            
            showTable() {
                document.getElementById('table-container').style.display = 'block';
            }
            
            hideTable() {
                document.getElementById('table-container').style.display = 'none';
            }
            
            showHeader() {
                document.getElementById('data-header').style.display = 'flex';
            }
            
            hideHeader() {
                document.getElementById('data-header').style.display = 'none';
            }
            
            showStats() {
                document.getElementById('data-stats').style.display = 'flex';
            }
            
            hideStats() {
                document.getElementById('data-stats').style.display = 'none';
            }
            
            disableRefreshBtn() {
                const refreshBtn = document.getElementById('refresh-btn');
                refreshBtn.classList.add('loading');
                refreshBtn.querySelector('.refresh-icon').style.display = 'inline-block';
                refreshBtn.querySelector('span:last-child').textContent = '刷新中...';
            }
            
            enableRefreshBtn() {
                const refreshBtn = document.getElementById('refresh-btn');
                refreshBtn.classList.remove('loading');
                refreshBtn.querySelector('.refresh-icon').style.display = 'inline-block';
                refreshBtn.querySelector('span:last-child').textContent = '刷新数据';
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new MovieBoxOffice();
        });
    </script>
</body>
</html>