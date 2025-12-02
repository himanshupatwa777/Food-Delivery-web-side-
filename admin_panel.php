<?php

include("database.php");

// Admin Login (Hardcoded user for demo)
$admin_username = "admin";
$admin_password = "1234";

// Login Process
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin'] = true;
        header("Location: admin_panel.php");
        exit;
    } else {
        $error = "Invalid credentials!";
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin_panel.php");
    exit;
}

// Add Restaurant
if (isset($_POST['add_restaurant'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $address = $_POST['address'];
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "uploads/$image");

    mysqli_query($conn, "INSERT INTO restaurants (name, category, address, image) VALUES ('$name', '$category', '$address', '$image')");
}

// Add Menu Item
if (isset($_POST['add_menu'])) {
    $restaurant_id = $_POST['restaurant_id'];
    $dish_name = $_POST['dish_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "uploads/$image");

    mysqli_query($conn, "INSERT INTO menu (restaurant_id, dish_name, description, price, image) VALUES ('$restaurant_id', '$dish_name', '$description', '$price', '$image')");
}

// Delete Restaurant
if (isset($_GET['delete_restaurant'])) {
    $id = $_GET['delete_restaurant'];
    mysqli_query($conn, "DELETE FROM restaurants WHERE id=$id");
}

// Delete Menu Item
if (isset($_GET['delete_menu'])) {
    $id = $_GET['delete_menu'];
    mysqli_query($conn, "DELETE FROM menu WHERE id=$id");
}

// Fetch for dashboard and manage
$restaurants = mysqli_query($conn, "SELECT * FROM restaurants");
$menus = mysqli_query($conn, "SELECT * FROM menu");
$restaurant_count = mysqli_num_rows($restaurants);
$menu_count = mysqli_num_rows($menus);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; margin: 0; padding: 20px; }
        h2 { color: #e74c3c; }
        .container { max-width: 1000px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
        input, select, textarea { width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #ccc; }
        .btn { background: #e74c3c; color: #fff; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; }
        .btn:hover { background: #c0392b; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #e74c3c; color: white; }
        .logout { float: right; }
    </style>
</head>
<body>
<div class="container">
    <?php if (!isset($_SESSION['admin'])) { ?>
        <h2>🔐 Admin Login</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button class="btn" name="login">Login</button>
        </form>
    <?php } else { ?>
        <h2>👋 Welcome Admin 
            <a class="btn logout" href="admin_panel.php?logout=1">Logout</a>
        </h2>

        <h3>📊 Dashboard Overview</h3>
        <p><strong>Total Restaurants:</strong> <?php echo $restaurant_count; ?></p>
        <p><strong>Total Menu Items:</strong> <?php echo $menu_count; ?></p>

        <hr>
        <h3>➕ Add New Restaurant</h3>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Restaurant Name" required>
            <input type="text" name="category" placeholder="Category" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="file" name="image" required>
            <button class="btn" name="add_restaurant">Add Restaurant</button>
        </form>

        <hr>
        <h3>🍽️ Add Menu Item</h3>
        <form method="post" enctype="multipart/form-data">
            <select name="restaurant_id" required>
                <option value="">Select Restaurant</option>
                <?php
                $resList = mysqli_query($conn, "SELECT * FROM restaurants");
                while ($res = mysqli_fetch_assoc($resList)) {
                    echo "<option value='{$res['id']}'>{$res['name']}</option>";
                }
                ?>
            </select>
            <input type="text" name="dish_name" placeholder="Dish Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="number" name="price" placeholder="Price" required>
            <input type="file" name="image" required>
            <button class="btn" name="add_menu">Add Dish</button>
        </form>

        <hr>
        <h3>🛠️ Manage Restaurants</h3>
        <table>
            <tr>
                <th>Name</th><th>Category</th><th>Address</th><th>Image</th><th>Action</th>
            </tr>
            <?php
            mysqli_data_seek($restaurants, 0); // Reset pointer
            while ($r = mysqli_fetch_assoc($restaurants)) {
                echo "<tr>
                    <td>{$r['name']}</td>
                    <td>{$r['category']}</td>
                    <td>{$r['address']}</td>
                    <td><img src='uploads/{$r['image']}' width='80'></td>
                    <td><a href='?delete_restaurant={$r['id']}' class='btn'>Delete</a></td>
                </tr>";
            }
            ?>
        </table>

        <hr>
        <h3>🧾 Manage Menu Items</h3>
        <table>
            <tr>
                <th>Dish</th><th>Description</th><th>Price</th><th>Image</th><th>Action</th>
            </tr>
            <?php
            mysqli_data_seek($menus, 0); // Reset pointer
            while ($m = mysqli_fetch_assoc($menus)) {
                echo "<tr>
                    <td>{$m['dish_name']}</td>
                    <td>{$m['description']}</td>
                    <td>₹{$m['price']}</td>
                    <td><img src='uploads/{$m['image']}' width='80'></td>
                    <td><a href='?delete_menu={$m['id']}' class='btn'>Delete</a></td>
                </tr>";
            }
            ?>
        </table>

    <?php } ?>
</div>
</body>
</html>
