
 <!-- begin app-main -->
        <div class="app-main" id="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 m-b-30">
                        <div class="d-block flex-nowrap align-items-center">
                            <div class="page-title ">
                                <h1>
                                    <strong>Tagi Points</strong>
                                </h1>

                                <div class="invoice-buttons text-right">
                                 <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-gift">Add Gift</a>
                                </div>
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
                                                <th>Range</th>
                                                <th>Next Gift Card</th>
                                                <th>Push Notification</th>
                                                <th>Home Screen English Note</th>
                                                <th>Home Screen Arabic Note</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($tagiData as $tdata)
                                            {
                                            ?>
                                            <tr id="<?php echo $tdata["id"]; ?>">
                                                <td><?php echo $tdata["point_range_from"]." - ".$tdata["point_range_to"] ; ?></td>
                                                <td><?php echo $tdata["next_gift_card"]; ?></td> 
                                                <td><?php echo $tdata["push_notification"]; ?></td> 
                                                <td><?php echo $tdata["home_note"]; ?></td> 
                                                <td><?php echo $tdata["arabic_note"]; ?></td> 
                                                <td>
                                                  <a class="edit btn btn-info" data-toggle="modal" data-target="#edit_tagi_point<?php echo $tdata['id']; ?>"><i class="fa fa-pencil fs-16"></i>&nbsp Edit</a>
                                                  <a href="#" onclick="deleteTag(<?php echo $tdata['id']; ?>)" class="btn btn-danger" >Delete</a>
                                                </td>
                                            </tr>
                                            <!-- +++++++++++++++++++++++++++++++++++ Edit CATEGORY MODAL ++++++++++++++++++++++++++++++ -->
                                              <div class="modal fade" id="edit_tagi_point<?php echo $tdata['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="edit_tagi_point">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                  <div class="modal-content">
                                            
                                                    <div class="modal-header">
                                                      <h4 class="modal-title has-icon ms-icon-round ">Edit Gift</h4>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                            
                                                    <div class="modal-body">
                                                      <form method="post" enctype="multipart/form-data">
                                                        
                                                        <div class="ms-form-group has-icon mt-4 mb-4">
                                                          <label>Choose Range</label>
                                                          <div class="row">
                                                                <div class="col-md-6">
                                                                  <input type="text" class="form-control" name="rangeFrom" id="rangeFrom<?php echo $tdata['id']; ?>" placeholder="From" value="<?php echo $tdata["point_range_from"]; ?>" required> 
                                                                </div>
                                                                <div class="col-md-6">
                                                                  <input type="text" class="form-control" name="rangeTo" id="rangeTo<?php echo $tdata['id']; ?>" placeholder="To" value="<?php echo $tdata["point_range_to"]; ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" class="form-control" name="id" id="id<?php echo $tdata['id']; ?>" value="<?php echo $tdata["id"]; ?>">
                                                        <div class="ms-form-group has-icon mt-4 mb-4">
                                                          <label>Next Gift Card</label>
                                                          <input type="text" class="form-control" name="next_gift_card" id="next_gift_card<?php echo $tdata['id']; ?>"  placeholder="Next Gift Card Text" value="<?php echo $tdata["next_gift_card"]; ?>" required>
                                                        </div>
                                                        
                                                        <div class="ms-form-group has-icon mt-4 mb-4">
                                                          <label>Push Notification</label>
                                                          <textarea type="text" class="form-control" name="notification_text" id="notification_text<?php echo $tdata['id']; ?>"  placeholder="Push Notification Text" required ><?php echo $tdata["push_notification"]; ?></textarea>
                                                        </div>
                                                        
                                                        <div class="ms-form-group has-icon mt-4 mb-4">
                                                          <label>Home Screen English Note</label>
                                                          <textarea type="text" class="form-control" name="home_screen_english_note" id="home_screen_english_note<?php echo $tdata['id']; ?>"  placeholder="Home Screen English Note" required ><?php echo $tdata["home_note"]; ?></textarea>
                                                        </div>
                                                        
                                                        <div class="ms-form-group has-icon mt-4 mb-4">
                                                          <label>Home Screen Arabic Note</label>
                                                          <textarea type="text" class="form-control" name="home_screen_arabic_note" id="home_screen_arabic_note<?php echo $tdata['id']; ?>"  placeholder="Home Screen Arabic Note" required ><?php echo $tdata["arabic_note"]; ?></textarea>
                                                        </div>
                                                        
                                                        <div class="modal-footer">
                                                          <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                                          <button type="button" class="btn btn-info shadow-none" id="<?php echo $tdata['id']; ?>" onclick="editTagiPoints(<?php echo $tdata['id']; ?>)" >Add Gift</button>
                                                        </div>
                                                    
                                                      </form>
                                                    </div>
                                            
                                                  </div>
                                                </div>
                                            </div>
                                            <!-- end app-wrap -->
                                            
                                            <?php
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


<!-- +++++++++++++++++++++++++++++++++++ ADD CATEGORY MODAL ++++++++++++++++++++++++++++++ -->
  <div class="modal fade" id="add-gift" tabindex="-1" role="dialog" aria-labelledby="add-gift">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title has-icon ms-icon-round ">Add Gift</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
          <form id="addTagiPoints" method="post" enctype="multipart/form-data">
            <div class="ms-form-group has-icon mt-4 mb-4">
                <label>Choose Range</label>
                <div class="row">
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="rangeFrom" placeholder="From" required> 
                    </div>
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="rangeTo" placeholder="To" required>
                    </div>
                </div>
            </div>
          
            <div class="ms-form-group has-icon mt-4 mb-4">
              <label>Next Gift Card</label>
              <input type="text" class="form-control" name="next_gift_card" placeholder="Next Gift Card" required> 
            </div>
            
            <div class="ms-form-group has-icon mt-4 mb-4">
              <label>Push Notification</label>
              <textarea type="text" class="form-control" name="push_notification_text" placeholder="Push Notification Text" required ></textarea>
            </div>
            
            <div class="ms-form-group has-icon mt-4 mb-4">
              <label>Home Screen English Note</label>
              <textarea type="text" class="form-control" name="home_screen_english_note" placeholder="Home Screen English Note" required ></textarea>
            </div>
            
            <div class="ms-form-group has-icon mt-4 mb-4">
              <label>Home Screen Arabic Note</label>
              <textarea type="text" class="form-control" name="home_screen_arabic_note" placeholder="Home Screen Arabic Note" required ></textarea>
            </div>
            
            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-info shadow-none">Add Gift</button>
            </div>
        
          </form>
        </div>

      </div>
    </div>
</div>
<!-- end app-wrap -->


</div>

<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
      <script>
        $(document).ready(function(e){
         
         $('#addTagiPoints').on('submit', function(e){
          e.preventDefault();
          $.ajax({
            type: 'post',
           url:"<?php echo base_url(); ?>dashboard/addTagiPoints",
           data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
           success:function(responsedata){
            if(responsedata == 1)
            {
                Swal.fire({
                icon: 'success',
                title: 'Added Successfully',
                showCancelButton: false,
                timer: 10000
            }).then((result) => {
                  if (result.value) {
                   window.location.reload();
                  }
                })
             }
             if(responsedata == 0){
                Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Something went wrong!',
                    }).then((result) => {
                  if (result.value) {
                   window.location.reload();
                  }
                })
             }
             if(responsedata == 2){
                Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Coupon code already exist!',
                    }).then((result) => {
                  if (result.value) {
                   window.location.reload();
                  }
                })
             }
             
           }
          })
         });
         
        });
        
        /*$(document).ready(function (e){

        $('#editTagiPoints').on('submit', function (e) {
          e.preventDefault();
          var id = $(".idd").val();
          alert(id);
          $.ajax({
            type: 'post',
            url: '<?php echo base_url();?>dashboard/editTagiPoints',
            data: $('form').serialize(),
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function (responsedata) {
                alert(responsedata);
              if(responsedata == 1)
                 {
                     Swal.fire({
                      icon: 'success',
                      title: 'Update Successfully',
                      showCancelButton: false,
                     timer: 10000
                            }).then((result) => {
                      if (result.value) {
                       window.location.reload();
                      }
                    })
                 }
                 if(responsedata == 2){
                Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Coupon code already exist!',
                    }).then((result) => {
                  if (result.value) {
                   window.location.reload();
                  }
                })
             }
                if(responsedata == 0){
                    Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong!',
                        }).then((result) => {
                      if (result.value) {
                       window.location.reload();
                      }
                    })
                 }
            }
          });

        });
      });*/
      
    function editTagiPoints(id)
    {
       /* var id=$("#id"+id).val();
        var image=$("#tagi_points_image"+id).val();
        var range=("#range"+id).val();
        var coupon_code=("#coupon_code"+id).val();*/
        var formData = new FormData();
        formData.append("id", $("#id"+id).val());
        formData.append("rangeFrom", $("#rangeFrom"+id).val());
        formData.append("rangeTo", $("#rangeTo"+id).val());
        formData.append("next_gift_card", $("#next_gift_card"+id).val());
        formData.append("notification_text", $("#notification_text"+id).val());
        formData.append("home_screen_english_note", $("#home_screen_english_note"+id).val());
        formData.append("home_screen_arabic_note", $("#home_screen_arabic_note"+id).val());
       // var dataString = 'id='+ id+ '&old_image=' + old_image+ '&range=' + range+'&coupon_code=' + coupon_code;
        
         $.ajax({
            type: 'post',
            url: '<?php echo base_url() ?>dashboard/editTagiPoints',
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
            success: function (responsedata) {
              console.log(responsedata);
              if(responsedata == 1)
                 {
                     Swal.fire({
                      icon: 'success',
                      title: 'Updated Successfully',
                      showCancelButton: false,
                      timer: 10000
                            }).then((result) => {
                      if (result.value) {
                       window.location.reload();
                      }
                    })
                 }
                 if(responsedata == 0){
                    Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong!',
                          timer: 10000
                        }).then((result) => {
                      if (result.value) {
                       window.location.reload();
                      }
                    })
                 }
                 if(responsedata == 2){
                    Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'UID already exist!',
                          timer: 10000
                        }).then((result) => {
                      if (result.value) {
                       window.location.reload();
                      }
                    })
                 }
            }
          });
    }
        
        function deleteTag(id){
        Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to delete this gift card? This process cannot be undone.",
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
                      url: '<?php echo base_url() ?>dashboard/deleteTagPoint',
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
