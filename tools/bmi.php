<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI计算器 - 工具箱</title>
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
        
        
        .unit-switch {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 30px;
        }
        
        .unit-btn {
            padding: 12px 24px;
            background-color: transparent;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #666;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .unit-btn.active {
            background-color: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
        }
        
        
        .input-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .input-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .input-label {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .input-field {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .input-field input {
            flex: 1;
            padding: 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            background-color: #fafafa;
        }
        
        .input-field input:focus {
            outline: none;
            border-color: #1a1a1a;
            background-color: #fff;
        }
        
        .input-unit {
            padding: 16px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            color: #666;
        }
        
        
        .calculate-section {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        
        .btn {
            padding: 16px 48px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 18px;
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
        
        
        .result-section {
            margin-bottom: 30px;
        }
        
        .result-card {
            padding: 30px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .result-title {
            font-size: 16px;
            color: #666;
            margin-bottom: 12px;
        }
        
        .bmi-value {
            font-size: 64px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .bmi-status {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        
        .bmi-status.underweight {
            color: #ffc107;
        }
        
        .bmi-status.normal {
            color: #28a745;
        }
        
        .bmi-status.overweight {
            color: #fd7e14;
        }
        
        .bmi-status.obese {
            color: #dc3545;
        }
        
        .bmi-detail {
            font-size: 14px;
            color: #666;
        }
        
        
        .bmi-range {
            padding: 20px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        
        .range-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .range-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }
        
        .range-item {
            padding: 16px;
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        
        .range-name {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .range-value {
            font-size: 12px;
            color: #666;
            margin-bottom: 4px;
        }
        
        .range-desc {
            font-size: 12px;
            color: #999;
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
            
            .input-section {
                grid-template-columns: 1fr;
            }
            
            .range-list {
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
                    <h2>BMI计算器</h2>
                    <p>计算身体质量指数，评估健康状况</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">

                    <div class="unit-switch">
                        <button class="unit-btn active" data-unit="metric">公制 (cm/kg)</button>
                        <button class="unit-btn" data-unit="imperial">英制 (ft/lbs)</button>
                    </div>
                    

                    <div class="input-section">

                        <div class="input-group">
                            <label class="input-label">身高</label>
                            <div class="input-field">
                                <input type="number" id="height" placeholder="请输入身高" step="any">
                                <span class="input-unit" id="height-unit">cm</span>
                            </div>
                        </div>
                        

                        <div class="input-group">
                            <label class="input-label">体重</label>
                            <div class="input-field">
                                <input type="number" id="weight" placeholder="请输入体重" step="any">
                                <span class="input-unit" id="weight-unit">kg</span>
                            </div>
                        </div>
                    </div>
                    

                    <div class="calculate-section">
                        <button class="btn btn-primary" id="calculate-btn">计算BMI</button>
                    </div>
                    

                    <div class="result-section">
                        <div class="result-card">
                            <div class="result-title">您的BMI指数</div>
                            <div class="bmi-value" id="bmi-value">0.0</div>
                            <div class="bmi-status" id="bmi-status">请输入身高和体重</div>
                            <div class="bmi-detail" id="bmi-detail">BMI = 体重(kg) / 身高(m)²</div>
                        </div>
                    </div>
                    

                    <div class="bmi-range">
                        <div class="range-title">BMI范围说明</div>
                        <div class="range-list">
                            <div class="range-item">
                                <div class="range-name">偏瘦</div>
                                <div class="range-value">BMI < 18.5</div>
                                <div class="range-desc">体重不足，建议适当增重</div>
                            </div>
                            <div class="range-item">
                                <div class="range-name">正常</div>
                                <div class="range-value">18.5 ≤ BMI < 24</div>
                                <div class="range-desc">体重正常，继续保持</div>
                            </div>
                            <div class="range-item">
                                <div class="range-name">超重</div>
                                <div class="range-value">24 ≤ BMI < 28</div>
                                <div class="range-desc">体重超重，建议适当减重</div>
                            </div>
                            <div class="range-item">
                                <div class="range-name">肥胖</div>
                                <div class="range-value">BMI ≥ 28</div>
                                <div class="range-desc">肥胖，建议减重并咨询医生</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        class BMICalculator {
            constructor() {
                this.currentUnit = 'metric';
                
                this.unitBtns = document.querySelectorAll('.unit-btn');
                this.heightInput = document.getElementById('height');
                this.weightInput = document.getElementById('weight');
                this.heightUnit = document.getElementById('height-unit');
                this.weightUnit = document.getElementById('weight-unit');
                this.calculateBtn = document.getElementById('calculate-btn');
                this.bmiValue = document.getElementById('bmi-value');
                this.bmiStatus = document.getElementById('bmi-status');
                this.bmiDetail = document.getElementById('bmi-detail');
                
                this.initEventListeners();
            }
            
            initEventListeners() {
                this.unitBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        this.switchUnit(btn.dataset.unit);
                    });
                });
                
                this.calculateBtn.addEventListener('click', () => {
                    this.calculate();
                });
                
                this.heightInput.addEventListener('input', () => {
                    this.calculate();
                });
                
                this.weightInput.addEventListener('input', () => {
                    this.calculate();
                });
            }
            
            switchUnit(unit) {
                this.currentUnit = unit;
                
                this.unitBtns.forEach(btn => {
                    btn.classList.remove('active');
                });
                document.querySelector(`[data-unit="${unit}"]`).classList.add('active');
                
                if (unit === 'metric') {
                    this.heightUnit.textContent = 'cm';
                    this.weightUnit.textContent = 'kg';
                    this.bmiDetail.textContent = 'BMI = 体重(kg) / 身高(m)²';
                } else {
                    this.heightUnit.textContent = 'ft';
                    this.weightUnit.textContent = 'lbs';
                    this.bmiDetail.textContent = 'BMI = 体重(lbs) / 身高(in)² × 703';
                }
                
                this.calculate();
            }
            
            calculate() {
                const height = parseFloat(this.heightInput.value);
                const weight = parseFloat(this.weightInput.value);
                
                if (isNaN(height) || isNaN(weight) || height <= 0 || weight <= 0) {
                    this.bmiValue.textContent = '0.0';
                    this.bmiStatus.textContent = '请输入有效的身高和体重';
                    this.bmiStatus.className = 'bmi-status';
                    return;
                }
                
                let bmi;
                
                if (this.currentUnit === 'metric') {
                    const heightM = height / 100;
                    bmi = weight / (heightM * heightM);
                } else {
                    const heightIn = height * 12;
                    bmi = (weight / (heightIn * heightIn)) * 703;
                }
                
                bmi = parseFloat(bmi.toFixed(1));
                
                this.bmiValue.textContent = bmi;
                
                const status = this.getBMIStatus(bmi);
                this.bmiStatus.textContent = status.name;
                this.bmiStatus.className = `bmi-status ${status.class}`;
                
                recordToolUsage('calculate');
            }
            
            getBMIStatus(bmi) {
                if (bmi < 18.5) {
                    return {
                        name: '偏瘦',
                        class: 'underweight'
                    };
                } else if (bmi < 24) {
                    return {
                        name: '正常',
                        class: 'normal'
                    };
                } else if (bmi < 28) {
                    return {
                        name: '超重',
                        class: 'overweight'
                    };
                } else {
                    return {
                        name: '肥胖',
                        class: 'obese'
                    };
                }
            }
        }
        
        function recordToolUsage(action) {
            fetch('../php/record-tool-usage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tool_id: 'bmi',
                    action: action
                })
            }).catch(error => {
                console.error('Failed to record usage:', error);
            });
        }
        
        const bmiCalculator = new BMICalculator();
    </script>
</body>
</html>