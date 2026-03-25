<section class="landing-hero card">
    <div>
        <span class="pill">حلول أومبلاج احترافية للشركات والمتاجر</span>
        <h1><?= e(setting('hero_title', 'حوّل منتجك إلى علامة تُباع أسرع بأومبلاج عصري.')) ?></h1>
        <p><?= e(setting('hero_subtitle', 'من رفع تصميمك إلى معاينة 3D ثم تصنيع وتوصيل حتى بابك — كل شيء من منصة واحدة.')) ?></p>
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
            <div><strong>24/7</strong><span>متابعة الطلبات</span></div>
            <div><strong>3D</strong><span>معاينة قبل التصنيع</span></div>
        </div>
    </div>
    <div class="hero-media">
        <img src="https://placehold.co/760x520/e0e7ff/312e81?text=Premium+Packaging+Mockup" alt="Embalor packaging showcase">
    </div>
</section>

<section class="card landing-section">
    <h2>لماذا Embalor؟</h2>
    <div class="grid landing-features">
        <article class="feature">
            <h3>Preview 3D واضح</h3>
            <p>العميل يرفع التصميم ديالو، كنحولوه لمعاينة ثلاثية الأبعاد باش ياخذ القرار بثقة قبل الإنتاج.</p>
        </article>
        <article class="feature">
            <h3>تصنيع ستوك سريع</h3>
            <p>بعد الموافقة كنطلقو الإنتاج من 50 حبة، مع جودة ثابتة وخامات مناسبة لمنتجك.</p>
        </article>
        <article class="feature">
            <h3>تسليم حتى الباب</h3>
            <p>من الفكرة حتى التوصيل، كل المراحل كاتبان فحسابك مع تواصل مباشر مع الفريق.</p>
        </article>
    </div>
</section>

<section class="card landing-section">
    <h2>كيفاش خدام المسار؟</h2>
    <div class="timeline">
        <div class="step"><span>1</span><div><h4>رفع الملف</h4><p>ترفع التصميم/المراجع وتختار شكل الأومبلاج.</p></div></div>
        <div class="step"><span>2</span><div><h4>المعاينة 3D</h4><p>كنصيفطو لك تصور واقعي قابل للتعديل حتى ترضى.</p></div></div>
        <div class="step"><span>3</span><div><h4>تأكيد + سعر</h4><p>كتوصل بالسعر التقديري والكمية، وكتأكد الانطلاق.</p></div></div>
        <div class="step"><span>4</span><div><h4>تصنيع وتوصيل</h4><p>كنصنعو ونوصلو الشحنة مباشرة لباب المنزل/الشركة.</p></div></div>
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

<section class="card landing-cta">
    <h2>واخا ماعندكش تصميم جاهز؟</h2>
    <p>فريقنا كيبني لك كونسبت أومبلاج عصري ومقنع يرفع قيمة منتجك ويزيد فرص البيع.</p>
    <a class="btn secondary" href="<?= e($user ? route_url('requests.create') : route_url('register')) ?>">طلب تواصل مع الفريق</a>
</section>
