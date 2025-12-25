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
    <title>快看漫画搜索API - <?php echo $siteConfig['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .tool-container {
            max-width: 1200px;
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
        
        .search-section {
            margin-bottom: 30px;
        }
        
        .search-form {
            display: flex;
            gap: 16px;
            margin-bottom: 16px;
        }
        
        .search-input {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.05);
        }
        
        .search-btn {
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
        
        .search-btn:hover:not(:disabled) {
            background-color: #333;
        }
        
        .search-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .results-section {
            margin-top: 30px;
        }
        
        .results-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .comic-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        
        .comic-card {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .comic-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .comic-cover {
            width: 100%;
            height: 240px;
            object-fit: cover;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .comic-info {
            padding: 16px;
        }
        
        .comic-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
            line-height: 1.4;
        }
        
        .comic-author {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }
        
        .comic-category {
            font-size: 13px;
            color: #888;
            margin-bottom: 8px;
        }
        
        .comic-latest {
            font-size: 13px;
            color: #ef4444;
            font-weight: 500;
        }
        
        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #666;
            background-color: #fafafa;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        
        .error-message {
            background-color: #fee2e2;
            color: #ef4444;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }
        
        @media (max-width: 768px) {
            .tool-container {
                padding: 20px 16px;
            }
            
            .tool-content {
                padding: 20px;
            }
            
            .search-form {
                flex-direction: column;
            }
            
            .search-btn {
                width: 100%;
            }
            
            .comic-list {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 16px;
            }
            
            .comic-cover {
                height: 160px;
            }
            
            .comic-info {
                padding: 12px;
            }
            
            .comic-title {
                font-size: 14px;
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
                    <h2>快看漫画搜索API</h2>
                    <p>搜索快看漫画的所有数据源，返回完整漫画信息</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">
                    <div class="error-message" id="error-message"></div>
                    
                    <div class="search-section">
                        <form id="search-form" class="search-form">
                            <input type="text" id="search" name="search" class="search-input" placeholder="请输入漫画名称进行搜索" required>
                            <button type="submit" class="search-btn" id="search-btn">
                                <span class="loading" id="loading" style="display: none;"></span>
                                <span id="search-text">搜索</span>
                            </button>
                        </form>
                    </div>
                    
                    <div class="results-section" id="results-section">
                        <h3 class="results-title" id="results-title">搜索结果</h3>
                        <div class="comic-list" id="comic-list"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        async function recordToolUsage(toolId, action, statusValue, responseTime = 0, content = '') {
            try {
                const status = statusValue === 1 ? 'success' : 'error';
                
                const responseTimeSeconds = responseTime / 1000;
                
                const contentObj = {
                    action: action
                };
                
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

        class KuaikanManhua {
            constructor() {
                this.searchForm = document.getElementById('search-form');
                this.searchInput = document.getElementById('search');
                this.searchBtn = document.getElementById('search-btn');
                this.searchText = document.getElementById('search-text');
                this.loading = document.getElementById('loading');
                this.errorMessage = document.getElementById('error-message');
                this.resultsSection = document.getElementById('results-section');
                this.resultsTitle = document.getElementById('results-title');
                this.comicList = document.getElementById('comic-list');
                
                this.apiUrl = '../php/kkmh-proxy.php';
                
                this.init();
            }
            
            init() {
                this.initEventListeners();
            }
            
            initEventListeners() {
                this.searchForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.searchComics();
                });
            }
            
            showError(message) {
                this.errorMessage.textContent = message;
                this.errorMessage.style.display = 'block';
                
                setTimeout(() => {
                    this.errorMessage.style.display = 'none';
                }, 5000);
            }
            
            hideError() {
                this.errorMessage.style.display = 'none';
            }
            
            async searchComics() {
                const search = this.searchInput.value.trim();
                
                if (!search) {
                    return;
                }
                
                this.hideError();
                
                this.searchText.style.display = 'none';
                this.loading.style.display = 'inline-block';
                this.searchBtn.disabled = true;
                
                const startTime = Date.now();
                
                try {
                    const params = new URLSearchParams();
                    params.append('search', search);
                    params.append('type', 'json');
                    
                    const requestUrl = `${this.apiUrl}?${params.toString()}`;
                    
                    const response = await fetch(requestUrl, {
                        method: 'GET'
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    const responseTime = Date.now() - startTime;
                    
                    if (data.success === true && data.data && Array.isArray(data.data)) {
                        await recordToolUsage('kkmh', 'searchComics', 1, responseTime, search);
                        this.renderResults(data.data, search);
                    } else {
                        await recordToolUsage('kkmh', 'searchComics', 0, responseTime, search);
                        this.renderNoResults(search);
                    }
                } catch (error) {
                    console.error('搜索失败:', error);
                    
                    const responseTime = Date.now() - startTime;
                    
                    await recordToolUsage('kkmh', 'searchComics', 0, responseTime, search);
                    
                    this.showError(`搜索失败: ${error.message}`);
                    this.renderNoResults(this.searchInput.value);
                } finally {
                    this.searchText.style.display = 'inline';
                    this.loading.style.display = 'none';
                    this.searchBtn.disabled = false;
                }
            }
            
            renderResults(comics, search) {
                this.resultsTitle.textContent = `搜索结果 (${comics.length} 条)`;
                
                const html = comics.map(comic => {
                    return `
                        <div class="comic-card" onclick="window.open('${comic.url}', '_blank')">
                            <img class="comic-cover" src="${comic.cover_image_url || comic.vertical_image_url}" alt="${comic.title}">
                            <div class="comic-info">
                                <div class="comic-title">${comic.title}</div>
                                <div class="comic-author">作者：${comic.author}</div>
                                <div class="comic-latest">最新章节：${comic.latest_comic_title || '暂无更新'}</div>
                            </div>
                        </div>
                    `;
                }).join('');
                
                this.comicList.innerHTML = html;
                this.resultsSection.style.display = 'block';
            }
            
            renderNoResults(search) {
                this.resultsTitle.textContent = `搜索 "${search}" 无结果`;
                this.comicList.innerHTML = `
                    <div class="no-results">
                        <p>未找到相关漫画，请尝试其他关键词</p>
                    </div>
                `;
                this.resultsSection.style.display = 'block';
            }
        }
        
        let kuaikanManhua;
        document.addEventListener('DOMContentLoaded', () => {
            kuaikanManhua = new KuaikanManhua();
        });
    </script>
</body>
</html>