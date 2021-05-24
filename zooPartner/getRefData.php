<?php 
error_reporting(0);
include_once 'lib/dao.php';
include 'lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input" , $_POST));

$qq=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","users_master.user_id='$user_id'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  ","");
$userData=mysqli_fetch_array($qq);
extract($userData);

?>

 
      <input type="hidden" name="refer_user_id" value="<?php echo $user_id;?>">
      <input type="hidden" name="returnReport" value="referralReport">
      <input type="hidden" name="refer_by_new" value="<?php echo $refer_by;?>">
      <input type="hidden" name="fromDate_new" value="<?php echo $fromDate;?>">
      <input type="hidden" name="toDate_new" value="<?php echo $toDate;?>">
      
      <div class="form-group row">
        <label class="col-lg-2 col-form-label form-control-label">Refer By <span class="required">*</span></label>
        <div class="col-lg-10">
          <select <?php if(strtotime($today) >   strtotime($validDateToEdit) && 0   ) { 
            echo "disabled";  } ?>  id="refer_by" onchange="referBy();" class="form-control single-select" name="refer_by" required=""   >
            <option value="">-- Select --</option>
            <option <?php if($refer_by==1){ echo "selected";} ?> value="1">Social Media</option>
            <option  <?php if($refer_by==2){ echo "selected";} ?> value="2">Member / Friend</option>
            <option   <?php if($refer_by==3){ echo "selected";} ?> value="3">Other</option>
          </select>
        </div>

      </div>

      <div class="form-group row">
        <label  <?php if($refer_by==2){  }  else {?> style="display: none" <?php } ?>  id="refere_by_name_lbl" class="col-lg-2 col-form-label form-control-label">Refer By Name <span class="required">*</span></label>
        <div  <?php if($refer_by==2){  }  else {?> style="display: none"   <?php } ?> class="col-lg-4" id="refere_by_name_div">
          <input <?php if(strtotime($today) >   strtotime($validDateToEdit) && 0  ) { 
            echo "disabled";  } ?>    class="form-control" name="refere_by_name"  maxlength="60" minlength="3"  type="text" value="<?php echo $refere_by_name;?>" id="refere_by_name" >
          </div>

          <label <?php if($refer_by==2){  }  else {?> style="display: none"  <?php } ?> id="refere_by_phone_number_lbl" class="col-lg-2 col-form-label form-control-label">Refer Perosn Number <span class="required">*</span></label>
          <div <?php if($refer_by==2){  }  else {?> style="display: none" <?php } ?> class="col-lg-4" id="refere_by_phone_number_div">
            <input  <?php if(strtotime($today) >   strtotime($validDateToEdit)  && 0  ) { 
              echo "disabled";  } ?>   class="form-control onlyNumber" name="refere_by_phone_number"  maxlength="10" minlength="3"  type="text" value="<?php echo $refere_by_phone_number;?>" id="refere_by_phone_number">
            </div>


            <label <?php if($refer_by==3){  }  else {?>  style="display: none" <?php }?>  id="remark_lbl" class="col-lg-2 col-form-label form-control-label">Remarks</label>
            <div <?php if($refer_by==3){  }  else {?>  style="display: none" <?php }?>  class="col-lg-10" id="remark_div">
              <input  <?php if(strtotime($today) >   strtotime($validDateToEdit) && 0   ) { 
                echo "disabled";  } ?>   class="form-control" name="remark"  maxlength="100" minlength="3"  type="text" value="<?php echo $remark;?>" >
              </div>
            </div>
            <?php 

if($userData['active_status']=="0"){
            if(strtotime($today) <=   strtotime($validDateToEdit) || 1 ) { 
              if ($refer_by!='0'   || 1 ) { ?> 
                <div class="form-group row">
                  <div class="col-lg-12 text-center">
                    <input type="submit" id="socAddBtn" class="btn btn-primary" name=""  value="Update">
                  </div>
                </div>

              <?php }
            } 
          } ?> 
        