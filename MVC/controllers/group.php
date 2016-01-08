<?php
class Group extends Controller {
	public function __construct() {
	    parent::__construct();
	    Auth::checkLogin();
	}
	
	public function index() {

	    $this->view->items =   $this->db->listItem();
	    $this->view->js    =   array('group/js/group.js', 'group/js/jquery-ui.min.js');
	    $this->view->css   =   array('group/css/jquery-ui.min.css');
	    $this->view->title =   'Group';
	    $this->view->render('group/index');
	     
	}
	
	public function delete() {
	    if(isset($_POST['id'])) {
	        $this->db->deleteItem($_POST['id']);
	    }
	}
	
}	
?>