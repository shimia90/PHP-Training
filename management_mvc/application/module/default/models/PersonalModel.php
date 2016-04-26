<?php
class PersonalModel extends Model {
    
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
	
	// Return Array Project
	public function listProject() {
		$query 				=		"SELECT * FROM `".TBL_PROJECT."`";
		$arrayProject 		=		$this->fetchAll($query);
		return $arrayProject;
	}
	
	//
	public function listUser() {
		$query 			=		"SELECT * FROM `".TBL_USER."`";
		$arrayUser 		=		$this->fetchAll($query);
		return $arrayUser;
	}
	
	//
	public function processDateRange($getUser = null, $getDateFrom = null, $getDateTo = null) {
		$arrayProject 	=	$this->listProject();
		if(!empty($getUser)) {
			$userPost       =   $getUser;
		} else {
			$userPost       =   @$_POST['user_name'];
		}
		
		if(!empty($getDateFrom)) {
			$dateFrom       =   $getDateFrom;
		} else {
			$dateFrom       =   @$_POST['date_from'];
		}
		
		if(!empty($getDateTo)) {
			$dateTo       =   $getDateTo;
		} else {
			$dateTo       =   @$_POST['date_to'];
		}
		//$dateFrom       =   @trim($_POST['date_from']);
    	//$dateTo         =   @trim($_POST['date_to']);
    	//$userPost       =   @$_POST['user_name'];
		$arrayWork 		=	array();
		
		if($dateFrom == $dateTo) {
			$queryWork      =   "SELECT * FROM `".TBL_WORK."` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) = STR_TO_DATE( '{$dateTo}', '%d/%m/%Y' ) AND `user` = {$userPost} ORDER BY `work_date` ASC";
		} else {
			$queryWork      =   "SELECT * FROM `".TBL_WORK."` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateTo}', '%d/%m/%Y' ) AND `user` = {$userPost} ORDER BY `work_date` ASC";
			$queryWorkOver1 =   "SELECT SUM(`real_duration`) AS `total_time`, `work_date`, `user` FROM `".TBL_WORK."` WHERE `work_date` IN (SELECT `work_date` FROM `work_time` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateTo}', '%d/%m/%Y' ) AND `change` = '0' AND `user` = {$userPost} ) AND `user` = {$userPost} GROUP BY `work_date`";
			$queryWorkOver2 =   "SELECT `work_time`, `work_date`, `user` FROM `".TBL_WORKTIME."` WHERE `user` = {$userPost} AND `change` = '0' AND `work_date` IN ( SELECT `work_date` FROM `work` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateTo}', '%d/%m/%Y' ) AND `user` = {$userPost} ) GROUP BY `work_date`";
		}
		
		$arrayWork      =   $this->fetchAll($queryWork);
		
		if($dateFrom != $dateTo) {
			// Process Overload Work
			$arrayWorkOver1 =   $this->fetchAll($queryWorkOver1);
			$arrayWorkOver2 =   $this->fetchAll($queryWorkOver2);
			$resultOverload = array();
			foreach($arrayWorkOver1 as $key => $value) {
				if(isset($arrayWorkOver1[$key])) {
					if($arrayWorkOver1[$key]['total_time'] > $arrayWorkOver2[$key]['work_time']) {
						$resultOverload['work_date'][] = $arrayWorkOver1[$key]['work_date'];
						$resultOverload['user'][] = $arrayWorkOver1[$key]['user'];
					}
				} else {
					break;
				}
			}
		}	
		
		foreach ($arrayWork as $key => $value) {
			foreach($arrayProject as $k => $v) {
				if($arrayWork[$key]['project_type'] == $arrayProject[$k]['id']) {
					$arrayWork[$key]['project_type'] = $arrayProject[$k]['project_type'];
				}
			}
		}
		return $arrayWork;
	}
	
	//
	public function processDateAllRange() {
		$arrayWork 		=	array();
		$arrayProject 		=		$this->listProject();
		$dateAllFrom        =       $_POST['date_all_from'];
        $dateAllTo          =       $_POST['date_all_to'];
        $projectFilter      =       $_POST['filter_project'];
		$queryTotal         =   	'';
        if($dateAllFrom == $dateAllTo && $projectFilter != '') {
            $queryWork      =   "SELECT * FROM `".TBL_WORK."` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) = STR_TO_DATE( '{$dateAllTo}', '%d/%m/%Y' ) AND `project_type` = '{$projectFilter}' ORDER BY `user`, `work_date` ASC";
            $queryTotal     =   "SELECT SUM(`real_duration`) AS `total_real`, SUM(`standard_duration`) AS `total_standard`, (SUM(`performance`)/ COUNT(`id`)) AS `total_performance`  FROM `".TBL_WORK."` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) = STR_TO_DATE( '{$dateAllTo}', '%d/%m/%Y' ) AND `project_type` = '{$projectFilter}' ORDER BY `user`, `work_date` ASC";
        } elseif ($dateAllFrom != $dateAllTo && $projectFilter != '') {
            $queryWork      =   "SELECT * FROM `".TBL_WORK."` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateAllFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateAllTo}', '%d/%m/%Y' ) AND `project_type` = '{$projectFilter}' ORDER BY `user`, `work_date` ASC";
            $queryTotal     =   "SELECT SUM(`real_duration`) AS `total_real`, SUM(`standard_duration`) AS `total_standard`, (SUM(`performance`)/ COUNT(`id`)) AS `total_performance`  FROM `".TBL_WORK."` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateAllFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateAllTo}', '%d/%m/%Y' ) AND `project_type` = '{$projectFilter}' ORDER BY `user`, `work_date` ASC";
        } elseif($dateAllFrom == $dateAllTo && $projectFilter == '') {
            $queryWork      =   "SELECT * FROM `".TBL_WORK."` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) = STR_TO_DATE( '{$dateAllTo}', '%d/%m/%Y' ) ORDER BY `user`, `work_date` ASC";
        } elseif($dateAllFrom != $dateAllTo && $projectFilter == '') {
            $queryWork      =   "SELECT * FROM `".TBL_WORK."` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateAllFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateAllTo}', '%d/%m/%Y' ) ORDER BY `user`, `work_date` ASC";
        }
        
        $arrayTotalFilter   =   $this->fetchAll($queryTotal);
        
        $arrayWork      	=   $this->fetchAll($queryWork);
        foreach ($arrayWork as $key => $value) {
            foreach($arrayProject as $k => $v) {
                if($arrayWork[$key]['project_type'] == $arrayProject[$k]['id']) {
                    $arrayWork[$key]['project_type'] = $arrayProject[$k]['project_type'];
                }
            }
        }
		return $arrayWork;
	}
	
	public function createSelectUser($id, $size, $name, $selected = null) {
		$arrayUser 	=	$this->listUser();
		$xhtml 		=	'<select id='.$id.' size='.$size.' name='.$name.'><option value="">Select Member</option>';
		foreach($arrayUser as $key => $value) :
			$selectedUser = ($value['id'] == $selected) ? 'selected="selected"' : '';
			$xhtml  .= 	'<option value="'.$value['id'].'" '.$selectedUser.'>'.$value['fullname'].'</option>';
		endforeach;
		$xhtml 		.=	'</select>';
		return $xhtml;
	}
	
	//
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
	 
	 public function findOverload($postUser, $dateFrom, $dateTo) {
		 $resultOverload 	=	array();
		 if($dateFrom != $dateTo) {
			 $queryWorkOver1 =   "SELECT SUM(`real_duration`) AS `total_time`, `work_date`, `user` FROM `".TBL_WORK."` WHERE `work_date` IN (SELECT `work_date` FROM `".TBL_WORKTIME."` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateTo}', '%d/%m/%Y' ) AND `change` = '0' AND `user` = {$postUser} ) AND `user` = {$postUser} GROUP BY `work_date`";
			 $queryWorkOver2 =   "SELECT `work_time`, `work_date`, `user` FROM `".TBL_WORKTIME."` WHERE `user` = {$postUser} AND `change` = '0' AND `work_date` IN ( SELECT `work_date` FROM `".TBL_WORK."` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$dateFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$dateTo}', '%d/%m/%Y' ) AND `user` = {$postUser} ) GROUP BY `work_date`";
		 	 $arrayWorkOver1 =   $this->fetchAll($queryWorkOver1);
        	 $arrayWorkOver2 =   $this->fetchAll($queryWorkOver2);
			 foreach($arrayWorkOver1 as $key => $value) {
				if(isset($arrayWorkOver1[$key])) {
					if($arrayWorkOver1[$key]['total_time'] > $arrayWorkOver2[$key]['work_time']) {
						$resultOverload['work_date'][] = $arrayWorkOver1[$key]['work_date'];
						$resultOverload['user'][] = $arrayWorkOver1[$key]['user'];
					}
				} else {
					break;
				}
			}
		 }
		 return $resultOverload;
	 }
	 
	 public function createWorkTime($postUser, $postFrom, $postTo, $arrayWork = null) {
		 $xhtml 	   =	'';
		 $totalBeingLate     =   0;
		 $workingDayTotal    =   0;
		 $OvertimeTotal      =   0;
		 $flagAbort          =   false;
		 $resultOverload 	 =	 $this->findOverload($postUser, $postFrom, $postTo);
		 if(isset($postUser) && trim($postUser) != '' && isset($postFrom) && trim($postFrom) != '' && isset($postTo) && trim($postTo) != '') {
			 if($postFrom != $postTo) {
				 $queryWt = "SELECT * FROM `".TBL_WORKTIME."` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '{$postFrom}', '%d/%m/%Y' ) AND STR_TO_DATE( '{$postTo}', '%d/%m/%Y' ) AND `user` = '{$postUser}' ORDER BY `user`, `work_date` ASC";
				 $arrayGetWorktime = $this->fetchAll($queryWt);
				 $xhtml 	.=		'<ul class="list-inline margin-t-10">';
				 	$xhtml  .= 			'<li>';
				 	$xhtml 	.=		'<ul class="list-inline">
										<li>Being late/ Leave early: </li>';
											foreach($arrayGetWorktime as $key => $value) {
												if(Helper::isWeekend($value['work_date']) == true) {
													continue;
												} else {
													$totalBeingLate     += ($value['delay'] + $value['unpaid'] + $value['paid'] + $value['others']);
												}
											}
											$xhtml  .=		'<li><strong>'.$totalBeingLate.'</strong></li>';
				 		$xhtml		.=		'</ul>';
				 	$xhtml		.=		'</li>';
					$xhtml 		.=		'<li>';
						$xhtml 	.=		'<ul class="list-inline">';
						$xhtml 	.=		'<li>Working day hour: </li>';
							foreach($arrayGetWorktime as $key => $value) {
								if(Helper::isWeekend($value['work_date']) == true) {
									continue;
								} else {
									$workingDayTotal += $value['work_time'];
								}
							}
							$xhtml .= '<li><strong>'.$workingDayTotal.'</strong></li>';
						$xhtml 	.=		'</ul>';
					$xhtml 		.=		'</li>';
					
					$xhtml 		.=		'<li>';
						$xhtml 	.=		'<ul class="list-inline"><li>Overtime: </li>';
							foreach($arrayGetWorktime as $key => $value) {
								if(Helper::isWeekend($value['work_date']) == true) {
									continue;
								} else {
									$OvertimeTotal += $value['overtime'];
								}
							}
							$xhtml 	.=	'<li><strong>'.$OvertimeTotal.'</strong></li>';
						$xhtml 	.=		'</ul>';
					$xhtml 		.=		'</li>';
					
					$xhtml 		.=		'<li>';
						$dayRealDur = 0;
						foreach($arrayWork as $key => $value) {
							if(Helper::isWeekend($value['work_date']) == true) {
								continue;
								$dayRealDur += 0;
							} else {
								$dayRealDur += $value['real_duration'];
							}
						}
						$xhtml  .=		'<ul class="list-inline"><li>Working real hour: </li><li class="label label-warning">'.$dayRealDur.'</li></ul>';
					$xhtml 		.=		'</li>';
					
					$xhtml 		.=		'<li><ul class="list-inline"><li>Capacity: </li><li class="label label-info">'.round((($dayRealDur / $workingDayTotal) * 100), 2).'%</li></ul></li></ul>';
					//Create Alert
					if($postFrom == $postTo) {
						if($dayRealDur > $workingDayTotal) {
							$xhtml .= '<div class="kode-alert kode-alert-icon kode-alert-click alert5"><i class="fa fa-warning"></i><a class="closed" href="#">x</a> The real time duration on <strong>'.$value['work_date'].'</strong> didnt input correctly, please check !!!</div>';
						}
					} else {
						if(!empty($resultOverload)) {
							foreach($resultOverload['work_date'] as $key => $value) {
								$xhtml .= '<div class="kode-alert kode-alert-icon kode-alert-click alert5"><i class="fa fa-warning"></i><a class="closed" href="#">x</a> The real time duration on <strong>'.$value.'</strong> didnt input correctly, please check !!!</div>';
							}
						}
					}
					/*$xhtml .= $dayRealDur . '<br />';
								
								$xhtml .= $workingDayTotal . '<br />';	*/
			 } else {
				 $queryWt = "SELECT * FROM `".TBL_WORKTIME."` WHERE STR_TO_DATE( `work_date`, '%d/%m/%Y' ) = STR_TO_DATE( '{$postTo}', '%d/%m/%Y' ) AND `user` = {$postUser} ORDER BY `work_date` ASC";
			 	 $arrayGetWorktime = $this->fetchAll($queryWt);
				 foreach($arrayGetWorktime as $key => $value) {
					if($value['change'] == '0') {
						$flagAbort = false;
					} elseif ($value['change'] == '1') {
						$flagAbort = true;
					}
					if(Helper::isWeekend($value['work_date']) == true) {
						continue;
					} else {
						$totalBeingLate     += ($value['delay'] + $value['unpaid'] + $value['paid'] + $value['others']);
					}
				 }
				
				foreach($arrayGetWorktime as $key => $value) {
					if(Helper::isWeekend($value['work_date']) == true) {
						continue;
					} else {
						$workingDayTotal += $value['work_time'];
					}
				 }
				 
				 foreach($arrayGetWorktime as $key => $value) {
					if(Helper::isWeekend($value['work_date']) == true) {
						continue;
					} else {
						$OvertimeTotal += $value['overtime'];
					}
					
				 }
				 
				 //Performance
				 $dayRealDur = 0;
				 foreach($arrayWork as $key => $value) {
					if(Helper::isWeekend($value['work_date']) == true) {
						$dayRealDur += 0;
					} else {
						$dayRealDur += $value['real_duration'];
					}
				 }
				 $xhtml 	.=		'<ul class="list-inline margin-t-10">
				 						<li>
											<ul class="list-inline">
												<li>Being late/ Leave early: </li>
												<li><strong>'.$totalBeingLate.'</strong></li>
											</ul>
										</li>
										<li>
											<ul class="list-inline">
												<li>Working day hour: </li>
												<li><strong>'.$workingDayTotal.'</strong></li>
											</ul>
										</li>
										<li>
											<ul class="list-inline">
												<li>Overtime: </li>
												<li><strong>'.$OvertimeTotal.'</strong></li>
											</ul>
										</li>
										<li>
											<ul class="list-inline">
												<li>Working real hour: </li>
												<li><strong>'.$dayRealDur.'</strong></li>
											</ul>
										</li>
										<li>
											<ul class="list-inline">
												<li>Capacity: </li>
												<li><strong>'.@round((($dayRealDur / $workingDayTotal) * 100), 2).'</strong></li>
											</ul>
										</li>
				 					</ul>';
								//Create Alert
								if($dayRealDur > $workingDayTotal) {
									if($flagAbort == false) {
										$xhtml .= '<div class="alert_wrapper"><div class="kode-alert kode-alert-icon kode-alert-click alert5"><i class="fa fa-warning"></i><a class="closed" href="#">x</a> The real time duration on <strong>'. $value['work_date'] .'</strong> didnt input correctly, please check !!!</div></div>';
									}
								}				
			 }
			 $xhtml .= '<div class="kode-alert kode-alert-icon alert4"><i class="fa fa-info"></i> （※）Capacity=Real duration/Working real hour --> hiện thị % lượng công việc làm trong ngày　（稼働率）<br />（※）Performance=Real duration/Standard duration --> hiện thị % tốc độ công việc　（パフォーマンス）</div>';
		 }
		 return $xhtml;
	 }
	 
	 public function createSelectFilter($selectedFiter) {
		 $arrayProject 		=		$this->listProject();
		 $xhtml 	=		'';
		 $xhtml 	.=		'<select class="form-control" id="filter_project" name="filter_project" style="margin-bottom: 0;"><option value="">Type of Project</option>';
			$selectedProject = (isset($selectedFiter) && $selectedFiter != '') ? 'selected="selected"' : '';
		foreach($arrayProject as $key => $value) {
			if($value['project_type'] == 'Newton Detail' || $value['project_type'] == 'New Coding Detail' || $value['project_type'] == 'FC Detail' || $value['project_type'] == 'Working') {
				continue;
			}
			
			$xhtml 	.= 		'<option value="'.$value['id'].'" '.$selectedProject.'>'.$value['project_type'].'</option>';
		}
		$xhtml 	.= '</select>';
		return $xhtml;
	 }
	 
	 public function createTimeline($arrayWork = array(), $postUsername, $dateFrom , $dateTo ) {
		 $xhtml = '';
		 if(!empty($arrayWork) && isset($postUsername) && $dateFrom == $dateTo) :
		 	$key_flag 			= 		false;
			$countArrayWork 	=       count($arrayWork);
			$colorDetail        =   	'';
			$maintenanceCheck   =       false;
			$newtonCheck        =       false;
			$fcCheck            =       false;
			$newCodingCheck     =       false;
			$domesticCheck      =       false;
			$researchCheck      =       false;
			$otherCheck         =       false;
			$arrayUser 			=		$this->listUser();
			$totalStandard      =       0;
			$totalReal          =       0;
			$totalPerformance   =       0;
		 	$xhtml .= "<div id='timeline'><ul>";
				foreach($arrayWork as $key => $value) :
					$newDate = DateTime::createFromFormat('d/m/Y', $value['work_date'])->format('Y-m-d');
					if($key_flag == false) { $xhtml .= '<li data-start="'.$newDate.'T08:30" data-end="'.$newDate.'T'.$value['start'].'" data-color="transparent"></li><li data-start="'.$newDate.'T12:00" data-end="'.$newDate.'T13:00" data-color="#AB82FF">Lunch Break</li><li data-start="'.$newDate.'T'.$value['end'].'" data-end="'.$newDate.'T17:30" data-color="transparent"></li>'; $key_flag= true;}
					foreach($arrayUser as $k => $v) :
						if($value['user'] == $v['id']) {
							$value['user'] = $v['nickname'];
						}
                	endforeach;
					$totalStandard  	+= 		$value['standard_duration'];
                	$totalReal      	+=      $value['real_duration'];
                	$totalPerformance 	+= 		$value['performance'];
                
                	$hourStart  		=   	substr($value['start'], 0, 2);
               		$minStart   		=   	number_format((substr($value['start'], 3, 2) / 60), 1);
                	$hourEnd    		=   	substr($value['end'], 0, 2);
                	$minEnd     		=   	number_format((substr($value['end'], 3, 2) / 60), 1);
					switch ($value['project_type']) {
						case 'Maintenance':
							$projectColor = 'rgb(149, 203, 255)';
							if($maintenanceCheck == false) { $colorDetail .= '<span class="badge" style="background-color: '.$projectColor.';">'.$value['project_type'].'</span>'; $maintenanceCheck = true; }
							$projectName  = $value['project_no'];
							break;
						case 'Newton':
							$projectColor = '#EE7621';
							if($newtonCheck == false) { $colorDetail .= '<span class="badge" style="background-color: '.$projectColor.';">'.$value['project_type'].'</span>'; $newtonCheck = true; }
							$projectName  = $value['project_no'];
							break;
						case 'FC':
							$projectColor = 'rgb(251, 194, 83)';
							if($fcCheck == false) { $colorDetail .= '<span class="badge" style="background-color: '.$projectColor.';">'.$value['project_type'].'</span>'; $fcCheck = true; }
							$projectName  = $value['project_name'] . ' (' . $value['page_name'] . ') ';
							break;
						case 'New Coding':
							$projectColor = 'rgb(255, 149, 192)';
							if($newCodingCheck == false) { $colorDetail .= '<span class="badge" style="background-color: '.$projectColor.';">'.$value['project_type'].'</span>'; $newCodingCheck = true; }
							$projectName  = (trim($value['page_name']) == '') ? $value['project_name'] . ' (' . $value['work_content'] . ') ' : $value['project_name'] . ' ('. $value['page_name'] . ') ';
							break;
						case 'Domestic':
							$projectColor = 'rgb(218, 152, 241)';
							if($domesticCheck == false) { $colorDetail .= '<span class="badge" style="background-color: '.$projectColor.';">'.$value['project_type'].'</span>'; $domesticCheck == true; }
							$projectName  = $value['project_name'];
							break;
						case 'Research':
							$projectColor = 'rgb(54, 248, 220)';
							if($researchCheck == false) { $colorDetail .= '<span class="badge" style="background-color: '.$projectColor.';">'.$value['project_type'].'</span>'; $researchCheck = true; }
							$projectName  = $value['project_name'];
							break;
						case 'Other':
							$projectColor = 'rgb(151, 255, 177)';
							if($otherCheck == false) { $colorDetail .= '<span class="badge" style="background-color: '.$projectColor.';">'.$value['project_type'].'</span>'; $otherCheck = true; }
							$projectName  = $value['work_content'];
							break;
					}
					if((($hourStart+$minStart) < 12 && ($hourEnd+$minEnd) < 12) || (($hourStart+$minStart) > 13 && ($hourEnd+$minEnd) > 13)) {
						$xhtml .= '<li data-start="'.$newDate.'T'. $value['start'] .'" data-end="'.$newDate.'T'.$value['end'].'" data-color="'.$projectColor.'">'.$projectName.'</li>';
						
					} elseif (($hourStart+$minStart) < 12 && $hourEnd == 12) {
						$xhtml .= '<li data-start="'.$newDate.'T'. $value['start'] .'" data-end="'.$newDate.'T12:00" data-color="'.$projectColor.'">'.$projectName.'</li>';
					} elseif($hourStart == 13 && ($hourEnd+$minEnd) > 13) {
						$xhtml .= '<li data-start="'.$newDate.'T13:00" data-end="'.$newDate.'T'.$value['end'].'" data-color="'.$projectColor.'">'.$projectName.'</li>';
					} elseif (($hourStart+$minStart) < 12 && ($hourEnd+$minEnd) > 13) {
						$xhtml .= '<li data-start="'.$newDate.'T'. $value['start'] .'" data-end="'.$newDate.'T12:00" data-color="'.$projectColor.'">'.$projectName.'</li>';
						$xhtml .= '<li data-start="'.$newDate.'T13:00" data-end="'.$newDate.'T'.$value['end'].'" data-color="'.$projectColor.'">'.$projectName.'</li>';
					}
				endforeach;
				$xhtml .= '</ul></div><div class="pull-right">'.$colorDetail.'</div>';
		 endif;
		 return $xhtml;
	 }
	 
	 public function createHighChart($userName, $dateFrom, $dateTo) {
		 $xhtml 	=		'';
		 if(isset($dateFrom) && isset($userName) && isset($dateTo) && trim($dateFrom) != '' && trim($dateTo) != '' && trim($userName) != '') : 
		 	$arrayProject 			=		$this->listProject();
		 	$dateFormat 			= 		'd/m/Y';
			$arrayResultChart 		= 		array();
            $strDays  				= 		'';
			$stringDate 			= 		$dateTo;
			$dateChartMonth 		= 		DateTime::createFromFormat($dateFormat, $stringDate)->format('m');
            $dateChartYear			= 		DateTime::createFromFormat($dateFormat, $stringDate)->format('Y');
			$numberDays 			= 		cal_days_in_month(CAL_GREGORIAN, $dateChartMonth, $dateChartYear);
			$chartQuery 			= 		"SELECT `work_date`, SUM(`real_duration`) AS `real_duration`, `project_type`, `user` FROM `".TBL_WORK."` WHERE `user` = '{$userName}' AND `work_date` LIKE '%/{$dateChartMonth}/{$dateChartYear}' GROUP BY `project_type`, `work_date` ORDER BY `work_date`";
		 	$arrayChart 			= 		$this->fetchAll($chartQuery);
			$chartContent 			= 		'series: [';
			$projectPercent 		=		'series: [{
												name: \'Project Percent\',
												colorByPoint: true,
												data: [';
			$projectMaintenance 	=		'series: [{
												name: \'Project Percent\',
												colorByPoint: true,
												data: [';
			foreach ($arrayChart as $key => $value) {
				foreach($arrayProject as $k => $v) {
					if($arrayChart[$key]['project_type'] == $arrayProject[$k]['id']) {
						$arrayChart[$key]['project_type'] = $arrayProject[$k]['project_type'];
					}
				}
			}
			
			for($i = 1; $i<= $numberDays; $i++) {
                
				if($i < $numberDays) {
					$strDays .= "'".$i ."', ";
				} else {
					$strDays .= "'".$i ."'";
				}
				/* if(empty($arrayChart[$i])) {
					$arrayChart[$i] = array();
				} */
				foreach($arrayChart as $key => $value) {
					$trimDate = (substr($value['work_date'], 0, 2) < 10) ? substr($value['work_date'], 1, 1) : substr($value['work_date'], 0, 2);

						$realNumber =  number_format($value['real_duration'], 1, '.', ' ');
						$arrayResultChart[$value['project_type']][$trimDate][$value['project_type']] = $realNumber;
						
					
					ksort($arrayResultChart[$value['project_type']]);
				}
				
			}
			
			foreach($arrayResultChart as $key => $value) {
                    
				for($i = 1; $i<= $numberDays; $i++) {
					if(array_key_exists($i, $value) == false) {
						$arrayResultChart[$key][$i][$key] = 0;
					}
				}
				
				ksort($arrayResultChart[$key]);
				
			}
			
			$arrayDataChart = array();
				$strData = '';
				foreach($arrayResultChart as $key => $value) {
					$arrayDataChart[$key]['name'] = $key;
					foreach($value as $k => $v) {
						$strData .= $v[$key] . ', ';
					}
				
				
				$strData = 'data: ['.$strData.']';
				//$strData = str_replace(', ]', ']', $strData);
				$arrayDataChart[$key]['data'] = $strData;
				$strData = '';
			}
			
			// Pie chart project
			$sqlPieChart = "SELECT count(`project_type`) as `project_count`, `project_type` FROM `".TBL_WORK."` WHERE `user` = '{$userName}' AND `work_date` LIKE '%/{$dateChartMonth}/{$dateChartYear}' GROUP BY `project_type`";
			$arrayPieChart = $this->fetchAll($sqlPieChart);
			$totalProjectCount = count($arrayPieChart);
			foreach ($arrayPieChart as $key => $value) {
				$arrayPieChart[$key]['project_count'] = $value['project_count'] / $totalProjectCount;
				foreach($arrayProject as $k => $v) {
					if($arrayPieChart[$key]['project_type'] == $arrayProject[$k]['id']) {
						$arrayPieChart[$key]['project_type'] = $arrayProject[$k]['project_type'];
					}
				}
			}
			
			// Maintenance Chart Project
			$arrayChartHour = array(
				'0.5~2.5h' => array('0.5', '2.5'), '3h~4.5h' => array('3', '4.5'), '5h~8h' => array('5', '8')
			);
			foreach($arrayChartHour as $key => $value) {
				$queryMaintenanceChart = "SELECT COUNT(`id`) AS `{$key}` FROM `".TBL_WORK."` WHERE `real_duration` BETWEEN '{$value[0]}' AND '{$value[1]}' AND `project_type` = '1' AND `user` = '{$userName}' AND `work_date` LIKE '%/{$dateChartMonth}/{$dateChartYear}'";
				$arrayMaintenanceSum[]   = $this->fetchAll($queryMaintenanceChart);
			}
			
			foreach($arrayDataChart as $key => $value) :
				$chartContent .= "{name: '". $key ."',";
				$chartContent .= $value['data'] . ', color: getColor[\''.$key.'\']},';
			endforeach;
			$chartContent 	  .= ']';
			
			// Project Percent
			foreach($arrayPieChart as $key => $value) :
				$projectPercent .= "{ name: '".$value['project_type']."', y: ".$value['project_count'].", color: getColor['".$value['project_type']."']},";
			endforeach;
			$projectPercent   .= ']}]';
			
			// Project Maintenance
			$flagNull = 0;
			foreach($arrayMaintenanceSum as $key => $value) :
				foreach($value[0] as $k => $v) :
					if($v == '0') {
						$v = 0;
						$projectMaintenance .= "{ name: '".$k."', y: ".$v."},";
						$flagNull++;	
					} else {
						$projectMaintenance .= "{ name: '".$k."', y: ".$v."},";	
					}
				endforeach;
			endforeach;
			$projectMaintenance .= ']}]';
			$xhtml .= '<script type="text/javascript">
							var getColor  = {
								"Maintenance" : "#7cb5ec",
								"Research" : "#434348",
								"Newton" : "#90ed7d",
								"New Coding" : "#f7a35c",
								"Other" : "#ed561b",
								"Domestic" : "#dddf00",
								"FC" : "#24cbe5"
							};
						';
				$xhtml .= '$(function () {
						$(\'#chartContainer\').highcharts({
							chart: {
								type: \'column\'
							},
							title: {
								text: \'Working Chart (Real dur) '.$dateChartMonth . '/' . $dateChartYear.'\'
							},
							xAxis: {
								categories: ['.$strDays.']
							},
							yAxis: {
								min: 0,
								tickInterval: 1,
								breaks: [{
									from: 5,
									to: 10,
									breakSize: 1
								}],
								title: {
									text: \'Hours\'
								},
								stackLabels: {
									enabled: false,
									style: {
										fontWeight: \'bold\',
										color: (Highcharts.theme && Highcharts.theme.textColor) || \'gray\'
									}
								}
							},
							legend: {
								align: \'right\',
								x: -30,
								verticalAlign: \'top\',
								y: 25,
								floating: true,
								backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || \'white\',
								borderColor: \'#CCC\',
								borderWidth: 1,
								shadow: false
							},
							tooltip: {
								formatter: function () {
									return \'<b>\' + this.x + \'</b><br/>\' +
										this.series.name + \': \' + this.y + \'<br/>\' +
										\'Total: \' + this.point.stackTotal;
								}
							},
							plotOptions: {
								column: {
									stacking: \'normal\',
									dataLabels: {
										enabled: false,
										color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || \'white\',
										style: {
											textShadow: \'0 0 3px black\'
										}
									}
								}
							},'.$chartContent.'
						});
					});';
			$xhtml .= '</script>';
			
			$xhtml .= '<script type="text/javascript">
						var getColor  = {
								"Maintenance" : "#7cb5ec",
								"Research" : "#434348",
								"Newton" : "#90ed7d",
								"New Coding" : "#f7a35c",
								"Other" : "#ed561b",
								"Domestic" : "#dddf00",
								"FC" : "#24cbe5"
							};
					';
				$xhtml .= '$(function () {
						$(\'#project_chart\').highcharts({
							chart: {
								plotBackgroundColor: null,
								plotBorderWidth: null,
								plotShadow: false,
								type: \'pie\'
							},
							title: {
								text: \'Project Working\'
							},
							tooltip: {
								pointFormat: \'{series.name}: <b>{point.percentage:.1f}%</b>\'
							},
							plotOptions: {
								pie: {
									allowPointSelect: true,
									cursor: \'pointer\',
									size: 200,
									dataLabels: {
										enabled: true,
										format: \'<b>{point.name}</b>: {point.percentage:.1f} %\',
										style: {
											color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || \'black\'
										}
									}
								}
							},'.$projectPercent.'
						});
					});';
			$xhtml .= '</script>';
			
			if($flagNull >= 3) {
				$xhtml .= '<script type="text/javascript">';
					$xhtml .= '$(function () {';
					$xhtml .= '$(\'#project_maintenance_chart\').highcharts({
									chart: {
										plotBackgroundColor: null,
										plotBorderWidth: null,
										plotShadow: false,
										type: \'pie\'
									},
									title: {
										text: \'This User did not work on maintenance project\'
									},
								});
							});';
				$xhtml .= '</script>';
			} else {
			$xhtml .= '<script type="text/javascript">';
				$xhtml .= '$(function () {
						$(\'#project_maintenance_chart\').highcharts({
							chart: {
								plotBackgroundColor: null,
								plotBorderWidth: null,
								plotShadow: false,
								type: \'pie\'
							},
							title: {
								text: \'Maitenance Working\'
							},
							tooltip: {
								pointFormat: \'{series.name}: <b>{point.percentage:.1f}%</b>\'
							},
							plotOptions: {
								pie: {
									allowPointSelect: true,
									cursor: \'pointer\',
									size: 200,
									dataLabels: {
										enabled: true,
										format: \'<b>{point.name}</b>: {point.percentage:.1f} %\',
										style: {
											color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || \'black\'
										}
									}
								}
							}, '.$projectMaintenance.'
						});
					});';
			$xhtml .= '</script>';
			}
		 endif;
		 return $xhtml;
	 }
	 
	 public function deletePersonal($id) {
	     if(isset($id)) {
	             //$ids 		=	$this->createWhereDeleteSQL($id);
	             $query     	=   "DELETE FROM `".TBL_WORK."` WHERE `id` IN ({$id})";
	             $this->query($query);
	             return array('id' => $id, 'success' => true);
	     }
	 }
}