<?php  error_reporting(0);
extract($_REQUEST);
if(isset($promotion_id)){
$promotion_master=$d->select("promotion_master","  promotion_id = '$promotion_id' ","");
$promotion_master_data=mysqli_fetch_array($promotion_master);
extract($promotion_master_data);
}
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <?php if(isset($promotion_id)){?>
        <h4 class="page-title">Edit Seasonal Greetings</h4>
        <?php  } else {?>
        <h4 class="page-title">Add Seasonal Greetings</h4>
        <?php } ?>

         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           
           <li class="breadcrumb-item"><a href="promoteBusiness">Seasonal Greetings List</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php if(isset($promotion_id)){?>
         Edit Seasonal Greetings 
        <?php  } else {?>
        Add Seasonal Greetings 
        <?php } ?></li>
         </ol>
        
      </div>
      
    </div>
    <!-- End Breadcrumb-->
    
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            
            <form id="promotionFrm" action="controller/businessPromotionController.php" method="post" enctype="multipart/form-data" >
              <?php if(isset($promotion_id)){ ?> 
              <input type="hidden" name="promotionEditBtn" value="promotionEditBtn">
            <?php  } else {?>
                <input type="hidden" name="promotionAddBtn" value="promotionAddBtn">
              <?php } ?> 
              
               <?php if(isset($promotion_id)){ ?> 
              <input type="hidden" id="isEdit" value="yes">
            <?php  } else {?>
                <input type="hidden" id="isEdit" value="no">
              <?php } ?> 
              
              <div class="form-group row">
                
                <label class="col-lg-2 col-form-label form-control-label">Event Name <span class="required">*</span></label>
                <div class="col-lg-10">
                  <input  required="" type="text" class="form-control  " name="event_name" id="event_name" value="<?php if(isset($promotion_id)){  echo $event_name;} ?>" placeholder="Event Name" minlength="5" maxlength="50"  >
                  
                </div>
               </div>


               <div   class="form-group row">
              
                  <label class="col-lg-2 col-form-label form-control-label">Start Date <span class="required">*</span></label>
                  <div class="col-lg-4" >
                     
                      <input id="start-date" required="" type="text"  readonly="" class="form-control"   value="<?php if(isset($promotion_id) && ($event_date !="1970-01-01" && $event_date !="0000-00-00")  ){ echo date("d-m-Y", strtotime($event_date)); }?>"  name="event_date"  >
                   </div>

                   


                  <label class="col-lg-2 col-form-label form-control-label">End Date <span class="required">*</span></label>
                  <div class="col-lg-4"  >
                     
                     <input id="end-date" required="" type="text"  readonly="" class="form-control"   value="<?php if(isset($promotion_id) && ($event_end_date !="1970-01-01" && $event_end_date !="0000-00-00")   ){ echo date("d-m-Y", strtotime($event_end_date)); }?>"  name="event_end_date"  >
                     
                     
                  </div>
                </div>
             <div class="form-group row">
                  <label class="col-lg-2 col-form-label form-control-label">Event Date (for sorting) <span class="required">*</span></label>
                <div class="col-lg-4">
                  <input  required="" readonly="" type="text" class="form-control  " name="order_date" id="autoclose-datepicker-evt" value="<?php if(isset($promotion_id)){  echo date("d-m-Y", strtotime($order_date));} ?>"  minlength="5" maxlength="50"  >
                  
                </div>
              </div> 
              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                  
                  <textarea  minlength="1" maxlength="250" value=""   class="form-control" id="description" name="description"><?php if(isset($promotion_id)){  echo $description;} ?></textarea>
                </div>
              </div>
               

              <div class="form-group row">
                <label for="event_frame" class="col-sm-2 col-form-label">Event Frame <?php  if(isset($promotion_id)){ } else { echo '<span class="required">*</span>'; } ?>  </label>
                <div class="col-sm-10">
                  <input  class="form-control-file border"    accept="image/*" <?php  if(isset($promotion_id ) && $event_frame !='' ){} else {?>  required="" <?php } ?>   type="file"  name="event_frame">
                  <?php  if(isset($promotion_id)){
                    ?>
                    <input type="hidden" name="event_frame_old" value="<?php echo $event_frame;?>">
                    <?php
                  }?>
                </div>
              </div>

               

              <div class="form-group row">
                <label for="promotion_frame_id" class="col-sm-2 col-form-label">Frame Image <span class="required">*</span></label>
                <div class="col-sm-5">
                  <select id="promotion_frame_id" class="form-control multiple-select" name="promotion_frame_id[]" type="text"    multiple="multiple">
                    <option   value="">--Select--</option>
                    <?php // onchange="getImage1();"
                    $promotion_rel_frame_master_array = array();
                      if(isset($promotion_id)){
                        $pfi=$d->select("promotion_rel_frame_master"," promotion_id= '$promotion_id' and  status = 0   ","");
                        while ($pfi_data = mysqli_fetch_array($pfi)) {
                          $promotion_rel_frame_master_array[] = $pfi_data['promotion_frame_id'];
                        }
                      }
                    $promotion_frame_master=$d->select("promotion_frame_master"," status = 0   ","");
                    $counter = 1;
                    while ($promotion_frame_master_data = mysqli_fetch_array($promotion_frame_master)) {
                      $id=$promotion_frame_master_data['promotion_frame_id'];
                    ?>
                    <option <?php  if(isset($promotion_id) && in_array($promotion_frame_master_data['promotion_frame_id'], $promotion_rel_frame_master_array)){ echo "selected";} ?>   value="<?php echo $promotion_frame_master_data['promotion_frame_id']; ?>">Frame <?php echo $id; ?></option>
                    <?php
                    $counter++;
                    }
                    ?>
                  </select>
                  <input multiple class="form-control-file border"    accept="image/*"   type="file" id="promotion_frame_new"  name="promotion_frame_new[]">
                </div>
                <div class="col-sm-5" id="getImage1_div"></div>
              </div>
              <div class="form-group row">
                <label for="promotion_center_image_id" class="col-sm-2 col-form-label">Center Image <span class="required">*</span> </label>
                <div class="col-sm-5">
                  <select id="promotion_center_image_id" class="form-control multiple-select" name="promotion_center_image_id[]" type="text"   multiple="multiple">
                    <option   value="">--Select--</option>
                    <?php
 // onchange="getImage2();"
                    $promotion_rel_center_master_array = array();
                      if(isset($promotion_id)){
                        $pci=$d->select("promotion_rel_center_master"," promotion_id= '$promotion_id' and  status = 0   ","");
                        while ($pci_data = mysqli_fetch_array($pci)) {
                          $promotion_rel_center_master_array[] = $pci_data['promotion_center_image_id'];
                        }
                      }


                    $promotion_center_image_master_qry=$d->select("promotion_center_image_master"," status = 0   ","");
                    $counter2 = 1;
                    while ($promotion_center_image_master = mysqli_fetch_array($promotion_center_image_master_qry)) {
                      $id=$promotion_center_image_master['promotion_center_image_id'];

                    ?>
                    <option <?php  if(isset($promotion_id) && in_array($promotion_center_image_master['promotion_center_image_id'], $promotion_rel_center_master_array)){ echo "selected";} ?>  value="<?php echo $promotion_center_image_master['promotion_center_image_id']; ?>">Center Image <?php echo $id; ?></option>
                    <?php
                    $counter2++;
                    }
                    ?>
                    <input multiple class="form-control-file border"    accept="image/*"   type="file" id="promotion_center_image_new"  name="promotion_center_image_new[]">
                  </select>
                </div>
                <div class="col-sm-5" id="getImage2_div"> <?php  if(isset($promotion_id)){}?></div>
              </div>
               
               <div class="form-group row" style="display: none;">
               <label class="col-lg-2 col-form-label form-control-label">Text Color </label>
                  <div class="col-lg-5">
               <input type="color" id="text_color" name="text_color" value="<?php if($promotion_id){ echo $text_color; } ?>"> 
             </div>
           </div>
                
               <div class="form-group row">
                <label for="event_status" class="col-sm-2 col-form-label">Event Status </label>
                <div class="col-sm-5">
                  <select id="event_status"   class="form-control single-select" name="event_status" type="text"  required=""  >
                     
                      <option  <?php if(isset($promotion_id) && $event_status == 0 ){  echo "selected";} ?>   value="0">Running</option>
                      <option   <?php if(isset($promotion_id) && $event_status == 1 ){  echo "selected";} ?> value="1">Upcomming</option> 
                    <!--   <option  <?php if(isset($promotion_id) && $event_status == 2 ){  echo "selected";} ?>  value="2">Expired</option>  -->
                  </select>
                </div>
                 
              </div>

               <!--  <div class="form-group row">
                <label for="event_status" class="col-sm-2 col-form-label">Auto Expire </label>
                <div class="col-sm-5">
                  <select id="auto_expire"   class="form-control single-select" name="auto_expire" type="text"  required=""  >
                    
                      <option  <?php if(isset($promotion_id) && $auto_expire == 0 ){  echo "selected";} ?>   value="0">Yes</option>
                      <option   <?php if(isset($promotion_id) && $auto_expire == 1 ){  echo "selected";} ?> value="1">No</option> 
                    
                  </select>
                </div>
                 
              </div> -->
                <div class="form-footer text-center">
                  
                  <?php  if(isset($promotion_id)){ ?>
                  <input type="hidden" name="promotion_id" value="<?php echo $promotion_id;?>">
                  <button type="submit" name="promotionEditBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> UPDATE</button>
                  <?php  } else {?>
                  <button type="submit" name="promotionAddBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                  <?php }?>
                  <a href="promoteBusiness" class="btn btn-danger">Cancel</a>
                  
                </div>
              </form>
            </div>
          </div>
        </div>
        </div><!--End Row-->
      </div>
      <!-- End container-fluid-->
      </div><!--End content-wrapper-->
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