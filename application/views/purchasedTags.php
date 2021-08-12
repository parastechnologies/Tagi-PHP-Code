 <!-- begin app-main -->
        <div class="app-main" id="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 m-b-30">
                        <div class="d-block flex-nowrap align-items-center">
                            <div class="page-title ">
                                <h1>
                                    <strong>Purchased Tags</strong>
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
                                                <th>Tag Name</th>
                                                <th>Serial Number</th>
                                                <th>User Name</th>
                                                <th>User ID</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>Gradient Tagi</td>
                                                <td>#23254</td>
                                                <td>Honey</td>
                                                <td>honeybuck123@gmail.com</td>  
                                                <td class="status">
                                                  <select>
                                                    <option>Active</option>
                                                    <option>Disactive</option>
                                                  </select>
                                                </td>
                                            </tr>        

                                            <tr>
                                                <td>Gradient Tagi</td>
                                                <td>#23254</td>
                                                <td>Honey</td>
                                                <td>honeybuck123@gmail.com</td>  
                                                <td class="status">
                                                  <select>
                                                    <option>Active</option>
                                                    <option>Disactive</option>
                                                  </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Gradient Tagi</td>
                                                <td>#23254</td>
                                                <td>Honey</td>
                                                <td>honeybuck123@gmail.com</td>  
                                                <td class="status">
                                                  <select>
                                                    <option>Active</option>
                                                    <option>Disactive</option>
                                                  </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Gradient Tagi</td>
                                                <td>#23254</td>
                                                <td>Honey</td>
                                                <td>honeybuck123@gmail.com</td>  
                                                <td class="status">
                                                  <select>
                                                    <option>Active</option>
                                                    <option>Disactive</option>
                                                  </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Gradient Tagi</td>
                                                <td>#23254</td>
                                                <td>Honey</td>
                                                <td>honeybuck123@gmail.com</td>  
                                                <td class="status">
                                                  <select>
                                                    <option>Active</option>
                                                    <option>Disactive</option>
                                                  </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Gradient Tagi</td>
                                                <td>#23254</td>
                                                <td>Honey</td>
                                                <td>honeybuck123@gmail.com</td>  
                                                <td class="status">
                                                  <select>
                                                    <option>Active</option>
                                                    <option>Disactive</option>
                                                  </select>
                                                </td>
                                            </tr>
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
    <div class="modal fade" id="add-tag" tabindex="-1" role="dialog" aria-labelledby="add-tag">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title has-icon ms-icon-round ">Add New Tag</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
              <form action="/action_page.php">
                <div class="ms-form-group has-icon mt-4 mb-4">
                  <label>Tag Name</label>
                  <input type="text" class="form-control" placeholder="Enter Tag Name">
                </div>
              
                <div class="ms-form-group has-icon mt-4 mb-4">
                  <label>Serial ID</label>
                  <input type="number" class="form-control" placeholder="Enter ID">
                </div>
                
              </form>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-info shadow-none">Assign NFC Tag</button>
            </div>

          </div>
        </div>
      </div>
<!-- end app-wrap -->

<!-- +++++++++++++++++++++++++++++++++++ ADD CATEGORY MODAL ++++++++++++++++++++++++++++++ -->
    <div class="modal fade" id="edit-tag" tabindex="-1" role="dialog" aria-labelledby="edit-tag">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title has-icon ms-icon-round ">Edit Tag</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
              <form action="/action_page.php">
                <div class="ms-form-group has-icon mt-4 mb-4">
                  <label>Tag Name</label>
                  <input type="text" class="form-control" placeholder="Enter Tag Name">
                </div>
              
                <div class="ms-form-group has-icon mt-4 mb-4">
                  <label>Serial ID</label>
                  <input type="number" class="form-control" placeholder="Enter ID">
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
