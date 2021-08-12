<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tagi Admin Panel</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Swap Admin" />
    <meta name="author" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- app favicon -->
   <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- plugin stylesheets -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/vendors.css" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- app style -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css" />
</head>
<body>
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
            <!-- begin app-header -->
            <header class="app-header top-bar">
                <!-- begin navbar -->
                <nav class="navbar navbar-expand-md">
                    <div class="navbar-header d-flex align-items-center">
                        <a href="javascript:void:(0)" class="mobile-toggle"><i class="ti ti-align-right"></i></a>
                        <a class="navbar-brand" href="index.html">
                            <img src="<?php echo base_url();?>assets/img/logo-full.png" class="img-fluid logo-desktop" alt="logo">
                            <img src="<?php echo base_url();?>assets/img/main-logo.png" class="img-fluid logo-mobile" alt="logo">

                        </a>
                    </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti ti-align-left"></i>
            </button>
            <!-- end navbar-header -->
            <!-- begin navigation -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navigation d-flex">
                    <ul class="navbar-nav nav-left">
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link sidebar-toggle">
                                <i class="ti ti-align-right"></i>
                            </a>
                        </li>
                    </ul>

                    <ul class="navbar-nav nav-right ml-auto">
                        <li class="nav-item dropdown user-profile">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle " id="navbarDropdown4" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="<?php echo base_url();?>assets/img/profile.jpg" alt="avtar-img">
                                <span class="bg-success user-status"></span>
                            </a>
                            <div class="dropdown-menu animated fadeIn" aria-labelledby="navbarDropdown">
                                <div class="bg-gradient px-4 py-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="mr-1">
                                          <h4 class="text-white mb-0"><?php echo $userData["name"]; ?></h4>
                                          <small class="text-white"><?php echo $userData["email"]; ?></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-4">
                                  <a class="dropdown-item d-flex nav-link" href="ResetPassword.html" data-toggle="modal" data-target="#reset-password">
                                    <i class=" ti ti-lock pr-2 text-info"></i>Reset Password
                                  </a>

                                  <a href="<?php echo base_url(); ?>logout" class="btn btn-danger mt-2" style="width: 100%"> 
                                    <i class="zmdi zmdi-power"></i> Logout
                                  </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- end navigation -->
        </nav>
                <!-- end navbar -->
            </header>
            <!-- end app-header -->
            <!-- begin app-container -->
            <div class="app-container">
                <!-- begin app-nabar -->
                <aside class="app-navbar">
                    <!-- begin sidebar-nav -->
                    <div class="sidebar-nav scrollbar scroll_light">
                        <ul class="metismenu" id="sidebarNav">
                            <li class="<?=($this->uri->segment(1)==='dashboard')?'active':''?>" ><a href="<?php echo base_url()."dashboard" ?>" aria-expanded="false"><i class="fa fa-dashboard"></i><span class="nav-title">Dashboard</span></a> </li>
                        <!--    <li class="menu-item">
                              <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Devices" aria-expanded="false" ><i class="fa fa-tags"></i> <span class="nav-title">User Management</span>
                              </a>
                              <ul id="Devices" class="collapse" aria-labelledby="Devices" data-parent="#side-nav-accordion">
                                <li><a href="<?php echo base_url()."registeredUsers" ?>">Registered Users</a></li>  
                                <li><a href="<?php echo base_url(). "registeredWithDevice" ?>" >Registered with Tagi Device</a></li>
                              </ul>
                            </li>-->
                            <li class="<?=($this->uri->segment(1)==='registeredUsers')?'active':''?>"><a href="<?php echo base_url()."registeredUsers" ?>" aria-expanded="false"><i class="fa fa-cog"></i><span class="nav-title">User Management</span></a> </li>
                            <!--<li class="<?=($this->uri->segment(1)==='productsMngmnt')?'active':''?>"><a href="<?php echo base_url()."productsMngmnt" ?>" aria-expanded="false"><i class="fa fa-cog"></i><span class="nav-title">Products Management</span></a> </li>-->
                            <li class="<?=($this->uri->segment(1)==='tagiPoints')?'active':''?>"><a href="<?php echo base_url()."tagiPoints" ?>" aria-expanded="false"><i class="fa fa-database"></i><span class="nav-title">TagMoi Points</span></a> </li>
                            <!--<li class="<?=($this->uri->segment(1)==='userReward')?'active':''?>"><a href="<?php echo base_url()."userReward" ?>" aria-expanded="false"><i class="fa fa-database"></i><span class="nav-title">User Rewards</span></a> </li>-->
                            <li class="menu-item <?=($this->uri->segment(1)==='nfcTags')?'active':''?>" >
                              <a href="#" class="has-chevron" data-toggle="collapse" data-target="#Devices" aria-expanded="false" ><i class="fa fa-tags"></i> <span class="nav-title">NFC Tags</span>
                              </a>
                              <ul id="Devices" class="collapse" aria-labelledby="Devices" data-parent="#side-nav-accordion">
                                <li><a href="<?php echo base_url()."nfcTags" ?>">NFC Tags</a></li>   
                                <?php
                                 foreach($nfcFolders as $folders)
                                 {
                                 ?>
                                 <li><a href="<?php echo base_url()."tagsCategory/".$folders["name"]; ?>"><?php echo $folders["name"]; ?></a></li>
                                 <?php
                                 }
                                 ?>
                            </ul>
                            </li>                  
                        </ul>
                    </div>
                    <!-- end sidebar-nav -->
                </aside>
                <!-- end app-navbar -->