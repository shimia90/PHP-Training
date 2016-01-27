<?php 
    $linkControlPanel   =   URL::createLink('admin', 'control', 'index');
    $linkMyProfile      =   URL::createLink('admin', 'profile', 'index');
    $linkUserManager    =   URL::createLink('admin', 'user', 'index');
    $linkAddUser        =   URL::createLink('admin', 'user', 'add');
    $linkAddGroup          =   URL::createLink('admin', 'group', 'add');
?>
<div id="border-top" class="h_blue">
	<span class="title"><a href="#">Administration</a></span>
</div>

<!-- HEADER -->
<div id="header-box">
	<div id="module-status">
		<span class="no-unread-messages"><a href="#">Log out</a></span>
	</div>
	<div id="module-menu">
		<!-- MENU -->
		<ul id="menu">
			<li class="node"><a href="#">Site</a>
				<ul>
					<li><a class="icon-16-cpanel" href="<?php echo $linkControlPanel; ?>">Control Panel</a></li>
					<li class="separator"><span></span></li>
					<li><a class="icon-16-profile" href="<?php echo $linkMyProfile; ?>">My Profile</a></li>
				</ul>
	        </li>
	        <li class="separator"><span></span></li>
	        <li class="node"><a href="#">Users</a>
				<ul>
					<li class="node">
						<a class="icon-16-user" href="<?php echo $linkUserManager; ?>">User Manager</a>
						<ul id="menu-com-users-users" class="menu-component">
							<li>
								<a class="icon-16-newarticle" href="<?php echo $linkAddUser; ?>">Add New User</a>
							</li>
						</ul>
					</li>
						
					<li class="node">
						<a class="icon-16-groups" href="#">Groups</a>
						<ul id="menu-com-users-groups" class="menu-component">
							<li>
								<a class="icon-16-newarticle" href="<?php echo $linkAddGroup; ?>">Add New Group</a>
							</li>
						</ul>
					</li>
				</ul>
			</li>
	</div>

	<div class="clr"></div>
</div>