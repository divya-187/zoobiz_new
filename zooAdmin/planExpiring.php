<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title">Plan Expiring (2 Months)</h4>
           <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Plan Expiring (2 Months)</li>
         </ol>
       </div>
         
     </div>
   <?php /* ?>
<?php 
 
  $end_date = date('Y-m-d', strtotime("+60 days"));
 
?>


      <form action="" method="get">
      <div class="row pt-2 pb-2">
         
          
          <div class="col-sm-5"  >


        <div class="input-daterange input-group">
                <input readonly="" type="text" class="form-control" autocomplete="off"   placeholder="Start Date" id="FromDate" name="from" value="<?php if ( !isset($_GET['from'])) { echo date('Y-m-01');} else {  echo $_GET['from']; } ?>"  />
                <div class="input-group-prepend">
                 <span class="input-group-text">to</span>
                </div>
                <input readonly="" type="text" class="form-control" autocomplete="off"   placeholder="End Date" id="ToDate" name="toDate" value="<?php if ( !isset($_GET['toDate'])) { echo date('Y-m-t',strtotime($end_date));} else { echo $_GET['toDate'];  } ?>" />
               </div>


        

           
       </div>
        
      

         <div class="col-lg-2 col-3">
            <label  class="form-control-label"> </label>
              <input  class="btn btn-success" type="submit" name="getReport" class="form-control" value="Search">
          </div>
     </div>
   </form>
   <?php */ ?>
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
                 
                  <th>No.</th>
               <th>Name</th>
               <th>Email</th>
               <th>Mobile Number</th>
               <th>PLan Expire Date</th>
               <th>Days Left</th>
                   
                </tr>
              </thead>
              <tbody>
                <?php 
  $difference_days =0 ;
             // $nq=$d->select("users_master","","ORDER BY plan_renewal_date ASC LIMIT 20");

              $today_date = date("Y-m-d");
extract(array_map("test_input" , $_GET));
                

                $where = "";
 

                if(isset($_GET['from']) && isset($_GET['toDate']) ){
                  $from = date('Y-m-d', strtotime($from));
                $toDate = date('Y-m-d', strtotime($toDate));
                $date=date_create($from);
                $dateTo=date_create($toDate);
                $nFrom= date_format($date,"Y-m-d");
                $nTo= date_format($dateTo,"Y-m-d");
                 $where ="  and  users_master.plan_renewal_date  BETWEEN '$nFrom' AND '$nTo'  ";
                } else {
                  $where = " and users_master.plan_renewal_date >= '$today_date' ";
                }

                $nq3=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","  business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id and users_master.user_mobile!='0' AND users_master.active_status=0  $where   ","ORDER BY plan_renewal_date ASC  ");
                  

    
                 while ($newUserData=mysqli_fetch_array($nq3)) {

                $today= date('Y-m-d');
                  if ($today>$newUserData['plan_renewal_date']) {
                      //echo "<p class='text text-danger'>Expire</p>";
                  } else {

 

                         $date11 = new DateTime($today);
                            $date22 = new DateTime($newUserData['plan_renewal_date']);
                            $interval = $date11->diff($date22);
                            $difference_days= $interval->days; 
                  }

                  $difference_days= $d->plan_days_left($newUserData['plan_renewal_date']);
                  
                  if ($difference_days < 61) {
               ?>
               <tr>
                 <td><?php echo $i++; ?></td>
                 <td>
                  
                  <?php if($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2   ){ ?>
                  <a href="viewMember?id=<?php echo $newUserData['user_id']; ?>"><?php echo $newUserData['user_full_name']; ?></a></td>
                  <?php } else { ?> 
                    <a href="memberView?id=<?php echo $newUserData['user_id']; ?>"><?php echo $newUserData['user_full_name']; ?></a>
                   <?php } ?>


                 <td><?php echo $newUserData['user_email']; ?></td>
                 <td><?php echo $newUserData['user_mobile']; ?></td>
                 <td data-order="<?php echo date("U",strtotime($newUserData['plan_renewal_date'])); ?>" ><?php echo $newUserData['plan_renewal_date']; ?></td>
                 <td><?php  
                 if ($today>$newUserData['plan_renewal_date']) {
                      echo "<span class='text text-danger'>Expired</span>  ";
                  } else if($difference_days > -1 ){ 
                           echo  $difference_days. " days ";
                           } 
                          ?>
                 </td>
                 
               </tr>
              <?php } } ?> 
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