<?php
class UserController extends Controller{
    
   public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	// HIEN THI LIST USER
	public function indexAction(){
	    $this->_view->_title       =   'User Management';
	    $totalItems = $this->_model->countItem($this->_arrParam, null);
	    
	    $configPagination          			=   	array('totalItemsPerPage'  =>  5, 'pageRange'  =>  2);
	    $this->setPagination($configPagination);
	    
	    $this->_view->pagination   			=   	new Pagination($totalItems, $this->_pagination);    
	    //$this->_view->Items    			= 		$this->_model->listItems($this->_arrParam, null);
		
		$this->_view->arrayUser 			=		$this->_model->listUser();
		
		$this->_view->render('user/index', true);
	}
	
	// INSERT USER
	public function insertAction() {
		$this->_view->_title       			=   	'Insert User';
		$this->_view->arrayTeam         =       $this->_model->listTeam();
		if(isset($_POST['insertUser'])) {

		    foreach($_POST['insertUser'] as $key => $value) {
		        if($key == 'password') {
		            $_POST['insertUser']['password']      =       md5($value);
		        }
		    }

			$this->_view->_result 			=		$this->_model->processInsert($_POST['insertUser']);
		}
		$this->_view->render('user/insert', true);
	}
	
	public function editAction() {
		$this->_view->_title       			=   	'Edit User';
		$this->_view->arrayTeam               =       $this->_model->listTeam();
		if(isset($_GET['id'])) {
			$this->_view->_arrayUser 		=		$this->_model->arrayEdit($_GET['id']);
		}
		
		if(isset($_POST['editUser']) && isset($_GET['id'])) {
		    
		    foreach ($_POST['editUser'] as $key => $value) {
		        if($key == 'password') {
		            $_POST['editUser']['password']    =   md5($value);
		        }
		    }
			$this->_view->_result 			=		$this->_model->processEdit($_POST['editUser'], $_GET['id']);
			URL::redirect(URL::createLink('default', 'user', 'edit', array('id' => $_GET['id'])));
		}
		$this->_view->render('user/edit', true);
	}
	
	public function deleteAction() {
		$this->_view->_title       			=   	'Delete | User';	
		$this->_view->message 				=		'';
		if (isset($_GET['id'])) {
			$this->_view->message 			=		$this->_model->processDelete($_GET['id']);
		}
		$this->_view->render('user/delete', true);
	}
	
	
}