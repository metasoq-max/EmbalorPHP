</div>
<footer class="footer">© <?= date('Y') ?> Embalor - نصمم أومبلاج يرفع قيمة منتجك في السوق.</footer>

<?php
$current = $_SESSION['current_page'] ?? 'home';
for ($i = 1; $i <= 3; $i++) {
    $content = setting('injection_' . $i . '_content', '');
    $target = setting('injection_' . $i . '_target', 'all');
    if ($content && ($target === 'all' || $target === $current)) {
        echo $content;
    }
}
?>

<script src="<?= e(base_url('assets/js/app.js')) ?>"></script>
</body>
</html>
