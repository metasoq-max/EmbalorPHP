<div class="card" style="max-width:980px;margin:auto;">
    <h2>لوحة التحكم المتقدمة للموقع</h2>
    <form method="post" action="<?= e(route_url('admin.settings')) ?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">

        <h3>الهوية العامة</h3>
        <label>اسم الموقع</label><input type="text" name="site_title" value="<?= e($settings['site_title'] ?? '') ?>">
        <label>اللوغو</label><input type="file" name="site_logo" accept=".png,.jpg,.jpeg,.webp,.svg">
        <?php if (!empty($settings['site_logo'])): ?><p><img src="<?= e(base_url($settings['site_logo'])) ?>" alt="logo" style="height:55px"></p><?php endif; ?>

        <h3>محتوى الصفحة الرئيسية</h3>
        <label>عنوان البطل (Hero)</label><input type="text" name="hero_title" value="<?= e($settings['hero_title'] ?? '') ?>">
        <label>وصف البطل</label><textarea name="hero_subtitle" rows="3"><?= e($settings['hero_subtitle'] ?? '') ?></textarea>
        <label>فقرة إضافية 1</label><textarea name="home_intro_1" rows="2"><?= e($settings['home_intro_1'] ?? '') ?></textarea>
        <label>فقرة إضافية 2</label><textarea name="home_intro_2" rows="2"><?= e($settings['home_intro_2'] ?? '') ?></textarea>
        <label>عنوان CTA</label><input type="text" name="home_cta_title" value="<?= e($settings['home_cta_title'] ?? '') ?>">
        <label>نص CTA</label><textarea name="home_cta_text" rows="2"><?= e($settings['home_cta_text'] ?? '') ?></textarea>

        <h3>صور الواجهة والكالوري</h3>
        <label>صورة Hero</label><input type="file" name="hero_image" accept=".png,.jpg,.jpeg,.webp">
        <?php for ($i=1; $i<=6; $i++): ?>
            <label>صورة Gallery <?= $i ?></label>
            <input type="file" name="gallery_<?= $i ?>" accept=".png,.jpg,.jpeg,.webp">
            <?php if (!empty($settings['gallery_' . $i])): ?><img src="<?= e(base_url($settings['gallery_' . $i])) ?>" style="height:50px; margin-bottom:8px;"><?php endif; ?>
        <?php endfor; ?>

        <h3>ألوان وتواصل</h3>
        <label>اللون الرئيسي</label><input type="color" name="primary_color" value="<?= e($settings['primary_color'] ?? '#4f46e5') ?>">
        <label>اللون الثانوي</label><input type="color" name="secondary_color" value="<?= e($settings['secondary_color'] ?? '#0ea5e9') ?>">
        <label>البريد الرسمي</label><input type="email" name="support_email" value="<?= e($settings['support_email'] ?? '') ?>">
        <label>هاتف التواصل</label><input type="text" name="support_phone" value="<?= e($settings['support_phone'] ?? '') ?>">
        <label>Base URL</label><input type="text" name="base_url" value="<?= e($settings['base_url'] ?? '') ?>">

        <h3>إضافة HTML/Script (حتى 3 عناصر)</h3>
        <?php for ($i=1; $i<=3; $i++): ?>
            <label>المحتوى <?= $i ?> (HTML أو Script)</label>
            <textarea name="injection_<?= $i ?>_content" rows="4"><?= e($settings['injection_' . $i . '_content'] ?? '') ?></textarea>
            <label>مكان الظهور <?= $i ?></label>
            <select name="injection_<?= $i ?>_target">
                <?php $target = $settings['injection_' . $i . '_target'] ?? 'all'; ?>
                <option value="all" <?= $target==='all'?'selected':'' ?>>كل الصفحات</option>
                <option value="home" <?= $target==='home'?'selected':'' ?>>الصفحة الرئيسية</option>
                <option value="dashboard" <?= $target==='dashboard'?'selected':'' ?>>لوحة التحكم</option>
                <option value="requests.create" <?= $target==='requests.create'?'selected':'' ?>>صفحة إنشاء الطلب</option>
            </select>
        <?php endfor; ?>

        <button class="btn" type="submit">حفظ كل الإعدادات</button>
    </form>
</div>

<div class="card" style="max-width:980px;margin:16px auto;">
    <h3>أنواع الأومبلاج</h3>
    <form method="post" action="<?= e(route_url('admin.types.add')) ?>">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <input type="text" name="type_name" placeholder="نوع جديد">
        <button class="btn" type="submit">إضافة</button>
    </form>
    <table>
        <tbody>
        <?php foreach ($types as $type): ?>
            <tr><td><?= e($type['type_name']) ?></td><td>
                <form method="post" action="<?= e(route_url('admin.types.delete', ['id' => (int)$type['id']])) ?>">
                    <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                    <button class="btn light" type="submit">حذف</button>
                </form>
            </td></tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
