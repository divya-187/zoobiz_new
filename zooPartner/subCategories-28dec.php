  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">Business Sub Categories</h4>
         
       </div>
       <div class="col-sm-3">
         <div class="btn-group float-sm-right">
           <a href="javascript:void(0)" onclick="DeleteAll('deleteSubCategory');" class="btn  btn-sm btn-danger pull-right"><i class="fa fa-trash-o fa-lg"></i> Delete </a>
          <a href="#" data-toggle="modal" data-target="#addCategory" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Add New </a>
          

       </div>
     </div>
   </div>
   <?php //12nov ?>
       <form action="" method="get">
       <div class="row pt-2 pb-2">
       
     
    
      <div class="col-sm-4">
          <div class="">
            <?php //echo "<pre>"; print_r($_GET); echo "</pre>";?>


            <select type="text" required="" id="filter_business_category_id"  class="form-control single-select" name="filter_business_category_id">


            
                          
                            <option  <?php if( isset($_GET['filter_business_category_id']) &&   $_GET['filter_business_category_id'] == 0 ) { echo 'selected';} ?>  value="0">All</option>
                            <?php $qb=$d->select("business_categories"," (category_status = 0 OR category_status = 2) ","");
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
  
 <?php //12nov ?>
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
                  <th class="deleteTh">
                    <input type="checkbox" class="selectAll" label="check all"  />
                  </th>
                  <th class="text-right">#</th>
                  <th>Name</th>
                  <th>Main Category</th>
                  <th>Related Category</th>
                  <th>Photo</th>
                   <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;


             $business_sub_ctagory_relation_master=$d->select("business_sub_categories,business_sub_ctagory_relation_master","business_sub_categories.business_sub_category_id=business_sub_ctagory_relation_master.related_sub_category_id");
              $data_array = array('0');
              while ($business_sub_ctagory_relation_master_data=mysqli_fetch_array($business_sub_ctagory_relation_master)) {
              $data_array[$business_sub_ctagory_relation_master_data['business_sub_category_id']][] = $business_sub_ctagory_relation_master_data['sub_category_name'];
              }

  //12nov2020
                $where = "";
                if(isset($_GET['filter_business_category_id']) && $_GET['filter_business_category_id']!="0"){
                  $filter_business_category_id = $_GET['filter_business_category_id'];
                  $where = " and  business_sub_categories.business_category_id = '$filter_business_category_id' ";
                }
                //12nov2020

//3dec code opt
 $qh=$d->select("business_sub_categories,business_categories","business_sub_categories.business_category_id=business_categories.business_category_id AND ( business_sub_categories.sub_category_status=0 OR business_sub_categories.sub_category_status=2 )  $where ","ORDER BY business_categories.category_name ASC");
                  
  $array = array('0');
   while ($data2=mysqli_fetch_array($qh)) {
    $array[] = $data2['business_sub_category_id'];
   }
$array = implode(",", $array);
$qdata_qry=$d->select("users_master,user_employment_details,business_categories,business_sub_categories"," business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND user_employment_details.business_sub_category_id in ($array) ","");

$count_array = array('0');
while ($qdata_data=mysqli_fetch_array($qdata_qry)) {
$count_array[$qdata_data['business_sub_category_id']][] = $qdata_data['business_sub_category_id'];
}
 

                    



                   $q=$d->select("business_sub_categories,business_categories","business_sub_categories.business_category_id=business_categories.business_category_id AND ( business_sub_categories.sub_category_status=0 OR business_sub_categories.sub_category_status=2 )  $where ","ORDER BY business_categories.category_name ASC");
                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  <td class='text-center'>
                    <?php /*$q3=$d->select("users_master,user_employment_details,business_categories,business_sub_categories"," business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND user_employment_details.business_sub_category_id='$business_sub_category_id'","");*/
                    $arr_new =array('0'); 
                    if(!empty($count_array[$business_sub_category_id])){
                      $arr_new = $count_array[$business_sub_category_id];
                    }
                    $totalSubCategory = count($arr_new);//  mysqli_num_rows($q3);


                  if ($totalSubCategory==0) {
                  ?>
                    <input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $data['business_sub_category_id']; ?>">
                  <?php  }?>
                  </td>
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td><?php echo $sub_category_name; ?></td>
                  <td><?php echo $category_name; ?></td>
                  <td> <?php 
                  if(!empty($data_array[$business_sub_category_id])){ 
                  $relation_array = $data_array[$business_sub_category_id];
                  $arr = array();
                  for ($h=0; $h <count($relation_array) ; $h++) { 
                    $arr[]= $relation_array[$h];
                  }
                  $arr = implode(",", $arr);

                 // echo $arr;

                  if(strlen($arr) > 20) {
                          $data = substr($arr, 0, 20);
                          echo $data; 
                          ?>
                          <button class="btn btn-warning btn-sm"  data-toggle="collapse" data-target="#demo<?php echo $h;?>"><i class="fa fa-eye"></i></button>
                              <div id="demo<?php echo $h;?>" class="collapse">
                            <?php    echo  wordwrap($arr,30,"<br>\n") ;?>
                            </div>
                            <?php
                         } else {
                          echo wordwrap($arr,30,"<br>\n");
                         }


                } else {
                  echo "-";
                }
                   ?></td>
                  <td><?php  if ($sub_category_images!='') { ?>
                    <img width="50" height="50" src="../img/sub_category/<?php echo $sub_category_images;?>">
                     <?php } ?></td>
                 <td>
                    <a data-toggle="modal" data-target="#editCategory" href="javascript:void();" onclick="editSubCategory('<?php echo $data['business_category_id']; ?>','<?php echo $business_sub_category_id; ?>','<?php echo $data['sub_category_name']; ?>','<?php echo $data['sub_category_images']; ?>');" class="btn btn-sm btn-primary shadow-primary">Edit</a>

                    <form action="manageSubCategory" method="post" style="display: inline-block;">    
                          <input type="hidden" name="business_sub_category_id" value="<?php echo $business_sub_category_id; ?>">    
                          <button type="submit" name="" class="btn btn-primary btn-sm "> Manage</button>
                        </form>


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


<div class="modal fade" id="addCategory">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Add Sub Category</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="addSubCat" action="controller/categoryController.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label"> Category <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <select required="" type="text" name="business_category_id"  class="single-select form-control">
                        <option value="">-- Select --</option>
                         <?php $q=$d->select("business_categories","");
                        while($row=mysqli_fetch_array($q)){ ?> 
                        <option value="<?php echo $row['business_category_id']; ?>"><?php echo $row['category_name']; ?></option>
                        <?php }?>
                      </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Sub Category Name <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <input required="" type="text" name="sub_category_name"  class="form-control text-capitalize">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Image <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <input required="" type="file" name="sub_category_images"  class="form-control-file border">
                    </div>
                </div>
         
                <div class="form-footer text-center">
                  <input type="hidden" name="addSubCategory" value="addSubCategory">
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
        <h5 class="modal-title text-white">Edit Sub Category</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="editSubCatFrm" action="controller/categoryController.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label"> Category <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <select required="" id="business_category_id" type="text" name="business_category_id"  class="form-control">
                        <option value="">-- Select --</option>
                         <?php $q=$d->select("business_categories","");
                        while($row=mysqli_fetch_array($q)){ ?> 
                        <option value="<?php echo $row['business_category_id']; ?>"><?php echo $row['category_name']; ?></option>
                        <?php }?>
                      </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Sub Category Name <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <input type="hidden" name="business_sub_category_id" id="local_service_provider_sub_id">
                      <input required="" id="service_provider_sub_category_name" type="text" name="sub_category_name"  class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Image </label>
                    <div class="col-sm-8">
                      <input type="hidden" name="sub_category_images_old" id="service_provider_sub_category_image">
                      <input  type="file" name="sub_category_images"  class="form-control-file border">
                    </div>
                </div>
         
                <div class="form-footer text-center">
                  <input type="hidden" name="editSubCategory" value="editSubCategory"> 
                  <button type="submit" name="" value="" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Update</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->


<div class="modal fade" id="bulkUpload">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Import Bulk Users</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="controller/countryController.php" method="post" enctype="multipart/form-data">
            
               <div class="form-group row">
                    <label class="col-sm-12 col-form-label">Step 1 -> DOWNLOAD FORMATTED CSV  <button type="submit" name="ExportArea" value="ExportArea" class="btn btn-sm btn-primary"><i class="fa fa-check-square-o"></i> Download</button></label>
                    <label class="col-sm-12 col-form-label">Step 2 -> FILL Category DATA</label>
                    <label class="col-sm-12 col-form-label">Step 3 -> Import This File Here</label>
                    <label class="col-sm-12 col-form-label">Step 4 -> Click on Upload Button</label>
                    <label class="col-sm-12 col-form-label text-danger">Note: Import Only Selected City Areas</label>

              </div> 
             
          </form> 
            <form id="importValidation" action="controller/countryController.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Import CSV File *</label>
                    <div class="col-sm-8" id="PaybleAmount">
                      <input required="" type="file" name="file"  accept=".csv" class="form-control-file border">
                    </div>
                </div>
         
                <div class="form-footer text-center">
                  <button type="submit" name="importArea" value="importArea" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Upload</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->