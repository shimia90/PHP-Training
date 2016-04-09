<?php
class CategoryModel extends Model{
    
    private $_columns 		= 		array('id', 'name', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering');
	
	private $_userInfo 		=		array();
    
	/**
	 * 
	 */
    public function __construct() {
        parent::__construct();
        $this->setTable(TBL_CATEGORY);
		
		$userObj 			=		Session::get('user');
		$this->_userInfo 	=		$userObj['info'];
    }
    
	/**
	 * 
	 * @param unknown $arrParam
	 * @param string $option
	 * @return multitype:unknown
	 */
	public function listItems($arrParam, $option = null) {
		$query[]  		=   "SELECT `id`, `name`, `picture`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`";
		$query[]  		=   "FROM `$this->table`";
		//$query[]        =   "WHERE `id` > 0";
		
		// FILTER : KEYWORD
		if(!empty($arrParam['filter_search'])) {
		    $keyword    =   '"%' . $arrParam['filter_search'] . '%"';
		    $query[]    =   "WHERE `name` LIKE {$keyword}";
		}
		
		// FILTER : STATTUS
		if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default') {
		    $query[]    =   "AND `status` = '{$arrParam['filter_state']}'";
		}
		
		// SORT
		if(!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])) {
			$column 	=	$arrParam['filter_column'];
			$columnDir 	=	$arrParam['filter_column_dir'];
			$query[] 	=	"ORDER BY `{$column}` {$columnDir}";
		} else {
			$query[] 	=	"ORDER BY `id` DESC";
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
	
	
	public function changeStatus($arrayParam, $option = null) {
	    if($option['task'] == 'change-ajax-status') {
	        $status    		=   ($arrayParam['status'] == 0) ? 1 : 0;
			$modified 		= 	date('Y-m-d', time());
			$modified_by 	= 	$this->_userInfo	['username'];
	        $id        		=   $arrayParam['id'];
	        $query     		=   "UPDATE `{$this->table}` SET `status` = {$status}, `modified` = '{$modified}', `modified_by` = '{$modified_by}' WHERE `id` = {$id}";
	        $this->query($query);
	        
			$result 	=	array(
								'id'		=>		$id,
								'status'	=>		$status,
								'link' 		=>		URL::createLink('admin', 'category', 'ajaxStatus', array('id' => $id, 'status' => $status))
							); //array($id, $status, URL::createLink('admin', 'group', 'ajaxStatus', array('id' => $id, 'status' => $status)));
	        return $result;
	    }
		    
		
		if($option['task'] == 'change-status') {
	        $status    =   $arrayParam['type'];
			$modified 		= 	date('Y-m-d', time());
			$modified_by 	= 	$this->_userInfo['username'];
	        if(!empty($arrayParam['cid'])) {
				$ids 		=	$this->createWhereDeleteSQL($arrayParam['cid']);
				$query     	=   "UPDATE `{$this->table}` SET `status` = {$status}, `modified` = '{$modified}', `modified_by` = '{$modified_by}' WHERE `id` IN ({$ids})";
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
				//$query     	=   "DELETE FROM `{$this->table}` WHERE `id` IN ({$ids})";
	        	//$this->query($query);	
				
				// Remove Image
				$query 		=	"SELECT `id`, `picture` AS `name` FROM `{$this->table}` WHERE `id` IN ($ids)";
				$arrImage 	=	$this->fetchPairs($query);
				
				require_once LIBRARY_EXT_PATH . 'Upload.php';
				$uploadObj 	=	new Upload();
				foreach($arrImage as $value) {
					$uploadObj->removeFile('category', $value);	
					$uploadObj->removeFile('category', '60x90-' . $value);
				}
				
				// DELETE FROM DATABASE
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
		$userObj 				=			Session::get('user');
		$userInfo 				=			$userObj['info'];
		require_once LIBRARY_EXT_PATH . 'Upload.php';
		$uploadObj 	=	new Upload();
		
	    if($option['task'] == 'add') {
			
			

			$arrayParam['form']['picture'] 		=		$uploadObj->uploadFile($arrayParam['form']['picture'], 'category');
	        $arrayParam['form']['created'] 		= 		date('Y-m-d', time());
	        $arrayParam['form']['created_by'] 	= 		$this->_userInfo['username'];
	        $data = array_intersect_key($arrayParam['form'], array_flip($this->_columns));
			
	        $this->insert($data);
	        Session::set('message', array('class' => 'success', 'content' => 'Data was inserted successfully'));
	        return $this->lastID();
	    }
	    
	    if($option['task'] == 'edit') {
	        $arrayParam['form']['modified']        = date('Y-m-d', time());
	        $arrayParam['form']['modified_by']     = $this->_userInfo['username'];
			
			if($arrayParam['form']['picture']['name'] == null) {
				unset($arrayParam['form']['picture']);	
			} else {
				$uploadObj->removeFile('category', $arrayParam['form']['picture_hidden']);	
				$uploadObj->removeFile('category', '60x90-' . $arrayParam['form']['picture_hidden']);
				$arrayParam['form']['picture'] 		=		$uploadObj->uploadFile($arrayParam['form']['picture'], 'category');
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
    	   $query[]     =   "AND `name` LIKE {$keyword}";
    	 }
    	
    	 // FILTER : STATTUS
    	 if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default') {
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
	         $query[]  =   "SELECT `id`, `name`, `picture`, `status`, `ordering`";
	         $query[]  =   "FROM `$this->table`";
	         $query[]  =   "WHERE `id` = '{$arrayParam['id']}'";
	         $query    =   implode(' ', $query);
	         $result   =   $this->fetchRow($query);
	         return $result;
	     }
	 }
}