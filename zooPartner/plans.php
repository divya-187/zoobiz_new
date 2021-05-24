  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
        <h4 class="page-title">Member Plans</h4>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Member Plans</li>
         </ol>
     </div>
     <div class="col-sm-3">
       <div class="btn-group float-sm-right">
        <a href="plan" class="btn btn-primary waves-effect waves-light btn-sm"><i class="fa fa-plus mr-1"></i> Add New</a>
         <a href="javascript:void(0)" onclick="DeleteAll('deletePackage');" class="btn btn-danger waves-effect waves-light btn-sm"><i class="fa fa-trash-o fa-lg"></i> Delete </a>
       
        
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
          <a href="javascript:void();" data-target="#CouponList" data-toggle="pill" class="nav-link active"><span class="hidden-xs">Plan List </span></a>
        </li>
        <li class="nav-item">
          <a href="javascript:void();" data-target="#promotionOnly" data-toggle="pill" class="nav-link "><span class="hidden-xs">Promotion Only Plan</span></a>
        </li>
      </ul>
      <div class="tab-content p-3">
         <div class="tab-pane active " id="CouponList">
              <div class="table-responsive">
              <table id="exampleList" class="table table-bordered">
                <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th class="text-right">#</th>
                      <th>Package Name</th>
                      <th>Only Coupon<br>Package</th>
                      <th>Description</th>
                      <th>IAP Apple ID</th>
                      <th class="text-right">Amount Without GST</th>
                      <th>GST Slab</th>
                      <th>Duration</th>
                      <th>Asign Member</th>
                      <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                  <?php 
                  $i=1;
                  $q=$d->select("package_master","is_cpn_package=0","");
                  while($row=mysqli_fetch_array($q))
                  {
                    extract($row);
                     $totalAsignPckg= $d->count_data_direct("plan_id","users_master","plan_id='$row[package_id]'");

                     if($gst_slab_id !="0"){
                       $gst_master=$d->select("gst_master","slab_id = '$gst_slab_id'","");
                      $gst_master_data=mysqli_fetch_array($gst_master);
                      $gst = $gst_master_data['slab_percentage'].' %';
                     } else {
                      $gst ="None";
                     }
                      
                  ?>
                    <tr>
                       <td class='text-center'>
                        <?php if ($totalAsignPckg==0) {
                         ?>
                        <input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $row['package_id']; ?>">
                        <?php } else { ?> 
                          <input title="Used Plans" type="checkbox"  disabled="">
                        <?php } ?>
                    </td>
                        <td class="text-right"><?php echo $i++; ?></td>
                        <td><?php echo $package_name; ?></td>
                        <td><?php if($is_cpn_package == 0){ echo "No";} else echo 'Yes'; ?></td>
                        <td><?php echo $packaage_description; ?></td>
                        <td><?php echo $inapp_ios_purchase_id; ?></td>
                        <td class="text-right"><?php echo $package_amount; ?></td>
                        <td><?php echo $gst; ?></td>
                        <td><?php echo $no_of_month; ?> <?php if($time_slab == 1) echo "Days"; else echo "Month"; ?></td>
                        <td class="text-right"><?php echo $totalAsignPckg; ?> </td>
                        <td>
                        <form style="display: inline-block;" action="plan" method="post">
                            <input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
                            <input type="submit" class="btn btn-sm btn-primary" name="updatepackage" value="Edit">
                          </form>


                          <?php if ($totalAsignPckg==0) {
                         ?>

                          <form style="display: inline-block;" action="controller/packageController.php" method="post">
                            <input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
                             <input type="hidden" name="deletepackage" value="deletepackage">
                            <input type="submit" class="btn btn-sm btn-danger form-btn" name="deletepackage" value="Delete">
                          </form>

                         
                        <?php }
                        //24nov2020
                        else { ?> 
                          <button type="button" disabled="" class="btn btn-sm btn-danger" title="This plan is used by member" style="cursor: not-allowed;"   >Delete</button>
                        <?php } ?>
                        
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
                
            </table>
            </div>
          </div>
          <div class="tab-pane  " id="promotionOnly">
            
             <div class="table-responsive">
              <table id="exampleList" class="table table-bordered">
                <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th class="text-right">#</th>
                      <th>Package Name</th>
                      <th>Only Coupon<br>Package</th>
                      <th>Description</th>
                      <th>IAP Apple ID</th>
                      <th class="text-right">Amount Without GST</th>
                      <th>GST Slab</th>
                      <th>Duration</th>
                      <th>Asign Member</th>
                      <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                  <?php 
                  $i=1;
                  $q=$d->select("package_master","is_cpn_package=1","");
                  while($row=mysqli_fetch_array($q))
                  {
                    extract($row);
                     $totalAsignPckg= $d->count_data_direct("plan_id","users_master","plan_id='$row[package_id]'");

                     if($gst_slab_id !="0"){
                       $gst_master=$d->select("gst_master","slab_id = '$gst_slab_id'","");
                      $gst_master_data=mysqli_fetch_array($gst_master);
                      $gst = $gst_master_data['slab_percentage'].' %';
                     } else {
                      $gst ="None";
                     }
                      
                  ?>
                    <tr>
                       <td class='text-center'>
                        <?php if ($totalAsignPckg==0) {
                         ?>
                        <input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $row['package_id']; ?>">
                        <?php } else { ?> 
                          <input title="Used Plans" type="checkbox"  disabled="">
                        <?php } ?>
                    </td>
                        <td class="text-right"><?php echo $i++; ?></td>
                        <td><?php echo $package_name; ?></td>
                        <td><?php if($is_cpn_package == 0){ echo "No";} else echo 'Yes'; ?></td>
                        <td><?php echo $packaage_description; ?></td>
                        <td><?php echo $inapp_ios_purchase_id; ?></td>
                        <td class="text-right"><?php echo $package_amount; ?></td>
                        <td><?php echo $gst; ?></td>
                        <td><?php echo $no_of_month; ?> <?php if($time_slab == 1) echo "Days"; else echo "Month"; ?></td>
                        <td class="text-right"><?php echo $totalAsignPckg; ?> </td>
                        <td>
                        <form style="display: inline-block;" action="plan" method="post">
                            <input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
                            <input type="submit" class="btn btn-sm btn-primary" name="updatepackage" value="Edit">
                          </form>


                          <?php if ($totalAsignPckg==0) {
                         ?>

                          <form style="display: inline-block;" action="controller/packageController.php" method="post">
                            <input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
                             <input type="hidden" name="deletepackage" value="deletepackage">
                            <input type="submit" class="btn btn-sm btn-danger form-btn" name="deletepackage" value="Delete">
                          </form>

                         
                        <?php }
                        //24nov2020
                        else { ?> 
                          <button type="button" disabled="" class="btn btn-sm btn-danger" title="This plan is used by member" style="cursor: not-allowed;"   >Delete</button>
                        <?php } ?>
                        
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
                
            </table>
            </div>
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



