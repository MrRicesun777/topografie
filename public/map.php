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
  <script type="text/javascript" src="mapdata.js"></script>
  <script type="text/javascript" src="europemap.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Open Sans', sans-serif;
      line-height: 1.6;
      color: #333; /* General text color */
      background-color: #f4f6f9; /* Slightly softer and common professional background */
      padding: 20px;
      -webkit-font-smoothing: antialiased; /* Improve font rendering on WebKit browsers */
      -moz-osx-font-smoothing: grayscale; /* Improve font rendering on Firefox */
    }
    
    .container {
      max-width: 1200px;
      margin: 30px auto; /* Added a bit more top/bottom margin for better spacing */
      padding: 25px 30px; /* Slightly increased padding for content */
      background-color: #ffffff; /* Clean white background for content */
      border-radius: 10px; /* Softer, more modern rounded corners */
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); /* More diffused and subtle shadow */
    }
    
    header {
      text-align: center;
      margin-bottom: 35px; /* Increased spacing below header */
      padding-bottom: 20px; /* Increased padding within header */
      border-bottom: 1px solid #e9ecef; /* Lighter, common professional border color */
    }
    
    h1 {
      color: #2c3e50; /* Strong, professional dark blue/grey */
      font-size: 2.4rem; /* Slightly larger for more impact */
      font-weight: 600; /* Using the imported bold weight */
      margin-bottom: 8px; /* Adjusted spacing between title and subtitle */
    }
    
    .subtitle {
      color: #5a6771; /* Slightly darker grey for better readability */
      font-size: 1.15rem; /* Slightly larger for better balance with title */
      font-weight: 400; /* Using the imported regular weight */
    }
    
    #map {
      width: 100%;
      height: auto; /* Default to auto, will be overridden if JS sets specific height */
      min-height: 450px; /* Ensure map area has a good minimum height */
      margin: 25px auto; /* Consistent margin */
      border-radius: 8px; /* Consistent with other elements or slightly less than container */
      overflow: hidden; /* Essential for keeping map content within bounds */
      background-color: #f8f9fa; /* Light placeholder background for the map area */
    }
    
    footer {
      text-align: center;
      margin-top: 35px; /* Increased spacing above footer */
      padding-top: 20px; /* Increased padding within footer */
      border-top: 1px solid #e9ecef; /* Consistent border color with header */
      color: #6c757d; /* Standard muted color for footer text */
      font-size: 0.9rem;
    }

    /* Optional: Basic transition for potential interactive elements for a smoother feel */
    a, button {
        transition: color 0.2s ease-in-out, background-color 0.2s ease-in-out, border-color 0.2s ease-in-out;
    }

    .klassecode-section {
        margin: 20px 0;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        text-align: center;
    }

    .klassecode-form {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 15px;
    }

    .klassecode-input {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
        width: 200px;
    }

    .submit-button {
        background-color: #4CAF50;
        color: white;
        padding: 8px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .submit-button:hover {
        background-color: #45a049;
    }

    .error-message {
        color: #dc3545;
        margin-top: 10px;
    }

    .success-message {
        color: #28a745;
        margin-top: 10px;
    }

    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .logout {
        color: #666;
        text-decoration: none;
    }

    .logout:hover {
        color: #333;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header-actions">
      <h1>Wereldkaart</h1>
      <a href="logout.php" class="logout">Logout</a>
    </div>
    <p class="subtitle">Interactieve kaart van Europa</p>
    
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
    
    <main>
      <div id="map"></div>
    </main>
    
    <footer>
      <p>&copy; 2025 Topografie Project</p>
    </footer>
  </div>
</body>
</html>