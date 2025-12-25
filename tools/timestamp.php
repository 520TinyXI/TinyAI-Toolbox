<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>时间戳转换 - 工具箱</title>
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
        
        .input-textarea,
        .input-field {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
        }
        
        .input-textarea {
            min-height: 120px;
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
            min-height: 120px;
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
        
        .datetime-inputs {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }
        
        .datetime-inputs input {
            flex: 1;
            min-width: 150px;
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
            
            .datetime-inputs {
                flex-direction: column;
            }
            
            .datetime-inputs input {
                width: 100%;
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
                    <h2>时间戳转换</h2>
                    <p>在线时间戳与日期时间转换工具</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    <div class="tool-tabs">
                        <button class="tab-btn active" data-tab="timestamp-to-date">时间戳转日期</button>
                        <button class="tab-btn" data-tab="date-to-timestamp">日期转时间戳</button>
                    </div>
                    
                    <div class="tab-content active" id="timestamp-to-date">
                        <div class="stats">
                            <div class="stat-item">
                                <span class="stat-label">输入时间戳</span>
                                <span class="stat-value" id="ts-input-value">0</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">时间格式</span>
                                <span class="stat-value" id="ts-format">秒</span>
                            </div>
                        </div>
                        
                        <div class="options">
                            <div class="option-item">
                                <input type="radio" id="ts-seconds" name="ts-format" value="seconds" checked>
                                <label for="ts-seconds">秒级时间戳</label>
                            </div>
                            <div class="option-item">
                                <input type="radio" id="ts-milliseconds" name="ts-format" value="milliseconds">
                                <label for="ts-milliseconds">毫秒级时间戳</label>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" id="ts-current" name="ts-current" value="1">
                                <label for="ts-current">使用当前时间戳</label>
                            </div>
                        </div>
                        
                        <div class="input-section">
                            <label for="ts-input" class="input-label">输入时间戳</label>
                            <textarea class="input-textarea" id="ts-input" placeholder="请输入时间戳，支持多行..."></textarea>
                        </div>
                        
                        <div class="btn-group">
                            <button class="btn btn-primary" id="ts-to-date-btn">转换</button>
                            <button class="btn btn-secondary" id="clear-ts-btn">清空</button>
                            <button class="btn btn-success" id="copy-ts-btn">复制结果</button>
                        </div>
                        
                        <div class="output-section">
                            <label for="ts-output" class="output-label">转换结果</label>
                            <textarea class="output-box" id="ts-output" readonly></textarea>
                        </div>
                    </div>
                    
                    <div class="tab-content" id="date-to-timestamp">
                        <div class="stats">
                            <div class="stat-item">
                                <span class="stat-label">状态</span>
                                <span class="stat-value" id="date-status">未转换</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">格式</span>
                                <span class="stat-value" id="date-format">YYYY-MM-DD HH:MM:SS</span>
                            </div>
                        </div>
                        
                        <div class="options">
                            <div class="option-item">
                                <input type="checkbox" id="date-current" name="date-current" value="1">
                                <label for="date-current">使用当前时间</label>
                            </div>
                        </div>
                        
                        <div class="input-section">
                            <label class="input-label">输入日期时间</label>
                            <div class="datetime-inputs">
                                <input type="date" id="date-input" class="input-field" value="<?php echo date('Y-m-d'); ?>">
                                <input type="time" id="time-input" class="input-field" value="<?php echo date('H:i:s'); ?>">
                            </div>
                            <textarea class="input-textarea" id="date-text-input" placeholder="或直接输入日期时间文本，支持多行..."></textarea>
                        </div>
                        
                        <div class="btn-group">
                            <button class="btn btn-primary" id="date-to-ts-btn">转换</button>
                            <button class="btn btn-secondary" id="clear-date-btn">清空</button>
                            <button class="btn btn-success" id="copy-date-btn">复制结果</button>
                        </div>
                        
                        <div class="output-section">
                            <label for="date-output" class="output-label">转换结果</label>
                            <textarea class="output-box" id="date-output" readonly></textarea>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <div class="info-title">关于时间戳</div>
                        <div class="info-text">
                            时间戳是指格林威治时间1970年01月01日00时00分00秒(北京时间1970年01月01日08时00分00秒)起至现在的总秒数。
                            <ul style="margin-top: 8px; padding-left: 20px;">
                                <li>秒级时间戳：10位数字，例如：1640995200</li>
                                <li>毫秒级时间戳：13位数字，例如：1640995200000</li>
                                <li>时间戳转换工具支持多种格式的时间戳转换</li>
                                <li>支持批量转换，每行一个时间戳</li>
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
                    tool_id: 'timestamp',
                    action: action
                })
            }).catch(error => {
                console.error('Failed to record usage:', error);
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
        
        function getCurrentTimestamp() {
            return Date.now();
        }
        
        function timestampToDate() {
            const input = document.getElementById('ts-input').value;
            const isSeconds = document.getElementById('ts-seconds').checked;
            const useCurrent = document.getElementById('ts-current').checked;
            
            let timestamps;
            if (useCurrent) {
                timestamps = [getCurrentTimestamp().toString()];
            } else if (!input.trim()) {
                document.getElementById('ts-output').value = 'Please enter a timestamp or check use current timestamp';
                return;
            } else {
                timestamps = input.split('\n').filter(ts => ts.trim() !== '');
            }
            
            let results = '';
            timestamps.forEach(ts => {
                try {
                    let timestamp = parseInt(ts.trim());
                    
                    let format = isSeconds ? 'seconds' : 'milliseconds';
                    if (timestamp.toString().length === 10) {
                        format = 'seconds';
                        timestamp *= 1000;
                    } else if (timestamp.toString().length === 13) {
                        format = 'milliseconds';
                    }
                    
                    const date = new Date(timestamp);
                    const formattedDate = formatDate(date);
                    results += `${ts.trim()} (${format}) → ${formattedDate}\n`;
                } catch (e) {
                    results += `${ts.trim()} → Invalid timestamp\n`;
                }
            });
            
            document.getElementById('ts-output').value = results.trim();
            document.getElementById('ts-input-value').textContent = timestamps.length > 1 ? `${timestamps.length} items` : timestamps[0];
            document.getElementById('ts-format').textContent = isSeconds ? 'Seconds' : 'Milliseconds';
            
            recordToolUsage('ts_to_date');
        }
        
        function dateToTimestamp() {
            const useCurrent = document.getElementById('date-current').checked;
            const dateInput = document.getElementById('date-input').value;
            const timeInput = document.getElementById('time-input').value;
            const textInput = document.getElementById('date-text-input').value;
            
            let dates;
            if (useCurrent) {
                dates = [new Date()];
            } else if (textInput.trim()) {
                dates = textInput.split('\n').filter(dateStr => dateStr.trim() !== '');
            } else if (dateInput && timeInput) {
                dates = [new Date(`${dateInput} ${timeInput}`)];
            } else {
                document.getElementById('date-output').value = 'Please enter date time or check use current date';
                return;
            }
            
            let results = '';
            dates.forEach(dateItem => {
                try {
                    let date;
                    if (dateItem instanceof Date) {
                        date = dateItem;
                    } else {
                        date = new Date(dateItem.trim());
                    }
                    
                    if (isNaN(date.getTime())) {
                        throw new Error('Invalid date');
                    }
                    
                    const seconds = Math.floor(date.getTime() / 1000);
                    const milliseconds = date.getTime();
                    results += `${formatDate(date)} → seconds: ${seconds}, milliseconds: ${milliseconds}\n`;
                } catch (e) {
                    results += `${dateItem} → Invalid date\n`;
                }
            });
            
            document.getElementById('date-output').value = results.trim();
            document.getElementById('date-status').textContent = 'Converted';
            
            recordToolUsage('date_to_ts');
        }
        
        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');
            const milliseconds = String(date.getMilliseconds()).padStart(3, '0');
            
            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}.${milliseconds}`;
        }
        
        function copyToClipboard(textareaId) {
            const textarea = document.getElementById(textareaId);
            textarea.select();
            textarea.setSelectionRange(0, 99999);
            document.execCommand('copy');
            
            alert('Copied successfully!');
        }
        
        function clearTextarea(tabId) {
            if (tabId === 'timestamp-to-date') {
                document.getElementById('ts-input').value = '';
                document.getElementById('ts-output').value = '';
                document.getElementById('ts-input-value').textContent = '0';
                document.getElementById('ts-current').checked = false;
            } else {
                document.getElementById('date-input').value = new Date().toISOString().split('T')[0];
                document.getElementById('time-input').value = new Date().toTimeString().split(' ')[0];
                document.getElementById('date-text-input').value = '';
                document.getElementById('date-output').value = '';
                document.getElementById('date-status').textContent = 'Not converted';
                document.getElementById('date-current').checked = false;
            }
        }
        
        function useCurrentTimestamp() {
            const isChecked = document.getElementById('ts-current').checked;
            if (isChecked) {
                document.getElementById('ts-input').disabled = true;
                document.getElementById('ts-input').placeholder = 'Using current timestamp';
                timestampToDate();
            } else {
                document.getElementById('ts-input').disabled = false;
                document.getElementById('ts-input').placeholder = 'Please enter timestamp, support multiple lines...';
            }
        }
        
        function useCurrentDate() {
            const isChecked = document.getElementById('date-current').checked;
            if (isChecked) {
                document.getElementById('date-input').disabled = true;
                document.getElementById('time-input').disabled = true;
                document.getElementById('date-text-input').disabled = true;
                dateToTimestamp();
            } else {
                document.getElementById('date-input').disabled = false;
                document.getElementById('time-input').disabled = false;
                document.getElementById('date-text-input').disabled = false;
            }
        }
        
        document.getElementById('ts-to-date-btn').addEventListener('click', timestampToDate);
        document.getElementById('date-to-ts-btn').addEventListener('click', dateToTimestamp);
        document.getElementById('copy-ts-btn').addEventListener('click', () => copyToClipboard('ts-output'));
        document.getElementById('copy-date-btn').addEventListener('click', () => copyToClipboard('date-output'));
        document.getElementById('clear-ts-btn').addEventListener('click', () => clearTextarea('timestamp-to-date'));
        document.getElementById('clear-date-btn').addEventListener('click', () => clearTextarea('date-to-timestamp'));
        document.getElementById('ts-current').addEventListener('change', useCurrentTimestamp);
        document.getElementById('date-current').addEventListener('change', useCurrentDate);
        document.querySelectorAll('input[name="ts-format"]').forEach(radio => {
            radio.addEventListener('change', () => {
                if (document.getElementById('ts-input').value) {
                    timestampToDate();
                }
            });
        });
        
        document.getElementById('ts-input').addEventListener('input', timestampToDate);
        document.getElementById('date-input').addEventListener('change', dateToTimestamp);
        document.getElementById('time-input').addEventListener('change', dateToTimestamp);
        document.getElementById('date-text-input').addEventListener('input', dateToTimestamp);
    </script>
</body>
</html>