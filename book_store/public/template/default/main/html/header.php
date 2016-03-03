<?php 
    $imageURL   		=   	TEMPLATE_URL . 'default/main/' . $this->_dirImg;
	$linkHome 			=		URL::createLink('default', 'index', 'index');
	$linkCategories 	=		URL::createLink('default', 'category', 'index');
?>
<div class="header">
	<div class="logo">
		<a href="index.html"><img src="<?php echo $imageURL; ?>/logo.gif" alt="" title=""
			border="0" /></a>
	</div>
	<div id="menu">
		<ul>
			<li class="selected"><a href="<?php echo $linkHome; ?>">Home</a></li>
			<li><a href="<?php echo $linkCategories; ?>">Categories</a></li>
			<li><a href="category.html">My Account</a></li>
			<li><a href="specials.html">Register</a></li>
			<li><a href="myaccount.html">Login</a></li>
		</ul>
	</div>
</div>