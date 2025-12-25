<?php
require_once 'php/auth.php';

requireAdminLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$action = $_POST['action'] ?? '';
$search = $_POST['search'] ?? '';
$status_filter = $_POST['status'] ?? '';

if (empty($action) || !in_array($action, ['activate', 'deactivate'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit;
}

$config = require '../php/config.php';
$all_tools = $config['tools'];

$target_tools = [];
if (!empty($search)) {
    $keyword = strtolower($search);
    $target_tools = array_filter($all_tools, function($tool) use ($keyword) {
        return strpos(strtolower($tool['name']), $keyword) !== false ||
               strpos(strtolower($tool['description']), $keyword) !== false ||
               strpos(strtolower($tool['category']), $keyword) !== false;
    });
} else {
    $target_tools = $all_tools;
}

if (!empty($status_filter)) {
    $target_tools = array_filter($target_tools, function($tool) use ($status_filter) {
        return isset($tool['status']) && $tool['status'] == $status_filter;
    });
}

$updated_count = 0;
foreach ($config['tools'] as &$tool) {
    if (in_array($tool, $target_tools)) {
        $tool['status'] = ($action == 'activate') ? 'active' : 'inactive';
        $updated_count++;
    }
}

$config_content = "<?php\n/**\n * 工具箱框架配置文件\n */\n\nreturn " . var_export($config, true) . ";\n";

if (file_put_contents('../php/config.php', $config_content)) {
    echo json_encode([
        'success' => true, 
        'message' => ($action == 'activate' ? '批量开启' : '批量关闭') . '成功！',
        'updated_count' => $updated_count
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to update config file']);
}
?>