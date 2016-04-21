<?php
class UserModel extends Model {
    
    private $_columns = array('id', 'nickname', 'fullname', 'team', 'position');
    
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
		$this->setTable(TBL_USER);
		$query[]  		=   "SELECT `id`, `nickname`, `fullname`, `team`, `position`";
		$query[]  		=   "FROM `$this->table`";
		$query[]        =   "WHERE `id` > 0";
		
		// FILTER : KEYWORD
		if(!empty($arrParam['filter_search'])) {
		    $keyword    =   '"%' . $arrParam['filter_search'] . '%"';
		    $query[]    =   "WHERE `name` LIKE {$keyword}";
		}
		
		// FILTER : STATTUS
		if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default') {
		    $query[]    =   "AND `status` = '{$arrParam['filter_state']}'";
		}
		
		// FILTER : GROUP ACP
		if(isset($arrParam['filter_group_acp']) && $arrParam['filter_group_acp'] != 'default') {
		    $query[]    =   "AND `group_acp` = '{$arrParam['filter_group_acp']}'";
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
	
	// Return Array User
	public function listUser() {
		$query 			=		"SELECT * FROM `".TBL_USER."`";
		$arrayUser 		=		$this->fetchAll($query);
		
		foreach($arrayUser as $key => $value) {
		    $arrayUser[$key]['team']  =   $this->convertTeam($value['team']);
		}
		return $arrayUser;
	}
	
	// Return Array Project
	public function listProject() {
		$query 				=		"SELECT * FROM `".TBL_PROJECT."`";
		$arrayProject 		=		$this->fetchAll($query);
		return $arrayProject;
	}
	
	// Return Array Project Link
	public function listProjectLink() {
		$query 					=		"SELECT * FROM `".TBL_LINK."`";
		$arrayProjectLink		=		$this->fetchAll($query);
		return $arrayProjectLink;
	}
	
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
	        $data = array_intersect_key($arrayParam['form'], array_flip($this->_columns));
	        $this->insert($data);
	        Session::set('message', array('class' => 'success', 'content' => 'Data was inserted successfully'));
	        return $this->lastID();
	    }
	    
	    if($option['task'] == 'edit') {
	        $arrayParam['form']['modified']        = date('Y-m-d', time());
	        $arrayParam['form']['modified_by']     = 10;
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
    	 
    	 // FILTER : GROUP ACP
    	 if(isset($arrParam['filter_group_acp']) && $arrParam['filter_group_acp'] != 'default') {
    	     $query[]    =   "AND `group_acp` = '{$arrParam['filter_group_acp']}'";
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
	         $query[]  =   "SELECT `id`, `name`, `group_acp`, `status`, `ordering`";
	         $query[]  =   "FROM `$this->table`";
	         $query[]  =   "WHERE `id` = '{$arrayParam['id']}'";
	         $query    =   implode(' ', $query);
	         $result   =   $this->fetchRow($query);
	         return $result;
	     }
	 }
	 
	 public function listGoogleLink() {
		$arraySource 	=	$this->listProjectLink();
		$arrayProject	=	$this->listProject();
		$d 				= 	1;
		$xhtml 			=	'';
		for($i = 0; $i < count($arraySource); $i++) { 
			$class = ($d % 2 == 0) ?  'even' : 'odd';
			foreach($arrayProject as $key => $value) {
				if($arraySource[$i]['project_link'] == $value['id']) {
					$arraySource[$i]['project_link'] = $value['project_type'];
				}
			}
			$xhtml 	.=	'<tr class="gradeA">';
				$xhtml .=	'<td class="text-center">'.$arraySource[$i]['id'].'</td>
							 <td class="text-center">'.$arraySource[$i]['link'].'</td>
							 <td class="text-center">'.$arraySource[$i]['link_month'].'</td>
							 <td class="text-center">'.$arraySource[$i]['link_year'].'</td>
							 <td class="text-center">'.$arraySource[$i]['project_link'].'</td>
							 <td class="text-center"><a class="btn btn-mini btn-primary" href="'.URL::createLink('default', 'google', 'insert').'&type=edit&idLink='.$arraySource[$i]['id'].'">Edit</a> <a class="btn btn-mini btn-danger" href="'.URL::createLink('default', 'google', 'delete').'&idLink='.$arraySource[$i]['id'].'" onclick="return ConfirmDelete();">Delete</a></td>';
			$xhtml 	.=	'</tr>';
			$d++;
		}
		return $xhtml;
	 }
	 
	 public function processInsert($arrayPost) {
		$xhtml 							=		'';
		$this->setTable(TBL_USER);
		$this->insert($arrayPost, 'single');
		if($this->affectedRows() > 0 ) {
			$xhtml = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert"></button>
						Insert Successful!
					</div>';
		}
		
		return $xhtml;
	 }
	 
	 public function processEdit($arrayPost, $idPost) {
		$xhtml 							=		'';
		
		$arrayWhere = array(
                array('id', $idPost, null)
                );
		$this->setTable(TBL_USER);
		$this->update($arrayPost, $arrayWhere);
		if($this->affectedRows() > 0 ) {
			$xhtml = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert"></button>
						Update successful!
					</div>';
		}
		return $xhtml;
	 }
	 
	 public function arrayEdit($idPost) {
		 $arrayEdit 	=		array();
		 $queryEdit  	=   	"SELECT * FROM `".TBL_USER."` WHERE `id` = {$idPost}";
         $arrayEdit  	=   	$this->fetchAll($queryEdit);
         foreach($arrayEdit as $key => $value) {
             $arrayEdit[$key]['team']  =   $this->convertTeam($value['team']);
         }
		 return $arrayEdit;
	 }
	 
	 public function createSelectProject($class, $name, $defautText = 'Select...') {
		$xhtml 							=		'';
		$arrayProject 	 				=		$this->listProject();
		$xhtml 							=		'<select class="'.$class.'" name="'.$name.'">';
			$xhtml 						.=		'<option value="">'.$defautText.'</option>';
		for($i = 0; $i < count($arrayProject); $i++) {
			$xhtml 						.=		'<option value="'.$arrayProject[$i]['id'].'">'.$arrayProject[$i]['project_type'].'</option>';
		}
		$xhtml 							.=		'</select>';
		return $xhtml; 
	 }
	 
	 public function processDelete($idLink) {
		 $xhtml 		=		'';
		 $arrayDelete = array(
			$idLink
		);
		$this->setTable(TBL_USER);
		if ($this->delete($arrayDelete)) {
			$xhtml		.=		'<div class="alert alert-success">
									<button class="close" data-dismiss="alert"></button>
									Delete successful!
								</div>';
		} else {
			$xhtml 		.=		'<div class="alert alert-error">
									<button class="close" data-dismiss="alert"></button>
									Invalid ID or Delete Failed;
								</div>';
					}
		
		return $xhtml;
	 }
	 
	 public function listTeam() {
	       $arrayTeam      =       array();
	       $query          =       "SELECT * FROM `".TBL_TEAM."`";
	       $arrayTeam      =       $this->fetchAll($query);
	       return $arrayTeam;
	 }
	 
	 public function convertTeam($teamNumber) {
	     $arrayTeamName   =   array();
	     $xhtml           =   '';
	     if(!empty($teamNumber)) {
    	     $query           =   "SELECT `team_name` FROM `".TBL_TEAM."` WHERE `team_number` = '".$teamNumber."'";
    	     $arrayTeamName   =   $this->fetchAll($query);
    	    
    	     $xhtml           =   $arrayTeamName[0]['team_name']; 
	     }
	     return $xhtml;
	 }
}