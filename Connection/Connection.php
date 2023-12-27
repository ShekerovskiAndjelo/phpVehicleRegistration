<?php
class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "challenge17";
    private $connection;

    public function __construct()
    {
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
?>