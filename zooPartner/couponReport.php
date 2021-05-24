<?php 
error_reporting(0);

 ?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
 

<h4 class="page-title">Coupon Report</h4>
 <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Coupon Report</li>
         </ol>
      <form action="" method="get">
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <?php 
        
   
          $qry=$d->select("coupon_master"," coupon_status=0","ORDER BY coupon_name ASC");
          //onchange="this.form.submit();"
          ?>
       
        <select name="coupon_id"  class="form-control single-select">
          
           <option  value="0">All</option>
          <?php   
           while ($blockRow=mysqli_fetch_array($qry)) {
         ?>
          <option <?php if ( isset($_REQUEST['coupon_id']) &&  $blockRow['coupon_id']==$_REQUEST['coupon_id'] ) { echo 'selected';} ?> value="<?php echo $blockRow['coupon_id'];?>"><?php echo $blockRow['coupon_name'].' - '.$blockRow['coupon_code'];?></option>
          <?php }?>
        </select>
         
       </div>
        <div class="col-sm-6">
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
                 
                  <th class="text-right" >#</th>
                 
                  <th>Company Name</th>
                  <th>User Name</th>
                  
                  <th>Mobile</th>
                   <th>Package Name</th>
                   <th class="text-right" > Original Amount</th>
                   <th class="text-right" > Coupon Per/ Amount</th>
                   <th class="text-right" >Coupon Amount</th>

                   <th>Payment Mode</th>
                    <th>Coupon Name</th>
                     <th>Coupon Code</th> 
                   <th>Date</th>
                   
                     
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                $where ="";
  if (isset($_GET['from']) && $_GET['from'] !='' && isset($_GET['toDate']) && $_GET['toDate'] !='' ) { 
                 extract(array_map("test_input" , $_GET));
                $from = date('Y-m-d', strtotime($from));
                $toDate = date('Y-m-d', strtotime($toDate));
                $date=date_create($from);
                $dateTo=date_create($toDate);
                $nFrom= date_format($date,"Y-m-d 00:00:01");
                $nTo= date_format($dateTo,"Y-m-d 23:59:59");
                $where .=" and  transection_master.transection_date  BETWEEN '$nFrom' AND '$nTo'";
}
 if (isset($_GET['coupon_id'])!='' && $_GET['coupon_id'] != 0 ) { 
                 extract(array_map("test_input" , $_GET));
                $where .=" and  transection_master.coupon_id  = '$coupon_id' ";
}                
               
                $q3=$d->select("transection_master,coupon_master,users_master, company_master","company_master.company_id =users_master.company_id and   coupon_master.coupon_id =transection_master.coupon_id and users_master.user_id =transection_master.user_id and    users_master.active_status= 0  $where  ","");
               while ($data=mysqli_fetch_array($q3)) {
                extract($data);
               
 
                
                  $package_master=$d->select("package_master","package_id='$package_id' ","");
              $package_master_data=mysqli_fetch_array($package_master);
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                   
                  <td><?php  echo $company_name; ?></td>
                  <td><?php echo  $salutation.' '.$user_full_name; ?></td>
                   
                  <td><?php echo $user_mobile; ?></td>
                  <td><?php echo $package_name; ?></td>
                  <td class="text-right"><?php echo $package_master_data['package_amount']; ?></td>
                  <td class="text-right"><?php if($coupon_per > 0){
                    $coupon_per= str_replace(".00","",$coupon_per);
                    echo  $coupon_per.'%';
                  } else {
                     
                     echo $coupon_amount;
                  } ?></td>
                  <td class="text-right"><?php echo $transection_amount; ?></td>
                  <td><?php echo $payment_mode; ?></td> 
                  <td><?php echo $coupon_name; ?></td> 
                  <td><?php echo $coupon_code; ?></td> 
                  <td data-order="<?php echo date("U",strtotime($transection_date)); ?>"><?php echo date("d-m-Y h:i:s A",strtotime($transection_date));  ?></td>
                  

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


  
 