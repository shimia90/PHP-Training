<?php
    $course = array();
    $course[0] = array( 'id' => 1, 'name' => 'Zend Framework' );
    $course[1] = array( 'id' => 2, 'name' => 'Joomla' );
    $course[2] = array( 'id' => 3, 'name' => 'jQuery Master' );
    
    if(isset($_POST['key'])) {
        $result = $course[$_POST['key']];
        echo json_encode($result);
    }
?>