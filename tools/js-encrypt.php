<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JavaScript代码加密工具 - 工具箱</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 800px;
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

        
        .obfuscation-level {
            margin-bottom: 30px;
        }

        .level-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 12px;
        }

        .level-options {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .level-option {
            padding: 8px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #fafafa;
            color: #666;
        }

        .level-option.active {
            background-color: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
        }

        
        .options-section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }

        .options-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }

        .options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
        }

        .option-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .option-label {
            font-size: 14px;
            color: #333;
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

        textarea {
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

        textarea:focus {
            outline: none;
            border-color: #1a1a1a;
            background-color: #fff;
        }

        textarea[readonly] {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }

        
        .btn {
            padding: 8px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 12px;
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

        
        .result-stats {
            display: flex;
            gap: 20px;
            padding: 16px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .stat-label {
            font-size: 12px;
            color: #666;
        }

        .stat-value {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
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

            .level-options {
                flex-direction: column;
            }

            .options-grid {
                grid-template-columns: 1fr;
            }

            .input-output {
                grid-template-columns: 1fr;
            }

            .result-stats {
                flex-direction: column;
                gap: 12px;
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
                    <h2>JavaScript代码加密工具</h2>
                    <p>JavaScript代码压缩、混淆和加密，保护您的代码安全</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    
                    <div class="obfuscation-level">
                        <div class="level-title">混淆级别</div>
                        <div class="level-options">
                            <div class="level-option active" data-level="simple">简单混淆</div>
                            <div class="level-option" data-level="medium">中等混淆</div>
                            <div class="level-option" data-level="advanced">高级混淆</div>
                        </div>
                    </div>
                    
                    
                    <div class="options-section">
                        <div class="options-title">选项设置</div>
                        <div class="options-grid">
                            <div class="option-item">
                                <input type="checkbox" id="remove-comments" checked>
                                <label for="remove-comments" class="option-label">移除注释</label>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" id="remove-whitespace" checked>
                                <label for="remove-whitespace" class="option-label">移除空格</label>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" id="rename-variables" checked>
                                <label for="rename-variables" class="option-label">重命名变量</label>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" id="rename-functions" checked>
                                <label for="rename-functions" class="option-label">重命名函数</label>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" id="encode-strings" checked>
                                <label for="encode-strings" class="option-label">编码字符串</label>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" id="add-garbage" checked>
                                <label for="add-garbage" class="option-label">添加垃圾代码</label>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="input-output">
                        
                        <div class="panel">
                            <div class="panel-header">
                                <div class="panel-title">输入JavaScript代码</div>
                                <div class="panel-actions">
                                    <button class="btn" id="clear-input">清空</button>
                                    <button class="btn" id="copy-input">复制</button>
                                </div>
                            </div>
                            <div class="textarea-container">
                                <textarea id="input-code" placeholder="请输入要加密的JavaScript代码">// 示例代码
function calculateSum(a, b) {
    // 计算两个数的和
    const sum = a + b;
    console.log(`Sum: ${sum}`);
    return sum;
}

// 调用函数
const result = calculateSum(5, 10);
alert(`Result: ${result}`);</textarea>
                            </div>
                        </div>
                        
                        
                        <div class="panel">
                            <div class="panel-header">
                                <div class="panel-title">加密后的代码</div>
                                <div class="panel-actions">
                                    <button class="btn" id="copy-output">复制</button>
                                    <button class="btn" id="clear-output">清空</button>
                                </div>
                            </div>
                            <div class="textarea-container">
                                <textarea id="output-code" placeholder="加密后的代码" readonly></textarea>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="result-stats">
                        <div class="stat-item">
                            <div class="stat-label">原始大小</div>
                            <div class="stat-value" id="original-size">0</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">加密后大小</div>
                            <div class="stat-value" id="encrypted-size">0</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">压缩率</div>
                            <div class="stat-value" id="compression-rate">0%</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">加密时间</div>
                            <div class="stat-value" id="encryption-time">0 ms</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        
        class JSEncryptor {
            constructor() {
                this.currentLevel = 'simple';
                this.removeComments = true;
                this.removeWhitespace = true;
                this.renameVariables = true;
                this.renameFunctions = true;
                this.encodeStrings = true;
                this.addGarbage = true;
                
                this.levelOptions = document.querySelectorAll('.level-option');
                this.removeCommentsCheckbox = document.getElementById('remove-comments');
                this.removeWhitespaceCheckbox = document.getElementById('remove-whitespace');
                this.renameVariablesCheckbox = document.getElementById('rename-variables');
                this.renameFunctionsCheckbox = document.getElementById('rename-functions');
                this.encodeStringsCheckbox = document.getElementById('encode-strings');
                this.addGarbageCheckbox = document.getElementById('add-garbage');
                
                this.inputCode = document.getElementById('input-code');
                this.outputCode = document.getElementById('output-code');
                this.clearInputBtn = document.getElementById('clear-input');
                this.copyInputBtn = document.getElementById('copy-input');
                this.clearOutputBtn = document.getElementById('clear-output');
                this.copyOutputBtn = document.getElementById('copy-output');
                
                this.originalSize = document.getElementById('original-size');
                this.encryptedSize = document.getElementById('encrypted-size');
                this.compressionRate = document.getElementById('compression-rate');
                this.encryptionTime = document.getElementById('encryption-time');
                
                this.variableMap = {};
                this.functionMap = {};
                
                this.initEventListeners();
                this.encrypt();
            }
            
            
            initEventListeners() {
                
                this.levelOptions.forEach(option => {
                    option.addEventListener('click', (e) => {
                        this.switchLevel(e.target.dataset.level);
                    });
                });
                
                
                this.removeCommentsCheckbox.addEventListener('change', (e) => {
                    this.removeComments = e.target.checked;
                    this.encrypt();
                });
                
                this.removeWhitespaceCheckbox.addEventListener('change', (e) => {
                    this.removeWhitespace = e.target.checked;
                    this.encrypt();
                });
                
                this.renameVariablesCheckbox.addEventListener('change', (e) => {
                    this.renameVariables = e.target.checked;
                    this.encrypt();
                });
                
                this.renameFunctionsCheckbox.addEventListener('change', (e) => {
                    this.renameFunctions = e.target.checked;
                    this.encrypt();
                });
                
                this.encodeStringsCheckbox.addEventListener('change', (e) => {
                    this.encodeStrings = e.target.checked;
                    this.encrypt();
                });
                
                this.addGarbageCheckbox.addEventListener('change', (e) => {
                    this.addGarbage = e.target.checked;
                    this.encrypt();
                });
                
                
                this.inputCode.addEventListener('input', () => {
                    this.encrypt();
                });
                
                
                this.clearInputBtn.addEventListener('click', () => this.clearInput());
                this.copyInputBtn.addEventListener('click', () => this.copyToClipboard(this.inputCode.value));
                this.clearOutputBtn.addEventListener('click', () => this.clearOutput());
                this.copyOutputBtn.addEventListener('click', () => this.copyToClipboard(this.outputCode.value));
            }
            
            
            switchLevel(level) {
                this.currentLevel = level;
                
                
                this.levelOptions.forEach(option => {
                    option.classList.toggle('active', option.dataset.level === level);
                });
                
                
                if (level === 'simple') {
                    this.removeComments = true;
                    this.removeWhitespace = true;
                    this.renameVariables = false;
                    this.renameFunctions = false;
                    this.encodeStrings = false;
                    this.addGarbage = false;
                } else if (level === 'medium') {
                    this.removeComments = true;
                    this.removeWhitespace = true;
                    this.renameVariables = true;
                    this.renameFunctions = true;
                    this.encodeStrings = false;
                    this.addGarbage = false;
                } else if (level === 'advanced') {
                    this.removeComments = true;
                    this.removeWhitespace = true;
                    this.renameVariables = true;
                    this.renameFunctions = true;
                    this.encodeStrings = true;
                    this.addGarbage = true;
                }
                
                
                this.removeCommentsCheckbox.checked = this.removeComments;
                this.removeWhitespaceCheckbox.checked = this.removeWhitespace;
                this.renameVariablesCheckbox.checked = this.renameVariables;
                this.renameFunctionsCheckbox.checked = this.renameFunctions;
                this.encodeStringsCheckbox.checked = this.encodeStrings;
                this.addGarbageCheckbox.checked = this.addGarbage;
                
                
                this.encrypt();
            }
            
            
            encrypt() {
                const input = this.inputCode.value;
                const startTime = performance.now();
                
                
                this.variableMap = {};
                this.functionMap = {};
                
                let output = input;
                
                
                if (this.removeComments) {
                    output = this.removeCommentsFromCode(output);
                }
                
                
                if (this.renameFunctions) {
                    output = this.renameFunctionsInCode(output);
                }
                
                
                if (this.renameVariables) {
                    output = this.renameVariablesInCode(output);
                }
                
                
                if (this.encodeStrings) {
                    output = this.encodeStringsInCode(output);
                }
                
                
                if (this.removeWhitespace) {
                    output = this.removeWhitespaceFromCode(output);
                }
                
                
                if (this.addGarbage) {
                    output = this.addGarbageCode(output);
                }
                
                const endTime = performance.now();
                const timeTaken = Math.round(endTime - startTime);
                
                
                this.outputCode.value = output;
                
                
                this.updateStats(input, output, timeTaken);
                
                
                recordToolUsage(this.currentLevel);
            }
            
            
            removeCommentsFromCode(code) {
                
                code = code.replace(/\/\/.*$/gm, '');
                
                code = code.replace(/\/\*[\s\S]*?\*\//g, '');
                return code;
            }
            
            
            removeWhitespaceFromCode(code) {
                
                code = code.replace(/\s+/g, ' ');
                code = code.replace(/\s*([{}();,.:=+\-*/%&|^!~<>?])\s*/g, '$1');
                code = code.replace(/^\s+|\s+$/g, '');
                return code;
            }
            
            
            generateRandomId(length = 3) {
                const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                let result = '';
                for (let i = 0; i < length; i++) {
                    result += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                return result;
            }
            
            
            renameFunctionsInCode(code) {
                
                const functionRegex = /function\s+([a-zA-Z_$][a-zA-Z0-9_$]*)/g;
                return code.replace(functionRegex, (match, name) => {
                    if (!this.functionMap[name]) {
                        this.functionMap[name] = this.generateRandomId();
                    }
                    return `function ${this.functionMap[name]}`;
                });
            }
            
            
            renameVariablesInCode(code) {
                
                const variableRegex = /(let|const|var)\s+([a-zA-Z_$][a-zA-Z0-9_$]*)/g;
                return code.replace(variableRegex, (match, keyword, name) => {
                    if (!this.variableMap[name]) {
                        this.variableMap[name] = this.generateRandomId();
                    }
                    return `${keyword} ${this.variableMap[name]}`;
                });
            }
            
            
            encodeStringsInCode(code) {
                
                const stringRegex = /"([^"]*)"|'([^']*)'/g;
                return code.replace(stringRegex, (match, doubleQuoteContent, singleQuoteContent) => {
                    const content = doubleQuoteContent || singleQuoteContent;
                    const quote = doubleQuoteContent ? '"' : "'";
                    
                    
                    let encoded = '';
                    for (let i = 0; i < content.length; i++) {
                        encoded += '\\x' + content.charCodeAt(i).toString(16).padStart(2, '0');
                    }
                    
                    return quote + encoded + quote;
                });
            }
            
            
            addGarbageCode(code) {
                const garbageFunctions = [
                    'function _(){}',
                    'const __=0;',
                    'let ___=function(){};',
                    'var ____=[];',
                    'function _____()return;'
                ];
                
                
                return garbageFunctions.join('') + code;
            }
            
            
            clearInput() {
                this.inputCode.value = '';
                this.encrypt();
            }
            
            
            clearOutput() {
                this.outputCode.value = '';
            }
            
            
            async copyToClipboard(text) {
                try {
                    await navigator.clipboard.writeText(text);
                    alert('已复制到剪贴板');
                } catch (err) {
                    
                    const textArea = document.createElement('textarea');
                    textArea.value = text;
                    textArea.style.position = 'fixed';
                    textArea.style.left = '-999999px';
                    textArea.style.top = '-999999px';
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    alert('已复制到剪贴板');
                }
            }
            
            
            updateStats(input, output, timeTaken) {
                const originalBytes = new Blob([input]).size;
                const encryptedBytes = new Blob([output]).size;
                const rate = originalBytes > 0 ? Math.round((1 - encryptedBytes / originalBytes) * 100) : 0;
                
                this.originalSize.textContent = this.formatSize(originalBytes);
                this.encryptedSize.textContent = this.formatSize(encryptedBytes);
                this.compressionRate.textContent = `${rate}%`;
                this.encryptionTime.textContent = `${timeTaken} ms`;
            }
            
            
            formatSize(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(2) + ' KB';
                return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
            }
        }
        
        
        function recordToolUsage(action) {
            
            fetch('../php/record-tool-usage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tool_id: 'js-encrypt',
                    action: action
                })
            }).catch(error => {
                console.error('记录使用量失败:', error);
            });
        }
        
        
        document.addEventListener('DOMContentLoaded', () => {
            new JSEncryptor();
        });
    </script>
</body>
</html>