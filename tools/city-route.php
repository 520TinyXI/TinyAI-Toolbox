<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>城市路线查询 - 工具箱</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 900px;
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
            background-color: #fafafa;
            padding: 24px;
            border-radius: 8px;
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
        }
        
        .query-form {
            display: grid;
            grid-template-columns: 1fr 80px 1fr;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .form-group {
            min-width: 150px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 2px rgba(26, 26, 26, 0.1);
        }
        

        .swap-btn {
            width: 80px;
            height: 48px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #fafafa;
            color: #1a1a1a;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            align-self: flex-end;
        }
        
        .swap-btn:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
        }
        

        .btn {
            padding: 12px 24px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #fafafa;
            color: #1a1a1a;
        }
        
        .btn:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
        }
        
        .btn-primary {
            background-color: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
        }
        
        .btn-primary:hover {
            background-color: #333;
        }
        

        .route-info {
            background-color: #fafafa;
            padding: 24px;
            border-radius: 8px;
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
        }
        
        .route-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .route-title {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .route-distance {
            font-size: 16px;
            color: #666;
        }
        
        .route-stats {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }
        
        .stat-item {
            background-color: #fff;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            text-align: center;
        }
        
        .stat-label {
            font-size: 14px;
            color: #999;
            margin-bottom: 8px;
            display: block;
        }
        
        .stat-value {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
        }
        

        .route-details {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            margin-bottom: 30px;
        }
        
        .route-details-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 12px;
        }
        
        .route-path {
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }
        

        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        

        .error {
            padding: 16px;
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
            
            .query-form {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            
            .swap-btn {
                width: 100%;
                height: 48px;
            }
            
            .route-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 class="logo">工具箱</h1>
            </div>
            <nav class="menu">
                <?php
                require_once '../php/framework.php';
                
                echo $toolbox->renderMenu();
                ?>
            </nav>
            <div class="sidebar-footer">
                <p class="copyright">© 2025 工具箱</p>
            </div>
        </aside>


        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h2>城市路线查询</h2>
                    <p>搜索城市出行路线信息，包括距离、油耗、耗时、过路费和详细路线</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">

                    <div class="query-section">
                        <form class="query-form" id="query-form">
                            <div class="form-group">
                                <label class="form-label" for="from">出发地</label>
                                <input type="text" id="from" class="form-input" placeholder="请输入出发地，例如：广州" required>
                            </div>
                            <button type="button" class="swap-btn" id="swap-btn">🔄</button>
                            <div class="form-group">
                                <label class="form-label" for="to">目的地</label>
                                <input type="text" id="to" class="form-input" placeholder="请输入目的地，例如：深圳" required>
                            </div>
                            <div style="grid-column: 1 / -1; text-align: center;">
                                <button type="submit" class="btn btn-primary" id="search-btn">
                                    查询路线
                                </button>
                            </div>
                        </form>
                    </div>
                    

                    <div class="route-info" id="route-info" style="display: none;">
                        <div class="route-header">
                            <div class="route-title" id="route-title"></div>
                            <div class="route-distance" id="route-distance"></div>
                        </div>
                        <div class="route-stats" id="route-stats"></div>
                    </div>
                    

                    <div class="route-details" id="route-details" style="display: none;">
                        <div class="route-details-title">详细路线</div>
                        <div class="route-path" id="route-path"></div>
                    </div>
                    

                    <div id="loading" class="loading" style="display: none;">
                        正在查询路线信息，请稍候...
                    </div>
                    

                    <div id="error" class="error" style="display: none;"></div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        function recordToolUsage(action, status = 'success', content = null, responseTime = null) {
            fetch('../php/record-tool-usage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tool_id: 'city-route',
                    action: action,
                    content: content,
                    result: {
                        status: status
                    },
                    response_time: responseTime
                })
            }).catch(error => {
                console.error('Failed to record usage:', error);
            });
        }

        class CityRouteQuery {
            constructor() {
                this.queryForm = document.getElementById('query-form');
                this.fromInput = document.getElementById('from');
                this.toInput = document.getElementById('to');
                this.swapBtn = document.getElementById('swap-btn');
                this.searchBtn = document.getElementById('search-btn');
                this.routeInfo = document.getElementById('route-info');
                this.routeTitle = document.getElementById('route-title');
                this.routeDistance = document.getElementById('route-distance');
                this.routeStats = document.getElementById('route-stats');
                this.routeDetails = document.getElementById('route-details');
                this.routePath = document.getElementById('route-path');
                this.loading = document.getElementById('loading');
                this.error = document.getElementById('error');
                
                this.apiUrl = '../php/city-route-proxy.php';
                
                this.init();
            }
            
            init() {
                this.initEventListeners();
            }
            
            initEventListeners() {
                this.queryForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.searchRoute();
                });
                
                this.swapBtn.addEventListener('click', () => {
                    this.swapLocations();
                });
            }
            
            swapLocations() {
                const temp = this.fromInput.value;
                this.fromInput.value = this.toInput.value;
                this.toInput.value = temp;
            }
            
            async searchRoute() {
                const from = this.fromInput.value.trim();
                const to = this.toInput.value.trim();
                
                if (!from || !to) {
                    this.showError('Please enter departure and destination');
                    return;
                }
                
                this.showLoading();
                
                const startTime = Date.now();
                
                try {
                    const response = await fetch(`${this.apiUrl}?from=${encodeURIComponent(from)}&to=${encodeURIComponent(to)}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP Error! Status: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    if (data.code === 200) {
                        this.showRoute(data);
                        recordToolUsage('search_route', 'success', {
                            api_code: data.code,
                            from: from,
                            to: to,
                            distance: data.data ? data.data.distance : '',
                            time: data.data ? data.data.time : ''
                        }, responseTime);
                    } else {
                        this.showError(data.msg || 'Failed to get data');
                        recordToolUsage('search_route', 'error', {
                            api_code: data.code || 500,
                            from: from,
                            to: to,
                            error_msg: data.msg || 'Failed to get data'
                        }, responseTime);
                    }
                } catch (error) {
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.showError(`Failed to get data: ${error.message}`);
                    console.error('API request error:', error);
                    recordToolUsage('search_route', 'error', {
                        from: from,
                        to: to,
                        error_msg: error.message,
                        exception: error.message
                    }, responseTime);
                }
            }
            
            showRoute(data) {
                this.routeTitle.textContent = `${data.from} → ${data.to}`;
                this.routeDistance.textContent = data.data.distance;
                
                this.routeStats.innerHTML = `
                    <div class="stat-item">
                        <span class="stat-label">Duration</span>
                        <span class="stat-value">${data.data.time}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Fuel Cost</span>
                        <span class="stat-value">${data.data.fuelcosts}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Toll Fees</span>
                        <span class="stat-value">${data.data.bridgetoll}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Total Cost</span>
                        <span class="stat-value">${data.data.totalcost}</span>
                    </div>
                `;
                
                this.routePath.textContent = data.data.roadconditions;
                
                this.routeInfo.style.display = 'block';
                this.routeDetails.style.display = 'block';
                
                this.hideLoading();
            }
            
            showLoading() {
                this.loading.style.display = 'block';
                this.error.style.display = 'none';
                this.routeInfo.style.display = 'none';
                this.routeDetails.style.display = 'none';
            }
            
            hideLoading() {
                this.loading.style.display = 'none';
                this.error.style.display = 'none';
            }
            
            showError(message) {
                this.error.textContent = message;
                this.loading.style.display = 'none';
                this.routeInfo.style.display = 'none';
                this.routeDetails.style.display = 'none';
                this.error.style.display = 'block';
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new CityRouteQuery();
        });
    </script>
</body>
</html>