<?php 
include_once (MODULE_PATH . 'default/views/top.php');
include_once (MODULE_PATH . 'default/views/sidebar.php');
$idLink = 	''; 	
if(isset($_GET['type']) && $_GET['type'] == 'edit') {
	$type 	=	$_GET['type'];
	if(isset($_GET['idLink'])) {
		$idLink 	=	'&idLink='.$_GET['idLink'];
	}
} else {
	$type 	=	'insert';	
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
              Fieldset
            </div>
        
            <div class="panel-body">
              <form class="fieldset-form" name="formGoogle[]" action="<?php echo URL::createLink('default', 'google', 'insert'); ?>&type=<?php echo $type . $idLink ; ?>" method="post">
                <fieldset>
                  <legend>Insert Google Link</legend>
                  <div class="form-group">
                    <label class="form-label" for="example10">Name</label>
                    <input type="text" data-required="1" class="form-control" name="formGoogle[google_link]" placeholder="Google Link" value="<?php echo $this->postLink; ?>" />
                  </div>
                  <div class="form-group">
                      <label class="form-label" for="example11">Month</label>
                      <div class="controls">
                       <div class="input-prepend input-group">
                         <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                         <input type="text" name="formGoogle[google_date]" value="<?php echo $this->postDate; ?>" class="form-control active" id="date-picker" placeholder="Month"> 
                       </div>
                      </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label">Project Type</label>
                    <select name="formGoogle[google_project]" class="form-control">
                    	<option value="">Select...</option>
                        <?php for($i = 0; $i < count($this->arrayProject); $i++) { ?>
						<?php 
                            if($_GET['type'] == 'edit' && $this->arrayEdit[0]['project_link'] == $this->arrayProject[$i]['id'] || isset($_POST['formGoogle']['google_project']) && $_POST['form_edit'] == $this->arrayProject[$i]['id']) {
                                $selected = 'selected="selected"';   
                            } else {
                                $selected = '';   
                            }
                        ?>
                        <option value="<?php echo $this->arrayProject[$i]['id']; ?>" <?php echo $selected; ?>><?php echo $this->arrayProject[$i]['project_type']; ?></option>
                        <?php } ?>
                    </select>
                  </div>
                  <?php echo $this->hiddenInput; ?>
                  <button class="btn btn-success" type="submit"><i class="fa fa-check-square-o"></i> Submit</button>
                  <a href="<?php echo URL::createLink('default', 'google', 'insert'); ?>&type=insert" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
                  <a href="<?php echo URL::createLink('default', 'google', 'index'); ?>" class="btn btn-primary"><i class="fa fa-backward"></i> Go Back</a>
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