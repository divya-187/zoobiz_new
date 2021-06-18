<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title">Plan Expired</h4>
           <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Plan Expired</li>
         </ol>
       </div>
         
     </div>


     
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


                 $nq=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","  business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id and users_master.user_mobile!='0' AND users_master.active_status=0 and users_master.plan_renewal_date < '$today_date'   ","ORDER BY plan_renewal_date ASC ");
                  


                 while ($newUserData=mysqli_fetch_array($nq)) {

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