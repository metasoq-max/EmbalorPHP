<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Database;

class AuthController
{
    public function __construct(private Database $db, private Auth $auth)
    {
    }

    public function loginForm(): void
    {
        view('auth/login');
    }

    public function loginSubmit(): void
    {
        verify_csrf();
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($this->auth->login($email, $password)) {
            flash('success', 'تم تسجيل الدخول بنجاح.');
            redirect('dashboard');
        }

        flash('error', 'بيانات الدخول غير صحيحة.');
        redirect('login');
    }

    public function registerForm(): void
    {
        view('auth/register');
    }

    public function registerSubmit(): void
    {
        verify_csrf();
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!$name || !$email || !$password) {
            flash('error', 'يرجى تعبئة الحقول المطلوبة.');
            redirect('register');
        }

        $exists = $this->db->query('SELECT id FROM users WHERE email = ?', [$email]);
        if ($exists) {
            flash('error', 'البريد الإلكتروني مستخدم مسبقاً.');
            redirect('register');
        }

        $this->db->execute(
            'INSERT INTO users (name, email, phone, password, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())',
            [$name, $email, $phone, password_hash($password, PASSWORD_DEFAULT), 'customer']
        );

        flash('success', 'تم إنشاء الحساب. يمكنك تسجيل الدخول الآن.');
        redirect('login');
    }

    public function logout(): void
    {
        $this->auth->logout();
        flash('success', 'تم تسجيل الخروج.');
        redirect('home');
    }
}
