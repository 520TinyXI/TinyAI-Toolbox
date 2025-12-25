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
    <title>车辆信息查询 - <?php echo $siteConfig['name']; ?></title>
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
            margin-bottom: 24px;
            border: 1px solid #e0e0e0;
        }
        
        .form-row {
            display: flex;
            gap: 16px;
            align-items: flex-end;
            flex-wrap: wrap;
        }
        
        .form-group {
            flex: 1;
            min-width: 300px;
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
            box-sizing: border-box;
            height: 48px;
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
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 48px;
            box-sizing: border-box;
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
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        
        .result-section {
            margin-bottom: 30px;
        }
        
        .result-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        
        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
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
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .car-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }
        
        .car-info {
            padding: 16px;
        }
        
        .car-brand {
            font-size: 12px;
            font-weight: 600;
            color: #666;
            margin-bottom: 4px;
        }
        
        .car-name {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .car-price {
            font-size: 16px;
            font-weight: 700;
            color: #d63031;
            margin-bottom: 8px;
        }
        
        .car-level {
            font-size: 14px;
            color: #666;
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
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        
        .error-container {
            background-color: #fff3f3;
            border: 1px solid #ffe0e0;
            border-radius: 8px;
            padding: 20px;
            color: #d63031;
            margin-bottom: 30px;
        }
        
        .error-message {
            font-size: 16px;
        }
        
        
        @media (max-width: 768px) {
            .tool-container {
                padding: 20px 16px;
            }
            
            .tool-content {
                padding: 20px;
            }
            
            .form-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .form-group {
                min-width: auto;
            }
            
            .car-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            
            .car-image {
                height: 180px;
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
                    <h2>车辆信息查询</h2>
                    <p>查询车辆品牌、系列、价格等详细信息</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">

                    <div class="error-container" id="error-container" style="display: none;">
                        <div class="error-message" id="error-message">查询失败，请稍后重试</div>
                    </div>
                    

                    <div class="query-section">
                        <form id="query-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="msg" class="form-label">车辆名称/品牌</label>
                                    <input type="text" id="msg" name="msg" class="form-input" placeholder="请输入车辆名称或品牌，例如：问界、比亚迪" required>
                                </div>
                                <button type="submit" class="btn btn-primary" id="query-btn">
                                    <span class="loading-icon" style="display: none;">🔄</span>
                                    查询车辆信息
                                </button>
                            </div>
                        </form>
                    </div>
                    

                    <div class="result-section" id="result-section" style="display: none;">
                        <h3 class="result-title">查询结果</h3>
                        

                        <div class="car-grid" id="car-grid"></div>
                    </div>
                    

                    <div class="loading-container" id="loading-container" style="display: none;">
                        <div class="loading"></div>
                        <p>正在查询车辆信息，请稍候...</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        async function recordToolUsage(toolId, action, statusValue, responseTime = 0, content = '') {
            try {
                const status = statusValue === 1 ? 'success' : 'error';
                
                const contentObj = {
                    action: action
                };
                
                const responseTimeSeconds = responseTime / 1000;
                
                await fetch('../php/record-tool-usage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        tool_id: toolId,
                        content: contentObj,
                        status: status,
                        response_time: responseTimeSeconds
                    })
                });
            } catch (error) {
                console.error('Failed to record tool usage:', error);
            }
        }
        
        class CarInfoQuery {
            constructor() {
                this.queryForm = document.getElementById('query-form');
                this.msgInput = document.getElementById('msg');
                this.queryBtn = document.getElementById('query-btn');
                this.loadingIcon = this.queryBtn.querySelector('.loading-icon');
                this.resultSection = document.getElementById('result-section');
                this.carGrid = document.getElementById('car-grid');
                this.loadingContainer = document.getElementById('loading-container');
                this.errorContainer = document.getElementById('error-container');
                this.errorMessage = document.getElementById('error-message');
                
                this.apiUrl = 'https://api.jkyai.top/API/clxxcx.php';
                
                this.init();
            }
            
            init() {
                this.initEventListeners();
            }
            
            initEventListeners() {
                this.queryForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.queryCarInfo();
                });
            }
            
            async queryCarInfo() {
                const msg = this.msgInput.value.trim();
                
                if (!msg) {
                    this.showError('Please enter vehicle name or brand');
                    return;
                }
                
                this.showLoading();
                
                const startTime = Date.now();
                
                try {
                    const params = new URLSearchParams();
                    params.append('msg', msg);
                    params.append('type', 'json');
                    
                    const requestUrl = `${this.apiUrl}?${params.toString()}`;
                    console.log('Request URL:', requestUrl);
                    
                    const response = await fetch(requestUrl, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP Error! Status code: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    console.log('Response data:', data);
                    
                    const responseTime = Date.now() - startTime;
                    
                    if ((data.code === 200 || data.code === 201) && data.data) {
                        this.showResults(data.data);
                        await recordToolUsage('car-info', 'query_car_info', 1, responseTime, `Query vehicle info: ${msg}`);
                    } else {
                        this.showError(data.message || 'Query failed');
                        await recordToolUsage('car-info', 'query_car_info', 0, responseTime, `Query vehicle info: ${msg}`);
                    }
                } catch (error) {
                    console.error('Query failed:', error);
                    this.showError(`Query failed: ${error.message}`);
                    const responseTime = Date.now() - startTime;
                    await recordToolUsage('car-info', 'query_car_info', 0, responseTime, `Query vehicle info: ${msg}`);
                }
            }
            
            showResults(carList) {
                this.carGrid.innerHTML = '';
                
                if (carList.length > 0) {
                    carList.forEach(car => {
                        const card = this.createCarCard(car);
                        this.carGrid.appendChild(card);
                    });
                } else {
                    this.carGrid.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">No vehicle information found</div>';
                }
                
                this.hideLoading();
                this.resultSection.style.display = 'block';
            }
            
            createCarCard(car) {
                const card = document.createElement('div');
                card.className = 'car-card';
                
                card.innerHTML = `
                    <img src="${car.white_pic_url || 'https://via.placeholder.com/320x200'}" alt="${car.series_name || 'Vehicle Image'}" class="car-image">
                    <div class="car-info">
                        <div class="car-brand">${car.brand_name || 'Unknown Brand'}</div>
                        <div class="car-name">${car.series_name || 'Unknown Model'}</div>
                        <div class="car-price">${car.official_price || 'Price Negotiable'}</div>
                        <div class="car-level">${car.level || 'Unknown Level'}</div>
                    </div>
                `;
                
                return card;
            }
            
            showLoading() {
                this.queryBtn.disabled = true;
                this.loadingIcon.style.display = 'inline';
                this.loadingContainer.style.display = 'block';
                this.resultSection.style.display = 'none';
                this.errorContainer.style.display = 'none';
            }
            
            hideLoading() {
                this.queryBtn.disabled = false;
                this.loadingIcon.style.display = 'none';
                this.loadingContainer.style.display = 'none';
            }
            
            showError(message) {
                this.errorMessage.textContent = message;
                this.errorContainer.style.display = 'block';
                this.resultSection.style.display = 'none';
                this.loadingContainer.style.display = 'none';
                this.queryBtn.disabled = false;
                this.loadingIcon.style.display = 'none';
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new CarInfoQuery();
        });
    </script>
</body>
</html>