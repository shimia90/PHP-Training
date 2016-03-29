<!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START SIDEBAR -->
<div id="main-menu" class="sidebar clearfix">
<ul class="sidebar-panel nav">
	<li class="sidetitle">MAIN</li>
    <li class="index-index"><a href="<?php echo URL::createLink('default', 'index', 'index'); ?>"><span class="icon color5"><i class="fa fa-home"></i></span>Dashboard</a></li>
	<li class="google-index"><a href="<?php echo URL::createLink('default', 'google', 'index'); ?>"><span class="icon color6"><i class="fa fa-external-link"></i></span>Google Link</a></li>
    <li class="user-index"><a href="<?php echo URL::createLink('default', 'user', 'index'); ?>"><span class="icon color6"><i class="fa fa-user-md"></i></span>User Management</a></li>
</ul>
<ul class="sidebar-panel nav">
  <li class="sidetitle">PERSONAL</li>
  <li class="personal-index"><a href="<?php echo URL::createLink('default', 'personal', 'index'); ?>"><span class="icon color6"><i class="fa fa-user"></i></span>Personal</a></li>
</ul>

<ul class="sidebar-panel nav">
	<li class="sidetitle">GROUP</li>
    
    <li class="group-internal"><a href="#"><span class="icon color9"><i class="fa fa-compress"></i></span>Internal Group<span class="caret"></span></a>
    	<ul>
          <li class="team-1"><a href="<?php echo URL::createLink('default', 'group', 'internal', array('team' => '1')); ?>"><i class="fa fa-users"></i> Team 1</a></li>
          <li class="team-2"><a href="<?php echo URL::createLink('default', 'group', 'internal', array('team' => '2')); ?>"><i class="fa fa-users"></i> Team 2</a></li>
          <li class="team-3"><a href="<?php echo URL::createLink('default', 'group', 'internal', array('team' => '3')); ?>"><i class="fa fa-users"></i> Team 3</a></li>
          <li class="team-4"><a href="<?php echo URL::createLink('default', 'group', 'internal', array('team' => '4')); ?>"><i class="fa fa-users"></i> Team 4</a></li>
          <li class="team-5"><a href="<?php echo URL::createLink('default', 'group', 'internal', array('team' => '5')); ?>"><i class="fa fa-users"></i> Team 5</a></li>
          <li class="team-6"><a href="<?php echo URL::createLink('default', 'group', 'internal', array('team' => '6')); ?>"><i class="fa fa-users"></i> Team 6</a></li>
        </ul>
    </li>
    
    <li><a href="<?php echo URL::createLink('default', 'group', 'external'); ?>"><span class="icon color6"><i class="fa fa-expand"></i></span> External Group</a></li>
    
</ul>

<div class="sidebar-plan">
  <a class="btn btn-primary" href="<?php echo URL::createLink('default', 'import', 'index'); ?>"><i class="fa fa-upload"></i>Update Data</a>
</div>

</div>
<!-- END SIDEBAR -->
<!-- //////////////////////////////////////////////////////////////////////////// --> 