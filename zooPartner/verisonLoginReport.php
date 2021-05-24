<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title">Version Login Members </h4>
           <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Version Login Members</li>
         </ol>
       </div>
        <div class="col-sm-6">
          <div class="">
            <table class="table table-bordered mTable">
              <tr>
                <th  class="text-center">Android </th>
                <th  class="text-center">Ios </th>
                <th  class="text-center">All Users </th>
              </tr>
              <tr>
                <td class="text-center">
                  <?php 
                  $q1=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","   business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.user_token!='' AND  lower(users_master.device) ='android' and users_master.office_member = 0 AND users_master.active_status=0   order by users_master.last_login desc","");
                  echo mysqli_num_rows($q1);

                  ?>
                </td>
                <td  class="text-center">
                  <?php 
                  $q2=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","    business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.user_token!='' AND  lower(users_master.device) ='ios' and users_master.office_member = 0 AND users_master.active_status=0  order by users_master.last_login desc","");

                   


                  echo mysqli_num_rows($q2);

                  ?>
                </td>
                <td  class="text-center">
                  <?php 

                  $q3=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","    business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.user_token!='' AND users_master.active_status=0   AND    users_master.office_member = 0 order by users_master.last_login desc","");


                  
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
                 
                  <th>Version Code </th>
                  <th>Device</th>
                  <th>Usage Counter( <?php echo date("Y-m-d h:i A");?>) </th>
                   
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;


                 
                  

                  $q4=$d->selectRow("count(*) as counter,version_code,device", "users_master,user_employment_details,business_categories,business_sub_categories","    business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.user_token!='' AND users_master.active_status=0   AND    users_master.office_member = 0  group by version_code,device  order by version_code desc ",""); 


               while ($data=mysqli_fetch_array($q4)) {
                extract($data);
                ?>
                <tr>
                 
                  <td class="text-right"><?php echo $i++; ?></td>
                   
                  <td><?php echo $version_code ; ?></td>
                  <td><?php echo $device; ?></td>
                  <td><?php  echo $counter; ?>  <?php if( $counter > 0 ){?>  
 <form style="display: inline-block;" action="vevrUsageMemberDetails" method="get">    
                          <input type="hidden" name="version_code" value="<?php echo $version_code; ?>">

                                <input type="hidden" name="device" value="<?php echo $device; ?>">
                          <button type="submit" name="" class="btn btn-info btn-sm "> View Details</button>
                        </form>       
                          <?php }?> </td> 
                

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