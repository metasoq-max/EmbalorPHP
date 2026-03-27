<?php

declare(strict_types=1);

session_start();
$root = dirname(__DIR__);
$configPath = $root . '/config/app.php';

if (file_exists($configPath)) {
    echo '<h2 dir="rtl">تم تثبيت النظام مسبقاً. احذف config/app.php لإعادة التثبيت.</h2>';
    exit;
}

$errors = [];
$success = null;

$detectedScheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$detectedHost = $_SERVER['HTTP_HOST'] ?? 'localhost';
$autoBaseUrl = $detectedScheme . '://' . $detectedHost;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbHost = trim($_POST['db_host'] ?? '127.0.0.1');
    $dbPort = trim($_POST['db_port'] ?? '3306');
    $dbName = trim($_POST['db_name'] ?? 'embalor');
    $dbUser = trim($_POST['db_user'] ?? 'root');
    $dbPass = $_POST['db_pass'] ?? '';
    $baseUrlInput = trim($_POST['base_url'] ?? '');
    $baseUrl = rtrim($baseUrlInput !== '' ? $baseUrlInput : $autoBaseUrl, '/');
    $baseUrl = preg_replace('#/web$#i', '', $baseUrl);
    $baseUrl = preg_replace('#/web/index\.php$#i', '', $baseUrl);

    $adminName = trim($_POST['admin_name'] ?? '');
    $adminEmail = trim($_POST['admin_email'] ?? '');
    $adminPassword = $_POST['admin_password'] ?? '';
    $adminPhone = trim($_POST['admin_phone'] ?? '');

    if (!$adminName || !$adminEmail || !$adminPhone || strlen($adminPassword) < 6) {
        $errors[] = 'بيانات المدير غير مكتملة أو كلمة المرور قصيرة.';
    }

    if (!$errors) {
        try {
            $pdo = new PDO("mysql:host={$dbHost};port={$dbPort};charset=utf8mb4", $dbUser, $dbPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `{$dbName}`");
            $schema = file_get_contents($root . '/database/schema.sql');
            $pdo->exec($schema);

            $pdo->prepare('INSERT INTO users (name, email, phone, password, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())')
                ->execute([$adminName, $adminEmail, $adminPhone, password_hash($adminPassword, PASSWORD_DEFAULT), 'admin']);

            $defaultSettings = [
                'site_title' => 'Embalor',
                'hero_title' => 'الأومبلاج وسيلة لزيادة المبيعات، وليس مجرد كرتونة.',
                'hero_subtitle' => 'نقدم حلول تغليف عصرية مدروسة بصرياً وتسويقياً لتعزيز حضور منتجك.',
                'primary_color' => '#4f46e5',
                'secondary_color' => '#0ea5e9',
                'support_email' => 'support@embalor.com',
                'support_phone' => '+212600000000',
                'base_url' => $baseUrl,
                'site_logo' => '',
            ];

            $stmt = $pdo->prepare('INSERT INTO settings (setting_key, setting_value, updated_at) VALUES (?, ?, NOW())');
            foreach ($defaultSettings as $key => $value) {
                $stmt->execute([$key, $value]);
            }

            $typeStmt = $pdo->prepare('INSERT INTO packaging_types (type_name, is_active, created_at) VALUES (?, 1, NOW())');
            foreach (['علبة كرتونية', 'كيس بلاستيكي', 'قنينة', 'تيوب', 'تغليف مخصص'] as $typeName) {
                $typeStmt->execute([$typeName]);
            }


            $config = "<?php\n\nreturn [\n    'app_name' => 'Embalor',\n    'base_url' => '" . addslashes($baseUrl) . "',\n    'db' => [\n        'host' => '" . addslashes($dbHost) . "',\n        'port' => '" . addslashes($dbPort) . "',\n        'name' => '" . addslashes($dbName) . "',\n        'user' => '" . addslashes($dbUser) . "',\n        'pass' => '" . addslashes($dbPass) . "',\n    ],\n];\n";
            file_put_contents($configPath, $config);

            if (!is_dir($root . '/web/uploads')) {
                mkdir($root . '/web/uploads', 0775, true);
            }

            $success = 'تم التثبيت بنجاح! افتح الموقع مباشرة من الجذر domain.com';
        } catch (Throwable $e) {
            $errors[] = 'فشل التثبيت: ' . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installer - Embalor</title>
    <style>body{font-family:system-ui;background:#eef2ff;margin:0;padding:20px}.box{max-width:760px;margin:20px auto;background:#fff;padding:24px;border-radius:16px;box-shadow:0 20px 40px rgba(0,0,0,.1)}input{width:100%;padding:11px;border:1px solid #ddd;border-radius:10px;margin:8px 0 14px}button{padding:11px 18px;background:#4f46e5;color:#fff;border:none;border-radius:10px;cursor:pointer}.err{background:#fee2e2;padding:10px;border-radius:8px;margin-bottom:8px}.ok{background:#dcfce7;padding:10px;border-radius:8px;margin-bottom:8px}</style>
</head>
<body>
<div class="box">
    <h2>تثبيت Embalor</h2>
    <?php foreach ($errors as $error): ?><div class="err"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endforeach; ?>
    <?php if ($success): ?><div class="ok"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
    <form method="post">
        <h3>إعدادات الموقع</h3>
        <input name="base_url" placeholder="Base URL مثال: https://domain.com" value="<?= htmlspecialchars($autoBaseUrl, ENT_QUOTES, 'UTF-8') ?>">
        <h3>إعدادات قاعدة البيانات</h3>
        <input name="db_host" value="127.0.0.1" required>
        <input name="db_port" value="3306" required>
        <input name="db_name" value="embalor" required>
        <input name="db_user" value="root" required>
        <input name="db_pass" placeholder="DB Password" type="password">
        <h3>حساب المدير الأول</h3>
        <input name="admin_name" placeholder="اسم المدير" required>
        <input name="admin_email" placeholder="بريد المدير" type="email" required>
        <input name="admin_phone" placeholder="هاتف المدير" required>
        <input name="admin_password" placeholder="كلمة المرور" type="password" minlength="6" required>
        <button type="submit">تثبيت النظام</button>
    </form>
</div>
</body>
</html>
