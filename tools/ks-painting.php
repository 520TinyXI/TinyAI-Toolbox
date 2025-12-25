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
    <title>快手可图绘画 - <?php echo $siteConfig['name']; ?></title>
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
        
        .painting-section {
            background-color: #fafafa;
            padding: 24px;
            border-radius: 8px;
            margin-bottom: 24px;
            border: 1px solid #e0e0e0;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .form-textarea {
            width: 100%;
            min-height: 100px;
            padding: 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            resize: vertical;
            font-family: inherit;
        }
        
        .form-textarea:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 2px rgba(26, 26, 26, 0.1);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }
        
        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
        }
        
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
        
        .result-section {
            margin-bottom: 24px;
        }
        
        .result-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .image-result {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 24px;
            text-align: center;
        }
        
        .generated-images {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            justify-content: center;
            margin-bottom: 24px;
        }
        
        .generated-image {
            max-width: 100%;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .image-item {
            max-width: 400px;
            margin: 0 auto;
        }
        
        .image-url {
            font-size: 14px;
            color: #666;
            margin-top: 12px;
            word-break: break-all;
        }
        
        .action-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
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
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .generated-image {
                max-width: 100%;
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
                    <h2>快手可图绘画</h2>
                    <p>使用AI快速生成高质量绘画作品</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">
                    <div class="error-container" id="error-container" style="display: none;">
                        <div class="error-message" id="error-message">生成失败，请稍后重试</div>
                    </div>
                    
                    <div class="painting-section">
                        <form id="painting-form">
                            <div class="form-group">
                                <label for="msg" class="form-label">绘画提示词（必填）</label>
                                <textarea id="msg" name="msg" class="form-textarea" placeholder="请输入AI绘画提示词，支持中英文双语，例如：一只可爱的小狗在草地上玩耍" required></textarea>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="size" class="form-label">图像大小</label>
                                    <select id="size" name="size" class="form-select">
                                        <option value="1024x1024">1024x1024（默认）</option>
                                        <option value="256x256">256x256</option>
                                        <option value="512x512">512x512</option>
                                        <option value="768x768">768x768</option>
                                        <option value="1536x1536">1536x1536</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="guidance" class="form-label">匹配程度（1-10）</label>
                                    <select id="guidance" name="guidance" class="form-select">
                                        <option value="7.5">7.5（默认）</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="batch" class="form-label">生成数量</label>
                                    <select id="batch" name="batch" class="form-select">
                                        <option value="1">1张（默认）</option>
                                        <option value="2">2张</option>
                                        <option value="3">3张</option>
                                        <option value="4">4张</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div style="text-align: center;">
                                <button type="submit" class="btn btn-primary" id="generate-btn">
                                    <span class="loading-icon" style="display: none;">🔄</span>
                                    生成绘画
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="result-section" id="result-section" style="display: none;">
                        <h3 class="result-title">生成结果</h3>
                        
                        <div class="image-result">
                            <div class="generated-images" id="generated-images"></div>
                            
                            <div class="action-buttons">
                                <button type="button" class="btn" id="regenerate-btn">
                                    <span class="loading-icon" style="display: none;">🔄</span>
                                    重新生成
                                </button>
                                <button type="button" class="btn" id="save-btn">
                                    💾 保存图片
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="loading-container" id="loading-container" style="display: none;">
                        <div class="loading"></div>
                        <p>正在生成绘画，请稍候...</p>
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
        
        class KSPainting {
            constructor() {
                this.paintingForm = document.getElementById('painting-form');
                this.msgInput = document.getElementById('msg');
                this.sizeSelect = document.getElementById('size');
                this.guidanceSelect = document.getElementById('guidance');
                this.batchSelect = document.getElementById('batch');
                this.generateBtn = document.getElementById('generate-btn');
                this.regenerateBtn = document.getElementById('regenerate-btn');
                this.saveBtn = document.getElementById('save-btn');
                this.loadingIcon = this.generateBtn.querySelector('.loading-icon');
                this.regenerateLoadingIcon = this.regenerateBtn.querySelector('.loading-icon');
                this.resultSection = document.getElementById('result-section');
                this.generatedImages = document.getElementById('generated-images');
                this.loadingContainer = document.getElementById('loading-container');
                this.errorContainer = document.getElementById('error-container');
                this.errorMessage = document.getElementById('error-message');
                
                this.apiUrl = 'https://api.jkyai.top/API/ks/api.php';
                
                this.currentImages = [];
                
                this.init();
            }
            
            init() {
                this.initEventListeners();
            }
            
            initEventListeners() {
                this.paintingForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.generatePainting();
                });
                
                this.regenerateBtn.addEventListener('click', () => {
                    this.generatePainting();
                });
                
                this.saveBtn.addEventListener('click', () => {
                    this.saveImages();
                });
            }
            
            async generatePainting() {
                const msg = this.msgInput.value.trim();
                const size = this.sizeSelect.value;
                const guidance = this.guidanceSelect.value;
                const batch = this.batchSelect.value;
                
                if (!msg) {
                    this.showError('请输入绘画提示词');
                    return;
                }
                
                this.showLoading();
                
                const startTime = Date.now();
                
                try {
                    const params = new URLSearchParams();
                    params.append('msg', msg);
                    if (size) params.append('size', size);
                    if (guidance) params.append('guidance', guidance);
                    if (batch) params.append('batch', batch);
                    
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
                    
                    const responseText = await response.text();
                    console.log('响应数据:', responseText);
                    
                    const responseTime = Date.now() - startTime;
                    
                    if (responseText.startsWith('http')) {
                        const imageUrls = responseText.split(/\s+/);
                        
                        this.currentImages = imageUrls;
                        
                        this.showResults(imageUrls);
                        
                        await recordToolUsage('ks-painting', 'generate_painting', 1, responseTime, `生成绘画: ${msg.substring(0, 50)}...`);
                    } else {
                        throw new Error('API返回格式错误');
                    }
                } catch (error) {
                    console.error('生成失败:', error);
                    this.showError(`生成失败: ${error.message}`);
                    
                    const responseTime = Date.now() - startTime;
                    
                    await recordToolUsage('ks-painting', 'generate_painting', 0, responseTime, `生成绘画: ${msg.substring(0, 50)}...`);
                }
            }
            
            showResults(imageUrls) {
                this.generatedImages.innerHTML = '';
                
                imageUrls.forEach((url, index) => {
                    const imageItem = document.createElement('div');
                    imageItem.className = 'image-item';
                    
                    imageItem.innerHTML = `
                        <img src="${url}" alt="生成的绘画 ${index + 1}" class="generated-image">
                        <div class="image-url">${url}</div>
                    `;
                    
                    this.generatedImages.appendChild(imageItem);
                });
                
                this.hideLoading();
                this.resultSection.style.display = 'block';
            }
            
            saveImages() {
                if (this.currentImages.length === 0) {
                    this.showError('没有可保存的图片');
                    return;
                }
                
                this.currentImages.forEach((url, index) => {
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `ks-painting-${Date.now()}-${index + 1}.jpg`;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                });
            }
            
            showLoading() {
                this.generateBtn.disabled = true;
                this.regenerateBtn.disabled = true;
                this.loadingIcon.style.display = 'inline';
                this.regenerateLoadingIcon.style.display = 'inline';
                this.loadingContainer.style.display = 'block';
                this.resultSection.style.display = 'none';
                this.errorContainer.style.display = 'none';
            }
            
            hideLoading() {
                this.generateBtn.disabled = false;
                this.regenerateBtn.disabled = false;
                this.loadingIcon.style.display = 'none';
                this.regenerateLoadingIcon.style.display = 'none';
                this.loadingContainer.style.display = 'none';
            }
            
            showError(message) {
                this.errorMessage.textContent = message;
                this.errorContainer.style.display = 'block';
                this.resultSection.style.display = 'none';
                this.loadingContainer.style.display = 'none';
                this.generateBtn.disabled = false;
                this.regenerateBtn.disabled = false;
                this.loadingIcon.style.display = 'none';
                this.regenerateLoadingIcon.style.display = 'none';
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new KSPainting();
        });
    </script>
</body>
</html>