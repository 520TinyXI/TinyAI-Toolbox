<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>专业计算器 - 工具箱</title>
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
        
        
        .calculator {
            display: grid;
            grid-template-rows: auto auto auto;
            gap: 20px;
        }
        
        
        .display {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            min-height: 100px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
        }
        
        .display-history {
            color: #999;
            font-size: 14px;
            min-height: 20px;
            text-align: right;
        }
        
        .display-current {
            color: #1a1a1a;
            font-size: 32px;
            font-weight: 700;
            text-align: right;
            word-break: break-all;
        }
        
        
        .buttons {
            display: grid;
            grid-template-columns: 1fr 3fr;
            gap: 20px;
        }
        
        
        .function-buttons {
            display: grid;
            grid-template-rows: repeat(5, auto);
            gap: 12px;
        }
        
        .function-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        
        
        .number-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
        
        
        .btn {
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #fafafa;
            color: #1a1a1a;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
        }
        
        .btn:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn:active {
            transform: translateY(0);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        
        .btn-function {
            background-color: #f0f0f0;
            color: #1a1a1a;
        }
        
        .btn-operator {
            background-color: #e0e0e0;
            color: #1a1a1a;
            font-weight: 600;
        }
        
        .btn-equals {
            background-color: #1a1a1a;
            color: #fff;
            grid-column: span 2;
        }
        
        .btn-equals:hover {
            background-color: #333;
        }
        
        .btn-clear {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .btn-clear:hover {
            background-color: #ffeeba;
        }
        
        
        .btn-number-zero {
            grid-column: span 2;
        }
        
        
        .history {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            max-height: 200px;
            overflow-y: auto;
        }
        
        .history-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .history-item {
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            font-size: 14px;
            color: #666;
        }
        
        .history-item:last-child {
            border-bottom: none;
        }
        
        
        .memory-indicators {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
            font-size: 12px;
            color: #999;
        }
        
        .memory-indicator {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .memory-indicator.active {
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
            
            .display-current {
                font-size: 24px;
            }
            
            .buttons {
                grid-template-columns: 1fr;
            }
            
            .btn {
                padding: 16px;
                font-size: 16px;
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
                    <h2>专业计算器</h2>
                    <p>支持各种科学计算，包括三角函数、对数函数、指数函数等</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    <div class="calculator">

                        <div class="display">
                            <div class="memory-indicators">
                                <div class="memory-indicator" id="memory-indicator">M</div>
                            </div>
                            <div class="display-history" id="display-history"></div>
                            <div class="display-current" id="display-current">0</div>
                        </div>
                        

                        <div class="buttons">

                            <div class="function-buttons">

                                <div class="function-row">
                                    <button class="btn btn-clear" data-action="clear">C</button>
                                    <button class="btn btn-clear" data-action="clear-entry">CE</button>
                                </div>
                                

                                <div class="function-row">
                                    <button class="btn btn-function" data-action="memory-clear">MC</button>
                                    <button class="btn btn-function" data-action="memory-recall">MR</button>
                                </div>
                                

                                <div class="function-row">
                                    <button class="btn btn-function" data-action="memory-add">M+</button>
                                    <button class="btn btn-function" data-action="memory-subtract">M-</button>
                                </div>
                                

                                <div class="function-row">
                                    <button class="btn btn-function" data-action="sqrt">√</button>
                                    <button class="btn btn-function" data-action="pow2">x²</button>
                                </div>
                                

                                <div class="function-row">
                                    <button class="btn btn-function" data-action="pow">x^y</button>
                                    <button class="btn btn-function" data-action="percent">%</button>
                                </div>
                                

                                <div class="function-row">
                                    <button class="btn btn-function" data-action="sin">sin</button>
                                    <button class="btn btn-function" data-action="cos">cos</button>
                                </div>
                                

                                <div class="function-row">
                                    <button class="btn btn-function" data-action="tan">tan</button>
                                    <button class="btn btn-function" data-action="asin">asin</button>
                                </div>
                                

                                <div class="function-row">
                                    <button class="btn btn-function" data-action="acos">acos</button>
                                    <button class="btn btn-function" data-action="atan">atan</button>
                                </div>
                                

                                <div class="function-row">
                                    <button class="btn btn-function" data-action="log">log</button>
                                    <button class="btn btn-function" data-action="ln">ln</button>
                                </div>
                                

                                <div class="function-row">
                                    <button class="btn btn-function" data-action="lg">lg</button>
                                    <button class="btn btn-function" data-action="toggle-sign">±</button>
                                </div>
                                

                                <div class="function-row">
                                    <button class="btn btn-function" data-action="pi">π</button>
                                    <button class="btn btn-function" data-action="e">e</button>
                                </div>
                            </div>
                            

                            <div class="number-buttons">

                                <button class="btn btn-function" data-action="backspace">⌫</button>
                                <button class="btn btn-operator" data-action="divide">÷</button>
                                <button class="btn btn-operator" data-action="multiply">×</button>
                                

                                <button class="btn" data-number="7">7</button>
                                <button class="btn" data-number="8">8</button>
                                <button class="btn" data-number="9">9</button>
                                

                                <button class="btn" data-number="4">4</button>
                                <button class="btn" data-number="5">5</button>
                                <button class="btn" data-number="6">6</button>
                                

                                <button class="btn" data-number="1">1</button>
                                <button class="btn" data-number="2">2</button>
                                <button class="btn" data-number="3">3</button>
                                

                                <button class="btn btn-operator" data-action="subtract">-</button>
                                <button class="btn btn-operator" data-action="add">+</button>
                                <button class="btn btn-equals" data-action="equals">=</button>
                                

                                <button class="btn btn-number-zero" data-number="0">0</button>
                                <button class="btn" data-number=".">.</button>
                            </div>
                        </div>
                        

                        <div class="history">
                            <div class="history-title">计算历史</div>
                            <div id="history-list"></div>
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
                    tool_id: 'calculator',
                    action: action
                })
            }).catch(error => {
                console.error('Failed to record usage:', error);
            });
        }
        
        class Calculator {
            constructor() {
                this.currentValue = '0';
                this.previousValue = null;
                this.operator = null;
                this.waitingForOperand = false;
                this.memory = 0;
                this.history = [];
                this.maxHistory = 10;
                
                this.displayCurrent = document.getElementById('display-current');
                this.displayHistory = document.getElementById('display-history');
                this.historyList = document.getElementById('history-list');
                this.memoryIndicator = document.getElementById('memory-indicator');
                
                this.initEventListeners();
                
                this.updateDisplay();
                this.updateHistory();
                this.updateMemoryIndicator();
            }
            
            initEventListeners() {
                document.querySelectorAll('[data-number]').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        this.inputNumber(e.target.dataset.number);
                    });
                });
                
                document.querySelectorAll('[data-action]').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        this.handleAction(e.target.dataset.action);
                    });
                });
                
                document.addEventListener('keydown', (e) => {
                    this.handleKeyPress(e.key);
                });
            }
            
            inputNumber(number) {
                if (this.waitingForOperand) {
                    this.currentValue = number;
                    this.waitingForOperand = false;
                } else {
                    this.currentValue = this.currentValue === '0' ? number : this.currentValue + number;
                }
                this.updateDisplay();
            }
            
            handleAction(action) {
                switch (action) {
                    case 'clear':
                        this.clear();
                        break;
                    case 'clear-entry':
                        this.clearEntry();
                        break;
                    case 'backspace':
                        this.backspace();
                        break;
                    case 'toggle-sign':
                        this.toggleSign();
                        break;
                    case 'percent':
                        this.percent();
                        break;
                    case 'equals':
                        this.calculate();
                        break;
                    case 'add':
                    case 'subtract':
                    case 'multiply':
                    case 'divide':
                        this.setOperator(action);
                        break;
                    case 'sqrt':
                        this.sqrt();
                        break;
                    case 'pow2':
                        this.pow2();
                        break;
                    case 'pow':
                        this.pow();
                        break;
                    case 'sin':
                        this.sin();
                        break;
                    case 'cos':
                        this.cos();
                        break;
                    case 'tan':
                        this.tan();
                        break;
                    case 'asin':
                        this.asin();
                        break;
                    case 'acos':
                        this.acos();
                        break;
                    case 'atan':
                        this.atan();
                        break;
                    case 'log':
                        this.log();
                        break;
                    case 'ln':
                        this.ln();
                        break;
                    case 'lg':
                        this.lg();
                        break;
                    case 'pi':
                        this.pi();
                        break;
                    case 'e':
                        this.e();
                        break;
                    case 'memory-clear':
                        this.memoryClear();
                        break;
                    case 'memory-recall':
                        this.memoryRecall();
                        break;
                    case 'memory-add':
                        this.memoryAdd();
                        break;
                    case 'memory-subtract':
                        this.memorySubtract();
                        break;
                    case 'memory-store':
                        this.memoryStore();
                        break;
                }
            }
            
            handleKeyPress(key) {
                if (key >= '0' && key <= '9') {
                    this.inputNumber(key);
                } else if (key === '.') {
                    this.inputNumber('.');
                } else if (key === '+') {
                    this.setOperator('add');
                } else if (key === '-') {
                    this.setOperator('subtract');
                } else if (key === '*') {
                    this.setOperator('multiply');
                } else if (key === '/') {
                    this.setOperator('divide');
                } else if (key === 'Enter' || key === '=') {
                    this.calculate();
                } else if (key === 'Escape') {
                    this.clear();
                } else if (key === 'Backspace') {
                    this.backspace();
                } else if (key === '%') {
                    this.percent();
                }
            }
            
            setOperator(operator) {
                if (this.operator && this.waitingForOperand) {
                    this.operator = operator;
                    this.updateDisplay();
                    return;
                }
                
                const inputValue = parseFloat(this.currentValue);
                
                if (this.previousValue === null) {
                    this.previousValue = inputValue;
                } else if (this.operator) {
                    this.calculate();
                    this.previousValue = parseFloat(this.currentValue);
                }
                
                this.waitingForOperand = true;
                this.operator = operator;
                this.updateDisplay();
            }
            
            calculate() {
                if (this.operator === null || this.waitingForOperand) return;
                
                const current = parseFloat(this.currentValue);
                const previous = this.previousValue;
                let result;
                
                const expression = `${previous} ${this.getOperatorSymbol(this.operator)} ${current}`;
                
                try {
                    switch (this.operator) {
                        case 'add':
                            result = previous + current;
                            break;
                        case 'subtract':
                            result = previous - current;
                            break;
                        case 'multiply':
                            result = previous * current;
                            break;
                        case 'divide':
                            if (current === 0) {
                                throw new Error('Division by zero');
                            }
                            result = previous / current;
                            break;
                        default:
                            return;
                    }
                    
                    this.addToHistory(`${expression} = ${result}`);
                    
                    this.currentValue = this.formatResult(result);
                    this.operator = null;
                    this.previousValue = null;
                    this.waitingForOperand = true;
                    this.updateDisplay();
                    this.updateHistory();
                    
                    recordToolUsage('calculate');
                } catch (error) {
                    this.currentValue = 'Error';
                    this.operator = null;
                    this.previousValue = null;
                    this.waitingForOperand = true;
                    this.updateDisplay();
                    
                    recordToolUsage('calculate_error');
                }
            }
            
            getOperatorSymbol(operator) {
                const symbols = {
                    add: '+',
                    subtract: '-',
                    multiply: '×',
                    divide: '÷'
                };
                return symbols[operator] || operator;
            }
            
            clear() {
                this.currentValue = '0';
                this.previousValue = null;
                this.operator = null;
                this.waitingForOperand = false;
                this.updateDisplay();
            }
            
            clearEntry() {
                this.currentValue = '0';
                this.updateDisplay();
            }
            
            backspace() {
                if (this.waitingForOperand) return;
                
                if (this.currentValue.length === 1 || this.currentValue === 'Error') {
                    this.currentValue = '0';
                } else {
                    this.currentValue = this.currentValue.slice(0, -1);
                }
                this.updateDisplay();
            }
            
            toggleSign() {
                if (this.currentValue === '0' || this.currentValue === 'Error') return;
                
                this.currentValue = this.currentValue.startsWith('-') 
                    ? this.currentValue.slice(1)
                    : '-' + this.currentValue;
                this.updateDisplay();
            }
            
            percent() {
                const value = parseFloat(this.currentValue);
                this.currentValue = this.formatResult(value / 100);
                this.updateDisplay();
            }
            
            sqrt() {
                const value = parseFloat(this.currentValue);
                if (value < 0) {
                    this.currentValue = 'Error';
                } else {
                    const result = Math.sqrt(value);
                    this.addToHistory(`√${value} = ${result}`);
                    this.currentValue = this.formatResult(result);
                }
                this.waitingForOperand = true;
                this.updateDisplay();
                this.updateHistory();
            }
            
            pow2() {
                const value = parseFloat(this.currentValue);
                const result = Math.pow(value, 2);
                this.addToHistory(`${value}² = ${result}`);
                this.currentValue = this.formatResult(result);
                this.waitingForOperand = true;
                this.updateDisplay();
                this.updateHistory();
            }
            
            pow() {
                this.previousValue = parseFloat(this.currentValue);
                this.operator = 'pow';
                this.waitingForOperand = true;
                this.updateDisplay();
            }
            
            sin() {
                const value = parseFloat(this.currentValue);
                const result = Math.sin(value * Math.PI / 180);
                this.addToHistory(`sin(${value}°) = ${result}`);
                this.currentValue = this.formatResult(result);
                this.waitingForOperand = true;
                this.updateDisplay();
                this.updateHistory();
            }
            
            cos() {
                const value = parseFloat(this.currentValue);
                const result = Math.cos(value * Math.PI / 180);
                this.addToHistory(`cos(${value}°) = ${result}`);
                this.currentValue = this.formatResult(result);
                this.waitingForOperand = true;
                this.updateDisplay();
                this.updateHistory();
            }
            
            tan() {
                const value = parseFloat(this.currentValue);
                const result = Math.tan(value * Math.PI / 180);
                this.addToHistory(`tan(${value}°) = ${result}`);
                this.currentValue = this.formatResult(result);
                this.waitingForOperand = true;
                this.updateDisplay();
                this.updateHistory();
            }
            
            asin() {
                const value = parseFloat(this.currentValue);
                if (value < -1 || value > 1) {
                    this.currentValue = 'Error';
                } else {
                    const result = Math.asin(value) * 180 / Math.PI;
                    this.addToHistory(`asin(${value}) = ${result}°`);
                    this.currentValue = this.formatResult(result);
                }
                this.waitingForOperand = true;
                this.updateDisplay();
                this.updateHistory();
            }
            
            acos() {
                const value = parseFloat(this.currentValue);
                if (value < -1 || value > 1) {
                    this.currentValue = 'Error';
                } else {
                    const result = Math.acos(value) * 180 / Math.PI;
                    this.addToHistory(`acos(${value}) = ${result}°`);
                    this.currentValue = this.formatResult(result);
                }
                this.waitingForOperand = true;
                this.updateDisplay();
                this.updateHistory();
            }
            
            atan() {
                const value = parseFloat(this.currentValue);
                const result = Math.atan(value) * 180 / Math.PI;
                this.addToHistory(`atan(${value}) = ${result}°`);
                this.currentValue = this.formatResult(result);
                this.waitingForOperand = true;
                this.updateDisplay();
                this.updateHistory();
            }
            
            log() {
                const value = parseFloat(this.currentValue);
                if (value <= 0) {
                    this.currentValue = 'Error';
                } else {
                    const result = Math.log10(value);
                    this.addToHistory(`log(${value}) = ${result}`);
                    this.currentValue = this.formatResult(result);
                }
                this.waitingForOperand = true;
                this.updateDisplay();
                this.updateHistory();
            }
            
            ln() {
                const value = parseFloat(this.currentValue);
                if (value <= 0) {
                    this.currentValue = 'Error';
                } else {
                    const result = Math.log(value);
                    this.addToHistory(`ln(${value}) = ${result}`);
                    this.currentValue = this.formatResult(result);
                }
                this.waitingForOperand = true;
                this.updateDisplay();
                this.updateHistory();
            }
            
            lg() {
                this.log();
            }
            
            pi() {
                this.currentValue = this.formatResult(Math.PI);
                this.waitingForOperand = true;
                this.updateDisplay();
            }
            
            e() {
                this.currentValue = this.formatResult(Math.E);
                this.waitingForOperand = true;
                this.updateDisplay();
            }
            
            memoryClear() {
                this.memory = 0;
                this.updateMemoryIndicator();
            }
            
            memoryRecall() {
                this.currentValue = this.formatResult(this.memory);
                this.waitingForOperand = true;
                this.updateDisplay();
            }
            
            memoryAdd() {
                this.memory += parseFloat(this.currentValue);
                this.updateMemoryIndicator();
            }
            
            memorySubtract() {
                this.memory -= parseFloat(this.currentValue);
                this.updateMemoryIndicator();
            }
            
            memoryStore() {
                this.memory = parseFloat(this.currentValue);
                this.updateMemoryIndicator();
            }
            
            updateDisplay() {
                this.displayCurrent.textContent = this.currentValue;
                
                let historyText = '';
                if (this.previousValue !== null) {
                    historyText = `${this.previousValue} ${this.getOperatorSymbol(this.operator)}`;
                }
                this.displayHistory.textContent = historyText;
            }
            
            updateHistory() {
                this.historyList.innerHTML = '';
                this.history.forEach(item => {
                    const historyItem = document.createElement('div');
                    historyItem.className = 'history-item';
                    historyItem.textContent = item;
                    this.historyList.appendChild(historyItem);
                });
                this.historyList.scrollTop = this.historyList.scrollHeight;
            }
            
            addToHistory(entry) {
                this.history.unshift(entry);
                if (this.history.length > this.maxHistory) {
                    this.history.pop();
                }
            }
            
            updateMemoryIndicator() {
                if (this.memory !== 0) {
                    this.memoryIndicator.classList.add('active');
                } else {
                    this.memoryIndicator.classList.remove('active');
                }
            }
            
            formatResult(result) {
                if (Math.abs(result) < 1e-10) return '0';
                if (Math.abs(result) > 1e10 || Math.abs(result) < 1e-6) {
                    return result.toExponential(10).replace(/\.?0+$/, '');
                }
                return result.toString().replace(/\.?0+$/, '');
            }
        }
        
        const calculator = new Calculator();
    </script>
</body>
</html>