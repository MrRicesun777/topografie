<?php
require_once('../../config/db_config.php');

class Database
{
    private $connectie;

    public function __construct()
    {
        $this->connectie = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    }

    public function voerQueryUit($query)
    {
        // Check if the query is a SELECT query
        if(str_contains($query, 'SELECT')){
            // Query is a SELECT, fetch the results
            $result = $this->connectie->query($query);
            $rows = $result->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }else{
            // Query is not a SELECT, execute the query
            $result = $this->connectie->exec($query);
            return $result;
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



