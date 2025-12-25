<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>密码生成 - 工具箱</title>
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
        
        .password-options {
            margin-bottom: 30px;
        }
        
        .password-options label {
            display: block;
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 12px;
        }
        
        .option-section {
            margin-bottom: 24px;
        }
        
        .option-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #666;
            margin-bottom: 8px;
        }
        
        .option-row {
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .length-control {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .length-slider {
            flex: 1;
            min-width: 200px;
        }
        
        .length-value {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            min-width: 40px;
            text-align: center;
        }
        
        .char-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
        }
        
        .char-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .password-result {
            margin-bottom: 30px;
        }
        
        .result-box {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .result-input {
            flex: 1;
            min-width: 300px;
            padding: 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            background-color: #fafafa;
        }
        
        .result-input:focus {
            outline: none;
            border-color: #1a1a1a;
            background-color: #fff;
        }
        
        .strength-indicator {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 8px;
        }
        
        .strength-label {
            font-size: 14px;
            font-weight: 500;
            color: #666;
        }
        
        .strength-bars {
            display: flex;
            gap: 8px;
            flex: 1;
        }
        
        .strength-bar {
            flex: 1;
            height: 8px;
            border-radius: 4px;
            background-color: #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .strength-bar.weak {
            background-color: #dc3545;
        }
        
        .strength-bar.medium {
            background-color: #ffc107;
        }
        
        .strength-bar.strong {
            background-color: #28a745;
        }
        
        .password-history {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e0e0e0;
        }
        
        .history-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .history-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 12px;
        }
        
        .history-item {
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            background-color: #fafafa;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .history-item:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
        }
        
        .btn {
            padding: 12px 24px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
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
        
        .batch-options {
            display: flex;
            gap: 16px;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .batch-count {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .batch-count input {
            width: 60px;
            padding: 8px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
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
            
            .result-box {
                flex-direction: column;
                align-items: stretch;
            }
            
            .result-input {
                min-width: auto;
            }
            
            .char-options {
                grid-template-columns: 1fr;
            }
            
            .option-row {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- 左侧菜单栏 -->
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

        <!-- 主内容区 -->
        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h2>密码生成</h2>
                    <p>生成高强度随机密码，支持自定义长度和字符类型</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    <!-- 密码生成选项 -->
                    <div class="password-options">
                        <label>密码生成选项：</label>
                        
                        <!-- 密码长度 -->
                        <div class="option-section">
                            <div class="option-label">密码长度</div>
                            <div class="length-control">
                                <input type="range" class="length-slider" id="password-length" min="4" max="64" value="16">
                                <span class="length-value" id="length-value">16</span>
                            </div>
                        </div>
                        
                        <!-- 字符类型 -->
                        <div class="option-section">
                            <div class="option-label">字符类型</div>
                            <div class="char-options">
                                <div class="char-option">
                                    <input type="checkbox" id="include-lowercase" checked>
                                    <label for="include-lowercase">小写字母 (a-z)</label>
                                </div>
                                <div class="char-option">
                                    <input type="checkbox" id="include-uppercase" checked>
                                    <label for="include-uppercase">大写字母 (A-Z)</label>
                                </div>
                                <div class="char-option">
                                    <input type="checkbox" id="include-numbers" checked>
                                    <label for="include-numbers">数字 (0-9)</label>
                                </div>
                                <div class="char-option">
                                    <input type="checkbox" id="include-symbols" checked>
                                    <label for="include-symbols">特殊字符 (!@#$%^&*)</label>
                                </div>
                                <div class="char-option">
                                    <input type="checkbox" id="exclude-similar" checked>
                                    <label for="exclude-similar">排除相似字符 (i, l, 1, 0, O)</label>
                                </div>
                                <div class="char-option">
                                    <input type="checkbox" id="exclude-ambiguous" checked>
                                    <label for="exclude-ambiguous">排除容易混淆的字符</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 批量生成选项 -->
                        <div class="batch-options">
                            <div class="batch-count">
                                <label for="batch-count">生成数量：</label>
                                <input type="number" id="batch-count" min="1" max="20" value="1">
                            </div>
                            <button class="btn btn-primary" id="generate-btn">生成密码</button>
                        </div>
                    </div>
                    
                    <!-- 密码结果 -->
                    <div class="password-result">
                        <div class="result-box">
                            <input type="text" class="result-input" id="password-result" readonly>
                            <button class="btn btn-primary" id="copy-btn">复制密码</button>
                            <button class="btn btn-secondary" id="regenerate-btn">重新生成</button>
                        </div>
                        
                        <!-- 密码强度 -->
                        <div class="strength-indicator">
                            <span class="strength-label">密码强度：</span>
                            <div class="strength-bars">
                                <div class="strength-bar" id="bar1"></div>
                                <div class="strength-bar" id="bar2"></div>
                                <div class="strength-bar" id="bar3"></div>
                                <div class="strength-bar" id="bar4"></div>
                            </div>
                            <span class="strength-text" id="strength-text">强</span>
                        </div>
                    </div>
                    
                    <!-- 批量生成结果 -->
                    <div id="batch-results" style="margin-top: 20px;"></div>
                    
                    <!-- 密码历史记录 -->
                    <div class="password-history">
                        <div class="history-title">最近生成的密码</div>
                        <div class="history-list" id="password-history"></div>
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
                    tool_id: 'password',
                    action: action
                })
            }).catch(error => {
                console.error('记录使用量失败:', error);
            });
        }
        
        const passwordLength = document.getElementById('password-length');
        const lengthValue = document.getElementById('length-value');
        const includeLowercase = document.getElementById('include-lowercase');
        const includeUppercase = document.getElementById('include-uppercase');
        const includeNumbers = document.getElementById('include-numbers');
        const includeSymbols = document.getElementById('include-symbols');
        const excludeSimilar = document.getElementById('exclude-similar');
        const excludeAmbiguous = document.getElementById('exclude-ambiguous');
        const batchCount = document.getElementById('batch-count');
        const generateBtn = document.getElementById('generate-btn');
        const regenerateBtn = document.getElementById('regenerate-btn');
        const copyBtn = document.getElementById('copy-btn');
        const passwordResult = document.getElementById('password-result');
        const strengthText = document.getElementById('strength-text');
        const strengthBars = [
            document.getElementById('bar1'),
            document.getElementById('bar2'),
            document.getElementById('bar3'),
            document.getElementById('bar4')
        ];
        const batchResults = document.getElementById('batch-results');
        const passwordHistory = document.getElementById('password-history');
        
        const charSets = {
            lowercase: 'abcdefghijklmnopqrstuvwxyz',
            uppercase: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            numbers: '0123456789',
            symbols: '!@#$%^&*()-_=+[]{}|;:,.<>?/`~'
        };
        
        const similarChars = 'il10O';
        
        const ambiguousChars = '{}[]()/\\\'"`~,;<>';
        
        function init() {
            passwordLength.addEventListener('input', updateLength);
            generateBtn.addEventListener('click', generatePassword);
            regenerateBtn.addEventListener('click', generatePassword);
            copyBtn.addEventListener('click', copyPassword);
            
            document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', generatePassword);
            });
            
            batchCount.addEventListener('input', updateBatchCount);
            
            updateLength();
            generatePassword();
            loadHistory();
        }
        
        function updateLength() {
            lengthValue.textContent = passwordLength.value;
        }
        
        function updateBatchCount() {
            if (batchCount.value < 1) batchCount.value = 1;
            if (batchCount.value > 20) batchCount.value = 20;
        }
        
        function generatePassword() {
            const length = parseInt(passwordLength.value);
            const count = parseInt(batchCount.value);
            const passwords = [];
            
            for (let i = 0; i < count; i++) {
                let password = '';
                const availableChars = getAvailableChars();
                
                if (availableChars === '') {
                    alert('请至少选择一种字符类型！');
                    return;
                }
                
                for (let j = 0; j < length; j++) {
                    const randomIndex = Math.floor(Math.random() * availableChars.length);
                    password += availableChars[randomIndex];
                }
                
                passwords.push(password);
            }
            
            passwordResult.value = passwords[0];
            updateStrength(passwords[0]);
            
            if (count > 1) {
                showBatchResults(passwords);
            } else {
                batchResults.innerHTML = '';
            }
            
            addToHistory(passwords[0]);
            
            recordToolUsage('generate');
        }
        
        function getAvailableChars() {
            let chars = '';
            
            if (includeLowercase.checked) chars += charSets.lowercase;
            if (includeUppercase.checked) chars += charSets.uppercase;
            if (includeNumbers.checked) chars += charSets.numbers;
            if (includeSymbols.checked) chars += charSets.symbols;
            
            if (excludeSimilar.checked) {
                chars = chars.split('').filter(char => !similarChars.includes(char)).join('');
            }
            
            if (excludeAmbiguous.checked) {
                chars = chars.split('').filter(char => !ambiguousChars.includes(char)).join('');
            }
            
            return chars;
        }
        
        function updateStrength(password) {
            const strength = calculateStrength(password);
            const strengthText = document.getElementById('strength-text');
            const bars = document.querySelectorAll('.strength-bar');
            
            bars.forEach(bar => bar.className = 'strength-bar');
            
            let strengthLevel = '弱';
            let strengthClass = 'weak';
            
            if (strength >= 0.75) {
                strengthLevel = '强';
                strengthClass = 'strong';
                bars[0].classList.add(strengthClass);
                bars[1].classList.add(strengthClass);
                bars[2].classList.add(strengthClass);
                bars[3].classList.add(strengthClass);
            } else if (strength >= 0.5) {
                strengthLevel = '中';
                strengthClass = 'medium';
                bars[0].classList.add(strengthClass);
                bars[1].classList.add(strengthClass);
                bars[2].classList.add(strengthClass);
            } else if (strength >= 0.25) {
                strengthLevel = '弱';
                strengthClass = 'weak';
                bars[0].classList.add(strengthClass);
                bars[1].classList.add(strengthClass);
            } else {
                strengthLevel = '极弱';
                strengthClass = 'weak';
                bars[0].classList.add(strengthClass);
            }
            
            document.getElementById('strength-text').textContent = strengthLevel;
        }
        
        function calculateStrength(password) {
            let score = 0;
            const length = password.length;
            
            if (length >= 12) score += 0.25;
            else if (length >= 8) score += 0.15;
            else if (length >= 6) score += 0.1;
            
            if (/[a-z]/.test(password)) score += 0.15;
            
            if (/[A-Z]/.test(password)) score += 0.15;
            
            if (/[0-9]/.test(password)) score += 0.15;
            
            if (/[^a-zA-Z0-9]/.test(password)) score += 0.2;
            
            let charTypes = 0;
            if (/[a-z]/.test(password)) charTypes++;
            if (/[A-Z]/.test(password)) charTypes++;
            if (/[0-9]/.test(password)) charTypes++;
            if (/[^a-zA-Z0-9]/.test(password)) charTypes++;
            
            score += charTypes * 0.05;
            
            return Math.min(1, score);
        }
        
        function copyPassword() {
            const password = passwordResult.value;
            navigator.clipboard.writeText(password).then(() => {
                alert('密码已复制到剪贴板！');
                recordToolUsage('copy');
            }).catch(err => {
                console.error('复制失败:', err);
                alert('复制失败，请手动复制');
            });
        }
        
        function showBatchResults(passwords) {
            let html = '<h4 style="margin-bottom: 12px;">批量生成结果：</h4>';
            html += '<div style="display: grid; gap: 12px;">';
            
            passwords.forEach((password, index) => {
                html += `
                    <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                        <span style="font-family: monospace; background: #fafafa; padding: 8px; border-radius: 4px; border: 1px solid #e0e0e0; flex: 1;">${password}</span>
                        <button class="btn btn-secondary" onclick="copySinglePassword('${password}')" style="padding: 6px 12px; font-size: 12px;">复制</button>
                    </div>
                `;
            });
            
            html += '</div>';
            batchResults.innerHTML = html;
        }
        
        function copySinglePassword(password) {
            navigator.clipboard.writeText(password).then(() => {
                alert('密码已复制到剪贴板！');
                recordToolUsage('copy');
            }).catch(err => {
                console.error('复制失败:', err);
                alert('复制失败，请手动复制');
            });
        }
        
        function addToHistory(password) {
            let history = JSON.parse(localStorage.getItem('passwordHistory') || '[]');
            
            history = history.filter(p => p !== password);
            
            history.unshift(password);
            
            if (history.length > 10) {
                history = history.slice(0, 10);
            }
            
            localStorage.setItem('passwordHistory', JSON.stringify(history));
            updateHistoryDisplay();
        }
        
        function loadHistory() {
            updateHistoryDisplay();
        }
        
        function updateHistoryDisplay() {
            let history = JSON.parse(localStorage.getItem('passwordHistory') || '[]');
            let html = '';
            
            history.forEach(password => {
                html += `
                    <div class="history-item" onclick="copySinglePassword('${password}')">
                        ${password}
                    </div>
                `;
            });
            
            document.getElementById('password-history').innerHTML = html;
        }
        
        document.addEventListener('DOMContentLoaded', init);
    </script>
</body>
</html>