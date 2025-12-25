<?php
function isAdminLoggedIn() {
    session_start();
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireAdminLogin() {
    if (!isAdminLoggedIn()) {
        header('Location: ../login.php');
        exit;
    }
}

function getCurrentAdmin() {
    session_start();
    if (isset($_SESSION['admin_username'])) {
        return [
            'username' => $_SESSION['admin_username']
        ];
    }
    return null;
}

function adminLogout() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: ../login.php');
    exit;
}
