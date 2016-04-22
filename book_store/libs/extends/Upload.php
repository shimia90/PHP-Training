<?php
require_once SCRIPT_PATH . 'PhpThumb' . DS . 'ThumbLib.inc.php';
class Upload {
	
	public function uploadFile($fileObj, $folderUpload, $width =  60, $height = 60, $options = null) {
		if($options == null) {
			/*echo '<pre>';
			print_r($fileObj);
			echo '</pre>';
			echo $folderUpload;*/
			if($fileObj['tmp_name'] != '') {
				$uploadDir 		=	UPLOAD_PATH . $folderUpload . DS;
				$fileName 	=	$this->randomString(8) . '.' . pathinfo($fileObj['name'], PATHINFO_EXTENSION);
				@copy($fileObj['tmp_name'], $uploadDir . $fileName);
				
				$thumb 			=	PhpThumbFactory::create($uploadDir . $fileName);
				$thumb->adaptiveResize($width, $height);
				$thumb->save($uploadDir . $width . 'x' . $height . '-' . $fileName); // 60x90-abcdef.png;
			}
		}
		return $fileName;
	}
	
	private function randomString($length = 5) {
		$arrCharacter 	=	array_merge(range('a', 'z'), range(0,9));
		$arrCharacter 	=	implode($arrCharacter, '');
		$arrCharacter 	=	str_shuffle($arrCharacter);
		
		$result 		=	substr($arrCharacter, 0, $length);
		return $result;
	}
	
	public function removeFile($folderUpload, $fileName) {
		$fileName 		=	UPLOAD_PATH . $folderUpload . DS . $fileName;	
		@unlink($fileName);
	}
}