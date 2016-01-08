<?php
class Bootstrap extends Controller {
    
    private $_url;
    
    private $_controller;
    
    public function init() {
        $this->setURL();
        if(!isset($this->_url['controller'])) {
            $this->loadDefaultController();
            exit();
        }
        $this->loadExistControler();
        $this->callControllerMethod();
    }
    
    /*
     * SET URL
     */
    private function setURL() {
        $this->_url = (isset($_GET)) ? $_GET : null;
    }
    
    /**
     * LOAD DEFAULT CONTROLLER
     */
    private function loadDefaultController() {
        require_once CONTROLLER_PATH . 'index.php';
        $this->_controller = new Index();
        $this->_controller->index();
    }
    
    /**
     *  LOAD EXIST CONTROLLER
     */
    private function loadExistControler() {
        $file               =   CONTROLLER_PATH . $this->_url['controller'] .".php";
        if(file_exists($file)) {
            require_once ($file);
            $this->_controller 	       =	new $this->_url['controller'];
            $this->_controller->loadModel($this->_url['controller']);
        }  else {
            $this->error();
        }
    }
    
    /**
     *  CALL METHOD
     */
    private function callControllerMethod() {
        if(method_exists($this->_controller, $this->_url['action']) == true) {
            $this->_controller->{$this->_url['action']}();
        } else {
            $this->error();
        }
    }
    
    /**
     * 
     */
    public function error() {
        require CONTROLLER_PATH . 'error.php';
        $error          =    new Error();
        $error->index();
    }
    
}