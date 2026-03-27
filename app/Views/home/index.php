<section class="landing-hero card">
    <div>
        <span class="pill">حلول أومبلاج احترافية للشركات والمتاجر</span>
        <h1><?= e(setting('hero_title', 'حوّل منتجك إلى علامة تُباع أسرع بأومبلاج عصري.')) ?></h1>
        <p><?= e(setting('hero_subtitle', 'ترفع الطلب ديالك، كنصنعو شونتيو حقيقي للمعاينة، ومن بعد كنطلقو الإنتاج الكامل والتوصيل.')) ?></p>
        <div class="hero-actions">
            <?php if (!$user): ?>
                <a class="btn" href="<?= e(route_url('register')) ?>">ابدأ طلبك الآن</a>
                <a class="btn light" href="<?= e(route_url('login')) ?>">دخول العملاء</a>
            <?php else: ?>
                <a class="btn" href="<?= e(route_url('dashboard')) ?>">الذهاب للوحة التحكم</a>
            <?php endif; ?>
        </div>
        <div class="hero-mini-stats">
            <div><strong>+50</strong><span>أقل كمية إنتاج</span></div>
            <div><strong>شونتيو</strong><span>عينة حقيقية قبل الإنتاج</span></div>
            <div><strong>24/7</strong><span>تتبع الطلبات</span></div>
        </div>
    </div>
    <div class="hero-media">
        <img src="https://placehold.co/760x520/e0e7ff/312e81?text=Premium+Packaging+Sample" alt="Embalor packaging showcase">
    </div>
</section>

<section class="card landing-section">
    <h2>كيفاش خدام المسار؟</h2>
    <div class="timeline">
        <div class="step"><span>1</span><div><h4>رفع الطلب</h4><p>العميل يعمر التفاصيل ويرفع ملف توضيحي.</p></div></div>
        <div class="step"><span>2</span><div><h4>صناعة شونتيو</h4><p>كنصنعو نموذج حقيقي وكنوريوه للعميل قبل الكمية الكاملة.</p></div></div>
        <div class="step"><span>3</span><div><h4>تأكيد</h4><p>بعد الموافقة، كنثبت السعر والكمية وجدولة التنفيذ.</p></div></div>
        <div class="step"><span>4</span><div><h4>إنتاج وتوصيل</h4><p>إنتاج محترف وتسليم حتى باب المنزل/الشركة.</p></div></div>
    </div>
</section>

<section class="landing-gallery card">
    <h2>نماذج أعمال (أماكن للصور)</h2>
    <div class="img-grid">
        <div class="img-slot"><img src="https://placehold.co/640x420/f0f9ff/0c4a6e?text=Food+Packaging" alt="food packaging"></div>
        <div class="img-slot"><img src="https://placehold.co/640x420/ecfdf5/14532d?text=Cosmetic+Packaging" alt="cosmetic packaging"></div>
        <div class="img-slot"><img src="https://placehold.co/640x420/fef3c7/78350f?text=Retail+Packaging" alt="retail packaging"></div>
    </div>
</section>
