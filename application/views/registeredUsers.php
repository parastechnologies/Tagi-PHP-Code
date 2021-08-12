
<style>
.dataTables_length
{
    display:none;
}
</style>
 <!-- begin app-main -->
        <div class="app-main" id="main">
            <div class="container-fluid ">
                <div class="row">
                    <div class="col-md-12 m-b-30">
                        <div class="d-block flex-nowrap align-items-center">
                            <div class="page-title ">
                                <h1>
                                    <strong>App Registered Users</strong>
                                </h1>
                            </div>  
                        </div>
                    </div>                    
                </div>
                <!-- Notification -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-statistics category">
                            <div class="card-body">
                                <div class="datatable-wrapper table-responsive">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <form method="POST" action="<?php echo base_url()."dashboard/registeredUsers"; ?>">
                                                <input type="text" name="search" value="" >
                                                <input type="submit" class="submit-btn" name="submit" value="Search" >
                                            </form>
                                        </div>
                                    </div>
                                    <table id="" class="display compact table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                               <!-- <th>Image</th>-->
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <th>Country</th>
                                                <!--<th>UID</th>-->
                                                <th>Created On Date</th>
                                                <th>Number of Tagmoi</th>
                                                <th>Tagmoi Points</th>
                                                <!--<th>People Logs</th>-->
                                                <!--<th>Link</th>-->
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            foreach($users as $user)
                                            {
                                            ?>
                                            <tr>
                                                <?php
                                                /*if(!empty($user["profile_image"]))
                                                {*/
                                                ?>
                                                    <!--<td><img src="<?php echo base_url()."profileImages/".$user["profile_image"]; ?>"></td> -->   
                                                <?php
                                               /* }
                                                else
                                                {*/
                                                ?>
                                                    <!--<td><img src="<?php echo base_url(); ?>profileImages/dummy.png"></td>-->
                                                <?php
                                               /* }*/
                                                ?>
                                                <td><?php echo $user["first_name"]." ".$user["last_name"]; ?></td>                                            
                                                <td><?php echo $user["email"]; ?></td>
                                                <td><?php echo $user["country"] ?></td>
                                                <!--<td>#<?php// echo $user["id"]; ?> </td>-->
                                                <td><?php echo $user["create_date"]; ?></td>
                                                
                                                <td><?php echo $user['numberOfTagi']; ?> </td>
                                                <td><?php 
                                                if(empty($user['tags_points']))
                                                {
                                                    echo "0";
                                                }
                                                else
                                                {
                                                    echo $user['tags_points'];    
                                                }
                                                 ?></td>
                                                <!--<td><?php// echo $user["peopleLogs"]; ?></td>-->
                                                <!--<td><?php// echo $user["profile_url"]; ?></td>-->
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                            <p class="pagination"><?php echo $links; ?></p>
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
<!-- end app-wrap -->

</div>
<script type="text/javascript">
	function getAccountstatus(id) {
     var idd = $('#read' + id).val();
    var dataString="status="+idd +"&user_id="+id;
    $.ajax({
            url: '<?php echo base_url();?>dashboard/updateAccountStatus',
            method:"POST",
            data:dataString,
            success:function(responsedata){
                if(idd == 0)
                 {
                     Swal.fire({
                      icon: 'success',
                      title: 'Profile Active Successfully',
                      showCancelButton: false,
                      timer: 10000
                            }).then((result) => {
                      if (result.value) {
                       window.location.href = "<?php echo base_url(); ?>registeredUsers";
                      }
                    })
                 }
                 else{
                    Swal.fire({
                      icon: 'success',
                      title: 'Profile Block Successfully',
                      showCancelButton: false,
                      timer: 10000
                            }).then((result) => {
                      if (result.value) {
                       window.location.href = "<?php echo base_url(); ?>registeredUsers";
                      }
                    })
                 }
            }
        });
    }
	/*$('#read').on('click', function () {
    $(this).val(this.checked ? 1 : 0);
    
    alert($('#read').val());
    console.log($(this).val());
});*/


</script>