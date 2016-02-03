<?php
include_once 'toolbar/index.php';
include_once 'submenu/index.php';

// INPUT
$dataForm               =           @$this->arrParam['form'];
$inputName              =           Helper::cmsInput('text', 'form[name]', 'name', @$dataForm['name'], 'inputbox required', 40);
$inputOrdering          =           Helper::cmsInput('text', 'form[ordering]', 'ordering', @$dataForm['ordering'], 'inputbox', 40);
$inputToken             =           Helper::cmsInput('hidden', 'form[token]', 'token', time());
$selectStatus           =           Helper::cmsSelectBox('form[status]', null, array('default'  =>  '- Select Status -', 1 => 'Publish', 0 => 'Unpublish'), @$dataForm['status'] , 'width: 150px;');
$selectGroupACP         =           Helper::cmsSelectBox('form[group_acp]', null, array('default'  =>  '- Select Group ACP -', 1 => 'Yes', 0 => 'No'), @$dataForm['group_acp'] , 'width: 150px;');

$inputID                =           '';
$rowID                  =           '';
if(isset($this->arrParam['id'])) {
    $inputID            =           Helper::cmsInput('text', 'form[id]', 'name', @$dataForm['id'], 'inputbox readonly', 40);
    $rowID              =           Helper::cmsRowForm('ID', $inputID);
}

// ROW
$rowName                =           Helper::cmsRowForm('Name', $inputName , true);
$rowOrdering            =           Helper::cmsRowForm('Ordering', $inputOrdering);
$rowStatus              =           Helper::cmsRowForm('Status', $selectStatus);
$rowGroupACP            =           Helper::cmsRowForm('Group ACP', $selectGroupACP);

$message           =   Session::get('message');
Session::delete('message');
$strMessage        =   Helper::cmsMessage($message);
?>
<div id="system-message-container"><?php echo @$this->errors . $strMessage; ?></div>
<div id="element-box">
	<div class="m">
		<form action="#" method="post" name="adminForm" id="adminForm"
			class="form-validate">
			<!-- FORM LEFT -->
			<div class="width-100 fltlft">
				<fieldset class="adminform">
					<legend>Details</legend>
					<ul class="adminformlist">
						<?php echo $rowName . $rowStatus . $rowGroupACP . $rowOrdering . $rowID; ?>
						
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
