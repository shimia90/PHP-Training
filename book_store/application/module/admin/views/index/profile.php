<?php
include_once (MODULE_PATH . 'admin/views/toolbar.php');

// INPUT
$dataForm               =           @$this->arrParam['form'];
$inputFullName          =           Helper::cmsInput('text', 'form[fullname]', 'fullname', @$dataForm['fullname'], 'inputbox required', 40);
$inputEmail             =           Helper::cmsInput('text', 'form[email]', 'email', @$dataForm['email'], 'inputbox required', 40);

$inputID                =           '';
$rowID                  =           '';
if(isset($this->arrParam['id']) || @$dataForm['id']) {
    $inputID            =           Helper::cmsInput('text', 'form[id]', 'name', @$dataForm['id'], 'inputbox readonly', 40);
    
}

// ROW
$rowEmail               =           Helper::cmsRowForm('Email', $inputEmail, true);
$rowID              	=           Helper::cmsRowForm('ID', $inputID);
$rowFullName            =           Helper::cmsRowForm('Full Name', $inputFullName);

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
						<?php echo $rowEmail . $rowFullName . $rowID; ?>
						
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
