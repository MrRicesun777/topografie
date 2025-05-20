<?php
session_start();
require_once('../src/quiz_results.php');
require_once('../src/student.php');

$quizResults = new QuizResults();
$student = new Student();

// Handle POST request to save quiz results
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_SESSION['student_id'];
    $totalPossibleScore = $_POST['total_possible_score'] ?? 0;
    $score = $_POST['score'] ?? 0;
    $mode = 'europe'; // Force mode to 'europe'
    $correctCountries = $_POST['correct_countries'] ?? [];
    $wrongCountries = $_POST['wrong_countries'] ?? [];

    // Save the quiz result
    $quizResults->saveQuizResult(
        $studentId,
        $totalPossibleScore,
        $score,
        $mode,
        $correctCountries,
        $wrongCountries
    );

    // Redirect to prevent form resubmission
    header('Location: score.php');
    exit();
}

// Get student's quiz history
$studentId = $_SESSION['student_id'];
$results = $quizResults->getStudentResults($studentId);
$stats = $quizResults->getStudentStats($studentId);
$studentInfo = $student->getStudent($studentId)[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>
    <div class="container">
        <h1>Quiz Results for <?php echo htmlspecialchars($studentInfo['username']); ?></h1>

        <!-- Statistics Section -->
        <div class="stats-section">
            <h2>Your Statistics</h2>
            <?php foreach ($stats as $stat): ?>
                <div class="stat-card">
                    <h3>Europe Mode</h3>
                    <p>Total Attempts: <?php echo $stat['total_attempts']; ?></p>
                    <p>Average Score: <?php echo round($stat['average_score'], 1); ?></p>
                    <p>Highest Score: <?php echo $stat['highest_score']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Recent Results Section -->
        <div class="results-section">
            <h2>Recent Quiz Attempts</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Mode</th>
                        <th>Score</th>
                        <th>Total Possible</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result): ?>
                        <tr>
                            <td><?php echo date('Y-m-d H:i', strtotime($result['created_at'])); ?></td>
                            <td>Europe</td>
                            <td><?php echo $result['score']; ?></td>
                            <td><?php echo $result['total_possible_score']; ?></td>
                            <td><?php echo round(($result['score'] / $result['total_possible_score']) * 100, 1); ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="navigation">
            <a href="quiz.php" class="button">Take Another Quiz</a>
            <a href="index.php" class="button">Back to Home</a>
        </div>
    </div>
</body>
</html>
