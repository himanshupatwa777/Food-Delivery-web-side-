<?php
include("database.php");

// Check if a specific restaurant is selected via GET
if (isset($_GET['restaurant_id'])) {
    $restaurant_id = (int) $_GET['restaurant_id'];
    $res = mysqli_query($conn, "SELECT * FROM restaurants WHERE id = $restaurant_id");
} else {
    $res = mysqli_query($conn, "SELECT * FROM restaurants");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>RESTAURANTS</title>
  <link rel="stylesheet" href="design.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #000;
      padding: 20px;
      overflow-x: hidden;
    }

    h2 {
      text-align: center;
      color: #881ccc;
      font-size: 36px;
      margin-bottom: 30px;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      animation: fadeIn 1s ease-in;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .card {
      background: #fff;
      width: 260px;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(136, 28, 204, 0.6);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
      position: relative;
    }

    .card:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 16px rgba(136, 28, 204, 0.9);
    }

    .card img {
      width: 100%;
      height: 160px;
      object-fit: cover;
      transition: transform 0.4s ease;
    }

    .card:hover img {
      transform: scale(1.1);
    }

    .card-body {
      padding: 15px;
    }

    .card-body h3 {
      margin: 0;
      color: #881ccc;
      font-size: 22px;
    }

    .card-body p {
      margin: 5px 0;
      font-size: 14px;
      color: #333;
    }

    .view-btn {
      display: inline-block;
      margin-top: 10px;
      padding: 10px 16px;
      background-color: #881ccc;
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
      transition: all 0.3s ease;
    }

    .view-btn:hover {
      background-color: #000000ff;
      transform: scale(1.05);
    }
  </style>
</head>
<body>

<h2><?php echo isset($_GET['restaurant_id']) ? "Selected Restaurant" : "RESTAURANTS"; ?></h2>

<div class="container">
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
    <p style="color: white;">No restaurant found.</p>
  <?php endif; ?>
</div>

</body>
</html>
