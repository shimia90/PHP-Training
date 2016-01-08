<?php
class Error extends Controller {
    
    /* public function __construct() {
        echo '<h3>This is an error</h3>';
    } */
    
    public function index() {
        
        $this->view->msg = 'This is an error';
        $this->view->render('error/index');
    }
    
    public function add() {
        echo '<h3>'. __METHOD__ .'</h3>';
    }
    
}