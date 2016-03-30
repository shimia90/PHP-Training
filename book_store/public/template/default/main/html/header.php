<?php 
    $xhtml              =       '';
    $imageURL   		=   	$this->_dirImg;
	$linkHome 			=		URL::createLink('default', 'index', 'index');
	
	$userObj            =       Session::get('user');
	
	$arrayMenu          =      array();
	$arrayMenu[]        =      array('class'   =>  'index-index',      'link'   =>  URL::createLink('default', 'index', 'index'),      'name'    =>  'Home');
	$arrayMenu[]        =      array('class'   =>  'category-index',   'link'   =>  URL::createLink('default', 'category', 'index'),   'name'    =>  'Categories');
	                          
	if($userObj['login'] == true) {
	    $arrayMenu[]    =      array('class'   =>  'user-index',       'link'   =>  URL::createLink('default', 'user', 'index'),       'name'    =>  'My Account');
	    $arrayMenu[]    =      array('class'   =>  'index-logout',     'link'   =>  URL::createLink('default', 'index', 'logout'),     'name'    =>  'Logout');
	} else {
	    $arrayMenu[]    =      array('class'   =>  'index-register',   'link'   =>  URL::createLink('default', 'index', 'register'),   'name'    =>  'Register');
	    $arrayMenu[]    =      array('class'   =>  'index-login',     'link'   =>  URL::createLink('default', 'index', 'login'),       'name'    =>  'Login');
	}
	
	if($userObj['group_acp'] == true) {
	    $arrayMenu[]    =      array('class'   =>  '',     'link'   =>  URL::createLink('admin', 'index', 'index'),       'name'    =>  'Admin Control Panel');
	}
	
	foreach ($arrayMenu as $key => $value) {
	    $xhtml         .=      '<li class="'.$value['class'].'"><a href="'.$value['link'].'">'.$value['name'].'</a></li>';
	}
?>
<div class="header">
	<div class="logo">
		<a href="<?php echo $linkHome; ?>"><img src="<?php echo $imageURL; ?>/logo.gif" /></a>
	</div>
	<div id="menu">
		<ul><?php echo $xhtml; ?></ul>
	</div>
</div>