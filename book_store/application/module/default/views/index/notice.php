<?php
	$message 	=	'';
	switch($this->arrayParams['type']) {
		case 'register-success': 
			$message 	=	'Your account has been created successful. Please wait for activation from administrator';
			break;
		case 'not-permission':
		    $message 	=	'Bạn không có quyền truy cập vào chức năng đó';
		    break;
		case 'not-url':
		    $message 	=	'Đường dẫn không hợp lệ';
		    break;
	}
?>
<div class="notice"><?php echo $message; ?></div>