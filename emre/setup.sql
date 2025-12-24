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
-- Adidas (Spor Ayakkabı)
('Adidas Superstar Spor Ayakkabı', 2499.00, 3299.00, 'https://n11scdn.akamaized.net/a1/352/24/05/17/76/62/83/86/74/59/17/63/79/766283867459176379.jpg', 'Adidas', 24, NULL, 4.8, 1500),
('Adidas Stan Smith Spor Ayakkabı', 2100.00, 2800.00, 'https://n11scdn.akamaized.net/a1/352/24/05/17/76/62/83/86/74/59/17/63/79/766283867459176379.jpg', 'Adidas', 25, 'Sepette %10', 4.7, 890),
('Adidas Ultraboost Spor Ayakkabı', 4500.00, 5500.00, 'https://n11scdn.akamaized.net/a1/352/24/05/17/76/62/83/86/74/59/17/63/79/766283867459176379.jpg', 'Adidas', 18, NULL, 4.9, 320),
-- Nike (Spor Ayakkabı)
('Nike Air Force 1 Spor Ayakkabı', 3200.00, 3800.00, 'https://n11scdn.akamaized.net/a1/352/23/08/11/65/59/82/53/35/65/04/55/6559825335650455.jpg', 'Nike', 15, NULL, 4.6, 1200),
('Nike Dunk Low Spor Ayakkabı', 3500.00, 4200.00, 'https://n11scdn.akamaized.net/a1/352/23/08/11/65/59/82/53/35/65/04/55/6559825335650455.jpg', 'Nike', 16, NULL, 4.8, 450),
('Nike Revolution 6 Spor Ayakkabı', 2100.00, 2500.00, 'https://n11scdn.akamaized.net/a1/352/23/08/11/65/59/82/53/35/65/04/55/6559825335650455.jpg', 'Nike', 16, NULL, 4.5, 300),
-- Puma (Günlük Ayakkabı)
('Puma Smash v2 Günlük Ayakkabı', 1599.90, 2200.00, 'https://n11scdn.akamaized.net/a1/352/22/09/20/65/92/74/48/43/66/14/06/6592744843661406.jpg', 'Puma', 27, NULL, 4.4, 185),
('Puma Caven 2.0 Günlük Ayakkabı', 1800.00, 2400.00, 'https://n11scdn.akamaized.net/a1/352/22/09/20/65/92/74/48/43/66/14/06/6592744843661406.jpg', 'Puma', 25, 'Kuponlu', 4.3, 120),
('Puma Rider FV Günlük Ayakkabı', 2300.00, 3000.00, 'https://n11scdn.akamaized.net/a1/352/22/09/20/65/92/74/48/43/66/14/06/6592744843661406.jpg', 'Puma', 23, NULL, 4.5, 75),
-- Jack & Jones (Giyim meant to be generic, but let's mix daily shoes if needed or keep clothing)
('JJ T-Shirt Basic', 299.00, 400.00, 'https://n11scdn.akamaized.net/a1/352/24/05/22/38/59/20/38/54/12/36/45/85/385920385412364585.jpg', 'Jack & Jones', 25, 'Sepette %20', 4.2, 500),
('JJ Denim Pantolon', 899.00, 1200.00, 'https://n11scdn.akamaized.net/a1/352/24/05/22/38/59/20/38/54/12/36/45/85/385920385412364585.jpg', 'Jack & Jones', 25, NULL, 4.6, 340),
('JJ Günlük Ayakkabı Sneaker', 1200.00, 1600.00, 'https://n11scdn.akamaized.net/a1/352/24/05/22/38/59/20/38/54/12/36/45/85/385920385412364585.jpg', 'Jack & Jones', 25, NULL, 4.4, 210),
-- Mavi (Günlük Ayakkabı included)
('Mavi Slim Fit Jean', 799.00, 1100.00, 'https://n11scdn.akamaized.net/a1/352/24/04/25/11/47/06/15/45/03/75/12/1147061545037512.jpg', 'Mavi', 27, NULL, 4.7, 800),
('Mavi Günlük Ayakkabı', 950.00, 1400.00, 'https://n11scdn.akamaized.net/a1/352/24/04/25/11/47/06/15/45/03/75/12/1147061545037512.jpg', 'Mavi', 32, 'Sepette %10', 4.5, 600),
('Mavi Kot Ceket', 1200.00, 1800.00, 'https://n11scdn.akamaized.net/a1/352/24/04/25/11/47/06/15/45/03/75/12/1147061545037512.jpg', 'Mavi', 33, NULL, 4.6, 250),
-- Koton (Çanta)
('Koton Kadın Elbise', 450.00, 600.00, 'https://n11scdn.akamaized.net/a1/352/23/06/15/78/34/41/50/80/77/82/13/7834415080778213.jpg', 'Koton', 25, NULL, 4.3, 180),
('Koton Çanta Siyah', 300.00, 450.00, 'https://n11scdn.akamaized.net/a1/352/23/06/15/78/34/41/50/80/77/82/13/7834415080778213.jpg', 'Koton', 33, 'Kuponlu', 4.2, 70),
('Koton Omuz Çanta', 350.00, 500.00, 'https://n11scdn.akamaized.net/a1/352/23/06/15/78/34/41/50/80/77/82/13/7834415080778213.jpg', 'Koton', 30, NULL, 4.1, 85),
-- US Polo Assn.
('US Polo Gömlek Mavi', 550.00, 900.00, 'https://n11scdn.akamaized.net/a1/352/24/02/14/19/23/52/49/09/16/95/96/1923524909169596.jpg', 'US Polo Assn.', 38, NULL, 4.5, 400),
('US Polo Günlük Ayakkabı', 1400.00, 2000.00, 'https://n11scdn.akamaized.net/a1/352/24/02/14/19/23/52/49/09/16/95/96/1923524909169596.jpg', 'US Polo Assn.', 30, NULL, 4.4, 250),
('US Polo Triko', 700.00, 1100.00, 'https://n11scdn.akamaized.net/a1/352/24/02/14/19/23/52/49/09/16/95/96/1923524909169596.jpg', 'US Polo Assn.', 36, NULL, 4.6, 150),
-- Hummel
('Hummel Spor Ayakkabı', 900.00, 1400.00, 'https://n11scdn.akamaized.net/a1/352/23/04/05/23/83/83/66/83/80/37/87/2383836683803787.jpg', 'Hummel', 35, NULL, 4.3, 110),
('Hummel Spor Ayakkabı Koşu', 1200.00, 1500.00, 'https://n11scdn.akamaized.net/a1/352/23/04/05/23/83/83/66/83/80/37/87/2383836683803787.jpg', 'Hummel', 20, 'Sepette %15', 4.4, 200),
('Hummel Hoodie', 750.00, 1200.00, 'https://n11scdn.akamaized.net/a1/352/23/04/05/23/83/83/66/83/80/37/87/2383836683803787.jpg', 'Hummel', 37, NULL, 4.5, 140),
-- DeFacto
('DeFacto Slim Fit Pantolon', 350.00, 500.00, 'https://placehold.co/400x500/f0f0f0/333?text=DeFacto+Pants', 'DeFacto', 30, NULL, 4.1, 300),
('DeFacto Basic Tişört', 150.00, 250.00, 'https://placehold.co/400x500/f0f0f0/333?text=DeFacto+Tee', 'DeFacto', 40, 'Kuponlu', 4.0, 500),
('DeFacto Günlük Ayakkabı', 600.00, 900.00, 'https://placehold.co/400x500/f0f0f0/333?text=DeFacto+Shoes', 'DeFacto', 33, NULL, 4.3, 200),
-- CABANI (Bot & Çizme)
('CABANI Deri Bot & Çizme', 2800.00, 4500.00, 'https://placehold.co/400x500/333/fff?text=Cabani+Bot', 'CABANI', 37, NULL, 4.6, 80),
('CABANI Klasik Bot & Çizme', 3200.00, 5000.00, 'https://placehold.co/400x500/333/fff?text=Cabani+Klasik', 'CABANI', 36, NULL, 4.7, 90),
('CABANI Süet Bot & Çizme', 2900.00, 4600.00, 'https://placehold.co/400x500/333/fff?text=Cabani+Suet', 'CABANI', 37, 'Sepette %10', 4.5, 60),
-- SALOMON (Bot & Çizme / Outdoor)
('Salomon XA Pro Bot & Çizme', 4500.00, 6000.00, 'https://placehold.co/400x500/555/fff?text=Salomon+XA', 'SALOMON', 25, NULL, 4.9, 150),
('Salomon Speedcross Bot & Çizme', 4800.00, 6500.00, 'https://placehold.co/400x500/555/fff?text=Salomon+Speed', 'SALOMON', 26, NULL, 4.8, 200),
('Salomon X Ultra Bot & Çizme', 5200.00, 7000.00, 'https://placehold.co/400x500/555/fff?text=Salomon+Ultra', 'SALOMON', 25, NULL, 4.8, 110),
-- MANUKA (Çanta)
('MANUKA Çapraz Çanta', 450.00, 700.00, 'https://placehold.co/400x500/eee/333?text=Manuka+Bag', 'MANUKA', 35, NULL, 4.4, 250),
('MANUKA Sırt Çanta', 650.00, 950.00, 'https://placehold.co/400x500/eee/333?text=Manuka+Backpack', 'MANUKA', 31, NULL, 4.5, 180),
('MANUKA Cüzdan Çanta', 150.00, 250.00, 'https://placehold.co/400x500/eee/333?text=Manuka+Wallet', 'MANUKA', 40, NULL, 4.3, 300),
-- Saat&Saat
('Saat&Saat Erkek Kol Saati', 3500.00, 5000.00, 'https://placehold.co/400x500/222/fff?text=Watch+Men', 'Saat&Saat', 30, NULL, 4.7, 120),
('Saat&Saat Kadın Kol Saati', 3200.00, 4800.00, 'https://placehold.co/400x500/222/fff?text=Watch+Women', 'Saat&Saat', 33, 'Kuponlu', 4.6, 140),
('Michael Kors Saat (S&S)', 5500.00, 8000.00, 'https://placehold.co/400x500/222/fff?text=MK+Watch', 'Saat&Saat', 31, NULL, 4.8, 90),
-- DILVIN (Topuklu Ayakkabı fillers)
('DILVIN Triko Kazak', 350.00, 600.00, 'https://placehold.co/400x500/ddd/000?text=Dilvin+Knit', 'DILVIN', 41, NULL, 4.2, 110),
('DILVIN Topuklu Ayakkabı', 1200.00, 1800.00, 'https://placehold.co/400x500/ddd/000?text=Dilvin+Heel', 'DILVIN', 33, NULL, 4.0, 50),
('DILVIN Ceket', 750.00, 1200.00, 'https://placehold.co/400x500/ddd/000?text=Dilvin+Jacket', 'DILVIN', 37, NULL, 4.3, 80),
-- MAI STUDIOS
('MAI Oversize Tshirt', 400.00, 650.00, 'https://placehold.co/400x500/888/fff?text=MAI+Tshirt', 'MAI STUDIO', 38, NULL, 4.5, 90),
('MAI Jogger Pantolon', 600.00, 950.00, 'https://placehold.co/400x500/888/fff?text=MAI+Jogger', 'MAI STUDIO', 36, NULL, 4.6, 70),
('MAI Topuklu Ayakkabı', 1500.00, 2200.00, 'https://placehold.co/400x500/888/fff?text=MAI+Heel', 'MAI STUDIO', 32, NULL, 4.7, 40),
-- Topuklu Ayakkabı specific
('Nine West Stiletto Topuklu Ayakkabı', 1200.00, 2000.00, 'https://placehold.co/400x500/000/fff?text=Stiletto', 'Nine West', 40, NULL, 4.5, 200),
('Derimod Platform Topuklu Ayakkabı', 1500.00, 2400.00, 'https://placehold.co/400x500/000/fff?text=Platform', 'Derimod', 37, NULL, 4.4, 150),
('Bambi Klasik Topuklu Ayakkabı', 900.00, 1500.00, 'https://placehold.co/400x500/000/fff?text=Bambi', 'Bambi', 40, NULL, 4.1, 300);

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    email VARCHAR(100)
);

-- Insert Test User (admin / 1234)
INSERT INTO users (username, password, full_name, email) VALUES 
('admin', '1234', 'Admin User', 'admin@n11.com')
ON DUPLICATE KEY UPDATE password='1234';

-- Cart Table
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_item (user_id, product_id)
);
