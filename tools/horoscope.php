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
    <title>星座运势 - <?php echo $siteConfig['name']; ?></title>
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
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 40px;
            gap: 20px;
        }
        
        .query-content {
            display: flex;
            gap: 16px;
            align-items: flex-end;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        
        .constellation-select {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .constellation-label {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .constellation-dropdown {
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            color: #1a1a1a;
            background-color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 200px;
        }
        
        .constellation-dropdown:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.05);
        }
        
        
        .query-btn {
            background-color: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 32px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .query-btn:hover:not(:disabled) {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .query-btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .query-btn.loading {
            background-color: #ccc;
            cursor: not-allowed;
        }
        
        .query-btn.loading .loading-icon {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        
        .horoscope-result {
            display: none;
        }
        
        .horoscope-result.visible {
            display: block;
        }
        
        
        .horoscope-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .horoscope-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .horoscope-time {
            font-size: 14px;
            color: #666;
        }
        
        
        .horoscope-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .overview-item {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .overview-item:hover {
            background-color: #f5f5f5;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .overview-label {
            font-size: 14px;
            color: #999;
            margin-bottom: 8px;
        }
        
        .overview-value {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .overview-value.color {
            display: inline-block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin: 0 auto;
        }
        
        
        .horoscope-details {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }
        
        .detail-section {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 24px;
        }
        
        .detail-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }
        
        .detail-icon {
            font-size: 20px;
        }
        
        .detail-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .detail-content {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
        }
        
        
        .loading {
            display: none;
            text-align: center;
            padding: 60px 20px;
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
        
        .loading-text {
            font-size: 16px;
            color: #666;
        }
        
        
        .error-message {
            display: none;
            background-color: #fff5f5;
            border: 1px solid #ffcccc;
            border-radius: 8px;
            padding: 16px;
            color: #d32f2f;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .error-message.visible {
            display: block;
        }
        
        
        .empty-state {
            display: none;
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        
        .empty-state.visible {
            display: block;
        }
        
        .empty-icon {
            font-size: 64px;
            margin-bottom: 16px;
        }
        
        .empty-text {
            font-size: 16px;
        }
        
        
        @media (max-width: 768px) {
            .tool-container {
                padding: 20px 16px;
            }
            
            .tool-content {
                padding: 20px;
            }
            
            .query-content {
                flex-direction: column;
                align-items: stretch;
            }
            
            .constellation-dropdown {
                min-width: auto;
            }
            
            .horoscope-overview {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .detail-section {
                padding: 20px;
            }
        }
        
        @media (max-width: 480px) {
            .horoscope-overview {
                grid-template-columns: 1fr;
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
                    <h2>星座运势</h2>
                    <p>查询今日星座运势，包括整体运势、爱情、事业、财运和健康</p>
                </div>
            </header>

            
            <div class="tool-container">
                
                <div class="tool-content">
                    
                    <div class="error-message" id="error-message"></div>
                    
                    
                    <div class="query-section">
                        <div class="query-content">
                            <div class="constellation-select">
                                <label class="constellation-label" for="constellation">选择星座</label>
                                <select class="constellation-dropdown" id="constellation">
                                    <option value="白羊">白羊座</option>
                                    <option value="金牛">金牛座</option>
                                    <option value="双子">双子座</option>
                                    <option value="巨蟹">巨蟹座</option>
                                    <option value="狮子">狮子座</option>
                                    <option value="处女">处女座</option>
                                    <option value="天秤">天秤座</option>
                                    <option value="天蝎">天蝎座</option>
                                    <option value="射手">射手座</option>
                                    <option value="摩羯">摩羯座</option>
                                    <option value="水瓶">水瓶座</option>
                                    <option value="双鱼">双鱼座</option>
                                </select>
                            </div>
                            <button class="query-btn" id="query-btn">
                                <span class="loading-icon" style="display: none;">🔄</span>
                                <span>查询运势</span>
                            </button>
                        </div>
                    </div>
                    
                    
                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div class="loading-text">正在获取运势信息，请稍候...</div>
                    </div>
                    
                    
                    <div class="empty-state" id="empty-state">
                        <div class="empty-icon">✨</div>
                        <div class="empty-text">请选择星座并点击查询按钮获取运势</div>
                    </div>
                    
                    
                    <div class="horoscope-result" id="horoscope-result">
                        
                        <div class="horoscope-header">
                            <h2 class="horoscope-title" id="horoscope-title"></h2>
                            <p class="horoscope-time" id="horoscope-time"></p>
                        </div>
                        
                        
                        <div class="horoscope-overview">
                            <div class="overview-item">
                                <div class="overview-label">健康指数</div>
                                <div class="overview-value" id="health-index"></div>
                            </div>
                            <div class="overview-item">
                                <div class="overview-label">讨论指数</div>
                                <div class="overview-value" id="discuss-index"></div>
                            </div>
                            <div class="overview-item">
                                <div class="overview-label">幸运颜色</div>
                                <div class="overview-value color" id="lucky-color"></div>
                            </div>
                            <div class="overview-item">
                                <div class="overview-label">幸运数字</div>
                                <div class="overview-value" id="lucky-number"></div>
                            </div>
                            <div class="overview-item">
                                <div class="overview-label">幸运星座</div>
                                <div class="overview-value" id="lucky-constellation"></div>
                            </div>
                            <div class="overview-item">
                                <div class="overview-label">短评</div>
                                <div class="overview-value" id="short-comment"></div>
                            </div>
                        </div>
                        
                        
                        <div class="horoscope-details">
                            <div class="detail-section">
                                <div class="detail-header">
                                    <span class="detail-icon">🌟</span>
                                    <h3 class="detail-title">整体运势</h3>
                                </div>
                                <div class="detail-content" id="overall-text"></div>
                            </div>
                            
                            <div class="detail-section">
                                <div class="detail-header">
                                    <span class="detail-icon">❤️</span>
                                    <h3 class="detail-title">爱情运势</h3>
                                </div>
                                <div class="detail-content" id="love-text"></div>
                            </div>
                            
                            <div class="detail-section">
                                <div class="detail-header">
                                    <span class="detail-icon">💼</span>
                                    <h3 class="detail-title">事业运势</h3>
                                </div>
                                <div class="detail-content" id="work-text"></div>
                            </div>
                            
                            <div class="detail-section">
                                <div class="detail-header">
                                    <span class="detail-icon">💰</span>
                                    <h3 class="detail-title">财运</h3>
                                </div>
                                <div class="detail-content" id="money-text"></div>
                            </div>
                            
                            <div class="detail-section">
                                <div class="detail-header">
                                    <span class="detail-icon">🏥</span>
                                    <h3 class="detail-title">健康运势</h3>
                                </div>
                                <div class="detail-content" id="health-text"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="../js/main.js"></script>
    
    <script>
        
        function recordToolUsage(action, status = 'success', content = null, responseTime = null) {
            fetch('../php/record-tool-usage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tool_id: 'horoscope',
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

        class Horoscope {
            constructor() {
                this.init();
            }
            
            init() {
                this.bindEvents();
            }
            
            bindEvents() {
                const queryBtn = document.getElementById('query-btn');
                queryBtn.addEventListener('click', () => {
                    this.queryHoroscope();
                });
                
                
                const constellationSelect = document.getElementById('constellation');
                constellationSelect.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        this.queryHoroscope();
                    }
                });
            }
            
            async queryHoroscope() {
                const constellation = document.getElementById('constellation').value;
                
                this.showLoading();
                this.hideError();
                this.hideEmptyState();
                this.hideResult();
                this.disableQueryBtn();
                
                
                const startTime = Date.now();
                
                try {
                    const response = await fetch(`../php/horoscope-proxy.php?xz=${encodeURIComponent(constellation)}`, {
                        method: 'GET',
                        timeout: 10000
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    if (data.success && data.code === 200) {
                        this.displayHoroscope(data);
                        
                        recordToolUsage('query_horoscope', 'success', {
                            api_code: data.code,
                            constellation: constellation,
                            title: data.data ? data.data.title || '' : ''
                        }, responseTime);
                    } else {
                        this.showError(data.message || '获取运势失败');
                        
                        recordToolUsage('query_horoscope', 'error', {
                            api_code: data.code || 500,
                            constellation: constellation,
                            error_msg: data.message || '获取运势失败'
                        }, responseTime);
                    }
                } catch (error) {
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.showError(`获取运势失败: ${error.message}`);
                    console.error('API请求错误:', error);
                    
                    recordToolUsage('query_horoscope', 'error', {
                        constellation: constellation,
                        error_msg: error.message,
                        exception: error.message
                    }, responseTime);
                } finally {
                    this.hideLoading();
                    this.enableQueryBtn();
                }
            }
            
            displayHoroscope(data) {
                if (!data.data) {
                    this.showError('获取的运势数据不完整');
                    return;
                }
                
                const result = data.data;
                
                
                document.getElementById('horoscope-title').textContent = result.title || `${data.xz}座今日运势`;
                document.getElementById('horoscope-time').textContent = result.time || '';
                
                
                document.getElementById('health-index').textContent = result.health || '';
                document.getElementById('discuss-index').textContent = result.discuss || '';
                
                
                const colorMap = {
                    '红色': '#ff0000',
                    '橙色': '#ffa500',
                    '黄色': '#ffff00',
                    '绿色': '#008000',
                    '青色': '#00ffff',
                    '蓝色': '#0000ff',
                    '紫色': '#800080',
                    '黑色': '#000000',
                    '白色': '#ffffff',
                    '灰色': '#808080',
                    '粉色': '#ffc0cb',
                    '棕色': '#a52a2a',
                    '金色': '#ffd700',
                    '银色': '#c0c0c0'
                };
                
                const luckyColorElement = document.getElementById('lucky-color');
                const chineseColor = result.luckycolor || '';
                const cssColor = colorMap[chineseColor] || (this.isValidColor(chineseColor) ? chineseColor : '#e0e0e0');
                
                luckyColorElement.style.backgroundColor = cssColor;
                luckyColorElement.setAttribute('title', chineseColor);
                
                
                let colorNameElement = luckyColorElement.querySelector('.color-name');
                if (!colorNameElement) {
                    colorNameElement = document.createElement('div');
                    colorNameElement.className = 'color-name';
                    colorNameElement.style.marginTop = '8px';
                    colorNameElement.style.fontSize = '12px';
                    colorNameElement.style.color = '#666';
                    luckyColorElement.appendChild(colorNameElement);
                }
                colorNameElement.textContent = chineseColor;
                
                document.getElementById('lucky-number').textContent = result.luckynumber || '';
                document.getElementById('lucky-constellation').textContent = result.luckyconstellation || '';
                document.getElementById('short-comment').textContent = result.shortcomment || '';
                
                
                document.getElementById('overall-text').textContent = result.alltext || '';
                document.getElementById('love-text').textContent = result.lovetext || '';
                document.getElementById('work-text').textContent = result.worktext || '';
                document.getElementById('money-text').textContent = result.moneytext || '';
                document.getElementById('health-text').textContent = result.healthtxt || result.healthtext || '';
                
                
                this.showResult();
            }
            
            showLoading() {
                document.getElementById('loading').classList.add('visible');
            }
            
            hideLoading() {
                document.getElementById('loading').classList.remove('visible');
            }
            
            showError(message) {
                const errorElement = document.getElementById('error-message');
                errorElement.textContent = message;
                errorElement.classList.add('visible');
            }
            
            hideError() {
                document.getElementById('error-message').classList.remove('visible');
            }
            
            showEmptyState() {
                document.getElementById('empty-state').classList.add('visible');
            }
            
            hideEmptyState() {
                document.getElementById('empty-state').classList.remove('visible');
            }
            
            showResult() {
                document.getElementById('horoscope-result').classList.add('visible');
            }
            
            hideResult() {
                document.getElementById('horoscope-result').classList.remove('visible');
            }
            
            
            isValidColor(color) {
                const s = new Option().style;
                s.color = color;
                return s.color !== '';
            }
            
            disableQueryBtn() {
                const queryBtn = document.getElementById('query-btn');
                queryBtn.disabled = true;
                queryBtn.classList.add('loading');
                queryBtn.querySelector('.loading-icon').style.display = 'inline-block';
                queryBtn.querySelector('span:last-child').textContent = '查询中...';
            }
            
            enableQueryBtn() {
                const queryBtn = document.getElementById('query-btn');
                queryBtn.disabled = false;
                queryBtn.classList.remove('loading');
                queryBtn.querySelector('.loading-icon').style.display = 'none';
                queryBtn.querySelector('span:last-child').textContent = '查询运势';
            }
        }
        
        
        document.addEventListener('DOMContentLoaded', () => {
            new Horoscope();
        });
    </script>
</body>
</html>