<?php 
include_once (MODULE_PATH . 'default/views/top.php');
include_once (MODULE_PATH . 'default/views/sidebar.php');
$rowTeam 			=		'';

foreach($this->arrayTeam as $key => $value) {
	$rowTeam 		.=		'<tr>
								<td>'.$value['id'].'</td>
								<td>'.$value['team_name'].'</td>
								<td>'.$value['team_number'].'</td>
								<td><a href="'.URL::createLink('default', 'team', 'edit', array('id' => $value['id'])).'" class="btn btn-mini btn-primary">Edit</a> <a href="'.URL::createLink('default', 'team', 'delete', array('id' => $value['id'])).'" class="btn btn-mini btn-danger" onclick="return ConfirmDelete();">Delete</a></td>
							  </tr>';
}
?>
 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTENT -->
<div class="content">

  <!-- Start Page Header -->
  
  <!-- End Page Header -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTAINER -->
<div class="panel-body">
		<div class="container-padding">


  <!-- Start Row -->
  <div class="row">

    <!-- Start Panel -->
    <div class="col-md-12">
      <p class="text-right"><a href="<?php echo URL::createLink('default', 'team', 'insert'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Insert</a></p>
      <div class="panel panel-default">
        <div class="panel-title"><?php echo $this->_title; ?></div>
        <div class="panel-body table-responsive">

          <table class="table table-hover">
            <thead>
              <tr>
              	<td>ID</td>
                <td>Team</td>
                <td>Team Name</td>
                <td>Action</td>
              </tr>
            </thead>
            <tbody>
				<?php echo $rowTeam; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <!-- End Panel -->

  </div>
  <!-- End Row -->






	</div>
</div>
<!-- END CONTAINER -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 

<?php include_once (MODULE_PATH . 'default/views/footer.php'); ?>

</div>
<!-- End Content -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 