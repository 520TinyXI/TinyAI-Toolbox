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
    <title>安兔兔设备性能榜 - <?php echo $siteConfig['name']; ?></title>
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
        
        
        .system-selector {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        
        .system-btn {
            padding: 12px 24px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #fafafa;
            color: #1a1a1a;
            flex: 1;
            min-width: 100px;
        }
        
        .system-btn:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
        }
        
        .system-btn.active {
            background-color: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
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
        
        
        .antutu-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            min-width: 1000px;
        }
        
        .antutu-table thead {
            background-color: #fafafa;
            border-bottom: 2px solid #e0e0e0;
        }
        
        .antutu-table th {
            padding: 16px;
            text-align: left;
            font-weight: 700;
            color: #1a1a1a;
            border-bottom: 1px solid #e0e0e0;
            white-space: nowrap;
        }
        
        .antutu-table td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .antutu-table tbody tr:hover {
            background-color: #fafafa;
        }
        
        
        .rank {
            font-weight: 700;
            font-size: 16px;
        }
        
        .rank.top3 {
            color: #d63031;
        }
        
        
        .device-name {
            font-weight: 600;
            color: #1a1a1a;
        }
        
        
        .config-info {
            color: #666;
            font-size: 13px;
        }
        
        
        .score {
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .total-score {
            font-weight: 700;
            color: #d63031;
            font-size: 16px;
        }
        
        
        .loading-container {
            text-align: center;
            padding: 60px 0;
            color: #666;
        }
        
        .loading {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 3px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top-color: #1a1a1a;
            animation: spin 1s ease-in-out infinite;
            margin-bottom: 16px;
        }
        
        
        .error-container {
            padding: 20px;
            background-color: #fff3f3;
            border: 1px solid #ffe0e0;
            border-radius: 8px;
            color: #d63031;
            text-align: center;
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
            
            .system-selector {
                flex-direction: column;
            }
            
            .system-btn {
                width: 100%;
            }
            
            .data-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .data-info {
                flex-direction: column;
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- 左侧菜单栏 -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 class="logo">工具箱</h1>
            </div>
            <nav class="menu">
                <?php

                echo $toolbox->renderMenu();
                ?>
            </nav>
            <div class="sidebar-footer">
                <p class="copyright">© 2025 工具箱</p>
            </div>
        </aside>

        <!-- 主内容区 -->
        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h2>安兔兔设备性能榜</h2>
                    <p>获取最新的多平台设备性能排名数据</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">

                    <div class="system-selector">
                        <button class="system-btn active" data-system="android">安卓</button>
                        <button class="system-btn" data-system="ios">苹果</button>
                        <button class="system-btn" data-system="pc">电脑</button>
                        <button class="system-btn" data-system="pad">平板</button>
                    </div>
                    

                    <div class="data-header">
                        <div class="data-info">
                            <div class="info-item">
                                <span>榜单标题：</span>
                                <span id="title">安兔兔设备性能榜</span>
                            </div>
                            <div class="info-item">
                                <span>设备数量：</span>
                                <span id="device-count">--</span>
                            </div>
                            <div class="info-item">
                                <span>更新时间：</span>
                                <span id="update-time">--</span>
                            </div>
                        </div>
                        <button class="refresh-btn" id="refresh-btn">
                            <span class="refresh-icon">↻</span>
                            <span>刷新数据</span>
                        </button>
                    </div>
                    

                    <div class="table-container" id="table-container">
                        <table class="antutu-table" id="antutu-table">
                            <thead>
                                <tr>
                                    <th>排名</th>
                                    <th>设备名称</th>
                                    <th>配置</th>
                                    <th>CPU分数</th>
                                    <th>GPU分数</th>
                                    <th>MEM分数</th>
                                    <th>UX分数</th>
                                    <th>综合总分</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">

                            </tbody>
                        </table>
                    </div>
                    

                    <div class="loading-container" id="loading-container" style="display: none;">
                        <div class="loading"></div>
                        <p>正在获取数据，请稍候...</p>
                    </div>
                    

                    <div class="error-container" id="error-container" style="display: none;">
                        <p id="error-message">获取数据失败，请稍后重试</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
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
        

        class AntutuPerformance {
            constructor() {
    
                this.systemBtns = document.querySelectorAll('.system-btn');
                this.refreshBtn = document.getElementById('refresh-btn');
                this.tableBody = document.getElementById('table-body');
                this.tableContainer = document.getElementById('table-container');
                this.loadingContainer = document.getElementById('loading-container');
                this.errorContainer = document.getElementById('error-container');
                this.errorMessage = document.getElementById('error-message');
                this.title = document.getElementById('title');
                this.deviceCount = document.getElementById('device-count');
                this.updateTime = document.getElementById('update-time');
                
    
                this.apiUrl = 'https://api.jkyai.top/API/attxnb.php';
                
    
                this.currentSystem = 'android';
                
    
                this.init();
            }
            

            init() {
    
                this.initEventListeners();
                
    
                this.fetchData();
            }
            

            initEventListeners() {
    
                this.systemBtns.forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const system = e.target.dataset.system;
                        this.selectSystem(system);
                    });
                });
                
    
                this.refreshBtn.addEventListener('click', () => {
                    this.fetchData();
                });
            }
            

            selectSystem(system) {
    
                this.currentSystem = system;
                
    
                this.systemBtns.forEach(btn => {
                    btn.classList.remove('active');
                    if (btn.dataset.system === system) {
                        btn.classList.add('active');
                    }
                });
                
    
                this.fetchData();
            }
            

            async fetchData() {
    
                this.showLoading();
                
    
                const startTime = Date.now();
                
                try {
        
                    const requestUrl = `${this.apiUrl}?msg=${this.currentSystem}`;
                    console.log('请求URL:', requestUrl);
                    
        
                    const response = await fetch(requestUrl, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    console.log('响应状态:', response.status);
                    console.log('响应头:', response.headers);
                    
        
                    const responseTime = (Date.now() - startTime) / 1000;
                    
        
                    if (!response.ok) {
            
                        await recordToolUsage('antutu-performance', '获取性能榜数据', 'error', responseTime, `HTTP错误! 状态码: ${response.status}`);
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    console.log('响应数据:', data);
                    
        
                    if (data.success && data.data) {
                        this.showData(data);
            
                        await recordToolUsage('antutu-performance', '获取性能榜数据', 'success', responseTime, this.currentSystem);
                    } else {
                        this.showError(data.message || '获取数据失败');
            
                        await recordToolUsage('antutu-performance', '获取性能榜数据', 'error', responseTime, `${this.currentSystem} - ${data.message || '获取数据失败'}`);
                    }
                } catch (error) {
                    console.error('获取数据失败:', error);
                    console.error('错误详情:', error.stack);
                    this.showError(`获取数据失败: ${error.message}`);
        
                    const responseTime = (Date.now() - startTime) / 1000;
        
                    await recordToolUsage('antutu-performance', '获取性能榜数据', 'error', responseTime, `${this.currentSystem} - ${error.message}`);
                }
            }
            

            showData(data) {
    
                this.title.textContent = data.data.title || '安兔兔设备性能榜';
                this.deviceCount.textContent = data.data.total_count || 0;
                this.updateTime.textContent = new Date().toLocaleString();
                
    
                this.tableBody.innerHTML = '';
                
    
                const rankings = data.data.rankings || [];
                if (rankings.length > 0) {
                    rankings.forEach((device) => {
                        const row = this.createTableRow(device);
                        this.tableBody.appendChild(row);
                    });
                } else {
        
                    this.tableBody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px; color: #666;">暂无数据</td></tr>';
                }
                
    
                this.hideLoading();
                this.tableContainer.style.display = 'block';
            }
            

            createTableRow(device) {
                const row = document.createElement('tr');
                
    
                const rankClass = device.rank <= 3 ? 'rank top3' : 'rank';
                
                row.innerHTML = `
                    <td><span class="${rankClass}">${device.rank}</span></td>
                    <td><span class="device-name">${device.name}</span></td>
                    <td><span class="config-info">${device.config}</span></td>
                    <td><span class="score">${device.cpu_score || '--'}</span></td>
                    <td><span class="score">${device.gpu_score || '--'}</span></td>
                    <td><span class="score">${device.mem_score || '--'}</span></td>
                    <td><span class="score">${device.ux_score || '--'}</span></td>
                    <td><span class="total-score">${device.total_score || '--'}</span></td>
                `;
                
                return row;
            }
            

            showLoading() {
                this.tableContainer.style.display = 'none';
                this.errorContainer.style.display = 'none';
                this.loadingContainer.style.display = 'block';
                this.refreshBtn.classList.add('loading');
            }
            

            hideLoading() {
                this.loadingContainer.style.display = 'none';
                this.refreshBtn.classList.remove('loading');
            }
            

            showError(message) {
                this.errorMessage.textContent = message;
                this.tableContainer.style.display = 'none';
                this.loadingContainer.style.display = 'none';
                this.errorContainer.style.display = 'block';
                this.refreshBtn.classList.remove('loading');
            }
        }
        

        document.addEventListener('DOMContentLoaded', () => {
            new AntutuPerformance();
        });
    </script>
</body>
</html>