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
	
	// Create Title Sort
    public static function cmsLinkSort($name, $column, $columnPost, $orderPost) {
        // <a href="#" onclick="Joomla.tableOrder">ID<img src="" alt="" /></a>
		$img 	=	'';
		if($column == $columnPost) {
			$img 	=	'<img src="'.TEMPLATE_URL.'admin/main/images/admin/sort_'.$orderPost.'.png" alt="" />';
		}
		$xhtml 	=	'<a href="#" onclick="">'.$name. $img .'</a>';
    }
    
}