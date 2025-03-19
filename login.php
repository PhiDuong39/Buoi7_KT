<?php
session_start();
require_once 'controllers/AuthController.php';

$controller = new AuthController();

$action = isset($_GET['action']) ? $_GET['action'] : 'login';

switch ($action) {
    case 'login':
        $controller->login();
        break;
    case 'register':
        $controller->register();
        break;
    case 'logout':
        $controller->logout();
        break;
    default:
        $controller->login();
}
?> 