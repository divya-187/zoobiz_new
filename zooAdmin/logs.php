 <?php 
extract($_REQUEST);
?> <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
        <h4 class="page-title">Logs</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Logs</li>
         </ol>
     </div>
     <div class="col-sm-3">
       <div class="btn-group float-sm-right">
       
        
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
              <table id="example2" class="table table-bordered">
                <thead>
                    <tr>
                      
                      <th class="text-right">#</th>
                      <th>Log</th>
                      <th>User</th>
                      <th>Log Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i=1;
                    if (isset($user_id)){ 

                      $qu = $d->select("users_master" ," user_id ='$user_id' ","");
                      $data_u=mysqli_fetch_array($qu);

                      $q = $d->select("log_master" ,"  app_user_id ='$user_id' ","order by log_id  DESC limit 2000");
                    } else if ($_SESSION['role_id']==1){ 
                      $q = $d->select("log_master,zoobiz_admin_master" ,"zoobiz_admin_master.zoobiz_admin_id =log_master.user_id and  log_master.user_id!=0 and log_master.user_id!= log_master.user_name ","order by log_master.log_id  DESC limit 2000");
                    } else {
                      $q = $d->select("log_master,zoobiz_admin_master" ,"log_master.user_id!=0 and log_master.user_id!= log_master.user_name","order by log_master.log_id  DESC limit 2000");
                    }
                    while ($data=mysqli_fetch_array($q)) {
                      // print_r($data);
                     ?>
                    <tr>
                  
                      <td class="text-right"><?php echo $i++; ?></td>
                        <td><?php echo $data["log_name"]; ?></td>
                        <td><?php 
                        if(isset($user_id)){
                          echo $data_u['user_full_name'];
                        } else {
                          echo $data["admin_name"];
                        }
                         ?></td>
                        <td data-order="<?php echo date("U",strtotime($data["log_time"])); ?>"><?php echo date("Y-m-d h:i:s A", strtotime($data["log_time"])); ?></td>
                        <!-- <td></td> -->
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



