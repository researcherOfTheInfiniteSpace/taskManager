<?php
class Transaction {


    public function __construct(){
        $db = Db::getInstance();
        $this->_dbh = $db->getConnection();
    }

    public function dbSelect($query) {
        try {
            $sql = $this->_dbh->query($query, PDO::FETCH_ASSOC);
            foreach ($sql as $key => $value) {
                $this->_dbh->select[$key] = $value;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function dbInsert($data) {

    }

    public function dbUpdate($data) {

    }

    public function dbDelete($data) {

        try {
            $sql = $this->_dbh->query($query);
            foreach ($sql as $key => $value) {
                print $key;
                print $value;
                $this->_dbh->delete = $value;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }
}
?>
