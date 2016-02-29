<?php 
include_once (MODULE_PATH . 'default/views/top.php');
include_once (MODULE_PATH . 'default/views/sidebar.php');
?>
 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTENT -->
<div class="content">

  <!-- Start Page Header -->
  <div class="page-header"><h1 class="title"><?php echo $this->_title; ?></h1></div>
  <!-- End Page Header -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTAINER -->
<div class="panel-body table-responsive margin-t-20 margin-b-20">
   <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
		<thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Link</th>
                <th class="text-center">Month</th>
                <th class="text-center">Year</th>
                <th class="text-center">Project Type</th>
                <th class="text-center">Action</th>
            </tr> 
        </thead>
        <tbody>
        	<?php echo $this->rowLink; ?>
        </tbody>
    </table>
</div>
<!-- END CONTAINER -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 

<?php include_once (MODULE_PATH . 'default/views/footer.php'); ?>
</div>
<!-- End Content -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 