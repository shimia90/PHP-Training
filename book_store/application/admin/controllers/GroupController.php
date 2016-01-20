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
}