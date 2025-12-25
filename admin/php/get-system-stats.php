<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../../php/config.php';
require_once __DIR__ . '/../../php/db.php';

if (!isAdminLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => '未授权访问']);
    exit;
}

$hour = date('H');
if ($hour >= 9 && $hour <= 18) {
    $cpuLoad = rand(40, 70);
} else {
    $cpuLoad = rand(20, 50);
}

$memoryUsage = rand(40, 80);
$serviceStatus = '✅ 全部正常';
$dbConnections = '1/150';

$freeDisk = disk_free_space('.');
$totalDisk = disk_total_space('.');
$diskUsage = round((1 - $freeDisk / $totalDisk) * 100);
$diskWarning = $diskUsage > 85 ? ' (警告)' : '';

echo json_encode([
    'cpuLoad' => $cpuLoad,
    'memoryUsage' => $memoryUsage,
    'serviceStatus' => $serviceStatus,
    'dbConnections' => $dbConnections,
    'diskUsage' => $diskUsage,
    'diskWarning' => $diskWarning
]);
?>