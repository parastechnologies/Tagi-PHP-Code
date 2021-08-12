<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tagi Admin Panel</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="..." />
    <meta name="author" content="Admin Panel" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- app favicon -->
    
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/vendors.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css" />
</head>

<body class="">
    <!-- begin app -->
    <div class="app">
        <!-- begin app-wrap -->
        <div class="app-wrap">
            <!-- begin pre-loader -->
            <!--<div class="loader">
                <div class="h-100 d-flex justify-content-center">
                    <div class="align-self-center">
                        <img src="<?php echo base_url(); ?>assets/img/loader/loader.svg" alt="loader">
                    </div>
                </div>
            </div>-->
            <!-- end pre-loader -->

            <!--start login contant-->
            <div class="app-contant bg-gradient login">
                <div class="">
                    <div class="container-fluid p-0">
                        <div class="row no-gutters">
                            <div class="col-md-6 offset-md-3">
                              <div class="form-content">
                                <img src="<?php echo base_url(); ?>assets/img/logo/logo.png">
                                <h1 class="">Log In to <a><span class="brand-name">Tagi</span></a></h1>
                                <?php $this->load->helper('form'); ?>
                                  <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                                <div class="col-md-12">
                                    <?php
                                    $error = $this->session->flashdata('error');
                                    if($error)
                                    {
                                        ?>
                                       <!-- <div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <?php// echo $error; ?>                    
                                        </div>-->
                                        <div class="alert alert-danger" role="alert">
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                          <?php echo $error; ?> 
                                        </div>
                                    <?php }
                                    $success = $this->session->flashdata('success');
                                    if($success)
                                    {
                                    ?>
                                    <div class="alert alert-success alert-dismissable" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <?php echo $success; ?>                    
                                    </div>
                                    <?php } ?> 
                                </div>
                                <form class="text-left mt-5" action="<?php echo base_url(); ?>loginMe" method="post" role="form" enctype="multipart/form-data">
                                    <div class="form">
                                        <div id="username-field" class="field-wrapper input">
                                            <label class="control-label">User Name</label>
                                            <input id="username" name="email" type="email" class="form-control" placeholder="Enter Username" >
                                        </div>

                                        <div id="password-field" class="field-wrapper input mb-2">
                                            <label class="control-label">Password</label>
                                            <input id="password" name="password" type="password" class="form-control" placeholder="Enter Password">
                                        </div>
                                        <div class="d-sm-flex justify-content-between">
                                            <div class="field-wrapper forgot-passwd">
                                              <a href="forgot_password.html" class="forgot-pass-link" data-toggle="modal" data-target="#forgot-passwd"><i class=" ti ti-lock pr-2 text-info"></i>Forgot Password?</a>
                                            </div>
                                        </div>

                                        <div class="mt-5">
                                            <div class="field-wrapper">
                                                <input type="submit" class="btn btn-info" style="width:100%" value="Log In">
                                            </div>
                                        </div>

                                    </div>
                                </form> 
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
                        <form id="formoid" method="post" class="px-3 pt-5 pb-3">
                        <div id='required' style="display:none" class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <span id="showMsg"></span>
                        </div>
                        <div style="display:none" id="required1" class="alert alert-success alert-dismissable" role="alert" >
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  
                             <span id="showMsg1"></span>
                        </div>
                          <div class="ms-form-group has-icon">
                            <input type="email" placeholder="Email Address" id="emailID" class="form-control" name="email" value="" requried>
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
    <script src="<?php echo base_url(); ?>assets/js/vendors.js"></script>

    <!-- custom app -->
    <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
        <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script type='text/javascript'>
        $("#formoid").submit(function(event) {
            event.preventDefault();
            var email = $("#emailID").val();
            dataString = "login_email="+email
            $.ajax({ 
                type: 'post',    
                url: '<?php echo base_url() ?>Login/forgotPasswordMail',
                data: dataString,
                cache: false,
                success: function(res) {
                    if(res == 2){
                        /*$("#required").show();
                        $("#showMsg").text("Email is required");*/
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Email is required',
                        })
                    }
                     if(res == 3){
                        /*$("#required").show();
                        $("#showMsg").text("This email is not found, Please try with the valid Email!");*/
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'This email is not found, Please try with the valid Email!',
                        })
                    }
                     if(res == 4){
                        /*$("#required").show();
                        $("#showMsg").text("Email error");*/
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Email error',
                        })
                    }
                     if(res == 1){
                        /*$("#required1").show();
                        $("#showMsg1").text("Please check your e-mail, we have sent a password reset link to your registered Email.");
                        */
                        Swal.fire(
                          'Success!',
                          'Please check your e-mail, we have sent a password reset link to your registered Email.',
                          'success'
                        ).then((result) => {
                          if (result.value) {
                              window.location.reload();
                          }
                        })  
                    } 
                }
            });
        });
        
         window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);
    </script>
    
</body>

</html>