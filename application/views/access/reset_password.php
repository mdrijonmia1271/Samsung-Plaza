<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $site_name . ' | ' . $meta_title; ?></title>

        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
        <link href="<?php echo site_url('private/css/login.min.css'); ?>" rel="stylesheet">
        <script src="<?php echo base_url(); ?>public/js/jquery.1.8.3.min.js"></script>
        <style>
            .form-input input[type='email']{
                width:100%;
                height:40px;
                line-height:40px;
                padding:0 8px;
                border:1px solid #ccc;
            }
            .form-input input[type='email']:focus{
                outline:none;
                border-color:#1976D2;
            }
        </style>
    </head>

    <body>

        <section class="container">
            <form method="post" action="<?php echo site_url('forgot_password/forgot_password/reset_password'); ?>" class="login-form">
                <div class="form-head">
                    <h3>Reset Password</h3>
                </div>
    
                <div class="form-input">
                    <div class="form-error">
                         <?php echo $this->session->flashdata('confirmation'); ?>
                    </div>
    
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="hidden" name="reset_code" value="<?php echo $reset_code;?>" required >
                        <input type="password" name="password"  id="password" placeholder="Enter New password" required >
                    </div>
                    
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirmPassword" placeholder="Enter Confirm password" required >
                    </div>    
                    
                    <div class="form-group">
                        <input type="submit" name="update_password"  class="btn" value="Recover">
                    </div>
    
                    <div class="form-group">
                        <a target="_blank" href="<?php echo base_url(); ?>">Home</a>
                    </div>
                </div>

            </form>
        </section>
        
        <script type="text/javascript">
            $(document).ready(function(){
               $('form').submit(function(){
                    var password = $('#password').val();
                    var passwordLength = password.length;
                    var confirmPassword = $('#confirmPassword').val();
                    var confirmPasswordLength = confirmPassword.length;
                    if((passwordLength<6 || passwordLength>20) || (confirmPasswordLength<6 || confirmPasswordLength>20))
                    {
                        alert('Please Given  Password Length  Minimum 6 Character and Maximum 20 Character !');
                        return false;
                    }
                    
                    var n = password.localeCompare(confirmPassword);
                    if(n != 0)
                    {
                        alert('Password and Confirm Password Does Not Match');
                        return false;
                    }
                    
               });
            });
        </script>
    </body>
</html>
