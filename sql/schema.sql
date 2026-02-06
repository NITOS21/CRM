CREATE DATABASE IF NOT EXISTS crm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE crm;

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(190) DEFAULT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    company VARCHAR(150) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS opportunities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    company VARCHAR(150) DEFAULT NULL,
    stage ENUM('Prospección', 'Calificada', 'Propuesta', 'Ganada', 'Perdida') NOT NULL DEFAULT 'Prospección',
    amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO contacts(name, email, phone, company)
VALUES
('Ana Torres', 'ana@acme.com', '+52 555 0101', 'ACME'),
('Luis Pérez', 'luis@globex.com', '+52 555 2345', 'Globex');

INSERT INTO opportunities(title, company, stage, amount)
VALUES
('Implementación CRM', 'ACME', 'Propuesta', 25000.00),
('Automatización Ventas', 'Globex', 'Calificada', 18000.00);
