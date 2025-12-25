<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ULID生成器 - 工具箱</title>
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

        .option-input {
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            width: 80px;
        }


        .actions-section {
            margin-bottom: 30px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
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
        }

        .btn-secondary {
            background-color: #fafafa;
            color: #1a1a1a;
        }

        .btn-secondary:hover {
            background-color: #f0f0f0;
        }


        .results-section {
            margin-bottom: 30px;
        }

        .results-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }

        .results-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-height: 500px;
            overflow-y: auto;
        }

        .result-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }

        .result-content {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .ulid-value {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
        }

        .ulid-time {
            font-size: 12px;
            color: #666;
        }

        .result-actions {
            display: flex;
            gap: 8px;
        }

        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
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

            .options-grid {
                grid-template-columns: 1fr;
            }

            .result-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .result-actions {
                align-self: flex-end;
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
                    <h2>ULID生成器</h2>
                    <p>生成唯一且可排序的ULID标识符</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">

                    <div class="options-section">
                        <div class="options-title">生成选项</div>
                        <div class="options-grid">
                            <div class="option-item">
                                <label for="count" class="option-label">生成数量：</label>
                                <input type="number" id="count" class="option-input" value="1" min="1" max="100">
                            </div>
                            <div class="option-item">
                                <input type="checkbox" id="show-timestamp" checked>
                                <label for="show-timestamp" class="option-label">显示生成时间</label>
                            </div>
                        </div>
                    </div>
                    

                    <div class="actions-section">
                        <button class="btn btn-primary" id="generate-btn">生成ULID</button>
                        <button class="btn btn-secondary" id="copy-all-btn">复制全部</button>
                        <button class="btn btn-secondary" id="clear-all-btn">清空全部</button>
                    </div>
                    

                    <div class="results-section">
                        <div class="results-title">生成结果</div>
                        <div class="results-list" id="results-list">
    
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        class ULIDGenerator {
            constructor() {
                this.countInput = document.getElementById('count');
                this.showTimestampCheckbox = document.getElementById('show-timestamp');
                this.generateBtn = document.getElementById('generate-btn');
                this.copyAllBtn = document.getElementById('copy-all-btn');
                this.clearAllBtn = document.getElementById('clear-all-btn');
                this.resultsList = document.getElementById('results-list');
                
                this.initEventListeners();
                this.generate();
            }
            
            initEventListeners() {
                this.generateBtn.addEventListener('click', () => this.generate());
                this.copyAllBtn.addEventListener('click', () => this.copyAll());
                this.clearAllBtn.addEventListener('click', () => this.clearAll());
            }
            
            generate() {
                const count = parseInt(this.countInput.value);
                const showTimestamp = this.showTimestampCheckbox.checked;
                
                for (let i = 0; i < count; i++) {
                    const ulid = this.ulid();
                    const timestamp = new Date().toLocaleString('zh-CN');
                    this.addResult(ulid, timestamp, showTimestamp);
                }
                
                recordToolUsage('generate');
            }
            
            ulid() {
                const timestamp = Date.now();
                const random = Math.random().toString(36).substring(2, 18);
                const timestampBase32 = this.toBase32(timestamp).padStart(10, '0');
                const randomBase32 = this.toBase32(parseInt(random, 36)).padStart(16, '0');
                
                return (timestampBase32 + randomBase32).substring(0, 26);
            }
            
            toBase32(num) {
                const alphabet = '0123456789ABCDEFGHJKMNPQRSTVWXYZ';
                let result = '';
                
                while (num > 0) {
                    result = alphabet[num % 32] + result;
                    num = Math.floor(num / 32);
                }
                
                return result;
            }
            
            addResult(ulid, timestamp, showTimestamp) {
                const resultItem = document.createElement('div');
                resultItem.className = 'result-item';
                
                const resultContent = document.createElement('div');
                resultContent.className = 'result-content';
                
                const ulidValue = document.createElement('div');
                ulidValue.className = 'ulid-value';
                ulidValue.textContent = ulid;
                
                const resultActions = document.createElement('div');
                resultActions.className = 'result-actions';
                
                const copyBtn = document.createElement('button');
                copyBtn.className = 'btn btn-small btn-secondary';
                copyBtn.textContent = 'Copy';
                copyBtn.addEventListener('click', () => this.copyToClipboard(ulid));
                
                const deleteBtn = document.createElement('button');
                deleteBtn.className = 'btn btn-small btn-secondary';
                deleteBtn.textContent = 'Delete';
                deleteBtn.addEventListener('click', () => resultItem.remove());
                
                resultActions.appendChild(copyBtn);
                resultActions.appendChild(deleteBtn);
                
                resultContent.appendChild(ulidValue);
                
                if (showTimestamp) {
                    const ulidTime = document.createElement('div');
                    ulidTime.className = 'ulid-time';
                    ulidTime.textContent = timestamp;
                    resultContent.appendChild(ulidTime);
                }
                
                resultItem.appendChild(resultContent);
                resultItem.appendChild(resultActions);
                
                this.resultsList.insertBefore(resultItem, this.resultsList.firstChild);
            }
            
            async copyToClipboard(text) {
                try {
                    await navigator.clipboard.writeText(text);
                    alert('Copied to clipboard');
                    recordToolUsage('copy_single');
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
                    alert('Copied to clipboard');
                    recordToolUsage('copy_single');
                }
            }
            
            async copyAll() {
                const ulidItems = this.resultsList.querySelectorAll('.ulid-value');
                if (ulidItems.length === 0) {
                    alert('No ULIDs to copy');
                    return;
                }
                
                const ulids = Array.from(ulidItems).map(item => item.textContent);
                const textToCopy = ulids.join('\n');
                
                try {
                    await navigator.clipboard.writeText(textToCopy);
                    alert(`Copied ${ulids.length} ULIDs to clipboard`);
                    recordToolUsage('copy_all');
                } catch (err) {
                    alert('Copy failed, please copy manually');
                }
            }
            
            clearAll() {
                this.resultsList.innerHTML = '';
            }
        }
        
        function recordToolUsage(action) {
            fetch('../php/record-tool-usage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tool_id: 'ulid',
                    action: action
                })
            }).catch(error => {
                console.error('Failed to record usage:', error);
            });
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new ULIDGenerator();
        });
    </script>
</body>
</html>