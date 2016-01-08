<div class="content">
    <h3>Login</h3>
    <?php 
        echo $errors = (!empty($this->errors)) ? $this->errors : '';
    ?>
    <form action="index.php?controller=user&action=login" method="post" name="form-login" id="form-login">
        <div class="row">
            <p>Username</p>
            <input type="text" name="username" />
        </div>
        <div class="row">
            <p>Password</p>
            <input type="password" name="password" />
        </div>
        <div class="row">
            <input type="submit" name="submit" value="Login" />
        </div>
    </form>
</div>