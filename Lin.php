<?php
session_start();
include 'database.php'; // ✅ DB connection in $conn

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT id, password FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION["user_id"] = $row["id"];
            header("Location: dashboard.php");
            exit();
        } else {
            $msg = "❌ Wrong password!";
        }
    } else {
        $msg = "❌ User not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - FOODMANIA </title>
    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            background-image: url('uploads/F.jpeg');
            background-size: cover;
            background-position: center;
        }

        .container {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-box {
            width: 500px;
            background-color: rgba(0, 0, 0, 0.3);
            padding: 50px;
            border-radius: 20px;
            color: white;
            box-shadow: 0 0 30px rgba(0,0,0,0.6);
        }

        .form-box h2 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 40px;
        }

        .form-box input[type="email"],
        .form-box input[type="password"] {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            margin: 15px 0;
            border: none;
            border-radius: 10px;
        }

        .form-box input[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #892ce1ff;
            color: white;
            font-size: 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.3s;
        }

        .form-box input[type="submit"]:hover {
            background-color: #c0392b;
        }

        .msg {
            color: #ffeb3b;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }

        .form-box a {
            color: #ddd;
            text-decoration: underline;
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }

        @media screen and (max-width: 600px) {
            .form-box {
                width: 90%;
                padding: 30px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-box">
        <h2>Login to FoodMania </h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Enter Email" required />
            <input type="password" name="password" placeholder="Enter Password" required />
            <input type="submit" value="Login" />
        </form>
        <div class="msg"><?php echo $msg; ?></div>
        <a href="register.php">Don't have an account? Register</a>
    </div>
</div>

</body>
</html>
