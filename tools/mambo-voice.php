<?php
require_once '../php/framework.php';

$toolbox = new ToolboxFramework();

$siteConfig = $toolbox->getSiteConfig();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>曼波配音生成 - <?php echo $siteConfig['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .tool-content {
            background-color: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }
        
        .input-section {
            background-color: #fafafa;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid #e0e0e0;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #666;
            margin-bottom: 8px;
        }
        
        .form-textarea {
            width: 100%;
            padding: 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-family: Arial, sans-serif;
            resize: vertical;
            min-height: 150px;
            line-height: 1.6;
        }
        
        .form-textarea:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 2px rgba(26, 26, 26, 0.1);
        }
        
        .options-row {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .option-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-select {
            padding: 10px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            min-width: 120px;
        }
        
        .form-select:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 2px rgba(26, 26, 26, 0.1);
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #1a1a1a;
            color: #fff;
            min-width: 120px;
        }
        
        .btn:hover {
            background-color: #333;
        }
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .stats-info {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding: 16px;
            background-color: #f0fdf4;
            border-radius: 8px;
            border: 1px solid #bbf7d0;
        }
        
        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #059669;
        }
        
        .result-section {
            margin-top: 24px;
            display: none;
        }
        
        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            font-size: 18px;
            color: #666;
        }
        
        .loading::before {
            content: '';
            display: inline-block;
            width: 24px;
            height: 24px;
            margin-right: 12px;
            border: 3px solid rgba(26, 26, 26, 0.1);
            border-radius: 50%;
            border-top-color: #1a1a1a;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .error-message {
            background-color: #fee2e2;
            color: #ef4444;
            padding: 16px;
            border-radius: 8px;
            margin: 24px 0;
            text-align: center;
        }
        
        .audio-result {
            background-color: #fafafa;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid #e0e0e0;
        }
        
        .result-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .audio-player {
            width: 100%;
            margin-bottom: 16px;
        }
        
        .result-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 16px;
        }
        
        .info-item {
            background-color: #fff;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        
        .info-label {
            font-size: 12px;
            font-weight: 500;
            color: #666;
            margin-bottom: 4px;
        }
        
        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .btn-secondary {
            background-color: #fff;
            color: #333;
            border: 1px solid #e0e0e0;
        }
        
        .btn-secondary:hover {
            background-color: #f9fafb;
            border-color: #d1d5db;
        }
        
        .history-section {
            background-color: #fafafa;
            border-radius: 12px;
            padding: 24px;
            margin-top: 24px;
            border: 1px solid #e0e0e0;
        }
        
        .history-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .history-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .history-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .history-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .history-text {
            flex: 1;
            font-size: 14px;
            color: #333;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .history-audio {
            min-width: 100px;
        }
        
        .history-delete {
            background: none;
            border: none;
            color: #ef4444;
            cursor: pointer;
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .history-delete:hover {
            background-color: #fee2e2;
        }
        
        @media (max-width: 768px) {
            .options-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .stats-info {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .result-info {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .history-item {
                flex-direction: column;
                align-items: stretch;
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
                    <h2>曼波配音生成</h2>
                    <p>通过文字生成曼波语音，支持MP3格式</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">
                    <div class="input-section">
                        <form id="voice-form">
                            <div class="form-group">
                                <label for="text" class="form-label">输入文本（支持中文、英文等多种语言）</label>
                                <textarea id="text" name="text" class="form-textarea" placeholder="请输入要转换为语音的文本，例如：不管了，直接加钠" required></textarea>
                            </div>
                            
                            <div class="stats-info">
                                <div class="stat-item">
                                    <span>📝</span>
                                    <span id="char-count">0</span> 字符
                                </div>
                                <div class="stat-item">
                                    <span>⏱️</span>
                                    预计生成时间：<span id="estimated-time">3-5秒</span>
                                </div>
                            </div>
                            
                            <div class="options-row">
                                <div class="option-group">
                                    <label for="format" class="form-label">输出格式</label>
                                    <select id="format" name="format" class="form-select">
                                        <option value="mp3">MP3</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn" id="generate-btn">
                                    生成配音
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="result-section" id="result-section">
                        <div class="loading" id="loading" style="display: none;">
                            正在生成配音...
                        </div>
                        
                        <div class="error-message" id="error-message" style="display: none;"></div>
                        
                        <div class="audio-result" id="audio-result" style="display: none;">
                            <h3 class="result-title">生成结果</h3>
                            <audio id="audio-player" class="audio-player" controls>
                                您的浏览器不支持音频播放
                            </audio>
                            
                            <div class="result-info">
                                <div class="info-item">
                                    <div class="info-label">生成时间</div>
                                    <div class="info-value" id="generate-time"></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">音频格式</div>
                                    <div class="info-value" id="audio-format"></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">音频大小</div>
                                    <div class="info-value" id="audio-size">获取中...</div>
                                </div>
                            </div>
                            
                            <div class="action-buttons">
                                <a id="download-link" class="btn btn-secondary" href="#" download>
                                    下载音频
                                </a>
                                <button id="regenerate-btn" class="btn btn-secondary">
                                    重新生成
                                </button>
                                <button id="copy-link-btn" class="btn btn-secondary">
                                    复制链接
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="history-section">
                        <h3 class="history-title">历史记录</h3>
                        <div class="history-list" id="history-list"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        async function recordToolUsage(toolId, action, statusValue, responseTime = 0, content = '') {
            try {
                const status = statusValue === 1 ? 'success' : 'error';
                
                const responseTimeSeconds = responseTime / 1000;
                
                const contentObj = {
                    action: action
                };
                
                await fetch('../php/record-tool-usage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        tool_id: toolId,
                        content: contentObj,
                        status: status,
                        response_time: responseTimeSeconds
                    })
                });
            } catch (error) {
                console.error('记录工具使用情况失败:', error);
            }
        }
        
        class MamboVoiceGenerator {
            constructor() {
                this.voiceForm = document.getElementById('voice-form');
                this.textArea = document.getElementById('text');
                this.formatSelect = document.getElementById('format');
                this.generateBtn = document.getElementById('generate-btn');
                this.charCount = document.getElementById('char-count');
                this.resultSection = document.getElementById('result-section');
                this.loading = document.getElementById('loading');
                this.errorMessage = document.getElementById('error-message');
                this.audioResult = document.getElementById('audio-result');
                this.audioPlayer = document.getElementById('audio-player');
                this.generateTime = document.getElementById('generate-time');
                this.audioFormat = document.getElementById('audio-format');
                this.audioSize = document.getElementById('audio-size');
                this.downloadLink = document.getElementById('download-link');
                this.regenerateBtn = document.getElementById('regenerate-btn');
                this.copyLinkBtn = document.getElementById('copy-link-btn');
                this.historyList = document.getElementById('history-list');
                
                this.apiUrl = '../php/mambo-voice-proxy.php';
                
                this.isGenerating = false;
                this.currentAudioUrl = '';
                this.history = this.loadHistory();
                
                this.init();
            }
            
            init() {
                this.initEventListeners();
                
                this.renderHistory();
            }
            
            initEventListeners() {
                this.textArea.addEventListener('input', () => this.updateCharCount());
                
                this.voiceForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.generateVoice();
                });
                
                this.regenerateBtn.addEventListener('click', () => {
                    this.generateVoice();
                });
                
                this.copyLinkBtn.addEventListener('click', () => {
                    this.copyLink();
                });
            }
            
            updateCharCount() {
                const text = this.textArea.value;
                this.charCount.textContent = text.length;
            }
            
            async generateVoice() {
                const text = this.textArea.value.trim();
                const format = this.formatSelect.value;
                
                if (!text) {
                    alert('请输入要转换为语音的文本');
                    return;
                }
                
                this.showLoading();
                
                const startTime = Date.now();
                
                try {
                    const params = new URLSearchParams();
                    params.append('text', text);
                    params.append('format', format);
                    
                    const requestUrl = `${this.apiUrl}?${params.toString()}`;
                    
                    const response = await fetch(requestUrl);
                    const data = await response.json();
                    
                    const responseTime = Date.now() - startTime;
                    
                    if (data.code === 200) {
                        this.showResult(data);
                        
                        this.saveToHistory(text, data.url, format);
                        
                        await recordToolUsage('mambo-voice', 'generateVoice', 1, responseTime, text);
                    } else {
                        await recordToolUsage('mambo-voice', 'generateVoice', 0, responseTime, text);
                        throw new Error(data.msg || '生成失败');
                    }
                } catch (error) {
                    console.error('生成配音失败:', error);
                    this.showError(`生成配音失败: ${error.message}`);
                    
                    const responseTime = Date.now() - startTime;
                    await recordToolUsage('mambo-voice', 'generateVoice', 0, responseTime, text);
                }
            }
            
            showLoading() {
                this.resultSection.style.display = 'block';
                this.loading.style.display = 'flex';
                this.errorMessage.style.display = 'none';
                this.audioResult.style.display = 'none';
                this.generateBtn.disabled = true;
                this.isGenerating = true;
            }
            
            showResult(data) {
                this.loading.style.display = 'none';
                this.errorMessage.style.display = 'none';
                this.audioResult.style.display = 'block';
                this.generateBtn.disabled = false;
                this.isGenerating = false;
                
                this.currentAudioUrl = data.url;
                
                this.audioPlayer.src = data.url;
                
                const now = new Date();
                this.generateTime.textContent = now.toLocaleString('zh-CN');
                
                this.audioFormat.textContent = this.formatSelect.value.toUpperCase();
                
                this.getAudioSize(data.url);
                
                this.downloadLink.href = data.url;
                this.downloadLink.download = `mambo-voice-${Date.now()}.${this.formatSelect.value}`;
            }
            
            showError(message) {
                this.loading.style.display = 'none';
                this.errorMessage.textContent = message;
                this.errorMessage.style.display = 'block';
                this.audioResult.style.display = 'none';
                this.generateBtn.disabled = false;
                this.isGenerating = false;
            }
            
            async getAudioSize(url) {
                try {
                    const response = await fetch(url, { method: 'HEAD' });
                    const contentLength = response.headers.get('content-length');
                    if (contentLength) {
                        const sizeInBytes = parseInt(contentLength);
                        const sizeInKB = (sizeInBytes / 1024).toFixed(2);
                        this.audioSize.textContent = `${sizeInKB} KB`;
                    } else {
                        this.audioSize.textContent = '未知';
                    }
                } catch (error) {
                    console.error('获取音频大小失败:', error);
                    this.audioSize.textContent = '获取失败';
                }
            }
            
            async copyLink() {
                if (!this.currentAudioUrl) {
                    alert('没有可复制的链接');
                    return;
                }
                
                try {
                    await navigator.clipboard.writeText(this.currentAudioUrl);
                    alert('链接已复制到剪贴板');
                } catch (error) {
                    console.error('复制链接失败:', error);
                    alert('复制链接失败，请手动复制');
                }
            }
            
            saveToHistory(text, url, format) {
                const historyItem = {
                    id: Date.now(),
                    text: text,
                    url: url,
                    format: format,
                    timestamp: new Date().toLocaleString('zh-CN')
                };
                
                this.history.unshift(historyItem);
                
                if (this.history.length > 10) {
                    this.history = this.history.slice(0, 10);
                }
                
                this.saveHistory();
                
                this.renderHistory();
            }
            
            loadHistory() {
                const history = localStorage.getItem('mambo-voice-history');
                return history ? JSON.parse(history) : [];
            }
            
            saveHistory() {
                localStorage.setItem('mambo-voice-history', JSON.stringify(this.history));
            }
            
            renderHistory() {
                if (this.history.length === 0) {
                    this.historyList.innerHTML = '<div style="text-align: center; padding: 20px; color: #666;">暂无历史记录</div>';
                    return;
                }
                
                const html = this.history.map(item => this.renderHistoryItem(item)).join('');
                this.historyList.innerHTML = html;
            }
            
            renderHistoryItem(item) {
                return `
                    <div class="history-item">
                        <div class="history-text">${item.text}</div>
                        <audio class="history-audio" controls src="${item.url}">
                            您的浏览器不支持音频播放
                        </audio>
                        <a href="${item.url}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;" download>下载</a>
                        <button class="history-delete" onclick="mamboVoiceGenerator.deleteHistoryItem(${item.id})">删除</button>
                    </div>
                `;
            }
            
            deleteHistoryItem(id) {
                this.history = this.history.filter(item => item.id !== id);
                this.saveHistory();
                this.renderHistory();
            }
        }
        
        let mamboVoiceGenerator;
        document.addEventListener('DOMContentLoaded', () => {
            mamboVoiceGenerator = new MamboVoiceGenerator();
        });
    </script>
</body>
</html>