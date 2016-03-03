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
			
			URL::checkRefreshPage($this->_arrParam['form']['token'], 'default', 'user', 'register');
			
			$queryUserName     =   "SELECT `id` FROM `".TBL_USER."` WHERE `username` = '{$this->_arrParam['form']['username']}'";
	        $queryEmail        =   "SELECT `email` FROM `".TBL_USER."` WHERE `email` = '{$this->_arrParam['form']['email']}'";
			$validate  =   new Validate($this->_arrParam['form']);
	        
	        $validate->addRule('username', 'string-notExistRecord', array('database' => $this->_model, 'query' => $queryUserName, 'min' => 3, 'max' => 25))
	                 ->addRule('email', 'email-notExistRecord', array('database' => $this->_model, 'query' => $queryEmail))
	                 ->addRule('password', 'password', array('action' => 'add'));
	        $validate->run();
	        $this->_arrParam['form'] = $validate->getResult();
	        if($validate->isValid() == false) {
	            $this->_view->errors = $validate->showErrorsPublic();
	        } else {
	            $id = $this->_model->saveItem($this->_arrParam, array('task' => 'user-register'));
	          	URL::redirect('default', 'index', 'notice', array('type' =>	'register-success'));
	        }
        }
        $this->_view->render('user/register');
    }
}