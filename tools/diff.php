<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文本对比 - 工具箱</title>
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
        

        .diff-settings {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            align-items: center;
        }
        
        .setting-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .setting-label {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
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
        

        .diff-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .diff-panel {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .diff-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px 8px 0 0;
        }
        
        .diff-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .diff-actions {
            display: flex;
            gap: 8px;
        }
        
        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
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
        

        .diff-result {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        
        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        
        .result-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .result-stats {
            display: flex;
            gap: 20px;
            font-size: 14px;
            color: #666;
        }
        
        /* 差异高亮样式 */
        .diff-view {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .diff-line {
            display: flex;
            align-items: flex-start;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.5;
            padding: 4px 8px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .diff-line:last-child {
            border-bottom: none;
        }
        
        .diff-line-number {
            width: 50px;
            text-align: right;
            padding-right: 12px;
            color: #999;
            background-color: #fafafa;
            border-right: 1px solid #e0e0e0;
            margin-right: 12px;
            font-size: 12px;
        }
        
        .diff-content {
            flex: 1;
            white-space: pre-wrap;
            word-break: break-all;
        }
        

        .diff-line.equal {
            background-color: #fff;
        }
        
        .diff-line.inserted {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
        }
        
        .diff-line.deleted {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
        }
        
        .diff-line.modified {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
        }
        

        .diff-inserted {
            background-color: #d4edda;
            padding: 2px 4px;
            border-radius: 3px;
        }
        
        .diff-deleted {
            background-color: #f8d7da;
            padding: 2px 4px;
            border-radius: 3px;
            text-decoration: line-through;
        }
        

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 200px;
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
            
            .diff-settings {
                flex-direction: column;
                align-items: stretch;
            }
            
            .diff-container {
                grid-template-columns: 1fr;
            }
            
            .result-stats {
                flex-direction: column;
                gap: 8px;
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
                    <h2>文本对比</h2>
                    <p>比较两个文本的差异，高亮显示不同之处</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">

                    <div class="diff-settings">
                        <div class="setting-item">
                            <label class="setting-label">对比模式：</label>
                            <select id="diff-mode" class="btn btn-small">
                                <option value="line">行对比</option>
                                <option value="char">字符对比</option>
                            </select>
                        </div>
                        <div class="setting-item">
                            <button class="btn btn-primary" id="compare-btn">开始对比</button>
                            <button class="btn" id="clear-btn">清空内容</button>
                        </div>
                    </div>
                    

                    <div class="diff-container">

                        <div class="diff-panel">
                            <div class="diff-header">
                                <div class="diff-title">原始文本</div>
                                <div class="diff-actions">
                                    <button class="btn btn-small" id="clear-left">清空</button>
                                    <button class="btn btn-small" id="swap-btn">⇄ 交换</button>
                                </div>
                            </div>
                            <textarea class="text-input" id="text1" placeholder="请输入原始文本..."></textarea>
                        </div>
                        

                        <div class="diff-panel">
                            <div class="diff-header">
                                <div class="diff-title">目标文本</div>
                                <div class="diff-actions">
                                    <button class="btn btn-small" id="clear-right">清空</button>
                                </div>
                            </div>
                            <textarea class="text-input" id="text2" placeholder="请输入目标文本..."></textarea>
                        </div>
                    </div>
                    

                    <div class="diff-result">
                        <div class="result-header">
                            <div class="result-title">对比结果</div>
                            <div class="result-stats">
                                <div>相同：<span id="same-count">0</span> 行</div>
                                <div>新增：<span id="added-count">0</span> 行</div>
                                <div>删除：<span id="deleted-count">0</span> 行</div>
                                <div>修改：<span id="modified-count">0</span> 行</div>
                            </div>
                        </div>
                        <div class="diff-view" id="diff-view">
                            <div class="empty-state">点击"开始对比"查看差异</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>

        class TextDiff {
            constructor() {

                this.text1 = document.getElementById('text1');
                this.text2 = document.getElementById('text2');
                this.compareBtn = document.getElementById('compare-btn');
                this.clearBtn = document.getElementById('clear-btn');
                this.clearLeftBtn = document.getElementById('clear-left');
                this.clearRightBtn = document.getElementById('clear-right');
                this.swapBtn = document.getElementById('swap-btn');
                this.diffMode = document.getElementById('diff-mode');
                this.diffView = document.getElementById('diff-view');
                this.sameCount = document.getElementById('same-count');
                this.addedCount = document.getElementById('added-count');
                this.deletedCount = document.getElementById('deleted-count');
                this.modifiedCount = document.getElementById('modified-count');
                

                this.initEventListeners();
            }
            

            initEventListeners() {

                this.compareBtn.addEventListener('click', () => {
                    this.compare();
                });
                

                this.clearBtn.addEventListener('click', () => {
                    this.clear();
                });
                
                this.clearLeftBtn.addEventListener('click', () => {
                    this.text1.value = '';
                    this.compare();
                });
                
                this.clearRightBtn.addEventListener('click', () => {
                    this.text2.value = '';
                    this.compare();
                });
                

                this.swapBtn.addEventListener('click', () => {
                    const temp = this.text1.value;
                    this.text1.value = this.text2.value;
                    this.text2.value = temp;
                    this.compare();
                });
                

                this.text1.addEventListener('input', () => {
                    this.compare();
                });
                
                this.text2.addEventListener('input', () => {
                    this.compare();
                });
                

                this.diffMode.addEventListener('change', () => {
                    this.compare();
                });
            }
            
            
            clear() {
                this.text1.value = '';
                this.text2.value = '';
                this.diffView.innerHTML = '<div class="empty-state">点击"开始对比"查看差异</div>';
                this.updateStats(0, 0, 0, 0);
            }
            
            
            compare() {
                const text1 = this.text1.value;
                const text2 = this.text2.value;
                
                if (!text1 && !text2) {
                    this.diffView.innerHTML = '<div class="empty-state">请输入要对比的文本</div>';
                    this.updateStats(0, 0, 0, 0);
                    return;
                }
                

                const lines1 = text1.split('\n');
                const lines2 = text2.split('\n');
                

                const diffResult = this.diff(lines1, lines2);
                

                this.displayDiff(diffResult);
                

                recordToolUsage('compare');
            }
            
            
            diff(lines1, lines2) {
                const result = [];
                const maxLines = Math.max(lines1.length, lines2.length);
                
                let same = 0;
                let added = 0;
                let deleted = 0;
                let modified = 0;
                
                for (let i = 0; i < maxLines; i++) {
                    const line1 = lines1[i] || '';
                    const line2 = lines2[i] || '';
                    
                    if (line1 === line2) {
    
                        result.push({ type: 'equal', line1, line2, lineNum: i + 1 });
                        same++;
                    } else if (line1 && !line2) {
    
                        result.push({ type: 'deleted', line1, line2: '', lineNum: i + 1 });
                        deleted++;
                    } else if (!line1 && line2) {
    
                        result.push({ type: 'inserted', line1: '', line2, lineNum: i + 1 });
                        added++;
                    } else {
    
                        result.push({ type: 'modified', line1, line2, lineNum: i + 1 });
                        modified++;
                    }
                }
                
                this.updateStats(same, added, deleted, modified);
                return result;
            }
            
            
            updateStats(same, added, deleted, modified) {
                this.sameCount.textContent = same;
                this.addedCount.textContent = added;
                this.deletedCount.textContent = deleted;
                this.modifiedCount.textContent = modified;
            }
            
            // 显示对比结果
            displayDiff(diffResult) {
                let html = '';
                
                diffResult.forEach(item => {
                    const lineClass = `diff-line ${item.type}`;
                    const lineNum = item.lineNum;
                    
                    switch (item.type) {
                        case 'equal':
                            html += `
                                <div class="${lineClass}">
                                    <div class="diff-line-number">${lineNum}</div>
                                    <div class="diff-content">${this.escapeHtml(item.line1)}</div>
                                </div>
                            `;
                            break;
                            
                        case 'inserted':
                            html += `
                                <div class="${lineClass}">
                                    <div class="diff-line-number">+${lineNum}</div>
                                    <div class="diff-content">${this.escapeHtml(item.line2)}</div>
                                </div>
                            `;
                            break;
                            
                        case 'deleted':
                            html += `
                                <div class="${lineClass}">
                                    <div class="diff-line-number">-${lineNum}</div>
                                    <div class="diff-content">${this.escapeHtml(item.line1)}</div>
                                </div>
                            `;
                            break;
                            
                        case 'modified':
                            html += `
                                <div class="${lineClass}">
                                    <div class="diff-line-number">-${lineNum}</div>
                                    <div class="diff-content">${this.escapeHtml(item.line1)}</div>
                                </div>
                                <div class="diff-line inserted">
                                    <div class="diff-line-number">+${lineNum}</div>
                                    <div class="diff-content">${this.escapeHtml(item.line2)}</div>
                                </div>
                            `;
                            break;
                    }
                });
                
                this.diffView.innerHTML = html;
            }
            
            
            escapeHtml(text) {
                return text
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;')
                    .replace(/\s/g, (match) => {
                        if (match === ' ') return ' ';
                        if (match === '\t') return '    ';
                        return match;
                    });
            }
        }
        

        function recordToolUsage(action) {

            fetch('../php/record-tool-usage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tool_id: 'diff',
                    action: action
                })
            }).catch(error => {
                console.error('记录使用量失败:', error);
            });
        }
        

        const textDiff = new TextDiff();
    </script>
</body>
</html>