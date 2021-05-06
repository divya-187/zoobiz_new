<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title">App Menu</h4>
           <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           <li class="breadcrumb-item"><a href="appMenu">App Menu</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add App Menu</li>
         </ol>
         
         </div>
      </div>
    <!-- End Breadcrumb-->
     
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <form enctype="multipart/form-data" id="appMenuFrmNew" action="controller/appMenuController.php" method="post"  >
                <?php 
                extract(array_map("test_input" , $_POST));
                 if(isset($app_menu_id)) {
                  $btnName="Edit";
                  
                  $q=$d->select("resident_app_menu","app_menu_id='$app_menu_id'");
                  $data=mysqli_fetch_array($q);
                  } else {
                  $btnName="Add";
                  }
                   ?>
                <h4 class="form-header text-uppercase">
                  <i class="fa fa-file"></i>
                  App Menu
                </h4>
                
                <div class="form-group row">

                   <label for="input-11" class="col-sm-2 col-form-label">Parent Menu </label>
                  <div class="col-sm-4" >
                    <select type="text" name="parent_menu_id" class="form-control"  >
                        <option value="0">Main Menu</option>
                        <?php  $q_parent=$d->select("resident_app_menu","parent_menu_id='0'");
                        while ($data_parent=mysqli_fetch_array($q_parent)) {
                          
                        ?>
                        <option value="<?php echo $data_parent['app_menu_id'];?>" <?php if(isset($app_menu_id) && $data['parent_menu_id']==$data_parent['app_menu_id']) { echo "selected";} ?>><?php echo $data_parent['menu_title'];?></option>
                      <?php } ?> 
                        
                    </select>
                  </div>


                  <label for="input-10" class="col-sm-2 col-form-label">App Menu Title <span class="required">*</span></label>
                  <div class="col-sm-4">
                     <input type="text" maxlength="40" maxlength="3" class="form-control" id="input-10" name="menu_title" value="<?php if(isset($app_menu_id)) {  echo $data['menu_title']; } ?>" required="">
                
                  </div>
                
                </div>
                <div class="form-group row">

                    <label for="input-11" class="col-sm-2 col-form-label">Android Menu Click<span class="required">*</span></label>
                  <div class="col-sm-4" >
                    <input type="text" maxlength="50" maxlength="3" class="form-control" id="input-11" name="menu_click"  value="<?php if(isset($app_menu_id)) {  echo $data['menu_click']; } ?>" required="">
                  </div>

                  <label for="input-11" class="col-sm-2 col-form-label">iOS Menu Click<span class="required">*</span></label>
                  <div class="col-sm-4" >
                   <input type="text" maxlength="50" maxlength="3" class="form-control" id="input-11" name="ios_menu_click"  value="<?php if(isset($app_menu_id)) {  echo $data['ios_menu_click']; } ?>" required="">
                  </div>
                 
                </div>
                <div class="form-group row">
                  <label for="input-11" class="col-sm-2 col-form-label">App Icon<span class="required">*</span></label>
                  <div class="col-sm-4" >
                   <input type="file"   class="form-control"  name="menu_icon_new"  required="">
                   <?php if(isset($app_menu_id)) { ?> 
                   <img   src="../img/app_icon/<?php echo $data['menu_icon_new']; ?>"  width="40" height="40"    /></td>
                   <input   type="hidden" name="menu_icon_new" value="<?php if(isset($app_menu_id)) {  echo $data['menu_icon_new']; } ?>">
                  <?php } ?> 
                  </div>

                  <label for="input-11" class="col-sm-2 col-form-label">menu sequence<span class="required">*</span></label>
                  <div class="col-sm-4" >
                    <input maxlength="30"   minlength="1"  type="number" name="menu_sequence" class="form-control" required   value="<?php if(isset($app_menu_id)) {  echo $data['menu_sequence']; } ?>">
                  </div>
                </div>
                <div class="form-group row">
                   <label for="input-10" class="col-sm-2 col-form-label">show youtube video Popup?</label>
                <div class="col-sm-4">
                   <select id="is_show" required="" class="form-control single-select" name="is_show" type="text" >
                            <option value="">-- Select --</option>
                            <option  <?php   if(  isset($app_menu_id) && $data['is_show']=="1"){  ?>selected <?php }?> value="1">Yes</option>
                            <option <?php   if( isset($app_menu_id) && $data['is_show']=="0"){  ?>selected <?php }?> value="0">No</option>
                             
                           
                          </select>
                </div>

                 <label class="col-lg-2 col-form-label form-control-label">youtube video url link</label>
                      <div class="col-lg-4">
                        <input minlength="5" maxlength="255"   class="form-control  " name="tutorial_video" type="text" value="<?php if(isset($app_menu_id)) {  echo $data['tutorial_video']; } ?>" >
                      </div>
                </div>

                <?php  if(isset($app_menu_id)) { ?>
                    <input    type="hidden" name="app_menu_id" value="<?php echo $data['app_menu_id']; ?>">
                    <?php } ?>
                <div class="form-footer text-center">
                   <?php  if(isset($app_menu_id)) { ?>
                   
                    <button name="editMenuAdd" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> UPDATE</button>
                  <?php } else { ?>
                    <button name="appMenuAdd" value="add Page" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> ADD</button>
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
 