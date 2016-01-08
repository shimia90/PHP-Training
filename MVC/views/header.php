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
    $fileJs     = '';
    $fileCss    = '';
    if(!empty($this->js)) {
        
        foreach($this->js as $js) {
            $fileJs .= '<script type="text/javascript" src="'.VIEW_URL . $js.'"></script>';
        }
    }
    
    if(!empty($this->css)) {
        foreach($this->css as $css) {
            $fileCss .= '<link rel="stylesheet" type="text/css" href="'.VIEW_URL. $css .'" />';
        }
    }
    
    $title = (isset($this->title)) ? $this->title : 'MVC';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $title; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $cssURL; ?>style.css" />
<?php echo $fileCss; ?>
<script type="text/javascript" src="<?php echo $jsURL; ?>jquery.js"></script>
<script type="text/javascript" src="<?php echo $jsURL; ?>custom.js"></script>
<?php echo $fileJs; ?>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h3>Header</h3>
            <?php echo $menu; ?>
        </div>