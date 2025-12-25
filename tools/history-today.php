<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>历史上的今天 - 工具箱</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 800px;
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
        
        
        .date-section {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 8px;
        }
        
        .current-date {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        
        .refresh-section {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
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
        
        
        .events-section {
            margin-bottom: 20px;
        }
        
        .events-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .events-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .event-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 20px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .event-item:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
            transform: translateX(8px);
        }
        
        .event-year {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .event-content {
            font-size: 16px;
            color: #333;
            line-height: 1.5;
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
            
            .current-date {
                font-size: 20px;
            }
            
            .event-item {
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
                    <h2>历史上的今天</h2>
                    <p>探索历史上今天发生的重要事件</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    
                    <div class="date-section">
                        <div class="current-date" id="current-date"></div>
                    </div>
                    
                    
                    <div class="refresh-section">
                        <button class="btn btn-primary" id="refresh-btn">刷新数据</button>
                    </div>
                    
                    
                    <div class="events-section">
                        <div class="events-title">历史事件</div>
                        <div class="events-list" id="events-list">
                            
                        </div>
                    </div>
                    
                    
                    <div id="loading" class="loading" style="display: none;">
                        正在获取数据，请稍候...
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
                    tool_id: 'history-today',
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

        
        class HistoryToday {
            constructor() {
                this.currentDateElement = document.getElementById('current-date');
                this.refreshBtn = document.getElementById('refresh-btn');
                this.eventsList = document.getElementById('events-list');
                this.loading = document.getElementById('loading');
                this.error = document.getElementById('error');
                
                
                this.apiUrl = '../php/history-proxy.php';
                
                
                this.init();
            }
            
            
            init() {
                
                this.displayCurrentDate();
                
                
                this.initEventListeners();
                
                
                this.fetchHistoryEvents();
            }
            
            
            initEventListeners() {
                
                this.refreshBtn.addEventListener('click', () => {
                    this.fetchHistoryEvents();
                });
            }
            
            
            displayCurrentDate() {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const dateStr = `${year}年${month}月${day}日`;
                this.currentDateElement.textContent = dateStr;
            }
            
            
            async fetchHistoryEvents() {
                
                this.showLoading();
                
                
                const startTime = Date.now();
                
                try {
                    
                    const response = await fetch(`${this.apiUrl}?type=json`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    
                    if (data.code === 200) {
                        this.showEvents(data);
                        
                        recordToolUsage('fetch_events', 'success', {
                            api_code: data.code,
                            event_count: data.data ? data.data.length : 0
                        }, responseTime);
                    } else {
                        this.showError(data.msg || '获取数据失败');
                        console.error('API返回错误:', data);
                        
                        recordToolUsage('fetch_events', 'error', {
                            api_code: data.code || 500,
                            error_msg: data.msg || '获取数据失败'
                        }, responseTime);
                    }
                } catch (error) {
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.showError(`获取数据失败: ${error.message}`);
                    console.error('API请求错误:', error);
                    
                    recordToolUsage('fetch_events', 'error', {
                        error_msg: error.message,
                        exception: error.message
                    }, responseTime);
                }
            }
            
            
            showEvents(data) {
                
                this.eventsList.innerHTML = '';
                
                
                this.currentDateElement.textContent = data.time;
                
                
                data.data.forEach(event => {
                    
                    const yearMatch = event.match(/^(\d+年)/);
                    const year = yearMatch ? yearMatch[1] : '未知年份';
                    const content = event;
                    
                    const eventItem = document.createElement('div');
                    eventItem.className = 'event-item';
                    
                    const eventYear = document.createElement('div');
                    eventYear.className = 'event-year';
                    eventYear.textContent = year;
                    
                    const eventContent = document.createElement('div');
                    eventContent.className = 'event-content';
                    eventContent.textContent = content;
                    
                    eventItem.appendChild(eventYear);
                    eventItem.appendChild(eventContent);
                    this.eventsList.appendChild(eventItem);
                });
                
                
                this.hideLoading();
            }
            
            
            showLoading() {
                this.loading.style.display = 'block';
                this.error.style.display = 'none';
                this.eventsList.innerHTML = '';
            }
            
            
            hideLoading() {
                this.loading.style.display = 'none';
                this.error.style.display = 'none';
            }
            
            
            showError(message) {
                this.error.textContent = message;
                this.loading.style.display = 'none';
                this.error.style.display = 'block';
                this.eventsList.innerHTML = '';
            }
        }
        
        
        document.addEventListener('DOMContentLoaded', () => {
            new HistoryToday();
        });
    </script>
</body>
</html>