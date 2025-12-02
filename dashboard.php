<?php
session_start();
include("database.php");

// Fetch restaurants based on selection
if (isset($_GET['restaurant_id'])) {
  $restaurant_id = (int) $_GET['restaurant_id'];
  $res = mysqli_query($conn, "SELECT * FROM restaurants WHERE id = $restaurant_id");
} else {
  $res = mysqli_query($conn, "SELECT * FROM restaurants");
}

// Random food image list
$foodImages = ['burger.jpg', 'pizza.jpg', 'biryani.jpg', 'dosa.jpg', 'pasta.jpg'];
$randomImage = $foodImages[array_rand($foodImages)];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FoodMenia</title>
  <link rel="stylesheet" href="design.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #000000ff;
    }
    header {
      background: #000;
      color: white;
      padding: 15px 0;
    }
    .container {
      width: 90%;
      margin: auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .logo {
      font-size: 28px;
      font-weight: bold;
      color: #881ccc;
      letter-spacing: 1px;
    }
    nav ul {
      list-style: none;
      display: flex;
      gap: 20px;
      margin: 0;
      padding: 0;
      align-items: center;
    }
    nav ul li a {
      color: white;
      text-decoration: none;
      font-weight: bold;
    }
    nav ul li a:hover {
      text-decoration: underline;
    }
    .food-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid white;
    }
    .hero {
      background: linear-gradient(rgba(168, 20, 201, 0.25), rgba(78, 16, 160, 0.44)),
                  url('uploads/zb3.png') no-repeat center center/cover;
      padding: 100px 0;
      text-align: center;
      color: #fff;
    }
    .hero h1 {
      font-size: 36px;
      margin-bottom: 20px;
    }
    .hero form select {
      padding: 10px;
      width: 500px;
      max-width: 90%;
      border-radius: 5px;
      border: none;
      font-size: 16px;
    }
    .hero form button {
      padding: 10px 20px;
      margin-left: 10px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      background-color: #030004d3;
      color: white;
      cursor: pointer;
    }
    .hero form button:hover {
      background-color: #881cccd3;
    }
    .restaurants-section {
      padding: 40px 20px;
    }
    .restaurants-section h2 {
      text-align: center;
      color: #7b26d1ff;
      margin-bottom: 30px;
    }
    .card-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }
    .card {
      background: #fff;
      width: 260px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }
    .card:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 16px #881ccc;
    }
    .card img {
      width: 100%;
      height: 160px;
      object-fit: cover;
    }
    .card-body {
      padding: 15px;
    }
    .card-body h3 {
      margin: 0;
      color: #7420a1ff;
    }
    .card-body p {
      margin: 5px 0;
    }
    .view-btn {
      display: inline-block;
      margin-top: 10px;
      padding: 8px 12px;
      background-color: #8c3ce7ff;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.2s ease;
    }
    .view-btn:hover {
      background-color: #020202ff;
    }
  </style>
</head>
<body>

<!-- Header -->
<header>
  <div class="container">
    <div class="logo">FoodMenia</div>
    <nav>
      <ul>
        <li><a href="Front.php">Home</a></li>
        <li><a href="RAJ.php">Restaurants</a></li>
        <li><a href="cart.php">Cart</a></li>
        <?php if (!isset($_SESSION['user_id'])): ?>
          <li><a href="Lin.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
        <?php else: ?>
          <li><a href="logout.php">Logout</a></li>
          <li>
            <img src="uploads/<?php echo $randomImage; ?>" class="food-avatar" title="Welcome!" />
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</header>

<!-- Hero Section -->
<section class="hero">
  <div class="container" style="flex-direction: column; display: flex; align-items: center;">
    <h1>Discover the best food & drinks in your city</h1>
    <form action="RAJ.php" method="GET">
      <select name="restaurant_id" required>
        <option value="" disabled selected>Select a restaurant</option>
        <?php
          $all = mysqli_query($conn, "SELECT id, name FROM restaurants");
          while ($row = mysqli_fetch_assoc($all)) {
            $selected = (isset($_GET['restaurant_id']) && $_GET['restaurant_id'] == $row['id']) ? 'selected' : '';
            echo '<option value="' . $row['id'] . '" ' . $selected . '>' . htmlspecialchars($row['name']) . '</option>';
          }
        ?>
      </select>
      <button type="submit">Go</button>
    </form>
  </div>
</section>

<!-- Restaurants Cards Section -->
<section class="restaurants-section">
  <h2><?php echo isset($_GET['restaurant_id']) ? "Selected Restaurant" : "RESTAURANTS"; ?></h2>
  <div class="card-container">
    <?php if (mysqli_num_rows($res) > 0): ?>
      <?php while($row = mysqli_fetch_assoc($res)) { ?>
        <div class="card">
          <img src="uploads/<?php echo urlencode($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
          <div class="card-body">
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($row['category']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?></p>
            <a class="view-btn" href="menu.php?id=<?php echo $row['id']; ?>">View Menu</a>
          </div>
        </div>
      <?php } ?>
    <?php else: ?>
      <p style="color:white; text-align:center;">No restaurant found.</p>
    <?php endif; ?>
  </div>
</section>

</body>
</html>
