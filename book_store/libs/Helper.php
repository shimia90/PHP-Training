<?php
class Helper {
    
    // Create Button
    public static function cmsButton($name, $id, $link, $icon, $type = 'new') {
		$xhtml 	= 	'<li class="button" id="'.$id.'">';
		if($type == 'new') {
			$xhtml .=	'<a class="modal" href="'.$link.'"><span class="'.$icon.'"></span>'.$name.'</a>';
		} else if($type == 'submit') {
			$xhtml .=	'<a class="modal" href="#" onClick="javascript:submitForm(\''.$link.'\');"><span class="'.$icon.'"></span>'.$name.'</a>';
		}
		$xhtml .=	'</li>';
        return $xhtml;
    }
    
    // Format Date
    public static function formatDate($format, $value) {
        $result = '';
        if(!empty($value) && $value != '0000-00-00') {
            $result     =   date($format, strtotime($value));
        }
        return $result;
    }
    
    // Create Icon Status
    public static function cmsStatus($statusValue, $link, $id) {
        $strStatus  =   ($statusValue == 0) ? 'unpublish' : 'publish';
        $xhtml      =   '<a href="javascript:changeStatus(\''.$link.'\');" class="jgrid" id="status-'.$id.'">
                        	<span class="state '.$strStatus.'"></span>
                        </a>';
        return $xhtml;
    }
	
	// Create Icon Group ACP
    public static function cmsGroupACP($groupAcpValue, $link, $id) {
        $strGroupACP  	=   ($groupAcpValue == 0) ? 'unpublish' : 'publish';
        $xhtml      	=   '<a href="javascript:changeGroupACP(\''.$link.'\');" class="jgrid" id="group-acp-'.$id.'">
                        	<span class="state '.$strGroupACP.'"></span>
                        </a>';
        return $xhtml;
    }
	
	/**
	 * Sort
	 * @param unknown $name
	 * @param unknown $column
	 * @param unknown $columnPost
	 * @param unknown $orderPost
	 */
    public static function cmsLinkSort($name, $column, $columnPost, $orderPost) {
		$img 	    =	'';
		$order      =   ($orderPost == 'desc') ? 'asc' : 'desc';
		if($column == $columnPost) {
			$img 	=	'<img src="'.TEMPLATE_URL.'admin/main/images/admin/sort_'.$orderPost.'.png" alt="" />';
		}
		$xhtml 	=	'<a href="#" onclick="javascript:sortList(\''. $column .'\', \''. $order .'\')">'.$name. $img .'</a>';
		return $xhtml;
    }
    
    // Create Select Box
    public static function cmsSelectBox($name, $class, $arrValue, $keySelect = 'default') {
        $xhtml        =   '<select name="'.$name.'" class="'.$class.'">';
    		foreach($arrValue as $key => $value) {
    		    if($key == $keySelect) {
    		        $xhtml    .=      '<option value="'.$key.'" selected="selected">'.$value.'</option>';
    		    } else {
    		        $xhtml    .=      '<option value="'.$key.'">'.$value.'</option>';
    		    }
    		    
    		}				
    	$xhtml		.=	 '</select>';
    	return $xhtml;
    }
    
    public static function cmsRowForm($lblName, $input, $require = false) {
        $strRequired        =       '';
        if($require == true) {
            $strRequired  .=  '<span class="star">&nbsp;*</span>';
        }
        $xhtml      =       '<li><label>'.$lblName. $strRequired .'</label>'. $input . '</li>';
        return $xhtml;
    }
    
    /**
     * CREATE INPUT
     * @param unknown $type
     * @param unknown $name
     * @param unknown $id
     * @param unknown $value
     * @param unknown $class
     * @param unknown $size
     * @return string
     */
    public static function cmsInput($type, $name, $id, $value, $class, $size) {
        $xhtml      =       '<input type="'.$type.'" name="'.$name.'" id="'.$id.'" value="'.$value.'"
							class="'.$class.'" size="'.$size.'">';
        
        return $xhtml;
    }
    
}