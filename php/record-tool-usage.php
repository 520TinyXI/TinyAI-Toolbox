<?php



header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');


require_once 'framework.php';


$toolbox = new ToolboxFramework();


try {
    
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    
    if (!isset($data['tool_id'])) {
            echo json_encode(['code' => 400, 'msg' => 'Missing tool_id parameter']);
            exit;
        }
    
    $toolId = $data['tool_id'];
    $content = $data['content'] ?? null;
    $status = $data['status'] ?? 'success';
    $responseTime = $data['response_time'] ?? 0;
    
    
    $toolInfo = $toolbox->getToolById($toolId);
    $toolName = $toolInfo ? $toolInfo['name'] : $toolId;
    
    
    if (is_string($content)) {
        $contentArray = json_decode($content, true);
        if ($contentArray === null) {
            $contentArray = ['action' => 'use'];
        }
    } else {
        $contentArray = $content ?? ['action' => 'use'];
    }
    
    
    $historyId = $toolbox->saveHistory(
        $toolId,
        $toolName,
        $contentArray,
        null,
        [
            'status' => $status,
            'response_time' => $responseTime
        ]
    );
    
    echo json_encode([
            'code' => 200,
            'msg' => 'Recorded successfully',
            'history_id' => $historyId
        ]);
    
} catch (Exception $e) {
        echo json_encode([
            'code' => 500,
            'msg' => 'Failed to record: ' . $e->getMessage()
        ]);
    }
?>