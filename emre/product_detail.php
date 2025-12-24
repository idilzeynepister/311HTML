<?php
require_once 'db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;

if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
}

if (!$product) {
    die("Product not found.");
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - n11</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

    <header>
        <div class="container header-container">
            <a href="index.php" class="logo-container">
                <svg class="logo-icon" viewBox="0 0 100 50" width="80" height="40">
                    <circle cx="20" cy="25" r="15" fill="#333" />
                    <circle cx="20" cy="25" r="5" fill="#e11830" />
                    <text x="40" y="35" font-family="Arial, sans-serif" font-size="30" font-weight="bold"
                        fill="#333">n11</text>
                </svg>
            </a>

            <div class="search-area">
                <form action="products.php" method="GET" class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="q" placeholder="Ürün, kategori, marka ara">
                </form>
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

    <nav class="main-nav">
        <div class="container">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="products.php"
                        style="display:flex; align-items:center; gap:5px; text-decoration:none; color:inherit; height:100%;">
                        <img src="https://n11scdn.akamaized.net/a1/org/23/04/18/76/01/26/51/76012651.svg" width="24"
                            alt="">
                        <span>Moda</span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-header">Moda</div>
                        <div class="dropdown-grid">
                            <a href="products.php" class="dropdown-item">
                                <img src="https://n11scdn.akamaized.net/a1/org/23/04/18/76/01/26/51/76012651.svg"
                                    class="dropdown-thumb" alt="">
                                <span class="dropdown-title">Ayakkabı & Çanta</span>
                            </a>
                            <a href="#" class="dropdown-item">
                                <img src="https://placehold.co/80x80/eee/333?text=Kadin" class="dropdown-thumb" alt="">
                                <span class="dropdown-title">Kadın Giyim & Aksesuar</span>
                            </a>
                            <a href="#" class="dropdown-item">
                                <img src="https://placehold.co/80x80/eee/333?text=Erkek" class="dropdown-thumb" alt="">
                                <span class="dropdown-title">Erkek Giyim & Aksesuar</span>
                            </a>
                            <a href="#" class="dropdown-item">
                                <img src="https://placehold.co/80x80/eee/333?text=Cocuk" class="dropdown-thumb" alt="">
                                <span class="dropdown-title">Çocuk Giyim & Aksesuar</span>
                            </a>
                        </div>
                    </div>
                </li>
                <li class="nav-item"><i class="fas fa-desktop"></i> <span>Elektronik</span></li>
                <li class="nav-item"><i class="fas fa-home"></i> <span>Ev & Yaşam</span></li>
                <li class="nav-item"><i class="fas fa-baby"></i> <span>Anne & Bebek</span></li>
                <li class="nav-item"><i class="fas fa-pump-soap"></i> <span>Kozmetik & Kişisel Bakım</span></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="listing-breadcrumb">
            <a href="index.php">Ana Sayfa</a> > <a href="index.php">Moda</a> > <a href="products.php">Ayakkabı &
                Çanta</a> > <span><?php echo htmlspecialchars($product['name']); ?></span>
        </div>

        <div class="product-detail-container">

            <div class="detail-left">
                <div class="detail-image-wrapper">
                    <?php if ($product['coupon']): ?>
                        <div class="coupon-circle"
                            style="left: 20px; top: 20px; width: 60px; height: 60px; font-size: 10px;">
                            <div>KUPONLU</div>
                            <div>ÜRÜN</div>
                        </div>
                    <?php endif; ?>
                    <img id="mainImage" src="<?php echo htmlspecialchars($product['image_url']); ?>"
                        alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                <div class="detail-thumbnails">
                    <div class="thumb active"
                        onclick="changeImage(this, '<?php echo htmlspecialchars($product['image_url']); ?>')">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Front">
                    </div>
                    <div class="thumb"
                        onclick="changeImage(this, 'https://placehold.co/500x500/eee/333?text=Side+View')">
                        <img src="https://placehold.co/500x500/eee/333?text=Side+View" alt="Side">
                    </div>
                    <div class="thumb"
                        onclick="changeImage(this, 'https://placehold.co/500x500/eee/333?text=Back+View')">
                        <img src="https://placehold.co/500x500/eee/333?text=Back+View" alt="Back">
                    </div>
                    <div class="thumb"
                        onclick="changeImage(this, 'https://placehold.co/500x500/eee/333?text=Detail+Zoom')">
                        <img src="https://placehold.co/500x500/eee/333?text=Detail+Zoom" alt="Detail">
                    </div>
                </div>
            </div>

            <div class="detail-right">
                <h1 class="detail-title"><?php echo htmlspecialchars($product['name']); ?></h1>

                <div class="detail-rating-row">
                    <div class="stars">
                        <?php
                        for ($i = 0; $i < 5; $i++)
                            echo ($i < floor($product['rating'])) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                        ?>
                    </div>
                    <span class="review-count"><?php echo $product['review_count']; ?> Yorum</span>
                    <span class="sku-code">Ürün Kodu: <?php echo $product['id'] . 'ABC' . rand(100, 999); ?></span>
                </div>

                <div class="detail-price-box">
                    <?php if ($product['old_price']): ?>
                        <div class="detail-old-price">
                            <span class="strike"><?php echo number_format($product['old_price'], 2, ',', '.'); ?> TL</span>
                            <?php if ($product['discount_rate']): ?>
                                <span class="discount-rate">%<?php echo $product['discount_rate']; ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="detail-current-price">
                        <?php echo number_format($product['price'], 2, ',', '.'); ?> <span>TL</span>
                    </div>

                    <?php if ($product['old_price']): ?>
                        <div class="detail-sepette-label">SEPETTE
                            <?php echo number_format($product['price'], 2, ',', '.'); ?> TL
                        </div>
                    <?php endif; ?>

                    <div class="detail-cargo-badge">
                        <i class="fas fa-truck"></i>
                        <span>ÜCRETSİZ KARGO</span>
                    </div>
                </div>

                <div class="detail-actions">
                    <div class="quantity-selector">
                        <button class="qty-btn" onclick="updateQty(-1)">-</button>
                        <input type="text" id="productQty" value="1" class="qty-input" readonly>
                        <button class="qty-btn" onclick="updateQty(1)">+</button>
                    </div>
                    <button class="add-to-cart-btn" onclick="prepareAddToCart()">
                        <i class="fas fa-shopping-cart"></i> Sepete Ekle
                    </button>
                </div>

                <button class="buy-now-btn">Hemen Al</button>

                <div class="detail-features">
                    <div><strong>Marka:</strong> <?php echo htmlspecialchars($product['brand']); ?></div>
                    <div><strong>Cinsiyet:</strong> Kadın</div>
                    <div><strong>Renk:</strong> Bej</div>
                </div>

            </div>

        </div>

    </div>

    <footer>
        <div class="container" style="padding-bottom: 20px; color:#666; font-size:12px;">
            <p>&copy; 2024 n11.com</p>
        </div>
    </footer>

    <script>
        function changeImage(thumb, src) {
            document.getElementById('mainImage').src = src;
            document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
            thumb.classList.add('active');
        }

        function updateQty(change) {
            const qtyInput = document.getElementById('productQty');
            let currentQty = parseInt(qtyInput.value);
            let newQty = currentQty + change;

            if (newQty < 1) newQty = 1;

            qtyInput.value = newQty;
        }

        function prepareAddToCart() {
            const qty = document.getElementById('productQty').value;
            const productId = <?php echo $product['id']; ?>;

            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', qty);

            fetch('add_to_cart.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showToast(data.message);
                    } else {
                        if (data.message.includes('giriş')) {
                            if (confirm(data.message + "\nGiriş sayfasına yönlendirilsin mi?")) {
                                window.location.href = 'login.php';
                            }
                        } else {
                            alert("Hata: " + data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Bir hata oluştu.');
                });
        }

        function showToast(message) {
            let toast = document.getElementById('toast-notification');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'toast-notification';
                toast.className = 'toast-notification';
                toast.innerHTML = '<i class="fas fa-check-circle"></i> <span>' + message + '</span>';
                document.body.appendChild(toast);
            } else {
                toast.querySelector('span').innerText = message;
            }

            setTimeout(() => toast.classList.add('show'), 10);

            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }
    </script>

</body>

</html>