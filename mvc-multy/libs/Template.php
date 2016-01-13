<?php
class Template {
    
    // File Config (admin/main/template.ini)
    private $_fileConfig;
    
    // File Template (/admin/main/index.php)
    private $_fileTemplate;
    
    // Folder Template (/admin/main/)
    private $_folderTemplate;
    
    // Controller Object
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
            $view               =   $this->_controller->getView();
            $view->setTitle($arrayConfig['title']);
            $view->_title       =   $this->createTitle($arrayConfig['title']);
            $view->_metaHTTP    =   $this->createMeta($arrayConfig['metaHTTP'], 'http-equiv');
            $view->_metaName    =   $this->createMeta($arrayConfig['metaName'], 'name');
            $view->_cssFiles    =   $this->createLinkCSS($arrayConfig['dirCss'], $arrayConfig['fileCss']);
            $view->_jsFiles     =   $this->createLinkJS($arrayConfig['dirJs'], $arrayConfig['fileJs']);
            $view->_dirImg      =   $arrayConfig['dirImg'];
            $view->setTemplatePath(TEMPLATE_PATH . $folderTemplate . $fileTemplate);
            
        }
    }
    
    /**
     * 
     * @param unknown $value
     * @return string
     */
    public function createTitle($value) {
        return '<title>'.$value.'</title>';
    }
    
    /**
     * Create Meta ( Name - HTTP )
     * @param unknown $arrayMetaHTTP
     * @return string
     */
    public function createMeta($arrayMeta, $typeMeta = 'name') {
        $xhtml  =   '';
        if(!empty($arrayMeta)) {
            foreach($arrayMeta as $meta) {
                $temp   =   explode('|', $meta);
                $xhtml .= '<meta '.$typeMeta.'="'.$temp[0].'" content="'.$temp[1].'" />';
            }
        }
        return $xhtml;
    }
    
    /**
     *
     * @param unknown createLinkCSS
     * @return string
     */
    public function createLinkCSS($pathCSS, $fileCSS) {
        $xhtml  =   '';
        if(!empty($fileCSS)) {
            $path   =   TEMPLATE_URL . $this->_folderTemplate . $pathCSS . '/';
            foreach($fileCSS as $css) {
                $xhtml .= '<link rel="stylesheet" type="text/css" href="'.$path. $css.'" />';
            }
        }
        return $xhtml;
    }
    
    /**
     *
     * @param unknown createLinkJS
     * @return string
     */
    public function createLinkJS($pathJS, $fileJS) {
        $xhtml  =   '';
        if(!empty($fileJS)) {
            $path   =   TEMPLATE_URL . $this->_folderTemplate . $pathJS . '/';
            foreach($fileJS as $js) {
                $xhtml .= '<script type="text/javascript" src="'.$path. $js. '"></script>';
            }
        }
        return $xhtml;
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