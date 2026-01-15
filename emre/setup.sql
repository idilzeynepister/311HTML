CREATE DATABASE IF NOT EXISTS n11;
USE n11;

-- Disable foreign key checks for clean drop
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS cart;
DROP TABLE IF EXISTS product_variants;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    email VARCHAR(100)
);

INSERT INTO users (username, password, full_name, email) VALUES 
('admin', '1234', 'Admin User', 'admin@n11.com');

-- 2. Products Table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    old_price DECIMAL(10, 2),
    image_url VARCHAR(255),
    brand VARCHAR(100),
    discount_rate INT,
    coupon VARCHAR(50),
    rating DECIMAL(2, 1) DEFAULT 0,
    review_count INT DEFAULT 0,
    type ENUM('cloth', 'shoe', 'std') DEFAULT 'std'
);

-- Seed Products (Initial type will be 'std', updated below)
INSERT INTO products (name, price, old_price, image_url, brand, discount_rate, coupon, rating, review_count) VALUES
('Adidas Superstar Spor Ayakkabı', 2499.00, 3299.00, 'https://korayspor.sm.mncdn.com/mnresize/1920/-/korayspor/products/JH7032_3.jpg', 'Adidas', 24, NULL, 4.8, 1500),
('Adidas Stan Smith Spor Ayakkabı', 2100.00, 2800.00, 'https://static.ticimax.cloud/37646/uploads/urunresimleri/buyuk/adidas-stan-smith-erkek-gunluk-spor-ay-7f-4e7.jpg', 'Adidas', 25, 'Sepette %10', 4.7, 890),
('Adidas Ultraboost Spor Ayakkabı', 4500.00, 5500.00, 'https://minio.yalispor.com.tr/yalispor/images/adidas-ultraboost-10-erkek-spor-ayakkabi-beyaz-1-1690194326.jpg', 'Adidas', 18, NULL, 4.9, 320),
('Nike Air Force 1 Spor Ayakkabı', 3200.00, 3800.00, 'https://img.sportinn.com.tr/nike-air-force-1-07-erkek-sneaker-ayakkabi-cw2288-111-153736-43-B.jpg', 'Nike', 15, NULL, 4.6, 1200),
('Nike Dunk Low Spor Ayakkabı', 3500.00, 4200.00, 'https://static.nike.com/a/images/t_web_pdp_936_v2/f_auto/b1bcbca4-e853-4df7-b329-5be3c61ee057/NIKE+DUNK+LOW+RETRO.png', 'Nike', 16, NULL, 4.8, 450),
('Nike Revolution 6 Spor Ayakkabı', 2100.00, 2500.00, 'https://korayspor.sm.mncdn.com/mnresize/1920/-/korayspor/products/DC3728-401_1.jpg', 'Nike', 16, NULL, 4.5, 300),
('Puma Smash v2 Günlük Ayakkabı', 1599.90, 2200.00, 'https://floimages.mncdn.com/media/catalog/product/25-01/09/100325849_d1-1736427525.jpg', 'Puma', 27, NULL, 4.4, 185),
('Puma Caven 2.0 Günlük Ayakkabı', 1800.00, 2400.00, 'https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,e_sharpen/global/392290/04/sv04/fnd/TUR/w/1000/h/1000/fmt/png', 'Puma', 25, 'Kuponlu', 4.3, 120),
('Puma Rider FV Günlük Ayakkabı', 2300.00, 3000.00, 'https://korayspor.sm.mncdn.com/mnresize/1920/-/korayspor/products/30760501_1.jpg', 'Puma', 23, NULL, 4.5, 75),
('JJ T-Shirt Basic', 299.00, 400.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTfDv49YDxnG-OLzpg_t7Ch2TZXozuJDW2dvQ&s', 'Jack & Jones', 25, 'Sepette %20', 4.2, 500),
('JJ Denim Pantolon', 899.00, 1200.00, 'https://cdn.dsmcdn.com/mnresize/420/620/ty1782/prod/QC_PREP/20251031/19/1f72434e-429e-3de0-ab45-7f572c58ab5b/1_org_zoom.jpg', 'Jack & Jones', 25, NULL, 4.6, 340),
('JJ Günlük Ayakkabı Sneaker', 1200.00, 1600.00, 'https://floimages.mncdn.com/media/catalog/product/25-07/01/102053385_f1.jpg', 'Jack & Jones', 25, NULL, 4.4, 210),
('Mavi Slim Fit Jean', 799.00, 1100.00, 'https://www.sementa.com/cdn/shop/files/eskitme-yikamali-slim-fit-jean-pantolon-mavi-32722.jpg?v=1738787108&width=1600', 'Mavi', 27, NULL, 4.7, 800),
('Mavi Günlük Ayakkabı', 950.00, 1400.00, 'https://static.ticimax.cloud/55294/uploads/urunresimleri/buyuk/mavi-kadin-gunluk-ayakkabi-9f-467.png', 'Mavi', 32, 'Sepette %10', 4.5, 600),
('Mavi Kot Ceket', 1200.00, 1800.00, 'https://cdn.dsmcdn.com/mnresize/420/620/ty1761/prod/QC_ENRICHMENT/20250922/05/ca9615b1-3992-3136-b2da-32928989e17c/1_org_zoom.jpg', 'Mavi', 33, NULL, 4.6, 250),
('Koton Kadın Elbise', 450.00, 600.00, 'https://ktnimg2.mncdn.com/products/2024/06/13/2410054/98b80df1-72b4-4bcb-b96c-a55394a444aa_size870x1142.jpg', 'Koton', 25, NULL, 4.3, 180),
('Koton Çanta Siyah', 300.00, 450.00, 'https://ktnimg2.mncdn.com/products/2024/03/05/2870828/39ff1b36-970f-4eb9-86c5-61da5aae02b4_size870x1142.jpg', 'Koton', 33, 'Kuponlu', 4.2, 70),
('Koton Omuz Çanta', 350.00, 500.00, 'https://ktnimg2.mncdn.com/products/2025/11/05/3149031/31fc1626-d89c-49db-9ab9-f4a4ae1289a2_size708x930.jpg', 'Koton', 30, NULL, 4.1, 85),
('US Polo Gömlek Mavi', 550.00, 900.00, 'https://25d163-uspolo.akinoncloudcdn.com/products/2019/08/28/176744/44019629-8795-44c2-b6b1-81d39580535e_size2800x2800_quality100.jpg', 'US Polo Assn.', 38, NULL, 4.5, 400),
('US Polo Günlük Ayakkabı', 1400.00, 2000.00, 'https://img.sporpark.com.tr/us-polo-assn-4m-poker-4fx-erkek-sneaker-ayakkabi-beyaz-sneakers-us-polo-assn-101502097-107687-13-B.jpg', 'US Polo Assn.', 30, NULL, 4.4, 250),
('US Polo Triko', 700.00, 1100.00, 'https://25d163-uspolo.akinoncloudcdn.com/products/2021/08/17/541726/33ada028-c5e2-4302-b5f1-714bff9b69e6_size2800x2800_quality100.jpg', 'US Polo Assn.', 36, NULL, 4.6, 150),
('Hummel Spor Ayakkabı', 900.00, 1400.00, 'https://st-hummel.mncdn.com/Content/media/ProductImg/original/900615-2001-vm78-cph-ayakkabi-638587984616377235.jpg', 'Hummel', 35, NULL, 4.3, 110),
('Hummel Spor Ayakkabı Koşu', 1200.00, 1500.00, 'https://cdn.dsmcdn.com/mnresize/420/620/ty1229/product/media/images/prod/SPM/PIM/20240326/14/b7fb7e28-3719-395b-9024-95f9ff631cb9/1_org_zoom.jpg', 'Hummel', 20, 'Sepette %15', 4.4, 200),
('Hummel Hoodie', 750.00, 1200.00, 'https://st-hummel.mncdn.com/mnresize/548/548/Content/media/ProductImg/original/921836-2001-t-ic-ico-fermuarli-hoodie-638399990076787813.jpg', 'Hummel', 37, NULL, 4.5, 140),
('DeFacto Slim Fit Pantolon', 350.00, 500.00, 'https://dfcdn.defacto.com.tr/7/T1055AZ_24SP_NV147_01_04.jpg', 'DeFacto', 30, NULL, 4.1, 300),
('DeFacto Basic T-Shirt', 150.00, 250.00, 'https://dfcdn.defacto.com.tr/376/N2104AZ_25AU_WT34_01_01.jpg', 'DeFacto', 40, 'Kuponlu', 4.0, 500),
('DeFacto Günlük Ayakkabı', 600.00, 900.00, 'https://dfcdn.defacto.com.tr/7/C8780AX_NS_BN45_01_01.jpg', 'DeFacto', 33, NULL, 4.3, 200),
('CABANI Deri Bot & Çizme', 2800.00, 4500.00, 'https://static.ticimax.cloud/cdn-cgi/image/width=-,quality=85/41550/uploads/urunresimleri/buyuk/hakiki-deri-siyah-kadin-gunluk-bot-ciz-ed1-6f.jpg', 'CABANI', 37, NULL, 4.6, 80),
('CABANI Klasik Bot & Çizme', 3200.00, 5000.00, 'https://static.ticimax.cloud/41550/uploads/urunresimleri/buyuk/hakiki-deri-kahverengi-fermuarli-gunlu-4bb9-8.jpg', 'CABANI', 36, NULL, 4.7, 90),
('CABANI Süet Bot & Çizme', 2900.00, 4600.00, 'https://cdn.dsmcdn.com/ty1794/prod/QC_PREP/20251206/11/62caa713-3692-3336-932d-c0ff2dd4da88/1_org_zoom.jpg', 'CABANI', 37, 'Sepette %10', 4.5, 60),
('Salomon XA Pro Bot & Çizme', 4500.00, 6000.00, 'https://cdn.dsmcdn.com/ty1212/product/media/images/prod/SPM/PIM/20240318/14/111982ce-a9fe-3a02-89bd-5f1e5c32990a/1_org_zoom.jpg', 'SALOMON', 25, NULL, 4.9, 150),
('Salomon Speedcross Bot & Çizme', 4800.00, 6500.00, 'https://www.sporfashion.com/salomon-speedcross-peak-gtx-478538-bot-cizme-salomon-5082549-96-B.jpg', 'SALOMON', 26, NULL, 4.8, 200),
('Salomon X Ultra Bot & Çizme', 5200.00, 7000.00, 'https://static.ticimax.cloud/cdn-cgi/image/width=-,quality=85/51771/uploads/urunresimleri/buyuk/x-ultra-4-mid-gtx-l41383400-9d58-c.jpg', 'SALOMON', 25, NULL, 4.8, 110),
('MANUKA Çapraz Çanta', 450.00, 700.00, 'https://cache.manuka.com.tr/product/cache/1200x1800_-76228-12-B.jpg', 'MANUKA', 35, NULL, 4.4, 250),
('MANUKA Sırt Çanta', 650.00, 950.00, 'https://cache.manuka.com.tr/product/cache/1200x1800_-86153-14-B.jpg', 'MANUKA', 31, NULL, 4.5, 180),
('MANUKA Cüzdan Çanta', 150.00, 250.00, 'https://cache.manuka.com.tr/product/cache/1200x1800_-80713-12-B.jpg', 'MANUKA', 40, NULL, 4.3, 300),
('Saat&Saat Erkek Kol Saati', 3500.00, 5000.00, 'https://cdn.saatvesaat.com.tr/mnresize/740/-/media/catalog/product/e/8/e8f3de3785e96a3b40681baca5fb9bb83061c5f693874356b217b3dcf687cd17.jpeg', 'Saat&Saat', 30, NULL, 4.7, 120),
('Saat&Saat Kadın Kol Saati', 3200.00, 4800.00, 'https://cdn.saatvesaat.com.tr/mnresize/740/-/media/catalog/product/8/2/82277924108cb8437af4bcf3cca807f1a189ad77fc33df03ac9d177d242488e5.jpeg', 'Saat&Saat', 33, 'Kuponlu', 4.6, 140),
('Michael Kors Saat (S&S)', 5500.00, 8000.00, 'https://cdn.saatvesaat.com.tr/mnresize/740/-/media/catalog/product/e/9/e9566df5c9f34acb996c800cf39bcc77207f8f060625d18b43d9871a3d1ed26e.jpeg', 'Saat&Saat', 31, NULL, 4.8, 90),
('DILVIN Triko Kazak', 350.00, 600.00, 'https://www.dilvin.com.tr/productimages/122868/original/103a01267_ekru.jpg', 'DILVIN', 41, NULL, 4.2, 110),
('DILVIN Topuklu Ayakkabı', 1200.00, 1800.00, 'https://www.dilvin.com.tr/productimages/100885/middle/112a06340_siyah.jpg', 'DILVIN', 33, NULL, 4.0, 50),
('DILVIN Ceket', 750.00, 1200.00, 'https://www.dilvin.com.tr/productimages/129837/original/101a60736_tas.jpg', 'DILVIN', 37, NULL, 4.3, 80),
('MAI Oversize Tshirt', 400.00, 650.00, 'https://static.ticimax.cloud/cdn-cgi/image/width=1845,quality=99/55981/uploads/urunresimleri/buyuk/gama-oversize-sort-t-shirt-takim-siyah-0a-0ae.jpg', 'MAI STUDIO', 38, NULL, 4.5, 90),
('MAI Jogger Pantolon', 600.00, 950.00, 'https://floimages.mncdn.com/media/catalog/product/24-05/30/201227280-1-1717048401.jpg', 'MAI STUDIO', 36, NULL, 4.6, 70),
('MAI Topuklu Ayakkabı', 1500.00, 2200.00, 'https://c38c9c.cdn.akinoncloud.com/products/2025/07/11/2248473/5be8d9ad-ccbb-4ac5-8f4f-9b4ddd23d74d_size368x560_cropCenter.jpg', 'MAI STUDIO', 32, NULL, 4.7, 40),
('Nine West Stiletto Topuklu Ayakkabı', 1200.00, 2000.00, 'https://floimages.mncdn.com/media/catalog/product/25-02/04/101928674_f2.JPG', 'Nine West', 40, NULL, 4.5, 200),
('Derimod Platform Topuklu Ayakkabı', 1500.00, 2400.00, 'https://derimod.com.tr/cdn/shop/files/bb21cd1330e7870a7c0ec28125054ddc_d1fade88-f534-4157-83a6-38ccbe1b5dcb_2048x2048.jpg?v=1755208287', 'Derimod', 37, NULL, 4.4, 150),
('Bambi Klasik Topuklu Ayakkabı', 900.00, 1500.00, 'https://static.ticimax.cloud/5412/uploads/urunresimleri/buyuk/siyah-kadin-klasik-topuklu-ayakkabi-k0-123894.jpg', 'Bambi', 40, NULL, 4.1, 300);

-- Update Product Types automatically
UPDATE products SET type = 'shoe' WHERE name LIKE '%Ayakkabı%' OR name LIKE '%Bot%' OR name LIKE '%Çizme%';
UPDATE products SET type = 'cloth' WHERE name LIKE '%T-Shirt%' OR name LIKE '%Pantolon%' OR name LIKE '%Gömlek%' OR name LIKE '%Elbise%' OR name LIKE '%Kazak%' OR name LIKE '%Ceket%' OR name LIKE '%Hoodie%' OR name LIKE '%Triko%' OR name LIKE '%Jean%';

-- 3. Product Variants Table
CREATE TABLE product_variants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    size VARCHAR(10) NOT NULL,
    stock_quantity INT DEFAULT 100,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_product_size (product_id, size)
);

-- Seed Shoe Sizes (36-45)
INSERT INTO product_variants (product_id, size, stock_quantity)
SELECT p.id, s.size, 50 
FROM products p 
CROSS JOIN (
    SELECT '36' as size UNION SELECT '37' UNION SELECT '38' UNION SELECT '39' UNION SELECT '40' 
    UNION SELECT '41' UNION SELECT '42' UNION SELECT '43' UNION SELECT '44' UNION SELECT '45'
) s 
WHERE p.type = 'shoe';

-- Seed Cloth Sizes (XS-XL)
INSERT INTO product_variants (product_id, size, stock_quantity)
SELECT p.id, s.size, 50 
FROM products p 
CROSS JOIN (
    SELECT 'XS' as size UNION SELECT 'S' UNION SELECT 'M' UNION SELECT 'L' UNION SELECT 'XL'
) s 
WHERE p.type = 'cloth';

-- Seed Standard Items (STD)
INSERT INTO product_variants (product_id, size, stock_quantity)
SELECT p.id, 'STD', 100 
FROM products p 
WHERE p.type = 'std';

-- 4. Cart Table
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    size VARCHAR(10) NOT NULL,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_item_size (user_id, product_id, size)
);
