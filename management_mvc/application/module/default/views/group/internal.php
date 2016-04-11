<?php 
include_once (MODULE_PATH . 'default/views/top.php');
include_once (MODULE_PATH . 'default/views/sidebar.php');

$dateFrom 	=	(isset($_POST['group_form']['date_from'])) ? $_POST['group_form']['date_from'] : date("d/m/Y");
$dateTo 	=	(isset($_POST['group_form']['date_to'])) ? $_POST['group_form']['date_to'] : date("d/m/Y");

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
	<div class="panel panel-default">
		
        <div class="panel-title">
          Select Date
        </div>

            <div class="panel-body">
              <form class="form-inline" name="group_form" method="post" action="<?php echo URL::createLink('default', 'group', 'internal', array('team' => $_GET['team'])); ?>">
                <div class="form-group">
                  <label class="form-label" for="example1">From</label>
                  <div class="input-prepend input-group">
                     <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                     <input type="text" value="<?php echo $dateFrom; ?>" class="form-control active" id="date-range200" name="group_form[date_from]" /> 
                   </div>
                </div>
                <div class="form-group">
                  <label class="form-label" for="example2">To</label>
                  <div class="input-prepend input-group">
                     <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                     <input type="text" value="<?php echo $dateTo; ?>" class="form-control active" id="date-range201" name="group_form[date_to]" /> 
                   </div>
                </div>
                <button class="btn btn-default" type="submit">Search</button>
              </form>
            </div>

      </div>
   <!-- <div class="row"> -->
   		<!-- <div class="col-lg-6 col-md-6"> -->
        	<div class="panel panel-widget">
                <div class="panel-title">
                  Team <span class="label label-info"><?php echo $_GET['team']; ?></span>
                  <ul class="panel-tools">
                    <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                    <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
                    <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                  </ul>
                </div>
        
                <div class="panel-search">
                  <form>
                    <input type="text" placeholder="Search..." class="form-control">
                    <i class="fa fa-search icon"></i>
                  </form>
                </div>
        
        
                <div class="panel-body table-responsive">
        
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <td class="text-center">Group leader</td>
                        <td class="text-center">Name</td>
                        <td class="text-center">Project</td>
                        <td class="text-center">Standard dur</td>
                        <td class="text-center">Real dur</td>
                        <td class="text-center">Performance</td>
                      </tr>
                    </thead>
                    <tbody>
                      <?php echo $this->colUser; ?>
                    </tbody>
                  </table>
        
                </div>
              </div>
        <!-- </div> --><!-- col-lg-6 -->
        <!-- <div class="col-lg-6 col-md-6">
        
        </div> --><!-- col-lg-6 -->
   <!--</div> --><!-- row --> 
   
   <div id="chartist-line">
   
   </div>
</div>
<!-- END CONTAINER -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 

<?php include_once (MODULE_PATH . 'default/views/footer.php'); ?>
</div>
<?php echo @$this->chart; ?>
<!-- End Content -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 