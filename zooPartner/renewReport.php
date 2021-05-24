<?php 
error_reporting(0);

 ?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
  <?php  

 $where ="";
  if ( isset($_GET['from']) && $_GET['from'] !='' && isset($_GET['toDate']) && $_GET['toDate'] !='' ) { 
                 extract(array_map("test_input" , $_GET));
                $from = date('Y-m-d', strtotime($from));
                $toDate = date('Y-m-d', strtotime($toDate));
                $date=date_create($from);
                $dateTo=date_create($toDate);
                $nFrom= date_format($date,"Y-m-d 00:00:01");
                $nTo= date_format($dateTo,"Y-m-d 23:59:59");
                $where .=" and  transection_master.transection_date  BETWEEN '$nFrom' AND '$nTo'";
}
 if (isset($_GET['company_id'])!='' && $_GET['company_id'] != 0 ) { 
                 extract(array_map("test_input" , $_GET));
                $where .=" and  users_master.company_id  = '$company_id' ";
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
 

?> 
<div class="row pt-2 pb-2">
      <div class="col-sm-6">
        <h4 class="page-title"> Renew Invoice Report </h4>
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Renew Invoice Report</li>
         </ol>
      </div>
 

</div>
<?php  
$_REQUEST['paid_trans'] = 0 ; ?> 
      <form action="" method="get">
      <div class="row pt-2 pb-2">

 

        <div class="col-sm-3">
          <?php 
        
   
          $qry=$d->select("company_master"," status=0","ORDER BY company_name ASC");
       
          ?>
       
        <select name="company_id"  class="form-control single-select">
          
           <option  value="0">All</option>
          <?php   
           while ($blockRow=mysqli_fetch_array($qry)) {
         ?>
          <option <?php if ( isset($_REQUEST['company_id']) &&  $blockRow['company_id']==$_REQUEST['company_id'] ) { echo 'selected';} ?> value="<?php echo $blockRow['company_id'];?>"><?php echo $blockRow['company_name'].' - '.$blockRow['comp_gst_number'];?></option>
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
                 <th>Company Name</th>
                  
                  <th>User Name</th>
                   <th>Device</th>
                  <th>Mobile</th>
                   <th>Package Name</th>
                   <th class="text-right">Package Amount</th>
                   <th>Payment Mode</th>
                
                   <th>Transaction Date</th>
                   <th>Download Invoice</th>
                     
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
               
         
               
            
 $q3=$d->select("users_master,user_employment_details,company_master,transection_master,business_categories,business_sub_categories, plan_renew_master ","plan_renew_master.transaction_id =transection_master.transection_id and   company_master.company_id= users_master.company_id AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id  and   users_master.user_id =transection_master.user_id and    user_employment_details.user_id =users_master.user_id and  users_master.office_member=0 AND users_master.active_status= 0       $where group by DATE(plan_renew_master.renew_date),plan_renew_master.user_id  order by plan_renew_master.renew_date  asc  ","");

   
 
               while ($data=mysqli_fetch_array($q3)) {
                extract($data);
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                    
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
                    
                  <td data-order="<?php echo date("U",strtotime($renew_date)); ?>"><?php echo date("d-m-Y h:i:s A",strtotime($renew_date));  ?></td>
                  <td>
                    <?php 


                     if (isset($_GET['paid_trans'])  && ($_GET['paid_trans'] == 1 || $_GET['paid_trans'] == 2 ) ) {   echo "-";  } else {

 
                      ?> 
                     <a target="_blank"  href="../paymentReceipt.php?user_id=<?php echo $user_id; ?>&downloadInvoice=true&transection_date=<?php echo date("Y-m-d", strtotime($renew_date)); ?>" class=" btn-sm btn-info"><i class="fa fa-download"></i>Download</a>
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

</div>


  
 