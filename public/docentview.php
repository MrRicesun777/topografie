<?php
session_start();
require_once('../src/student.php');

// Check if user is logged in and is a docent
if (!isset($_SESSION['user_id']) || $_SESSION['type'] !== 'docent') {
    header("Location: index.php");
    exit();
}

$student = new Student();
$klassecode = $student->getKlassecode($_SESSION['user_id']);
$students = $klassecode ? $student->getStudentsByKlassecode($klassecode) : [];

// Handle klassecode creation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_klassecode'])) {
    // Generate a random 6-character klassecode
    $newKlassecode = strtoupper(substr(md5(uniqid()), 0, 6));
    if ($student->updateKlassecode($_SESSION['user_id'], $newKlassecode)) {
        $klassecode = $newKlassecode;
        $students = $student->getStudentsByKlassecode($klassecode);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Docent Dashboard</title>
    <style>
        .container {
            width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .welcome {
            font-size: 24px;
        }
        .klassecode-section {
            margin: 20px 0;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        .klassecode {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin: 10px 0;
        }
        .create-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .create-button:hover {
            background-color: #45a049;
        }
        .logout {
            color: #666;
            text-decoration: none;
        }
        .logout:hover {
            color: #333;
        }
        .students-section {
            margin-top: 30px;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        .students-list {
            margin-top: 15px;
        }
        .student-item {
            padding: 10px;
            background-color: white;
            border-radius: 4px;
            margin-bottom: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .student-name {
            font-weight: bold;
            color: #2c3e50;
        }
        .student-email {
            color: #666;
            font-size: 0.9em;
        }
        .no-students {
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="welcome">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></div>
            <a href="logout.php" class="logout">Logout</a>
        </div>

        <div class="klassecode-section">
            <?php if ($klassecode): ?>
                <h3>Your Klassecode:</h3>
                <div class="klassecode"><?php echo htmlspecialchars($klassecode); ?></div>
            <?php else: ?>
                <form method="POST">
                    <button type="submit" name="create_klassecode" class="create-button">Create Klassecode</button>
                </form>
            <?php endif; ?>
        </div>

        <?php if ($klassecode): ?>
        <div class="students-section">
            <h3>Students in Your Class</h3>
            <div class="students-list">
                <?php if (count($students) > 0): ?>
                    <?php foreach ($students as $student): ?>
                        <div class="student-item">
                            <div class="student-name"><?php echo htmlspecialchars($student['username']); ?></div>
                            <div class="student-email"><?php echo htmlspecialchars($student['email']); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-students">No students have joined your class yet.</div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
