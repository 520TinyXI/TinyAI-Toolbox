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
    <title>IP详情查询 - <?php echo $siteConfig['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 1000px;
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
        
        
        .query-section {
            margin-bottom: 30px;
        }
        
        .query-form {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            align-items: flex-end;
        }
        
        .form-group {
            flex: 1;
            min-width: 300px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.05);
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #1a1a1a;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        
        .results-section {
            margin-top: 30px;
            display: none;
        }
        
        .results-section.visible {
            display: block;
        }
        
        .results-header {
            margin-bottom: 20px;
        }
        
        .results-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .results-subtitle {
            font-size: 14px;
            color: #666;
        }
        
        
        .result-card {
            background-color: #fafafa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .result-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
        }
        
        .result-item {
            display: flex;
            flex-direction: column;
        }
        
        .result-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 4px;
        }
        
        .result-value {
            font-size: 16px;
            color: #1a1a1a;
            font-weight: 500;
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
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
        
        
        .empty-state {
            display: block;
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        
        .empty-state.hidden {
            display: none;
        }
        
        .empty-icon {
            font-size: 64px;
            margin-bottom: 16px;
        }
        
        
        @media (max-width: 768px) {
            .tool-container {
                padding: 20px 16px;
            }
            
            .tool-content {
                padding: 20px;
            }
            
            .query-form {
                flex-direction: column;
                align-items: stretch;
            }
            
            .form-group {
                min-width: auto;
            }
            
            .result-grid {
                grid-template-columns: 1fr;
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
                    <h2>IP详情查询</h2>
                    <p>查询IP的详细信息，包括归属地、运营商、ASN等</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">
                    
                    <div class="error-message" id="error-message"></div>
                    
                    
                    <div class="empty-state" id="empty-state">
                        <div class="empty-icon">🔍</div>
                        <div>请输入IP地址开始查询</div>
                    </div>
                    
                    
                    <div class="query-section">
                        <form class="query-form" id="query-form">
                            <div class="form-group">
                                <label class="form-label" for="ip">IP地址</label>
                                <input type="text" id="ip" class="form-input" placeholder="请输入IP地址（IPv4或IPv6），留空查询本机IP">
                            </div>
                            <button type="submit" class="btn" id="query-btn">
                                <span class="loading-icon" style="display: none;">🔄</span>
                                <span>查询详情</span>
                            </button>
                        </form>
                    </div>
                    
                    
                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div>正在查询IP详情，请稍候...</div>
                    </div>
                    
                    
                    <div class="results-section" id="results-section">
                        
                        <div class="results-header">
                            <h3 class="results-title">查询结果</h3>
                            <div class="results-subtitle" id="results-subtitle"></div>
                        </div>
                        
                        
                        <div class="result-card">
                            <div class="result-grid" id="result-grid"></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="../js/main.js"></script>
    
    <script>
        
        async function recordToolUsage(action, status = 'success', content = null, responseTime = null) {
            try {
                await fetch('../php/record-tool-usage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        tool_id: 'ip-details',
                        action: action,
                        content: content,
                        result: {
                            status: status
                        },
                        response_time: responseTime
                    })
                });
            } catch (error) {
                console.error('记录工具使用情况失败:', error);
            }
        }

        class IPDetailsSearch {
            constructor() {
                this.init();
            }
            
            init() {
                this.bindEvents();
            }
            
            bindEvents() {
                const queryForm = document.getElementById('query-form');
                queryForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.searchDetails();
                });
            }
            
            async searchDetails() {
                const ip = document.getElementById('ip').value.trim();
                
                this.showLoading();
                this.hideError();
                this.hideResults();
                this.hideEmptyState();
                this.disableQueryBtn();
                
                const startTime = Date.now();
                
                try {
                    
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 30000); 
                    
                    const response = await fetch(`../php/ip-details-proxy.php?ip=${encodeURIComponent(ip)}`, {
                        method: 'GET',
                        signal: controller.signal
                    });
                    
                    clearTimeout(timeoutId);
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    
                    console.log('API完整响应:', data);
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    if (data.code === 200) {
                        this.displayResults(data);
                        await recordToolUsage('search_details', 'success', { 
                            api_code: data.code, 
                            ip: data.ip 
                        }, responseTime);
                    } else {
                        
                        let errorMsg = data.msg || '查询失败';
                        this.showError(errorMsg);
                        await recordToolUsage('search_details', 'error', { 
                            api_code: data.code || 500, 
                            ip: data.ip, 
                            error_msg: data.msg || '未知错误' 
                        }, responseTime);
                    }
                } catch (error) {
                    const responseTime = (Date.now() - startTime) / 1000;
                    let errorMsg = `查询失败: ${error.message}`;
                    if (error.name === 'AbortError') {
                        errorMsg = '查询超时，请稍后重试';
                    }
                    this.showError(errorMsg);
                    console.error('API请求错误:', error);
                    await recordToolUsage('search_details', 'error', { 
                        exception: error.message,
                        ip: ip 
                    }, responseTime);
                } finally {
                    this.hideLoading();
                    this.enableQueryBtn();
                }
            }
            
            displayResults(data) {
                
                const resultsSection = document.getElementById('results-section');
                resultsSection.classList.add('visible');
                
                
                const resultsSubtitle = document.getElementById('results-subtitle');
                resultsSubtitle.textContent = `查询IP: ${data.ip}`;
                
                
                const resultData = data.data;
                
                
                const mapField = (fieldName, ...alternatives) => {
                    for (const alt of [fieldName, ...alternatives]) {
                        if (resultData.hasOwnProperty(alt) && resultData[alt] !== null && resultData[alt] !== '' && resultData[alt] !== 'null') {
                            return resultData[alt];
                        }
                    }
                    return '未知';
                };
                
                
                const getCoordinates = () => {
                    
                    const lat = mapField('latitude', 'lat', 'LAT', 'latitude_x', 'lat_x');
                    const lng = mapField('longitude', 'lng', 'lng', 'longitude_x', 'lng_x');
                    
                    if (lat !== '未知' && lng !== '未知' && lat !== '0.0' && lng !== '0.0') {
                        return `${lat}, ${lng}`;
                    }
                    return '未知';
                };
                
                
                const resultItems = [
                    { label: 'IP地址', value: data.ip },
                    { label: '归属地', value: mapField('location', 'address', 'addr', 'full_location', 'full_address') },
                    { label: '国家', value: mapField('country', 'nation', 'country_name', 'nation_name') },
                    { label: '省份', value: mapField('province', 'state', 'province_name', 'state_name') },
                    { label: '城市', value: mapField('city', 'city_name', 'city_x') },
                    { label: '区县', value: mapField('district', 'county', 'district_name', 'county_name') },
                    { label: '运营商', value: mapField('isp', 'operator', 'isp_name', 'operator_name') },
                    { label: 'ASN编号', value: mapField('asn', 'asn_number', 'as_number') },
                    { label: 'ASN组织', value: mapField('as_org', 'asn_org', 'as_organization', 'as_name') },
                    { label: 'IP类型', value: mapField('type', 'ip_type', 'type_name') },
                    { label: '邮政编码', value: mapField('zipcode', 'postal_code', 'zip', 'postcode') },
                    { label: '时区', value: mapField('timezone', 'time_zone', 'tz') },
                    { label: '经纬度', value: getCoordinates() }
                ];
                
                
                const additionalFields = {
                    'continent': '大洲',
                    'continent_code': '大洲代码',
                    'country_code': '国家代码',
                    'province_code': '省份代码',
                    'city_code': '城市代码',
                    'isp_code': '运营商代码',
                    'ip_version': 'IP版本',
                    'is_private': '是否私有IP',
                    'is_reserved': '是否保留IP',
                    'is_anonymous': '是否匿名IP',
                    'accuracy_radius': '精度半径',
                    'isp_org': 'ISP组织',
                    'organization': '组织',
                    'latitude': '纬度',
                    'longitude': '经度'
                };
                
                
                for (const [field, label] of Object.entries(additionalFields)) {
                    const value = resultData[field];
                    if (value !== undefined && value !== null && value !== '' && value !== 'null' && value !== '未知') {
                        resultItems.push({ label: label, value: value });
                    }
                }
                
                
                const resultGrid = document.getElementById('result-grid');
                resultGrid.innerHTML = resultItems.map(item => `
                    <div class="result-item">
                        <span class="result-label">${item.label}</span>
                        <span class="result-value">${item.value}</span>
                    </div>
                `).join('');
            }
            
            showLoading() {
                document.getElementById('loading').classList.add('visible');
            }
            
            hideLoading() {
                document.getElementById('loading').classList.remove('visible');
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
            
            showResults() {
                document.getElementById('results-section').classList.add('visible');
            }
            
            hideResults() {
                document.getElementById('results-section').classList.remove('visible');
            }
            
            showEmptyState() {
                document.getElementById('empty-state').classList.remove('hidden');
            }
            
            hideEmptyState() {
                document.getElementById('empty-state').classList.add('hidden');
            }
            
            disableQueryBtn() {
                const queryBtn = document.getElementById('query-btn');
                queryBtn.disabled = true;
                queryBtn.querySelector('.loading-icon').style.display = 'inline-block';
                queryBtn.querySelector('span:last-child').textContent = '查询中...';
            }
            
            enableQueryBtn() {
                const queryBtn = document.getElementById('query-btn');
                queryBtn.disabled = false;
                queryBtn.querySelector('.loading-icon').style.display = 'none';
                queryBtn.querySelector('span:last-child').textContent = '查询详情';
            }
        }
        
        
        document.addEventListener('DOMContentLoaded', () => {
            new IPDetailsSearch();
        });
    </script>
</body>
</html>