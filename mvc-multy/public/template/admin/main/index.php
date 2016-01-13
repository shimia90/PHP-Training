<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="management mvc" />
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/template.css"/>
    <link rel="stylesheet" type="text/css" href="css/system.css"/>
    <script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
	<div id="border-top" class="h_blue">
		<span class="title"><a href="index.php">Administration</a></span>
	</div>
	<div id="content-box">
		<div id="element-box" class="login">
			<div class="m wbg">
				<h1>Administration Login</h1>
                <!-- ERROR -->
				<div id="system-message-container">
                    <dl id="system-message">
                        <dt class="error">Error</dt>
                        <dd class="error message">
                            <ul>
                                <li>Empty password not allowed</li>
                            </ul>
                        </dd>
                    </dl>
                </div>
				
                <div id="section-box">
					<div class="m">
						<form action="#" method="post" id="form-login">
							<fieldset class="loginform">
                                <label>User Name</label>
                                <input name="username" id="mod-login-username" type="text" class="inputbox" size="15" />
                                <label id="mod-login-password-lbl" for="mod-login-password">Password</label>
                                <input name="passwd" id="mod-login-password" type="password" class="inputbox" size="15" />
                                <div class="button-holder">
                                    <div class="button1">
                                        <div class="next">
                                            <a href="#" onclick="document.getElementById('form-login').submit();">Log in</a>
                                        </div>
                                    </div>
                                </div>
								<div class="clr"></div>
                            </fieldset>
						</form>
						<div class="clr"></div>
					</div>
				</div>
		
            	<p>Use a valid username and password to gain access to the administrator backend.</p>
            	<p><a href="http://localhost/joomla/">Go to site home page.</a></p>
				<div id="lock"></div>
			</div>
		</div>
	</div>
	<div id="footer">
		<p class="copyright">
			<a href="http://www.joomla.org">Joomla!&#174;</a> is free software released under the <a href="http://www.gnu.org/licenses/gpl-2.0.html">GNU General Public License</a>.	
		</p>
	</div>
</body>
</html>
