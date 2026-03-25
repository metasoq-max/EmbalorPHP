CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    phone VARCHAR(60) NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','worker','designer','customer') NOT NULL DEFAULT 'customer',
    created_at DATETIME NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(120) NOT NULL UNIQUE,
    setting_value TEXT NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS packaging_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    assigned_to INT NULL,
    service_type ENUM('design_to_3d','team_design') NOT NULL DEFAULT 'design_to_3d',
    package_shape VARCHAR(120) NULL,
    title VARCHAR(190) NULL,
    description TEXT NULL,
    dimensions VARCHAR(120) NULL,
    contact_only TINYINT(1) NOT NULL DEFAULT 0,
    reference_file VARCHAR(255) NULL,
    estimated_price DECIMAL(10,2) NULL,
    status ENUM('new','in_progress','waiting_customer','done','cancelled') NOT NULL DEFAULT 'new',
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    CONSTRAINT fk_requests_customer FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_requests_assigned FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS request_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_id INT NOT NULL,
    sender_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NULL,
    CONSTRAINT fk_messages_request FOREIGN KEY (request_id) REFERENCES packaging_requests(id) ON DELETE CASCADE,
    CONSTRAINT fk_messages_sender FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
