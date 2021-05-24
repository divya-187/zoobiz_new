  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-6">
          <h4 class="page-title">Users Details</h4>
         
       </div>
       <div class="col-sm-6">
         
            

      
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
                   <th>Version Code</th>
                  <th>User Name</th>
                  <th>Mobile Number</th>
                 <th>Device</th>
                 <th>Last App Usage </th>
                   <!-- <th>User Profile</th> -->
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                extract($_REQUEST);
 
                if( isset($_REQUEST['version_code']) ||  $_REQUEST['version_code'] !=""   &&  isset($_REQUEST['device']) ||  $_REQUEST['device'] !="" ){

                     

                $q=$d->select(  "users_master,user_employment_details,business_categories,business_sub_categories","    business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.user_token!='' AND users_master.version_code ='$version_code' and  lower(users_master.device) = '$device' and    users_master.active_status=0   AND    users_master.office_member = 0  group by users_master.user_id    order by version_code desc ",""); 

                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                
                  
                   <td><?php echo $version_code; ?></td> 
                   <td><a target="_blank"   title="View Profile"  href="viewMember?id=<?php echo $user_id; ?>" ><?php echo $user_full_name; ?></a></td>
               
                 <td> <?php echo $user_mobile; ?> </td>
                  <td> <?php echo $device; ?> </td>
                  <td> <?php echo date("d-m-Y h:i A", strtotime($last_login)); ?> </td> 
               </tr>

             <?php }
               }   ?> 
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