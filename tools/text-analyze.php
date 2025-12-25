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
    <title>多维度分析文本内容 - <?php echo $siteConfig['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 900px;
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
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-textarea {
            width: 100%;
            min-height: 200px;
            padding: 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-family: inherit;
            resize: vertical;
            transition: all 0.3s ease;
            line-height: 1.6;
        }
        
        .form-textarea:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.05);
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
            margin-bottom: 20px;
        }
        
        .result-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .result-card {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .result-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .result-value {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .result-label {
            font-size: 14px;
            color: #666;
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
            
            .result-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 16px;
            }
            
            .result-value {
                font-size: 24px;
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
                    <h2>多维度分析文本内容</h2>
                    <p>从多个维度分析文本，包括字符数、词数、句子数、段落数和行数，支持中英文文本</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">
                <div class="error-message" id="error-message"></div>
                
                <form id="text-analyze-form">
                        <div class="form-group">
                            <label class="form-label" for="text-input">待分析文本</label>
                            <textarea class="form-textarea" id="text-input" name="text" placeholder="请输入或粘贴要分析的文本内容..."></textarea>
                        </div>
                        
                        <div style="margin-top: 20px;">
                            <button type="submit" class="btn" id="analyze-btn">
                                <span class="loading-icon" style="display: none;">🔄</span>
                                <span>开始分析</span>
                            </button>
                        </div>
                    </form>
                    
                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div>正在分析文本，请稍候...</div>
                    </div>
                    
                    <div class="result-section" id="result-section" style="display: none;">
                        <h3 class="result-title">分析结果</h3>
                        <div class="result-grid" id="result-grid">
                            <!-- 结果将通过JavaScript动态生成 -->
                        </div>
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
        
        class TextAnalyzer {
            constructor() {
                this.init();
            }
            
            init() {
                this.bindEvents();
            }
            
            bindEvents() {
                const form = document.getElementById('text-analyze-form');
                
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.analyzeText();
                });
            }
            
            async analyzeText() {
                const text = document.getElementById('text-input').value.trim();
                
                if (!text) {
                    this.showError('请输入要分析的文本内容');
                    return;
                }
                
                this.showLoading();
                this.hideError();
                
                const startTime = Date.now();
                
                try {
                    const requestUrl = '../php/text-analyze-proxy.php';
                    
                    const response = await fetch(requestUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ text: text })
                    });
                    
                    if (!response.ok) {
                        const errorData = await response.json().catch(() => ({}));
                        throw new Error(errorData.message || `HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    console.log('API响应数据:', data);
                    
                    this.displayResults(data);
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    await recordToolUsage('text-analyze', 'analyze', 'success', responseTime);
                    
                } catch (error) {
                    this.showError(`分析失败: ${error.message}`);
                    console.error('API请求错误:', error);
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    await recordToolUsage('text-analyze', 'analyze', 'error', responseTime);
                } finally {
                    this.hideLoading();
                }
            }
            
            displayResults(results) {
                const resultGrid = document.getElementById('result-grid');
                const resultSection = document.getElementById('result-section');
                
                resultGrid.innerHTML = '';
                
                let displayResults = {};
                
                if (results.hasOwnProperty('total_chars_unicode')) {
                    displayResults = {
                        characters: results.total_chars_unicode || 0,
                        chinese_chars: results.chinese_chars || 0,
                        english_letters: results.english_letters || 0,
                        numbers: results.numbers || 0,
                        punctuation_marks: results.punctuation_marks || 0
                    };
                } 
                else if (results.hasOwnProperty('characters')) {
                    displayResults = {
                        characters: results.characters || 0,
                        words: results.words || 0,
                        sentences: results.sentences || 0,
                        paragraphs: results.paragraphs || 0,
                        lines: results.lines || 0
                    };
                } 
                else {
                    displayResults = results;
                }
                
                for (const [key, value] of Object.entries(displayResults)) {
                    if (key === 'original_text') continue;
                    
                    const label = this.formatLabel(key);
                    
                    const resultCard = document.createElement('div');
                    resultCard.className = 'result-card';
                    
                    resultCard.innerHTML = `
                        <div class="result-value">${value}</div>
                        <div class="result-label">${label}</div>
                    `;
                    
                    resultGrid.appendChild(resultCard);
                }
                
                if (Object.keys(displayResults).length === 0) {
                    resultGrid.innerHTML = '<div style="text-align: center; color: #666; padding: 40px;">没有可显示的分析结果</div>';
                }
                
                resultSection.style.display = 'block';
            }
            
            formatLabel(key) {
                const labelMap = {
                    characters: '字符数',
                    words: '单词数',
                    sentences: '句子数',
                    paragraphs: '段落数',
                    lines: '行数',
                    total_chars_unicode: '字符数(Unicode)',
                    total_bytes: '字节数',
                    chinese_chars: '中文字符',
                    english_letters: '英文字母',
                    numbers: '数字',
                    punctuation_marks: '标点符号',
                    whitespace_chars: '空白字符'
                };
                
                if (labelMap[key]) {
                    return labelMap[key];
                } else {
                    return key.replace(/_/g, ' ').replace(/(^|\s)[a-z]/g, (match) => match.toUpperCase());
                }
            }
            
            showLoading() {
                const loading = document.getElementById('loading');
                const analyzeBtn = document.getElementById('analyze-btn');
                
                loading.classList.add('visible');
                analyzeBtn.disabled = true;
                analyzeBtn.querySelector('.loading-icon').style.display = 'inline-block';
                analyzeBtn.querySelector('span:last-child').textContent = '分析中...';
            }
            
            hideLoading() {
                const loading = document.getElementById('loading');
                const analyzeBtn = document.getElementById('analyze-btn');
                
                loading.classList.remove('visible');
                analyzeBtn.disabled = false;
                analyzeBtn.querySelector('.loading-icon').style.display = 'none';
                analyzeBtn.querySelector('span:last-child').textContent = '开始分析';
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
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new TextAnalyzer();
        });
    </script>
</body>
</html>