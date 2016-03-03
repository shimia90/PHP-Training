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
			 } else {
				$this->_view->colUser 			=		$this->_model->listTeamUser($_GET['team']); 
			 }
		 } else {
			URL::redirect(URL::createLink('default', 'index', 'index')); 
		 }
		 
         $this->_view->render('group/internal');
    }
    
    public function externalAction() {
         $this->_view->_title       			=   	'External Group Management';
		 
         $this->_view->render('group/external');
    }
}