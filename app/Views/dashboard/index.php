<div class="grid">
    <div class="card"><div class="muted">الاسم</div><div class="kpi"><?= e($user['name']) ?></div></div>
    <div class="card"><div class="muted">الدور</div><div class="kpi"><?= e($user['role']) ?></div></div>
    <div class="card"><div class="muted">عدد الطلبات</div><div class="kpi"><?= count($requests) ?></div></div>
</div>

<div class="card">
    <?php if ($user['role'] === 'customer'): ?>
        <a class="btn" href="<?= e(route_url('requests.create')) ?>">+ إنشاء طلب أومبلاج</a>
    <?php elseif ($user['role'] === 'admin'): ?>
        <a class="btn" href="<?= e(route_url('admin.users.create')) ?>">+ إضافة مستخدم</a>
    <?php endif; ?>
</div>

<div class="card">
    <h3>الطلبات</h3>
    <table>
        <thead><tr><th>#</th><th>العنوان</th><th>النوع</th><th>السعر</th><th>الحالة</th><th>تفاصيل</th></tr></thead>
        <tbody>
        <?php foreach ($requests as $r): ?>
            <tr>
                <td><?= (int) $r['id'] ?></td>
                <td><?= e($r['title'] ?: 'بدون عنوان') ?></td>
                <td><?= e($r['service_type']) ?></td>
                <td><?= $r['estimated_price'] ? e(number_format((float)$r['estimated_price'],2)) . ' MAD' : '-' ?></td>
                <td><span class="badge"><?= e($r['status']) ?></span></td>
                <td><a class="btn light" href="<?= e(route_url('requests.show', ['id' => (int)$r['id']])) ?>">عرض</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
