<?php
session_start();
require_once('../src/student.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit();
}

$error = '';
$success = '';

// Handle klassecode submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_klassecode'])) {
  $klassecode = trim($_POST['klassecode']);
  $student = new Student();

  if ($student->verifyKlassecode($klassecode)) {
    // Update student's klassecode
    if ($student->updateKlassecode($_SESSION['user_id'], $klassecode)) {
      $success = "Klassecode successfully linked to your account!";
    } else {
      $error = "Failed to link klassecode. Please try again.";
    }
  } else {
    $error = "Invalid klassecode. Please enter a valid code.";
  }
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wereldkaart met PHP</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Open Sans', sans-serif;
      background: #f5f7fa;
      color: #333;
    }

    .container {
      max-width: 960px;
      margin: 0 auto;
      padding: 20px;
    }

    .header-actions {
      display: flex;
      justify-content: flex-end;
      padding: 10px 0;
    }

    .logout {
      background-color: #ff4d4f;
      color: #fff;
      padding: 8px 16px;
      text-decoration: none;
      border-radius: 6px;
      transition: background-color 0.3s ease;
    }

    .logout:hover {
      background-color: #d9363e;
    }

    .klassecode-section {
      background-color: #ffffff;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
      text-align: center;
    }

    .klassecode-section h3 {
      margin-bottom: 15px;
      color: #2c3e50;
    }

    .klassecode-form {
      display: flex;
      justify-content: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .klassecode-input {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
      width: 250px;
      transition: border-color 0.3s ease;
    }

    .klassecode-input:focus {
      border-color: #3498db;
      outline: none;
    }

    .submit-button {
      padding: 10px 18px;
      background-color: #3498db;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .submit-button:hover {
      background-color: #2980b9;
    }

    .error-message,
    .success-message {
      margin-bottom: 10px;
      padding: 10px;
      border-radius: 6px;
      font-weight: 600;
    }

    .error-message {
      background-color: #ffe0e0;
      color: #d8000c;
    }

    .success-message {
      background-color: #e0ffe6;
      color: #008000;
    }

    #question {
      font-size: 22px;
      font-weight: 600;
      margin-bottom: 10px;
    }

    #score {
      font-size: 18px;
      margin-bottom: 15px;
      color: #555;
    }

    #map {
      height: 75vh;
      width: 100%;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 600px) {
      .klassecode-form {
        flex-direction: column;
        align-items: center;
      }

      .klassecode-input {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header-actions">
      <a href="logout.php" class="logout">Logout</a>
    </div>

    <?php if ($_SESSION['type'] === 'leerling'): ?>
      <div class="klassecode-section">
        <h3>Enter Klassecode</h3>
        <?php if ($error): ?>
          <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
          <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form method="POST" class="klassecode-form">
          <input type="text" name="klassecode" class="klassecode-input" placeholder="Enter klassecode" required>
          <button type="submit" name="submit_klassecode" class="submit-button">Submit</button>
        </form>
      </div>
    <?php endif; ?>

    <div id="question">Vraag wordt geladen...</div>
    <div id="score">Score: 0</div>
    <div id="map"></div>
  </div>

  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="game.js"></script>
</body>

</html>