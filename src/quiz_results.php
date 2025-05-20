<?php
require_once('database.php');

class QuizResults {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function createTable() {
        $query = "CREATE TABLE IF NOT EXISTS quiz_results (
            id INT AUTO_INCREMENT PRIMARY KEY,
            student_id INT NOT NULL,
            total_possible_score INT NOT NULL,
            score INT NOT NULL,
            mode ENUM('country', 'capital') NOT NULL,
            correct_countries JSON,
            wrong_countries JSON,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (student_id) REFERENCES students(id)
        )";
        
        return $this->db->voerQueryUit($query);
    }

    public function saveQuizResult($studentId, $totalPossibleScore, $score, $mode, $correctCountries, $wrongCountries) {
        $query = "INSERT INTO quiz_results (student_id, total_possible_score, score, mode, correct_countries, wrong_countries) 
                 VALUES (:student_id, :total_possible_score, :score, :mode, :correct_countries, :wrong_countries)";
        
        $params = [
            ':student_id' => $studentId,
            ':total_possible_score' => $totalPossibleScore,
            ':score' => $score,
            ':mode' => $mode,
            ':correct_countries' => json_encode($correctCountries),
            ':wrong_countries' => json_encode($wrongCountries)
        ];
        
        return $this->db->voerQueryUit($query, $params);
    }

    public function getStudentResults($studentId) {
        $query = "SELECT * FROM quiz_results WHERE student_id = :student_id ORDER BY created_at DESC";
        $params = [':student_id' => $studentId];
        
        return $this->db->voerQueryUit($query, $params);
    }

    public function getStudentStats($studentId) {
        $query = "SELECT 
                    mode,
                    COUNT(*) as total_attempts,
                    AVG(score) as average_score,
                    MAX(score) as highest_score
                 FROM quiz_results 
                 WHERE student_id = :student_id 
                 GROUP BY mode";
        
        $params = [':student_id' => $studentId];
        
        return $this->db->voerQueryUit($query, $params);
    }
} 