<?php
class URL {
    /**
     * 
     */
    public static function createLink($module, $controller, $action) {
       $url = 'index.php?module='.$module.'&controller='.$controller.'&action='.$action;
       return $url; 
    }
}