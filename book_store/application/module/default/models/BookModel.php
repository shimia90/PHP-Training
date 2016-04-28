<?php
class BookModel extends Model{
    
    private $_columns = array('id', 'name', 'description', 'price', 'sale_off', 'picture' , 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'category_id');
	
	private $_userInfo 		=		array();
    
	/**
	 * 
	 */
    public function __construct() {
        parent::__construct();
        $this->setTable(TBL_BOOK);
		
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
	    if($option['task'] == 'books-in-cat') {
	        $catID          =   $arrParam['category_id'];
    		$query[]  		=   "SELECT `id`, `name`, `picture`, `description`";
    		$query[]  		=   "FROM `$this->table`";
    		$query[]        =   "WHERE `status` = 1 AND `category_id` = '$catID'";
    		$query[]        =   "ORDER BY `ordering` ASC";
    		
    		$query  		=   implode(" ", $query);
    		$result   		=   $this->fetchAll($query);
    		return $result;
	    }
	    
	    if($option['task'] == 'book-relate') {
	        
	        $bookID         =   $arrParam['book_id'];
	        $queryCate      =   "SELECT `category_id` FROM `".TBL_BOOK."` WHERE `id` = '$bookID'";
	        $resultCate     =   $this->fetchRow($queryCate);
	        $catID          =   $resultCate['category_id'];
	        
	        $query[]  		=   "SELECT `id`, `name`, `picture`";
	        $query[]  		=   "FROM `$this->table`";
	        $query[]        =   "WHERE `status` = 1 AND `category_id` = '$catID' AND `id` <> '$bookID'";
	        $query[]        =   "ORDER BY `ordering` ASC";
	    
	        $query  		=   implode(" ", $query);
	        $result   		=   $this->fetchAll($query);
	        return $result;
	    }
	}
	
	/**
	 *
	 * @param unknown $arrayParam
	 * @param string $option
	 */
	public function infoItem($arrayParam, $option = null) {
	    if($option['task'] == 'get-cat-name') {
	        
	        $query[]              =   "SELECT `name`";
	        $query[]              =   "FROM `".TBL_CATEGORY."`";
	        $query[]              =   "WHERE `id` = '{$arrayParam['category_id']}'";
	        $query                =   implode(' ', $query);
	        $result               =   $this->fetchRow($query);
	        return $result['name'];
	    }
	    
	    if($option['task'] == 'book-info') {

	        $query                =    "SELECT `id`, `name`, `price`, `sale_off`, `picture`, `description` FROM `".TBL_BOOK."` WHERE `id` = '".$arrayParam['book_id']."'";
	        $result               =    $this->fetchRow($query);
	        return $result;
	    }
	}
	
}