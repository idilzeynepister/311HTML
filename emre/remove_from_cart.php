<?php
require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Lütfen giriş yapınız.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;
    $user_id = $_SESSION['user_id'];

    if ($cart_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Geçersiz ürün.']);
        exit;
    }

    $check = $conn->prepare("SELECT id FROM cart WHERE id = ? AND user_id = ?");
    $check->bind_param("ii", $cart_id, $user_id);
    $check->execute();
    if ($check->get_result()->num_rows == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Ürün bulunamadı veya size ait değil.']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->bind_param("i", $cart_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Ürün sepetten silindi.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Hata: ' . $conn->error]);
    }
}
?>