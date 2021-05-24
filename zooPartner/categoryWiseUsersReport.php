  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">Categories Wise Users</h4>
            <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Categories Wise Users</li>
         </ol>
       </div>
       <div class="col-sm-3">
         <div class="btn-group float-sm-right">
            <a class="btn btn-sm btn-secondary" href="categoryWiseUsersReportDetails">View User Details</a>

       </div>
     </div>
   </div>

   <form action="" method="get">
      <div class="row pt-2 pb-2">
         <div class="col-sm-4">
            <select type="text"   id="filter_city_id"     class="form-control single-select" name="filter_city_id">


             
                            <option value="">-- Select --</option>
                            <option  <?php if( isset($_GET['filter_city_id']) &&   $_GET['filter_city_id'] == 0 ) { echo 'selected';} ?>  value="0">All</option>
                            <?php $qb=$d->select("cities"," city_flag = 1","");
                            while ($bData=mysqli_fetch_array($qb)) {?>
                              <option <?php if( isset($_GET['filter_city_id']) && $_GET['filter_city_id']== $bData['city_id']) { echo 'selected';} ?> value="<?php echo $bData['city_id']; ?>"><?php echo $bData['city_name']; ?></option>
                            <?php } ?> 
                          </select>
         </div>
         <div class="col-sm-4">
          <div class="">
            <?php //echo "<pre>"; print_r($_GET); echo "</pre>";?>

             <select type="text"   id="filter_business_category_id" 
                 class="form-control single-select" name="filter_business_category_id">


             
                            <option value="">-- Select --</option>
                            <option  <?php if( isset($_GET['filter_business_category_id']) &&   $_GET['filter_business_category_id'] == 0 ) { echo 'selected';} ?>  value="0">All</option>
                            <?php $qb=$d->select("business_categories","(category_status = 0  or category_status = 2) ","");
                            while ($bData=mysqli_fetch_array($qb)) {?>
                              <option <?php if( isset($_GET['filter_business_category_id']) && $_GET['filter_business_category_id']== $bData['business_category_id']) { echo 'selected';} ?> value="<?php echo $bData['business_category_id']; ?>"><?php echo $bData['category_name']; ?></option>
                            <?php } ?> 
                          </select>
          </div>
        </div>
         

         <div class="col-lg-2 col-3">
            <label  class="form-control-label"> </label>
              <input  class="btn btn-success" type="submit" name="getReport" class="form-control" value="Search">
          </div>
     </div>
   </form>
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
                  <th class="text-right">Members</th>
                  <th>View Users Details</th>
                </tr>
              </thead>
              <tbody>
                <?php 

                $where1="";
                  if(isset($_GET['filter_business_category_id']) && $_GET['filter_business_category_id'] !=0 ){
                    $filter_business_category_id = $_GET['filter_business_category_id'];
                    $where1 .=" and  business_categories.business_category_id ='$filter_business_category_id' ";
                  }


                $i=1;
                  $q=$d->select("business_categories","
  (category_status = 0  or category_status = 2)  $where1 ","ORDER BY category_name ASC");
                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td><?php echo $category_name; ?></td>
                 <td class="text-right">
                   <?php 
                   $where12="";
                   if(isset($_GET['filter_city_id']) && $_GET['filter_city_id'] !=0 ){
                    $filter_city_id = $_GET['filter_city_id'];
                    $where12 .=" and  users_master.city_id ='$filter_city_id' ";
                  }
                   $q3=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","    business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND user_employment_details.business_category_id='$business_category_id' AND users_master.office_member=0 AND users_master.active_status=0  $where12 ","");
                  echo mysqli_num_rows($q3);

                  ?>  
                 </td>
                 <td>
   <?php if( mysqli_num_rows($q3) > 0 ){?>  
 <form style="display: inline-block;" action="categoryWiseUsersReportDetails" method="get">   

    <input type="hidden" name="filter_city_id" value="<?php echo $filter_city_id; ?>"> 
                          <input type="hidden" name="business_category_id" value="<?php echo $business_category_id; ?>">    
                          <button type="submit" name="" class="btn btn-info btn-sm "> View Details</button>
                        </form>       
                          <?php }?>              </td>

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


<div class="modal fade" id="replyModal">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Reply Feedback</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="replyFeedbackFrm" action="controller/feedbackController.php" method="post">
          <input type="hidden" id="society_id" name="society_id" value="<?php echo $society_id;?>">
          <input type="hidden" id="feedback_id" name="feedback_id">
          <input type="hidden" id="feedback_email" name="feedback_email">
          
          
          <div class="form-group row">
            <label for="input-10" class="col-sm-4 col-form-label">Reply</label>
            <div class="col-sm-8" id="">
              <textarea maxlength="300" class="form-control" required="" id="reply" name="reply">

              </textarea>
            </div>
          </div>

          
          <div class="form-footer text-center">
            <button type="submit" name="replyFeedback" value="replyFeedback" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Reply</button>
          </div>

        </form>
      </div>
      
    </div>
  </div>
</div><!--End Modal -->


<div class="modal fade" id="addCategory">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Add Category</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="addCategoryForm" action="controller/categoryController.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Category Name *</label>
                    <div class="col-sm-8">
                      <input required="" type="text" name="category_name"  class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Image *</label>
                    <div class="col-sm-8">
                      <input required="" type="file" name="category_images"  class="form-control-file border">
                    </div>
                </div>
         
                <div class="form-footer text-center">
                  <input type="hidden" name="addCategory" value="addCategory">
                  <button type="submit" name="" value="" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Add</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->


<div class="modal fade" id="editCategory">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Edit Category</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="editCatForm" action="controller/categoryController.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Category Name *</label>
                    <div class="col-sm-8">
                      <input type="hidden" name="business_category_id" id="local_service_provider_id">
                      <input required="" id="service_provider_category_name" type="text" name="category_name_edit"  class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Image </label>
                    <div class="col-sm-8">
                      <input type="hidden" name="category_images_old" id="service_provider_category_image">
                      <input  type="file" name="category_images"  class="form-control-file border">
                    </div>
                </div>
         
                <div class="form-footer text-center">
                  <input type="hidden"  name="editCategory" value="editCategory">
                  <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Update</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->