<div class="card" style="max-width:560px;margin:auto;">
    <h2>إنشاء حساب عميل</h2>
    <form method="post" action="<?= e(route_url('register')) ?>">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <label>الاسم الكامل</label><input type="text" name="name" required>
        <label>البريد الإلكتروني</label><input type="email" name="email" required>
        <label>رقم الهاتف</label><input type="text" name="phone" required>
        <label>كلمة المرور</label><input type="password" name="password" required minlength="6">
        <button class="btn" type="submit">إنشاء الحساب</button>
    </form>
</div>
