<section class="landing-hero card animate-fade">
    <div>
        <span class="pill">حلول أومبلاج احترافية بمعايير إبداعية حصرية</span>
        <h1><?= e(setting('hero_title', 'حوِّل منتجك إلى قصة نجاح بصرية تُقنع العميل من النظرة الأولى.')) ?></h1>
        <p>
            <?= e(setting('hero_subtitle', 'نحن لا نقدّم تغليفًا تقليديًا فحسب، بل نبني تجربة متكاملة تُعزّز الثقة بعلامتك التجارية، وترفع القيمة المتصوَّرة لمنتجك، وتدفع قرار الشراء بثبات.')) ?>
        </p>
        <p>
            في Embalor نؤمن أن الأومبلاج الذكي هو أداة تسويق ومبيعات قبل أن يكون غلافًا؛ لذلك نصمم حلولًا مدروسة بعناية،
            ونصنع عيّنة حقيقية (شونتيو) قبل الإنتاج الكامل حتى تتأكد من الجودة والنتيجة الواقعية بكل تفاصيلها.
        </p>
        <div class="hero-actions">
            <?php if (!$user): ?>
                <a class="btn" href="<?= e(route_url('register')) ?>">ابدأ رحلتك الآن</a>
                <a class="btn light" href="<?= e(route_url('login')) ?>">تسجيل الدخول</a>
            <?php else: ?>
                <a class="btn" href="<?= e(route_url('dashboard')) ?>">الانتقال إلى لوحة التحكم</a>
            <?php endif; ?>
        </div>
        <div class="hero-mini-stats">
            <div><strong>+50</strong><span>الحد الأدنى للكمية</span></div>
            <div><strong>عيّنة حقيقية</strong><span>قبل الإنتاج الكامل</span></div>
            <div><strong>جودة متقنة</strong><span>تليق بعلامتك التجارية</span></div>
        </div>
    </div>
    <div class="hero-media animate-float">
        <img src="https://placehold.co/760x520/e0e7ff/312e81?text=Embalor+Premium+Packaging" alt="عرض بصري لتصاميم الأومبلاج الاحترافية">
    </div>
</section>

<section class="card landing-section animate-fade delay-1">
    <h2>لماذا يختارنا العملاء؟</h2>
    <div class="grid landing-features">
        <article class="feature glow">
            <h3>قيمة تسويقية أعلى</h3>
            <p>نحوّل الأومبلاج إلى عنصر إقناع بصري يرفع ثقة العميل ويزيد فرص الشراء في السوق.</p>
        </article>
        <article class="feature glow">
            <h3>احترافية في كل تفصيلة</h3>
            <p>من اختيار الخامات إلى دقة التنفيذ، نعمل بمعايير عالية تضمن صورة راقية لمنتجك.</p>
        </article>
        <article class="feature glow">
            <h3>مرونة وتخصيص كامل</h3>
            <p>حلولنا مصممة لتلائم هوية نشاطك، جمهورك المستهدف، وأهدافك التجارية.</p>
        </article>
    </div>
</section>

<section class="card landing-section animate-fade delay-2">
    <h2>مسار التنفيذ من الفكرة إلى التسليم</h2>
    <div class="timeline">
        <div class="step"><span>1</span><div><h4>استقبال الطلب</h4><p>تُدخل تفاصيل منتجك وترفع الملفات التوضيحية بكل سهولة.</p></div></div>
        <div class="step"><span>2</span><div><h4>تصميم وتنفيذ العيّنة</h4><p>نُعد نموذجًا واقعيًا (شونتيو) لتقييم الشكل النهائي على أرض الواقع.</p></div></div>
        <div class="step"><span>3</span><div><h4>اعتماد العميل</h4><p>بعد موافقتك النهائية يتم تثبيت المواصفات والسعر والكمية.</p></div></div>
        <div class="step"><span>4</span><div><h4>إنتاج وتسليم</h4><p>نبدأ التصنيع بجودة ثابتة ثم نُسلم الطلب إلى باب منزلك أو شركتك.</p></div></div>
    </div>
</section>

<section class="landing-gallery card animate-fade delay-3">
    <h2>نماذج لأعمال ملهمة (قابلة للاستبدال بصورك)</h2>
    <div class="img-grid">
        <div class="img-slot"><img src="https://placehold.co/640x420/f0f9ff/0c4a6e?text=تغليف+المنتجات+الغذائية" alt="تغليف غذائي"></div>
        <div class="img-slot"><img src="https://placehold.co/640x420/ecfdf5/14532d?text=تغليف+منتجات+العناية" alt="تغليف مستحضرات"></div>
        <div class="img-slot"><img src="https://placehold.co/640x420/fef3c7/78350f?text=تغليف+المنتجات+التجارية" alt="تغليف تجاري"></div>
    </div>
</section>

<section class="card landing-cta animate-fade delay-4">
    <h2>اجعل منتجك أكثر حضورًا... وأكثر مبيعًا</h2>
    <p>
        إذا كنت تبحث عن شريك يقدّم لك الإبداع، الدقة، والموثوقية في الأومبلاج، فأنت في المكان الصحيح.
        دعنا نبني معًا تجربة تغليف استثنائية تعكس قوة علامتك وتضاعف أثرها في السوق.
    </p>
    <a class="btn secondary" href="<?= e($user ? route_url('requests.create') : route_url('register')) ?>">اطلب الخدمة الآن</a>
</section>
