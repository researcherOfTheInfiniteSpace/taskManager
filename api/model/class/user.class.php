<?php

class User {

    public $id;
    public $name;
    public $email;

    public function __construct($method, $args = null) {
        if($args != null && is_array($args)) {
            switch ($method) {
                case 'GET':
                    # code...
                    break;
                case 'POST':
                    # code...
                    break;
                case 'UPDATE':
                    # code...
                    break;
                case 'DELETE':
                    # code...
                    break;
                default:
                    throw new Exception('This method : ' . $method . ' cannot be used');
                    break;
            }
        } else if($args != null && is_numeric($args)) {
            switch ($method) {
                case 'GET':
                    $get = new Transaction;
                    $get->dbSelect('SELECT * FROM ' . get_called_class() . ' WHERE id = ' . $args);
                    if(property_exists($get->_dbh, 'select') && is_array($get->_dbh->select)) {
                        $this->_get(array_shift($get->_dbh->select));
                    } else {
                        throw new Exception('No user found for this request');
                    }
                    break;
                case 'DELETE':
                    #code
                    break;
                default:
                    throw new Exception('This method : ' . $method . ' needs at least one argument.');
                    break;
            }
        } else {
            if($method == 'GET') {
                $get = new Transaction;
                $get->dbSelect('SELECT * FROM ' . get_called_class());
                if(is_array($get->_dbh->select)) {
                    $this->all = array();
                    foreach($get->_dbh->select as $key => $value) {
                        $this->all[] = $value;
                    }
                } else {
                    throw new Exception('No user found for this request');
                }
            } else {
                throw new Exception('This method : ' . $method . ' cannot be used with this argument : ' . print_r($args) . '.');
            }
        }
    }

    private function _get($data) {
        foreach ($data as $key => $value) {
            if(property_exists(get_called_class() , $key)) {
                $this->$key = $value;
            }
        }
    }
}

?>
