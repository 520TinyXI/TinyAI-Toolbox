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
    <title>TINY音乐 - <?php echo $siteConfig['name']; ?></title>
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
        
        .query-section {
            background-color: #fafafa;
            padding: 24px;
            border-radius: 8px;
            margin-bottom: 24px;
            border: 1px solid #e0e0e0;
        }
        
        .form-row {
            display: flex;
            gap: 16px;
            align-items: flex-end;
            flex-wrap: wrap;
        }
        
        .form-group {
            flex: 1;
            min-width: 300px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            box-sizing: border-box;
            height: 48px;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 2px rgba(26, 26, 26, 0.1);
        }
        
        .btn {
            padding: 12px 24px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #fafafa;
            color: #1a1a1a;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 48px;
            box-sizing: border-box;
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
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .result-section {
            margin-bottom: 30px;
        }
        
        .result-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .music-list {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .music-item {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid #e0e0e0;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .music-item:hover {
            background-color: #fafafa;
            transform: translateX(4px);
        }
        
        .music-item:last-child {
            border-bottom: none;
        }
        
        .music-info {
            flex: 1;
            min-width: 0;
        }
        
        .music-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .music-artist {
            font-size: 14px;
            color: #666;
            margin-bottom: 2px;
        }
        
        .music-album {
            font-size: 12px;
            color: #999;
        }
        
        .music-actions {
            display: flex;
            gap: 8px;
        }
        
        .play-btn {
            padding: 8px 16px;
            background-color: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 600;
        }
        
        .play-btn:hover {
            background-color: #333;
        }
        
        .player-section {
            position: fixed;
            bottom: 40px;
            right: 20px;
            width: 350px;
            background: rgba(26, 26, 46, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            color: #fff;
            overflow: hidden;
            z-index: 1000;
            display: none;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .player-content {
            padding: 15px 20px;
        }
        
        .player-info-mini {
            margin-bottom: 10px;
        }
        
        .player-title {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .player-info {
            font-size: 12px;
            color: #b0b0b0;
            margin: 0;
        }
        
        .progress-section {
            margin-bottom: 20px;
        }
        
        .progress-container {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .progress-bar {
            flex: 1;
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
            cursor: pointer;
            overflow: hidden;
            position: relative;
        }
        
        .progress-filled {
            height: 100%;
            background: linear-gradient(90deg, #4CAF50, #2196F3);
            border-radius: 3px;
            transition: width 0.1s linear;
            width: 0%;
        }
        
        .time-display {
            font-size: 12px;
            color: #b0b0b0;
            min-width: 45px;
            text-align: center;
        }
        
        .player-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .control-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #fff;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        
        .control-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }
        
        .control-btn.play-pause {
            width: 64px;
            height: 64px;
            font-size: 24px;
            background: linear-gradient(135deg, #4CAF50, #2196F3);
        }
        
        .loading-container {
            text-align: center;
            padding: 40px 0;
            color: #666;
        }
        
        .loading {
            display: inline-block;
            width: 30px;
            height: 30px;
            border: 3px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top-color: #1a1a1a;
            animation: spin 1s ease-in-out infinite;
            margin-bottom: 16px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .error-container {
            background-color: #fff3f3;
            border: 1px solid #ffe0e0;
            border-radius: 8px;
            padding: 20px;
            color: #d63031;
            margin-bottom: 30px;
            display: none;
        }
        
        .platform-selector {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 8px;
        }
        
        .platform-option {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        }
        
        .platform-option:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
        }
        
        .platform-option input[type="radio"] {
            display: none;
        }
        
        .platform-option input[type="radio"]:checked + span {
            color: #1a1a1a;
            font-weight: 600;
        }
        
        .platform-option input[type="radio"]:checked + span::before {
            content: "✓ ";
            color: #4CAF50;
            font-weight: bold;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
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
            
            .form-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .form-group {
                min-width: auto;
            }
        }
        
        @media (max-width: 400px) {
            .player-section {
                width: 300px;
            }
        }
        
        .player-header, .player-body, .player-footer, .lyrics-container, .lyrics-scroll, .lyrics-content, .album-cover {
            display: none !important;
        }
        
        .player-content {
            padding: 15px 20px !important;
            display: block !important;
        }
        
        .player-info-mini {
            margin-bottom: 10px !important;
        }
        
        .progress-section {
            margin-bottom: 12px !important;
        }
        
        .progress-container {
            gap: 8px !important;
        }
        
        .time-display {
            font-size: 10px !important;
            min-width: 35px !important;
        }
        
        .progress-bar {
            height: 4px !important;
            border-radius: 2px !important;
        }
        
        .progress-filled {
            border-radius: 2px !important;
        }
        
        .player-controls {
            gap: 8px !important;
            justify-content: space-between !important;
        }
        
        .control-btn {
            width: 32px !important;
            height: 32px !important;
            font-size: 14px !important;
        }
        
        .control-btn.play-pause {
            width: 40px !important;
            height: 40px !important;
            font-size: 16px !important;
        }
        
        .volume-control {
            display: flex;
            align-items: center;
            gap: 6px;
            flex: 1;
            justify-content: flex-end;
        }
        
        .volume-btn {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }
        
        .volume-bar {
            width: 60px;
            height: 3px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            cursor: pointer;
            overflow: hidden;
            display: block;
        }
        
        .volume-filled {
            height: 100%;
            background: linear-gradient(90deg, #4CAF50, #2196F3);
            border-radius: 2px;
            transition: width 0.1s ease;
            display: block;
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
                    <h2>TINY音乐</h2>
                    <p>搜索和播放你喜爱的音乐</p>
                </div>
            </header>
            
            <div class="tool-container">
                <div class="tool-content">
                    <div class="error-container" id="error-container">
                        <div class="error-message" id="error-message">搜索失败，请稍后重试</div>
                    </div>
                    
                    <div class="query-section">
                        <form id="search-form">
                            <div class="form-row" style="margin-bottom: 16px;">
                                <div class="form-group" style="flex: 1;">
                                    <label class="form-label">选择平台</label>
                                    <div class="platform-selector" style="display: flex; align-items: center;">
                                        <label class="platform-option">
                                            <input type="radio" name="platform" value="wy" checked>
                                            <span>网易云音乐</span>
                                        </label>
                                        <label class="platform-option">
                                            <input type="radio" name="platform" value="qq">
                                            <span>QQ音乐</span>
                                        </label>
                                        <label class="platform-option">
                                            <input type="radio" name="platform" value="kw">
                                            <span>酷我音乐</span>
                                        </label>
                                        <label class="platform-option">
                                            <input type="radio" name="platform" value="mg">
                                            <span>酷狗音乐</span>
                                        </label>
                                        <label class="platform-option">
                                            <input type="radio" name="platform" value="mgyy">
                                            <span>咪咕音乐</span>
                                        </label>
                                    </div>
                                </div>
                                <div style="display: flex; align-items: flex-end; margin-left: 16px;">
                                    <button class="btn" id="hot-search-btn" style="margin-bottom: 20px;">热搜榜</button>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="keyword" class="form-label">搜索关键词</label>
                                    <input type="text" id="keyword" name="keyword" class="form-input" placeholder="请输入歌曲名、歌手或专辑名" value="周杰伦" required>
                                </div>
                                <button type="submit" class="btn btn-primary" id="search-btn">
                                    <span class="loading-icon" style="display: none;">🔄</span>
                                    搜索歌曲
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="result-section" id="result-section" style="display: none;">
                        <h3 class="result-title">搜索结果</h3>
                        
                        <div class="loading-container" id="loading-container" style="display: none;">
                            <div class="loading"></div>
                            <p>正在搜索音乐，请稍候...</p>
                        </div>
                        
                        <div class="empty-state" id="empty-state" style="display: none;">
                            <div class="empty-icon">🎵</div>
                            <div>暂无搜索结果</div>
                            <div style="margin-top: 12px; font-size: 14px;">请尝试其他搜索关键词</div>
                        </div>
                        
                        <div class="music-list" id="music-list"></div>
                    </div>
                    
                    <div class="singer-info-section" id="singer-info-section" style="display: none; position: fixed; right: 20px; top: 50%; transform: translateY(-50%); width: 300px; height: 600px; background-color: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); border: 1px solid #e0e0e0; padding: 20px; z-index: 999; overflow-y: auto;">
                        <h3 class="singer-info-title" style="margin-top: 0; margin-bottom: 16px; font-size: 18px; font-weight: 600; color: #1a1a1a;">歌手信息</h3>
                        
                        <div class="singer-info-content" id="singer-info-content">
                            <div class="singer-info-loading" id="singer-info-loading" style="display: none; text-align: center; color: #666; padding: 40px 0;">
                                <div class="loading"></div>
                                <p>正在加载歌手信息...</p>
                            </div>
                            
                            <div class="singer-info-empty" id="singer-info-empty" style="display: block; text-align: center; color: #999; padding: 40px 0;">
                                <div style="font-size: 48px; margin-bottom: 16px;">🎤</div>
                                <div>暂无歌手信息</div>
                                <div style="margin-top: 8px; font-size: 14px;">播放歌曲查看歌手详情</div>
                            </div>
                            
                            <div class="singer-info-details" id="singer-info-details" style="display: none;">
                                <div class="singer-info-image" style="text-align: center; margin-bottom: 16px;">
                                    <img id="singer-image" src="" alt="歌手图片" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 3px solid #f0f0f0;">
                                </div>
                                <div class="singer-info-name" id="singer-name" style="font-size: 20px; font-weight: 600; color: #1a1a1a; text-align: center; margin-bottom: 12px;"></div>
                                <div class="singer-info-profile" id="singer-profile" style="font-size: 14px; color: #666; line-height: 1.6; text-align: justify;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="player-section" id="player-section">
                        <div class="player-content">
                            <div class="player-info-mini">
                                <div class="player-title" id="player-title">暂无播放</div>
                                <div class="player-info" id="player-info">请选择一首歌曲播放</div>
                            </div>
                            
                            <div class="progress-section">
                                <div class="progress-container">
                                    <div class="time-display" id="current-time">00:00</div>
                                    <div class="progress-bar" id="progress-bar">
                                        <div class="progress-filled" id="progress-filled"></div>
                                    </div>
                                    <div class="time-display" id="duration">00:00</div>
                                </div>
                            </div>
                            
                            <div class="player-controls">
                                <button class="control-btn" id="prev-btn" disabled>
                                    ⏮️
                                </button>
                                <button class="control-btn" id="repeat-btn">🔁</button>
                                <button class="control-btn play-pause" id="play-pause-btn" disabled>
                                    ▶️
                                </button>
                                <button class="control-btn" id="next-btn" disabled>
                                    ⏭️
                                </button>
                                <div class="volume-control">
                                    <button class="control-btn volume-btn" id="volume-btn">🔊</button>
                                    <div class="volume-bar" id="volume-bar">
                                        <div class="volume-filled" id="volume-filled"></div>
                                    </div>
                                </div>
                            </div>
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

        class TinyMusic {
            constructor() {
                this.proxyApi = '../php/tiny-music-proxy.php';
                
                this.searchForm = document.getElementById('search-form');
                this.keywordInput = document.getElementById('keyword');
                this.platformRadios = document.querySelectorAll('input[name="platform"]');
                this.hotSearchBtn = document.getElementById('hot-search-btn');
                this.searchBtn = document.getElementById('search-btn');
                this.loadingIcon = this.searchBtn.querySelector('.loading-icon');
                this.resultSection = document.getElementById('result-section');
                this.loadingContainer = document.getElementById('loading-container');
                this.emptyState = document.getElementById('empty-state');
                this.musicList = document.getElementById('music-list');
                this.errorContainer = document.getElementById('error-container');
                this.errorMessage = document.getElementById('error-message');
                
                this.singerInfoSection = document.getElementById('singer-info-section');
                this.singerInfoContent = document.getElementById('singer-info-content');
                this.singerInfoLoading = document.getElementById('singer-info-loading');
                this.singerInfoEmpty = document.getElementById('singer-info-empty');
                this.singerInfoDetails = document.getElementById('singer-info-details');
                this.singerImage = document.getElementById('singer-image');
                this.singerName = document.getElementById('singer-name');
                this.singerProfile = document.getElementById('singer-profile');
                
                this.playerSection = document.getElementById('player-section');
                this.playerTitle = document.getElementById('player-title');
                this.playerInfo = document.getElementById('player-info');
                this.currentTime = document.getElementById('current-time');
                this.duration = document.getElementById('duration');
                this.progressBar = document.getElementById('progress-bar');
                this.progressFilled = document.getElementById('progress-filled');
                this.playPauseBtn = document.getElementById('play-pause-btn');
                this.prevBtn = document.getElementById('prev-btn');
                this.nextBtn = document.getElementById('next-btn');
                this.repeatBtn = document.getElementById('repeat-btn');
                this.volumeBtn = document.getElementById('volume-btn');
                this.volumeBar = document.getElementById('volume-bar');
                this.volumeFilled = document.getElementById('volume-filled');
                
                this.audio = new Audio();
                this.isPlaying = false;
                this.currentIndex = -1;
                this.musicDataList = [];
                this.currentMusic = null;
                this.repeatMode = 'none';
                this.volume = 1.0;
                this.isMuted = false;
                
                this.init();
            }
            
            init() {
                this.bindEvents();
                this.audio.volume = this.volume;
                this.volumeFilled.style.width = `${this.volume * 100}%`;
                this.searchMusic('周杰伦');
            }
            
            bindEvents() {
                this.searchForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const keyword = this.keywordInput.value.trim();
                    if (keyword) {
                        this.searchMusic(keyword);
                    }
                });
                
                this.platformRadios.forEach(radio => {
                    radio.addEventListener('change', () => {
                        const keyword = this.keywordInput.value.trim();
                        if (keyword) {
                            this.searchMusic(keyword);
                        }
                    });
                });
                
                this.hotSearchBtn.addEventListener('click', () => {
                    this.showHotSearchList();
                });
                
                this.audio.addEventListener('timeupdate', () => {
                    this.updateProgress();
                });
                
                this.audio.addEventListener('loadedmetadata', () => {
                    this.updateDuration();
                });
                
                this.audio.addEventListener('ended', () => {
                    this.handleEnded();
                });
                
                this.progressBar.addEventListener('click', (e) => {
                    this.seek(e);
                });
                
                this.playPauseBtn.addEventListener('click', () => {
                    this.togglePlayPause();
                });
                
                this.prevBtn.addEventListener('click', () => {
                    this.playPrev();
                });
                
                this.nextBtn.addEventListener('click', () => {
                    this.playNext();
                });
                
                this.repeatBtn.addEventListener('click', () => {
                    this.toggleRepeat();
                });
                
                this.volumeBtn.addEventListener('click', () => {
                    this.toggleMute();
                });
                
                this.volumeBar.addEventListener('click', (e) => {
                    this.setVolume(e);
                });
            }
            
            async searchMusic(keyword) {
                this.showLoading();
                
                const startTime = Date.now();
                
                try {
                    console.log('开始搜索音乐:', keyword);
                    
                    const platform = this.getSelectedPlatform();
                    console.log('用户选择的平台:', platform);
                    
                    const musicList = await this.getMusicList(keyword, platform);
                    console.log('获取到的音乐列表:', musicList);
                    
                    const responseTime = Date.now() - startTime;
                    
                    await recordToolUsage('tiny-music', 'searchMusic', 1, responseTime, keyword);
                    
                    if (musicList && musicList.length > 0) {
                        this.musicDataList = musicList;
                        this.renderMusicList();
                    } else {
                        console.log('未获取到音乐列表，显示空状态');
                        this.showEmptyState();
                    }
                } catch (error) {
                    console.error('搜索音乐失败:', error);
                    

                    const responseTime = Date.now() - startTime;
                    

                    await recordToolUsage('tiny-music', 'searchMusic', 0, responseTime, keyword);
                    
                    this.showError(`搜索失败：${error.message}`);
                } finally {
                    this.hideLoading();
                }
            }
            
            getSelectedPlatform() {
                for (const radio of this.platformRadios) {
                    if (radio.checked) {
                        return radio.value;
                    }
                }
                return 'wy';
            }
            
            async showHotSearchList() {
                this.showLoading();
                
                const startTime = Date.now();
                
                try {
                    console.log('开始获取热搜榜');
                    
                    const platform = this.getSelectedPlatform();
                    console.log('用户选择的平台:', platform);
                    
                    const hotSearchList = await this.getHotSearchList(platform);
                    console.log('获取到的热搜榜数据:', hotSearchList);
                    
                    const responseTime = Date.now() - startTime;
                    
                    await recordToolUsage('tiny-music', 'getHotSearchList', 1, responseTime, platform);
                    
                    if (hotSearchList && hotSearchList.length > 0) {
                        this.musicDataList = hotSearchList;
                        this.renderMusicList();
                    } else {
                        console.log('未获取到热搜榜数据，显示空状态');
                        this.showEmptyState();
                    }
                } catch (error) {
                    console.error('获取热搜榜失败:', error);
                    

                    const responseTime = Date.now() - startTime;
                    

                    await recordToolUsage('tiny-music', 'getHotSearchList', 0, responseTime, platform);
                    
                    this.showError(`获取热搜榜失败：${error.message}`);
                } finally {
                    this.hideLoading();
                }
            }
            
            async getHotSearchList(platform) {
                const params = new URLSearchParams();
                params.append('action', 'getHotSearch');
                params.append('type', platform);
                params.append('num', '99');
                
                const requestUrl = `${this.proxyApi}?${params.toString()}`;
                console.log('请求热搜榜代理API:', requestUrl);
                
                try {
                    const response = await fetch(requestUrl);
                    console.log('热搜榜代理API响应状态:', response.status);
                    
                    const responseText = await response.text();
                    console.log('热搜榜代理API响应内容:', responseText);
                    
                    const data = JSON.parse(responseText);
                    console.log('解析后的热搜榜代理API响应:', data);
                    
                    if (data && data.code === 200) {
                        return data.data || [];
                    } else {
                        console.error('热搜榜代理API返回错误:', data);
                        throw new Error(data.msg || '获取热搜榜失败');
                    }
                } catch (error) {
                    console.error('获取热搜榜失败:', error);
                    throw error;
                }
            }
            
            async getMusicList(keyword, platform, num = 99) {
                const startTime = Date.now();
                
                const params = new URLSearchParams();
                params.append('action', 'getMusicId');
                params.append('keyword', keyword);
                params.append('type', platform);
                params.append('num', num);
                
                const requestUrl = `${this.proxyApi}?${params.toString()}`;
                console.log('请求音乐列表代理API:', requestUrl);
                
                try {
                    const response = await fetch(requestUrl);
                    console.log('音乐列表代理API响应状态:', response.status);
                    
                    const responseText = await response.text();
                    console.log('音乐列表代理API响应内容:', responseText);
                    
                    const data = JSON.parse(responseText);
                    console.log('解析后的音乐列表代理API响应:', data);
                    
                    if (data && data.code === 200) {
                        const responseTime = Date.now() - startTime;
                        
                        await recordToolUsage('tiny-music', 'getMusicList', 1, responseTime, keyword);
                        
                        return data.data || [];
                    } else {
                        console.error('音乐列表代理API返回错误:', data);
                        
                        const responseTime = Date.now() - startTime;
                        
                        await recordToolUsage('tiny-music', 'getMusicList', 0, responseTime, keyword);
                        
                        throw new Error(data.msg || '获取音乐列表失败');
                    }
                } catch (error) {
                    console.error('获取音乐列表失败:', error);
                    

                    const responseTime = Date.now() - startTime;
                    

                    await recordToolUsage('tiny-music', 'getMusicList', 0, responseTime, keyword);
                    
                    throw error;
                }
            }
            
            async searchMusicDetail(id, type = 'qq') {
                const startTime = Date.now();
                
                const params = new URLSearchParams();
                params.append('action', 'searchMusic');
                params.append('id', id);
                params.append('type', type);
                
                const requestUrl = `${this.proxyApi}?${params.toString()}`;
                console.log('请求音乐详情代理API:', requestUrl);
                
                try {
                    const response = await fetch(requestUrl);
                    console.log('音乐详情代理API响应状态:', response.status);
                    
                    const responseText = await response.text();
                    console.log('音乐详情代理API响应内容:', responseText);
                    
                    const data = JSON.parse(responseText);
                    console.log('解析后的音乐详情代理API响应:', data);
                    
                    if (data && data.code === 200) {
                        const responseTime = Date.now() - startTime;
                        
                        await recordToolUsage('tiny-music', 'searchMusicDetail', 1, responseTime, id);
                        
                        const musicData = data.data;
                        return {
                            id: id,
                            title: musicData.title || '未知歌曲',
                            singer: musicData.singer || '未知歌手',
                            album: musicData.album || '未知专辑',
                            cover: musicData.cover || 'https://via.placeholder.com/200',
                            url: musicData.url || '',
                            lrc: musicData.lrc || ''
                        };
                    } else {
                        console.log('音乐详情代理API返回错误:', data);
                        

                        const responseTime = Date.now() - startTime;
                        

                        await recordToolUsage('tiny-music', 'searchMusicDetail', 0, responseTime, id);
                        
                        throw new Error(data.msg || '获取音乐详情失败');
                    }
                } catch (error) {
                    console.error('获取音乐详情失败:', error);
                    

                    const responseTime = Date.now() - startTime;
                    

                    await recordToolUsage('tiny-music', 'searchMusicDetail', 0, responseTime, id);
                    
                    throw error;
                }
            }
            
            renderMusicList() {
                if (this.musicDataList.length === 0) {
                    this.showEmptyState();
                    return;
                }
                
                this.emptyState.style.display = 'none';
                
                const html = this.musicDataList.map((music, index) => {
                    return `
                        <div class="music-item" data-index="${index}">
                            <div class="music-info">
                                <div class="music-title">${music.title}</div>
                                <div class="music-artist">${music.singer}</div>
                                <div class="music-album">${music.album}</div>
                            </div>
                            <div class="music-actions">
                                <button class="play-btn" onclick="tinyMusic.playMusic(${index})">播放</button>
                            </div>
                        </div>
                    `;
                }).join('');
                
                this.musicList.innerHTML = html;
            }
            
            async playMusic(index) {
                if (index < 0 || index >= this.musicDataList.length) return;
                
                this.currentIndex = index;
                const basicMusicInfo = this.musicDataList[index];
                
                this.updatePlayerInfo(basicMusicInfo);
                
                this.getSingerInfo(basicMusicInfo.singer);
                
                try {
                    const musicDetail = await this.searchMusicDetail(basicMusicInfo.id, basicMusicInfo.type);
                    console.log('获取到的完整音乐详情:', musicDetail);
                    
                    this.currentMusic = musicDetail;
                    
                    console.log('准备播放音乐，URL:', this.currentMusic.url);
                    console.log('音乐URL类型:', typeof this.currentMusic.url);
                    console.log('音乐URL长度:', this.currentMusic.url.length);
                    
                    if (!this.currentMusic.url || typeof this.currentMusic.url !== 'string' || this.currentMusic.url.length === 0) {
                        throw new Error('无效的音频URL');
                    }
                    
                    const cleanUrl = this.currentMusic.url.trim();
                    console.log('清理后的音频URL:', cleanUrl);
                    
                    this.audio.src = cleanUrl;
                    await this.audio.play();
                    this.isPlaying = true;
                    this.updatePlayButton();
                    
                    this.playPauseBtn.disabled = false;
                    this.prevBtn.disabled = false;
                    this.nextBtn.disabled = false;
                } catch (error) {
                    console.error('播放音乐失败:', error);
                    this.showError(`播放失败：${error.message}`);
                }
            }
            
            updatePlayerInfo(music = null) {
                const musicInfo = music || this.currentMusic;
                if (!musicInfo) return;
                
                this.playerSection.style.display = 'block';
                
                this.playerTitle.textContent = musicInfo.title;
                this.playerInfo.textContent = `${musicInfo.singer} - ${musicInfo.album}`;
            }
            
            handleEnded() {
                switch (this.repeatMode) {
                    case 'one':
                        this.audio.currentTime = 0;
                        this.audio.play();
                        break;
                    case 'all':
                        this.playNext();
                        break;
                    default:
                        this.isPlaying = false;
                        this.updatePlayButton();
                        break;
                }
            }
            
            toggleRepeat() {
                const repeatBtn = this.repeatBtn;
                
                switch (this.repeatMode) {
                    case 'none':
                        this.repeatMode = 'one';
                        repeatBtn.innerHTML = '🔂';
                        repeatBtn.style.background = 'rgba(76, 175, 80, 0.6)';
                        break;
                    case 'one':
                        this.repeatMode = 'all';
                        repeatBtn.innerHTML = '🔁';
                        repeatBtn.style.background = 'rgba(33, 150, 243, 0.6)';
                        break;
                    case 'all':
                        this.repeatMode = 'none';
                        repeatBtn.innerHTML = '🔁';
                        repeatBtn.style.background = 'rgba(255, 255, 255, 0.1)';
                        break;
                }
            }
            
            toggleMute() {
                this.isMuted = !this.isMuted;
                this.audio.muted = this.isMuted;
                
                const volumeBtn = this.volumeBtn;
                volumeBtn.innerHTML = this.isMuted ? '🔇' : '🔊';
            }
            
            setVolume(e) {
                const volumeBar = this.volumeBar;
                const rect = volumeBar.getBoundingClientRect();
                this.volume = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
                
                this.audio.volume = this.volume;
                this.isMuted = this.volume === 0;
                
                this.volumeFilled.style.width = `${this.volume * 100}%`;
                const volumeBtn = this.volumeBtn;
                volumeBtn.innerHTML = this.isMuted ? '🔇' : '🔊';
            }
            
            updateProgress() {
                if (!this.audio.duration) return;
                
                const progress = (this.audio.currentTime / this.audio.duration) * 100;
                this.progressFilled.style.width = `${progress}%`;
                
                this.currentTime.textContent = this.formatTime(this.audio.currentTime);
            }
            
            updateDuration() {
                this.duration.textContent = this.formatTime(this.audio.duration);
            }
            
            formatTime(seconds) {
                if (isNaN(seconds)) return '00:00';
                const mins = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60);
                return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            }
            
            seek(e) {
                const rect = this.progressBar.getBoundingClientRect();
                const percent = (e.clientX - rect.left) / rect.width;
                this.audio.currentTime = percent * this.audio.duration;
            }
            
            togglePlayPause() {
                if (!this.currentMusic) return;
                
                if (this.isPlaying) {
                    this.audio.pause();
                } else {
                    this.audio.play();
                }
                
                this.isPlaying = !this.isPlaying;
                this.updatePlayButton();
            }
            
            updatePlayButton() {
                this.playPauseBtn.innerHTML = this.isPlaying ? '⏸️' : '▶️';
            }
            
            playPrev() {
                if (this.musicDataList.length === 0) return;
                
                this.currentIndex = (this.currentIndex - 1 + this.musicDataList.length) % this.musicDataList.length;
                this.playMusic(this.currentIndex);
            }
            
            playNext() {
                if (this.musicDataList.length === 0) return;
                
                this.currentIndex = (this.currentIndex + 1) % this.musicDataList.length;
                this.playMusic(this.currentIndex);
            }
            

            async getSingerInfo(singerName) {
                if (!singerName) return;
                

                this.singerInfoSection.style.display = 'block';
                this.singerInfoLoading.style.display = 'block';
                this.singerInfoEmpty.style.display = 'none';
                this.singerInfoDetails.style.display = 'none';
                
                try {
    
                    const singerNames = singerName.split('/').map(name => name.trim()).filter(name => name);
                    
                    if (singerNames.length === 0) {

                        this.singerInfoLoading.style.display = 'none';
                        this.singerInfoEmpty.style.display = 'block';
                        return;
                    }
                    

                    const singerInfos = await Promise.all(
                        singerNames.map(async name => {
    
                            const startTime = Date.now();
                            
                            const params = new URLSearchParams();
                            params.append('action', 'getSingerInfo');
                            params.append('singerName', name);
                            
                            const requestUrl = `${this.proxyApi}?${params.toString()}`;
                            console.log('请求歌手信息代理API:', requestUrl);
                            
                            try {
                                const response = await fetch(requestUrl);
                                console.log('歌手信息代理API响应状态:', response.status);
                                
                                const responseText = await response.text();
                                console.log('歌手信息代理API响应内容:', responseText);
                                
                                const data = JSON.parse(responseText);
                                console.log('解析后的歌手信息代理API响应:', data);
                                

                                const responseTime = Date.now() - startTime;
                                
                                if (data && data.code === 200) {
    
                                    await recordToolUsage('tiny-music', 'getSingerInfo', 1, responseTime, name);
                                    return data.data;
                                } else {
                                    console.error('歌手信息代理API返回错误:', data);
    
                                    await recordToolUsage('tiny-music', 'getSingerInfo', 0, responseTime, name);
                                    return null;
                                }
                            } catch (error) {
                                console.error('获取歌手信息失败:', error);
                                

                                const responseTime = Date.now() - startTime;
                                

                                await recordToolUsage('tiny-music', 'getSingerInfo', 0, responseTime, name);
                                
                                return null;
                            }
                        })
                    );
                    
    
                    const validSingerInfos = singerInfos.filter(info => info !== null);
                    
                    if (validSingerInfos.length === 0) {
        
                        this.singerInfoLoading.style.display = 'none';
                        this.singerInfoEmpty.style.display = 'block';
                        return;
                    }
                    
    
                    this.updateSingerInfoDetails(validSingerInfos);
                    
    
                    this.singerInfoLoading.style.display = 'none';
                    this.singerInfoDetails.style.display = 'block';
                } catch (error) {
                    console.error('获取歌手信息失败:', error);
    
                    this.singerInfoLoading.style.display = 'none';
                    this.singerInfoEmpty.style.display = 'block';
                }
            }
            

            updateSingerInfoDetails(singerInfos) {
                if (singerInfos.length === 0) return;
                

                let html = '';
                
                singerInfos.forEach((info, index) => {
                    if (index === 0) {

                        html += `
                            <div class="singer-info-item main-singer" style="margin-bottom: 24px; text-align: center;">
                                <div class="singer-info-image" style="margin-bottom: 16px;">
                                    <img src="${info.img_url}" alt="${info.name}" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 3px solid #f0f0f0;">
                                </div>
                                <div class="singer-info-name" style="font-size: 20px; font-weight: 600; color: #1a1a1a; margin-bottom: 12px;">${info.name}</div>
                                <div class="singer-info-profile" style="font-size: 14px; color: #666; line-height: 1.6; text-align: justify;">${info.profile}</div>
                            </div>
                        `;
                    } else {

                        html += `
                            <div class="singer-info-item other-singer" style="margin-bottom: 20px; padding-top: 20px; border-top: 1px solid #f0f0f0;">
                                <div class="singer-info-name" style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin-bottom: 8px;">${info.name}</div>
                                <div class="singer-info-profile" style="font-size: 14px; color: #666; line-height: 1.6; text-align: justify;">${info.profile}</div>
                            </div>
                        `;
                    }
                });
                

                this.singerInfoDetails.innerHTML = html;
            }
            
            showLoading() {
                this.searchBtn.disabled = true;
                this.loadingIcon.style.display = 'inline';
                this.resultSection.style.display = 'block';
                this.loadingContainer.style.display = 'block';
                this.emptyState.style.display = 'none';
                this.hideError();
            }
            
            hideLoading() {
                this.searchBtn.disabled = false;
                this.loadingIcon.style.display = 'none';
                this.loadingContainer.style.display = 'none';
            }
            
            showEmptyState() {
                this.emptyState.style.display = 'block';
                this.musicList.innerHTML = '';
            }
            
            showError(message) {
                this.errorMessage.textContent = message;
                this.errorContainer.style.display = 'block';
            }
            
            hideError() {
                this.errorContainer.style.display = 'none';
            }
        }
        

        let tinyMusic;
        document.addEventListener('DOMContentLoaded', () => {
            tinyMusic = new TinyMusic();
        });
    </script>
</body>
</html>