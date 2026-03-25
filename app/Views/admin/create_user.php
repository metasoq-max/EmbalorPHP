<div class="card" style="max-width:620px; margin:auto;">
    <h2>إضافة مستخدم/موظف</h2>
    <form method="post" action="/public/index.php?r=admin.users.create">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">

        <label>الاسم</label>
        <input type="text" name="name" required>

        <label>البريد الإلكتروني</label>
        <input type="email" name="email" required>

        <label>الهاتف</label>
        <input type="text" name="phone">

        <label>كلمة المرور</label>
        <input type="password" name="password" required>

        <label>الدور</label>
        <select name="role" required>
            <option value="worker">Worker</option>
            <option value="designer">Designer</option>
            <option value="admin">Admin</option>
            <option value="customer">Customer</option>
        </select>

        <button class="btn" type="submit">حفظ</button>
    </form>
</div>
