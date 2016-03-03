<?php
class UserModel extends Model{
    
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
								 'register_date',
								 'register_ip',
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
}