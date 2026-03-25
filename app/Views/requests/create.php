<div class="card">
    <h2>إنشاء طلب أومبلاج جديد</h2>
    <form method="post" action="/public/index.php?r=requests.create" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">

        <label>نوع الخدمة</label>
        <select name="service_type" required>
            <option value="design_to_3d">لدي تصميم وأريد تحويله إلى أومبلاج 3D</option>
            <option value="team_design">أريد من الفريق تصميم الأومبلاج المناسب</option>
        </select>

        <label>عنوان الطلب</label>
        <input type="text" name="title" required>

        <label>شكل الأومبلاج المطلوب</label>
        <select name="package_shape">
            <option value="box">علبة Box</option>
            <option value="pouch">كيس Pouch</option>
            <option value="bottle">زجاجة Bottle</option>
            <option value="tube">أنبوب Tube</option>
            <option value="custom">شكل مخصص</option>
        </select>

        <label>المقاسات (اختياري)</label>
        <input type="text" name="dimensions" placeholder="مثال: 20cm x 10cm x 5cm">

        <label>وصف الطلب</label>
        <textarea name="description" rows="5" placeholder="اكتب تفاصيل المنتج، السوق المستهدف، الألوان المفضلة..."></textarea>

        <label>ملف مرجعي (صورة/PDF)</label>
        <input type="file" name="reference_file" accept=".jpg,.jpeg,.png,.pdf,.webp">

        <label><input type="checkbox" name="contact_only" value="1" style="width:auto; margin-left:8px;"> أريد تواصل فقط قبل البدء بالتنفيذ</label>

        <button class="btn" type="submit">إرسال الطلب</button>
    </form>
</div>
