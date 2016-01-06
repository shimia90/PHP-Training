<?php
	require_once "class/Validate.class.php";
		
	$flagType 	=	'error';
	$error 		=	'';
	$source 	=	array(
		'name'		=>		$_POST['name'],
		'email'		=>		$_POST['email'],
		'message'	=>		$_POST['message'],
		'file'		=>		$_FILES['attach'],
	);
	
	$validate 	= 	new Validate($source);
	
	$validate->addRule('name', 'string', array('min' => 2, 'max' => 50))
			->addRule('email', 'email')
			->addRule('message', 'string', array('min' => 5, 'max' => 500))
			->addRule('file', 'file', array('extension' => array('png', 'jpg'), 'min' => 50, 'max' => 9000000), false);
	
	$validate->run();
	
	if($validate->isValid() == false) {
		$error 	=	$validate->getError();	
	} else {
		$flagType = 'success';
	}
	
	$response = array(
		'type' 		=> $flagType,
		'message' 	=> $error
	);
	echo json_encode($response);
?>