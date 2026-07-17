DROP DATABASE IF EXISTS phantomdb;
CREATE DATABASE phantomdb;
USE phantomdb;

-- Users Table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,

    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,

    password_hash VARCHAR(255) NOT NULL,

    role ENUM('ADMIN', 'SELLER', 'BUYER') NOT NULL,

    status ENUM('ACTIVE', 'INACTIVE') DEFAULT 'ACTIVE',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);

-- Admin
INSERT INTO users (
    username,
    email,
    password_hash,
    role
)
VALUES (
    'admin',
    'admin@phantom.com',
    'admin123',
    'ADMIN'
);

-- Seller
INSERT INTO users (
    username,
    email,
    password_hash,
    role
)
VALUES (
    'seller',
    'seller@phantom.com',
    'seller123',
    'SELLER'
);