<?php
require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Lütfen giriş yapınız.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    $user_id = $_SESSION['user_id'];

    if ($cart_id <= 0 || $quantity < 1) {
        echo json_encode(['status' => 'error', 'message' => 'Geçersiz miktar.']);
        exit;
    }

    // Check ownership
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("iii", $quantity, $cart_id, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Hata oluştu.']);
    }
}
?>