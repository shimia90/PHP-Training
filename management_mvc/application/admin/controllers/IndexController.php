<?php
class IndexController extends Controller{
	public function __construct(){
	
	}
	
	public function indexAction(){
	}
	
	public function addAction(){
		echo '<h3>' . __METHOD__ . '</h3>';
		$this->_view->render('index/index');
	}
}