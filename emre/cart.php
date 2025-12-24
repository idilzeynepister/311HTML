<?php
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch Cart Items
$sql = "SELECT c.id as cart_id, c.quantity, p.id as product_id, p.name, p.price, p.image_url, p.brand, p.old_price 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total_price = 0;
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total_price += ($row['price'] * $row['quantity']);
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sepetim - n11</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
        }

        .cart-page-container {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            align-items: flex-start;
        }

        .cart-items-wrapper {
            flex: 2;
            background: #fff;
            border: 1px solid #e1e1e1;
            border-radius: 4px;
            padding: 20px;
        }

        .cart-summary-wrapper {
            flex: 1;
            background: #fff;
            border: 1px solid #e1e1e1;
            border-radius: 4px;
            padding: 20px;
            position: sticky;
            top: 20px;
        }

        .cart-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 600;
        }

        .cart-item {
            display: flex;
            gap: 15px;
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-img {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #eee;
        }

        .cart-item-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .cart-item-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            text-decoration: none;
        }

        .cart-item-brand {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .cart-item-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .cart-item-qty {
            font-size: 13px;
            color: #666;
        }

        .cart-item-price {
            font-size: 16px;
            font-weight: 700;
            color: #333;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
            color: #333;
        }

        .summary-total {
            border-top: 1px solid #eee;
            padding-top: 15px;
            margin-top: 10px;
            font-size: 20px;
            font-weight: 700;
            color: #e11830;
        }

        .btn-checkout {
            width: 100%;
            background: #e11830;
            color: #fff;
            padding: 15px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
            cursor: pointer;
        }

        .btn-checkout:hover {
            background: #c9162b;
        }
    </style>
</head>

<body>

    <!-- Header (Simple version for cart) -->
    <header style="background:#fff; border-bottom:1px solid #eee;">
        <div class="container header-container">
            <a href="index.php" class="logo-container">
                <svg class="logo-icon" viewBox="0 0 100 50" width="80" height="40">
                    <circle cx="20" cy="25" r="15" fill="#333" />
                    <circle cx="20" cy="25" r="5" fill="#e11830" />
                    <text x="40" y="35" font-family="Arial, sans-serif" font-size="30" font-weight="bold"
                        fill="#333">n11</text>
                </svg>
            </a>
            <div class="user-menu" style="margin-left: auto;">
                <span>Merhaba, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </div>
        </div>
    </header>

    <div class="container cart-page-container">
        <!-- Cart Items -->
        <div class="cart-items-wrapper">
            <div class="cart-header">Sepetim (<span id="cart-count"><?php echo count($cart_items); ?></span> Ürün)</div>

            <?php if (count($cart_items) > 0): ?>
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item" id="item-<?php echo $item['cart_id']; ?>">
                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="" class="cart-item-img">
                        <div class="cart-item-details">
                            <div>
                                <a href="product_detail.php?id=<?php echo $item['product_id']; ?>"
                                    class="cart-item-title"><?php echo htmlspecialchars($item['name']); ?></a>
                                <div class="cart-item-brand">Marka: <?php echo htmlspecialchars($item['brand']); ?></div>
                            </div>
                            <div class="cart-item-controls">
                                <div class="quantity-selector" style="transform: scale(0.8); transform-origin: left;">
                                    <button class="qty-btn"
                                        onclick="updateCartItem(<?php echo $item['cart_id']; ?>, -1, <?php echo $item['price']; ?>)">-</button>
                                    <input type="text" id="qty-<?php echo $item['cart_id']; ?>"
                                        value="<?php echo $item['quantity']; ?>" class="qty-input" readonly>
                                    <button class="qty-btn"
                                        onclick="updateCartItem(<?php echo $item['cart_id']; ?>, 1, <?php echo $item['price']; ?>)">+</button>
                                </div>
                                <div class="cart-item-price">
                                    <span
                                        id="price-<?php echo $item['cart_id']; ?>"><?php echo number_format($item['price'] * $item['quantity'], 2, ',', '.'); ?></span>
                                    TL
                                </div>
                                <button onclick="removeFromCart(<?php echo $item['cart_id']; ?>)"
                                    style="background:none; border:none; color:#999; cursor:pointer; margin-left:10px;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div id="empty-cart-msg" style="text-align:center; padding: 40px;">
                    <i class="fas fa-shopping-cart" style="font-size: 40px; color:#ddd; margin-bottom:10px;"></i>
                    <p>Sepetinizde ürün bulunmamaktadır.</p>
                    <a href="index.php" style="color:#e11830; text-decoration:underline;">Alışverişe Başla</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Order Summary -->
        <div class="cart-summary-wrapper">
            <div class="cart-header">Sipariş Özeti</div>

            <div class="summary-row">
                <span>Ürün Toplamı</span>
                <span id="summary-product-total"><?php echo number_format($total_price, 2, ',', '.'); ?> TL</span>
            </div>
            <div class="summary-row">
                <span>Kargo Toplam</span>
                <span>0,00 TL</span>
            </div>

            <div class="summary-row summary-total">
                <span>Toplam</span>
                <span id="summary-grand-total"><?php echo number_format($total_price, 2, ',', '.'); ?> TL</span>
            </div>

            <button class="btn-checkout">Sepeti Onayla <i class="fas fa-chevron-right"></i></button>
        </div>
    </div>

    <!-- Interactive Cart Scripts -->
    <script>
        function updateCartItem(cartId, change, unitPrice) {
            const qtyInput = document.getElementById('qty-' + cartId);
            let currentQty = parseInt(qtyInput.value);
            let newQty = currentQty + change;

            if (newQty < 1) return; // Prevent going below 1

            // Optimistic UI Update
            qtyInput.value = newQty;
            updatePriceDisplay(cartId, newQty, unitPrice);
            recalculateTotal();

            // AJAX Update
            const formData = new FormData();
            formData.append('cart_id', cartId);
            formData.append('quantity', newQty);

            fetch('update_cart.php', {
                method: 'POST',
                body: formData
            })
                .then(r => r.json())
                .then(data => {
                    if (data.status !== 'success') {
                        // Revert on failure
                        qtyInput.value = currentQty;
                        updatePriceDisplay(cartId, currentQty, unitPrice);
                        recalculateTotal();
                        alert('Güncelleme başarısız');
                    }
                });
        }

        function removeFromCart(cartId) {
            if (!confirm('Ürünü sepetten silmek istediğinize emin misiniz?')) return;

            const formData = new FormData();
            formData.append('cart_id', cartId);

            fetch('remove_from_cart.php', {
                method: 'POST',
                body: formData
            })
                .then(r => r.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('item-' + cartId).remove();
                        // Check if cart is empty
                        const remainingItems = document.querySelectorAll('.cart-item');
                        document.getElementById('cart-count').innerText = remainingItems.length;

                        if (remainingItems.length === 0) {
                            location.reload();
                        } else {
                            recalculateTotal();
                        }
                    } else {
                        alert(data.message);
                    }
                });
        }

        function updatePriceDisplay(cartId, qty, unitPrice) {
            const priceEl = document.getElementById('price-' + cartId);
            const total = qty * unitPrice;
            priceEl.textContent = new Intl.NumberFormat('tr-TR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(total);
        }

        function recalculateTotal() {
            let total = 0;
            document.querySelectorAll('.cart-item-price span').forEach(span => {
                // Parse "1.200,50" -> 1200.50
                let valStr = span.textContent.replace(/\./g, '').replace(',', '.');
                total += parseFloat(valStr);
            });

            const fmt = new Intl.NumberFormat('tr-TR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(total) + " TL";
            document.getElementById('summary-product-total').textContent = fmt;
            document.getElementById('summary-grand-total').textContent = fmt;
        }
    </script>

</body>

</html>