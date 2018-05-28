    <?php include HOME . '/Core/includes/login.inc.php'; ?> 
    
    
<div class="wrapper">

<h2>Login</h2>

<p>Please fill in your credentials to login.</p>

<form action="" method="post">

    <div class="form-group <?php echo (!empty(get_username_error())) ? 'has-error' : ''; ?>">

        <label>Username</label>

        <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">

        <span class="help-block"><?php echo get_username_error(); ?></span>

    </div>    

    <div class="form-group <?php  echo (!empty(get_password_error())) ? 'has-error' : ''; ?>">

        <label>Password</label>

        <input type="password" name="password" class="form-control">

        <span class="help-block"><?php echo get_password_error(); ?></span>

    </div>

    <div class="form-group">

        <input type="submit" class="btn btn-primary" value="Login">

    </div>

    <p>Don't have an account? <a href="/user/register">Sign up now</a>.</p>

</form>

</div>    <!-- close wrapper -->
