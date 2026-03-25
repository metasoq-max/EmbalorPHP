<div class="hero card">
    <h1>منصة Embalor للأومبلاج الذكي</h1>
    <p>حوّل فكرتك أو تصميمك إلى نموذج تغليف احترافي 3D، أو دع فريقنا يتولى التصميم بالكامل.</p>
    <div style="margin-top:16px; display:flex; gap:10px; flex-wrap:wrap;">
        <?php if (!$user): ?>
            <a class="btn" href="/public/index.php?r=register">ابدأ الآن</a>
            <a class="btn secondary" href="/public/index.php?r=login">تسجيل الدخول</a>
        <?php else: ?>
            <a class="btn" href="/public/index.php?r=dashboard">الذهاب للوحة التحكم</a>
        <?php endif; ?>
    </div>
</div>

<div class="grid">
    <div class="card">
        <h3>الخيار 1: تصميمك إلى 3D</h3>
        <p class="muted">ارفع الملف، اختر شكل الأومبلاج، أضف المقاسات والملاحظات، وتابع التنفيذ خطوة بخطوة.</p>
    </div>
    <div class="card">
        <h3>الخيار 2: تواصل مع الفريق</h3>
        <p class="muted">اختر "طلب تواصل" ليقوم المصممون بإعداد مقترح تصميم مناسب لمنتجك.</p>
    </div>
    <div class="card">
        <h3>لوحات متعددة الصلاحيات</h3>
        <p class="muted">عميل، مصمم، عامل، ومدير مع صلاحيات مخصصة لكل دور لإدارة workflow متكامل.</p>
    </div>
</div>
