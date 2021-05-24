<?php  error_reporting(0);
extract($_REQUEST);
if(isset($business_sub_category_id)){
$business_sub_categories=$d->select("business_sub_categories","  business_sub_category_id= '$business_sub_category_id' ","");
$business_sub_categories_data=mysqli_fetch_array($business_sub_categories);
extract($business_sub_categories_data);
}
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        
        <h4 class="page-title">View Sub Category</h4>
        
        <ol class="breadcrumb">,
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           <li class="breadcrumb-item"><a href="subCategories">Business Sub Categories</a></li>
           
            <li class="breadcrumb-item active" aria-current="page">View Sub Category</li>
         </ol>
      </div>
      
    </div>
    <!-- End Breadcrumb-->
    
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            
            
              <form id="editSubCatFrm" action="controller/categoryController.php" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label"> Category <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <select required="" id="business_category_id" type="text" name="business_category_id"  class="form-control">
                        <option value="">-- Select --</option>
                         <?php $q=$d->select("business_categories","");
                        while($row=mysqli_fetch_array($q)){ ?> 
                        <option <?php if($business_category_id == $row['business_category_id'] ){ echo "selected";} ?> value="<?php echo $row['business_category_id']; ?>"><?php echo $row['category_name']; ?></option>
                        <?php }?>
                      </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Sub Category Name <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <input type="hidden" name="business_sub_category_id" id="business_sub_category_id" value="<?php echo $business_sub_category_id;?>">
                      <input required="" id="service_provider_sub_category_name" type="text" name="sub_category_name"  class="form-control" value="<?php echo $sub_category_name;?>">
                    </div>
                </div>

                <?php /* ?>  
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Image </label>
                    <div class="col-sm-8">
                       <input type="hidden" name="sub_category_images_old" id="service_provider_sub_category_image"  value="<?php echo $sub_category_images;?>">
                      <input  type="file" name="sub_category_images"  class="form-control-file border">

                     <?php if ($sub_category_images!='') { ?>
                    <img width="400" height="400" src="../img/sub_category/<?php echo $sub_category_images;?>">
                     <?php } ?>
                      
                    </div>
                </div> 
               <?php */ ?> 
               <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label"> </label>
                    <div class="col-sm-8">
                       <input type="hidden" name="business_sub_category_id" id="" value="<?php echo $business_sub_category_id;?>">
                        <input type="hidden" name="editSubCategory" value="editSubCategory"> 
                  <button type="submit" name="" value="" class="btn   btn-success"><i class="fa fa-check-square-o"></i> Update</button>
                      <a  href="subCategories" class="btn btn-danger">Back</a>
                      
                    </div>
                </div> 
                

               

          </form> 

              
          </div>
        </div>
      </div>
      </div><!--End Row-->
    </div>
    <!-- End container-fluid-->
    </div><!--End content-wrapper-->