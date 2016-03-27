<?php
require_once '../connect.php';
@$xhtmlDistrict .= '<option value="">-- Select a district --</option>';
if (isset($_GET['idCity'])) {
    $cityID = $_GET['idCity'];
    
    $queryDistrict = "SELECT `district_id`, `district_name` FROM `districts` WHERE `city_id` = '{$cityID}'";
    $dataDistrict   =   $database->listRecord($queryDistrict);
    foreach($dataDistrict as $key => $value) {
        $xhtmlDistrict .=   '<option value="'.$value['district_id'].'">'.$value['district_name'].'</option>';
    }
    echo $xhtmlDistrict;
}
?>