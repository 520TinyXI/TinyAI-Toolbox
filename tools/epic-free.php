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
    <title>Epic喜加一 - <?php echo $siteConfig['name']; ?></title>
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
        
        /* 游戏列表 */
        .games-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        

        .game-card {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 24px;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .game-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            border-color: #1a1a1a;
        }
        
        .game-header {
            margin-bottom: 16px;
        }
        
        .game-name {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
            line-height: 1.4;
        }
        
        .game-type {
            display: inline-block;
            background-color: #e0e0e0;
            color: #666;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 12px;
        }
        
        .game-info {
            margin-bottom: 20px;
            flex: 1;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .info-label {
            color: #999;
            font-weight: 500;
            min-width: 70px;
        }
        
        .info-value {
            color: #1a1a1a;
            flex: 1;
        }
        
        .perpetual-yes {
            color: #2e7d32;
            font-weight: 600;
        }
        
        .perpetual-no {
            color: #d32f2f;
            font-weight: 600;
        }
        
        .source-badge {
            display: inline-block;
            background-color: #1a1a1a;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 12px;
        }
        
        .game-footer {
            margin-top: auto;
        }
        
        .game-link {
            display: block;
            width: 100%;
            background-color: #fff;
            color: #1a1a1a;
            border: 2px solid #1a1a1a;
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .game-link:hover {
            background-color: #1a1a1a;
            color: #fff;
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
                    <h2>Epic喜加一</h2>
                    <p>获取最新的Epic喜加一游戏信息</p>
                </div>
            </header>


            <div class="tool-container">

                <div class="tool-content">

                    <div class="error-message" id="error-message"></div>
                    

                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div class="loading-text">正在获取游戏信息，请稍候...</div>
                    </div>
                    

                    <div class="games-section" id="games-section" style="display: none;">
                        <div class="games-header">
                            <div class="games-info">
                                <div class="info-item">
                                    <span class="info-label">更新时间:</span>
                                    <span class="info-value" id="update-time"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">游戏数量:</span>
                                    <span class="info-value" id="game-count"></span>
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
                            <div class="empty-text">暂无喜加一游戏信息</div>
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
                    tool_id: 'epic-free',
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

        class EpicFreeGames {
            constructor() {
                this.init();
            }
            
            init() {
                this.bindEvents();
                this.fetchGames();
            }
            
            bindEvents() {
                const refreshBtn = document.getElementById('refresh-btn');
                refreshBtn.addEventListener('click', () => {
                    this.fetchGames();
                });
            }
            
            async fetchGames() {
                this.showLoading();
                this.hideError();
                this.hideEmptyState();
                this.disableRefreshBtn();
                

                const startTime = Date.now();
                
                try {
                    const response = await fetch('../php/epic-free-proxy.php', {
                        method: 'GET',
                        timeout: 10000
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
    
                    console.log('API完整响应:', JSON.stringify(data, null, 2));
                    
    
                    if (data.data && data.data.length > 0) {
                        console.log('游戏列表:', data.data.map(game => ({
                            name: game.name,
                            translated_name: game.translated_name
                        })));
                    }
                    
                    if (data.success && data.code === 200) {
                        this.displayGames(data);
        
                        recordToolUsage('fetch_games', 'success', {
                            api_code: data.code,
                            game_count: data.count || 0,
                            update_time: data.time || ''
                        }, responseTime);
                    } else {
                        this.showError(data.message || '获取游戏信息失败');
        
                        recordToolUsage('fetch_games', 'error', {
                            api_code: data.code || 500,
                            error_msg: data.message || '获取游戏信息失败'
                        }, responseTime);
                    }
                } catch (error) {
                    // 计算响应时间（秒）
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.showError(`获取游戏信息失败: ${error.message}`);
                    console.error('API请求错误:', error);
    
                    recordToolUsage('fetch_games', 'error', {
                        error_msg: error.message,
                        exception: error.message
                    }, responseTime);
                } finally {
                    this.hideLoading();
                    this.enableRefreshBtn();
                }
            }
            
            displayGames(data) {
                const gamesSection = document.getElementById('games-section');
                const updateTime = document.getElementById('update-time');
                const gameCount = document.getElementById('game-count');
                const gamesList = document.getElementById('games-list');
                

                updateTime.textContent = data.time || '';
                gameCount.textContent = data.count || '0';
                

                if (data.data && data.data.length > 0) {
                    gamesList.innerHTML = data.data.map(game => this.createGameCard(game)).join('');
                    this.hideEmptyState();
                } else {
                    gamesList.innerHTML = '';
                    this.showEmptyState();
                }
                

                gamesSection.style.display = 'block';
            }
            
            createGameCard(game) {
                const perpetualClass = game.perpetual === '是' ? 'perpetual-yes' : 'perpetual-no';
                
                return `
                    <div class="game-card">
                        <div class="game-header">
                            ${game.translated_name && game.translated_name !== game.name ? `
                                <h3 class="game-name">${this.escapeHtml(game.translated_name || '')}</h3>
                                <p class="game-original-name" style="font-size: 14px; color: #666; margin: 4px 0 8px;">${this.escapeHtml(game.name || '')}</p>
                            ` : `
                                <h3 class="game-name">${this.escapeHtml(game.name || '')}</h3>
                            `}
                            ${game.type ? `<span class="game-type">${this.escapeHtml(game.type)}</span>` : ''}
                        </div>
                        <div class="game-info">
                            <div class="info-row">
                                <span class="info-label">开始时间:</span>
                                <span class="info-value">${this.escapeHtml(game.starttime || '')}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">结束时间:</span>
                                <span class="info-value">${this.escapeHtml(game.endtime || '')}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">是否永久:</span>
                                <span class="info-value ${perpetualClass}">${this.escapeHtml(game.perpetual || '')}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">来源商店:</span>
                                <span class="info-value">
                                    <span class="source-badge">${this.escapeHtml(game.source || '')}</span>
                                </span>
                            </div>
                        </div>
                        <div class="game-footer">
                            ${game.url ? `<a href="${this.escapeHtml(game.url)}" class="game-link" target="_blank" rel="noopener noreferrer">查看详情</a>` : ''}
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
        }
        

        document.addEventListener('DOMContentLoaded', () => {
            new EpicFreeGames();
        });
    </script>
</body>
</html>