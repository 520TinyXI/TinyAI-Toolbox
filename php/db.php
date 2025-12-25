<?php

class Database {

    private static $instance = null;
    

    private $pdo = null;
    

    private $dbPath = '/www/wwwroot/www.ctsqnb.xyz/data/toolbox.db';
    

    private $dbVersion = '1.0.0';
    

    private function __construct() {
        try {

            $this->ensureDataDirectory();
            

            $this->pdo = new PDO('sqlite:' . $this->dbPath);
            

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            

            $this->initDatabase();
            
        } catch (PDOException $e) {
            die('数据库连接失败: ' . $e->getMessage());
        }
    }
    

    private function ensureDataDirectory() {
        $dataDir = dirname($this->dbPath);
        if (!is_dir($dataDir)) {
            mkdir($dataDir, 0755, true);
        }
    }
    

    private function initDatabase() {

        $stmt = $this->pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='settings'");
        $hasSettings = $stmt->fetch();
        

        if (!$hasSettings) {
            $this->createTables();
            $this->insertInitialData();
        }
    }
    

    private function createTables() {
        $sql = "";
        $sql .= "CREATE TABLE IF NOT EXISTS tools (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            tool_id VARCHAR(50) NOT NULL UNIQUE,
            name VARCHAR(100) NOT NULL,
            icon VARCHAR(20) NOT NULL,
            description TEXT,
            category VARCHAR(50) NOT NULL,
            url VARCHAR(255) NOT NULL,
            status VARCHAR(20) NOT NULL DEFAULT 'active',
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        );
        ";

        $sql .= "CREATE TABLE IF NOT EXISTS history (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            tool_id VARCHAR(50) NOT NULL,
            tool_name VARCHAR(100) NOT NULL,
            content TEXT,
            result TEXT,
            ip_address VARCHAR(50),
            user_agent TEXT,
            start_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            end_time DATETIME,
            response_time FLOAT,
            status VARCHAR(20) NOT NULL DEFAULT 'success',
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        );
        ";

        $sql .= "CREATE TABLE IF NOT EXISTS daily_stats (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            date DATE NOT NULL UNIQUE,
            visit_count INTEGER NOT NULL DEFAULT 0,
            call_count INTEGER NOT NULL DEFAULT 0,
            success_count INTEGER NOT NULL DEFAULT 0,
            total_response_time FLOAT NOT NULL DEFAULT 0,
            avg_response_time FLOAT NOT NULL DEFAULT 0,
            updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        );
        ";

        $sql .= "CREATE TABLE IF NOT EXISTS tool_stats (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            tool_id VARCHAR(50) NOT NULL,
            tool_name VARCHAR(100) NOT NULL,
            date DATE NOT NULL,
            call_count INTEGER NOT NULL DEFAULT 0,
            success_count INTEGER NOT NULL DEFAULT 0,
            total_response_time FLOAT NOT NULL DEFAULT 0,
            avg_response_time FLOAT NOT NULL DEFAULT 0,
            updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            UNIQUE(tool_id, date)
        );
        ";

        $sql .= "CREATE TABLE IF NOT EXISTS tool_total_stats (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            tool_id VARCHAR(50) NOT NULL UNIQUE,
            tool_name VARCHAR(100) NOT NULL,
            total_call_count INTEGER NOT NULL DEFAULT 0,
            total_success_count INTEGER NOT NULL DEFAULT 0,
            total_response_time FLOAT NOT NULL DEFAULT 0,
            avg_response_time FLOAT NOT NULL DEFAULT 0,
            last_call_time DATETIME,
            updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        );
        ";

        $sql .= "CREATE INDEX IF NOT EXISTS idx_tool_stats_tool_id ON tool_stats(tool_id);
        ";
        $sql .= "CREATE INDEX IF NOT EXISTS idx_tool_stats_date ON tool_stats(date);
        ";
        $sql .= "CREATE INDEX IF NOT EXISTS idx_tool_total_stats_tool_id ON tool_total_stats(tool_id);
        ";

        $sql .= "CREATE TABLE IF NOT EXISTS settings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            `key` VARCHAR(50) NOT NULL UNIQUE,
            `value` TEXT,
            description TEXT,
            updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        );
        ";

        $sql .= "CREATE INDEX IF NOT EXISTS idx_history_tool_id ON history(tool_id);
        ";
        $sql .= "CREATE INDEX IF NOT EXISTS idx_history_created_at ON history(created_at);
        ";
        $sql .= "CREATE INDEX IF NOT EXISTS idx_tools_category ON tools(category);
        ";
        $sql .= "CREATE INDEX IF NOT EXISTS idx_tools_status ON tools(status);
        ";
        

        $this->pdo->exec($sql);
    }
    

    private function insertInitialData() {

        $this->pdo->prepare("INSERT INTO settings (`key`, `value`, description) VALUES (?, ?, ?)")
            ->execute(['db_version', $this->dbVersion, '数据库版本']);
        

        $this->pdo->prepare("INSERT INTO settings (`key`, `value`, description) VALUES (?, ?, ?)")
            ->execute(['site_name', '工具箱', '网站名称']);
        $this->pdo->prepare("INSERT INTO settings (`key`, `value`, description) VALUES (?, ?, ?)")
            ->execute(['history_limit', '100', '每个工具保存的历史记录数量限制']);
    }
    

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    

    public function getPdo() {
        return $this->pdo;
    }
    

    public function fetchAll($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    

    public function fetchOne($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }
    

    public function execute($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }
    

    public function insert($table, $data) {

        $fields = array_keys($data);
        $fieldList = implode(', ', $fields);
        

        $placeholders = ':' . implode(', :', $fields);
        

        $sql = "INSERT INTO $table ($fieldList) VALUES ($placeholders)";
        

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        

        return $this->pdo->lastInsertId();
    }
    

    public function update($table, $data, $where, $whereParams = []) {

        $setClause = [];
        foreach (array_keys($data) as $field) {
            $setClause[] = "$field = :$field";
        }
        $setClause = implode(', ', $setClause);
        

        $sql = "UPDATE $table SET $setClause WHERE $where";
        

        $params = array_merge($data, $whereParams);
        

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        

        return $stmt->rowCount();
    }
    

    public function delete($table, $where, $params = []) {

        $sql = "DELETE FROM $table WHERE $where";
        

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        

        return $stmt->rowCount();
    }
    

    public function beginTransaction() {
        $this->pdo->beginTransaction();
    }
    

    public function commit() {
        $this->pdo->commit();
    }
    

    public function rollBack() {
        $this->pdo->rollBack();
    }
    

    public function getVersion() {
        return $this->dbVersion;
    }
    

    public function getDbPath() {
        return $this->dbPath;
    }
}
?>