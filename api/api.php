<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once( __ROOT__ . '/api/model/abstract/api.abstract.php');
spl_autoload_register(function ($className) {
    $className = strtolower($className);
    if(file_exists(__ROOT__ . '/api/model/class/'.$className.'.class.php')) {
        require_once( __ROOT__ . '/api/model/class/'.$className.'.class.php');
    } else {
        throw new Exception('No endpoint for : ' . $className);
    }
});

// Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {
    $API = new TaskManager($_REQUEST, $_SERVER['HTTP_ORIGIN']);
    print $API->processAPI();
} catch (Exception $e) {
    print json_encode(Array('error' => $e->getMessage()));
}

?>
