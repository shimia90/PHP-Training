<?php
class IndexModel extends Model{
	public function __construct(){
		parent::__construct();
	}
	
	public function infoItem($arrParam, $option = null) {
		if($option == null) {
			$username 		=	$arrParam['form']['username'];
			$password 		=	md5($arrParam['form']['passwd']);
			$query[] 		=	"SELECT `u`.`id`, `u`.`fullname`, `u`.`email`, `u`.`group_id`, `g`.`group_acp`";
			$query[] 		=	"FROM `user` AS `u` LEFT JOIN `group` AS `g` ON `u`.`group_id` = `g`.`id`";
			$query[] 		=	"WHERE `username` = '{$username}' AND `password` = '{$password}'";
			
			$query 			=	implode(" ", $query);
			$result 		=	$this->fetchRow($query);
			return $result;
		}
	}
}