<?php
require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Lütfen giriş yapınız.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $user_id = $_SESSION['user_id'];

    if ($product_id <= 0 || $quantity <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Geçersiz ürün veya miktar.']);
        exit;
    }

    $size = isset($_POST['size']) ? trim($_POST['size']) : null;
    if (empty($size)) {
        echo json_encode(['status' => 'error', 'message' => 'Lütfen beden seçiniz.']);
        exit;
    }

    // Check stock
    $stmt = $conn->prepare("SELECT stock_quantity FROM product_variants WHERE product_id = ? AND size = ?");
    $stmt->bind_param("is", $product_id, $size);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Bu bedene ait stok bulunamadı.']);
        exit;
    }

    $variant = $result->fetch_assoc();
    if ($variant['stock_quantity'] < $quantity) {
        echo json_encode(['status' => 'error', 'message' => 'Yetersiz stok. Kalan: ' . $variant['stock_quantity']]);
        exit;
    }

    $sql = "INSERT INTO cart (user_id, product_id, size, quantity) VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisi", $user_id, $product_id, $size, $quantity);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Ürün sepete eklendi.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Bir hata oluştu: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Geçersiz istek.']);
}
?>