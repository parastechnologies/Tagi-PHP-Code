
 <!-- begin app-main -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

 <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/delete_script.js"></script>
        <div class="app-main " id="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 m-b-30">
                        <div class="d-block flex-nowrap align-items-center">
                            <div class="page-title category">
                                <h1>
                                    <strong>All NFC Tags</strong>
                                </h1>
                                <form method="POST" action="<?php echo base_url()."dashboard/nfcTags"; ?>" class="text-right">
                                    <input type="text" name="search" value="" >
                                    <input type="submit" class="submit-btn" name="submit" value="Search" >
                                </form>
                                
                            </div>
                            <div class="invoice-buttons text-left mt-2"> 
                                 <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#upload-excel">Upload Excel sheet</a>
                                 <a href="#" class="btn btn-info" data-toggle="modal" data-target="#add-tag">Add NFC Tag</a>
                                 <a href="#" class="btn btn-info" data-toggle="modal" data-target="#add-new-folder">Add New Folder</a>
                                </div>
                            
                        </div>
                    </div>                    
                </div>
                <?php
            if(!empty($nfcTags))
            {
            ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-statistics category">
                            <div class="card-body">
                                <div class="datatable-wrapper table-responsive">
                                   
                                    <table  class="display compact table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select_all"></th>
                                                <th>No</th>
                                                <th>UID</th>
                                               <th>User</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                                 $i=1;
                                                
                                                foreach($nfcTags as $tags)
                                                {
                                            ?>
                                            <tr id="<?php echo $tags["id"]; ?>">
                                                <td>
                                                     <input type="checkbox" class="emp_checkbox" data-emp-id="<?php echo $tags["id"]; ?>">     
                                                </td>
                                                <td><?php echo $i++; ?> </td>
                                                <td><?php echo $tags["uid"] ?></td>
                                                <td><a href="registeredUsers"><?php echo $tags["email"] ?></a></td>
                                                <td>
                                                    
                                                   <?php
                                                   if(!empty($tags['user_status'] || $tags['user_status'] !== null))
                                                   {
                                                       if($tags['user_status'] == 0)
                                                       {
                                                       ?>
                                                       <span>Disable</span>
                                                       <?php
                                                       }
                                                       else
                                                       {
                                                               if($tags['active_status'] == 1)
                                                               {
                                                                   ?>
                                                                   <span>Active</span>
                                                                    <?php
                                                               }
                                                               else
                                                               {
                                                                    ?>
                                                                   <span>Inactive</span>
                                                                    <?php
                                                               }
                                                       }
                                                   }
                                                   else
                                                   {
                                                       if($tags['active_status'] == 1)
                                                       {
                                                           ?>
                                                           <span>Active</span>
                                                            <?php
                                                       }
                                                       else
                                                       {
                                                            ?>
                                                           <span>Inactive</span>
                                                            <?php
                                                       }
                                                   }
                                                   ?>
                                                </td>
                                                <td>
                                                      <a href="#" onclick="deleteTag(<?php echo $tags['id']; ?>,<?php echo $tags['active_status']; ?>)" class="btn btn-danger" >Delete</a>
                                                </td>
                                            
                                            </tr>
                                            <!-- +++++++++++++++++++++++++++++++++++ ADD CATEGORY MODAL ++++++++++++++++++++++++++++++ -->
                                                <div class="modal fade" id="edit-tag<?php echo $tags['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="edit-tag">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                      <div class="modal-content">
                                            
                                                        <div class="modal-header">
                                                          <h4 class="modal-title has-icon ms-icon-round ">Edit UID</h4>
                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        </div>
                                            
                                                        <div class="modal-body">
                                                          <form method="post"> 
                                                            <div class="ms-form-group has-icon mt-4 mb-4">
                                                              <label>UID</label>
                                                              <input type="number" name="uid" id="uid<?php echo $tags["id"]; ?>" value="<?php echo $tags['uid']; ?>" class="form-control" placeholder="Enter UID">
                                                              <input type="hidden" name="idd" id="idd" value="<?php echo $tags["id"]; ?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                          <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                                          <button type="button" class="btn btn-info shadow-none" id="<?php echo $tags['id']; ?>" onclick="editTag(<?php echo $tags['id']; ?>)">Submit</button>
                                                        </div>
                                            
                                                          </form>
                                                        </div>
                                                        
                                                        
                                                      </div>
                                                    </div>
                                                  </div>
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
                <?php
                }
                ?>
                <!-- Notification -->
                
            </div>
         <!-- end container-fluid -->
        </div>
     <!-- end app-main -->
    </div>
<!-- end app-container -->

</div>
            
<!-- +++++++++++++++++++++++++++++++++++ ADD CATEGORY MODAL ++++++++++++++++++++++++++++++ -->
    <div class="modal fade" id="add-tag" tabindex="-1" role="dialog" aria-labelledby="add-tag">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title has-icon ms-icon-round ">Add New Tag</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
              <form method="post" id="addNewTag">
               
                <div class="ms-form-group has-icon mt-4 mb-4">
                  <label>UID</label>
                  <input type="text" name="uid" class="form-control" placeholder="Enter UID" required >
                </div>
                <div class="ms-form-group has-icon mt-4 mb-4">
                   <select name="category" class="form-control" style="height:50px" required>
                       <option value="">Select Folder</option>
                    <?php
                 foreach($nfcFolders as $folders)
                 {
                 ?>
                 <option value="<?php echo $folders["name"]; ?>"> <?php echo $folders["name"]; ?></option>
                 <?php
                 }
                 ?>
                 </select>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-info shadow-none">Add NFC Tag</button>
            </div>
            </form>
          </div>
        </div>
      </div>
<!-- end app-wrap -->

<!-- +++++++++++++++++++++++++++++++++++ ADD CATEGORY MODAL ++++++++++++++++++++++++++++++ -->
    <div class="modal fade" id="add-new-folder" tabindex="-1" role="dialog" aria-labelledby="add-new-folder">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title has-icon ms-icon-round ">Add New Folder</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body pt-0 pb-0">
              <form method="post" id="addNewFolder">
                <div class="ms-form-group has-icon mt-4 mb-0">
                  <label>Folder Name</label>
                  <input type="text" name="folder_name" class="form-control mb-0" placeholder="Enter Folder Name" required >
                </div>
            </div>
            <div class="modal-footer" style="border:0px">
              <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-info shadow-none">Save</button>
            </div>
            </form>
             <table class="folderlist table-bordered">
                 <?php
                 foreach($nfcFolders as $folders)
                 {
                 ?>
                <tr>
                    <td><?php echo $folders["name"]; ?> </td>
                    <td><a onclick="deleteFolder(<?php echo $folders['id']; ?>)" class="btn btn-danger">Delete </a> </td>
                </tr>  
                <?php
                 }
                ?>
            </table>
          </div>
        </div>
      </div>
<!-- end app-wrap -->


<!-- +++++++++++++++++++++++++++++++++++ ADD CATEGORY MODAL ++++++++++++++++++++++++++++++ -->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">

            <div class="modal-header">              
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body text-center py-0 pb-5">
              <i class="fa fa-times-circle-o" style="font-size:80px;color: #e62323;"></i>
              <h2 class="modal-title has-icon ms-icon-round">Are you sure?</h2>
              <p class="mb-4">Do you really want to delete this record? This process cannot be undone.</p>
               <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-danger shadow-none">Delete</button>
            </div>

            
          </div>
        </div>
      </div>
<!-- end app-wrap -->



<!-- +++++++++++++++++++++++++++++++++++ ADD SHIPPING CHARGES MODAL ++++++++++++++++++++++++++++++ -->
    <div class="modal fade" id="add-shipping" tabindex="-1" role="dialog" aria-labelledby="add-shipping">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title has-icon ms-icon-round ">Add Shipping Charges</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
              <form action="/action_page.php">
                 <div class="ms-form-group has-icon mt-4 mb-4">
                  <label>Amount</label>
                  <input type="text" class="form-control" placeholder="Enter Shipping Amount">
                </div>
              
              </form>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-info shadow-none">Submit</button>
            </div>

          </div>
        </div>
      </div>
</div>

<!-- +++++++++++++++++++++++++++++++++++ Add Excelsheet ++++++++++++++++++++++++++++++ -->
    <div class="modal fade" id="upload-excel" tabindex="-1" role="dialog" aria-labelledby="upload-excel">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title has-icon ms-icon-round ">Upload Excel Sheet</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
              <form id="addExcel" method="post" enctype="multipart/form-data">
                <div class="ms-form-group has-icon mb-4">
                  <label>Choose File</label>
                  <input type="file" id="myFile" name="sheet">  
                </div>
                <div class="ms-form-group has-icon mb-4" >
                    <select name="category" class="form-control" style="height:50px" required>
                       <option value="">Select Folder</option>
                    <?php
                     foreach($nfcFolders as $folders)
                     {
                     ?>
                     <option value="<?php echo $folders["name"]; ?>"> <?php echo $folders["name"]; ?></option>
                     <?php
                     }
                     ?>
                     </select>
                </div>
                <div class="modal-footer">
              <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-info shadow-none">Upload</button>
            </div>
              </form>
               
            </div>
          </div>
        </div>
      </div>

<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
        <script>
 
 $(document).ready(function(e){
           
           $('#addExcel').on('submit', function(e){
            e.preventDefault();
            $.ajax({
              type: 'post',
             url:"<?php echo base_url(); ?>dashboard/uploadExcelSheet",
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
               
             }
            })
           });
           
          });
 
 
    function editTag(id)
    {
        var uid=$("#uid"+id).val();
        var id=id;
        var dataString = 'id='+ id+ '&uid=' + uid 
         $.ajax({
            type: 'post',
            url: '<?php echo base_url() ?>dashboard/editTag',
            data: dataString,
            cache: false,
            success: function (responsedata) {
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
     $(document).ready(function(e){
           
           $('#addNewTag').on('submit', function(e){
            e.preventDefault();
            $.ajax({
              type: 'post',
             url:"<?php echo base_url(); ?>dashboard/addNewTag",
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
                        text: 'UID already exist!',
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
          $(document).ready(function(e){
           
           $('#addNewFolder').on('submit', function(e){
            e.preventDefault();
            $.ajax({
              type: 'post',
             url:"<?php echo base_url(); ?>dashboard/addNewFolder",
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
                        text: 'Folder already exist!',
                      }).then((result) => {
                    if (result.value) {
                     /*window.location.reload();*/
                    }
                  })
               }
               
             }
            })
           });
           
          });
      function deleteTag(id,status){
        Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to delete this tag? This process cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
          
        if (result.value) {
             dataString = "id="+id+"&status="+status;
                  $.ajax({ 
                      type: 'post',    
                      url: '<?php echo base_url() ?>dashboard/deleteTag',
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
      function deleteFolder(id){
        Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to delete this folder? This process cannot be undone.",
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
                      url: '<?php echo base_url() ?>dashboard/deleteFolder',
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

      function test(id,status) {
          //var status = (a.value || a.options[a.selectedIndex].value);  //crossbrowser solution =)
      
          var id=id;
          var status=status;
           dataString = 'status='+ status+'&id='+ id;
           
         $.ajax({ 
                      type: 'post',    
                      url: '<?php echo base_url() ?>dashboard/updateTagStatus',
                      data: dataString,
                      cache: false,
                      success: function(res) {
                          if(res == 2){
                              Swal.fire(
                                'Success',
                                'Tag Active Successfully',
                                'success'
                              ).then((result) => {
                        if (result.value) {
                            
                            window.location.reload();
                          }
                          })      
                              
                          }
                          if(res == 1){
                              Swal.fire(
                                'Success',
                                'Tag Disactive Successfully',
                                'success'
                              ).then((result) => {
                        if (result.value) {
                            
                            window.location.reload();
                          }
                          })   
                          }
                          if(res == 0)
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
      

(function(window, document, $, undefined){
    $(document).ready(function() {
    $('#tag_datatable').DataTable( {
        "pagingType": "full_numbers",
         "order": false,
         "ordering": false,
         "bSort" : false,
        stateSave: true,
        pageLength: 10
    } );
} );
} );
$(document).ready( function () {
    $('#tag_datatable').DataTable({
        "ordering": false,
         "bSort" : false,
        
        });
    
} );
         
  </script>