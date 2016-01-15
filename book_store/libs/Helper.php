<?php
class Helper {
    public static function cmsButton($name, $id, $link, $icon) {
        $xhtml = '<li class="button" id="'.$id.'"><a class="modal" href="'.$link.'"><span
						class="'.$icon.'"></span>'.$name.'</a></li>';
        return $xhtml;
    }
}