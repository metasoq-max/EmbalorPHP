<?php
$currentUser = ['id' => $_SESSION['user_id'] ?? null, 'role' => $_SESSION['user_role'] ?? null, 'name' => $_SESSION['user_name'] ?? null];
$siteTitle = setting('site_title', 'Embalor');
$primary = setting('primary_color', '#4f46e5');
$secondary = setting('secondary_color', '#0ea5e9');
$siteLogo = setting('site_logo', '');
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($siteTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(base_url('assets/css/app.css')) ?>">
    <style>:root{--primary:<?= e($primary) ?>;--secondary:<?= e($secondary) ?>}</style>
</head>
<body>
<nav class="nav">
    <div class="nav-start">
        <button class="menu-btn" id="menu-toggle" aria-label="menu">☰</button>
        <a class="brand" href="<?= e(route_url('home')) ?>">
            <?php if ($siteLogo): ?><img src="<?= e(base_url($siteLogo)) ?>" alt="logo" class="logo"><?php else: ?><?= e($siteTitle) ?><?php endif; ?>
        </a>
        <?php if ($currentUser['id'] && $currentUser['role'] === 'customer'): ?>
            <a class="icon-btn" title="طلب جديد" href="<?= e(route_url('requests.create')) ?>">＋</a>
        <?php endif; ?>
        <?php if ($currentUser['id']): ?>
            <a class="icon-btn" title="الإشعارات" href="<?= e(route_url('notifications.latest')) ?>">🔔<span id="notif-badge" class="notif">0</span></a>
        <?php endif; ?>
    </div>

    <div class="nav-links desktop-links">
        <?php if ($currentUser['id']): ?>
            <a href="<?= e(route_url('dashboard')) ?>">لوحة التحكم</a>
            <?php if ($currentUser['role'] === 'admin'): ?>
                <a href="<?= e(route_url('admin.users')) ?>">المستخدمون</a>
                <a href="<?= e(route_url('admin.settings')) ?>">إعدادات الموقع</a>
            <?php endif; ?>
            <a href="<?= e(route_url('logout')) ?>">تسجيل الخروج</a>
        <?php else: ?>
            <a href="<?= e(route_url('login')) ?>">دخول</a>
            <a href="<?= e(route_url('register')) ?>">حساب جديد</a>
        <?php endif; ?>
    </div>
</nav>

<div class="mobile-drawer" id="mobile-drawer">
    <div class="drawer-card">
        <?php if ($currentUser['id']): ?>
            <a href="<?= e(route_url('dashboard')) ?>">لوحة التحكم</a>
            <?php if ($currentUser['role'] === 'admin'): ?>
                <a href="<?= e(route_url('admin.users')) ?>">المستخدمون</a>
                <a href="<?= e(route_url('admin.settings')) ?>">إعدادات الموقع</a>
            <?php endif; ?>
            <a href="<?= e(route_url('notifications.latest')) ?>">🔔 الرسائل الجديدة</a>
            <?php if ($currentUser['role'] === 'customer'): ?>
                <a href="<?= e(route_url('requests.create')) ?>">＋ طلب جديد</a>
            <?php endif; ?>
            <a href="<?= e(route_url('logout')) ?>">تسجيل الخروج</a>
        <?php else: ?>
            <a href="<?= e(route_url('login')) ?>">دخول</a>
            <a href="<?= e(route_url('register')) ?>">حساب جديد</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
<?php if ($msg = flash('success')): ?><div class="alert success"><?= e($msg) ?></div><?php endif; ?>
<?php if ($msg = flash('error')): ?><div class="alert error"><?= e($msg) ?></div><?php endif; ?>
