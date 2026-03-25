<div class="card">
    <h2>إدارة المستخدمين</h2>
    <a class="btn" href="/public/index.php?r=admin.users.create">إضافة مستخدم جديد</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>البريد</th>
                <th>الهاتف</th>
                <th>الدور</th>
                <th>تاريخ الإنشاء</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= (int) $u['id'] ?></td>
                    <td><?= e($u['name']) ?></td>
                    <td><?= e($u['email']) ?></td>
                    <td><?= e($u['phone'] ?? '-') ?></td>
                    <td><span class="badge"><?= e($u['role']) ?></span></td>
                    <td><?= e($u['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
