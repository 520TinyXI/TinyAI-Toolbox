<?php
require_once 'php/auth.php';

requireAdminLogin();

$admin = getCurrentAdmin();

if (!isset($_GET['id'])) {
    header('Location: tools.php');
    exit;
}

$toolId = $_GET['id'];
$config = require '../php/config.php';
$tools = $config['tools'];

$toolIndex = -1;
$tool = null;
foreach ($tools as $index => $t) {
    if ($t['id'] === $toolId) {
        $toolIndex = $index;
        $tool = $t;
        break;
    }
}

if ($tool === null) {
    header('Location: tools.php');
    exit;
}

$success = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $icon = trim($_POST['icon'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $url = trim($_POST['url'] ?? '');
    
    if (empty($name) || empty($icon) || empty($category) || empty($description) || empty($url)) {
        $error = '请填写所有必填字段';
    } else {
        $config['tools'][$toolIndex] = [
            'id' => $toolId,
            'name' => $name,
            'icon' => $icon,
            'category' => $category,
            'description' => $description,
            'url' => $url
        ];
        
        $configContent = "<?php\n/**\n * 工具箱框架配置文件\n */\n\nreturn " . var_export($config, true) . ";";
        
        if (file_put_contents('../php/config.php', $configContent)) {
            $success = true;
            $tool = $config['tools'][$toolIndex];
        } else {
            $error = '保存配置文件失败，请检查文件权限';
        }
    }
}

$config = require '../php/config.php';
$categoriesConfig = $config['categories'] ?? [];
$categories = [];
foreach ($categoriesConfig as $category) {
    $categories[$category['id']] = $category['name'];
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑工具 - 工具箱</title>
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
                    <h1 class="admin-page-title">编辑工具</h1>
                    <div class="admin-breadcrumb">
                        <span class="breadcrumb-item">后台管理</span>
                        <span class="breadcrumb-separator">/</span>
                        <span class="breadcrumb-item"><a href="tools.php">工具管理</a></span>
                        <span class="breadcrumb-separator">/</span>
                        <span class="breadcrumb-item">编辑工具</span>
                    </div>
                </div>
            </header>
            
            
            <?php if ($success): ?>
                <div style="background-color: #e8f5e8; border: 1px solid #c8e6c9; color: #2e7d32; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;">
                    工具更新成功！
                </div>
            <?php endif; ?>
            
            
            <?php if (!empty($error)): ?>
                <div style="background-color: #fff3f3; border: 1px solid #ffe0e0; color: #d63031; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            
            <div class="admin-card">
                <div class="card-header">
                    <h2 class="card-title">工具信息</h2>
                </div>
                
                <form class="tool-form" action="tool-edit.php?id=<?php echo $toolId; ?>" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="id" class="form-label">工具ID</label>
                            <input type="text" id="id" name="id" class="form-input" value="<?php echo $tool['id']; ?>" readonly style="background-color: #f5f5f5; cursor: not-allowed;">
                            <div class="form-hint" style="font-size: 12px; color: #999; margin-top: 4px;">
                                工具ID不可修改
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="name" class="form-label">工具名称 <span style="color: #d63031;">*</span></label>
                            <input type="text" id="name" name="name" class="form-input" placeholder="例如：JSON格式化" required value="<?php echo $tool['name']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="icon" class="form-label">工具图标 <span style="color: #d63031;">*</span></label>
                            <input type="text" id="icon" name="icon" class="form-input" placeholder="例如：📄" required value="<?php echo $tool['icon']; ?>">
                            <div class="form-hint" style="font-size: 12px; color: #999; margin-top: 4px;">
                                支持emoji或图标代码
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="category" class="form-label">分类 <span style="color: #d63031;">*</span></label>
                            <select id="category" name="category" class="form-input" required>
                                <?php foreach ($categories as $key => $value): ?>
                                    <option value="<?php echo $key; ?>" <?php echo ($tool['category'] === $key) ? 'selected' : ''; ?>>
                                        <?php echo $value; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="url" class="form-label">工具链接 <span style="color: #d63031;">*</span></label>
                        <input type="text" id="url" name="url" class="form-input" placeholder="例如：tools/json.php" required value="<?php echo $tool['url']; ?>">
                        <div class="form-hint" style="font-size: 12px; color: #999; margin-top: 4px;">
                            工具页面的相对路径
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="form-label">工具描述 <span style="color: #d63031;">*</span></label>
                        <textarea id="description" name="description" class="form-textarea" placeholder="请输入工具描述" required><?php echo $tool['description']; ?></textarea>
                        <div class="form-hint" style="font-size: 12px; color: #999; margin-top: 4px;">
                            简洁描述工具的功能和用途
                        </div>
                    </div>
                    
                    <div class="form-actions" style="display: flex; gap: 12px; margin-top: 30px;">
                        <a href="tools.php" class="btn btn-secondary">取消</a>
                        <button type="submit" class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>