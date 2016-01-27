<?php
class GroupController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	// HIEN THI DANH SACH GROUUP
	public function indexAction(){
	    $this->_view->_title   =   'User Manager: User Groups';
	    $this->_view->Items = $this->_model->listItems($this->_arrParam, null);
		$this->_view->render('group/index', true);
	}
	
	// THEM GROUP
	public function addAction() {
	    $this->_view->_title   =   'User Manager: User Groups : Add';
	    $this->_view->render('group/add', true);
	}
	
	// PROCESS AJAX STATUS
	public function ajaxStatusAction() {
	     $result   		=	   	$this->_model->changeStatus($this->_arrParam, array('task' => 'change-ajax-status'));
	     echo json_encode($result);
	}
	
	// PROCESS AJAX GROUP ACP
	public function ajaxGroupACPAction() {
		$result 		=		$this->_model->changeStatus($this->_arrParam, array('task'	=>	'change-ajax-group-acp'));
		echo json_encode($result);
	}
	
	// ACTION STATUS
	public function statusAction() {
		$this->_model->changeStatus($this->_arrParam, array('task' 	=>	'change-status'));
		URL::redirect(URL::createLink('admin', 'group', 'index'));
	}
	
	// ACTION TRASH
	public function trashAction() {
		$this->_model->deleteItem($this->_arrParam);
		URL::redirect(URL::createLink('admin', 'group', 'index'));
	}
}