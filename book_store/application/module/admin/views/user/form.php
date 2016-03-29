<?php
include_once 'toolbar/index.php';
include_once 'submenu/index.php';

// INPUT
$dataForm               =           @$this->arrParam['form'];
$inputUserName          =           Helper::cmsInput('text', 'form[username]', 'username', @$dataForm['username'], 'inputbox required', 40);
$inputEmail             =           Helper::cmsInput('text', 'form[email]', 'email', @$dataForm['email'], 'inputbox required', 40);
$inputFullName          =           Helper::cmsInput('text', 'form[fullname]', 'fullname', @$dataForm['fullname'], 'inputbox', 40);
$inputPassword          =           Helper::cmsInput('password', 'form[password]', 'password', @$dataForm['password'], 'inputbox required', 40);
$inputOrdering          =           Helper::cmsInput('text', 'form[ordering]', 'ordering', @$dataForm['ordering'], 'inputbox', 40);
$inputToken             =           Helper::cmsInput('hidden', 'form[token]', 'token', time());
$slbStatus              =           Helper::cmsSelectBox('form[status]', null, array('default'  =>  '- Select Status -', 1 => 'Publish', 0 => 'Unpublish'), @$dataForm['status'] , 'width: 150px;');
$slbGroup               =           Helper::cmsSelectBox('form[group_id]', 'inputbox', $this->slbGroup, @$dataForm['group_id']);

$inputID                =           '';
$rowID                  =           '';
if(isset($this->arrParam['id']) || @$dataForm['id']) {
    $inputID            =           Helper::cmsInput('text', 'form[id]', 'name', @$dataForm['id'], 'inputbox readonly', 40);
    $rowID              =           Helper::cmsRowForm('ID', $inputID);
}

// ROW
$rowUserName            =           Helper::cmsRowForm('Username', $inputUserName , true);
$rowEmail               =           Helper::cmsRowForm('Email', $inputEmail, true);
$rowFullName            =           Helper::cmsRowForm('Full Name', $inputFullName);
$rowPassword            =           Helper::cmsRowForm('Password', $inputPassword, true);
$rowOrdering            =           Helper::cmsRowForm('Ordering', $inputOrdering);
$rowStatus              =           Helper::cmsRowForm('Status', $slbStatus);
$rowGroup               =           Helper::cmsRowForm('Group', $slbGroup);

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
						<?php echo $rowUserName . $rowEmail . $rowFullName . $rowPassword . $rowStatus . $rowGroup . $rowOrdering . $rowID; ?>
						
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
