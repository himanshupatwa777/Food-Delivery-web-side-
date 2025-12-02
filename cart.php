<?php
session_start();
include("database.php");

$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$totalAmount = 0;
foreach ($cartItems as $item) {
    $totalAmount += $item['price'] * $item['qty'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <style>
        body {
            font-family: Arial;
            background:#8f26d0ff;
            background-size: cover;
            color: #fff;
            padding: 20px;
            margin: 0;
        }

        h2 {
            text-align: center;
            color: #fff;
            text-shadow: 1px 1px 3px black;
        }

        table {
            width: 80%;
            margin: auto;
            background-color: rgba(0, 0, 0, 0.7);
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #444;
        }

        th {
            background-color: #000000ff;
        }

        tr:hover {
            background-color: black;
        }

        .place-order-btn {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 12px;
            font-size: 16px;
            background-color: #8c00ffff;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }

        .place-order-btn:hover {
            background-color: #000000ff;
        }
    </style>
</head>
<body>

<h2>YOUR CART</h2>

<?php if (!empty($cartItems)) { ?>
<table>
    <tr>
        <th>Dish</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Subtotal</th>
    </tr>
    <?php foreach ($cartItems as $item) { ?>
        <tr>
            <td><?php echo $item['dish_name']; ?></td>
            <td>₹<?php echo $item['price']; ?></td>
            <td><?php echo $item['qty']; ?></td>
            <td>₹<?php echo $item['price'] * $item['qty']; ?></td>
        </tr>
    <?php } ?>

    <!-- ✅ Subtotal Total Row -->
    <tr style="background-color:#2c3e50; color:#fff;">
        <td colspan="3"><strong>Total</strong></td>
        <td><strong>₹<?php echo $totalAmount; ?></strong></td>
    </tr>
</table>

<form action="place_order.php" method="POST">
    <button class="place-order-btn" type="submit"> Place Order</button>
</form>

<?php } else { ?>
    <p style="text-align:center; color:white; font-size: 18px;">Your cart is empty!</p>
<?php } ?>

</body>
</html>
