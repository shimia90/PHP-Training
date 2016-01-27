<?php
class GroupModel extends Model{
    
	/**/
    public function __construct() {
        parent::__construct();
        $this->setTable(TBL_GROUP);
    }
    
	/**/
	public function listItems($arrParam, $option = null) {
		$query[]  		=   "SELECT `id`, `name`, `group_acp`, `ordering`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`";
		$query[]  		=   "FROM `$this->table`";
		if(!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])) {
			$column 	=	$arrParam['filter_column'];
			$columnDir 	=	$arrParam['filter_column_dir'];
			$query[] 	=	"ORDER BY `{$column}` {$columnDir}";
		} else {
			$query[] 	=	"ORDER BY `name` ASC";
		}
		$query  		=   implode(" ", $query);
		$result   		=   $this->listRecord($query);
		return $result;
	}
	
	/**/
	public function changeStatus($arrayParam, $option = null) {
	    if($option['task'] == 'change-ajax-status') {
	        $status    =   ($arrayParam['status'] == 0) ? 1 : 0;
	        $id        =   $arrayParam['id'];
	        $query     =   "UPDATE `{$this->table}` SET `status` = {$status} WHERE `id` = {$id}";
	        $this->query($query);
	        
	        return array($id, $status, URL::createLink('admin', 'group', 'ajaxStatus', array('id' => $id, 'status' => $status)));
	    }
		
		if($option['task'] == 'change-ajax-group-acp') {
	        $group_acp    =   ($arrayParam['group_acp'] == 0) ? 1 : 0;
	        $id        =   $arrayParam['id'];
	        $query     =   "UPDATE `{$this->table}` SET `group_acp` = {$group_acp} WHERE `id` = {$id}";
	        $this->query($query);
	        
	        return array($id, $group_acp, URL::createLink('admin', 'group', 'ajaxGroupACP', array('id' => $id, 'group_acp' => $group_acp)));
	    }
		
		if($option['task'] == 'change-status') {
	        $status    =   $arrayParam['type'];
	        if(!empty($arrayParam['cid'])) {
				$ids 		=	$this->createWhereDeleteSQL($arrayParam['cid']);
				$query     	=   "UPDATE `{$this->table}` SET `status` = {$status} WHERE `id` IN ({$ids})";
	        	$this->query($query);	
			}
	    }
	}
	
	/**/
	public function deleteItem($arrayParam, $option = null) {
		if($option == null) {
	        if(!empty($arrayParam['cid'])) {
				$ids 		=	$this->createWhereDeleteSQL($arrayParam['cid']);
				$query     	=   "DELETE FROM `{$this->table}` WHERE `id` IN ({$ids})";
	        	$this->query($query);	
			}
	    }
	}
}