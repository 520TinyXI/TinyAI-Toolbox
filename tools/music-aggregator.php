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
    <title>音乐聚合平台 - <?php echo $siteConfig['name']; ?></title>
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
            padding: 20px;
            background-color: #fafafa;
            border-radius: 8px;
        }
        
        .search-form {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .search-input {
            flex: 1;
            min-width: 300px;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.1);
        }
        
        .search-btn {
            background-color: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .search-btn:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .search-btn:active {
            transform: translateY(0);
        }
        
        .search-btn.loading {
            cursor: not-allowed;
            opacity: 0.7;
        }
        
        .search-btn.loading .search-icon {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .results-section {
            margin-bottom: 30px;
        }
        
        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .results-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .results-count {
            font-size: 14px;
            color: #666;
        }
        
        .music-list {
            background-color: #fafafa;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
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
            background-color: #fff;
            transform: translateX(4px);
        }
        
        .music-item:last-child {
            border-bottom: none;
        }
        
        .music-item.active {
            background-color: #e8f5e8;
            border-left: 4px solid #2e7d32;
        }
        
        .music-cover {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 16px;
            flex-shrink: 0;
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
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .music-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        
        .play-btn {
            background-color: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .play-btn:hover {
            background-color: #333;
            transform: scale(1.1);
        }
        
        .play-btn.playing {
            background-color: #2e7d32;
        }
        
        .player-section {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            color: #fff;
            overflow: hidden;
            transition: all 0.3s ease;
            display: none;
        }
        
        .player-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .player-title {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin: 0;
        }
        
        .player-info {
            font-size: 14px;
            color: #b0b0b0;
            margin: 0;
        }
        
        .close-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .close-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .player-body {
            display: flex;
            padding: 30px;
            gap: 30px;
            min-height: 300px;
        }
        
        .player-left {
            flex: 0 0 250px;
        }
        
        .album-cover {
            position: relative;
            width: 250px;
            height: 250px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .album-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }
        
        .album-cover:hover img {
            transform: scale(1.05);
        }
        
        .cover-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.6) 100%);
        }
        
        .player-right {
            flex: 1;
        }
        
        .lyrics-container {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
            height: 250px;
        }
        
        .lyrics-title {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 16px;
            text-align: center;
        }
        
        .lyrics-scroll {
            height: calc(100% - 32px);
            overflow-y: auto;
            padding: 10px 0;
        }
        
        .lyrics-scroll::-webkit-scrollbar {
            width: 6px;
        }
        
        .lyrics-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }
        
        .lyrics-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
        
        .lyrics-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
        
        .lyrics-content {
            text-align: center;
        }
        
        .lyric-line {
            font-size: 14px;
            line-height: 2;
            color: #b0b0b0;
            margin: 8px 0;
            transition: all 0.3s ease;
            padding: 4px 0;
        }
        
        .lyric-line.active {
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            transform: scale(1.05);
        }
        
        .player-footer {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px 24px;
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
            position: relative;
        }
        
        .progress-filled::after {
            content: '';
            position: absolute;
            right: -6px;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            height: 14px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
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
            gap: 24px;
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
            backdrop-filter: blur(10px);
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
        
        .control-btn.play-pause:hover {
            transform: scale(1.15);
        }
        
        .control-btn:disabled {
            background: rgba(255, 255, 255, 0.05);
            color: #666;
            cursor: not-allowed;
            transform: none;
        }
        
        .volume-control {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
        }
        
        .volume-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .volume-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .volume-slider {
            width: 120px;
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
            cursor: pointer;
            overflow: hidden;
        }
        
        .volume-filled {
            height: 100%;
            background: linear-gradient(90deg, #4CAF50, #2196F3);
            border-radius: 3px;
            width: 70%;
            transition: width 0.1s ease;
        }
        
        @media (max-width: 768px) {
            .player-body {
                flex-direction: column;
                align-items: center;
                padding: 20px;
            }
            
            .player-left {
                flex: 0 0 auto;
            }
            
            .album-cover {
                width: 200px;
                height: 200px;
            }
            
            .player-controls {
                gap: 16px;
            }
            
            .control-btn {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }
            
            .control-btn.play-pause {
                width: 56px;
                height: 56px;
                font-size: 20px;
            }
            
            .volume-slider {
                width: 80px;
            }
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
        
        .empty-text {
            font-size: 16px;
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
            
            .search-input {
                min-width: auto;
            }
            
            .music-item {
                flex-wrap: wrap;
                gap: 12px;
            }
            
            .music-info {
                flex-basis: calc(100% - 132px);
            }
            
            .music-actions {
                justify-content: flex-start;
            }
            
            .results-header {
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
                <h1 class="logo"><?php echo $siteConfig['name']; ?></h1>
            </div>
            <nav class="menu">
                <?php echo $toolbox->renderMenu(); ?>
            </nav>
            <div class="sidebar-footer">
                <p class="copyright">© 2025 <?php echo $siteConfig['name']; ?></p>
            </div>
        </aside>

        <!-- 主内容区 -->
        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h2>音乐聚合平台</h2>
                    <p>搜索和播放来自多个平台的音乐</p>
                </div>
            </header>
            
            <div class="tool-container">
                <!-- 工具内容 -->
                <div class="tool-content">
                    <!-- 错误信息 -->
                    <div class="error-message" id="error-message"></div>
                    
                    <!-- 搜索区域 -->
                    <div class="search-section">
                        <form class="search-form" id="search-form">
                            <input type="text" class="search-input" id="search-input" placeholder="输入歌手、歌曲名或专辑名" value="邓紫棋">
                            <button type="submit" class="search-btn" id="search-btn">
                                <span class="search-icon">🔍</span>
                                <span>搜索音乐</span>
                            </button>
                        </form>
                    </div>
                    
                    <!-- 播放器区域 - 仿酷狗播放器 -->
                    <div class="player-section" id="player-section" style="display: none;">
                        <!-- 播放器头部 -->
                        <div class="player-header">
                            <div class="player-title" id="player-title">暂无播放</div>
                            <div class="player-info" id="player-info">请选择一首歌曲播放</div>
                            <button class="close-btn" id="close-player-btn">✕</button>
                        </div>
                        
                        <!-- 播放器主体 -->
                        <div class="player-body">
                            <!-- 左侧歌曲图片 -->
                            <div class="player-left">
                                <div class="album-cover">
                                    <img id="album-cover-img" src="https://via.placeholder.com/200" alt="专辑封面">
                                    <div class="cover-overlay"></div>
                                </div>
                            </div>
                            
                            <!-- 右侧歌词区域 -->
                            <div class="player-right">
                                <div class="lyrics-container">
                                    <div class="lyrics-title">歌词</div>
                                    <div class="lyrics-scroll" id="lyrics-scroll">
                                        <div class="lyrics-content" id="lyrics-content">
                                            <div class="lyric-line">暂无歌词</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 播放器底部 -->
                        <div class="player-footer">
                            <!-- 进度条 -->
                            <div class="progress-section">
                                <div class="progress-container">
                                    <div class="time-display" id="current-time">00:00</div>
                                    <div class="progress-bar" id="progress-bar">
                                        <div class="progress-filled" id="progress-filled"></div>
                                    </div>
                                    <div class="time-display" id="duration">00:00</div>
                                </div>
                            </div>
                            
                            <!-- 播放控制 -->
                            <div class="player-controls">
                                <button class="control-btn" id="prev-btn" disabled>
                                    ⏮️
                                </button>
                                <button class="control-btn repeat-btn" id="repeat-btn">🔁</button>
                                <button class="control-btn play-pause" id="play-pause-btn" disabled>
                                    ▶️
                                </button>
                                <button class="control-btn" id="next-btn" disabled>
                                    ⏭️
                                </button>
                            </div>
                            
                            <!-- 音量控制 -->
                            <div class="volume-control">
                                <button class="volume-btn" id="volume-btn">🔊</button>
                                <div class="volume-slider" id="volume-slider">
                                    <div class="volume-filled" id="volume-filled"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 搜索结果区域 -->
                    <div class="results-section" id="results-section" style="display: none;">
                        <div class="results-header">
                            <div class="results-title">搜索结果</div>
                            <div class="results-count" id="results-count">0 首歌曲</div>
                        </div>
                        
                        <!-- 加载状态 -->
                        <div class="loading" id="loading">
                            <div class="loading-spinner"></div>
                            <div>正在搜索音乐，请稍候...</div>
                        </div>
                        
                        <!-- 音乐列表 -->
                        <div class="music-list" id="music-list"></div>
                        
                        <!-- 空状态 -->
                        <div class="empty-state" id="empty-results">
                            <div class="empty-icon">🎵</div>
                            <div>暂无搜索结果</div>
                            <div style="margin-top: 12px; font-size: 14px;">请尝试其他搜索关键词</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="../js/main.js"></script>
    
    <script>
        async function recordToolUsage(toolId, action, statusValue, responseTime = 0, content = '') {
            try {
                await fetch('../php/record-tool-usage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        tool_id: toolId,
                        content: content,
                        status: statusValue,
                        response_time: responseTime
                    })
                });
            } catch (error) {
                console.error('记录工具使用情况失败:', error);
            }
        }
        
        class MusicAggregator {
            constructor() {
                this.currentMusic = null;
                this.musicList = [];
                this.currentIndex = -1;
                this.audio = new Audio();
                this.isPlaying = false;
                this.isMuted = false;
                this.volume = 0.7;
                this.lyrics = [];
                this.currentLyricIndex = -1;
                this.repeatMode = 'none';
                this.init();
            }
            
            init() {
                this.bindEvents();
                this.searchMusic('邓紫棋');
            }
            
            bindEvents() {
                document.getElementById('search-form').addEventListener('submit', (e) => {
                    e.preventDefault();
                    const keyword = document.getElementById('search-input').value.trim();
                    if (keyword) {
                        this.searchMusic(keyword);
                    }
                });
                
                this.audio.addEventListener('timeupdate', () => {
                    this.updateProgress();
                    this.updateLyrics();
                });
                
                this.audio.addEventListener('ended', () => {
                    this.handleEnded();
                });
                
                this.audio.addEventListener('loadedmetadata', () => {
                    this.updateDuration();
                });
                
                document.getElementById('progress-bar').addEventListener('click', (e) => {
                    this.seek(e);
                });
                
                document.getElementById('play-pause-btn').addEventListener('click', () => {
                    this.togglePlayPause();
                });
                
                document.getElementById('prev-btn').addEventListener('click', () => {
                    this.playPrev();
                });
                
                document.getElementById('next-btn').addEventListener('click', () => {
                    this.playNext();
                });
                
                document.getElementById('volume-btn').addEventListener('click', () => {
                    this.toggleMute();
                });
                
                document.getElementById('volume-slider').addEventListener('click', (e) => {
                    this.setVolume(e);
                });
                
                document.getElementById('close-player-btn').addEventListener('click', () => {
                    this.closePlayer();
                });
                
                document.getElementById('repeat-btn').addEventListener('click', () => {
                    this.toggleRepeat();
                });
            }
            
            async searchMusic(keyword) {
                this.showLoading();
                this.hideError();
                
                const startTime = Date.now();
                
                try {
                    const requestUrl = `../php/music-api-proxy.php?action=search&keyword=${encodeURIComponent(keyword)}`;
                    console.log('搜索请求URL:', requestUrl);
                    
                    const response = await fetch(requestUrl, {
                        method: 'GET',
                        timeout: 15000
                    });
                    
                    console.log('搜索响应状态:', response.status);
                    
                    const responseText = await response.text();
                    console.log('搜索响应文本:', responseText);
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    if (!response.ok) {
                        await recordToolUsage('music-aggregator', '搜索音乐', 'error', responseTime, `HTTP错误! 状态码: ${response.status}, 响应: ${responseText}`);
                        throw new Error(`HTTP错误! 状态码: ${response.status}, 响应: ${responseText}`);
                    }
                    
                    let data;
                    try {
                        data = JSON.parse(responseText);
                        console.log('解析后的搜索数据:', data);
                    } catch (jsonError) {
                        await recordToolUsage('music-aggregator', '搜索音乐', 'error', responseTime, `JSON解析失败: ${jsonError.message}, 响应: ${responseText}`);
                        throw new Error(`JSON解析失败: ${jsonError.message}, 响应: ${responseText}`);
                    }
                    
                    if (data.code === 200) {
                        this.musicList = Array.isArray(data.data) ? data.data : [];
                        this.currentIndex = -1;
                        this.renderMusicList();
                        document.getElementById('results-section').style.display = 'block';
                        document.getElementById('results-count').textContent = `${this.musicList.length} 首歌曲`;
                        await recordToolUsage('music-aggregator', '搜索音乐', 'success', responseTime);
                    } else {
                        let errorMsg = data.msg || '搜索音乐失败';
                        if (data.error) {
                            errorMsg += ` (${data.error})`;
                        }
                        if (data.raw_response) {
                            errorMsg += '，原始响应: ' + data.raw_response;
                        }
                        if (data.request_url) {
                            errorMsg += '，请求URL: ' + data.request_url;
                        }
                        this.showError(errorMsg);
                        console.error('API返回错误:', data);
                        await recordToolUsage('music-aggregator', '搜索音乐', 'error', responseTime, errorMsg);
                    }
                } catch (error) {
                    this.showError(`搜索音乐失败: ${error.message}`);
                    console.error('搜索过程发生错误:', error);
                    const responseTime = (Date.now() - startTime) / 1000;
                    await recordToolUsage('music-aggregator', '搜索音乐', 'error', responseTime, error.message);
                } finally {
                    this.hideLoading();
                }
            }
            
            renderMusicList() {
                const musicListEl = document.getElementById('music-list');
                const emptyResultsEl = document.getElementById('empty-results');
                
                if (this.musicList.length === 0) {
                    musicListEl.innerHTML = '';
                    emptyResultsEl.style.display = 'block';
                    return;
                }
                
                emptyResultsEl.style.display = 'none';
                musicListEl.innerHTML = this.musicList.map((music, index) => {
                    return `
                        <div class="music-item ${this.currentIndex === index ? 'active' : ''}" data-index="${index}">
                            <img class="music-cover" src="${music.cover || 'https://via.placeholder.com/60'}" alt="${music.title}">
                            <div class="music-info">
                                <div class="music-title">${music.title}</div>
                                <div class="music-artist">${music.singer}</div>
                            </div>
                            <div class="music-actions">
                                <button class="play-btn" data-index="${index}">▶️</button>
                            </div>
                        </div>
                    `;
                }).join('');
                
                musicListEl.querySelectorAll('.music-item').forEach(item => {
                    item.addEventListener('click', (e) => {
                        const index = parseInt(item.getAttribute('data-index'));
                        if (e.target.tagName === 'BUTTON') {
                            this.playMusic(index);
                        } else {
                            this.playMusic(index);
                        }
                    });
                });
            }
            
            async playMusic(index) {
                if (index < 0 || index >= this.musicList.length) return;
                
                this.showLoading();
                
                try {
                    this.currentIndex = index;
                    const music = this.musicList[index];
                    
                    this.renderMusicList();
                    
                    const detailData = await this.getMusicDetail(music.title, index + 1);
                    
                    this.currentMusic = {
                        ...music,
                        ...detailData
                    };
                    
                    this.updatePlayerInfo();
                    
                    this.updateAlbumCover();
                    
                    this.displayLyrics(this.currentMusic.lrc);
                    
                    this.audio.src = this.currentMusic.music_url;
                    await this.audio.play();
                    this.isPlaying = true;
                    this.updatePlayButton();
                    
                    document.getElementById('player-section').style.display = 'block';
                } catch (error) {
                    this.showError(`播放失败: ${error.message}`);
                    console.error('播放音乐失败:', error);
                } finally {
                    this.hideLoading();
                }
            }
            
            async getMusicDetail(keyword, index) {
                const startTime = Date.now();
                
                try {
                    const requestUrl = `../php/music-api-proxy.php?action=get&keyword=${encodeURIComponent(keyword)}&n=${index}`;
                    console.log('获取音乐详情请求:', requestUrl);
                    
                    const response = await fetch(requestUrl, {
                        method: 'GET',
                        timeout: 15000
                    });
                    
                    const responseTime = (Date.now() - startTime) / 1000;
                    
                    if (!response.ok) {
                        await recordToolUsage('music-aggregator', '获取音乐详情', 'error', responseTime, `HTTP错误! 状态码: ${response.status}`);
                        throw new Error(`HTTP错误! 状态码: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.code === 200) {
                        await recordToolUsage('music-aggregator', '获取音乐详情', 'success', responseTime);
                        return data;
                    } else {
                        await recordToolUsage('music-aggregator', '获取音乐详情', 'error', responseTime, data.msg || '获取音乐详情失败');
                        throw new Error(data.msg || '获取音乐详情失败');
                    }
                } catch (error) {
                    console.error('获取音乐详情失败:', error);
                    const responseTime = (Date.now() - startTime) / 1000;
                    await recordToolUsage('music-aggregator', '获取音乐详情', 'error', responseTime, error.message);
                    throw error;
                }
            }
            
            updatePlayerInfo(music = this.currentMusic) {
                if (!music) return;
                
                document.getElementById('player-title').textContent = music.title;
                document.getElementById('player-info').textContent = music.singer;
            }
            
            updateAlbumCover() {
                if (!this.currentMusic) return;
                
                const coverImg = document.getElementById('album-cover-img');
                coverImg.src = this.currentMusic.cover || 'https://via.placeholder.com/200';
                coverImg.alt = this.currentMusic.title;
            }
            
            parseLyrics(lyricsText) {
                if (!lyricsText) {
                    return [{ time: 0, text: '暂无歌词' }];
                }
                
                const lyrics = [];
                const lyricRegex = /\[(\d{2}):(\d{2})\.(\d{2,3})\](.*)/g;
                
                let match;
                while ((match = lyricRegex.exec(lyricsText)) !== null) {
                    const minutes = parseInt(match[1]);
                    const seconds = parseInt(match[2]);
                    const milliseconds = parseInt(match[3].padEnd(3, '0'));
                    const time = minutes * 60 + seconds + milliseconds / 1000;
                    const text = match[4].trim();
                    
                    if (text) {
                        lyrics.push({ time, text });
                    }
                }
                
                lyrics.sort((a, b) => a.time - b.time);
                
                return lyrics.length > 0 ? lyrics : [{ time: 0, text: '暂无歌词' }];
            }
            
            displayLyrics(lyricsText) {
                this.lyrics = this.parseLyrics(lyricsText);
                this.currentLyricIndex = -1;
                
                const lyricsContent = document.getElementById('lyrics-content');
                lyricsContent.innerHTML = this.lyrics.map((lyric, index) => {
                    return `<div class="lyric-line" data-index="${index}">${lyric.text}</div>`;
                }).join('');
            }
            
            updateLyrics() {
                if (!this.lyrics || this.lyrics.length === 0) return;
                
                const currentTime = this.audio.currentTime;
                let newIndex = -1;
                
                for (let i = this.lyrics.length - 1; i >= 0; i--) {
                    if (this.lyrics[i].time <= currentTime) {
                        newIndex = i;
                        break;
                    }
                }
                
                if (newIndex !== this.currentLyricIndex) {
                    const prevActive = document.querySelector('.lyric-line.active');
                    if (prevActive) {
                        prevActive.classList.remove('active');
                    }
                    
                    const newActive = document.querySelector(`.lyric-line[data-index="${newIndex}"]`);
                    if (newActive) {
                        newActive.classList.add('active');
                    }
                    
                    this.currentLyricIndex = newIndex;
                }
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
                const repeatBtn = document.getElementById('repeat-btn');
                
                switch (this.repeatMode) {
                    case 'none':
                        this.repeatMode = 'one';
                        repeatBtn.textContent = '🔂';
                        repeatBtn.style.background = 'rgba(76, 175, 80, 0.6)';
                        break;
                    case 'one':
                        this.repeatMode = 'all';
                        repeatBtn.textContent = '🔁';
                        repeatBtn.style.background = 'rgba(33, 150, 243, 0.6)';
                        break;
                    case 'all':
                        this.repeatMode = 'none';
                        repeatBtn.textContent = '🔁';
                        repeatBtn.style.background = 'rgba(255, 255, 255, 0.1)';
                        break;
                }
            }
            
            closePlayer() {
                this.audio.pause();
                this.isPlaying = false;
                this.updatePlayButton();
                document.getElementById('player-section').style.display = 'none';
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
            
            playPrev() {
                if (this.musicList.length === 0) return;
                
                this.currentIndex = (this.currentIndex - 1 + this.musicList.length) % this.musicList.length;
                this.playMusic(this.currentIndex);
            }
            
            playNext() {
                if (this.musicList.length === 0) return;
                
                this.currentIndex = (this.currentIndex + 1) % this.musicList.length;
                this.playMusic(this.currentIndex);
            }
            
            updatePlayerInfo() {
                if (!this.currentMusic) return;
                
                document.getElementById('player-title').textContent = this.currentMusic.title;
                document.getElementById('player-info').textContent = this.currentMusic.singer;
            }
            
            updatePlayButton() {
                const playPauseBtn = document.getElementById('play-pause-btn');
                playPauseBtn.innerHTML = this.isPlaying ? '⏸️' : '▶️';
                playPauseBtn.disabled = false;
                
                document.getElementById('prev-btn').disabled = false;
                document.getElementById('next-btn').disabled = false;
            }
            
            updateProgress() {
                if (!this.audio.duration) return;
                
                const progress = (this.audio.currentTime / this.audio.duration) * 100;
                document.getElementById('progress-filled').style.width = `${progress}%`;
                
                document.getElementById('current-time').textContent = this.formatTime(this.audio.currentTime);
            }
            
            updateDuration() {
                document.getElementById('duration').textContent = this.formatTime(this.audio.duration);
            }
            
            seek(e) {
                const progressBar = document.getElementById('progress-bar');
                const rect = progressBar.getBoundingClientRect();
                const percent = (e.clientX - rect.left) / rect.width;
                this.audio.currentTime = percent * this.audio.duration;
            }
            
            toggleMute() {
                this.isMuted = !this.isMuted;
                this.audio.muted = this.isMuted;
                
                const volumeBtn = document.getElementById('volume-btn');
                volumeBtn.innerHTML = this.isMuted ? '🔇' : '🔊';
            }
            
            setVolume(e) {
                const volumeSlider = document.getElementById('volume-slider');
                const rect = volumeSlider.getBoundingClientRect();
                this.volume = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
                
                this.audio.volume = this.volume;
                this.isMuted = this.volume === 0;
                
                document.getElementById('volume-filled').style.width = `${this.volume * 100}%`;
                const volumeBtn = document.getElementById('volume-btn');
                volumeBtn.innerHTML = this.isMuted ? '🔇' : '🔊';
            }
            
            formatTime(seconds) {
                if (isNaN(seconds)) return '00:00';
                const mins = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60);
                return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            }
            
            showLoading() {
                document.getElementById('loading').classList.add('visible');
                document.getElementById('search-btn').classList.add('loading');
            }
            
            hideLoading() {
                document.getElementById('loading').classList.remove('visible');
                document.getElementById('search-btn').classList.remove('loading');
            }
            
            showError(message) {
                const errorEl = document.getElementById('error-message');
                errorEl.textContent = message;
                errorEl.classList.add('visible');
            }
            
            hideError() {
                document.getElementById('error-message').classList.remove('visible');
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new MusicAggregator();
        });
    </script>
</body>
</html>