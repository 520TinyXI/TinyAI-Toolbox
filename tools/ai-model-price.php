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
    <title>AI大模型价格对比 - <?php echo $siteConfig['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .tool-content {
            background-color: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }
        
        
        .control-panel {
            background-color: #fafafa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            border: 1px solid #e0e0e0;
        }
        
        .control-row {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 16px;
        }
        
        .control-row:last-child {
            margin-bottom: 0;
        }
        
        .form-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .form-label {
            font-size: 14px;
            font-weight: 500;
            color: #666;
        }
        
        .form-select, .form-input {
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            min-width: 150px;
        }
        
        .form-select:focus, .form-input:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 2px rgba(26, 26, 26, 0.1);
        }
        
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #1a1a1a;
            color: #fff;
        }
        
        .btn:hover {
            background-color: #333;
        }
        
        
        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .stat-card {
            background-color: #fafafa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            text-align: center;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .stat-label {
            font-size: 14px;
            color: #666;
        }
        
        
        .result-section {
            margin-top: 24px;
        }
        
        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            font-size: 18px;
            color: #666;
        }
        
        .loading::before {
            content: '';
            display: inline-block;
            width: 24px;
            height: 24px;
            margin-right: 12px;
            border: 3px solid rgba(26, 26, 26, 0.1);
            border-radius: 50%;
            border-top-color: #1a1a1a;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        
        .error-message {
            background-color: #fee2e2;
            color: #ef4444;
            padding: 16px;
            border-radius: 8px;
            margin: 24px 0;
            text-align: center;
        }
        
        
        .model-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .model-card {
            background-color: #fafafa;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .model-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        .model-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 12px;
        }
        
        .model-title {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .model-provider {
            font-size: 14px;
            font-weight: 500;
            color: #666;
        }
        
        .model-quality {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            background-color: #e6f4ea;
            color: #10b981;
            border-radius: 16px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .quality-bar {
            width: 60px;
            height: 6px;
            background-color: #d1fae5;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .quality-fill {
            height: 100%;
            background-color: #10b981;
            border-radius: 3px;
        }
        
        .model-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 16px;
        }
        
        .info-item {
            background-color: #fff;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        
        .info-label {
            font-size: 12px;
            font-weight: 500;
            color: #666;
            margin-bottom: 4px;
        }
        
        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .model-costs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
            margin-bottom: 16px;
        }
        
        .cost-item {
            background-color: #fff;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            text-align: center;
        }
        
        .cost-label {
            font-size: 12px;
            font-weight: 500;
            color: #666;
            margin-bottom: 4px;
        }
        
        .cost-value {
            font-size: 18px;
            font-weight: 700;
            color: #ef4444;
        }
        
        .model-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .btn-secondary {
            background-color: #fff;
            color: #333;
            border: 1px solid #e0e0e0;
        }
        
        .btn-secondary:hover {
            background-color: #f9fafb;
            border-color: #d1d5db;
        }
        
        
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            margin-top: 24px;
            padding: 16px;
            background-color: #fafafa;
            border-radius: 8px;
        }
        
        .pagination-info {
            font-size: 14px;
            color: #666;
        }
        
        .pagination-btn {
            padding: 8px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background-color: #fff;
            color: #333;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .pagination-btn:hover:not(:disabled) {
            background-color: #f9fafb;
            border-color: #d1d5db;
        }
        
        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .pagination-btn.active {
            background-color: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
        }
        
        
        .calculator-section {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }
        
        .calculator-title {
            font-size: 18px;
            font-weight: 600;
            color: #059669;
            margin-bottom: 16px;
        }
        
        .calculator-form {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            align-items: center;
        }
        
        .calculator-result {
            margin-top: 16px;
            padding: 16px;
            background-color: #e6f4ea;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            color: #059669;
        }
        
        
        @media (max-width: 768px) {
            .control-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .model-header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .model-info {
                grid-template-columns: 1fr;
            }
            
            .model-costs {
                grid-template-columns: 1fr;
            }
            
            .stats-section {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 480px) {
            .stats-section {
                grid-template-columns: 1fr;
            }
            
            .calculator-form {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- 左侧菜单栏 -->
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

        <!-- 主内容区 -->
        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h2>AI大模型价格对比</h2>
                    <p>对比不同AI大模型的价格、性能和质量</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">
    
                    <div class="calculator-section">
                        <h3 class="calculator-title">价格计算器</h3>
                        <form id="price-calculator">
                            <div class="calculator-form">
                                <div class="form-group">
                                    <label for="input-tokens" class="form-label">输入令牌数</label>
                                    <input type="number" id="input-tokens" name="input-tokens" class="form-input" placeholder="请输入输入令牌数" min="0" value="1000">
                                </div>
                                <div class="form-group">
                                    <label for="output-tokens" class="form-label">输出令牌数</label>
                                    <input type="number" id="output-tokens" name="output-tokens" class="form-input" placeholder="请输入输出令牌数" min="0" value="1000">
                                </div>
                                <button type="submit" class="btn">计算价格</button>
                            </div>
                        </form>
                        <div id="calculator-result" class="calculator-result" style="display: none;"></div>
                    </div>
                    

                    <div class="control-panel">
                        <div class="control-row">
                            <div class="form-group">
                                <label for="provider-filter" class="form-label">提供商</label>
                                <select id="provider-filter" class="form-select">
                                    <option value="">全部</option>
    
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="sort-by" class="form-label">排序</label>
                                <select id="sort-by" class="form-select">
                                    <option value="quality-desc">质量评分 (高→低)</option>
                                    <option value="quality-asc">质量评分 (低→高)</option>
                                    <option value="input-cost-asc">输入成本 (低→高)</option>
                                    <option value="input-cost-desc">输入成本 (高→低)</option>
                                    <option value="output-cost-asc">输出成本 (低→高)</option>
                                    <option value="output-cost-desc">输出成本 (高→低)</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="search" class="form-label">搜索</label>
                                <input type="text" id="search" class="form-input" placeholder="搜索模型名称或提供商">
                            </div>
                        </div>
                    </div>
                    

                    <div class="stats-section" id="stats-section">
                        <div class="stat-card">
                            <div class="stat-value" id="total-models">0</div>
                            <div class="stat-label">总模型数</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" id="total-providers">0</div>
                            <div class="stat-label">提供商数量</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" id="avg-quality">0</div>
                            <div class="stat-label">平均质量</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" id="cheapest-input">$0</div>
                            <div class="stat-label">最低输入成本</div>
                        </div>
                    </div>
                    

                    <div class="result-section" id="result-section">

                        <div class="loading" id="loading" style="display: none;">
                            正在加载AI模型数据...
                        </div>
                        

                        <div class="error-message" id="error-message" style="display: none;"></div>
                        

                        <div class="model-list" id="model-list"></div>
                        

                        <div class="pagination" id="pagination" style="display: none;">

                        </div>
                    </div>
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


        class AIModelPriceComparison {
            constructor() {
    
                this.loading = document.getElementById('loading');
                this.errorMessage = document.getElementById('error-message');
                this.modelList = document.getElementById('model-list');
                this.pagination = document.getElementById('pagination');
                this.providerFilter = document.getElementById('provider-filter');
                this.sortBy = document.getElementById('sort-by');
                this.search = document.getElementById('search');
                this.priceCalculator = document.getElementById('price-calculator');
                this.calculatorResult = document.getElementById('calculator-result');
                
    
                this.totalModels = document.getElementById('total-models');
                this.totalProviders = document.getElementById('total-providers');
                this.avgQuality = document.getElementById('avg-quality');
                this.cheapestInput = document.getElementById('cheapest-input');
                
    
                this.apiUrl = '../php/ai-model-price-proxy.php';
                
    
                this.allModels = [];
                this.filteredModels = [];
                this.currentPage = 1;
                this.pageSize = 10;
                this.providers = [];
                
    
                this.init();
            }
            

            init() {
    
                this.initEventListeners();
                
    
                this.loadModelData();
            }
            

            initEventListeners() {
    
                this.providerFilter.addEventListener('change', () => this.applyFilters());
                this.sortBy.addEventListener('change', () => this.applyFilters());
                this.search.addEventListener('input', () => this.applyFilters());
                
    
                this.priceCalculator.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.calculatePrice();
                });
            }
            

            async loadModelData() {
    
                this.showLoading();
                
    
                const startTime = Date.now();
                
                try {
        
                    const response = await fetch(this.apiUrl);
                    const data = await response.json();
                    
        
                    const responseTime = Date.now() - startTime;
                    
        
                    if (data.code !== 200) {
            
                        await recordToolUsage('ai-model-price', 'loadModelData', 0, responseTime, '获取模型数据');
                        throw new Error(data.msg || '获取数据失败');
                    }
                    
        
                    await recordToolUsage('ai-model-price', 'loadModelData', 1, responseTime, '获取模型数据');
                    
        
                    this.allModels = data.data;
                    this.filteredModels = [...this.allModels];
                    
        
                    this.processData();
                    
        
                    this.renderResults();
                } catch (error) {
                    console.error('加载数据失败:', error);
                    
        
                    const responseTime = Date.now() - startTime;
                    
        
                    await recordToolUsage('ai-model-price', 'loadModelData', 0, responseTime, '获取模型数据');
                    
                    this.showError(`加载数据失败: ${error.message}`);
                }
            }
            
    
            processData() {
    
                const providerSet = new Set();
                this.allModels.forEach(model => {
                    if (model.provider) {
                        providerSet.add(model.provider);
                    }
                });
                this.providers = Array.from(providerSet).sort();
                
    
                this.renderProviderFilter();
                
    
                this.updateStats();
            }
            

            renderProviderFilter() {
    
                this.providerFilter.innerHTML = '<option value="">全部</option>';
                
    
                this.providers.forEach(provider => {
                    const option = document.createElement('option');
                    option.value = provider;
                    option.textContent = provider;
                    this.providerFilter.appendChild(option);
                });
            }
            

            updateStats() {
    
                this.totalModels.textContent = this.allModels.length;
                
    
                this.totalProviders.textContent = this.providers.length;
                
    
                const qualitySum = this.allModels.reduce((sum, model) => {
                    return sum + (parseFloat(model.quality) || 0);
                }, 0);
                const avgQuality = this.allModels.length > 0 ? (qualitySum / this.allModels.length).toFixed(1) : 0;
                this.avgQuality.textContent = avgQuality;
                
    
                const cheapestModel = this.allModels.reduce((cheapest, model) => {
                    const inputCost = parseFloat(model.input_cost) || Infinity;
                    const cheapestCost = parseFloat(cheapest.input_cost) || Infinity;
                    return inputCost < cheapestCost ? model : cheapest;
                }, { input_cost: Infinity });
                this.cheapestInput.textContent = `$${cheapestModel.input_cost}`;
            }
            

            applyFilters() {
    
                const providerFilter = this.providerFilter.value;
                const sortBy = this.sortBy.value;
                const searchTerm = this.search.value.toLowerCase().trim();
                
    
                this.filteredModels = this.allModels.filter(model => {
        
                    if (providerFilter && model.provider !== providerFilter) {
                        return false;
                    }
                    
        
                    if (searchTerm) {
                        const modelName = model.name.toLowerCase() || '';
                        const providerName = model.provider.toLowerCase() || '';
                        return modelName.includes(searchTerm) || providerName.includes(searchTerm);
                    }
                    
                    return true;
                });
                
    
                this.sortModels(sortBy);
                
    
                this.currentPage = 1;
                
    
                this.renderResults();
            }
            

            sortModels(sortBy) {
                this.filteredModels.sort((a, b) => {
                    switch (sortBy) {
                        case 'quality-desc':
                            return (parseFloat(b.quality) || 0) - (parseFloat(a.quality) || 0);
                        case 'quality-asc':
                            return (parseFloat(a.quality) || 0) - (parseFloat(b.quality) || 0);
                        case 'input-cost-asc':
                            return (parseFloat(a.input_cost) || Infinity) - (parseFloat(b.input_cost) || Infinity);
                        case 'input-cost-desc':
                            return (parseFloat(b.input_cost) || Infinity) - (parseFloat(a.input_cost) || Infinity);
                        case 'output-cost-asc':
                            return (parseFloat(a.output_cost) || Infinity) - (parseFloat(b.output_cost) || Infinity);
                        case 'output-cost-desc':
                            return (parseFloat(b.output_cost) || Infinity) - (parseFloat(a.output_cost) || Infinity);
                        default:
                            return 0;
                    }
                });
            }
            

            renderResults() {
    
                this.hideLoading();
                
    
                const totalPages = Math.ceil(this.filteredModels.length / this.pageSize);
                const startIndex = (this.currentPage - 1) * this.pageSize;
                const endIndex = startIndex + this.pageSize;
                const currentModels = this.filteredModels.slice(startIndex, endIndex);
                
    
                this.renderModelList(currentModels);
                
    
                if (totalPages > 1) {
                    this.renderPagination(totalPages);
                } else {
                    this.pagination.style.display = 'none';
                }
            }
            

            renderModelList(models) {
                if (models.length === 0) {
                    this.modelList.innerHTML = '<div style="text-align: center; padding: 40px; color: #666;">没有找到匹配的模型</div>';
                    return;
                }
                
                const html = models.map(model => this.renderModelCard(model)).join('');
                this.modelList.innerHTML = html;
            }
            

            renderModelCard(model) {
    
                const quality = parseFloat(model.quality) || 0;
                
    
                const context = model.context || 'N/A';
                
    
                const inputCost = parseFloat(model.input_cost) || 0;
                const outputCost = parseFloat(model.output_cost) || 0;
                
    
                const knowledge = model.knowledge || 'N/A';
                
    
                const freeTrial = model.free_trial || '#';
                
                return `
                    <div class="model-card">
                        <div class="model-header">
                            <div>
                                <div class="model-title">
                                    ${model.name}
                                    <span class="model-provider">${model.provider}</span>
                                </div>
                            </div>
                            <div class="model-quality">
                                <span>${quality}</span>
                                <div class="quality-bar">
                                    <div class="quality-fill" style="width: ${quality}%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="model-info">
                            <div class="info-item">
                                <div class="info-label">上下文窗口</div>
                                <div class="info-value">${context}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">知识截止</div>
                                <div class="info-value">${knowledge}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">输入成本</div>
                                <div class="info-value">$${inputCost}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">输出成本</div>
                                <div class="info-value">$${outputCost}</div>
                            </div>
                        </div>
                        
                        <div class="model-actions">
                            <a href="${freeTrial}" target="_blank" class="btn btn-secondary">免费试用</a>
                            <button class="btn btn-secondary" onclick="copyModelInfo('${model.name}')">复制信息</button>
                        </div>
                    </div>
                `;
            }
            

            renderPagination(totalPages) {
                let paginationHTML = '';
                
    
                paginationHTML += `
                    <button class="pagination-btn" ${this.currentPage === 1 ? 'disabled' : ''} onclick="aiModelPriceComparison.goToPage(${this.currentPage - 1})">
                        上一页
                    </button>
                `;
                
    
                const maxVisiblePages = 5;
                let startPage = Math.max(1, this.currentPage - Math.floor(maxVisiblePages / 2));
                let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
                
                if (endPage - startPage + 1 < maxVisiblePages) {
                    startPage = Math.max(1, endPage - maxVisiblePages + 1);
                }
                
    
                if (startPage > 1) {
                    paginationHTML += `<button class="pagination-btn" onclick="aiModelPriceComparison.goToPage(1)">1</button>`;
                    if (startPage > 2) {
                        paginationHTML += `<span>...</span>`;
                    }
                }
                
    
                for (let i = startPage; i <= endPage; i++) {
                    paginationHTML += `
                        <button class="pagination-btn ${this.currentPage === i ? 'active' : ''}" onclick="aiModelPriceComparison.goToPage(${i})">
                            ${i}
                        </button>
                    `;
                }
                
    
                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        paginationHTML += `<span>...</span>`;
                    }
                    paginationHTML += `<button class="pagination-btn" onclick="aiModelPriceComparison.goToPage(${totalPages})">${totalPages}</button>`;
                }
                

                paginationHTML += `
                    <button class="pagination-btn" ${this.currentPage === totalPages ? 'disabled' : ''} onclick="aiModelPriceComparison.goToPage(${this.currentPage + 1})">
                        下一页
                    </button>
                `;
                
    
                paginationHTML += `
                    <div class="pagination-info">
                        第 ${this.currentPage} / ${totalPages} 页
                    </div>
                `;
                
                this.pagination.innerHTML = paginationHTML;
                this.pagination.style.display = 'flex';
            }
            

            goToPage(page) {
                this.currentPage = page;
                this.renderResults();
            }
            

            calculatePrice() {
    
                const inputTokens = parseInt(document.getElementById('input-tokens').value) || 0;
                const outputTokens = parseInt(document.getElementById('output-tokens').value) || 0;
                
    
                const inputCostPerToken = 0.001; 
                const outputCostPerToken = 0.001;
                
    
                const totalCost = (inputTokens * inputCostPerToken) + (outputTokens * outputCostPerToken);
                
    
                this.calculatorResult.innerHTML = `
                    输入令牌数: ${inputTokens}，输出令牌数: ${outputTokens}<br>
                    预估总成本: $${totalCost.toFixed(4)}
                `;
                this.calculatorResult.style.display = 'block';
            }
            

            showLoading() {
                this.loading.style.display = 'flex';
                this.errorMessage.style.display = 'none';
                this.modelList.innerHTML = '';
                this.pagination.style.display = 'none';
            }
            

            hideLoading() {
                this.loading.style.display = 'none';
            }
            

            showError(message) {
                this.loading.style.display = 'none';
                this.errorMessage.textContent = message;
                this.errorMessage.style.display = 'block';
                this.modelList.innerHTML = '';
                this.pagination.style.display = 'none';
            }
        }
        

        let aiModelPriceComparison;
        document.addEventListener('DOMContentLoaded', () => {
            aiModelPriceComparison = new AIModelPriceComparison();
        });
        

        function copyModelInfo(modelName) {
            const model = aiModelPriceComparison.allModels.find(m => m.name === modelName);
            if (model) {
                const modelInfo = `${model.name} (${model.provider})\n质量评分: ${model.quality}\n输入成本: $${model.input_cost}/千tokens\n输出成本: $${model.output_cost}/千tokens\n上下文窗口: ${model.context}\n知识截止: ${model.knowledge}`;
                
                navigator.clipboard.writeText(modelInfo).then(() => {
                    alert('模型信息已复制到剪贴板');
                }).catch(err => {
                    console.error('复制失败:', err);
                });
            }
        }
    </script>
</body>
</html>