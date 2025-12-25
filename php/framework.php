<?php

require_once __DIR__ . '/db.php';

class ToolboxFramework {
    private $config;
    private $currentCategory = 'all';
    private $db;
    
    public function __construct() {
        $this->config = require __DIR__ . '/config.php';
        $this->handleCurrentCategory();
        $this->db = Database::getInstance();
    }
    
    private function handleCurrentCategory() {
        if (isset($_GET['category'])) {
            $this->currentCategory = $_GET['category'];
        }
    }
    
    public function getSiteConfig() {
        return $this->config['site'];
    }
    
    public function getMenus() {
        $menus = $this->config['menus'];
        
        foreach ($menus as &$menu) {
            $menu['active'] = ($menu['id'] == $this->currentCategory);
        }
        
        return $menus;
    }
    
    public function getTools() {
        $tools = $this->config['tools'];
        
        $tools = array_filter($tools, function($tool) {
            return !isset($tool['status']) || $tool['status'] == 'active';
        });
        
        if ($this->currentCategory != 'all') {
            $tools = array_filter($tools, function($tool) {
                return $tool['category'] == $this->currentCategory;
            });
        }
        
        return array_values($tools);
    }
    
    public function getToolById($id) {
        $tools = $this->config['tools'];
        
        foreach ($tools as $tool) {
            if ($tool['id'] == $id) {
                return $tool;
            }
        }
        
        return null;
    }
    
    public function getCategories() {
        $categories = [];
        $tools = $this->config['tools'];
        $configCategories = $this->config['categories'] ?? [];
        
        $categoryStats = [];
        foreach ($tools as $tool) {
            $category = $tool['category'];
            if (!isset($categoryStats[$category])) {
                $categoryStats[$category] = 0;
            }
            $categoryStats[$category]++;
        }
        
        foreach ($configCategories as $category) {
            $categories[] = [
                'id' => $category['id'],
                'name' => $category['name'],
                'icon' => $category['icon'],
                'description' => $category['description'] ?? '',
                'status' => $category['status'] ?? 'active',
                'tool_count' => $categoryStats[$category['id']] ?? 0
            ];
        }
        
        return $categories;
    }
    
    public function searchTools($keyword) {
        if (empty($keyword)) {
            return $this->getTools();
        }
        
        $keyword = strtolower($keyword);
        $tools = $this->config['tools'];
        
        $results = array_filter($tools, function($tool) use ($keyword) {
            return (!isset($tool['status']) || $tool['status'] == 'active') &&
                   (strpos(strtolower($tool['name']), $keyword) !== false ||
                    strpos(strtolower($tool['description']), $keyword) !== false);
        });
        
        return array_values($results);
    }
    
    public function getCurrentCategory() {
        return $this->currentCategory;
    }
    
    public function renderToolCard($tool) {
        $html = '<div class="tool-card" tabindex="0">';
        $html .= '    <div class="tool-icon">' . $tool['icon'] . '</div>';
        $html .= '    <h3 class="tool-name">' . $tool['name'] . '</h3>';
        $html .= '    <p class="tool-desc">' . $tool['description'] . '</p>';
        $html .= '    <div class="tool-action">';
        $html .= '        <a href="' . $tool['url'] . '" class="btn-use">使用</a>';
        $html .= '    </div>';
        $html .= '</div>';
        
        return $html;
    }
    
    public function renderMenu() {
        $menus = $this->getMenus();
        $html = '<ul class="menu-list">';
        
        foreach ($menus as $menu) {
            $activeClass = $menu['active'] ? 'active' : '';
            $html .= '<li class="menu-item ' . $activeClass . '">';
            $html .= '    <a href="../index.php?category=' . $menu['id'] . '" class="menu-link">';
            $html .= '        <span class="menu-icon">' . $menu['icon'] . '</span>';
            $html .= '        <span class="menu-text">' . $menu['name'] . '</span>';
            $html .= '    </a>';
            $html .= '</li>';
        }
        
        $html .= '</ul>';
        
        return $html;
    }
    
    public function getDb() {
        return $this->db;
    }
    
    public function saveHistory($toolId, $toolName, $content = null, $result = null, $options = []) {
        $contentStr = is_array($content) || is_object($content) ? json_encode($content) : (string)$content;
        $resultStr = is_array($result) || is_object($result) ? json_encode($result) : (string)$result;
        
        $ipAddress = $this->getClientIp();
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        $startTime = $options['start_time'] ?? date('Y-m-d H:i:s');
        $endTime = $options['end_time'] ?? date('Y-m-d H:i:s');
        $responseTime = $options['response_time'] ?? 0;
        $status = $options['status'] ?? 'success';
        
        $data = [
            'tool_id' => $toolId,
            'tool_name' => $toolName,
            'content' => $contentStr,
            'result' => $resultStr,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'response_time' => $responseTime,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $historyId = $this->db->insert('history', $data);
        $this->updateStats($toolId, $toolName, $status, $responseTime);
        
        return $historyId;
    }
    
    public function recordVisit() {
        try {
            $today = date('Y-m-d');
            $sql = "SELECT * FROM daily_stats WHERE date = ?";
            $todayStats = $this->db->fetchOne($sql, [$today]);
            
            if ($todayStats) {
                $updateData = [
                    'visit_count' => $todayStats['visit_count'] + 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $this->db->update('daily_stats', $updateData, 'date = ?', [$today]);
            } else {
                $newData = [
                    'date' => $today,
                    'visit_count' => 1,
                    'call_count' => 0,
                    'success_count' => 0,
                    'total_response_time' => 0,
                    'avg_response_time' => 0
                ];
                $this->db->insert('daily_stats', $newData);
            }
            
            return true;
        } catch (Exception $e) {
            error_log('Failed to update visit stats: ' . $e->getMessage());
            return false;
        }
    }
    
    private function updateStats($toolId, $toolName, $status, $responseTime = 0) {
        try {
            $today = date('Y-m-d');
            $now = date('Y-m-d H:i:s');
            
            $this->updateDailyTotalStats($status, $responseTime, $today, $now);
            $this->updateToolDailyStats($toolId, $toolName, $status, $responseTime, $today, $now);
            $this->updateToolTotalStats($toolId, $toolName, $status, $responseTime, $now);
            
            return true;
        } catch (Exception $e) {
            error_log('Failed to update stats: ' . $e->getMessage());
            return false;
        }
    }
    
    private function updateDailyTotalStats($status, $responseTime, $today, $now) {
        $sql = "SELECT * FROM daily_stats WHERE date = ?";
        $todayStats = $this->db->fetchOne($sql, [$today]);
        
        if ($todayStats) {
            $updateData = [
                'call_count' => $todayStats['call_count'] + 1,
                'updated_at' => $now
            ];
            
            if ($status === 'success') {
                $updateData['success_count'] = $todayStats['success_count'] + 1;
                $updateData['total_response_time'] = $todayStats['total_response_time'] + $responseTime;
                $updateData['avg_response_time'] = $updateData['total_response_time'] / $updateData['success_count'];
            }
            
            $this->db->update('daily_stats', $updateData, 'date = ?', [$today]);
        } else {
            $newData = [
                'date' => $today,
                'visit_count' => 0,
                'call_count' => 1,
                'success_count' => ($status === 'success') ? 1 : 0,
                'total_response_time' => ($status === 'success') ? $responseTime : 0,
                'avg_response_time' => ($status === 'success' && $responseTime > 0) ? $responseTime : 0
            ];
            $this->db->insert('daily_stats', $newData);
        }
    }
    
    private function updateToolDailyStats($toolId, $toolName, $status, $responseTime, $today, $now) {
        $sql = "SELECT * FROM tool_stats WHERE tool_id = ? AND date = ?";
        $toolStats = $this->db->fetchOne($sql, [$toolId, $today]);
        
        if ($toolStats) {
            $updateData = [
                'call_count' => $toolStats['call_count'] + 1,
                'updated_at' => $now
            ];
            
            if ($status === 'success') {
                $updateData['success_count'] = $toolStats['success_count'] + 1;
                $updateData['total_response_time'] = $toolStats['total_response_time'] + $responseTime;
                $updateData['avg_response_time'] = $updateData['total_response_time'] / $updateData['success_count'];
            }
            
            $this->db->update('tool_stats', $updateData, 'tool_id = ? AND date = ?', [$toolId, $today]);
        } else {
            $newData = [
                'tool_id' => $toolId,
                'tool_name' => $toolName,
                'date' => $today,
                'call_count' => 1,
                'success_count' => ($status === 'success') ? 1 : 0,
                'total_response_time' => ($status === 'success') ? $responseTime : 0,
                'avg_response_time' => ($status === 'success' && $responseTime > 0) ? $responseTime : 0
            ];
            $this->db->insert('tool_stats', $newData);
        }
    }
    
    private function updateToolTotalStats($toolId, $toolName, $status, $responseTime, $now) {
        $sql = "SELECT * FROM tool_total_stats WHERE tool_id = ?";
        $toolTotalStats = $this->db->fetchOne($sql, [$toolId]);
        
        if ($toolTotalStats) {
            $updateData = [
                'total_call_count' => $toolTotalStats['total_call_count'] + 1,
                'last_call_time' => $now,
                'updated_at' => $now
            ];
            
            if ($status === 'success') {
                $updateData['total_success_count'] = $toolTotalStats['total_success_count'] + 1;
                $updateData['total_response_time'] = $toolTotalStats['total_response_time'] + $responseTime;
                $updateData['avg_response_time'] = $updateData['total_response_time'] / $updateData['total_success_count'];
            }
            
            $this->db->update('tool_total_stats', $updateData, 'tool_id = ?', [$toolId]);
        } else {
            $newData = [
                'tool_id' => $toolId,
                'tool_name' => $toolName,
                'total_call_count' => 1,
                'total_success_count' => ($status === 'success') ? 1 : 0,
                'total_response_time' => ($status === 'success') ? $responseTime : 0,
                'avg_response_time' => ($status === 'success' && $responseTime > 0) ? $responseTime : 0,
                'last_call_time' => $now
            ];
            $this->db->insert('tool_total_stats', $newData);
        }
    }
    
    public function getTodayStats() {
        $today = date('Y-m-d');
        $sql = "SELECT * FROM daily_stats WHERE date = ?";
        $todayStats = $this->db->fetchOne($sql, [$today]);
        
        if (!$todayStats) {
            return [
                'visit_count' => 0,
                'call_count' => 0,
                'success_count' => 0,
                'avg_response_time' => 0,
                'success_rate' => 0
            ];
        }
        
        $successRate = $todayStats['call_count'] > 0 ? 
            round(($todayStats['success_count'] / $todayStats['call_count']) * 100, 2) : 0;
        
        return [
            'visit_count' => $todayStats['visit_count'],
            'call_count' => $todayStats['call_count'],
            'success_count' => $todayStats['success_count'],
            'avg_response_time' => round($todayStats['avg_response_time'], 3),
            'success_rate' => $successRate
        ];
    }
    
    public function getStatsByDateRange($startDate, $endDate) {
        $sql = "SELECT * FROM daily_stats WHERE date BETWEEN ? AND ? ORDER BY date";
        $stats = $this->db->fetchAll($sql, [$startDate, $endDate]);
        
        foreach ($stats as &$stat) {
            $stat['success_rate'] = $stat['call_count'] > 0 ? 
                round(($stat['success_count'] / $stat['call_count']) * 100, 2) : 0;
        }
        
        return $stats;
    }
    
    public function getToolStats() {
        $sql = "SELECT * FROM tool_total_stats ORDER BY total_call_count DESC";
        $stats = $this->db->fetchAll($sql);
        
        foreach ($stats as &$stat) {
            $stat['success_rate'] = $stat['total_call_count'] > 0 ? 
                round(($stat['total_success_count'] / $stat['total_call_count']) * 100, 2) : 0;
        }
        
        return $stats;
    }
    
    public function getToolStatsById($toolId) {
        $sql = "SELECT * FROM tool_total_stats WHERE tool_id = ?";
        $stat = $this->db->fetchOne($sql, [$toolId]);
        
        if ($stat) {
            $stat['success_rate'] = $stat['total_call_count'] > 0 ? 
                round(($stat['total_success_count'] / $stat['total_call_count']) * 100, 2) : 0;
        }
        
        return $stat;
    }
    
    public function getToolStatsByDateRange($toolId, $startDate, $endDate) {
        $sql = "SELECT * FROM tool_stats WHERE tool_id = ? AND date BETWEEN ? AND ? ORDER BY date";
        $stats = $this->db->fetchAll($sql, [$toolId, $startDate, $endDate]);
        
        foreach ($stats as &$stat) {
            $stat['success_rate'] = $stat['call_count'] > 0 ? 
                round(($stat['success_count'] / $stat['call_count']) * 100, 2) : 0;
        }
        
        return $stats;
    }
    
    public function getToolStatsByDate($date) {
        $sql = "SELECT * FROM tool_stats WHERE date = ? ORDER BY call_count DESC";
        $stats = $this->db->fetchAll($sql, [$date]);
        
        foreach ($stats as &$stat) {
            $stat['success_rate'] = $stat['call_count'] > 0 ? 
                round(($stat['success_count'] / $stat['call_count']) * 100, 2) : 0;
        }
        
        return $stats;
    }
    
    public function getTodayToolStats() {
        $today = date('Y-m-d');
        return $this->getToolStatsByDate($today);
    }
    
    public function getHistory($toolId = null, $limit = 100, $offset = 0) {
        $sql = "SELECT * FROM history WHERE 1=1";
        $params = [];
        
        if ($toolId) {
            $sql .= " AND tool_id = ?";
            $params[] = $toolId;
        }
        
        $sql .= " ORDER BY created_at DESC";
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        $history = $this->db->fetchAll($sql, $params);
        
        foreach ($history as &$item) {
            $content = json_decode($item['content'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $item['content'] = $content;
            }
            
            $result = json_decode($item['result'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $item['result'] = $result;
            }
        }
        
        return $history;
    }
    
    public function deleteHistory($id) {
        return $this->db->delete('history', 'id = ?', [$id]);
    }
    
    public function clearHistory($toolId) {
        return $this->db->delete('history', 'tool_id = ?', [$toolId]);
    }
    
    private function getClientIp() {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        $ip = explode(',', $ip);
        $ip = trim($ip[0]);
        
        return $ip;
    }
}

$toolbox = new ToolboxFramework();