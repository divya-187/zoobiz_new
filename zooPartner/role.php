<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
    <!-- End Breadcrumb-->
     
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <form id="roleFrm" action="controller/menuController.php" method="post" >
                <?php 
                   if(isset($_POST['editRole'])) {
                    extract(array_map("test_input" , $_POST));
                    $q=$d->select("role_master","role_id='$role_id'");
                    $data=mysqli_fetch_array($q);
                    }
                   ?>
                <h4 class="form-header text-uppercase">
                  <i class="fa fa-lock"></i>
                  Role
                </h4>
                <input type="hidden" name="societyId" value="<?php echo $data['society_id']; ?>">
                <div class="form-group row">
                  <label for="input-10" class="col-sm-2 col-form-label">Role Name  <span class="required">*</span></label>
                  <div class="col-sm-4">
                    <?php if(isset($_POST['editRole'])) { ?>
                        <input type="hidden" name="role_id" value="<?php echo $data['role_id']; ?>">
                        <input maxlength="30" minlength="1" type="text" name="role_nameEdit" class="form-control" required data-validation-required-message="Enter Role  Name"  value="<?php echo $data['role_name']; ?>">
                    <?php } else { ?>
                        <input maxlength="30" type="text" name="role_name" class="form-control" required data-validation-required-message="Enter Role Name">
                    <?php } ?>
                  </div>
                  <label for="input-11" class="col-sm-2 col-form-label"> Description <span class="required">*</span></label>
                  <div class="col-sm-4" >
                    <input maxlength="100" type="text" name="role_description" class="form-control"    value="<?php echo $data['role_description']; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  
                  <label for="input-11" class="col-sm-3 col-form-label">User Permissions <span class="required">*</span></label>
                  <div class="col-sm-9" >
                    <div class="controls">
                      <h6>
                        <div class="icheck-material-primary">
                              <input type="checkbox" id="user-checkbox" class="chk_boxes" />
                              <label for="user-checkbox">Check All </label>
                         </div>
                                    
                      </h6>
                     <?php
                      $menuId=$data['menu_id'];
                      $menuId=explode(",", $menuId);

                    $i=1;
                    $q1=$d->select("master_menu","parent_menu_id=0");
                    while ($dataMenu=mysqli_fetch_array($q1)) {
                      $menu_id=$dataMenu['menu_id'];
                    if($dataMenu['parent_menu_id']==0 && $dataMenu['sub_menu']==0) {

                    ?>

                    <label  style="margin-left: -30px;" class="custom-control custom-checkbox error_color">

                      

                      <input <?php if(in_array($menu_id, $menuId)){ echo "checked"; } ?> type="checkbox" class="pagePrivilege" value="<?php echo $dataMenu['menu_id']; ?>" name="menu_id[]">

                      <span class="custom-control-indicator"></span>

                      <span class="custom-control-description"><b><?php echo $dataMenu['menu_name']; ?></b></span>

                    </label>

                    <?php }  else if($dataMenu['sub_menu']==1) {

                    $menu_id=$dataMenu['menu_id'];

                    ?>
                    <label   class=" custom-checkbox error_color">
                      <span class="custom-control-description"><b><?php echo $dataMenu['menu_name']; ?></b></span>

                    </label>
                    <!-- sub menu display -->
                    <?php

                    $s=$d->select("master_menu","parent_menu_id='$menu_id' AND page_status=0");
                    while ($sdata=mysqli_fetch_array($s)) {
                    $sub_menu_id=$sdata['menu_id'];
                    ?>

                    <label class="custom-control custom-checkbox error_color">

                      <input <?php if(in_array($sub_menu_id, $menuId)){ echo "checked"; } ?>  type="checkbox" class="pagePrivilege" value="<?php echo $sdata['menu_id']; ?>" name="menu_id[]">

                      <span class="custom-control-indicator"></span>

                      <span class="custom-control-description"><?php echo $sdata['menu_name']; ?></span>

                    </label>

                    <?php } ?>

                    <?php } } ?>
                </div>
                  </div>
               
                  
                </div>
                
                <div class="form-footer text-center">
                   <?php if(isset($_POST['editRole'])) { ?>
                    <button type="submit" name="updateRole" class="btn btn-success"><i class="fa fa-check-square-o"></i> UPDATE</button>
                  <?php } else { ?>
                    <button name="addRole" value="add Role" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> ADD</button>
                  <?php } ?>
                    <button  type="reset" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div><!--End Row-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
  <!--select icon modal -->
    <script src="../zooAdmin/assets/js/jquery.min.js"></script>
<script type="text/javascript">

  $(function() {

    $('.chk_boxes').click(function() {

        $('.pagePrivilege').prop('checked', this.checked);

    });

});

</script>