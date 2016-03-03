<?php
	$message 	=	'';
	switch($this->arrayParams['type']) {
		case 'register-success': 
			$message 	=	'Your account has been created successful. Please wait for activation from administrator';
			break;	
	}
?>
<div class="notice"><?php echo $message; ?></div>