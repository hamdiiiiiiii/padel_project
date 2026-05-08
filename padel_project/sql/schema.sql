CREATE DATABASE IF NOT EXISTS padel_db;
USE padel_db;

CREATE TABLE IF NOT EXISTS courts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    type VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'available'
);

INSERT INTO courts (name, location, price, type, status) VALUES
('Central Court', '📍 Mivida', 400, 'Indoor', 'available'),
('Lakeside Court', '📍 Hyde park Sports Club', 450, 'Outdoor', 'available'),
('Elite Arena', '📍 Cairo Staduim', 350, 'Indoor', 'busy'),
('Pro Court', '📍 New Cairo Club', 500, 'Premium', 'available');
