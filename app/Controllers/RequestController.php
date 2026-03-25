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
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'pdf', 'webp'], true)) {
                $name = 'req_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $target = base_path('public/uploads/' . $name);
                if (move_uploaded_file($_FILES['reference_file']['tmp_name'], $target)) {
                    $uploadPath = $name;
                }
            }
        }

        $this->db->execute(
            'INSERT INTO packaging_requests (customer_id, service_type, package_shape, title, description, dimensions, contact_only, reference_file, status, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())',
            [$user['id'], $serviceType, $packageShape, $title, $description, $dimensions, $contactOnly, $uploadPath, 'new']
        );

        flash('success', 'تم إرسال طلبك بنجاح.');
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

        $staff = $user['role'] === 'admin'
            ? $this->db->query("SELECT id, name, role FROM users WHERE role IN ('worker','designer','admin') ORDER BY name ASC")
            : [];

        $messages = $this->db->query(
            'SELECT m.*, u.name as sender_name, u.role as sender_role FROM request_messages m
             JOIN users u ON u.id = m.sender_id
             WHERE request_id = ? ORDER BY m.id ASC',
            [$id]
        );

        view('requests/show', ['request' => $request, 'user' => $user, 'staff' => $staff, 'messages' => $messages]);
    }

    public function updateStatus(int $id): void
    {
        $this->auth->requireAuth();
        $this->auth->requireRole(['admin', 'worker', 'designer']);
        verify_csrf();

        $status = $_POST['status'] ?? 'new';
        if (!in_array($status, ['new', 'in_progress', 'waiting_customer', 'done', 'cancelled'], true)) {
            flash('error', 'حالة غير صالحة.');
            redirect('requests.show', ['id' => $id]);
        }

        $this->db->execute('UPDATE packaging_requests SET status = ?, updated_at = NOW() WHERE id = ?', [$status, $id]);
        flash('success', 'تم تحديث الحالة.');
        redirect('requests.show', ['id' => $id]);
    }

    public function updatePrice(int $id): void
    {
        $this->auth->requireAuth();
        $this->auth->requireRole(['admin', 'worker', 'designer']);
        verify_csrf();

        $price = (float) ($_POST['estimated_price'] ?? 0);
        $this->db->execute('UPDATE packaging_requests SET estimated_price = ?, updated_at = NOW() WHERE id = ?', [$price, $id]);
        flash('success', 'تم تحديث السعر التقديري.');
        redirect('requests.show', ['id' => $id]);
    }

    public function sendMessage(int $id): void
    {
        $this->auth->requireAuth();
        verify_csrf();

        $user = $this->auth->user();
        $message = trim($_POST['message'] ?? '');
        if ($message === '') {
            flash('error', 'اكتب رسالة قبل الإرسال.');
            redirect('requests.show', ['id' => $id]);
        }

        $request = $this->db->query('SELECT customer_id, assigned_to FROM packaging_requests WHERE id = ?', [$id])[0] ?? null;
        if (!$request) {
            flash('error', 'الطلب غير موجود.');
            redirect('dashboard');
        }

        $allowed = $user['role'] === 'admin' || (int) $request['customer_id'] === (int) $user['id'] || (int) $request['assigned_to'] === (int) $user['id'];
        if (!$allowed) {
            http_response_code(403);
            exit('غير مصرح');
        }

        $this->db->execute('INSERT INTO request_messages (request_id, sender_id, message, created_at) VALUES (?, ?, ?, NOW())', [$id, $user['id'], $message]);
        flash('success', 'تم إرسال الرسالة.');
        redirect('requests.show', ['id' => $id]);
    }
}
