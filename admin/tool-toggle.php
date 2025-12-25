<?php

require_once 'php/auth.php';


requireAdminLogin();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}


$tool_id = $_POST['id'] ?? '';
$status = $_POST['status'] ?? '';


if (empty($tool_id) || !in_array($status, ['active', 'inactive'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit;
}


$config = require '../php/config.php';


$tool_found = false;
foreach ($config['tools'] as &$tool) {
    if ($tool['id'] === $tool_id) {
        $tool['status'] = $status;
        $tool_found = true;
        break;
    }
}

if (!$tool_found) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Tool not found']);
    exit;
}


$config_content = "<?php\n/**\n * 工具箱框架配置文件\n */\n\nreturn " . var_export($config, true) . ";\n";

if (file_put_contents('../php/config.php', $config_content)) {
    echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to update config file']);
}
?>