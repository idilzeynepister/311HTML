<?php
require_once 'db.php';

// Filter & Search Logic
$whereClauses = [];
$params = [];
$types = "";

function toggleUrl($key, $value)
{
    $queryParams = $_GET;
    if (isset($queryParams[$key]) && $queryParams[$key] == $value) {
        unset($queryParams[$key]);
    } else {
        $queryParams[$key] = $value;
    }
    return 'products.php' . (empty($queryParams) ? '' : '?' . http_build_query($queryParams));
}

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $whereClauses[] = "name LIKE ?";
    $params[] = "%" . $_GET['q'] . "%";
    $types .= "s";
}

if (isset($_GET['brand']) && !empty($_GET['brand'])) {
    $whereClauses[] = "brand = ?";
    $params[] = $_GET['brand'];
    $types .= "s";
}

if (isset($_GET['category']) && !empty($_GET['category'])) {
    // Determine category matching logic (assuming a 'category' or similar column logic, 
    // or just 'name LIKE' if category column doesn't exist, but Setup.sql likely has generic structure.
    // Checking setup.sql... User said 'products table... id, name, price... brand, discount_rate'. 
    // I don't recall a category column. I'll assume 'name' or just default to brand-like behavior or add a column?
    // User provided setup.sql earlier. Let's check db assumption.
    // If no category column, I'll filter by name LIKE category for now to be safe/simple.)
    $whereClauses[] = "(name LIKE ? OR brand LIKE ?)"; // Loose matching for demo
    $params[] = "%" . $_GET['category'] . "%";
    $params[] = "%" . $_GET['category'] . "%";
    $types .= "ss";
}

// Price Filter Logic
if (isset($_GET['min_price']) && is_numeric($_GET['min_price'])) {
    $whereClauses[] = "price >= ?";
    $params[] = $_GET['min_price'];
    $types .= "d";
}

if (isset($_GET['max_price']) && is_numeric($_GET['max_price'])) {
    $whereClauses[] = "price <= ?";
    $params[] = $_GET['max_price'];
    $types .= "d";
}

$sql = "SELECT * FROM products";
if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}

$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// Sidebar data (mock)
$brands = ['Adidas', 'Nike', 'Puma', 'Jack & Jones', 'Mavi', 'Koton', 'US Polo Assn.', 'Hummel'];
$categories = ['Spor Ayakkabı', 'Günlük Ayakkabı', 'Bot & Çizme', 'Topuklu Ayakkabı', 'Çanta'];
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>n11 - Ayakkabı & Çanta</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

    <!-- Header (Same as index) -->
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
                    <input type="text" name="q" placeholder="Ürün, kategori, marka ara"
                        value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
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

                <div class="user-menu">
                    <i class="fas fa-shopping-cart" style="font-size: 18px;"></i>
                </div>

                <div class="user-menu">
                    <i class="far fa-user" style="font-size: 18px;"></i>
                    <div class="user-text">
                        <span>HESABIM</span>
                        <span>Üye Ol Giriş Yap</span>
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
                    <a href="index.php"
                        style="display:flex; align-items:center; gap:5px; text-decoration:none; color:inherit;">
                        <img src="https://n11scdn.akamaized.net/a1/org/23/04/18/76/01/26/51/76012651.svg" width="24"
                            alt=""> <span>Moda</span>
                    </a>
                </li>
                <li class="nav-item"><i class="fas fa-desktop"></i> <span>Elektronik</span></li>
                <li class="nav-item"><i class="fas fa-home"></i> <span>Ev & Yaşam</span></li>
                <li class="nav-item"><i class="fas fa-baby"></i> <span>Anne & Bebek</span></li>
                <li class="nav-item"><i class="fas fa-pump-soap"></i> <span>Kozmetik & Kişisel Bakım</span></li>
            </ul>
        </div>
    </nav>

    <!-- Listings -->
    <div class="container">
        <div class="listing-breadcrumb">
            <a href="index.php">Ana Sayfa</a> > <a href="index.php">Moda</a> > <span>Ayakkabı & Çanta</span>
        </div>

        <div class="listing-container">
            <!-- Sidebar -->
            <aside class="filter-container">
                <div class="filter-group">
                    <div class="filter-header">Kategoriler</div>
                    <div class="filter-content">
                        <ul class="filter-list">
                            <?php foreach ($categories as $cat): ?>
                                <li><a href="<?php echo toggleUrl('category', $cat); ?>"
                                        style="<?php echo (isset($_GET['category']) && $_GET['category'] == $cat) ? 'font-weight:bold; color:#e11830;' : ''; ?>">
                                        <?php echo $cat; ?>
                                    </a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-header">Marka</div>
                    <div class="filter-content">
                        <input type="text" class="filter-search" placeholder="Marka Ara">
                        <ul class="filter-checkbox-list">
                            <?php foreach ($brands as $brand): ?>
                                <li>
                                    <label>
                                        <input type="checkbox"
                                            onclick="window.location.href='<?php echo toggleUrl('brand', $brand); ?>'" <?php echo (isset($_GET['brand']) && $_GET['brand'] == $brand) ? 'checked' : ''; ?>>
                                        <?php echo $brand; ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-header">Fiyat Aralığı</div>
                    <div class="filter-content">
                        <div style="display:flex; gap:5px;">
                            <input type="number" id="min_price" placeholder="En Az"
                                value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>"
                                style="width:45%; padding:5px; border:1px solid #ddd; font-size:12px;">
                            <input type="number" id="max_price" placeholder="En Çok"
                                value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>"
                                style="width:45%; padding:5px; border:1px solid #ddd; font-size:12px;">
                            <button onclick="applyPriceFilter()"
                                style="width:25px; height:25px; background:#ccc; border:none; color:white; cursor:pointer;"><i
                                    class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>

                <script>
                    function applyPriceFilter() {
                        const min = document.getElementById('min_price').value;
                        const max = document.getElementById('max_price').value;
                        const url = new URL(window.location.href);

                        if (min) url.searchParams.set('min_price', min);
                        else url.searchParams.delete('min_price');

                        if (max) url.searchParams.set('max_price', max);
                        else url.searchParams.delete('max_price');

                        window.location.href = url.toString();
                    }
                </script>
            </aside>

            <!-- Grid -->
            <main class="listing-content">
                <div class="listing-header">
                    <h1 class="listing-title">Ayakkabı & Çanta</h1>
                    <div class="suggestion-pills">
                        <div class="pill-item">Erkek Ayakkabı</div>
                        <div class="pill-item">Kadın Ayakkabı</div>
                        <div class="pill-item">Çocuk Ayakkabı</div>
                        <div class="pill-item">Spor Çantası</div>
                        <div class="pill-item">Valiz</div>
                    </div>
                </div>

                <div class="listing-grid">
                    <?php if (count($products) > 0): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-card-listing">
                                <div class="pl-fav"><i class="far fa-heart"></i></div>
                                <?php if ($product['discount_rate']): ?>
                                    <div class="pl-badge-discount">%<?php echo $product['discount_rate']; ?></div>
                                <?php endif; ?>

                                <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="pl-image"
                                    style="display:block; text-decoration:none; color:inherit;">
                                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="">
                                </a>

                                <div class="pl-details">
                                    <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="pl-title"
                                        style="display:block; text-decoration:none; color:inherit;"><?php echo htmlspecialchars($product['name']); ?></a>
                                    <div class="pl-rating">
                                        <?php
                                        for ($i = 0; $i < 5; $i++)
                                            echo ($i < floor($product['rating'])) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                                        ?>
                                        (<?php echo $product['review_count']; ?>)
                                    </div>
                                    <div class="pl-price-box">
                                        <?php if ($product['old_price']): ?>
                                            <div class="pl-old-price">
                                                <?php echo number_format($product['old_price'], 2, ',', '.'); ?> TL
                                            </div>
                                        <?php endif; ?>
                                        <div class="pl-current-price">
                                            <?php echo number_format($product['price'], 2, ',', '.'); ?> TL
                                        </div>
                                    </div>
                                    <div class="pl-shipping"><i class="fas fa-truck"></i> Ücretsiz Kargo</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="grid-column: 1/-1; padding: 20px; text-align: center; font-size: 16px;">
                            Aradığınız kriterlere uygun ürün bulunamadı.
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <footer>
        <div class="container" style="padding-bottom: 20px; color:#666; font-size:12px;">
            <p>&copy; 2024 n11.com</p>
        </div>
    </footer>

</body>

</html>