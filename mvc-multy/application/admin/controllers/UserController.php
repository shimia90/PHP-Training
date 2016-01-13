<?php
class UserController extends Controller {
    
    /**
     * 
     */
    public function indexAction() {
         echo '<h3>'. __METHOD__ . '</h3>';
    }
    
    /**
     *
     */
    public function loginAction() {
        $this->_templateObj->setFolderTemplate('admin/main');
        $this->_templateObj->setFileConfig('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
        $this->_view->render('user/login');
    }
}