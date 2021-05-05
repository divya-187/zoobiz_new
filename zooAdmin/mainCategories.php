  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">Business Categories</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Business Categories</li>
         </ol>
         
       </div>
       <div class="col-sm-3">
         <div class="btn-group float-sm-right">
           <a href="categoryWiseUsersReport"   class="btn btn-sm btn-warning waves-effect waves-light">Report</a>
           <a href="javascript:void(0)" onclick="DeleteAllMainCat('deleteCategory');" class="btn  btn-sm btn-danger pull-right"><i class="fa fa-trash-o fa-lg"></i> Delete </a>
          <a href="#" data-toggle="modal" data-target="#addCategory" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Add New </a>
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
            <table id="catTable" class="table table-bordered">
              <thead>
                <tr>
                  <th class="deleteTh">
                    Select
                  </th>
                  <th class="text-right">#</th>
                 <th class="text-right">Members</th>
                  <th>Name</th>
                  <!-- <th>Icon</th>
                  <th>Photo</th> -->
                  
                   <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                  $q=$d->select("business_categories","category_status=0 OR category_status =2","ORDER BY category_name ASC");
                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  <td class='text-center'>
                     <?php 
                   
                   $q3=$d->select("users_master,user_employment_details,business_categories,business_sub_categories"," business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND user_employment_details.business_category_id='$business_category_id' AND users_master.office_member=0 AND users_master.active_status=0","");
                 $totalCategory =  mysqli_num_rows($q3);
                  if ($totalCategory==0) {
                  ?>  
                    <input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $data['business_category_id']; ?>">
                  <?php } else { ?>
                      <input type="checkbox" disabled="">
                  <?php } ?>
                  </td>
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td class='text-center' >
                    <?php 
                    if ($totalCategory==0) {
                      echo "0";
                   } else { ?>

                    <a href="categoryWiseUsersReportDetails?business_category_id=<?php echo $data['business_category_id']; ?>"  target="_blank">
                     <?php
                     echo $totalCategory;?>
                     </a>
                      <?php 
                  } ?>
                  </td>
                  
                  <td><?php echo $category_name; ?></td>
                  <?php /* ?>
                  <td> <?php  if ($menu_icon!='') { ?>
                      <img width="50" height="50" src="../img/category/icon/<?php echo $menu_icon;?>">
                     <?php } ?></td>
                  <td><?php  if ($category_images!='') { ?>
                      <img width="50" height="50" src="../img/category/<?php echo $category_images;?>">
                     <?php } ?></td>
               
                 <?php */ ?> 
                   <td>
                     <a data-toggle="modal" data-target="#editCategory" href="javascript:void();" onclick="editCategory('<?php echo $data['business_category_id']; ?>','<?php echo $data['category_name']; ?>','<?php echo str_replace("'", "\\'",$data['category_images']); ?>','<?php echo $data['menu_icon']; ?>');" class="btn btn-sm btn-primary shadow-primary">Edit</a>

                     <?php 

                       


                        $cnt=$d->select(" business_categories,business_sub_categories "," business_sub_categories.business_category_id = business_categories.business_category_id and    business_categories.category_status = 0  and business_categories.business_category_id='$business_category_id'  group by business_categories.business_category_id   order by business_categories.category_name asc   ");



                 $cnt2 =  mysqli_num_rows($cnt);

                  if ($cnt2 > 0) {?>
                      <form action="manageMainCategory" method="post" style="display: inline-block;">    
                          <input type="hidden" name="business_category_id" value="<?php echo $data['business_category_id']; ?>">    
                          <button type="submit" name="" class="btn btn-primary btn-sm "> Bind Sub Cat</button>
                        </form>
                         
                         <form action="manageMainCategory2" method="post" style="display: inline-block;">    
                          <input type="hidden" name="business_category_id" value="<?php echo $data['business_category_id']; ?>">    
                          <button type="submit" name="" class="btn btn-primary btn-sm "> Bind Cat</button>
                        </form>
                        
                      <?php } ?> 
                 </td>
                

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
                    <label for="input-10" class="col-sm-4 col-form-label">Category Name <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <input required="" type="text" name="category_name"  class="form-control" minlength="3" maxlength="50">
                    </div>
                </div>

<?php /*
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Icon <span class="required">*</span></label>
                    <div class="col-sm-8">
                       

                       <input required="" type="file" name="cat_icon"  class="form-control-file border">


                    </div>
                </div>


                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Image <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <input required="" type="file" name="category_images"  class="form-control-file border">
                    </div>
                </div>
         <?php */ ?> 
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
                    <label for="input-10" class="col-sm-4 col-form-label">Category Name <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <input type="hidden" name="business_category_id" id="local_service_provider_id">
                      <input required="" id="service_provider_category_name" type="text" name="category_name_edit"  class="form-control" minlength="3" maxlength="50">
                    </div>
                </div>

<?php /* ?>
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Icon <span    id="req_icon" style="display: none;" class="required">*</span></label>
                    <div class="col-sm-8">
                       <input required="" type="file" name="cat_icon"  class="form-control-file border">

                      <input required="" type="hidden" name="cat_icon_old"   value="">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Image </label>
                    <div class="col-sm-8">
                      <input type="hidden" name="category_images_old" id="service_provider_category_image">
                      <input  type="file" name="category_images"  class="form-control-file border">
                    </div>
                </div>
         <?php */ ?> 
                <div class="form-footer text-center">
                  <input type="hidden"  name="editCategory" value="editCategory">
                  <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Update</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->

<div id="iconModal" class="modal fade pullDown" role="dialog" id="large">
  <div class="modal-dialog modal-lg" role="document" >

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary white">
      <h4 class="modal-title" id="myModalLabel8">Select Icon</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
        <ul class="list-inline">
          <?php 
          $i=1;
          $q=$d->select("icons","");
          while ($data=mysqli_fetch_array($q)) {
          ?>
          <li title="<?php echo $data['icon_name']; ?>" style="display: inline; font-size: 22px; padding: 10px; cursor: pointer;"  ><i id="<?php echo $data['icon_class']; ?>" onclick="get_class(this);" class="fa <?php echo $data['icon_class']; ?>"></i></li>
          <?php } ?>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    <div id="myform"></div>
  </div>
</div>


<div id="iconModal2" class="modal fade pullDown" role="dialog" id="large">
  <div class="modal-dialog modal-lg" role="document" >

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary white">
      <h4 class="modal-title" id="myModalLabel8">Select Icon</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
        <ul class="list-inline">
          <?php 
          $i=1;
          $q=$d->select("icons","");
          while ($data=mysqli_fetch_array($q)) {
          ?>
          <li title="<?php echo $data['icon_name']; ?>" style="display: inline; font-size: 22px; padding: 10px; cursor: pointer;"  ><i id="<?php echo $data['icon_class']; ?>" onclick="get_class_edit(this);" class="fa <?php echo $data['icon_class']; ?>"></i></li>
          <?php } ?>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    <div id="myform"></div>
  </div>
</div>
<script type="text/javascript">
   function get_class(x) {
   var element = $(x);
   var class_name = element.attr("class");
   document.getElementById('getclass').value=class_name;
   $('#iconModal').modal('toggle');
  }

 function get_class_edit(x) {
   var element = $(x);
   var class_name = element.attr("class");
   document.getElementById('getclassEdit').value=class_name;
   $('#iconModal2').modal('toggle');
  }
 
</script>