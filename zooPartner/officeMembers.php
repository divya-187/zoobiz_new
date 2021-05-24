<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title">Office Members</h4>
           <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Office Members</li>
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
                 
                  <th class="text-right">#</th>
                 <th>ZOOBIZ ID</th>
                  <th>Name</th>
                   <th>Mobile Number</th>
                    <th>Email</th>
                  <th>Category</th>
                  <th>Sub Category</th>
                   <th>Device</th>
                   <th>Registration Date</th>
                   <!-- <th>View Profile</th> -->
                   
                </tr>
              </thead>
              <tbody>
                <?php 

//24nov2020
$business_categories_qry=$d->select("business_categories"," category_status != 2  ");
     $business_categories_array = array();         
     $business_categories_ids =  array();         
while($business_categories_data=mysqli_fetch_array($business_categories_qry)) {
   $business_categories_array[$business_categories_data['business_category_id']] = $business_categories_data['category_name'];
   $business_categories_ids[]= $business_categories_data['business_category_id'];
}

$business_categories_ids = implode(",", $business_categories_ids);
$business_sub_categories_qry=$d->select("business_sub_categories","   business_category_id in ($business_categories_ids)   ");
     $business_sub_categories_array = array();         
       
while($business_sub_categories_data=mysqli_fetch_array($business_sub_categories_qry)) {
   $business_sub_categories_array[$business_sub_categories_data['business_sub_category_id']] = $business_sub_categories_data['sub_category_name'];
   
}

            $q3=$d->select("users_master,user_employment_details,business_categories,business_sub_categories"," business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.office_member=1 AND users_master.active_status=0  ","");
                  


                $i=1;
               while ($data=mysqli_fetch_array($q3)) {
                extract($data);
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td><?php echo  $zoobiz_id; ?></td>
                   
                  <td><a  target="_blank"  title="View Profile"  href="viewMember?id=<?php echo $user_id; ?>" ><?php echo  $salutation.' '.$user_full_name; ?></a></td>
                  <td><?php echo  $user_mobile; ?></td>
                    <td><?php echo  $user_email; ?></td>
                  <td><?php $cat_array = $business_categories_array[$business_category_id];
                      echo $cat_array; ?></td>
                      <td><?php $sub_cat_array = $business_sub_categories_array[$business_sub_category_id];
                      echo $sub_cat_array; ?></td>
                  <td><?php echo $device; ?></td>
                  <td data-order="<?php echo date("U",strtotime($register_date)); ?>" ><?php echo date("d-m-Y", strtotime($register_date)); ?></td>
                 
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