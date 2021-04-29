<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <form action="" method="get">
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title">Member Feature Used</h4>
           <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Member Feature Used</li>
         </ol>
       </div>
     </div>

      <div class="row pt-2 pb-2">
        <div class="col-sm-5"> 
          <div class="">

             <select   name="feature_arr"  class="form-control single-select">
              <option    value="">--Select--</option>

           <option  <?php if ( isset($_REQUEST['feature_arr']) &&   $_REQUEST['feature_arr'] == 0   ) { echo 'selected';} ?>    value="0">Timeline Used</option>
           <option  <?php if ( isset($_REQUEST['feature_arr']) &&  $_REQUEST['feature_arr'] == 1 ) { echo 'selected';} ?>    value="1">Classified Used</option>
           <option  <?php if ( isset($_REQUEST['feature_arr']) && $_REQUEST['feature_arr'] == 2 ) { echo 'selected';} ?>    value="2">Meetup Used</option>
           <option  <?php if ( isset($_REQUEST['feature_arr']) &&$_REQUEST['feature_arr'] == 3) { echo 'selected';} ?>    value="3">Chat Used</option>
           
          
           
        </select>
          </div>
        </div>
            <div class="col-sm-5"> 
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


   <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <!-- <div class="card-header"><i class="fa fa-table"></i> Data Exporting</div> -->
        <div class="card-body">
          <div class="table-responsive">
            <?php 
// echo "<pre>";print_r($_REQUEST);

            if ( (isset($_REQUEST['feature_arr']) && $_REQUEST['feature_arr'] !='' )   ) {  ?>
            <table id="example" class="table table-bordered">
              <thead>
                <tr>
                 
                  <th class="text-right">#</th>
                 
                  
                  <th>Name</th>

                  <th>Payment Details</th>
                   <th>refer by</th>
                    <th>Refer Person Name</th>
                   <th>Refer Person Phone No.</th>

                  <th>City</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>BUSINESS Name</th> 
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;

                 extract(array_map("test_input" , $_REQUEST));
                $from = date('Y-m-d', strtotime($from));
                $toDate = date('Y-m-d', strtotime($toDate));
                $date=date_create($from);
                $dateTo=date_create($toDate);
                $nFrom= date_format($date,"Y-m-d 00:00:01");
                $nTo= date_format($dateTo,"Y-m-d 23:59:59");

$where="";
$leftJoin="";
extract(array_map("test_input" , $_REQUEST));
if (isset($_GET['feature_arr'])!=''  ) { 
                if( $_REQUEST['feature_arr'] == 0){
                   $leftJoin .=" ,timeline_master  ";
                   $where=" and timeline_master.user_id= users_master.user_id and  timeline_master.created_date  BETWEEN '$nFrom' AND '$nTo'";
                }
                if($_REQUEST['feature_arr'] == 1 ){
                    $leftJoin .=" , cllassifieds_master  ";
                    $where=" and cllassifieds_master.user_id= users_master.user_id  and  cllassifieds_master.created_date  BETWEEN '$nFrom' AND '$nTo'";
                  }
                 if($_REQUEST['feature_arr'] == 2){
                    $leftJoin .="  , meeting_master    ";
                    $where=" and (meeting_master.user_id= users_master.user_id OR meeting_master.member_id= users_master.user_id) and  meeting_master.date  BETWEEN '$nFrom' AND '$nTo'";
                  }

                  if($_REQUEST['feature_arr'] == 3){
                    $leftJoin .=" , chat_master ";
                     $where=" and (chat_master.msg_by= users_master.user_id OR chat_master.msg_for= users_master.user_id)  and  chat_master.msg_date  BETWEEN '$nFrom' AND '$nTo'";
                  }
                 
                
}  

 
/*    echo "cities,user_employment_details,users_master  $leftJoin";
                echo "cities.city_id= users_master.city_id and    user_employment_details.user_id =users_master.user_id and  users_master.active_status= 0 AND users_master.office_member=0  $where ";exit;*/
  //echo "users_master,user_employment_details  $leftJoin";exit;
                $q3=$d->select("cities,user_employment_details,users_master  $leftJoin","cities.city_id= users_master.city_id and    user_employment_details.user_id =users_master.user_id and  users_master.active_status= 0 AND users_master.office_member=0  $where "," group by users_master.user_id");

                
               while ($data=mysqli_fetch_array($q3)) {
                extract($data);
  
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                   
                  <td><a target="_blank"   title="View Profile"  href="viewMember?id=<?php echo $user_id; ?>" ><?php echo  $salutation.' '.$user_full_name; ?></a></td>

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
                  <td><?php echo $user_mobile; ?></td>
                  <td><?php  echo $company_name;
                   ?></td>
  
               </tr>

             <?php  } ?> 
           </tbody>

         </table>
       <?php } else {
        echo "Please select Feature from drop down.";
       } ?>
       </div>
     </div>
   </div>
 </div>
</div><!-- End Row-->

</div>
<!-- End container-fluid-->

</div><!--End content-wrapper-->
<!--Start Back To Top Button-->