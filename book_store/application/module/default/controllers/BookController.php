<?php
class BookController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	// HIEN THI DANH SACH CATEGORY
	public function listAction(){
	    $this->_view->_title           =   'List Book';
	    
	    $this->_view->categoryName     =    $this->_model->infoItem($this->_arrParam, array('task' => 'get-cat-name'));
	    $this->_view->Items            =    $this->_model->listItems($this->_arrParam, array('task' => 'books-in-cat'));
	    
		$this->_view->render('book/list', true);
		
		
		
	}
	
	public function detailAction() {
	    $this->_view->_title           =   'Detail Book';
	    
	    $this->_view->render('book/detail', true);
	}
	

}