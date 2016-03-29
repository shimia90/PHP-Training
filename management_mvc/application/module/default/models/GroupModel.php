<?php
class GroupModel extends Model {
	/*public function __construct(){
		
	}*/
	
	public function listTeamUser($team, $arrayDate = null) {
		$xhtml 			=		'';
		$arrayUser 		=		array();
		$query 			=		"SELECT * FROM ".TBL_USER." WHERE `team` = '".$team."'";
		$arrayUser 		=		$this->fetchAll($query);
		$dateFrom 		=		(!empty($arrayDate)) ? $arrayDate['date_from'] : date("d/m/Y") ;
		$dateTo			=		(!empty($arrayDate)) ? $arrayDate['date_to'] : date("d/m/Y") ;
		foreach($arrayUser as $key => $value) {
			$xhtml			.=		'<tr>';
			if($value['position'] 	==	'leader') {
				$xhtml 	.=		'<td class="text-center">'.ucfirst($value['position']).'</td>'	;
			} else {
				$xhtml 	.=		'<td class="text-center"></td>'	;
			}
				$xhtml 	.=		'<td class="text-center"><a href="'.URL::createLink('default', 'personal', 'index', array('user' => $value['id'], 'date_from' => $dateFrom, 'date_to' => $dateTo)).'">'.$value['fullname'].'</a></td>';
				$xhtml 	.=		'<td class="text-center">'.$this->listProjectUser($value['id'], $arrayDate).'</td>'; // Project
				$xhtml 	.=		'<td class="text-center">'.$this->createLabelDuration($this->getDuration($value['id'], $arrayDate, 'standard_duration')).'</td>'; // Standard Duration
				$xhtml 	.=		'<td class="text-center">'.$this->createLabelDuration($this->getDuration($value['id'], $arrayDate, 'real_duration')).'</td>'; // Real Duration
				$xhtml 	.=		'<td class="text-center">'.$this->getPerformance($this->getDuration($value['id'], $arrayDate, 'standard_duration'), $this->getDuration($value['id'], $arrayDate, 'real_duration')).'</td>'; // Performance
				$xhtml 	.=		'</tr>';
		}
		return $xhtml;
	}
	
	public function addLabel($name) {
		
		switch ($name) {
			case 'Maintenance':
				$name 	=	'<span class="label" style="background-color: #7cb5ec;">'.$name.'</span>';
				break;
			case 'New Coding':
				$name 	=	'<span class="label" style="background-color: #f7a35c;">'.$name.'</span>';
				break;
			case 'Domestic':
				$name 	=	'<span class="label" style="background-color: #dddf00;">'.$name.'</span>';
				break;
			case 'Newton':
				$name 	=	'<span class="label" style="background-color: #90ed7d;">'.$name.'</span>';
				break;
			case 'Research':
				$name 	=	'<span class="label" style="background-color: #434348;">'.$name.'</span>';
				break;
			case 'Other':
				$name 	=	'<span class="label" style="background-color: #ed561b;">'.$name.'</span>';
				break;
			case 'FC':
				$name 	=	'<span class="label" style="background-color: #24cbe5;">'.$name.'</span>';
				break;
		}
		return $name;
	}
	
	public function createLabelDuration($timeDuration) {
		$xhtml 			=		'';
		if((float)$timeDuration <= 6) {
			$xhtml 		=		'<span class="label" style="background-color: #ed561b;">'.$timeDuration.'</span>';
		} else if((float)$timeDuration >= 7 && (float)$timeDuration <= 8) {
			$xhtml 		=		'<span class="label" style="background-color: #7cb5ec;">'.$timeDuration.'</span>';
		} else if((float)$timeDuration > 8){
			$xhtml 		=		'<span class="label" style="background-color: #FF1493;">'.$timeDuration.'</span>';
		}
		
		return $xhtml;
	}
	
	public function listProjectType() {
		$arrayProject 		=		array();
		$query 				=		"SELECT * FROM `".TBL_PROJECT."`";
		$arrayProject 		=		$this->fetchAll($query);
		return $arrayProject;	
	}
	
	
	public function listProjectUser($user, $arrayDate = null) {
		$xhtml 							=		'';
		$arrayProject 					=		$this->listProjectType();
		$arrayWorkProject 				=		array();
		$query 							=		'';
		if(!empty($arrayDate)) {
			if($arrayDate['date_from'] == $arrayDate['date_to']) {
				$query 				=		"SELECT `project_type` FROM `".TBL_PROJECT."` WHERE `id` IN (SELECT `project_type` FROM `".TBL_WORK."` WHERE `user` = '".$user."' AND STR_TO_DATE( `work_date`, '%d/%m/%Y' ) = STR_TO_DATE( '".$arrayDate['date_to']."', '%d/%m/%Y' ) ORDER BY `work_date` ASC)";
				$arrayWorkProject 				=		$this->fetchAll($query);
			} else {
				// date_from != date_to
				$query 	=	"SELECT `project_type` FROM `".TBL_PROJECT."` WHERE `id` IN (SELECT `project_type` FROM `".TBL_WORK."` WHERE `user` = '".$user."' AND STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '".$arrayDate['date_from']."', '%d/%m/%Y' ) AND STR_TO_DATE( '".$arrayDate['date_to']."', '%d/%m/%Y' ) ORDER BY `work_date` ASC)";
				$arrayWorkProject 				=		$this->fetchAll($query);
			}
			
			foreach($arrayWorkProject as $key => $value) {
				$xhtml .= $this->addLabel($value['project_type']) . ' ' ;
			}
		}
		
		
		
		return $xhtml;
	}
	
	public function getDuration($user, $arrayDate = null, $field = null) {
		$xhtml 							=		'';
		$arrayWork						=		array();
		if(!empty($arrayDate)) {
			if($arrayDate['date_from'] == $arrayDate['date_to']) {
				if($field == null) {
					// $field = null	
				} else {
					$query			=		"SELECT SUM(`".$field."`) AS `total_standard` FROM `".TBL_WORK."` WHERE `user` = '".$user."' AND STR_TO_DATE( `work_date`, '%d/%m/%Y' ) = STR_TO_DATE( '".$arrayDate['date_to']."', '%d/%m/%Y' )";
					$arrayWork		=		$this->fetchAll($query);
				}
			} else {
				// date_from != date_to
					$query 			=		"SELECT SUM(`".$field."`) AS `total_standard` FROM `".TBL_WORK."` WHERE `user` = '".$user."' AND STR_TO_DATE( `work_date`, '%d/%m/%Y' ) BETWEEN STR_TO_DATE( '".$arrayDate['date_from']."', '%d/%m/%Y' ) AND STR_TO_DATE( '".$arrayDate['date_to']."', '%d/%m/%Y' )";
					$arrayWork		=		$this->fetchAll($query);
					//echo $query;
					
			}
			
			foreach($arrayWork as $key => $value) {
				$xhtml .= $value['total_standard'];
			}
			
			
		}
		return $xhtml;
	}
	
	public function getPerformance($strStandard, $strReal) {
		$xhtml 			=		'';
		if(trim($strReal) != '' && $strReal > 0) {
			$xhtml 		=		round($strStandard / $strReal, 2) * 100 . '%';
		}
		
		// <div class="easypie margin-b-50" data-percent="82"><span>82%</span>New Visit</div>

		return $xhtml;
	}
	
	public function isWeekend($date) {
		//$inputDate = DateTime::createFromFormat("d-m-Y", $date, new DateTimeZone("Europe/Amsterdam"));
		$inputDate = DateTime::createFromFormat('d/m/Y', $date, new DateTimeZone("Asia/Ho_Chi_Minh"));
		return $inputDate->format('N') >= 6;
	}
	
	public function excludeWeekend() {
		$workdays = array();
		$type = CAL_GREGORIAN;
		$month = date('n'); // Month ID, 1 through to 12.
		$year = date('Y'); // Year in 4 digit 2009 format.
		$day_count = cal_days_in_month($type, $month, $year); // Get the amount of days
		
		//loop through all days
		for ($i = 1; $i <= $day_count; $i++) {
		
				$date = $year.'/'.$month.'/'.$i; //format date
				$get_name = date('l', strtotime($date)); //get week day
				$day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
		
				//if not a weekend add day to array
				if($day_name != 'Sun' && $day_name != 'Sat'){
					$workdays[] = $i;
				}
		
		}
		return $workdays;
	}
	
	public function createChart($team, $arrayDate = null) {
		$xhtml 			=		'';
		$arrayWork  	=		array();
		$arrayData 		=		array();
		$arrayDays 		=		array();
		$strData 		=		'';
		$strDays  		= 		'';
		$strTemp 		=		'';
		$numberDays 	= 		'';
		if(!empty($arrayDate)) {
				$arrayPostDate 		=		explode('/', $arrayDate['date_to']);
				$month 				=		$arrayPostDate[1];
				$year 				=		$arrayPostDate[2];
				//$numberDays 		= 		cal_days_in_month(CAL_GREGORIAN, $month, $year);
				$numberDays 		=		$this->excludeWeekend();
				
				for($i = 0; $i< count($numberDays); $i++) {
                
                    /*if($i < count($numberDays)) {
                        $strDays .= "'".$i ."', ";
                    } else {
                        $strDays .= "'".$i ."'";
                    }*/
					
					$strDays .= "'".$numberDays[$i ]."', ";
				}
				$query 				=		"SELECT `work_date`, SUM(`real_duration`) AS `real_duration`, `u`.`fullname` AS `user` FROM `".TBL_WORK."` AS `w` INNER JOIN `".TBL_USER."` AS `u` ON `w`.`user` = `u`.id WHERE `user` IN ( SELECT `id` FROM `".TBL_USER."` WHERE `team` = '".$team."') AND `work_date` LIKE '%/{$month}/{$year}' GROUP BY `user`, `work_date`";
				// SELECT `work_date`, SUM(`real_duration`) AS `real_duration`, `u`.`fullname` AS `user` FROM `work` AS `w` INNER JOIN `user` AS `u` ON `w`.`user` = `u`.id WHERE `user` IN ( SELECT `id` FROM `user` WHERE `team` = '1') AND `work_date` LIKE '%/02/2016' GROUP BY `user`, `work_date`
				$arrayWork 			=		$this->fetchAll($query);
			
			foreach($arrayWork as $key => $value) {
				
				$arrayData[$value['user']][$value['work_date']] 	=	$value['real_duration'];	
			}
			
			
			for($i = 0; $i < count($numberDays); $i++) {
				if( $numberDays[$i] < 10 ) {
					$strTemp 			=		'0'.$numberDays[$i].'/'.$month.'/'.$year;	
				} else {
					$strTemp 			=		 $numberDays[$i].'/'.$month.'/'.$year;
				}
				
				$arrayDays[$i] 	=	$strTemp;
			}
			$arrayDays		=		array_values($arrayDays);
			
			for($i = 0; $i < count($arrayDays); $i++) {
				foreach($arrayData as $key => $value) {
					if(array_key_exists($arrayDays[$i], $value)) {
						continue;
					} else {
						$arrayData[$key][$arrayDays[$i]] 	=	0;
					}
					
				}
			}
			
			
			
			foreach($arrayData as $key => $value) {
				ksort($arrayData[$key], 1);
			}
			
			$strData 	=	'[';
			foreach($arrayData as $key => $value) {
				$strData 	.=		"{
										name: '".$key."',
										data: [
									";
				foreach($value as $k => $v) {
					$strData 	.=	$v . ",";
				}
				$strData 	.=		"]},";
			}
			$strData 	.=	']';

			$xhtml 		.=		'<script type="text/javascript">
									$(document).ready(function(e) {
										$(function () {
											$(\'#chartist-line\').highcharts({
												title: {
													text: \'Monthly Team Working\',
													x: -20 //center
												},
												xAxis: {
													categories: ['.$strDays.']
												},
												yAxis: {
													title: {
														text: \'Hours\'
													},
													plotLines: [{
														value: 0,
														width: 1,
														color: \'#808080\'
													}]
												},
												tooltip: {
													valueSuffix: \'hours\'
												},
												legend: {
													layout: \'vertical\',
													align: \'right\',
													verticalAlign: \'middle\',
													borderWidth: 0
												},
												series: '.$strData.'
											});
										});
									});
									</script>';
		}
		
		return $xhtml;
	}
}