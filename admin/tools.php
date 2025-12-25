<?php

require_once 'php/auth.php';


requireAdminLogin();


$admin = getCurrentAdmin();


$config = require '../php/config.php';
$tools = $config['tools'];


$search = '';
$status_filter = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $tools = array_filter($tools, function($tool) use ($search) {
        return strpos(strtolower($tool['name']), strtolower($search)) !== false ||
               strpos(strtolower($tool['description']), strtolower($search)) !== false ||
               strpos(strtolower($tool['category']), strtolower($search)) !== false;
    });
    $tools = array_values($tools);
}


if (isset($_GET['status']) && !empty($_GET['status'])) {
    $status_filter = $_GET['status'];
    $tools = array_filter($tools, function($tool) use ($status_filter) {
        return isset($tool['status']) && $tool['status'] == $status_filter;
    });
    $tools = array_values($tools);
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>工具管理 - 工具箱</title>
    <link rel="stylesheet" href="css/admin.css">
    <style>

        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
        }
        
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .slider {
            background-color: #4CAF50;
        }
        
        input:focus + .slider {
            box-shadow: 0 0 1px #4CAF50;
        }
        
        input:checked + .slider:before {
            transform: translateX(24px);
        }
    </style>
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
                    <li class="admin-menu-item active">
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
                    <h1 class="admin-page-title">工具管理</h1>
                    <div class="admin-breadcrumb">
                        <span class="breadcrumb-item">后台管理</span>
                        <span class="breadcrumb-separator">/</span>
                        <span class="breadcrumb-item">工具管理</span>
                    </div>
                </div>
            </header>
            

            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div style="background-color: #e8f5e8; border: 1px solid #c8e6c9; color: #2e7d32; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;">
                    <?php echo $_GET['message'] ?? '操作成功！'; ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                <div style="background-color: #fff3f3; border: 1px solid #ffe0e0; color: #d63031; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;">
                    <?php echo $_GET['message'] ?? '操作失败！'; ?>
                </div>
            <?php endif; ?>
        

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <div style="display: flex; gap: 8px; align-items: center;">
                    <form class="admin-search" action="tools.php" method="GET" style="margin: 0;">
                        <input type="text" name="search" class="search-input" placeholder="搜索工具名称、描述或分类..." value="<?php echo $search; ?>">
                        <button type="submit" class="btn btn-primary">搜索</button>
                    </form>
                    <button id="batch-activate" class="btn btn-success">
                        <span>✅</span>
                        <span>一键开启</span>
                    </button>
                    <button id="batch-deactivate" class="btn btn-warning">
                        <span>❌</span>
                        <span>一键关闭</span>
                    </button>
                </div>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <form action="tools.php" method="GET" style="margin: 0;">
                        <select name="status" class="status-filter" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; background-color: white;">
                            <option value="" <?php echo empty($_GET['status']) ? 'selected' : ''; ?>>全部状态</option>
                            <option value="active" <?php echo (isset($_GET['status']) && $_GET['status'] == 'active') ? 'selected' : ''; ?>>已开启</option>
                            <option value="inactive" <?php echo (isset($_GET['status']) && $_GET['status'] == 'inactive') ? 'selected' : ''; ?>>已关闭</option>
                        </select>
                        <input type="hidden" name="search" value="<?php echo $search; ?>">
                        <button type="submit" class="btn btn-primary">筛选</button>
                    </form>
                    <a href="tool-add.php" class="btn btn-primary">
                        <span>➕</span>
                        <span>添加工具</span>
                    </a>
                </div>
            </div>
            

            <div class="admin-card">
                <div class="card-header">
                    <h2 class="card-title">工具列表</h2>
                    <div class="card-actions">
                        <span class="action-text">共 <?php echo count($tools); ?> 个工具</span>
                    </div>
                </div>
                
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>状态</th>
                            <th>图标</th>
                            <th>名称</th>
                            <th>分类</th>
                            <th>描述</th>
                            <th>链接</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($tools)): ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px; color: #999;">
                                    暂无工具数据
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($tools as $tool): ?>
                                <tr>
                                    <td><?php echo $tool['id']; ?></td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" class="status-toggle" data-id="<?php echo $tool['id']; ?>" <?php echo $tool['status'] == 'active' ? 'checked' : ''; ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td><?php echo $tool['icon']; ?></td>
                                    <td><?php echo $tool['name']; ?></td>
                                    <td>
                                        <span class="status-badge status-active"><?php echo $tool['category']; ?></span>
                                    </td>
                                    <td><?php echo $tool['description']; ?></td>
                                    <td>
                                        <a href="<?php echo $tool['url']; ?>" target="_blank" style="color: #1a1a1a; text-decoration: none;">
                                            <?php echo $tool['url']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="btn-group" style="gap: 8px;">
                                            <a href="tool-edit.php?id=<?php echo $tool['id']; ?>" class="btn btn-secondary" style="font-size: 12px; padding: 4px 8px;">
                                                编辑
                                            </a>
                                            <a href="tool-delete.php?id=<?php echo $tool['id']; ?>" class="btn btn-danger" style="font-size: 12px; padding: 4px 8px;" onclick="return confirm('确定要删除工具「<?php echo $tool['name']; ?>」吗？');">
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
        </main>
    </div>
    
    <script>

        document.addEventListener('DOMContentLoaded', function() {

            const statusToggles = document.querySelectorAll('.status-toggle');
            

            statusToggles.forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const toolId = this.getAttribute('data-id');
                    const newStatus = this.checked ? 'active' : 'inactive';
                    

                    fetch('tool-toggle.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            'id': toolId,
                            'status': newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {

                        if (data.success) {
                            console.log('Status updated successfully');
                        } else {
                            console.error('Failed to update status:', data.message);

                            this.checked = !this.checked;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        this.checked = !this.checked;
                    });
                });
            });
            

            const batchActivateBtn = document.getElementById('batch-activate');
            const batchDeactivateBtn = document.getElementById('batch-deactivate');
            const searchInput = document.querySelector('.search-input');
            

            batchActivateBtn.addEventListener('click', function() {
                if (confirm('确定要批量开启所有符合条件的工具吗？')) {
                    performBatchAction('activate');
                }
            });
            

            batchDeactivateBtn.addEventListener('click', function() {
                if (confirm('确定要批量关闭所有符合条件的工具吗？')) {
                    performBatchAction('deactivate');
                }
            });
            

            function performBatchAction(action) {
                const searchValue = searchInput.value.trim();
                const statusFilter = document.querySelector('.status-filter').value;
                

                fetch('batch-toggle.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'action': action,
                        'search': searchValue,
                        'status': statusFilter
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {

                        alert(data.message + ' 共更新了 ' + data.updated_count + ' 个工具');

                        window.location.reload();
                    } else {

                        alert('操作失败：' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('操作失败：网络错误');
                });
            }
        });
    </script>
</body>
</html>