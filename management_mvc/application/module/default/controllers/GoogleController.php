<?php
class GoogleController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	// HIEN THI LIST GOOGLE LINK
	public function indexAction(){
	    $this->_view->_title       			=   	'Google Link Management';
	    $totalItems = $this->_model->countItem($this->_arrParam, null);
	    
	    $configPagination          			=   	array('totalItemsPerPage'  =>  5, 'pageRange'  =>  2);
	    $this->setPagination($configPagination);
		
		$this->_view->rowLink 				=		$this->_model->listGoogleLink();
	    
	    $this->_view->pagination   			=   	new Pagination($totalItems, $this->_pagination);    
	    //$this->_view->Items    				= 		$this->_model->listItems($this->_arrParam, null);
		
		$this->_view->render('google/index', true);
	}
	
	// INSERT GOOGLE LINK
	public function insertAction() {
		if(isset($_GET['type']) && $_GET['type'] == 'edit') {
			$this->_view->_title       			=   	'Edit | Google Link';	
		} else {
			$this->_view->_title       			=   	'Insert | Google Link';	
		}
		
		$this->_view->hiddenInput 			=		'';	
		$this->_view->message				=		'';
		$this->_view->arrayEdit 			=		array();
		$this->_view->postLink 				=		'';
		$this->_view->postDate				=		'';
		
		if(isset($_GET['type']) && $_GET['type'] == 'edit') {
			$this->_view->arrayEdit 	=		$this->_model->arrayEdit($_GET['idLink']);
		}
		
		if(isset($_POST['form_edit'])) {
			$this->_view->postLink  		=		$_POST['formGoogle']['google_link'];
			$this->_view->postDate  		=		$_POST['formGoogle']['google_date'];
		} else if($_GET['type'] == 'edit'){
			$this->_view->postLink  		=		@$this->_view->arrayEdit[0]['link'];
			$this->_view->postDate 			=		@$this->_view->arrayEdit[0]['link_month']. ' ' . @$this->_view->arrayEdit[0]['link_year'];
		}
		
		if(isset($_GET['type']) && $_GET['type'] == 'edit') {
			if(isset($_POST['form_edit'])&& trim($_POST['form_edit']) != '') {
				$this->_view->message 		=		$this->_model->processEdit($_POST['formGoogle'], $_POST['form_edit']);
			}
		} else {
			if(isset($_POST['formGoogle']) && !isset($_POST['form_edit']) && trim($_POST['formGoogle']['google_link']) != '' && trim($_POST['formGoogle']['google_date']) != '' && trim($_POST['formGoogle']['google_project']) !='') {
					$this->_view->message 			=		$this->_model->processInsert($_POST['formGoogle']);
			}	
		}
		
		
		if(isset($_GET['type']) && trim($_GET['type']) != '') {
			if($_GET['type'] == 'insert') {
				$this->_view->hiddenInput 			=		'<input type="hidden" name="form_insert" value="" />';
			} else if($_GET['type'] == 'edit') {
				if(isset($_GET['idLink']) && trim($_GET['idLink']) != '') {
					$this->_view->hiddenInput 			=		'<input type="hidden" name="form_edit" value="'.$_GET['idLink'].'" />';
				} else {
					$this->_view->hiddenInput 			=		'<input type="hidden" name="form_edit" value="" />';
				}
			}
		}
		$this->_view->arrayProject 		=		$this->_model->listProject();
		$this->_view->render('google/insert', true);
	}
	
	public function editAction() {
		$this->_view->render('google/edit', true);
	}
	
	public function deleteAction() {
		$this->_view->_title       			=   	'Delete | Google Link';	
		$this->_view->message 				=		'';
		if (isset($_GET['idLink'])) {
			$this->_view->message 			=		$this->_model->processDelete($_GET['idLink']);
		}
		$this->_view->render('google/delete', true);
	}
}