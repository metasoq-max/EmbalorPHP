<div class="card">
    <h2>طلب أومبلاج جديد</h2>
    <p class="muted">خدمتنا تركز على تصميم تغليف احترافي يرفع قيمة منتجك ويزيد فرص البيع.</p>
    <form method="post" action="<?= e(route_url('requests.create')) ?>" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <label>نوع الخدمة</label>
        <select name="service_type" required>
            <option value="design_to_3d">لدي تصميم وأريد تحويله إلى أومبلاج 3D</option>
            <option value="team_design">أريد من الفريق تصميم الأومبلاج المناسب</option>
        </select>
        <label>عنوان الطلب</label><input type="text" name="title" required>
        <label>شكل الأومبلاج</label>
        <select name="package_shape"><option value="box">Box</option><option value="pouch">Pouch</option><option value="bottle">Bottle</option><option value="tube">Tube</option><option value="custom">Custom</option></select>
        <label>المقاسات</label><input type="text" name="dimensions" placeholder="20 x 10 x 5 cm">
        <label>وصف الطلب</label><textarea name="description" rows="5"></textarea>
        <label>ملف مرجعي</label><input type="file" name="reference_file" accept=".jpg,.jpeg,.png,.pdf,.webp">
        <label><input style="width:auto" type="checkbox" name="contact_only" value="1"> أريد تواصل أولاً قبل التنفيذ</label>
        <button class="btn" type="submit">إرسال الطلب</button>
    </form>
</div>
