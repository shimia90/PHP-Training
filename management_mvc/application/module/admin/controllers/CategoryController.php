<?php
class CategoryController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	// HIEN THI DANH SACH GROUUP
	public function indexAction(){
	    $this->_view->_title       =   'Category Manager: List';
	    $totalItems = $this->_model->countItem($this->_arrParam, null);
	    
	    $configPagination          =   array('totalItemsPerPage'  =>  5, 'pageRange'  =>  2);
	    $this->setPagination($configPagination);
	    
	    $this->_view->pagination   =   new Pagination($totalItems, $this->_pagination);    
	    $this->_view->Items    = $this->_model->listItems($this->_arrParam, null);
		$this->_view->render('category/index', true);
		
		
	}
	
	// ACTION ADD & EDIT CATEGORY
	public function formAction() {
	    $this->_view->_title   =   'Category Manager : Add';
	    if(isset($this->_arrParam['id'])) {
	        $this->_view->_title   =   'Category Manager : Edit';
	        $this->_arrParam['form']  =   $this->_model->infoItem($this->_arrParam);
	        if(empty($this->_arrParam['form'])) URL::redirect(URL::createLink('admin', 'category', 'index'));
	    }
	    if( @$this->_arrParam['form']['token'] > 0 ) {
	        $validate  =   new Validate($this->_arrParam['form']);
	        $validate->addRule('name', 'string', array('min' => 3, 'max' => 255))
	                 ->addRule('ordering', 'int', array('min' => 1, 'max' => 100))
	                 ->addRule('status', 'status', array('deny' => array('default')));
	        $validate->run();
	        $this->_arrParam['form'] = $validate->getResult();
	        if($validate->isValid() == false) {
	            $this->_view->errors = $validate->showErrors();
	        } else {
	            echo $task    =     (isset($this->_arrParam['form']['id'])) ? 'edit' : 'add';
	            // Insert to Database
	            $id = $this->_model->saveItem($this->_arrParam, array('task' => $task));
	            $type = $this->_arrParam['type'];
	            if($type == 'save-close') URL::redirect(URL::createLink('admin', 'category', 'index'));
	            if($type == 'save-new') URL::redirect(URL::createLink('admin', 'category', 'form'));
	            if($type == 'save') URL::redirect(URL::createLink('admin', 'category', 'form', array('id' => $id)));
	        }
	    }
	    
	    $this->_view->arrParam     =   $this->_arrParam;
	    $this->_view->render('category/form', true);
	}
	
	// PROCESS AJAX STATUS (*)
	public function ajaxStatusAction() {
	     $result   		=	   	$this->_model->changeStatus($this->_arrParam, array('task' => 'change-ajax-status'));
	     echo json_encode($result);
	}
	
	// ACTION STATUS (*)
	public function statusAction() {
		$this->_model->changeStatus($this->_arrParam, array('task' 	=>	'change-status'));
		URL::redirect(URL::createLink('admin', 'category', 'index'));
	}
	
	// ACTION TRASH (*)
	public function trashAction() {
		$this->_model->deleteItem($this->_arrParam);
		URL::redirect(URL::createLink('admin', 'category', 'index'));
	}
	
	// ACTION ORDERING (*)
	public function orderingAction() {
	    $this->_model->ordering($this->_arrParam);
	    URL::redirect(URL::createLink('admin', 'category', 'index'));
	}
}