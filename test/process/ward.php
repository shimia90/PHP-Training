<?php
require_once '../connect.php';
@$xhtmlWard .= '<option value="">-- Select a wards --</option>';
if (isset($_GET['idDistrict'])) {
    $districtID = $_GET['idDistrict'];
    
    $queryDistrict = "SELECT `ward_id`, `ward_name` FROM `wards` WHERE `district_id` = '{$districtID}'";
    $dataWard   =   $database->listRecord($queryDistrict);
    foreach($dataWard as $key => $value) {
        $xhtmlWard .=   '<option value="'.$value['ward_id'].'">'.$value['ward_name'].'</option>';
    }
    echo $xhtmlWard;
}
?>