 <!-- begin app-main -->
                <div class="app-main" id="main">
                    <!-- begin container-fluid -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 m-b-30">
                                <div class="d-block d-lg-flex flex-nowrap align-items-center">
                                    <div class="page-title mr-4 pr-4 border-right">
                                        <h1>Dashboard</h1>
                                    </div>
                                    <div class="breadcrumb-bar align-items-center">
                                        <nav>
                                            <ol class="breadcrumb p-0 m-b-0">
                                                <li class="breadcrumb-item">
                                                    <a href="#"><i class="ti ti-home"></i></a>
                                                </li>
                                                <li class="breadcrumb-item">
                                                    Dashboard
                                                </li>
                                            </ol>
                                        </nav>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                        <!-- Notification -->
                        <div class="row mt-5">
                            <div class="col-md-4">
                                <div class="card card-statistics h-100 m-b-0 text-center">
                                    <div class="card-body">
                                        <div class="icon pink"> 
                                          <i class="fa fa-users"></i>
                                        </div>
                                        <h2 class="text-white mb-0"><?php echo $totalRegisteredUsers; ?></h2>
                                        <p>App Registered Users</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-statistics h-100 m-b-0 text-center">
                                    <div class="card-body">
                                        <div class="icon blue"> 
                                          <i class="fa fa-shopping-cart"></i>
                                        </div>
                                        <h2 class="text-white mb-0"><?php echo $purchasedTagUsers; ?></h2>
                                        <p>No. of users who purchased tags</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-statistics h-100 m-b-0 text-center">
                                    <div class="card-body">
                                        <div class="icon orange"> 
                                          <i class="fa fa-list-alt"></i>
                                        </div>
                                        <h2 class="text-white mb-0"><?php echo $notPurchasedTag; ?></h2>
                                        <p>Users installed app but not purchased tag</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 spc-top">
                                <div class="card card-statistics h-100 m-b-0 text-center">
                                    <div class="card-body">
                                        <div class="icon green"> 
                                          <i class="fa fa-check"></i>
                                        </div>
                                        <h2 class="text-white mb-0"><?php echo $totalRegisteredTags; ?></h2>
                                        <p>Total Registered Tags</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 spc-top">
                                <div class="card card-statistics h-100 m-b-0 text-center">
                                    <div class="card-body">
                                        <div class="icon yellow"> 
                                          <i class="fa fa-tags"></i>
                                        </div>
                                        <h2 class="text-white mb-0"><?php echo $TagsAddedByAdmin; ?></h2>
                                        <p> Total number of Tags added by admin</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 spc-top">
                                <div class="card card-statistics h-100 m-b-0 text-center">
                                    <div class="card-body">
                                        <div class="icon skyblue"> 
                                          <i class="fa fa-list-alt"></i>
                                        </div>
                                        <h2 class="text-white mb-0"><?php echo $NotRegisterTags; ?></h2>
                                        <p>No of Tags which are not registered by customers yet</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 spc-top">
                                <div class="card card-statistics h-100 m-b-0 text-center">
                                    <div class="card-body">
                                        <div class="icon grey"> 
                                          <i><img src="assets/img/disable.png"></i>
                                        </div>
                                        <h2 class="text-white mb-0"><?php echo $DisableTags; ?></h2>
                                        <p>No of Disable Tags</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 spc-top">
                                <div class="card card-statistics h-100 m-b-0 text-center">
                                    <div class="card-body">
                                        <div class="icon red"> 
                                          <i class="fa fa-times"></i>
                                        </div>
                                        <h2 class="text-white mb-0">0</h2>
                                        <p>No of Failed Tags</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <!-- end row -->
                        <!-- begin row -->
                      
                           
                        </div>
                        <!-- end row -->
                        <!-- event Modal -->

                    </div>
                    <!-- end container-fluid -->
                </div>
                <!-- end app-main -->
            </div>
            <!-- end app-container -->
            
        </div>
        <!-- end app-wrap -->
    </div>
    <!-- end app -->
