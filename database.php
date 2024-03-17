<?php
class DB {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'vk_restapi';
    private $connection;

    public function __construct() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
