<?php
class Helper {
    
    // Create Button
    public static function cmsButton($name, $id, $link, $icon) {
        $xhtml = '<li class="button" id="'.$id.'"><a class="modal" href="'.$link.'"><span
						class="'.$icon.'"></span>'.$name.'</a></li>';
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
    public static function cmsStatus($statusValue) {
        $strStatus  =   ($statusValue == 0) ? 'unpublish' : 'publish';
        $xhtml      =   '<a href="javascript:void(0);" class="jgrid">
                        	<span class="state '.$strStatus.'"></span>
                        </a>';
        return $xhtml;
    }
}