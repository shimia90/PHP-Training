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
    
    public function registerAction() {
        if(isset($this->_arrParam['form']['submit'])) {
            echo '<pre>';
            print_r($this->_arrParam);
            echo '</pre>';
            if(Session::get('token') == $this->_arrParam['form']['token']) {
                Session::delete('token');
                URL::redirect(URL::createLink('default', 'user', 'register'));
            } else {
                Session::set('token', $this->_arrParam['form']['token']);
            }
        }
        $this->_view->render('user/register');
    }
}