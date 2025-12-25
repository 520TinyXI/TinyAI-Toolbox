<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL编码 - 工具箱</title>
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
        
        .tool-tabs {
            display: flex;
            margin-bottom: 24px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .tab-btn {
            padding: 12px 24px;
            background-color: transparent;
            border: none;
            border-bottom: 2px solid transparent;
            font-size: 16px;
            font-weight: 500;
            color: #666;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 16px;
        }
        
        .tab-btn.active {
            color: #1a1a1a;
            border-bottom-color: #1a1a1a;
        }
        
        .tab-btn:hover {
            color: #1a1a1a;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .input-section {
            margin-bottom: 24px;
        }
        
        .input-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .input-textarea {
            width: 100%;
            min-height: 200px;
            padding: 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            resize: vertical;
            transition: all 0.3s ease;
        }
        
        .input-textarea:focus {
            outline: none;
            border-color: #ccc;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
        }
        
        .options {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        
        .option-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-group {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 24px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background-color: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
        }
        
        .btn-primary:hover {
            background-color: #333;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }
        
        .btn-secondary {
            background-color: #f5f5f5;
            color: #333;
        }
        
        .btn-secondary:hover {
            background-color: #e0e0e0;
        }
        
        .btn-success {
            background-color: #e8f5e8;
            color: #2e7d32;
            border-color: #c8e6c9;
        }
        
        .btn-success:hover {
            background-color: #c8e6c9;
        }
        
        .output-section {
            margin-top: 24px;
        }
        
        .output-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .output-box {
            width: 100%;
            min-height: 200px;
            padding: 16px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            resize: vertical;
            white-space: pre-wrap;
            word-break: break-all;
            font-family: 'Courier New', Courier, monospace;
        }
        
        .stats {
            display: flex;
            gap: 24px;
            margin-bottom: 24px;
            padding: 16px;
            background-color: #fafafa;
            border-radius: 8px;
            flex-wrap: wrap;
        }
        
        .stat-item {
            display: flex;
            flex-direction: column;
        }
        
        .stat-label {
            font-size: 12px;
            color: #999;
            margin-bottom: 4px;
        }
        
        .stat-value {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .info-box {
            background-color: #f0f7ff;
            border: 1px solid #e1e8ed;
            border-radius: 8px;
            padding: 16px;
            margin-top: 24px;
        }
        
        .info-title {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .info-text {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
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
            
            .btn-group {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
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
                    <h2>URL编码</h2>
                    <p>在线URL编码解码工具，支持完整URL和部分URL编码</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">

                    <div class="tool-tabs">
                        <button class="tab-btn active" data-tab="encode">编码</button>
                        <button class="tab-btn" data-tab="decode">解码</button>
                    </div>
                    

                    <div class="tab-content active" id="encode">
                        <div class="stats">
                            <div class="stat-item">
                                <span class="stat-label">输入字符数</span>
                                <span class="stat-value" id="encode-input-count">0</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">输出字符数</span>
                                <span class="stat-value" id="encode-output-count">0</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">编码率</span>
                                <span class="stat-value" id="encode-ratio">0%</span>
                            </div>
                        </div>
                        
                        <div class="options">
                            <div class="option-item">
                                <input type="checkbox" id="encode-full-url" name="encode-full-url" value="1">
                                <label for="encode-full-url">完整URL编码</label>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" id="encode-space-plus" name="encode-space-plus" value="1" checked>
                                <label for="encode-space-plus">空格编码为+</label>
                            </div>
                        </div>
                        
                        <div class="input-section">
                            <label for="encode-input" class="input-label">输入URL或文本</label>
                            <textarea class="input-textarea" id="encode-input" placeholder="请输入要编码的URL或文本..."></textarea>
                        </div>
                        
                        <div class="btn-group">
                            <button class="btn btn-primary" id="encode-btn">编码</button>
                            <button class="btn btn-secondary" id="clear-encode-btn">清空</button>
                            <button class="btn btn-success" id="copy-encode-btn">复制结果</button>
                        </div>
                        
                        <div class="output-section">
                            <label for="encode-output" class="output-label">URL编码结果</label>
                            <textarea class="output-box" id="encode-output" readonly></textarea>
                        </div>
                    </div>
                    

                    <div class="tab-content" id="decode">
                        <div class="stats">
                            <div class="stat-item">
                                <span class="stat-label">输入字符数</span>
                                <span class="stat-value" id="decode-input-count">0</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-value" id="decode-output-count">0</span>
                                <span class="stat-label">输出字符数</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">解码率</span>
                                <span class="stat-value" id="decode-ratio">0%</span>
                            </div>
                        </div>
                        
                        <div class="options">
                            <div class="option-item">
                                <input type="checkbox" id="decode-plus-space" name="decode-plus-space" value="1" checked>
                                <label for="decode-plus-space">+解码为空格</label>
                            </div>
                        </div>
                        
                        <div class="input-section">
                            <label for="decode-input" class="input-label">输入URL编码文本</label>
                            <textarea class="input-textarea" id="decode-input" placeholder="请输入要解码的URL编码文本..."></textarea>
                        </div>
                        
                        <div class="btn-group">
                            <button class="btn btn-primary" id="decode-btn">解码</button>
                            <button class="btn btn-secondary" id="clear-decode-btn">清空</button>
                            <button class="btn btn-success" id="copy-decode-btn">复制结果</button>
                        </div>
                        
                        <div class="output-section">
                            <label for="decode-output" class="output-label">URL解码结果</label>
                            <textarea class="output-box" id="decode-output" readonly></textarea>
                        </div>
                    </div>
                    

                    <div class="info-box">
                        <div class="info-title">关于URL编码</div>
                        <div class="info-text">
                            URL编码是一种用于将URL中的特殊字符转换为浏览器可识别格式的编码方式。
                            <ul style="margin-top: 8px; padding-left: 20px;">
                                <li>URL编码将特殊字符转换为%后跟两位十六进制数</li>
                                <li>空格可以编码为+或%20</li>
                                <li>URL编码确保URL中的特殊字符不会被误解为URL分隔符</li>
                                <li>常用于表单提交和URL参数传递</li>
                            </ul>
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
                    tool_id: 'url',
                    action: action
                })
            }).catch(error => {
                console.error('记录使用量失败:', error);
            });
        }
        

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const tabId = btn.getAttribute('data-tab');
                

                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                

                btn.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            });
        });
        

        function encodeURL() {
            const input = document.getElementById('encode-input').value;
            const fullURL = document.getElementById('encode-full-url').checked;
            const spacePlus = document.getElementById('encode-space-plus').checked;
            
            let output;
            if (fullURL) {

                output = encodeURI(input);
            } else {

                output = encodeURIComponent(input);
            }
            
            if (!spacePlus) {

                output = output.replace(/\+/g, '%20');
            }
            
            document.getElementById('encode-output').value = output;
            updateEncodeStats(input, output);
            

            recordToolUsage('encode');
        }
        

        function decodeURL() {
            const input = document.getElementById('decode-input').value;
            const plusSpace = document.getElementById('decode-plus-space').checked;
            
            let output = input;
            
            if (plusSpace) {

                output = output.replace(/\+/g, ' ');
            }
            
            try {

                output = decodeURI(output);
            } catch (e) {
                try {

                    output = decodeURIComponent(output);
                } catch (e2) {

                    output = input;
                }
            }
            
            document.getElementById('decode-output').value = output;
            updateDecodeStats(input, output);
            

            recordToolUsage('decode');
        }
        

        function updateEncodeStats(input, output) {
            const inputCount = input.length;
            const outputCount = output.length;
            const ratio = inputCount > 0 ? Math.round((outputCount / inputCount) * 100) : 0;
            
            document.getElementById('encode-input-count').textContent = inputCount;
            document.getElementById('encode-output-count').textContent = outputCount;
            document.getElementById('encode-ratio').textContent = ratio + '%';
        }
        

        function updateDecodeStats(input, output) {
            const inputCount = input.length;
            const outputCount = output.length;
            const ratio = inputCount > 0 ? Math.round((outputCount / inputCount) * 100) : 0;
            
            document.getElementById('decode-input-count').textContent = inputCount;
            document.getElementById('decode-output-count').textContent = outputCount;
            document.getElementById('decode-ratio').textContent = ratio + '%';
        }
        

        function copyToClipboard(textareaId) {
            const textarea = document.getElementById(textareaId);
            textarea.select();
            textarea.setSelectionRange(0, 99999);
            document.execCommand('copy');
            

            alert('复制成功！');
        }
        

        function clearTextarea(textareaId, outputId) {
            document.getElementById(textareaId).value = '';
            document.getElementById(outputId).value = '';
            
            if (textareaId === 'encode-input') {
                updateEncodeStats('', '');
            } else {
                updateDecodeStats('', '');
            }
        }
        

        document.getElementById('encode-btn').addEventListener('click', encodeURL);
        document.getElementById('decode-btn').addEventListener('click', decodeURL);
        document.getElementById('copy-encode-btn').addEventListener('click', () => copyToClipboard('encode-output'));
        document.getElementById('copy-decode-btn').addEventListener('click', () => copyToClipboard('decode-output'));
        document.getElementById('clear-encode-btn').addEventListener('click', () => clearTextarea('encode-input', 'encode-output'));
        document.getElementById('clear-decode-btn').addEventListener('click', () => clearTextarea('decode-input', 'decode-output'));
        

        document.getElementById('encode-full-url').addEventListener('change', function() {
            if (document.getElementById('encode-input').value) {
                encodeURL();
            }
        });
        document.getElementById('encode-space-plus').addEventListener('change', function() {
            if (document.getElementById('encode-input').value) {
                encodeURL();
            }
        });
        document.getElementById('decode-plus-space').addEventListener('change', function() {
            if (document.getElementById('decode-input').value) {
                decodeURL();
            }
        });
    </script>
</body>
</html>