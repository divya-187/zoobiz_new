<?php
	  extract($_POST);?>
<div class="content-wrapper">
  <div class="container-fluid">

      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">Custom Settings</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Custom Settings</li>
         </ol>
       </div>
       
   </div>
   <!-- End Breadcrumb-->

  	 <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">

            <fieldset class="scheduler-border">
                <legend  class="scheduler-border"> FCM Settings</legend>  
          	<?php
          	
            
              $getData = $d->select("custom_settings_master"," status = 0 and flag=0 ","");
              $data = mysqli_fetch_array($getData);
            


          		?>
 
          		 <form id="customFrm" action="controller/customController.php" method="POST" enctype="multipart/form-data">
              
             
              
              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Send FCM <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                   <?php 
                   if( mysqli_num_rows($getData) > 0){ 
                   if(   $data['send_fcm']=="1"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $data['custom_id']; ?>','fcmDeactive');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $data['custom_id']; ?>','fcmActive');" data-size="small"/>
                        <?php }
                } else { ?> 
                   <div class="col-lg-4">
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio" checked="" class="form-check-input" value="0" name="send_fcm"> No
                          </label>
                        </div>
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio"   class="form-check-input" value="1" name="send_fcm"> Yes
                          </label>
                        </div>
                      </div>
            <?php } ?>
                </div>
              </div>

              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">nOTIFY uSER Within City <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                   <?php 
                   if( mysqli_num_rows($getData) > 0){ 
                   if(   $data['share_within_city']=="1"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $data['custom_id']; ?>','withinCityDeactive');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $data['custom_id']; ?>','withinCityActive');" data-size="small"/>
                        <?php }
                } else { ?> 
                   <div class="col-lg-4">
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio" checked="" class="form-check-input" value="0" name="share_within_city"> No
                          </label>
                        </div>
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio"   class="form-check-input" value="1" name="share_within_city"> Yes
                          </label>
                        </div>
                      </div>
            <?php } ?>
                </div>
              </div>

              <div class="form-group row">
                <label for="fcm_content" class="col-sm-2 col-form-label">Content <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                   <textarea  minlength="1" maxlength="250" value="" rows="8"   class="form-control" id="fcm_content" name="fcm_content"><?php 
                   if(mysqli_num_rows($getData) > 0  ){
                   echo $data['fcm_content'];
                 }?></textarea>

                 include <b>USER_NAME</b> to send User Name,<b>COMPANY_NAME</b> to send User's Business Name and <b>CAT_NAME</b> to send Category Name , press <b>Enter</b> for New line in FCM Message
                </div>
              </div>
             
            
              <div class="form-footer text-center">
                <?php if(mysqli_num_rows($getData) > 0  ){ ?>
                  <input style="display: none;" type="radio" checked="" class="form-check-input" value="<?php echo $data['send_fcm'];?>" name="send_fcm">
                   
                  <input type="hidden" name="custom_id" value="<?php echo $data['custom_id'];?>">
                <button name="updateCustomData" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
              <?php } else { ?>
               <button name="addCustomData" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save</button>
                <?php } ?> 
              </div>
            </form>
          		</fieldset>


<fieldset class="scheduler-border">
                <legend  class="scheduler-border">New User Welcome Message</legend>  
            <?php
            
            
              $getData = $d->select("custom_settings_master"," status = 0 and flag = 1 ","");
              $data = mysqli_fetch_array($getData);
            


              ?>
 
               <form id="customFrm2" action="controller/customController.php" method="POST" enctype="multipart/form-data">
              
             
              
               <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Send Message <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                   <?php 
                   if( mysqli_num_rows($getData) > 0){ 
                   if(   $data['send_fcm']=="1"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $data['custom_id']; ?>','fcmDeactive');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $data['custom_id']; ?>','fcmActive');" data-size="small"/>
                        <?php }
                } else { ?> 
                   <div class="col-lg-4">
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio" checked="" class="form-check-input" value="0" name="send_fcm"> No
                          </label>
                        </div>
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio"   class="form-check-input" value="1" name="send_fcm"> Yes
                          </label>
                        </div>
                      </div>
            <?php } ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="fcm_content" class="col-sm-2 col-form-label">Welcome Message <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                   <textarea  minlength="1" maxlength="500" value="" rows="8"   class="form-control" id="fcm_content" name="fcm_content"><?php 
                   if(mysqli_num_rows($getData) > 0  ){
                   echo $data['fcm_content'];
                 }?></textarea>

                 include <b>USER_FULL_NAME</b> to send User Full Name and <b>ANDROID_LINK</b> to Android Link <b>IOS_LINK</b> to iOS Link, press <b>Enter</b> for New line  in Message
                </div>
              </div>
             
            
              <div class="form-footer text-center">
                <?php if(mysqli_num_rows($getData) > 0  ){ ?>
                  <input style="display: none;" type="radio" checked="" class="form-check-input" value="<?php echo $data['send_fcm'];?>" name="send_fcm">
                   
                  <input type="hidden" name="custom_id" value="<?php echo $data['custom_id'];?>">
                <button name="updateWelcomeData" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
              <?php } else { ?>
               <button name="addWelcomeData" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save</button>
                <?php } ?> 
              </div>
            </form>
              </fieldset>


          <fieldset class="scheduler-border">
                <legend  class="scheduler-border">ZooBiz Admin Notification</legend>  
           
 
               <form id="adminNotiFrm" action="controller/customController.php" method="POST" enctype="multipart/form-data">
              
             
              
              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">ZooBiz Admins</label>


            
                      <div class="col-lg-10">
                        

 <?php    $zoobiz_admin_master = $d->select("zoobiz_admin_master, role_master","  role_master.role_id =zoobiz_admin_master.role_id and  zoobiz_admin_master.admin_mobile != 0 and zoobiz_admin_master.status = 0  ","");
     while ($bData=mysqli_fetch_array($zoobiz_admin_master)) {?>
                          <label  style="margin-left: -30px;" class="custom-control custom-checkbox error_color">

                      

                      <input <?php  if( $bData['send_notification'] =="1"){ echo "checked"; } ?> type="checkbox" class="pagePrivilege" value="<?php echo $bData['zoobiz_admin_id']; ?>" name="zoobiz_admin_id[]">

                      <span class="custom-control-indicator"></span>

                      <span class="custom-control-description"><b><?php echo $bData['admin_name']; ?>  ( <?php echo $bData['role_name']; ?> )</b></span>

                    </label>
<?php } ?> 
</div>
</div>
               
             
            
              <div class="form-footer text-center">
                
               <button name="adminNotificationData" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save</button>
                
              </div>
            </form>
              </fieldset>


 <fieldset class="scheduler-border">
                <legend  class="scheduler-border">Misc Settings</legend>  
           
<div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Is_IAP_Payment <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                   <?php 
                    $zoobiz_settings_master = $d->select("zoobiz_settings_master","","");
                if( mysqli_num_rows($zoobiz_settings_master) > 0){ 

                   $zoobiz_settings_masterData = mysqli_fetch_array($zoobiz_settings_master);
                
                   if(   $zoobiz_settings_masterData['Is_IAP_Payment']=="true"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $zoobiz_settings_masterData['setting_id']; ?>','Is_IAP_PaymentFalse');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $zoobiz_settings_masterData['setting_id']; ?>','Is_IAP_PaymentTrue');" data-size="small"/>
                        <?php }
                }   ?>
                </div>
              </div>



      <?php //11march21 ?>
      <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">IS UPI <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                   <?php 
                    $zoobiz_settings_master = $d->select("zoobiz_settings_master","","");
                if( mysqli_num_rows($zoobiz_settings_master) > 0){ 

                   $zoobiz_settings_masterData = mysqli_fetch_array($zoobiz_settings_master);
                
                   if(   $zoobiz_settings_masterData['is_upi']=="1"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $zoobiz_settings_masterData['setting_id']; ?>','is_upiFalse');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $zoobiz_settings_masterData['setting_id']; ?>','is_upiTrue');" data-size="small"/>
                        <?php }
                }   ?>
                </div>
              </div>

              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Show Members Citywise? <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                   <?php 
                    $zoobiz_settings_master = $d->select("zoobiz_settings_master","","");
                if( mysqli_num_rows($zoobiz_settings_master) > 0){ 

                   $zoobiz_settings_masterData = mysqli_fetch_array($zoobiz_settings_master);
                
                   if(   $zoobiz_settings_masterData['show_member_citywise']=="1"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $zoobiz_settings_masterData['setting_id']; ?>','MemberCityWiseFalse');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $zoobiz_settings_masterData['setting_id']; ?>','MemberCityWiseTrue');" data-size="small"/>
                        <?php }
                }   ?>
                </div>
              </div>


              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Enable Member Capacity (City/Subcategory) <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                   <?php 
                    $zoobiz_settings_master = $d->select("zoobiz_settings_master","","");
                if( mysqli_num_rows($zoobiz_settings_master) > 0){ 

                   $zoobiz_settings_masterData = mysqli_fetch_array($zoobiz_settings_master);
                
                   if(   $zoobiz_settings_masterData['enable_max_member_facility']=="1"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $zoobiz_settings_masterData['setting_id']; ?>','DisableMaxCapacity');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $zoobiz_settings_masterData['setting_id']; ?>','EnableMaxCapacity');" data-size="small"/>
                        <?php }
                }   ?>
                </div>
              </div>


              <?php  $zoobiz_settings_master = $d->select("zoobiz_settings_master","","");
                

                   $zoobiz_settings_masterData = mysqli_fetch_array($zoobiz_settings_master);
                   extract($zoobiz_settings_masterData);
                   if(   $zoobiz_settings_masterData['enable_max_member_facility']=="1"){
                   ?>
 <form id="customFrmA" action="controller/customController.php" method="POST" enctype="multipart/form-data">
               <div class="form-group row">
                       <label class="col-lg-2 col-form-label form-control-label">Max Allowed member per City/Category <span class="required">*</span></label>
                      <div class="col-lg-4">
                        <input minlength="1" maxlength="3" max="100"  class="form-control onlyNumber" name="max_member_per_subcategory" type="text" value="<?php echo $max_member_per_subcategory; ?>" required="">
                      </div>
                    </div>
  <div class="form-footer text-center">
    <input type="hidden" name="setting_id" value="<?php echo $setting_id;?>">
                     <button name="updateMisc" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
                   </div>

  </form>
      <?php  } //11march21 ?>
</fieldset>

<fieldset class="scheduler-border">
                <legend  class="scheduler-border">Classified Reminder Settings</legend>  
                <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Enable Classified  Reminder <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                   <?php 
                    $zoobiz_settings_master = $d->select("zoobiz_settings_master","","");
                

                   $zoobiz_settings_masterData = mysqli_fetch_array($zoobiz_settings_master);
                
                   if(   $zoobiz_settings_masterData['classified_reminder_flag']=="1"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $zoobiz_settings_masterData['setting_id']; ?>','DisableClRem');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $zoobiz_settings_masterData['setting_id']; ?>','EnableClRem');" data-size="small"/>
                        <?php }
                   ?>
                </div>
              </div>
 
              <?php   
                   if(   $zoobiz_settings_masterData['classified_reminder_flag']=="1"){
                   ?>
 <form id="customFrmA" action="controller/customController.php" method="POST" enctype="multipart/form-data">
               <div class="form-group row">
                       <label class="col-lg-2 col-form-label form-control-label">Classified Reminder Days <span class="required">*</span></label>
                      <div class="col-lg-4">
                        <input minlength="1" maxlength="3" max="100"  class="form-control  " name="classified_reminder_days" type="text" value="<?php echo $classified_reminder_days; ?>" required="">
                      </div>
                    </div>
  <div class="form-footer text-center">
    <input type="hidden" name="setting_id" value="<?php echo $setting_id;?>">
                     <button name="updateMiscCls" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
                   </div>

  </form>
      <?php  } //11march21 ?>
</fieldset>
<fieldset class="scheduler-border">
                <legend  class="scheduler-border">Meetups Reminder Settings</legend>  
                <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Enable Meetups  Reminder <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                   <?php 
                    $zoobiz_settings_master = $d->select("zoobiz_settings_master","","");
                

                   $zoobiz_settings_masterData = mysqli_fetch_array($zoobiz_settings_master);
                
                   if(   $zoobiz_settings_masterData['meetups_reminder_flag']=="1"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $zoobiz_settings_masterData['setting_id']; ?>','DisableMuRem');" data-size="smaluzl"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $zoobiz_settings_masterData['setting_id']; ?>','EnableMuRem');" data-size="small"/>
                        <?php }
                   ?>
                </div>
              </div>
 
              <?php   
                   if(   $zoobiz_settings_masterData['meetups_reminder_flag']=="1"){
                   ?>
 <form id="customFrmA" action="controller/customController.php" method="POST" enctype="multipart/form-data">
               <div class="form-group row">
                       <label class="col-lg-2 col-form-label form-control-label">Meetups Reminder Days <span class="required">*</span></label>
                      <div class="col-lg-4">
                        <input minlength="1" maxlength="3" max="100"  class="form-control  " name="meetup_reminder_days" type="text" value="<?php echo $meetup_reminder_days; ?>" required="">
                      </div>
                    </div>
  <div class="form-footer text-center">
    <input type="hidden" name="setting_id" value="<?php echo $setting_id;?>">
                     <button name="updateMiscMeet" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
                   </div>

  </form>
      <?php  } //11march21 ?>
</fieldset>
<fieldset class="scheduler-border">
                <legend  class="scheduler-border">Timeline Reminder Settings</legend>  
                <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Enable Timeline  Reminder <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                   <?php 
                    $zoobiz_settings_master = $d->select("zoobiz_settings_master","","");
                

                   $zoobiz_settings_masterData = mysqli_fetch_array($zoobiz_settings_master);
                
                   if(   $zoobiz_settings_masterData['timeline_reminer_flag']=="1"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $zoobiz_settings_masterData['setting_id']; ?>','DisableTmRem');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $zoobiz_settings_masterData['setting_id']; ?>','EnableTmRem');" data-size="small"/>
                        <?php }
                   ?>
                </div>
              </div>
 
              <?php   
                   if(   $zoobiz_settings_masterData['timeline_reminer_flag']=="1"){
                   ?>
 <form id="customFrmA" action="controller/customController.php" method="POST" enctype="multipart/form-data">
               <div class="form-group row">
                       <label class="col-lg-2 col-form-label form-control-label">Meetups Reminder Days <span class="required">*</span></label>
                      <div class="col-lg-4">
                        <input minlength="1" maxlength="3" max="100"  class="form-control  " name="timeline_reminder_days" type="text" value="<?php echo $timeline_reminder_days; ?>" required="">
                      </div>
                    </div>
  <div class="form-footer text-center">
    <input type="hidden" name="setting_id" value="<?php echo $setting_id;?>">
                     <button name="updateMiscTimeline" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
                   </div>

  </form>
      <?php  } //11march21 ?>
</fieldset>




<fieldset class="scheduler-border">
  <?php 

  ?>
                <legend  class="scheduler-border">Classifieds Settings</legend>  
                 <form id="customClassifieds" action="controller/customController.php" method="POST" enctype="multipart/form-data">
                <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">Select Multiple Cities <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                   <select id="classifieds_sel_multiple_cities" required="" class="form-control single-select" name="classifieds_sel_multiple_cities" type="text" >
                            <option value="">-- Select --</option>
                            <option  <?php   if(   $classifieds_sel_multiple_cities=="1"){  ?>selected <?php }?> value="1">Yes</option>
                            <option <?php   if(  $classifieds_sel_multiple_cities=="0"){  ?>selected <?php }?> value="0">No</option>
                             
                           
                          </select>
                </div>
              </div>
 
              

               <div class="form-group row">
                       <label class="col-lg-2 col-form-label form-control-label">Maximum Image Select  <span class="required">*</span></label>
                      <div class="col-lg-4">
                        <input minlength="1" maxlength="3" max="100"  class="form-control onlyNumber  " name="classified_max_image_select" type="text" value="<?php echo $classified_max_image_select; ?>" required="">
                      </div>
                    </div>

                      <div class="form-group row">
                       <label class="col-lg-2 col-form-label form-control-label">Maximum Document Select  <span class="required">*</span></label>
                      <div class="col-lg-4">
                        <input minlength="1" maxlength="3" max="100"  class="form-control onlyNumber  " name="classified_max_document_select" type="text" value="<?php echo $classified_max_document_select; ?>" required="">
                      </div>
                    </div>

                    <div class="form-group row">
                       <label class="col-lg-2 col-form-label form-control-label">Maximum Audio Duration (in Miliseconds)  <span class="required">*</span></label>
                      <div class="col-lg-4">
                        <input minlength="1" maxlength="8" max="10000000"  class="form-control onlyNumber " name="classified_max_audio_duration" type="text" value="<?php echo $classified_max_audio_duration; ?>" required="">
                      </div>
                    </div>

  <div class="form-footer text-center">
    <input type="hidden" name="setting_id" value="<?php echo $setting_id;?>">
                     <button name="updateClassifieds" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
                   </div>

  </form>
     
</fieldset>



<fieldset class="scheduler-border">
  <?php 

  ?>
                <legend  class="scheduler-border">App Popup Settings</legend>  
                 <form id="customClassifieds" action="controller/customController.php" method="POST" enctype="multipart/form-data">
                <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">show youtube video Popup?<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                   <select id="show_youtube_video_poup" required="" class="form-control single-select" name="show_youtube_video_poup" type="text" >
                            <option value="">-- Select --</option>
                            <option  <?php   if(   $show_youtube_video_poup=="1"){  ?>selected <?php }?> value="1">Yes</option>
                            <option <?php   if(  $show_youtube_video_poup=="0"){  ?>selected <?php }?> value="0">No</option>
                             
                           
                          </select>
                </div>
              </div>
 
              

               <div class="form-group row">
                       <label class="col-lg-2 col-form-label form-control-label">youtube video Popup link <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input minlength="5" maxlength="255"   class="form-control  " name="youtube_video_poup_link" type="text" value="<?php echo $youtube_video_poup_link; ?>" required="">
                      </div>
                    </div>

                       

  <div class="form-footer text-center">
    <input type="hidden" name="setting_id" value="<?php echo $setting_id;?>">
                     <button name="updateAppPop" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
                   </div>

  </form>
     
</fieldset>

<?php /* 
//31dec2020 ?>
<fieldset class="scheduler-border">
                <legend  class="scheduler-border">SMS API Configurations</legend>  
           
 
               <form id="smsConfigFrm" action="controller/customController.php" method="POST" enctype="multipart/form-data">
              
             
 <?php    $zoobiz_settings_master = $d->select("zoobiz_settings_master","","");

 $zoobiz_settings_master_data=mysqli_fetch_array($zoobiz_settings_master);
      ?>
                 <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">SMS API Link <span class="required">*</span></label>
                  <div class="col-sm-10">
                     <textarea  minlength="1" maxlength="250" value="" required="" class="form-control" id="sms_api_link" name="sms_api_link"><?php echo $zoobiz_settings_master_data['sms_api_link'];?></textarea>
                      <b>CELL_PHONE_NUMBER</b> and ,<b>SMS_CONTENT</b>  are bind dynamically.
                    </div>
                 </div>

                 <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">OTP API Link <span class="required">*</span></label>
                  <div class="col-sm-10">
                     <textarea  minlength="1" maxlength="250" value="" required="" class="form-control" id="otp_api_link" name="otp_api_link"><?php echo $zoobiz_settings_master_data['otp_api_link'];?></textarea>
                     <b>CELL_PHONE_NUMBER</b> and ,<b>OTP_MSG</b>  are bind dynamically.
                    </div>
                 </div>

                 <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Multiple SMS API Link <span class="required">*</span></label>
                  <div class="col-sm-10">
                     <textarea  minlength="1" maxlength="250" value="" required="" class="form-control" id="multiple_sms_link" name="multiple_sms_link"><?php echo $zoobiz_settings_master_data['multiple_sms_link'];?></textarea>
                    </div>
                 </div>
<?php  ?> 
          
              <div class="form-footer text-center">
                
               <button name="editSMSConfData" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save</button>
                
              </div>
            </form>
              </fieldset>
<?php //31dec2020

*/ ?>


          </div>
        </div>
      </div>
      </div><!--End Row-->
  </div>
</div>

