<?php 
error_reporting(0);

 ?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
 

<!-- <h4 class="page-title">Invoice Report</h4> -->
<?php //25nov2020 

 $where ="";
  if ( isset($_GET['from']) && $_GET['from'] !='' && isset($_GET['toDate']) && $_GET['toDate'] !='' ) { 
                 extract(array_map("test_input" , $_GET));
                $from = date('Y-m-d', strtotime($from));
                $toDate = date('Y-m-d', strtotime($toDate));
                $date=date_create($from);
                $dateTo=date_create($toDate);
                $nFrom= date_format($date,"Y-m-d 00:00:01");
                $nTo= date_format($dateTo,"Y-m-d 23:59:59");
                $where .=" and  user_employment_details.complete_profile_date  BETWEEN '$nFrom' AND '$nTo'";
}
 if (isset($_GET['city_id'])!='' && $_GET['city_id'] != 0 ) { 
                 extract(array_map("test_input" , $_GET));
                $where .=" and  users_master.city_id  = '$city_id' ";
}  

$transCond ="";
   if (isset($_GET['paid_trans'])  && $_GET['paid_trans'] == 1 ) { 
                 extract(array_map("test_input" , $_GET));
                $transCond   .=" and   transection_master.is_paid =1 and transection_master.coupon_id  = 0 ";
}  else  if (isset($_GET['paid_trans'])  && $_GET['paid_trans'] == 2 ) { 
                 extract(array_map("test_input" , $_GET));
                $transCond   .="  and transection_master.coupon_id != 0 ";
}  else {
  $transCond   .=" and  transection_master.is_paid  = 0 and transection_master.coupon_id  = 0 ";
}
$where .=$transCond;

 $summ_qry=$d->select("users_master,user_employment_details,cities,transection_master","cities.city_id= users_master.city_id and   users_master.user_id =transection_master.user_id and    user_employment_details.user_id =users_master.user_id and  users_master.active_status= 0      $where group by transection_master.user_id   ","");
 $paid_total = 0 ;
 $free_total = 0 ; 
 while ($summ_data=mysqli_fetch_array($summ_qry)) {
    if (isset($_GET['paid_trans'])  && $_GET['paid_trans'] == 1) { 
      $free_total += $summ_data['transection_amount'] ;
    } else  {
       $paid_total += $summ_data['transection_amount'] ;
    }
}

?> 
<div class="row pt-2 pb-2">
      <div class="col-sm-6">
        <h4 class="page-title">  Invoice Report </h4>
      </div>


<?php if (isset($_GET['paid_trans'])  && ( $_GET['paid_trans'] == 2 ) ) { } else {?>
       <div class="col-sm-3">
         
           <span class="badge badge-pill badge-success m-1"> <span >Paid <i class="fa fa-inr"></i> <?php  echo number_format($paid_total,2,'.',''); ?> </span > </span > 
        
      </div>
       <div class="col-sm-3">
         
          <a href="couponReport"> <span class="badge badge-pill badge-danger m-1"> <span >Free <i class="fa fa-inr"></i><?php echo number_format($free_total,2,'.',''); ?> </span > </span > </a>
        
      </div>
<?php } ?> 

</div>
<?php //25nov2020
$_REQUEST['paid_trans'] = 0 ; ?> 
      <form action="" method="get">
      <div class="row pt-2 pb-2">

<?php /*
        <div class="col-sm-2">
           
       
        <select name="paid_trans"  class="form-control single-select">
           <option  <?php if ( isset($_REQUEST['paid_trans']) &&   $_REQUEST['paid_trans'] ==0  ) { echo 'selected';} ?>    value="0">Paid</option>
           <option <?php if ( isset($_REQUEST['paid_trans']) &&   $_REQUEST['paid_trans'] ==1 ) { echo 'selected';} ?>   value="1">Free</option>
          <option <?php if ( isset($_REQUEST['paid_trans']) &&   $_REQUEST['paid_trans'] ==2 ) { echo 'selected';} ?>   value="2">Coupon</option>
           
        </select>
         
       </div>
<?php */ ?>

        <div class="col-sm-3">
          <?php 
        
   
          $qry=$d->select("cities"," city_flag=1","ORDER BY city_name ASC");
          //onchange="this.form.submit();"
          ?>
       
        <select name="city_id"  class="form-control single-select">
          
           <option  value="0">All</option>
          <?php   
           while ($blockRow=mysqli_fetch_array($qry)) {
         ?>
          <option <?php if ( isset($_REQUEST['city_id']) &&  $blockRow['city_id']==$_REQUEST['city_id'] ) { echo 'selected';} ?> value="<?php echo $blockRow['city_id'];?>"><?php echo $blockRow['city_name'];?></option>
          <?php }?>
        </select>
         
       </div>
        <div class="col-sm-5">
          <div class="">
            <div id="dateragne-picker">
                <div class="input-daterange input-group">
                <input readonly="" type="text" class="form-control" autocomplete="off"   placeholder="Start Date" name="from" value="<?php echo $_GET['from']; ?>" />
                <div class="input-group-prepend">
                 <span class="input-group-text">to</span>
                </div>
                <input readonly="" type="text" class="form-control" autocomplete="off"   placeholder="End Date" name="toDate" value="<?php echo $_GET['toDate']; ?>" />
               </div>
              </div>
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
           
            <table id="example" class="table table-bordered">
              <thead>
                <tr>
                 
                  <th class="text-right">#</th>
                 <th>City Name</th>
                  <th>Business Name</th>
                  <th>User Name</th>
                   <th>Device</th>
                  <th>Mobile</th>
                   <th>Package Name</th>
                   <th class="text-right">Package Amount</th>
                   <th>Payment Mode</th>
                    <th>Refered By</th>
                   <th>Transaction Date</th>
                   <th>Download Invoice</th>
                     
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
               
         
               
              /*  $q3=$d->select("transection_master,company_master,users_master,user_employment_details ","user_employment_details.user_id =users_master.user_id and   company_master.company_id =transection_master.company_id and users_master.user_id =transection_master.user_id and    users_master.active_status= 0 and users_master.user_payment_mode != 0   $where  ","");*/
// /and users_master.user_payment_mode = 0
 $q3=$d->select("users_master,user_employment_details,cities,transection_master,business_categories,business_sub_categories ","cities.city_id= users_master.city_id AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id  and   users_master.user_id =transection_master.user_id and    user_employment_details.user_id =users_master.user_id and  users_master.office_member=0 AND users_master.active_status= 0       $where group by transection_master.user_id order by user_employment_details.complete_profile_date  asc  ","");

  
 
               while ($data=mysqli_fetch_array($q3)) {
                extract($data);
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                   <td><?php  echo $city_name; ?></td>
                  <td><?php  echo $company_name; ?></td>
                  <td><a target="_blank"   title="View Profile"  href="viewMember?id=<?php echo $user_id; ?>" ><?php echo  $salutation.' '.$user_full_name; ?></a></td>
                   <td><?php echo $device; ?></td>
                  <td><?php echo $user_mobile; ?></td>
                  <td><?php echo $package_name; ?></td>
                  <td class="text-right"><?php echo $transection_amount; ?></td>
                  <td><?php 
                  $word = strtolower('Razorpay');
                  $word1 = 'Razorpay';
                  if (strpos($payment_mode, $word) !== false || strpos($payment_mode, $word1) !== false ) {
 echo 'Online';
} else  {
  echo $payment_mode;
}  ?></td> 
                    <td><?php if($refer_by=="1") {echo "Social Media";} 
                  else if($refer_by=="2") {echo "Member / Friend </br>(".$refere_by_name." - ". $refere_by_phone_number .")";}
                  else if($refer_by=="3") {

                    if($remark !=""){
                      echo "Other </br>(".$remark .")";
                    }
                    echo "Other";}
                   ?></td>
                  <td data-order="<?php echo date("U",strtotime($complete_profile_date)); ?>"><?php echo date("d-m-Y h:i:s A",strtotime($complete_profile_date));  ?></td>
                  <td>
                    <?php  if (isset($_GET['paid_trans'])  && ($_GET['paid_trans'] == 1 || $_GET['paid_trans'] == 2 ) ) {   echo "-";  } else { ?> 
                     <a target="_blank"  href="../paymentReceipt.php?user_id=<?php echo $user_id; ?>&downloadInvoice=true" class=" btn-sm btn-info"><i class="fa fa-download"></i>Download</a>
                   <?php }  ?> 
                  </td>

               </tr>

             <?php  } ?> 
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


  
 