<div class="card">
    <h2>تفاصيل الطلب #<?= (int) $request['id'] ?></h2>
    <p><strong>العنوان:</strong> <?= e($request['title'] ?: 'بدون عنوان') ?></p>
    <p><strong>العميل:</strong> <?= e($request['customer_name']) ?> (<?= e($request['customer_email']) ?>)</p>
    <p><strong>نوع الخدمة:</strong> <?= e($request['service_type']) ?></p>
    <p><strong>الشكل:</strong> <?= e($request['package_shape'] ?: '-') ?></p>
    <p><strong>المقاسات:</strong> <?= e($request['dimensions'] ?: '-') ?></p>
    <p><strong>الحالة:</strong> <span class="badge"><?= e($request['status']) ?></span></p>
    <p><strong>مكلّف إلى:</strong> <?= e($request['assigned_name'] ?: 'غير محدد') ?></p>
    <p><strong>الوصف:</strong><br><?= nl2br(e($request['description'] ?: '-')) ?></p>

    <?php if (!empty($request['reference_file'])): ?>
        <p><strong>الملف المرجعي:</strong> <a href="/public/uploads/<?= e($request['reference_file']) ?>" target="_blank">عرض الملف</a></p>
    <?php endif; ?>
</div>

<?php if (in_array($user['role'], ['admin', 'worker', 'designer'], true)): ?>
<div class="card">
    <h3>تحديث حالة الطلب</h3>
    <form method="post" action="/public/index.php?r=requests.update_status&id=<?= (int) $request['id'] ?>">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <select name="status">
            <option value="new">جديد</option>
            <option value="in_progress">قيد التنفيذ</option>
            <option value="waiting_customer">بانتظار العميل</option>
            <option value="done">مكتمل</option>
            <option value="cancelled">ملغي</option>
        </select>
        <button class="btn" type="submit">حفظ الحالة</button>
    </form>
</div>
<?php endif; ?>


<?php if ($user['role'] === 'admin'): ?>
<div class="card">
    <h3>إسناد الطلب</h3>
    <form method="post" action="/public/index.php?r=admin.assign&id=<?= (int) $request['id'] ?>">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <select name="assigned_to">
            <option value="">بدون إسناد</option>
            <?php foreach ($staff as $member): ?>
                <option value="<?= (int) $member['id'] ?>" <?= (int)$request['assigned_to'] === (int)$member['id'] ? 'selected' : '' ?>>
                    <?= e($member['name']) ?> (<?= e($member['role']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <button class="btn secondary" type="submit">حفظ الإسناد</button>
    </form>
</div>
<?php endif; ?>
