<?php
include_once('database.php');

class Student extends Database
{
    private $id;
    private $username;
    private $email;
    private $password;

    // Get all students
    public function getAllStudents()
    {
        $query = "SELECT * FROM Students";
        return parent::voerQueryUit($query);
    }

    // Get a specific student
    public function getStudent($id)
    {
        $query = "SELECT * FROM Students WHERE id = $id";
        return parent::voerQueryUit($query);
    }

    // Save a new student
    public function saveStudent()
    {
        // Check if all required fields are filled in
        if($this->getUsername() == "" || $this->getEmail() == "" || $this->getPassword() == ""){
            return false;
        }

        $username = $this->getUsername();
        $email = $this->getEmail();
        // Hash the password before saving to database
        $hashedPassword = password_hash($this->getPassword(), PASSWORD_DEFAULT);

        $query = "INSERT INTO Students (username, email, password) 
                  VALUES ('$username', '$email', '$hashedPassword')";
        
        // Return true if the query is successful, else return false
        return parent::voerQueryUit($query);
    }

    // Update a student
    public function updateStudent($id)
    {
        // Check if all required fields are filled in
        if($this->getUsername() == "" || $this->getEmail() == "" || $this->getPassword() == ""){
            return false;
        }

        $username = $this->getUsername();
        $email = $this->getEmail();
        // Hash the password before saving to database
        $hashedPassword = password_hash($this->getPassword(), PASSWORD_DEFAULT);

        $query = "UPDATE Students SET 
                  username = '$username', 
                  email = '$email', 
                  password = '$hashedPassword' 
                  WHERE id = $id";
        
        // Return true if the query is successful, else return false
        return parent::voerQueryUit($query);
    }

    // Delete a student
    public function deleteStudent($id)
    {
        $query = "DELETE FROM Students WHERE id = $id";
        // Return true if the query is successful, else return false
        return parent::voerQueryUit($query);
    }

    // Verify password
    public function verifyPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword);
    }

    // Login method
    public function loginStudent($username, $password)
    {
        $query = "SELECT * FROM Students WHERE username = '$username'";
        $result = parent::voerQueryUit($query);
        
        if ($result && count($result) > 0) {
            $student = $result[0];
            if ($this->verifyPassword($password, $student['password'])) {
                return $student;
            }
        }
        
        return false;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}
?>