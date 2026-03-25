<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Database;

class DashboardController
{
    public function __construct(private Database $db, private Auth $auth)
    {
    }

    public function index(): void
    {
        $this->auth->requireAuth();
        $user = $this->auth->user();

        if ($user['role'] === 'customer') {
            $requests = $this->db->query(
                'SELECT r.*, u.name as assigned_name
                 FROM packaging_requests r
                 LEFT JOIN users u ON u.id = r.assigned_to
                 WHERE r.customer_id = ?
                 ORDER BY r.id DESC',
                [$user['id']]
            );
        } else {
            $requests = $this->db->query(
                'SELECT r.*, c.name as customer_name, u.name as assigned_name
                 FROM packaging_requests r
                 JOIN users c ON c.id = r.customer_id
                 LEFT JOIN users u ON u.id = r.assigned_to
                 WHERE (? = "admin") OR (r.assigned_to = ?) OR (? = "worker" AND r.assigned_to IS NULL)
                 ORDER BY r.id DESC',
                [$user['role'], $user['id'], $user['role']]
            );
        }

        view('dashboard/index', ['user' => $user, 'requests' => $requests]);
    }
}
