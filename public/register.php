<?php
session_start();
require_once('../src/student.php');

// Initialize error message
$error = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student = new Student();

    // Get form data
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : '';

    // Basic validation
    if ($password !== $confirmPassword) {
        $error = "Wachtwoorden komen niet overeen";
    } else if (empty($username) || empty($email) || empty($password) || empty($type)) {
        if (empty($type)) {
            $error = "Selecteer een type (leerling of docent).";
        } else {
            $error = "Alle velden zijn verplicht";
        }
    } else {
        // Set student properties
        $student->setUsername($username);
        $student->setEmail($email);
        $student->setPassword($password);
        $student->setType($type);

        // Attempt to save student
        if ($student->saveStudent()) {
            // Registration successful
            $_SESSION['registration_success'] = true;
            header("Location: index.php");
            exit();
        } else {
            $error = "Registratie mislukt. Probeer het opnieuw.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registratie</title>
    <style>
        .register-container {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Student Registratie</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username">Gebruikersnaam:</label>
                <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Wachtwoord:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Bevestig Wachtwoord:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <div class="form-group">
                <label for="type">Type:</label>
                <select id="type" name="type" required>
                    <option value="">-- Selecteer Type --</option>
                    <option value="leerling" <?php echo (isset($_POST['type']) && $_POST['type'] === 'leerling') ? 'selected' : ''; ?>>Leerling</option>
                    <option value="docent" <?php echo (isset($_POST['type']) && $_POST['type'] === 'docent') ? 'selected' : ''; ?>>Docent</option>
                </select>
            </div>

            <input type="submit" value="Registreer">
        </form>

        <div class="login-link">
            Heb je al een account? <a href="inlog.php">Log hier in</a>
        </div>
    </div>
</body>
</html>