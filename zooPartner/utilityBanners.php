<?php
extract($_REQUEST);
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-6">
        <h4 class="page-title">Utility Banners</h4>
        
      </div>
      
      <div class="col-sm-6">
        <div class="btn-group float-right">

          <?php if( isset($frame_id) ) {?>
           
             <a href="utilityBanners" class="btn btn-danger btn-sm waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Back To Folder</a>
         
        <?php } else {?>
         <a href="addUtiBanner" class="btn btn-primary btn-sm waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Add New Banner</a>
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
 <?php if( isset($frame_id) ) {?>
 <fieldset class="scheduler-border">
                <legend  class="scheduler-border"> Add New Images</legend>  
                 <div class="row">
                 <div class="col-md-6">
               <form id="utilityFrm" method="post" action="controller/utilityBannerController.php" enctype="multipart/form-data">
              

              <div class="form-group row">
                <label for="input-12" class="col-sm-4 col-form-label">Frame <span class="required">*</span></label>
                <div class="col-sm-8">

                   <select type="text"      class="form-control single-select" id="frame_id" name="frame_id">
                     <option value="">-- Select --</option>
                        <?php
                           $q31=$d->select("frame_master","status=0 and frame_id ='$frame_id'","ORDER BY frame_name ASC");
                          while ($blockRow11=mysqli_fetch_array($q31)) {
                           ?>
                           <option <?php if( isset($frame_id) && $frame_id==$blockRow11['frame_id']) {echo "selected";} ?> value="<?php echo $blockRow11['frame_id'];?>"><?php echo $blockRow11['frame_name'];?></option>
                          <?php }  ?>
                      </select>


               
                </div>
              </div>


              <div class="form-group row">
                <label for="banner_image" class="col-sm-4 col-form-label">Banner Image <span class="required">*</span></label>
                <div class="col-sm-8">
                  <input class="form-control-file border"  multiple accept="image/*" required="" type="file"  name="banner_image[]">
                </div>
              </div>
               
               

              

              
              <div class="form-footer text-center">
                <button type="submit" class="btn btn-success" name = "addPerUtilityBannerImage"><i class="fa fa-check-square-o"></i> SAVE</button>
               <a href="utilityBanners" class="btn btn-danger">Cancel</a>
              </div>
            </form>
          </div>
          <div class="col-md-6" style="display: inline-block; float: left">
            <?php 
             $eqm2 = $d->select("frame_master","frame_id='$frame_id' ");

                 
                $frame_master_data2 = mysqli_fetch_assoc($eqm2);
                ?>
                  <img src="../img/frames/<?php  echo $frame_master_data2['frame_image']; ?>" alt="<?php echo $frame_name; ?>" class="lightbox-thumb img-thumbnail"  style="height: 100%;width: 100%;" >

          </div>
        </div>
</fieldset>
 <?php } ?>
             <fieldset class="scheduler-border">
                <legend  class="scheduler-border">  <?php if( isset($frame_id) ) {
                   
                $eqm = $d->select("frame_master","frame_id='$frame_id' ");

                 
                $frame_master_data = mysqli_fetch_assoc($eqm);
                echo  $frame_master_data['frame_name'];
                ?>'s Images <?php } else { echo "Frames";} ?> </legend>  
              <div class="row">
                <?php
                if (!isset($frame_id)) {
                error_reporting(0);
                /*$q = $d->select("utility_banner_master, frame_master"," utility_banner_master.frame_id =frame_master.frame_id and  utility_banner_master.active_status != 2 ","GROUP BY utility_banner_master.frame_id");*/
                $q = $d->select("frame_master "," status = 0  ","GROUP BY  frame_id");

                 if(mysqli_num_rows($q)>0) {

                while($data = mysqli_fetch_array($q)){
              
                   $frame_id = $data['frame_id'];

                    $frame_master_qry = $d->select("frame_master "," frame_id='$frame_id' "," ");
                    $frame_master_data = mysqli_fetch_array($frame_master_qry);
                ?>
                <div class="col-md-2 col-6">
                  <a href="utilityBanners?frame_id=<?php echo $data['frame_id'] ?>&viewDetail=true">
<div class="folder"  >
                     <img src="../img/frames/<?php  echo $data['frame_image']; ?>" alt="<?php echo $frame_name; ?>" class="lightbox-thumb img-thumbnail"  style="height: 135px;width: 100%;" >
                     <?php echo custom_echo($frame_master_data['frame_name'],8); ?> (<?php 

                      $totalImages = $d->count_data_direct("frame_id","utility_banner_master","frame_id='$frame_id' ");
                      echo $totalImages; ?>)
</div>

                  
                  </a>
                  <br>
                  <?php  if ($totalImages > 0){ ?> 
                   <i title="Delete Gallary Folder" class="fa fa-trash-o btn-sm btn-danger pull-left" onclick="DeleteGallaryFolder('<?php echo $data['frame_id']; ?>');"></i>  
                 <?php } ?> 
                </div>
                <?php } 
} else {
  echo "<img width='250' src='img/no_data_found.png'>";
}

              } ?>
              </div>
              <div class="row">
                <?php   if (isset($frame_id) && $viewDetail =="true") { 
                  // /IS_1002
                
                 ?>
            

                 <div class="col-md-3">  </div>
                <div class="col-md-3"></div>
                <div class="col-md-3">
                 
                </div>
                <div class="col-md-3"></div>



               
                <?php
               if($frame_id!=0 ) {
                $eq = $d->select("utility_banner_master","frame_id='$frame_id'");
              }  
              
                if(mysqli_num_rows($eq)>0) {
                while ($pData = mysqli_fetch_array($eq)) {
                  
                ?>

                <div class="col-md-6 col-6 col-lg-3 col-xl-3">
                  <a href="../img/utilityBanner/<?php echo $pData['banner_image'] ?>" data-fancybox="images" data-caption="Photo Name : <?php echo $pData["banner_image"]; ?>">
                    <img src="../img/utilityBanner/<?php echo $pData['banner_image'] ?>" alt="<?php echo $pData['frame_name'] ?>" class="lightbox-thumb img-thumbnail" style="width:250px;height:150px;">
                  </a>
                  <div class="row">
                   <div class="col-md-6 col-6">
                    <a href="../img/utilityBanner/<?php echo $pData['banner_image'] ?>" download="<?php echo $pData['banner_image'] ?>">
                    <button class="btn btn-sm btn-primary" style="margin-right: 5px;"><i class="fa fa-download" aria-hidden="true"></i></button></a>
                  </div>
                  <div class="col-md-6 col-6">

                    <form action="controller/utilityBannerController.php" method="POST" >
                      <input type="hidden" name="banner_id" value="<?php echo $pData['banner_id']; ?>">
                      <input type="hidden" name="gallery_path" value="../../img/utilityBanner/<?php echo $pData['banner_image'] ?>">
                      <?php //IS_570 ?>
                      <input type="hidden" name="frame_id" value="<?php echo $frame_id; ?>">

                      <input type="hidden" value="deleteGalleryPhoto" name="deleteGalleryPhoto">
                    <button type="submit" class="form-btn  btn btn-sm btn-danger" name="" ><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                    </form>
                   </div>
                  </div>
                  
                </div>
                <?php
                  }  } else {
                  echo "<img width='250' src='img/no_data_found.png'>";
                } 
               }
                ?>
              </div>
            </fieldset>
            </div>
          </div>
        </div>
      </div>
      </div><!--End Row-->
      
    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
    <!--Start Back To Top Button-->