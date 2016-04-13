<?php
class GroupController extends Controller {
    
    /**
     * 
     */
    public function __construct($arrayParams) {
        parent::__construct($arrayParams);
        $this->_templateObj->setFolderTemplate('default/main/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }
    
    /**
     * 
     */
    public function indexAction() {
         $this->_view->_title       			=   	'Group Management';
		 
         $this->_view->render('group/index');
    }
	
	public function internalAction() {
         $this->_view->_title       			=   	'Internal Group Management';
		 
		 
		 
		 if(isset($_GET['team']) && trim($_GET['team']) != '') {
			 if(isset($_POST['group_form']) && !empty($_POST['group_form'])) {
				 $this->_view->colUser 			=		$this->_model->listTeamUser($_GET['team'], $_POST['group_form']); 
			 } else if(!isset($_GET['date_from']) && !isset($_GET['date_to'])) {
			 	 $arrayDefault 		=		array('date_from' => date("d/m/Y"), 'date_to' => date("d/m/Y"));
		 
				 $this->_view->colUser 			=		$this->_model->listTeamUser($_GET['team'], $arrayDefault); 
						 
				 $this->_view->duration 		=		$this->_model->getDuration('2', $arrayDefault, 'standard_duration');
					 
				 $this->_view->chart 			=		$this->_model->createChart($_GET['team'], $arrayDefault); 
			 } else if(isset($_GET['date_from']) && isset($_GET['date_to'])) {
				 $arrayDate 	=		array('date_from' => $_GET['date_from'], 'date_to' => $_GET['date_to']);
				 
				 $this->_view->colUser 			=		$this->_model->listTeamUser($_GET['team'], $arrayDate); 
				 
				 $this->_view->duration 				=		$this->_model->getDuration('2', $arrayDate, 'standard_duration');
			 
				 $this->_view->chart 				=		$this->_model->createChart($_GET['team'], $arrayDate); 
			 } else {

				 $this->_view->colUser 			=		$this->_model->listTeamUser($_GET['team']); 
			 }
			 
		 } else {
			URL::redirect(URL::createLink('default', 'index', 'index')); 
		 }
		 
		 // CREATE CHART
		 if(isset($_POST['group_form'])) {
			$this->_view->duration 				=		$this->_model->getDuration('2', $_POST['group_form'], 'standard_duration');
		 
		 	$this->_view->chart 				=		$this->_model->createChart($_GET['team'], $_POST['group_form']); 
			
		 }
		 
		 
         $this->_view->render('group/internal');
    }
    
    public function externalAction() {
         $this->_view->_title       			=   	'External Group Management';

		 if(isset($_POST['group_form']) && !empty($_POST['group_form'])) {
			 
			 $this->_view->tableGroup 				=		$this->_model->createTableGroup($_POST['group_form']);
		 } else {
			$arrayDefault 						=		array('date_from' => date("d/m/Y"), 'date_to' => date("d/m/Y"));
			
			$this->_view->tableGroup 			=		$this->_model->createTableGroup($arrayDefault); 
		 }
         $this->_view->render('group/external');
    }
}