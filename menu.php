<?php
session_start();
include("database.php");

// Check restaurant ID
if (!isset($_GET['id'])) {
  echo "Restaurant ID missing!";
  exit;
}

$restaurant_id = $_GET['id'];
$resInfo = mysqli_query($conn, "SELECT * FROM restaurants WHERE id=$restaurant_id");
$restaurant = mysqli_fetch_assoc($resInfo);
$menuItems = mysqli_query($conn, "SELECT * FROM menu WHERE restaurant_id=$restaurant_id");
?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $restaurant['name']; ?> - Menu</title>
  <style>
    body {
      font-family: Arial;
      background-color: #8f25d5b6;
      background-size: cover;
      padding: 20px;
      margin: 0;
    }

    h2 {
      text-align: center;
      color: #fff;
      text-shadow: 1px 1px 3px black;
    }

    .menu-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }

    .dish-card {
      width: 250px;
      background: rgba(0, 0, 0, 1);
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 2px 8px #8234d1ff;
      transition: transform 0.3s, background-color 0.3s;
    }

    .dish-card:hover {
      transform: scale(1.05);
      background-color: #8234d1ff;
    }

    .dish-card img {
      width: 100%;
      height: 140px;
      object-fit: cover;
      border-radius: 8px;
    }

    .dish-card h3 {
      margin: 10px 0 5px;
      color: #efefefff;
    }

    .dish-card p {
      margin: 5px 0;
    }

    .dish-card input[type="number"] {
      width: 60px;
      padding: 5px;
    }

    .dish-card button {
      background-color: #872fcfff;
      color: #fff;
      border: none;
      padding: 7px 10px;
      cursor: pointer;
      border-radius: 5px;
      margin-left: 10px;
      transition: background 0.3s;
    }

    .dish-card button:hover {
      background-color: #000000ff;
    }

    .toast {
      position: fixed;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #8f26d0ff;
      color: white;
      padding: 12px 20px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(115, 22, 197, 0.43);
      font-weight: bold;
      display: none;
      z-index: 9999;
    }

    .cart-bar {
      text-align: right;
      margin-bottom: 15px;
    }

    .cart-bar a {
      color: white;
      font-size: 18px;
      text-decoration: none;
    }
  </style>
</head>
<body>

<!-- Cart Count -->
<div class="cart-bar">
  <a href="cart.php">🛒 Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a>
</div>

<h2> Menu - <?php echo $restaurant['name']; ?></h2>
<p style="text-align:center; color:black;">
  <strong>Category:</strong> <?php echo $restaurant['category']; ?> |
  <strong>Address:</strong> <?php echo $restaurant['address']; ?>
</p>

<div class="menu-container">
  <?php while($dish = mysqli_fetch_assoc($menuItems)) { ?>
    <div class="dish-card">
      <img src="uploads/<?php echo $dish['image']; ?>" alt="<?php echo $dish['dish_name']; ?>">
      <h3><?php echo $dish['dish_name']; ?></h3>
      <p><?php echo $dish['description']; ?></p>
      <p><strong>₹<?php echo $dish['price']; ?></strong></p>

      <form class="add-to-cart-form">
        <input type="hidden" name="dish_id" value="<?php echo $dish['id']; ?>">
        <input type="hidden" name="dish_name" value="<?php echo $dish['dish_name']; ?>">
        <input type="hidden" name="price" value="<?php echo $dish['price']; ?>">
        <label>Qty:</label>
        <input type="number" name="qty" value="1" min="1">
        <button type="submit">Add to Cart</button>
      </form>
    </div>
  <?php } ?>
</div>

<div class="toast" id="toast">✅ Item added to cart!</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
  $('.add-to-cart-form').on('submit', function(e) {
    e.preventDefault();
    const form = $(this);
    const formData = form.serialize();

    $.post('add_to_cart.php', formData, function(response) {
      const res = JSON.parse(response);
      if (res.success) {
        $('#toast').text(res.message).fadeIn();
        $('a[href="cart.php"]').html('🛒 Cart (' + res.cartCount + ')');
        setTimeout(() => $('#toast').fadeOut(), 3000);
      }
    });
  });
});
</script>

</body>
</html>
