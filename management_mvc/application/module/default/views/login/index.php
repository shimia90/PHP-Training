<div class="login-form">
	<div class="kode-alert alert6">
		<a class="closed" href="#"><i class="fa fa-close"></i></a> <?php echo @$this->errors; ?>
	</div>
	
	<form action="<?php echo URL::createLink('default', 'login', 'index'); ?>" method="post" name="loginForm[]">
		<div class="top">
			<h1>Login</h1>
			<h4>Freesale Vietnam</h4>
		</div>
		<div class="form-area">
			<div class="group">
				<input type="text" class="form-control" placeholder="Username" name="loginForm[username]" > <i
					class="fa fa-user"></i>
			</div>
			<div class="group">
				<input type="password" class="form-control" placeholder="Password" name="loginForm[password]">
				<i class="fa fa-key"></i>
			</div>
			<div class="checkbox checkbox-primary">
				<input id="checkbox101" type="checkbox" name="loginForm[remember]"> <label
					for="checkbox101"> Remember Me</label>
			</div>
			<!-- TOKEN -->
            <input name="loginForm[token]" type="hidden" value="<?php echo time(); ?>" />
			<button type="submit" class="btn btn-default btn-block">LOGIN</button>
		</div>
	</form>
	<!-- <div class="footer-links row">
		<div class="col-xs-6">
			<a href="#"><i class="fa fa-external-link"></i> Register Now</a>
		</div>
		<div class="col-xs-6 text-right">
			<a href="#"><i class="fa fa-lock"></i> Forgot password</a>
		</div>
	</div> -->
</div>