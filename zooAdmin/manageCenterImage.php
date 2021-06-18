<?php
extract($_REQUEST);
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">
          <?php if(isset($editCenterImage) && $editCenterImage=="editCenterImage" && isset($promotion_rel_center_id) ){
            echo "Edit Center Image";
                } else  {?> Manage Center Image <?php } ?> </h4>

                 <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>

           <li class="breadcrumb-item"><a href="promoteBusiness">Seasonal Greetings List</a></li>
            <li class="breadcrumb-item active" aria-current="page"> <?php if(isset($editCenterImage) && $editCenterImage=="editCenterImage" && isset($promotion_rel_center_id) ){
            echo "Edit Center Image";
                } else  {?> Manage Center Image <?php } ?></li>
         </ol>
        
      </div>
      
      <div class="col-sm-3">
        <div class="btn-group float-right">

          <?php /* if( isset($promotion_id) ) {?>
         
             <a href="manageCenterImage?promotion_id=<?php echo $promotion_id;?>" class="btn btn-danger btn-sm waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Back To Frames</a>
         
        <?php } else*/ 
        {?>
         <a href="promoteBusiness" class="btn btn-danger btn-sm waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Back To Listing</a>
      
          <?php } ?>
        </div>
      </div>
    </div>
    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-12">
       
        <div id="photo_id">
          <div class="card">
            <div class="card-body">
  
             
                <?php
                if(isset($editCenterImage) && $editCenterImage=="editCenterImage" && isset($promotion_rel_center_id) ){
                     $eqm2 = $d->select("promotion_rel_center_master,promotion_center_image_master"," promotion_center_image_master.promotion_center_image_id =promotion_rel_center_master.promotion_center_image_id AND   promotion_rel_center_master.promotion_rel_center_id='$promotion_rel_center_id' ");

                 
                $promotion_rel_center_master = mysqli_fetch_assoc($eqm2);
                  ?>
             <fieldset class="scheduler-border">
                <legend  class="scheduler-border">Edit Center Image</legend>  
                 <div class="row">
                 <div class="col-md-6">

               <form id="frmimgFrm" method="post" action="controller/businessPromotionController.php" enctype="multipart/form-data">
               

                <input type="hidden" name="promotion_rel_center_id" value="<?php echo $promotion_rel_center_id; ?>">
                <input type="hidden" name="EditCenterImage" value="EditCenterImage">
                 <input type="hidden" name="promotion_id" value="<?php echo $promotion_rel_center_master['promotion_id']; ?>">


              <div class="form-group row">
                <label for="promotion_center_image" class="col-sm-4 col-form-label">Image <span class="required">*</span></label>
                <div class="col-sm-8">
                  <input id="imgInp" class="form-control-file border"  accept="image/*"   type="file"  name="promotion_center_image" required="">

                  <input  class="form-control-file border"    type="hidden"  name="promotion_center_image_old" value="<?php   echo $promotion_rel_center_master['promotion_center_image']; ?>">

                </div>
              </div>
               
                  

            

            
              
              <div class="form-footer text-center">
                <button type="submit" class="btn btn-success" name = "updateFrmImgBtn">Update</button>
               <a href="promoteBusiness" class="btn btn-danger">Cancel</a>
              </div>
            </form>
          </div>
          <div class="col-md-6" style="display: inline-block; float: left">
            
                  <img id="blah" src="../img/promotion/promotion_center_image/<?php  echo $promotion_rel_center_master['promotion_center_image']; ?>"   class="lightbox-thumb img-thumbnail"  style="height: 100%;width: 100%;" >

          </div>
        </div>
</fieldset>
<?php

                } else if (isset($promotion_id)) { 
                  ?>
                  <fieldset class="scheduler-border">
                <legend  class="scheduler-border">Center Images   </legend>  
              <div class="row">
                <?php
                error_reporting(0);
               
                $promotion_rel_center_master = $d->select("promotion_center_image_master,promotion_rel_center_master "," promotion_rel_center_master.promotion_center_image_id =promotion_center_image_master.promotion_center_image_id  and  promotion_rel_center_master.promotion_id= '$promotion_id'   "," ");
 
                 if(mysqli_num_rows($promotion_rel_center_master)>0) {
 
                while($promotion_rel_center_master_data = mysqli_fetch_array($promotion_rel_center_master)){
              
                   $promotion_id = $promotion_rel_center_master_data['promotion_id'];

                    $frame_master_qry = $d->select("promotion_master "," promotion_id='$promotion_id' "," ");
                    $frame_master_data = mysqli_fetch_array($frame_master_qry);
                ?>
                <div class="col-md-2 ">
                   
<div class="folder"  >
                     <img src="../img/promotion/promotion_center_image/<?php  echo $promotion_rel_center_master_data['promotion_center_image']; ?>" class="lightbox-thumb img-thumbnail"  style="height: 135px;width: 100%;" >


                    
                     </div>
 
                      <br> 
                 <?php  if(mysqli_num_rows($promotion_rel_center_master)>1) { ?>
                  <form style="display: inline-block;"  action="controller/businessPromotionController.php" method="post">
                          <input type="hidden" name="promotion_rel_center_id" value="<?php echo $promotion_rel_center_master_data['promotion_rel_center_id']; ?>">
                           <input type="hidden" name="deleteCenterImageId" value="deleteCenterImageId">
                           <input type="hidden" name="promotion_id" value="<?php echo $promotion_rel_center_master_data['promotion_id']; ?>">

                    <button type="submit" name="deleteCenterImageIdBtn" class="form-btn btn btn-danger btn-sm "> <i title="Delete Frame" class="fa fa-trash-o   btn-danger pull-left"  ></i></button>
                  </form>
                <?php } ?> 

                   <form style="display: inline-block;" action="manageCenterImage" method="post">
                          <input type="hidden" name="promotion_rel_center_id" value="<?php echo $promotion_rel_center_master_data['promotion_rel_center_id']; ?>">
                          <input type="hidden" name="editCenterImage" value="editCenterImage">
                    <button type="submit" name="editCenterImageBtn" value="editCenterImageBtn" class="btn btn-primary btn-sm "> <i title="Edit Frame" class="fa fa-pencil   btn-primary pull-left"  ></i></button>
                  </form>

                  <?php if(   $promotion_rel_center_master_data['status']=="0"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $promotion_rel_center_master_data['promotion_rel_center_id'];; ?>','CenterImgDeactive');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $promotion_rel_center_master_data['promotion_rel_center_id'];; ?>','CenterImgActive');" data-size="small"/>
                        <?php } ?>
                  
                  
                </div>
                <?php } 
} else {
  echo "<img width='250' src='img/no_data_found3.png'>";
}
?>
 </div>
               
            </fieldset> 
<?php

              } ?>
             
            </div>
          </div>
        </div>
      </div>
      </div><!--End Row-->
      
    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
    <!--Start Back To Top Button-->
    <script src="assets/js/jquery.min.js"></script>
<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#imgInp").change(function() {
    readURL(this);
  });
  
</script>