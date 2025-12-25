<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>正则表达式工具 - 工具箱</title>
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
        
        .input-field,
        .input-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
        }
        
        .input-textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        .input-field:focus,
        .input-textarea:focus {
            outline: none;
            border-color: #ccc;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
        }
        
        .options {
            display: flex;
            gap: 20px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        
        .option-group {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .option-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .option-item label {
            font-size: 14px;
            color: #1a1a1a;
            cursor: pointer;
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
            margin-bottom: 24px;
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
            min-height: 150px;
            padding: 16px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            resize: vertical;
            white-space: pre-wrap;
            word-break: break-all;
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
        
        .highlight {
            background-color: #fff3cd;
            color: #856404;
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: bold;
        }
        
        .regex-presets {
            margin-top: 32px;
        }
        
        .presets-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .presets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 12px;
        }
        
        .preset-item {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .preset-item:hover {
            background-color: #f0f0f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .preset-name {
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .preset-regex {
            font-size: 12px;
            color: #666;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            margin-bottom: 4px;
        }
        
        .preset-desc {
            font-size: 12px;
            color: #999;
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
            
            .options {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .btn-group {
                flex-direction: column;
            }
            
            .presets-grid {
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
                    <h2>正则表达式工具</h2>
                    <p>在线正则表达式测试、替换和学习工具</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    <div class="tool-tabs">
                        <button class="tab-btn active" data-tab="match">正则匹配</button>
                        <button class="tab-btn" data-tab="replace">正则替换</button>
                    </div>
                    
                    <div class="tab-content active" id="match">
                        <div class="stats">
                            <div class="stat-item">
                                <span class="stat-label">匹配结果</span>
                                <span class="stat-value" id="match-count">0</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">执行时间</span>
                                <span class="stat-value" id="execute-time">0 ms</span>
                            </div>
                        </div>
                        
                        <div class="input-section">
                            <label for="regex-input" class="input-label">正则表达式</label>
                            <input type="text" class="input-field" id="regex-input" placeholder="请输入正则表达式，例如：\d+">
                        </div>
                        
                        <div class="input-section">
                            <label for="test-text" class="input-label">测试文本</label>
                            <textarea class="input-textarea" id="test-text" placeholder="请输入要测试的文本...">
例如：
手机号码：13800138000, 13900139000
邮箱：test@example.com, admin@test.org
网址：https://www.example.com, http://test.org
日期：2025-12-12, 2025/12/12
数字：123, 456.789, -100
                            </textarea>
                        </div>
                        
                        <div class="options">
                            <div class="option-group">
                                <div class="option-item">
                                    <input type="checkbox" id="flag-g" name="flags" value="g">
                                    <label for="flag-g">全局匹配 (g)</label>
                                </div>
                                <div class="option-item">
                                    <input type="checkbox" id="flag-i" name="flags" value="i">
                                    <label for="flag-i">忽略大小写 (i)</label>
                                </div>
                                <div class="option-item">
                                    <input type="checkbox" id="flag-m" name="flags" value="m">
                                    <label for="flag-m">多行模式 (m)</label>
                                </div>
                                <div class="option-item">
                                    <input type="checkbox" id="flag-s" name="flags" value="s">
                                    <label for="flag-s">单行模式 (s)</label>
                                </div>
                                <div class="option-item">
                                    <input type="checkbox" id="flag-u" name="flags" value="u">
                                    <label for="flag-u">Unicode模式 (u)</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="btn-group">
                            <button class="btn btn-primary" id="match-btn">执行匹配</button>
                            <button class="btn btn-secondary" id="clear-btn">清空</button>
                            <button class="btn btn-success" id="copy-result-btn">复制结果</button>
                        </div>
                        
                        <div class="output-section">
                            <label for="match-result" class="output-label">匹配结果</label>
                            <div class="output-box" id="match-result"></div>
                        </div>
                        
                        <div class="output-section">
                            <label for="highlight-result" class="output-label">高亮结果</label>
                            <div class="output-box" id="highlight-result"></div>
                        </div>
                    </div>
                    
                    <div class="tab-content" id="replace">
                        <div class="stats">
                            <div class="stat-item">
                                <span class="stat-label">替换次数</span>
                                <span class="stat-value" id="replace-count">0</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">执行时间</span>
                                <span class="stat-value" id="replace-time">0 ms</span>
                            </div>
                        </div>
                        
                        <div class="input-section">
                            <label for="regex-replace-input" class="input-label">正则表达式</label>
                            <input type="text" class="input-field" id="regex-replace-input" placeholder="请输入正则表达式，例如：(\d+)-(\d+)-(\d+)">
                        </div>
                        
                        <div class="input-section">
                            <label for="replace-text" class="input-label">替换文本</label>
                            <input type="text" class="input-field" id="replace-text" placeholder="请输入替换文本，例如：$3/$2/$1">
                        </div>
                        
                        <div class="input-section">
                            <label for="replace-test-text" class="input-label">测试文本</label>
                            <textarea class="input-textarea" id="replace-test-text" placeholder="请输入要测试的文本...">
例如：
日期：2025-12-12, 2025-12-13, 2025-12-14
手机号码：13800138000, 13900139000
邮箱：test@example.com, admin@test.org
                            </textarea>
                        </div>
                        
                        <div class="options">
                            <div class="option-group">
                                <div class="option-item">
                                    <input type="checkbox" id="replace-flag-g" name="replace-flags" value="g">
                                    <label for="replace-flag-g">全局替换 (g)</label>
                                </div>
                                <div class="option-item">
                                    <input type="checkbox" id="replace-flag-i" name="replace-flags" value="i">
                                    <label for="replace-flag-i">忽略大小写 (i)</label>
                                </div>
                                <div class="option-item">
                                    <input type="checkbox" id="replace-flag-m" name="replace-flags" value="m">
                                    <label for="replace-flag-m">多行模式 (m)</label>
                                </div>
                                <div class="option-item">
                                    <input type="checkbox" id="replace-flag-s" name="replace-flags" value="s">
                                    <label for="replace-flag-s">单行模式 (s)</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="btn-group">
                            <button class="btn btn-primary" id="replace-btn">执行替换</button>
                            <button class="btn btn-secondary" id="clear-replace-btn">清空</button>
                            <button class="btn btn-success" id="copy-replace-result-btn">复制结果</button>
                        </div>
                        
                        <div class="output-section">
                            <label for="replace-result" class="output-label">替换结果</label>
                            <div class="output-box" id="replace-result"></div>
                        </div>
                    </div>
                    
                    <div class="regex-presets">
                        <div class="presets-title">常用正则表达式</div>
                        <div class="presets-grid" id="regex-presets">
                            <!-- 预设将通过JavaScript生成 -->
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
                    tool_id: 'regex',
                    action: action
                })
            }).catch(error => {
                console.error('记录使用量失败:', error);
            });
        }
        
        
        let currentTab = 'match';
        
        
        const regexPresets = [
            {
                name: '手机号码',
                regex: '1[3-9]\\d{9}',
                desc: '匹配中国大陆手机号码'
            },
            {
                name: '邮箱地址',
                regex: '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}',
                desc: '匹配电子邮件地址'
            },
            {
                name: 'URL地址',
                regex: 'https?:\\/\\/[\\w\\-_]+(\\.[\\w\\-_]+)+([\\w\\-\\.,@?^=%&:/~\\+#]*[\\w\\-\\@?^=%&/~\\+#])?',
                desc: '匹配HTTP/HTTPS网址'
            },
            {
                name: '日期格式',
                regex: '\\d{4}[-/]\\d{1,2}[-/]\\d{1,2}',
                desc: '匹配YYYY-MM-DD或YYYY/MM/DD格式日期'
            },
            {
                name: 'IP地址',
                regex: '\\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\b',
                desc: '匹配IPv4地址'
            },
            {
                name: '数字',
                regex: '-?\\d+(\\.\\d+)?',
                desc: '匹配整数和小数'
            },
            {
                name: '中文',
                regex: '[\\u4e00-\\u9fa5]+',
                desc: '匹配中文汉字'
            },
            {
                name: '身份证号',
                regex: '[1-9]\\d{5}(18|19|20)\\d{2}(0[1-9]|1[0-2])(0[1-9]|[12]\\d|3[01])\\d{3}[\\dXx]',
                desc: '匹配18位身份证号码'
            },
            {
                name: '密码强度',
                regex: '^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[@$!%*?&])[A-Za-z\\d@$!%*?&]{8,}$',
                desc: '匹配至少8位，包含大小写字母、数字和特殊字符的密码'
            },
            {
                name: 'HTML标签',
                regex: '<[^>]+>',
                desc: '匹配HTML标签'
            }
        ];
        
        function init() {
            initRegexPresets();
            
            initEventListeners();
            
            initDefaultValues();
        }
        
        function initRegexPresets() {
            const presetsGrid = document.getElementById('regex-presets');
            regexPresets.forEach(preset => {
                const presetItem = document.createElement('div');
                presetItem.className = 'preset-item';
                presetItem.innerHTML = `
                    <div class="preset-name">${preset.name}</div>
                    <div class="preset-regex">${preset.regex}</div>
                    <div class="preset-desc">${preset.desc}</div>
                `;
                presetItem.addEventListener('click', () => {
                    if (currentTab === 'match') {
                        document.getElementById('regex-input').value = preset.regex;
                    } else {
                        document.getElementById('regex-replace-input').value = preset.regex;
                    }
                });
                presetsGrid.appendChild(presetItem);
            });
        }
        
        function initEventListeners() {
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const tabId = btn.getAttribute('data-tab');
                    switchTab(tabId);
                });
            });
            
            
            document.getElementById('match-btn').addEventListener('click', executeMatch);
            document.getElementById('clear-btn').addEventListener('click', clearMatch);
            document.getElementById('copy-result-btn').addEventListener('click', () => copyToClipboard('match-result'));
            
            
            document.getElementById('replace-btn').addEventListener('click', executeReplace);
            document.getElementById('clear-replace-btn').addEventListener('click', clearReplace);
            document.getElementById('copy-replace-result-btn').addEventListener('click', () => copyToClipboard('replace-result'));
            
            
            document.getElementById('regex-input').addEventListener('input', executeMatch);
            document.getElementById('test-text').addEventListener('input', executeMatch);
            document.querySelectorAll('input[name="flags"]').forEach(checkbox => {
                checkbox.addEventListener('change', executeMatch);
            });
            
            
            document.getElementById('regex-replace-input').addEventListener('input', executeReplace);
            document.getElementById('replace-text').addEventListener('input', executeReplace);
            document.getElementById('replace-test-text').addEventListener('input', executeReplace);
            document.querySelectorAll('input[name="replace-flags"]').forEach(checkbox => {
                checkbox.addEventListener('change', executeReplace);
            });
        }
        
        function initDefaultValues() {
            executeMatch();
        }
        
        function switchTab(tabId) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            
            document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');
            document.getElementById(tabId).classList.add('active');
            
            currentTab = tabId;
            
            
            if (tabId === 'match') {
                executeMatch();
            } else {
                executeReplace();
            }
        }
        
        function executeMatch() {
            const startTime = performance.now();
            
            const regex = document.getElementById('regex-input').value;
            const testText = document.getElementById('test-text').value;
            const flags = Array.from(document.querySelectorAll('input[name="flags"]:checked')).map(checkbox => checkbox.value).join('');
            
            let result = '';
            let highlightResult = testText;
            let matchCount = 0;
            
            if (regex) {
                try {
                    const regexObj = new RegExp(regex, flags);
                    const matches = testText.matchAll(regexObj);
                    const matchArray = Array.from(matches);
                    matchCount = matchArray.length;
                    
                    matchArray.forEach((match, index) => {
                        result += `匹配 ${index + 1}: ${match[0]}\n`;
                        if (match.length > 1) {
                            for (let i = 1; i < match.length; i++) {
                                result += `  分组 ${i}: ${match[i] || ''}\n`;
                            }
                        }
                        result += `  位置: ${match.index}-${match.index + match[0].length}\n\n`;
                    });
                    
                    if (flags.includes('g')) {
                        highlightResult = testText.replace(regexObj, '<span class="highlight">$&</span>');
                    } else {
                        highlightResult = testText.replace(regexObj, '<span class="highlight">$&</span>');
                    }
                } catch (error) {
                    result = `错误: ${error.message}`;
                }
            }
            
            const endTime = performance.now();
            const executeTime = Math.round(endTime - startTime);
            
            document.getElementById('match-count').textContent = matchCount;
                    document.getElementById('execute-time').textContent = `${executeTime} ms`;
                    
                    document.getElementById('match-result').textContent = result;
                    document.getElementById('highlight-result').innerHTML = highlightResult;
                    
                    recordToolUsage('match');
        }
        
        function executeReplace() {
            const startTime = performance.now();
            
            const regex = document.getElementById('regex-replace-input').value;
            const replaceText = document.getElementById('replace-text').value;
            const testText = document.getElementById('replace-test-text').value;
            const flags = Array.from(document.querySelectorAll('input[name="replace-flags"]:checked')).map(checkbox => checkbox.value).join('');
            
            let result = testText;
            let replaceCount = 0;
            
            if (regex) {
                try {
                    const regexObj = new RegExp(regex, flags);
                    const originalText = testText;
                    result = originalText.replace(regexObj, replaceText);
                    
                    if (flags.includes('g')) {
                        const matches = originalText.match(regexObj);
                        replaceCount = matches ? matches.length : 0;
                    } else {
                        replaceCount = originalText !== result ? 1 : 0;
                    }
                } catch (error) {
                    result = `错误: ${error.message}`;
                }
            }
            
            const endTime = performance.now();
            const executeTime = Math.round(endTime - startTime);
            
            document.getElementById('replace-count').textContent = replaceCount;
                    document.getElementById('replace-time').textContent = `${executeTime} ms`;
                    
                    document.getElementById('replace-result').textContent = result;
                    
                    recordToolUsage('replace');
        }
        
        function clearMatch() {
            document.getElementById('regex-input').value = '';
            document.getElementById('test-text').value = '';
            document.querySelectorAll('input[name="flags"]').forEach(checkbox => checkbox.checked = false);
            executeMatch();
        }
        
        function clearReplace() {
            document.getElementById('regex-replace-input').value = '';
            document.getElementById('replace-text').value = '';
            document.getElementById('replace-test-text').value = '';
            document.querySelectorAll('input[name="replace-flags"]').forEach(checkbox => checkbox.checked = false);
            executeReplace();
        }
        
        function copyToClipboard(elementId) {
            const element = document.getElementById(elementId);
            let text;
            
            if (element.tagName === 'DIV') {
                text = element.textContent;
            } else {
                text = element.value;
            }
            
            navigator.clipboard.writeText(text).then(() => {
                alert('复制成功！');
            }).catch(err => {
                console.error('复制失败:', err);
                alert('复制失败，请手动复制');
            });
        }
        
        window.addEventListener('load', init);
    </script>
</body>
</html>