<?php
class IndexModel extends Model{
    
    private $_columns = array(	 
								 'id',
								 'username',
								 'email',
								 'fullname',
								 'password',
								 'created',
								 'created_by',
								 'modified',
								 'modified_by',
								 'status',
								 'ordering',
								 'group_id'
							);
    
	/**
	 * 
	 */
    public function __construct() {
        parent::__construct();
        $this->setTable(TBL_USER);
    }
	
	/**
	 * 
	 * @param unknown $arrayParam
	 * @param string $option
	 */
	public function saveItem($arrayParam, $option = null) {
	    if($option['task'] == 'user-register') {
	        $arrayParam['form']['password'] 		= 	md5($arrayParam['form']['password']);
			$arrayParam['form']['register_date'] 	= 	date('Y-m-d H:m:s', time());
			$arrayParam['form']['register_ip'] 		= 	@$_SERVER[REMOTE_ADDR];
			$arrayParam['form']['status'] 			= 	0;
	        $data = array_intersect_key($arrayParam['form'], array_flip($this->_columns));
	        
	        $this->insert($data);
	        //Session::set('message', array('class' => 'success', 'content' => 'Data was inserted successfully'));
	        return $this->lastID();
	    }
	}
	
	public function infoItem($arrParam, $option = null) {
	    if($option == null) {
	        $email 		    =	    $arrParam['form']['email'];
	        $password 		=	md5($arrParam['form']['password']);
	        $query[] 		=	"SELECT `u`.`id`, `u`.`fullname`, `u`.`email`, `u`.`username` , `u`.`group_id`, `g`.`group_acp`";
	        $query[] 		=	"FROM `user` AS `u` LEFT JOIN `group` AS `g` ON `u`.`group_id` = `g`.`id`";
	        $query[] 		=	"WHERE `email` = '{$email}' AND `password` = '{$password}'";
	        	
	        $query 			=	implode(" ", $query);
	        $result 		=	$this->fetchRow($query);
	        return $result;
	    }
	}
	
	/**
	 *
	 * @param unknown $arrParam
	 * @param string $option
	 * @return multitype:unknown
	 */
	public function listItems($arrParam, $option = null) {
	    if($option['task'] == 'book-special') {
	        $query[]  		=   "SELECT `id`, `name`, `picture`, `description`";
	        $query[]  		=   "FROM `".TBL_BOOK."`";
	        $query[]        =   "WHERE `status` = 1 AND `special` = 1";
	        $query[]        =   "ORDER BY `ordering` ASC";
	        $query[]        =   "LIMIT 2,0";
	
	        $query  		=   implode(" ", $query);
	        $result   		=   $this->fetchAll($query);
	        return $result;
	    }
	}
}