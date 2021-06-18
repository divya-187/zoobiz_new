<?php  error_reporting(0);
extract($_REQUEST);
if(isset($frame_id)){
$frame_master=$d->select("frame_master","  frame_id = '$frame_id' ","");
$frame_master_data=mysqli_fetch_array($frame_master);
extract($frame_master_data);
}
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <?php if(isset($frame_id)){?>
        <h4 class="page-title">Edit Frame</h4>
        <?php  } else {?>
        <h4 class="page-title">Add Frame</h4>
        <?php } ?>
        
      </div>
      
    </div>
    <!-- End Breadcrumb-->
   
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
           
            <form id="FrameFrm" action="controller/frameController.php" method="post" enctype="multipart/form-data">
              
              
                <div class="form-group row">
                  
                  <label class="col-lg-2 col-form-label form-control-label">Frame Name <span class="required">*</span></label>
                  <div class="col-lg-4">
                    <input  required="" type="text" class="form-control  " name="frame_name" id="frame_name" value="<?php if(isset($frame_id)){  echo $frame_name;} ?>" placeholder="Frame Name" minlength="5" maxlength="50"  >
                    
                  </div>
                  
                    <label class="col-lg-2 col-form-label form-control-label">Layout Name <span class="required">*</span></label>
                  <div class="col-lg-4">
                    <input  required="" type="text" class="form-control  " name="layout_name" id="layout_name" value="<?php if(isset($frame_id)){  echo $layout_name;} ?>" placeholder="Layout Name" minlength="5" maxlength="50"  >
                    
                  </div>
                </div>

                 <div class="form-group row">
               
                  <?php if(isset($frame_id)){ ?> 
                     <label for="banner_image" class="col-sm-2 col-form-label">Frame Image </label>
                <div class="col-sm-10">
                  <input class="form-control-file border"  multiple accept="image/*"   type="file"  name="frame_image_edit">
                     <input type="hidden" name="frame_image_old" value="<?php echo $frame_image;?>">
                  <?php }  else {?>
                     <label for="banner_image" class="col-sm-2 col-form-label">Frame Image <span class="required">*</span></label>
                <div class="col-sm-10">
                  <input class="form-control-file border"  multiple accept="image/*" required="" type="file"  name="frame_image">
                  <?php } ?>
                </div>
              </div>
                
                
              
               
              <div class="form-footer text-center">
                
                <?php  if(isset($frame_id)){ ?>
                <input type="hidden" name="frame_id" value="<?php echo $frame_id;?>">
                <button type="submit" name="frameEditBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> UPDATE</button>
                <?php  } else {?>
                <button type="submit" name="frameAddBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                <?php }?> 
                <a href="frameList" class="btn btn-danger">Cancel</a>
                
              </div>
            </form>
          </div>
        </div>
      </div>
      </div><!--End Row-->
    </div>
    <!-- End container-fluid-->
    </div><!--End content-wrapper-->