<?php
class BookModel extends Model{
    
    private $_columns = array('id', 'name', 'description', 'price', 'sale_off', 'picture' , 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'category_id');
    private $_userinfo;
    
	/**
	 * 
	 */
    public function __construct() {
        parent::__construct();
        $this->setTable(TBL_BOOK);
    }
    
	/**
	 * 
	 * @param unknown $arrParam
	 * @param string $option
	 * @return multitype:unknown
	 */
	public function listItems($arrParam, $option = null) {
		$query[]  		=   "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`price`, `b`.`sale_off`, `b`.`created`, `b`.`created_by`, `b`.`modified`, `b`.`modified_by`, `b`.`status`, `b`.`special`, `b`.`ordering`, `c`.`name` AS `category_name`";
		$query[]  		=   "FROM `$this->table` AS `b` LEFT JOIN `".TBL_CATEGORY."` AS `c` ON `b`.`category_id` = `c`.`id`";
		$query[]        =   "WHERE `b`.`id` > 0";
		
		// FILTER : KEYWORD
		if(!empty($arrParam['filter_search'])) {
		    $keyword    =   '"%' . $arrParam['filter_search'] . '%"';
		    $query[]     =   "AND (`b`.`name` LIKE {$keyword})";
		}
		
		// FILTER : STATUS
		if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default') {
		    $query[]    =   "AND `b`.`status` = '{$arrParam['filter_state']}'";
		}
		
		// FILTER : SPECIAL
		if(isset($arrParam['filter_special']) && $arrParam['filter_special'] != 'default') {
		    $query[]    =   "AND `b`.`special` = '{$arrParam['filter_special']}'";
		}
		
		// FILTER : CATEGORY ID
		if(isset($arrParam['filter_category_id']) && $arrParam['filter_category_id'] != 'default') {
		    $query[]    =   "AND `b`.`category_id` = '{$arrParam['filter_category_id']}'";
		}
		
		// SORT
		if(!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])) {
			$column 	=	$arrParam['filter_column'];
			$columnDir 	=	$arrParam['filter_column_dir'];
			$query[] 	=	"ORDER BY `b`.`{$column}` {$columnDir}";
		} else {
			$query[] 	=	"ORDER BY `b`.`id` DESC";
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
	        $status        =   ($arrayParam['status'] == 0) ? 1 : 0;
	        $modified_by   =   $this->_userinfo['username'];
	        $modified      =   date('Y-m-d', time());
	        $id            =   $arrayParam['id'];
	        $query         =   "UPDATE `{$this->table}` SET `status` = {$status} WHERE `id` = {$id}";
	        $this->query($query);
	        
			$result 	=	array(
								'id'		=>		$id,
								'status'	=>		$status,
								'link' 		=>		URL::createLink('admin', 'book', 'ajaxStatus', array('id' => $id, 'status' => $status))
							); //array($id, $status, URL::createLink('admin', 'group', 'ajaxStatus', array('id' => $id, 'status' => $status)));
	        return $result;
	    }
	    
	    if($option['task'] == 'change-ajax-special') {
	        $special        =   ($arrayParam['special'] == 0) ? 1 : 0;
	        $modified_by   =   $this->_userinfo['username'];
	        $modified      =   date('Y-m-d', time());
	        $id            =   $arrayParam['id'];
	        $query         =   "UPDATE `{$this->table}` SET `special` = {$special} WHERE `id` = {$id}";
	        $this->query($query);
	         
	        $result 	=	array(
	            'id'		=>		$id,
	            'special'	=>		$special,
	            'link' 		=>		URL::createLink('admin', 'book', 'ajaxSpecial', array('id' => $id, 'special' => $special))
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
	    require_once LIBRARY_EXT_PATH . 'Upload.php';
	    $uploadObj 	=	new Upload();
	    if($option['task'] == 'add') {
	        $arrayParam['form']['picture'] 		   =		   $uploadObj->uploadFile($arrayParam['form']['picture'], 'book' , 98, 150);
	        $arrayParam['form']['created']         =           date('Y-m-d', time());
	        $arrayParam['form']['created_by']      =           1;
	        $arrayParam['form']['description']     =           mysqli_real_escape_string($this->connect, $arrayParam['form']['description']);
	        $arrayParam['form']['name']            =           mysqli_real_escape_string($this->connect, $arrayParam['form']['name']);

	        $data = array_intersect_key($arrayParam['form'], array_flip($this->_columns));
	        $this->insert($data);
	        Session::set('message', array('class' => 'success', 'content' => 'Data was inserted successfully'));
	        return $this->lastID();
	    }
	    
	    if($option['task'] == 'edit') {
			// Khong cho thay doi username
			unset($arrayParam['form']['username']);
			
	        $arrayParam['form']['modified']        = date('Y-m-d', time());
	        $arrayParam['form']['modified_by']     = 10;
	        $arrayParam['form']['description']     =           mysqli_real_escape_string($this->connect, $arrayParam['form']['description']);
	        $arrayParam['form']['name']            =           mysqli_real_escape_string($this->connect, $arrayParam['form']['name']);
	        
	        if($arrayParam['form']['picture']['name'] == null) {
	            unset($arrayParam['form']['picture']);
	        } else {
	            $uploadObj->removeFile('book', $arrayParam['form']['picture_hidden']);
	            $uploadObj->removeFile('book', '98x150-' . $arrayParam['form']['picture_hidden']);
	            $arrayParam['form']['picture'] 		=		$uploadObj->uploadFile($arrayParam['form']['picture'], 'book' , 98, 150);
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
    	 
    	 // FILTER : CATEGORY ID
    	 if(isset($arrParam['filter_category_id']) && $arrParam['filter_category_id'] != 'default') {
    	     $query[]    =   "AND `category_id` = '{$arrParam['filter_category_id']}'";
    	 }
    	
    	 // FILTER : STATTUS
    	 if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default') {
    	     //$status   =   ($arrParam['filter_state'] == 'unpublish') ? 0 : 1;
    	     $query[]    =   "AND `status` = '{$arrParam['filter_state']}'";
    	   
    	 }
    	 
    	 // FILTER : SPECIAL
    	 if(isset($arrParam['filter_special']) && $arrParam['filter_special'] != 'default') {
    	     $query[]    =   "AND `special` = '{$arrParam['filter_special']}'";
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
	         $query[]              =   "SELECT `id`,`description`, `picture`, `name`, `price`, `special`, `sale_off`, `category_id`, `status`, `ordering`";
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
	         $query    =   "SELECT `id`, `name` FROM `".TBL_CATEGORY."`";
	         $result   =   $this->fetchPairs($query);
	         $result['default']    =   '- Select Category -';
	         ksort($result);
	     }
	     return $result;
	 }
}