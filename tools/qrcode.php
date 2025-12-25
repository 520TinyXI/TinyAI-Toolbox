<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>二维码生成 - 工具箱</title>
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
        
        .input-textarea,
        .input-field,
        .select-field {
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
        .input-textarea:focus,
        .select-field:focus {
            outline: none;
            border-color: #ccc;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
        }
        
        .options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .option-item {
            display: flex;
            flex-direction: column;
        }
        
        .option-label {
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 8px;
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
        
        .qrcode-container {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            min-height: 300px;
            margin-bottom: 20px;
        }
        
        #qrcode {
            background-color: #fff;
            padding: 10px;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        #qrcode img {
            max-width: 100%;
            height: auto;
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
            
            .options {
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
                    <h2>二维码生成</h2>
                    <p>在线生成二维码，支持自定义颜色、大小和LOGO</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    <div class="stats">
                        <div class="stat-item">
                            <span class="stat-label">内容长度</span>
                            <span class="stat-value" id="content-length">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">二维码大小</span>
                            <span class="stat-value" id="qrcode-size">200x200</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">纠错级别</span>
                            <span class="stat-value" id="error-level">M</span>
                        </div>
                    </div>
                    
                    <div class="input-section">
                        <label for="qrcode-content" class="input-label">输入内容（文本或URL）</label>
                        <textarea class="input-textarea" id="qrcode-content" placeholder="请输入要生成二维码的内容，支持文本和URL..."></textarea>
                    </div>
                    
                    <div class="options">
                        <div class="option-item">
                            <label for="qrcode-size-select" class="option-label">二维码大小</label>
                            <select class="select-field" id="qrcode-size-select">
                                <option value="100">100x100</option>
                                <option value="200" selected>200x200</option>
                                <option value="300">300x300</option>
                                <option value="400">400x400</option>
                                <option value="500">500x500</option>
                                <option value="600">600x600</option>
                            </select>
                        </div>
                        <div class="option-item">
                            <label for="error-level-select" class="option-label">纠错级别</label>
                            <select class="select-field" id="error-level-select">
                                <option value="L">L - 7%容错</option>
                                <option value="M" selected>M - 15%容错</option>
                                <option value="Q">Q - 25%容错</option>
                                <option value="H">H - 30%容错</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="btn-group">
                        <button class="btn btn-primary" id="generate-btn">生成二维码</button>
                        <button class="btn btn-secondary" id="clear-btn">清空</button>
                        <button class="btn btn-success" id="download-btn">下载二维码</button>
                    </div>
                    
                    <div class="output-section">
                        <label class="output-label">生成结果</label>
                        <div class="qrcode-container">
                            <div id="qrcode"></div>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <div class="info-title">关于二维码</div>
                        <div class="info-text">
                            二维码（QR Code）是一种矩阵式二维条码，能够存储较多信息，支持文本、URL、联系方式等多种数据类型。
                            <ul style="margin-top: 8px; padding-left: 20px;">
                                <li>纠错级别越高，二维码越复杂，但容错能力越强</li>
                                <li>L级：7%容错</li>
                                <li>M级：15%容错</li>
                                <li>Q级：25%容错</li>
                                <li>H级：30%容错</li>
                                <li>二维码大小建议设置为200x200以上，以便清晰扫描</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        (function() {
            const ErrorCorrectLevel = {
                L: 1,
                M: 0,
                Q: 3,
                H: 2
            };
            
            
            const Mode = {
                MODE_NUMBER: 1 << 0,
                MODE_ALPHA_NUM: 1 << 1,
                MODE_8BIT_BYTE: 1 << 2,
                MODE_KANJI: 1 << 3
            };
            
            
            class QRCode {
                constructor(typeNumber, errorCorrectLevel) {
                    this.typeNumber = typeNumber;
                    this.errorCorrectLevel = errorCorrectLevel;
                    this.modules = null;
                    this.moduleCount = 0;
                    this.dataCache = null;
                    this.dataList = [];
                }
                
                addData(data) {
                    let newData = new QR8bitByte(data);
                    this.dataList.push(newData);
                    this.dataCache = null;
                }
                
                make() {
                    this.makeImpl(false, this.getBestMaskPattern());
                }
                
                makeImpl(test, maskPattern) {
                    this.moduleCount = this.typeNumber * 4 + 17;
                    this.modules = new Array(this.moduleCount);
                    
                    for (let row = 0; row < this.moduleCount; row++) {
                        this.modules[row] = new Array(this.moduleCount);
                        for (let col = 0; col < this.moduleCount; col++) {
                            this.modules[row][col] = null;
                        }
                    }
                    
                    this.setupPositionProbePattern(0, 0);
                    this.setupPositionProbePattern(this.moduleCount - 7, 0);
                    this.setupPositionProbePattern(0, this.moduleCount - 7);
                    this.setupPositionAdjustPattern();
                    this.setupTimingPattern();
                    this.setupTypeInfo(test, maskPattern);
                    
                    if (this.typeNumber >= 7) {
                        this.setupTypeNumber(test);
                    }
                    
                    if (this.dataCache == null) {
                        this.dataCache = QRCode.createData(this.typeNumber, this.errorCorrectLevel, this.dataList);
                    }
                    
                    this.mapData(this.dataCache, maskPattern);
                }
                
                setupPositionProbePattern(row, col) {
                    for (let r = -1; r <= 7; r++) {
                        if (row + r <= -1 || this.moduleCount <= row + r) continue;
                        for (let c = -1; c <= 7; c++) {
                            if (col + c <= -1 || this.moduleCount <= col + c) continue;
                            if ((0 <= r && r <= 6 && (c == 0 || c == 6)) || (0 <= c && c <= 6 && (r == 0 || r == 6)) || (2 <= r && r <= 4 && 2 <= c && c <= 4)) {
                                this.modules[row + r][col + c] = true;
                            } else {
                                this.modules[row + r][col + c] = false;
                            }
                        }
                    }
                }
                
                setupPositionAdjustPattern() {
                    let pos = QRUtil.getPatternPosition(this.typeNumber);
                    
                    for (let i = 0; i < pos.length; i++) {
                        for (let j = 0; j < pos.length; j++) {
                            let row = pos[i];
                            let col = pos[j];
                            
                            if (this.modules[row][col] != null) continue;
                            
                            for (let r = -2; r <= 2; r++) {
                                for (let c = -2; c <= 2; c++) {
                                    if (r == -2 || r == 2 || c == -2 || c == 2 || (r == 0 && c == 0)) {
                                        this.modules[row + r][col + c] = true;
                                    } else {
                                        this.modules[row + r][col + c] = false;
                                    }
                                }
                            }
                        }
                    }
                }
                
                setupTimingPattern() {
                    for (let r = 8; r < this.moduleCount - 8; r++) {
                        if (this.modules[r][6] != null) continue;
                        this.modules[r][6] = (r % 2 == 0);
                    }
                    
                    for (let c = 8; c < this.moduleCount - 8; c++) {
                        if (this.modules[6][c] != null) continue;
                        this.modules[6][c] = (c % 2 == 0);
                    }
                }
                
                setupTypeNumber(test) {
                    let bits = QRUtil.getBCHTypeNumber(this.typeNumber);
                    
                    for (let i = 0; i < 18; i++) {
                        let mod = (!test && ((bits >> i) & 1) == 1);
                        this.modules[Math.floor(i / 3)][i % 3 + this.moduleCount - 8 - 3] = mod;
                    }
                    
                    for (let i = 0; i < 18; i++) {
                        let mod = (!test && ((bits >> i) & 1) == 1);
                        this.modules[i % 3 + this.moduleCount - 8 - 3][Math.floor(i / 3)] = mod;
                    }
                }
                
                setupTypeInfo(test, maskPattern) {
                    let data = (this.errorCorrectLevel << 3) | maskPattern;
                    let bits = QRUtil.getBCHTypeInfo(data);
                    
                    for (let i = 0; i < 15; i++) {
                        let mod = (!test && ((bits >> i) & 1) == 1);
                        
                        if (i < 6) {
                            this.modules[i][8] = mod;
                        } else if (i < 8) {
                            this.modules[i + 1][8] = mod;
                        } else {
                            this.modules[this.moduleCount - 15 + i][8] = mod;
                        }
                    }
                    
                    for (let i = 0; i < 15; i++) {
                        let mod = (!test && ((bits >> i) & 1) == 1);
                        
                        if (i < 8) {
                            this.modules[8][this.moduleCount - i - 1] = mod;
                        } else if (i < 9) {
                            this.modules[8][15 - i - 1 + 1] = mod;
                        } else {
                            this.modules[8][15 - i - 1] = mod;
                        }
                    }
                    
                    this.modules[this.moduleCount - 8][8] = (!test);
                }
                
                mapData(data, maskPattern) {
                    let inc = -1;
                    let row = this.moduleCount - 1;
                    let bitIndex = 7;
                    let byteIndex = 0;
                    let maskFunc = QRUtil.getMaskFunction(maskPattern);
                    
                    for (let col = this.moduleCount - 1; col > 0; col -= 2) {
                        if (col == 6) col--;
                        
                        while (true) {
                            for (let c = 0; c < 2; c++) {
                                if (this.modules[row][col - c] == null) {
                                    let dark = false;
                                    
                                    if (byteIndex < data.length) {
                                        dark = (((data[byteIndex] >>> bitIndex) & 1) == 1);
                                    }
                                    
                                    let mask = maskFunc(row, col - c);
                                    
                                    if (mask) {
                                        dark = !dark;
                                    }
                                    
                                    this.modules[row][col - c] = dark;
                                    
                                    bitIndex--;
                                    
                                    if (bitIndex == -1) {
                                        byteIndex++;
                                        bitIndex = 7;
                                    }
                                }
                            }
                            
                            row += inc;
                            
                            if (row < 0 || this.moduleCount <= row) {
                                row -= inc;
                                inc = -inc;
                                break;
                            }
                        }
                    }
                }
                
                getBestMaskPattern() {
                    let minLostPoint = 0;
                    let pattern = 0;
                    
                    for (let i = 0; i < 8; i++) {
                        this.makeImpl(true, i);
                        let lostPoint = QRUtil.getLostPoint(this);
                        
                        if (i == 0 || minLostPoint > lostPoint) {
                            minLostPoint = lostPoint;
                            pattern = i;
                        }
                    }
                    
                    return pattern;
                }
                
                static createData(typeNumber, errorCorrectLevel, dataList) {
                    let rsBlocks = QRRSBlock.getRSBlocks(typeNumber, errorCorrectLevel);
                    let buffer = new QRBitBuffer();
                    
                    for (let i = 0; i < dataList.length; i++) {
                        let data = dataList[i];
                        buffer.put(data.mode, 4);
                        buffer.put(data.getLength(), QRUtil.getLengthInBits(data.mode, typeNumber));
                        data.write(buffer);
                    }
                    
                    let totalDataCount = 0;
                    for (let i = 0; i < rsBlocks.length; i++) {
                        totalDataCount += rsBlocks[i].dataCount;
                    }
                    
                    if (buffer.getLengthInBits() > totalDataCount * 8) {
                        throw new Error("code length overflow. (" + buffer.getLengthInBits() + " > " + totalDataCount * 8 + ")");
                    }
                    
                    if (buffer.getLengthInBits() + 4 <= totalDataCount * 8) {
                        buffer.put(0, 4);
                    }
                    
                    while (buffer.getLengthInBits() % 8 != 0) {
                        buffer.putBit(false);
                    }
                    
                    while (true) {
                        if (buffer.getLengthInBits() >= totalDataCount * 8) break;
                        buffer.put(0xec, 8);
                    }
                    
                    return QRCode.createBytes(buffer, rsBlocks);
                }
                
                static createBytes(buffer, rsBlocks) {
                    let offset = 0;
                    let maxDcCount = 0;
                    let maxEcCount = 0;
                    let dcdata = new Array(rsBlocks.length);
                    let ecdata = new Array(rsBlocks.length);
                    
                    for (let r = 0; r < rsBlocks.length; r++) {
                        let dcCount = rsBlocks[r].dataCount;
                        let ecCount = rsBlocks[r].totalCount - dcCount;
                        
                        maxDcCount = Math.max(maxDcCount, dcCount);
                        maxEcCount = Math.max(maxEcCount, ecCount);
                        
                        dcdata[r] = new Array(dcCount);
                        
                        for (let i = 0; i < dcdata[r].length; i++) {
                            dcdata[r][i] = 0xff & buffer.buffer[i + offset];
                        }
                        offset += dcCount;
                        
                        let rsPoly = QRUtil.getErrorCorrectPolynomial(ecCount);
                        let rawPoly = new QRPolynomial(dcdata[r], rsPoly.getLength() - 1);
                        
                        let modPoly = rawPoly.mod(rsPoly);
                        ecdata[r] = new Array(rsPoly.getLength() - 1);
                        for (let i = 0; i < ecdata[r].length; i++) {
                            let modIndex = i + modPoly.getLength() - ecdata[r].length;
                            ecdata[r][i] = (modIndex >= 0) ? modPoly.get(modIndex) : 0;
                        }
                    }
                    
                    let totalCodeCount = 0;
                    for (let i = 0; i < rsBlocks.length; i++) {
                        totalCodeCount += rsBlocks[i].totalCount;
                    }
                    
                    let data = new Array(totalCodeCount);
                    let index = 0;
                    
                    for (let i = 0; i < maxDcCount; i++) {
                        for (let r = 0; r < rsBlocks.length; r++) {
                            if (i < dcdata[r].length) {
                                data[index++] = dcdata[r][i];
                            }
                        }
                    }
                    
                    for (let i = 0; i < maxEcCount; i++) {
                        for (let r = 0; r < rsBlocks.length; r++) {
                            if (i < ecdata[r].length) {
                                data[index++] = ecdata[r][i];
                            }
                        }
                    }
                    
                    return data;
                }
            }
            
            
            const QRUtil = {
                PATTERN_POSITION_TABLE: [
                    [],
                    [6, 18],
                    [6, 22],
                    [6, 26],
                    [6, 30],
                    [6, 34],
                    [6, 22, 38],
                    [6, 24, 42],
                    [6, 26, 46],
                    [6, 28, 50],
                    [6, 30, 54],
                    [6, 32, 58],
                    [6, 34, 62],
                    [6, 26, 46, 66],
                    [6, 26, 48, 70],
                    [6, 26, 50, 74],
                    [6, 30, 54, 78],
                    [6, 30, 56, 82],
                    [6, 30, 58, 86],
                    [6, 34, 62, 90],
                    [6, 28, 50, 72, 94],
                    [6, 26, 50, 74, 98],
                    [6, 30, 54, 78, 102],
                    [6, 28, 54, 80, 106],
                    [6, 32, 58, 84, 110],
                    [6, 30, 58, 86, 114],
                    [6, 34, 62, 90, 118],
                    [6, 26, 50, 74, 98, 122],
                    [6, 30, 54, 78, 102, 126],
                    [6, 26, 52, 78, 104, 130],
                    [6, 30, 56, 82, 108, 134],
                    [6, 34, 60, 86, 112, 138],
                    [6, 30, 58, 86, 114, 142],
                    [6, 34, 62, 90, 118, 146],
                    [6, 30, 54, 78, 102, 126, 150],
                    [6, 24, 50, 76, 102, 128, 154],
                    [6, 28, 54, 80, 106, 132, 158],
                    [6, 32, 58, 84, 110, 136, 162],
                    [6, 26, 54, 82, 110, 138, 166],
                    [6, 30, 58, 86, 114, 142, 170]
                ],
                
                G15: (1 << 10) | (1 << 8) | (1 << 5) | (1 << 4) | (1 << 2) | (1 << 1) | (1 << 0),
                G18: (1 << 12) | (1 << 11) | (1 << 10) | (1 << 9) | (1 << 8) | (1 << 5) | (1 << 2) | (1 << 0),
                G15_MASK: (1 << 14) | (1 << 12) | (1 << 10) | (1 << 4) | (1 << 1),
                
                getBCHTypeInfo(data) {
                    let d = data << 10;
                    while (QRUtil.getBCHDigit(d) - QRUtil.getBCHDigit(QRUtil.G15) >= 0) {
                        d ^= (QRUtil.G15 << (QRUtil.getBCHDigit(d) - QRUtil.getBCHDigit(QRUtil.G15)));
                    }
                    return ((data << 10) | d) ^ QRUtil.G15_MASK;
                },
                
                getBCHTypeNumber(data) {
                    let d = data << 12;
                    while (QRUtil.getBCHDigit(d) - QRUtil.getBCHDigit(QRUtil.G18) >= 0) {
                        d ^= (QRUtil.G18 << (QRUtil.getBCHDigit(d) - QRUtil.getBCHDigit(QRUtil.G18)));
                    }
                    return (data << 12) | d;
                },
                
                getBCHDigit(data) {
                    let digit = 0;
                    while (data != 0) {
                        digit++;
                        data >>>= 1;
                    }
                    return digit;
                },
                
                getPatternPosition(typeNumber) {
                    return QRUtil.PATTERN_POSITION_TABLE[typeNumber - 1];
                },
                
                getMaskFunction(maskPattern) {
                    switch (maskPattern) {
                        case 0: return (i, j) => ((i + j) % 2 == 0);
                        case 1: return (i, j) => (i % 2 == 0);
                        case 2: return (i, j) => (j % 3 == 0);
                        case 3: return (i, j) => ((i + j) % 3 == 0);
                        case 4: return (i, j) => ((Math.floor(i / 2) + Math.floor(j / 3)) % 2 == 0);
                        case 5: return (i, j) => ((i * j) % 2 + (i * j) % 3 == 0);
                        case 6: return (i, j) => (((i * j) % 2 + (i * j) % 3) % 2 == 0);
                        case 7: return (i, j) => (((i + j) % 2 + (i * j) % 3) % 2 == 0);
                        default: return (i, j) => false;
                    }
                },
                
                getErrorCorrectPolynomial(errorCorrectLength) {
                    let a = new QRPolynomial([1], 0);
                    for (let i = 0; i < errorCorrectLength; i++) {
                        a = a.multiply(new QRPolynomial([1, QRMath.gexp(i)], 0));
                    }
                    return a;
                },
                
                getLengthInBits(mode, type) {
                    if (1 <= type && type < 10) {
                        switch (mode) {
                            case Mode.MODE_NUMBER: return 10;
                            case Mode.MODE_ALPHA_NUM: return 9;
                            case Mode.MODE_8BIT_BYTE: return 8;
                            case Mode.MODE_KANJI: return 8;
                            default: throw new Error("mode: " + mode);
                        }
                    } else if (type < 27) {
                        switch (mode) {
                            case Mode.MODE_NUMBER: return 12;
                            case Mode.MODE_ALPHA_NUM: return 11;
                            case Mode.MODE_8BIT_BYTE: return 16;
                            case Mode.MODE_KANJI: return 10;
                            default: throw new Error("mode: " + mode);
                        }
                    } else if (type < 41) {
                        switch (mode) {
                            case Mode.MODE_NUMBER: return 14;
                            case Mode.MODE_ALPHA_NUM: return 13;
                            case Mode.MODE_8BIT_BYTE: return 16;
                            case Mode.MODE_KANJI: return 12;
                            default: throw new Error("mode: " + mode);
                        }
                    } else {
                        throw new Error("type: " + type);
                    }
                },
                
                getLostPoint(qrCode) {
                    let moduleCount = qrCode.moduleCount;
                    let modules = qrCode.modules;
                    let lostPoint = 0;
                    
                    for (let row = 0; row < moduleCount; row++) {
                        for (let col = 0; col < moduleCount; col++) {
                            let sameCount = 0;
                            let dark = modules[row][col];
                            
                            for (let r = -1; r <= 1; r++) {
                                if (row + r < 0 || moduleCount <= row + r) continue;
                                
                                for (let c = -1; c <= 1; c++) {
                                    if (col + c < 0 || moduleCount <= col + c) continue;
                                    if (r == 0 && c == 0) continue;
                                    
                                    if (dark == modules[row + r][col + c]) {
                                        sameCount++;
                                    }
                                }
                            }
                            
                            if (sameCount > 5) {
                                lostPoint += (3 + sameCount - 5);
                            }
                        }
                    }
                    
                    for (let row = 0; row < moduleCount - 1; row++) {
                        for (let col = 0; col < moduleCount - 1; col++) {
                            let count = 0;
                            if (modules[row][col]) count++;
                            if (modules[row + 1][col]) count++;
                            if (modules[row][col + 1]) count++;
                            if (modules[row + 1][col + 1]) count++;
                            
                            if (count == 0 || count == 4) {
                                lostPoint += 3;
                            }
                        }
                    }
                    
                    for (let row = 0; row < moduleCount; row++) {
                        for (let col = 0; col < moduleCount - 6; col++) {
                            if (modules[row][col] && !modules[row][col + 1] && modules[row][col + 2] && modules[row][col + 3] && modules[row][col + 4] && !modules[row][col + 5] && modules[row][col + 6]) {
                                lostPoint += 40;
                            }
                        }
                    }
                    
                    for (let col = 0; col < moduleCount; col++) {
                        for (let row = 0; row < moduleCount - 6; row++) {
                            if (modules[row][col] && !modules[row + 1][col] && modules[row + 2][col] && modules[row + 3][col] && modules[row + 4][col] && !modules[row + 5][col] && modules[row + 6][col]) {
                                lostPoint += 40;
                            }
                        }
                    }
                    
                    let darkCount = 0;
                    
                    for (let col = 0; col < moduleCount; col++) {
                        for (let row = 0; row < moduleCount; row++) {
                            if (modules[row][col]) {
                                darkCount++;
                            }
                        }
                    }
                    
                    let ratio = Math.abs(100 * darkCount / moduleCount / moduleCount - 50) / 5;
                    lostPoint += ratio * 10;
                    
                    return lostPoint;
                }
            };
            
            
            const QRMath = {
                glog: function(n) {
                    if (n < 1) throw new Error("glog(" + n + ")");
                    return QRMath.LOG_TABLE[n];
                },
                
                gexp: function(n) {
                    while (n < 0) n += 255;
                    while (n >= 256) n -= 255;
                    return QRMath.EXP_TABLE[n];
                },
                
                EXP_TABLE: new Array(256),
                LOG_TABLE: new Array(256)
            };
            
            (function() {
                for (let i = 0; i < 8; i++) {
                    QRMath.EXP_TABLE[i] = 1 << i;
                }
                
                for (let i = 8; i < 256; i++) {
                    QRMath.EXP_TABLE[i] = QRMath.EXP_TABLE[i - 4] ^ QRMath.EXP_TABLE[i - 5] ^ QRMath.EXP_TABLE[i - 6] ^ QRMath.EXP_TABLE[i - 8];
                }
                
                for (let i = 0; i < 255; i++) {
                    QRMath.LOG_TABLE[QRMath.EXP_TABLE[i]] = i;
                }
            })();
            
            
            class QRBitBuffer {
                constructor() {
                    this.buffer = [];
                    this.length = 0;
                }
                
                get(index) {
                    let bufIndex = Math.floor(index / 8);
                    return ((this.buffer[bufIndex] >>> (7 - index % 8)) & 1) == 1;
                }
                
                put(num, length) {
                    for (let i = 0; i < length; i++) {
                        this.putBit(((num >>> (length - i - 1)) & 1) == 1);
                    }
                }
                
                putBit(bit) {
                    let bufIndex = Math.floor(this.length / 8);
                    if (this.buffer.length <= bufIndex) {
                        this.buffer.push(0);
                    }
                    
                    if (bit) {
                        this.buffer[bufIndex] |= (0x80 >>> (this.length % 8));
                    }
                    
                    this.length++;
                }
                
                getLengthInBits() {
                    return this.length;
                }
            }
            
            
            class QRPolynomial {
                constructor(num, shift) {
                    if (num.length == undefined) {
                        throw new Error(num.length + "/" + shift);
                    }
                    
                    let offset = 0;
                    
                    while (offset < num.length && num[offset] == 0) {
                        offset++;
                    }
                    
                    this.num = new Array(num.length - offset + shift);
                    
                    for (let i = 0; i < num.length - offset; i++) {
                        this.num[i] = num[i + offset];
                    }
                }
                
                get(index) {
                    return this.num[index];
                }
                
                getLength() {
                    return this.num.length;
                }
                
                multiply(e) {
                    let num = new Array(this.getLength() + e.getLength() - 1);
                    
                    for (let i = 0; i < this.getLength(); i++) {
                        for (let j = 0; j < e.getLength(); j++) {
                            num[i + j] ^= QRMath.gexp(QRMath.glog(this.get(i)) + QRMath.glog(e.get(j)));
                        }
                    }
                    
                    return new QRPolynomial(num, 0);
                }
                
                mod(e) {
                    if (this.getLength() - e.getLength() < 0) {
                        return this;
                    }
                    
                    let ratio = QRMath.glog(this.get(0)) - QRMath.glog(e.get(0));
                    
                    let num = new Array(this.getLength());
                    
                    for (let i = 0; i < this.getLength(); i++) {
                        num[i] = this.get(i);
                    }
                    
                    for (let i = 0; i < e.getLength(); i++) {
                        num[i] ^= QRMath.gexp(QRMath.glog(e.get(i)) + ratio);
                    }
                    
                    return new QRPolynomial(num, 0).mod(e);
                }
            }
            
            
            class QRRSBlock {
                constructor(totalCount, dataCount) {
                    this.totalCount = totalCount;
                    this.dataCount = dataCount;
                }
                
                static RS_BLOCK_TABLE = [
                    
                    [1, 26, 19],
                    [1, 44, 34],
                    [1, 70, 55],
                    [1, 100, 80],
                    [1, 134, 108],
                    [2, 86, 68],
                    [2, 98, 81],
                    [2, 110, 96],
                    [2, 134, 116],
                    [2, 154, 137],
                    [2, 174, 158],
                    [2, 194, 179],
                    [2, 224, 207],
                    [4, 106, 86],
                    [4, 122, 101],
                    [4, 152, 127],
                    [4, 180, 154],
                    [4, 196, 171],
                    [4, 224, 198],
                    [4, 254, 227],
                    [4, 280, 254],
                    [4, 310, 283],
                    [4, 338, 313],
                    [4, 364, 341],
                    [4, 400, 374],
                    [4, 434, 408],
                    [6, 144, 116],
                    [6, 158, 133],
                    [6, 180, 154],
                    [6, 198, 175],
                    [6, 216, 195],
                    [6, 240, 219],
                    [6, 258, 236],
                    [6, 284, 261],
                    [6, 312, 287],
                    [6, 338, 314],
                    [6, 366, 343],
                    [6, 394, 372],
                    [6, 420, 400],
                    [6, 450, 430],
                    
                    [1, 26, 16],
                    [1, 44, 28],
                    [1, 70, 44],
                    [1, 100, 64],
                    [1, 134, 86],
                    [2, 86, 58],
                    [2, 98, 68],
                    [2, 110, 78],
                    [2, 134, 98],
                    [2, 154, 114],
                    [2, 174, 130],
                    [2, 194, 146],
                    [2, 224, 168],
                    [4, 106, 74],
                    [4, 122, 86],
                    [4, 152, 106],
                    [4, 180, 126],
                    [4, 196, 142],
                    [4, 224, 162],
                    [4, 254, 180],
                    [4, 280, 200],
                    [4, 310, 222],
                    [4, 338, 242],
                    [4, 364, 260],
                    [4, 400, 286],
                    [4, 434, 310],
                    [6, 144, 100],
                    [6, 158, 114],
                    [6, 180, 130],
                    [6, 198, 146],
                    [6, 216, 162],
                    [6, 240, 180],
                    [6, 258, 198],
                    [6, 284, 216],
                    [6, 312, 236],
                    [6, 338, 256],
                    [6, 366, 276],
                    [6, 394, 296],
                    [6, 420, 316],
                    [6, 450, 336],
                    
                    [1, 26, 13],
                    [1, 44, 22],
                    [1, 70, 34],
                    [1, 100, 50],
                    [1, 134, 66],
                    [2, 86, 44],
                    [2, 98, 58],
                    [2, 110, 64],
                    [2, 134, 82],
                    [2, 154, 96],
                    [2, 174, 110],
                    [2, 194, 122],
                    [2, 224, 140],
                    [4, 106, 58],
                    [4, 122, 66],
                    [4, 152, 86],
                    [4, 180, 100],
                    [4, 196, 114],
                    [4, 224, 130],
                    [4, 254, 146],
                    [4, 280, 160],
                    [4, 310, 176],
                    [4, 338, 192],
                    [4, 364, 206],
                    [4, 400, 226],
                    [4, 434, 244],
                    [6, 144, 76],
                    [6, 158, 86],
                    [6, 180, 100],
                    [6, 198, 114],
                    [6, 216, 128],
                    [6, 240, 144],
                    [6, 258, 158],
                    [6, 284, 174],
                    [6, 312, 190],
                    [6, 338, 206],
                    [6, 366, 224],
                    [6, 394, 242],
                    [6, 420, 258],
                    [6, 450, 276],
                    
                    [1, 26, 9],
                    [1, 44, 22],
                    [1, 70, 34],
                    [1, 100, 48],
                    [1, 134, 64],
                    [2, 86, 44],
                    [2, 98, 58],
                    [2, 110, 64],
                    [2, 134, 82],
                    [2, 154, 96],
                    [2, 174, 110],
                    [2, 194, 122],
                    [2, 224, 140],
                    [4, 106, 58],
                    [4, 122, 66],
                    [4, 152, 86],
                    [4, 180, 100],
                    [4, 196, 114],
                    [4, 224, 130],
                    [4, 254, 146],
                    [4, 280, 160],
                    [4, 310, 176],
                    [4, 338, 192],
                    [4, 364, 206],
                    [4, 400, 226],
                    [4, 434, 244],
                    [6, 144, 76],
                    [6, 158, 86],
                    [6, 180, 100],
                    [6, 198, 114],
                    [6, 216, 128],
                    [6, 240, 144],
                    [6, 258, 158],
                    [6, 284, 174],
                    [6, 312, 190],
                    [6, 338, 206],
                    [6, 366, 224],
                    [6, 394, 242],
                    [6, 420, 258],
                    [6, 450, 276]
                ];
                
                static getRSBlocks(typeNumber, errorCorrectLevel) {
                    let rsBlock = QRRSBlock.getRsBlockTable(typeNumber, errorCorrectLevel);
                    if (rsBlock == undefined) {
                        throw new Error("bad rs block @ typeNumber:" + typeNumber + "/errorCorrectLevel:" + errorCorrectLevel);
                    }
                    
                    let length = rsBlock.length / 3;
                    let list = [];
                    
                    for (let i = 0; i < length; i++) {
                        let count = rsBlock[i * 3 + 0];
                        let totalCount = rsBlock[i * 3 + 1];
                        let dataCount = rsBlock[i * 3 + 2];
                        
                        for (let j = 0; j < count; j++) {
                            list.push(new QRRSBlock(totalCount, dataCount));
                        }
                    }
                    
                    return list;
                }
                
                static getRsBlockTable(typeNumber, errorCorrectLevel) {
                    switch (errorCorrectLevel) {
                        case ErrorCorrectLevel.L: return QRRSBlock.RS_BLOCK_TABLE[typeNumber - 1];
                        case ErrorCorrectLevel.M: return QRRSBlock.RS_BLOCK_TABLE[typeNumber - 1 + 45];
                        case ErrorCorrectLevel.Q: return QRRSBlock.RS_BLOCK_TABLE[typeNumber - 1 + 90];
                        case ErrorCorrectLevel.H: return QRRSBlock.RS_BLOCK_TABLE[typeNumber - 1 + 135];
                        default: return undefined;
                    }
                }
            }
            
            
            class QR8bitByte {
                constructor(data) {
                    this.mode = Mode.MODE_8BIT_BYTE;
                    this.data = data;
                    this.parsedData = [];
                    
                    for (let i = 0; i < this.data.length; i++) {
                        let byte = this.data.charCodeAt(i);
                        this.parsedData.push(byte);
                    }
                }
                
                getLength(buffer) {
                    return this.parsedData.length;
                }
                
                write(buffer) {
                    for (let i = 0; i < this.parsedData.length; i++) {
                        buffer.put(this.parsedData[i], 8);
                    }
                }
            }
            
            
            window.generateQRCode = function(text, size, errorLevel) {
                let typeNumber = 0;
                let errorCorrectLevel = ErrorCorrectLevel[errorLevel] || ErrorCorrectLevel.M;
                
                try {
                    typeNumber = 1;
                    while (true) {
                        let rsBlocks = QRRSBlock.getRSBlocks(typeNumber, errorCorrectLevel);
                        let buffer = new QRBitBuffer();
                        let qr8bitByte = new QR8bitByte(text);
                        buffer.put(qr8bitByte.mode, 4);
                        buffer.put(qr8bitByte.getLength(), QRUtil.getLengthInBits(qr8bitByte.mode, typeNumber));
                        qr8bitByte.write(buffer);
                        
                        let totalDataCount = 0;
                        for (let i = 0; i < rsBlocks.length; i++) {
                            totalDataCount += rsBlocks[i].dataCount;
                        }
                        
                        if (buffer.getLengthInBits() <= totalDataCount * 8) {
                            break;
                        }
                        
                        typeNumber++;
                        if (typeNumber > 40) {
                            throw new Error("Too long data");
                        }
                    }
                } catch (e) {
                    console.error(e);
                    return null;
                }
                
                let qrCode = new QRCode(typeNumber, errorCorrectLevel);
                qrCode.addData(text);
                qrCode.make();
                
                let canvas = document.createElement('canvas');
                let ctx = canvas.getContext('2d');
                canvas.width = size;
                canvas.height = size;
                
                let moduleCount = qrCode.moduleCount;
                let modules = qrCode.modules;
                let moduleSize = Math.floor(size / moduleCount);
                let offset = Math.floor((size - moduleCount * moduleSize) / 2);
                
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, size, size);
                
                ctx.fillStyle = '#000000';
                
                for (let row = 0; row < moduleCount; row++) {
                    for (let col = 0; col < moduleCount; col++) {
                        if (modules[row][col]) {
                            ctx.fillRect(
                                col * moduleSize + offset,
                                row * moduleSize + offset,
                                moduleSize,
                                moduleSize
                            );
                        }
                    }
                }
                
                return canvas;
            };
        })();
        
        function recordToolUsage(action) {
            fetch('../php/record-tool-usage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tool_id: 'qrcode',
                    action: action
                })
            }).catch(error => {
                console.error('记录使用量失败:', error);
            });
        }
        
        window.addEventListener('load', function() {
            document.getElementById('qrcode').innerHTML = '<p style="color: #999; font-size: 16px;">请输入要生成二维码的内容</p>';
            
            function updateStats(contentLength, size, errorLevel) {
                document.getElementById('content-length').textContent = contentLength;
                document.getElementById('qrcode-size').textContent = `${size}x${size}`;
                document.getElementById('error-level').textContent = errorLevel;
            }
            
            function generateQRCodeUI() {
                const content = document.getElementById('qrcode-content').value;
                const size = parseInt(document.getElementById('qrcode-size-select').value);
                const errorLevel = document.getElementById('error-level-select').value;
                const qrcodeContainer = document.getElementById('qrcode');
                
                qrcodeContainer.innerHTML = '';
                
                if (!content.trim()) {
                    qrcodeContainer.innerHTML = '<p style="color: #999; font-size: 16px;">请输入要生成二维码的内容</p>';
                    updateStats(0, size, errorLevel);
                    return;
                }
                
                const canvas = window.generateQRCode(content, size, errorLevel);
                
                if (canvas) {
                    qrcodeContainer.appendChild(canvas);
                    updateStats(content.length, size, errorLevel);
                    
                    recordToolUsage('generate');
                } else {
                    qrcodeContainer.innerHTML = '<p style="color: #ff4444; font-size: 16px;">生成二维码失败，请重试</p>';
                    
                    recordToolUsage('generate_error');
                }
            }
            
            function clearQRCode() {
                document.getElementById('qrcode-content').value = '';
                document.getElementById('qrcode').innerHTML = '<p style="color: #999; font-size: 16px;">请输入要生成二维码的内容</p>';
                const size = parseInt(document.getElementById('qrcode-size-select').value);
                const errorLevel = document.getElementById('error-level-select').value;
                updateStats(0, size, errorLevel);
            }
            
            function downloadQRCode() {
                const canvas = document.querySelector('#qrcode canvas');
                if (!canvas) {
                    alert('请先生成二维码');
                    return;
                }
                
                const link = document.createElement('a');
                link.download = 'qrcode.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            }
            
            
            document.getElementById('generate-btn').addEventListener('click', generateQRCodeUI);
            document.getElementById('clear-btn').addEventListener('click', clearQRCode);
            document.getElementById('download-btn').addEventListener('click', downloadQRCode);
            
            
            document.getElementById('qrcode-content').addEventListener('input', function() {
                const contentLength = this.value.length;
                const size = parseInt(document.getElementById('qrcode-size-select').value);
                const errorLevel = document.getElementById('error-level-select').value;
                updateStats(contentLength, size, errorLevel);
            });
            
            
            document.getElementById('qrcode-size-select').addEventListener('change', function() {
                const content = document.getElementById('qrcode-content').value;
                if (content.trim()) {
                    generateQRCodeUI();
                }
            });
            
            document.getElementById('error-level-select').addEventListener('change', function() {
                const content = document.getElementById('qrcode-content').value;
                if (content.trim()) {
                    generateQRCodeUI();
                }
            });
        });
    </script>
</body>
</html>