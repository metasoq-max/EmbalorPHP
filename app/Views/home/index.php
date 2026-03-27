<?php
$heroImage = setting('hero_image', 'https://placehold.co/760x520/e0e7ff/312e81?text=Embalor+Premium+Packaging');
$gallery = [];
for ($i=1; $i<=6; $i++) {
    $gallery[] = setting('gallery_' . $i, 'https://placehold.co/640x420/f0f9ff/0c4a6e?text=Gallery+' . $i);
}
?>
<section class="landing-hero card animate-fade">
    <div>
        <span class="pill">حلول أومبلاج احترافية بمعايير إبداعية حصرية</span>
        <h1><?= e(setting('hero_title', 'حوِّل منتجك إلى قصة نجاح بصرية تُقنع العميل من النظرة الأولى.')) ?></h1>
        <p><?= e(setting('hero_subtitle', 'نحن لا نقدّم تغليفًا تقليديًا فحسب، بل نبني تجربة متكاملة تُعزّز الثقة بعلامتك التجارية.')) ?></p>
        <p><?= e(setting('home_intro_1', 'نُنتج عيّنة حقيقية قبل الكمية الكاملة لضمان رضاك الكامل.')) ?></p>
        <p><?= e(setting('home_intro_2', 'كل تفاصيل الموقع قابلة للتخصيص من لوحة الأدمن: النصوص، الصور، والألوان.')) ?></p>
        <div class="hero-actions">
            <?php if (!$user): ?>
                <a class="btn" href="<?= e(route_url('register')) ?>">ابدأ رحلتك الآن</a>
                <a class="btn light" href="<?= e(route_url('login')) ?>">تسجيل الدخول</a>
            <?php else: ?>
                <a class="btn" href="<?= e(route_url('dashboard')) ?>">الانتقال إلى لوحة التحكم</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="hero-media animate-float"><img src="<?= e(base_url($heroImage)) ?>" alt="hero"></div>
</section>

<section class="landing-gallery card animate-fade delay-2">
    <h2>معرض الأعمال</h2>
    <div class="img-grid">
        <?php foreach ($gallery as $img): ?>
            <div class="img-slot"><img src="<?= e(base_url($img)) ?>" alt="gallery"></div>
        <?php endforeach; ?>
    </div>
</section>

<section class="card landing-cta animate-fade delay-4">
    <h2><?= e(setting('home_cta_title', 'اجعل منتجك أكثر حضورًا... وأكثر مبيعًا')) ?></h2>
    <p><?= e(setting('home_cta_text', 'ابدأ معنا الآن لتصميم أومبلاج احترافي يميز علامتك في السوق.')) ?></p>
    <a class="btn secondary" href="<?= e($user ? route_url('requests.create') : route_url('register')) ?>">اطلب الخدمة الآن</a>
</section>
