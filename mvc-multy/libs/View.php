<?php
class View {
    
    public $_moduleName;
    
    public $_templatePath;
    
    public $_title;
    
    public $_metaHTTP;
    
    public $_metaName;
    
    public $_cssFiles;
    
    public $_jsFiles;
    
    public $_dirImg;
    
    /**
     * 
     */
    public function __construct($moduleName) {
         $this->_moduleName     =   $moduleName;
    }
    
    /**
     * 
     */
    public function render($fileInclude) {
        require_once $this->_templatePath;
        
        $path   =   APPLICATION_PATH . $this->_moduleName . DS . 'views' . DS . $fileInclude . '.php';
        if(file_exists($path)) {
            require_once $path;
        } else {
             echo '<h3>'. __METHOD__ . ': Error</h3>';
        }
    }
    
    /**
     * SET PATH TO TEMPLATE
     * @param unknown $path
     */
    public function setTemplatePath($path) {
        $this->_templatePath = $path;
    }
    
    /**
     * 
     * @param unknown $value
     */
    public function setTitle($value) {
        $this->_title = $value;
    }
   
    
}