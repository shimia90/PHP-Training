<?php 
ob_start();
if (isset($_GET['id'])) {
include_once (MODULE_PATH . 'default/views/top.php');
include_once (MODULE_PATH . 'default/views/sidebar.php');
?>
 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTENT -->
<div class="content">

  <!-- Start Page Header -->
  <div class="page-header">
  	<h1 class="title"><?php echo $this->_title; ?></h1>
  </div>
  <!-- End Page Header -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTAINER -->
<div class="panel-body table-responsive margin-t-20 margin-b-20">
	<?php echo $this->message; ?>
    <p><a href="<?php echo URL::createLink('default', 'team', 'index'); ?>" class="btn btn-primary"><i class="fa fa-backward"></i> Go Back</a></p>
</div>
<!-- END CONTAINER -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 

<?php include_once (MODULE_PATH . 'default/views/footer.php'); ?>
</div>
<!-- End Content -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<?php
} else {
	URL::redirect(URL::createLink('default', 'team', 'index'));	
}
?>