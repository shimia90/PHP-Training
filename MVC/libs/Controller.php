<?php
class Controller {
    protected $view;
    /**
     * 
     */
    public function __construct() {
         $this->view = new View();
    }
    
    public function loadModel($name) {
        $path = MODEL_PATH . $name . '_model.php';
        $modelName  =   ucfirst($name) . '_Model';
        if(file_exists($path)) {
            require_once $path;
            $this->db   = new $modelName();
        }
    }
    
    public function redirect($controller, $action) {
        header("location: index.php?controlle={$controller}&action={$action}");
        exit();
    }
}