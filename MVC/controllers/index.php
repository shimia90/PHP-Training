<?php
class Index extends Controller {
	
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        Session::init();
    }
    
	public function index() {
	    $this->view->render('index/index');
	}
	
}	
?>