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
    <title>临时邮箱 - <?php echo $siteConfig['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .tool-content {
            background-color: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }
        
        .email-generate-section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 8px;
        }
        
        .generate-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .generate-title {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .generate-btn {
            background-color: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .generate-btn:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .generate-btn:active {
            transform: translateY(0);
        }
        
        .current-email-section {
            background-color: #e8f5e8;
            border: 1px solid #c8e6c9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .email-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }
        
        .email-address {
            font-size: 24px;
            font-weight: 700;
            color: #2e7d32;
            margin-bottom: 12px;
            word-break: break-all;
        }
        
        .email-info {
            display: flex;
            gap: 20px;
            font-size: 14px;
            color: #666;
            flex-wrap: wrap;
        }
        
        .email-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .action-btn {
            background-color: #fff;
            color: #1a1a1a;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .action-btn:hover {
            background-color: #f5f5f5;
        }
        
        .email-list-section {
            margin-top: 30px;
        }
        
        .list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .list-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .list-info {
            font-size: 14px;
            color: #666;
        }
        
        .refresh-btn {
            background-color: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .refresh-btn:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .refresh-btn.loading {
            cursor: not-allowed;
            opacity: 0.7;
        }
        
        .refresh-btn.loading .refresh-icon {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .emails-list {
            background-color: #fafafa;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            overflow: hidden;
        }
        
        .email-item {
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .email-item:hover {
            background-color: #fff;
            transform: translateX(4px);
        }
        
        .email-item:last-child {
            border-bottom: none;
        }
        
        .email-item.unread {
            background-color: #fff8e1;
            border-left: 4px solid #ffc107;
        }
        
        .email-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            flex-wrap: wrap;
            gap: 12px;
        }
        
        .email-sender {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .email-time {
            font-size: 12px;
            color: #666;
        }
        
        .email-subject {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .email-preview {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        
        .email-detail {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 24px;
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .detail-header {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .detail-subject {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 12px;
        }
        
        .detail-info {
            display: flex;
            gap: 20px;
            font-size: 14px;
            color: #666;
            flex-wrap: wrap;
        }
        
        .detail-body {
            font-size: 16px;
            line-height: 1.6;
            color: #1a1a1a;
            white-space: pre-wrap;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        
        .empty-icon {
            font-size: 64px;
            margin-bottom: 16px;
        }
        
        .empty-text {
            font-size: 16px;
        }
        
        .history-section {
            margin-top: 40px;
        }
        
        .history-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 20px;
        }
        
        .history-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        
        .history-item {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            color: #666;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .history-item:hover {
            background-color: #e8f5e8;
            border-color: #c8e6c9;
            color: #2e7d32;
        }
        
        .history-item.active {
            background-color: #e8f5e8;
            border-color: #2e7d32;
            color: #2e7d32;
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        .loading.visible {
            display: block;
        }
        
        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #1a1a1a;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 16px;
        }
        
        .error-message {
            display: none;
            background-color: #fff3f3;
            border: 1px solid #ffe0e0;
            border-radius: 8px;
            padding: 16px;
            color: #d63031;
            margin-bottom: 20px;
        }
        
        .error-message.visible {
            display: block;
        }
        
        @media (max-width: 768px) {
            .tool-container {
                padding: 20px 16px;
            }
            
            .tool-content {
                padding: 20px;
            }
            
            .generate-header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .list-header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .email-info {
                flex-direction: column;
                gap: 8px;
            }
            
            .email-header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .email-address {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 class="logo"><?php echo $siteConfig['name']; ?></h1>
            </div>
            <nav class="menu">
                <?php echo $toolbox->renderMenu(); ?>
            </nav>
            <div class="sidebar-footer">
                <p class="copyright">© 2025 <?php echo $siteConfig['name']; ?></p>
            </div>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h2>临时邮箱</h2>
                    <p>生成临时邮箱，接收邮件，保护隐私</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">
                <div class="error-message" id="error-message"></div>
                
                <div class="email-generate-section">
                        <div class="generate-header">
                            <div class="generate-title">生成临时邮箱</div>
                            <button class="generate-btn" id="generate-btn">生成新邮箱</button>
                        </div>
                        
                        <div class="current-email-section" id="current-email-section" style="display: none;">
                            <div class="email-label">当前邮箱地址</div>
                            <div class="email-address" id="current-email"></div>
                            <div class="email-info">
                                <div>过期时间: <span id="expiry-time"></span></div>
                                <div>创建时间: <span id="create-time"></span></div>
                            </div>
                            <div class="email-actions">
                                <button class="action-btn" id="copy-email-btn">复制邮箱</button>
                                <button class="action-btn" id="refresh-email-btn">刷新邮箱</button>
                                <button class="action-btn" id="delete-email-btn">删除邮箱</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="email-list-section" id="email-list-section" style="display: none;">
                        <div class="list-header">
                            <div>
                                <div class="list-title">收件箱</div>
                                <div class="list-info" id="mail-count">0 封邮件</div>
                            </div>
                            <button class="refresh-btn" id="check-mail-btn">
                                <span class="refresh-icon">🔄</span>
                                <span>检查新邮件</span>
                            </button>
                        </div>
                        
                        <div class="loading" id="mail-loading">
                            <div class="loading-spinner"></div>
                            <div>正在检查邮件，请稍候...</div>
                        </div>
                        
                        <div class="emails-list" id="emails-list"></div>
                        
                        <div class="empty-state" id="empty-mails">
                            <div class="empty-icon">📭</div>
                            <div>暂无邮件</div>
                            <div style="margin-top: 12px; font-size: 14px;">使用上方邮箱地址接收邮件，然后点击"检查新邮件"查看</div>
                        </div>
                        
                        <div class="email-detail" id="email-detail" style="display: none;">
                            <div class="detail-header">
                                <div class="detail-subject" id="detail-subject"></div>
                                <div class="detail-info">
                                    <div>发件人: <span id="detail-sender"></span></div>
                                    <div>时间: <span id="detail-time"></span></div>
                                </div>
                            </div>
                            <div class="detail-body" id="detail-body"></div>
                        </div>
                    </div>
                    
                    <div class="history-section">
                        <div class="history-title">历史邮箱</div>
                        <div class="history-list" id="history-list"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="../js/main.js"></script>
    
    <script>
        async function recordToolUsage(toolId, action, statusValue, responseTime = 0, content = '') {
            try {
                await fetch('../php/record-tool-usage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        tool_id: toolId,
                        content: content,
                        status: statusValue,
                        response_time: responseTime
                    })
                });
            } catch (error) {
                console.error('Failed to record tool usage:', error);
            }
        }
        
        class TempEmail {
            constructor() {
                this.currentEmail = null;
                this.emailHistory = JSON.parse(localStorage.getItem('tempEmailHistory') || '[]');
                this.emails = [];
                this.init();
            }
            
            init() {
                this.bindEvents();
                this.renderHistory();
                if (this.emailHistory.length > 0) {
                    const lastEmail = this.emailHistory[this.emailHistory.length - 1];
                    this.setCurrentEmail(lastEmail.email, new Date(lastEmail.createdAt));
                }
            }
            
            bindEvents() {
                document.getElementById('generate-btn').addEventListener('click', () => {
                    this.generateEmail();
                });
                
                document.getElementById('copy-email-btn').addEventListener('click', () => {
                    this.copyEmail();
                });
                
                document.getElementById('refresh-email-btn').addEventListener('click', () => {
                    this.generateEmail();
                });
                
                document.getElementById('delete-email-btn').addEventListener('click', () => {
                    this.deleteEmail();
                });
                
                document.getElementById('check-mail-btn').addEventListener('click', () => {
                    if (this.currentEmail) {
                        this.checkEmails();
                    }
                });
            }
            
            async generateEmail() {
                this.showLoading();
                this.hideError();
                
                const startTime = Date.now();
                
                try {
                    const response = await fetch('../php/temp-email-api.php?action=generate', {
                        method: 'GET',
                        timeout: 10000
                    });
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    if (!response.ok) {
                        await recordToolUsage('temp-email', 'generate-email', 'error', responseTime, `HTTP error! Status: ${response.status}`);
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.code === 200) {
                        const now = new Date();
                        this.setCurrentEmail(data.email, now);
                        this.addToHistory(data.email, now);
                        this.renderHistory();
                        this.checkEmails();
                        await recordToolUsage('temp-email', 'generate-email', 'success', responseTime);
                    } else {
                        this.showError(data.msg || 'Failed to generate email');
                        await recordToolUsage('temp-email', 'generate-email', 'error', responseTime, data.msg || 'Failed to generate email');
                    }
                } catch (error) {
                    this.showError(`Failed to generate email: ${error.message}`);
                    console.error('API Request Error:', error);
                    const responseTime = (Date.now() - startTime) / 1000;
                    await recordToolUsage('temp-email', 'generate-email', 'error', responseTime, error.message);
                } finally {
                    this.hideLoading();
                }
            }
            
            async checkEmails() {
                if (!this.currentEmail) return;
                
                this.showMailLoading();
                this.hideError();
                this.disableCheckBtn();
                
                const startTime = Date.now();
                
                try {
                    const requestUrl = `../php/temp-email-api.php?action=check&email=${encodeURIComponent(this.currentEmail.email)}`;
                    console.log('Check email request URL:', requestUrl);
                    
                    const response = await fetch(requestUrl, {
                        method: 'GET',
                        timeout: 10000
                    });
                    
                    const responseText = await response.text();
                    console.log('Check email response:', responseText);
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    if (!response.ok) {
                        await recordToolUsage('temp-email', 'check-emails', 'error', responseTime, `HTTP error! Status: ${response.status}, Response: ${responseText}`);
                        throw new Error(`HTTP error! Status: ${response.status}, Response: ${responseText}`);
                    }
                    
                    let data;
                    try {
                        data = JSON.parse(responseText);
                    } catch (jsonError) {
                        await recordToolUsage('temp-email', 'check-emails', 'error', responseTime, `JSON parsing failed: ${jsonError.message}, Response: ${responseText}`);
                        throw new Error(`JSON parsing failed: ${jsonError.message}, Response: ${responseText}`);
                    }
                    
                    if (data.code === 200) {
                        console.log('Received email data:', data.emails);
                        this.emails = Array.isArray(data.emails) ? data.emails : [];
                        console.log('Processed email data:', this.emails);
                        this.renderEmails();
                        document.getElementById('mail-count').textContent = `${data.count} emails`;
                        await recordToolUsage('temp-email', 'check-emails', 'success', responseTime);
                    } else {
                        let errorMsg = data.msg || 'Failed to check emails';
                        if (data.error) {
                            errorMsg += ` (${data.error})`;
                        }
                        if (data.raw_response) {
                            errorMsg += '\nRaw response: ' + data.raw_response;
                        }
                        this.showError(errorMsg);
                        await recordToolUsage('temp-email', 'check-emails', 'error', responseTime, errorMsg);
                    }
                } catch (error) {
                    this.showError(`Failed to check emails: ${error.message}`);
                    console.error('API Request Error:', error);
                    const responseTime = (Date.now() - startTime) / 1000;
                    await recordToolUsage('temp-email', 'check-emails', 'error', responseTime, error.message);
                } finally {
                    this.hideMailLoading();
                    this.enableCheckBtn();
                }
            }
            
            setCurrentEmail(email, createdAt) {
                this.currentEmail = {
                    email: email,
                    createdAt: createdAt,
                    expiryTime: new Date(createdAt.getTime() + 60 * 1000 * 10)
                };
                
                document.getElementById('current-email-section').style.display = 'block';
                document.getElementById('email-list-section').style.display = 'block';
                
                document.getElementById('current-email').textContent = email;
                document.getElementById('create-time').textContent = this.formatDate(createdAt);
                document.getElementById('expiry-time').textContent = this.formatDate(this.currentEmail.expiryTime);
            }
            
            addToHistory(email, createdAt) {
                const existingIndex = this.emailHistory.findIndex(item => item.email === email);
                if (existingIndex !== -1) {
                    this.emailHistory.splice(existingIndex, 1);
                }
                
                this.emailHistory.push({
                    email: email,
                    createdAt: createdAt
                });
                
                if (this.emailHistory.length > 10) {
                    this.emailHistory.shift();
                }
                
                localStorage.setItem('tempEmailHistory', JSON.stringify(this.emailHistory));
            }
            
            copyEmail() {
                if (!this.currentEmail) return;
                
                navigator.clipboard.writeText(this.currentEmail.email)
                    .then(() => {
                        this.showError('Email copied successfully!', 'success');
                    })
                    .catch(err => {
                        this.showError('Copy failed, please copy manually');
                    });
            }
            
            deleteEmail() {
                if (!this.currentEmail) return;
                
                this.emailHistory = this.emailHistory.filter(item => item.email !== this.currentEmail.email);
                localStorage.setItem('tempEmailHistory', JSON.stringify(this.emailHistory));
                
                this.currentEmail = null;
                this.emails = [];
                
                document.getElementById('current-email-section').style.display = 'none';
                document.getElementById('email-list-section').style.display = 'none';
                
                this.renderHistory();
            }
            
            renderHistory() {
                const historyList = document.getElementById('history-list');
                
                if (this.emailHistory.length === 0) {
                    historyList.innerHTML = '<div class="history-item">No history emails</div>';
                    return;
                }
                
                historyList.innerHTML = this.emailHistory.map(item => {
                    const isActive = this.currentEmail && this.currentEmail.email === item.email;
                    return `
                        <div class="history-item ${isActive ? 'active' : ''}" data-email="${item.email}">
                            <span>${item.email}</span>
                            <span style="font-size: 12px;">${this.formatDate(new Date(item.createdAt))}</span>
                        </div>
                    `;
                }).join('');
                
                historyList.querySelectorAll('.history-item').forEach(item => {
                    item.addEventListener('click', () => {
                        const email = item.getAttribute('data-email');
                        const historyItem = this.emailHistory.find(h => h.email === email);
                        if (historyItem) {
                            this.setCurrentEmail(email, new Date(historyItem.createdAt));
                            this.checkEmails();
                            this.renderHistory();
                        }
                    });
                });
            }
            
            renderEmails() {
                const emailsList = document.getElementById('emails-list');
                const emptyMails = document.getElementById('empty-mails');
                
                if (this.emails.length === 0) {
                    emailsList.innerHTML = '';
                    emptyMails.style.display = 'block';
                    return;
                }
                
                emptyMails.style.display = 'none';
                emailsList.innerHTML = this.emails.map(email => {
                    return `
                        <div class="email-item" data-email-id="${email.id || Math.random().toString(36).substr(2, 9)}">
                            <div class="email-header">
                                <div class="email-sender">${email.from || '未知发件人'}</div>
                                <div class="email-time">${this.formatDate(new Date(email.time || Date.now()))}</div>
                            </div>
                            <div class="email-subject">${email.subject || '无主题'}</div>
                            <div class="email-preview">${this.extractPreview(email.body || '')}</div>
                        </div>
                    `;
                }).join('');
                
                emailsList.querySelectorAll('.email-item').forEach(item => {
                    item.addEventListener('click', () => {
                        const emailId = item.getAttribute('data-email-id');
                        this.showEmailDetail(emailId);
                    });
                });
            }
            
            showEmailDetail(emailId) {
                const email = this.emails.find(e => (e.id || Math.random().toString(36).substr(2, 9)) === emailId);
                if (!email) return;
                
                const emailDetail = document.getElementById('email-detail');
                emailDetail.style.display = 'block';
                
                document.getElementById('detail-subject').textContent = email.subject || '无主题';
                document.getElementById('detail-sender').textContent = email.from || '未知发件人';
                document.getElementById('detail-time').textContent = this.formatDate(new Date(email.time || Date.now()));
                
                const bodyElement = document.getElementById('detail-body');
                if (email.body && email.body.html) {
                    bodyElement.innerHTML = email.body.html;
                } else {
                    bodyElement.textContent = email.body || email.body.text || '无内容';
                }
                
                emailDetail.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            
            extractPreview(body) {
                if (typeof body === 'object') {
                    body = body.text || body.html || '';
                }
                
                const plainText = body.replace(/<[^>]*>/g, '');
                return plainText.length > 100 ? plainText.substring(0, 100) + '...' : plainText;
            }
            
            formatDate(date) {
                return date.toLocaleString('zh-CN', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
            }
            
            showError(message, type = 'error') {
                const errorElement = document.getElementById('error-message');
                errorElement.textContent = message;
                errorElement.className = `error-message ${type}`;
                errorElement.classList.add('visible');
                
                if (type === 'success') {
                    setTimeout(() => {
                        this.hideError();
                    }, 3000);
                }
            }
            
            hideError() {
                document.getElementById('error-message').classList.remove('visible');
            }
            
            showLoading() {
            }
            
            hideLoading() {
            }
            
            showMailLoading() {
                document.getElementById('mail-loading').classList.add('visible');
            }
            
            hideMailLoading() {
                document.getElementById('mail-loading').classList.remove('visible');
            }
            
            disableCheckBtn() {
                const checkBtn = document.getElementById('check-mail-btn');
                checkBtn.classList.add('loading');
                checkBtn.disabled = true;
            }
            
            enableCheckBtn() {
                const checkBtn = document.getElementById('check-mail-btn');
                checkBtn.classList.remove('loading');
                checkBtn.disabled = false;
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new TempEmail();
        });
    </script>
</body>
</html>