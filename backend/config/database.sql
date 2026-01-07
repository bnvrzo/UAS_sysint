-- Database Creation Script for Towerindo
-- This script creates the database with XML integration support

-- Create Database
CREATE DATABASE IF NOT EXISTS towerindo_db;
USE towerindo_db;

-- Users Table (Admin Authentication)
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- News Table
CREATE TABLE IF NOT EXISTS news (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content LONGTEXT NOT NULL,
    image_url VARCHAR(255),
    author_id INT NOT NULL,
    category VARCHAR(100),
    status ENUM('draft', 'published') DEFAULT 'draft',
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    xml_backup_path VARCHAR(255),
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Customer Growth Data Table
CREATE TABLE IF NOT EXISTS customer_growth (
    id INT PRIMARY KEY AUTO_INCREMENT,
    year INT NOT NULL,
    total_customers INT NOT NULL,
    growth_percentage DECIMAL(5, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_year (year)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- BTS Coverage Data Table
CREATE TABLE IF NOT EXISTS bts_coverage (
    id INT PRIMARY KEY AUTO_INCREMENT,
    island_name VARCHAR(100) NOT NULL,
    bts_count INT NOT NULL,
    population INT,
    coverage_percentage DECIMAL(5, 2),
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    xml_backup_path VARCHAR(255),
    INDEX idx_island_name (island_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Admin Activity Log
CREATE TABLE IF NOT EXISTS admin_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    action VARCHAR(100),
    table_name VARCHAR(100),
    record_id INT,
    changes LONGTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_action (action),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Sample Admin User
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@towerindo.com', '$2y$10$N9qo8uLOickgx2ZMRZoHy.Qj2aTzRWjHsYxhzOjBP.r3XvGn1wfJy', 'admin');

-- Insert Sample Customer Growth Data
INSERT INTO customer_growth (year, total_customers, growth_percentage) VALUES
(2020, 5000, 0),
(2021, 7500, 50),
(2022, 12000, 60),
(2023, 18500, 54.17),
(2024, 26500, 43.24),
(2025, 35000, 32.08);

-- Insert Sample BTS Coverage Data (Major Indonesian Islands)
INSERT INTO bts_coverage (island_name, bts_count, population, coverage_percentage, latitude, longitude) VALUES
('Jawa', 3500, 150000000, 98.5, -6.9175, 107.6928),
('Sumatra', 1200, 56000000, 85.3, 0.5467, 101.4477),
('Kalimantan', 850, 16500000, 72.4, -0.1804, 111.4605),
('Sulawesi', 680, 19000000, 68.9, -2.5071, 120.7554),
('Papua', 450, 4000000, 45.2, -3.5898, 132.2384),
('Bali-Nusa Tenggara', 620, 8200000, 92.1, -8.6705, 115.2126),
('Maluku', 380, 2000000, 52.6, -3.1883, 129.4060),
('Riau Islands', 290, 1800000, 88.3, 1.0547, 101.4477);
