<?php
class BookController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	// HIEN THI DANH SACH BOOK
	public function indexAction(){
	    $this->_view->_title           =   'Book Manager: List';
	    $totalItems = $this->_model->countItem($this->_arrParam, null);
	    
	    $configPagination              =   array('totalItemsPerPage'  =>  5, 'pageRange'  =>  2);
	    $this->setPagination($configPagination);
	    
	    $this->_view->pagination       =   new Pagination($totalItems, $this->_pagination);    
	    
	    $this->_view->slbCategory      =   $this->_model->itemInSelectBox($this->_arrParam);
	    $this->_view->Items            =   $this->_model->listItems($this->_arrParam, null);
		$this->_view->render('book/index', true);
		
		
	}
	
	// ACTION ADD & EDIT BOOK
	public function formAction() {
	    $this->_view->_title   =   'Book : Add';
	    $this->_view->slbGroup     =   $this->_model->itemInSelectBox($this->_arrParam);
	    if(isset($this->_arrParam['id'])) {
	        $this->_view->_title   =   'Book : Edit';
	        $this->_arrParam['form']  =   $this->_model->infoItem($this->_arrParam);
	        if(empty($this->_arrParam['form'])) URL::redirect('admin', 'book', 'index');
	    }
	    if( @$this->_arrParam['form']['token'] > 0 ) {
	        $task              =       'add';
	        
	        if(isset($this->_arrParam['form']['id'])) {
	            $task              =       'edit';
	            
	        }
	        $validate  =   new Validate($this->_arrParam['form']);
	        
	        $validate->addRule('name', 'string', array('min' => 1, 'max' => 255))
	                 ->addRule('ordering', 'int', array('min' => 1, 'max' => 100))
	                 ->addRule('status', 'status', array('deny' => array('default')))
	                 ->addRule('group_id', 'status', array('deny' => array('default')));
	        $validate->run();
	        $this->_arrParam['form'] = $validate->getResult();
	        if($validate->isValid() == false) {
	            $this->_view->errors = $validate->showErrors();
	        } else {
	            $task    =     (isset($this->_arrParam['form']['id'])) ? 'edit' : 'add';
	            // Insert to Database
	            $id = $this->_model->saveItem($this->_arrParam, array('task' => $task));
	            $type = $this->_arrParam['type'];
	            if($type == 'save-close') URL::redirect('admin', 'user', 'index');
	            if($type == 'save-new') URL::redirect('admin', 'user', 'form');
	            if($type == 'save') URL::redirect('admin', 'user', 'form', array('id' => $id));
	        }
	    }
	    
	    $this->_view->arrParam     =   $this->_arrParam;
	    $this->_view->render('user/form', true);
	}
	
	// PROCESS AJAX STATUS (*)
	public function ajaxStatusAction() {
	     $result   		=	   	$this->_model->changeStatus($this->_arrParam, array('task' => 'change-ajax-status'));
	     echo json_encode($result);
	}
	
	// ACTION STATUS (*)
	public function statusAction() {
		$this->_model->changeStatus($this->_arrParam, array('task' 	=>	'change-status'));
		URL::redirect('admin', 'book', 'index');
	}
	
	// ACTION TRASH (*)
	public function trashAction() {
		$this->_model->deleteItem($this->_arrParam);
		URL::redirect('admin', 'book', 'index');
	}
	
	// ACTION ORDERING (*)
	public function orderingAction() {
	    $this->_model->ordering($this->_arrParam);
	    URL::redirect('admin', 'book', 'index');
	}
}