<div class="card">
    <h2>طلب أومبلاج جديد</h2>
    <p class="muted">الخدمة: العميل يرسل الطلب وملف توضيحي، نحن نصنع عينة حقيقية (شونتيو) ونعرضها عليه قبل بدء الكمية الكاملة لضمان الرضا.</p>
    <form method="post" action="<?= e(route_url('requests.create')) ?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <label>نوع الطلب</label>
        <select name="service_type" required>
            <option value="standard_order">طلب تصنيع عادي</option>
            <option value="team_consultation">أريد استشارة الفريق</option>
        </select>
        <label>عنوان الطلب</label><input type="text" name="title" required>
        <label>نوع الأومبلاج</label>
        <select name="package_shape" required>
            <?php foreach ($types as $type): ?>
                <option value="<?= e($type['type_name']) ?>"><?= e($type['type_name']) ?></option>
            <?php endforeach; ?>
        </select>
        <label>المقاسات</label><input type="text" name="dimensions" placeholder="20 x 10 x 5 cm">
        <label>وصف الطلب</label><textarea name="description" rows="5"></textarea>
        <label>ملف توضيحي</label><input type="file" name="reference_file" accept=".jpg,.jpeg,.png,.pdf,.webp">
        <label><input style="width:auto" type="checkbox" name="contact_only" value="1"> أريد تواصل أولاً قبل التنفيذ</label>
        <button class="btn" type="submit">إرسال الطلب</button>
    </form>
</div>
