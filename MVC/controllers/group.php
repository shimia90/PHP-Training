<?php
class Group extends Controller {
	public function __construct() {
	    parent::__construct();
	    Session::init();
	    if(Session::get('loggedIn') == false) {
	        $this->redirect('user', 'login');
	    }
	}
	
	public function index() {
	    $this->view->render('group/index');
	}
	
}	
?>