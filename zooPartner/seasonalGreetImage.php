<?php  error_reporting(0);
extract($_REQUEST);
if(isset($seasonal_greet_image_id )){
$seasonal_greet_master=$d->select("seasonal_greet_image_master","  seasonal_greet_image_id  = '$seasonal_greet_image_id' ","");
$seasonal_greet_master_data=mysqli_fetch_array($seasonal_greet_master);
extract($seasonal_greet_master_data);




}

$seasonal_greet_master_qry=$d->select("seasonal_greet_master","  seasonal_greet_id  = '$seasonal_greet_id' ","");

 
$seasonal_greet_master_d=mysqli_fetch_array($seasonal_greet_master_qry);
?>

<?php 
$font_master=$d->select("font_master","status='Active' ","");
 $font_master_data = array();
                $counter = 0 ;
                foreach ($font_master as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $font_master_data[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                ?>


<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
       
        <h4 class="page-title">Manage Seasonal Greetings - <?php echo $seasonal_greet_master_d['title'];?></h4>
         
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>

           <li class="breadcrumb-item"><a href="seasonalGreetList">Seasonal Greetings List</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Manage Seasonal Greetings - <?php echo $seasonal_greet_master_d['title'];?></li>
         </ol>
      </div>
      
    </div>
    <!-- End Breadcrumb-->
    
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            
            <form id="seasonalGreetImageFrm" action="controller/seasonalGreetController.php" method="post" enctype="multipart/form-data" >
             
             <input type="hidden" name="seasonal_greet_id" value="<?php echo $seasonal_greet_id;?>">

               <fieldset class="scheduler-border">
                <legend  class="scheduler-border">Image Details</legend>
               <div class="form-group row">
                <label for="cover_image" class="col-sm-2 col-form-label">Cover Image <?php  if(isset($seasonal_greet_image_id) && $cover_image !=''){ } else { 
                    ?> <span class="required">*</span> <?php } ?> </label>
                <div class="col-sm-4">
                  <input id="cover_image" class="form-control-file border"  accept="image/*"   type="file"  name="cover_image">
                   <input id="cover_image_old"    type="hidden" value="<?php if(isset($seasonal_greet_image_id )){  echo $cover_image;} ?>"  name="cover_image_old">

                  <?php   if(isset($seasonal_greet_image_id) && $cover_image !=''){
                    ?>
                    
                     <a    href="../img/promotion/<?php echo $cover_image; ?>" data-fancybox="images1<?php echo $seasonal_greet_image_id;?>" data-caption="Photo Name : <?php echo $cover_image; ?>">
              <img style="max-height:40px;max-width:40px;" class="d-block w-100" src="../img/promotion/<?php echo $cover_image; ?>" alt="">
              </a>
            
              <?php
                  }?>
 
                </div>
               

              

                <label for="background_image" class="col-sm-2 col-form-label">Background Image <?php  if(isset($seasonal_greet_image_id) && $background_image !=''){ } else { 
                    ?> <span class="required">*</span><?php } ?></label>
                <div class="col-sm-4">
                  <input id="background_image" class="form-control-file border"  accept="image/*"   type="file"  name="background_image">
                  <input id="background_image_old"    type="hidden" value="<?php if(isset($seasonal_greet_image_id )){  echo $background_image;} ?>"  name="background_image_old">

                       <?php   if(isset($seasonal_greet_image_id) && $background_image !=''){
                    ?>
                    
                     <a    href="../img/promotion/<?php echo $background_image; ?>" data-fancybox="images2<?php echo $seasonal_greet_image_id;?>" data-caption="Photo Name : <?php echo $background_image; ?>">
              <img style="max-height:40px;max-width:40px;" class="d-block w-100" src="../img/promotion/<?php echo $background_image; ?>" alt="">
              </a>
            
              <?php
                  }?>
                </div>
              </div>
 <div class="form-group row">
                <label for="background_image" class="col-sm-2 col-form-label">Logo Alignment</label>
                <div class="col-sm-4">
                   <select type="text"   id="logo_alignment" 
                 class="form-control single-select" name="logo_alignment">
                     
                     <option <?php if(isset($seasonal_greet_image_id ) && $logo_alignment=="Center"  ){ echo "selected";} ?>   value="Center">Center</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $logo_alignment=="Start"  ){ echo "selected";} ?>   value="Start">Start</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $logo_alignment=="End"  ){ echo "selected";} ?>   value="End">End</option>

                       <option <?php if(isset($seasonal_greet_image_id ) && $logo_alignment=="Left"  ){ echo "selected";} ?>   value="Left">Left</option>
                       <option <?php if(isset($seasonal_greet_image_id ) && $logo_alignment=="Right"  ){ echo "selected";} ?>   value="Right">Right</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $logo_alignment=="Top"  ){ echo "selected";} ?>   value="Top">Top</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $logo_alignment=="Bottom"  ){ echo "selected";} ?>   value="Bottom">Bottom</option>
                    </select>
                </div>

                 <label class="col-lg-2 col-form-label form-control-label">Page Alignment<span class="required">*</span></label>
                <div class="col-lg-4">
                     <select type="text"   id="page_alignment" 
                 class="form-control single-select" name="page_alignment">
                     <option value="">-- Select --</option>
                     <option <?php if(isset($seasonal_greet_image_id ) && $page_alignment=="top_top_from"  ){ echo "selected";} ?>   value="top_top_from">Top Top From</option>
                     <option <?php if(isset($seasonal_greet_image_id ) && $page_alignment=="top_bottom_from"  ){ echo "selected";} ?>   value="top_bottom_from">Top Bottom From</option>


                     <option <?php if(isset($seasonal_greet_image_id ) && $page_alignment=="Left"  ){ echo "selected";} ?>   value="Left">Left</option>
                     <option  <?php if(isset($seasonal_greet_image_id ) && $page_alignment=="Right"  ){ echo "selected";} ?>  value="Right">Right</option>
                      

                     <?php /*
                     <option  <?php if(isset($seasonal_greet_image_id ) && $page_alignment=="Bottom"  ){ echo "selected";} ?>  value="Bottom">Bottom</option>

                     <option  <?php if(isset($seasonal_greet_image_id ) && $page_alignment=="Start"  ){ echo "selected";} ?>  value="Start">Start</option>
                     <option  <?php if(isset($seasonal_greet_image_id ) && $page_alignment=="End"  ){ echo "selected";} ?>  value="End">End</option>
                     <option  <?php if(isset($seasonal_greet_image_id ) && $page_alignment=="Center"  ){ echo "selected";} ?>  value="Center">Center</option>
                     <?php */ ?>
                    </select>
                    </div>

              </div>

</fieldset>


  <fieldset class="scheduler-border" style="display: none;">
                <legend  class="scheduler-border">Title Details</legend>

              <div class="form-group row">
                
                <label class="col-lg-2 col-form-label form-control-label">Title on Image </label>
                <div class="col-lg-4">
                  <input  required="" type="text" class="form-control  " name="title_on_image" id="title_on_image" value="<?php if(isset($seasonal_greet_image_id )){  echo $title_on_image;} ?>" placeholder="Title On Image" minlength="3" maxlength="100"  >
                  
                </div>

               
                  
                

               </div>

               <div class="form-group row" >
               <label class="col-lg-2 col-form-label form-control-label">Title Font Color </label>
                  <div class="col-lg-4">
               <input type="color" id="title_font_color" name="title_font_color" value="<?php if($seasonal_greet_image_id ){ echo $title_font_color; } ?>"> 
             </div>



             



                      <label for="background_image" class="col-sm-2 col-form-label">Title Alignment</label>
                <div class="col-sm-4">
                   <select type="text"   id="title_alignment" 
                 class="form-control single-select" name="title_alignment">
                     
                     <option <?php if(isset($seasonal_greet_image_id ) && $title_alignment=="End"  ){ echo "selected";} ?>   value="End">End</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $title_alignment=="Start"  ){ echo "selected";} ?>   value="Start">Start</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $title_alignment=="Center"  ){ echo "selected";} ?>   value="Center">Center</option>


                       <option <?php if(isset($seasonal_greet_image_id ) && $title_alignment=="Left"  ){ echo "selected";} ?>   value="Left">Left</option>
                       <option <?php if(isset($seasonal_greet_image_id ) && $title_alignment=="Right"  ){ echo "selected";} ?>   value="Right">Right</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $title_alignment=="Top"  ){ echo "selected";} ?>   value="Top">Top</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $title_alignment=="Bottom"  ){ echo "selected";} ?>   value="Bottom">Bottom</option>


                    </select>
                </div>


           </div>


<div class="form-group row">
           <label class="col-lg-2 col-form-label form-control-label">Title Font Name <span class="required">*</span> </label>
                  <div class="col-lg-4">
                  <select type="text"  onchange="titleNameDemo();"   id="title_font_name" 
                 class="form-control single-select" name="title_font_name">
             <option value="">-- Select --</option>
                           <?php 
                            for ($l=0; $l < count($font_master_data) ; $l++) { 
                              ?>
                              <option <?php if(isset($seasonal_greet_image_id ) && $title_font_name==$font_master_data[$l]['font_name']  ){ echo "selected";} ?>  value="<?php echo $font_master_data[$l]['font_name']; ?>"><?php echo $font_master_data[$l]['font_name']; ?></option>
                            <?php } ?> 
                          </select>
                    </div>
 
<label class="col-lg-6 col-form-label form-control-label" id="demo_title_text"> </label>
</div>


</fieldset>

  <fieldset class="scheduler-border" style="display: none;">
                <legend  class="scheduler-border">Description Details</legend>

               <div class="form-group row">
                
                <label class="col-lg-2 col-form-label form-control-label">Description on Image</label>
                <div class="col-lg-10">
                  <textarea required="" class="form-control valid" id="description_on_image" name="description_on_image"  ><?php if(isset($seasonal_greet_image_id )){  echo $description_on_image;} ?></textarea>
                  
                </div>
               </div>

            <div class="form-group row" >
               <label class="col-lg-2 col-form-label form-control-label">Description Font Color </label>
                  <div class="col-lg-4">
               <input type="color" id="description_font_color" name="description_font_color" value="<?php if($seasonal_greet_image_id ){ echo $description_font_color; } ?>"> 
             </div>



           

                     <label for="background_image" class="col-sm-2 col-form-label">Description Alignment</label>
                <div class="col-sm-4">
                   <select type="text"   id="description_alignment" 
                 class="form-control single-select" name="description_alignment">
                     
                     <option <?php if(isset($seasonal_greet_image_id ) && $description_alignment=="Center"  ){ echo "selected";} ?>   value="Center">Center</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $description_alignment=="Start"  ){ echo "selected";} ?>   value="Start">Start</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $description_alignment=="End"  ){ echo "selected";} ?>   value="End">End</option>

                       <option <?php if(isset($seasonal_greet_image_id ) && $description_alignment=="Left"  ){ echo "selected";} ?>   value="Left">Left</option>
                       <option <?php if(isset($seasonal_greet_image_id ) && $description_alignment=="Right"  ){ echo "selected";} ?>   value="Right">Right</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $description_alignment=="Top"  ){ echo "selected";} ?>   value="Top">Top</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $description_alignment=="Bottom"  ){ echo "selected";} ?>   value="Bottom">Bottom</option>

                    </select>
                </div>
           </div>

<div class="form-group row">
             <label class="col-lg-2 col-form-label form-control-label">Description Font Name <span class="required">*</span> </label>
                  <div class="col-lg-4">
                  <select type="text"  onchange="descNameDemo();"  id="description_font_name" 
                 class="form-control single-select" name="description_font_name">
             <option value="">-- Select --</option>
                           <?php 
                            for ($l=0; $l < count($font_master_data) ; $l++) { 
                              ?>
                              <option <?php if(isset($seasonal_greet_image_id ) && $description_font_name==$font_master_data[$l]['font_name']  ){ echo "selected";} ?>  value="<?php echo $font_master_data[$l]['font_name']; ?>"><?php echo $font_master_data[$l]['font_name']; ?></option>
                            <?php } ?> 
                          </select>
                    </div>

<label class="col-lg-6 col-form-label form-control-label" id="demo_desc_text"> </label>
</div>

</fieldset>


  <fieldset class="scheduler-border">
                <legend  class="scheduler-border">To Name Details</legend>
                <div class="form-group row">
                <label for="show_to_name" class="col-sm-2 col-form-label">Show To Name?</label>
                <div class="col-sm-4">
                  <select id="show_to_name"   class="form-control single-select" name="show_to_name" type="text" onchange="showToName();"  required=""  >
                     
                     
                      <option <?php if(isset($seasonal_greet_image_id ) && $show_to_name=="No"  ){ echo "selected";} ?>    value="No">No</option> 
                       <option <?php if(isset($seasonal_greet_image_id ) && $show_to_name=="Yes"  ){ echo "selected";} ?>   value="Yes">Yes</option>
                     
                  </select>
                </div>
               </div>

<?php
$stle_var= "display:none;";
 if(isset($seasonal_greet_image_id ) && $show_to_name=="No" ){
$stle_var= "display:block;";
} else {
 $stle_var= "display:none;";
}?>
              <span id="to_name_div"   


              <?php if(isset($seasonal_greet_image_id ) && $show_to_name=="No" ){?> style="display: none;" <?php } ?>

               >
               <div   class="form-group row" >
               <label class="col-lg-2 col-form-label form-control-label">To Name Font Color </label>
                  <div class="col-lg-2">
               <input type="color" id="to_name_font_color" name="to_name_font_color" value="<?php if($seasonal_greet_image_id ){ echo $to_name_font_color; } ?>"> 
             </div>

              <div class="col-lg-2">
               <input type="text" class="form-control"  id="to_name_font_color_text" name="to_name_font_color_text" value="<?php if($seasonal_greet_image_id ){ echo $to_name_font_color; } ?>"> 
             </div>




           


                     <label for="background_image" class="col-sm-2 col-form-label">To Text Alignment</label>
                <div class="col-sm-4">
                   <select type="text"   id="to_text_alignment" 
                 class="form-control single-select" name="to_text_alignment">
                     
                     <option <?php if(isset($seasonal_greet_image_id ) && $to_text_alignment=="Start"  ){ echo "selected";} ?>   value="Start">Start</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $to_text_alignment=="Center"  ){ echo "selected";} ?>   value="Center">Center</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $to_text_alignment=="End"  ){ echo "selected";} ?>   value="End">End</option>

                      <option <?php if(isset($seasonal_greet_image_id ) && $to_text_alignment=="Left"  ){ echo "selected";} ?>   value="Left">Left</option>
                       <option <?php if(isset($seasonal_greet_image_id ) && $to_text_alignment=="Right"  ){ echo "selected";} ?>   value="Right">Right</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $to_text_alignment=="Top"  ){ echo "selected";} ?>   value="Top">Top</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $to_text_alignment=="Bottom"  ){ echo "selected";} ?>   value="Bottom">Bottom</option>


                    </select>
                </div>


                </div>



 <div class="form-group row">
                  <label class="col-lg-2 col-form-label form-control-label">To Name Font Name <span class="required">*</span> </label>
                  <div class="col-lg-2">
                  <select type="text" onchange="toNameDemo();"  id="to_name_font_name" 
                 class="form-control single-select" name="to_name_font_name">
             <option value="">-- Select --</option>
                           <?php 
                            for ($l=0; $l < count($font_master_data) ; $l++) { 
                              ?>
                              <option  <?php if(isset($seasonal_greet_image_id ) && $to_name_font_name==$font_master_data[$l]['font_name'] ){ echo "selected";} ?>  value="<?php echo $font_master_data[$l]['font_name']; ?>"><?php echo $font_master_data[$l]['font_name']; ?></option>
                            <?php } ?> 
                          </select>
                    </div>


                    <label class="col-lg-2 col-form-label form-control-label" id="demo_to_text"> </label>

 <label class="col-lg-2 col-form-label form-control-label">To Name Font Size</label>                
<div class="col-lg-4">
                  <select type="text"    id="to_name_font_size" 
                 class="form-control single-select" name="to_name_font_size">
             
                       <option <?php if(isset($seasonal_greet_image_id ) && $to_name_font_size=="Medium"  ){ echo "selected";} ?>   value="Medium">Medium</option>
                       <option <?php if(isset($seasonal_greet_image_id ) && $to_name_font_size=="Small"  ){ echo "selected";} ?>   value="Small">Small</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $to_name_font_size=="Large"  ){ echo "selected";} ?>   value="Large">Large</option>


                          </select>
                    </div>

                  </div>


               </span>
</fieldset>

  <fieldset class="scheduler-border">
                <legend  class="scheduler-border">From Name Details</legend>

               <div class="form-group row">
                <label for="show_from_name" class="col-sm-2 col-form-label">Show From Name?</label>
                <div class="col-sm-4">
                  <select id="show_from_name"   class="form-control single-select" name="show_from_name" type="text" onchange="showFromName();"  required=""  >
                     
                      <option <?php if(isset($seasonal_greet_image_id ) && $show_from_name=="Yes" ){ echo "selected";} ?>   value="Yes">Yes</option>
                      <option  <?php if(isset($seasonal_greet_image_id ) && $show_from_name=="No" ){ echo "selected";} ?>  value="No">No</option> 
                     
                  </select>
                </div>
               </div>


              <span id="from_name_div"  <?php if(isset($seasonal_greet_image_id ) && $show_from_name=="No" ){?> style="display: none;" <?php } ?> >
               <div   class="form-group row" >
               <label class="col-lg-2 col-form-label form-control-label">From Name Font Color (select or type) </label>
                  <div class="col-lg-2">
               <input type="color" id="from_name_font_color" name="from_name_font_color" value="<?php if($seasonal_greet_image_id ){ echo $from_name_font_color; } ?>">
             </div>
                <div class="col-lg-2">
               <input type="text" class="form-control"  id="from_name_font_color_text" name="from_name_font_color_text" value="<?php if($seasonal_greet_image_id ){ echo $from_name_font_color; } ?>"> 
             </div>



            


                     <label for="background_image" class="col-sm-2 col-form-label">From Text Alignment</label>
                <div class="col-sm-4">
                   <select type="text"   id="from_text_alignment" 
                 class="form-control single-select" name="from_text_alignment">
                     
                     <option <?php if(isset($seasonal_greet_image_id ) && $from_text_alignment=="Start"  ){ echo "selected";} ?>   value="Start">Start</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $from_text_alignment=="Center"  ){ echo "selected";} ?>   value="Center">Center</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $from_text_alignment=="End"  ){ echo "selected";} ?>   value="End">End</option>


                       <option <?php if(isset($seasonal_greet_image_id ) && $from_text_alignment=="Left"  ){ echo "selected";} ?>   value="Left">Left</option>
                       <option <?php if(isset($seasonal_greet_image_id ) && $from_text_alignment=="Right"  ){ echo "selected";} ?>   value="Right">Right</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $from_text_alignment=="Top"  ){ echo "selected";} ?>   value="Top">Top</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $from_text_alignment=="Bottom"  ){ echo "selected";} ?>   value="Bottom">Bottom</option>
                    </select>
                </div>


                </div>


<div   class="form-group row" >
                 <label class="col-lg-2 col-form-label form-control-label">From Name Font Name <span class="required">*</span> </label>
                  <div class="col-lg-2">
                  <select type="text"  onchange="fromNameDemo();"  id="from_name_font_name" 
                 class="form-control single-select" name="from_name_font_name">
             <option value="">-- Select --</option>
                           <?php 
                            for ($l=0; $l < count($font_master_data) ; $l++) { 
                              ?>
                              <option  <?php if(isset($seasonal_greet_image_id ) && $from_name_font_name==$font_master_data[$l]['font_name'] ){ echo "selected";} ?>  value="<?php echo $font_master_data[$l]['font_name']; ?>"><?php echo $font_master_data[$l]['font_name']; ?></option>
                            <?php } ?> 
                          </select>
                    </div>

                   
 <label class="col-lg-2 col-form-label form-control-label" id="demo_from_text"> </label>


<label class="col-lg-2 col-form-label form-control-label">From Name Font Size</label>                
<div class="col-lg-4">
                  <select type="text"    id="from_name_font_size" 
                 class="form-control single-select" name="from_name_font_size">
             
                       <option <?php if(isset($seasonal_greet_image_id ) && $from_name_font_size=="Medium"  ){ echo "selected";} ?>   value="Medium">Medium</option>
                       <option <?php if(isset($seasonal_greet_image_id ) && $from_name_font_size=="Small"  ){ echo "selected";} ?>   value="Small">Small</option>
                      <option <?php if(isset($seasonal_greet_image_id ) && $from_name_font_size=="Large"  ){ echo "selected";} ?>   value="Large">Large</option>


                          </select>
                    </div>

                  </div>



               </span>
  </fieldset>
  <fieldset class="scheduler-border">
                <legend  class="scheduler-border">Other Details</legend>
            <div   class="form-group row" >
              <label class="col-lg-2 col-form-label form-control-label">Status </label>
                  <div class="col-lg-4">
                  <select type="text"   id="status" 
                 class="form-control single-select" name="status">
                    <option  <?php if(isset($seasonal_greet_image_id ) && $status=="Active" ){ echo "selected";} ?> value="Active">Active</option>
                    <option <?php if(isset($seasonal_greet_image_id ) && $status=="InActive" ){ echo "selected";} ?>  value="InActive">InActive</option>        
                          </select>
                    </div>
            </div>
         </fieldset>       
                <div class="form-footer text-center">
                  
                  <?php  if(isset($seasonal_greet_image_id )){ ?>
                  <input type="hidden" name="seasonal_greet_image_id" value="<?php echo $seasonal_greet_image_id;?>">
                  <button type="submit" name="updateSeasonalGreetImage" class="btn btn-success"><i class="fa fa-check-square-o"></i> UPDATE</button>
                  <?php  } else {?>
                  <button type="submit" name="addSeasonalGreetImage" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                  <?php }?>
                  <a href="manageSeasonalGreet?seasonal_greet_id=<?php echo $seasonal_greet_id;?>" class="btn btn-danger">Cancel</a>
                  
                </div>
              </form>
            </div>
          </div>
        </div>
        </div><!--End Row-->
      </div>
      <!-- End container-fluid-->
      </div><!--End content-wrapper-->
      <script type="text/javascript">
       

      </script>