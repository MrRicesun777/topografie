<?php
include_once('database.php');

class Student extends Database
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $type;
    private $klassecode;

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
        $type = $this->type;
        $klassecode = $this->klassecode;

        $query = "INSERT INTO Students (username, email, password, type, klassecode) 
                  VALUES ('$username', '$email', '$hashedPassword', '$type', " . 
                  ($klassecode ? "'$klassecode'" : "NULL") . ")";
        
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

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setKlassecode($klassecode)
    {
        $this->klassecode = $klassecode;
    }

    public function getKlassecode($id)
    {
        $query = "SELECT klassecode FROM Students WHERE id = $id";
        $result = parent::voerQueryUit($query);
        return $result && count($result) > 0 ? $result[0]['klassecode'] : null;
    }

    public function updateKlassecode($id, $klassecode)
    {
        $query = "UPDATE Students SET klassecode = '$klassecode' WHERE id = $id";
        return parent::voerQueryUit($query);
    }

    public function verifyKlassecode($klassecode)
    {
        $query = "SELECT id FROM Students WHERE klassecode = '$klassecode' AND type = 'docent'";
        $result = parent::voerQueryUit($query);
        return $result && count($result) > 0;
    }

    public function getStudentsByKlassecode($klassecode)
    {
        $query = "SELECT id, username, email FROM Students WHERE klassecode = '$klassecode' AND type = 'leerling'";
        return parent::voerQueryUit($query);
    }
}
?>