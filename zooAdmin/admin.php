<?php  error_reporting(0);
extract($_REQUEST);
if(isset($zoobiz_admin_id_edit)){
$zoobiz_admin_master=$d->select("zoobiz_admin_master","  zoobiz_admin_id= '$zoobiz_admin_id_edit' ","");
$zoobiz_admin_master_data=mysqli_fetch_array($zoobiz_admin_master);
extract($zoobiz_admin_master_data);
}
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <?php if(isset($zoobiz_admin_id_edit)){?>
        <h4 class="page-title">Edit Admin</h4>
        <?php  } else {?>
        <h4 class="page-title">Add Admin</h4>
        <?php } ?>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="adminList" > Admin List</a></li>
            <li class="breadcrumb-item active" aria-current="page">  <?php if(isset($zoobiz_admin_id_edit)){?>
        Edit Admin 
        <?php  } else {?>
        Add Admin 
        <?php } ?></li>
         </ol>
      </div>
      
    </div>
    <!-- End Breadcrumb-->
    
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            
            <form autocomplete="off" id="adminFrm" action="controller/adminController.php" method="post" enctype="multipart/form-data">
              <?php
              if(isset($zoobiz_admin_id_edit)){
                ?>
                 <input type="hidden" name="zoobiz_admin_id_edit" value="<?php echo $zoobiz_admin_id_edit;?>">
<input type="hidden" name="isedit" id="isedit" value="yes">
                <?php
              } else { ?>
                 <input type="hidden" name="zoobiz_admin_id_edit" value="0">
               <input type="hidden" name="isedit" id="isedit" value="no">
             <?php  } ?>
              <fieldset class="scheduler-border">
                <legend  class="scheduler-border">Admin Details</legend>

 <div class="form-group row">
                 <label class="col-lg-2 col-form-label form-control-label">Role <span class="required">*</span></label>
                      <div class="col-lg-10">
                         <select id="role_id" required="" class="form-control single-select" name="role_id" type="text"  onchange="planDetails();">
                            <option value="">-- Select --</option>
                            <?php $qb=$d->select("role_master","role_status=0","");
                            while ($bData=mysqli_fetch_array($qb)) {?>
                              <option <?php if(isset($zoobiz_admin_id_edit) &&  $bData['role_id']== $role_id ){  echo "selected";} ?>   value="<?php echo $bData['role_id']; ?>"><?php echo $bData['role_name']; ?></option>
                            <?php } ?> 
                          </select>
                         
                      </div>
</div>

                <div class="form-group row">
                  
                  <label class="col-lg-2 col-form-label form-control-label">Admin Name <span class="required">*</span></label>
                  <div class="col-lg-10">
                    <input  required="" type="text" class="form-control" name="admin_name" id="admin_name" value="<?php if(isset($zoobiz_admin_id_edit)){  echo $admin_name;} ?>" placeholder="Admin Name" minlength="3" maxlength="80"  >
                    
                  </div>
                 
                </div>

                <div class="form-group row">
                  
                  <label class="col-lg-2 col-form-label form-control-label">Admin Email <span class="required">*</span></label>
                  <div class="col-lg-10">
                    <input readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','');"  autocomplete="off"   required="" type="email" class="form-control" name="admin_email" id="admin_email" value="<?php if(isset($zoobiz_admin_id_edit)){  echo $admin_email;} ?>" placeholder="Admin Email" minlength="3" maxlength="80"  >
                    
                  </div>
                 
                </div>

                 <div class="form-group row">
                  
                  <label class="col-lg-2 col-form-label form-control-label">Admin Mobile <span class="required">*</span></label>
                  <div class="col-lg-10">
                    <input  readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','');"  autocomplete="off"   onblur="checkMobileAdmin()"    maxlength="10" minlength="10"  required="" type="text" class="form-control onlyNumber" name="admin_mobile" id="admin_mobile" value="<?php if(isset($zoobiz_admin_id_edit)){  echo $admin_mobile;} ?>" placeholder="Admin Mobile"   >
                    
                  </div>
                 
                </div>

<?php if(isset($zoobiz_admin_id_edit)){ } else {  ?> 
                 <div class="form-group row">
          <label class="col-lg-2 col-form-label form-control-label">Password <span class="required">*</span></label>
          <div class="col-lg-4">
            <input  readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','');"  autocomplete="off"   class="form-control" minlength="5" maxlength="50" required="" type="password" name="password" id="password" value="">
          </div>
       
          <label class="col-lg-2 col-form-label form-control-label">Confirm password <span class="required">*</span></label>
          <div class="col-lg-4">
            <input  readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','');" class="form-control" minlength="5" maxlength="50" required="" name="password2" type="password" value="">
          </div>
        </div>
<?php } ?>
        <div class="form-group row">
          <label class="col-lg-2 col-form-label form-control-label">Profile<span class="required">*</span></label>
          <div class="col-lg-10">
            <input class="form-control-file border photoOnly" id="imgInp" accept="image/*" name="admin_profile" type="file">
            <?php if(isset($zoobiz_admin_id_edit)){
            ?> 
          <input class="form-control-file border photoOnly"     name="admin_profile_old" type="hidden" value="<?php echo $admin_profile?>">
        <?php  }?>
             </div>
        </div>
  </fieldset>
               
              <div class="form-footer text-center">
                  
                <?php  if(isset($zoobiz_admin_id_edit)){ ?>
               
                <button type="submit" name="cpnEditBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> UPDATE</button>
                <?php  } else {?>
                <button type="submit" name="admAddBtn" id="admAddBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
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