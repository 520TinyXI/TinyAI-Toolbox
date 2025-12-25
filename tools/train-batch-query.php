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
    <title>火车批次查询 - <?php echo $siteConfig['name']; ?></title>
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
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            align-items: end;
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
        
        .form-input,
        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .form-input:focus,
        .form-select:focus {
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
            justify-content: center;
            gap: 8px;
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
        

        .swap-container {
            display: flex;
            justify-content: center;
        }
        
        .swap-btn {
            width: 48px;
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
        

        .result-section {
            margin-bottom: 30px;
        }
        
        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .result-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .result-meta {
            font-size: 14px;
            color: #666;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        

        .train-list {
            margin-bottom: 20px;
        }
        

        .train-card {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 16px;
            overflow: hidden;
        }
        
        .train-header {
            background-color: #fff;
            padding: 16px 24px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .train-info {
            display: flex;
            gap: 32px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .train-number {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .train-stations {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .station {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .station-separator {
            color: #666;
            font-size: 14px;
        }
        
        .train-times {
            display: flex;
            gap: 16px;
            align-items: center;
        }
        
        .time {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .time-separator {
            color: #666;
            font-size: 14px;
        }
        
        .duration {
            font-size: 14px;
            color: #666;
        }
        

        .seat-section {
            padding: 16px 24px;
        }
        
        .seat-title {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 12px;
        }
        
        .seat-list {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }
        
        .seat-item {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 12px 16px;
            min-width: 120px;
            text-align: center;
        }
        
        .seat-name {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 4px;
        }
        
        .seat-price {
            font-size: 16px;
            font-weight: 700;
            color: #d63031;
            margin-bottom: 4px;
        }
        
        .seat-residue {
            font-size: 12px;
            color: #666;
        }
        
        .seat-residue.low {
            color: #d63031;
            font-weight: 600;
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
            
            .query-form {
                grid-template-columns: 1fr;
            }
            
            .train-info {
                gap: 16px;
            }
            
            .train-stations {
                gap: 8px;
            }
            
            .train-times {
                gap: 8px;
            }
            
            .result-meta {
                flex-direction: column;
                gap: 8px;
            }
            
            .seat-list {
                gap: 12px;
            }
            
            .seat-item {
                min-width: 100px;
                padding: 10px 12px;
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
                    <h2>火车批次查询</h2>
                    <p>查询全国火车和高铁班次信息</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">

                    <div class="error-container" id="error-container" style="display: none;">
                        <div class="error-message" id="error-message">查询失败，请稍后重试</div>
                    </div>
                    

                    <div class="query-section">
                        <form class="query-form" id="query-form">
                            <div class="form-group">
                                <label for="go" class="form-label">出发城市</label>
                                <input type="text" id="go" name="go" class="form-input" placeholder="请输入出发城市" value="长沙" required>
                            </div>
                            
                            <div class="swap-container">
                                <button type="button" class="swap-btn" id="swap-btn" title="交换出发和到达城市">↔️</button>
                            </div>
                            
                            <div class="form-group">
                                <label for="to" class="form-label">到达城市</label>
                                <input type="text" id="to" name="to" class="form-input" placeholder="请输入到达城市" value="北京" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="form" class="form-label">列车类型</label>
                                <select id="form" name="form" class="form-select">
                                    <option value="">全部</option>
                                    <option value="高铁">高铁</option>
                                    <option value="火车">火车</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="time" class="form-label">查询日期</label>
                                <input type="date" id="time" name="time" class="form-input">
                            </div>
                            
                            <div class="form-group">
                                <label for="count" class="form-label">返回条数</label>
                                <select id="count" name="count" class="form-select">
                                    <option value="10">10条</option>
                                    <option value="20">20条</option>
                                    <option value="30">30条</option>
                                    <option value="50">50条</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="query-btn">
                                    <span class="loading-icon" style="display: none;">🔄</span>
                                    查询火车班次
                                </button>
                            </div>
                        </form>
                    </div>
                    

                    <div class="result-section" id="result-section" style="display: none;">

                        <div class="result-header">
                            <h3 class="result-title">查询结果</h3>
                            <div class="result-meta" id="result-meta">
                                <span id="meta-go"></span>
                                <span id="meta-to"></span>
                                <span id="meta-date"></span>
                                <span id="meta-total"></span>
                            </div>
                        </div>
                        

                        <div class="train-list" id="train-list"></div>
                    </div>
                    

                    <div class="loading-container" id="loading-container" style="display: none;">
                        <div class="loading"></div>
                        <p>正在查询火车班次，请稍候...</p>
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
        
        class TrainBatchQuery {
            constructor() {
                this.queryForm = document.getElementById('query-form');
                this.goInput = document.getElementById('go');
                this.toInput = document.getElementById('to');
                this.swapBtn = document.getElementById('swap-btn');
                this.queryBtn = document.getElementById('query-btn');
                this.loadingIcon = this.queryBtn.querySelector('.loading-icon');
                this.resultSection = document.getElementById('result-section');
                this.resultMeta = document.getElementById('result-meta');
                this.metaGo = document.getElementById('meta-go');
                this.metaTo = document.getElementById('meta-to');
                this.metaDate = document.getElementById('meta-date');
                this.metaTotal = document.getElementById('meta-total');
                this.trainList = document.getElementById('train-list');
                this.loadingContainer = document.getElementById('loading-container');
                this.errorContainer = document.getElementById('error-container');
                this.errorMessage = document.getElementById('error-message');
                
                this.apiUrl = 'https://api.jkyai.top/API/hcpccx.php';
                
                this.init();
            }
            
            init() {
                this.initEventListeners();
                
                this.setDefaultDate();
            }
            
            setDefaultDate() {
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('time').value = today;
            }
            
            initEventListeners() {
                this.queryForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.queryTrains();
                });
                
                this.swapBtn.addEventListener('click', () => {
                    this.swapCities();
                });
            }
            
            swapCities() {
                const temp = this.goInput.value;
                this.goInput.value = this.toInput.value;
                this.toInput.value = temp;
            }
            
            async queryTrains() {
                const formData = new FormData(this.queryForm);
                const go = formData.get('go').trim();
                const to = formData.get('to').trim();
                const type = formData.get('form');
                const time = formData.get('time');
                const count = formData.get('count');
                
                if (!go || !to) {
                    this.showError('Please fill in departure and arrival cities');
                    return;
                }
                
                this.showLoading();
                
                const startTime = Date.now();
                
                try {
                    const params = new URLSearchParams();
                    params.append('go', go);
                    params.append('to', to);
                    if (type) params.append('form', type);
                    if (time) params.append('time', time);
                    if (count) params.append('count', count);
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
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    console.log('Response data:', data);
                    
                    const responseTime = Date.now() - startTime;
                    
                    if (data.code === 200) {
                        this.showResults(data.data);
                        await recordToolUsage('train-batch-query', 'query', 1, responseTime, `${go}to${to}`);
                    } else {
                        this.showError(data.message || 'Query failed');
                        await recordToolUsage('train-batch-query', 'query', 0, responseTime, `${go}to${to}`);
                    }
                } catch (error) {
                    console.error('Query failed:', error);
                    this.showError(`Query failed: ${error.message}`);
                    const responseTime = Date.now() - startTime;
                    await recordToolUsage('train-batch-query', 'query', 0, responseTime, `${go}to${to}`);
                }
            }
            
            showResults(data) {
                this.metaGo.textContent = `Departure: ${data.meta.go}`;
                this.metaTo.textContent = `Arrival: ${data.meta.to}`;
                this.metaDate.textContent = `Query Date: ${data.meta.queryDate}`;
                this.metaTotal.textContent = `Total ${data.meta.total} trains, showing ${data.list ? data.list.length : 0}`;
                
                this.trainList.innerHTML = '';
                
                if (data.list && data.list.length > 0) {
                    data.list.forEach(train => {
                        const card = this.createTrainCard(train);
                        this.trainList.appendChild(card);
                    });
                } else {
                    this.trainList.innerHTML = '<div style="text-align: center; padding: 40px; color: #666;">No data available</div>';
                }
                
                this.hideLoading();
                this.resultSection.style.display = 'block';
            }
            
            createTrainCard(train) {
                const card = document.createElement('div');
                card.className = 'train-card';
                
                let seatHtml = '';
                if (train.SeatList && train.SeatList.length > 0) {
                    seatHtml = `
                        <div class="seat-section">
                            <div class="seat-title">Seat Information</div>
                            <div class="seat-list">
                                ${train.SeatList.map(seat => {
                                    const residueClass = parseInt(seat.SeatResidue) < 10 ? 'low' : '';
                                    return `
                                        <div class="seat-item">
                                            <div class="seat-name">${seat.SeatName}</div>
                                            <div class="seat-price">¥${seat.SeatPrice}</div>
                                            <div class="seat-residue ${residueClass}">${seat.SeatResidue} seats left</div>
                                        </div>
                                    `;
                                }).join('')}
                            </div>
                        </div>
                    `;
                }
                
                card.innerHTML = `
                    <div class="train-header">
                        <div class="train-info">
                            <div class="train-number">${train.TrainNumber}</div>
                            <div class="train-stations">
                                <div class="station">${train.Start}</div>
                                <div class="station-separator">→</div>
                                <div class="station">${train.End}</div>
                            </div>
                            <div class="train-times">
                                <div class="time">${train.DepartTime}</div>
                                <div class="time-separator">→</div>
                                <div class="time">${train.ArriveTime}</div>
                                <div class="duration">${train.Duration}</div>
                            </div>
                        </div>
                    </div>
                    ${seatHtml}
                `;
                
                return card;
            }
            
            showLoading() {
                this.queryBtn.disabled = true;
                this.loadingIcon.style.display = 'inline';
                this.resultSection.style.display = 'none';
                this.errorContainer.style.display = 'none';
                this.loadingContainer.style.display = 'block';
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
            new TrainBatchQuery();
        });
    </script>
</body>
</html>