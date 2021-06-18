<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
                 <div class="col-md-6">
            <?php //IS_572  signupForm to addGallary ?> 
             <form id="utilityFrm" method="post" action="controller/utilityBannerController.php" enctype="multipart/form-data">
              <h4 class="form-header text-uppercase">
              <i class="fa fa-address-book-o"></i>
              Add Utility Banner Images 
              </h4>

              <div class="form-group row">
                <label for="input-12" class="col-sm-4 col-form-label">Frame <span class="required">*</span></label>
                <div class="col-sm-8">

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
                <label for="banner_image" class="col-sm-4 col-form-label">Banner Image <span class="required">*</span></label>
                <div class="col-sm-8">
                  <input class="form-control-file border"  multiple accept="image/*" required="" type="file"  name="banner_image[]">
                </div>
              </div>
               
               

              

              
              <div class="form-footer text-center">
                <button type="submit" class="btn btn-success" name = "addUtilityBannerImage"><i class="fa fa-check-square-o"></i> SAVE</button>
               <a href="utilityBanners" class="btn btn-danger">Cancel</a>
              </div>
            </form>
           </div>

            <div class="col-md-6" style="display: inline-block; float: left" id="frame_img">
            </div>
          </div>

          </div>
        </div>
      </div>
      </div><!--End Row-->
    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->

<script src="assets/js/jquery.min.js"></script>

      <script type="text/javascript">
//IS_988
         $( "#addGallary" ).submit(function( event ) {
  var error = 0;
  
 var fp = $("#galary_photos");
               var lg = fp[0].files.length; // get length
               var items = fp[0].files;
               var fileSize = 0;
           
           if (lg > 0) {
               for (var i = 0; i < lg; i++) {
                   fileSize = fileSize+items[i].size; // get file size

                   if(  items[i].size > 2097152) {
                    error++;
                    $('#galary_photos_div').css('color','#ff0000');
                    $('#galary_photos_div').css('text-transform','uppercase');
                    $('#galary_photos_div').css('font-size','.75rem');
                    $('#galary_photos_div').css('font-weight','600');
                    
                    $('#galary_photos_div').text('each file size must be less than or equal to 2MB.');
                  }
               }
               
           }
   if(error==0){
    $('#galary_photos_div').text('');
   }
  if(error > 0 ){
    event.preventDefault();
    $('#galary_photos_div').css('color','#ff0000');
    $('#galary_photos_div').css('text-transform','uppercase');
    $('#galary_photos_div').css('font-size','.75rem');
    $('#galary_photos_div').css('font-weight','600');
    
    $('#galary_photos_div').text('each file size must be less than or equal to 2MB.');
  } else {
    $( "#addGallary" ).submit();
  }
  
});
// /IS_988

        


      $(document).ready(function() {
          $('#otherDiv').hide();
          
          $('.check').change(function(){
            var data= $(this).val();
             if(data==0) {
              $('#otherDiv').show();
             } else {
              $('#otherDiv').hide();
             }          
          });
        
      });
  </script>