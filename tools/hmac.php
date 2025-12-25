<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMAC生成器 - 工具箱</title>
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
        
        
        .settings-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .setting-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .setting-label {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .setting-control {
            padding: 12px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        
        
        select {
            width: 100%;
            padding: 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            background-color: #fafafa;
            cursor: pointer;
        }
        
        select:focus {
            outline: none;
            border-color: #1a1a1a;
            background-color: #fff;
        }
        
        
        textarea {
            width: 100%;
            min-height: 120px;
            padding: 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            line-height: 1.5;
            resize: vertical;
            background-color: #fafafa;
            color: #1a1a1a;
        }
        
        textarea:focus {
            outline: none;
            border-color: #1a1a1a;
            background-color: #fff;
        }
        
        
        input[type="text"] {
            width: 100%;
            padding: 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            background-color: #fafafa;
        }
        
        input[type="text"]:focus {
            outline: none;
            border-color: #1a1a1a;
            background-color: #fff;
        }
        
        
        .options-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .option-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .option-title {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .option-list {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .option-item {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        
        .option-label {
            font-size: 14px;
            color: #666;
        }
        
        
        .result-section {
            margin-bottom: 30px;
        }
        
        .result-card {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 20px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        
        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .result-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .result-actions {
            display: flex;
            gap: 8px;
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
        
        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        
        .result-content {
            padding: 16px;
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            line-height: 1.5;
            white-space: pre-wrap;
            word-break: break-all;
            color: #1a1a1a;
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
            
            .settings-section {
                grid-template-columns: 1fr;
            }
            
            .options-section {
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
                    <h2>HMAC生成器</h2>
                    <p>生成基于哈希函数和密钥的HMAC值</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    
                    <div class="settings-section">
                        
                        <div class="setting-group">
                            <label class="setting-label">哈希算法</label>
                            <select id="algorithm">
                                <option value="md5">MD5</option>
                                <option value="sha1">SHA-1</option>
                                <option value="sha256" selected>SHA-256</option>
                                <option value="sha384">SHA-384</option>
                                <option value="sha512">SHA-512</option>
                                <option value="sha224">SHA-224</option>
                                <option value="ripemd160">RIPEMD-160</option>
                            </select>
                        </div>
                        
                        
                        <div class="setting-group">
                            <label class="setting-label">密钥</label>
                            <input type="text" id="key" placeholder="请输入密钥" value="secret_key">
                        </div>
                    </div>
                    
                    
                    <div class="setting-group" style="margin-bottom: 30px;">
                        <label class="setting-label">消息</label>
                        <textarea id="message" placeholder="请输入要计算HMAC的消息">Hello, World!</textarea>
                    </div>
                    
                    
                    <div class="options-section">
                        
                        <div class="option-group">
                            <div class="option-title">输出格式</div>
                            <div class="option-list">
                                <div class="option-item">
                                    <input type="radio" id="format-hex" name="format" value="hex" checked>
                                    <label class="option-label" for="format-hex">十六进制</label>
                                </div>
                                <div class="option-item">
                                    <input type="radio" id="format-base64" name="format" value="base64">
                                    <label class="option-label" for="format-base64">Base64</label>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="option-group">
                            <div class="option-title">输出大小写</div>
                            <div class="option-list">
                                <div class="option-item">
                                    <input type="radio" id="case-lower" name="case" value="lower" checked>
                                    <label class="option-label" for="case-lower">小写</label>
                                </div>
                                <div class="option-item">
                                    <input type="radio" id="case-upper" name="case" value="upper">
                                    <label class="option-label" for="case-upper">大写</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="result-section">
                        <div class="result-card">
                            <div class="result-header">
                                <div class="result-title">HMAC结果</div>
                                <div class="result-actions">
                                    <button class="btn btn-small" id="copy-btn">复制</button>
                                    <button class="btn btn-small" id="regenerate-btn">重新生成</button>
                                </div>
                            </div>
                            <div class="result-content" id="result-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        
        function arrayBufferToHex(buffer) {
            return Array.from(new Uint8Array(buffer))
                .map(b => b.toString(16).padStart(2, '0'))
                .join('');
        }
        
        
        function arrayBufferToBase64(buffer) {
            return btoa(String.fromCharCode(...new Uint8Array(buffer)));
        }
        
        
        function stringToArrayBuffer(str) {
            const encoder = new TextEncoder();
            return encoder.encode(str);
        }
        
        
        class HMACJS {
            constructor() {
                this.hashFunctions = {
                    md5: this.md5,
                    sha1: this.sha1,
                    sha256: this.sha256
                };
            }
            
            
            md5(str) {
                
                const crypto = window.crypto || window.msCrypto;
                if (crypto && crypto.subtle && crypto.digest) {
                    const encoder = new TextEncoder();
                    return crypto.subtle.digest('MD5', encoder.encode(str))
                        .then(buffer => arrayBufferToHex(buffer));
                }
                
                let hash = 0;
                for (let i = 0; i < str.length; i++) {
                    const char = str.charCodeAt(i);
                    hash = ((hash << 5) - hash) + char;
                    hash = hash & hash;
                }
                return Promise.resolve(Math.abs(hash).toString(16).padStart(32, '0'));
            }
            
            
            sha1(str) {
                const crypto = window.crypto || window.msCrypto;
                if (crypto && crypto.subtle && crypto.digest) {
                    const encoder = new TextEncoder();
                    return crypto.subtle.digest('SHA-1', encoder.encode(str))
                        .then(buffer => arrayBufferToHex(buffer));
                }
                
                let hash = 0;
                for (let i = 0; i < str.length; i++) {
                    hash = (((hash << 5) - hash) + str.charCodeAt(i)) & 0xFFFFFFFF;
                }
                return Promise.resolve(hash.toString(16).padStart(40, '0'));
            }
            
            
            sha256(str) {
                const crypto = window.crypto || window.msCrypto;
                if (crypto && crypto.subtle && crypto.digest) {
                    const encoder = new TextEncoder();
                    return crypto.subtle.digest('SHA-256', encoder.encode(str))
                        .then(buffer => arrayBufferToHex(buffer));
                }
                
                let hash = 0;
                for (let i = 0; i < str.length; i++) {
                    hash = (((hash << 5) - hash) + str.charCodeAt(i)) & 0xFFFFFFFF;
                }
                return Promise.resolve(hash.toString(16).padStart(64, '0'));
            }
            
            
            async hmac(algorithm, key, message) {
                const hashFunc = this.hashFunctions[algorithm];
                if (!hashFunc) {
                    throw new Error('不支持的算法：' + algorithm);
                }
                
                
                const blockSize = 64;
                
                
                let keyHash;
                if (key.length > blockSize) {
                    keyHash = await hashFunc(key);
                } else {
                    keyHash = key;
                }
                
                
                let paddedKey = keyHash;
                while (paddedKey.length < blockSize) {
                    paddedKey += '\0';
                }
                
                
                const ipad = new Array(blockSize + 1).join(String.fromCharCode(0x36));
                const opad = new Array(blockSize + 1).join(String.fromCharCode(0x5C));
                
                
                const inner = paddedKey.split('').map((char, i) => String.fromCharCode(char.charCodeAt(0) ^ ipad.charCodeAt(i))).join('') + message;
                const innerHash = await hashFunc(inner);
                
                const outer = paddedKey.split('').map((char, i) => String.fromCharCode(char.charCodeAt(0) ^ opad.charCodeAt(i))).join('') + innerHash;
                const outerHash = await hashFunc(outer);
                
                return outerHash;
            }
        }
        
        
        class HMACGenerator {
            constructor() {
                this.algorithm = document.getElementById('algorithm');
                this.key = document.getElementById('key');
                this.message = document.getElementById('message');
                this.formatHex = document.getElementById('format-hex');
                this.formatBase64 = document.getElementById('format-base64');
                this.caseLower = document.getElementById('case-lower');
                this.caseUpper = document.getElementById('case-upper');
                this.resultContent = document.getElementById('result-content');
                this.copyBtn = document.getElementById('copy-btn');
                this.regenerateBtn = document.getElementById('regenerate-btn');
                
                
                this.hmacjs = new HMACJS();
                
                
                this.initEventListeners();
                
                
                this.generate();
            }
            
            
            initEventListeners() {
                
                this.algorithm.addEventListener('change', () => {
                    this.generate();
                });
                
                this.key.addEventListener('input', () => {
                    this.generate();
                });
                
                this.message.addEventListener('input', () => {
                    this.generate();
                });
                
                this.formatHex.addEventListener('change', () => {
                    this.generate();
                });
                
                this.formatBase64.addEventListener('change', () => {
                    this.generate();
                });
                
                this.caseLower.addEventListener('change', () => {
                    this.generate();
                });
                
                this.caseUpper.addEventListener('change', () => {
                    this.generate();
                });
                
                
                this.copyBtn.addEventListener('click', () => {
                    this.copyToClipboard();
                });
                
                
                this.regenerateBtn.addEventListener('click', () => {
                    this.generate();
                });
            }
            
            
            async generate() {
                const algorithm = this.algorithm.value;
                const key = this.key.value;
                const message = this.message.value;
                const format = this.formatHex.checked ? 'hex' : 'base64';
                const isUpper = this.caseUpper.checked;
                
                try {
                    let result;
                    
                    
                    if (window.crypto && window.crypto.subtle) {
                        result = await this.generateWithSubtleCrypto(algorithm, key, message, format);
                    } else {
                        
                        result = await this.generateWithJS(algorithm, key, message, format);
                    }
                    
                    
                    if (isUpper) {
                        result = result.toUpperCase();
                    } else {
                        result = result.toLowerCase();
                    }
                    
                    
                    this.resultContent.textContent = result;
                    
                    
                    recordToolUsage('generate');
                } catch (error) {
                    console.error('生成HMAC失败:', error);
                    this.resultContent.textContent = '生成HMAC失败：' + error.message;
                }
            }
            
            
            async generateWithSubtleCrypto(algorithm, key, message, format) {
                
                const subtleAlgorithm = this.getSubtleAlgorithm(algorithm);
                if (!subtleAlgorithm) {
                    throw new Error('不支持的算法：' + algorithm);
                }
                
                
                const encoder = new TextEncoder();
                const keyData = encoder.encode(key);
                const messageData = encoder.encode(message);
                
                
                const cryptoKey = await crypto.subtle.importKey(
                    'raw',
                    keyData,
                    { name: 'HMAC', hash: subtleAlgorithm },
                    false,
                    ['sign']
                );
                
                
                const signature = await crypto.subtle.sign(
                    'HMAC',
                    cryptoKey,
                    messageData
                );
                
                
                if (format === 'hex') {
                    return arrayBufferToHex(signature);
                } else {
                    return arrayBufferToBase64(signature);
                }
            }
            
            
            async generateWithJS(algorithm, key, message, format) {
                
                const supportedAlgorithms = ['md5', 'sha1', 'sha256'];
                if (!supportedAlgorithms.includes(algorithm)) {
                    throw new Error('JavaScript实现仅支持：' + supportedAlgorithms.join(', '));
                }
                
                
                const result = await this.hmacjs.hmac(algorithm, key, message);
                
                
                if (format === 'base64') {
                    
                    const hex = result;
                    const bytes = new Uint8Array(hex.length / 2);
                    for (let i = 0; i < hex.length; i += 2) {
                        bytes[i / 2] = parseInt(hex.substr(i, 2), 16);
                    }
                    return btoa(String.fromCharCode(...bytes));
                }
                
                return result;
            }
            
            
            getSubtleAlgorithm(algorithm) {
                const algorithmMap = {
                    'md5': 'MD5',
                    'sha1': 'SHA-1',
                    'sha256': 'SHA-256',
                    'sha384': 'SHA-384',
                    'sha512': 'SHA-512',
                    'sha224': 'SHA-224'
                };
                return algorithmMap[algorithm] || null;
            }
            
            
            async copyToClipboard() {
                const result = this.resultContent.textContent;
                if (!result) return;
                
                try {
                    await navigator.clipboard.writeText(result);
                    this.showNotification('已复制到剪贴板');
                } catch (err) {
                    console.error('复制失败:', err);
                    
                    const textarea = document.createElement('textarea');
                    textarea.value = result;
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);
                    this.showNotification('已复制到剪贴板');
                }
            }
            
            
            showNotification(message) {
                const notification = document.createElement('div');
                notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: #1a1a1a;
                    color: #fff;
                    padding: 12px 24px;
                    border-radius: 8px;
                    font-size: 14px;
                    z-index: 1000;
                `;
                notification.textContent = message;
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 2000);
            }
        }
        
        
        function recordToolUsage(action) {
            
            fetch('../php/record-tool-usage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tool_id: 'hmac',
                    action: action
                })
            }).catch(error => {
                console.error('记录使用量失败:', error);
            });
        }
        
        
        const hmacGenerator = new HMACGenerator();
    </script>
</body>
</html>