<?php
class View {
    
    private $_moduleName;
    
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
        $path   =   APPLICATION_PATH . $this->_moduleName . DS . 'views' . DS . $fileInclude . '.php';
        if(file_exists($path)) {
            require_once $path;
        } else {
             echo '<h3>'. __METHOD__ . ': Error</h3>';
        }
    }
    
}