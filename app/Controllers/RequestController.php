<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Database;

class RequestController
{
    public function __construct(private Database $db, private Auth $auth)
    {
    }

    public function create(): void
    {
        $this->auth->requireAuth();
        $this->auth->requireRole(['customer']);
        view('requests/create');
    }

    public function store(): void
    {
        $this->auth->requireAuth();
        $this->auth->requireRole(['customer']);
        verify_csrf();

        $user = $this->auth->user();
        $serviceType = $_POST['service_type'] ?? 'design_to_3d';
        $packageShape = trim($_POST['package_shape'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $dimensions = trim($_POST['dimensions'] ?? '');
        $contactOnly = isset($_POST['contact_only']) ? 1 : 0;

        $uploadPath = null;
        if (!empty($_FILES['reference_file']['name']) && is_uploaded_file($_FILES['reference_file']['tmp_name'])) {
            $ext = strtolower(pathinfo($_FILES['reference_file']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'pdf', 'webp'];
            if (in_array($ext, $allowed, true)) {
                $name = 'req_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $target = base_path('public/uploads/' . $name);
                if (move_uploaded_file($_FILES['reference_file']['tmp_name'], $target)) {
                    $uploadPath = $name;
                }
            }
        }

        $this->db->execute(
            'INSERT INTO packaging_requests
            (customer_id, service_type, package_shape, title, description, dimensions, contact_only, reference_file, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())',
            [$user['id'], $serviceType, $packageShape, $title, $description, $dimensions, $contactOnly, $uploadPath, 'new']
        );

        flash('success', 'تم إرسال طلبك بنجاح.');
        redirect('dashboard');
    }

    public function index(): void
    {
        $this->auth->requireAuth();
        redirect('dashboard');
    }

    public function show(int $id): void
    {
        $this->auth->requireAuth();
        $user = $this->auth->user();

        $rows = $this->db->query(
            'SELECT r.*, c.name as customer_name, c.email as customer_email, u.name as assigned_name
             FROM packaging_requests r
             JOIN users c ON c.id = r.customer_id
             LEFT JOIN users u ON u.id = r.assigned_to
             WHERE r.id = ?',
            [$id]
        );

        $request = $rows[0] ?? null;
        if (!$request) {
            exit('الطلب غير موجود');
        }

        $canView = $user['role'] === 'admin' || (int) $request['customer_id'] === (int) $user['id'] || (int) $request['assigned_to'] === (int) $user['id'];
        if (!$canView) {
            http_response_code(403);
            exit('غير مصرح');
        }

        $staff = [];
        if ($user['role'] === 'admin') {
            $staff = $this->db->query("SELECT id, name, role FROM users WHERE role IN ('worker','designer','admin') ORDER BY name ASC");
        }

        view('requests/show', ['request' => $request, 'user' => $user, 'staff' => $staff]);
    }

    public function updateStatus(int $id): void
    {
        $this->auth->requireAuth();
        $this->auth->requireRole(['admin', 'worker', 'designer']);
        verify_csrf();

        $status = $_POST['status'] ?? 'new';
        $allowed = ['new', 'in_progress', 'waiting_customer', 'done', 'cancelled'];
        if (!in_array($status, $allowed, true)) {
            flash('error', 'حالة غير صالحة.');
            redirect('dashboard');
        }

        $this->db->execute('UPDATE packaging_requests SET status = ?, updated_at = NOW() WHERE id = ?', [$status, $id]);
        flash('success', 'تم تحديث الحالة.');
        redirect('requests.show&id=' . $id);
    }
}
