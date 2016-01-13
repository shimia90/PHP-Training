<?php
// id name id_city
$district = array(
    array('id' => 1, 'name' => "Thu Duc",   'id_city' => 1),
    array('id' => 2, 'name' => "Binh Thanh",    'id_city' => 1),
    array('id' => 3, 'name' => "Quan 9",   'id_city' => 1),
    array('id' => 4, 'name' => "My Tho",    'id_city' => 2),
    array('id' => 5, 'name' => "Go Cong Tay",    'id_city' => 2),
    array('id' => 6, 'name' => "Ninh Kieu",    'id_city' => 3),
    array('id' => 7, 'name' => "Cai Rang",    'id_city' => 3),
);
$idCity = $_GET['idCity'];
$xhtml  = '<option value="0">Chọn quận huyện</option>';
foreach($district as $key => $value) {
    if($idCity == $value['id_city']) {
        $xhtml .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
    }
}
echo $xhtml;