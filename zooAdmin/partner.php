<?php  error_reporting(0);
extract($_REQUEST);
if(isset($zoobiz_partner_id_edit)){
$zoobiz_partner_master=$d->select("zoobiz_partner_master","  zoobiz_partner_id= '$zoobiz_partner_id_edit' ","");
$zoobiz_partner_master_data=mysqli_fetch_array($zoobiz_partner_master);
extract($zoobiz_partner_master_data);
}
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <?php if(isset($zoobiz_partner_id_edit)){?>
        <h4 class="page-title">Edit Partner</h4>
        <?php  } else {?>
        <h4 class="page-title">Add Partner</h4>
        <?php } ?>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="partnerList" > Partner List</a></li>
            <li class="breadcrumb-item active" aria-current="page">  <?php if(isset($zoobiz_partner_id_edit)){?>
        Edit Partner 
        <?php  } else {?>
        Add Partner 
        <?php } ?></li>
         </ol>
      </div>
      
    </div>
    <!-- End Breadcrumb-->
    
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            
            <form autocomplete="off" id="partnerFrm" action="controller/partnerController.php" method="post" enctype="multipart/form-data">
              <?php
              if(isset($zoobiz_partner_id_edit)){
                ?>
                 <input type="hidden" name="zoobiz_partner_id_edit" value="<?php echo $zoobiz_partner_id_edit;?>">
<input type="hidden" name="isedit" id="isedit" value="yes">
                <?php
              } else { ?>
                 <input type="hidden" name="zoobiz_partner_id_edit" value="0">
               <input type="hidden" name="isedit" id="isedit" value="no">
             <?php  } ?>
              <fieldset class="scheduler-border">
                <legend  class="scheduler-border">Partner Details</legend>

<div class="form-group row">
                  <label for="country_id" class="col-sm-2 col-form-label"> Country <span class="required">*</span></label>
                  <div class="col-sm-4">
                    <select type="text" required="" id="country_id" onchange="getStates();" class="form-control single-select" name="country_id">
                      <option value="">-- Select --</option>
                      <?php 
                        $q3=$d->select("countries","flag=1","");
                         while ($blockRow=mysqli_fetch_array($q3)) {
                       ?>
                        <option   <?php if(  isset($zoobiz_partner_id_edit) && $country_id==$blockRow['country_id']) {echo "selected";} ?> value="<?php echo $blockRow['country_id'];?>"><?php echo $blockRow['country_name'];?></option>
                        <?php }?>
                      </select>
                  </div>
                   <label for="state_id" class="col-sm-2 col-form-label"> State <span class="required">*</span></label>
                  <div class="col-sm-4">
                       <?php  if(isset($zoobiz_partner_id_edit)) { ?>
                      <select type="text" onchange="getCity();"  required="" class="form-control single-select" id="state_id" name="state_id">
                        <?php
                        
                           $q31=$d->select("states","country_id='$country_id'","");
                          while ($blockRow11=mysqli_fetch_array($q31)) {
                           ?>
                           <option <?php if( isset($zoobiz_partner_id_edit) && $state_id==$blockRow11['state_id']) {echo "selected";} ?> value="<?php echo $blockRow11['state_id'];?>"><?php echo $blockRow11['state_name'];?></option>
                          <?php }  ?>
                      </select>
                      <?php } else { ?>
                      <select type="text" onchange="getCity();"  required="" class="form-control single-select" id="state_id" name="state_id">
                      <option value="">-- Select --</option>
                      </select>
                      <?php } ?>
                  </div>
                  
                </div>

                <div class="form-group row">
                  <label for="input-101" class="col-sm-2 col-form-label"> City <span class="required">*</span></label>
                  <div class="col-sm-10">
                      <?php  if(isset($zoobiz_partner_id_edit)) {   ?>
                      <select type="text"   multiple="multiple"   required="" class="form-control multiple-select "   name="city_id[]" id="city_id">
                        <?php
                           $q34=$d->select("cities","state_id='$state_id'","");
                           $city_id = explode(",", $city_id);
                          while ($blockRow12=mysqli_fetch_array($q34)) {
                           


                           ?>
                           <option <?php if( isset($zoobiz_partner_id_edit) && in_array($blockRow12['city_id'], $city_id)   ) {echo "selected";} ?> value="<?php echo $blockRow12['city_id'];?>"><?php echo $blockRow12['city_name'];?></option>
                          <?php }  ?>
                      </select>
                      <?php } else { ?>
                      <select  type="text"   multiple="multiple"  required="" class="form-control multiple-select" name="city_id[]" id="city_id">
                      <option value="">-- Select --</option>
                      
                      </select>
                      <?php } ?>
                  </div>
                </div>
 <div class="form-group row">
                 <label class="col-lg-2 col-form-label form-control-label">Role <span class="required">*</span></label>
                      <div class="col-lg-10">
                         <select id="role_id" required="" class="form-control single-select" name="role_id" type="text"  onchange="planDetails();">
                            <option value="">-- Select --</option>
                            <?php $qb=$d->select("role_master","role_status=0","");
                            while ($bData=mysqli_fetch_array($qb)) {?>
                              <option <?php if(isset($zoobiz_partner_id_edit) &&  $bData['role_id']== $role_id ){  echo "selected";} ?>   value="<?php echo $bData['role_id']; ?>"><?php echo $bData['role_name']; ?></option>
                            <?php } ?> 
                          </select>
                         
                      </div>
</div>

                <div class="form-group row">
                  
                  <label class="col-lg-2 col-form-label form-control-label">Parner Name <span class="required">*</span></label>
                  <div class="col-lg-10">
                    <input  required="" type="text" class="form-control" name="partner_name" id="partner_name" value="<?php if(isset($zoobiz_partner_id_edit)){  echo $partner_name;} ?>" placeholder="Partner Name" minlength="3" maxlength="80"  >
                    
                  </div>
                 
                </div>

                

                 <div class="form-group row">
                  
                  <label class="col-lg-2 col-form-label form-control-label">Parner Mobile <span class="required">*</span></label>
                  <div class="col-lg-10">
                    <input  readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','');"  autocomplete="off"   onblur="checkMobileAdmin()"    maxlength="10" minlength="10"  required="" type="text" class="form-control onlyNumber" name="partner_mobile" id="partner_mobile" value="<?php if(isset($zoobiz_partner_id_edit)){  echo $partner_mobile;} ?>" placeholder="Partner Mobile"   >
                    
                  </div>
                 
                </div>

 
        <div class="form-group row">
          <label class="col-lg-2 col-form-label form-control-label">Profile<span class="required">*</span></label>
          <div class="col-lg-10">
            <input class="form-control-file border photoOnly" id="imgInp" accept="image/*" name="partner_profile" type="file">
            <?php if(isset($zoobiz_partner_id_edit)){
            ?> 
          <input class="form-control-file border photoOnly"     name="partner_profile_old" type="hidden" value="<?php echo $partner_profile?>">
        <?php  }?>
             </div>
        </div>
  </fieldset>
               
              <div class="form-footer text-center">
                  
                <?php  if(isset($zoobiz_partner_id_edit)){ ?>
               
                <button type="submit" name="prtEditBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> UPDATE</button>
                <?php  } else {?>
                <button type="submit" name="prtAddBtn" id="prtAddBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                <?php }?>
                <button type="reset" class="btn btn-danger"><i class="fa fa-times"></i> RESET</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      </div><!--End Row-->
    </div>
    <!-- End container-fluid-->
    </div><!--End content-wrapper-->