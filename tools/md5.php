<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MD5加密 - 工具箱</title>
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
            min-height: 120px;
            padding: 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            resize: vertical;
            transition: all 0.3s ease;
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
            min-height: 80px;
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
                    <h2>MD5加密</h2>
                    <p>在线生成MD5哈希值，支持多种输出格式</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    <div class="stats">
                        <div class="stat-item">
                            <span class="stat-label">输入字符数</span>
                            <span class="stat-value" id="input-count">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">输出字符数</span>
                            <span class="stat-value" id="output-count">32</span>
                        </div>
                    </div>
                    
                    <div class="options">
                        <div class="option-item">
                            <input type="checkbox" id="uppercase" name="uppercase" value="1">
                            <label for="uppercase">大写输出</label>
                        </div>
                        <div class="option-item">
                            <input type="checkbox" id="salt" name="salt" value="1">
                            <label for="salt">添加随机盐值</label>
                        </div>
                    </div>
                    
                    <div class="input-section">
                        <label for="input-text" class="input-label">输入文本</label>
                        <textarea class="input-textarea" id="input-text" placeholder="请输入要加密的文本..."></textarea>
                    </div>
                    
                    <div class="btn-group">
                        <button class="btn btn-primary" id="encrypt-btn">生成MD5</button>
                        <button class="btn btn-secondary" id="clear-btn">清空</button>
                        <button class="btn btn-success" id="copy-btn">复制结果</button>
                    </div>
                    
                    <div class="output-section">
                        <label for="output-text" class="output-label">MD5哈希值</label>
                        <textarea class="output-box" id="output-text" readonly></textarea>
                    </div>
                    
                    <div class="info-box">
                        <div class="info-title">关于MD5加密</div>
                        <div class="info-text">
                            MD5是一种广泛使用的密码散列函数，可以产生一个128位（16字节）的散列值，通常表示为32位十六进制数。
                            <ul style="margin-top: 8px; padding-left: 20px;">
                                <li>MD5生成的哈希值长度固定为32位十六进制数</li>
                                <li>MD5是单向哈希函数，无法从哈希值恢复原始数据</li>
                                <li>相同的输入永远产生相同的MD5哈希值</li>
                                <li>不同的输入产生相同MD5哈希值的概率极低（碰撞）</li>
                                <li>添加盐值可以增加哈希的安全性，防止彩虹表攻击</li>
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
                    tool_id: 'md5',
                    action: action
                })
            }).catch(error => {
                console.error('记录使用量失败:', error);
            });
        }
        
        function md5(message) {
            function md5cycle(x, k) {
                var a = x[0], b = x[1], c = x[2], d = x[3];
                a = ff(a, b, c, d, k[0], 7, -680876936);
                d = ff(d, a, b, c, k[1], 12, -389564586);
                c = ff(c, d, a, b, k[2], 17, 606105819);
                b = ff(b, c, d, a, k[3], 22, -1044525330);
                a = ff(a, b, c, d, k[4], 7, -176418897);
                d = ff(d, a, b, c, k[5], 12, 1200080426);
                c = ff(c, d, a, b, k[6], 17, -1473231341);
                b = ff(b, c, d, a, k[7], 22, -45705983);
                a = ff(a, b, c, d, k[8], 7, 1770035416);
                d = ff(d, a, b, c, k[9], 12, -1958414417);
                c = ff(c, d, a, b, k[10], 17, -42063);
                b = ff(b, c, d, a, k[11], 22, -1990404162);
                a = ff(a, b, c, d, k[12], 7, 1804603682);
                d = ff(d, a, b, c, k[13], 12, -40341101);
                c = ff(c, d, a, b, k[14], 17, -1502002290);
                b = ff(b, c, d, a, k[15], 22, 1236535329);
                a = gg(a, b, c, d, k[1], 5, -165796510);
                d = gg(d, a, b, c, k[6], 9, -1069501632);
                c = gg(c, d, a, b, k[11], 14, 643717713);
                b = gg(b, c, d, a, k[0], 20, -373897302);
                a = gg(a, b, c, d, k[5], 5, -701558691);
                d = gg(d, a, b, c, k[10], 9, 38016083);
                c = gg(c, d, a, b, k[15], 14, -660478335);
                b = gg(b, c, d, a, k[4], 20, -405537848);
                a = gg(a, b, c, d, k[9], 5, 568446438);
                d = gg(d, a, b, c, k[14], 9, -1019803690);
                c = gg(c, d, a, b, k[3], 14, -187363961);
                b = gg(b, c, d, a, k[8], 20, 1163531501);
                a = gg(a, b, c, d, k[13], 5, -1444681467);
                d = gg(d, a, b, c, k[2], 9, -51403784);
                c = gg(c, d, a, b, k[7], 14, 1735328473);
                b = gg(b, c, d, a, k[12], 20, -1926607734);
                a = hh(a, b, c, d, k[5], 4, -378558);
                d = hh(d, a, b, c, k[8], 11, -2022574463);
                c = hh(c, d, a, b, k[11], 16, 1839030562);
                b = hh(b, c, d, a, k[14], 23, -35309556);
                a = hh(a, b, c, d, k[1], 4, -1530992060);
                d = hh(d, a, b, c, k[4], 11, 1272893353);
                c = hh(c, d, a, b, k[7], 16, -155497632);
                b = hh(b, c, d, a, k[10], 23, -1094730640);
                a = hh(a, b, c, d, k[13], 4, 681279174);
                d = hh(d, a, b, c, k[0], 11, -358537222);
                c = hh(c, d, a, b, k[3], 16, -722521979);
                b = hh(b, c, d, a, k[6], 23, 76029189);
                a = hh(a, b, c, d, k[9], 4, -640364487);
                d = hh(d, a, b, c, k[12], 11, -421815835);
                c = hh(c, d, a, b, k[15], 16, 530742520);
                b = hh(b, c, d, a, k[2], 23, -995338651);
                a = ii(a, b, c, d, k[0], 6, -198630844);
                d = ii(d, a, b, c, k[7], 10, 1126891415);
                c = ii(c, d, a, b, k[14], 15, -1416354905);
                b = ii(b, c, d, a, k[5], 21, -57434055);
                a = ii(a, b, c, d, k[12], 6, 1700485571);
                d = ii(d, a, b, c, k[3], 10, -1894986606);
                c = ii(c, d, a, b, k[10], 15, -1051523);
                b = ii(b, c, d, a, k[1], 21, -2054922799);
                a = ii(a, b, c, d, k[8], 6, 1873313359);
                d = ii(d, a, b, c, k[15], 10, -30611744);
                c = ii(c, d, a, b, k[6], 15, -1560198380);
                b = ii(b, c, d, a, k[13], 21, 1309151649);
                a = ii(a, b, c, d, k[4], 6, -145523070);
                d = ii(d, a, b, c, k[11], 10, -1120210379);
                c = ii(c, d, a, b, k[2], 15, 718787259);
                b = ii(b, c, d, a, k[9], 21, -343485551);
                x[0] = add32(a, x[0]);
                x[1] = add32(b, x[1]);
                x[2] = add32(c, x[2]);
                x[3] = add32(d, x[3]);
            }
            function cmn(q, a, b, x, s, t) {
                a = add32(add32(a, q), add32(x, t));
                return add32((a << s) | (a >>> (32 - s)), b);
            }
            function ff(a, b, c, d, x, s, t) {
                return cmn((b & c) | ((~b) & d), a, b, x, s, t);
            }
            function gg(a, b, c, d, x, s, t) {
                return cmn((b & d) | (c & (~d)), a, b, x, s, t);
            }
            function hh(a, b, c, d, x, s, t) {
                return cmn(b ^ c ^ d, a, b, x, s, t);
            }
            function ii(a, b, c, d, x, s, t) {
                return cmn(c ^ (b | (~d)), a, b, x, s, t);
            }
            function md51(s) {
                txt = '';
                var n = s.length, state = [1732584193, -271733879, -1732584194, 271733878];
                for (var i = 0; i < n; i += 16) {
                    var block = s.slice(i, i + 16);
                    var k = [];
                    for (var j = 0; j < 16; j++) {
                        k[j] = block.charCodeAt(j) || 0;
                    }
                    md5cycle(state, k);
                }
                return state;
            }
            function add32(a, b) {
                return (a + b) & 0xFFFFFFFF;
            }
            var txt = '';
            var n = message.length, state = [1732584193, -271733879, -1732584194, 271733878];
            for (var i = 0; i < n; i += 16) {
                var block = message.slice(i, i + 16);
                var k = [];
                for (var j = 0; j < 16; j++) {
                    k[j] = block.charCodeAt(j) || 0;
                }
                md5cycle(state, k);
            }
            var digest = state;
            return digest.map(function(x) {
                return ('00000000' + (x >>> 0).toString(16)).slice(-8);
            }).join('');
        }
        
        function generateMD5() {
            const input = document.getElementById('input-text').value;
            const uppercase = document.getElementById('uppercase').checked;
            const addSalt = document.getElementById('salt').checked;
            
            let text = input;
            
            if (addSalt) {
                const salt = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
                text = input + salt;
            }
            
            let hashHex = md5(text);
            if (uppercase) {
                hashHex = hashHex.toUpperCase();
            }
            document.getElementById('output-text').value = hashHex;
            updateStats(input, hashHex);
            
            recordToolUsage('encrypt');
        }
        
        function updateStats(input, output) {
            document.getElementById('input-count').textContent = input.length;
            document.getElementById('output-count').textContent = output.length;
        }
        
        function copyToClipboard() {
            const textarea = document.getElementById('output-text');
            textarea.select();
            textarea.setSelectionRange(0, 99999);
            document.execCommand('copy');
            
            alert('复制成功！');
        }
        
        function clearFields() {
            document.getElementById('input-text').value = '';
            document.getElementById('output-text').value = '';
            updateStats('', '');
        }
        
        document.getElementById('encrypt-btn').addEventListener('click', generateMD5);
        document.getElementById('copy-btn').addEventListener('click', copyToClipboard);
        document.getElementById('clear-btn').addEventListener('click', clearFields);
    </script>
</body>
</html>