<?php
class UserController extends Controller {
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        
    }
    
    /**
     * 
     */
    public function indexAction() {
         $this->getModel('admin', 'index');
         $this->_view->data = array('PHP', 'Joomla');
         $this->_view->render('user/index');
    }
    
    /**
     *
     */
    public function addAction() {
        echo '<h3>'. __METHOD__ . '</h3>';
    }
}