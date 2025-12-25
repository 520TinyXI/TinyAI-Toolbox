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
    <title>高度可定制的随机数生成器 - <?php echo $siteConfig['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .tool-content {
            background-color: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-label {
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .form-input {
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.05);
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
        }
        
        .checkbox-label {
            font-size: 14px;
            color: #1a1a1a;
            cursor: pointer;
            user-select: none;
        }
        
        .form-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        
        .btn {
            padding: 12px 32px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #1a1a1a;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .result-section {
            margin-top: 30px;
        }
        
        .result-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .result-container {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            min-height: 100px;
        }
        
        .number-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        
        .number-item {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 12px 16px;
            font-size: 16px;
            font-weight: 500;
            color: #1a1a1a;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .number-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .copy-btn {
            padding: 8px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background-color: #fff;
            color: #1a1a1a;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 12px;
        }
        
        .copy-btn:hover {
            background-color: #f5f5f5;
            border-color: #1a1a1a;
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 40px;
            color: #666;
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
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .error-message {
            display: none;
            background-color: #fff3f3;
            border: 1px solid #ffe0e0;
            border-radius: 8px;
            padding: 16px;
            color: #d63031;
            margin-bottom: 20px;
        }
        
        .error-message.visible {
            display: block;
        }
        
        @media (max-width: 768px) {
            .tool-container {
                padding: 20px 16px;
            }
            
            .tool-content {
                padding: 20px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-row {
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
                    <h2>高度可定制的随机数生成器</h2>
                    <p>生成指定范围、数量、精度的随机数，支持整数/小数、允许/禁止重复</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">
                    <div class="error-message" id="error-message"></div>
                    
                    <form id="random-form">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label" for="min-value">最小值</label>
                                <input type="number" class="form-input" id="min-value" name="min" value="1" step="any">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="max-value">最大值</label>
                                <input type="number" class="form-input" id="max-value" name="max" value="100" step="any">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="count">生成数量</label>
                                <input type="number" class="form-input" id="count" name="count" value="1" min="1" max="100">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" class="form-checkbox" id="allow-decimal" name="allow_decimal">
                                    <label class="checkbox-label" for="allow-decimal">允许小数</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" class="form-checkbox" id="allow-repeat" name="allow_repeat" checked>
                                    <label class="checkbox-label" for="allow-repeat">允许重复</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group" id="decimal-places-group" style="display: none;">
                            <label class="form-label" for="decimal-places">小数位数</label>
                            <input type="number" class="form-input" id="decimal-places" name="decimal_places" value="2" min="0" max="10">
                        </div>
                        
                        <div style="margin-top: 30px;">
                            <button type="submit" class="btn" id="generate-btn">
                                <span class="loading-icon" style="display: none;">🔄</span>
                                <span>生成随机数</span>
                            </button>
                        </div>
                    </form>
                    
                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div>正在生成随机数，请稍候...</div>
                    </div>
                    
                    <div class="result-section" id="result-section" style="display: none;">
                        <h3 class="result-title">生成结果</h3>
                        <div class="result-container">
                            <ul class="number-list" id="number-list"></ul>
                        </div>
                        <button class="copy-btn" id="copy-btn">复制结果</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="../js/main.js"></script>
    
    <script>
        async function recordToolUsage(toolId, action, statusValue, responseTime = 0) {
            try {
                const content = JSON.stringify({ action });
                await fetch('../php/record-tool-usage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        tool_id: toolId,
                        content: content,
                        status: statusValue,
                        response_time: responseTime
                    })
                });
            } catch (error) {
                console.error('记录工具使用情况失败:', error);
            }
        }
        
        class RandomNumberGenerator {
            constructor() {
                this.init();
            }
            
            init() {
                this.bindEvents();
            }
            
            bindEvents() {
                const form = document.getElementById('random-form');
                const allowDecimalCheckbox = document.getElementById('allow-decimal');
                const copyBtn = document.getElementById('copy-btn');
                
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.generateRandomNumbers();
                });
                
                allowDecimalCheckbox.addEventListener('change', () => {
                    this.toggleDecimalPlaces();
                });
                
                copyBtn.addEventListener('click', () => {
                    this.copyResults();
                });
            }
            
            toggleDecimalPlaces() {
                const allowDecimal = document.getElementById('allow-decimal').checked;
                const decimalPlacesGroup = document.getElementById('decimal-places-group');
                
                if (allowDecimal) {
                    decimalPlacesGroup.style.display = 'block';
                } else {
                    decimalPlacesGroup.style.display = 'none';
                }
            }
            
            async generateRandomNumbers() {
                const min = document.getElementById('min-value').value;
                const max = document.getElementById('max-value').value;
                const count = document.getElementById('count').value;
                const allowRepeat = document.getElementById('allow-repeat').checked;
                const allowDecimal = document.getElementById('allow-decimal').checked;
                const decimalPlaces = document.getElementById('decimal-places').value;
                
                if (parseFloat(min) > parseFloat(max)) {
                    this.showError('最小值不能大于最大值');
                    return;
                }
                
                if (!allowRepeat && (parseFloat(max) - parseFloat(min) + 1 < parseInt(count))) {
                    this.showError('范围太小，无法生成指定数量的不重复随机数');
                    return;
                }
                
                this.showLoading();
                this.hideError();
                
                const startTime = Date.now();
                const startTime = Date.now();
                
                try {
                    
                    const params = new URLSearchParams({
                        min: min,
                        max: max,
                        count: count,
                        allow_repeat: allowRepeat,
                        allow_decimal: allowDecimal,
                        decimal_places: decimalPlaces
                    });
                    
                    const requestUrl = `../php/random-proxy.php?${params.toString()}`;
                    
                    
                    const response = await fetch(requestUrl);
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.numbers && Array.isArray(data.numbers)) {
                        this.displayResults(data.numbers);
                    } else {
                        throw new Error(data.message || '生成随机数失败');
                    }
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    
                    await recordToolUsage('random-number', 'generate', 'success', responseTime);
                    
                } catch (error) {
                    this.showError(`生成随机数失败: ${error.message}`);
                    console.error('API请求错误:', error);
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    
                    await recordToolUsage('random-number', 'generate', 'error', responseTime);
                } finally {
                    this.hideLoading();
                }
            }
            
            displayResults(numbers) {
                const numberList = document.getElementById('number-list');
                const resultSection = document.getElementById('result-section');
                
                
                numberList.innerHTML = '';
                
                
                numbers.forEach(number => {
                    const listItem = document.createElement('li');
                    listItem.className = 'number-item';
                    listItem.textContent = number;
                    numberList.appendChild(listItem);
                });
                
                
                resultSection.style.display = 'block';
            }
            
            showLoading() {
                const loading = document.getElementById('loading');
                const generateBtn = document.getElementById('generate-btn');
                
                loading.classList.add('visible');
                generateBtn.disabled = true;
                generateBtn.querySelector('.loading-icon').style.display = 'inline-block';
                generateBtn.querySelector('span:last-child').textContent = '生成中...';
            }
            
            hideLoading() {
                const loading = document.getElementById('loading');
                const generateBtn = document.getElementById('generate-btn');
                
                loading.classList.remove('visible');
                generateBtn.disabled = false;
                generateBtn.querySelector('.loading-icon').style.display = 'none';
                generateBtn.querySelector('span:last-child').textContent = '生成随机数';
            }
            
            showError(message) {
                const errorElement = document.getElementById('error-message');
                errorElement.textContent = message;
                errorElement.classList.add('visible');
            }
            
            hideError() {
                const errorElement = document.getElementById('error-message');
                errorElement.classList.remove('visible');
            }
            
            async copyResults() {
                const numbers = Array.from(document.querySelectorAll('.number-item'))
                    .map(item => item.textContent)
                    .join(', ');
                
                try {
                    await navigator.clipboard.writeText(numbers);
                    
                    
                    const copyBtn = document.getElementById('copy-btn');
                    const originalText = copyBtn.textContent;
                    copyBtn.textContent = '已复制!';
                    
                    setTimeout(() => {
                        copyBtn.textContent = originalText;
                    }, 2000);
                } catch (error) {
                    console.error('复制失败:', error);
                    this.showError('复制失败，请手动复制');
                }
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new RandomNumberGenerator();
        });
    </script>
</body>
</html>