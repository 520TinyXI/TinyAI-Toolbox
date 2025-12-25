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
    <title>FLUX.1文生图API - <?php echo $siteConfig['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 1200px;
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
        

        .form-section {
            margin-bottom: 30px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-label {
            display: block;
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
        

        .prompt-input {
            resize: vertical;
            min-height: 100px;
            max-height: 200px;
            font-family: inherit;
        }
        

        .form-select {
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            background-color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .form-select:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.05);
        }
        

        .generate-btn {
            padding: 14px 32px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #1a1a1a;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            margin-top: 20px;
        }
        
        .generate-btn:hover:not(:disabled) {
            background-color: #333;
        }
        
        .generate-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        

        .result-section {
            margin-top: 30px;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            display: none;
        }
        
        .result-section.visible {
            display: block;
        }
        
        .result-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        

        .image-container {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .generated-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        

        .image-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 4px;
        }
        
        .info-value {
            font-size: 16px;
            font-weight: 500;
            color: #1a1a1a;
            word-break: break-all;
        }
        

        .error-message {
            background-color: #fee2e2;
            color: #ef4444;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }
        

        .limit-info {
            background-color: #fef3c7;
            color: #f59e0b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-top: 16px;
            font-size: 14px;
        }
        

        @media (max-width: 768px) {
            .tool-container {
                padding: 20px 16px;
            }
            
            .tool-content {
                padding: 20px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .image-info {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 480px) {
            .generate-btn {
                font-size: 16px;
                padding: 12px 20px;
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
                    <h2>FLUX.1文生图API</h2>
                    <p>AIGC官方镜像，指令优化版</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">

                    <div class="error-message" id="error-message"></div>
                    

                    <div class="form-section">
                        <form id="flux-form">
        
                            <div class="form-group">
                                <label for="prompt" class="form-label">绘画提示词 <span style="color: #ef4444;">*</span></label>
                                <textarea type="text" id="prompt" name="prompt" class="form-input prompt-input" placeholder="请输入绘画提示词，支持中英文双语，不能大于500个字符" rows="3" required></textarea>
                            </div>
                            
        
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="size" class="form-label">图像尺寸</label>
                                    <select id="size" name="size" class="form-select">
                                        <option value="1024*1024">1024*1024 (默认)</option>
                                        <option value="512*1024">512*1024</option>
                                        <option value="768*512">768*512</option>
                                        <option value="768*1024">768*1024</option>
                                        <option value="1024*576">1024*576</option>
                                        <option value="576*1024">576*1024</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="steps" class="form-label">绘画精细程度</label>
                                    <select id="steps" name="steps" class="form-select">
                                        <option value="4">4 (默认)</option>
                                        <option value="1">1 (最浅)</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10 (最深)</option>
                                    </select>
                                </div>
                            </div>
                            
        
                            <button type="submit" class="generate-btn" id="generate-btn">
                                <span class="loading" id="loading" style="display: none;"></span>
                                <span id="generate-text">生成图片</span>
                            </button>
                            
        
                            <div class="limit-info">
                                <strong>注意：</strong>由于是官方镜像，为了避免违规已内置违禁词检测，速率限制为每分钟/60次，图片仅保存24小时
                            </div>
                        </form>
                    </div>
                    

                    <div class="result-section" id="result-section">
                        <h3 class="result-title">生成结果</h3>
                        <div class="image-container">
                            <img id="generated-image" class="generated-image" src="" alt="生成的图片">
                        </div>
                        <div class="image-info">
                            <div class="info-item">
                                <span class="info-label">提示词</span>
                                <span class="info-value" id="result-prompt"></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">图像尺寸</span>
                                <span class="info-value" id="result-size"></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">精细程度</span>
                                <span class="info-value" id="result-steps"></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">图片链接</span>
                                <span class="info-value" id="result-url"></span>
                            </div>
                        </div>
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


        class Flux1 {
            constructor() {

                this.form = document.getElementById('flux-form');
                this.promptInput = document.getElementById('prompt');
                this.sizeInput = document.getElementById('size');
                this.stepsInput = document.getElementById('steps');
                this.generateBtn = document.getElementById('generate-btn');
                this.generateText = document.getElementById('generate-text');
                this.loading = document.getElementById('loading');
                this.errorMessage = document.getElementById('error-message');
                this.resultSection = document.getElementById('result-section');
                this.generatedImage = document.getElementById('generated-image');
                this.resultPrompt = document.getElementById('result-prompt');
                this.resultSize = document.getElementById('result-size');
                this.resultSteps = document.getElementById('result-steps');
                this.resultUrl = document.getElementById('result-url');
                

                this.apiUrl = '../php/flux1-proxy.php';
                

                this.init();
            }
            
            
            init() {

                this.initEventListeners();
            }
            
            
            initEventListeners() {

                this.form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.generateImage();
                });
                

                this.promptInput.addEventListener('input', () => {
                    const prompt = this.promptInput.value;
                    if (prompt.length > 500) {
                        this.promptInput.value = prompt.substring(0, 500);
                    }
                });
            }
            
            
            showError(message) {
                this.errorMessage.textContent = message;
                this.errorMessage.style.display = 'block';
                
                
                setTimeout(() => {
                    this.errorMessage.style.display = 'none';
                }, 5000);
            }
            
            
            hideError() {
                this.errorMessage.style.display = 'none';
            }
            
            
            showResult(data) {
                
                this.generatedImage.src = data.url;
                
                
                this.resultPrompt.textContent = data.prompt;
                this.resultSize.textContent = data.size;
                this.resultSteps.textContent = data.steps;
                
                
                const urlLink = document.createElement('a');
                urlLink.href = data.url;
                urlLink.target = '_blank';
                urlLink.textContent = data.url;
                urlLink.style.color = '#1a1a1a';
                urlLink.style.textDecoration = 'underline';
                
                
                this.resultUrl.innerHTML = '';
                this.resultUrl.appendChild(urlLink);
                
区域
                this.resultSection.classList.add('visible');
            }
            
            
            async generateImage() {

                const prompt = this.promptInput.value.trim();
                const size = this.sizeInput.value;
                const steps = this.stepsInput.value;
                

                if (!prompt) {
                    return;
                }
                
                if (prompt.length > 500) {
                    this.showError('提示词不能超过500个字符');
                    return;
                }
                
                
                this.hideError();
                this.resultSection.classList.remove('visible');
                

                this.generateText.style.display = 'none';
                this.loading.style.display = 'inline-block';
                this.generateBtn.disabled = true;
                

                const startTime = Date.now();
                
                try {
    
                    const params = new URLSearchParams();
                    params.append('prompt', prompt);
                    params.append('size', size);
                    params.append('steps', steps);
                    params.append('type', 'json');
                    
    
                    const response = await fetch(`${this.apiUrl}?${params.toString()}`, {
                        method: 'GET'
                    });
                    
    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
    
                    const data = await response.json();
                    
                    
                    const responseTime = Date.now() - startTime;
                    
    
                    if (data.error === false) {
        
        
                        await recordToolUsage('flux1', 'generateImage', 1, responseTime, prompt);
                        
                        this.showResult({
                            url: data.data.url,
                            prompt: data.data.prompt,
                            size: data.data.size,
                            steps: data.data.steps
                        });
                    } else {
        
        
                        await recordToolUsage('flux1', 'generateImage', 0, responseTime, prompt);
                        throw new Error(data.message || '生成图片失败');
                    }
                } catch (error) {
                    console.error('生成图片失败:', error);
                    
                    
                    const responseTime = Date.now() - startTime;
                    
                    
                    await recordToolUsage('flux1', 'generateImage', 0, responseTime, prompt);
                    
                    this.showError(`生成图片失败: ${error.message}`);
                } finally {
    
                    this.generateText.style.display = 'inline';
                    this.loading.style.display = 'none';
                    this.generateBtn.disabled = false;
                }
            }
        }
        

        let flux1;
        document.addEventListener('DOMContentLoaded', () => {
            flux1 = new Flux1();
        });
    </script>
</body>
</html>