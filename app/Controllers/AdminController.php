<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Database;

class AdminController
{
    public function __construct(private Database $db, private Auth $auth)
    {
    }

    public function users(): void
    {
        $this->auth->requireAuth();
        $this->auth->requireRole(['admin']);
        $users = $this->db->query('SELECT id, name, email, phone, role, created_at FROM users ORDER BY id DESC');
        view('admin/users', ['users' => $users]);
    }

    public function createUser(): void
    {
        $this->auth->requireAuth();
        $this->auth->requireRole(['admin']);
        view('admin/create_user');
    }

    public function storeUser(): void
    {
        $this->auth->requireAuth();
        $this->auth->requireRole(['admin']);
        verify_csrf();

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'worker';

        if (!$name || !$email || !$password) {
            flash('error', 'يرجى تعبئة الحقول المطلوبة.');
            redirect('admin.users.create');
        }

        $this->db->execute(
            'INSERT INTO users (name, email, phone, password, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())',
            [$name, $email, $phone, password_hash($password, PASSWORD_DEFAULT), $role]
        );

        flash('success', 'تم إنشاء المستخدم بنجاح.');
        redirect('admin.users');
    }

    public function assignRequest(int $id): void
    {
        $this->auth->requireAuth();
        $this->auth->requireRole(['admin']);
        verify_csrf();

        $assignedTo = (int) ($_POST['assigned_to'] ?? 0);
        $this->db->execute('UPDATE packaging_requests SET assigned_to = ?, updated_at = NOW() WHERE id = ?', [$assignedTo ?: null, $id]);
        flash('success', 'تم إسناد الطلب.');
        redirect('requests.show', ['id' => $id]);
    }

    public function settings(): void
    {
        $this->auth->requireAuth();
        $this->auth->requireRole(['admin']);
        $rows = $this->db->query('SELECT setting_key, setting_value FROM settings');
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        view('admin/settings', ['settings' => $settings]);
    }

    public function updateSettings(): void
    {
        $this->auth->requireAuth();
        $this->auth->requireRole(['admin']);
        verify_csrf();

        $updatable = ['site_title', 'hero_title', 'hero_subtitle', 'primary_color', 'secondary_color', 'support_email', 'support_phone', 'base_url'];
        $stmt = $this->db->pdo()->prepare(
            'INSERT INTO settings (setting_key, setting_value, updated_at) VALUES (?, ?, NOW())
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = NOW()'
        );

        foreach ($updatable as $key) {
            $value = trim($_POST[$key] ?? '');
            $stmt->execute([$key, $value]);
        }


        if (!empty($_FILES['site_logo']['name']) && is_uploaded_file($_FILES['site_logo']['tmp_name'])) {
            $ext = strtolower(pathinfo($_FILES['site_logo']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['png', 'jpg', 'jpeg', 'webp', 'svg'], true)) {
                if (!is_dir(base_path('public/uploads/logos'))) {
                    mkdir(base_path('public/uploads/logos'), 0775, true);
                }
                $logoName = 'logo_' . time() . '.' . $ext;
                $target = base_path('public/uploads/logos/' . $logoName);
                if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $target)) {
                    $stmt->execute(['site_logo', 'uploads/logos/' . $logoName]);
                }
            }
        }

        $config = app_config();
        $config['base_url'] = trim($_POST['base_url'] ?? '');
        file_put_contents(base_path('config/app.php'), "<?php\n\nreturn " . var_export($config, true) . ";\n");

        flash('success', 'تم تحديث إعدادات الموقع والتصميم.');
        redirect('admin.settings');
    }
}
