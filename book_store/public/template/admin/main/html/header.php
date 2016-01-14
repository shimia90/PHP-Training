<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<?php echo $this->_metaHTTP;?>
	<?php echo $this->_metaName;?>
    <?php echo $this->_title;?>
    <?php echo $this->_cssFiles;?>
    <?php echo $this->_jsFiles;?>
</head>
<body>
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
						<li><a class="icon-16-cpanel" href="#">Control Panel</a></li>
						<li class="separator"><span></span></li>
						<li><a class="icon-16-profile" href="#">My Profile</a></li>
						<li class="separator"><span></span></li>
						<li><a class="icon-16-config" href="#">Global Configuration</a></li>
						<li class="separator"><span></span></li>
						<li class="node"><a class="icon-16-maintenance" href="#">Maintenance</a>
							<ul id="menu-com-checkin" class="menu-component">
								<li><a class="icon-16-checkin" href="#">Global Check-in</a></li>
								<li class="separator"><span></span></li>
								<li><a class="icon-16-clear" href="#">Clear Cache</a></li>
								<li><a class="icon-16-purge" href="#">Purge Expired Cache</a></li>
							</ul></li>
						<li class="separator"><span></span></li>
					</ul>
		
		</div>

		<div class="clr"></div>
	</div>