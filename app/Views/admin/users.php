<div class="card">
    <h2>إدارة المستخدمين</h2>
    <a class="btn" href="<?= e(route_url('admin.users.create')) ?>">إضافة مستخدم</a>
</div>
<div class="card table-responsive">
<table>
<thead><tr><th>#</th><th>الاسم</th><th>البريد</th><th>الهاتف</th><th>الدور</th><th>الحالة</th><th>إجراء</th></tr></thead>
<tbody>
<?php foreach ($users as $u): ?>
<tr>
<td><?= (int)$u['id'] ?></td>
<td><?= e($u['name']) ?></td>
<td><?= e($u['email']) ?></td>
<td><?= e($u['phone'] ?? '-') ?></td>
<td><span class="badge"><?= e($u['role']) ?></span></td>
<td><?= (int)$u['is_banned'] === 1 ? 'محظور' : 'نشط' ?></td>
<td>
<?php if ($u['role'] !== 'admin'): ?>
<form method="post" action="<?= e(route_url('admin.user.ban', ['id' => (int)$u['id']])) ?>">
<input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
<button class="btn light" type="submit"><?= (int)$u['is_banned'] === 1 ? 'رفع الحظر' : 'حظر' ?></button>
</form>
<?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
