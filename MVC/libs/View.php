<?php
class View {
    
    /**
     * 
     */
    public function __construct() {
         
    }
    
    /**
     * 
     */
    public function render($name, $full = true) {
        if($full == true) {
            include_once VIEW_PATH . 'header.php';
            require_once VIEW_PATH . $name . '.php';
            include_once VIEW_PATH . 'footer.php';
        } else {
            require_once VIEW_PATH . $name . '.php';
        }
        
        
    }
    
}