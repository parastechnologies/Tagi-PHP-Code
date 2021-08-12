<?php
/*print_r($data);
die;*/
?>
 
 <!-- begin app-main -->
        <div class="app-main" id="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 m-b-30">
                        <div class="d-block flex-nowrap align-items-center">
                            <div class="page-title ">
                                <h1>
                                    <strong>User Rewards</strong>
                                </h1>
                            </div>  
                        </div>
                    </div>                    
                </div>
                <!-- Notification -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-statistics">
                            <div class="card-body">
                                <div class="datatable-wrapper table-responsive">
                                    <table id="datatable" class="display compact table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <!--<th>Home screen Note</th>-->
                                                <th>Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php 
                                            if($data)
                                            {
                                                foreach($data as $dt)
                                                {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    if(!empty($dt["profile_image"]))
                                                    {
                                                    ?>
                                                        <img src="<?php echo base_url()."profileImages/".$dt["profile_image"]; ?>"> 
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                        <img src="<?php echo base_url(); ?>profileImages/dummy.png">
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $dt["first_name"]." ".$dt["last_name"]; ?></td>  
                                                <td><?php echo $dt["email"]; ?></td>
                                                <!--<td>#<?php// echo $dt["coupon_code"]; ?></td>-->
                                                <td>
                                                  <a href="#" onclick="deleteTag(<?php echo $dt['id']; ?>)" class="btn btn-danger" data-toggle="modal" data-target="#delete">Delete</a>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         <!-- end container-fluid -->
        </div>
     <!-- end app-main -->
    </div>
<!-- end app-container -->

</div>

</div>
<script>
    function deleteTag(id){
        Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to delete this record? This process cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
          
        if (result.value) {
             dataString = "id="+id;
                  $.ajax({ 
                      type: 'post',    
                      url: '<?php echo base_url() ?>dashboard/deleteRewardRecord',
                      data: dataString,
                      cache: false,
                      success: function(res) {
                          if(res == 1){
                              Swal.fire(
                                'Deleted!',
                                'Successfully deleted.',
                                'success'
                              ).then((result) => {
                        if (result.value) {
                            
                            window.location.reload();
                          }
                          })      
                              
                          }
                          else
                          {
                              Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                              })
                          }
                      }
                  }); 
              }   
          })
                  
      }
</script>