-- UniTrade Database Schema for XAMPP
CREATE DATABASE IF NOT EXISTS unitrade;
USE unitrade;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Profiles Table
CREATE TABLE profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    ugr_id VARCHAR(20) UNIQUE NOT NULL,
    astu_email VARCHAR(255) NOT NULL,
    telegram_username VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    department VARCHAR(100),
    year_of_study INT,
    is_verified BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- User Roles Table
CREATE TABLE user_roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    role ENUM('student', 'admin') DEFAULT 'student',
    UNIQUE(user_id, role),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Categories Table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(50) UNIQUE NOT NULL,
    label VARCHAR(100) NOT NULL,
    description TEXT,
    icon VARCHAR(50)
);

-- Insert Categories
INSERT INTO categories (`key`, label, description, icon) VALUES
('electronics', 'Electronics', 'Laptops, phones, accessories', 'laptop'),
('stationery', 'Stationery', 'Books, pens, notebooks', 'book'),
('clothes', 'Clothes', 'Apparel, jackets, traditional wear', 'shirt'),
('shoes', 'Shoes', 'Sneakers, formals, sandals', 'footprints'),
('dorm', 'Dorm Essentials', 'Bedding, lamps, kitchenware', 'home'),
('food', 'Food & Beverage', 'Injera & wot, burgers, pasta, coffee, juices', 'utensils');

-- Items Table
CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT NOT NULL,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    price_etb DECIMAL(10, 2) NOT NULL,
    `condition` ENUM('new', 'used') NOT NULL,
    image_url VARCHAR(500),
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    rejection_reason TEXT,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Item Images Table
CREATE TABLE item_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_primary BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE
);
