CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO users (username, email, password) VALUES
('john_doe', 'john@example.com', MD5('password123')),
('jane_doe', 'jane@example.com', MD5('password123')),
('mike_smith', 'mike@example.com', MD5('password123'));

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description CHARACTER(100),
    price DECIMAL(10, 2),
    image VARCHAR(255)
);

INSERT INTO products (name, description, price, image) VALUES
('Casual Shirt', 'Elegant Casual dress perfect for any event', 100.00, 'prod1.jpg'),
('Formal Shirt', 'Elegant Formal dress perfect for any event', 150.00, 'prod2.jpg'),
('Grey pant', 'Elegant grey dress perfect for any event.', 120.00, 'prod3.jpg'),
('Black pant', 'Description of Product 4', 200.00, 'prod4.jpg'),
('blue shoes', 'Comfortable and stylish blue sneakers.', 80.00, 'prod5.jpg'),
('Red Sneakers', 'Comfortable and stylish red sneakers.', 50.99, 'prod6.jpg'),
('Blue Denim Jacket', 'Trendy blue denim jacket for all occasions.', 75.49, 'prod7.jpg'),
('Black Leather Wallet', 'Premium black leather wallet.', 25.00, 'prod8.jpg'),
('Wireless Headphones', 'Bluetooth-enabled wireless headphones.', 89.99, 'prod9.jpg'),
('Smart Watch', 'Modern smartwatch with fitness tracking.', 149.99, 'prod10.jpg'),
('Red Dress', 'Elegant red dress perfect for any event.', 120.00, 'prod11.jpg'),
('Black Sunglasses', 'Stylish black sunglasses for sunny days.', 30.00, 'prod12.jpg'),
('Blue Running Shoes', 'High-performance blue running shoes.', 60.00, 'prod13.jpg'),
('Leather Jacket', 'Premium black leather jacket.', 200.00, 'prod14.jpg'),
('Gaming Mouse', 'RGB-backlit gaming mouse with high precision.', 45.00, 'prod15.jpg');

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
