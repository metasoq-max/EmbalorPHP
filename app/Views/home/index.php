<div class="hero card">
    <h1><?= e(setting('hero_title', 'الأومبلاج وسيلة لزيادة المبيعات، وليس مجرد كرتونة.')) ?></h1>
    <p><?= e(setting('hero_subtitle', 'نقدم حلول تغليف عصرية مدروسة بصرياً وتسويقياً لتعزيز حضور منتجك.')) ?></p>
    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:12px">
        <?php if (!$user): ?>
            <a class="btn" href="<?= e(route_url('register')) ?>">ابدأ مشروعك الآن</a>
            <a class="btn light" href="<?= e(route_url('login')) ?>">دخول العملاء</a>
        <?php else: ?>
            <a class="btn" href="<?= e(route_url('dashboard')) ?>">الدخول للوحة التحكم</a>
        <?php endif; ?>
    </div>
</div>

<div class="grid">
    <div class="card"><h3>تصميم إلى 3D</h3><p class="muted">ارفع تصميمك واختر شكل الأومبلاج، وسنحوّله إلى نموذج تطبيقي قابل للتعديل.</p></div>
    <div class="card"><h3>فريق إبداع متكامل</h3><p class="muted">إذا لم تكن لديك فكرة جاهزة، مصممونا يبنون لك هوية تغليف تناسب جمهورك المستهدف.</p></div>
    <div class="card"><h3>أثر بيعي</h3><p class="muted">هدفنا رفع مبيعاتك عبر تجربة بصرية حديثة، خامات مناسبة، وتموضع أقوى لمنتجك.</p></div>
</div>
