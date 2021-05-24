<?php
	  extract($_POST);?>
<div class="content-wrapper">
  <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">App Version</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">App Version</li>
         </ol>
       </div>
       <div class="col-sm-3">
         <div class="btn-group float-sm-right">
         
          <a href="#" data-toggle="modal" data-target="#addUPI" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Add New </a>
       </div>
     </div>
   </div>
   <!-- End Breadcrumb-->
  	 <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
          	<?php
          	
            
              $getData = $d->select("app_version_master"," status = 0 ","");
              $data = mysqli_fetch_array($getData);
            extract($data);


          		?>
 
          		 <form id="appVersionFrm" action="controller/versionController.php" method="POST" enctype="multipart/form-data">
              <h4 class="form-header text-uppercase">
               
              <i class="fa fa-mobile"></i>
            App Version Settings
              </h4>
              <div class="form-group row">
                <label for="version_code_android" class="col-sm-2 col-form-label"> version code android<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                  <input minlength="1" maxlength="80" class="form-control" name="version_code_android" type="text" value="<?php if(   mysqli_num_rows($getData) > 0 ) { echo $version_code_android ; } ?>" required="">

                    
                </div>
              </div>
              <div class="form-group row">
                <label for="version_code_android_view" class="col-sm-2 col-form-label">version code android view <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input minlength="1" maxlength="80" class="form-control" name="version_code_android_view" type="text" value="<?php if(   mysqli_num_rows($getData) > 0 ) { echo $version_code_android_view ; } ?>" required="">
                </div>
              </div>
             
            <div class="form-group row">
                <label for="version_code_ios" class="col-sm-2 col-form-label">version code ios <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input minlength="1" maxlength="80" class="form-control" name="version_code_ios" type="text" value="<?php if(  mysqli_num_rows($getData) > 0 ) { echo $version_code_ios ; } ?>" required="">
                </div>
              </div>

               <div class="form-group row">
                <label for="version_code_ios_view" class="col-sm-2 col-form-label">version code ios View <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input minlength="1" maxlength="80" class="form-control" name="version_code_ios_view" type="text" value="<?php if( mysqli_num_rows($getData) > 0 ) { echo $version_code_ios_view ; } ?>" required="">
                </div>
              </div>


              <div class="form-footer text-center">
                <?php if(mysqli_num_rows($getData) > 0  ){ ?>
                 
                   
                  <input type="hidden" name="version_id" value="<?php echo $data['version_id'];?>">
                <button name="updateVersionData" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
              <?php } else { ?>
               <button name="addVersionData" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save</button>
                <?php } ?> 
              </div>
            </form>
          		
          
          </div>
        </div>
      </div>
      </div><!--End Row-->
  </div>
</div>

