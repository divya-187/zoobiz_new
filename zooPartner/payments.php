
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-6">
        <h4 class="page-title">  Member Transactions </h4>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Member Transactions</li>
         </ol>
      </div>

      <?php 
      //24nov2020
      /* ?>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right">
          <!-- <a href="buyPlan" class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Renew  Plan </a> -->

          
        </div>
      </div>
      <?php */

$where="";
                  if (isset($_GET['mode']) && $_GET['mode']== 1 ) { 
                 extract(array_map("test_input" , $_GET));
                $where .=" and  transection_master.coupon_id  = 0 ";
}  else if (isset($_GET['mode']) && $_GET['mode']== 2 ) { 
                 extract(array_map("test_input" , $_GET));
                $where .=" and  transection_master.coupon_id  != 0 ";
}  
      $qry=$d->select("users_master,transection_master","transection_master.user_id=users_master.user_id AND (transection_master.payment_status='success' OR transection_master.payment_status='SUCCESS' ) $where ","ORDER BY transection_master.transection_id DESC");
                  $total_transaction = 0 ;
                  $total_coupon = 0 ;
                  while($qry_data=mysqli_fetch_array($qry))
                  {
                    if(  $qry_data['coupon_id'] != 0){
                      $total_coupon += $qry_data['transection_amount'];
                      
                    } else {
                      $total_transaction += $qry_data['transection_amount'];
                    }
                    
                  }
       /*            ?> 

      <div class="col-sm-3">
           <?php if($total_transaction>0){ ?> 
           <span class="badge badge-pill badge-success m-1"> <span >Earning <i class="fa fa-inr"></i> <?php echo number_format($total_transaction,2,'.',''); ?> </span > </span > 
          <?php } ?> 
      </div>
       <div class="col-sm-3">
         <?php if($total_coupon>0){ ?>  
          <a href="couponReport"> <span class="badge badge-pill badge-danger m-1"> <span >Coupon <i class="fa fa-inr"></i><?php echo number_format($total_coupon,2,'.',''); ?> </span > </span > </a>
          <?php } ?> 
      </div>
      <?php  */ //24nov2020 ?>

  
    </div>

    <form action="" method="get">
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <select name="mode"  class="form-control single-select">
           <option <?php if ( isset($_REQUEST['mode']) && $_REQUEST['mode']==0   ) { echo 'selected';} ?>  value="0">All</option>
           <option <?php if ( isset($_REQUEST['mode']) && $_REQUEST['mode']==1   ) { echo 'selected';} ?>  value="1">Transaction</option>
           <option <?php if ( isset($_REQUEST['mode']) && $_REQUEST['mode']==2   ) { echo 'selected';} ?> value="2">Coupon</option>
           
        </select>
        </div>

        <div class="col-sm-5"  >


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
                    <th>Company Name</th>
                    <th>Name</th>
                    <th>Package</th>
                    <th>Mode</th>
                    <th class="text-right">Amount</th>
                    <th>Date</th>
                    <th>Txt Id</th>
                    
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ( !isset($_GET['from'])) {
            $_GET['from'] = date('Y-m-01');
            $_GET['toDate'] = date('Y-m-t');
           } 

             extract(array_map("test_input" , $_GET));
                $from = date('Y-m-d', strtotime($from));
                $toDate = date('Y-m-d', strtotime($toDate));
                $date=date_create($from);
                $dateTo=date_create($toDate);
                $nFrom= date_format($date,"Y-m-d");
                $nTo= date_format($dateTo,"Y-m-d");
                 $where = "";


                if(isset($_GET['from']) && isset($_GET['toDate']) ){

                  $nFrom = $nFrom.' 00:00:00';
                  $nTo = $nTo.' 23:59:59';
                  $where =" and  transection_master.transection_date  BETWEEN '$nFrom' AND '$nTo' ";
                }
 

                  $q=$d->select("transection_master,users_master,company_master"," users_master.company_id = company_master.company_id and transection_master.user_id=users_master.user_id AND transection_master.payment_status='success' $where ","ORDER BY transection_master.transection_id DESC");
                  $i = 0;
                  while($row=mysqli_fetch_array($q))
                  {
                    if($_GET['mode']==1 && $row['razorpay_payment_id']=='' ){
                      continue;
                    }

                    if($_GET['mode']==2 && $row['razorpay_payment_id']!='' ){
                      continue;
                    }
                  // extract($row);
                  $i++;
                  
                  ?>
                  <tr>
                    
                    <td class="text-right"><?php echo $i; ?></td>
                     <td> <span title="Company Name"> <?php echo $row['company_name']; ?> </span></td>
                    <?php 
                    $u_id=$row['user_id'];
                    $comp_pr=$d->select(" user_employment_details","user_id='$u_id'");
if(mysqli_num_rows($comp_pr) > 0  ){
                    ?>
                   
                    <td><a href="viewMember?id=<?php echo $row['user_id'];?>"> <?php echo $row['user_full_name']; ?></a></td>
                    <?php }  else {?> 
                     <td> <span title="Profile Not Completed"> <?php echo $row['user_full_name']; ?> </span></td>
                     <?php }?> 
                    <td><?php echo $row['package_name']; ?></td>
                    <td><?php echo $row['payment_mode']; ?></td>
                    <td class="text-right"><?php echo $row['transection_amount']; ?></td>
                    <td data-order="<?php echo date("U",strtotime($row['transection_date'])); ?>" ><?php echo $row['transection_date']; ?></td>
                    <td><?php echo $row['razorpay_payment_id']; ?></td>
                    
                  </tr>
                  <?php }?>
                </tbody>
                
              </div>
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
