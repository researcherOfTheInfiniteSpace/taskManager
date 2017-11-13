<?php
class Transaction {


    public function __construct(){
        $db = Db::getInstance();
        $this->_dbh = $db->getConnection();
    }

    public function dbSelect($query) {
        try {
            $sql = $this->_dbh->query($query, PDO::FETCH_ASSOC);
            $this->select = array();
            foreach ($sql as $key => $value) {
                $this->select[$key] = $value;
            }
            $this->_dbh = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function dbInsert($query) {
        try {
            $sql = $this->_dbh->query($query);
            $this->insert = true;
            $this->_dbh = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function dbUpdate($data) {

    }

    public function dbDelete($query) {
        try {
            $sql = $this->_dbh->query($query);
            $this->delete = true;
            $this->_dbh = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }
}
?>
