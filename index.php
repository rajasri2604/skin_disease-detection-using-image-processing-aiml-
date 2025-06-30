<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Skin Disease Detection</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color:rgb(29, 195, 228);
      
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .upload-box {
      background: white;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      text-align: center;
    }
    input[type="file"] {
      margin: 1rem 0;
    }
    button {
      background-color: #2563eb;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="upload-box">
    <h2>Upload Skin Image</h2>
    <form action="upload.php" method="POST" enctype="multipart/form-data">

    <form action="predict.php" method="POST" enctype="multipart/form-data">
      <input type="file" name="image" accept="image/*" required>
      <br>
      <button type="submit">Predict</button>
    </form>
  </div>
</body>
</html>
