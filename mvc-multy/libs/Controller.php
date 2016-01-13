<?php
class Controller {
    
    // View Object
    protected $_view;
    
    // Model Object
    protected $_model;
    
    // Params (GET - POST)
    protected $_arrParams;
    
    // Template Object
    protected $_templateObj;
    
    /**
     * SET MODEL
     * @param unknown $moduleName
     * @param unknown $modelName
     */
    public function setModel($moduleName, $modelName) {
        $modelName  =   ucfirst($modelName) . 'Model'; 
        $path       =   APPLICATION_PATH . $moduleName . DS . 'models' . DS . $modelName . '.php';
        if(file_exists($path)) {
            require_once $path;
            $this->db   =   new $modelName();
        }
    }
    
    /**
     * GET MODEL
     */
    public function getModel() {
        return $this->_model;
    }
  
    /**
     * SET VIEW
     * @param unknown $moduleName
     */
    public function setView($moduleName) {
        $this->_view = new View($moduleName);
    }
    
    /**
     * GET VIEW
     * @return View
     */
    public function getView() {
        return $this->_view;
    }
    
    /**
     * SET TEMPLATE
     * @param unknown $moduleName
     */
    public function setTemplate($moduleName) {
        $this->_templateObj     =   new Template($this);
    }
    
    /**
     * GET TEMPLATE
     * @return Template
     */
    public function getTemplate() {
        return $this->_templateObj;
    }
    
    public function setParams($arrayParams) {
        $this->_arrParams = $arrayParams;
    }
    
    public function getParams() {
        return $this->_arrParams;
    }

}