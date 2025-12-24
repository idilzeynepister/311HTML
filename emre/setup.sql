-- Create database if not exists
CREATE DATABASE IF NOT EXISTS n11;
USE n11;

-- Create products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    old_price DECIMAL(10, 2),
    image_url VARCHAR(255),
    brand VARCHAR(100),
    discount_rate INT,
    coupon VARCHAR(50),
    rating DECIMAL(2, 1) DEFAULT 0,
    review_count INT DEFAULT 0
);

-- Insert sample data (Clothing & Shoes)
INSERT INTO products (name, price, old_price, image_url, brand, discount_rate, coupon, rating, review_count) VALUES
('Jack & Jones Jjebasic Erkek Tişört', 149.99, 299.99, 'https://n11scdn.akamaized.net/a1/352/24/05/22/38/59/20/38/54/12/36/45/85/385920385412364585.jpg', 'Jack & Jones', 50, 'Kuponlu', 4.5, 120),
('Adidas Erkek Spor Ayakkabı', 1299.00, 1899.00, 'https://n11scdn.akamaized.net/a1/352/24/05/17/76/62/83/86/74/59/17/63/79/766283867459176379.jpg', 'Adidas', 32, NULL, 4.8, 450),
('Mavi Erkek Jeans', 699.99, 899.99, 'https://n11scdn.akamaized.net/a1/352/24/04/25/11/47/06/15/45/03/75/12/1147061545037512.jpg', 'Mavi', 22, 'Sepette %10', 4.6, 210),
('Nike Revolution 6 Erkek Koşu Ayakkabısı', 2100.00, 2500.00, 'https://n11scdn.akamaized.net/a1/352/23/08/11/65/59/82/53/35/65/04/55/6559825335650455.jpg', 'Nike', 16, NULL, 4.7, 300),
('Puma Smash v2 Unisex Günlük Ayakkabı', 1599.90, 2200.00, 'https://n11scdn.akamaized.net/a1/352/22/09/20/65/92/74/48/43/66/14/06/6592744843661406.jpg', 'Puma', 27, NULL, 4.4, 85),
('US Polo Assn. Erkek Gömlek', 399.99, 799.99, 'https://n11scdn.akamaized.net/a1/352/24/02/14/19/23/52/49/09/16/95/96/1923524909169596.jpg', 'US Polo Assn.', 50, 'Kuponlu', 4.3, 150),
('Koton Kadın Elbise', 259.99, 459.99, 'https://n11scdn.akamaized.net/a1/352/23/06/15/78/34/41/50/80/77/82/13/7834415080778213.jpg', 'Koton', 43, NULL, 4.2, 60),
('Hummel Erkek Tişört', 199.99, 350.00, 'https://n11scdn.akamaized.net/a1/352/23/04/05/23/83/83/66/83/80/37/87/2383836683803787.jpg', 'Hummel', 43, 'Sepette %5', 4.5, 95);
