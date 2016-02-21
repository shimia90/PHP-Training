<?php
class GoogleModel extends Model {
    
    private $_columns = array('id', 'name', 'group_acp', 'created', 'created_by', 'modified', 'modiefied_by', 'status', 'ordering');
    
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
		return $arrayUser;
	}
	
	// Return Array Project
	public function listProject() {
		$query 				=		"SELECT * FROM `".TBL_PROJECT."`";
		$arrayProject 		=		$this->fetchAll($query);
		return $arrayProject;
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
	 
	 public function getDataGoogle() {
	     $arrayData = array();
	     $arraySource = array();
	     for($i = 1; $i <=11; $i ++) {
	         $queryProject = "SELECT * FROM `".TBL_LINK."` WHERE `project_link` = ".$i." ORDER BY `link_month` DESC LIMIT 1";
	         $arraySource[] = $this->fetchAll($queryProject);
	     }
	     for($i = 0; $i < count($arraySource); $i++) {
	         switch ($arraySource[$i][0]['project_link']) {
	             case 1:
	                 $arrayLink['maintenance']               =   $arraySource[$i][0]['link'];
	                 break;
	             case 2:
	                 $arrayLink['new_coding']                =   $arraySource[$i][0]['link'];
	                 break;
	             case 3:
	                 $arrayLink['domestic']                  =   $arraySource[$i][0]['link'];
	                 break;
	             case 4:
	                 $arrayLink['newton']                    =   $arraySource[$i][0]['link'];
	                 break;
	             case 5:
	                 $arrayLink['research']                  =   $arraySource[$i][0]['link'];
	                 break;
	             case 6:
	                 $arrayLink['other']                     =   $arraySource[$i][0]['link'];
	                 break;
	             case 7:
	                 $arrayLink['fc']                        =   $arraySource[$i][0]['link'];
	                 break;
	             case 8:
	                 $arrayLink['working']                   =   $arraySource[$i][0]['link'];
	                 break;
	             case 9:
	                 $arrayLink['newton_detail']             =   $arraySource[$i][0]['link'];
	                 break;
	             case 10:
	                 $arrayLink['new_coding_detail']         =   $arraySource[$i][0]['link'];
	                 break;
	             case 11:
	                 $arrayLink['fc_detail']                 =   $arraySource[$i][0]['link'];
	                 break;
	         }
	     } 
	     foreach($arrayLink as $key => $value) {
	         $arrayData[$key] = Helper::getData($value);
	     }
	     return $arrayData;
	 }
	 
	 public function processMaintenance() {
		$arrayData 			= 	$this->getDataGoogle();
		$arrayMaintenance 	= 	array();
		array_shift($arrayData['maintenance']);
		for ($i = 0; $i < count($arrayData['maintenance']) - 1; $i ++) {
			if (trim($arrayData['maintenance'][$i][15]) != '' && trim($arrayData['maintenance'][$i][16]) != '' && trim($arrayData['maintenance'][$i][13]) != '') {
				if ($arrayData['maintenance'][$i][6] == '') {
					unset($arrayData['maintenance'][$i][6]);
					continue;
				} else {
					$arrayData['maintenance'][$i][8] = str_replace(',', '.', $arrayData['maintenance'][$i][8]);
					$arrayData['maintenance'][$i][19] = str_replace(',', '.', $arrayData['maintenance'][$i][19]);
					$arrayMaintenance['Maintenance'][$i]['PROJECT_NO'] = $arrayData['maintenance'][$i][1];
					$arrayMaintenance['Maintenance'][$i]['PROJECT_TYPE'] = 'Maintenance';
					$arrayMaintenance['Maintenance'][$i]['ORDER_DATE'] = $arrayData['maintenance'][$i][2];
					$arrayMaintenance['Maintenance'][$i]['WORK_DATE'] = $arrayData['maintenance'][$i][13];
					$arrayMaintenance['Maintenance'][$i]['PROJECT_NAME'] = $arrayData['maintenance'][$i][4];
					$arrayMaintenance['Maintenance'][$i]['STATUS'] = $arrayData['maintenance'][$i][5];
					$arrayMaintenance['Maintenance'][$i]['STANDARD_DURATION'] = $arrayData['maintenance'][$i][8];
					$arrayMaintenance['Maintenance'][$i]['DELIVERY_DATE'] = $arrayData['maintenance'][$i][12];
					$arrayMaintenance['Maintenance'][$i]['DELIVERY_BEFORE'] = $arrayData['maintenance'][$i][10];
					$arrayMaintenance['Maintenance'][$i]['USER'] = $arrayData['maintenance'][$i][6];
					$arrayMaintenance['Maintenance'][$i]['START'] = $arrayData['maintenance'][$i][15];
					$arrayMaintenance['Maintenance'][$i]['END'] = $arrayData['maintenance'][$i][16];
					$arrayMaintenance['Maintenance'][$i]['REAL_DURATION'] = $arrayData['maintenance'][$i][19];
					$arrayMaintenance['Maintenance'][$i]['PERFORMANCE'] = ($arrayData['maintenance'][$i][19] > 0) ? (round($arrayData['maintenance'][$i][8] / $arrayData['maintenance'][$i][19], 2)) : 0;
					$arrayMaintenance['Maintenance'][$i]['NOTE'] = $arrayData['maintenance'][$i][21];
					$arrayMaintenance['Maintenance'][$i]['PAGE_NAME'] = '';
					$arrayMaintenance['Maintenance'][$i]['PAGE_NUMBER'] = '';
					$arrayMaintenance['Maintenance'][$i]['TYPE'] = '';
					$arrayMaintenance['Maintenance'][$i]['WORK_CONTENT'] = '';
				}
			}
		}
		foreach($arrayMaintenance as $key => $value) {
			$value = array_values($value);
			$arrayMaintenance[$key] = $value;
		}
		return $arrayMaintenance;
	 }
	 
	 public function processNewtonDetail() {
		 $arrayData 				= 		$this->getDataGoogle();
		 $arrayNewtonDetail 	    = 		array();
		 array_shift($arrayData['newton_detail']);
		 for ($i = 0; $i < count($arrayData['newton_detail']) - 1; $i ++) {
			if (trim($arrayData['newton_detail'][$i][11]) != '' && trim($arrayData['newton_detail'][$i][12]) != '' && trim($arrayData['newton_detail'][$i][13]) != '') {
				if ($arrayData['newton_detail'][$i][6] == '') {
					unset($arrayData['newton_detail'][$i][6]);
					continue;
				} else {
					$arrayData['newton_detail'][$i][8] = str_replace(',', '.', $arrayData['newton_detail'][$i][8]);
					//$arrayData['newton_detail'][$i][5] = str_replace(',', '.', $arrayData['newton_detail'][$i][5]);
					$arrayNewtonDetail['Newton'][$i]['PROJECT_NO'] = $arrayData['newton_detail'][$i][1];
					$arrayNewtonDetail['Newton'][$i]['PROJECT_TYPE'] = 'Newton';
					$arrayNewtonDetail['Newton'][$i]['ORDER_DATE'] = $arrayData['newton_detail'][$i][11];
					$arrayNewtonDetail['Newton'][$i]['WORK_DATE'] = $arrayData['newton_detail'][$i][13];
					$arrayNewtonDetail['Newton'][$i]['PROJECT_NAME'] = $arrayData['newton_detail'][$i][4];
					$arrayNewtonDetail['Newton'][$i]['STATUS'] = $arrayData['newton_detail'][$i][5];
					$arrayNewtonDetail['Newton'][$i]['STANDARD_DURATION'] = $arrayData['newton_detail'][$i][8];
					$arrayNewtonDetail['Newton'][$i]['DELIVERY_DATE'] = $arrayData['newton_detail'][$i][12];
					$arrayNewtonDetail['Newton'][$i]['DELIVERY_BEFORE'] = $arrayData['newton_detail'][$i][10];
					$arrayNewtonDetail['Newton'][$i]['USER'] = $arrayData['newton_detail'][$i][6];
					$arrayNewtonDetail['Newton'][$i]['START'] = $arrayData['newton_detail'][$i][15];
					$arrayNewtonDetail['Newton'][$i]['END'] = $arrayData['newton_detail'][$i][16];
					$arrayNewtonDetail['Newton'][$i]['REAL_DURATION'] = $arrayData['newton_detail'][$i][19];
					$arrayNewtonDetail['Newton'][$i]['PERFORMANCE'] = '';
					$arrayNewtonDetail['Newton'][$i]['NOTE'] = $arrayData['newton_detail'][$i][21];
					$arrayNewtonDetail['Newton'][$i]['PAGE_NAME'] = '';
					$arrayNewtonDetail['Newton'][$i]['PAGE_NUMBER'] = '';
					$arrayNewtonDetail['Newton'][$i]['TYPE'] = $arrayData['newton_detail'][$i][2];
					$arrayNewtonDetail['Newton'][$i]['WORK_CONTENT'] = '';
				}
			}
		}
		return $arrayNewtonDetail;
	 }
	 
	 public function processNewton() {
		 $arrayData 				= 		$this->getDataGoogle();
		 $arrayNewtonDetail 		=		$this->processNewtonDetail();
		 $arrayNewton 				= 		array();
		 array_shift($arrayData['newton']);
		 for ($i = 0; $i < count($arrayData['newton']) - 1; $i ++) {
			if (trim($arrayData['newton'][$i][9]) != '' && trim($arrayData['newton'][$i][10]) != '' && trim($arrayData['newton'][$i][0]) != '') {
				if ($arrayData['newton'][$i][7] == '') {
					unset($arrayData['newton'][$i][7]);
					continue;
				} else {
					$arrayData['newton'][$i][4] = str_replace(',', '.', $arrayData['newton'][$i][4]);
					$arrayData['newton'][$i][5] = str_replace(',', '.', $arrayData['newton'][$i][5]);
					$arrayNewton['Newton'][$i]['PROJECT_NO'] = $arrayData['newton'][$i][1];
					$arrayNewton['Newton'][$i]['PROJECT_TYPE'] = 'Newton';
					$arrayNewton['Newton'][$i]['ORDER_DATE'] = '';
					$arrayNewton['Newton'][$i]['DELIVERY_DATE'] = '';
					$arrayNewton['Newton'][$i]['DELIVERY_BEFORE'] = '';
					foreach($arrayNewtonDetail['Newton'] as $a => $b) {
						
						if($arrayNewtonDetail['Newton'][$a]['PROJECT_NO'] == $arrayData['newton'][$i][1] && $arrayNewtonDetail['Newton'][$a]['PROJECT_NAME'] == $arrayData['newton'][$i][2] && $arrayNewtonDetail['Newton'][$a]['USER'] == $arrayData['newton'][$i][7]) {
							$arrayNewton['Newton'][$i]['ORDER_DATE']            = $b['ORDER_DATE'];
							$arrayNewton['Newton'][$i]['DELIVERY_DATE']         = $b['DELIVERY_DATE'];
							$arrayNewton['Newton'][$i]['DELIVERY_BEFORE']       = $b['DELIVERY_BEFORE'];
						}
					}
					   
					
					$arrayNewton['Newton'][$i]['WORK_DATE'] = $arrayData['newton'][$i][0];
					$arrayNewton['Newton'][$i]['PROJECT_NAME'] = $arrayData['newton'][$i][2];
					$arrayNewton['Newton'][$i]['STATUS'] = $arrayData['newton'][$i][8];
					$arrayNewton['Newton'][$i]['STANDARD_DURATION'] = $arrayData['newton'][$i][4];
					
					$arrayNewton['Newton'][$i]['DELIVERY_BEFORE'] = '';
					$arrayNewton['Newton'][$i]['USER'] = $arrayData['newton'][$i][7];
					$arrayNewton['Newton'][$i]['START'] = $arrayData['newton'][$i][9];
					$arrayNewton['Newton'][$i]['END'] = $arrayData['newton'][$i][10];
					$arrayNewton['Newton'][$i]['REAL_DURATION'] = $arrayData['newton'][$i][5];
					$arrayNewton['Newton'][$i]['PERFORMANCE'] = ($arrayData['newton'][$i][4] > 0 && $arrayData['newton'][$i][5] > 0) ? (round($arrayData['newton'][$i][5] / $arrayData['newton'][$i][4], 2)) : 0;
					$arrayNewton['Newton'][$i]['NOTE'] = $arrayData['newton'][$i][12];
					$arrayNewton['Newton'][$i]['PAGE_NAME'] = $arrayData['newton'][$i][6];
					$arrayNewton['Newton'][$i]['PAGE_NUMBER'] = '';
					$arrayNewton['Newton'][$i]['TYPE'] = $arrayData['newton'][$i][3];
					$arrayNewton['Newton'][$i]['WORK_CONTENT'] = '';
				}
			}
		}
		return $arrayNewton;
	 }
	 
	 public function processNewCodingDetail() {
		 $arrayData 				= 		$this->getDataGoogle();
		 $arrayNewCodingDetail 		=		array();
		 array_shift($arrayData['new_coding_detail']);
		 for ($i = 0; $i < count($arrayData['new_coding_detail']) - 1; $i ++) {
			if (trim($arrayData['new_coding_detail'][$i][7]) != '' && trim($arrayData['new_coding_detail'][$i][7]) != '-' && trim($arrayData['new_coding_detail'][$i][9]) != '') {
				$arrayNewCodingDetail['NewCoding'][$i]['PROJECT_NO'] = $arrayData['new_coding_detail'][$i][3];
				$arrayNewCodingDetail['NewCoding'][$i]['PROJECT_TYPE'] = 'New Coding';
				$arrayNewCodingDetail['NewCoding'][$i]['ORDER_DATE'] = $arrayData['new_coding_detail'][$i][9];
				$arrayNewCodingDetail['NewCoding'][$i]['WORK_DATE'] = '';
				$arrayNewCodingDetail['NewCoding'][$i]['PROJECT_NAME'] = $arrayData['new_coding_detail'][$i][5];
				$arrayNewCodingDetail['NewCoding'][$i]['STATUS'] = '';
				$arrayNewCodingDetail['NewCoding'][$i]['STANDARD_DURATION'] = $arrayData['new_coding_detail'][$i][12];
				$arrayNewCodingDetail['NewCoding'][$i]['DELIVERY_DATE'] = $arrayData['new_coding_detail'][$i][10];;
				$arrayNewCodingDetail['NewCoding'][$i]['DELIVERY_BEFORE'] = $arrayData['new_coding_detail'][$i][8];
				$arrayNewCodingDetail['NewCoding'][$i]['USER'] = $arrayData['new_coding_detail'][$i][7];
				$arrayNewCodingDetail['NewCoding'][$i]['START'] = '';
				$arrayNewCodingDetail['NewCoding'][$i]['END'] = '';
				$arrayNewCodingDetail['NewCoding'][$i]['REAL_DURATION'] = 0;
				$arrayNewCodingDetail['NewCoding'][$i]['PERFORMANCE'] = 0;
				$arrayNewCodingDetail['NewCoding'][$i]['NOTE'] = $arrayData['new_coding_detail'][$i][20];
				$arrayNewCodingDetail['NewCoding'][$i]['PAGE_NAME'] = '';
				$arrayNewCodingDetail['NewCoding'][$i]['PAGE_NUMBER'] = $arrayData['new_coding_detail'][$i][11];
				$arrayNewCodingDetail['NewCoding'][$i]['TYPE'] = $arrayData['new_coding_detail'][$i][4];
				$arrayNewCodingDetail['NewCoding'][$i]['WORK_CONTENT'] = '';
			}
		}
		foreach($arrayNewCodingDetail as $key => $value) {
			$value = array_values($value);
			$arrayNewCodingDetail[$key] = $value;
		}
		return $arrayNewCodingDetail;
	 }
	 
	 public function processNewCoding() {
		 $arrayData 				= 		$this->getDataGoogle();
		 $arrayNewCoding 			=		array();
		 $arrayNewCodingDetail 		=		$this->processNewCodingDetail();
		 array_shift($arrayData['new_coding']);
		 for ($i = 0; $i < count($arrayData['new_coding']) - 1; $i ++) {
			if (trim($arrayData['new_coding'][$i][9]) != '' && trim($arrayData['new_coding'][$i][11]) != '' && trim($arrayData['new_coding'][$i][12]) != '') {
					$arrayData['new_coding'][$i][5] = str_replace(',', '.', $arrayData['new_coding'][$i][5]);
					$arrayData['new_coding'][$i][6] = str_replace(',', '.', $arrayData['new_coding'][$i][6]);
					$arrayNewCoding['NewCoding'][$i]['PROJECT_NO'] = $arrayData['new_coding'][$i][1];
					$arrayNewCoding['NewCoding'][$i]['PROJECT_TYPE'] = 'New Coding';
					$arrayNewCoding['NewCoding'][$i]['ORDER_DATE'] = '';
					$arrayNewCoding['NewCoding'][$i]['DELIVERY_DATE'] = '';
					$arrayNewCoding['NewCoding'][$i]['DELIVERY_BEFORE'] = '';
					if($arrayData['new_coding'][$i][3] == 'Option') {
						$arrayData['new_coding'][$i][3] = 'New';
					}
					foreach($arrayNewCodingDetail['NewCoding'] as $a => $b) {
						if(trim($arrayNewCodingDetail['NewCoding'][$a]['PROJECT_NO']) == trim($arrayData['new_coding'][$i][1]) && trim($arrayNewCodingDetail['NewCoding'][$a]['PROJECT_NAME']) == trim($arrayData['new_coding'][$i][2]) && trim($arrayNewCodingDetail['NewCoding'][$a]['TYPE']) == trim($arrayData['new_coding'][$i][3])) {
							$arrayNewCoding['NewCoding'][$i]['ORDER_DATE']            = $b['ORDER_DATE'];
							$arrayNewCoding['NewCoding'][$i]['DELIVERY_DATE']         = $b['DELIVERY_DATE'];
							$arrayNewCoding['NewCoding'][$i]['DELIVERY_BEFORE']       = $b['DELIVERY_BEFORE'];
						}
					}
					$arrayNewCoding['NewCoding'][$i]['WORK_DATE'] = $arrayData['new_coding'][$i][0];
					$arrayNewCoding['NewCoding'][$i]['PROJECT_NAME'] = $arrayData['new_coding'][$i][2];
					$arrayNewCoding['NewCoding'][$i]['STATUS'] = $arrayData['new_coding'][$i][10];
					$arrayNewCoding['NewCoding'][$i]['STANDARD_DURATION'] = $arrayData['new_coding'][$i][5];
					$arrayNewCoding['NewCoding'][$i]['USER'] = $arrayData['new_coding'][$i][9];
					$arrayNewCoding['NewCoding'][$i]['START'] = $arrayData['new_coding'][$i][11];
					$arrayNewCoding['NewCoding'][$i]['END'] = $arrayData['new_coding'][$i][12];
					$arrayNewCoding['NewCoding'][$i]['REAL_DURATION'] = $arrayData['new_coding'][$i][6];
					$arrayNewCoding['NewCoding'][$i]['PERFORMANCE'] = ($arrayData['new_coding'][$i][5] > 0 && $arrayData['new_coding'][$i][6] > 0) ? (round($arrayData['new_coding'][$i][6] / $arrayData['new_coding'][$i][5], 2)) : 0;
					$arrayNewCoding['NewCoding'][$i]['NOTE'] = $arrayData['new_coding'][$i][14];
					$arrayNewCoding['NewCoding'][$i]['PAGE_NAME'] = $arrayData['new_coding'][$i][8];
					$arrayNewCoding['NewCoding'][$i]['PAGE_NUMBER'] = $arrayData['new_coding'][$i][4];
					$arrayNewCoding['NewCoding'][$i]['TYPE'] = $arrayData['new_coding'][$i][3];
					$arrayNewCoding['NewCoding'][$i]['WORK_CONTENT'] = $arrayData['new_coding'][$i][7];
					
			}
		}
		foreach($arrayNewCoding as $key => $value) {
			$value = array_values($value);
			$arrayNewCoding[$key] = $value; 
		}
		return $arrayNewCoding;
	 }
	 
	 public function processDomestic() {
		$arrayData 				= 		$this->getDataGoogle();
		$arrayDomestic 			=		array();
		array_shift($arrayData['domestic']);

		for ($i = 0; $i < count($arrayData['domestic']) - 1; $i ++) {
			if (trim($arrayData['domestic'][$i][9]) != '' && trim($arrayData['domestic'][$i][10]) != '' && trim($arrayData['domestic'][$i][0]) != '') {
				if ($arrayData['domestic'][$i][7] == '') {
					unset($arrayData['domestic'][$i][7]);
					continue;
				} else {
					$arrayData['domestic'][$i][4] = str_replace(',', '.', $arrayData['domestic'][$i][4]);
					$arrayData['domestic'][$i][5] = str_replace(',', '.', $arrayData['domestic'][$i][5]);
					$arrayDomestic['Domestic'][$i]['PROJECT_NO'] = '';
					$arrayDomestic['Domestic'][$i]['PROJECT_TYPE'] = 'Domestic';
					$arrayDomestic['Domestic'][$i]['ORDER_DATE'] = '';
					$arrayDomestic['Domestic'][$i]['WORK_DATE'] = $arrayData['domestic'][$i][0];
					$arrayDomestic['Domestic'][$i]['PROJECT_NAME'] = $arrayData['domestic'][$i][1];
					$arrayDomestic['Domestic'][$i]['STATUS'] = $arrayData['domestic'][$i][8];
					$arrayDomestic['Domestic'][$i]['STANDARD_DURATION'] = $arrayData['domestic'][$i][4];
					$arrayDomestic['Domestic'][$i]['DELIVERY_DATE'] = '';
					$arrayDomestic['Domestic'][$i]['DELIVERY_BEFORE'] = '';
					$arrayDomestic['Domestic'][$i]['USER'] = $arrayData['domestic'][$i][7];
					$arrayDomestic['Domestic'][$i]['START'] = $arrayData['domestic'][$i][9];
					$arrayDomestic['Domestic'][$i]['END'] = $arrayData['domestic'][$i][10];
					$arrayDomestic['Domestic'][$i]['REAL_DURATION'] = $arrayData['domestic'][$i][5];
					$arrayDomestic['Domestic'][$i]['PERFORMANCE'] = ($arrayData['domestic'][$i][4] > 0 && $arrayData['domestic'][$i][5] > 0) ? (round($arrayData['domestic'][$i][5] / $arrayData['domestic'][$i][4], 2)) : 0;
					$arrayDomestic['Domestic'][$i]['NOTE'] = $arrayData['domestic'][$i][12];
					$arrayDomestic['Domestic'][$i]['PAGE_NAME'] = '';
					$arrayDomestic['Domestic'][$i]['PAGE_NUMBER'] = $arrayData['domestic'][$i][3];
					$arrayDomestic['Domestic'][$i]['TYPE'] = $arrayData['domestic'][$i][2];
					$arrayDomestic['Domestic'][$i]['WORK_CONTENT'] = $arrayData['domestic'][$i][6];
				}
			}
		}
		
		return $arrayDomestic;
	 }
	 
	 public function processFcDetail() {
		$arrayData 				= 		$this->getDataGoogle();
		$arrayFcDetail 			=		array();
		array_shift($arrayData['fc_detail']);
		
		for ($i = 0; $i < count($arrayData['fc_detail']) - 1; $i ++) {
			if (trim($arrayData['fc_detail'][$i][6]) != '' && trim($arrayData['fc_detail'][$i][7]) != '' && trim($arrayData['fc_detail'][$i][9]) != '') {
				if ($arrayData['fc_detail'][$i][8] == '') {
					unset($arrayData['fc_detail'][$i][8]);
					continue;
				} else {
					$arrayFcDetail['FC'][$i]['PROJECT_NO'] = $arrayData['fc_detail'][$i][0];
					$arrayFcDetail['FC'][$i]['PROJECT_TYPE'] = 'FC';
					$arrayFcDetail['FC'][$i]['ORDER_DATE'] = $arrayData['fc_detail'][$i][6];
					$arrayFcDetail['FC'][$i]['WORK_DATE'] = '';
					$arrayFcDetail['FC'][$i]['PROJECT_NAME'] = $arrayData['fc_detail'][$i][3];
					$arrayFcDetail['FC'][$i]['STATUS'] = trim($arrayData['fc_detail'][$i][9]);
					$arrayFcDetail['FC'][$i]['STANDARD_DURATION'] = '';
					$arrayFcDetail['FC'][$i]['DELIVERY_DATE'] = $arrayData['fc_detail'][$i][7];;
					$arrayFcDetail['FC'][$i]['DELIVERY_BEFORE'] = '';
					$arrayFcDetail['FC'][$i]['USER'] = $arrayData['fc_detail'][$i][8];
					$arrayFcDetail['FC'][$i]['START'] = '';
					$arrayFcDetail['FC'][$i]['END'] = '';
					$arrayFcDetail['FC'][$i]['REAL_DURATION'] = '';
					$arrayFcDetail['FC'][$i]['PERFORMANCE'] = 0;
					$arrayFcDetail['FC'][$i]['NOTE'] = $arrayData['fc_detail'][$i][13];
					$arrayFcDetail['FC'][$i]['PAGE_NAME'] = '';
					$arrayFcDetail['FC'][$i]['PAGE_NUMBER'] = $arrayData['fc_detail'][$i][4];
					$arrayFcDetail['FC'][$i]['TYPE'] = '';
					$arrayFcDetail['FC'][$i]['WORK_CONTENT'] = '';
				}
			}
		}
		return $arrayFcDetail;
	 }
	 
	 public function processFc() {
		$arrayData 				= 		$this->getDataGoogle();
		$arrayFcDetail 			=		$this->processFcDetail();
		$arrayFc 				=		array();
		array_shift($arrayData['fc']);
		
		for ($i = 0; $i < count($arrayData['fc']) - 1; $i ++) {
			if (trim($arrayData['fc'][$i][10]) != '' && trim($arrayData['fc'][$i][11]) != '' && trim($arrayData['fc'][$i][0]) != '') {
				if ($arrayData['fc'][$i][8] == '') {
					unset($arrayData['fc'][$i][8]);
					continue;
				} else {
					$arrayData['fc'][$i][5] = str_replace(',', '.', $arrayData['fc'][$i][5]);
					$arrayData['fc'][$i][6] = str_replace(',', '.', $arrayData['fc'][$i][6]);
					$arrayFc['FC'][$i]['PROJECT_NO'] = $arrayData['fc'][$i][1];
					$arrayFc['FC'][$i]['PROJECT_TYPE'] = 'FC';
					$arrayFc['FC'][$i]['ORDER_DATE'] = '';
					$arrayFc['FC'][$i]['DELIVERY_DATE'] = '';
					$arrayFc['FC'][$i]['DELIVERY_BEFORE'] = '';
					foreach($arrayFcDetail['FC'] as $a => $b) {
					
						if($arrayFcDetail['FC'][$a]['PROJECT_NO'] == $arrayData['fc'][$i][1] && $arrayFcDetail['FC'][$a]['PROJECT_NAME'] == $arrayData['fc'][$i][2]) {
							$arrayFc['FC'][$i]['ORDER_DATE']            = $b['ORDER_DATE'];
							$arrayFc['FC'][$i]['DELIVERY_DATE']         = $b['DELIVERY_DATE'];
							$arrayFc['FC'][$i]['DELIVERY_BEFORE']       = $b['DELIVERY_BEFORE'];
						}
					}
					$arrayFc['FC'][$i]['WORK_DATE'] = $arrayData['fc'][$i][0];
					$arrayFc['FC'][$i]['PROJECT_NAME'] = $arrayData['fc'][$i][2];
					$arrayFc['FC'][$i]['STATUS'] = $arrayData['fc'][$i][9];
					$arrayFc['FC'][$i]['STANDARD_DURATION'] = $arrayData['fc'][$i][5];
					$arrayFc['FC'][$i]['USER'] = $arrayData['fc'][$i][8];
					$arrayFc['FC'][$i]['START'] = $arrayData['fc'][$i][10];
					$arrayFc['FC'][$i]['END'] = $arrayData['fc'][$i][11];
					$arrayFc['FC'][$i]['REAL_DURATION'] = $arrayData['fc'][$i][6];
					$arrayFc['FC'][$i]['PERFORMANCE'] = ($arrayData['fc'][$i][5] > 0 && $arrayData['fc'][$i][6] > 0) ? (round($arrayData['fc'][$i][6] / $arrayData['fc'][$i][5], 2)) : 0;
					$arrayFc['FC'][$i]['NOTE'] = $arrayData['fc'][$i][13];
					$arrayFc['FC'][$i]['PAGE_NAME'] = $arrayData['fc'][$i][7];
					$arrayFc['FC'][$i]['PAGE_NUMBER'] = $arrayData['fc'][$i][4];
					$arrayFc['FC'][$i]['TYPE'] = $arrayData['fc'][$i][3];
					$arrayFc['FC'][$i]['WORK_CONTENT'] = '';
				}
			}
		} 
		return $arrayFc;
	 }
	 
	 public function processOther() {
		$arrayData 				= 		$this->getDataGoogle();
		$arrayOther 			=		array();
		array_shift($arrayData['other']);
		
		for ($i = 0; $i < count($arrayData['other']) - 1; $i ++) {
			if (trim($arrayData['other'][$i][4]) != '' && trim($arrayData['other'][$i][5]) != '' && trim($arrayData['other'][$i][0]) != '') {
				if ($arrayData['other'][$i][3] == '') {
					unset($arrayData['other'][$i][3]);
					continue;
				} else {
					$arrayData['other'][$i][7] = str_replace(',', '.', $arrayData['other'][$i][7]);
					$arrayOther['Other'][$i]['PROJECT_NO'] = '';
					$arrayOther['Other'][$i]['PROJECT_TYPE'] = 'Other';
					$arrayOther['Other'][$i]['ORDER_DATE'] = '';
					$arrayOther['Other'][$i]['WORK_DATE'] = $arrayData['other'][$i][0];
					$arrayOther['Other'][$i]['PROJECT_NAME'] = $arrayData['other'][$i][1];
					$arrayOther['Other'][$i]['STATUS'] = '';
					$arrayOther['Other'][$i]['STANDARD_DURATION'] = '';
					$arrayOther['Other'][$i]['DELIVERY_DATE'] = '';
					$arrayOther['Other'][$i]['DELIVERY_BEFORE'] = '';
					$arrayOther['Other'][$i]['USER'] = $arrayData['other'][$i][3];
					$arrayOther['Other'][$i]['START'] = $arrayData['other'][$i][4];
					$arrayOther['Other'][$i]['END'] = $arrayData['other'][$i][5];
					$arrayOther['Other'][$i]['REAL_DURATION'] = $arrayData['other'][$i][7];
					$arrayOther['Other'][$i]['PERFORMANCE'] = '';
					$arrayOther['Other'][$i]['NOTE'] = $arrayData['other'][$i][8];
					$arrayOther['Other'][$i]['PAGE_NAME'] = '';
					$arrayOther['Other'][$i]['PAGE_NUMBER'] = '';
					$arrayOther['Other'][$i]['TYPE'] = '';
					$arrayOther['Other'][$i]['WORK_CONTENT'] = $arrayData['other'][$i][2];
				}
			}
		}
		return $arrayOther;
	 }
	 
	 public function processResearch() {
		$arrayData 			=		$this->getDataGoogle();
		$arrayResearch 		=		array();
		
		for($i = 0; $i < 4; $i++) {
			array_shift($arrayData['research']);
		}
		
		for ($i = 0; $i < count($arrayData['research']) - 1; $i ++) {
			if (trim($arrayData['research'][$i][6]) != '' && trim($arrayData['research'][$i][7]) != '' && trim($arrayData['research'][$i][1]) != '') {
				if ($arrayData['research'][$i][3] == '') {
					unset($arrayData['research'][$i][3]);
					continue;
				} else {
					$arrayData['research'][$i][4] = str_replace(',', '.', $arrayData['research'][$i][4]);
					$arrayData['research'][$i][5] = str_replace(',', '.', $arrayData['research'][$i][5]);
					$arrayResearch['Research'][$i]['PROJECT_NO'] = '';
					$arrayResearch['Research'][$i]['PROJECT_TYPE'] = 'Research';
					$arrayResearch['Research'][$i]['ORDER_DATE'] = '';
					$arrayResearch['Research'][$i]['WORK_DATE'] = $arrayData['research'][$i][1];
					$arrayResearch['Research'][$i]['PROJECT_NAME'] = $arrayData['research'][$i][0];
					$arrayResearch['Research'][$i]['STATUS'] = '';
					$arrayResearch['Research'][$i]['STANDARD_DURATION'] = $arrayData['research'][$i][4];
					$arrayResearch['Research'][$i]['DELIVERY_DATE'] = '';
					$arrayResearch['Research'][$i]['DELIVERY_BEFORE'] = '';
					$arrayResearch['Research'][$i]['USER'] = $arrayData['research'][$i][3];
					$arrayResearch['Research'][$i]['START'] = $arrayData['research'][$i][6];
					$arrayResearch['Research'][$i]['END'] = $arrayData['research'][$i][7];
					$arrayResearch['Research'][$i]['REAL_DURATION'] = $arrayData['research'][$i][5];
					//$arrayResearch['Research'][$i]['PERFORMANCE'] = ($arrayData['research'][$i][4] > 0 && $arrayData['research'][$i][5] > 0) ? (round($arrayData['research'][$i][5] / $arrayData['research'][$i][4], 2)) : 0;
					$arrayResearch['Research'][$i]['PERFORMANCE'] = '';
					$arrayResearch['Research'][$i]['NOTE'] = $arrayData['research'][$i][9]. '-' . $arrayData['research'][$i][10] . '-' . $arrayData['research'][$i][11];
					$arrayResearch['Research'][$i]['PAGE_NAME'] = '';
					$arrayResearch['Research'][$i]['PAGE_NUMBER'] = '';
					$arrayResearch['Research'][$i]['TYPE'] = '';
					$arrayResearch['Research'][$i]['WORK_CONTENT'] = $arrayData['research'][$i][2];;
				}
			}
		} 
		return $arrayResearch;
	 }
	 
	 public function processWorkTime() {
		 $finalArray 		 = 	 array();
		 $arrayDate  		 =   array();
		 $arrayData 		 =	 $this->getDataGoogle();
		 $query 			 =	 "SELECT * FROM `".TBL_LINK."` WHERE `project_link` = '8'";
		 $arrayQueryDate     =   $this->fetchAll($query); 
		 $currentWorkMonth   =   $arrayQueryDate[0]['link_month'];
		 $currentWorkYear    =   $arrayQueryDate[0]['link_year'];
		 $currentMonth   	 =   date('m');
		 
		 foreach($arrayData['working'] as $key => $value) {
			array_pop($arrayData['working'][$key]);
			$arrayData['working'][$key] = array_values($arrayData['working'][$key]);
		 }
		 
		 foreach($arrayData['working'][0] as $key => $value) {
			if(is_numeric($value) == 1 && trim($value) != '' ) {
				if($value > 0 && $value <= 9) {
					$arrayDate[] = '0'.$value.'/'.$currentMonth.'/'.$currentWorkYear;
				} else {
					$arrayDate[] = $value.'/'.$currentMonth.'/'.$currentWorkYear;
				}
			} else {
				continue;
			}
		 }
		 
		 $arrayDate = array_unique($arrayDate);
		 
		 unset($arrayData['working'][0]);
		 unset($arrayData['working'][1]);
		 $arrayData['working'] = array_values($arrayData['working']);
		 for($i = 0 ; $i < count($arrayData['working']) ; $i++) {
			foreach($arrayDate as $key => $value) {
				if($arrayData['working'][$i][$key+6] == '') {
					$arrayData['working'][$i][$key+6] = 0;
				}
				$finalArray[$value][$arrayData['working'][$i][0]][] = $arrayData['working'][$i][$key+6];
			}
		 }
		 $arrayKey = array(
			'Overtime',
			'Delay',
			'Unpaid',
			'Special Paid',
			'Paid',
			'Others'
		);
		foreach($finalArray as $key => $value) {
			foreach($value as $k => $v) {
				$finalArray[$key][$k] = array_combine($arrayKey, $v);
			}
		}
		
		return $finalArray;
	 }
	 
	 public function importMaintenance() {
		 $arrayUser 			=		$this->listUser();
		 $arrayProject 			=		$this->listProject();
		 $arrayMaintenance 		=		$this->processMaintenance();
		 if(!empty($arrayMaintenance)) {
			foreach($arrayMaintenance['Maintenance'] as $key => $value) {
				if(empty($arrayMaintenance['Maintenance'][$key])) {
					unset($arrayMaintenance['Maintenance'][$key]);
				} else {
					$arrayMaintenance['Maintenance'][$key] = array_change_key_case($arrayMaintenance['Maintenance'][$key], CASE_LOWER);
					foreach($arrayUser as $k => $v) {
						if($arrayMaintenance['Maintenance'][$key]['user'] == $arrayUser[$k]['nickname']) {
							$arrayMaintenance['Maintenance'][$key]['user'] = $arrayUser[$k]['id'];
						}
					}
					foreach($arrayProject as $e => $q) {
						if($arrayMaintenance['Maintenance'][$key]['project_type'] == $arrayProject[$e]['project_type']) {
							$arrayMaintenance['Maintenance'][$key]['project_type'] = $arrayProject[$e]['id'];
						}
					}
					//echo $databaseWork->checkExistRow($arrayMaintenance['Maintenance'][$key]) . '<br />';
					$arrayToSelect['project_no']    = $arrayMaintenance['Maintenance'][$key]['project_no'];
					$arrayToSelect['project_type']  = $arrayMaintenance['Maintenance'][$key]['project_type'];
					$arrayToSelect['project_name']  = $arrayMaintenance['Maintenance'][$key]['project_name'];
					$arrayToSelect['work_date']  = $arrayMaintenance['Maintenance'][$key]['work_date'];
					//$arrayToSelect['user']  = $arrayMaintenance['Maintenance'][$key]['user'];
					if($this->checkExistRow($arrayToSelect, TBL_WORK) == 1) {
						$arrayIdMaintenance = $this->returnID($arrayToSelect, TBL_WORK);
						if(!empty($arrayIdMaintenance)) {
							$this->update($arrayMaintenance['Maintenance'][$key], array(array('id', $arrayIdMaintenance[0]['id'], null)));
						}    
					} else {
						$this->insert($arrayMaintenance['Maintenance'][$key]);
					}
				}
			}
		}
	 }
	 
	 //Import Newton Data
	 public function importNewton() {
		$arrayUser 				=		$this->listUser();
		$arrayProject 			=		$this->listProject();
		$arrayNewton 			=		$this->processNewton();
		if(!empty($arrayNewton)) {
			foreach($arrayNewton['Newton'] as $key => $value) {
				if(empty($arrayNewton['Newton'][$key])) {
					unset($arrayNewton['Newton'][$key]);
				} else {
					$arrayNewton['Newton'][$key] = array_change_key_case($arrayNewton['Newton'][$key], CASE_LOWER);
					foreach($arrayUser as $k => $v) {
						if($arrayNewton['Newton'][$key]['user'] == $arrayUser[$k]['nickname']) {
							$arrayNewton['Newton'][$key]['user'] = $arrayUser[$k]['id'];
						}
					}
					foreach($arrayProject as $e => $q) {
						if($arrayNewton['Newton'][$key]['project_type'] == $arrayProject[$e]['project_type']) {
							$arrayNewton['Newton'][$key]['project_type'] = $arrayProject[$e]['id'];
						}
					}
				   //$databaseWork->insert($arrayNewton['Newton'][$key]);
				   $arrayNewtonToSelect['project_no']   =   $arrayNewton['Newton'][$key]['project_no'];
				   $arrayNewtonToSelect['project_type']   =   $arrayNewton['Newton'][$key]['project_type'];
				   $arrayNewtonToSelect['project_name']   =   $arrayNewton['Newton'][$key]['project_name'];
				   $arrayNewtonToSelect['work_date']   =   $arrayNewton['Newton'][$key]['work_date'];
				   //$arrayNewtonToSelect['user']   =   $arrayNewton['Newton'][$key]['user'];
				   $arrayNewtonToSelect['type']   =   $arrayNewton['Newton'][$key]['type'];
					if($this->checkExistRow($arrayNewtonToSelect, TBL_WORK) == 1) {
						
						$arrayIdNewton = $this->returnID($arrayNewtonToSelect, TBL_WORK);
						if(!empty($arrayIdNewton)) {
							$this->update($arrayNewton['Newton'][$key], array(array('id', $arrayIdNewton[0]['id'], null)));
						}
					} else {
						$this->insert($arrayNewton['Newton'][$key]);
					}
				}
			}
		}
	 }
	 
	 public function importDomestic() {
	     $arrayUser 				=		$this->listUser();
	     $arrayProject 			    =		$this->listProject();
	     $arrayDomestic             =       $this->processDomestic();
	     if(!empty($arrayDomestic)) {
	         foreach($arrayDomestic['Domestic'] as $key => $value) {
	             if(empty($arrayDomestic['Domestic'][$key])) {
	                 unset($arrayDomestic['Domestic'][$key]);
	             } else {
	                 $arrayDomestic['Domestic'][$key] = array_change_key_case($arrayDomestic['Domestic'][$key], CASE_LOWER);
	                 foreach($arrayUser as $k => $v) {
	                     if($arrayDomestic['Domestic'][$key]['user'] == $arrayUser[$k]['nickname']) {
	                         $arrayDomestic['Domestic'][$key]['user'] = $arrayUser[$k]['id'];
	                     }
	                 }
	                 foreach($arrayProject as $e => $q) {
	                     if($arrayDomestic['Domestic'][$key]['project_type'] == $arrayProject[$e]['project_type']) {
	                         $arrayDomestic['Domestic'][$key]['project_type'] = $arrayProject[$e]['id'];
	                     }
	                 }
	                 //$databaseWork->insert($arrayDomestic['Domestic'][$key]);
	                 $arrayDomesticToSelect['project_name']  =   $arrayDomestic['Domestic'][$key]['project_name'];
	                 $arrayDomesticToSelect['project_type']  =   $arrayDomestic['Domestic'][$key]['project_type'];
	                 $arrayDomesticToSelect['user']  =   $arrayDomestic['Domestic'][$key]['user'];
	                 $arrayDomesticToSelect['work_date']  =   $arrayDomestic['Domestic'][$key]['work_date'];
	                 $arrayDomesticToSelect['work_content']  =   $arrayDomestic['Domestic'][$key]['work_content'];
	                 $arrayDomesticToSelect['type']  =   $arrayDomestic['Domestic'][$key]['type'];
	                 $arrayDomesticToSelect['status']  =   $arrayDomestic['Domestic'][$key]['status'];
	                 $arrayDomesticToSelect['start']  =   $arrayDomestic['Domestic'][$key]['start'];
	                 $arrayDomesticToSelect['end']  =   $arrayDomestic['Domestic'][$key]['end'];
	                 if($this->checkExistRow($arrayDomesticToSelect, TBL_WORK) == 1) {
	     
	                     $arrayIdDomestic = $this->returnID($arrayDomesticToSelect, TBL_WORK);
	                     if(!empty($arrayIdDomestic)) {
	                         $this->update($arrayDomestic['Domestic'][$key], array(array('id', $arrayIdDomestic[0]['id'], null)));
	                     }
	                 } else {
	                     $this->insert($arrayDomestic['Domestic'][$key]);
	                 }
	             }
	         }
	     }
	 }
	 
	 public function importFC() {
	     $arrayUser 				=		$this->listUser();
	     $arrayProject 			    =		$this->listProject();
	     $arrayFc                   =       $this->processFc();   
	     if(!empty($arrayFc)) {
	         foreach($arrayFc['FC'] as $key => $value) {
	             if(empty($arrayFc['FC'][$key])) {
	                 unset($arrayFc['FC'][$key]);
	             } else {
	                 $arrayFc['FC'][$key] = array_change_key_case($arrayFc['FC'][$key], CASE_LOWER);
	                 foreach($arrayUser as $k => $v) {
	                     if($arrayFc['FC'][$key]['user'] == $arrayUser[$k]['nickname']) {
	                         $arrayFc['FC'][$key]['user'] = $arrayUser[$k]['id'];
	                     }
	                 }
	                 foreach($arrayProject as $e => $q) {
	                     if($arrayFc['FC'][$key]['project_type'] == $arrayProject[$e]['project_type']) {
	                         $arrayFc['FC'][$key]['project_type'] = $arrayProject[$e]['id'];
	                     }
	                 }
	                 //$databaseWork->insert($arrayFc['FC'][$key]);
	                 $arrayFcToSelect['project_no']    =   $arrayFc['FC'][$key]['project_no'];
	                 $arrayFcToSelect['project_type']    =   $arrayFc['FC'][$key]['project_type'];
	                 //$arrayFcToSelect['project_name']    =   $arrayFc['FC'][$key]['project_name'];
	                 $arrayFcToSelect['work_date']    =   $arrayFc['FC'][$key]['work_date'];
	                 $arrayFcToSelect['user']    =   $arrayFc['FC'][$key]['user'];
	                 $arrayFcToSelect['type']    =   $arrayFc['FC'][$key]['type'];
	                 $arrayFcToSelect['page_name']    =   $arrayFc['FC'][$key]['page_name'];
	                 if($this->checkExistRow($arrayFcToSelect, TBL_WORK) == true) {
	                     $arrayIdFC = $this->returnID($arrayFcToSelect, TBL_WORK);
	                     if(!empty($arrayIdFC)) {
	                         $this->update($arrayFc['FC'][$key], array(array('id', $arrayIdFC[0]['id'], null)));
	                     }
	                 } else {
	                     $this->insert($arrayFc['FC'][$key]);
	                 }
	             }
	         }
	     }
	 }
	 
	 public function importOther() {
	     $arrayUser 				=		$this->listUser();
	     $arrayProject 			    =		$this->listProject();
	     $arrayOther                =       $this->processOther();
    	 if(!empty($arrayOther)) {
                foreach($arrayOther['Other'] as $key => $value) {
                    if(empty($arrayOther['Other'][$key])) {
                        unset($arrayOther['Other'][$key]);
                    } else {
                        $arrayOther['Other'][$key] = array_change_key_case($arrayOther['Other'][$key], CASE_LOWER);
                        foreach($arrayUser as $k => $v) {
                            if($arrayOther['Other'][$key]['user'] == $arrayUser[$k]['nickname']) {
                                $arrayOther['Other'][$key]['user'] = $arrayUser[$k]['id'];
                            }
                        }
                        foreach($arrayProject as $e => $q) {
                            if($arrayOther['Other'][$key]['project_type'] == $arrayProject[$e]['project_type']) {
                                $arrayOther['Other'][$key]['project_type'] = $arrayProject[$e]['id'];
                            }
                        }
                        //$databaseWork->insert($arrayOther['Other'][$key]);
                        $arrayOtherToSelect['project_name']     =   $arrayOther['Other'][$key]['project_name'];
                        $arrayOtherToSelect['project_type']     =   $arrayOther['Other'][$key]['project_type'];
                        $arrayOtherToSelect['user']             =   $arrayOther['Other'][$key]['user'];
                        $arrayOtherToSelect['work_date']     =   $arrayOther['Other'][$key]['work_date'];
                        if($this->checkExistRow($arrayOtherToSelect, TBL_WORK) == true) {
                            $arrayIdOther = $this->returnID($arrayOtherToSelect, TBL_WORK);
                            if(!empty($arrayIdOther)) {
                                $this->update($arrayOther['Other'][$key], array(array('id', $arrayIdOther[0]['id'], null)));
                            }
                        } else {
                            $this->insert($arrayOther['Other'][$key]);
                        }
                       
                    }
                }
            }
	 }
	 
	 public function importResearch() {
	     $arrayUser 				=		$this->listUser();
	     $arrayProject 			    =		$this->listProject();
	     $arrayResearch             =       $this->processResearch();
	     if(!empty($arrayResearch)) {
	         foreach($arrayResearch['Research'] as $key => $value) {
	             if(empty($arrayResearch['Research'][$key])) {
	                 unset($arrayResearch['Research'][$key]);
	             } else {
	                 $arrayResearch['Research'][$key] = array_change_key_case($arrayResearch['Research'][$key], CASE_LOWER);
	                 foreach($arrayUser as $k => $v) {
	                     if($arrayResearch['Research'][$key]['user'] == $arrayUser[$k]['nickname']) {
	                         $arrayResearch['Research'][$key]['user'] = $arrayUser[$k]['id'];
	                     }
	                 }
	                 foreach($arrayProject as $e => $q) {
	                     if($arrayResearch['Research'][$key]['project_type'] == $arrayProject[$e]['project_type']) {
	                         $arrayResearch['Research'][$key]['project_type'] = $arrayProject[$e]['id'];
	                     }
	                 }
	                 //$databaseWork->insert($arrayResearch['Research'][$key]);
	                 $arrayResearchToSelect['project_type'] = $arrayResearch['Research'][$key]['project_type'];
	                 $arrayResearchToSelect['project_name'] = $arrayResearch['Research'][$key]['project_name'];
	                 $arrayResearchToSelect['user'] = $arrayResearch['Research'][$key]['user'];
	                 $arrayResearchToSelect['work_date'] = $arrayResearch['Research'][$key]['work_date'];
	                 if($this->checkExistRow($arrayResearchToSelect, TBL_WORK) == true) {
	                     /* $arrayIdResearch = $databaseWork->returnID($arrayResearch['Research'][$key]);
	                      foreach($arrayIdResearch as $key => $value) {
	                      $arrayResearchWhere[] = array('id',$value['id'], null);
	                      }
	                      @$databaseWork->update($arrayResearch['Research'][$key], $arrayResearchWhere); */
	                     $arrayIdResearch = $this->returnID($arrayResearchToSelect, TBL_WORK);
	                     if(!empty($arrayIdResearch)) {
	                         $this->update($arrayResearch['Research'][$key], array(array('id', $arrayIdResearch[0]['id'], null)));
	                     }
	                 } else {
	                     $this->insert($arrayResearch['Research'][$key]);
	                 }
	             }
	         }
	     }
	 }	 
	 
	 public function importNewCoding() {
	     $arrayUser 				=		$this->listUser();
	     $arrayProject 			    =		$this->listProject();
	     $arrayNewCoding            =       $this->processNewCoding();
	     if(!empty($arrayNewCoding)) {
	         foreach($arrayNewCoding['NewCoding'] as $key => $value) {
	             if(empty($arrayNewCoding['NewCoding'][$key])) {
	                 unset($arrayNewCoding['NewCoding'][$key]);
	             } else {
	                 $arrayNewCoding['NewCoding'][$key] = array_change_key_case($arrayNewCoding['NewCoding'][$key], CASE_LOWER);
	                 foreach($arrayUser as $k => $v) {
	                     if($arrayNewCoding['NewCoding'][$key]['user'] == $arrayUser[$k]['nickname']) {
	                         $arrayNewCoding['NewCoding'][$key]['user'] = $arrayUser[$k]['id'];
	                     }
	                 }
	                 foreach($arrayProject as $e => $q) {
	                     if($arrayNewCoding['NewCoding'][$key]['project_type'] == $arrayProject[$e]['project_type']) {
	                         $arrayNewCoding['NewCoding'][$key]['project_type'] = $arrayProject[$e]['id'];
	                     }
	                 }
	                 //$databaseWork->insert($arrayNewCoding['New Coding'][$key]);
	                 $arrayNewCodingToSelect['project_no']   =   $arrayNewCoding['NewCoding'][$key]['project_no'];
	                 $arrayNewCodingToSelect['project_name']   =   $arrayNewCoding['NewCoding'][$key]['project_name'];
	                 $arrayNewCodingToSelect['project_type']   =   $arrayNewCoding['NewCoding'][$key]['project_type'];
	                 $arrayNewCodingToSelect['work_date']   =   $arrayNewCoding['NewCoding'][$key]['work_date'];
	                 $arrayNewCodingToSelect['user']   =   $arrayNewCoding['NewCoding'][$key]['user'];
	                 $arrayNewCodingToSelect['work_content']   =   $arrayNewCoding['NewCoding'][$key]['work_content'];
	                 //if($databaseWork->checkExistRow($arrayNewCoding['NewCoding'][$key]) == true) {
	                 if($this->checkExistRow($arrayNewCodingToSelect, TBL_WORK) == true) {
	                     $arrayIdCoding = $this->returnID($arrayNewCodingToSelect, TBL_WORK);
	                     if(!empty($arrayIdCoding)) {
	                         $this->update($arrayNewCoding['NewCoding'][$key], array(array('id', $arrayIdCoding[0]['id'], null)));
	                     }
	                 } else {
	                     $this->insert($arrayNewCoding['NewCoding'][$key]);
	                 }
	             }
	         }
	     }
	 }
	 
	 public function importWorkTime() {
	     $this->setTable(TBL_WORKTIME);
	     $arrayUser 				=		$this->listUser();
	     $arrayWorktimeImport       =       array();
	     $arrayWorktimeSelect       =       array();
	     $arrayIdWorktime           =       array();
	     $finalArray                =       $this->processWorkTime();
	     
	     foreach($finalArray as $key => $value) {
	         foreach($value as $k => $v) {
	             if($k == 'ManhTD') {
	                 $finalArray[$key]['ManhT'] = $v;
	                 unset($finalArray[$key]['ManhTD']);
	             }
	         }
	     }
	     
	     foreach($finalArray as $key => $value) {
	         foreach($value as $k => $v) {
	             foreach($arrayUser as $a => $b) {
	                 if($k == $b['nickname']) {
	                     $finalArray[$key][$b['id']] = $v;
	                     unset($finalArray[$key][$k]);
	                 }
	             }
	         }
	     } 
	     
	     foreach($finalArray as $key => $value) {
	         foreach($value as $k => $v) {
	             $arrayWorktimeImport[$key][$k]['work_date']        =     $key;
	             $arrayWorktimeImport[$key][$k]['user']             =     $k;
	             $arrayWorktimeImport[$key][$k]['overtime']         =     $v['Overtime'];
	             $arrayWorktimeImport[$key][$k]['delay']            =     $v['Delay'];
	             $arrayWorktimeImport[$key][$k]['unpaid']           =     $v['Unpaid'];
	             $arrayWorktimeImport[$key][$k]['special_paid']     =     $v['Special Paid'];
	             $arrayWorktimeImport[$key][$k]['paid']             =     $v['Paid'];
	             $arrayWorktimeImport[$key][$k]['others']           =     $v['Others'];
	             $arrayWorktimeImport[$key][$k]['work_time']        =     (8 + $v['Overtime']) - ($v['Delay'] + $v['Unpaid'] + $v['Paid'] + $v['Others']);
	         }
	     }
	     
	     foreach($arrayWorktimeImport as $key => $value) {
	         foreach($value as $k => $v) {
	             $arrayWorktimeSelect['work_date'] = $v['work_date'];
	             $arrayWorktimeSelect['user'] = $v['user'];
	             if($this->checkExistRow($arrayWorktimeSelect, TBL_WORKTIME)) {
	                 $arrayIdWorktime = $this->returnID($arrayWorktimeSelect, TBL_WORKTIME);
	                 if(!empty($arrayIdWorktime)) {
	                     $this->update($v, array(array('id', $arrayIdWorktime[0]['id'], null)));
	                 }
	             } else {
	                 $this->insert($v);
	             }
	     
	         }
	     }
	     
	     
	     return $arrayWorktimeImport;
	 }
}