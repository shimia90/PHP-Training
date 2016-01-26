<?php
class PersonalModel extends Model{
    
    public function __construct() {
        parent::__construct();
        $this->setTable(USER);
    }
    
	public function listItems($arrParam, $option) {
		$query[]      =   "SELECT `id`, `name`, `group_acp`, `ordering`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`";
		$query[]      =   "FROM `$this->table`";
		$query        =   implode(" ", $query);
		
		$result       =   $this->listRecord($query);
		return $result;
	}
	
	public function listUsers($arrParam, $option) {
	    $query[]      =   "SELECT * ";
	    $query[]      =   "FROM `$this->table`";
	    $query      =   implode(" ", $query);
	    
	    $result       =   $this->listRecord($query);
	    return $result;
	    
	}
	       
}