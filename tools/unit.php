<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>单位转换 - 工具箱</title>
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
        

        .conversion-type {
            margin-bottom: 30px;
        }
        
        .conversion-type label {
            display: block;
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 12px;
        }
        
        .type-selector {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 12px;
        }
        
        .type-btn {
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #fafafa;
            color: #666;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .type-btn:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
        }
        
        .type-btn.active {
            background-color: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
        }
        

        .conversion-panel {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 15px;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .conversion-box {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .conversion-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        
        .conversion-label {
            font-size: 14px;
            font-weight: 500;
            color: #666;
        }
        
        .conversion-input {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .conversion-input input[type="number"] {
            flex: 1;
            padding: 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            background-color: #fafafa;
        }
        
        .conversion-input input[type="number"]:focus {
            outline: none;
            border-color: #1a1a1a;
            background-color: #fff;
        }
        
        .conversion-input select {
            max-width: 120px;
            min-width: 100px;
            padding: 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            color: #666;
            background-color: #fafafa;
            cursor: pointer;
        }
        
        .conversion-input select:focus {
            outline: none;
            border-color: #1a1a1a;
        }
        

        .swap-btn {
            width: 40px;
            height: 40px;
            border: 1px solid #e0e0e0;
            border-radius: 50%;
            background-color: #fafafa;
            color: #666;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }
        
        .swap-btn:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
            transform: rotate(180deg);
        }
        

        .conversion-result {
            padding: 20px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .result-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }
        
        .result-value {
            font-size: 24px;
            font-weight: 700;
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
            
            .conversion-panel {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .swap-btn {
                transform: rotate(90deg);
            }
            
            .swap-btn:hover {
                transform: rotate(270deg);
            }
            
            .type-selector {
                grid-template-columns: repeat(2, 1fr);
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
                    <h2>单位转换</h2>
                    <p>支持多种单位转换，包括长度、重量、温度、面积、体积、速度等</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">

                    <div class="conversion-type">
                        <label>选择转换类型：</label>
                        <div class="type-selector">
                            <button class="type-btn active" data-type="length">长度</button>
                            <button class="type-btn" data-type="weight">重量</button>
                            <button class="type-btn" data-type="temperature">温度</button>
                            <button class="type-btn" data-type="area">面积</button>
                            <button class="type-btn" data-type="volume">体积</button>
                            <button class="type-btn" data-type="speed">速度</button>
                        </div>
                    </div>
                    

                    <div class="conversion-panel">

                        <div class="conversion-box">
                            <div class="conversion-row">
                                <div class="conversion-label">从：</div>
                                <div class="conversion-label">到：</div>
                            </div>
                            <div class="conversion-input">
                                <input type="number" id="input-value" placeholder="输入数值" value="1" step="any">
                                <select id="from-unit"></select>
                            </div>
                        </div>
                        

                        <button class="swap-btn" id="swap-btn">⇄</button>
                        

                        <div class="conversion-box">
                            <div class="conversion-row">
                                <div class="conversion-label">结果：</div>
                                <div class="conversion-label"></div>
                            </div>
                            <div class="conversion-input">
                                <input type="number" id="output-value" placeholder="转换结果" readonly step="any">
                                <select id="to-unit"></select>
                            </div>
                        </div>
                    </div>
                    

                    <div class="conversion-result">
                        <div class="result-label">转换结果：</div>
                        <div class="result-value" id="result-value"></div>
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
                    tool_id: 'unit',
                    action: action
                })
            }).catch(error => {
                console.error('Failed to record usage:', error);
            });
        }
        
        const unitData = {
            length: {
                name: '长度',
                units: {
                    'mm': { name: '毫米', factor: 0.001 },
                    'cm': { name: '厘米', factor: 0.01 },
                    'dm': { name: '分米', factor: 0.1 },
                    'm': { name: '米', factor: 1 },
                    'km': { name: '千米', factor: 1000 },
                    'in': { name: '英寸', factor: 0.0254 },
                    'ft': { name: '英尺', factor: 0.3048 },
                    'yd': { name: '码', factor: 0.9144 },
                    'mi': { name: '英里', factor: 1609.344 }
                }
            },
            
            weight: {
                name: '重量',
                units: {
                    'mg': { name: '毫克', factor: 0.000001 },
                    'g': { name: '克', factor: 0.001 },
                    'kg': { name: '千克', factor: 1 },
                    't': { name: '吨', factor: 1000 },
                    'oz': { name: '盎司', factor: 0.0283495 },
                    'lb': { name: '磅', factor: 0.453592 }
                }
            },
            
            temperature: {
                name: '温度',
                units: {
                    'c': { name: '摄氏度', convert: (val, to) => {
                        if (to === 'f') return val * 9/5 + 32;
                        if (to === 'k') return val + 273.15;
                        return val;
                    }},
                    'f': { name: '华氏度', convert: (val, to) => {
                        if (to === 'c') return (val - 32) * 5/9;
                        if (to === 'k') return (val - 32) * 5/9 + 273.15;
                        return val;
                    }},
                    'k': { name: '开尔文', convert: (val, to) => {
                        if (to === 'c') return val - 273.15;
                        if (to === 'f') return (val - 273.15) * 9/5 + 32;
                        return val;
                    }}
                }
            },
            
            area: {
                name: '面积',
                units: {
                    'mm2': { name: '平方毫米', factor: 0.000001 },
                    'cm2': { name: '平方厘米', factor: 0.0001 },
                    'dm2': { name: '平方分米', factor: 0.01 },
                    'm2': { name: '平方米', factor: 1 },
                    'km2': { name: '平方千米', factor: 1000000 },
                    'in2': { name: '平方英寸', factor: 0.00064516 },
                    'ft2': { name: '平方英尺', factor: 0.092903 },
                    'yd2': { name: '平方码', factor: 0.836127 }
                }
            },
            
            volume: {
                name: '体积',
                units: {
                    'ml': { name: '毫升', factor: 0.001 },
                    'l': { name: '升', factor: 1 },
                    'm3': { name: '立方米', factor: 1000 },
                    'in3': { name: '立方英寸', factor: 0.0163871 },
                    'ft3': { name: '立方英尺', factor: 28.3168 },
                    'gal': { name: '加仑', factor: 3.78541 },
                    'qt': { name: '夸脱', factor: 0.946353 },
                    'pt': { name: '品脱', factor: 0.473176 },
                    'cup': { name: '杯', factor: 0.236588 }
                }
            },
            
            speed: {
                name: '速度',
                units: {
                    'm/s': { name: '米/秒', factor: 1 },
                    'km/h': { name: '千米/小时', factor: 0.277778 },
                    'mph': { name: '英里/小时', factor: 0.44704 },
                    'ft/s': { name: '英尺/秒', factor: 0.3048 },
                    'knot': { name: '节', factor: 0.514444 }
                }
            }
        };
        
        let currentType = 'length';
        
        const inputValue = document.getElementById('input-value');
        const outputValue = document.getElementById('output-value');
        const fromUnit = document.getElementById('from-unit');
        const toUnit = document.getElementById('to-unit');
        const swapBtn = document.getElementById('swap-btn');
        const resultValue = document.getElementById('result-value');
        const typeBtns = document.querySelectorAll('.type-btn');
        
        function init() {
            typeBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    setConversionType(btn.dataset.type);
                });
            });
            
            inputValue.addEventListener('input', convert);
            fromUnit.addEventListener('change', convert);
            toUnit.addEventListener('change', convert);
            
            swapBtn.addEventListener('click', swapUnits);
            
            setConversionType('length');
        }
        
        function setConversionType(type) {
            currentType = type;
            
            typeBtns.forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelector(`[data-type="${type}"]`).classList.add('active');
            
            updateUnitSelectors();
            
            convert();
        }
        
        function updateUnitSelectors() {
            const units = unitData[currentType].units;
            
            fromUnit.innerHTML = '';
            toUnit.innerHTML = '';
            
            Object.keys(units).forEach(unit => {
                const option1 = document.createElement('option');
                option1.value = unit;
                option1.textContent = units[unit].name;
                fromUnit.appendChild(option1);
                
                const option2 = document.createElement('option');
                option2.value = unit;
                option2.textContent = units[unit].name;
                toUnit.appendChild(option2);
            });
            
            const unitKeys = Object.keys(units);
            if (unitKeys.length > 1) {
                toUnit.value = unitKeys[1];
            }
        }
        
        function convert() {
            const value = parseFloat(inputValue.value) || 0;
            const from = fromUnit.value;
            const to = toUnit.value;
            
            let result;
            
            if (currentType === 'temperature') {
                const celsius = unitData[currentType].units[from].convert(value, 'c');
                result = unitData[currentType].units['c'].convert(celsius, to);
            } else {
                const baseValue = value * unitData[currentType].units[from].factor;
                result = baseValue / unitData[currentType].units[to].factor;
            }
            
            outputValue.value = result;
            
            const fromName = unitData[currentType].units[from].name;
            const toName = unitData[currentType].units[to].name;
            resultValue.textContent = `${value} ${fromName} = ${result} ${toName}`;
            
            recordToolUsage('convert');
        }
        
        function swapUnits() {
            const temp = fromUnit.value;
            fromUnit.value = toUnit.value;
            toUnit.value = temp;
            
            convert();
        }
        
        document.addEventListener('DOMContentLoaded', init);
    </script>
</body>
</html>