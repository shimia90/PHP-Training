<?php 
    $inputSubmit    =   Helper::cmsInput('submit', 'form[submit]', 'submit', 'Register', 'register');
    $inputToken     =   Helper::cmsInput('hidden', 'form[token]', 'token', time(), '');
    
    $rowUserName    =   Helper::cmsRow('Username:'  , Helper::cmsInput('text', 'form[username]', 'username', '', 'contact_input'));
    $rowFullName    =   Helper::cmsRow('Fullname:'  , Helper::cmsInput('text', 'form[fullname]', 'fullname', '', 'contact_input'));
    $rowEmail       =   Helper::cmsRow('Email:'     , Helper::cmsInput('email', 'form[email]', 'email', '', 'contact_input'));
    $rowPassword    =   Helper::cmsRow('Password:'  , Helper::cmsInput('password', 'form[password]', 'password', '', 'contact_input'));
    $rowSubmit      =   Helper::cmsRow('Submit'     , $inputToken . $inputSubmit , true);
    
    $linkAction     =   URL::createLink('default', 'user', 'register');
?>
<div class="title">
	<span class="title_icon"><img src="<?php echo $imageURL; ?>/bullet1.gif" /></span>Register
</div>

<div class="feat_prod_box_details">
	<p class="details">Lorem ipsum dolor sit amet, consectetur adipisicing
		elit, sed do eiusmod tempor incididunt ut labore et dolore magna
		aliqua. Ut enim ad minim veniam, quis nostrud. Lorem ipsum dolor sit
		amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
		ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
		nostrud.</p>

	<div class="contact_form">
		<div class="form_subtitle">create new account</div>
		<form name="adminforn" action="<?php echo $linkAction; ?>" method="post">
			<?php echo $rowUserName . $rowFullName . $rowEmail . $rowPassword . $rowSubmit; ?>
		</form>
	</div>

</div>
