<?php
require_once 'php/auth.php';

requireAdminLogin();

$admin = getCurrentAdmin();

$config = require '../php/config.php';

$success = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siteName = trim($_POST['site_name'] ?? '');
    $siteDescription = trim($_POST['site_description'] ?? '');
    $siteVersion = trim($_POST['site_version'] ?? '');
    
    if (empty($siteName) || empty($siteDescription)) {
        $error = '请填写网站名称和描述';
    } else {
        $config['site']['name'] = $siteName;
        $config['site']['description'] = $siteDescription;
        $config['site']['version'] = $siteVersion;
        
        $configContent = "<?php\n/**\n * 工具箱框架配置文件\n */\n\nreturn " . var_export($config, true) . ";";
        
        if (file_put_contents('../php/config.php', $configContent)) {
            $success = true;
        } else {
            $error = '保存配置文件失败，请检查文件权限';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>系统设置 - 工具箱</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-container">
        
        <aside class="admin-sidebar">
            <div class="admin-sidebar-header">
                <h1 class="admin-logo">工具箱后台</h1>
            </div>
            
            <nav class="admin-menu">
                <ul class="admin-menu-list">
                    <li class="admin-menu-item">
                        <a href="index.php" class="admin-menu-link">
                            <span class="admin-menu-icon">📊</span>
                            <span class="admin-menu-text">仪表盘</span>
                        </a>
                    </li>
                    <li class="admin-menu-item">
                        <a href="tools.php" class="admin-menu-link">
                            <span class="admin-menu-icon">🔧</span>
                            <span class="admin-menu-text">工具管理</span>
                        </a>
                    </li>
                    <li class="admin-menu-item">
                        <a href="categories.php" class="admin-menu-link">
                            <span class="admin-menu-icon">📁</span>
                            <span class="admin-menu-text">分类管理</span>
                        </a>
                    </li>
                    <li class="admin-menu-item">
                        <a href="tool-stats.php" class="admin-menu-link">
                            <span class="admin-menu-icon">📈</span>
                            <span class="admin-menu-text">工具调用数据</span>
                        </a>
                    </li>
                    <li class="admin-menu-item active">
                        <a href="settings.php" class="admin-menu-link">
                            <span class="admin-menu-icon">⚙️</span>
                            <span class="admin-menu-text">系统设置</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="admin-sidebar-footer">
                <div class="admin-user-info">
                    <div class="admin-user-avatar">
                        <?php echo substr($admin['username'], 0, 1); ?>
                    </div>
                    <div class="admin-user-details">
                        <div class="admin-username"><?php echo $admin['username']; ?></div>
                        <div class="admin-role">管理员</div>
                    </div>
                </div>
                <div style="margin-top: 12px; text-align: center;">
                    <form action="php/logout.php" method="POST" style="display: inline;">
                        <button type="submit" class="admin-logout">退出登录</button>
                    </form>
                </div>
            </div>
        </aside>
        
        
        <main class="admin-main">
            <header class="admin-header">
                <div>
                    <h1 class="admin-page-title">系统设置</h1>
                    <div class="admin-breadcrumb">
                        <span class="breadcrumb-item">后台管理</span>
                        <span class="breadcrumb-separator">/</span>
                        <span class="breadcrumb-item">系统设置</span>
                    </div>
                </div>
            </header>
            
            
            <?php if ($success): ?>
                <div style="background-color: #e8f5e8; border: 1px solid #c8e6c9; color: #2e7d32; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;">
                    设置保存成功！
                </div>
            <?php endif; ?>
            
            
            <?php if (!empty($error)): ?>
                <div style="background-color: #fff3f3; border: 1px solid #ffe0e0; color: #d63031; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            
            <div class="admin-card">
                <div class="card-header">
                    <h2 class="card-title">网站设置</h2>
                </div>
                
                <form action="settings.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="site_name" class="form-label">网站名称 <span style="color: #d63031;">*</span></label>
                            <input type="text" id="site_name" name="site_name" class="form-input" required value="<?php echo $config['site']['name']; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="site_version" class="form-label">网站版本</label>
                            <input type="text" id="site_version" name="site_version" class="form-input" value="<?php echo $config['site']['version']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="site_description" class="form-label">网站描述 <span style="color: #d63031;">*</span></label>
                        <textarea id="site_description" name="site_description" class="form-textarea" required rows="3"><?php echo $config['site']['description']; ?></textarea>
                        <div class="form-hint" style="font-size: 12px; color: #999; margin-top: 4px;">
                            网站描述将显示在首页和搜索引擎结果中
                        </div>
                    </div>
                    
                    <div class="form-actions" style="display: flex; gap: 12px; margin-top: 30px;">
                        <button type="reset" class="btn btn-secondary">重置</button>
                        <button type="submit" class="btn btn-primary">保存设置</button>
                    </div>
                </form>
            </div>
            
            
            <div class="admin-card" style="margin-top: 24px;">
                <div class="card-header">
                    <h2 class="card-title">系统信息</h2>
                </div>
                
                <div style="padding: 20px 0;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px;">
                        <div style="background-color: #f5f5f5; padding: 16px; border-radius: 8px;">
                            <div style="font-size: 12px; color: #999; margin-bottom: 4px;">PHP 版本</div>
                            <div style="font-size: 18px; font-weight: 600;"><?php echo phpversion(); ?></div>
                        </div>
                        
                        <div style="background-color: #f5f5f5; padding: 16px; border-radius: 8px;">
                            <div style="font-size: 12px; color: #999; margin-bottom: 4px;">服务器软件</div>
                            <div style="font-size: 18px; font-weight: 600;"><?php echo $_SERVER['SERVER_SOFTWARE'] ?? '未知'; ?></div>
                        </div>
                        
                        <div style="background-color: #f5f5f5; padding: 16px; border-radius: 8px;">
                            <div style="font-size: 12px; color: #999; margin-bottom: 4px;">系统类型</div>
                            <div style="font-size: 18px; font-weight: 600;"><?php echo PHP_OS; ?></div>
                        </div>
                        
                        <div style="background-color: #f5f5f5; padding: 16px; border-radius: 8px;">
                            <div style="font-size: 12px; color: #999; margin-bottom: 4px;">当前时间</div>
                            <div style="font-size: 18px; font-weight: 600;"><?php echo date('Y-m-d H:i:s'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>