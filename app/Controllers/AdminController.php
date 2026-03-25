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

        if (!in_array($role, ['admin', 'worker', 'designer', 'customer'], true)) {
            flash('error', 'الدور غير صالح.');
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
        redirect('requests.show&id=' . $id);
    }
}
