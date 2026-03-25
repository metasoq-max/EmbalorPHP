<div class="card" style="max-width:760px;margin:auto;">
    <h2>إعدادات الموقع والتحكم في الديزاين</h2>
    <form method="post" action="<?= e(route_url('admin.settings')) ?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <label>اسم الموقع</label><input type="text" name="site_title" value="<?= e($settings['site_title'] ?? '') ?>">
        <label>لوغو الموقع (بدل الكتابة)</label><input type="file" name="site_logo" accept=".png,.jpg,.jpeg,.webp,.svg">
        <?php if (!empty($settings['site_logo'])): ?><p><img src="<?= e(base_url($settings['site_logo'])) ?>" alt="logo" style="height:55px;background:#fff;padding:4px;border-radius:8px"></p><?php endif; ?>
        <label>عنوان الواجهة الرئيسية</label><input type="text" name="hero_title" value="<?= e($settings['hero_title'] ?? '') ?>">
        <label>النص التسويقي</label><textarea name="hero_subtitle" rows="3"><?= e($settings['hero_subtitle'] ?? '') ?></textarea>
        <label>اللون الرئيسي</label><input type="color" name="primary_color" value="<?= e($settings['primary_color'] ?? '#4f46e5') ?>">
        <label>اللون الثانوي</label><input type="color" name="secondary_color" value="<?= e($settings['secondary_color'] ?? '#0ea5e9') ?>">
        <label>البريد الرسمي</label><input type="email" name="support_email" value="<?= e($settings['support_email'] ?? '') ?>">
        <label>هاتف التواصل</label><input type="text" name="support_phone" value="<?= e($settings['support_phone'] ?? '') ?>">
        <label>Base URL (باش يدخل دومين مباشر بلا /public)</label><input type="text" name="base_url" placeholder="https://domain.com" value="<?= e($settings['base_url'] ?? '') ?>">
        <button class="btn" type="submit">حفظ الإعدادات</button>
    </form>
</div>
