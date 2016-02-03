<?php
class UserController extends Controller {
    
    /**
     * 
     */
    public function __construct($arrayParams) {
        parent::__construct($arrayParams);
        $this->_templateObj->setFolderTemplate('default/main/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }
    
    /**
     * 
     */
    public function indexAction() {
         $this->getModel('admin', 'index');
         $this->_view->data = array('PHP', 'Joomla');
         $this->_view->render('user/index');
    }
    
    /**
     *
     */
    public function addAction() {
        echo '<h3>'. __METHOD__ . '</h3>';
    }
    
    public function loginAction() {
        $this->getModel('admin', 'index');
        $this->_view->data = array('PHP', 'Joomla');
        $this->_view->render('user/login');
    }
}