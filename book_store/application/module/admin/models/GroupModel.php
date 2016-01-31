<?php
class GroupModel extends Model{
    
	/**
	 * 
	 */
    /*public function __construct() {
        parent::__construct();
        $this->setTable(TBL_GROUP);
    }*/
    
	/**
	 * 
	 * @param unknown $arrParam
	 * @param string $option
	 * @return multitype:unknown
	 */
	public function listItems($arrParam, $option = null) {
		$query[]  		=   "SELECT `id`, `name`, `group_acp`, `ordering`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`";
		$query[]  		=   "FROM `$this->table`";
		
		// FILTER : KEYWORD
		$flagWhere     =   false;
		if(!empty($arrParam['filter_search'])) {
		    $keyword    =   '"%' . $arrParam['filter_search'] . '%"';
		    $query[]    =   "WHERE `name` LIKE {$keyword}";
		    $flagWhere     =   true;
		}
		
		// FILTER : STATTUS
		if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default') {
		    $status   =   ($arrParam['filter_state'] == 'unpublish') ? 0 : 1; 
		    if($flagWhere == true) {
		        $query[]    =   "AND `status` = '{$status}'";
		    } else {
		        $query[]    =   "WHERE `status` = '{$status}'";
		    }
		}
		
		// SORT
		if(!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])) {
			$column 	=	$arrParam['filter_column'];
			$columnDir 	=	$arrParam['filter_column_dir'];
			$query[] 	=	"ORDER BY `{$column}` {$columnDir}";
		} else {
			$query[] 	=	"ORDER BY `name` ASC";
		}
		
		// PAGINATION
		$pagination           =   $arrParam['pagination'];
		$totalItemsPerPage    =   $pagination['totalItemsPerPage'];
		$currentPage          =   $pagination['currentPage'];
		if($totalItemsPerPage > 0) {
		    $position	= ($currentPage-1)*$totalItemsPerPage;
		    $query[]	= "LIMIT $position, $totalItemsPerPage";
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
	        
			$result 	=	array(
								'id'		=>		$id,
								'status'	=>		$status,
								'link' 		=>		URL::createLink('admin', 'group', 'ajaxStatus', array('id' => $id, 'status' => $status))
							); //array($id, $status, URL::createLink('admin', 'group', 'ajaxStatus', array('id' => $id, 'status' => $status)));
	        return $result;
	    }
		
		if($option['task'] == 'change-ajax-group-acp') {
	        $group_acp    =   ($arrayParam['group_acp'] == 0) ? 1 : 0;
	        $id        =   $arrayParam['id'];
	        $query     =   "UPDATE `{$this->table}` SET `group_acp` = {$group_acp} WHERE `id` = {$id}";
	        $this->query($query);
	        
	        $result 	=	array(
								'id'		=>		$id,
								'group_acp'	=>		$group_acp,
								'link'		=>		 URL::createLink('admin', 'group', 'ajaxGroupACP', array('id' => $id, 'group_acp' => $group_acp))
							);// return array($id, $group_acp, URL::createLink('admin', 'group', 'ajaxGroupACP', array('id' => $id, 'group_acp' => $group_acp)));
			return $result;
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
	
	/**
	 * 
	 * @param unknown $arrayParam
	 * @param string $option
	 */
	public function deleteItem($arrayParam, $option = null) {
		if($option == null) {
	        if(!empty($arrayParam['cid'])) {
				$ids 		=	$this->createWhereDeleteSQL($arrayParam['cid']);
				$query     	=   "DELETE FROM `{$this->table}` WHERE `id` IN ({$ids})";
	        	$this->query($query);	
			}
	    }
	}
	
	/**
	 * 
	 * @param unknown $arrParam
	 * @param string $option
	 * @return Ambigous <>
	 */
	public function countItem($arrParam, $option = null) {
    	 $query[]  		=   "SELECT COUNT(`id`) AS `total`";
    	 $query[]  		=   "FROM `$this->table`";
    	
    	 // FILTER : KEYWORD
    	 $flagWhere     =   false;
    	 if(!empty($arrParam['filter_search'])) {
    	   $keyword     =   '"%' . $arrParam['filter_search'] . '%"';
    	   $query[]     =   "WHERE `name` LIKE {$keyword}";
    	   $flagWhere     =   true;
    	 }
    	
    	 // FILTER : STATTUS
    	 if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default') {
    	     $status   =   ($arrParam['filter_state'] == 'unpublish') ? 0 : 1;
    	     if($flagWhere == true) {
    	         $query[]    =   "AND `status` = '{$status}'";
    	     } else {
    	         $query[]    =   "WHERE `status` = '{$status}'";
    	     }
    	   
    	 }
    	
    	 $query  		=   implode(" ", $query);
    	 $result   		=   $this->singleRecord($query);
    	 return $result['total'];
	 }
	 
	 public function ordering($arrParam, $option = null) {
	     if($option == null) {
	         if(!empty($arrParam['order'])) {
	             foreach($arrParam['order'] as $id => $ordering) :
	               $query     =   "UPDATE `{$this->table}` SET `ordering` = {$ordering} WHERE `id` = {$id}";
	               $this->query($query);
	             endforeach;
	         }
	     }
	     
	 }
}