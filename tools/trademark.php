<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商标信息查询 - 工具箱</title>
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
        

        .trademark-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .trademark-card {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            transition: all 0.3s ease;
        }
        
        .trademark-card:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .trademark-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 16px;
        }
        
        .trademark-image {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #fff;
        }
        
        .trademark-info {
            flex: 1;
        }
        
        .trademark-name {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 4px;
        }
        
        .trademark-status {
            font-size: 14px;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
        }
        
        .status-registered {
            background-color: #e8f5e8;
            color: #2e7d32;
        }
        
        .status-pending {
            background-color: #fff3e0;
            color: #e65100;
        }
        
        .trademark-details {
            margin-top: 16px;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .detail-label {
            color: #666;
            font-weight: 500;
        }
        
        .detail-value {
            color: #1a1a1a;
            font-weight: 600;
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
            
            .trademark-list {
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
                    <h2>商标查询</h2>
                    <p>查询商标信息，包括注册状态、类别、申请人等</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">

                    <div class="query-section">
                        <form class="query-form" id="query-form">
                            <div class="form-group">
                                <label class="form-label" for="keyword">商标关键词</label>
                                <input type="text" id="keyword" class="form-input" placeholder="请输入商标关键词，例如：疯狂小杨哥" required>
                            </div>
                            <button type="submit" class="btn btn-primary" id="search-btn" style="align-self: flex-end;">
                                查询
                            </button>
                        </form>
                    </div>
                    

                    <div class="result-stats" id="result-stats" style="display: none;">
                        <div class="stats-text">
                            共找到 <span class="stats-highlight" id="result-count">0</span> 条关于 "<span class="stats-highlight" id="search-keyword"></span>" 的商标信息
                        </div>
                    </div>
                    

                    <div class="trademark-list" id="trademark-list">

                    </div>
                    

                    <div id="loading" class="loading" style="display: none;">
                        正在查询商标信息，请稍候...
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
                    tool_id: 'trademark',
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


        class TrademarkQuery {
            constructor() {

                this.queryForm = document.getElementById('query-form');
                this.keywordInput = document.getElementById('keyword');
                this.searchBtn = document.getElementById('search-btn');
                this.resultStats = document.getElementById('result-stats');
                this.resultCount = document.getElementById('result-count');
                this.searchKeyword = document.getElementById('search-keyword');
                this.trademarkList = document.getElementById('trademark-list');
                this.loading = document.getElementById('loading');
                this.error = document.getElementById('error');
                

                this.apiUrl = '../php/trademark-proxy.php';
                

                this.init();
            }
            

            init() {
    
                this.initEventListeners();
            }
            

            initEventListeners() {

                this.queryForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.searchTrademark();
                });
            }
            

            async searchTrademark() {
                const keyword = this.keywordInput.value.trim();
                if (!keyword) {
                    this.showError('请输入商标关键词');
                    return;
                }
                

                this.showLoading();
                

                const startTime = Date.now();
                
                try {
    
                    const response = await fetch(`${this.apiUrl}?keyword=${encodeURIComponent(keyword)}`, {
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
                        this.showResults(data);
    
                        recordToolUsage('search_trademark', 'success', {
                            keyword: keyword,
                            api_code: data.code,
                            result_count: data.count
                        }, responseTime);
                    } else {
                        this.showError(data.msg || '查询失败');
    
                        recordToolUsage('search_trademark', 'error', {
                            keyword: keyword,
                            api_code: data.code || 500,
                            error_msg: data.msg || '查询失败'
                        }, responseTime);
                    }
                } catch (error) {
    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.showError(`查询失败: ${error.message}`);
                    console.error('API请求错误:', error);

                    recordToolUsage('search_trademark', 'error', {
                        keyword: keyword,
                        error_msg: error.message,
                        exception: error.message
                    }, responseTime);
                }
            }
            

            showResults(data) {

                this.resultCount.textContent = data.count;
                this.searchKeyword.textContent = data.keyword;
                this.resultStats.style.display = 'block';
                

                this.trademarkList.innerHTML = '';
                

                data.data.forEach(trademark => {
                    const card = this.createTrademarkCard(trademark);
                    this.trademarkList.appendChild(card);
                });
                

                this.hideLoading();
            }
            

            createTrademarkCard(trademark) {
                const card = document.createElement('div');
                card.className = 'trademark-card';
                

                const statusClass = trademark.statusStr.includes('已注册') ? 'status-registered' : 'status-pending';
                
                card.innerHTML = `
                    <div class="trademark-header">
                        <img src="${trademark.tmImgOssPath}" alt="${trademark.tmName}" class="trademark-image">
                        <div class="trademark-info">
                            <div class="trademark-name">${trademark.tmName}</div>
                            <div class="trademark-status ${statusClass}">${trademark.statusStr}</div>
                        </div>
                    </div>
                    <div class="trademark-details">
                        <div class="detail-item">
                            <span class="detail-label">申请/注册号:</span>
                            <span class="detail-value">${trademark.regNo}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">国际分类:</span>
                            <span class="detail-value">${trademark.clsStr}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">申请日期:</span>
                            <span class="detail-value">${trademark.appDate || '暂无'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">注册公告日期:</span>
                            <span class="detail-value">${trademark.regDate || '暂无'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">申请人名称:</span>
                            <span class="detail-value">${trademark.applicantCn}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">办理机构:</span>
                            <span class="detail-value">${trademark.agent || '暂无'}</span>
                        </div>
                    </div>
                `;
                
                return card;
            }
            

            showLoading() {
                this.loading.style.display = 'block';
                this.error.style.display = 'none';
                this.resultStats.style.display = 'none';
                this.trademarkList.innerHTML = '';
            }
            

            hideLoading() {
                this.loading.style.display = 'none';
                this.error.style.display = 'none';
            }
            

            showError(message) {
                this.error.textContent = message;
                this.loading.style.display = 'none';
                this.resultStats.style.display = 'none';
                this.trademarkList.innerHTML = '';
                this.error.style.display = 'block';
            }
        }
        

        document.addEventListener('DOMContentLoaded', () => {
            new TrademarkQuery();
        });
    </script>
</body>
</html>