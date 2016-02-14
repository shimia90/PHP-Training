<?php
class ImportController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	// HIEN THI DANH SACH GROUUP
	public function indexAction(){
	    $this->_view->_title       =   'Personal Management';
	    $totalItems = $this->_model->countItem($this->_arrParam, null);
	    
	    $configPagination          =   array('totalItemsPerPage'  =>  5, 'pageRange'  =>  2);
	    $this->setPagination($configPagination);
	    
	    $this->_view->pagination   =   new Pagination($totalItems, $this->_pagination);    
	    $this->_view->Items    = $this->_model->listItems($this->_arrParam, null);
		$this->_view->render('import/index', true);
	}
}