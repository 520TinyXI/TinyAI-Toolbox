<?php


return array (
  'site' => 
  array (
    'name' => '工具箱',
    'description' => '精心挑选的实用工具集合',
    'version' => '1.0.0',
  ),
  'menus' => 
  array (
    0 => 
    array (
      'id' => 'all',
      'name' => '所有工具',
      'icon' => '📁',
      'url' => '#',
      'active' => true,
    ),
    1 => 
    array (
      'id' => 'dev',
      'name' => '开发工具',
      'icon' => '⚙️',
      'url' => '#',
      'active' => false,
    ),
    2 => 
    array (
      'id' => 'data',
      'name' => '数据分析',
      'icon' => '📊',
      'url' => '#',
      'active' => false,
    ),
    3 => 
    array (
      'id' => 'design',
      'name' => '设计工具',
      'icon' => '🎨',
      'url' => '#',
      'active' => false,
    ),
    4 => 
    array (
      'id' => 'security',
      'name' => '安全工具',
      'icon' => '🔒',
      'url' => '#',
      'active' => false,
    ),
    5 => 
    array (
      'id' => 'text',
      'name' => '文本工具',
      'icon' => '📝',
      'url' => '#',
      'active' => false,
    ),
    6 => 
    array (
      'id' => 'document',
      'name' => '文档工具',
      'icon' => '📄',
      'url' => '#',
      'active' => false,
    ),
    7 => 
    array (
      'id' => 'image',
      'name' => '图片工具',
      'icon' => '🖼️',
      'url' => '#',
      'active' => false,
    ),
    8 => 
    array (
      'id' => 'calculator',
      'name' => '计算工具',
      'icon' => '🧮',
      'url' => '#',
      'active' => false,
    ),
    9 => 
    array (
      'id' => 'query',
      'name' => '查询工具',
      'icon' => '🔍',
      'url' => '#',
      'active' => false,
    ),
    10 => 
    array (
      'id' => 'generate',
      'name' => '生成工具',
      'icon' => '✨',
      'url' => '#',
      'active' => false,
    ),
    11 => 
    array (
      'id' => 'simulate',
      'name' => '模拟工具',
      'icon' => '🎮',
      'url' => '#',
      'active' => false,
    ),
  ),
  'categories' => 
  array (
    0 => 
    array (
      'id' => 'dev',
      'name' => '开发工具',
      'icon' => '⚙️',
      'description' => '开发相关的工具集合',
      'status' => 'active',
    ),
    1 => 
    array (
      'id' => 'data',
      'name' => '数据分析',
      'icon' => '📊',
      'description' => '数据分析和处理工具',
      'status' => 'active',
    ),
    2 => 
    array (
      'id' => 'design',
      'name' => '设计工具',
      'icon' => '🎨',
      'description' => '设计和创意工具',
      'status' => 'active',
    ),
    3 => 
    array (
      'id' => 'security',
      'name' => '安全工具',
      'icon' => '🔒',
      'status' => 'active',
    ),
    4 => 
    array (
      'id' => 'text',
      'name' => '文本工具',
      'icon' => '📝',
      'status' => 'active',
    ),
    5 => 
    array (
      'id' => 'document',
      'name' => '文档工具',
      'icon' => '📄',
      'description' => '文档处理和转换工具',
      'status' => 'active',
    ),
    6 => 
    array (
      'id' => 'image',
      'name' => '图片工具',
      'icon' => '🖼️',
      'description' => '图片处理和编辑工具',
      'status' => 'active',
    ),
    7 => 
    array (
      'id' => 'calculator',
      'name' => '计算工具',
      'icon' => '🧮',
      'description' => '各种计算和转换工具',
      'status' => 'active',
    ),
    8 => 
    array (
      'id' => 'query',
      'name' => '查询工具',
      'icon' => '🔍',
      'description' => '信息查询和检索工具',
      'status' => 'active',
    ),
    9 => 
    array (
      'id' => 'generate',
      'name' => '生成工具',
      'icon' => '✨',
      'description' => '内容生成和创作工具',
      'status' => 'active',
    ),
    10 => 
    array (
      'id' => 'simulate',
      'name' => '模拟工具',
      'icon' => '🎮',
      'description' => '模拟和测试工具',
      'status' => 'active',
    ),
  ),
  'tools' => 
  array (
    0 => 
    array (
      'id' => 'json',
      'name' => 'JSON格式化',
      'icon' => '📄',
      'description' => '在线JSON格式化工具',
      'category' => 'dev',
      'url' => 'tools/json.php',
      'status' => 'active',
    ),
    1 => 
    array (
      'id' => 'base64',
      'name' => 'Base64编码',
      'icon' => '🔤',
      'description' => 'Base64编码解码',
      'category' => 'dev',
      'url' => 'tools/base64.php',
      'status' => 'active',
    ),
    2 => 
    array (
      'id' => 'md5',
      'name' => 'MD5加密',
      'icon' => '🔒',
      'description' => '生成MD5哈希值',
      'category' => 'security',
      'url' => 'tools/md5.php',
      'status' => 'active',
    ),
    3 => 
    array (
      'id' => 'url',
      'name' => 'URL编码',
      'icon' => '🌐',
      'description' => 'URL编码解码工具',
      'category' => 'dev',
      'url' => 'tools/url.php',
      'status' => 'active',
    ),
    4 => 
    array (
      'id' => 'timestamp',
      'name' => '时间戳转换',
      'icon' => '⏰',
      'description' => '时间戳与日期转换',
      'category' => 'dev',
      'url' => 'tools/timestamp.php',
      'status' => 'active',
    ),
    5 => 
    array (
      'id' => 'ip',
      'name' => 'IP查询',
      'icon' => '📍',
      'description' => 'IP地址查询工具',
      'category' => 'dev',
      'url' => 'tools/ip.php',
      'status' => 'active',
    ),
    6 => 
    array (
      'id' => 'qrcode',
      'name' => '二维码生成',
      'icon' => '📱',
      'description' => '在线二维码生成器',
      'category' => 'design',
      'url' => 'tools/qrcode.php',
      'status' => 'active',
    ),
    7 => 
    array (
      'id' => 'color',
      'name' => '颜色选择器',
      'icon' => '🎨',
      'description' => 'RGB/HEX颜色转换',
      'category' => 'design',
      'url' => 'tools/color.php',
      'status' => 'active',
    ),
    8 => 
    array (
      'id' => 'regex',
      'name' => '正则表达式',
      'icon' => '🔍',
      'description' => '正则表达式测试工具',
      'category' => 'dev',
      'url' => 'tools/regex.php',
      'status' => 'active',
    ),
    9 => 
    array (
      'id' => 'calculator',
      'name' => '计算器',
      'icon' => '🧮',
      'description' => '科学计算器',
      'category' => 'dev',
      'url' => 'tools/calculator.php',
      'status' => 'active',
    ),
    10 => 
    array (
      'id' => 'unit',
      'name' => '单位转换',
      'icon' => '📏',
      'description' => '各种单位转换工具',
      'category' => 'data',
      'url' => 'tools/unit.php',
      'status' => 'active',
    ),
    11 => 
    array (
      'id' => 'password',
      'name' => '密码生成',
      'icon' => '🔑',
      'description' => '随机密码生成器',
      'category' => 'security',
      'url' => 'tools/password.php',
      'status' => 'active',
    ),
    12 => 
    array (
      'id' => 'diff',
      'name' => '文本对比',
      'icon' => '📋',
      'description' => '文本差异对比工具',
      'category' => 'text',
      'url' => 'tools/diff.php',
      'status' => 'active',
    ),
    13 => 
    array (
      'id' => 'minify',
      'name' => 'HTML压缩',
      'icon' => '📦',
      'description' => 'HTML/CSS/JS压缩工具',
      'category' => 'dev',
      'url' => 'tools/minify.php',
      'status' => 'active',
    ),
    14 => 
    array (
      'id' => 'bmi',
      'name' => 'BMI计算器',
      'icon' => '⚖️',
      'description' => '身体质量指数计算器',
      'category' => 'data',
      'url' => 'tools/bmi.php',
      'status' => 'active',
    ),
    15 => 
    array (
      'id' => 'hmac',
      'name' => 'HMAC生成器',
      'icon' => '🔐',
      'description' => '生成HMAC哈希值',
      'category' => 'security',
      'url' => 'tools/hmac.php',
      'status' => 'active',
    ),
    16 => 
    array (
      'id' => 'html-entity',
      'name' => 'HTML实体转义工具',
      'icon' => '🔤',
      'description' => 'HTML实体转义和反转义',
      'category' => 'dev',
      'url' => 'tools/html-entity.php',
      'status' => 'active',
    ),
    17 => 
    array (
      'id' => 'js-encrypt',
      'name' => 'JavaScript代码加密',
      'icon' => '🔒',
      'description' => 'JavaScript代码压缩、混淆和加密',
      'category' => 'dev',
      'url' => 'tools/js-encrypt.php',
      'status' => 'active',
    ),
    18 => 
    array (
      'id' => 'ulid',
      'name' => 'ULID生成器',
      'icon' => '🔤',
      'description' => '生成唯一且可排序的ULID标识符',
      'category' => 'dev',
      'url' => 'tools/ulid.php',
      'status' => 'active',
    ),
    19 => 
    array (
      'id' => 'expiry',
      'name' => '保质期计算器',
      'icon' => '📅',
      'description' => '计算食品、药品等产品的保质期到期日期',
      'category' => 'calculator',
      'url' => 'tools/expiry.php',
      'status' => 'active',
    ),
    20 => 
    array (
      'id' => 'wzry',
      'name' => '王者荣耀战力查询',
      'icon' => '🎮',
      'description' => '查询王者荣耀英雄在不同系统的战力数据',
      'category' => 'query',
      'url' => 'tools/wzry.php',
      'status' => 'active',
    ),
    21 => 
    array (
      'id' => 'history-today',
      'name' => '历史上的今天',
      'icon' => '📅',
      'description' => '探索历史上今天发生的重要事件',
      'category' => 'query',
      'url' => 'tools/history-today.php',
      'status' => 'active',
    ),
    22 => 
    array (
      'id' => 'trademark',
      'name' => '商标信息查询',
      'icon' => '🏷️',
      'description' => '查询商标关键词的详细信息',
      'category' => 'query',
      'url' => 'tools/trademark.php',
      'status' => 'active',
    ),
    23 => 
    array (
      'id' => 'gold-price',
      'name' => '今日黄金价格',
      'icon' => '💰',
      'description' => '获取最新的黄金价格以及各种黄金的详细信息',
      'category' => 'query',
      'url' => 'tools/gold-price.php',
      'status' => 'active',
    ),
    24 => 
    array (
      'id' => 'history-person',
      'name' => '历史人物年轮详情',
      'icon' => '👤',
      'description' => '查询历史人物的详细信息和年轮记录',
      'category' => 'query',
      'url' => 'tools/history-person.php',
      'status' => 'active',
    ),
    25 => 
    array (
      'id' => 'car-price',
      'name' => '车辆价格信息查询',
      'icon' => '🚗',
      'description' => '查询车辆的价格、配置和图片信息',
      'category' => 'query',
      'url' => 'tools/car-price.php',
      'status' => 'active',
    ),
    26 => 
    array (
      'id' => 'city-route',
      'name' => '城市路线查询',
      'icon' => '🗺️',
      'description' => '搜索城市出行路线信息，包括距离、油耗、耗时、过路费和详细路线',
      'category' => 'query',
      'url' => 'tools/city-route.php',
      'status' => 'active',
    ),
    27 => 
    array (
      'id' => 'tech-news',
      'name' => '实时科技资讯',
      'icon' => '📰',
      'description' => '获取当前时间的最新实时科技资讯信息',
      'category' => 'query',
      'url' => 'tools/tech-news.php',
      'status' => 'active',
    ),
    28 => 
    array (
      'id' => 'epic-free',
      'name' => 'Epic喜加一',
      'icon' => '🎮',
      'description' => '获取最新的Epic喜加一游戏信息',
      'category' => 'query',
      'url' => 'tools/epic-free.php',
      'status' => 'active',
    ),
    29 => 
    array (
      'id' => 'horoscope',
      'name' => '星座运势',
      'icon' => '✨',
      'description' => '查询今日星座运势，包括整体运势、爱情、事业、财运和健康',
      'category' => 'query',
      'url' => 'tools/horoscope.php',
      'status' => 'active',
    ),
    30 => 
    array (
      'id' => 'movie-box-office',
      'name' => '猫眼电影实时票房排行',
      'icon' => '🎬',
      'description' => '获取最新猫眼电影实时票房名单，包括电影名称、票房、排片率等信息',
      'category' => 'query',
      'url' => 'tools/movie-box-office.php',
      'status' => 'active',
    ),
    31 => 
    array (
      'id' => 'domain-price',
      'name' => '域名比价查询',
      'icon' => '🌐',
      'description' => '查询域名后缀在各平台的注册、续费、转入价格排行',
      'category' => 'query',
      'url' => 'tools/domain-price.php',
      'status' => 'active',
    ),
    32 => 
    array (
      'id' => 'douyin-video',
      'name' => '抖音单视频解析',
      'icon' => '🎬',
      'description' => '通过抖音分享链接获取抖音视频信息，包括无水印视频链接、音乐链接等',
      'category' => 'query',
      'url' => 'tools/douyin-video.php',
      'status' => 'active',
    ),
    33 => 
    array (
      'id' => 'movie-lines',
      'name' => '影视台词搜寻',
      'icon' => '🎬',
      'description' => '通过台词搜寻存在的电影，获取电影信息和相关台词',
      'category' => 'query',
      'url' => 'tools/movie-lines.php',
      'status' => 'active',
    ),
    34 => 
    array (
      'id' => 'ip-location',
      'name' => 'IP高精度地理位置查询',
      'icon' => '🌍',
      'description' => '查询IP的高精度地理位置信息，支持IPv4和IPv6',
      'category' => 'query',
      'url' => 'tools/ip-location.php',
      'status' => 'active',
    ),
    35 => 
    array (
      'id' => 'ip-details',
      'name' => 'IP详情查询',
      'icon' => '🔍',
      'description' => '查询IP的详细信息，包括归属地、运营商、ASN等',
      'category' => 'query',
      'url' => 'tools/ip-details.php',
      'status' => 'active',
    ),
    36 => 
    array (
      'id' => 'zhihu-hot',
      'name' => '知乎热搜榜',
      'icon' => '📊',
      'description' => '实时获取知乎热搜榜数据，了解热门话题',
      'category' => 'query',
      'url' => 'tools/zhihu-hot.php',
      'status' => 'active',
    ),
    37 => 
    array (
      'id' => 'llm-reader',
      'name' => '基于LLM模型网页读取',
      'icon' => '📄',
      'description' => '通过LLM模型读取网页内容，支持JSON和文本格式返回',
      'category' => 'dev',
      'url' => 'tools/llm-reader.php',
      'status' => 'active',
    ),
    38 => 
    array (
      'id' => 'universal-search',
      'name' => '万能搜索引擎',
      'icon' => '🔍',
      'description' => '通过内部搜索引擎接口返回搜索结果，支持分页查询',
      'category' => 'query',
      'url' => 'tools/universal-search.php',
      'status' => 'active',
    ),
    39 => 
    array (
      'id' => 'hotboard',
      'name' => '多平台实时热榜',
      'icon' => '📊',
      'description' => '一网打尽各大主流平台的实时热榜/热搜，快速跟上网络热点',
      'category' => 'query',
      'url' => 'tools/hotboard.php',
      'status' => 'active',
    ),
    40 => 
    array (
      'id' => 'random-number',
      'name' => '高度可定制的随机数',
      'icon' => '🎲',
      'description' => '生成高度可定制的随机数，支持整数/小数、允许/禁止重复',
      'category' => 'generate',
      'url' => 'tools/random-number.php',
      'status' => 'active',
    ),
    41 => 
    array (
      'id' => 'text-analyze',
      'name' => '多维度分析文本内容',
      'icon' => '📊',
      'description' => '从多个维度分析文本内容，包括字符数、词数、句子数、段落数和行数',
      'category' => 'text',
      'url' => 'tools/text-analyze.php',
      'status' => 'active',
    ),
    42 => 
    array (
      'id' => 'minecraft-status',
      'name' => '查询Minecraft服务器状态',
      'icon' => '🎮',
      'description' => '实时查询Minecraft Java版服务器的在线状态、玩家数量、版本信息等',
      'category' => 'query',
      'url' => 'tools/minecraft-status.php',
      'status' => 'active',
    ),
    43 => 
    array (
      'id' => 'oil-price',
      'name' => '全国油价查询',
      'icon' => '⛽',
      'description' => '查询全国各城市的最新油价信息，包括92#、95#、98#汽油和0#柴油价格',
      'category' => 'query',
      'url' => 'tools/oil-price.php',
      'status' => 'active',
    ),
    44 => 
    array (
      'id' => 'tv-boxoffice',
      'name' => '电视剧实时票房',
      'icon' => '🎬',
      'description' => '查询热播电视剧的实时票房和热度排名',
      'category' => 'query',
      'url' => 'tools/tv-boxoffice.php',
      'status' => 'active',
    ),
    45 => 
    array (
      'id' => 'rp-luck',
      'name' => '人品运势',
      'icon' => '🌟',
      'description' => '输入你的名字，查询今日人品运势',
      'category' => 'query',
      'url' => 'tools/rp-luck.php',
      'status' => 'active',
    ),
    46 => 
    array (
      'id' => 'earthquake',
      'name' => '地震信息',
      'icon' => '🌍',
      'description' => '获取近期全球的地震信息，包括地点、震级、时间、深度等',
      'category' => 'query',
      'url' => 'tools/earthquake.php',
      'status' => 'active',
    ),
    47 => 
    array (
      'id' => 'top-movie',
      'name' => '全球影史票房榜',
      'icon' => '🎬',
      'description' => '查询全球电影票房历史排行榜，包括电影名称、票房和上映年份',
      'category' => 'query',
      'url' => 'tools/top-movie.php',
      'status' => 'active',
    ),
    48 => 
    array (
      'id' => 'steam-online',
      'name' => 'Steam游戏在线人数查询',
      'icon' => '🎮',
      'description' => '查询Steam平台游戏在线人数统计，包括当前在线人数和历史峰值',
      'category' => 'query',
      'url' => 'tools/steam-online.php',
      'status' => 'active',
    ),
    49 => 
    array (
      'id' => 'bilibili-parse',
      'name' => 'B站视频解析',
      'icon' => '📺',
      'description' => '解析B站视频链接，获取无水印视频地址和视频信息',
      'category' => 'query',
      'url' => 'tools/bilibili-parse.php',
      'status' => 'active',
    ),
    50 => 
    array (
      'id' => 'temp-email',
      'name' => '临时邮箱',
      'icon' => '📧',
      'description' => '生成临时邮箱，接收邮件，保护隐私',
      'category' => 'query',
      'url' => 'tools/temp-email.php',
      'status' => 'active',
    ),
    51 => 
    array (
      'id' => 'music-aggregator',
      'name' => '音乐聚合平台',
      'icon' => '🎵',
      'description' => '搜索和播放来自多个平台的音乐',
      'category' => 'query',
      'url' => 'tools/music-aggregator.php',
      'status' => 'active',
    ),
    52 => 
    array (
      'id' => 'beer-query',
      'name' => '全球啤酒厂查询',
      'icon' => '🍺',
      'description' => '查询全球啤酒厂信息，支持按国家、城市、类型等筛选',
      'category' => 'query',
      'url' => 'tools/beer-query.php',
      'status' => 'active',
    ),
    53 => 
    array (
      'id' => 'wallpaper-gallery',
      'name' => '壁纸大全',
      'icon' => '🖼️',
      'description' => '获取各种类型的壁纸图片，包括SFW内容和动漫壁纸',
      'category' => 'image',
      'url' => 'tools/wallpaper-gallery.php',
      'status' => 'active',
    ),
    54 => 
    array (
      'id' => 'antutu-performance',
      'name' => '安兔兔设备性能榜',
      'icon' => '📱',
      'description' => '获取最新的多平台设备性能排名数据',
      'category' => 'query',
      'url' => 'tools/antutu-performance.php',
      'status' => 'active',
    ),
    55 => 
    array (
      'id' => 'train-batch-query',
      'name' => '火车批次查询',
      'icon' => '🚂',
      'description' => '查询全国火车和高铁班次信息',
      'category' => 'query',
      'url' => 'tools/train-batch-query.php',
      'status' => 'active',
    ),
    56 => 
    array (
      'id' => 'football-news',
      'name' => '足球赛事热点',
      'icon' => '⚽',
      'description' => '获取最新的足球赛事热点新闻',
      'category' => 'query',
      'url' => 'tools/football-news.php',
      'status' => 'active',
    ),
    57 => 
    array (
      'id' => 'cctv-news',
      'name' => '央视新闻热点',
      'icon' => '📺',
      'description' => '获取最新的央视新闻热点资讯',
      'category' => 'query',
      'url' => 'tools/cctv-news.php',
      'status' => 'active',
    ),
    58 => 
    array (
      'id' => 'ks-painting',
      'name' => '快手可图绘画',
      'icon' => '🎨',
      'description' => '使用AI快速生成高质量绘画作品',
      'category' => 'generate',
      'url' => 'tools/ks-painting.php',
      'status' => 'active',
    ),
    59 => 
    array (
      'id' => 'car-info',
      'name' => '车辆信息查询',
      'icon' => '🚗',
      'description' => '查询车辆品牌、系列、价格等详细信息',
      'category' => 'query',
      'url' => 'tools/car-info.php',
      'status' => 'active',
    ),
    60 => 
    array (
      'id' => 'site-ping',
      'name' => '站点超级Ping',
      'icon' => '🌐',
      'description' => '一键检测网站速度、状态和性能',
      'category' => 'query',
      'url' => 'tools/site-ping.php',
      'status' => 'active',
    ),
    61 => 
    array (
      'id' => 'seo-diagnosis',
      'name' => 'SEO网页诊断',
      'icon' => '📊',
      'description' => '企业级网页分析，全面诊断SEO问题',
      'category' => 'query',
      'url' => 'tools/seo-diagnosis.php',
      'status' => 'active',
    ),
    62 => 
    array (
      'id' => 'proxy-pool',
      'name' => '高质量代理池',
      'icon' => '🔌',
      'description' => '私域自动筛选，确保80%可用',
      'category' => 'query',
      'url' => 'tools/proxy-pool.php',
      'status' => 'active',
    ),
    63 => 
    array (
      'id' => 'real-time-ip',
      'name' => '实时采集IP',
      'icon' => '🌐',
      'description' => '实时采集数据，自行检测是否可用',
      'category' => 'query',
      'url' => 'tools/real-time-ip.php',
      'status' => 'active',
    ),
    64 => 
    array (
      'id' => 'tiny-music',
      'name' => 'TINY音乐',
      'icon' => '🎵',
      'description' => '搜索和播放你喜爱的音乐',
      'category' => 'query',
      'url' => 'tools/tiny-music.php',
      'status' => 'active',
    ),
    65 => 
    array (
      'id' => 'gpt5-nano',
      'name' => 'Gpt5-nano API',
      'icon' => '🤖',
      'description' => '基于OpenAI官方逆向的独立加密算法',
      'category' => 'generate',
      'url' => 'tools/gpt5-nano.php',
      'status' => 'active',
    ),
    66 => 
    array (
      'id' => 'constellation-pair',
      'name' => '星座运势配对',
      'icon' => '🌟',
      'description' => '查看星座运势、个性分析和最佳配对',
      'category' => 'query',
      'url' => 'tools/constellation-pair.php',
      'status' => 'active',
    ),
    67 => 
    array (
      'id' => 'ai-model-price',
      'name' => 'AI大模型价格对比',
      'icon' => '💰',
      'description' => '对比不同AI大模型的价格、性能和质量',
      'category' => 'query',
      'url' => 'tools/ai-model-price.php',
      'status' => 'active',
    ),
    68 => 
    array (
      'id' => 'flux1',
      'name' => 'FLUX.1文生图',
      'icon' => '🎨',
      'description' => 'AIGC官方镜像，指令优化版',
      'category' => 'generate',
      'url' => 'tools/flux1.php',
      'status' => 'active',
    ),
    69 => 
    array (
      'id' => 'kkmh',
      'name' => '快看漫画搜索',
      'icon' => '📚',
      'description' => '搜索快看漫画的所有数据源，返回完整漫画信息',
      'category' => 'query',
      'url' => 'tools/kkmh.php',
      'status' => 'active',
    ),
    70 => 
    array (
      'id' => 'mambo-voice',
      'name' => '曼波配音生成',
      'icon' => '🎤',
      'description' => '通过文字生成曼波语音，支持MP3格式',
      'category' => 'generate',
      'url' => 'tools/mambo-voice.php',
      'status' => 'active',
    ),
  ),
  'pagination' => 
  array (
    'per_page' => 21,
  ),
  'theme' => 
  array (
    'color' => 
    array (
      'primary' => '#1a1a1a',
      'secondary' => '#666666',
      'background' => '#fafafa',
      'card' => '#ffffff',
      'border' => '#e0e0e0',
      'hover' => '#f0f0f0',
    ),
  ),
  'admin' => 
  array (
    'name' => '工具箱后台',
    'version' => '1.0.0',
    'description' => '工具箱后台管理系统',
    'login_title' => '工具箱后台登录',
    'dashboard_title' => '后台仪表盘',
  ),
);
