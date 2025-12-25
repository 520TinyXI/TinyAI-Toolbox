<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台登录 - 工具箱</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h1 class="login-title">工具箱后台</h1>
                <p class="login-subtitle">请登录管理后台</p>
            </div>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="login-error">
                    <span class="error-icon">⚠️</span>
                    <span class="error-text">
                        <?php 
                        $error = $_GET['error'];
                        if ($error == 'invalid') echo '用户名或密码错误';
                        elseif ($error == 'required') echo '请填写所有字段';
                        else echo '登录失败';
                        ?>
                    </span>
                </div>
            <?php endif; ?>
            
            <form class="login-form" action="php/login.php" method="POST">
                <div class="form-group">
                    <label for="username" class="form-label">用户名</label>
                    <input type="text" id="username" name="username" class="form-input" placeholder="请输入用户名" required>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">密码</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="请输入密码" required>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-login">登录</button>
                </div>
            </form>
            
            <div class="login-footer">
                <p class="footer-text">© 2025 工具箱管理后台</p>
            </div>
        </div>
    </div>
</body>
</html>