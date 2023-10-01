<?php
include('./includes/header.php') 
?>

            <div class="row">
                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Bank Details</h4>
                        <!-- <p class="card-description"> Basic form layout </p> -->
                        <form class="forms-sample">
                          <div class="form-group">
                            <label for="exampleInputUsername1">Bank Name</label>
                            <input type="text" class="form-control" id="exampleInputUsername1" value ="<?= $userAccountDetails['bank_name'] ? $userAccountDetails['bank_name'] : "None" ?>" disabled>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Account Name</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" value="<?= $userDetalis['fullname'] ? $userDetalis['fullname'] :"" ?>" disabled>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Account Number Number</label>
                            <input type="tel" class="form-control" id="exampleInputPassword1" value="<?= $userAccountDetails['account_number'] ? $userAccountDetails['account_number'] : 0000000000 ?>" disabled>
                          </div>

                         
                          
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Withdrawal Request form</h4>
                        <!-- <p class="card-description"> Horizontal form layout </p> -->
                        <form class="forms-sample" id="withdrawReqForm">
                          
                            <div class="form-group">
                              <label for="exampleInputPassword1">Amount</label>
                              <input type="text" class="form-control" id="exampleInputPassword1" >
                            </div>
                            <div class="form-group">
                              <label for="exampleInputConfirmPassword1">Transfer Pin</label>
                              <input type="password" class="form-control" id="tfPin"  >
                            </div>
                            
                            <button type="submit" class="btn btn-gradient-primary me-2">Request</button>
                            
                          </form>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Update Bank Details</h4>
                        <!-- <p class="card-description"> Horizontal form layout </p> -->
                        <form class="forms-sample">
                            <div class="form-group" id="bankUpdateForm">
                              <label for="exampleInputUsername1">Bank Name</label>
                              <input type="text" class="form-control" id="bank_name" >
                            </div>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Account Name</label>
                              <input type="email" class="form-control" id="account_name" >
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Account Number</label>
                              <input type="tel" class="form-control" id="account_number" >
                            </div>
                            <div class="form-group">
                              <label for="exampleInputConfirmPassword1">Transfer Pin</label>
                              <input type="text" class="form-control" id="tfPin"  >
                            </div>
                            
                            <button type="submit" class="btn btn-gradient-primary me-2">Update</button>
                            
                          </form>
                      </div>
                    </div>
                  </div>
            </div>
          <!-- content-wrapper ends -->
          <!-- partial:./partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
              <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © bootstrapdash.com 2021</span>
              <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin template</a> from Bootstrapdash.com</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="./assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="./assets/js/off-canvas.js"></script>
    <script src="./assets/js/hoverable-collapse.js"></script>
    <script src="./assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
  </body>
</html>