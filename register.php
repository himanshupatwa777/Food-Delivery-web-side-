<?php
include 'database.php'; // DB Connection

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if ($name != "" && $email != "" && $password != "") {
        $hash = password_hash($password, PASSWORD_DEFAULT); // secure password
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hash')";
        if (mysqli_query($conn, $sql)) {
            header("Location: Lin.php"); // Redirect to login
            exit();
        } else {
            $msg = "Email already exists or error!";
        }
    } else {
        $msg = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Zomato Clone</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('uploads/F.jpeg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-box {
            width: 400px;
            background-color: rgba(0, 0, 0, 0.3); /* Semi-transparent dark background */
            padding: 40px;
            border-radius: 15px;
            color: white;
            box-shadow: 0 0 25px rgba(0,0,0,0.7);
        }

        .form-box h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .form-box input[type="text"],
        .form-box input[type="email"],
        .form-box input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
        }

        .form-box input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: rgba(126, 12, 202, 1);
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 20px;
        }

        .form-box input[type="submit"]:hover {
            background-color: darkred;
        }

        .msg {
            color: yellow;
            text-align: center;
            margin-top: 10px;
        }

        a {
            color: #ccc;
            text-decoration: underline;
            display: block;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Register</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Enter Your Name" required />
        <input type="email" name="email" placeholder="Enter Email" required />
        <input type="password" name="password" placeholder="Enter Password" required />
        <input type="submit" value="Register" />
    </form>
    <div class="msg"><?php echo $msg; ?></div>
    <a href="Lin.php">Already have an account? Login</a>
</div>

</body>
</html>
