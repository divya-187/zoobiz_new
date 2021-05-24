<?php error_reporting(0); ?> 
    <div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-6">
        <h4 class="page-title">Utility Banner</h4>
        
      </div>
      <div class="col-sm-6">
        
      </div>
    </div>
    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-lg-12">
        <?php
        $slider_array = array();
        $sq = $d->select("utility_banner_master"," active_status != 2  ");
        while ($sData = mysqli_fetch_array($sq)) {
        array_push($slider_array,$sData['banner_image']);
        }
        // print_r($slider_array);
        if(mysqli_num_rows($sq)>0){
        ?>
        <div class="card">
          <div id="carousel-A" class="carousel slide" data-ride="carousel">
            <ul class="carousel-indicators">
              <li data-target="#demo-a" data-slide-to="0" class="active"></li>
              <li data-target="#demo-b" data-slide-to="1"></li>
              <li data-target="#demo-c" data-slide-to="2"></li>
              <li data-target="#demo-d" data-slide-to="3"></li>
              <li data-target="#demo-e" data-slide-to="4"></li>
              <li data-target="#demo-f" data-slide-to="5"></li>
              <li data-target="#demo-g" data-slide-to="6"></li>
              <li data-target="#demo-h" data-slide-to="7"></li>
              <li data-target="#demo-i" data-slide-to="8"></li>
              <li data-target="#demo-j" data-slide-to="9"></li>
            </ul>
            
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/utilityBanner/<?php echo $slider_array[0] ?>" alt="Slider_Image_1" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/utilityBanner/<?php echo $slider_array[1] ?>" alt="Slider_Image_2" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/utilityBanner/<?php echo $slider_array[2] ?>" alt="Slider_Image_3" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/utilityBanner/<?php echo $slider_array[3] ?>" alt="Slider_Image_4" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/utilityBanner/<?php echo $slider_array[4] ?>" alt="Slider_Image_5" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/utilityBanner/<?php echo $slider_array[5] ?>" alt="Slider_Image_6" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/utilityBanner/<?php echo $slider_array[6] ?>" alt="Slider_Image_7" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/utilityBanner/<?php echo $slider_array[7] ?>" alt="Slider_Image_8" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/utilityBanner/<?php echo $slider_array[8] ?>" alt="Slider_Image_9" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/utilityBanner/<?php echo $slider_array[9] ?>" alt="Slider_Image_10" width="" height="400">
              </div>
            </div>
            
            <a class="carousel-control-prev" href="#carousel-A" data-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#carousel-A" data-slide="next">
              <span class="carousel-control-next-icon"></span>
            </a>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
    
    <?php
    $rq1 = $d->select("utility_banner_master"," active_status != 2  ");
    $rows = mysqli_num_rows($rq1);
    if ($rows < 10 &&  $_GET['editBannerSlider']!='editBannerSlider') {
    ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <form id="utilityFrm" method="post" action="controller/utilityBannerController.php" enctype="multipart/form-data">
              <h4 class="form-header text-uppercase">
              <i class="fa fa-address-book-o"></i>
              Add Utility Banner Images 
              </h4>

              <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label">Frame </label>
                <div class="col-sm-10">

                   <select type="text"      class="form-control single-select" id="frame_id" name="frame_id">
                     <option value="">-- Select --</option>
                        <?php
                           $q31=$d->select("frame_master","status=0","ORDER BY frame_name ASC");
                          while ($blockRow11=mysqli_fetch_array($q31)) {
                           ?>
                           <option <?php if( isset($data['frame_id']) && $data['frame_id']==$blockRow11['frame_id']) {echo "selected";} ?> value="<?php echo $blockRow11['frame_id'];?>"><?php echo $blockRow11['frame_name'];?></option>
                          <?php }  ?>
                      </select>


               
                </div>
              </div>


              <div class="form-group row">
                <label for="banner_image" class="col-sm-2 col-form-label">Banner Image <span class="required">*</span></label>
                <div class="col-sm-10">
                  <input class="form-control-file border" accept="image/*" required="" type="file"  name="banner_image">
                </div>
              </div>
               
               

              

              
              <div class="form-footer text-center">
                <button type="submit" class="btn btn-success" name = "addUtilityBannerImage"><i class="fa fa-check-square-o"></i> SAVE</button>
               
              </div>
            </form>
          </div>
        </div>
      </div>
      </div><!--End Row-->
      <?php
      } else if (isset($_GET['editBannerSlider']) && $_GET['editBannerSlider']=='editBannerSlider') { 
         $sq = $d->select("utility_banner_master","banner_id='$_GET[banner_id]' and active_status != 2  ");
        $sData11 = mysqli_fetch_array($sq);
        extract($sData11);

       ?>
      <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <form id="utilityFrm" method="post" action="controller/utilityBannerController.php" enctype="multipart/form-data">
              <h4 class="form-header text-uppercase">
              <i class="fa fa-address-book-o"></i>
              Edit Utility Banner  
              </h4>

                

              <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label">Slider Image</label>
                <div class="col-sm-10">
                  <input class="form-control-file border" accept="image/*" type="file"  name="banner_image">
                </div>
              </div>
                   
              <div class="form-footer text-center">
                <input type="hidden" name="banner_id_edit" value="<?php echo $banner_id; ?>" >
                <input type="hidden" name="banner_image_old" value="<?php echo $banner_image; ?>" >
                <button type="submit" class="btn btn-success" name = "updateUtilityBanner"><i class="fa fa-check-square-o"></i> Update</button>
                <a href="utilityBanners" class="btn btn-danger" ><i class="fa fa-times"></i> Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
      </div><!--End Row-->
      <?php }
      ?>
      <!--End Row-->
      <!-- Msanage Slider -->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
                <h4 class="form-header text-uppercase">
                <i class="fa fa-address-book-o"></i>
                Manage Utility Images (Max 10 Images)
                </h4>
                <div class="row">
                  <?php
                  $sq = $d->select("utility_banner_master"," active_status != 2 ");
                  while ($sData11 = mysqli_fetch_array($sq)) {
                  ?>
                  <div class="col-md-6 col-lg-3 col-xl-3">
                     <a target="_blank" href="<?php if ($sData11['banner_url']!='') {  echo $sData11['banner_url']; } else { echo '#';} ?>">
                      <img src="../img/utilityBanner/<?php echo $sData11['banner_image']; ?>" alt="banner_image" class="lightbox-thumb img-thumbnail" style="width:250px;height:150px;">
                      </a>
                      
                       
                    <form  style="display: inline-block;"  action="controller/utilityBannerController.php" method="post">
                      <input type="hidden" name="banner_id" value="<?php echo $sData11['banner_id']; ?>">
                      <input type="hidden" name="deleteUtilityBannerImage" value="deleteUtilityBannerImage">
                      <button type="submit" class="btn btn-sm form-btn btn-danger" >Delete</button>
                    </form> 
                     <form  style="display: inline-block;" action="" method="get">
                      <input type="hidden" name="banner_id" value="<?php echo $sData11['banner_id']; ?>">
                      <input type="hidden" name="editBannerSlider" value="editBannerSlider">
                      <button type="submit" class="btn btn-sm btn-success" >Edit</button>
                    </form>
                    <div style="display: inline-block;" >
                    <?php if($sData11['active_status']=="0"){ ?>
                         <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $sData11['banner_id']; ?>','inActiveBanner');" data-size="small"/>
                        <?php } else { ?>
                          <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $sData11['banner_id']; ?>','activeBanner');" data-size="small"/>
                           <?php } ?>
                         </div>
                  </div>
                  <?php
                  }
                  ?>
                </div>
              </div>
          </div>
        </div>
      </div>


        


      </div><!--End Row-->
    </div>
  </div>
</div>
<!-- End container-fluid-->
</div><!--End content-wrapper-->
<!--Start Back To Top Button-->