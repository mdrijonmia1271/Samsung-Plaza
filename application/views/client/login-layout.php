<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $meta_title; ?></title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <style>
            .login-panel {
                border-radius: 15px;
                box-shadow: 0 3px 20px 0px rgba(0, 0, 0, 0.1);
                -moz-box-shadow: 0 3px 20px 0px rgba(0, 0, 0, 0.1);
                -webkit-box-shadow: 0 3px 20px 0px rgba(0, 0, 0, 0.1);
                -o-box-shadow: 0 3px 20px 0px rgba(0, 0, 0, 0.1);
                -ms-box-shadow: 0 3px 20px 0px rgba(0, 0, 0, 0.1);
            }

            .login-panel .title {
                background: #57b846;
                color: #ffff;
            }

            .login-panel .form-control {
                border-radius: 15px;
                padding: .8rem;
            }

            .login-panel .submit-btn {
                background: #57b846;
                color: #ffff;
                width: 100%;
                border-radius: 15px;
                padding: .6rem;
                font-weight: bold;
                font-size: 1.2rem;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center" style="height: 100vh;">
                <div class="col-lg-5">
                    <div class="login-panel overflow-hidden">
                        <div class="title p-4">
                            <h3 class="text-center m-0 fw-bold">Client Login</h3>
                        </div>

                        <div class="body p-5">

                            <?php
                            $errorMessage = $this->session->flashdata('error');
                            if (!empty($errorMessage)) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $errorMessage; ?>
                                </div>
                            <?php } ?>

                            <?php echo form_open('client/login/loginValidity', ['class' => 'pt-3 pb-3']) ?>

                            <div class="mb-3">
                                <input type="text" name="username" class="form-control" placeholder="Username"
                                       autocomplete="off" required>
                            </div>

                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                       autocomplete="off" required>
                            </div>

                            <div class="pt-3 mb-3">
                                <input type="submit" name="login" value="Sign In" class="submit-btn btn">
                            </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>