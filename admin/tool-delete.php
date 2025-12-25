<?php
require_once 'php/auth.php';

requireAdminLogin();

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

if ($toolIndex !== -1) {
    array_splice($config['tools'], $toolIndex, 1);
    
    $configContent = "<?php\n/**\n * 工具箱框架配置文件\n */\n\nreturn " . var_export($config, true) . ";";
    
    if (file_put_contents('../php/config.php', $configContent)) {
        $success = true;
    } else {
        $error = '保存配置文件失败，请检查文件权限';
    }
} else {
    $error = '工具不存在';
}

if ($success) {
    header('Location: tools.php?success=1&message=' . urlencode('工具删除成功'));
} else {
    header('Location: tools.php?error=1&message=' . urlencode($error));
}
exit;
