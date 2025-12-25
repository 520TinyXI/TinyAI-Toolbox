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
    <title>SEO网页诊断 - <?php echo $siteConfig['name']; ?></title>
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
        
        .overview-card {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 20px;
        }
        
        .overview-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .diagnosis-info {
            flex: 1;
        }
        
        .diagnosis-url {
            font-size: 16px;
            color: #666;
            margin-bottom: 8px;
        }
        
        .diagnosis-time {
            font-size: 14px;
            color: #999;
        }
        
        .score-card {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            min-width: 200px;
        }
        
        .score-number {
            font-size: 48px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .score-rating {
            font-size: 18px;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 20px;
            display: inline-block;
        }
        
        .rating-excellent {
            background-color: #e6f4ea;
            color: #10b981;
        }
        
        .rating-good {
            background-color: #dbeafe;
            color: #3b82f6;
        }
        
        .rating-pass {
            background-color: #fef3c7;
            color: #f59e0b;
        }
        
        .rating-poor {
            background-color: #fee2e2;
            color: #ef4444;
        }
        
        .overall-suggestions {
            background-color: #f3f4f6;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 24px;
        }
        
        .suggestions-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 12px;
        }
        
        .suggestions-list {
            list-style-type: decimal;
            padding-left: 24px;
        }
        
        .suggestions-item {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            line-height: 1.5;
        }
        
        .diagnosis-list {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .diagnosis-item {
            background-color: #fff;
            border-bottom: 1px solid #e0e0e0;
            padding: 20px;
        }
        
        .diagnosis-item:last-child {
            border-bottom: none;
        }
        
        .diagnosis-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 12px;
        }
        
        .diagnosis-item-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .diagnosis-item-status {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-excellent {
            background-color: #e6f4ea;
            color: #10b981;
        }
        
        .status-good {
            background-color: #dbeafe;
            color: #3b82f6;
        }
        
        .status-average {
            background-color: #fef3c7;
            color: #f59e0b;
        }
        
        .status-poor {
            background-color: #fee2e2;
            color: #ef4444;
        }
        
        .score-bar {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .score-value {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .score-progress {
            width: 80px;
            height: 8px;
            background-color: #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .score-fill {
            height: 100%;
            transition: width 0.3s ease;
        }
        
        .score-fill-excellent {
            background-color: #10b981;
        }
        
        .score-fill-good {
            background-color: #3b82f6;
        }
        
        .score-fill-average {
            background-color: #f59e0b;
        }
        
        .score-fill-poor {
            background-color: #ef4444;
        }
        
        .diagnosis-item-detail {
            margin-bottom: 12px;
            padding: 12px;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
        }
        
        .detail-text {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
        }
        
        .optimization-suggestions {
            margin-top: 16px;
        }
        
        .suggestions-subtitle {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 12px;
        }
        
        .suggestion-item {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            padding-left: 20px;
            position: relative;
        }
        
        .suggestion-item::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #1a1a1a;
            font-weight: bold;
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
            
            .overview-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .score-card {
                width: 100%;
                min-width: auto;
            }
            
            .diagnosis-item-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .diagnosis-item-status {
                width: 100%;
                justify-content: space-between;
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
                    <h2>SEO网页诊断</h2>
                    <p>企业级网页分析，全面诊断SEO问题</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">
                    <div class="error-container" id="error-container" style="display: none;">
                        <div class="error-message" id="error-message">诊断失败，请稍后重试</div>
                    </div>
                    
                    <div class="query-section">
                        <form id="query-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="url" class="form-label">网站链接</label>
                                    <input type="text" id="url" name="url" class="form-input" placeholder="请输入需要诊断的域名或链接，例如：www.ctsqnb.xyz" required>
                                </div>
                                <button type="submit" class="btn btn-primary" id="query-btn">
                                    <span class="loading-icon" style="display: none;">🔄</span>
                                    开始诊断
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="result-section" id="result-section" style="display: none;">
                        <h3 class="result-title">诊断结果</h3>
                        
                        <div class="overview-card" id="overview-card"></div>
                        
                        <div class="diagnosis-list" id="diagnosis-list"></div>
                    </div>
                    
                    <div class="loading-container" id="loading-container" style="display: none;">
                        <div class="loading"></div>
                        <p>正在进行SEO诊断，请稍候...</p>
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
                console.error('记录工具使用情况失败:', error);
            }
        }
        
        class SEODiagnosis {
            constructor() {
                this.queryForm = document.getElementById('query-form');
                this.urlInput = document.getElementById('url');
                this.queryBtn = document.getElementById('query-btn');
                this.loadingIcon = this.queryBtn.querySelector('.loading-icon');
                this.resultSection = document.getElementById('result-section');
                this.overviewCard = document.getElementById('overview-card');
                this.diagnosisList = document.getElementById('diagnosis-list');
                this.loadingContainer = document.getElementById('loading-container');
                this.errorContainer = document.getElementById('error-container');
                this.errorMessage = document.getElementById('error-message');
                
                
                this.apiUrl = 'https://api.jkyai.top/API/seowyzd.php';
                
                this.init();
            }
            
            init() {
                this.initEventListeners();
            }
            
            initEventListeners() {
                this.queryForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.diagnose();
                });
            }
            
            async diagnose() {
                let url = this.urlInput.value.trim();
                
                if (!url) {
                    this.showError('请输入需要诊断的域名或链接');
                    return;
                }
                
                this.showLoading();
                
                const startTime = Date.now();
                
                try {
                    const params = new URLSearchParams();
                    params.append('url', url);
                    params.append('type', 'json');
                    
                    const requestUrl = `${this.apiUrl}?${params.toString()}`;
                    console.log('请求URL:', requestUrl);
                    
                    const response = await fetch(requestUrl, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    console.log('响应数据:', data);
                    
                    const responseTime = Date.now() - startTime;
                    
                    if (data['诊断项目'] && data['诊断项目'].length > 0) {
                        this.showResults(data);
                        await recordToolUsage('seo-diagnosis', 'diagnose', 1, responseTime, `诊断网站: ${url}`);
                    } else {
                        this.showError('诊断失败，未能获取有效数据');
                        await recordToolUsage('seo-diagnosis', 'diagnose', 0, responseTime, `诊断网站: ${url}`);
                    }
                } catch (error) {
                    console.error('诊断失败:', error);
                    this.showError(`诊断失败: ${error.message}`);
                    const responseTime = Date.now() - startTime;
                    await recordToolUsage('seo-diagnosis', 'diagnose', 0, responseTime, `诊断网站: ${url}`);
                }
            }
            
            showResults(data) {
                this.renderOverview(data);
                
                this.renderDiagnosisList(data['诊断项目']);
                
                this.hideLoading();
                this.resultSection.style.display = 'block';
            }
            
            renderOverview(data) {
                const { rating, ratingClass } = this.getRatingInfo(data['总分']);
                
                const html = `
                    <div class="overview-header">
                        <div class="diagnosis-info">
                            <div class="diagnosis-url">${data['诊断网址']}</div>
                            <div class="diagnosis-time">诊断时间：${data['诊断时间']}</div>
                        </div>
                        <div class="score-card">
                            <div class="score-number">${data['总分']}</div>
                            <div class="score-rating ${ratingClass}">${rating}</div>
                            <div style="margin-top: 8px; font-size: 14px; color: #666;">满分：${data['满分']}</div>
                        </div>
                    </div>
                    
                    ${data['总体建议'] && data['总体建议'].length > 0 ? `
                        <div class="overall-suggestions">
                            <div class="suggestions-title">总体建议</div>
                            <ol class="suggestions-list">
                                ${data['总体建议'].map(suggestion => `<li class="suggestions-item">${suggestion}</li>`).join('')}
                            </ol>
                        </div>
                    ` : ''}
                `;
                
                this.overviewCard.innerHTML = html;
            }
            
            renderDiagnosisList(items) {
                const html = items.map(item => {
                    return this.renderDiagnosisItem(item);
                }).join('');
                
                this.diagnosisList.innerHTML = html;
            }
            
            renderDiagnosisItem(item) {
                const { statusText, statusClass, ratingClass } = this.getStatusInfo(item['状态'], item['得分']);
                
                return `
                    <div class="diagnosis-item">
                        <div class="diagnosis-item-header">
                            <div class="diagnosis-item-title">${item['项目']}</div>
                            <div class="diagnosis-item-status">
                                <span class="status-badge ${statusClass}">${statusText}</span>
                                <div class="score-bar">
                                    <span class="score-value">${item['得分']}/5</span>
                                    <div class="score-progress">
                                        <div class="score-fill ${ratingClass}" style="width: ${(item['得分'] / 5) * 100}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="diagnosis-item-detail">
                            <div class="detail-text">${item['详情']}</div>
                        </div>
                        
                        <div class="optimization-suggestions">
                            <div class="suggestions-subtitle">优化建议</div>
                            ${item['优化建议'].map(suggestion => `<div class="suggestion-item">${suggestion}</div>`).join('')}
                        </div>
                    </div>
                `;
            }
            
            getRatingInfo(score) {
                if (score >= 90) {
                    return { rating: '优秀', ratingClass: 'rating-excellent' };
                } else if (score >= 80) {
                    return { rating: '良好', ratingClass: 'rating-good' };
                } else if (score >= 60) {
                    return { rating: '及格', ratingClass: 'rating-pass' };
                } else {
                    return { rating: '较差', ratingClass: 'rating-poor' };
                }
            }
            
            getStatusInfo(status, score) {
                let statusText = status;
                let statusClass = 'status-poor';
                let ratingClass = 'score-fill-poor';
                
                if (status === '优秀') {
                    statusClass = 'status-excellent';
                    ratingClass = 'score-fill-excellent';
                } else if (status === '良好') {
                    statusClass = 'status-good';
                    ratingClass = 'score-fill-good';
                } else if (status === '需要优化' || status === '建议优化') {
                    statusClass = 'status-poor';
                    ratingClass = 'score-fill-poor';
                } else {
                    statusClass = 'status-average';
                    ratingClass = 'score-fill-average';
                }
                
                return { statusText, statusClass, ratingClass };
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
            new SEODiagnosis();
        });
    </script>
</body>
</html>