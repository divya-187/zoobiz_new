  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">Category Wise Follow </h4>
           <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Category Wise Follow</li>
         </ol>
       </div>
       <div class="col-sm-3">
         <div class="btn-group float-sm-right">
          
          <a class="btn btn-sm btn-secondary" href="categorywiseFollowDetails">View User Details</a>
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
                 
                  <th>Category Name</th>
                  <th class="text-right">Followers</th>
                   <th>View Followers Details</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                  $q=$d->select("business_categories","  category_status=0","ORDER BY category_name ASC");
                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td><?php echo $category_name; ?></td>
                 <td class="text-right">
                   <?php 
                   

                    $q3=$d->select("category_follow_master,users_master,business_categories ","  users_master.user_id = category_follow_master.user_id and     business_categories.business_category_id =category_follow_master.category_id and   category_follow_master.category_id = business_categories.business_category_id and category_follow_master.category_id='$business_category_id' AND users_master.office_member=0 AND users_master.active_status=0    "," ");


                    
                  echo mysqli_num_rows($q3);

                  ?>  
                 </td>
                  <td>
                    <?php if( mysqli_num_rows($q3) > 0 ){?>  
 <form style="display: inline-block;" action="categorywiseFollowDetails" method="get">    
                          <input type="hidden" name="business_category_id" value="<?php echo $business_category_id; ?>">    
                          <button type="submit" name="" class="btn btn-info btn-sm "> View Details</button>
                        </form>          
                        <?php }?>       </td>
                

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