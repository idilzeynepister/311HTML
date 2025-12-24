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

    // Check if product exists
    $sql = "SELECT id, price FROM products WHERE id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Ürün bulunamadı.']);
        exit;
    }

    // Insert or Update Cart
    // Using ON DUPLICATE KEY UPDATE to handle existing items (increment quantity)
    // Note: If user wants to "set" quantity to a specific number (not add), logic would be different.
    // Assuming "Add to Cart" means "Add this many more".
    $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)
            ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";

    if ($conn->query($sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Ürün sepete eklendi.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Bir hata oluştu: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Geçersiz istek.']);
}
?>