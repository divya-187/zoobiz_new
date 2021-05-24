<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Seasonal Greetings List</h4>
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Seasonal Greetings List</li>
         </ol>
      </div>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right">
          <a href="seasonalGreet"  class="btn  btn-sm btn-primary pull-right"><i class="fa fa-plus fa-lg"></i> Add New </a>
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
            <table id="example" class="table table-bordered">
              <thead>
                <tr>
                   
                  <th class="text-right">#</th>

                  <th>Title</th>
                  
                  <th> Expiry</th>
                   <th>Start Date</th>
                    <th>End Date</th>
                 <th class="text-right">Active Images</th>
                   <th class="text-right">InActive Images</th>
                  <th>Created By</th>
                  <th>Created at</th>
                  <th>Action</th>
                  
                </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
                $q=$d->select("seasonal_greet_master,zoobiz_admin_master","  seasonal_greet_master.created_by =zoobiz_admin_master.zoobiz_admin_id   order by seasonal_greet_master.created_at
                  desc ");
                while ($data=mysqli_fetch_array($q)) {
                  extract($data);
                  ?>
                  <tr>
                    

                    <td class="text-right"><?php echo $i++; ?></td>

                    


                    <td><?php echo  $title; ?></td>
                     
                    <td><?php echo $is_expiry; ?></td>
                    <td   <?php if($is_expiry=="Yes" && $start_date!="0000-00-00") {?> data-order="<?php echo date("U",strtotime($start_date)); ?>"  <?php } ?>  ><?php if($is_expiry=="Yes" && $start_date!="0000-00-00" ) {echo date("d-m-Y", strtotime($start_date));} else echo "-"; ?></td>
                    <td <?php if($is_expiry=="Yes" && $end_date!="0000-00-00") {?> data-order="<?php echo date("U",strtotime($end_date)); ?>"  <?php } ?>  ><?php if($is_expiry=="Yes" && $end_date!="0000-00-00") {echo date("d-m-Y", strtotime($end_date));} else echo "-"; ?></td>

                     <td class="text-right"><?php
                     $q3=$d->select("seasonal_greet_image_master"," seasonal_greet_id='$seasonal_greet_id' and status ='Active'","");
                      echo $totalActiveImages =  mysqli_num_rows($q3);

                     ?></td>
                     <td class="text-right"><?php
                     $q3=$d->select("seasonal_greet_image_master"," seasonal_greet_id='$seasonal_greet_id' and status ='InActive'","");
                      echo $totalActiveImages =  mysqli_num_rows($q3);

                     ?></td>
                    <td><?php echo $admin_name; ?></td>
                    <td data-order="<?php echo date("U",strtotime($created_at)); ?>"><?php echo date("d-m-Y h:i:s A", strtotime($created_at)); ?></td>
                    <td>

                        
                      <div style="display: inline-block;">
                        <form action="manageSeasonalGreet" method="post">
                          <input type="hidden" name="seasonal_greet_id" value="<?php echo $seasonal_greet_id; ?>">
                          <button type="submit" name="" class="btn btn-warning btn-sm "> Manage</button>
                        </form>
                      </div>


                      <div style="display: inline-block;">
                        <form action="seasonalGreet" method="post">
                          <input type="hidden" name="seasonal_greet_id" value="<?php echo $seasonal_greet_id; ?>">
                          <button type="submit" name="" class="btn btn-primary btn-sm "> Edit</button>
                        </form>
                      </div>
                      
                   
                    <?php $today = date("Y-m-d"); 

                 
                      if ($is_expiry=="Yes"  && strtotime($today) > strtotime($end_date) ) { ?>
                      <div style="display: inline-block;">
                        <form  action="controller/seasonalGreetController.php" method="post">
                          <input type="hidden" name="delete_seasonal_greet_id" value="<?php echo $seasonal_greet_id; ?>">
                          <button type="submit" name="deleteCmp" class="form-btn btn btn-danger btn-sm "> Delete</button>
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