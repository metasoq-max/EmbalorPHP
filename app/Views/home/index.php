<div class="hero card">
    <h1><?= e(setting('hero_title', 'الأومبلاج وسيلة لزيادة المبيعات، وليس مجرد كرتونة.')) ?></h1>
    <p><?= e(setting('hero_subtitle', 'نقدم حلول تغليف عصرية مدروسة بصرياً وتسويقياً لتعزيز حضور منتجك.')) ?></p>
    <p><strong>كيفاش خدام خيار 3D؟</strong> العميل كيرفع ديزاين ديالو، كيتحوّل لمعاينة 3D، إلا وافق عليه كنبدأو إنتاج ستوك الأومبلاج ابتداءً من <strong>50 حبة</strong> ونوصّلو حتى لباب المنزل.</p>
    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:12px">
        <?php if (!$user): ?>
            <a class="btn" href="<?= e(route_url('register')) ?>">ابدأ مشروعك الآن</a>
            <a class="btn light" href="<?= e(route_url('login')) ?>">دخول العملاء</a>
        <?php else: ?>
            <a class="btn" href="<?= e(route_url('dashboard')) ?>">الدخول للوحة التحكم</a>
        <?php endif; ?>
    </div>
</div>

<div class="img-grid card">
    <div class="img-slot"><img src="https://placehold.co/640x420/EEF2FF/1E3A8A?text=صورة+أومبلاج+1" alt="packaging sample"></div>
    <div class="img-slot"><img src="https://placehold.co/640x420/ECFEFF/0E7490?text=صورة+أومبلاج+2" alt="packaging sample"></div>
    <div class="img-slot"><img src="https://placehold.co/640x420/F5F3FF/5B21B6?text=صورة+أومبلاج+3" alt="packaging sample"></div>
</div>

<div class="grid">
    <div class="card"><h3>تصميم إلى 3D</h3><p class="muted">رفع ديزاينك، معاينة ثلاثية الأبعاد، تعديلات سريعة، ثم أمر إنتاج واضح.</p></div>
    <div class="card"><h3>توصيل حتى الباب</h3><p class="muted">من التصور إلى التصنيع والتسليم، كلشي منظم داخل نفس المنصة.</p></div>
    <div class="card"><h3>أثر بيعي</h3><p class="muted">الأومبلاج المدروس كيزيد الثقة ويقوي قرار الشراء ديال الزبون النهائي.</p></div>
</div>
