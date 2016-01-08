<?php 
    $cssURL     =   PUBLIC_URL . 'css/';
    $jsURL      =   PUBLIC_URL . 'js/';
    $menu       =   '<a class="index" href="index.php?controller=index&action=index">Home</a>';
    if(Session::get('loggedIn') == true) {
        $menu       .=   '<a class="group" href="index.php?controller=group&action=index">Group</a>';
        $menu       .=   '<a class="user" href="index.php?controller=user&action=logout">Logout</a>';
    } else {
        $menu       .=   '<a class="user" href="index.php?controller=user&action=login">Login</a>';
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>MVC</title>
<link rel="stylesheet" type="text/css" href="<?php echo $cssURL; ?>style.css" />
<script type="text/javascript" src="<?php echo $jsURL; ?>jquery.js"></script>
<script type="text/javascript" src="<?php echo $jsURL; ?>custom.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h3>Header</h3>
            <?php echo $menu; ?>
        </div>