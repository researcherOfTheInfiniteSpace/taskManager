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
                    $insert = new Transaction;
                    $insert->dbInsert($args, strtolower(get_called_class()));
                    if(!property_exists($insert, 'insert') && !$insert->insert) {
                        throw new Exception('The record couldn\'t be done.');
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
                        $value["tasks"] = array();
                        $tasks = new Transaction;
                        $tasks->dbSelect('SELECT * FROM user_task WHERE user_id = ' .$value['id']);
                        if(is_array($tasks->select) && !empty($tasks->select)) {
                            foreach ($tasks->select as $t => $info) {
                                $task = new Task('GET', $info['task_id']);
                                $task->user_id = $value['id'];
                                $value['tasks'][] = $task;
                            }
                        }
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
