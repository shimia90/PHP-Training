<?php 
include_once (MODULE_PATH . 'default/views/top.php');
include_once (MODULE_PATH . 'default/views/sidebar.php');
$xhtml 				= 		'';
$colSpan 			= 		'15';
if(!empty($this->arrayWork)) {
	$divider 			= 		'';
	$totalStandard      =       0;
	$totalReal 			=		0;
	$j                  =       0;
	$totalPerformance   =       0;
	$countArrayWork 	=		count($this->arrayWork);
	$tdDesigner = '';
	foreach($this->arrayWork as $key => $value) {
			foreach($this->arrayUser as $k => $v) :
			  if($value['user'] == $v['id']) {
				  $value['user'] = $v['nickname'];
			  }   
			endforeach;
			$tmpUser = $value['user'];
			if($value['project_type'] == 'Other' || $value['project_type'] == 'Research') {
			  $totalStandard  += 0;
			  $totalReal      +=      $value['real_duration'];
			  $totalPerformance += 0;
			} else {
			  $totalStandard  += $value['standard_duration'];
			  $totalReal      +=      $value['real_duration'];
			  
			}
															  
			if($value['performance'] != 0) {
			  $j              +=      1;
			  $totalPerformance += $value['performance'];	  
			}
			
			if(isset($_POST['date_all_from']) && isset($_POST['date_all_to']) && trim($_POST['date_all_from']) != '' && trim($_POST['date_all_to'])) :
				$tdDesigner = '<td class="text-center">'.$value['user'].'</td>';
			else:
				$tdDesigner = '';
			endif;
			
			$xhtml 	.=	'<tr class="gradeX">';	
				$xhtml  .=	'<td>'.$value['work_date'].'</td>
							 <td class="text-center">'.($key+1).'</td>'.$tdDesigner.'
							 <td class="text-center">'.Helper::emptyReturn($value['project_type']).'</td>
							 <td class="text-center">'.Helper::emptyReturn($value['project_no']).'</td>
							 <td class="text-center">'.Helper::emptyReturn($value['project_name']).'</td>
							 <td class="text-center">'.Helper::emptyReturn($value['order_date']).'</td>
							 <td class="text-center">'.Helper::emptyReturn($value['delivery_date']).'</td>
							 <td class="text-center">'.Helper::emptyReturn($value['delivery_before']).'</td>
							 <td class="text-center">'.Helper::emptyReturn($value['status']).'</td>
							 <td class="text-center">'.Helper::emptyReturn($value['standard_duration']).'</td>
							 <td class="text-center">'.Helper::emptyReturn($value['real_duration']).'</td>
							 <td class="text-center">'.Helper::emptyReturn($value['start']).'</td>
							 <td class="text-center">'.Helper::emptyReturn($value['end']).'</td>
							 <td class="text-center">'.(Helper::emptyReturn($value['performance']) * 100).'%</td>
							 <td class="text-center">'.Helper::emptyReturn($value['note']).'</td>
							 ';
			$xhtml  .=	'</tr>';
			if(($key+1) < $countArrayWork) {
				 if($this->arrayWork[$key]['work_date'] != $this->arrayWork[$key+1]['work_date']) {
					 $divider = '<tr class="info"><td class="text-center padding-0" colspan="16">&nbsp;</td></tr>';
				 } else {
					 $divider = '';
				 }
			 } 
			$xhtml .= $divider;
		}
		
		//
		if(!@$_POST['date_all_from'] && isset($_POST['date_from']) && isset($_POST['date_to']) && $_POST['date_from'] != '' && $_POST['date_to'] && $_POST['user_name'] != '') :
			$statusClass = '';
		   	if($totalStandard <= 6 || $totalReal <= 6) {
			   $statusClass = 'label-danger';
		   	} elseif($totalStandard >= 7 && $totalStandard <= 8 || $totalReal >= 7 && $totalReal <= 8) {
			   $statusClass = 'label-info';
		   	} elseif($totalStandard > 8 && $totalReal > 8) {
			   $statusClass = 'label-success';
		   	}
			$xhtml .= '<tr id="work_sum">
							<td colspan="8"></td>
					   		<td class="text-center"><b>Total</b></td>
					   		<td class="text-center"><span class="label '.$statusClass.'">'.$totalStandard.'</span></td>
					   		<td class="text-center"><span class="label '.$statusClass.'">'.$totalReal.'</span></td>
					   		<td></td>
					   		<td class="text-center"><b>Average</b></td>
							<td class="text-center"><span class="label '.$statusClass.'">'.@round(($totalPerformance / $j * 100), 2).'%</span></td>
							<td colspan="2"></td>
						</tr>';
		endif;
		//
		if(!empty($arrayTotalFilter)) :
			$xhtml .= '<tr id="work_sum">
							<td colspan="9"></td>
							<td class="text-center"><b>Total</b></td>
							<td class="text-center"><span class="label label-info">'.$value['total_standard'].'</span></td>
							<td class="text-center"><span class="label label-info">'.$value['total_real'].'</span></td>
							<td></td>
						    <td class="text-center"><b>Average</b></td>
						    <td class="text-center"><span class="label label-info">'.@round(($totalPerformance / $j * 100), 2).'%</span></td>
						    <td colspan="2"></td>
					   </tr>';
		endif;
} else {
		if(isset($_POST['date_all_from']) && isset($_POST['date_all_to'])) { $colSpan = '16'; } else { $colSpan = '15'; }
			$xhtml .= '<tr class="warning">
					    	<td class="text-center" colspan="'.$colSpan.'"><strong>No Records</strong></td>
					   </tr>';	
}
if(isset($_POST['date_all_from']) && isset($_POST['date_all_to'])) { $colSpan = '16'; } else { $colSpan = '15'; }
?>
 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTENT -->
<div class="content">

  <!-- Start Page Header -->
  
  <!-- End Page Header -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTAINER -->
<div class="panel-body">


    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-fixed" id="example">
    	<thead>
        	<tr>
            	<th colspan="<?php echo $colSpan; ?>">
                	<h1 class="title"><?php echo $this->_title; ?></h1>
                </th>
            </tr>
        	<tr>
            	<th colspan="<?php echo $colSpan; ?>">
                	<div class="row">
                    	<div class="col-lg-8 col-md-8">
                        	<?php echo $this->searchForm; ?><?php echo @$this->htmlWorkTime; ?>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <button tabindex="0" class="btn btn-info" role="button" data-toggle="popover" data-trigger="click" data-placement="left" data-container="body" data-html="true" id="PopS"
                            data-content='
                            <div id="popover-content">
                            
                            <form role="form" method="post" action="<?php echo URL::createLink('default', 'personal', 'index'); ?>">
                                
                                <div class="form-group">
                                    <label>Select Date</label>
                                    <div class="input-group date margin-b-10">
                                        <input type="text" class="form-control" id="datetimepicker" name="date_all_from" placeholder="From" />
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </span>
                                    </div>
                                    <div class="input-group date margin-b-10">
                                        <input type="text" class="form-control" id="datetimepicker1" name="date_all_to" placeholder="To" />
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </span>
                                    </div>
                                    
                                    <!-- Create Filter -->
                                    <?php echo $this->selectFilter; ?>
                                    
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Show</button>
                                </div>
                            </form>
                            </div>'><i class="fa fa-expand"></i> Show All</button>
                        </div>
                    </div>
                </th>
            </tr>
            <tr class="success">
                <th>Working Date</th>
                <th class="text-center">No</th>
                <?php echo $this->tableHead; ?>
                <th class="text-center">Project Type</th>
                <th class="text-center">Project no.</th>
                <th class="text-center">Project Name</th>
                <th class="text-center">Order Date</th>
                <th class="text-center">Delivery Date</th>
                <th class="text-center">Delivery Before</th>
                <th class="text-center">Status</th>
                <th class="text-center">Standard Duration</th>
                <th class="text-center">Real Duration </th>
                <th class="text-center">Start</th>
                <th class="text-center">End</th>
                <th class="text-center">Performance</th>
                <th class="text-center">Note</th>
            </tr>
        </thead>
        <tbody>
        	<?php echo $xhtml; ?>
        </tbody>
    </table>
</div>
<div class="container-widget margin-t-40">
	<div class="row">
    	<div class="col-md-12">
        	<?php echo @$this->htmlTimeline; ?>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-12">
        	<!--  Chart Area -->
            <div id="chart_area" class="margin-t-40 margin-b-40">
                <div class="container-fluid">
                    <div class="row">
                        <div class="span12">
                            <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                        </div><!--  span4 -->
                        
                    </div><!--  row -->
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="project_chart" style="height: 300px; width: 100%;"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="project_maintenance_chart" style="height: 300px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div><!--  chart_area -->
        </div>
    </div>
</div>
<!-- END CONTAINER -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 

<?php include_once (MODULE_PATH . 'default/views/footer.php'); ?>
<!-- Hight Chart -->
<?php echo @$this->htmlHighChart; ?>

</div>
<!-- End Content -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 