  <?php 
  if (isset($_GET['notLogin'])) {  ?>
 
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title">App Not Login Members</h4>
           <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">App Not Login Members</li>
         </ol>
           <a class="btn btn-sm btn-secondary" href="loginUsersReport"> View Login Users</a>
       </div>
        <div class="col-sm-6">
          <div class="">
            <table class="table table-bordered mTable">
              <tr>
                <th  class="text-center">Android </th>
                <th  class="text-center">Ios </th>
                <th  class="text-center">Never Login Users </th>
                <th  class="text-center">Total Users </th>
              </tr>
              <tr>
                <td class="text-center">
                  <?php 
                  $q1=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","     business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.user_token='' AND  lower(users_master.device) ='android' and users_master.office_member = 0 AND users_master.active_status=0 order by users_master.last_login  desc","");
                  echo mysqli_num_rows($q1);

                  ?>
                </td>
                <td  class="text-center">
                  <?php 
                  $q2=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","     business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.user_token='' AND  lower(users_master.device) ='ios' and users_master.office_member = 0 AND users_master.active_status=0  order by users_master.last_login desc","");
                  echo mysqli_num_rows($q2);

                  ?>
                </td>
                <td  class="text-center">
                  <?php 
                  $q3=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","    business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.user_token='' AND  lower(users_master.device) ='' and users_master.office_member = 0 AND users_master.active_status=0  order by users_master.last_login desc","");
                  echo //(mysqli_num_rows($q1) + mysqli_num_rows($q2)); 
                     mysqli_num_rows($q3);
                  ?>
                </td>
                <td  class="text-center">
                  <?php 
                  $q3=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","    business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.user_token='' and users_master.office_member = 0 AND users_master.active_status=0  order by users_master.last_login desc","");
                  echo //(mysqli_num_rows($q1) + mysqli_num_rows($q2)); 
                     mysqli_num_rows($q3);
                  ?>
                </td>
              </tr>
            </table>
          </div>
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
                 
                  <th class="text-right">#</th>
                 
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Company</th>
                   <th>Device</th>
                     
                  <!--  <th>Action</th> -->
                    <th>Last Login Time</th>
                    
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
               while ($data=mysqli_fetch_array($q3)) {
                extract($data);
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
                   <td data-order="<?php echo date("U",strtotime($last_login)); ?>" ><?php if ($last_login!='0000-00-00 00:00:00') {
                      echo date("d M Y h:i A", strtotime($last_login)); 
                    } ?></td>
                 
                  <!--  <td>
                    <form action="viewMember" method="get">    
                          <input type="hidden" name="id" value="<?php echo $user_id; ?>">    
                          <button type="submit" name="" class="btn btn-danger btn-sm "> View Profile</button>
                        </form>
                    </div>
                 </td> -->
                  

                

               </tr>

             <?php } ?> 
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

 <?php } else { ?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title">App Login Members</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">App Login Members</li>
         </ol>
          <a class="btn btn-sm btn-secondary" href="loginUsersReport?notLogin=notLogin"> View Not Login Users</a>
       </div>
        <div class="col-sm-6">
          <div class="">
            <table class="table table-bordered mTable">
              <tr>
                <th  class="text-center">Android </th>
                <th  class="text-center">Ios </th>
                <th  class="text-center">Never Login Users </th>
                <th  class="text-center">All Users </th>
              </tr>
              <tr>
                <td class="text-center">
                  <?php 
                  $q1=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","   business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.user_token!='' AND  users_master.device='android' and users_master.office_member = 0 AND users_master.active_status=0  order by users_master.last_login desc","");
                  echo mysqli_num_rows($q1);

                  ?>
                </td>
                <td  class="text-center">
                  <?php 
                  $q2=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","    business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.user_token!='' AND  users_master.device='ios' and users_master.office_member = 0 AND users_master.active_status=0  order by users_master.last_login desc","");
                  echo mysqli_num_rows($q2);

                  ?>
                </td>
                <td  class="text-center">
                  <?php 
                  $q2=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","    business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.user_token!='' AND  users_master.device='' and users_master.office_member = 0 AND users_master.active_status=0  order by users_master.last_login desc","");
                  echo mysqli_num_rows($q2);

                  ?>
                </td>
                <td  class="text-center">
                  <?php 
                  $q3=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","    business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.user_token!='' and users_master.office_member = 0 AND users_master.active_status=0  order by users_master.last_login desc","");
                  echo mysqli_num_rows($q3);
                  ?>
                </td>
              </tr>
            </table>
          </div>
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
                 
                  <th class="text-right">#</th>
                 
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Company</th>
                   <th>Device</th>
                     <th>Last Login Time</th>
                  <!--  <th>Action</th> -->
                  
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
               while ($data=mysqli_fetch_array($q3)) {
                extract($data);
                ?>
                <tr>
                  <!-- <td class='text-center'>
                    <input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $data['feedback_id']; ?>">
                  </td> -->
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td><a target="_blank"  title="View Profile"  href="viewMember?id=<?php echo $user_id; ?>" ><?php echo  $salutation.' '.$user_full_name; ?></a></td>
                  <td><?php echo $user_email ; ?></td>
                  <td><?php echo $user_mobile; ?></td>
                  <td><?php  echo $company_name;
                   ?></td>
                  <td><?php echo $device; ?></td>
                   <td data-order="<?php echo date("U",strtotime($last_login)); ?>" ><?php if ($last_login!='0000-00-00 00:00:00') {
                      echo date("d M Y h:i A", strtotime($last_login)); 
                    } ?></td>
                   <!-- <td>
                    <form action="viewMember" method="get">    
                          <input type="hidden" name="id" value="<?php echo $user_id; ?>">    
                          <button type="submit" name="" class="btn btn-danger btn-sm "> View Profile</button>
                        </form>
                    </div>
                 </td> -->
                  

                

               </tr>

             <?php } ?> 
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


<?php } ?>