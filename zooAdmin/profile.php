<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">My Profile</h4>
      </div>
    </div>
    <!-- End Breadcrumb-->

    <div class="row">
      <div class="col-lg-4">
       <div class="card profile-card-2">
        <div class="card-img-block">
          <img class="img-fluid" src="img/Free-hd-building-wallpaper.jpg" alt="Card image cap">
        </div>
        <div class="card-body pt-5">
           <img id="blah"  onerror="this.src='img/user.png'" src="img/profile/<?php echo $_SESSION['admin_profile']; ?>"  width="75" height="75"   src="#" alt="your image" class='profile' />
          <h5 class="card-title"><?php echo $_SESSION['full_name']; ?></h5>
          
        </div>

        <div class="card-body border-top">

           <?php 
         $role_master=$d->select("role_master","role_id='$_SESSION[role_id]'");
      $role_master_data=mysqli_fetch_array($role_master);
       ?>

        <div class="media align-items-center">
           <div>
             <i class="fa fa-user"></i>
           </div>
           <div class="media-body text-left ml-3">
             <div class="progress-wrapper">
               <?php echo $role_master_data['role_name']; ?>
            </div>                   
          </div>

        </div>

        
         <div class="media align-items-center">
           <div>
             <i class="fa fa-phone"></i>
           </div>
           <div class="media-body text-left ml-3">
             <div class="progress-wrapper">
               <?php echo $_SESSION['mobile_number'];
                ?>
            </div>                   
          </div>

        </div>
       

        <div class="media align-items-center">
           <div>
             <i class="fa fa-envelope"></i>
           </div>
           <div class="media-body text-left ml-3">
             <div class="progress-wrapper">
               <marquee scrollamount="3"> <a href="mailto:<?php echo $user_email;?>"  >  <?php echo $_SESSION['admin_email']; ?></a>   </marquee>
               
            </div>                   
          </div>

        </div>
</div>
</div>

</div>

<div class="col-lg-8">
 <div class="card">
  <div class="card-body">
    <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
      <li class="nav-item">
        <a href="javascript:void();" data-target="#edit" data-toggle="pill" class="nav-link active"><i class="icon-note"></i> <span class="hidden-xs">Edit Profile</span></a>
      </li>
      <li class="nav-item">
        <a href="javascript:void();" data-target="#messages" data-toggle="pill" class="nav-link"><i class="icon-envelope-open"></i> <span class="hidden-xs">Change Password</span></a>
      </li>

    </ul>
    <div class="tab-content p-3">
     
      <div class="tab-pane" id="messages">
        
      <div class="">
        <form id="profileFrm1" action="controller/profileController.php" method="post">
          <input type="hidden" name="admin_mobile" value="<?php echo $_SESSION['mobile_number']; ?>">
          <input type="hidden" name="admin_email" value="<?php echo $_SESSION['admin_email']; ?>">
          <input type="hidden" name="full_name" value="<?php echo $_SESSION['full_name']; ?>">
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Old Password <span class="required">*</span></label>
          <div class="col-lg-9">
            <input class="form-control" minlength="5" maxlength="50" required="" name="old_password" type="password" value="">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Password <span class="required">*</span></label>
          <div class="col-lg-9">
            <input class="form-control" minlength="5" maxlength="50" required="" type="password" name="password" id="password" value="">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Confirm password <span class="required">*</span></label>
          <div class="col-lg-9">
            <input class="form-control" minlength="5" maxlength="50" required="" name="password2" type="password" value="">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label"></label>
          <div class="col-lg-9">
            <input type="submit" name="passwordChange" class="btn btn-primary" value="Change Password">
          </div>
        </div>
      </form>
</div>
</div>
<div class="tab-pane active" id="edit">
  <form id="profileDetailFrm" action="controller/profileController.php" method="post" enctype="multipart/form-data">
    <?php   
      if(isset($_SESSION['zoobiz_admin_id'])) {
      $q=$d->select("zoobiz_admin_master","zoobiz_admin_id='$_SESSION[zoobiz_admin_id]'");
      $data=mysqli_fetch_array($q);
      extract($data);
      } ?>

      <input   name="zoobiz_admin_id" type="hidden" value="<?php echo $_SESSION['zoobiz_admin_id']; ?>">


    <div class="form-group row">
      <label class="col-lg-3 col-form-label form-control-label">Full Name <span class="required">*</span></label>
      <div class="col-lg-9">
        <input required="" minlength="3" maxlength="80" class="form-control" name="full_name" type="text" value="<?php echo $admin_name; ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-lg-3 col-form-label form-control-label">Mobile <span class="required">*</span></label>
      <div class="col-lg-9">
        <input class="form-control" minlength="10" maxlength="10"  readonly=""  type="text" value="<?php echo $data['admin_mobile']; ?>">
      </div>
    </div>
      <div class="form-group row">
      <label class="col-lg-3 col-form-label form-control-label">Email <span class="required">*</span></label>
      <div class="col-lg-9">
        <input class="form-control" minlength="3" maxlength="80" name="admin_email"  type="email" value="<?php echo $data['admin_email']; ?>">
      </div>
    </div>


    <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Change profile</label>
          <div class="col-lg-9">

              <?php //IS_573   id="profile_image_old" ?> 

            <input class="form-control-file border photoOnly" id="imgInp" accept="image/*" name="profile_image" type="file">
            <input class="form-control-file border" value="<?php if(isset($_SESSION['admin_profile'])){  echo $_SESSION['admin_profile']; } else { echo $data['admin_profile']; } ?>" name="profile_image_old" id="profile_image_old" type="hidden">

          </div>
        </div>


    <div class="form-group row">
      <label class="col-lg-3 col-form-label form-control-label"></label>
      <div class="col-lg-9">
        <input type="submit" class="btn btn-primary" name="updateProfile"  value="Update Profile">
      </div>
    </div>
  </form>
</div>
</div>
</div>
</div>
</div>

</div>

</div>
<!-- End container-fluid-->
</div><!--End content-wrapper-->

  <script src="assets/js/jquery.min.js"></script>
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

$("#imgInp").change(function() {
  readURL(this);
});
</script>