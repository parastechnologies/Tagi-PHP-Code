<!-- +++++++++++++++++++++++++++++++++++ RESET PASSWORD ++++++++++++++++++++++++++++++ -->
    <div class="modal fade" id="reset-password" tabindex="-1" role="dialog" aria-labelledby="reset-password">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title has-icon ms-icon-round ">Reset Password</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
              <form id="resetAdminPassword"  method="post" enctype="multipart/form-data">
                <div class="ms-form-group has-icon mt-4 mb-4">
                  <label class="control-label">Current Password</label>
                  <input id="password" name="password" type="password" class="form-control" placeholder="Current Password">
                </div>
              
                <div class="ms-form-group has-icon mt-4 mb-4">
                  <label class="control-label">New Password</label>
                  <input id="password" name="new_password" type="password" class="form-control" placeholder="New Password">
                </div>

                <div class="ms-form-group has-icon mt-4 mb-4">
                  <label class="control-label">Confirm Password</label>
                  <input id="password" name="confirm_password" type="password" class="form-control" placeholder="Confirm Password">
                </div>
                    <input type="hidden" name="id" value="1" >
                <div class="modal-footer">
                  <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-info shadow-none">Submit</button>
                </div>
                
              </form>
            </div>

            

          </div>
        </div>
      </div>  
  
  <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
     <script>
    $(document).ready(function (e){

        $('#resetAdminPassword').on('submit', function (e) {
          e.preventDefault();
          $.ajax({
            type: 'post',
            url: '<?php echo base_url();?>dashboard/resetAdminPassword',
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function (responsedata) {
              if(responsedata == 1)
                 {
                     Swal.fire({
                      icon: 'success',
                      title: 'Password updated successfully',
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
                          text: 'Password not updated, Please, do not use your previous password.!',
                        })
                 }
                 if(responsedata == 2){
                    Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Password not updated, Please, do not use your previous password.!',
                        })
                 }
                 if(responsedata == 3){
                    Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Password and confirm password not match.',
                        })
                 }
                 if(responsedata == 4){
                    Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Old password not match.',
                        })
                 }
            }
          });

        });

      });
     
</script>
<script>
$(document).ready(function() {
    $('#datatable2').DataTable( {
        "lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]],
        "pageLength": 100
    } );
} );
</script>
    <!-- plugins -->
    <script src="<?php echo base_url(); ?>assets/js/vendors.js"></script>

    <!-- custom app -->
    <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
</body>

</html>