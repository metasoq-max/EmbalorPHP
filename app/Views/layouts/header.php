<?php
$currentUser = [
    'id' => $_SESSION['user_id'] ?? null,
    'role' => $_SESSION['user_role'] ?? null,
    'name' => $_SESSION['user_name'] ?? null,
];
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Embalor</title>
    <style>
        body {font-family: Tahoma, Arial, sans-serif; margin:0; background:#f4f6fb; color:#1c2333;}
        .nav {background:#0f172a; padding:14px 20px; display:flex; justify-content:space-between; align-items:center;}
        .nav a {color:#fff; text-decoration:none; margin-left:10px;}
        .brand {font-weight:700; color:#38bdf8 !important;}
        .container {max-width:1100px; margin:24px auto; padding:0 16px;}
        .card {background:#fff; border-radius:14px; padding:20px; box-shadow:0 8px 20px rgba(15,23,42,.08); margin-bottom:16px;}
        .hero {background:linear-gradient(120deg,#0f172a,#1d4ed8); color:#fff; padding:40px; border-radius:16px;}
        .btn {display:inline-block; background:#2563eb; color:#fff; border:none; border-radius:10px; padding:10px 16px; text-decoration:none; cursor:pointer;}
        .btn.secondary {background:#0f766e;}
        .btn.light {background:#e2e8f0; color:#111827;}
        input, select, textarea {width:100%; padding:10px; border:1px solid #d1d5db; border-radius:10px; margin-top:6px; margin-bottom:12px; box-sizing:border-box;}
        label {font-weight:600;}
        table {width:100%; border-collapse:collapse;}
        th, td {padding:10px; border-bottom:1px solid #eee; text-align:right;}
        .alert {padding:12px; border-radius:10px; margin-bottom:14px;}
        .success {background:#dcfce7; color:#166534;}
        .error {background:#fee2e2; color:#991b1b;}
        .muted {color:#6b7280; font-size:.9rem;}
        .grid {display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:16px;}
        .badge {padding:4px 10px; border-radius:99px; font-size:.85rem; background:#e2e8f0;}
    </style>
</head>
<body>
<nav class="nav">
    <div>
        <a href="/public/index.php?r=home" class="brand">Embalor</a>
    </div>
    <div>
        <?php if ($currentUser['id']): ?>
            <a href="/public/index.php?r=dashboard">لوحة التحكم</a>
            <?php if ($currentUser['role'] === 'admin'): ?>
                <a href="/public/index.php?r=admin.users">المستخدمون</a>
            <?php endif; ?>
            <a href="/public/index.php?r=logout">تسجيل الخروج</a>
        <?php else: ?>
            <a href="/public/index.php?r=login">دخول</a>
            <a href="/public/index.php?r=register">حساب جديد</a>
        <?php endif; ?>
    </div>
</nav>
<div class="container">
    <?php if ($msg = flash('success')): ?><div class="alert success"><?= e($msg) ?></div><?php endif; ?>
    <?php if ($msg = flash('error')): ?><div class="alert error"><?= e($msg) ?></div><?php endif; ?>
