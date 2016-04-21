<?php
include_once 'toolbar/index.php';
include_once 'submenu/index.php';

// INPUT
$dataForm               =           @$this->arrParam['form'];
$inputName              =           Helper::cmsInput('text', 'form[name]', 'name', @$dataForm['name'], 'inputbox required', 40);
//$inputDescription       =           Helper::cmsInput('text', 'form[description]', 'description', @$dataForm['description'], 'inputbox required', 40);
$inputDescription       =           '<textarea name="form[description]">'.$dataForm['description'].'</textarea>';
$inputPrice             =           Helper::cmsInput('text', 'form[price]', 'price', @$dataForm['price'], 'inputbox required', 40);
$inputSaleOff           =           Helper::cmsInput('text', 'form[sale_off]', 'sale_off', @$dataForm['sale_off'], 'inputbox', 40);
$inputOrdering          =           Helper::cmsInput('text', 'form[ordering]', 'ordering', @$dataForm['ordering'], 'inputbox', 40);
$inputToken             =           Helper::cmsInput('hidden', 'form[token]', 'token', time());
$slbStatus              =           Helper::cmsSelectBox('form[status]', null, array('default'  =>  '- Select Status -', 1 => 'Publish', 0 => 'Unpublish'), @$dataForm['status'] , 'width: 150px;');
$slbSpecial             =           Helper::cmsSelectBox('form[special]', null, array('default'  =>  '- Select Special -', 1 => 'Yes', 0 => 'No'), @$dataForm['special'] , 'width: 150px;');
$slbCategory            =           Helper::cmsSelectBox('form[category_id]', 'inputbox', $this->slbCategory, @$dataForm['category_id']);
$inputPicture 			=			Helper::cmsInput('file', 'picture', 'picture', '', 'inputbox', 40);

$inputID                =           '';

$rowID                  =           '';
$picture 				=			'';
$inputPictureHidden     =           '';
if(isset($this->arrParam['id']) || @$dataForm['id']) {
    $inputID            =           Helper::cmsInput('text', 'form[id]', 'name', @$dataForm['id'], 'inputbox readonly', 40);
	$inputUserName      =           Helper::cmsInput('text', 'form[username]', 'username', @$dataForm['username'], 'inputbox readonly', 40);
    $rowID              =           Helper::cmsRowForm('ID', $inputID);
    
    @$picture 			=			'<img src="'.UPLOAD_URL . 'category' . DS. '60x90-' . $dataForm['picture'].'" />';
    @$inputPictureHidden =			Helper::cmsInput('hidden', 'form[picture_hidden]', 'picture_hidden', $dataForm['picture'], 'inputbox', 40);
}

// ROW
$rowName                =           Helper::cmsRowForm('Name', $inputName , true);
$rowPicture             =           Helper::cmsRowForm('Picture', $inputPicture . $picture . $inputPictureHidden);
$rowDescription         =           Helper::cmsRowForm('Description', $inputDescription);
$rowPrice               =           Helper::cmsRowForm('Price', $inputPrice, true);
$rowSaleOff             =           Helper::cmsRowForm('Sale Off', $inputSaleOff);
$rowOrdering            =           Helper::cmsRowForm('Ordering', $inputOrdering, true);
$rowStatus              =           Helper::cmsRowForm('Status', $slbStatus);
$rowSpecial             =           Helper::cmsRowForm('Special', $slbSpecial);
$rowCategory            =           Helper::cmsRowForm('Category', $slbCategory);


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
						<?php echo $rowName . $rowPicture . $rowDescription . $rowPrice . $rowSaleOff . $rowOrdering . $rowStatus . $rowSpecial . $rowCategory . $rowID; ?>
						
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
