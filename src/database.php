<?php
require_once('../cfg/db_config.php');

class Database
{
    private $connectie;

    public function __construct()
    {
        $this->connectie = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    }

    public function voerQueryUit($query, $params = [])
    {
        $stmt = $this->connectie->prepare($query);
        $stmt->execute($params);
        if (stripos($query, 'SELECT') === 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $stmt->rowCount();
        }
    }

    public function sluitVerbinding()
    {
        $this->connectie = null;
    }

    public function testVerbinding()
    {
        return (bool) $this->connectie;
    }

    public function __destruct()
    {
        $this->sluitVerbinding();
    }
}



