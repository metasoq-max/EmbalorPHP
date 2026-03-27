<?php

declare(strict_types=1);

function base_path(string $path = ''): string
{
    $base = dirname(__DIR__, 2);
    return $path ? $base . '/' . ltrim($path, '/') : $base;
}

function normalize_base_url(string $url): string
{
    $url = rtrim($url, '/');
    $url = preg_replace('#/web$#i', '', $url);
    $url = preg_replace('#/web/index\.php$#i', '', $url);
    return rtrim((string) $url, '/');
}

function app_config(?string $key = null, mixed $default = null): mixed
{
    $config = $GLOBALS['app_config'] ?? [];
    if ($key === null) return $config;
    $segments = explode('.', $key);
    $value = $config;
    foreach ($segments as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) return $default;
        $value = $value[$segment];
    }
    return $value;
}

function base_url(string $path = ''): string
{
    $base = normalize_base_url((string) app_config('base_url', ''));
    if ($base === '') {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $base = $scheme . '://' . $host;
    }

    $normalizedPath = ltrim($path, '/');
    if ($normalizedPath !== '' && preg_match('#^(assets|uploads)/#', $normalizedPath)) {
        $normalizedPath = 'web/' . $normalizedPath;
    }

    return $normalizedPath === '' ? $base . '/' : $base . '/' . $normalizedPath;
}

function route_url(string $route, array $params = []): string
{
    $map = [
        'home' => '',
        'login' => 'login',
        'register' => 'register',
        'logout' => 'logout',
        'dashboard' => 'dashboard',
        'requests.create' => 'requests/create',
        'admin.users' => 'admin/users',
        'admin.users.create' => 'admin/users/create',
        'admin.settings' => 'admin/settings',
        'notifications.latest' => 'notifications/latest',
    ];

    if ($route === 'requests.show' && isset($params['id'])) {
        $path = 'requests/' . (int) $params['id'];
        unset($params['id']);
    } elseif (isset($map[$route])) {
        $path = $map[$route];
    } else {
        $query = http_build_query(array_merge(['r' => $route], $params));
        return base_url('index.php?' . $query);
    }

    $url = base_url($path);
    if (!empty($params)) $url .= '?' . http_build_query($params);
    return $url;
}

function view(string $view, array $data = []): void
{
    extract($data, EXTR_SKIP);
    $viewPath = base_path('app/Views/' . $view . '.php');
    require base_path('app/Views/layouts/header.php');
    require $viewPath;
    require base_path('app/Views/layouts/footer.php');
}

function redirect(string $route, array $params = []): void
{
    header('Location: ' . route_url($route, $params));
    exit;
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return null;
    }
    $msg = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $msg;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}

function verify_csrf(): void
{
    $token = $_POST['_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(419);
        exit('رمز الحماية غير صالح.');
    }
}

function setting(string $key, mixed $default = null): mixed
{
    return $_SESSION['settings'][$key] ?? $default;
}
