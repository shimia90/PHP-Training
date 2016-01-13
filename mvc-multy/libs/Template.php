<?php
class Template {
    
    private $_fileConfig;
    
    private $_fileTemplate;
    
    private $_folderTemplate;
    
    private $_controller;
    
    /**
     * 
     */
    public function __construct($controller) {
        $this->_controller  =   $controller;
    }
    
    public function load() {
        $fileConfig             =   $this->getFileConfig();
        $folderTemplate         =   $this->getFolderTemplate();
        $fileTemplate           =   $this->getFileTemplate();
        
        $pathFileConfig         =   TEMPLATE_PATH . $folderTemplate . DS . $fileConfig;
        if(file_exists($pathFileConfig) == true) {
            $arrayConfig        =   parse_ini_file($pathFileConfig);
            echo $this->_controller->_view->templatePath = TEMPLATE_PATH . $folderTemplate . $fileTemplate;
        }
    }
    
    /**
     * 
     * @param string $value
     */
    public function setFileTemplate($value = 'index.php') {
        $this->_fileTemplate    =   $value;
    }
    
    /**
     * 
     * @return string
     */
    public function getFileTemplate() {
        return $this->_fileTemplate;
    }
    
    /**
     * 
     * @param string $value
     */
    public function setFileConfig( $value = 'template.ini' ) {
        $this->_fileConfig = $value;
    }
    
    /**
     * 
     * @return string
     */
    public function getFileConfig() {
        return $this->_fileConfig;
    }
    
    /**
     * 
     * @param string $value
     */
    public function setFolderTemplate($value = 'default/main') {
        $this->_folderTemplate = $value;
    }
    
    /**
     * 
     */
    public function getFolderTemplate() {
        return $this->_folderTemplate;
    }
}