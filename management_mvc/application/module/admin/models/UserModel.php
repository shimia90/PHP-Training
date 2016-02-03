<?php
class UserModel extends Model{
    
    private $_columns = array('id', 'username', 'email', 'fullname', 'password', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'group_id');
    
	/**
	 * 
	 */
    public function __construct() {
        parent::__construct();
        $this->setTable(TBL_USER);
    }
    
	/**
	 * 
	 * @param unknown $arrParam
	 * @param string $option
	 * @return multitype:unknown
	 */
	public function listItems($arrParam, $option = null) {
		$query[]  		=   "SELECT `u`.`id`, `u`.`username`, `u`.`email`, `u`.`fullname`, `u`.`created`, `u`.`created_by`, `u`.`modified`, `u`.`modified_by`, `u`.`status`, `u`.`ordering`, `g`.`name` AS `group_name`";
		$query[]  		=   "FROM `$this->table` AS `u`, `".TBL_GROUP."` AS `g`";
		$query[]        =   "WHERE `u`.`group_id` = `g`.`id`";
		
		// FILTER : KEYWORD
		if(!empty($arrParam['filter_search'])) {
		    $keyword    =   '"%' . $arrParam['filter_search'] . '%"';
		    $query[]     =   "AND (`username` LIKE {$keyword} OR `email` LIKE {$keyword})";
		}
		
		// FILTER : STATUS
		if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default') {
		    $query[]    =   "AND `u`.`status` = '{$arrParam['filter_state']}'";
		}
		
		// FILTER : GROUP ID
		if(isset($arrParam['filter_group_id']) && $arrParam['filter_group_id'] != 'default') {
		    $query[]    =   "AND `u`.`group_id` = '{$arrParam['filter_group_id']}'";
		}
		
		// SORT
		if(!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])) {
			$column 	=	$arrParam['filter_column'];
			$columnDir 	=	$arrParam['filter_column_dir'];
			$query[] 	=	"ORDER BY `u`.`{$column}` {$columnDir}";
		} else {
			$query[] 	=	"ORDER BY `u`.`id` DESC";
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
		$result   		=   $this->fetchAll($query);
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $arrayParam
	 * @param string $option
	 * @return multitype:number unknown string
	 */
	public function changeStatus($arrayParam, $option = null) {
	    if($option['task'] == 'change-ajax-status') {
	        $status    =   ($arrayParam['status'] == 0) ? 1 : 0;
	        $id        =   $arrayParam['id'];
	        $query     =   "UPDATE `{$this->table}` SET `status` = {$status} WHERE `id` = {$id}";
	        $this->query($query);
	        
			$result 	=	array(
								'id'		=>		$id,
								'status'	=>		$status,
								'link' 		=>		URL::createLink('admin', 'user', 'ajaxStatus', array('id' => $id, 'status' => $status))
							); //array($id, $status, URL::createLink('admin', 'group', 'ajaxStatus', array('id' => $id, 'status' => $status)));
	        return $result;
	    }
		
		if($option['task'] == 'change-status') {
	        $status    =   $arrayParam['type'];
	        if(!empty($arrayParam['cid'])) {
				$ids 		=	$this->createWhereDeleteSQL($arrayParam['cid']);
				$query     	=   "UPDATE `{$this->table}` SET `status` = {$status} WHERE `id` IN ({$ids})";
	        	$this->query($query);	
	        	Session::set('message', array('class' => 'success', 'content' => $this->affectedRows() . ' updated successfully'));
			} else {
			    Session::set('message', array('class' => 'error', 'content' => 'Please choose the item that you want to change status !!'));
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
	        	Session::set('message', array('class' => 'success', 'content' => $this->affectedRows() . ' items were deleted successfully'));
			} else {
			    Session::set('message', array('class' => 'error', 'content' => 'Please choose the item that you want to delete !!'));
			}
	    }
	}
	
	/**
	 * 
	 * @param unknown $arrayParam
	 * @param string $option
	 */
	public function saveItem($arrayParam, $option = null) {
	    if($option['task'] == 'add') {
	        $arrayParam['form']['created'] = date('Y-m-d', time());
	        $arrayParam['form']['created_by'] = 1;
	        $arrayParam['form']['password'] = md5($arrayParam['form']['password']);
	        $data = array_intersect_key($arrayParam['form'], array_flip($this->_columns));
	        $this->insert($data);
	        Session::set('message', array('class' => 'success', 'content' => 'Data was inserted successfully'));
	        return $this->lastID();
	    }
	    
	    if($option['task'] == 'edit') {
	        $arrayParam['form']['modified']        = date('Y-m-d', time());
	        $arrayParam['form']['modified_by']     = 10;
	        if($arrayParam['form']['password'] != null) {
	            $arrayParam['form']['password'] = md5($arrayParam['form']['password']);
	        } else {
	            unset($arrayParam['form']['password']);
	        }
	        $data = array_intersect_key($arrayParam['form'], array_flip($this->_columns));
	        $this->update($data, array(array('id', $arrayParam['form']['id'])));
	        Session::set('message', array('class' => 'success', 'content' => 'Data was inserted successfully'));
	        return $arrayParam['form']['id'];
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
    	 $query[]       =   "WHERE `id` > 0";
    	
    	 // FILTER : KEYWORD
    	 if(!empty($arrParam['filter_search'])) {
    	   $keyword     =   '"%' . $arrParam['filter_search'] . '%"';
    	   $query[]     =   "AND (`username` LIKE {$keyword} OR `email` LIKE {$keyword})";
    	 }
    	 
    	 // FILTER : GROUP ID
    	 if(isset($arrParam['filter_group_id']) && $arrParam['filter_group_id'] != 'default') {
    	     $query[]    =   "AND `group_id` = '{$arrParam['filter_group_id']}'";
    	 }
    	
    	 // FILTER : STATTUS
    	 if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default') {
    	     //$status   =   ($arrParam['filter_state'] == 'unpublish') ? 0 : 1;
    	     $query[]    =   "AND `status` = '{$arrParam['filter_state']}'";
    	   
    	 }
    	 
    	 $query  		=   implode(" ", $query);
    	 $result   		=   $this->fetchRow($query);
    	 return $result['total'];
	 }
	 
	 /**
	  * 
	  * @param unknown $arrParam
	  * @param string $option
	  */
	 public function ordering($arrParam, $option = null) {
	     $query = '';
	     if($option == null) {
	         if(!empty($arrParam['order'])) {
	             $i = 0;
	             foreach($arrParam['order'] as $id => $ordering) :
	               $i++;
	               $query     =   "UPDATE `{$this->table}` SET `ordering` = {$ordering} WHERE `id` = {$id}";
	             $this->query($query);
	             endforeach;
	             Session::set('message', array('class' => 'success', 'content' => $i . ' items were deleted successfully'));
	         }
	     }
	     
	 }
	 
	 /**
	  *
	  * @param unknown $arrayParam
	  * @param string $option
	  */
	 public function infoItem($arrayParam, $option = null) {
	     if($option == null) {
	         $query[]              =   "SELECT `id`, `username`, `email`, `fullname`, `group_id`, `status`, `ordering`";
	         $query[]              =   "FROM `$this->table`";
	         $query[]              =   "WHERE `id` = '{$arrayParam['id']}'";
	         $query                =   implode(' ', $query);
	         $result               =   $this->fetchRow($query);
	         return $result;
	     }
	 }
	 
	 public function itemInSelectBox($arrayParam, $option = null) {
	     $result       =   array();
	     if($option == null) {
	         $query    =   "SELECT `id`, `name` FROM `".TBL_GROUP."`";
	         $result   =   $this->fetchPairs($query);
	         $result['default']    =   '- Select Group -';
	         ksort($result);
	     }
	     return $result;
	 }
}