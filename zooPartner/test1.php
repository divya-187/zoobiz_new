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
      

<div class="col-lg-12">
 <div class="card">
  <div class="card-body">
  <form id="signupForm" action="controller/profileController.php" method="post">
    <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
      <li class="nav-item">
        <a href="javascript:void();" data-target="#edit" data-toggle="pill" class="nav-link active"><i class="icon-note"></i> <span class="hidden-xs">Edit Profile</span></a>
      </li>
      <li class="nav-item">
        <a href="javascript:void();" data-target="#messages" data-toggle="pill" class="nav-link"><i class="icon-envelope-open"></i> <span class="hidden-xs">Change Password</span></a>
      </li>

    </ul>
    <div id="mytabs" class="tab-content p-3">
     
      <div class="tab-pane" id="messages">
        
      <div class="">
          <input type="hidden" name="admin_mobile" value="<?php echo $_SESSION['mobile_number']; ?>">
          <input type="hidden" name="admin_email" value="<?php echo $_SESSION['admin_email']; ?>">
          <input type="hidden" name="full_name" value="<?php echo $_SESSION['full_name']; ?>">
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Old Password <span class="required">*</span></label>
          <div class="col-lg-9">
            <input class="form-control" required="" name="old_password" type="password" value="">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Password <span class="required">*</span></label>
          <div class="col-lg-9">
            <input class="form-control" required="" type="password" name="password" value="">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Confirm password <span class="required">*</span></label>
          <div class="col-lg-9">
            <input class="form-control" required="" name="password2" type="password" value="">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label"></label>
          <div class="col-lg-9">
            <input type="submit" name="passwordChange" class="btn btn-primary" value="Change Password">
          </div>
        </div>
</div>
</div>
<div class="tab-pane active" id="edit">
    <?php 
      if(isset($_SESSION['partner_login_id'])) {
      $q=$d->select("zoobiz_admin_master","partner_login_id='$_SESSION[partner_login_id]'");
      $data=mysqli_fetch_array($q);
      extract($data);
      } ?>
    <div class="form-group row">
      <label class="col-lg-3 col-form-label form-control-label">Full Name <span class="required">*</span></label>
      <div class="col-lg-9">
        <input required="" class="form-control" name="full_name" type="text" value="<?php echo $admin_name; ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-lg-3 col-form-label form-control-label">Mobile <span class="required">*</span></label>
      <div class="col-lg-9">
        <input class="form-control" readonly=""  type="text" value="<?php echo $data['admin_mobile']; ?>">
      </div>
    </div>
      <div class="form-group row">
      <label class="col-lg-3 col-form-label form-control-label">Email <span class="required">*</span></label>
      <div class="col-lg-9">
        <input class="form-control" name="admin_email"  type="email" value="<?php echo $data['admin_email']; ?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-lg-3 col-form-label form-control-label"></label>
      <div class="col-lg-9">
        <input id="changetabbutton" type="button" class="btn btn-primary" name="updateProfile"  value="Update Profile">
      </div>
    </div>
</div>
</div>
</div>
</div>
</div>

</div>

  </form>
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


$('#changetabbutton').click(function(e){
    e.preventDefault();
    $('#mytabs a[href="#messages"]').tab('show');
})
</script>