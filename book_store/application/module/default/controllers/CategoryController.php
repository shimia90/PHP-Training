<?php
class CategoryController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	// HIEN THI DANH SACH CATEGORY
	public function indexAction(){
	    $this->_view->_title       =   'Category List';
	    
	    $this->_view->Items    = $this->_model->listItems($this->_arrParam, null);
		$this->_view->render('category/index', true);
		
		
	}

}