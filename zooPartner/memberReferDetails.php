<?php 
error_reporting(0);
extract($_REQUEST);
 ?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
 

<h4 class="page-title">Referral  Details</h4>

  
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
           
       
        
         
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
                 
                  <th>#</th>
                 
                  <th>Company Name</th>
                  <th>User Name</th>
                   
                  <th>User Mobile</th>
                   <th>refer by</th>
                   <th>Refer Person Name</th>
                   <th>Refer Person Phone No.</th>
                    <th>ReMark</th>
                   <th>Date</th>
                   <th>View Profile</th>
                     
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                $where ="";
     $where .=" and  users_master.refere_by_phone_number  = '$user_mobile' ";
                 
               
                $q6=$d->select("company_master,users_master","company_master.company_id =  users_master.company_id  and    users_master.active_status= 0  and users_master.refer_by!= 0 AND users_master.active_status=0  $where  ","");

                $user_id_array = array('0');
                 while ($data3=mysqli_fetch_array($q6)) {
                  $user_id_array[] = $data3['user_id'];
                 }
                  $user_id_array = implode(",", $user_id_array);
 
                 $q3= $d->select("company_master,users_master","company_master.company_id =  users_master.company_id  and    users_master.active_status= 0  and users_master.refer_by!= 0 AND users_master.active_status=0   $where  ","");
 
                 $user_employment_details=$d->select("users_master,user_employment_details ","   user_employment_details.user_id=users_master.user_id and users_master.user_id in ($user_id_array) AND users_master.active_status=0  ","");
 
                 $user_employment_details_array = array();
                 while ($user_employment_details_data=mysqli_fetch_array($user_employment_details)) {
                  $user_employment_details_array[$user_employment_details_data['user_id']] = $user_employment_details_data;
                 }


                  
               while ($data=mysqli_fetch_array($q3)) {
                extract($data);
               
 
              
                 
                ?>
                <tr>
                  
                  <td><?php echo $i++; ?></td>
                   
                  <td><?php  echo $company_name; ?></td>
                  <td><?php echo  $salutation.' '.$user_full_name; ?></td>
                  
                  <td><?php echo $user_mobile; ?></td>

                  <td><?php if($refer_by=="1") {echo "Social Media";} 
                  else if($refer_by=="2") {echo "Member / Friend";}
                  else if($refer_by=="3") {echo "Other";}
                   ?></td>
                  <td><?php echo wordwrap($refere_by_name,20,"<br>\n"); ?></td>
                  <td><?php echo  $refere_by_phone_number ; ?></td> 
                  <td><?php echo wordwrap($remark,20,"<br>\n"); ?></td> 
                  <td><?php echo date("d-m-Y h:i:s A",strtotime($register_date));  ?></td>
                  <td>
                    <?php 
                    $isProfileComplete = $user_employment_details_array[$user_id];
                   if(!empty($isProfileComplete)) {?> 
                      <form action="viewMember" method="get">    
                          <input type="hidden" name="id" value="<?php echo $user_id; ?>">    
                          <button type="submit" name="" class="btn btn-secondary btn-sm "> View Profile</button>
                        </form>
                      <?php }  else {?>
                        <button type="button"  disabled="" class="btn btn-danger btn-sm ">Profile Incomplete</button>
                       <?php } ?> 
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


  
 