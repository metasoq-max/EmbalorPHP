<div class="card" style="max-width:520px; margin:auto;">
    <h2>تسجيل الدخول</h2>
    <form method="post" action="/public/index.php?r=login">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <label>البريد الإلكتروني</label>
        <input type="email" name="email" required>

        <label>كلمة المرور</label>
        <input type="password" name="password" required>

        <button class="btn" type="submit">دخول</button>
    </form>
</div>
