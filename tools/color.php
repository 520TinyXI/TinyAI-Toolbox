<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>颜色选择器 - 工具箱</title>
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
        

        .color-preview {
            width: 100%;
            height: 200px;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }
        

        .color-picker-section {
            margin-bottom: 32px;
        }
        
        .color-picker-container {
            display: flex;
            gap: 20px;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        
        .color-sliders {
            flex: 1;
            min-width: 300px;
        }
        
        .slider-item {
            margin-bottom: 16px;
        }
        
        .slider-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
        }
        
        .slider-value {
            color: #666;
            font-weight: normal;
        }
        
        .slider {
            width: 100%;
            height: 6px;
            border-radius: 3px;
            background: linear-gradient(to right, #000000, #ffffff);
            outline: none;
            -webkit-appearance: none;
            cursor: pointer;
        }
        
        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #1a1a1a;
            cursor: pointer;
            border: 2px solid #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }
        
        .slider::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #1a1a1a;
            cursor: pointer;
            border: 2px solid #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }
        

        .color-formats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        
        .format-item {
            display: flex;
            flex-direction: column;
        }
        
        .format-label {
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .format-input {
            display: flex;
            gap: 8px;
        }
        
        .input-field {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            outline: none;
            border-color: #ccc;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
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
        

        .color-history {
            margin-top: 32px;
        }
        
        .history-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .history-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(50px, 1fr));
            gap: 12px;
        }
        
        .history-item {
            width: 50px;
            height: 50px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .history-item:hover {
            transform: scale(1.1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
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
            
            .color-picker-container {
                flex-direction: column;
                align-items: stretch;
            }
            
            .color-formats {
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
                    <h2>颜色转换器</h2>
                    <p>在线颜色代码转换工具，支持多种颜色格式</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">

                    <div class="color-preview" id="color-preview"></div>
                    

                    <div class="color-picker-section">
                        <div class="color-picker-container">

                            <div class="color-sliders">
                                <div class="slider-item">
                                    <div class="slider-label">
                                        <span>红色 (R)</span>
                                        <span class="slider-value" id="r-value">255</span>
                                    </div>
                                    <input type="range" class="slider" id="r-slider" min="0" max="255" value="255">
                                </div>
                                
                                <div class="slider-item">
                                    <div class="slider-label">
                                        <span>绿色 (G)</span>
                                        <span class="slider-value" id="g-value">255</span>
                                    </div>
                                    <input type="range" class="slider" id="g-slider" min="0" max="255" value="255">
                                </div>
                                
                                <div class="slider-item">
                                    <div class="slider-label">
                                        <span>蓝色 (B)</span>
                                        <span class="slider-value" id="b-value">255</span>
                                    </div>
                                    <input type="range" class="slider" id="b-slider" min="0" max="255" value="255">
                                </div>
                                
                                <div class="slider-item">
                                    <div class="slider-label">
                                        <span>亮度</span>
                                        <span class="slider-value" id="brightness-value">100</span>%
                                    </div>
                                    <input type="range" class="slider" id="brightness-slider" min="0" max="100" value="100">
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="color-formats">
                        <div class="format-item">
                            <label class="format-label">HEX</label>
                            <div class="format-input">
                                <input type="text" class="input-field" id="hex-input" placeholder="#FFFFFF">
                                <button class="btn btn-secondary" onclick="copyToClipboard('hex-input')">复制</button>
                            </div>
                        </div>
                        
                        <div class="format-item">
                            <label class="format-label">RGB</label>
                            <div class="format-input">
                                <input type="text" class="input-field" id="rgb-input" placeholder="rgb(255, 255, 255)">
                                <button class="btn btn-secondary" onclick="copyToClipboard('rgb-input')">复制</button>
                            </div>
                        </div>
                        
                        <div class="format-item">
                            <label class="format-label">HSL</label>
                            <div class="format-input">
                                <input type="text" class="input-field" id="hsl-input" placeholder="hsl(0, 0%, 100%)">
                                <button class="btn btn-secondary" onclick="copyToClipboard('hsl-input')">复制</button>
                            </div>
                        </div>
                    </div>
                    

                    <div class="color-history">
                        <div class="history-title">常用颜色</div>
                        <div class="history-grid" id="color-history">

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
                    tool_id: 'color',
                    action: action
                })
            }).catch(error => {
                console.error('Failed to record usage:', error);
            });
        }
        
        let currentColor = { r: 255, g: 255, b: 255 };
        let colorHistory = [];
        const MAX_HISTORY = 20;
        
        const presetColors = [
            '#000000', '#ffffff', '#ff0000', '#00ff00', '#0000ff',
            '#ffff00', '#ff00ff', '#00ffff', '#808080', '#800000',
            '#808000', '#008000', '#800080', '#008080', '#000080',
            '#c0c0c0', '#ffc0cb', '#ffa500', '#800080', '#008080'
        ];
        
        function init() {
            initColorHistory();
            initEventListeners();
            updateColor();
        }
        
        function initColorHistory() {
            const historyGrid = document.getElementById('color-history');
            presetColors.forEach(color => {
                const historyItem = document.createElement('div');
                historyItem.className = 'history-item';
                historyItem.style.backgroundColor = color;
                historyItem.addEventListener('click', () => {
                    setColorFromHex(color);
                });
                historyGrid.appendChild(historyItem);
            });
        }
        
        function initEventListeners() {
            document.getElementById('r-slider').addEventListener('input', updateFromSliders);
            document.getElementById('g-slider').addEventListener('input', updateFromSliders);
            document.getElementById('b-slider').addEventListener('input', updateFromSliders);
            document.getElementById('brightness-slider').addEventListener('input', updateBrightness);
            
            document.getElementById('hex-input').addEventListener('input', updateFromHex);
            document.getElementById('rgb-input').addEventListener('input', updateFromRgb);
            document.getElementById('hsl-input').addEventListener('input', updateFromHsl);
        }
        
        function updateFromSliders() {
            currentColor.r = parseInt(document.getElementById('r-slider').value);
            currentColor.g = parseInt(document.getElementById('g-slider').value);
            currentColor.b = parseInt(document.getElementById('b-slider').value);
            updateColor();
        }
        
        function updateBrightness() {
            const brightness = parseInt(document.getElementById('brightness-slider').value);
            const hsl = rgbToHsl(currentColor.r, currentColor.g, currentColor.b);
            hsl.l = brightness / 100;
            const rgb = hslToRgb(hsl.h, hsl.s, hsl.l);
            currentColor.r = Math.round(rgb.r);
            currentColor.g = Math.round(rgb.g);
            currentColor.b = Math.round(rgb.b);
            updateColor();
        }
        
        function updateFromHex() {
            const hex = document.getElementById('hex-input').value;
            const rgb = hexToRgb(hex);
            if (rgb) {
                currentColor = rgb;
                updateColor();
            }
        }
        
        function updateFromRgb() {
            const rgb = document.getElementById('rgb-input').value;
            const match = rgb.match(/rgb\((\d+),\s*(\d+),\s*(\d+)\)/);
            if (match) {
                currentColor.r = parseInt(match[1]);
                currentColor.g = parseInt(match[2]);
                currentColor.b = parseInt(match[3]);
                updateColor();
            }
        }
        
        function updateFromHsl() {
            const hsl = document.getElementById('hsl-input').value;
            const match = hsl.match(/hsl\((\d+),\s*(\d+)%,\s*(\d+)%\)/);
            if (match) {
                const h = parseInt(match[1]);
                const s = parseInt(match[2]) / 100;
                const l = parseInt(match[3]) / 100;
                const rgb = hslToRgb(h, s, l);
                currentColor.r = Math.round(rgb.r);
                currentColor.g = Math.round(rgb.g);
                currentColor.b = Math.round(rgb.b);
                updateColor();
            }
        }
        
        function updateColor() {
            const preview = document.getElementById('color-preview');
            preview.style.backgroundColor = `rgb(${currentColor.r}, ${currentColor.g}, ${currentColor.b})`;
            
            document.getElementById('r-slider').value = currentColor.r;
            document.getElementById('g-slider').value = currentColor.g;
            document.getElementById('b-slider').value = currentColor.b;
            
            document.getElementById('r-value').textContent = currentColor.r;
            document.getElementById('g-value').textContent = currentColor.g;
            document.getElementById('b-value').textContent = currentColor.b;
            
            const hsl = rgbToHsl(currentColor.r, currentColor.g, currentColor.b);
            document.getElementById('brightness-slider').value = Math.round(hsl.l * 100);
            document.getElementById('brightness-value').textContent = Math.round(hsl.l * 100);
            
            const hex = rgbToHex(currentColor.r, currentColor.g, currentColor.b);
            const rgbStr = `rgb(${currentColor.r}, ${currentColor.g}, ${currentColor.b})`;
            const hslStr = `hsl(${Math.round(hsl.h)}, ${Math.round(hsl.s * 100)}%, ${Math.round(hsl.l * 100)}%)`;
            
            document.getElementById('hex-input').value = hex;
            document.getElementById('rgb-input').value = rgbStr;
            document.getElementById('hsl-input').value = hslStr;
            
            updateSliderBackgrounds();
            
            recordToolUsage('update');
        }
        
        function updateSliderBackgrounds() {
            const rSlider = document.getElementById('r-slider');
            const gSlider = document.getElementById('g-slider');
            const bSlider = document.getElementById('b-slider');
            
            rSlider.style.background = `linear-gradient(to right, #000000, rgb(255, ${currentColor.g}, ${currentColor.b}))`;
            gSlider.style.background = `linear-gradient(to right, #000000, rgb(${currentColor.r}, 255, ${currentColor.b}))`;
            bSlider.style.background = `linear-gradient(to right, #000000, rgb(${currentColor.r}, ${currentColor.g}, 255))`;
        }
        
        function rgbToHex(r, g, b) {
            return '#' + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1).toUpperCase();
        }
        
        function hexToRgb(hex) {
            hex = hex.replace(/^#/, '');
            
            let r, g, b;
            if (hex.length === 3) {
                r = parseInt(hex[0] + hex[0], 16);
                g = parseInt(hex[1] + hex[1], 16);
                b = parseInt(hex[2] + hex[2], 16);
            } else if (hex.length === 6) {
                r = parseInt(hex.substring(0, 2), 16);
                g = parseInt(hex.substring(2, 4), 16);
                b = parseInt(hex.substring(4, 6), 16);
            } else {
                return null;
            }
            
            return { r, g, b };
        }
        
        function rgbToHsl(r, g, b) {
            r /= 255;
            g /= 255;
            b /= 255;
            
            const max = Math.max(r, g, b);
            const min = Math.min(r, g, b);
            let h, s, l = (max + min) / 2;
            
            if (max === min) {
                h = s = 0;
            } else {
                const d = max - min;
                s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
                
                switch (max) {
                    case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                    case g: h = (b - r) / d + 2; break;
                    case b: h = (r - g) / d + 4; break;
                }
                h /= 6;
            }
            
            return { h, s, l };
        }
        
        function hslToRgb(h, s, l) {
            let r, g, b;
            
            if (s === 0) {
                r = g = b = l;
            } else {
                const hue2rgb = (p, q, t) => {
                    if (t < 0) t += 1;
                    if (t > 1) t -= 1;
                    if (t < 1/6) return p + (q - p) * 6 * t;
                    if (t < 1/2) return q;
                    if (t < 2/3) return p + (q - p) * (2/3 - t) * 6;
                    return p;
                };
                
                const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
                const p = 2 * l - q;
                r = hue2rgb(p, q, h + 1/3);
                g = hue2rgb(p, q, h);
                b = hue2rgb(p, q, h - 1/3);
            }
            
            return { r: r * 255, g: g * 255, b: b * 255 };
        }
        
        function setColorFromHex(hex) {
            const rgb = hexToRgb(hex);
            if (rgb) {
                currentColor = rgb;
                updateColor();
            }
        }
        
        function copyToClipboard(inputId) {
            const input = document.getElementById(inputId);
            input.select();
            input.setSelectionRange(0, 99999);
            document.execCommand('copy');
            
            alert('Copied successfully!');
        }
        
        window.addEventListener('load', init);
    </script>
</body>
</html>