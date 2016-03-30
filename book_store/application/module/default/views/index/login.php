<?php
 
	// Input
    $inputSubmit    =   Helper::cmsInput('submit', 'form[submit]', 'submit', 'login', 'register');
    $inputToken     =   Helper::cmsInput('hidden', 'form[token]', 'token', time(), '');
    
	// Row
    $rowEmail       =   Helper::cmsRow('Email'     , Helper::cmsInput('email', 'form[email]', 'email', null, 'contact_input'));
    $rowPassword    =   Helper::cmsRow('Password'  , Helper::cmsInput('password', 'form[password]', 'password', null, 'contact_input'));
    $rowSubmit      =   Helper::cmsRow('Submit'     , $inputToken . $inputSubmit , true);
    
    $linkAction     =   URL::createLink('default', 'index', 'login');
?>
<div class="title">
	<span class="title_icon"><img src="<?php echo $imageURL; ?>/bullet1.gif" /></span>Login
</div>

<div class="feat_prod_box_details">

	<div class="contact_form">
		<div class="form_subtitle">Login</div>
        <?php echo @$this->errors; ?>
		<form name="adminforn" action="<?php echo $linkAction; ?>" method="post">
			<?php echo $rowEmail . $rowPassword . $rowSubmit; ?>
		</form>
	</div>

</div>
