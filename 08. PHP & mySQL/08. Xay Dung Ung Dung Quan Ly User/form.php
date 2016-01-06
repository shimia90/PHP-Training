<?php
	require_once 'class/Validate.class.php'; 
	require_once 'class/HTML.class.php'; 
	require_once 'connect.php'; 
	session_start();
	
	$error 			= '';
	$outValidate	= array();
	$id				= $_GET['id'];
	$action			= $_GET['action'];
	$flagRedirect	= false;
	$titlePage		= '';
	
	if($action == 'edit'){
		$id = mysql_real_escape_string($id);
		$query = "SELECT `name`, `status`, `ordering` FROM `group` WHERE id = '" . $id . "'";
		$outValidate	= $database->singleRecord($query);
		$linkForm		= 'form.php?action=edit&id=' . $id;
		if(empty($outValidate)) $flagRedirect	= true;		
		$titlePage		= 'EDIT USER';
	}else if($action == 'add'){
		$linkForm		= 'form.php?action=add';
		$titlePage		= 'ADD USER';
	}else{
		$flagRedirect	= true;
	}
	
	// Redirect page
	if($flagRedirect == true) {
		header('location: error.php');
		exit();
	}
	
	if(!empty($_POST)){
		if($_SESSION['token'] == $_POST['token']){ // refresh page
			unset($_SESSION['token']);
			header('location: ' . $linkForm);
			exit();
		}else{
			$_SESSION['token'] = $_POST['token'];
		}
		
		$source   = array(
		                  'username' => $_POST['username'],
		                  'email' => $_POST['email'],
		                  'password' => $_POST['password'],
		                  'birthday' => $_POST['birthday'],
		                  'status'=> $_POST['status'],
		                  'groupid'=> $_POST['groupid'],
		                  'ordering'=> $_POST['ordering']
		          );
		$validate = new Validate($source);
		$validate->addRule('username', 'string', 2, 50)
		         ->addRule('email', 'email')
		         ->addRule('password', 'password')
		         ->addRule('birthday', 'birthday')
		         ->addRule('groupid', 'status')
				 ->addRule('ordering', 'int', 1, 10)
				 ->addRule('status', 'status');
		
		$validate->run();

		$outValidate = $validate->getResult();
		
		if(!$validate->isValid()){
			$error = $validate->showErrors();
		}else{
			if($action == 'edit'){
				$where = array(array('id', $id));
				$database->update($outValidate, $where);
			}else if($action == 'add'){
				$database->insert($outValidate);
				$outValidate = array();
			}
			$success = '<div class="success">Success</div>'; 
		}
	}
	
	//Select Status
	$arrStatus 	= array(2=> 'Select status', 0 => 'Inactive', 1 => 'Active');
	$status		= HTML::createSelectbox($arrStatus, 'status', $outValidate['status']);
	
	//Select Group
	$query      = 'SELECT `id`,`name` FROM `group`';
	$groupID = $database->createSelectBox($query, 'groupid', $outValidate['groupid']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
<title><?php echo $titlePage;?></title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/my-js.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
</head>
<body>
	<div id="wrapper">
    	<div class="title"><?php echo $titlePage;?></div>
        <div id="form">   
        	<?php echo $error . $success; ?>
			<form action="<?php echo $linkForm;?>" method="post" name="add-form">
				<div class="row">
					<p>Username</p>
					<input type="text" name="username" value="<?php echo $outValidate['username'];?>">
				</div>
				
				<div class="row">
					<p>Email</p>
					<input type="text" name="email" value="<?php echo $outValidate['email'];?>">
				</div>
				
				<div class="row">
					<p>Password</p>
					<input type="text" name="password" value="<?php echo $outValidate['password'];?>">
				</div>
				
				<div class="row">
					<p>Birthday</p>
					<input type="text" id="datepicker" name="birthday" value="<?php echo $outValidate['birthday'];?>">
				</div>
				
				<div class="row">
					<p>Group</p>
					<?php echo $groupID; ?>
				</div>
				
				<div class="row">
					<p>Status</p>
					<?php echo $status;?>
				</div>
				
				<div class="row">
					<p>Ordering</p>
					<input type="text" name="ordering" value="<?php echo $outValidate['ordering'];?>">
				</div>
				
				<div class="row">
					<input type="submit" value="Save" name="submit">
					<input type="button" value="Cancel" name="cancel" id="cancel-button">
					<input type="hidden" value="<?php echo time();?>" name="token" />
				</div>
												
			</form>    
        </div>
        
    </div>
</body>
</html>
