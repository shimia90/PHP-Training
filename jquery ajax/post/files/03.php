<?php
    $username = $_POST['username'];
    $password = $_POST['password'];
	$message  = array();
	if(empty($username)) {
		$message['username'] = 'Username khong duoc rong'; 	
	} else if($username != 'hailan') {
		$message['username'] = 'Username khong ton tai'; 	
	}
	
	if(empty($password)) {
		$message['password'] = 'Password khong duoc rong'; 	
	} else if($username != 'hailan') {
		$message['password'] = 'Password khong ton tai'; 	
	}
	
	$status = 'error';
	if(count($message) == 0) $status = 'success'; 
	
	$response = array(
					'status' 	=>	$status,
					'message'	=>	$message
				);
	echo $jsonString = json_encode($response);