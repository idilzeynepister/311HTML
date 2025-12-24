<?php
require_once 'db.php';

// Fetch products
try {
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching products: " . $e->getMessage();
    $products = [];
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>n11 - Giyim & Ayakkabı</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <!-- Header -->
    <header>
        <div class="container header-content">
            <a href="#" class="logo">n11</a>
            <div class="search-bar">
                <input type="text" placeholder="Ürün, kategori, marka ara">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="user-actions">
                <div class="user-action-item">
                    <i class="fas fa-user"></i>
                    <span>Giriş Yap</span>
                </div>
                <div class="user-action-item">
                    <i class="fas fa-heart"></i>
                    <span>Favorilerim</span>
                </div>
                <div class="user-action-item">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Sepetim</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav>
        <div class="container nav-menu">
            <div class="nav-item active">Giyim & Ayakkabı</div>
            <div class="nav-item">Elektronik</div>
            <div class="nav-item">Ev & Yaşam</div>
            <div class="nav-item">Anne & Bebek</div>
            <div class="nav-item">Kozmetik & Kişisel Bakım</div>
            <div class="nav-item">Mücevher & Saat</div>
            <div class="nav-item">Spor & Outdoor</div>
            <div class="nav-item">Kitap, Müzik, Film, Oyun</div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container main-content">

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="filter-box">
                <div class="filter-title">Kategoriler</div>
                <ul class="filter-list">
                    <li>Kadın Giyim</li>
                    <li>Erkek Giyim</li>
                    <li>Kadın Ayakkabı</li>
                    <li>Erkek Ayakkabı</li>
                    <li>Çocuk Giyim</li>
                    <li>Çanta & Aksesuar</li>
                </ul>
            </div>

            <div class="filter-box">
                <div class="filter-title">Marka</div>
                <ul class="filter-list">
                    <li><input type="checkbox"> Adidas</li>
                    <li><input type="checkbox"> Nike</li>
                    <li><input type="checkbox"> Puma</li>
                    <li><input type="checkbox"> Jack & Jones</li>
                    <li><input type="checkbox"> Mavi</li>
                    <li><input type="checkbox"> Koton</li>
                </ul>
            </div>

            <div class="filter-box">
                <div class="filter-title">Fiyat Aralığı</div>
                <div style="display: flex; gap: 5px;">
                    <input type="text" placeholder="En az" style="width: 100%; padding: 5px; border: 1px solid #ccc;">
                    <input type="text" placeholder="En çok" style="width: 100%; padding: 5px; border: 1px solid #ccc;">
                </div>
            </div>
        </aside>

        <!-- Product Grid -->
        <main class="product-grid-container">
            <div class="breadcrumbs">
                Anasayfa > Giyim & Ayakkabı
            </div>

            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <?php if ($product['discount_rate']): ?>
                            <div class="discount-badge">%<?php echo $product['discount_rate']; ?></div>
                        <?php endif; ?>

                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>"
                            alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">

                        <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>

                        <div class="rating-container">
                            <div class="stars">
                                <?php
                                $rating = $product['rating'];
                                for ($i = 0; $i < 5; $i++) {
                                    if ($i < floor($rating))
                                        echo '<i class="fas fa-star"></i>';
                                    else if ($i < $rating)
                                        echo '<i class="fas fa-star-half-alt"></i>';
                                    else
                                        echo '<i class="far fa-star"></i>';
                                }
                                ?>
                            </div>
                            <span>(<?php echo $product['review_count']; ?>)</span>
                        </div>

                        <div class="product-price-container">
                            <?php if ($product['old_price']): ?>
                                <span class="old-price"><?php echo number_format($product['old_price'], 2, ',', '.'); ?>
                                    TL</span>
                            <?php endif; ?>
                            <div class="current-price"><?php echo number_format($product['price'], 2, ',', '.'); ?> TL</div>
                        </div>

                        <?php if ($product['coupon']): ?>
                            <div class="coupon-badge"><i class="fas fa-ticket-alt"></i> <?php echo $product['coupon']; ?></div>
                        <?php endif; ?>

                        <div class="shipping-info">
                            <i class="fas fa-truck" style="margin-right: 5px;"></i> Ücretsiz Kargo
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container footer-content">
            <div class="footer-col">
                <h4>Kurumsal</h4>
                <ul>
                    <li>Hakkımızda</li>
                    <li>Kariyer</li>
                    <li>Marka Koruma Merkezi</li>
                    <li>İletişim</li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Yardım</h4>
                <ul>
                    <li>Sipariş Takibi</li>
                    <li>İade ve Değişim</li>
                    <li>Sıkça Sorulan Sorular</li>
                    <li>Canlı Destek</li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Alışveriş</h4>
                <ul>
                    <li>Ödeme Seçenekleri</li>
                    <li>Kargo ve Teslimat</li>
                    <li>Gizlilik Politikası</li>
                    <li>Kullanıcı Sözleşmesi</li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Mobil Uygulamalar</h4>
                <ul>
                    <li>iOS</li>
                    <li>Android</li>
                    <li>Huawei AppGallery</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            &copy; 2024 n11. Tüm hakları saklıdır.
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>