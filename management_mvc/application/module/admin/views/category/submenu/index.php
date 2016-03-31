<?php 
    $linkCategory   =   URL::createLink('admin', 'category', 'index');
    $linkBook       =   URL::createLink('admin', 'user', 'index');
?>
<div id="submenu-box">
	<div class="m">
		<ul id="submenu">
			<li><a href="<?php echo $linkCategory; ?>" class="active">Category</a></li>
			<li><a href="<?php echo $linkBook; ?>">Book</a></li>
		</ul>
		<div class="clr"></div>
	</div>
</div>