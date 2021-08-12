<!DOCTYPE html>
<html lang="en">

<head>
    <title>Fulkrum Admin Panel</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="..." />
    <meta name="author" content="Admin Panel" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- app favicon -->
    
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/vendors.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css" />
</head>

<body class="bg-white">
    <!-- begin app -->
    <div class="app">
        <!-- begin app-wrap -->
        <div class="app-wrap">
            <!-- begin pre-loader -->
            <!--<div class="loader">
                <div class="h-100 d-flex justify-content-center">
                    <div class="align-self-center">
                        <img src="assets/img/loader/loader.svg" alt="loader">
                    </div>
                </div>
            </div>-->
            <!-- end pre-loader -->

            <!--start login contant-->
            <div class="app-contant">
                <div class="bg-white">
                    <div class="container-fluid p-0">
                        <div class="row no-gutters">
                            <div class="col-md-6">
                              <div class="form-content">
                                <h1 class="">Reset Password </h1>
                                <form class="text-left mt-5" action="<?php echo base_url(); ?>forgotResetPassword" method="post" role="form" enctype="multipart/form-data">
                                    <?php
                            $error = $this->session->flashdata('error');
                            if($error)
                            {
                                ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <?php echo $error; ?>                    
                                </div>
                            <?php }
                            $success = $this->session->flashdata('success');
                            if($success)
                            {
                            ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $success; ?>                    
                            </div>
                             <div class="col-lg-6">
                                <a href="<?php echo base_url();?>login"  class="btn btn-small btn-primary mt-4">Login</a>
                            </label>
                          </div>
                            <?php }
                            else
                            {
                            ?>
                                    <input type="hidden" name="email" value="<?php echo $_GET["email"]; ?>">
                                <div class="form">
                                    <div id="password-field" class="field-wrapper input mb-2">
                                        <label class="control-label">New Password</label>
                                        <input id="password" name="password" type="password" class="form-control" placeholder="New Password">
                                    </div>

                                    <div id="password-field" class="field-wrapper input mb-2">
                                        <label class="control-label">Confirm Password</label>
                                        <input id="password" name="confirm_password" type="password" class="form-control" placeholder="Confirm Password">
                                    </div>

                                    <div class="mt-5">
                                        <div class="field-wrapper">
                                            <button  type="submit" class="btn btn-primary">Reset Password</button>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                                </form> 

                            </div>
                            </div>

                            <div class="col-md-6  bg-gradient login o-hidden order-1 order-sm-2">
                                <div class="form-image">
                                    <img src="<?php echo base_url(); ?>assets/img/logo/logo.png">           
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Forgot Password Modal -->
                <div class="modal fade" id="forgot-passwd" tabindex="-1" role="dialog" aria-labelledby="forgot-passwd">
                  <div class="modal-dialog modal-dialog-centered modal-min" role="document">
                    <div class="modal-content">
                      <div class="modal-body text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button> <i class="flaticon-secure-shield d-block"></i>
                        <h2>Forgot Password?</h2>
                        <p>Enter your email to recover your password</p>
                        <form method="post"  class="px-3 pt-5 pb-3">
                          <div class="ms-form-group has-icon">
                            <input type="text" placeholder="Email Address" class="form-control" name="forgot-password" value="">
                          </div>
                          <button type="submit" class="btn btn-primary shadow-none">RESET PASSWORD</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <!--end login contant-->
        </div>
        <!-- end app-wrap -->
    </div>
    <!-- end app -->



    <!-- plugins -->
    <script src="<?php echo base_url(); ?>assets/js/vendors.js"></script>

    <!-- custom app -->
    <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
</body>

</html>