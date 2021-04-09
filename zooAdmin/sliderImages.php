<?php error_reporting(0); ?> 
    <div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-6">
        <h4 class="page-title">App Banner</h4>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">App Banner</li>
         </ol>
      </div>
      <div class="col-sm-6">
        
      </div>
    </div>
    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-lg-12">
        <?php
        $slider_array = array();
        $sq = $d->select("slider_master","status=0");
        while ($sData = mysqli_fetch_array($sq)) {
        array_push($slider_array,$sData['slider_image']);
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
                <img onerror="this.src='../imgslidersslider.jpg'" class="d-block w-100" src="../img/sliders/<?php echo $slider_array[0] ?>" alt="Slider_Image_1" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/sliders/<?php echo $slider_array[1] ?>" alt="Slider_Image_2" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/sliders/<?php echo $slider_array[2] ?>" alt="Slider_Image_3" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/sliders/<?php echo $slider_array[3] ?>" alt="Slider_Image_4" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/sliders/<?php echo $slider_array[4] ?>" alt="Slider_Image_5" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/sliders/<?php echo $slider_array[5] ?>" alt="Slider_Image_6" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/sliders/<?php echo $slider_array[6] ?>" alt="Slider_Image_7" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/sliders/<?php echo $slider_array[7] ?>" alt="Slider_Image_8" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/sliders/<?php echo $slider_array[8] ?>" alt="Slider_Image_9" width="" height="400">
              </div>
              <div class="carousel-item">
                <img onerror="this.src='../img/sliders/slider.jpg'" class="d-block w-100" src="../img/sliders/<?php echo $slider_array[9] ?>" alt="Slider_Image_10" width="" height="400">
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
    $rq1 = $d->select("slider_master","status=0");
    $rows = mysqli_num_rows($rq1);
    if (/*$rows < 10 &&*/  $_GET['editSlider']!='editSlider') {
    ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <form id="appBannerFrm" method="post" action="controller/sliderController.php" enctype="multipart/form-data">
              <h4 class="form-header text-uppercase">
              <i class="fa fa-address-book-o"></i>
              Add Slider Images 
              </h4>

              <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label">Business Category </label>
                <div class="col-sm-10">

                   <select type="text" onchange="getMembersOfCategory();"      class="form-control single-select" id="business_category_id" name="business_category_id">
                     <option value="">-- Select --</option>
                        <?php
                           $q31=$d->select("business_categories","category_status=0","ORDER BY category_name ASC");
                          while ($blockRow11=mysqli_fetch_array($q31)) {
                           ?>
                           <option <?php if( isset($data['business_category_id']) && $data['business_category_id']==$blockRow11['business_category_id']) {echo "selected";} ?> value="<?php echo $blockRow11['business_category_id'];?>"><?php echo $blockRow11['category_name'];?></option>
                          <?php }  ?>
                      </select>


               
                </div>
              </div>


              <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label">Slider Image <span class="required">*</span></label>
                <div class="col-sm-10">
                  <input class="form-control-file border" accept="image/*" required="" type="file"  name="slider_image">
                </div>
              </div>
              <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label">URL </label>
                <div class="col-sm-10">
                  <input class="form-control" maxlength="250" minlength="3" type="url"  name="slider_url">
                </div>
              </div>
               <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label">Youtube Video Id </label>
                <div class="col-sm-10">
                  <input class="form-control" maxlength="100" minlength="3" type="text"  name="slider_video_url">
                </div>
              </div>
              <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label">Phone Number </label>
                <div class="col-sm-10">
                  <input class="form-control" id="trlDays" type="text" maxlength="12"  name="slider_mobile">
                </div>
              </div>
              <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label">Member </label>
                <div class="col-sm-10">
                  <select class="form-control single-select" id="user_id" type="text" maxlength="12"  name="user_id">
                    <option> -- Select --</option>
                    <  <?php 
                $i=1;
                  $q=$d->select("users_master,user_employment_details,business_categories,business_sub_categories"," business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  ","ORDER BY users_master.user_id DESC");
               while ($data=mysqli_fetch_array($q)) {  ?>
                  <option value="<?php echo $data['user_id'] ; ?>"><?php echo $data['user_full_name'] ; ?>-<?php echo $data['company_name'] ; ?></option>

                    <?php } ?>
                  </select>
                </div>
              </div>

              

              <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label">About Offer </label>
                <div class="col-sm-10">
                  <textarea class="form-control"  type="text" maxlength="250"  name="slider_description"></textarea>
                </div>
              </div>
              <div class="form-footer text-center">
                <button type="submit" class="btn btn-success" name = "addSliderImage"><i class="fa fa-check-square-o"></i> SAVE</button>
               
              </div>
            </form>
          </div>
        </div>
      </div>
      </div><!--End Row-->
      <?php
      } else if (isset($_GET['editSlider']) && $_GET['editSlider']=='editSlider') { 
         $sq = $d->select("slider_master","slider_id='$_GET[slider_id]' and status=0");
        $sData11 = mysqli_fetch_array($sq);
        extract($sData11);

       ?>
      <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <form id="editAppBannerFrm" method="post" action="controller/sliderController.php" enctype="multipart/form-data">
              <h4 class="form-header text-uppercase">
              <i class="fa fa-address-book-o"></i>
              Edit Slider  
              </h4>

               <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label">Business Category </label>
                <div class="col-sm-10">
                    <select type="text"     class="form-control single-select" id="business_category_id" name="business_category_id">
                       <option value="">-- Select --</option>
                        <?php
                           $q31=$d->select("business_categories","category_status=0","ORDER BY category_name ASC");
                          while ($blockRow11=mysqli_fetch_array($q31)) {
                           ?>
                           <option <?php if( isset($business_category_id) && $business_category_id==$blockRow11['business_category_id']) {echo "selected";} ?> value="<?php echo $blockRow11['business_category_id'];?>"><?php echo $blockRow11['category_name'];?></option>
                          <?php }  ?>
                      </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label">Slider Image </label>
                <div class="col-sm-10">
                  <input class="form-control-file border" accept="image/*" type="file"  name="slider_image">
                </div>
              </div>
              <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label">URL </label>
                <div class="col-sm-10">
                  <input class="form-control" maxlength="250" type="url" value="<?php echo $slider_url; ?>" name="slider_url">
                </div>
              </div>
               <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label">Youtube Video Id </label>
                <div class="col-sm-10">
                  <input class="form-control" maxlength="100" type="text"  value="<?php echo $slider_video_url; ?>" name="slider_video_url">
                </div>
              </div>
              <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label">Phone Number </label>
                <div class="col-sm-10">
                  <input class="form-control" id="trlDays" type="text" value="<?php if($slider_mobile!=0 )  echo $slider_mobile; ?>"  maxlength="12"  name="slider_mobile">
                </div>
              </div>
              <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label">Member </label>
                <div class="col-sm-10">
                  <select class="form-control single-select" id="trlDays" type="text" maxlength="12"  name="user_id">
                    <option> -- Select --</option>
                    <  <?php 
                $i=1;
                  $q=$d->select("users_master,user_employment_details,business_categories,business_sub_categories"," business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  ","ORDER BY users_master.user_id DESC");
               while ($data=mysqli_fetch_array($q)) {  ?>
                  <option <?php if($data['user_id']==$user_id) { echo 'selected';} ?> value="<?php echo $data['user_id'] ; ?>"><?php echo $data['user_full_name'] ; ?>-<?php echo $data['company_name'] ; ?></option>

                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="input-12" class="col-sm-2 col-form-label">About Offer </label>
                <div class="col-sm-10">
                  <textarea class="form-control"  type="text" maxlength="250"  name="slider_description"><?php echo $slider_description; ?></textarea>
                </div>
              </div>
              <div class="form-footer text-center">
                <input type="hidden" name="slider_id_edit" value="<?php echo $slider_id; ?>" >
                <input type="hidden" name="slider_image_old" value="<?php echo $slider_image; ?>" >
                <button type="submit" class="btn btn-success" name = "updateSlider"><i class="fa fa-check-square-o"></i> Update</button>
               
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
                Manage Slider Images (Max 10 Images)
                </h4>
                <div class="row">
                  <?php
                  $sq = $d->select("slider_master","status=0");
                  while ($sData11 = mysqli_fetch_array($sq)) {
                  ?>
 
                  <div class="col-md-6 col-lg-4 col-xl-4" style="padding: 10px !important;">
                    



                      <a href="../img/sliders/<?php echo $sData11['slider_image']; ?>" data-fancybox="images" data-caption="images">
                    <img src="../img/sliders/<?php echo $sData11['slider_image']; ?>" alt="images" class="lightbox-thumb img-thumbnail" style="width:250px;height:150px;">
                  </a>



                      <p><?php if($sData11['slider_mobile']!=0 ) echo $sData11['slider_mobile']; ?>
                        
                        <?php
                        if($sData11['business_category_id'] !="0"){
                          $business_category_id = $sData11['business_category_id'];

                        $business_categories_qry=$d->select("business_categories","business_category_id= '$business_category_id' ","ORDER BY category_name ASC");
                          $business_categories_data=mysqli_fetch_array($business_categories_qry);
                          echo '- '.$business_categories_data['category_name'];
                        }
                         ?>
                      </p>

                      <?php if(trim($sData11['slider_description']) !='') {?> 
                       <div class="card-body" style="max-height: 100px !important; overflow-y: auto;"> 
                       
              <p class="card-text"><div class="cls-notice-info"><?php echo stripslashes(htmlspecialchars_decode($sData11['slider_description'])); ?> </div></p>
            </div>
          <?php } else {
            echo '<p></p>';
          } ?> 

                      <?php if($sData11['created_date'] !="0000-00-00 00:00:00"){?> 
                      
                      <?php echo date("d-m-Y h:i:s A", strtotime($sData11['created_date'])); ?>
                      <br>
                    <?php } ?>


                    <form  style="display: inline-block;"  action="controller/sliderController.php" method="post">
                      <input type="hidden" name="slider_id" value="<?php echo $sData11['slider_id']; ?>">
                      <input type="hidden" name="deleteSliderImage" value="deleteSliderImage">
                      <button type="submit" class="btn btn-sm form-btn btn-danger" >Delete</button>
                    </form>

                     <form style="display: inline-block;" action="" method="get">
                      <input type="hidden" name="slider_id" value="<?php echo $sData11['slider_id']; ?>">
                      <input type="hidden" name="editSlider" value="editSlider">
                      <button type="submit" class="btn btn-sm btn-success" >Edit</button>
                    </form>



                  </div>
                   
                  <?php
                  }
                  ?>
                </div>
              </div>
          </div>
        </div>
      </div>


       <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
            <div class="">
              <form  id="advertiseFrm" action="controller/profileController.php" method="post" enctype="multipart/form-data">
          <?php 
            if(isset($_SESSION['zoobiz_admin_id'])) {
            $qa=$d->select("advertisement_master","");
            $advdata=mysqli_fetch_array($qa);
            extract($advdata);
            } ?>
          
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Image </label>
            <div class="col-lg-9">
              


                  <a href="../img/sliders/<?php echo $advertisement_url; ?>" data-fancybox="images" data-caption="images">
                    <img style="width:500px;height:500px;"  src="../img/sliders/<?php echo $advertisement_url; ?>" alt="images" class="lightbox-thumb img-thumbnail"  >
                  </a>



            </div>
          </div>
          
         
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Change Image</label>
            <div class="col-lg-9">
              <input class="form-control-file border" id="imgInp" accept="image/*" name="advertisement_url" type="file">
              <input class="form-control-file border" value="<?php echo $advertisement_url; ?>" name="advertisement_url_old" type="hidden">
             
            </div>
          </div>
           <div class="form-group row">
              <label for="state" class="col-sm-2 col-form-label">View Type</label>
              <div class="col-sm-10">
                  <div class="form-check-inline">
                    <label class="form-check-label">
                      <input  <?php if($view_status==0) { echo 'checked'; } ?> type="radio" checked="" class="form-check-input" value="0" name="view_status"> Every Time When App Open
                    </label>
                  </div>
                  <div class="form-check-inline">
                    <label class="form-check-label">
                      <input  <?php if($view_status==1) { echo 'checked'; } ?> type="radio" class="form-check-input" value="1" name="view_status"> One Time 
                    </label>
                  </div>
              </div>
            </div>
           <div class="form-group row">
              <label for="state" class="col-sm-2 col-form-label">Active Status</label>
              <div class="col-sm-10">
                  <div class="form-check-inline">
                    <label class="form-check-label">
                      <input <?php if($active_status==1) { echo 'checked'; } ?> type="radio" checked="" class="form-check-input" value="1" name="active_status"> Active
                    </label>
                  </div>
                  <div class="form-check-inline">
                    <label class="form-check-label">
                      <input  <?php if($active_status==0) { echo 'checked'; } ?> type="radio" class="form-check-input" value="0" name="active_status"> Deactive
                    </label>
                  </div>
              </div>
            </div> 
           
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label"></label>
            <div class="col-lg-9">
              
              <input type="submit" class="btn btn-primary" name="updateAdvertisement"  value="Update">
            </div>
          </div>
        </form>
      </div>
    </div></div>
        </div>
      </div>



      </div><!--End Row-->
    </div>
  </div>
</div>
<!-- End container-fluid-->
</div><!--End content-wrapper-->
<!--Start Back To Top Button-->