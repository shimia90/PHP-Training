<?php
class Bootstrap extends Controller {
    
    public function __construct() {
        $controllerURL      =   (isset($_GET['controller'])) ? $_GET['controller'] : 'index';
        $actionURL 	        =   (isset($_GET['action'])) ? $_GET['action'] : 'index';
        
        $controllerName     =   ucfirst($controllerURL);
        
        $file               =   CONTROLLER_PATH . $controllerURL .".php";
        if(file_exists($file)) {
            require_once ($file);
            $controller 	=	new $controllerName;
            
            if(method_exists($controller, $actionURL) == true) {
                $controller->loadModel($controllerURL);
                $controller->$actionURL();
                
            } else {
                $this->error();
            }
 
        }  else {
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