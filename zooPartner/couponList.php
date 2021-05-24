<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Coupon List</h4>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Coupon List</li>
         </ol>
      </div>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right">
           <a href="couponReport"  class="btn  btn-sm btn-secondary pull-right">Report</a>
          <a href="coupon"  class="btn  btn-sm btn-primary pull-right"><i class="fa fa-plus fa-lg"></i> Add New </a>
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
          <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
        <li class="nav-item">
          <a href="javascript:void();" data-target="#CouponList" data-toggle="pill" class="nav-link active"><span class="hidden-xs">Coupon List </span></a>
        </li>
        <li class="nav-item">
          <a href="javascript:void();" data-target="#promotionOnly" data-toggle="pill" class="nav-link "><span class="hidden-xs">Promotion Only Coupon</span></a>
        </li>
      </ul>
       <div class="tab-content p-3">
         <div class="tab-pane active " id="CouponList">
          <div class="table-responsive">
            <table id="example" class="table table-bordered">
              <thead>
                <tr>
                  
                  <th class="text-right">#</th>
                  
                  <th>Coupon Name</th>
                  <th>Coupon Code</th>
                  <th>Membership Plan</th>
                  <th>Coupon Expiry</th>
                   <th>Start Date</th>
                    <th>End Date</th>
                  <th>Is Unlimited?</th>
                  <th>Use limit</th>
                  <th>Created By</th>
                  <th>Created at</th>
                  <th>Action</th>
                  
                </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
                $q=$d->select("coupon_master,zoobiz_admin_master,package_master","  package_master.package_id =coupon_master.plan_id and    coupon_master.created_by =zoobiz_admin_master.zoobiz_admin_id and package_master.is_cpn_package=0 and    coupon_master.coupon_status=0  order by coupon_master.coupon_name
                  asc ");
                while ($data=mysqli_fetch_array($q)) {
                  extract($data);
                  ?>
                  <tr>
                    
                    <td class="text-right"><?php echo $i++; ?></td>
                    <td><?php echo  $coupon_name; ?></td>
                    <td><?php echo  $coupon_code; ?></td>
                    <td><?php echo  $package_name; ?></td>
                    <td><?php if($cpn_expiry==1) {echo 'Yes';} else echo "No"; ?></td>
                    <td  <?php if($cpn_expiry==1 && $start_date!="0000-00-00" ) { ?> data-order="<?php echo date("U",strtotime($start_date)); ?>" <?php } ?> ><?php if($cpn_expiry==1 && $start_date!="0000-00-00" ) {echo date("d-m-Y", strtotime($start_date));} else echo "-"; ?></td>
                    <td  <?php if($cpn_expiry==1 && $end_date!="0000-00-00" ) { ?> data-order="<?php echo date("U",strtotime($end_date)); ?>" <?php } ?>     ><?php if($cpn_expiry==1 && $end_date!="0000-00-00") {echo date("d-m-Y", strtotime($end_date));} else echo "-"; ?></td>

                    <td><?php if($is_unlimited==1) {echo 'Yes';} else echo "No"; ?></td>
                    <td><?php if($is_unlimited==1) {echo 'Unlimited';} else echo $coupon_limit; ?></td>
                    <td><?php echo $admin_name; ?></td>
                    <td data-order="<?php echo date("U",strtotime($created_at)); ?>"><?php echo date("d-m-Y h:i:s A", strtotime($created_at)); ?></td>
                    <td>

                       <?php $transection_master=$d->select("transection_master","  coupon_id= '$coupon_id' ","");
                       if (mysqli_num_rows($transection_master) <= 0 ) {
                       ?>
                      <div style="display: inline-block;">
                        <form action="coupon" method="post">
                          <input type="hidden" name="coupon_id" value="<?php echo $coupon_id; ?>">
                          <button type="submit" name="" class="btn btn-primary btn-sm "> Edit</button>
                        </form>
                      </div>
                      
                     
 
                     <?php } else {
                      ?>
                       <div style="display: inline-block;">
                        <form action="coupon" method="post">
                          <input type="hidden" name="coupon_id" value="<?php echo $coupon_id; ?>">
                           <input type="hidden" name="onlyView" value="onlyView">
                          <button type="submit" name="" class="btn btn-secondary btn-sm "> View</button>
                        </form>
                      </div>
                      <?php 
                     }
                      if (mysqli_num_rows($transection_master) <= 0 ) { ?>
                        <div style="display: inline-block;">
                        <form  action="controller/couponController.php" method="post">
                          <input type="hidden" name="delete_coupon_id" value="<?php echo $coupon_id; ?>">
                          <button type="submit" name="deleteCmp" class="form-btn btn btn-danger btn-sm "> Delete</button>
                        </form>
                      </div>
                      <?php } 
                      //24nov2020
                      else { ?>
                        <button type="button"  disabled="" class="form-btn btn btn-danger btn-sm " style="cursor: not-allowed;"> Delete</button>
                       <?php } ?>
                      
                    </td>
                    
                    
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          </div>

<div class="tab-pane  " id="promotionOnly">
  <div class="table-responsive">
            <table id="example2" class="table table-bordered">
              <thead>
                <tr>
                  
                  <th class="text-right">#</th>
                  
                  <th>Coupon Name</th>
                  <th>Coupon Code</th>
                  <th>Membership Plan</th>
                  <th>Coupon Expiry</th>
                   <th>Start Date</th>
                    <th>End Date</th>
                  <th>Is Unlimited?</th>
                  <th>Use limit</th>
                  <th>Created By</th>
                  <th>Created at</th>
                  <th>Action</th>
                  
                </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
                $q=$d->select("coupon_master,zoobiz_admin_master,package_master","  package_master.package_id =coupon_master.plan_id and    coupon_master.created_by =zoobiz_admin_master.zoobiz_admin_id and package_master.is_cpn_package=1 and    coupon_master.coupon_status=0  order by coupon_master.coupon_name
                  asc ");
                while ($data=mysqli_fetch_array($q)) {
                  extract($data);
                  ?>
                  <tr>
                    
                    <td class="text-right"><?php echo $i++; ?></td>
                    <td><?php echo  $coupon_name; ?></td>
                    <td><?php echo  $coupon_code; ?></td>
                    <td><?php echo  $package_name; ?></td>
                    <td><?php if($cpn_expiry==1) {echo 'Yes';} else echo "No"; ?></td>
                    <td  <?php if($cpn_expiry==1 && $start_date!="0000-00-00" ) { ?> data-order="<?php echo date("U",strtotime($start_date)); ?>" <?php } ?> ><?php if($cpn_expiry==1 && $start_date!="0000-00-00" ) {echo date("d-m-Y", strtotime($start_date));} else echo "-"; ?></td>
                    <td  <?php if($cpn_expiry==1 && $end_date!="0000-00-00" ) { ?> data-order="<?php echo date("U",strtotime($end_date)); ?>" <?php } ?>     ><?php if($cpn_expiry==1 && $end_date!="0000-00-00") {echo date("d-m-Y", strtotime($end_date));} else echo "-"; ?></td>

                    <td><?php if($is_unlimited==1) {echo 'Yes';} else echo "No"; ?></td>
                    <td><?php if($is_unlimited==1) {echo 'Unlimited';} else echo $coupon_limit; ?></td>
                    <td><?php echo $admin_name; ?></td>
                    <td data-order="<?php echo date("U",strtotime($created_at)); ?>"><?php echo date("d-m-Y h:i:s A", strtotime($created_at)); ?></td>
                    <td>

                       <?php $transection_master=$d->select("transection_master","  coupon_id= '$coupon_id' ","");
                       if (mysqli_num_rows($transection_master) <= 0 ) {
                       ?>
                      <div style="display: inline-block;">
                        <form action="coupon" method="post">
                          <input type="hidden" name="coupon_id" value="<?php echo $coupon_id; ?>">
                          <button type="submit" name="" class="btn btn-primary btn-sm "> Edit</button>
                        </form>
                      </div>
                      
                     
 
                     <?php } else {
                      ?>
                       <div style="display: inline-block;">
                        <form action="coupon" method="post">
                          <input type="hidden" name="coupon_id" value="<?php echo $coupon_id; ?>">
                           <input type="hidden" name="onlyView" value="onlyView">
                          <button type="submit" name="" class="btn btn-secondary btn-sm "> View</button>
                        </form>
                      </div>
                      <?php 
                     }
                      if (mysqli_num_rows($transection_master) <= 0 ) { ?>
                        <div style="display: inline-block;">
                        <form  action="controller/couponController.php" method="post">
                          <input type="hidden" name="delete_coupon_id" value="<?php echo $coupon_id; ?>">
                          <button type="submit" name="deleteCmp" class="form-btn btn btn-danger btn-sm "> Delete</button>
                        </form>
                      </div>
                      <?php } 
                      //24nov2020
                      else { ?>
                        <button type="button"  disabled="" class="form-btn btn btn-danger btn-sm " style="cursor: not-allowed;"> Delete</button>
                       <?php } ?>
                      
                    </td>
                    
                    
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
</div>

        </div>
      </div>
    </div>
  </div><!-- End Row-->
</div>
<!-- End container-fluid-->
</div><!--End content-wrapper-->
    <!--Start Back To Top Button-->