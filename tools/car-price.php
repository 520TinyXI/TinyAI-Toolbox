<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>车辆价格信息查询 - 工具箱</title>
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
            background-color: #fafafa;
            padding: 24px;
            border-radius: 8px;
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
        }
        
        .query-form {
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .form-group {
            flex: 1;
            min-width: 200px;
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
        
        
        .result-stats {
            margin-bottom: 20px;
            padding: 16px;
            background-color: #fafafa;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        
        .stats-text {
            font-size: 14px;
            color: #666;
        }
        
        .stats-highlight {
            font-weight: 600;
            color: #1a1a1a;
        }
        
        
        .car-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .car-card {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .car-card:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .car-image {
            width: 100%;
            height: 200px;
            object-fit: contain;
            background-color: #fff;
            padding: 20px;
        }
        
        .car-info {
            padding: 20px;
        }
        
        .car-name {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 12px;
            line-height: 1.4;
        }
        
        .car-prices {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        
        .price-retail {
            font-size: 14px;
            color: #999;
        }
        
        .price-dealer {
            font-size: 20px;
            font-weight: 700;
            color: #d63031;
        }
        
        .car-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .tag {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 4px;
            background-color: #e0e0e0;
            color: #666;
            font-weight: 500;
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
                flex-direction: column;
                align-items: stretch;
            }
            
            .form-group {
                min-width: auto;
            }
            
            .car-list {
                grid-template-columns: 1fr;
            }
            
            .car-image {
                height: 150px;
                padding: 16px;
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
                    <h2>车辆价格信息查询</h2>
                    <p>查询车辆的价格、配置和图片信息</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">

                    <div class="query-section">
                        <form class="query-form" id="query-form">
                            <div class="form-group">
                                <label class="form-label" for="search">车辆关键词</label>
                                <input type="text" id="search" class="form-input" placeholder="请输入车辆关键词，例如：帕萨特" required>
                            </div>
                            <button type="submit" class="btn btn-primary" id="search-btn" style="align-self: flex-end;">
                                查询
                            </button>
                        </form>
                    </div>
                    

                    <div class="result-stats" id="result-stats" style="display: none;">
                        <div class="stats-text">
                            共找到 <span class="stats-highlight" id="result-count">0</span> 条关于 "<span class="stats-highlight" id="search-keyword"></span>" 的车辆信息
                        </div>
                    </div>
                    

                    <div class="car-list" id="car-list">

                    </div>
                    

                    <div id="loading" class="loading" style="display: none;">
                        正在查询车辆价格信息，请稍候...
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
                    tool_id: 'car-price',
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

        class CarPriceQuery {
            constructor() {
                this.queryForm = document.getElementById('query-form');
                this.searchInput = document.getElementById('search');
                this.searchBtn = document.getElementById('search-btn');
                this.resultStats = document.getElementById('result-stats');
                this.resultCount = document.getElementById('result-count');
                this.searchKeyword = document.getElementById('search-keyword');
                this.carList = document.getElementById('car-list');
                this.loading = document.getElementById('loading');
                this.error = document.getElementById('error');
                
                this.apiUrl = '../php/car-proxy.php';
                
                this.init();
            }
            
            init() {
                this.initEventListeners();
            }
            
            initEventListeners() {
                this.queryForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.searchCar();
                });
            }
            
            async searchCar() {
                const search = this.searchInput.value.trim();
                if (!search) {
                    this.showError('Please enter a car keyword');
                    return;
                }
                
                this.showLoading();
                
                const startTime = Date.now();
                
                try {
                    const response = await fetch(`${this.apiUrl}?search=${encodeURIComponent(search)}`, {
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
                        this.showResults(data);
                        recordToolUsage('search_car', 'success', {
                            api_code: data.code,
                            search_keyword: search,
                            car_count: data.count || 0
                        }, responseTime);
                    } else {
                        this.showError(data.msg || 'Failed to get data');
                        recordToolUsage('search_car', 'error', {
                            api_code: data.code || 500,
                            search_keyword: search,
                            error_msg: data.msg || 'Failed to get data'
                        }, responseTime);
                    }
                } catch (error) {
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.showError(`Failed to get data: ${error.message}`);
                    console.error('API request error:', error);
                    recordToolUsage('search_car', 'error', {
                        search_keyword: search,
                        error_msg: error.message,
                        exception: error.message
                    }, responseTime);
                }
            }
            
            showResults(data) {
                this.resultCount.textContent = data.count;
                this.searchKeyword.textContent = data.car;
                this.resultStats.style.display = 'block';
                
                this.carList.innerHTML = '';
                
                data.data.forEach(car => {
                    const card = this.createCarCard(car);
                    this.carList.appendChild(card);
                });
                
                this.hideLoading();
            }
            
            createCarCard(car) {
                const card = document.createElement('div');
                card.className = 'car-card';
                
                card.innerHTML = `
                    <img src="${car.cover_url}" alt="${car.car_name}" class="car-image">
                    <div class="car-info">
                        <div class="car-name">${car.car_name}</div>
                        <div class="car-prices">
                            <div class="price-retail">Retail Price: ${car.price}</div>
                            <div class="price-dealer">${car.dealer_price}</div>
                        </div>
                        <div class="car-tags">
                            ${car.tags.map(tag => `<span class="tag">${tag}</span>`).join('')}
                        </div>
                    </div>
                `;
                
                return card;
            }
            
            showLoading() {
                this.loading.style.display = 'block';
                this.error.style.display = 'none';
                this.resultStats.style.display = 'none';
                this.carList.innerHTML = '';
            }
            
            hideLoading() {
                this.loading.style.display = 'none';
                this.error.style.display = 'none';
            }
            
            showError(message) {
                this.error.textContent = message;
                this.loading.style.display = 'none';
                this.resultStats.style.display = 'none';
                this.carList.innerHTML = '';
                this.error.style.display = 'block';
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new CarPriceQuery();
        });
    </script>
</body>
</html>