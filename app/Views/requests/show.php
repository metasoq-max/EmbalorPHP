<div class="card">
    <h2>تفاصيل الطلب #<?= (int) $request['id'] ?></h2>
    <p><strong>العنوان:</strong> <?= e($request['title'] ?: 'بدون عنوان') ?></p>
    <p><strong>العميل:</strong> <?= e($request['customer_name']) ?></p>
    <p><strong>النوع:</strong> <?= e($request['service_type']) ?></p>
    <p><strong>الحالة:</strong> <span class="badge"><?= e($request['status']) ?></span></p>
    <p><strong>السعر التقديري:</strong> <?= $request['estimated_price'] ? e(number_format((float)$request['estimated_price'],2)) . ' MAD' : 'لم يتم تحديده بعد' ?></p>
    <p><strong>الوصف:</strong><br><?= nl2br(e($request['description'] ?: '-')) ?></p>
    <?php if (!empty($request['reference_file'])): ?><p><a class="btn light" target="_blank" href="<?= e(base_url('uploads/' . $request['reference_file'])) ?>">فتح الملف المرجعي</a></p><?php endif; ?>
</div>

<?php if ($user['role'] === 'admin'): ?>
<div class="card">
    <h3>إسناد الطلب</h3>
    <form method="post" action="<?= e(route_url('admin.assign', ['id' => (int)$request['id']])) ?>">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <select name="assigned_to"><option value="">بدون إسناد</option><?php foreach ($staff as $member): ?><option value="<?= (int)$member['id'] ?>" <?= (int)$request['assigned_to']===(int)$member['id']?'selected':'' ?>><?= e($member['name']) ?> (<?= e($member['role']) ?>)</option><?php endforeach; ?></select>
        <button class="btn secondary" type="submit">حفظ الإسناد</button>
    </form>
</div>
<?php endif; ?>

<?php if (in_array($user['role'], ['admin','worker','designer'], true)): ?>
<div class="card">
    <h3>تحديث الحالة والسعر</h3>
    <form method="post" action="<?= e(route_url('requests.update_status', ['id' => (int)$request['id']])) ?>">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <select name="status"><option value="new">جديد</option><option value="in_progress">قيد التنفيذ</option><option value="waiting_customer">بانتظار العميل</option><option value="done">مكتمل</option><option value="cancelled">ملغي</option></select>
        <button class="btn" type="submit">حفظ الحالة</button>
    </form>
    <form method="post" action="<?= e(route_url('requests.update_price', ['id' => (int)$request['id']])) ?>">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <label>السعر التقديري (MAD)</label>
        <input type="number" name="estimated_price" step="0.01" min="0" value="<?= e((string)($request['estimated_price'] ?? '')) ?>">
        <button class="btn secondary" type="submit">حفظ السعر</button>
    </form>
</div>
<?php endif; ?>

<div class="card" id="messages-section">
    <h3>التواصل داخل الطلب</h3>
    <div class="chat" id="chat-box" data-request-id="<?= (int)$request['id'] ?>" data-last-message-id="<?= !empty($messages) ? (int) end($messages)['id'] : 0 ?>">
        <?php foreach ($messages as $m): ?>
            <div class="msg"><strong><?= e($m['sender_name']) ?> (<?= e($m['sender_role']) ?>)</strong><br><?= nl2br(e($m['message'])) ?><div class="muted"><?= e($m['created_at']) ?></div></div>
        <?php endforeach; ?>
    </div>
    <form method="post" action="<?= e(route_url('messages.send', ['id' => (int)$request['id']])) ?>">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <textarea name="message" rows="3" placeholder="اكتب رسالتك..."></textarea>
        <button class="btn" type="submit">إرسال</button>
    </form>
</div>
