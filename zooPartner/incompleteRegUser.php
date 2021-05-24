<?php 
error_reporting(0);

 ?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <form action="" method="get">
      <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">Incomplete User Registration Report</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Incomplete User Registration Report</li>
         </ol>
       </div>
     </div>
     <div class="row pt-2 pb-2">
      <div class="col-sm-2"></div>
        <div class="col-sm-6">
            <div class="input-daterange input-group">
                <input readonly="" type="text" class="form-control" autocomplete="off"   placeholder="Start Date" id="FromDate" name="from" value="<?php if ( !isset($_GET['from'])) { echo date('Y-m-01');} else {  echo $_GET['from']; } ?>"  />
                <div class="input-group-prepend">
                 <span class="input-group-text">to</span>
                </div>
                <input readonly="" type="text" class="form-control" autocomplete="off"   placeholder="End Date" id="ToDate" name="toDate" value="<?php if ( !isset($_GET['toDate'])) { echo date('Y-m-t');} else { echo $_GET['toDate'];  } ?>" />
               </div>
        </div>

         <div class="col-sm-2">
          <div class="">
             <select id="view_otp"  class="form-control single-select" name="view_otp" type="text"   >  <option <?php if( isset($_GET['view_otp']) &&   $_GET['view_otp'] == 0 ) { echo 'selected';} ?>  value="0">Hide OTP</option>
              <option <?php if( isset($_GET['view_otp']) &&   $_GET['view_otp'] ==1 ) { echo 'selected';} ?>  value="1">View OTP</option>
                            
                            </select>
          </div>
        </div>
         <div class="col-lg-2 col-3">
            <label  class="form-control-label"> </label>
              <input  class="btn btn-success" type="submit" name="getReport" class="form-control" value="Get Report">
          </div>
     </div>
   </div>
   <!-- End Breadcrumb-->
    </form>


   <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <!-- <div class="card-header"><i class="fa fa-table"></i> Data Exporting</div> -->
        <div class="card-body">
          <div class="table-responsive">
            <?php if ($_GET['from']!='') {  ?>
            <table id="example" class="table table-bordered">
              <thead>
                <tr>
                 
                  <th class="text-right">#</th>
                 
                  
                  
                  <th>Name</th>
                   <th>Mobile Number</th>
                  <?php if(isset($_GET['view_otp']) && $_GET['view_otp']==1 ){?>
                  <th>OTP</th>
                  <?php }?>
                  <th>Payment Details</th>
                   <th>refer by</th>
                    <th>Refer Person Name</th>
                   <th>Refer Person Phone No.</th>
               
                  <th>City</th>
                  <th>Email</th>
                 
                    <th>Company Name</th>

                   <th>Date</th>
                     <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;

                 extract(array_map("test_input" , $_GET));
                $from = date('Y-m-d', strtotime($from));
                $toDate = date('Y-m-d', strtotime($toDate));
                $date=date_create($from);
                $dateTo=date_create($toDate);
                $nFrom= date_format($date,"Y-m-d 00:00:01");
                $nTo= date_format($dateTo,"Y-m-d 23:59:59");

                $user_employment_details=$d->select("user_employment_details","","");
                $completed_users = array('0');

               while ($user_employment_details_data=mysqli_fetch_array($user_employment_details)) {
                $completed_users[] =$user_employment_details_data['user_id'];
               }

               $completed_users = implode(",", $completed_users);
               
                $q3=$d->select("users_master,cities","cities.city_id= users_master.city_id and   users_master.active_status= 0 and  users_master.register_date  BETWEEN '$nFrom' AND '$nTo' and users_master.user_id not in ($completed_users) ","");

                 
               while ($data=mysqli_fetch_array($q3)) {
                extract($data);
               
 $companyName="-";
$company_master_qry=$d->select("company_master","  company_id = '$company_id'   ","");
                 if(mysqli_num_rows($company_master_qry)>0) { 
                  $company_master_data=mysqli_fetch_array($company_master_qry);
                  $companyName=$company_master_data['company_name'];
                 }
              
                 
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                  
                  <td><?php echo  $salutation.' '.$user_full_name; ?></td>
 <td><?php echo $user_mobile; ?>
                    
                    
                  </td>
                   <?php if(isset($_GET['view_otp']) && $_GET['view_otp']==1 ){?>
                  <td><?php echo  $otp; ?></td>
                  <?php } ?>
                  
                  <?php
                   $transection_master=$d->select("transection_master","user_id = '$user_id'  "," order by transection_id desc"); 
                   $transection_master_data=mysqli_fetch_array($transection_master);
                  ?>
                  <td><?php echo 'Plan: '.$transection_master_data['package_name'] ;
                  echo '<br>Payment Mode: '.$transection_master_data['payment_mode'] ;
                   
                  if($transection_master_data['coupon_id'] !=0){
                    $coupon_master=$d->select("coupon_master","coupon_id = '$transection_master_data[coupon_id]'  ",""); 
                   $coupon_master_data=mysqli_fetch_array($coupon_master);
                   echo '<br>Coupon Name: '.$coupon_master_data['coupon_name'] ;
                   echo '<br>Coupon Code: '.$coupon_master_data['coupon_code'] ;
                   
                  }
                  
                   ?></td>
                     <td><?php if($refer_by=="1") {echo "Social Media";} 
                  else if($refer_by=="2") {echo "Member / Friend";}
                  else if($refer_by=="3") {echo "Other";}
                   ?></td>
                 
                  <td><?php echo wordwrap($refere_by_name,20,"<br>\n"); ?></td>
                  <td><?php echo  $refere_by_phone_number ; ?></td> 
            

                   <td><?php echo $city_name ; ?></td>
                  <td><?php echo $user_email ; ?></td>
                 
                  <td><?php  echo $companyName; ?></td>
                  <td data-order="<?php echo date("U",strtotime($register_date)); ?>"><?php echo date("d-m-Y h:i:s A",strtotime($register_date));  ?></td>
                    
                
                 <td>
                      <form action="controller/userController.php" method="post">
      <input type="hidden" name="incomp_delete_user_id" value="<?php echo $user_id; ?>"> 
      <input type="hidden" name="from" value="<?php echo $_GET['from']; ?>"> 
      <input type="hidden" name="toDate" value="<?php echo $_GET['toDate']; ?>"> 

      <button type="submit" class="btn form-btn btn-danger" >Delete</button>
    </form>
                   </td>

               </tr>

             <?php  } ?> 
           </tbody>

         </table>
       <?php } else {

        echo "Select Date";
      }?>
       </div>
     </div>
   </div>
 </div>
</div><!-- End Row-->

</div>
<!-- End container-fluid-->

</div><!--End content-wrapper-->
<!--Start Back To Top Button-->


  
<script type="text/javascript">
  function replyFeedback (feedback_id,email,name) {
    $('#feedback_id').val(feedback_id);
    $('#feedback_email').val(email); 

  }
  function contemtModal(feedback_id){
     // $('#content').html(content); 
      $.ajax({
      url: "viewFeedbackMessage.php",
      cache: false,
      type: "POST",
      data: {feedback_id:feedback_id},
      success: function(response){
        $('#content').html(response);

      }
    });
  }
</script>