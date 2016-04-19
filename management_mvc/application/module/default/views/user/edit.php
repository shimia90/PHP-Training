<?php 
include_once (MODULE_PATH . 'default/views/top.php');
include_once (MODULE_PATH . 'default/views/sidebar.php');
$nickname 	=	'';
$fullname 	=	'';
$team 		=	'';
$position 	=	'';
if(!empty($this->_arrayUser)) {
	foreach($this->_arrayUser as $key => $value) {
		$id 		=		$value['id'];
		$nickname 	=		$value['nickname'];
		$fullname 	=		$value['fullname'];
		$team	 	=		$value['team'];
		$position 	=		$value['position'];
	}
}
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
              <form class="fieldset-form" name="editUser[]" action="<?php echo URL::createLink('default', 'user', 'edit', array('id' => $_GET['id'])); ?>" method="post">
                <fieldset>
                  <legend>Insert User</legend>
                  <div class="form-group">
                    <label class="form-label" for="id">ID</label>
                    <input id="id" type="text" data-required="1" class="form-control" name="editUser[id]" placeholder="ID" value="<?php echo $id; ?>" />
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="nickname">Username</label>
                    <input id="nickname" type="text" data-required="1" class="form-control" name="editUser[nickname]" placeholder="User Name" value="<?php echo $nickname; ?>" />
                  </div>
                  <div class="form-group">
                     <label class="form-label" for="example10">Full Name</label>
                     <input id="fullname" type="text" data-required="1" class="form-control" name="editUser[fullname]" placeholder="Full Name" value="<?php echo $fullname; ?>" />
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="team">Team</label>
                  	<select class="form-control" name="editUser[team]" id="team">
                    	<option value="">Select Team</option>
                        <?php foreach($this->arrayTeam as $key => $value) : ?>
                        	<option value="<?php echo $value['team_number']; ?>" <?php if($team == $value['team_name']) echo 'selected="selected"'; ?>><?php echo $value['team_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="position">Position</label>
                    <select class="form-control" name="editUser[position]" id="position">
                    	<option value="">Select Position</option>
                        <option value="leader" <?php if($position == 'leader') echo 'selected="selected"';  ?>>Leader</option>
                        <option value="member" <?php if($position == 'member') echo 'selected="selected"';  ?>>Member</option>
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