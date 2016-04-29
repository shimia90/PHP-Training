<?php

	$message	= '';
	
	switch ($this->arrayParams['type']){
		case 'register-success':
			$message	= 'Your account has been registerd successful !';
			break;
		case 'not-permission':
			$message	= 'You dont have permission to enter this role';
			break;
		case 'not-url':
			$message	= 'This link not exist';
			break;
	}
?>
<div class="notice"><?php echo $message;?></div>