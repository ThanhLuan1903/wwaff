<?php
// PHP 5.6 compatible code
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Desktop Device Notice</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: rgba(242, 230, 164, 1);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .notification-container {
      background-color: white;
      border-radius: 15px;
      box-shadow: 0 8px 32px rgba(250, 224, 75, 0.2), 0 2px 8px rgba(0, 0, 0, 0.08);
      padding: 30px;
      text-align: center;
      max-width: 500px;
      width: 100%;
      animation: fadeIn 0.8s ease-in-out;
    }

    .icon {
      font-size: 60px;
      margin-bottom: 20px;
      color: #6b7280;
    }

    h1 {
      color: #374151;
      margin-bottom: 15px;
      font-size: 24px;
    }

    p {
      color: #6b7280;
      margin-bottom: 25px;
      font-size: 18px;
      line-height: 1.5;
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

    .desktop-icon {
      display: inline-block;
      position: relative;
      margin-bottom: 20px;
    }

    .monitor {
      width: 120px;
      height: 90px;
      border: 5px solid #6b7280;
      border-radius: 8px 8px 0 0;
      position: relative;
      margin: 0 auto;
    }

    .screen {
      width: 108px;
      height: 78px;
      background-color: #f8f8f8;
      position: absolute;
      top: 6px;
      left: 6px;
      border-radius: 3px;
    }

    .stand-top {
      width: 50px;
      height: 10px;
      background-color: #6b7280;
      position: relative;
      margin: 0 auto;
    }

    .stand-bottom {
      width: 70px;
      height: 5px;
      background-color: #6b7280;
      border-radius: 2px;
      position: relative;
      margin: 0 auto;
    }
  </style>
</head>

<body>
  <div class="notification-container">
    <div class="desktop-icon">
      <div class="monitor">
        <div class="screen"></div>
      </div>
      <div class="stand-top"></div>
      <div class="stand-bottom"></div>
    </div>
    <h1>Notice</h1>
    <p>Please use a desktop device to continue this step.</p>
  </div>
</body>

</html>