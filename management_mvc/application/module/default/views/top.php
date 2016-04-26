<?php
    $fullname    =  (isset($_SESSION['user'])) ? $_SESSION['user']['info']['fullname'] : '';
?>
<!-- Start Page Loading -->
  <div class="loading"><img src="<?php echo TEMPLATE_URL . 'default/main/img' ?>/loading.gif" alt="loading-img"></div>
<!-- End Page Loading -->
<!-- START TOP -->
  <div id="top" class="clearfix">

    <!-- Start App Logo -->
    <div class="applogo">
      <a href="<?php echo URL::createLink('default', 'index', 'index')?>" class="logo">Freesale</a>
    </div>
    <!-- End App Logo -->

    <!-- Start Sidebar Show Hide Button -->
    <!-- <a href="#" class="sidebar-open-button"><i class="fa fa-bars"></i></a>
    <a href="#" class="sidebar-open-button-mobile"><i class="fa fa-bars"></i></a> -->
    <!-- End Sidebar Show Hide Button -->

    <!-- Start Searchbox -->
    <form class="searchform">
      <input type="text" class="searchbox" id="searchbox" placeholder="Search">
      <span class="searchbutton"><i class="fa fa-search"></i></span>
    </form>
    <!-- End Searchbox -->
	
	<!-- Start Top Right -->
    <ul class="top-right">

    <li class="dropdown link">
      <a href="#" data-toggle="dropdown" class="dropdown-toggle profilebox"><b><?php echo $fullname; ?></b><span class="caret"></span></a>
        <ul class="dropdown-menu dropdown-menu-list dropdown-menu-right">
          <li><a href="<?php echo URL::createLink('default', 'login', 'logout')?>"><i class="fa falist fa-power-off"></i> Logout</a></li>
        </ul>
    </li>

    </ul>
    <!-- End Top Right -->
	
  </div>
  <!-- END TOP -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 