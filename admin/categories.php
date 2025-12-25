<?php
require_once 'php/auth.php';

requireAdminLogin();

$admin = getCurrentAdmin();

$config = require '../php/config.php';
$tools = $config['tools'];
$categories = $config['categories'] ?? [];

$categoryStats = [];
foreach ($tools as $tool) {
    $category = $tool['category'];
    if (!isset($categoryStats[$category])) {
        $categoryStats[$category] = 0;
    }
    $categoryStats[$category]++;
}

$success = false;
$error = '';

if (isset($_GET['success'])) {
    $success = true;
    $message = $_GET['message'] ?? '操作成功！';
}

if (isset($_GET['error'])) {
    $error = $_GET['error'] ?? '操作失败！';
}

$categoriesAssoc = [];
foreach ($categories as $category) {
    $categoriesAssoc[$category['id']] = $category;
}

$allCategories = $categoriesAssoc;
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>分类管理 - 工具箱</title>
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
                        <a href="tool-stats.php" class="admin-menu-link">
                            <span class="admin-menu-icon">📈</span>
                            <span class="admin-menu-text">工具调用数据</span>
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
                    <h1 class="admin-page-title">分类管理</h1>
                    <div class="admin-breadcrumb">
                        <span class="breadcrumb-item">后台管理</span>
                        <span class="breadcrumb-separator">/</span>
                        <span class="breadcrumb-item">分类管理</span>
                    </div>
                </div>
            </header>
            
            <!-- 成功提示 -->
            <?php if ($success): ?>
                <div style="background-color: #e8f5e8; border: 1px solid #c8e6c9; color: #2e7d32; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <!-- 错误提示 -->
            <?php if (!empty($error)): ?>
                <div style="background-color: #fff3f3; border: 1px solid #ffe0e0; color: #d63031; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <!-- 添加分类按钮 -->
            <div style="margin-bottom: 24px; text-align: right;">
                <a href="category-add.php" class="btn btn-primary">
                    <span>➕</span>
                    <span>添加分类</span>
                </a>
            </div>
            
            <!-- 分类列表 -->
            <div class="admin-card">
                <div class="card-header">
                    <h2 class="card-title">分类列表</h2>
                    <div class="card-actions">
                        <span class="action-text">共 <?php echo count($allCategories); ?> 个分类</span>
                    </div>
                </div>
                
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>分类ID</th>
                            <th>图标</th>
                            <th>分类名称</th>
                            <th>工具数量</th>
                            <th>状态</th>
                            <th>描述</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($allCategories)): ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                                    暂无分类数据
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($allCategories as $category): ?>
                                <tr>
                                    <td><?php echo $category['id']; ?></td>
                                    <td><?php echo $category['icon']; ?></td>
                                    <td><?php echo $category['name']; ?></td>
                                    <td><?php echo $categoryStats[$category['id']] ?? 0; ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $category['status']; ?>">
                                            <?php echo $category['status'] == 'active' ? '启用' : '禁用'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $category['description'] ?? '-'; ?></td>
                                    <td>
                                        <div class="btn-group" style="gap: 8px;">
                                            <a href="category-edit.php?id=<?php echo $category['id']; ?>" class="btn btn-secondary" style="font-size: 12px; padding: 4px 8px;">
                                                编辑
                                            </a>
                                            <a href="category-delete.php?id=<?php echo $category['id']; ?>" class="btn btn-danger" style="font-size: 12px; padding: 4px 8px;" onclick="return confirm('确定要删除分类「<?php echo $category['name']; ?>」吗？该分类下有 <?php echo $categoryStats[$category['id']] ?? 0; ?> 个工具将被影响。');">
                                                删除
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- 分类统计图表 -->
            <div class="admin-card" style="margin-top: 24px;">
                <div class="card-header">
                    <h2 class="card-title">分类统计</h2>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; padding: 20px 0;">
                    <?php foreach ($categoryStats as $categoryId => $count): ?>
                        <?php if (isset($categoriesAssoc[$categoryId])): ?>
                            <div style="background-color: #f5f5f5; padding: 20px; border-radius: 8px; text-align: center;">
                                <div style="font-size: 14px; color: #666; margin-bottom: 8px;">
                                    <?php echo $categoriesAssoc[$categoryId]['icon']; ?> <?php echo $categoriesAssoc[$categoryId]['name']; ?>
                                </div>
                                <div style="font-size: 32px; font-weight: 700; color: #1a1a1a;">
                                    <?php echo $count; ?>
                                </div>
                                <div style="font-size: 12px; color: #999; margin-top: 4px;">
                                    个工具
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>