<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSON格式化 - 工具箱</title>
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
            font-family: 'Courier New', Courier, monospace;
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
        
        .btn-warning {
            background-color: #fff3cd;
            color: #856404;
            border-color: #ffeeba;
        }
        
        .btn-warning:hover {
            background-color: #ffeeba;
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
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 16px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 16px;
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
                    <h2>JSON格式化</h2>
                    <p>在线JSON格式化、压缩、验证工具</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    <div class="tool-tabs">
                        <button class="tab-btn active" data-tab="format">格式化</button>
                        <button class="tab-btn" data-tab="compress">压缩</button>
                        <button class="tab-btn" data-tab="validate">验证</button>
                    </div>
                    
                    <div class="tab-content active" id="format">
                        <div class="stats">
                            <div class="stat-item">
                                <span class="stat-label">输入字符数</span>
                                <span class="stat-value" id="format-input-count">0</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">输出字符数</span>
                                <span class="stat-value" id="format-output-count">0</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">缩进空格数</span>
                                <span class="stat-value" id="format-indent-count">4</span>
                            </div>
                        </div>
                        
                        <div class="options">
                            <div class="option-item">
                                <label for="indent-size" style="font-size: 14px; font-weight: 500;">缩进空格数：</label>
                                <input type="number" id="indent-size" name="indent-size" value="4" min="0" max="8" style="width: 60px; padding: 4px 8px; border: 1px solid #e0e0e0; border-radius: 4px;">
                            </div>
                            <div class="option-item">
                                <input type="checkbox" id="sort-keys" name="sort-keys" value="1">
                                <label for="sort-keys">排序键</label>
                            </div>
                        </div>
                        
                        <div class="input-section">
                            <label for="format-input" class="input-label">输入JSON</label>
                            <textarea class="input-textarea" id="format-input" placeholder="请输入要格式化的JSON..."></textarea>
                        </div>
                        
                        <div class="btn-group">
                            <button class="btn btn-primary" id="format-btn">格式化</button>
                            <button class="btn btn-secondary" id="clear-format-btn">清空</button>
                            <button class="btn btn-success" id="copy-format-btn">复制结果</button>
                        </div>
                        
                        <div class="output-section">
                            <label for="format-output" class="output-label">格式化结果</label>
                            <textarea class="output-box" id="format-output" readonly></textarea>
                        </div>
                    </div>
                    
                    <div class="tab-content" id="compress">
                        <div class="stats">
                            <div class="stat-item">
                                <span class="stat-label">输入字符数</span>
                                <span class="stat-value" id="compress-input-count">0</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">输出字符数</span>
                                <span class="stat-value" id="compress-output-count">0</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">压缩率</span>
                                <span class="stat-value" id="compress-ratio">0%</span>
                            </div>
                        </div>
                        
                        <div class="input-section">
                            <label for="compress-input" class="input-label">输入JSON</label>
                            <textarea class="input-textarea" id="compress-input" placeholder="请输入要压缩的JSON..."></textarea>
                        </div>
                        
                        <div class="btn-group">
                            <button class="btn btn-primary" id="compress-btn">压缩</button>
                            <button class="btn btn-secondary" id="clear-compress-btn">清空</button>
                            <button class="btn btn-success" id="copy-compress-btn">复制结果</button>
                        </div>
                        
                        <div class="output-section">
                            <label for="compress-output" class="output-label">压缩结果</label>
                            <textarea class="output-box" id="compress-output" readonly></textarea>
                        </div>
                    </div>
                    
                    <div class="tab-content" id="validate">
                        <div class="stats">
                            <div class="stat-item">
                                <span class="stat-label">字符数</span>
                                <span class="stat-value" id="validate-count">0</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">状态</span>
                                <span class="stat-value" id="validate-status">未验证</span>
                            </div>
                        </div>
                        
                        <div class="input-section">
                            <label for="validate-input" class="input-label">输入JSON</label>
                            <textarea class="input-textarea" id="validate-input" placeholder="请输入要验证的JSON..."></textarea>
                        </div>
                        
                        <div class="btn-group">
                            <button class="btn btn-primary" id="validate-btn">验证</button>
                            <button class="btn btn-secondary" id="clear-validate-btn">清空</button>
                            <button class="btn btn-warning" id="fix-json-btn">尝试修复</button>
                        </div>
                        
                        <div id="validate-result" style="margin-bottom: 24px;"></div>
                        
                        <div class="output-section">
                            <label for="validate-output" class="output-label">处理结果</label>
                            <textarea class="output-box" id="validate-output" readonly></textarea>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <div class="info-title">关于JSON格式化</div>
                        <div class="info-text">
                            JSON格式化工具可以帮助您美化、压缩和验证JSON数据，使其更易于阅读和处理。
                            <ul style="margin-top: 8px; padding-left: 20px;">
                                <li>格式化功能可以美化JSON，添加适当的缩进和换行</li>
                                <li>压缩功能可以移除所有不必要的空格和换行，减小JSON体积</li>
                                <li>验证功能可以检查JSON格式是否正确，并尝试修复简单错误</li>
                                <li>支持自定义缩进空格数和排序键功能</li>
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
                    tool_id: 'json',
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
        
        function formatJSON() {
            const input = document.getElementById('format-input').value;
            const indentSize = parseInt(document.getElementById('indent-size').value);
            const sortKeys = document.getElementById('sort-keys').checked;
            
            try {
                const parsed = JSON.parse(input);
                let output;
                if (indentSize > 0) {
                    output = JSON.stringify(parsed, sortKeys ? Object.keys(parsed).sort() : null, indentSize);
                } else {
                    output = JSON.stringify(parsed, sortKeys ? Object.keys(parsed).sort() : null);
                }
                
                document.getElementById('format-output').value = output;
                updateFormatStats(input, output, indentSize);
                
                recordToolUsage('format');
            } catch (e) {
                document.getElementById('format-output').value = `JSON格式错误: ${e.message}`;
                updateFormatStats(input, `JSON格式错误: ${e.message}`, indentSize);
                
                recordToolUsage('format_error');
            }
        }
        
        function compressJSON() {
            const input = document.getElementById('compress-input').value;
            
            try {
                const parsed = JSON.parse(input);
                const output = JSON.stringify(parsed);
                
                document.getElementById('compress-output').value = output;
                updateCompressStats(input, output);
                
                recordToolUsage('compress');
            } catch (e) {
                document.getElementById('compress-output').value = `JSON格式错误: ${e.message}`;
                updateCompressStats(input, `JSON格式错误: ${e.message}`);
                
                recordToolUsage('compress_error');
            }
        }
        
        function validateJSON() {
            const input = document.getElementById('validate-input').value;
            
            if (!input.trim()) {
                document.getElementById('validate-result').innerHTML = '<div class="error-message">请输入要验证的JSON</div>';
                document.getElementById('validate-output').value = '';
                updateValidateStats(input, '未验证');
                return;
            }
            
            try {
                const parsed = JSON.parse(input);
                document.getElementById('validate-result').innerHTML = '<div class="success-message">✓ JSON格式正确</div>';
                document.getElementById('validate-output').value = JSON.stringify(parsed, null, 4);
                updateValidateStats(input, '有效');
                
                recordToolUsage('validate_success');
            } catch (e) {
                document.getElementById('validate-result').innerHTML = `<div class="error-message">✗ JSON格式错误: ${e.message}</div>`;
                document.getElementById('validate-output').value = input;
                updateValidateStats(input, '无效');
                
                recordToolUsage('validate_error');
            }
        }
        
        function fixJSON() {
            const input = document.getElementById('validate-input').value;
            
            if (!input.trim()) {
                document.getElementById('validate-result').innerHTML = '<div class="error-message">请输入要修复的JSON</div>';
                return;
            }
            
            try {
                let fixed = input.replace(/,\s*([}\]])/g, '$1');
                fixed = fixed.replace(/'/g, '"');
                fixed = fixed.replace(/([{,])\s*([a-zA-Z0-9_]+)\s*:/g, '$1"$2":');
                
                const parsed = JSON.parse(fixed);
                document.getElementById('validate-result').innerHTML = '<div class="success-message">✓ JSON修复成功</div>';
                document.getElementById('validate-output').value = JSON.stringify(parsed, null, 4);
                updateValidateStats(input, '已修复');
                
                recordToolUsage('fix_success');
            } catch (e) {
                document.getElementById('validate-result').innerHTML = `<div class="error-message">✗ 修复失败: ${e.message}</div>`;
                
                recordToolUsage('fix_error');
            }
        }
        
        function updateFormatStats(input, output, indentSize) {
            document.getElementById('format-input-count').textContent = input.length;
            document.getElementById('format-output-count').textContent = output.length;
            document.getElementById('format-indent-count').textContent = indentSize;
        }
        
        function updateCompressStats(input, output) {
            document.getElementById('compress-input-count').textContent = input.length;
            document.getElementById('compress-output-count').textContent = output.length;
            const ratio = input.length > 0 ? Math.round(((input.length - output.length) / input.length) * 100) : 0;
            document.getElementById('compress-ratio').textContent = `${ratio}%`;
        }
        
        function updateValidateStats(input, status) {
            document.getElementById('validate-count').textContent = input.length;
            document.getElementById('validate-status').textContent = status;
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
            
            if (textareaId === 'format-input') {
                updateFormatStats('', '', document.getElementById('indent-size').value);
            } else if (textareaId === 'compress-input') {
                updateCompressStats('', '');
            } else if (textareaId === 'validate-input') {
                updateValidateStats('', '未验证');
                document.getElementById('validate-result').innerHTML = '';
            }
        }
        
        document.getElementById('format-btn').addEventListener('click', formatJSON);
        document.getElementById('compress-btn').addEventListener('click', compressJSON);
        document.getElementById('validate-btn').addEventListener('click', validateJSON);
        document.getElementById('fix-json-btn').addEventListener('click', fixJSON);
        document.getElementById('copy-format-btn').addEventListener('click', () => copyToClipboard('format-output'));
        document.getElementById('copy-compress-btn').addEventListener('click', () => copyToClipboard('compress-output'));
        document.getElementById('clear-format-btn').addEventListener('click', () => clearTextarea('format-input', 'format-output'));
        document.getElementById('clear-compress-btn').addEventListener('click', () => clearTextarea('compress-input', 'compress-output'));
        document.getElementById('clear-validate-btn').addEventListener('click', () => clearTextarea('validate-input', 'validate-output'));
        
        document.getElementById('indent-size').addEventListener('change', function() {
            if (document.getElementById('format-input').value) {
                formatJSON();
            }
        });
        document.getElementById('sort-keys').addEventListener('change', function() {
            if (document.getElementById('format-input').value) {
                formatJSON();
            }
        });
    </script>
</body>
</html>