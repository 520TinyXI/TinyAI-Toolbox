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
    <title>查询Minecraft服务器状态 - <?php echo $siteConfig['name']; ?></title>
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
        
        .result-section {
            margin-top: 30px;
        }
        
        .result-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 20px;
        }
        
        .server-card {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .server-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .server-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }
        
        .server-icon {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            border: 2px solid #e0e0e0;
            object-fit: cover;
            background-color: #fff;
        }
        
        .server-info {
            flex: 1;
        }
        
        .server-status {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }
        
        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        
        .status-indicator.online {
            background-color: #4CAF50;
            box-shadow: 0 0 10px rgba(76, 175, 80, 0.5);
        }
        
        .status-indicator.offline {
            background-color: #F44336;
            box-shadow: 0 0 10px rgba(244, 67, 54, 0.5);
        }
        
        .status-text {
            font-weight: 600;
            font-size: 18px;
        }
        
        .status-text.online {
            color: #4CAF50;
        }
        
        .status-text.offline {
            color: #F44336;
        }
        
        .server-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }
        
        .detail-item {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 16px;
        }
        
        .detail-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }
        
        .detail-value {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .player-progress {
            margin-top: 8px;
        }
        
        .progress-bar {
            height: 8px;
            background-color: #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 8px;
        }
        
        .progress-fill {
            height: 100%;
            background-color: #4CAF50;
            transition: width 0.3s ease;
        }
        
        .progress-text {
            font-size: 12px;
            color: #666;
            text-align: right;
        }
        
        .motd-section {
            margin-top: 20px;
        }
        
        .motd-title {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .motd-content {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 16px;
            font-family: monospace;
            font-size: 14px;
            line-height: 1.5;
            white-space: pre-wrap;
            word-break: break-word;
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
            
            .server-header {
                flex-direction: column;
                text-align: center;
            }
            
            .server-details {
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
                    <h2>查询Minecraft服务器状态</h2>
                    <p>实时查询Minecraft Java版服务器的在线状态、玩家数量、版本信息等</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">
                    <div class="error-message" id="error-message"></div>
                    
                    <div class="form-section">
                        <form id="minecraft-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="server-address">服务器地址</label>
                                    <input type="text" class="form-input" id="server-address" name="server" placeholder="请输入服务器地址，如 hypixel.net 或 mc.example.com:25565" value="hypixel.net">
                                </div>
                                <button type="submit" class="btn" id="query-btn">
                                    <span class="loading-icon" style="display: none;">🔄</span>
                                    <span>查询状态</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div>正在查询服务器状态，请稍候...</div>
                    </div>
                    
                    <div class="result-section" id="result-section" style="display: none;">
                        <h3 class="result-title">查询结果</h3>
                        <div id="server-result"></div>
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
        
        class MinecraftServerStatus {
            constructor() {
                this.init();
            }
            
            init() {
                this.bindEvents();
            }
            
            bindEvents() {
                const form = document.getElementById('minecraft-form');
                
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.queryServerStatus();
                });
            }
            
            async queryServerStatus() {
                const server = document.getElementById('server-address').value.trim();
                
                if (!server) {
                    this.showError('请输入Minecraft服务器地址');
                    return;
                }
                
                this.showLoading();
                this.hideError();
                
                const startTime = Date.now();
                
                try {
                    const params = new URLSearchParams({ server: server });
                    const requestUrl = `../php/minecraft-proxy.php?${params.toString()}`;
                    
                    const response = await fetch(requestUrl);
                    
                    if (!response.ok) {
                        const errorData = await response.json().catch(() => ({}));
                        throw new Error(errorData.message || `HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    console.log('API响应数据:', data);
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.displayResults(data);
                    
                    const content = JSON.stringify({ action: 'query_status', server: server });
                    await recordToolUsage('minecraft-status', 'query_status', 'success', responseTime, content);
                } catch (error) {
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.showError(`查询失败: ${error.message}`);
                    console.error('API请求错误:', error);
                    
                    const content = JSON.stringify({ action: 'query_status', server: server, error: error.message });
                    await recordToolUsage('minecraft-status', 'query_status', 'error', responseTime, content);
                } finally {
                    this.hideLoading();
                }
            }
            
            displayResults(results) {
                const resultContainer = document.getElementById('server-result');
                const resultSection = document.getElementById('result-section');
                
                resultContainer.innerHTML = '';
                
                if (!results.online && results.code !== 200) {
                    resultContainer.innerHTML = `
                        <div class="server-card">
                            <div class="server-status">
                                <div class="status-indicator offline"></div>
                                <div class="status-text offline">服务器查询失败</div>
                            </div>
                            <div style="margin-top: 16px; color: #666;">
                                <p>错误信息: ${results.message || '未知错误'}</p>
                                <p>错误代码: ${results.code || 'UNKNOWN_ERROR'}</p>
                            </div>
                        </div>
                    `;
                } else {
                    const playerPercentage = results.max_players > 0 ? 
                        Math.round((results.players / results.max_players) * 100) : 0;
                    
                    resultContainer.innerHTML = `
                        <div class="server-card">
                            <div class="server-header">
                                <div class="server-icon">
                                    ${results.favicon_url ? 
                                        `<img src="${results.favicon_url}" alt="服务器图标" style="width: 100%; height: 100%; border-radius: 10px; object-fit: cover;">` : 
                                        '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 32px;">⚙️</div>'
                                    }
                                </div>
                                
                                <div class="server-info">
                                    <div class="server-status">
                                        <div class="status-indicator ${results.online ? 'online' : 'offline'}"></div>
                                        <div class="status-text ${results.online ? 'online' : 'offline'}">
                                            ${results.online ? '服务器在线' : '服务器离线'}
                                        </div>
                                    </div>
                                    <div style="color: #666; margin-top: 4px;">
                                        ${results.ip || '未知IP'}:${results.port || 25565}
                                    </div>
                                </div>
                            </div>
                            
                            ${results.online ? `
                                <div class="server-details">
                                    <div class="detail-item">
                                        <div class="detail-label">在线玩家</div>
                                        <div class="detail-value">${results.players || 0}</div>
                                        <div class="player-progress">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: ${playerPercentage}%"></div>
                                            </div>
                                            <div class="progress-text">
                                                ${playerPercentage}% (${results.players || 0}/${results.max_players || 0})
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <div class="detail-label">最大容量</div>
                                        <div class="detail-value">${results.max_players || 0}</div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <div class="detail-label">Minecraft版本</div>
                                        <div class="detail-value" style="font-size: 16px; font-weight: 500;">
                                            ${results.version || '未知'}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="motd-section">
                                    <div class="motd-title">服务器描述（MOTD）</div>
                                    <div class="motd-content">
                                        ${results.motd_clean || '无描述信息'}
                                    </div>
                                </div>
                            ` : ''}
                        </div>
                    `;
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
                queryBtn.querySelector('span:last-child').textContent = '查询状态';
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
            new MinecraftServerStatus();
        });
    </script>
</body>
</html>