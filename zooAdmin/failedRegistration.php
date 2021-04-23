<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-4">
        <h4 class="page-title">Failed Registration Users</h4>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Failed Registration Users</li>
         </ol>
      </div>

    </div>

 <form action="" method="get">
        <div class="row pt-2 pb-2">
      <div class="col-sm-4"></div>
        <div class="col-sm-6">
            <div class="input-daterange input-group">
                <input readonly="" type="text" class="form-control" autocomplete="off"   placeholder="Start Date" id="FromDate" name="from" value="<?php if ( !isset($_GET['from'])) { echo date('Y-m-01');} else {  echo $_GET['from']; } ?>"  />
                <div class="input-group-prepend">
                 <span class="input-group-text">to</span>
                </div>
                <input readonly="" type="text" class="form-control" autocomplete="off"   placeholder="End Date" id="ToDate" name="toDate" value="<?php if ( !isset($_GET['toDate'])) { echo date('Y-m-t');} else { echo $_GET['toDate'];  } ?>" />
               </div>
        </div>
         <div class="col-lg-2 col-3">
            <label  class="form-control-label"> </label>
              <input  class="btn btn-success" type="submit" name="getReport" class="form-control" value="Get Report">
          </div>
     </div>
   </form>

  </div>
  <!-- End Breadcrumb-->


  <div class="row">
    <div class="col-lg-12">
      <div class="card">

        <div class="card-body">
          <div class="table-responsive">
            <table id="example" class="table table-bordered">
              <thead>
                <tr>

                  <th class="text-right">#</th>
                  
                  <th>Name</th>
                  <th>City</th>
                  <th>Mobile Number</th>
                  <th>Email</th>
                 
                   
                  <th>Date Date</th>
                   <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                 
$where="";
 if(isset($_GET['from']) && isset($_GET['from'])){ 
 extract(array_map("test_input" , $_GET));
                $from = date('Y-m-d', strtotime($from));
                $toDate = date('Y-m-d', strtotime($toDate));
                $date=date_create($from);
                $dateTo=date_create($toDate);
                $nFrom= date_format($date,"Y-m-d 00:00:01");
                $nTo= date_format($dateTo,"Y-m-d 23:59:59");

                $where=" and  users_master_temp.register_date  BETWEEN '$nFrom' AND '$nTo' ";
}
                $users_master=$d->select("users_master","","");
                $completed_users = array('0');

               while ($users_master_data=mysqli_fetch_array($users_master)) {
                $completed_users[] =$users_master_data['user_mobile'];
               }

               $completed_users = implode(",", $completed_users);
                $q3=$d->select("users_master_temp,cities","cities.city_id= users_master_temp.city_id  and users_master_temp.user_mobile not in ($completed_users) $where ","");
              $i=1;
                while ($data=mysqli_fetch_array($q3)) {
                  extract($data);
                  ?>
                  <tr>

                    <td class="text-right"><?php echo $i++; ?></td>
                    <td><?php echo  $salutation.' '.$user_full_name; ?></td>
                    <td><?php echo  $city_name; ?></td>
                    <td><?php echo  $user_mobile; ?></td>
                    <td><?php echo  $user_email; ?></td>
                     <td data-order="<?php echo date("U",strtotime($register_date)); ?>" ><?php echo date("d-m-Y", strtotime($register_date)); ?></td>
                  

                    <td>
                      <form action="controller/commonController.php" method="post">
      <input type="hidden" name="temp_user_id" value="<?php echo $user_id; ?>"> 
      <?php if(isset($_GET['from']) && $_GET['from']!='' && isset($_GET['toDate'])  && $_GET['toDate']!='' ){ ?>
      <input type="hidden" name="from" value="<?php echo $_GET['from']; ?>"> 
      <input type="hidden" name="toDate" value="<?php echo $_GET['toDate']; ?>"> 
    <?php } ?> 
      <button type="submit" class="btn form-btn btn-danger" >Delete</button>
    </form>
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