<?php
class Controller {
    public $_view;
    
    protected $_model;
    
    protected $_arrParams;
    
    protected $_templateObj;
    
    public function loadModel($moduleName, $modelName) {
        $modelName  =   ucfirst($modelName) . 'Model'; 
        $path       =   APPLICATION_PATH . $moduleName . DS . 'models' . DS . $modelName . '.php';
        if(file_exists($path)) {
            require_once $path;
            $this->db   =   new $modelName();
        }
    }
  
    public function setView($moduleName) {
        $this->_view = new View($moduleName);
    }
    
    public function setParams($arrayParams) {
        
        $this->_arrParams = $arrayParams;
    }
    
    /**
     * 
     * @param unknown $moduleName
     */
    public function setTemplate($moduleName) {
        $this->_templateObj     =   new Template($this);
        echo '<pre>';
        print_r($this->_templateObj);
        echo '</pre>';
    }
    
}