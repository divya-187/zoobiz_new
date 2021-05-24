<?php
extract($_REQUEST);
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">
          <?php if(isset($editFrame) && $editFrame=="editFrame" && isset($promotion_rel_frame_id) ){
            echo "Edit Frame";
                } else  {?> Manage Promotion Frames <?php } ?> </h4>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           
           <li class="breadcrumb-item"><a href="promoteBusiness">Seasonal Greetings List</a></li>
            <li class="breadcrumb-item active" aria-current="page">  <?php if(isset($editFrame) && $editFrame=="editFrame" && isset($promotion_rel_frame_id) ){
            echo "Edit Frame";
                } else  {?> Manage Promotion Frames <?php } ?></li>
         </ol>
      </div>
      
      <div class="col-sm-3">
        <div class="btn-group float-right">

          <?php /*if( isset($promotion_id) ) {?>
          <a href="manageFrame?promotion_id=<?php echo $promotion_id;?>" class="btn btn-danger btn-sm waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Back To Frames</a>
            
         
        <?php } else*/ {?>
        
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
                if(isset($editFrame) && $editFrame=="editFrame" && isset($promotion_rel_frame_id) ){
                     $eqm2 = $d->select("promotion_rel_frame_master,promotion_frame_master"," promotion_frame_master.promotion_frame_id =promotion_rel_frame_master.promotion_frame_id AND   promotion_rel_frame_master.promotion_rel_frame_id='$promotion_rel_frame_id' ");

                 
                $promotion_rel_frame_master = mysqli_fetch_assoc($eqm2);
                  ?>
             <fieldset class="scheduler-border">
                <legend  class="scheduler-border">Edit Image</legend>  
                 <div class="row">
                 <div class="col-md-6">

               <form id="frmimgFrm" method="post" action="controller/businessPromotionController.php" enctype="multipart/form-data">
               

                <input type="hidden" name="promotion_rel_frame_id" value="<?php echo $promotion_rel_frame_id; ?>">
                <input type="hidden" name="updateFrmImg" value="updateFrmImg">
                 <input type="hidden" name="promotion_id" value="<?php echo $promotion_rel_frame_master['promotion_id']; ?>">


              <div class="form-group row">
                <label for="promotion_frame" class="col-sm-4 col-form-label">Image </label>
                <div class="col-sm-8">
                  <input id="imgInp" class="form-control-file border"  accept="image/*"   type="file"  name="promotion_frame">

                  <input  class="form-control-file border"    type="hidden"  name="promotion_frame_old" value="<?php   echo $promotion_rel_frame_master['promotion_frame']; ?>">

                </div>
              </div>
               
                 <div class="form-group row" style="display: none;">
               <label class="col-lg-4 col-form-label form-control-label">Text Color </label>
                  <div class="col-lg-8">
               <input type="color" id="text_color" name="text_color" value="<?php if($promotion_rel_frame_id){ echo $promotion_rel_frame_master['text_color']; } ?>"> 
             </div>
           </div>

            <div class="form-group row">
               <label class="col-lg-4 col-form-label form-control-label">frame title</label>
               <div class="col-lg-8">
               <input type="text" class="form-control"   id="frame_title" name="frame_title" value="<?php if($promotion_rel_frame_id){ echo $promotion_rel_frame_master['frame_title']; } ?>"> 
             </div>
           </div>

            
              
              <div class="form-footer text-center">
                <button type="submit" class="btn btn-success" name = "updateFrmImgBtn">Update</button>
               <a href="promoteBusiness" class="btn btn-danger">Cancel</a>
              </div>
            </form>
          </div>
          <div class="col-md-6" style="display: inline-block; float: left">
            
                  <img id="blah" src="../img/promotion/promotion_frames/<?php  echo $promotion_rel_frame_master['promotion_frame']; ?>"   class="lightbox-thumb img-thumbnail"  style="height: 100%;width: 100%;" >

          </div>
        </div>
</fieldset>
<?php

                } else if (isset($promotion_id)) { 
                  ?>
                  <fieldset class="scheduler-border">
                <legend  class="scheduler-border">Frames   </legend>  
              <div class="row">
                <?php
                error_reporting(0);
               
                $promotion_rel_frame_master = $d->select("promotion_frame_master,promotion_rel_frame_master "," promotion_rel_frame_master.promotion_frame_id =promotion_frame_master.promotion_frame_id  and  promotion_rel_frame_master.promotion_id= '$promotion_id'   "," ");
  
                 if(mysqli_num_rows($promotion_rel_frame_master)>0) {
 
                while($promotion_rel_frame_master_data = mysqli_fetch_array($promotion_rel_frame_master)){
              
                   $promotion_id = $promotion_rel_frame_master_data['promotion_id'];

                    $frame_master_qry = $d->select("promotion_master "," promotion_id='$promotion_id' "," ");
                    $frame_master_data = mysqli_fetch_array($frame_master_qry);
                ?>
                <div class="col-md-2 ">
                   
<div class="folder"  >
                     <img src="../img/promotion/promotion_frames/<?php  echo $promotion_rel_frame_master_data['promotion_frame']; ?>" class="lightbox-thumb img-thumbnail"  style="height: 135px;width: 100%;" >


                    <span class="" style="font-weight: bold; color:<?php  echo $promotion_rel_frame_master_data['text_color'];  ?>"> <?php if(trim($promotion_rel_frame_master_data['frame_title']) =="") echo "No Frame Title"; else echo $promotion_rel_frame_master_data['frame_title'];?></span>
                     </div>
 
                      <br> 
                 <?php  if(mysqli_num_rows($promotion_rel_frame_master)>1) { ?>
                  <form style="display: inline-block;"  action="controller/businessPromotionController.php" method="post">
                          <input type="hidden" name="promotion_rel_frame_id" value="<?php echo $promotion_rel_frame_master_data['promotion_rel_frame_id']; ?>">
                          <input type="hidden" name="deleteFrameId" value="deleteFrameId">
                           <input type="hidden" name="promotion_id" value="<?php echo $promotion_rel_frame_master_data['promotion_id']; ?>">

                    <button type="submit" name="deleteFrameIdBtn" class=" form-btn btn btn-danger btn-sm "> <i title="Delete Frame" class="fa fa-trash-o   btn-danger pull-left"  ></i></button>
                  </form>
                <?php } ?> 
                   <form style="display: inline-block;" action="manageFrame" method="post">
                          <input type="hidden" name="promotion_rel_frame_id" value="<?php echo $promotion_rel_frame_master_data['promotion_rel_frame_id']; ?>">
                          <input type="hidden" name="editFrame" value="editFrame">
                    <button type="submit" name="editFrameBtn" value="editFrameBtn" class="btn btn-primary btn-sm "> <i title="Edit Frame" class="fa fa-pencil   btn-primary pull-left"  ></i></button>
                  </form>

                  <?php if(   $promotion_rel_frame_master_data['status']=="0"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $promotion_rel_frame_master_data['promotion_rel_frame_id']; ?>','ProFrmDeactive');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $promotion_rel_frame_master_data['promotion_rel_frame_id'];; ?>','ProFrmActive');" data-size="small"/>
                        <?php } ?>
                  
                  
                </div>
                <?php } 
} else {
  echo "<img width='250' src='img/no_data_found.png'>";
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
    <script src="../zooAdmin/assets/js/jquery.min.js"></script>
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