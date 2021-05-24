<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Currency List</h4>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Currency List</li>
         </ol>
      </div>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right">
          <a href="currency"  class="btn  btn-sm btn-primary pull-right"><i class="fa fa-plus fa-lg"></i> Add New </a>
        </button>
      </div>
    </div>
  </div>
  <!-- End Breadcrumb-->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <!-- <div class="card-header"><i class="fa fa-table"></i> Data Exporting</div> -->
        <div class="card-body">
          <div class="table-responsive">
            <table id="exampleList" class="table table-bordered">
              <thead>
                <tr>
                  
                  <th>#</th>
                  
                  <th>currency Name</th>
                  <th>currency Code</th>
                  <th>currency Symbol</th>
                  
                  <th>Action</th>
                  
                </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
                $q=$d->select("currency_master"," status=0 ");
                while ($data=mysqli_fetch_array($q)) {
                  extract($data);
                  ?>
                  <tr>
                    
                    <td><?php echo $i++; ?></td>
                    <td><?php echo  $currency_name; ?></td>
                    <td><?php echo $currency_code ; ?></td>
                    <td><?php echo $currency_symbol; ?></td>
                    
                    <td>
                      <div style="display: inline-block;">
                        <form action="currency" method="post" >
                          <input type="hidden" name="currency_id" value="<?php echo $currency_id; ?>">
                          <button type="submit" name="" class="btn btn-primary btn-sm "> Edit</button>
                        </form>
                      </div>
                      
                      <?php $payment_getway_master=$d->select("payment_getway_master","  currency_id= '$currency_id' ","");
                      if (mysqli_num_rows($payment_getway_master) <= 0 ) { ?>
                        <div style="display: inline-block;">
                        <form  action="controller/currencyController.php" method="post">
                          <input type="hidden" name="currency_id" value="<?php echo $currency_id; ?>">
                          <button type="submit" name="deleteCurr" class="btn btn-danger btn-sm "> Delete</button>
                        </form>
                      </div>
                      <?php }  ?>
                    </td>
                    
                    
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div><!-- End Row-->
</div>
<!-- End container-fluid-->
</div><!--End content-wrapper-->
    <!--Start Back To Top Button-->