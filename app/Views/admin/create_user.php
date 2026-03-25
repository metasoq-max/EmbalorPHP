<div class="card" style="max-width:620px;margin:auto;">
    <h2>إضافة مستخدم/موظف</h2>
    <form method="post" action="<?= e(route_url('admin.users.create')) ?>">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
https://github.com/metasoq-max/EmbalorPHP/pull/2/conflict?name=app%252FViews%252Fadmin%252Fcreate_user.php&base_oid=d6e9344786b73d9fa91b2bd6e728742017daa12e&head_oid=5d9c05b66fe8ceda09e5f5a621567488f0a8d991        <label>الاسم</label><input type="text" name="name" required>
        <label>البريد الإلكتروني</label><input type="email" name="email" required>
        <label>الهاتف</label><input type="text" name="phone">
        <label>كلمة المرور</label><input type="password" name="password" required>
        <label>الدور</label>
        <select name="role" required><option value="worker">Worker</option><option value="designer">Designer</option><option value="admin">Admin</option><option value="customer">Customer</option></select>
        <button class="btn" type="submit">حفظ</button>
    </form>
</div>
