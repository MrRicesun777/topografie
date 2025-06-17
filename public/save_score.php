<?php
session_start();
require_once('../src/quiz_results.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['score']) || !isset($data['total_possible_score']) || !isset($data['correct_countries']) || !isset($data['wrong_countries'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit();
}

// Save the quiz result
$quizResults = new QuizResults();
$result = $quizResults->saveQuizResult(
    $_SESSION['user_id'],
    $data['total_possible_score'],
    $data['score'],
    'europe',
    $data['correct_countries'],
    $data['wrong_countries']
);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save score']);
} 