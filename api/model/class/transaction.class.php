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

    public function dbInsert($args, $table) {
        try {
            $query = 'INSERT INTO ' . $table . ' (';
            $query .= implode(',', array_keys($args));
            $query .= ') ';
            $query .= 'VALUES(';
            $i = 0;
            foreach($args as $key => $value) {
                $i++;
                if($i < count($args)) {
                    $query .=  '\'' . $value . '\', ';
                } else {
                    $query .=  '\'' . $value . '\'';
                }
            }
            $query .= ')';
            $sql = $this->_dbh->query($query);
            $this->insert = $this->_dbh->lastInsertId();
            $this->_dbh = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function dbUpdate($data) {

    }

    public function dbDelete($args, $table) {
        try {
            $query = 'DELETE FROM ' . $table . ' WHERE ';
            if(!empty($args)) {
                $i = 1;
                foreach($args as $key => $value) {
                    $i++;
                    if($i < count($args)) {
                        $query .= $key . ' = \'' . $value . '\' AND ';
                    } else {
                        $query .= $key . ' = \'' . $value . '\' ';
                    }
                }
            }
            $sql = $this->_dbh->query($query);
            $this->delete = true;
            $this->_dbh = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }
}
?>
