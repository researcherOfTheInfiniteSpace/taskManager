<?php
abstract class API {
    /**
     * Property: method
     * The HTTP method this request was made in, either GET, POST, PUT or DELETE
     */
    protected $method = '';
    /**
     * Property: endpoint
     * The Model requested in the URI. eg: /files
     */
    protected $endpoint = '';
    /**
     * Property: args
     * Any additional URI components after the endpoint and verb have been removed, in our
     * case, an integer ID for the resource. eg: /<endpoint>/<verb>/<arg0>/<arg1>
     * or /<endpoint>/<arg0>
     */
    protected $args = Array();

    public function __construct($request) {

        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        $this->method = $_SERVER['REQUEST_METHOD'];
        if($this->method == 'GET') {
            $this->args = explode('/', rtrim($request['request'], '/'));
            if(!empty($this->args)) {
                $this->endpoint = array_shift($this->args);
                if(!empty($this->args)) {
                    if($this->args[0] == 'all') {
                        $this->args = array_shift($this->args);
                    }

                }
            }
        } else if($this->method == 'POST' || $this->method == 'DELETE') {
            $this->endpoint = $request['request'];
            unset($request['request']);
            $this->args = $request;
        }
    }

    public function processAPI() {
        if($this->args != null) {
            $classCalled = ucfirst($this->endpoint);
            $call = new $classCalled($this->method, $this->args);
            if($call) {
                if(is_numeric($this->args) || $this->args != 'all') {
                    return $this->_response($call);
                } else {
                    return $this->_response($call->all);
                }
            } else {
                return $this->_response("Data deleted", 200);
            }
        } else {
            return $this->_response("This endpoint needs argument", 404);
        }
    }

    private function _response($data, $status = 200) {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return json_encode($data);
    }

    private function _requestStatus($code) {
        $status = array(
           200 => 'OK',
           404 => 'Not Found',
           405 => 'Method Not Allowed',
           500 => 'Internal Server Error',
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }
}

?>
