<!DOCTYPE html>
<html>
<head>
    <title>Zomato Clone - Welcome</title>
    <!-- Google Font for Stylish Food Look -->
    <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: Arial, sans-serif;
        }

        body {
            background-image: url('uploads/Index.jpeg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .wrapper {
            display: flex;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .half {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: 0.4s;
            z-index: 1;
        }

        .right, .left {
            background-color: rgba(208, 0, 255, 1);
        }

        .half:hover {
            background-color: rgba(195, 0, 255, 0);
            cursor: pointer;
        }

        a {
            color: white;
            text-decoration: none;
            padding: 20px 40px;
            border: 2px solid white;
            border-radius: 10px;
            font-size: 24px;
            background-color: rgba(187, 0, 255, 1);
            z-index: 2;
        }

        a:hover {
            background-color: rgba(6, 6, 6, 1);
        }

        /* Watermark base style (hidden by default) */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 130px;
            font-family: 'Bangers', cursive;
            color: rgba(255, 255, 255, 0.63);
            white-space: nowrap;
            z-index: 0;
            pointer-events: none;
        }

        .left-half,
        .right-half {
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        /* Show left half only when hovering left */
        .left:hover ~ .watermark .left-half {
            opacity: 1;
        }

        /* Show right half only when hovering right */
        .right:hover ~ .watermark .right-half {
            opacity: 1;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <!-- Left Half - Register -->
    <div class="half left">
        <a href="register.php">Register</a>
    </div>

    <!-- Right Half - Login -->
    <div class="half right">
        <a href="Lin.php">Login</a>
    </div>

    <!-- Watermark in Center (Hidden by Default) -->
    <div class="watermark">
        <span class="left-half">FOOD</span>
        <span class="right-half">MANIA</span>
    </div>
</div>

</body>
</html>
