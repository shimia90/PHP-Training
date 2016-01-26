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
    
    /**
     * Create Function Select
     * @param unknown $arrayUsers
     * @param unknown $id
     * @param unknown $class
     * @param string $firstText
     * @param string $selected
     * @return string
     */
    public static function createUserSelect($arrayUsers, $id, $class, $firstText = null, $selected = null) {
        $xhtml  =   '';
        if(!empty($arrayUsers)) :
            $xhtml      .=       '<select id="'.$id.'" size="1" name="'.$id.'" class="'.$class.'" aria-controls="example">';
                $xhtml  .=       '<option value="">'.$firstText.'</option>';
            foreach($arrayUsers as $key => $value) :
                $xhtml  .=       '<option value="'.$value['id'].'">'.$value['fullname'].'</option>';
            endforeach;
            $xhtml      .=       '</select>';
        endif;
        return $xhtml;
    }
    
    /**
     * 
     * @param unknown $messageStrong
     * @param unknown $messageNormal
     * @return string
     */
    public static function createAlert($messageStrong, $messageNormal) {
        $xhtml      =       '';
        if(trim($messageStrong != '' || trim($messageNormal) != '')) {
            $xhtml      .=      '<div class="alert alert-error">
                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                  <strong>'.$messageStrong.' </strong> '.$messageNormal.'
                                </div>';
        }
        return $xhtml;
    }
    
    /**
     * 
     * @param unknown $url
     * @return Ambigous <multitype:, multitype:multitype: >
     */
    public static function getData($url) {
        $array_data = array();
        if(!ini_set('default_socket_timeout', 15)) echo "<!-- unable to change socket timeout -->";
    
        if (($handle = @fopen($url, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $array_data[]=$data;
            }
            fclose($handle);
        }
        else {
            $array_data = array();
        }
        return $array_data;
    }
    
    /**
     * 
     * @param unknown $data
     * @return string
     */
    public static function projectTypeBg($data) {
        $class  = "";
        if(trim($data) == "Maintenance") {
            $class = "success";
        } elseif (trim($data) == "Newton") {
            $class = "info";
        }
        return $class;
    }
    
    /**
     * 
     * @param unknown $arrayRemove
     * @param unknown $arraySource
     * @return unknown
     */
    public static function removeArrayItem($arrayRemove = array(), $arraySource = array()) {
        foreach($arrayRemove as $key => $value) {
            if(array_key_exists($value, $arraySource)) {
                unset($arraySource[$value]);
            }
        }
        return $arraySource;
    }
    
    /**
     * 
     * @param unknown $str
     * @return unknown
     */
    public static function convertMonth($str) {
        $month = '';
        $arrayDate = explode('/', $str);
        $month = $arrayDate[1];
        return $month;
    }
    
    /**
     * 
     * @param unknown $str
     * @return string
     */
    public static function emptyReturn($str) {
        if(trim($str) == '') {
            $str = '-';
        }
        return $str;
    }
    
    /**
     * 
     * @param unknown $date
     * @return boolean
     */
    public static function isWeekend($date) {
        //$inputDate = DateTime::createFromFormat("d-m-Y", $date, new DateTimeZone("Europe/Amsterdam"));
        $inputDate = DateTime::createFromFormat('d/m/Y', $date, new DateTimeZone("Asia/Ho_Chi_Minh"));
        return $inputDate->format('N') >= 6;
    }
    
    /**
     * 
     * @param unknown $date
     * @return boolean
     */
    public static function checkWeekend($date) {
        if(date('w', strtotime($date)) == 6 || date('w', strtotime($date)) == 0) {
            return true;
        } else {
            return false;
        }
        return false;
    }
}