<?php
session_start();
$_SESSION['cart'] = []; // Clear cart after placing order
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Placed</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #8f26d0;
      margin: 0;
      padding: 0;
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      overflow: hidden;
      text-shadow: 1px 1px 5px #000;
      position: relative;
    }

    h1 {
      font-size: 48px;
      margin-bottom: 20px;
      animation: springPop 0.7s ease-out forwards;
      transform: scale(0.5);
    }

    @keyframes springPop {
      0% { transform: scale(0.5); opacity: 0; }
      50% { transform: scale(1.2); opacity: 1; }
      100% { transform: scale(1); }
    }

    p {
      font-size: 20px;
    }

    .btn {
      margin-top: 30px;
      padding: 12px 25px;
      background-color: #00da53;
      border: none;
      color: white;
      font-size: 18px;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
    }

    .btn:hover {
      background-color: #000000;
    }

    .confetti {
      position: absolute;
      width: 10px;
      height: 10px;
      background-color: #fff;
      animation: fall 3s linear infinite;
      opacity: 0.8;
    }

    @keyframes fall {
      0% {
        transform: translateY(-10px) rotate(0deg);
        opacity: 1;
      }
      100% {
        transform: translateY(100vh) rotate(360deg);
        opacity: 0;
      }
    }
  </style>
</head>
<body>

<h1>🎉 Order Placed Successfully!</h1>
<p>Thank you for your order. Your food is being prepared! 🍱</p>
<a class="btn" href="dashboard.php">🏠 Go to Home</a>

<script>
  function createConfetti() {
    const colors = ['#ffcc00', '#ff4d4d', '#66ff66', '#00ffff', '#ff66cc'];
    for (let i = 0; i < 100; i++) {
      let confetti = document.createElement('div');
      confetti.classList.add('confetti');
      confetti.style.left = Math.random() * 100 + 'vw';
      confetti.style.top = Math.random() * -100 + 'px';
      confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
      confetti.style.animationDuration = (Math.random() * 2 + 2) + 's';
      confetti.style.opacity = Math.random();
      document.body.appendChild(confetti);

      setTimeout(() => confetti.remove(), 4000); // Clean up
    }
  }

  // Trigger confetti on page load
  window.onload = createConfetti;
</script>

</body>
</html>
