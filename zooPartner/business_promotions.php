<?php
extract($_REQUEST);
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-6">
        <h4 class="page-title">View</h4>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           
           <li class="breadcrumb-item"><a href="promoteBusiness">Seasonal Greetings List</a></li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
         </ol>
      </div>
      
      <div class="col-sm-6">
        <div class="btn-group float-right">

          <?php if( isset($promotion_id) ) {?>
           
             <a href="promoteBusiness" class="btn btn-danger btn-sm waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Back To Folder</a>
         
        <?php }   ?>
        </div>
      </div>
    </div>
    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-12">
       
        <div id="photo_id">
          <div class="card">
            <div class="card-body">
 <?php if( isset($promotion_id)   ) {

  ?>
 <fieldset class="scheduler-border">
                <legend  class="scheduler-border"> Image Frame Combination View</legend>  
                 <div class="row">
                   
         
            <?php 
              $promotion_master=$d->select("promotion_master","   status = 0 and promotion_id ='$promotion_id'   ","");
if(mysqli_num_rows($promotion_master)  > 0    ){
}
 

 $promotion_rel_frame_master=$d->select("promotion_rel_frame_master,promotion_frame_master ","  promotion_frame_master.promotion_frame_id = promotion_rel_frame_master.promotion_frame_id and    promotion_rel_frame_master.promotion_id ='$promotion_id' and   
   promotion_rel_frame_master.status = 0   ","");
 if(mysqli_num_rows($promotion_rel_frame_master)  > 0    ){
     while ($promotion_rel_frame_master_data = mysqli_fetch_array($promotion_rel_frame_master)) {

 

        $promotion_rel_center_master=$d->select("promotion_rel_center_master,promotion_center_image_master ","  promotion_center_image_master.promotion_center_image_id = promotion_rel_center_master.promotion_center_image_id and    promotion_rel_center_master.promotion_id ='$promotion_id' and  promotion_rel_center_master.status = 0   ","");
 
  if(mysqli_num_rows($promotion_rel_center_master)  > 0    ){
    //$response["centerImageDetails"] = array();
    while ($promotion_rel_center_master_data = mysqli_fetch_array($promotion_rel_center_master)) {

       ?>
       <div class="col-md-4" style="clear: both;padding: 3px !important;">

                <img src="../img/promotion/promotion_frames/<?php  echo $promotion_rel_frame_master_data['promotion_frame']; ?>" id="blah" alt="" class="lightbox-thumb  img-thumbnail " style=" width: 100%; height: 100%; position: relative;
      top: 0;
      left: 0; padding:5px !important;"  >
                   
                     <img id="blah2" src="../img/promotion/promotion_center_image/<?php  echo $promotion_rel_center_master_data['promotion_center_image']; ?>" alt="" class="lightbox-thumb  " style="width: 70%; height: 70%;   position: absolute;
      top: 60px;bottom: 60px;
      left: 50px;right: 50px; margin: 0 auto;.">
    </div>

      <?php 

    }
  }

    }
  }

               ?>


               

          
</fieldset>
 <?php } 
 

   if (isset($promotion_id) && isset($outlook_id) && $viewDetail =="true" && 0) { 
                  
                
                 ?>
              <div class="col-md-3">  </div>
                <div class="col-md-3"></div>
                <div class="col-md-3">
                 
                </div>
                <div class="col-md-3"></div>

 <?php   } ?>
              

           
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

  function readURL2(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#blah2').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#imgInp").change(function() {
    readURL(this);
  });
  $("#imgInp2").change(function() {
    readURL2(this);
  });
</script>
