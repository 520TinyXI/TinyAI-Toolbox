<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>保质期计算器 - 工具箱</title>
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


        .form-section {
            margin-bottom: 30px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .form-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .form-input {
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #1a1a1a;
        }


        .unit-select {
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            background-color: #fafafa;
        }


        .actions-section {
            margin-bottom: 30px;
        }

        .btn {
            padding: 12px 24px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
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
            padding: 20px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }

        .result-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }

        .result-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .result-item:last-child {
            border-bottom: none;
        }

        .result-label {
            font-size: 14px;
            color: #666;
        }

        .result-value {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .result-value.expired {
            color: #e53935;
        }

        .result-value.warning {
            color: #f57c00;
        }

        .result-value.valid {
            color: #43a047;
        }


        .info-section {
            padding: 20px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }

        .info-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 12px;
        }

        .info-content {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
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

            .form-grid {
                grid-template-columns: 1fr;
            }

            .result-item {
                flex-direction: column;
                align-items: flex-start;
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
                    <h2>保质期计算器</h2>
                    <p>计算食品、药品等产品的保质期到期日期</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">

                    <div class="form-section">
                        <form id="expiry-form">
                            <div class="form-grid">
                                <div class="form-item">
                                    <label for="production-date" class="form-label">生产日期：</label>
                                    <input type="date" id="production-date" class="form-input" required>
                                </div>
                                <div class="form-item">
                                    <label for="expiry-days" class="form-label">保质期：</label>
                                    <input type="number" id="expiry-days" class="form-input" min="1" value="365" required>
                                </div>
                                <div class="form-item">
                                    <label for="expiry-unit" class="form-label">单位：</label>
                                    <select id="expiry-unit" class="unit-select">
                                        <option value="days">天</option>
                                        <option value="months">月</option>
                                        <option value="years">年</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    

                    <div class="actions-section">
                        <button class="btn btn-primary" id="calculate-btn">计算保质期</button>
                    </div>
                    

                    <div class="result-section">
                        <div class="result-title">计算结果</div>
                        <div class="result-item">
                            <div class="result-label">到期日期：</div>
                            <div class="result-value" id="expiry-date"></div>
                        </div>
                        <div class="result-item">
                            <div class="result-label">剩余天数：</div>
                            <div class="result-value" id="remaining-days"></div>
                        </div>
                        <div class="result-item">
                            <div class="result-label">状态：</div>
                            <div class="result-value" id="status"></div>
                        </div>
                        <div class="result-item">
                            <div class="result-label">保质期时长：</div>
                            <div class="result-value" id="expiry-duration"></div>
                        </div>
                    </div>
                    

                    <div class="info-section">
                        <div class="info-title">使用说明</div>
                        <div class="info-content">
                            <p>1. 选择或输入产品的生产日期</p>
                            <p>2. 输入保质期时长，可以选择天、月、年作为单位</p>
                            <p>3. 点击"计算保质期"按钮，系统将自动计算到期日期</p>
                            <p>4. 结果会显示到期日期、剩余天数和当前状态</p>
                            <p>5. 红色表示已过期，黄色表示即将过期，绿色表示正常</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>

        class ExpiryCalculator {
            constructor() {
                this.productionDateInput = document.getElementById('production-date');
                this.expiryDaysInput = document.getElementById('expiry-days');
                this.expiryUnitSelect = document.getElementById('expiry-unit');
                this.calculateBtn = document.getElementById('calculate-btn');
                this.expiryDateElement = document.getElementById('expiry-date');
                this.remainingDaysElement = document.getElementById('remaining-days');
                this.statusElement = document.getElementById('status');
                this.expiryDurationElement = document.getElementById('expiry-duration');
                
                this.init();
            }
            

            init() {

                const today = new Date().toISOString().split('T')[0];
                this.productionDateInput.value = today;
                
                this.initEventListeners();
                this.calculate();
            }
            

            initEventListeners() {
                this.calculateBtn.addEventListener('click', () => this.calculate());
                this.productionDateInput.addEventListener('change', () => this.calculate());
                this.expiryDaysInput.addEventListener('input', () => this.calculate());
                this.expiryUnitSelect.addEventListener('change', () => this.calculate());
            }
            

            calculate() {
                const productionDate = new Date(this.productionDateInput.value);
                const expiryValue = parseInt(this.expiryDaysInput.value);
                const expiryUnit = this.expiryUnitSelect.value;
                

                const expiryDate = new Date(productionDate);
                
                switch (expiryUnit) {
                    case 'days':
                        expiryDate.setDate(expiryDate.getDate() + expiryValue);
                        break;
                    case 'months':
                        expiryDate.setMonth(expiryDate.getMonth() + expiryValue);
                        break;
                    case 'years':
                        expiryDate.setFullYear(expiryDate.getFullYear() + expiryValue);
                        break;
                }
                

                const now = new Date();
                const timeDiff = expiryDate.getTime() - now.getTime();
                const remainingDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                

                let status = '';
                let statusClass = '';
                
                if (remainingDays < 0) {
                    status = '已过期';
                    statusClass = 'expired';
                } else if (remainingDays <= 30) {
                    status = '即将过期';
                    statusClass = 'warning';
                } else {
                    status = '正常';
                    statusClass = 'valid';
                }
                
    
                const formattedProductionDate = this.formatDate(productionDate);
                const formattedExpiryDate = this.formatDate(expiryDate);
                
                // 更新结果
                this.expiryDateElement.textContent = formattedExpiryDate;
                this.remainingDaysElement.textContent = `${Math.abs(remainingDays)} 天`;
                this.statusElement.textContent = status;
                this.expiryDurationElement.textContent = `${expiryValue} ${this.getUnitText(expiryUnit)}`;
                
                // 更新状态样式
                this.expiryDateElement.className = 'result-value';
                this.remainingDaysElement.className = 'result-value';
                this.statusElement.className = `result-value ${statusClass}`;
                
                // 如果已过期，给到期日期也添加过期样式
                if (remainingDays < 0) {
                    this.expiryDateElement.classList.add('expired');
                    this.remainingDaysElement.classList.add('expired');
                } else if (remainingDays <= 30) {
                    this.expiryDateElement.classList.add('warning');
                    this.remainingDaysElement.classList.add('warning');
                } else {
                    this.expiryDateElement.classList.add('valid');
                    this.remainingDaysElement.classList.add('valid');
                }
                

                recordToolUsage('calculate');
            }
            
            // 格式化日期
            formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }
            

            getUnitText(unit) {
                const unitMap = {
                    days: '天',
                    months: '个月',
                    years: '年'
                };
                return unitMap[unit] || '天';
            }
        }
        

        function recordToolUsage(action) {

            fetch('../php/record-tool-usage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tool_id: 'expiry',
                    action: action
                })
            }).catch(error => {
                console.error('记录使用量失败:', error);
            });
        }
        

        document.addEventListener('DOMContentLoaded', () => {
            new ExpiryCalculator();
        });
    </script>
</body>
</html>