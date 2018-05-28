    <?php include HOME . '/Core/includes/register.inc.php'; ?> 
    
    <div class="form-wrapper">
        <h2>Sign Up</h2>
        
        <p>Please fill this form to create an account.</p>

        <form action="" method="post">

            <div class="form-group <?php echo (!empty(get_username_error())) ? 'has-error' : ''; ?>">

                <label>Username</label>

                <input type="text" name="username"class="form-control" value="<?php echo $username;?>">
                <span class="help-block"><?php echo get_username_error(); ?></span>

            </div>   

            <div class="form-group <?php echo (!empty(get_username_error())) ? 'has-error' : ''; ?>">

                <label>Email</label>

                <input type="text" name="email"class="form-control" value="<?php echo $email; ?>">

                <span class="help-block"><?php echo get_email_error(); ?></span>

            </div>

            <div class="form-group <?php echo (!empty(get_password_error())) ? 'has-error' : ''; ?>">

                <label>Password</label>

                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">

                <span class="help-block"><?php echo get_password_error(); ?></span>

            </div>

            <div class="form-group <?php echo (!empty(get_confirm_password_error())) ? 'has-error' : ''; ?>">

                <label>Confirm Password</label>

                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">

                <span class="help-block"><?php echo get_confirm_password_error(); ?></span>

            </div>

            <div class="form-group">

                <input type="submit" class="btn btn-primary" value="Submit">

                <input type="reset" class="btn btn-default" value="Reset">

            </div>

            <p>Already have an account? <a href="#">Login here</a>.</p>

        </form>

    </div>    <!--close wrapper-->
