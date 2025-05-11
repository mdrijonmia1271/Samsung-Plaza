<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>
        <link rel="icon" href="" type="image/png">

        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
        <link href="<?php echo site_url('private/css/login.min.css'); ?>" rel="stylesheet">
        
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

	    <style>
	        .form-head h3 {margin: 0px !important;line-height: 2.7;}
    		.form-group {position: relative;}
    		.form-group #show {
    			position: absolute;
    			top: 47%;
    			right: 3px;
    			border: none;
    			background: transparent
    		}
	        .form-group #show i {color: #1976D2;opacity: 0.6;font-size: 18px;}
	    </style>
    </head>

    <body style="background: url(<?php echo site_url('public/programmer.jpg'); ?>);background-repeat: no-repeat;background-size: cover;">

        <section class="container">
            <form method="post" action="<?php echo site_url('smsControl/login');?>" class="login-form">
            
            <div class="form-head">
                <h3>Control Panel</h3>
            </div>
            <div class="form-input">
                <div class="form-group">
                    <label>Usernames</label>
                    <input type="text" name="username" placeholder="Username" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input type="password" id="pass" name="password" placeholder="Password" class="form-control" required>
                    <div id="show" class="btn btn-default" onclick="showHide()">
                    	<i class="glyphicon glyphicon-eye-open"></i>
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" name="submit_login" class="btn" value="Login">
                </div>

            </div>

            </form>
        </section>
        
        
    <script>
		function showHide() {
			var x = document.getElementById("pass");
			
			if (x.type === "password") {
				x.type = "text";
				} else {
				x.type = "password";
			}
			if($('#show i.glyphicon').hasClass('glyphicon-eye-open')) {
				$('#show i.glyphicon').removeClass('glyphicon-eye-open');
				$('#show i.glyphicon').addClass('glyphicon-eye-close');
			} else {
				$('#show i.glyphicon').removeClass('glyphicon-eye-close');
				$('#show i.glyphicon').addClass('glyphicon-eye-open');
			}
		}
	</script>

    </body>
</html>