
<!-- begin app-main -->
        <div class="app-main" id="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 m-b-30">
                        <div class="d-block flex-nowrap align-items-center">
                            <div class="page-title ">
                                <h1>
                                    <strong>Product Management</strong>
                                </h1>

                                <div class="invoice-buttons text-right"> 
                                 <a href="#" class="btn btn-info" data-toggle="modal" data-target="#add-product">Add New Product</a>
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
                                                <th>UID</th>
                                                <th>Product Image</th>
                                                <th>Product Name</th>
                                                <th>Product Link</th>
                                                <th>Price</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            foreach($products as $product)
                                            {
                                            ?>
                                            <tr>
                                                <td>#<?php echo $product["uid"]; ?></td>
                                                <td><img src="<?php echo base_url()."productsImages/".$product["product_image"]; ?>"></td>
                                                <td><?php echo $product["name"]; ?></td>
                                                <td><?php echo $product["link"]; ?></td>
                                                <td><?php echo $product["price"]; ?></td>  
                                                <td>
                                                  <a class="edit btn btn-info" data-toggle="modal" data-target="#edit-product<?php echo $product['id']; ?>"><i class="fa fa-pencil fs-16"></i>&nbsp Edit</a>
                                                  <a href="#" onclick="deleteProduct(<?php echo $product['id']; ?>)" class="btn btn-danger" >Delete</a>
                                                </td>
                                            </tr>
                                            <!-- +++++++++++++++++++++++++++++++++++ Edit PRODUCT MODAL ++++++++++++++++++++++++++++++ -->
                                            <div class="modal fade" id="edit-product<?php echo $product['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="edit-product">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                  <div class="modal-content">
                                        
                                                    <div class="modal-header">
                                                      <h4 class="modal-title has-icon ms-icon-round ">Edit Product</h4>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                        
                                                    <div class="modal-body">
                                                      <form  method="post" enctype="multipart/form-data">
                                                        <div class="ms-form-group">
                                                        <label for="img">Choose Image: </label>&nbsp
                                                        <input type="file" id="product_img<?php echo $product["id"]; ?>" name="product_img" accept="image/*" >   
                                                        <input type="hidden"  name="old_product_img" id="old_product_img<?php echo $product["id"]; ?>" value="<?php echo $product["product_image"]; ?>" >
                                                        <input type="hidden" id="id<?php echo $product["id"]; ?>" name="id"  value="<?php echo $product["id"]; ?>" >
                                                        </div>
                                                         <div class="ms-form-group has-icon mt-4 mb-4">
                                                          <label>Product Name</label>
                                                          <input type="text" class="form-control" name="name" id="name<?php echo $product["id"]; ?>" value="<?php echo $product["name"]; ?>" placeholder="Enter Product Name" required>
                                                        </div>
                                                      
                                                        <div class="ms-form-group has-icon mt-4 mb-4">
                                                          <label>Product Price</label>
                                                          <input type="text" class="form-control" name="price" id="price<?php echo $product["id"]; ?>" value="<?php echo $product["price"]; ?>" placeholder="Enter Price" required>
                                                        </div>
                                        
                                                        <div class="ms-form-group has-icon mt-4 mb-4">
                                                          <label>Product Link</label>
                                                          <input type="url" class="form-control" name="product_link" id="product_link<?php echo $product["id"]; ?>" value="<?php echo $product["link"] ?>" placeholder="Enter Product Link" required>
                                                        </div>
                                                        
                                                        <div class="ms-form-group has-icon mt-4 mb-4">
                                                          <label>UID</label>
                                                          <input type="text" class="form-control" name="uid" id="uid<?php echo $product["id"]; ?>" value="<?php echo $product["uid"]; ?>" placeholder="Enter UID" required>
                                                        </div>
                                                        
                                                        <div class="modal-footer">
                                                          <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                                          <button type="button" id="<?php echo $product['id']; ?>" onclick="editProduct(<?php echo $product['id']; ?>)" class="btn btn-info shadow-none" >Submit</button>
                                                         
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
            </div>
         <!-- end container-fluid -->
        </div>
     <!-- end app-main -->
    </div>
<!-- end app-container -->

</div>


<!-- +++++++++++++++++++++++++++++++++++ ADD CATEGORY MODAL ++++++++++++++++++++++++++++++ -->
    <div class="modal fade" id="add-product" tabindex="-1" role="dialog" aria-labelledby="add-product">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title has-icon ms-icon-round ">Add New Product</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
              <form id="addProducts" method="post" enctype="multipart/form-data">
                <div class="ms-form-group">
                <label for="img">Choose Image: </label>&nbsp
                <input type="file" id="img" name="product_img" accept="image/*" required>             
                </div>

                <div class="ms-form-group has-icon mt-4 mb-4">
                  <label>Product Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Enter Product Name" required>
                </div>
              
                <div class="ms-form-group has-icon mt-4 mb-4">
                  <label>Product Price</label>
                  <input type="text" class="form-control" name="price" placeholder="Enter Price" required>
                </div>

                <div class="ms-form-group has-icon mt-4 mb-4">
                  <label>Product Link</label>
                  <input type="url" class="form-control" name="product_link" placeholder="Enter Product Link" required>
                </div>
                
                <div class="ms-form-group has-icon mt-4 mb-4">
                  <label>UID</label>
                  <input type="text" class="form-control" name="uid"  placeholder="Enter UID" required>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                  <button type="submit"  class="btn btn-info shadow-none">Post</button>
                </div>
              </form>
            </div>

            

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

</div>

<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
      <script>
        $(document).ready(function(e){
         
         $('#addProducts').on('submit', function(e){
          e.preventDefault();
          $.ajax({
            type: 'post',
           url:"<?php echo base_url(); ?>dashboard/addProducts",
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
        
    function deleteProduct(id){
    
      Swal.fire({
      title: 'Are you sure?',
      text: "Do you really want to delete this product? This process cannot be undone.",
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
                    url: '<?php echo base_url() ?>dashboard/deleteProduct',
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
    function editProduct(id)
    {
        var product_img=$("#product_img"+id)[0].files[0];
       
        var formData = new FormData();
        formData.append("id", $("#id"+id).val());
        formData.append("name", $("#name"+id).val());
        formData.append("price", $("#price"+id).val());
        formData.append("product_link", $("#product_link"+id).val());
        formData.append("uid", $("#uid"+id).val());
        formData.append("old_product_img", $("#old_product_img"+id).val());
        formData.append("product_img", product_img);
       // var dataString = 'id='+ id+ '&old_image=' + old_image+ '&range=' + range+'&coupon_code=' + coupon_code;
        
         $.ajax({
            type: 'post',
            url: '<?php echo base_url() ?>dashboard/editProduct',
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
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
</script>
