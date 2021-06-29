<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

class Controller{
    private $handler;
    private $params;

    function __construct() {
        $dataStr = $_SERVER['PATH_INFO'];
        $this->params = explode('/',$dataStr);
        array_shift ($this->params); //remove beginning ' '
        $resource = array_shift($this->params);
        $resource = strtolower($resource); // small type
        $resource = ucfirst($resource); //first type big
        $handlerName = $resource.'Handler';
        $handlerFile = $handlerName.'.php';

        if(file_exists($handlerFile)){
            //correct resource name
            require_once $handlerFile;
            $this->handler = new $handlerName;

            $method = $_SERVER['REQUEST_METHOD'];
            $method = 'rest'.ucfirst(strtolower($method));

            $this->handler->$method($this->params);
        }else{
            echo'resource not found';
        }
    }
}

$controller = new Controller();
?>