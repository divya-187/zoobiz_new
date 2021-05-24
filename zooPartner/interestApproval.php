<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">Interest Approval Pending Members</h4>
           <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Interest Approval Pending Members</li>
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
               <th>Interest</th>
                
              </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
              
         
$today_date = date("Y-m-d");

              $nq=$d->select("users_master,user_employment_details,interest_master","  interest_master.added_by_member_id=users_master.user_id and    user_employment_details.user_id=users_master.user_id and users_master.user_mobile!='0' AND users_master.active_status=0 and interest_master.int_status='User Added'   "," group by interest_master.interest_id  ORDER BY interest_master.created_at ASC  ");


              while ($newUserData=mysqli_fetch_array($nq)) { ?>
               <tr>
                 <td><?php echo $i++; ?></td>
                 <td><a href="approveInterest?id=<?php echo $newUserData['user_id']; ?>&interest_id=<?php echo $newUserData['interest_id']; ?>"><?php echo $newUserData['user_full_name']; ?></a></td>
                 <td><?php echo $newUserData['user_email']; ?></td>
                 <td><?php echo $newUserData['user_mobile']; ?></td>
                 <td><?php echo $newUserData['interest_name']; ?></td>
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