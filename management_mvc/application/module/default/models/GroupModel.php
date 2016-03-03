<?php
class GroupModel extends Model {
	/*public function __construct(){
		
	}*/
	
	public function listTeamUser($team, $arrayDate = null) {
		$xhtml 			=		'';
		$arrayUser 		=		array();
		$query 			=		"SELECT * FROM ".TBL_USER." WHERE `team` = '".$team."'";
		$arrayUser 		=		$this->fetchAll($query);
		foreach($arrayUser as $key => $value) {
			$xhtml			.=		'<tr>';
			if($value['position'] 	==	'leader') {
				$xhtml 	.=		'<td class="text-center">'.ucfirst($value['position']).'</td>'	;
			} else {
				$xhtml 	.=		'<td class="text-center"></td>'	;
			}
				$xhtml 	.=		'<td class="text-center"><a href="'.URL::createLink('default', 'personal', 'index', array('user' => $value['nickname'])).'">'.$value['fullname'].'</a></td>';
				$xhtml 	.=		'<td class="text-center">'.$this->listProjectUser($value['nickname'], $arrayDate).'</td>'; // Project
				$xhtml 	.=		'<td class="text-center"></td>'; // Standard Duration
				$xhtml 	.=		'<td class="text-center"></td>'; // Real Duration
				$xhtml 	.=		'<td class="text-center"></td>'; // Performance
				$xhtml 	.=		'</tr>';
		}
		return $xhtml;
	}
	
	public function listProjectUser($user, $arrayDate = null) {
		$xhtml 	=	'';
		if(!empty($arrayDate)) {
				
		}
		
		return $arrayDate;
	}
}