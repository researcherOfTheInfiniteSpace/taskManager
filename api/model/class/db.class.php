<?php

class Db {

    private $_connection;
    private static $_instance;
    private $_host = '127.0.0.1';
    private $_username = 'root';
    private $_password = 'root';
    private $_database = 'get';

    public static function getInstance() {

        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        try {
            $this->_connection  = new \PDO("mysql:host=$this->_host;dbname=$this->_database", $this->_username, $this->_password);
            $this->_connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
    }

    // Get mysql pdo connection
    public function getConnection() {
        return $this->_connection;
    }

}

?>
