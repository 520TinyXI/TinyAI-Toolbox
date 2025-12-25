<?php
require_once 'php/auth.php';

requireAdminLogin();

$admin = getCurrentAdmin();

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $icon = trim($_POST['icon'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status = trim($_POST['status'] ?? 'active');
    
    if (empty($id) || empty($name) || empty($icon)) {
        $error = '请填写分类ID、名称和图标';
    } else {
        $config = require '../php/config.php';
        $categories = $config['categories'] ?? [];
        
        foreach ($categories as $category) {
            if ($category['id'] === $id) {
                $error = '分类ID已存在，请使用其他ID';
                break;
            }
        }
        
        if (empty($error)) {
            $newCategory = [
                'id' => $id,
                'name' => $name,
                'icon' => $icon,
                'description' => $description,
                'status' => $status
            ];
            
            $config['categories'][] = $newCategory;
            
            $configContent = "<?php\n/**\n * 工具箱框架配置文件\n */\n\nreturn " . var_export($config, true) . ";";
            
            if (file_put_contents('../php/config.php', $configContent)) {
                header('Location: categories.php?success=1&message=分类添加成功！');
                exit;
            } else {
                $error = '保存配置文件失败，请检查文件权限';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>添加分类 - 工具箱</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-container">
        <!-- 侧边栏 -->
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
                    <li class="admin-menu-item active">
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
        
        <!-- 主内容区 -->
        <main class="admin-main">
            <header class="admin-header">
                <div>
                    <h1 class="admin-page-title">添加分类</h1>
                    <div class="admin-breadcrumb">
                        <span class="breadcrumb-item">后台管理</span>
                        <span class="breadcrumb-separator">/</span>
                        <span class="breadcrumb-item"><a href="categories.php">分类管理</a></span>
                        <span class="breadcrumb-separator">/</span>
                        <span class="breadcrumb-item">添加分类</span>
                    </div>
                </div>
            </header>
            
            <!-- 错误提示 -->
            <?php if (!empty($error)): ?>
                <div style="background-color: #fff3f3; border: 1px solid #ffe0e0; color: #d63031; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <!-- 添加分类表单 -->
            <div class="admin-card">
                <div class="card-header">
                    <h2 class="card-title">分类信息</h2>
                </div>
                
                <form action="category-add.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="id" class="form-label">分类ID <span style="color: #d63031;">*</span></label>
                            <input type="text" id="id" name="id" class="form-input" placeholder="例如：dev, data, design" required>
                            <div class="form-hint" style="font-size: 12px; color: #999; margin-top: 4px;">
                                唯一标识符，用于URL和内部管理，只能包含字母、数字和下划线
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="name" class="form-label">分类名称 <span style="color: #d63031;">*</span></label>
                            <input type="text" id="name" name="name" class="form-input" placeholder="例如：开发工具，数据分析" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="icon" class="form-label">分类图标 <span style="color: #d63031;">*</span></label>
                            <input type="text" id="icon" name="icon" class="form-input" placeholder="例如：⚙️, 📊, 🎨" required>
                            <div class="form-hint" style="font-size: 12px; color: #999; margin-top: 4px;">
                                支持Emoji或图标代码
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="status" class="form-label">状态 <span style="color: #d63031;">*</span></label>
                            <select id="status" name="status" class="form-input" required>
                                <option value="active">启用</option>
                                <option value="inactive">禁用</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="form-label">分类描述</label>
                        <textarea id="description" name="description" class="form-textarea" placeholder="请输入分类描述" rows="3"></textarea>
                    </div>
                    
                    <div class="form-actions" style="display: flex; gap: 12px; margin-top: 30px;">
                        <a href="categories.php" class="btn btn-secondary">取消</a>
                        <button type="submit" class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>