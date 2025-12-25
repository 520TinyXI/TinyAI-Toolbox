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
    <title>星座运势配对 - <?php echo $siteConfig['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .tool-content {
            background-color: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }
        

        .query-section {
            margin-bottom: 24px;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 12px;
        }
        
        .form-row {
            display: flex;
            gap: 16px;
            align-items: flex-end;
            flex-wrap: wrap;
        }
        
        .form-group {
            flex: 1;
            min-width: 200px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #666;
            margin-bottom: 8px;
        }
        
        .form-input,
        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
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
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #1a1a1a;
            color: #fff;
        }
        
        .btn:hover {
            background-color: #333;
        }
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        

        .result-section {
            margin-top: 24px;
        }
        
        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            font-size: 18px;
            color: #666;
        }
        
        .loading::before {
            content: '';
            display: inline-block;
            width: 24px;
            height: 24px;
            margin-right: 12px;
            border: 3px solid rgba(26, 26, 26, 0.1);
            border-radius: 50%;
            border-top-color: #1a1a1a;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        

        .constellation-card {
            background-color: #fafafa;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid #e0e0e0;
        }
        
        .card-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .card-subtitle {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin: 20px 0 12px 0;
        }
        

        .basic-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .info-item {
            background-color: #fff;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        
        .info-label {
            font-size: 14px;
            font-weight: 500;
            color: #666;
            margin-bottom: 8px;
        }
        
        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
        }
        

        .match-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .match-card {
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        
        .match-card.best {
            background-color: #e6f4ea;
            border-color: #10b981;
        }
        
        .match-card.good {
            background-color: #dbeafe;
            border-color: #3b82f6;
        }
        
        .match-card.fair {
            background-color: #fef3c7;
            border-color: #f59e0b;
        }
        
        .match-card.poor {
            background-color: #fee2e2;
            border-color: #ef4444;
        }
        
        .match-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .match-card.best .match-title {
            color: #059669;
        }
        
        .match-card.good .match-title {
            color: #1d4ed8;
        }
        
        .match-card.fair .match-title {
            color: #d97706;
        }
        
        .match-card.poor .match-title {
            color: #dc2626;
        }
        
        .match-value {
            font-size: 16px;
            font-weight: 500;
            color: #333;
        }
        

        .fortune-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .fortune-item {
            background-color: #fff;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        
        .fortune-label {
            font-size: 14px;
            font-weight: 500;
            color: #666;
            margin-bottom: 8px;
        }
        
        .fortune-value {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }
        

        .lucky-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .lucky-item {
            background-color: #fff;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            text-align: center;
        }
        
        .lucky-label {
            font-size: 14px;
            font-weight: 500;
            color: #666;
            margin-bottom: 8px;
        }
        
        .lucky-value {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
        }
        

        .error-message {
            background-color: #fee2e2;
            color: #ef4444;
            padding: 16px;
            border-radius: 8px;
            margin: 24px 0;
            text-align: center;
        }
        

        .color-tags {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .color-tag {
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 14px;
            font-weight: 500;
            color: #fff;
        }
        

        .number-tags {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .number-tag {
            padding: 6px 12px;
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 16px;
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }
        

        .constellation-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 8px;
            margin-top: 8px;
        }
        
        .constellation-item {
            padding: 8px 12px;
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .constellation-item:hover {
            background-color: #f0f0f0;
            border-color: #1a1a1a;
        }
        
        .constellation-item.selected {
            background-color: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
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
                    <h2>星座运势配对</h2>
                    <p>查看星座运势、个性分析和最佳配对</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">

                    <div class="query-section">
                        <form id="query-form">
                            <div class="form-row">

                                <div class="form-group">
                                    <label for="constellation" class="form-label">选择星座</label>
                                    <select id="constellation" name="constellation" class="form-select" required>
                                        <option value="">请选择星座</option>
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
                                

                                <div class="form-group">
                                    <label for="time" class="form-label">查询时间</label>
                                    <select id="time" name="time" class="form-select">
                                        <option value="today">今天</option>
                                        <option value="week">本周</option>
                                        <option value="month">本月</option>
                                        <option value="year">今年</option>
                                    </select>
                                </div>
                                

                                <button type="submit" class="btn" id="query-btn">
                                    查询运势
                                </button>
                            </div>
                        </form>
                    </div>
                    

                    <div class="result-section" id="result-section">

                        <div class="loading" id="loading" style="display: none;">
                            正在查询...
                        </div>
                        

                        <div class="error-message" id="error-message" style="display: none;"></div>
                        

                        <div id="constellation-result" style="display: none;"></div>
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

        class ConstellationPair {
            constructor() {
                this.queryForm = document.getElementById('query-form');
                this.constellationSelect = document.getElementById('constellation');
                this.timeSelect = document.getElementById('time');
                this.queryBtn = document.getElementById('query-btn');
                this.resultSection = document.getElementById('result-section');
                this.loading = document.getElementById('loading');
                this.errorMessage = document.getElementById('error-message');
                this.constellationResult = document.getElementById('constellation-result');
                
                this.apiUrl = '../php/constellation-pair-proxy.php';
                
                this.init();
            }
            
            init() {
                this.initEventListeners();
            }
            
            initEventListeners() {
                this.queryForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.getConstellationData();
                });
            }
            
            async getConstellationData() {
                const constellation = this.constellationSelect.value;
                const time = this.timeSelect.value;
                
                this.showLoading();
                
                const startTime = Date.now();
                
                try {
                    const params = new URLSearchParams();
                    params.append('msg', constellation);
                    params.append('time', time);
                    params.append('type', 'json');
                    
                    const requestUrl = `${this.apiUrl}?${params.toString()}`;
                    
                    const response = await fetch(requestUrl, {
                        method: 'GET'
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP Error! Status code: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    const responseTime = Date.now() - startTime;
                    
                    if (data.status === 'success') {
                        await recordToolUsage('constellation-pair', 'getConstellationData', 1, responseTime, constellation);
                        this.displayResult(data);
                    } else {
                        await recordToolUsage('constellation-pair', 'getConstellationData', 0, responseTime, constellation);
                        throw new Error(data.message || 'Failed to get data');
                    }
                } catch (error) {
                    console.error('Request failed:', error);
                    
                    const responseTime = Date.now() - startTime;
                    
                    await recordToolUsage('constellation-pair', 'getConstellationData', 0, responseTime, constellation);
                    
                    this.showError(`Failed to get constellation data: ${error.message}`);
                }
            }
            
            showLoading() {
                this.loading.style.display = 'flex';
                this.errorMessage.style.display = 'none';
                this.constellationResult.style.display = 'none';
                this.queryBtn.disabled = true;
            }
            
            showError(message) {
                this.loading.style.display = 'none';
                this.errorMessage.style.display = 'block';
                this.errorMessage.textContent = message;
                this.constellationResult.style.display = 'none';
                this.queryBtn.disabled = false;
            }
            
            displayResult(data) {
                this.loading.style.display = 'none';
                this.errorMessage.style.display = 'none';
                
                const html = this.buildResultHTML(data);
                
                this.constellationResult.innerHTML = html;
                this.constellationResult.style.display = 'block';
                this.queryBtn.disabled = false;
            }
            
            buildResultHTML(data) {
                return `
                    <div class="constellation-card">
                        <h2 class="card-title">
                            ${data.constellation_name}
                            <span style="font-size: 18px; font-weight: 500; color: #666;">(${data.constellation_en})</span>
                        </h2>
                        
                        <div class="basic-info">
                            <div class="info-item">
                                <div class="info-label">Date Range</div>
                                <div class="info-value">${data.date_range}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Element</div>
                                <div class="info-value">${data.element}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Ruling Planet</div>
                                <div class="info-value">${data.ruling_planet}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Time Period</div>
                                <div class="info-value">
                                    ${data.time_period === 'today' ? 'Today' : 
                                      data.time_period === 'week' ? 'This Week' : 
                                      data.time_period === 'month' ? 'This Month' : 'This Year'}
                                </div>
                            </div>
                        </div>
                        
                        <h3 class="card-subtitle">Personality Traits</h3>
                        <div class="basic-info">
                            <div class="info-item">
                                <div class="info-label">Strengths</div>
                                <div class="info-value">${data.strengths}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Weaknesses</div>
                                <div class="info-value">${data.weaknesses}</div>
                            </div>
                        </div>
                        
                        <h3 class="card-subtitle">Best Matches</h3>
                        <div class="match-section">
                            <div class="match-card best">
                                <div class="match-title">Best Match</div>
                                <div class="match-value">${data.best_match}</div>
                            </div>
                            <div class="match-card good">
                                <div class="match-title">Good Matches</div>
                                <div class="match-value">${Array.isArray(data.good_matches) ? data.good_matches.join('、') : data.good_matches}</div>
                            </div>
                            <div class="match-card fair">
                                <div class="match-title">Fair Matches</div>
                                <div class="match-value">${Array.isArray(data.fair_matches) ? data.fair_matches.join('、') : data.fair_matches}</div>
                            </div>
                            <div class="match-card poor">
                                <div class="match-title">Poor Matches</div>
                                <div class="match-value">${Array.isArray(data.poor_matches) ? data.poor_matches.join('、') : data.poor_matches}</div>
                            </div>
                        </div>
                        
                        <h3 class="card-subtitle">Lucky Information</h3>
                        <div class="lucky-section">
                            <div class="lucky-item">
                                <div class="lucky-label">Lucky Colors</div>
                                <div class="lucky-value">
                                    <div class="color-tags">
                                        ${Array.isArray(data.lucky_colors) ? 
                                            data.lucky_colors.map(color => `<span class="color-tag" style="background-color: ${this.getColorHex(color)}">${color}</span>`).join('') : 
                                            data.lucky_colors}
                                    </div>
                                </div>
                            </div>
                            <div class="lucky-item">
                                <div class="lucky-label">Lucky Numbers</div>
                                <div class="lucky-value">
                                    <div class="number-tags">
                                        ${Array.isArray(data.lucky_numbers) ? 
                                            data.lucky_numbers.map(number => `<span class="number-tag">${number}</span>`).join('') : 
                                            data.lucky_numbers}
                                    </div>
                                </div>
                            </div>
                            <div class="lucky-item">
                                <div class="lucky-label">Lucky Direction</div>
                                <div class="lucky-value">${data.lucky_direction}</div>
                            </div>
                            <div class="lucky-item">
                                <div class="lucky-label">Lucky Time</div>
                                <div class="lucky-value">${data.lucky_time}</div>
                            </div>
                        </div>
                        
                        <h3 class="card-subtitle">Fortune Analysis</h3>
                        <div class="fortune-section">
                            <div class="fortune-item">
                                <div class="fortune-label">General Fortune</div>
                                <div class="fortune-value">${data.general_fortune}</div>
                            </div>
                            <div class="fortune-item">
                                <div class="fortune-label">Love Fortune</div>
                                <div class="fortune-value">${data.love_fortune}</div>
                            </div>
                            <div class="fortune-item">
                                <div class="fortune-label">Career Fortune</div>
                                <div class="fortune-value">${data.work_fortune}</div>
                            </div>
                            <div class="fortune-item">
                                <div class="fortune-label">Wealth Fortune</div>
                                <div class="fortune-value">${data.wealth_fortune}</div>
                            </div>
                            <div class="fortune-item">
                                <div class="fortune-label">Health Fortune</div>
                                <div class="fortune-value">${data.health_fortune}</div>
                            </div>
                        </div>
                        
                        <h3 class="card-subtitle">Love Advice</h3>
                        <div style="background-color: #fff; padding: 16px; border-radius: 8px; border: 1px solid #e0e0e0;">
                            ${data.love_advice}
                        </div>
                        
                        <h3 class="card-subtitle">Desire Analysis</h3>
                        <div style="background-color: #fff; padding: 16px; border-radius: 8px; border: 1px solid #e0e0e0;">
                            ${data.desire_analysis}
                        </div>
                    </div>
                `;
            }
            
            getColorHex(color) {
                const colorMap = {
                    '红色': '#ef4444',
                    '橙色': '#f97316',
                    '黄色': '#eab308',
                    '绿色': '#22c55e',
                    '蓝色': '#3b82f6',
                    '靛色': '#6366f1',
                    '紫色': '#a855f7',
                    '金色': '#f59e0b',
                    '银色': '#94a3b8',
                    '白色': '#f3f4f6',
                    '黑色': '#1f2937'
                };
                
                return colorMap[color] || '#6b7280';
            }
        }
        
        let constellationPair;
        document.addEventListener('DOMContentLoaded', () => {
            constellationPair = new ConstellationPair();
        });
    </script>
</body>
</html>