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
    <title>Steam游戏在线人数查询 - <?php echo $siteConfig['name']; ?></title>
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
            margin-bottom: 30px;
            padding: 24px;
            background-color: #fafafa;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
        }
        
        .query-form {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            align-items: center;
        }
        
        .form-group {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .form-input {
            padding: 10px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            min-width: 120px;
        }
        
        .form-select {
            padding: 10px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            min-width: 150px;
        }
        
        .query-btn {
            background-color: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .query-btn:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .games-section {
            margin-bottom: 30px;
        }
        
        .games-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .games-info {
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
        
        .games-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }
        
        .game-card {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 24px;
            transition: all 0.3s ease;
        }
        
        .game-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            border-color: #1a1a1a;
        }
        
        .game-rank {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .game-name {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 16px;
            line-height: 1.4;
        }
        
        .game-stats {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .stat-label {
            font-size: 14px;
            color: #666;
        }
        
        .stat-value {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .online-value {
            color: #2e7d32;
        }
        
        .peak-value {
            color: #d32f2f;
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
                justify-content: space-between;
            }
            
            .games-header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .games-info {
                gap: 16px;
            }
            
            .games-list {
                grid-template-columns: 1fr;
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
                    <h2>Steam游戏在线人数查询</h2>
                    <p>查询Steam平台游戏在线人数统计，包括当前在线人数和历史峰值</p>
                </div>
            </header>

            <div class="tool-container">
                <div class="tool-content">
                    <div class="error-message" id="error-message"></div>
                    
                    <div class="query-section">
                        <form class="query-form" id="query-form">
                            <div class="form-group">
                                <label class="form-label" for="page">页码:</label>
                                <input type="number" class="form-input" id="page" name="page" value="1" min="1">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="num">每页数量:</label>
                                <select class="form-select" id="num" name="num">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                </select>
                            </div>
                            <button type="submit" class="query-btn">查询</button>
                        </form>
                    </div>
                    
                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div class="loading-text">正在获取游戏在线人数信息，请稍候...</div>
                    </div>
                    
                    <div class="games-section" id="games-section" style="display: none;">
                        <div class="games-header">
                            <div class="games-info">
                                <div class="info-item">
                                    <span class="info-label">总游戏数:</span>
                                    <span class="info-value" id="total-games"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">当前页码:</span>
                                    <span class="info-value" id="current-page"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">每页数量:</span>
                                    <span class="info-value" id="per-page"></span>
                                </div>
                            </div>
                            <button class="refresh-btn" id="refresh-btn">
                                <span class="refresh-icon">🔄</span>
                                <span>刷新</span>
                            </button>
                        </div>
                        
                        <div class="games-list" id="games-list"></div>
                        
                        <div class="empty-state" id="empty-state">
                            <div class="empty-icon">🎮</div>
                            <div class="empty-text">暂无游戏在线人数信息</div>
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
        
        class SteamOnlinePlayers {
            constructor() {
                this.init();
            }
            
            init() {
                this.bindEvents();
                this.fetchGames();
            }
            
            bindEvents() {
                const queryForm = document.getElementById('query-form');
                const refreshBtn = document.getElementById('refresh-btn');
                
                queryForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.fetchGames();
                });
                
                refreshBtn.addEventListener('click', () => {
                    this.fetchGames();
                });
            }
            
            async fetchGames() {
                this.showLoading();
                this.hideError();
                this.hideEmptyState();
                this.disableRefreshBtn();
                
                const page = document.getElementById('page').value || 1;
                const num = document.getElementById('num').value || 10;
                
                const startTime = Date.now();
                
                try {
                    const response = await fetch('../php/steam-online-proxy.php?page=' + page + '&num=' + num, {
                        method: 'GET',
                        timeout: 10000
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    console.log('API返回数据:', data);
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    if (data.success) {
                        if (data.games && Array.isArray(data.games)) {
                            this.displayGames(data);
                            await recordToolUsage('steam-online', '查询游戏在线人数', 'success', responseTime);
                        } else if (data.raw_response) {
                            const parsedData = this.parseRawResponse(data.raw_response);
                            this.displayGames(parsedData);
                            await recordToolUsage('steam-online', '查询游戏在线人数', 'success', responseTime);
                        } else {
                            this.showError('API返回数据格式不正确');
                            await recordToolUsage('steam-online', '查询游戏在线人数', 'error', responseTime, 'API返回数据格式不正确');
                        }
                    } else {
                        this.showError(data.message || '获取游戏在线人数信息失败');
                        if (data.debug) {
                            console.error('调试信息:', data.debug);
                        }
                        await recordToolUsage('steam-online', '查询游戏在线人数', 'error', responseTime, data.message || '获取游戏在线人数信息失败');
                    }
                } catch (error) {
                    this.showError(`获取游戏在线人数信息失败: ${error.message}`);
                    console.error('API请求错误:', error);
                    const responseTime = (Date.now() - startTime) / 1000;
                await recordToolUsage('steam-online', '查询游戏在线人数', 'error', responseTime, error.message);
                } finally {
                    this.hideLoading();
                    this.enableRefreshBtn();
                }
            }
            
            displayGames(data) {
                const gamesSection = document.getElementById('games-section');
                const totalGames = document.getElementById('total-games');
                const currentPage = document.getElementById('current-page');
                const perPage = document.getElementById('per-page');
                const gamesList = document.getElementById('games-list');
                
                totalGames.textContent = data.total || '0';
                currentPage.textContent = data.page || '1/1';
                perPage.textContent = data.per_page || '10';
                
                if (data.games && data.games.length > 0) {
                    gamesList.innerHTML = data.games.map((game, index) => this.createGameCard(game, index + 1)).join('');
                    this.hideEmptyState();
                } else {
                    gamesList.innerHTML = '';
                    this.showEmptyState();
                }
                
                gamesSection.style.display = 'block';
            }
            
            createGameCard(game, rank) {
                return `
                    <div class="game-card">
                        <div class="game-rank">${rank}</div>
                        <div class="game-name">${this.escapeHtml(game.name || '')}</div>
                        <div class="game-stats">
                            <div class="stat-item">
                                <span class="stat-label">当前在线:</span>
                                <span class="stat-value online-value">${this.escapeHtml(game.current_online || '')}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">历史峰值:</span>
                                <span class="stat-value peak-value">${this.escapeHtml(game.peak_online || '')}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">峰值时间:</span>
                                <span class="stat-value">${this.escapeHtml(game.peak_time || '')}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Steam ID:</span>
                                <span class="stat-value">${this.escapeHtml(game.steam_id || '')}</span>
                            </div>
                        </div>
                    </div>
                `;
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
                document.getElementById('empty-state').style.display = 'block';
            }
            
            hideEmptyState() {
                document.getElementById('empty-state').style.display = 'none';
            }
            
            disableRefreshBtn() {
                const refreshBtn = document.getElementById('refresh-btn');
                refreshBtn.classList.add('loading');
                refreshBtn.disabled = true;
            }
            
            enableRefreshBtn() {
                const refreshBtn = document.getElementById('refresh-btn');
                refreshBtn.classList.remove('loading');
                refreshBtn.disabled = false;
            }
            
            parseRawResponse(rawResponse) {
                const result = {
                    total: 0,
                    page: '1/1',
                    per_page: 10,
                    games: []
                };
                
                const totalMatch = rawResponse.match(/总游戏数: ([\d,]+)/);
                if (totalMatch) {
                    result.total = totalMatch[1].replace(/,/g, '');
                }
                
                const pageMatch = rawResponse.match(/当前页码: ([\d\/]+)/);
                if (pageMatch) {
                    result.page = pageMatch[1];
                }
                
                const perPageMatch = rawResponse.match(/每页数量: (\d+)/);
                if (perPageMatch) {
                    result.per_page = parseInt(perPageMatch[1]);
                }
                
                const gameRegex = /\d+\. (.+?)\n当前在线: ([\d,]+) 人\n历史峰值: ([\d,]+) 人\n峰值时间: (.+?)\nSteam ID: (\d+)/g;
                let match;
                
                while ((match = gameRegex.exec(rawResponse)) !== null) {
                    result.games.push({
                        name: match[1].trim(),
                        current_online: match[2].trim(),
                        peak_online: match[3].trim(),
                        peak_time: match[4].trim(),
                        steam_id: match[5].trim()
                    });
                }
                
                return result;
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new SteamOnlinePlayers();
        });
    </script>
</body>
</html>