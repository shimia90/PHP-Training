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
              <?php echo @$this->_result; ?>
              <form class="fieldset-form" name="insertTeam[]" action="<?php echo URL::createLink('default', 'team', 'insert'); ?>" method="post">
                <fieldset>
                  <legend>Insert Team</legend>
                  <!-- <div class="form-group">
                    <label class="form-label" for="id">ID</label>
                    <input id="id" type="text" data-required="1" class="form-control" name="insertTeam[id]" placeholder="ID" value="" />
                  </div> -->
                  <div class="form-group">
                     <label class="form-label" for="team_name">Team Name</label>
                     <input id="team_name" type="text" data-required="1" class="form-control" name="insertTeam[team_name]" placeholder="Team Name" value="" />
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="team">Team</label>
                    <input id="team_number" type="text" data-required="1" class="form-control" name="insertTeam[team_number]" placeholder="Team Number" value="" />
                  </div>
                  <button class="btn btn-success" type="submit"><i class="fa fa-check-square-o"></i> Submit</button>
                  <a href="<?php echo URL::createLink('default', 'team', 'insert'); ?>&type=insert" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
                  <a href="<?php echo URL::createLink('default', 'team', 'index'); ?>" class="btn btn-primary"><i class="fa fa-backward"></i> Go Back</a>
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