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
    <title>地震信息 - <?php echo $siteConfig['name']; ?></title>
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
        

        .tool-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .tool-header h2 {
            font-size: 24px;
            color: #1a1a1a;
            margin: 0;
        }
        

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
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
        

        .earthquake-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .earthquake-table th,
        .earthquake-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .earthquake-table th {
            background-color: #f5f5f5;
            font-weight: 600;
            color: #1a1a1a;
            font-size: 14px;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .earthquake-table td {
            font-size: 14px;
            color: #1a1a1a;
        }
        

        .rank {
            font-weight: 600;
            color: #e74c3c;
        }
        

        .place {
            font-weight: 600;
        }
        

        .level {
            font-weight: 600;
            color: #e67e22;
        }
        

        .time {
            color: #3498db;
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
        

        @media (max-width: 1024px) {
            .tool-container {
                padding: 20px 16px;
            }
            
            .tool-content {
                padding: 20px;
            }
            
            .earthquake-table {
                display: block;
                overflow-x: auto;
            }
            
            .tool-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
        }
        
        @media (max-width: 768px) {
            .earthquake-table th,
            .earthquake-table td {
                padding: 10px 8px;
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
                    <h2>地震信息</h2>
                    <p>获取近期全球的地震信息，包括地点、震级、时间、深度等</p>
                </div>
            </header>
            
            <div class="tool-container">

                <div class="tool-content">

                    <div class="error-message" id="error-message"></div>
                    

                    <div class="tool-header">
                        <h2>近期全球地震信息</h2>
                        <button type="button" class="btn" id="refresh-btn">
                            <span class="loading-icon" style="display: none;">🔄</span>
                            <span>刷新数据</span>
                        </button>
                    </div>
                    

                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div>正在获取地震信息，请稍候...</div>
                    </div>
                    

                    <div class="result-section" id="result-section" style="display: none;">
                        <div style="overflow-x: auto;">
                            <table class="earthquake-table" id="earthquake-table">
                                <thead>
                                    <tr>
                                        <th>排名</th>
                                        <th>地点</th>
                                        <th>纬度</th>
                                        <th>经度</th>
                                        <th>震级</th>
                                        <th>时间</th>
                                        <th>深度</th>
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
                console.error('记录工具使用情况失败:', error);
            }
        }
        
        class EarthquakeQuery {
            constructor() {
                this.init();
            }
            
            init() {
                this.bindEvents();

                this.queryEarthquakeData();
            }
            
            bindEvents() {
                const refreshBtn = document.getElementById('refresh-btn');
                

                refreshBtn.addEventListener('click', () => {
                    this.queryEarthquakeData();
                });
            }
            
            async queryEarthquakeData() {

                this.showLoading();
                this.hideError();
                

                const startTime = Date.now();
                
                try {
    
                    const requestUrl = '../php/earthquake-proxy.php';
                    
    
                    const response = await fetch(requestUrl);
                    
                    if (!response.ok) {
                        const errorData = await response.json().catch(() => ({}));
                        throw new Error(errorData.message || `HTTP错误! 状态码: ${response.status}`);
                    }
                    
    
                    const data = await response.json();
                    
    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
    
                    this.displayResults(data);
                    
    
                    const content = JSON.stringify({ action: 'fetch_earthquake_data', count: Array.isArray(data) ? data.length : 0 });
                    await recordToolUsage('earthquake', 'fetch_earthquake_data', 'success', responseTime, content);
                } catch (error) {
                    // 计算响应时间
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.showError(`查询失败: ${error.message}`);
                    console.error('API请求错误:', error);
                    
    
                    const content = JSON.stringify({ action: 'fetch_earthquake_data', error: error.message });
                    await recordToolUsage('earthquake', 'fetch_earthquake_data', 'error', responseTime, content);
                } finally {
                    this.hideLoading();
                }
            }
            
            displayResults(earthquakes) {
                const resultSection = document.getElementById('result-section');
                const tableBody = document.getElementById('earthquake-table').querySelector('tbody');
                

                tableBody.innerHTML = '';
                

                if (Array.isArray(earthquakes) && earthquakes.length > 0) {
                    earthquakes.forEach((quake, index) => {
        
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td><span class="rank">${index + 1}</span></td>
                            <td><span class="place">${quake.place || '-'}</span></td>
                            <td>${quake.lat || '-'}</td>
                            <td>${quake.lon || '-'}</td>
                            <td><span class="level">${quake.level || '-'}</span></td>
                            <td><span class="time">${quake.time || '-'}</span></td>
                            <td>${quake.depth || '-'}</td>
                        `;
                        
                        tableBody.appendChild(row);
                    });
                } else {
                    tableBody.innerHTML = '<tr><td colspan="7" style="text-align: center; color: #666; padding: 40px;">未找到地震信息</td></tr>';
                }
                

                resultSection.style.display = 'block';
            }
            
            showLoading() {
                const loading = document.getElementById('loading');
                const refreshBtn = document.getElementById('refresh-btn');
                
                loading.classList.add('visible');
                refreshBtn.disabled = true;
                refreshBtn.querySelector('.loading-icon').style.display = 'inline-block';
                refreshBtn.querySelector('span:last-child').textContent = '刷新中...';
            }
            
            hideLoading() {
                const loading = document.getElementById('loading');
                const refreshBtn = document.getElementById('refresh-btn');
                
                loading.classList.remove('visible');
                refreshBtn.disabled = false;
                refreshBtn.querySelector('.loading-icon').style.display = 'none';
                refreshBtn.querySelector('span:last-child').textContent = '刷新数据';
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
            new EarthquakeQuery();
        });
    </script>
</body>
</html>