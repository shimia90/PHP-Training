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
<div class="panel panel-default">
    <div class="row">
    	<div class="col-offset-6">
        </div>
        <div class="col-md-6">
        	<div class="panel-title">
              <?php echo $this->_title; ?>
            </div>
        
            <div class="panel-body">
              <?php echo $this->_result; ?>
              <form class="fieldset-form" name="insertUser[]" action="<?php echo URL::createLink('default', 'user', 'insert'); ?>" method="post">
                <fieldset>
                  <legend>Insert User</legend>
                  <div class="form-group">
                    <label class="form-label" for="nickname">Username</label>
                    <input id="nickname" type="text" data-required="1" class="form-control" name="insertUser[nickname]" placeholder="User Name" value="" />
                  </div>
                  <div class="form-group">
                     <label class="form-label" for="example10">Full Name</label>
                     <input id="fullname" type="text" data-required="1" class="form-control" name="insertUser[fullname]" placeholder="Full Name" value="" />
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="team">Team</label>
                    <input id="team" type="text" data-required="1" class="form-control" name="insertUser[team]" placeholder="Team" value="" />
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="position">Position</label>
                    <select class="form-control" name="insertUser[position]" id="position">
                    	<option value="">Select Position</option>
                        <option value="leader">Leader</option>
                        <option value="member">Member</option>
                    </select>
                  </div>
                  <button class="btn btn-success" type="submit"><i class="fa fa-check-square-o"></i> Submit</button>
                  <a href="<?php echo URL::createLink('default', 'user', 'insert'); ?>&type=insert" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
                  <a href="<?php echo URL::createLink('default', 'user', 'index'); ?>" class="btn btn-primary"><i class="fa fa-backward"></i> Go Back</a>
                </fieldset>
              </form>
        
            </div>
        </div>
    </div>

</div>
<!-- END CONTAINER -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 

<?php include_once (MODULE_PATH . 'default/views/footer.php'); ?>
</div>
<!-- End Content -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 