<?php 
error_reporting(0);
extract($_REQUEST);
$users_master=$d->selectRow("user_full_name","users_master"," user_id='$user_id'");
$users_master_data=mysqli_fetch_array($users_master);

?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <h4 class="page-title">Followers Of <?php echo $users_master_data['user_full_name'];?></h4>
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

                <th>Business Name</th>
                <th>User Name</th>
                <th>User Mobile</th>

                <th>Date</th>


              </tr>
            </thead>
            <tbody>
              <?php 
              $i=1;
             $tq33=$d->select("users_master,user_employment_details,business_categories,business_sub_categories,follow_master","business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_by=users_master.user_id AND follow_master.follow_to='$user_id'","ORDER BY users_master.user_full_name ASC");
             while ($data=mysqli_fetch_array($tq33)) {
              extract($data);
             ?>
              <tr>
               <td><?php echo $i++; ?></td>
               <td><?php  echo $company_name; ?></td>
               <td><a href="viewMember?id=<?php echo $user_id; ?>"><?php echo  $user_full_name; ?></a> </td>
               <td><?php echo $user_mobile; ?></td>
               <td data-order="<?php echo date("U",strtotime($created_at)); ?>" ><?php if($created_at =='0000-00-00 00:00:00') { echo "N/A";} else {  echo date("d-m-Y h:i:s A",strtotime($created_at)); }  ?></td>
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



