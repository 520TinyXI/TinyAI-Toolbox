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
    <title>壁纸大全 - <?php echo $siteConfig['name']; ?></title>
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
        

        .control-panel {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .type-selector {
            display: flex;
            background-color: #f5f5f5;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .type-btn {
            padding: 10px 20px;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            color: #666;
            transition: all 0.3s ease;
            border-radius: 4px;
        }
        
        .type-btn.active {
            background-color: #1a1a1a;
            color: #fff;
        }
        
        .category-selector {
            position: relative;
        }
        
        #category {
            padding: 10px 40px 10px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            background-color: #fff;
            cursor: pointer;
        }
        
        .load-more-btn {
            background-color: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 30px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .load-more-btn:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .load-more-btn:active {
            transform: translateY(0);
        }
        
        .load-more-btn:disabled {
            background-color: #666;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }
        
        .gallery-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }
        
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            overflow: auto;
        }
        
        .modal.active {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            max-width: 90%;
            max-height: 90%;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        .close-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 30px;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
            transition: color 0.3s ease;
            z-index: 1001;
        }
        
        .close-btn:hover {
            color: #ccc;
        }
        

        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .loading.active {
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
            background-color: #fff5f5;
            border: 1px solid #ffcccc;
            border-radius: 8px;
            padding: 16px;
            color: #d32f2f;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .error-message.active {
            display: block;
        }
        

        .refresh-btn {
            background-color: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .refresh-btn:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .refresh-btn:active {
            transform: translateY(0);
        }
        

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }
        
        .page-btn {
            padding: 10px 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #666;
            background-color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .page-btn:hover:not(:disabled) {
            background-color: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
        }
        
        .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .page-info {
            font-size: 14px;
            color: #666;
            font-weight: 500;
        }
        

        @media (max-width: 768px) {
            .tool-container {
                padding: 20px 16px;
            }
            
            .gallery {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 15px;
            }
            
            .gallery-item img {
                height: 200px;
            }
            
            .control-panel {
                flex-direction: column;
                align-items: stretch;
            }
            
            .type-selector {
                justify-content: space-between;
            }
            
            .type-btn {
                flex: 1;
                text-align: center;
            }
            
            .pagination {
                gap: 15px;
            }
            
            .page-btn {
                padding: 8px 15px;
                font-size: 13px;
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
                    <h2>壁纸大全</h2>
                    <p>获取各种类型的壁纸图片</p>
                </div>
            </header>


            <div class="tool-container">
    
                <div class="tool-content">

                    <div class="error-message" id="error-message"></div>
                    

                    <div class="control-panel">
                        <div class="type-selector">
                            <button class="type-btn active" data-type="sfw">SFW</button>
                            <button class="type-btn" data-type="cartoon">动漫</button>
                        </div>
                        
                        <div class="category-selector">
                            <select id="category">

                            </select>
                        </div>
                        
                        <button class="refresh-btn" id="refresh-btn">
                            刷新数据
                        </button>
                    </div>
                    

                    <div class="loading" id="loading">
                        <div class="loading-spinner"></div>
                        <div class="loading-text">正在加载图片...</div>
                    </div>
                    

                    <div class="gallery" id="gallery"></div>
                    

                    <div class="pagination" id="pagination">
                        <button class="page-btn" id="prev-page" disabled>上一页</button>
                        <div class="page-info" id="page-info">第 1 页</div>
                        <button class="page-btn" id="next-page">下一页</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    

    <div class="modal" id="image-modal">
        <span class="close-btn">&times;</span>
        <img class="modal-content" id="modal-image">
    </div>
    
    <script src="../js/main.js"></script>
    
    <script>
        class WallpaperGallery {
            constructor() {
                this.currentType = 'sfw';
                this.allImages = [];
                this.currentPage = 1;
                this.imagesPerPage = 20;
                this.isLoading = false;
                this.hasMore = true;
                this.totalImages = 0;
                
    
                this.categories = {
                    sfw: {
                        'awoo': '嚎叫',
                        'bite': '咬',
                        'blush': '脸红',
                        'bonk': '敲头',
                        'bully': '欺负',
                        'cringe': '尴尬',
                        'cry': '哭泣',
                        'cuddle': '依偎',
                        'dance': '跳舞',
                        'glomp': '亲昵地抱',
                        'handhold': '牵手',
                        'happy': '开心',
                        'highfive': '击掌',
                        'hug': '拥抱',
                        'kick': '踢',
                        'kill': '杀死',
                        'kiss': '亲吻',
                        'lick': '舔舐',
                        'megumin': '爆裂魔女',
                        'nom': '啃咬',
                        'pat': '轻拍',
                        'poke': '戳',
                        'shinobu': '忍冬',
                        'slap': '拍打',
                        'smile': '微笑',
                        'smug': '得意',
                        'wave': '挥手',
                        'wink': '眨眼',
                        'yeet': '扔'
                    },
                    cartoon: {
                        'cartoon': '动漫壁纸'
                    }
                };
                
    
                this.currentCategory = Object.keys(this.categories[this.currentType])[0];
                
                this.init();
            }
            
            init() {
                this.bindEvents();
                this.generateCategoryOptions();
                this.loadImages();
            }
            
            bindEvents() {

                document.querySelectorAll('.type-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        this.setType(e.target.dataset.type);
                    });
                });
                

                document.getElementById('category').addEventListener('change', (e) => {
                    this.setCategory(e.target.value);
                });
                

                document.getElementById('prev-page').addEventListener('click', () => {
                    this.prevPage();
                });
                
                document.getElementById('next-page').addEventListener('click', () => {
                    this.nextPage();
                });
                

                document.getElementById('refresh-btn').addEventListener('click', () => {
                    this.refreshData();
                });
                

                const modal = document.getElementById('image-modal');
                const closeBtn = document.querySelector('.close-btn');
                
                closeBtn.addEventListener('click', () => {
                    modal.classList.remove('active');
                });
                
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        modal.classList.remove('active');
                    }
                });
            }
            
            generateCategoryOptions() {
                const select = document.getElementById('category');
                select.innerHTML = '';
                

                const categoryMap = this.categories[this.currentType];
                

                for (const [key, value] of Object.entries(categoryMap)) {
                    const option = document.createElement('option');
                    option.value = key;
                    option.textContent = value;
                    if (key === this.currentCategory) {
                        option.selected = true;
                    }
                    select.appendChild(option);
                }
            }
            
            setType(type) {
                this.currentType = type;

                const categoryKeys = Object.keys(this.categories[type]);
                this.currentCategory = categoryKeys[0];
                

                this.allImages = [];
                this.currentPage = 1;
                this.hasMore = true;
                this.totalImages = 0;
                

                document.querySelectorAll('.type-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                document.querySelector(`[data-type="${type}"]`).classList.add('active');
                

                this.generateCategoryOptions();
                

                this.loadImages();
            }
            
            setCategory(category) {
                this.currentCategory = category;
                

                this.allImages = [];
                this.currentPage = 1;
                this.hasMore = true;
                this.totalImages = 0;
                

                this.loadImages();
            }
            
            async loadImages() {
                if (this.isLoading) return;
                
                this.isLoading = true;
                this.showLoading();
                this.hideError();
                
                try {
    
                    const cacheKey = `wallpaper_${this.currentType}_${this.currentCategory}`;
                    
    
                    const cachedData = localStorage.getItem(cacheKey);
                    if (cachedData) {
                        console.log('从本地存储加载数据:', cacheKey);
                        const parsedData = JSON.parse(cachedData);
                        this.allImages = parsedData;
                        this.totalImages = this.allImages.length;
                        this.updateGallery();
                        this.updatePagination();
                        this.isLoading = false;
                        this.hideLoading();
                        return;
                    }
                    

                    let jsonFileUrl;
                    let data;
                    
                    if (this.currentType === 'cartoon') {

                        jsonFileUrl = './壁纸资源/动漫/wallpaper_data.json';
                        console.log('请求的JSON文件URL:', window.location.href, '→', jsonFileUrl);
                        
                        const response = await fetch(jsonFileUrl, {
                            method: 'GET',
                            timeout: 10000
                        });
                        
                        if (!response.ok) {
                            console.error('加载失败! 状态码:', response.status, 'URL:', response.url);
                            throw new Error(`加载JSON文件失败! 状态码: ${response.status}, URL: ${response.url}`);
                        }
                        
                        data = await response.json();
                        

                        this.allImages = data.map(item => item.url);
                    } else {

                        jsonFileUrl = `./壁纸资源/${this.currentType}/${this.currentCategory}/${this.currentCategory}_links.txt`;
                        console.log('请求的JSON文件URL:', window.location.href, '→', jsonFileUrl);
                        
                        const response = await fetch(jsonFileUrl, {
                            method: 'GET',
                            timeout: 10000
                        });
                        
                        if (!response.ok) {
                            console.error('加载失败! 状态码:', response.status, 'URL:', response.url);
                            throw new Error(`加载JSON文件失败! 状态码: ${response.status}, URL: ${response.url}`);
                        }
                        
                        data = await response.json();
                        

                        this.allImages = data.links;
                    }
                    
                    this.totalImages = this.allImages.length;
                    

                    const cacheData = JSON.stringify(this.allImages);
                    localStorage.setItem(cacheKey, cacheData);
                    console.log('数据已保存到本地存储:', cacheKey);
                    

                    this.updateGallery();

                    this.updatePagination();
                } catch (error) {
                    this.showError(`加载图片失败: ${error.message}`);
                    console.error('加载错误:', error);
                } finally {
                    this.isLoading = false;
                    this.hideLoading();
                }
            }
            
            updateGallery() {
                const gallery = document.getElementById('gallery');
                gallery.innerHTML = '';
                

                const startIndex = (this.currentPage - 1) * this.imagesPerPage;
                const endIndex = startIndex + this.imagesPerPage;
                const currentImages = this.allImages.slice(startIndex, endIndex);
                

                currentImages.forEach(imageUrl => {
                    const galleryItem = document.createElement('div');
                    galleryItem.className = 'gallery-item';
                    
                    const img = document.createElement('img');
                    img.src = imageUrl;
                    img.alt = '壁纸图片';
                    
    
                    img.addEventListener('click', () => {
                        this.showImageModal(imageUrl);
                    });
                    
                    galleryItem.appendChild(img);
                    gallery.appendChild(galleryItem);
                });
                

                this.preloadNextPage();
            }
            

            preloadNextPage() {
                const nextStartIndex = this.currentPage * this.imagesPerPage;
                const nextEndIndex = nextStartIndex + this.imagesPerPage;
                const nextImages = this.allImages.slice(nextStartIndex, nextEndIndex);
                
                if (nextImages.length > 0) {
    
                    nextImages.forEach(imageUrl => {
                        const preloadImg = new Image();
                        preloadImg.src = imageUrl;
        
                    });
                    console.log('预加载下一页图片:', nextImages.length, '张');
                }
            }
            
            showImageModal(imageUrl) {
                const modal = document.getElementById('image-modal');
                const modalImage = document.getElementById('modal-image');
                
                modalImage.src = imageUrl;
                modal.classList.add('active');
            }
            
            showLoading() {
                document.getElementById('loading').classList.add('active');
            }
            
            hideLoading() {
                document.getElementById('loading').classList.remove('active');
            }
            
            showError(message) {
                const errorElement = document.getElementById('error-message');
                errorElement.textContent = message;
                errorElement.classList.add('active');
            }
            
            hideError() {
                document.getElementById('error-message').classList.remove('active');
            }
            

            prevPage() {
                if (this.currentPage > 1) {
                    this.currentPage--;
                    this.updateGallery();
                    this.updatePagination();
                }
            }
            

            nextPage() {
                const totalPages = Math.ceil(this.allImages.length / this.imagesPerPage);
                if (this.currentPage < totalPages) {
                    this.currentPage++;
                    this.updateGallery();
                    this.updatePagination();
                }
            }
            

            updatePagination() {
                const totalPages = Math.ceil(this.allImages.length / this.imagesPerPage);
                const prevBtn = document.getElementById('prev-page');
                const nextBtn = document.getElementById('next-page');
                const pageInfo = document.getElementById('page-info');
                

                pageInfo.textContent = `第 ${this.currentPage} 页 / 共 ${totalPages} 页`;
                

                prevBtn.disabled = this.currentPage === 1;
                nextBtn.disabled = this.currentPage >= totalPages;
            }
            

            refreshData() {

                const cacheKey = `wallpaper_${this.currentType}_${this.currentCategory}`;
                

                localStorage.removeItem(cacheKey);
                console.log('清除本地缓存:', cacheKey);
                

                this.loadImages();
            }
        }
        

        document.addEventListener('DOMContentLoaded', () => {
            new WallpaperGallery();
        });
    </script>
</body>
</html>