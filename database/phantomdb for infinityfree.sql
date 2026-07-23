USE if0_42440932_phantomdb;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('ADMIN','SELLER','BUYER') NOT NULL DEFAULT 'BUYER',
    verified ENUM('YES','NO') DEFAULT 'NO',
    verify_token VARCHAR(64) DEFAULT NULL
);

INSERT INTO users (username, email, password_hash, role, verified)
VALUES
('Admin',           'admin@phantomstore.com',        '$2y$10$dUO1Kf/f6hLwtsHqgK1KEeIBb/m9kEWbkGSeLHYTdILuJuExjv5bO',      'ADMIN',     'YES'),
('Bondoc',          'bondoc@phantomstore.com',       '$2y$10$dUO1Kf/f6hLwtsHqgK1KEeIBb/m9kEWbkGSeLHYTdILuJuExjv5bO',      'SELLER',    'YES'),
('Tamayo',          'tamayo@phantomstore.com',       '$2y$10$dUO1Kf/f6hLwtsHqgK1KEeIBb/m9kEWbkGSeLHYTdILuJuExjv5bO',      'SELLER',    'YES'),
('Comendador',      'comendador@phantomstore.com',   '$2y$10$dUO1Kf/f6hLwtsHqgK1KEeIBb/m9kEWbkGSeLHYTdILuJuExjv5bO',      'BUYER',     'YES'),
('Miranda',         'miranda@phantomstore.com',      '$2y$10$dUO1Kf/f6hLwtsHqgK1KEeIBb/m9kEWbkGSeLHYTdILuJuExjv5bO',      'BUYER',     'YES'),
('Seller',          'seller@phantomstore.com',       '$2y$10$dUO1Kf/f6hLwtsHqgK1KEeIBb/m9kEWbkGSeLHYTdILuJuExjv5bO',      'SELLER',    'YES'),
('Buyer',           'buyer@phantomstore.com',        '$2y$10$dUO1Kf/f6hLwtsHqgK1KEeIBb/m9kEWbkGSeLHYTdILuJuExjv5bO',      'BUYER',     'YES');


CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL
);

INSERT INTO categories (category_name)
VALUES
('Chairs'),
('Desks'),
('Tables'),
('Storages'),
('Arms & Stands');

CREATE TABLE inventory (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    product_name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock_quantity INT NOT NULL DEFAULT 0,
    image VARCHAR(255),
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

INSERT INTO inventory (category_id, product_name, description, price, stock_quantity, image)
VALUES
(1,     'Ergonomic Office Chair',       'Mesh backrest, adjustable armrests, 5-wheel base',                 3500.00, 10,    'chair_1.jpg'),
(2,     'Adjustable Desk',              'Wooden surface, black paneling, adjustable metal legs',            5200.00, 5,     'desk_1.jpg'),
(3,     'Conference Table',             'Large rectangular table with metal legs',                          7200.00, 3,     'table_1.jpg'),
(4,     'White Storage Cabinet',        'Six horizontal drawers with sleek handles',                        4800.00, 8,     'drawer_1.jpg'),
(5,     'Adjustable Phone Stand',       'Metallic stand with adjustable height mechanism',                  1500.00, 15,    'stand_1.jpg');


CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES inventory(product_id)
);


CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    order_status ENUM('PENDING','COMPLETED','CANCELLED') DEFAULT 'PENDING',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES inventory(product_id)
);

CREATE TABLE audit_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    activity VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
