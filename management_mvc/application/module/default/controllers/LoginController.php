<?php
class LoginController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	// HIEN THI LIST GOOGLE LINK
	public function indexAction(){
	    $this->_view->_title       			=   	'Login';
	    
	    $userInfo     =   Session::get('user');
	    
	    if(@$this->_arrParam['loginForm']['token'] > 0) {
			
			$validate 	=	new Validate($this->_arrParam['loginForm']);
			$username 	=	@$this->_arrParam['loginForm']['username'];
			$password 	=	md5(@$this->_arrParam['loginForm']['password']);
			$query 		=	"SELECT `id` FROM `user` WHERE `nickname` = '{$username}' AND `password` = '{$password}'";
		
			$validate->addRule('username', 'existRecord', array('database' => $this->_model, 'query' => $query));
			$validate->run();
			
			if($validate->isValid() == true) {
				$infoUser 		=	$this->_model->infoItem($this->_arrParam);
				$arraySession 	=	array(
											'login' 		=>		true,
											'info'			=>		$infoUser,
											'time' 			=>		time(),
											'admin_control' =>		$infoUser['admin_control']
										);
				Session::set('user', $arraySession);
				URL::redirect(URL::createLink('default', 'index', 'index'));
			} else {
				$this->_view->errors 	=	$validate->showErrors(false);	
			}
		}
	    
	    
		
		$this->_view->render('login/index', true);
	}
	
	public function logoutAction() {
	    Session::delete('user');
	    URL::redirect(URL::createLink('default', 'login', 'index'));
	}
	
}