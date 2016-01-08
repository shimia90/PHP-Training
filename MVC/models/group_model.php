<?php
class Group_Model extends Model {
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->setTable('user');
    }
    
    public function listItem($options = null) {
        $query[] 	= "SELECT * FROM `user`";
        $query		= implode(" ", $query);
        
        $result		= $this->listRecord($query);
        return $result;
    }
    
    public function deleteItem($id, $options = null) {
        $this->delete(array($id));
    }
}