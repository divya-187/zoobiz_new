<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-6">
          <?php   ?>
          <h4 class="page-title">Not Active User Before <?php echo $_REQUEST['days'];?> Days -App </h4>
            <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Not Active Users</li>
         </ol>
       </div>

       

        <div class="col-sm-6">
          <div class="">
            <?php  
            $where="";


$today = date("Y-m-d");
                  $login_date_start = date('Y-m-d 00:00:00', strtotime($today .   -$_REQUEST['days'] .' day'));

                  $login_date_end = date('Y-m-d 23:59:59', strtotime($today .   -$_REQUEST['days'] .' day'));

                  $day_int = (int)$_REQUEST['days'];
 //CAST(last_login AS DATE) = '2020-12-20' and user_token!=''
//$where= " AND last_login BETWEEN '$login_date_start' AND '$login_date_end'";
 //$where= " AND CAST(last_login AS DATE) = '$login_date_start' and user_token!='' ";
if(isset($_REQUEST['days']) && $_REQUEST['days'] > 0 ){
 // $_REQUEST['days'] = 0 ;

$currDate = date("Y-m-d");
$date_before_1_day = date("Y-m-d", strtotime($currDate."-".$_REQUEST['days']." day"));

/*if(strtotime($date_before_1_day) < strtotime($currDate) ){
  $date_before_1_day =$currDate;
}*/
 
   //$where= " AND user_token!='' and CAST(last_login AS DATE)= DATE_SUB(CURDATE(), INTERVAL ".$day_int." DAY)  and office_member = 0 ";

   $where= " AND user_token!='' and DATE(last_login) <= '".$date_before_1_day."'  and office_member = 0 ";

/*if($_SESSION[zoobiz_admin_id] == 7 ){
  echo $where;
}*/
     $q3=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","    business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND users_master.active_status=0  AND user_employment_details.user_id=users_master.user_id  and users_master.last_login !='0000-00-00 00:00:00'  $where group by users_master.user_id  ","");
}
                 
 
 
             if(isset($_REQUEST['days']) && $_REQUEST['days'] > 0  && mysqli_num_rows($q3) > 0 ) { ?> 
            <table class="table table-bordered mTable">
              <tr>
                <th  class="text-center">Android </th>
                <th  class="text-center">Ios </th>
                <th  class="text-center">All Users </th>
              </tr>
              <tr>
                <td class="text-center">
                  <?php 

                  
                 

                  $q1=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","     business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id $where  AND  lower(users_master.device) ='android' AND users_master.active_status=0  group by users_master.user_id","");
                  echo mysqli_num_rows($q1);

                  ?>
                </td>
                <td  class="text-center">
                  <?php 
                  $q2=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","     business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id $where AND  lower(users_master.device) ='ios' AND users_master.active_status=0 group by users_master.user_id","");
                  echo mysqli_num_rows($q2);

                  ?>
                </td>
                <td  class="text-center">
                  <?php 
                
                   
                  echo   mysqli_num_rows($q3);



                  ?>
                </td>
              </tr>
            </table>
          <?php } ?> 
          </div>
        </div>
     </div>





         
            <form action=""   method="post" accept-charset="utf-8">
<div class="row pt-2 pb-2">

  <label class="col-lg-3 col-form-label form-control-label">Not Active Before Days <span class="required">*</span></label>

              <div class="col-sm-4">
           <input min="1" minlength="1" maxlength="4" class="form-control onlyNumber " name="days" type="text" value="<?php echo $_REQUEST['days'] ; ?>" required="">

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
        <!-- <div class="card-header"><i class="fa fa-table"></i> Data Exporting</div> -->
        <div class="card-body">
          <div class="table-responsive">
            <table id="example" class="table table-bordered">
              <thead>
                <tr>
                 
                  <th class="text-right">#</th>
                 
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Company</th>
                   <th>Device</th>
                    <th>no. of Days</th>
                    <th>Last Active Time</th> 
                   
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;

               if($_REQUEST['days'] > 0 ){ 
               while ($data=mysqli_fetch_array($q3)) {
                extract($data);
if($last_login !='0000-00-00 00:00:00'){

                $startTimeStamp = strtotime($last_login);
$endTimeStamp = strtotime($currDate);

$timeDiff = abs($endTimeStamp - $startTimeStamp);

$numberDays = $timeDiff/86400;  // 86400 seconds in one day

// and you might want to convert to integer
$numberDays = intval($numberDays);

                ?>
                <tr>
                  <!-- <td class='text-center'>
                    <input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $data['feedback_id']; ?>">
                  </td> -->
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td><a target="_blank"   title="View Profile"  href="viewMember?id=<?php echo $user_id; ?>" ><?php echo  $salutation.' '.$user_full_name; ?></a></td>
                  <td><?php echo $user_email ; ?></td>
                  <td><?php echo $user_mobile; ?></td>
                  <td><?php  echo $company_name;
                   ?></td>
                  <td><?php echo $device; ?></td>
                  <td><?php echo $numberDays; ?></td>
                 <td data-order="<?php echo date("U",strtotime($last_login)); ?>"><?php echo date("d-m-Y h:i:s A",strtotime($last_login));  ?></td>
                  <!--  <td>
                    <form action="viewMember" method="get">    
                          <input type="hidden" name="id" value="<?php echo $user_id; ?>">    
                          <button type="submit" name="" class="btn btn-danger btn-sm "> View Profile</button>
                        </form>
                    </div>
                 </td> -->
                 
                

               </tr>

             <?php }}  
           }
            ?> 
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