<?php 
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
   <div class="panel panel-widget">
        <div class="panel-title">
          Projects Stats <span class="label label-info">62</span>
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
                <td>ID</td>
                <td>Project</td>
                <td>Status</td>
                <td class="text-right">Progress</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>965</td>
                <td>Kode Dashboard Template</td>
                <td><span class="label label-default">Developing</span></td>
                <td class="text-right"><span class="demo-project-stats"><canvas style="display: inline-block; width: 100px; height: 20px; vertical-align: top;" width="100" height="20"></canvas></span></td>
              </tr>
              <tr>
                <td>620</td>
                <td>EBI iOS Application</td>
                <td><span class="label label-warning">Design</span></td>
                <td class="text-right"><span class="demo-project-stats"><canvas style="display: inline-block; width: 100px; height: 20px; vertical-align: top;" width="100" height="20"></canvas></span></td>
              </tr>
              <tr>
                <td>621</td>
                <td>Kode Landing Page</td>
                <td><span class="label label-info">Testing</span></td>
                <td class="text-right"><span class="demo-project-stats"><canvas style="display: inline-block; width: 100px; height: 20px; vertical-align: top;" width="100" height="20"></canvas></span></td>
              </tr>
              <tr>
                <td>621</td>
                <td>John Coffe Shop Logo</td>
                <td><span class="label label-danger">Canceled</span></td>
                <td class="text-right"><span class="demo-project-stats"><canvas style="display: inline-block; width: 100px; height: 20px; vertical-align: top;" width="100" height="20"></canvas></span></td>
              </tr>
              <tr>
                <td>621</td>
                <td>BKM Website Design</td>
                <td><span class="label label-primary">Reply waiting</span></td>
                <td class="text-right"><span class="demo-project-stats"><canvas style="display: inline-block; width: 100px; height: 20px; vertical-align: top;" width="100" height="20"></canvas></span></td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
</div>
<!-- END CONTAINER -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 

<?php include_once (MODULE_PATH . 'default/views/footer.php'); ?>
</div>
<!-- End Content -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 