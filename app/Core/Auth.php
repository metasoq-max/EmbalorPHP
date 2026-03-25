<?php

namespace App\Core;

class Auth
{
    public function __construct(private Database $db)
    {
    }

    public function user(): ?array
    {
        if (empty($_SESSION['user_id'])) {
            return null;
        }

        $rows = $this->db->query('SELECT * FROM users WHERE id = ?', [$_SESSION['user_id']]);
        $user = $rows[0] ?? null;

        if ($user) {
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_name'] = $user['name'];
        }

        return $user;
    }

    public function check(): bool
    {
        return !empty($_SESSION['user_id']);
    }

    public function login(string $email, string $password): bool
    {
        $rows = $this->db->query('SELECT * FROM users WHERE email = ?', [$email]);
        $user = $rows[0] ?? null;

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $user['name'];
        return true;
    }

    public function logout(): void
    {
        unset($_SESSION['user_id'], $_SESSION['user_role'], $_SESSION['user_name']);
        session_regenerate_id(true);
    }

    public function requireAuth(): void
    {
        if (!$this->check()) {
            flash('error', 'يرجى تسجيل الدخول أولاً.');
            redirect('login');
        }
    }

    public function requireRole(array $roles): void
    {
        $role = $_SESSION['user_role'] ?? null;
        if (!$role || !in_array($role, $roles, true)) {
            http_response_code(403);
            exit('غير مصرح.');
        }
    }
}
