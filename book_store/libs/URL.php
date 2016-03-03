<?php
class URL {
    /**
     * 
     */
    public static function createLink($module, $controller, $action, $params = null) {
        $linkParams     =       '';
        if(!empty($params)) {
            foreach ($params as $key => $value) {
                $linkParams    .=   "&{$key}={$value}";
            }
        }
       $url = 'index.php?module='.$module.'&controller='.$controller.'&action='.$action . $linkParams;
       return $url; 
    }
	
	public static function redirect($module, $controller, $action, $params = null) {
	    $link  =   self::createLink($module, $controller, $action, $params);
		header("location: ". $link);
		exit();
	}
	
	public static function checkRefreshPage($value, $module, $controller, $action, $params = null) {
	    if(Session::get('token') == $value) {
			Session::delete('token');
			URL::redirect($module, $controller, $action);
		} else {
			Session::set('token', $value);
		}
	}
}