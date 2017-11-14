<?php

class Task {

    public $id;
    public $user_id;
    public $title;
    public $description;
    public $creation_date;
    public $status;

    public function __construct($method, $args = null) {
        if($args != null && is_array($args)) {
            switch ($method) {
                case 'GET':
                    # code...
                    break;
                case 'POST':
                    $insert = new Transaction;
                    $argsAsso = array('user_id' => $args['user_id']);
                    unset($args['user_id']);
                    $insert->dbInsert($args, strtolower(get_called_class()));
                    if(!property_exists($insert, 'insert') && !$insert->insert) {
                        throw new Exception('The record couldn\'t be done.');
                    } else {
                        $argsAsso['task_id'] = $insert->insert;
                        $insertAsso = new Transaction;
                        $insertAsso->dbInsert($argsAsso, 'user_task');
                    }
                    break;
                case 'UPDATE':
                    # code...
                    break;
                case 'DELETE':
                    $delete = new Transaction;
                    $delete->dbDelete($args, strtolower(get_called_class()));
                    if(!property_exists($delete, '$delete') && !$delete->delete) {
                        throw new Exception('The deletion couldn\'t be done.');
                    } else {
                        $deleteAsso = new Transaction;
                        $argsAsso = array("task_id" => $args['id']);
                        $deleteAsso->dbDelete($argsAsso, 'user_task');
                        if(!property_exists($deleteAsso, '$delete') && !$deleteAsso->delete) {
                            throw new Exception('The deletion couldn\'t be done.');
                        }
                    }
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
                    if(property_exists($get, 'select') && is_array($get->select) && !empty($get->select)) {
                        $this->_get(array_shift($get->select));
                        $getAssoUser = new Transaction;
                        $getAssoUser->dbSelect('SELECT user_id FROM user_task WHERE task_id = ' . $this->id);
                        if(property_exists($getAssoUser, 'select') && is_array($getAssoUser->select) && !empty($getAssoUser->select)) {
                            $this->user_id = $getAssoUser->select[0]['user_id'];
                        } else {
                            throw new Exception('No user found for this request');
                        }
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
                $getAll = new Transaction;
                $getAll->dbSelect('SELECT * FROM ' . get_called_class());
                if($getAll->select && is_array($getAll->select) && !empty($getAll->select)) {
                    $this->all = array();
                    foreach($getAll->select as $key => $value) {
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
            if(property_exists('Task', $key)) {
                $this->$key = $value;
            }
        }
    }
}

?>
