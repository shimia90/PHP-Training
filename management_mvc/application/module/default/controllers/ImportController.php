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
	    $this->_view->_title       			=   	'Personal Management';
	    $totalItems = $this->_model->countItem($this->_arrParam, null);
	    
	    $configPagination          			=   	array('totalItemsPerPage'  =>  5, 'pageRange'  =>  2);
	    $this->setPagination($configPagination);
	    
	    $this->_view->pagination   			=   	new Pagination($totalItems, $this->_pagination);    
	    //$this->_view->Items    				= 		$this->_model->listItems($this->_arrParam, null);
		
		// Process Maintenance Data
		//$this->_view->arrayMaintenance 		= 		$this->_model->processMaintenance();
		
		// Process Newton Data
		//$this->_view->arrayNewtonDetail 	=		$this->_model->processNewtonDetail();
		//$this->_view->arrayNewton 			=		$this->_model->processNewton();
		
		// Process Newcoding Detail
		//$this->_view->arrayNewCodingDetail 	=		$this->_model->processNewCodingDetail();
		//$this->_view->arrayNewCoding 			=		$this->_model->processNewCoding();
		
		// Process Domestic Data
		//$this->_view->arrayDomestic 			=		$this->_model->processDomestic();
		
		// Process FC Data
		//$this->_view->arrayFcDetail 			=		$this->_model->processFcDetail();
		//$this->_view->arrayFc 					=		$this->_model->processFc();
		
		// Process Other
		//$this->_view->arrayOther 				=		$this->_model->processOther();
		
		// Process Research
		//$this->_view->arrayResearch 			=		$this->_model->processResearch();
		
		// Process Worktime
		//$this->_view->arrayWorktime 			=		$this->_model->processWorkTime();
		
		$this->_model->importMaintenance();
		$this->_model->importNewton();
		$this->_model->importDomestic();
		$this->_model->importFC();
		$this->_model->importOther();
		$this->_model->importResearch();
		$this->_model->importNewCoding();
		$this->_model->importWorkTime(); 
		
		$this->_view->render('import/index', true);
	}
}