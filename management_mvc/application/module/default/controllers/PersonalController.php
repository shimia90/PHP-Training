<?php
class PersonalController extends Controller{
	
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
		
		$today          = 	date("d/m/Y");
		if(isset($_POST['date_from']) && isset($_POST['user_name']) && isset($_POST['date_to']) && trim($_POST['date_from']) != '' && trim($_POST['date_to']) != '' && trim($_POST['user_name']) != '') {
			$this->_view->arrayWork 		= 	$this->_model->processDateRange();
			$this->_view->htmlWorkTime  	=	$this->_model->createWorkTime($_POST['user_name'], $_POST['date_from'], $_POST['date_to'], $this->_model->processDateRange());
			// Create Timeline
			$this->_view->htmlTimeline 		=	$this->_model->createTimeline($this->_model->processDateRange(), $_POST['user_name'], $_POST['date_from'], $_POST['date_to']);
			// Create Chart
			$this->_view->htmlHighChart 	=	$this->_model->createHighChart($_POST['user_name'], $_POST['date_from'], $_POST['date_to']);
		}
		
		if(isset($_POST['date_all_from']) && isset($_POST['date_all_to']) && trim($_POST['date_all_from']) != '' && trim($_POST['date_all_to']) != '') {
			$this->_view->arrayWork = $this->_model->processDateAllRange();
		}
		
		$this->_view->selectFilter  = $this->_model->createSelectFilter(@$_POST['filter_project']);
		
		//
		//$dateFrom 		=	(isset($_POST['date_from'])) ? $_POST['date_from'] : $today;
		//$dateTo 		=	(isset($_POST['date_to'])) ? $_POST['date_to'] : $today;
		
		$dateFrom 		=	(isset($_POST['date_all_from'])) ? $_POST['date_all_from'] : ((isset($_POST['date_from'])) ? $_POST['date_from'] : $today);
		$dateTo 		=	(isset($_POST['date_all_to'])) ? $_POST['date_all_to'] : ((isset($_POST['date_to'])) ? $_POST['date_to'] : $today);
		$this->_view->searchForm 		=	'<form action="'.URL::createLink('default', 'personal', 'index').'" method="post" id="user_form" class="form-inline mb_10">
												<div class="form-group"><label>Name:</label>
													'.$this->_model->createSelectUser('user_select', '1', 'user_name', @$_POST['user_name']).'
												</div>
												<div class="form-group"><label>
													From </label><span id="two-inputs"><input id="date-range200" size="20" name="date_from" value="'.$dateFrom.'"> <label>To</label> <input id="date-range201" size="20" name="date_to" value="'.$dateTo.'"></span>
												</div>
												<input type="hidden" name="type" value="single" />
                                                <input type="hidden" name="page_submit" value="record" />
												<button class="btn btn-default" type="submit"><i class="fa  fa-search"></i> Search</button>
											</form>';
		
		if(isset($_POST['date_all_from']) && isset($_POST['date_all_to']) && trim($_POST['date_all_from']) != '' && trim($_POST['date_all_to'])) :
			$this->_view->tableHead	 	= 	'<th class="text-center">Designer</th>';
		else :
			$this->_view->tableHead 	= 	'';
		endif;
		
		$this->_view->arrayUser 		=	$this->_model->listUser();
		
		if(isset($_POST['date_from']) && isset($_POST['user_name']) && isset($_POST['date_to']) && trim($_POST['date_from']) != '' && trim($_POST['date_to']) != '' && trim($_POST['user_name']) != '') {
			
		}
	    
	    $this->_view->pagination   =   new Pagination($totalItems, $this->_pagination);    
	    $this->_view->Items    = $this->_model->listItems($this->_arrParam, null);
		$this->_view->render('personal/index', true);
	}
	
	// ACTION ADD & EDIT GROUP
	public function formAction() {
	    $this->_view->_title   =   'User Groups : Add';
	    if(isset($this->_arrParam['id'])) {
	        $this->_view->_title   =   'User Groups : Edit';
	        $this->_arrParam['form']  =   $this->_model->infoItem($this->_arrParam);
	        if(empty($this->_arrParam['form'])) URL::redirect(URL::createLink('admin', 'group', 'index'));
	    }
	    if( @$this->_arrParam['form']['token'] > 0 ) {
	        $validate  =   new Validate($this->_arrParam['form']);
	        $validate->addRule('name', 'string', array('min' => 3, 'max' => 255))
	                 ->addRule('ordering', 'int', array('min' => 1, 'max' => 100))
	                 ->addRule('status', 'status', array('deny' => array('default')))
	                 ->addRule('group_acp', 'status', array('deny' => array('default')));
	        $validate->run();
	        $this->_arrParam['form'] = $validate->getResult();
	        if($validate->isValid() == false) {
	            $this->_view->errors = $validate->showErrors();
	        } else {
	            echo $task    =     (isset($this->_arrParam['form']['id'])) ? 'edit' : 'add';
	            // Insert to Database
	            $id = $this->_model->saveItem($this->_arrParam, array('task' => $task));
	            $type = $this->_arrParam['type'];
	            if($type == 'save-close') URL::redirect(URL::createLink('admin', 'group', 'index'));
	            if($type == 'save-new') URL::redirect(URL::createLink('admin', 'group', 'form'));
	            if($type == 'save') URL::redirect(URL::createLink('admin', 'group', 'form', array('id' => $id)));
	        }
	    }
	    
	    $this->_view->arrParam     =   $this->_arrParam;
	    $this->_view->render('group/form', true);
	}
	
	// PROCESS AJAX STATUS (*)
	public function ajaxStatusAction() {
	     $result   		=	   	$this->_model->changeStatus($this->_arrParam, array('task' => 'change-ajax-status'));
	     echo json_encode($result);
	}
	
	// PROCESS AJAX GROUP ACP (*)
	public function ajaxGroupACPAction() {
		$result 		=		$this->_model->changeStatus($this->_arrParam, array('task'	=>	'change-ajax-group-acp'));
		echo json_encode($result);
	}
	
	// ACTION STATUS (*)
	public function statusAction() {
		$this->_model->changeStatus($this->_arrParam, array('task' 	=>	'change-status'));
		URL::redirect(URL::createLink('admin', 'group', 'index'));
	}
	
	// ACTION TRASH (*)
	public function trashAction() {
		$this->_model->deleteItem($this->_arrParam);
		URL::redirect(URL::createLink('admin', 'group', 'index'));
	}
	
	// ACTION ORDERING (*)
	public function orderingAction() {
	    $this->_model->ordering($this->_arrParam);
	    URL::redirect(URL::createLink('admin', 'group', 'index'));
	}
}