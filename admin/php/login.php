<?php
session_start();

$VALID_USERNAME = 'admin';
$VALID_PASSWORD = 'admin';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if (empty($username) || empty($password)) {
        header('Location: ../login.php?error=required');
        exit;
    }
    
    if ($username === $VALID_USERNAME && $password === $VALID_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        
        header('Location: ../index.php');
        exit;
    } else {
        header('Location: ../login.php?error=invalid');
        exit;
    }
} else {
    header('Location: ../login.php');
    exit;
}
