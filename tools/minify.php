<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML压缩 - 工具箱</title>
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
        
        .minify-type {
            margin-bottom: 30px;
        }
        
        .type-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .type-tab {
            padding: 12px 24px;
            background-color: transparent;
            border: none;
            border-bottom: 2px solid transparent;
            font-size: 16px;
            font-weight: 600;
            color: #666;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .type-tab.active {
            color: #1a1a1a;
            border-bottom-color: #1a1a1a;
        }
        
        .minify-settings {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        
        .setting-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .setting-label {
            font-size: 14px;
            color: #666;
        }
        
        .input-output {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .panel {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px 8px 0 0;
        }
        
        .panel-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .panel-actions {
            display: flex;
            gap: 8px;
        }
        
        .textarea-container {
            position: relative;
        }
        
        .text-input {
            width: 100%;
            min-height: 400px;
            padding: 16px;
            border: 1px solid #e0e0e0;
            border-radius: 0 0 8px 8px;
            font-size: 14px;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            line-height: 1.5;
            resize: vertical;
            background-color: #fafafa;
            color: #1a1a1a;
        }
        
        .text-input:focus {
            outline: none;
            border-color: #1a1a1a;
            background-color: #fff;
        }
        
        .btn {
            padding: 12px 24px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
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
        
        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        .result-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 16px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #666;
        }
        
        .info-value {
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 400px;
            color: #999;
            font-size: 14px;
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
            
            .input-output {
                grid-template-columns: 1fr;
            }
            
            .minify-settings {
                grid-template-columns: 1fr;
            }
            
            .result-info {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
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
                    <h2>HTML压缩</h2>
                    <p>压缩HTML、CSS、JS代码，减小文件体积</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    <div class="minify-type">
                        <div class="type-tabs">
                            <button class="type-tab active" data-type="html">HTML</button>
                            <button class="type-tab" data-type="css">CSS</button>
                            <button class="type-tab" data-type="js">JS</button>
                        </div>
                    </div>
                    
                    <div class="minify-settings">
                        <div class="setting-item">
                            <input type="checkbox" id="remove-comments" checked>
                            <label class="setting-label" for="remove-comments">移除注释</label>
                        </div>
                        <div class="setting-item">
                            <input type="checkbox" id="remove-whitespace" checked>
                            <label class="setting-label" for="remove-whitespace">移除空格</label>
                        </div>
                        <div class="setting-item">
                            <input type="checkbox" id="remove-newlines" checked>
                            <label class="setting-label" for="remove-newlines">移除换行</label>
                        </div>
                    </div>
                    
                    <div class="input-output">
                        <div class="panel">
                            <div class="panel-header">
                                <div class="panel-title">原始代码</div>
                                <div class="panel-actions">
                                    <button class="btn btn-small" id="clear-input">清空</button>
                                    <button class="btn btn-small" id="example-input">示例</button>
                                </div>
                            </div>
                            <div class="textarea-container">
                                <textarea class="text-input" id="input-code" placeholder="请输入要压缩的代码..."></textarea>
                            </div>
                        </div>
                        
                        <div class="panel">
                            <div class="panel-header">
                                <div class="panel-title">压缩结果</div>
                                <div class="panel-actions">
                                    <button class="btn btn-small" id="copy-output">复制</button>
                                    <button class="btn btn-small" id="download-output">下载</button>
                                </div>
                            </div>
                            <div class="textarea-container">
                                <textarea class="text-input" id="output-code" placeholder="压缩结果将显示在这里..." readonly></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="result-info">
                        <div class="info-item">
                            原始大小: <span class="info-value" id="original-size">0</span> 字节
                        </div>
                        <div class="info-item">
                            压缩大小: <span class="info-value" id="compressed-size">0</span> 字节
                        </div>
                        <div class="info-item">
                            压缩率: <span class="info-value" id="compression-ratio">0%</span>
                        </div>
                        <div class="info-item">
                            <button class="btn btn-primary" id="minify-btn">开始压缩</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        class CodeMinifier {
            constructor() {
                this.currentType = 'html';
                
                this.typeTabs = document.querySelectorAll('.type-tab');
                this.removeComments = document.getElementById('remove-comments');
                this.removeWhitespace = document.getElementById('remove-whitespace');
                this.removeNewlines = document.getElementById('remove-newlines');
                this.inputCode = document.getElementById('input-code');
                this.outputCode = document.getElementById('output-code');
                this.clearInput = document.getElementById('clear-input');
                this.exampleInput = document.getElementById('example-input');
                this.copyOutput = document.getElementById('copy-output');
                this.downloadOutput = document.getElementById('download-output');
                this.minifyBtn = document.getElementById('minify-btn');
                this.originalSize = document.getElementById('original-size');
                this.compressedSize = document.getElementById('compressed-size');
                this.compressionRatio = document.getElementById('compression-ratio');
                
                this.examples = {
                    html: `<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>示例页面</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <header>
        <h1>欢迎使用工具箱</h1>
    </header>
    <main>
        <p>这是一个示例页面，用于演示HTML压缩功能。</p>
    </main>
    <footer>
        <p>&copy; 2025 工具箱</p>
    </footer>
</body>
</html>`,
                    css: `/* 这是一个CSS注释 */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
}

h1 {
    color: #333;
    font-size: 24px;
    margin-bottom: 20px;
}

p {
    color: #666;
    line-height: 1.5;
}`,
                    js: `// 这是一个JavaScript注释
function hello() {
    console.log("Hello, World!");
    
    // 循环示例
    for (let i = 0; i < 10; i++) {
        console.log(i);
    }
}

// 调用函数
hello();`
                };
                
                this.initEventListeners();
                
                this.setExample();
            }
            
            initEventListeners() {
                this.typeTabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        this.switchType(tab.dataset.type);
                    });
                });
                
                this.clearInput.addEventListener('click', () => {
                    this.inputCode.value = '';
                    this.outputCode.value = '';
                    this.updateStats();
                });
                
                this.exampleInput.addEventListener('click', () => {
                    this.setExample();
                });
                
                this.copyOutput.addEventListener('click', () => {
                    this.copyToClipboard();
                });
                
                this.downloadOutput.addEventListener('click', () => {
                    this.downloadOutputFile();
                });
                
                this.minifyBtn.addEventListener('click', () => {
                    this.minify();
                });
                
                this.inputCode.addEventListener('input', () => {
                    this.updateStats();
                });
            }
            
            switchType(type) {
                this.currentType = type;
                
                this.typeTabs.forEach(tab => {
                    tab.classList.remove('active');
                });
                document.querySelector(`[data-type="${type}"]`).classList.add('active');
                
                this.setExample();
            }
            
            setExample() {
                this.inputCode.value = this.examples[this.currentType];
                this.updateStats();
            }
            
            minify() {
                const input = this.inputCode.value;
                if (!input) return;
                
                let output = input;
                
                switch (this.currentType) {
                    case 'html':
                        output = this.minifyHTML(input);
                        break;
                    case 'css':
                        output = this.minifyCSS(input);
                        break;
                    case 'js':
                        output = this.minifyJS(input);
                        break;
                }
                
                this.outputCode.value = output;
                this.updateStats();
                
                recordToolUsage(`minify_${this.currentType}`);
            }
            
            minifyHTML(code) {
                let result = code;
                
                if (this.removeComments.checked) {
                    result = result.replace(/<!--[\s\S]*?-->/g, '');
                }
                
                if (this.removeNewlines.checked) {
                    result = result.replace(/\r?\n/g, '');
                }
                
                if (this.removeWhitespace.checked) {
                    result = result.replace(/\s+/g, ' ');
                    result = result.replace(/>\s+</g, '><');
                }
                
                return result.trim();
            }
            
            minifyCSS(code) {
                let result = code;
                
                if (this.removeComments.checked) {
                    result = result.replace(/\/\*[\s\S]*?\*\//g, '');
                }
                
                if (this.removeNewlines.checked) {
                    result = result.replace(/\r?\n/g, '');
                }
                
                if (this.removeWhitespace.checked) {
                    result = result.replace(/\s+/g, ' ');
                    result = result.replace(/;\s*}/g, '}');
                    result = result.replace(/\s*{\s*/g, '{');
                    result = result.replace(/\s*:\s*/g, ':');
                    result = result.replace(/\s*;\s*/g, ';');
                    result = result.replace(/,\s*/g, ',');
                }
                
                return result.trim();
            }
            
            minifyJS(code) {
                let result = code;
                
                if (this.removeComments.checked) {
                    result = result.replace(/\/\/.*$/gm, '');
                    result = result.replace(/\/\*[\s\S]*?\*\//g, '');
                }
                
                if (this.removeNewlines.checked) {
                    result = result.replace(/\r?\n/g, '');
                }
                
                if (this.removeWhitespace.checked) {
                    result = result.replace(/\s+/g, ' ');
                    result = result.replace(/\s*{\s*/g, '{');
                    result = result.replace(/\s*}\s*/g, '}');
                    result = result.replace(/\s*:\s*/g, ':');
                    result = result.replace(/\s*;\s*/g, ';');
                    result = result.replace(/,\s*/g, ',');
                    result = result.replace(/\s*\+\s*/g, '+');
                    result = result.replace(/\s*-\s*/g, '-');
                    result = result.replace(/\s*\*\s*/g, '*');
                    result = result.replace(/\s*\/\s*/g, '/');
                    result = result.replace(/\s*===\s*/g, '===');
                    result = result.replace(/\s*==\s*/g, '==');
                    result = result.replace(/\s*!==\s*/g, '!==');
                    result = result.replace(/\s*!=\s*/g, '!=');
                    result = result.replace(/\s*<\s*/g, '<');
                    result = result.replace(/\s*>\s*/g, '>');
                    result = result.replace(/\s*<=\s*/g, '<=');
                    result = result.replace(/\s*>=\s*/g, '>=');
                    result = result.replace(/\s*&&\s*/g, '&&');
                    result = result.replace(/\s*\|\|\s*/g, '||');
                }
                
                return result.trim();
            }
            
            updateStats() {
                const input = this.inputCode.value;
                const output = this.outputCode.value;
                
                const originalSize = new Blob([input]).size;
                const compressedSize = new Blob([output]).size;
                
                this.originalSize.textContent = originalSize;
                this.compressedSize.textContent = compressedSize;
                
                if (originalSize > 0) {
                    const ratio = Math.round((1 - compressedSize / originalSize) * 100);
                    this.compressionRatio.textContent = ratio + '%';
                } else {
                    this.compressionRatio.textContent = '0%';
                }
            }
            
            async copyToClipboard() {
                const output = this.outputCode.value;
                if (!output) return;
                
                try {
                    await navigator.clipboard.writeText(output);
                    this.showNotification('已复制到剪贴板');
                } catch (err) {
                    console.error('复制失败:', err);
                }
            }
            
            downloadOutputFile() {
                const output = this.outputCode.value;
                if (!output) return;
                
                const blob = new Blob([output], { type: 'text/plain' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `minified.${this.currentType}`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }
            
            showNotification(message) {
                const notification = document.createElement('div');
                notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: #1a1a1a;
                    color: #fff;
                    padding: 12px 24px;
                    border-radius: 8px;
                    font-size: 14px;
                    z-index: 1000;
                    animation: slideIn 0.3s ease;
                `;
                notification.textContent = message;
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 2000);
            }
        }
        
        function recordToolUsage(action) {
            fetch('../php/record-tool-usage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tool_id: 'minify',
                    action: action
                })
            }).catch(error => {
                console.error('记录使用量失败:', error);
            });
        }
        
        const codeMinifier = new CodeMinifier();
    </script>
</body>
</html>