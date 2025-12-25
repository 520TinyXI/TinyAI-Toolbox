<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>历史人物年轮详情 - 工具箱</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 1000px;
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
        
        
        .person-info {
            background-color: #fafafa;
            padding: 24px;
            border-radius: 8px;
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
        }
        
        .person-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .person-name {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .person-dynasty {
            font-size: 16px;
            color: #666;
            padding: 4px 8px;
            border-radius: 4px;
            background-color: #e0e0e0;
        }
        
        .person-desc {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .person-details {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 16px;
        }
        
        .detail-item {
            background-color: #fff;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        
        .detail-label {
            font-size: 14px;
            color: #999;
            margin-bottom: 8px;
            display: block;
        }
        
        .detail-value {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        
        .yearsmap-section {
            margin-bottom: 30px;
        }
        
        .yearsmap-title {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .yearsmap-content {
            background-color: #fafafa;
            padding: 24px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            max-height: 600px;
            overflow-y: auto;
        }
        
        .year-event {
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .year-event:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .event-year {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .event-content {
            font-size: 16px;
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
                flex-direction: column;
                align-items: stretch;
            }
            
            .form-group {
                min-width: auto;
            }
            
            .person-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            
            .person-details {
                grid-template-columns: 1fr;
            }
            
            .person-name {
                font-size: 20px;
            }
            
            .yearsmap-content {
                max-height: 400px;
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
                    <h2>历史人物年轮详情</h2>
                    <p>查询历史人物的详细信息和年轮记录</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    
                    <div class="query-section">
                        <form class="query-form" id="query-form">
                            <div class="form-group">
                                <label class="form-label" for="person-name">历史人物名</label>
                                <input type="text" id="person-name" class="form-input" placeholder="请输入历史人物名，例如：曹操" required>
                            </div>
                            <button type="submit" class="btn btn-primary" id="search-btn" style="align-self: flex-end;">
                                查询
                            </button>
                        </form>
                    </div>
                    
                    
                    <div class="person-info" id="person-info" style="display: none;">
                        <div class="person-header">
                            <div class="person-name" id="person-name-display"></div>
                            <div class="person-dynasty" id="person-dynasty"></div>
                        </div>
                        <div class="person-desc" id="person-desc"></div>
                        <div class="person-details" id="person-details"></div>
                    </div>
                    
                    
                    <div class="yearsmap-section" id="yearsmap-section" style="display: none;">
                        <div class="yearsmap-title">年轮详情</div>
                        <div class="yearsmap-content" id="yearsmap-content"></div>
                    </div>
                    
                    
                    <div id="loading" class="loading" style="display: none;">
                        正在查询历史人物信息，请稍候...
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
                    tool_id: 'history-person',
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

        
        class HistoryPersonTool {
            constructor() {
                this.queryForm = document.getElementById('query-form');
                this.personNameInput = document.getElementById('person-name');
                this.searchBtn = document.getElementById('search-btn');
                this.personInfo = document.getElementById('person-info');
                this.personNameDisplay = document.getElementById('person-name-display');
                this.personDynasty = document.getElementById('person-dynasty');
                this.personDesc = document.getElementById('person-desc');
                this.personDetails = document.getElementById('person-details');
                this.yearsmapSection = document.getElementById('yearsmap-section');
                this.yearsmapContent = document.getElementById('yearsmap-content');
                this.loading = document.getElementById('loading');
                this.error = document.getElementById('error');
                
                
                this.apiUrl = '../php/history-person-proxy.php';
                
                
                this.init();
            }
            
            
            init() {
                
                this.initEventListeners();
            }
            
            
            initEventListeners() {
                
                this.queryForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.searchPerson();
                });
            }
            
            
            async searchPerson() {
                const name = this.personNameInput.value.trim();
                if (!name) {
                    this.showError('请输入历史人物名');
                    return;
                }
                
                
                this.showLoading();
                
                
                const startTime = Date.now();
                
                try {
                    
                    const response = await fetch(`${this.apiUrl}?name=${encodeURIComponent(name)}`, {
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
                        this.showPersonInfo(data);
                        
                        recordToolUsage('search_person', 'success', {
                            api_code: data.code,
                            person_name: name,
                            person_count: data.data ? data.data.length : 0
                        }, responseTime);
                    } else {
                        this.showError(data.msg || '获取数据失败');
                        
                        recordToolUsage('search_person', 'error', {
                            api_code: data.code || 500,
                            person_name: name,
                            error_msg: data.msg || '获取数据失败'
                        }, responseTime);
                    }
                } catch (error) {
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.showError(`获取数据失败: ${error.message}`);
                    console.error('API请求错误:', error);
                    
                    recordToolUsage('search_person', 'error', {
                        person_name: name,
                        error_msg: error.message,
                        exception: error.message
                    }, responseTime);
                }
            }
            
            
            showPersonInfo(data) {
                
                const person = data.data[0];
                
                
                this.personNameDisplay.textContent = person.name;
                this.personDynasty.textContent = person.dynasty;
                this.personDesc.textContent = person.desc;
                
                
                this.personDetails.innerHTML = '';
                person.info.forEach(info => {
                    const detailItem = document.createElement('div');
                    detailItem.className = 'detail-item';
                    
                    
                    const colonIndex = info.indexOf('：');
                    if (colonIndex > -1) {
                        const label = info.substring(0, colonIndex).trim();
                        const value = info.substring(colonIndex + 1).trim();
                        detailItem.innerHTML = `
                            <span class="detail-label">${label}</span>
                            <span class="detail-value">${value}</span>
                        `;
                    } else {
                        detailItem.innerHTML = `
                            <span class="detail-label">信息</span>
                            <span class="detail-value">${info}</span>
                        `;
                    }
                    
                    this.personDetails.appendChild(detailItem);
                });
                
                
                this.updateYearsmap(person.event);
                
                
                this.personInfo.style.display = 'block';
                this.yearsmapSection.style.display = 'block';
                
                
                this.hideLoading();
            }
            
            
            updateYearsmap(events) {
                this.yearsmapContent.innerHTML = '';
                
                events.forEach(event => {
                    const yearEvent = document.createElement('div');
                    yearEvent.className = 'year-event';
                    
                    
                    const arrowIndex = event.indexOf(' ----> ');
                    if (arrowIndex > -1) {
                        const year = event.substring(0, arrowIndex).trim();
                        const content = event.substring(arrowIndex + 6).trim();
                        yearEvent.innerHTML = `
                            <div class="event-year">${year}</div>
                            <div class="event-content">${content}</div>
                        `;
                    } else {
                        yearEvent.innerHTML = `
                            <div class="event-year">未知年份</div>
                            <div class="event-content">${event}</div>
                        `;
                    }
                    
                    this.yearsmapContent.appendChild(yearEvent);
                });
            }
            
            
            showLoading() {
                this.loading.style.display = 'block';
                this.error.style.display = 'none';
                this.personInfo.style.display = 'none';
                this.yearsmapSection.style.display = 'none';
            }
            
            
            hideLoading() {
                this.loading.style.display = 'none';
                this.error.style.display = 'none';
            }
            
            
            showError(message) {
                this.error.textContent = message;
                this.loading.style.display = 'none';
                this.personInfo.style.display = 'none';
                this.yearsmapSection.style.display = 'none';
                this.error.style.display = 'block';
            }
        }
        
        
        document.addEventListener('DOMContentLoaded', () => {
            new HistoryPersonTool();
        });
    </script>
</body>
</html>