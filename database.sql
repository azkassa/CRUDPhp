CREATE DATABASE IF NOT EXISTS crud_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE crud_db;

CREATE TABLE IF NOT EXISTS mahasiswa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nim VARCHAR(20) NOT NULL UNIQUE,
  nama VARCHAR(100) NOT NULL,
  jurusan VARCHAR(100) NOT NULL,
  email VARCHAR(100) NULL,
  no_hp VARCHAR(20) NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO mahasiswa (nim, nama, jurusan, email, no_hp) VALUES
('2024001', 'Budi Santoso', 'Teknik Informatika', 'budi@example.com', '081234567890'),
('2024002', 'Siti Aminah', 'Sistem Informasi', 'siti@example.com', '082233445566'),
('2024003', 'Andi Pratama', 'Teknik Elektro', NULL, NULL);
