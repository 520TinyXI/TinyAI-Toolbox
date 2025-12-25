<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>王者荣耀战力查询 - 工具箱</title>
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
        

        .input-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .input-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
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
        
        .input-field input,
        .input-field select {
            flex: 1;
            padding: 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            background-color: #fafafa;
        }
        
        .input-field input:focus,
        .input-field select:focus {
            outline: none;
            border-color: #1a1a1a;
            background-color: #fff;
        }
        

        .right-sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: 300px;
            height: 100vh;
            background-color: #fff;
            border-left: 1px solid #e0e0e0;
            box-shadow: -2px 0 8px rgba(0, 0, 0, 0.05);
            transform: translateX(100%);
            transition: transform 0.3s ease;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        .right-sidebar.open {
            transform: translateX(0);
        }
        

        .toggle-btn {
            position: fixed;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            background-color: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 8px 0 0 8px;
            padding: 12px 8px;
            cursor: pointer;
            z-index: 1001;
            writing-mode: vertical-rl;
            text-orientation: mixed;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .toggle-btn:hover {
            background-color: #333;
            padding: 12px 12px;
        }
        

        .hero-selector {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 20px;
            overflow: hidden;
        }
        
        .selector-header {
            margin-bottom: 20px;
        }
        
        .hero-search {
            margin-bottom: 16px;
        }
        
        .hero-search input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
        }
        
        .hero-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        
        .hero-item {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            height: 70px;
            border: 2px solid #e0e0e0;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #fff;
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            text-align: center;
            line-height: 1.2;
            padding: 8px;
            box-sizing: border-box;
        }
        
        .hero-item:hover {
            border-color: #1a1a1a;
            background-color: #f0f0f0;
            transform: scale(1.1);
        }
        
        .hero-item.selected {
            border-color: #1a1a1a;
            background-color: #1a1a1a;
            color: #fff;
        }
        

        .tool-container {
            transition: all 0.3s ease;
        }
        

        @media (max-width: 768px) {
            .input-row {
                grid-template-columns: 1fr;
            }
            
            .hero-item {
                width: 60px;
                height: 60px;
                font-size: 12px;
            }
            
            .right-sidebar {
                width: 100%;
            }
        }
        

        .query-section {
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
            margin-bottom: 20px;
        }
        
        .hero-info {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .hero-photo {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            object-fit: cover;
        }
        
        .hero-details {
            flex: 1;
        }
        
        .hero-name {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 4px;
        }
        
        .hero-alias {
            font-size: 16px;
            color: #666;
            margin-bottom: 8px;
        }
        
        .hero-platform {
            font-size: 14px;
            color: #999;
        }
        

        .power-pyramid {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 30px;
        }
        
        .pyramid-level {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        

        .level-nation {
            border-left: 4px solid #ffd700;
            margin-left: 0;
        }
        
        .level-province {
            border-left: 4px solid #c0c0c0;
            margin-left: 20px;
        }
        
        .level-city {
            border-left: 4px solid #cd7f32;
            margin-left: 40px;
        }
        
        .level-area {
            border-left: 4px solid #964b00;
            margin-left: 60px;
        }
        
        .power-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .power-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .power-region {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            background-color: #f0f0f0;
            padding: 4px 12px;
            border-radius: 4px;
        }
        
        .power-value {
            font-size: 36px;
            font-weight: 700;
            color: #1a1a1a;
            text-align: center;
            margin-top: 8px;
        }
        

        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        

        .error {
            padding: 16px;
            background-color: #fff3f3;
            border: 1px solid #ffe0e0;
            border-radius: 8px;
            color: #d63031;
            text-align: center;
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
            
            .hero-info {
                flex-direction: column;
                text-align: center;
            }
            
            .power-list {
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
                    <h2>王者荣耀战力查询</h2>
                    <p>查询王者荣耀英雄在不同系统的战力数据</p>
                </div>
            </header>
            
            <div class="tool-container">
                
                <div class="tool-content">

                    <div class="input-section">

                        <div class="input-row">

                            <div class="input-group">
                                <label class="input-label">英雄名称</label>
                                <div class="input-field">
                                    <input type="text" id="hero" placeholder="请输入英雄名称，如：孙悟空" required>
                                </div>
                            </div>
                            

                            <div class="input-group">
                                <label class="input-label">选择系统</label>
                                <div class="input-field">
                                    <select id="type" required>
                                        <option value="">请选择系统</option>
                                        <option value="aqq">安卓-QQ区</option>
                                        <option value="awx">安卓-微信区</option>
                                        <option value="iqq">iOS-QQ区</option>
                                        <option value="iwx">iOS-微信区</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="query-section">
                        <button class="btn btn-primary" id="query-btn">查询战力</button>
                    </div>
                    

                    <div class="result-section">
                        <div id="result-container" style="display: none;">

                            <div class="result-card">
                                <div class="hero-info">
                                    <img id="hero-photo" class="hero-photo" src="" alt="英雄头像">
                                    <div class="hero-details">
                                        <div class="hero-name" id="hero-name"></div>
                                        <div class="hero-alias" id="hero-alias"></div>
                                        <div class="hero-platform" id="hero-platform"></div>
                                    </div>
                                </div>
                                

                                <div class="power-pyramid">

                                    <div class="pyramid-level level-nation">
                                        <div class="power-header">
                                            <div class="power-title">全国战力</div>
                                        </div>
                                        <div class="power-value" id="guobiao"></div>
                                    </div>
                                    

                                    <div class="pyramid-level level-province">
                                        <div class="power-header">
                                            <div class="power-title">省标</div>
                                            <div class="power-region" id="province-region">台湾省</div>
                                        </div>
                                        <div class="power-value" id="province"></div>
                                    </div>
                                    

                                    <div class="pyramid-level level-city">
                                        <div class="power-header">
                                            <div class="power-title">市标</div>
                                            <div class="power-region" id="city-region">葫芦岛市</div>
                                        </div>
                                        <div class="power-value" id="city"></div>
                                    </div>
                                    

                                    <div class="pyramid-level level-area">
                                        <div class="power-header">
                                            <div class="power-title">区标</div>
                                            <div class="power-region" id="area-region">南芬区</div>
                                        </div>
                                        <div class="power-value" id="area"></div>
                                    </div>
                                </div>
                                

                                <div style="text-align: center; margin-top: 20px; font-size: 14px; color: #999;">
                                    更新时间：<span id="update-time"></span>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div id="loading" class="loading" style="display: none;">
                            正在查询数据，请稍候...
                        </div>
                        
                        
                        <div id="error" class="error" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    

    <div class="right-sidebar" id="right-sidebar">
        <div class="hero-selector">
            <div class="selector-header">
                <h3>选择英雄</h3>
            </div>
            <div class="hero-search">
                <input type="text" id="hero-search" placeholder="搜索英雄，如：孙悟空">
            </div>
            <div class="hero-list" id="hero-list">

            </div>
        </div>
    </div>
    

    <button class="toggle-btn" id="toggle-btn">选择英雄</button>
    
    <script>
        function recordToolUsage(action, status = 'success', content = null, responseTime = null) {
            fetch('../php/record-tool-usage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tool_id: 'wzry',
                    action: action,
                    content: content,
                    result: {
                        status: status
                    },
                    response_time: responseTime
                })
            }).catch(error => {
                console.error('记录使用量失败:', error);
            });
        }

        class WZRYPowerQuery {
            constructor() {
                this.heroInput = document.getElementById('hero');
                this.typeSelect = document.getElementById('type');
                this.queryBtn = document.getElementById('query-btn');
                this.resultContainer = document.getElementById('result-container');
                this.loading = document.getElementById('loading');
                this.error = document.getElementById('error');
                
                this.rightSidebar = document.getElementById('right-sidebar');
                this.toggleBtn = document.getElementById('toggle-btn');
                
                this.heroSearch = document.getElementById('hero-search');
                this.heroList = document.getElementById('hero-list');
                
                this.toolContainer = document.querySelector('.tool-container');
                
                this.heroPhoto = document.getElementById('hero-photo');
                this.heroName = document.getElementById('hero-name');
                this.heroAlias = document.getElementById('hero-alias');
                this.heroPlatform = document.getElementById('hero-platform');
                
                this.guobiao = document.getElementById('guobiao');
                this.province = document.getElementById('province');
                this.city = document.getElementById('city');
                this.area = document.getElementById('area');
                
                this.provinceRegion = document.getElementById('province-region');
                this.cityRegion = document.getElementById('city-region');
                this.areaRegion = document.getElementById('area-region');
                
                this.updateTime = document.getElementById('update-time');
                
                this.apiUrl = 'https://www.sapi.run/hero/select.php';
                
                this.heroes = [
                    {"ename": 105, "cname": "廉颇"},
                    {"ename": 106, "cname": "小乔"},
                    {"ename": 107, "cname": "赵云"},
                    {"ename": 108, "cname": "墨子"},
                    {"ename": 109, "cname": "妲己"},
                    {"ename": 110, "cname": "嬴政"},
                    {"ename": 111, "cname": "孙尚香"},
                    {"ename": 112, "cname": "鲁班七号"},
                    {"ename": 113, "cname": "庄周"},
                    {"ename": 114, "cname": "刘禅"},
                    {"ename": 115, "cname": "高渐离"},
                    {"ename": 116, "cname": "阿轲"},
                    {"ename": 117, "cname": "钟无艳"},
                    {"ename": 118, "cname": "孙膑"},
                    {"ename": 119, "cname": "扁鹊"},
                    {"ename": 120, "cname": "白起"},
                    {"ename": 121, "cname": "芈月"},
                    {"ename": 123, "cname": "吕布"},
                    {"ename": 124, "cname": "周瑜"},
                    {"ename": 126, "cname": "夏侯惇"},
                    {"ename": 127, "cname": "甄姬"},
                    {"ename": 128, "cname": "曹操"},
                    {"ename": 129, "cname": "典韦"},
                    {"ename": 130, "cname": "宫本武藏"},
                    {"ename": 131, "cname": "李白"},
                    {"ename": 132, "cname": "马可波罗"},
                    {"ename": 133, "cname": "狄仁杰"},
                    {"ename": 134, "cname": "达摩"},
                    {"ename": 135, "cname": "项羽"},
                    {"ename": 136, "cname": "武则天"},
                    {"ename": 139, "cname": "老夫子"},
                    {"ename": 140, "cname": "关羽"},
                    {"ename": 141, "cname": "貂蝉"},
                    {"ename": 142, "cname": "安琪拉"},
                    {"ename": 144, "cname": "程咬金"},
                    {"ename": 146, "cname": "露娜"},
                    {"ename": 148, "cname": "姜子牙"},
                    {"ename": 149, "cname": "刘邦"},
                    {"ename": 150, "cname": "韩信"},
                    {"ename": 152, "cname": "王昭君"},
                    {"ename": 153, "cname": "兰陵王"},
                    {"ename": 154, "cname": "花木兰"},
                    {"ename": 156, "cname": "张良"},
                    {"ename": 157, "cname": "不知火舞"},
                    {"ename": 162, "cname": "娜可露露"},
                    {"ename": 163, "cname": "橘右京"},
                    {"ename": 166, "cname": "亚瑟"},
                    {"ename": 167, "cname": "孙悟空"},
                    {"ename": 168, "cname": "牛魔"},
                    {"ename": 169, "cname": "后羿"},
                    {"ename": 170, "cname": "刘备"},
                    {"ename": 171, "cname": "张飞"},
                    {"ename": 173, "cname": "李元芳"},
                    {"ename": 174, "cname": "虞姬"},
                    {"ename": 175, "cname": "钟馗"},
                    {"ename": 178, "cname": "杨戬"},
                    {"ename": 183, "cname": "雅典娜"},
                    {"ename": 184, "cname": "蔡文姬"},
                    {"ename": 186, "cname": "太乙真人"},
                    {"ename": 180, "cname": "哪吒"},
                    {"ename": 190, "cname": "诸葛亮"},
                    {"ename": 192, "cname": "黄忠"},
                    {"ename": 191, "cname": "大乔"},
                    {"ename": 187, "cname": "东皇太一"},
                    {"ename": 182, "cname": "干将莫邪"},
                    {"ename": 189, "cname": "鬼谷子"},
                    {"ename": 193, "cname": "铠"},
                    {"ename": 196, "cname": "百里守约"},
                    {"ename": 195, "cname": "百里玄策"},
                    {"ename": 194, "cname": "苏烈"},
                    {"ename": 198, "cname": "梦奇"},
                    {"ename": 179, "cname": "女娲"},
                    {"ename": 501, "cname": "明世隐"},
                    {"ename": 199, "cname": "公孙离"},
                    {"ename": 176, "cname": "杨玉环"},
                    {"ename": 502, "cname": "裴擒虎"},
                    {"ename": 197, "cname": "弈星"},
                    {"ename": 503, "cname": "狂铁"},
                    {"ename": 504, "cname": "米莱狄"},
                    {"ename": 125, "cname": "元歌"},
                    {"ename": 510, "cname": "孙策"},
                    {"ename": 137, "cname": "司马懿"},
                    {"ename": 509, "cname": "盾山"},
                    {"ename": 508, "cname": "伽罗"},
                    {"ename": 312, "cname": "沈梦溪"},
                    {"ename": 507, "cname": "李信"},
                    {"ename": 513, "cname": "上官婉儿"},
                    {"ename": 515, "cname": "嫦娥"},
                    {"ename": 511, "cname": "猪八戒"},
                    {"ename": 529, "cname": "盘古"},
                    {"ename": 505, "cname": "瑶"},
                    {"ename": 506, "cname": "云中君"},
                    {"ename": 522, "cname": "曜"},
                    {"ename": 518, "cname": "马超"},
                    {"ename": 523, "cname": "西施"},
                    {"ename": 525, "cname": "鲁班大师"},
                    {"ename": 524, "cname": "蒙犽"},
                    {"ename": 531, "cname": "镜"},
                    {"ename": 527, "cname": "蒙恬"},
                    {"ename": 533, "cname": "阿古朵"},
                    {"ename": 536, "cname": "夏洛特"},
                    {"ename": 528, "cname": "澜"},
                    {"ename": 537, "cname": "司空震"},
                    {"ename": 155, "cname": "艾琳"},
                    {"ename": 538, "cname": "云缨"},
                    {"ename": 540, "cname": "金蝉"},
                    {"ename": 542, "cname": "暃"},
                    {"ename": 534, "cname": "桑启"},
                    {"ename": 548, "cname": "戈娅"},
                    {"ename": 521, "cname": "海月"},
                    {"ename": 544, "cname": "赵怀真"},
                    {"ename": 545, "cname": "莱西奥"},
                    {"ename": 564, "cname": "姬小满"},
                    {"ename": 514, "cname": "亚连"},
                    {"ename": 159, "cname": "朵莉亚"},
                    {"ename": 563, "cname": "海诺"},
                    {"ename": 519, "cname": "敖隐"},
                    {"ename": 517, "cname": "大司命"}
                ];
                
                this.apiUrl = 'https://www.sapi.run/hero/select.php';
                
                this.init();
            }
            
            init() {
                this.initEventListeners();
                
                this.generateHeroList();
            }
            
            initEventListeners() {
                this.queryBtn.addEventListener('click', () => {
                    this.query();
                });
                
                this.heroInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        this.query();
                    }
                });
                
                this.typeSelect.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        this.query();
                    }
                });
                
                this.heroSearch.addEventListener('input', () => {
                    this.filterHeroes();
                });
                
                this.toggleBtn.addEventListener('click', () => {
                    this.toggleSidebar();
                });
            }
            
            toggleSidebar() {
                this.rightSidebar.classList.toggle('open');
                this.toggleBtn.textContent = this.rightSidebar.classList.contains('open') ? '关闭面板' : '选择英雄';
            }
            
            generateHeroList(heroes = null) {
                const heroData = heroes || this.heroes;
                this.heroList.innerHTML = '';
                
                heroData.forEach(hero => {
                    const heroItem = document.createElement('div');
                    heroItem.className = 'hero-item';
                    heroItem.textContent = hero.cname;
                    heroItem.dataset.heroName = hero.cname;
                    
                    heroItem.addEventListener('click', () => {
                        this.selectHero(heroItem);
                    });
                    
                    this.heroList.appendChild(heroItem);
                });
            }
            
            filterHeroes() {
                const searchTerm = this.heroSearch.value.toLowerCase();
                const filteredHeroes = this.heroes.filter(hero => {
                    return hero.cname.toLowerCase().includes(searchTerm);
                });
                this.generateHeroList(filteredHeroes);
            }
            
            selectHero(heroItem) {
                document.querySelectorAll('.hero-item').forEach(item => {
                    item.classList.remove('selected');
                });
                
                heroItem.classList.add('selected');
                
                const heroName = heroItem.dataset.heroName;
                this.heroInput.value = heroName;
                
                this.query();
            }
            
            async query() {
                const hero = this.heroInput.value.trim();
                const type = this.typeSelect.value;
                
                if (!hero) {
                    this.showError('Please enter hero name');
                    return;
                }
                
                if (!type) {
                    this.showError('Please select query system');
                    return;
                }
                
                this.showLoading();
                
                const startTime = Date.now();
                
                try {
                    const response = await fetch(`${this.apiUrl}?hero=${encodeURIComponent(hero)}&type=${type}`);
                    const data = await response.json();
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    console.log('API Response:', data);
                    
                    if (data.code === 200 && data.data) {
                        this.showResult(data.data);
                        recordToolUsage('power_query', 'success', {
                            hero: hero,
                            type: type,
                            api_code: data.code
                        }, responseTime);
                    } else {
                        this.showError(data.msg || 'Query failed, please try again later');
                        recordToolUsage('power_query', 'error', {
                            hero: hero,
                            type: type,
                            api_code: data.code || 500,
                            error_msg: data.msg || 'Query failed'
                        }, responseTime);
                    }
                } catch (error) {
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    this.showError('Network error, please check your connection and try again');
                    console.error('API Request Error:', error);
                    recordToolUsage('power_query', 'error', {
                        hero: hero,
                        type: type,
                        error_msg: 'Network error',
                        exception: error.message
                    }, responseTime);
                }
            }
            
            showLoading() {
                this.resultContainer.style.display = 'none';
                this.error.style.display = 'none';
                this.loading.style.display = 'block';
            }
            
            showResult(data) {
                this.heroPhoto.src = data.photo;
                this.heroName.textContent = data.name;
                this.heroAlias.textContent = `(${data.alias})`;
                this.heroPlatform.textContent = data.platform;
                
                this.guobiao.textContent = data.guobiao;
                this.province.textContent = data.provincePower;
                this.city.textContent = data.cityPower;
                this.area.textContent = data.areaPower;
                
                this.provinceRegion.textContent = data.province || '台湾省';
                this.cityRegion.textContent = data.city || '葫芦岛市';
                this.areaRegion.textContent = data.area || '南芬区';
                
                this.updateTime.textContent = data.updatetime;
                
                this.loading.style.display = 'none';
                this.error.style.display = 'none';
                this.resultContainer.style.display = 'block';
            }
            
            showError(message) {
                this.error.textContent = message;
                this.loading.style.display = 'none';
                this.resultContainer.style.display = 'none';
                this.error.style.display = 'block';
            }
        }
        

        const wzryPowerQuery = new WZRYPowerQuery();
    </script>
</body>
</html>