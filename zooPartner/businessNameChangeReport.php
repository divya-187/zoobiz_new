<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-4">
        <h4 class="page-title">Business Name Change</h4>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Business Name Change</li>
         </ol>
      </div>

    </div>

 <form action="" method="get">
        <div class="row pt-2 pb-2">
      <div class="col-sm-4">
         <select name="request_status"  class="form-control single-select">
           <option  <?php if ( isset($_REQUEST['request_status']) && $_REQUEST['request_status'] =="0" ) { echo 'selected';} ?>  value="0">All</option>
            <option <?php if ( isset($_REQUEST['request_status']) && $_REQUEST['request_status'] =="Pending" ) { echo 'selected';} ?> value="Pending">Pending</option>
            <option <?php if ( isset($_REQUEST['request_status']) && $_REQUEST['request_status']  =="Approved" ) { echo 'selected';} ?> value="Approved">Approved</option>
            <option <?php if ( isset($_REQUEST['request_status']) && $_REQUEST['request_status'] =="Rejected" ) { echo 'selected';} ?> value="Rejected">Rejected</option>
         
          
        </select>

      </div>
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
                  
                  <th>Mobile Number</th>
                  <th>Comapny Name</th>
                  <th>New Comapny Name</th>
                   
                  <th>REQUESTED Date</th>
                   <th>ACTION Date</th>
                   <th>ACTION BY</th>
                <th>Status</th>
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

                $where=" and  business_name_change_request_masater.requested_at  BETWEEN '$nFrom' AND '$nTo' ";
}

if(isset($_GET['request_status']) && $_GET['request_status'] != "0"){

                  $request_status = $_GET['request_status'];
                  $where .=" and business_name_change_request_masater.request_status='$request_status'";
                }

             
                $q3=$d->select("users_master,business_name_change_request_masater,user_employment_details"," user_employment_details.user_id = users_master.user_id and  users_master.user_id =business_name_change_request_masater.user_id  and users_master.city_id='$selected_city_id'   $where ","group by business_name_change_request_id");
              $i=1;
                while ($data=mysqli_fetch_array($q3)) {
                  extract($data);
                  ?>
                  <tr>

                    <td class="text-right"><?php echo $i++; ?></td>
                    <td><?php echo  $salutation.' '.$user_full_name; ?></td>
                   
                    <td><?php echo  $user_mobile; ?></td>
                    <td><?php echo  $company_name; ?></td>  
                    <td><?php echo  $requested_business_name; ?></td>  
                     <td data-order="<?php echo date("U",strtotime($requested_at)); ?>" ><?php echo date("d-m-Y", strtotime($requested_at)); ?></td>
                   <td data-order="<?php if($action_at!="0000-00-00 00:00:00"){  echo date("U",strtotime($action_at)); } ?>" ><?php if($action_at!="0000-00-00 00:00:00"){  echo date("d-m-Y", strtotime($action_at)); } else { echo "-";} ?></td>
                      <td><?php echo  $action_by; ?></td>  
                    <td><?php echo  $request_status; ?></td>  
                    


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