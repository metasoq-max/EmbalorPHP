<?php

declare(strict_types=1);

session_start();

$root = dirname(__DIR__);
$configFile = $root . '/config/app.php';

if (!file_exists($configFile)) {
    header('Location: /install/');
    exit;
}

require_once $root . '/app/Core/helpers.php';
require_once $root . '/app/Core/Database.php';
require_once $root . '/app/Core/Auth.php';
require_once $root . '/app/Controllers/HomeController.php';
require_once $root . '/app/Controllers/AuthController.php';
require_once $root . '/app/Controllers/DashboardController.php';
require_once $root . '/app/Controllers/RequestController.php';
require_once $root . '/app/Controllers/AdminController.php';

$config = require $configFile;
$db = new App\Core\Database($config['db']);
$auth = new App\Core\Auth($db);

$route = $_GET['r'] ?? 'home';
$method = $_SERVER['REQUEST_METHOD'];

$home = new App\Controllers\HomeController($db, $auth);
$authController = new App\Controllers\AuthController($db, $auth);
$dashboard = new App\Controllers\DashboardController($db, $auth);
$requestController = new App\Controllers\RequestController($db, $auth);
$admin = new App\Controllers\AdminController($db, $auth);

switch ($route) {
    case 'home':
        $home->index();
        break;

    case 'login':
        $method === 'POST' ? $authController->loginSubmit() : $authController->loginForm();
        break;

    case 'register':
        $method === 'POST' ? $authController->registerSubmit() : $authController->registerForm();
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'dashboard':
        $dashboard->index();
        break;

    case 'requests.create':
        $method === 'POST' ? $requestController->store() : $requestController->create();
        break;

    case 'requests.index':
        $requestController->index();
        break;

    case 'requests.show':
        $requestController->show((int) ($_GET['id'] ?? 0));
        break;

    case 'requests.update_status':
        $requestController->updateStatus((int) ($_GET['id'] ?? 0));
        break;

    case 'admin.users':
        $admin->users();
        break;

    case 'admin.users.create':
        $method === 'POST' ? $admin->storeUser() : $admin->createUser();
        break;

    case 'admin.assign':
        $admin->assignRequest((int) ($_GET['id'] ?? 0));
        break;

    default:
        http_response_code(404);
        echo 'الصفحة غير موجودة';
        break;
}
