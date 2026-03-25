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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbHost = trim($_POST['db_host'] ?? '127.0.0.1');
    $dbPort = trim($_POST['db_port'] ?? '3306');
    $dbName = trim($_POST['db_name'] ?? 'embalor');
    $dbUser = trim($_POST['db_user'] ?? 'root');
    $dbPass = $_POST['db_pass'] ?? '';

    $adminName = trim($_POST['admin_name'] ?? '');
    $adminEmail = trim($_POST['admin_email'] ?? '');
    $adminPassword = $_POST['admin_password'] ?? '';

    if (!$adminName || !$adminEmail || strlen($adminPassword) < 6) {
        $errors[] = 'بيانات المدير غير مكتملة أو كلمة المرور قصيرة.';
    }

    if (!$errors) {
        try {
            $pdo = new PDO("mysql:host={$dbHost};port={$dbPort};charset=utf8mb4", $dbUser, $dbPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `{$dbName}`");

            $schema = file_get_contents($root . '/database/schema.sql');
            $pdo->exec($schema);

            $stmt = $pdo->prepare('INSERT INTO users (name, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())');
            $stmt->execute([$adminName, $adminEmail, password_hash($adminPassword, PASSWORD_DEFAULT), 'admin']);

            $config = "<?php\n\nreturn [\n    'app_name' => 'Embalor',\n    'db' => [\n        'host' => '" . addslashes($dbHost) . "',\n        'port' => '" . addslashes($dbPort) . "',\n        'name' => '" . addslashes($dbName) . "',\n        'user' => '" . addslashes($dbUser) . "',\n        'pass' => '" . addslashes($dbPass) . "',\n    ],\n];\n";
            file_put_contents($configPath, $config);

            if (!is_dir($root . '/public/uploads')) {
                mkdir($root . '/public/uploads', 0775, true);
            }

            $success = 'تم التثبيت بنجاح! انتقل الآن إلى /public';
        } catch (Throwable $e) {
            $errors[] = 'فشل التثبيت: ' . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installer - Embalor</title>
    <style>
        body{font-family:Tahoma,Arial,sans-serif;background:#f1f5f9;margin:0;padding:20px}
        .box{max-width:760px;margin:20px auto;background:#fff;padding:24px;border-radius:12px}
        input{width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;margin:8px 0 14px}
        button{padding:10px 16px;background:#2563eb;color:#fff;border:none;border-radius:8px;cursor:pointer}
        .err{background:#fee2e2;padding:10px;border-radius:8px;margin-bottom:8px}
        .ok{background:#dcfce7;padding:10px;border-radius:8px;margin-bottom:8px}
    </style>
</head>
<body>
<div class="box">
    <h2>تثبيت Embalor</h2>

    <?php foreach ($errors as $error): ?>
        <div class="err"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endforeach; ?>
    <?php if ($success): ?>
        <div class="ok"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form method="post">
        <h3>إعدادات قاعدة البيانات</h3>
        <input name="db_host" placeholder="DB Host" value="127.0.0.1" required>
        <input name="db_port" placeholder="DB Port" value="3306" required>
        <input name="db_name" placeholder="DB Name" value="embalor" required>
        <input name="db_user" placeholder="DB User" value="root" required>
        <input name="db_pass" placeholder="DB Password" type="password">

        <h3>حساب المدير الأول</h3>
        <input name="admin_name" placeholder="اسم المدير" required>
        <input name="admin_email" placeholder="بريد المدير" type="email" required>
        <input name="admin_password" placeholder="كلمة المرور" type="password" minlength="6" required>

        <button type="submit">تثبيت النظام</button>
    </form>
</div>
</body>
</html>
