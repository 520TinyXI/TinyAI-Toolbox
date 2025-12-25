<?php
require_once 'php/auth.php';

requireAdminLogin();

if (!isset($_GET['id'])) {
    header('Location: categories.php');
    exit;
}

$categoryId = $_GET['id'];
$config = require '../php/config.php';
$categories = $config['categories'] ?? [];
$tools = $config['tools'] ?? [];

$categoryIndex = -1;
$category = null;
foreach ($categories as $index => $cat) {
    if ($cat['id'] === $categoryId) {
        $categoryIndex = $index;
        $category = $cat;
        break;
    }
}

if ($category === null) {
    header('Location: categories.php');
    exit;
}

$hasTools = false;
foreach ($tools as $tool) {
    if ($tool['category'] === $categoryId) {
        $hasTools = true;
        break;
    }
}

$success = false;
$error = '';

if (!$hasTools) {
    array_splice($config['categories'], $categoryIndex, 1);
    
    $configContent = "<?php\n/**\n * 工具箱框架配置文件\n */\n\nreturn " . var_export($config, true) . ";";
    
    if (file_put_contents('../php/config.php', $configContent)) {
        header('Location: categories.php?success=1&message=分类删除成功！');
    } else {
        header('Location: categories.php?error=1&message=保存配置文件失败，请检查文件权限');
    }
} else {
    header('Location: categories.php?error=1&message=该分类下还有工具，无法删除');
}

exit;
