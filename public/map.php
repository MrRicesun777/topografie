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
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      text-align: center;
    }

    #question {
      font-size: 24px;
      margin: 15px;
    }

    #score {
      margin-bottom: 10px;
      font-size: 18px;
      font-weight: bold;
    }

    #map {
      height: 90vh;
      width: 100%;
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