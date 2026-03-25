<div class="card">
    <h2>مرحباً <?= e($user['name']) ?></h2>
    <p class="muted">الدور: <strong><?= e($user['role']) ?></strong></p>

    <?php if ($user['role'] === 'customer'): ?>
        <a class="btn" href="/public/index.php?r=requests.create">إنشاء طلب أومبلاج جديد</a>
    <?php elseif ($user['role'] === 'admin'): ?>
        <a class="btn" href="/public/index.php?r=admin.users.create">إضافة مستخدم/موظف</a>
    <?php endif; ?>
</div>

<div class="card">
    <h3>الطلبات</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>العنوان</th>
                <th>النوع</th>
                <th>الحالة</th>
                <th>تفاصيل</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $r): ?>
                <tr>
                    <td><?= (int) $r['id'] ?></td>
                    <td><?= e($r['title'] ?: 'بدون عنوان') ?></td>
                    <td><?= e($r['service_type']) ?></td>
                    <td><span class="badge"><?= e($r['status']) ?></span></td>
                    <td><a class="btn light" href="/public/index.php?r=requests.show&id=<?= (int) $r['id'] ?>">عرض</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
