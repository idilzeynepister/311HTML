<?php
require_once 'db.php';

// Fetch products for shelf
// Limit to 5 for the row as per screenshot
$sql = "SELECT * FROM products LIMIT 5";
$result = $conn->query($sql);
$products = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>n11 - Moda</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

    <!-- Header -->
    <header>
        <div class="container header-container">
            <a href="#" class="logo-container">
                <svg class="logo-icon" viewBox="0 0 100 50" width="80" height="40">
                    <circle cx="20" cy="25" r="15" fill="#333" />
                    <circle cx="20" cy="25" r="5" fill="#e11830" />
                    <text x="40" y="35" font-family="Arial, sans-serif" font-size="30" font-weight="bold"
                        fill="#333">n11</text>
                </svg>
            </a>

            <div class="search-area">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" placeholder="Ürün, kategori, marka ara">
                </div>
            </div>

            <div class="header-right">
                <div class="location-area">
                    <i class="fas fa-map-marker-alt" style="font-size: 16px;"></i>
                    <div class="location-text">
                        <span>TESLİMAT ADRESİ</span>
                        <a href="#">Adres Ekle</a>
                    </div>
                </div>

                <a href="cart.php" class="user-menu" style="text-decoration:none; color:inherit;">
                    <i class="fas fa-shopping-cart" style="font-size: 18px;"></i>
                </a>

                <div class="user-menu">
                    <i class="far fa-user" style="font-size: 18px;"></i>
                    <div class="user-text">
                        <?php if (isset($_SESSION['username'])): ?>
                            <span>Merhaba, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            <span><a href="logout.php" style="color:#666; text-decoration:none;">Çıkış Yap</a></span>
                        <?php else: ?>
                            <span>HESABIM</span>
                            <span><a href="login.php" style="color:#666; text-decoration:none;">Giriş Yap</a> / <a href="#"
                                    style="color:#666; text-decoration:none;">Üye Ol</a></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="main-nav">
        <div class="container">
            <ul class="nav-list">
                <li class="nav-item">
                    <img src="https://n11scdn.akamaized.net/a1/org/23/04/18/76/01/26/51/76012651.svg" width="24" alt="">
                    <span>Moda</span>
                </li>
                <li class="nav-item">
                    <i class="fas fa-desktop"></i> <span>Elektronik</span>
                </li>
                <li class="nav-item">
                    <i class="fas fa-home"></i> <span>Ev & Yaşam</span>
                </li>
                <li class="nav-item">
                    <i class="fas fa-baby"></i> <span>Anne & Bebek</span>
                </li>
                <li class="nav-item">
                    <i class="fas fa-pump-soap"></i> <span>Kozmetik & Kişisel Bakım</span>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">

        <!-- Breadcrumbs -->
        <div style="font-size: 12px; color: #666; margin-bottom: 10px;">
            Ana Sayfa > Moda
        </div>

        <!-- Banner Carousel -->
        <section class="hero-slider">
            <!-- Slide 1 -->
            <div class="banner-slide active"
                style="background-color: #dedede; background-image: url('https://placehold.co/1200x400/e0e0e0/999?text=Defacto+Banner');">
                <div class="banner-content">
                    <div class="promo-badge">31<br>ARALIK<br>SON</div>

                    <div class="promo-text-box">
                        <h3>Seçili Ürünlerde</h3>
                        <h1>%70'e Varan Sepette İndirim</h1>
                        <a href="products.php?brand=DeFacto" class="btn-pink">İndirimi Yakala <i
                                class="fas fa-arrow-right"></i></a>
                    </div>

                    <div
                        style="position: absolute; top: 10%; left: 50%; transform: translateX(-50%); font-size: 40px; font-weight: 300;">
                        DeFacto
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="banner-slide"
                style="background-color: #cceeff; background-image: url('https://placehold.co/1200x400/cceeff/005588?text=Mavi+Banner');">
                <div class="banner-content">
                    <div class="promo-badge">25<br>ARALIK<br>SON</div>
                    <div class="promo-text-box">
                        <h3>Yeni Sezon</h3>
                        <h1>Mavi'de Büyük Kış İndirimi</h1>
                        <a href="products.php" class="btn-pink">Fırsatı Kaçırma <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="banner-slide"
                style="background-color: #ffeeff; background-image: url('https://placehold.co/1200x400/ffeeff/880055?text=Koton+Banner');">
                <div class="banner-content">
                    <div class="promo-badge">YENİ<br>YIL</div>
                    <div class="promo-text-box">
                        <h3>Koton</h3>
                        <h1>Parti Koleksiyonu Yayında</h1>
                        <a href="products.php?brand=Koton" class="btn-pink">Keşfet <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Slide 4 -->
            <div class="banner-slide"
                style="background-color: #eef2ff; background-image: url('https://placehold.co/1200x400/eef2ff/333399?text=JackJones+Banner');">
                <div class="banner-content">
                    <div class="promo-badge">%50<br>İNDİRİM</div>
                    <div class="promo-text-box">
                        <h3>Jack & Jones</h3>
                        <h1>Erkek Modasında Dev İndirim</h1>
                        <a href="products.php?brand=JackJones" class="btn-pink">Alışverişe Başla <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Slide 5 -->
            <div class="banner-slide"
                style="background-color: #fff9e6; background-image: url('https://placehold.co/1200x400/fff9e6/cc9900?text=Altin+Banner');">
                <div class="banner-content">
                    <div class="promo-badge">ALTIN<br>FIRSAT</div>
                    <div class="promo-text-box">
                        <h3>Mücevher & Saat</h3>
                        <h1>Yılbaşına Özel Fırsatlar</h1>
                        <a href="products.php?category=Mucevher" class="btn-pink">İncele <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <button class="slider-btn prev"><i class="fas fa-chevron-left"></i></button>
            <button class="slider-btn next"><i class="fas fa-chevron-right"></i></button>

            <div class="slider-dots" style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);">
                <span class="dot active"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
        </section>

        <!-- Quick Links -->
        <section class="quick-links-row">
            <div class="link-item">
                <div class="icon-placeholder"><i class="fas fa-ticket-alt"></i></div>
                <span>Kuponlu Ürünler</span>
            </div>
            <div class="link-item">
                <div class="pink-label">500 TL<br>ALTI</div>
                <span>500 TL Altı<br>Ürünler</span>
            </div>
            <div class="link-item">
                <div class="pink-label">500 TL ALTI<br>ÜRÜNLER.</div>
                <span>500 TL Altı<br>Ürünler</span>
            </div>
            <div class="link-item">
                <div class="pink-label">1500 TL<br>ALTI</div>
                <span>1500 TL Altı<br>Ürünler</span>
            </div>
            <div class="link-item">
                <div class="icon-placeholder"><i class="fas fa-gift"></i></div>
                <span>Hediye Rehberi</span>
            </div>
        </section>

        <!-- Product Shelf Row -->
        <section class="product-shelf-row">
            <?php foreach ($products as $product): ?>
                <div class="product-item">
                    <button class="fav-icon"><i class="far fa-heart"></i></button>

                    <?php if ($product['coupon']): ?>
                        <div class="coupon-circle">
                            <div>KUPONLU</div>
                            <div>ÜRÜN</div>
                        </div>
                    <?php endif; ?>

                    <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="p-image"
                        style="display:block; text-decoration:none; color:inherit;">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="">
                        <div class="free-cargo-bar">ÜCRETSİZ KARGO</div>
                    </a>

                    <div class="p-details">
                        <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="p-title"
                            style="display:block; text-decoration:none; color:inherit;"><?php echo htmlspecialchars($product['name']); ?></a>
                        <div class="p-stars">
                            <?php
                            for ($i = 0; $i < 5; $i++)
                                echo ($i < floor($product['rating'])) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                            ?>
                            (<?php echo $product['review_count']; ?>)
                        </div>

                        <div class="p-price-box">
                            <?php if ($product['old_price']): ?>
                                <div class="price-old"><?php echo number_format($product['old_price'], 2, ',', '.'); ?> TL</div>
                            <?php endif; ?>

                            <div class="price-label">SEPETTE</div>
                            <div class="price-current"><?php echo number_format($product['price'], 2, ',', '.'); ?> TL</div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

        <!-- Brand Grid -->
        <section class="brand-grid">
            <a href="products.php?brand=DeFacto" class="brand-box" style="text-decoration:none;">
                <div class="brand-visual"
                    style="background-image: url('https://placehold.co/400x150/f0f0f0/333?text=DeFacto');"></div>
                <div class="brand-info">
                    <span>%70'e Varan Sepette İndirim</span>
                    <span style="font-weight: 400; color:#ccc;">22-25 Aralık</span>
                </div>
            </a>
            <a href="products.php?brand=CABANI" class="brand-box" style="text-decoration:none;">
                <div class="brand-visual"
                    style="background-image: url('https://placehold.co/400x150/f0f0f0/333?text=CABANI');"></div>
                <div class="brand-info">
                    <span>%30'a Varan Sepette İndirim</span>
                    <span style="font-weight: 400; color:#ccc;">22-25 Aralık</span>
                </div>
            </a>
            <a href="products.php?brand=USPOLO" class="brand-box" style="text-decoration:none;">
                <div class="brand-visual"
                    style="background-image: url('https://placehold.co/400x150/f0f0f0/333?text=US+POLO');"></div>
                <div class="brand-info">
                    <span>%60'a Varan İndirim</span>
                    <span style="font-weight: 400; color:#ccc;">22-25 Aralık</span>
                </div>
            </a>
            <!-- Row 2 -->
            <a href="products.php?brand=SALOMON" class="brand-box" style="text-decoration:none;">
                <div class="brand-visual"
                    style="background-image: url('https://placehold.co/400x150/f0f0f0/333?text=SALOMON');"></div>
                <div class="brand-info">
                    <span>Sepette %25'e Varan İndirimler</span>
                    <span style="font-weight: 400; color:#ccc;">22-25 Aralık</span>
                </div>
            </a>
            <a href="products.php?brand=MANUKA" class="brand-box" style="text-decoration:none;">
                <div class="brand-visual"
                    style="background-image: url('https://placehold.co/400x150/f0f0f0/333?text=MANUKA');"></div>
                <div class="brand-info">
                    <span>İndirimlere Ek 100 TL Kupon Fırsatı</span>
                    <span style="font-weight: 400; color:#ccc;">22-25 Aralık</span>
                </div>
            </a>
            <a href="products.php?brand=SaatSaat" class="brand-box" style="text-decoration:none;">
                <div class="brand-visual"
                    style="background-image: url('https://placehold.co/400x150/f0f0f0/333?text=saat%26saat');"></div>
                <div class="brand-info">
                    <span>Kaçmaz Modeller</span>
                    <span style="font-weight: 400; color:#ccc;">22-25 Aralık</span>
                </div>
            </a>

            <!-- Row 3 -->
            <a href="products.php?brand=DILVIN" class="brand-box" style="text-decoration:none;">
                <div class="brand-visual"
                    style="background-image: url('https://placehold.co/400x150/f0f0f0/333?text=DILVIN');"></div>
                <div class="brand-info">
                    <span>%25 Sepette İndirim</span>
                    <span style="font-weight: 400; color:#ccc;">22-25 Aralık</span>
                </div>
            </a>
            <a href="products.php?brand=MAI" class="brand-box" style="text-decoration:none;">
                <div class="brand-visual"
                    style="background-image: url('https://placehold.co/400x150/f0f0f0/333?text=MAI+STUDIOS');"></div>
                <div class="brand-info">
                    <span>%50 Sepette İndirim</span>
                    <span style="font-weight: 400; color:#ccc;">22-25 Aralık</span>
                </div>
            </a>
            <a href="products.php?brand=Mavi" class="brand-box" style="text-decoration:none;">
                <div class="brand-visual"
                    style="background-image: url('https://placehold.co/400x150/f0f0f0/333?text=mavi');"></div>
                <div class="brand-info">
                    <span>%40'a Varan İndirim</span>
                    <span style="font-weight: 400; color:#ccc;">22-25 Aralık</span>
                </div>
            </a>
        </section>

    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 n11.com</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>