<?php
require_once 'controllers/HocPhanController.php';

$controller = new HocPhanController();

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch($action) {
    case 'register':
        $controller->register();
        break;
    case 'unregister':
        $controller->unregister();
        break;
    case 'unregister_all':
        $controller->unregister_all();
        break;
    case 'myCourses':
        $controller->myCourses();
        break;
    default:
        $controller->index();
        break;
}
?>