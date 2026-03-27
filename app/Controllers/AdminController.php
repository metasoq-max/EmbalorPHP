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
        $users = $this->db->query('SELECT id, name, email, phone, role, is_banned, created_at FROM users ORDER BY id DESC');
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

        if (!$name || !$email || !$phone || !$password) {
            flash('error', 'يرجى تعبئة الحقول المطلوبة.');
            redirect('admin.users.create');
        }

        $this->db->execute('INSERT INTO users (name, email, phone, password, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())', [$name, $email, $phone, password_hash($password, PASSWORD_DEFAULT), $role]);
        flash('success', 'تم إنشاء المستخدم بنجاح.');
        redirect('admin.users');
    }

    public function resetPassword(int $id): void
    {
        $this->auth->requireAuth();
        $this->auth->requireRole(['admin']);
        verify_csrf();
        $newPassword = trim($_POST['new_password'] ?? '');
        if (strlen($newPassword) < 6) {
            flash('error', 'كلمة المرور يجب أن تكون 6 أحرف على الأقل.');
            redirect('admin.users');
        }
        $this->db->execute('UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?', [password_hash($newPassword, PASSWORD_DEFAULT), $id]);
        flash('success', 'تم تحديث كلمة المرور.');
        redirect('admin.users');
    }

    public function toggleBan(int $id): void
    {
        $this->auth->requireAuth();
        $this->auth->requireRole(['admin']);
        verify_csrf();

        $target = $this->db->query('SELECT id, role, is_banned FROM users WHERE id = ?', [$id])[0] ?? null;
        if (!$target || $target['role'] === 'admin') {
            flash('error', 'لا يمكن تنفيذ العملية على هذا المستخدم.');
            redirect('admin.users');
        }

        $newState = (int) $target['is_banned'] === 1 ? 0 : 1;
        $this->db->execute('UPDATE users SET is_banned = ?, updated_at = NOW() WHERE id = ?', [$newState, $id]);
        flash('success', $newState ? 'تم حظر العميل.' : 'تم رفع الحظر عن العميل.');
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
        foreach ($rows as $row) $settings[$row['setting_key']] = $row['setting_value'];

        $types = $this->db->query('SELECT * FROM packaging_types ORDER BY id DESC');
        view('admin/settings', ['settings' => $settings, 'types' => $types]);
    }

    public function addPackagingType(): void
    {
        $this->auth->requireAuth();
        $this->auth->requireRole(['admin']);
        verify_csrf();
        $typeName = trim($_POST['type_name'] ?? '');
        if ($typeName !== '') {
            $this->db->execute('INSERT INTO packaging_types (type_name, is_active, created_at) VALUES (?, 1, NOW())', [$typeName]);
            flash('success', 'تم إضافة نوع الأومبلاج.');
        }
        redirect('admin.settings');
    }

    public function deletePackagingType(int $id): void
    {
        $this->auth->requireAuth();
        $this->auth->requireRole(['admin']);
        verify_csrf();
        $this->db->execute('DELETE FROM packaging_types WHERE id = ?', [$id]);
        flash('success', 'تم حذف النوع.');
        redirect('admin.settings');
    }

    public function updateSettings(): void
    {
        $this->auth->requireAuth();
        $this->auth->requireRole(['admin']);
        verify_csrf();

        $updatable = [
            'site_title','hero_title','hero_subtitle','primary_color','secondary_color','support_email','support_phone','base_url',
            'home_intro_1','home_intro_2','home_cta_title','home_cta_text',
            'injection_1_content','injection_1_target','injection_2_content','injection_2_target','injection_3_content','injection_3_target'
        ];

        $stmt = $this->db->pdo()->prepare('INSERT INTO settings (setting_key, setting_value, updated_at) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = NOW()');
        foreach ($updatable as $key) $stmt->execute([$key, trim($_POST[$key] ?? '')]);

        if (!is_dir(base_path('web/uploads/site'))) mkdir(base_path('web/uploads/site'), 0775, true);
        $uploadMap = ['site_logo','hero_image','gallery_1','gallery_2','gallery_3','gallery_4','gallery_5','gallery_6'];
        foreach ($uploadMap as $field) {
            if (!empty($_FILES[$field]['name']) && is_uploaded_file($_FILES[$field]['tmp_name'])) {
                $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['png','jpg','jpeg','webp','svg'], true)) {
                    $name = $field . '_' . time() . '.' . $ext;
                    $target = base_path('web/uploads/site/' . $name);
                    if (move_uploaded_file($_FILES[$field]['tmp_name'], $target)) {
                        $stmt->execute([$field, 'uploads/site/' . $name]);
                    }
                }
            }
        }

        $config = app_config();
        $config['base_url'] = trim($_POST['base_url'] ?? '');
        file_put_contents(base_path('config/app.php'), "<?php\n\nreturn " . var_export($config, true) . ";\n");

        flash('success', 'تم تحديث إعدادات الموقع.');
        redirect('admin.settings');
    }
}
