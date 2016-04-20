<?php 
include_once (MODULE_PATH . 'default/views/top.php');
include_once (MODULE_PATH . 'default/views/sidebar.php');
$rowUser 			=		'';

foreach($this->arrayUser as $key => $value) {
    $control        =       ($value['admin_control'] == 0) ? 'Read Only' : 'Edit'; 
	$rowUser 		.=		'<tr>
								<td>'.$value['id'].'</td>
								<td>'.$value['nickname'].'</td>
								<td>'.$value['fullname'].'</td>
								<td>'.$value['team'].'</td>
								<td>'.ucfirst($value['position']).'</td>
								<td>'.$control.'</td>
								<td><a href="'.URL::createLink('default', 'user', 'edit', array('id' => $value['id'])).'" class="btn btn-mini btn-primary">Edit</a> <a href="'.URL::createLink('default', 'user', 'delete', array('id' => $value['id'])).'" class="btn btn-mini btn-danger" onclick="return ConfirmDelete();">Delete</a></td>
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
      <p class="text-right"><a href="<?php echo URL::createLink('default', 'user', 'insert'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Insert</a></p>
      <div class="panel panel-default">
        <div class="panel-title"><?php echo $this->_title; ?></div>
        <div class="panel-body table-responsive">

          <table class="table table-hover">
            <thead>
              <tr>
              	<td>ID</td>
                <td>Username</td>
                <td>Fullname</td>
                <td>Team</td>
                <td>Position</td>
                <td>Admin Control</td>
                <td>Action</td>
              </tr>
            </thead>
            <tbody>
             	<?php echo $rowUser; ?>
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