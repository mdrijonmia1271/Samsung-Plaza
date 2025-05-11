<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $site_name . ' | ' . $meta_title; ?></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
        <link href="<?php echo site_url('private/css/login.min.css'); ?>" rel="stylesheet">
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
            <form method="post" action="<?php echo site_url('forgot_password/forgot_password/sent_reset_code'); ?>" class="login-form">
                <div class="form-head">
                    <h3>Reset Password</h3>
                </div>
    
                <div class="form-input">
                    <div class="form-success">
                         <?php echo $this->session->flashdata('confirmation'); ?>
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="E-mail" required>
                    </div>
    
                    <div class="form-group">
                        <input type="submit" name="reset" class="btn" value="Get Reset Link">
                    </div>
    
                    <div class="form-group">
                        <a target="_blank" href="<?php echo base_url(); ?>">Home</a>
                    </div>
                </div>

            </form>
        </section>

    </body>
</html>
