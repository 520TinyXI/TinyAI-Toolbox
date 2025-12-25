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
    <title>电视剧实时票房 - <?php echo $siteConfig['name']; ?></title>
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
        

        .form-section {
            margin-bottom: 30px;
            text-align: center;
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
            display: inline-flex;
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
        

        .boxoffice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .boxoffice-table th,
        .boxoffice-table td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .boxoffice-table th {
            background-color: #f5f5f5;
            font-weight: 600;
            color: #1a1a1a;
            font-size: 14px;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .boxoffice-table td {
            font-size: 14px;
            color: #1a1a1a;
        }
        

        .rank {
            font-weight: 600;
            color: #e74c3c;
            font-size: 16px;
        }
        

        .tv-name {
            font-weight: 600;
            color: #1a1a1a;
        }
        

        .platform {
            background-color: #3498db;
            color: #fff;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
        }
        

        .heat {
            font-weight: 600;
            color: #e67e22;
        }
        

        .play-count {
            font-weight: 600;
            color: #27ae60;
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
            
            .boxoffice-table {
                display: block;
                overflow-x: auto;
            }
            
            .boxoffice-table th,
            .boxoffice-table td {
                padding: 12px 8px;
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
                    <h2>电视剧实时票房</h2>
                    <p>查询热播电视剧的实时票房和热度排名</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">

                    <div class="error-message" id="error-message"></div>
                    

                    <div class="form-section">
                        <button type="button" class="btn" id="query-btn">
                            <span class="loading-icon" style="display: none;">🔄</span>
                            <span>查询实时票房</span>
                        </button>
                    </div>
                    

                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div>正在查询电视剧实时票房，请稍候...</div>
                    </div>
                    

                    <div class="result-section" id="result-section" style="display: none;">
                        <h3 class="result-title">查询结果</h3>
                        <div style="overflow-x: auto;">
                            <table class="boxoffice-table" id="boxoffice-table">
                                <thead>
                                    <tr>
                                        <th>排名</th>
                                        <th>电视剧名称</th>
                                        <th>播放平台</th>
                                        <th>上线天数</th>
                                        <th>实时热量</th>
                                        <th>实时播放量</th>
                                    </tr>
                                </thead>
                                <tbody>

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
                console.error('Failed to record tool usage:', error);
            }
        }
        
        class TVBoxOfficeQuery {
            constructor() {
                this.init();
            }
            
            init() {
                this.bindEvents();

                this.queryBoxOffice();
            }
            
            bindEvents() {
                const queryBtn = document.getElementById('query-btn');
                

                queryBtn.addEventListener('click', () => {
                    this.queryBoxOffice();
                });
            }
            
            async queryBoxOffice() {
                this.showLoading();
                this.hideError();
                
                const startTime = Date.now();
                
                try {
                    const requestUrl = '../php/tv-boxoffice-proxy.php';
                    
                    const response = await fetch(requestUrl);
                    
                    if (!response.ok) {
                        const errorData = await response.json().catch(() => ({}));
                        throw new Error(errorData.message || `HTTP error! Status: ${response.status}`);
                    }
                    
                    const textResponse = await response.text();
                    
                    const tvList = this.parseTVData(textResponse);
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.displayResults(tvList);
                    
                    const content = JSON.stringify({ action: 'fetch_tv_boxoffice' });
                    await recordToolUsage('tv-boxoffice', 'fetch_tv_boxoffice', 'success', responseTime, content);
                } catch (error) {
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.showError(`Query failed: ${error.message}`);
                    console.error('API Request Error:', error);
                    
                    const content = JSON.stringify({ action: 'fetch_tv_boxoffice', error: error.message });
                    await recordToolUsage('tv-boxoffice', 'fetch_tv_boxoffice', 'error', responseTime, content);
                } finally {
                    this.hideLoading();
                }
            }
            
            parseTVData(text) {
                const tvList = [];
                const lines = text.split('\n');
                let currentTV = null;
                
                lines.forEach(line => {
                    line = line.trim();
                    if (!line) return;
                    

                    const rankMatch = line.match(/Top (\d+) -> (.+)/);
                    if (rankMatch) {
    
                        if (currentTV) {
                            tvList.push(currentTV);
                        }
                        
    
                        currentTV = {
                            rank: rankMatch[1],
                            name: rankMatch[2],
                            platform: '',
                            daysOnline: '',
                            heat: '',
                            playCount: ''
                        };
                        return;
                    }
                    

                    const infoMatch = line.match(/(.+)独播 上线(\d+)天/);
                    if (infoMatch) {
                        if (currentTV) {
                            currentTV.platform = infoMatch[1];
                            currentTV.daysOnline = infoMatch[2];
                        }
                        return;
                    }
                    

                    const multiPlatformMatch = line.match(/多平台播放 上线(\d+)天/);
                    if (multiPlatformMatch) {
                        if (currentTV) {
                            currentTV.platform = '多平台';
                            currentTV.daysOnline = multiPlatformMatch[1];
                        }
                        return;
                    }
                    

                    const heatMatch = line.match(/实时热量 (.+) 万/);
                    if (heatMatch) {
                        if (currentTV) {
                            currentTV.heat = heatMatch[1];
                        }
                        return;
                    }
                    

                    const playCountMatch = line.match(/实时播放量 (.+) 万/);
                    if (playCountMatch) {
                        if (currentTV) {
                            currentTV.playCount = playCountMatch[1];
                        }
                        return;
                    }
                });
                
                
                if (currentTV) {
                    tvList.push(currentTV);
                }
                
                return tvList;
            }
            
            displayResults(tvList) {
                const resultSection = document.getElementById('result-section');
                const tableBody = document.getElementById('boxoffice-table').querySelector('tbody');
                
                tableBody.innerHTML = '';
                
                if (tvList.length > 0) {
                    tvList.forEach(tv => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td><span class="rank">${tv.rank}</span></td>
                            <td><span class="tv-name">${tv.name}</span></td>
                            <td><span class="platform">${tv.platform}</span></td>
                            <td>${tv.daysOnline} days</td>
                            <td><span class="heat">${tv.heat} 万</span></td>
                            <td>${tv.playCount ? `<span class="play-count">${tv.playCount} 万</span>` : '-'}</td>
                        `;
                        
                        tableBody.appendChild(row);
                    });
                } else {
                    tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; color: #666; padding: 40px;">No TV box office data found</td></tr>';
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
                queryBtn.querySelector('span:last-child').textContent = '查询实时票房';
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
            new TVBoxOfficeQuery();
        });
    </script>
</body>
</html>