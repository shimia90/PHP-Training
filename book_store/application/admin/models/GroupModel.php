<?php
class GroupModel extends Model{
    
    public function __construct() {
        parent::__construct();
        $this->setTable(TBL_GROUP);
    }
    
	public function listItems($arrParam, $option) {
		$query[]  =   "SELECT `id`, `name`, `group_acp`, `ordering`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`";
		$query[]  =   "FROM `$this->table`";
		$query  =   implode(" ", $query);
		
		$result   =   $this->listRecord($query);
		return $result;
	}
}