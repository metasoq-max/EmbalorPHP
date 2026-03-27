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
if (!empty($config['base_url'])) {
    $config['base_url'] = normalize_base_url((string) $config['base_url']);
}
$GLOBALS['app_config'] = $config;
$db = new App\Core\Database($config['db']);
$auth = new App\Core\Auth($db);

$settingsRows = $db->query('SELECT setting_key, setting_value FROM settings');
$_SESSION['settings'] = [];
foreach ($settingsRows as $row) {
    $_SESSION['settings'][$row['setting_key']] = $row['setting_value'];
}

$route = $_GET['r'] ?? null;
if ($route === null) {
    $path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
    $path = preg_replace('#^web/#', '', $path);
    if ($path === '' || $path === 'index.php') $route = 'home';
    elseif ($path === 'login') $route = 'login';
    elseif ($path === 'register') $route = 'register';
    elseif ($path === 'logout') $route = 'logout';
    elseif ($path === 'dashboard') $route = 'dashboard';
    elseif ($path === 'requests/create') $route = 'requests.create';
    elseif (preg_match('#^requests/(\d+)$#', $path, $m)) { $route = 'requests.show'; $_GET['id'] = (int) $m[1]; }
    elseif ($path === 'admin/users') $route = 'admin.users';
    elseif ($path === 'admin/users/create') $route = 'admin.users.create';
    elseif ($path === 'admin/settings') $route = 'admin.settings';
    elseif ($path === 'notifications/latest') $route = 'notifications.latest';
    else $route = 'home';
}

$_SESSION['current_page'] = $route;
$method = $_SERVER['REQUEST_METHOD'];

$home = new App\Controllers\HomeController($db, $auth);
$authController = new App\Controllers\AuthController($db, $auth);
$dashboard = new App\Controllers\DashboardController($db, $auth);
$requestController = new App\Controllers\RequestController($db, $auth);
$admin = new App\Controllers\AdminController($db, $auth);

switch ($route) {
    case 'home': $home->index(); break;
    case 'login': $method === 'POST' ? $authController->loginSubmit() : $authController->loginForm(); break;
    case 'register': $method === 'POST' ? $authController->registerSubmit() : $authController->registerForm(); break;
    case 'logout': $authController->logout(); break;
    case 'dashboard': $dashboard->index(); break;
    case 'requests.create': $method === 'POST' ? $requestController->store() : $requestController->create(); break;
    case 'requests.show': $requestController->show((int) ($_GET['id'] ?? 0)); break;
    case 'requests.update_status': $requestController->updateStatus((int) ($_GET['id'] ?? 0)); break;
    case 'requests.update_price': $requestController->updatePrice((int) ($_GET['id'] ?? 0)); break;
    case 'messages.send': $requestController->sendMessage((int) ($_GET['id'] ?? 0)); break;
    case 'messages.latest_id': $requestController->latestMessageId((int) ($_GET['id'] ?? 0)); break;
    case 'notifications.count': $requestController->notificationsCount(); break;
    case 'notifications.latest': $requestController->latestNotification(); break;
    case 'admin.users': $admin->users(); break;
    case 'admin.users.create': $method === 'POST' ? $admin->storeUser() : $admin->createUser(); break;
    case 'admin.assign': $admin->assignRequest((int) ($_GET['id'] ?? 0)); break;
    case 'admin.user.ban': $admin->toggleBan((int) ($_GET['id'] ?? 0)); break;
    case 'admin.user.password': $admin->resetPassword((int) ($_GET['id'] ?? 0)); break;
    case 'admin.types.add': $admin->addPackagingType(); break;
    case 'admin.types.delete': $admin->deletePackagingType((int) ($_GET['id'] ?? 0)); break;
    case 'admin.settings': $method === 'POST' ? $admin->updateSettings() : $admin->settings(); break;
    default: http_response_code(404); echo 'الصفحة غير موجودة'; break;
}
