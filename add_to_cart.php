<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dish_id = $_POST['dish_id'];
    $dish_name = $_POST['dish_name'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];

    $cart_item = [
        'dish_id' => $dish_id,
        'dish_name' => $dish_name,
        'price' => $price,
        'qty' => $qty
    ];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][] = $cart_item;

    echo json_encode([
        'success' => true,
        'message' => 'Item added to cart!',
        'cartCount' => count($_SESSION['cart'])
    ]);
}
?>
