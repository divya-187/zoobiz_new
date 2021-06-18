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
          <img class="img-fluid" src="../zooAdmin/img/Free-hd-building-wallpaper.jpg" alt="Card image cap">
        </div>
        <div class="card-body pt-5">
           <img id="blah"  onerror="this.src='../zooAdmin/img/user.png'" src="../zooAdmin/img/profile/<?php echo $_SESSION['admin_profile']; ?>"  width="75" height="75"   src="#" alt="your image" class='profile' />
          <h5 class="card-title"><?php echo $_SESSION['full_name']; ?></h5>
          
        </div>

        <div class="card-body border-top">

           <?php 
         //  echo "<pre>";print_r($_SESSION);
         $role_master=$d->select("role_master","role_id='$_SESSION[partner_role_id]'");
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
      

    </ul>
    <div class="tab-content p-3">
     
       
<div class="tab-pane active" id="edit">
  <form id="profileDetailFrm" action="controller/profileController.php" method="post" enctype="multipart/form-data">
    <?php   

      if(isset($_SESSION['partner_login_id'])) {
        
      $q=$d->select("zoobiz_partner_master","zoobiz_partner_id='$_SESSION[partner_login_id]'");
      $data=mysqli_fetch_array($q);
      extract($data);

      
      } ?>

      <input   name="zoobiz_partner_id" type="hidden" value="<?php echo $_SESSION['partner_login_id']; ?>">


    <div class="form-group row">
      <label class="col-lg-3 col-form-label form-control-label">Full Name <span class="required">*</span></label>
      <div class="col-lg-9">
        <input required="" minlength="3" maxlength="80" class="form-control" name="partner_name" type="text" value="<?php echo $partner_name; ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-lg-3 col-form-label form-control-label">Mobile <span class="required">*</span></label>
      <div class="col-lg-9">
        <input class="form-control" minlength="10" maxlength="10"  readonly=""  type="text" value="<?php echo $data['partner_mobile']; ?>">
      </div>
    </div>
      


    <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Change profile</label>
          <div class="col-lg-9">

              <?php //IS_573   id="profile_image_old" ?> 

            <input class="form-control-file border photoOnly" id="imgInp" accept="image/*" name="partner_profile" type="file">
            <input class="form-control-file border" value="<?php if(isset($_SESSION['partner_profile'])){  echo $_SESSION['partner_profile']; } else { echo $data['partner_profile']; } ?>" name="partner_profile_old" id="partner_profile_old" type="hidden">

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

  <script src="../zooAdmin/assets/js/jquery.min.js"></script>
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