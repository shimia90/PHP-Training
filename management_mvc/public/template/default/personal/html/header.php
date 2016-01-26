<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Personal Management</title>
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="assets/styles.css" rel="stylesheet" media="screen">
        <link href="assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <link href="css/jquery-ui.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="css/daterangepicker.css" />
        <link rel="stylesheet" href="css/timestack.css" />
        <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="vendors/flot/excanvas.min.js"></script><![endif]-->
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        
    </head>
<body>
<div class="navbar">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
            </a>
            <a class="brand" href="index.php">Admin Dashboard</a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                	<li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Daily Duration Management <b class="caret"></b></a>
                        <ul class="dropdown-menu" id="menu1">
                            <li>
                                <a href="personal.php">Personal Management</a>
                            </li>
                            <li>
                                <a href="group.php">Group Management</a>
                            </li>
                            <li>
                                <a href="#">All</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Project Management</a>  
                    </li>
                    <li>
                        <a href="#">Run Slide Automatic</a>  
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>