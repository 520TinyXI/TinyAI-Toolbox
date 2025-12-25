<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML实体转义工具 - 工具箱</title>
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
        
        
        .operation-switch {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 30px;
        }
        
        .operation-btn {
            padding: 12px 24px;
            background-color: transparent;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            color: #666;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .operation-btn.active {
            background-color: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
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
        
        
        .text-input {
            width: 100%;
            min-height: 300px;
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
        
        
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        
        .stats-section {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-bottom: 30px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        
        .examples-section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        
        .examples-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
            text-align: center;
        }
        
        .examples-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }
        
        .example-item {
            padding: 12px;
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .example-item:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
        }
        
        .example-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
        }
        
        .example-text {
            font-size: 14px;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            color: #1a1a1a;
            word-break: break-all;
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
            
            .operation-switch {
                flex-direction: column;
                align-items: stretch;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: stretch;
            }
            
            .stats-section {
                flex-direction: column;
                gap: 20px;
            }
            
            .examples-grid {
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
                    <h2>HTML实体转义工具</h2>
                    <p>HTML实体转义和反转义</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    
                    <div class="operation-switch">
                        <button class="operation-btn active" data-operation="encode">HTML转义</button>
                        <button class="operation-btn" data-operation="decode">HTML反转义</button>
                    </div>
                    
                    
                    <div class="input-output">
                        
                        <div class="panel">
                            <div class="panel-header">
                                <div class="panel-title">输入文本</div>
                                <div class="panel-actions">
                                    <button class="btn btn-small" id="clear-input">清空</button>
                                    <button class="btn btn-small" id="example-btn">示例</button>
                                </div>
                            </div>
                            <textarea class="text-input" id="input-text" placeholder="请输入要转换的文本..."></textarea>
                        </div>
                        
                        
                        <div class="panel">
                            <div class="panel-header">
                                <div class="panel-title">转换结果</div>
                                <div class="panel-actions">
                                    <button class="btn btn-small" id="copy-output">复制</button>
                                    <button class="btn btn-small" id="clear-output">清空</button>
                                </div>
                            </div>
                            <textarea class="text-input" id="output-text" placeholder="转换结果将显示在这里..." readonly></textarea>
                        </div>
                    </div>
                    
                    
                    <div class="action-buttons">
                        <button class="btn btn-primary" id="convert-btn">转换</button>
                        <button class="btn" id="swap-btn">交换</button>
                    </div>
                    
                    
                    <div class="stats-section">
                        <div class="stat-item">
                            <div class="stat-label">输入字符数</div>
                            <div class="stat-value" id="input-count">0</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">输出字符数</div>
                            <div class="stat-value" id="output-count">0</div>
                        </div>
                    </div>
                    
                    
                    <div class="examples-section">
                        <div class="examples-title">常用示例</div>
                        <div class="examples-grid">
                            <div class="example-item" data-text="&lt;div&gt;Hello World&lt;/div&gt;">
                                <div class="example-label">HTML标签</div>
                                <div class="example-text">&lt;div&gt;Hello World&lt;/div&gt;</div>
                            </div>
                            <div class="example-item" data-text="&amp;amp; &amp;lt; &amp;gt; &amp;quot; &amp;#39;">
                                <div class="example-label">特殊字符</div>
                                <div class="example-text">&amp;amp; &amp;lt; &amp;gt; &amp;quot; &amp;#39;</div>
                            </div>
                            <div class="example-item" data-text="&copy; 2025 工具箱">
                                <div class="example-label">版权符号</div>
                                <div class="example-text">&copy; 2025 工具箱</div>
                            </div>
                            <div class="example-item" data-text="&#x1F600; &#x1F601; &#x1F602;">
                                <div class="example-label">表情符号</div>
                                <div class="example-text">&#x1F600; &#x1F601; &#x1F602;</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        
        function recordToolUsage(action) {
            
            fetch('../php/record-tool-usage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tool_id: 'html-entity',
                    action: action
                })
            }).catch(error => {
                console.error('记录使用量失败:', error);
            });
        }
        
        
        class HTMLEntityConverter {
            constructor() {
                this.currentOperation = 'encode';
                
                
                this.operationBtns = document.querySelectorAll('.operation-btn');
                this.inputText = document.getElementById('input-text');
                this.outputText = document.getElementById('output-text');
                this.clearInputBtn = document.getElementById('clear-input');
                this.exampleBtn = document.getElementById('example-btn');
                this.copyOutputBtn = document.getElementById('copy-output');
                this.clearOutputBtn = document.getElementById('clear-output');
                this.convertBtn = document.getElementById('convert-btn');
                this.swapBtn = document.getElementById('swap-btn');
                this.inputCount = document.getElementById('input-count');
                this.outputCount = document.getElementById('output-count');
                this.exampleItems = document.querySelectorAll('.example-item');
                
                
                this.initEventListeners();
            }
            
            
            initEventListeners() {
                
                this.operationBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        this.switchOperation(btn.dataset.operation);
                    });
                });
                
                
                this.clearInputBtn.addEventListener('click', () => {
                    this.inputText.value = '';
                    this.outputText.value = '';
                    this.updateStats();
                });
                
                
                this.exampleBtn.addEventListener('click', () => {
                    this.loadExample();
                });
                
                
                this.copyOutputBtn.addEventListener('click', () => {
                    this.copyToClipboard();
                });
                
                
                this.clearOutputBtn.addEventListener('click', () => {
                    this.outputText.value = '';
                    this.updateStats();
                });
                
                
                this.convertBtn.addEventListener('click', () => {
                    this.convert();
                });
                
                
                this.swapBtn.addEventListener('click', () => {
                    this.swap();
                });
                
                
                this.inputText.addEventListener('input', () => {
                    this.convert();
                });
                
                
                this.exampleItems.forEach(item => {
                    item.addEventListener('click', () => {
                        this.loadExampleText(item.dataset.text);
                    });
                });
            }
            
            
            switchOperation(operation) {
                this.currentOperation = operation;
                
                
                this.operationBtns.forEach(btn => {
                    btn.classList.remove('active');
                });
                document.querySelector(`[data-operation="${operation}"]`).classList.add('active');
                
                
                this.convertBtn.textContent = operation === 'encode' ? 'HTML转义' : 'HTML反转义';
                
                
                this.convert();
            }
            
            
            encodeHTML(text) {
                return text
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#x27;')
                    .replace(/\//g, '&#x2F;');
            }
            
            
            decodeHTML(text) {
                const temp = document.createElement('textarea');
                temp.innerHTML = text;
                return temp.value;
            }
            
            
            convert() {
                const input = this.inputText.value;
                let output = '';
                
                if (this.currentOperation === 'encode') {
                    output = this.encodeHTML(input);
                } else {
                    output = this.decodeHTML(input);
                }
                
                // 显示结果
                this.outputText.value = output;
                
                // 更新统计
                this.updateStats();
                
                // 记录使用量
                recordToolUsage(this.currentOperation);
            }
            
            
            swap() {
                const temp = this.inputText.value;
                this.inputText.value = this.outputText.value;
                this.outputText.value = temp;
                this.updateStats();
                this.convert();
            }
            
            
            updateStats() {
                this.inputCount.textContent = this.inputText.value.length;
                this.outputCount.textContent = this.outputText.value.length;
            }
            
            
            async copyToClipboard() {
                const output = this.outputText.value;
                if (!output) return;
                
                try {
                    await navigator.clipboard.writeText(output);
                    this.showNotification('已复制到剪贴板');
                    recordToolUsage('copy');
                } catch (err) {
                    console.error('复制失败:', err);
                    
                    const textarea = document.createElement('textarea');
                    textarea.value = output;
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);
                    this.showNotification('已复制到剪贴板');
                    recordToolUsage('copy');
                }
            }
            
            
            loadExample() {
                const example = '<div class="example">Hello & World!</div>';
                this.inputText.value = example;
                this.convert();
            }
            
            
            loadExampleText(text) {
                this.inputText.value = text;
                this.convert();
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
                    animation: fadeIn 0.3s ease;
                `;
                notification.textContent = message;
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 2000);
            }
        }
        
        
        const htmlEntityConverter = new HTMLEntityConverter();
    </script>
</body>
</html>