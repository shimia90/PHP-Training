<?php
include_once 'toolbar/index.php';
include_once 'submenu/index.php';

// INPUT
$inputName              =           Helper::cmsInput('text', 'form[name]', 'name', null, 'inputbox required', 40);
$inputOrdering          =           Helper::cmsInput('text', 'form[ordering]', 'ordering', null, 'inputbox', 40);
$selectStatus           =           Helper::cmsSelectBox('form[status]', null, array('default'  =>  'Select Status', 1 => 'Publish', 0 => 'Unpublish'));

// ROW
$rowName                =           Helper::cmsRowForm('Name', $inputName , true);
$rowOrdering            =           Helper::cmsRowForm('Ordering', $inputOrdering);
$rowStatus              =           Helper::cmsRowForm('Status', $selectStatus);
?>
<div id="element-box">
	<div class="m">
		<form action="#" method="post" name="adminForm" id="adminForm"
			class="form-validate">
			<!-- FORM LEFT -->
			<div class="width-100 fltlft">
				<fieldset class="adminform">
					<legend>Details</legend>
					<ul class="adminformlist">
						<?php echo $rowName . $rowOrdering . $rowStatus ; ?>
						
					</ul>
					<div class="clr"></div>
					<div>
						<input type="hidden" name="form[token]" value="1384158288">
					</div>
				</fieldset>
			</div>
			<div class="clr"></div>
			<div></div>
		</form>
		<div class="clr"></div>
	</div>
</div>
