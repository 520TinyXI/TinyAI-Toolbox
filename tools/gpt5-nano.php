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
    <title>Gpt5-nano API - <?php echo $siteConfig['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            height: calc(100vh - 200px);
        }
        
        .tool-content {
            background-color: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        
        .chat-container {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        
        .message {
            max-width: 80%;
            padding: 12px 16px;
            border-radius: 8px;
            line-height: 1.6;
        }
        
        .user-message {
            align-self: flex-end;
            background-color: #1a1a1a;
            color: #fff;
        }
        
        .ai-message {
            align-self: flex-start;
            background-color: #f5f5f5;
            color: #333;
        }
        
        
        .input-container {
            padding: 20px;
            background-color: #fff;
            border-top: 1px solid #e0e0e0;
        }
        
        
        .uid-input-group {
            margin-bottom: 16px;
        }
        
        .uid-input-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #666;
            margin-bottom: 8px;
        }
        
        .uid-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .uid-input:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 2px rgba(26, 26, 26, 0.1);
        }
        
        .uid-input.error {
            border-color: #ef4444;
        }
        
        .uid-error {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
            display: none;
        }
        
        
        .chat-input-group {
            display: flex;
            gap: 12px;
            align-items: flex-end;
        }
        
        .question-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            resize: none;
            min-height: 48px;
            max-height: 120px;
            transition: all 0.3s ease;
        }
        
        .question-input:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 2px rgba(26, 26, 26, 0.1);
        }
        
        
        .send-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #1a1a1a;
            color: #fff;
            align-self: flex-end;
        }
        
        .send-btn:hover {
            background-color: #333;
        }
        
        .send-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        
        .error-message {
            background-color: #fee2e2;
            color: #ef4444;
            padding: 12px;
            border-radius: 8px;
            margin: 16px 0;
            text-align: center;
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
                    <h2>Gpt5-nano API</h2>
                    <p>基于OpenAI官方逆向的独立加密算法</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">
                    
                    <div class="chat-container" id="chat-container"></div>
                    
                    
                    <div class="input-container">
                        
                        <div class="uid-input-group">
                            <label for="uid">UID（4-6位数字，用于存储对话记忆）</label>
                            <input type="text" id="uid" class="uid-input" placeholder="请输入4-6位数字，不能是简单的1234或1111等" maxlength="6">
                            <div class="uid-error" id="uid-error">UID格式不正确，请输入4-6位不简单的数字</div>
                        </div>
                        
                        
                        <div class="chat-input-group">
                            <textarea 
                                id="question" 
                                class="question-input" 
                                placeholder="请输入您的问题..."
                                rows="1"
                            ></textarea>
                            <button class="send-btn" id="send-btn">
                                <span id="send-text">发送</span>
                                <span class="loading" id="loading" style="display: none;"></span>
                            </button>
                        </div>
                    </div>
                    
                    
                    <div class="error-message" id="error-message" style="display: none;"></div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        
        async function recordToolUsage(toolId, action, statusValue, responseTime = 0, content = '') {
            try {
                
                const status = statusValue === 1 ? 'success' : 'error';
                
                
                const contentObj = {
                    action: action
                };
                
                
                const responseTimeSeconds = responseTime / 1000;
                
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

        
        class Gpt5Nano {
            constructor() {
                
                this.chatContainer = document.getElementById('chat-container');
                this.uidInput = document.getElementById('uid');
                this.uidError = document.getElementById('uid-error');
                this.questionInput = document.getElementById('question');
                this.sendBtn = document.getElementById('send-btn');
                this.sendText = document.getElementById('send-text');
                this.loading = document.getElementById('loading');
                this.errorMessage = document.getElementById('error-message');
                
                
                this.apiUrl = '../php/gpt5-nano-proxy.php';
                
                
                this.init();
            }
            
            
            init() {
                
                this.initEventListeners();
                
                
                this.addMessage('你好！我是Gpt5-nano，很高兴和你聊天。请输入你的问题。', 'ai');
            }
            
            
            initEventListeners() {
                
                this.sendBtn.addEventListener('click', () => {
                    this.sendMessage();
                });
                
                
                this.questionInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        this.sendMessage();
                    }
                });
                
                
                this.uidInput.addEventListener('input', () => {
                    this.validateUid();
                });
                
                
                this.questionInput.addEventListener('input', () => {
                    this.adjustTextareaHeight();
                });
            }
            
            
            adjustTextareaHeight() {
                this.questionInput.style.height = 'auto';
                this.questionInput.style.height = Math.min(this.questionInput.scrollHeight, 120) + 'px';
            }
            
            
            validateUid() {
                const uid = this.uidInput.value;
                
                
                if (!uid) {
                    this.uidInput.classList.remove('error');
                    this.uidError.style.display = 'none';
                    return true;
                }
                
                
                if (!/^\d{4,6}$/.test(uid)) {
                    this.uidInput.classList.add('error');
                    this.uidError.textContent = 'UID必须是4-6位数字';
                    this.uidError.style.display = 'block';
                    return false;
                }
                
                
                const simplePatterns = [
                    /^(\d)\1+$/, 
                    /^1234\d{0,2}$/, 
                    /^9876\d{0,2}$/, 
                    /^\d{4}0{1,2}$/
                ];
                
                for (const pattern of simplePatterns) {
                    if (pattern.test(uid)) {
                        this.uidInput.classList.add('error');
                        this.uidError.textContent = 'UID不能是简单数字，如1234、1111等';
                        this.uidError.style.display = 'block';
                        return false;
                    }
                }
                
                this.uidInput.classList.remove('error');
                this.uidError.style.display = 'none';
                return true;
            }
            
            
            addMessage(content, type) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${type}-message`;
                messageDiv.textContent = content;
                this.chatContainer.appendChild(messageDiv);
                
                
                this.chatContainer.scrollTop = this.chatContainer.scrollHeight;
            }
            
            
            showError(message) {
                this.errorMessage.textContent = message;
                this.errorMessage.style.display = 'block';
                
                
                setTimeout(() => {
                    this.errorMessage.style.display = 'none';
                }, 3000);
            }
            
            
            async sendMessage() {
                const question = this.questionInput.value.trim();
                const uid = this.uidInput.value;
                
                
                if (!question) {
                    return;
                }
                
                
                if (uid && !this.validateUid()) {
                    return;
                }
                
                
                this.addMessage(question, 'user');
                
                
                this.questionInput.value = '';
                this.adjustTextareaHeight();
                
                
                this.sendText.style.display = 'none';
                this.loading.style.display = 'inline-block';
                this.sendBtn.disabled = true;
                
                
                const startTime = Date.now();
                
                try {
                    
                    const params = new URLSearchParams();
                    params.append('question', question);
                    if (uid) {
                        params.append('uid', uid);
                    }
                    params.append('type', 'json');
                    
                    const requestUrl = `${this.apiUrl}?${params.toString()}`;
                    
                    
                    const response = await fetch(requestUrl, {
                        method: 'GET'
                    });
                    
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    
                    const data = await response.json();
                    
                    
                    const responseTime = Date.now() - startTime;
                    
                    
                    if (data.success === 'error' || !data.success) {
                        
                    await recordToolUsage('gpt5-nano', 'sendMessage', 0, responseTime, question);
                        throw new Error(data.content || '请求失败');
                    }
                    
                    
                    await recordToolUsage('gpt5-nano', 'sendMessage', 1, responseTime, question);
                    
                    
                    this.addMessage(data.content, 'ai');
                } catch (error) {
                    console.error('发送消息失败:', error);
                    
                    
                    const responseTime = Date.now() - startTime;
                    
                    
                    await recordToolUsage('gpt5-nano', 'sendMessage', 0, responseTime, question);
                    
                    this.showError(`发送消息失败: ${error.message}`);
                } finally {
                    
                    this.sendText.style.display = 'inline';
                    this.loading.style.display = 'none';
                    this.sendBtn.disabled = false;
                }
            }
        }
        
        
        let gpt5Nano;
        document.addEventListener('DOMContentLoaded', () => {
            gpt5Nano = new Gpt5Nano();
        });
    </script>
</body>
</html>