<?php 
    $linkGroup  =   URL::createLink('admin', 'group', 'index');
    $linkUser  =   URL::createLink('admin', 'user', 'login');
?>
<div id="submenu-box">
	<div class="m">
		<ul id="submenu">
			<li><a href="<?php echo $linkGroup; ?>" class="active">Group</a></li>
			<li><a href="<?php echo $linkUser; ?>">User</a></li>
		</ul>
		<div class="clr"></div>
	</div>
</div>