<?php
class TeamController extends Controller {
    
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
         $this->_view->_title       			=   	'Team Management';
         
         $this->_view->arrayTeam                =       $this->_model->listTeam();
		 
         $this->_view->render('team/index');
    }
    
    public function insertAction() {
        
       $this->_view->_title       			=   	'Team | Insert';
        
       if(isset($_POST['insertTeam'])) {
           $this->_view->_result 			=		$this->_model->processInsert($_POST['insertTeam']);
       } 
        
       $this->_view->render('team/insert', true);
    }
    
    public function deleteAction() {
        $this->_view->_title       			=   	'Delete | Team';
        $this->_view->message 				=		'';
        if (isset($_GET['id'])) {
            $this->_view->message 			=		$this->_model->processDelete($_GET['id']);
        }
        $this->_view->render('team/delete', true);
    }
    
    public function editAction() {
        $this->_view->_title       			=   	'Edit | Team';
        if(isset($_GET['id'])) {
            $this->_view->_arrayTeam 		=		$this->_model->arrayEdit($_GET['id']);
        }
    
        if(isset($_POST['editTeam']) && isset($_GET['id'])) {
            $this->_view->_result 			=		$this->_model->processEdit($_POST['editTeam'], $_GET['id']);
            URL::redirect(URL::createLink('default', 'team', 'edit', array('id' => $_GET['id'])));
        }
        $this->_view->render('team/edit', true);
    }
	
}