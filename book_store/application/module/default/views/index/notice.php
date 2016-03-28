<?php
	$message 	=	'';
	switch($this->arrayParams['type']) {
		case 'register-success': 
			$message 	=	'Your account has been created successful. Please wait for activation from administrator';
			break;
		case 'not-permission':
		    $message 	=	'Bạn không có quyền truy cập vào chức năng đó';
		    break;
	}
?>
<div class="notice"><?php echo $message; ?></div>