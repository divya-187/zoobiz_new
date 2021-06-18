<?php 
extract($_REQUEST);
$qq=$d->select("users_master,unit_master,block_master,floors_master","users_master.user_id='$id' AND unit_master.unit_id=users_master.unit_id AND block_master.block_id=floors_master.block_id AND floors_master.floor_id=unit_master.floor_id AND users_master.society_id='$society_id' AND users_master.member_status=0");
$userData=mysqli_fetch_array($qq);
extract($userData);
error_reporting(0);
$userType =$unit_status;
$user_type =$user_type;
if ($user_status==0) {
  $_SESSION['msg1']="Please Approve User First";
  echo ("<script LANGUAGE='JavaScript'>
    window.location.href='pendingUser?id=$id';
    </script>");
  exit();
}

 ?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <?php if(mysqli_num_rows($qq)>0) { ?>
    <div class="row pt-2 pb-2">
      <div class="col-sm-3">
        <h4 class="page-title"> <?php if ($user_type==1){ echo "Tenant";}else { echo "Owner"; }?> <?php echo $block_name; ?>-<?php echo $unit_name; ?></h4>
        
      </div>
      <div class="col-sm-6 text-center">
        <h6>Login Status Of User: <?php if($user_token==''){ ?> <i class="text-danger fa fa-times-circle"></i> <?php } else{ ?><i class="text-success fa fa-check-circle"></i><?php } ?></h6>
      </div>
      <div class="col-sm-3">
       <div class="btn-group float-sm-right">
        <a href="#" data-toggle="modal" data-target="#addFamilyMember"  class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Add Family Members </a>
        <a href="#" data-toggle="modal" data-target="#parkingAdd"  class="btn btn-sm btn-warning waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Add Parking</a>
        </div>
      </div>
    </div>
    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-lg-4">
       <div class="card profile-card-2">
        <div class="card-img-block">
          <img class="img-fluid" src="assets/images/gallery/31.jpg" alt="Card image cap">
        </div>
        <div class="card-body pt-5">
           <img id="blah"  onerror="this.src='img/user.png'" src="../img/users/recident_profile/<?php echo $user_profile_pic; ?>"  width="75" height="75"   src="#" alt="your image" class='profile' />
          <h5 class="card-title"><?php echo $user_full_name; ?></h5>
          <p class="card-text"><?php echo $_SESSION['society_name']; ?></p>
          
        </div>

        <div class="card-body border-top">
         <div class="media align-items-center">
           <div>
             <i class="fa fa-phone"></i>
           </div>
           <div class="media-body text-left ml-3">
             <div class="progress-wrapper">
               <?php echo $user_mobile; ?>
            </div>                   
          </div>
        </div>
        <hr>
        <div class="media align-items-center">
         <div>
           <i class="fa fa-envelope"></i>
         </div>
         <div class="media-body text-left ml-3">
           <div class="progress-wrapper">
              <?php echo $user_email; ?>
          </div>                   
        </div>
      </div>
      <hr>
      <div class="media align-items-center">
         <div>
           <i class="fa fa-car" title="Car Parking"></i>
         </div>
         <div class="media-body text-left ml-3">
           <div class="progress-wrapper">
              <?php echo $allocatedCars=$d->count_data_direct("parking_id","parking_master","unit_id='$unit_id' AND parking_type=0 AND parking_status=1");  ?>
          </div>                   
        </div>
        <div>
           <i class="fa fa-motorcycle" title="Bike Parking"></i>
         </div>
         <div class="media-body text-left ml-3">
           <div class="progress-wrapper">
              <?php echo $allocatedCars=$d->count_data_direct("parking_id","parking_master","unit_id='$unit_id' AND parking_type=1 AND parking_status=1");  ?>
          </div>                   
        </div>
      </div>
      <?php if ($user_type==1 && $tenant_doc!=''): ?>
       <hr>
        <div class="media align-items-center">
         <div>
           <i class="fa fa-file-o" title="Car Parking"></i>
         </div>
         <div class="media-body text-left ml-3">
           <div class="progress-wrapper">
              <a href="../img/documents/<?php echo $tenant_doc;?>" target="_blank">View Agreement</a>
          </div>                   
        </div>
       
      </div>
      <?php endif?>
       <hr>
      <div class="media align-items-center">
            <?php if ($facebook!=''): ?>
             <a target="_blank" href="<?php echo $facebook;?>"><i class="fa fa-facebook" title="Car Parking"></i></a>
            <?php endif ?>
            <?php if ($instagram!=''): ?>
           <a target="_blank" href="<?php echo $instagram;?>"><i class="fa fa-instagram" title="instagram"></i></a>
           <?php endif ?>
           <?php if ($linkedin!=''): ?>
           <a target="_blank" href="<?php echo $linkedin;?>"><i class="fa fa-linkedin" title="linkedin"></i></a>
           <?php endif ?>
           <?php if ($twitter!=''): ?>
           <a target="_blank" href="<?php echo $twitter;?>"><i class="fa fa-twitter" title="Twitter"></i></a>
           <?php endif ?>
      </div>
      <?php if ($user_type==1): 
       $fq=$d->select("users_master","user_type=0 AND member_status=0 AND unit_id='$unit_id'");
        $ownerData=mysqli_fetch_array($fq);
        if ($ownerData>0) {
        ?>
        
       <div class="card-body pt-2 text-center">
          <h5 class="card-title">Owner Details: 
             <div class="avatar">
              <a href="viewOwner?id=<?php echo $ownerData['user_id']; ?>">
              <img width="100" onerror="this.src='img/user.png'"  class="align-self-start mr-3" src="img/profile/<?php echo $ownerData['admin_profile']; ?>" alt="user avatar"><br>
              <?php echo $ownerData['user_full_name']; ?></a>
            </div>

            </h5>
          <p class="card-text"> Mobile: <?php echo $ownerData['user_mobile']; ?></p>
          
        </div>
      <?php } endif ?>
      <hr>
      <?php if($installed_by==$_SESSION['zoobiz_admin_id']){ ?>
      <div class="row">
        <div class="col-xs-6 col-12">
           <form action="controller/userController.php" method="post">
            <input type="hidden" name="userType" value="<?php echo $userType; ?>">
            <input type="hidden" name="delete_user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>">
            <input type="hidden" name="user_fcm" value="<?php echo $user_token; ?>">
            <input type="hidden" name="block_id" value="<?php echo $block_id; ?>">
            <?php if ($user_type==1) {?>
            <button type="submit" class="btn form-btn btn-danger" >Remove Tenant</button>
            <?php } else{ ?>
            <button type="submit" class="btn form-btn btn-danger" >Delete Owner</button>
            <?php }?>
          </form>
        </div>
      </div>
    <?php } ?>
     
      
   

</div>
</div>

</div>

<div class="col-lg-8">
 <div class="card">
  <div class="card-body">
    <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
      <li class="nav-item">
        <a href="javascript:void();" data-target="#edit" data-toggle="pill" class="nav-link active"><i class="icon-note"></i> <span class="hidden-xs">Basic </span></a>
      </li>
      <li class="nav-item">
        <a href="javascript:void();" data-target="#messages" data-toggle="pill" class="nav-link "><i class="fa fa-users"></i> <span class="hidden-xs">Family </span></a>
      </li>
      <li class="nav-item">
        <a href="javascript:void();" data-target="#parking111" data-toggle="pill" class="nav-link "><i class="fa fa-car"></i> <span class="hidden-xs">Parking </span></a>
      </li>
    </ul>
    <div class="tab-content p-3">
     
      <div class="tab-pane " id="messages">
        <?php  $fq=$d->select("users_master","unit_id='$unit_id' AND member_status=1 AND society_id='$society_id' AND user_type='$user_type'");

        if(mysqli_num_rows($fq)>0) { ?>
        <div class="table-responsive">
          
        <table class="table align-items-center table-bordered table-flush">
         <thead>
          <tr>
           <th>#</th>
           <th>#</th>
           <th>Name</th>
           <th>Relation</th>
           <!-- <th>Age</th> -->
           <th>Login Access</th>
           <th>Login Status</th>
          </tr>
         </thead>
         <tbody>
          <?php 
          $i=1;
         
          while ($fData=mysqli_fetch_array($fq)) {
           ?>
           <tr>
             <td><?php echo $i++; ?></td>
             <td>
                 <img id="blah"  onerror="this.src='img/user.png'" src="../img/users/recident_profile/<?php echo $fData['user_profile_pic']; ?>"  width="40" height="40"   src="#" alt="your image" class='profile' />
             </td>
             <td><?php echo $fData['user_full_name'] ?></td>
             <td><?php echo $fData['member_relation_name']; ?></td>
             <!-- <td><?php $dateOfBirth= $fData['member_date_of_birth'];
               $today = date("Y-m-d");
              $diff = date_diff(date_create($dateOfBirth), date_create($today));
              echo $diff->format('%y');
              ?></td> -->
              <td><?php if ($fData['user_status']==1) {
                echo "Yes (".$fData['user_mobile'].")";
              } else {
                echo "No";
              } ?></td>
              <td><?php if($fData['user_status']==1 && $fData['user_token']!='') {
                echo "<i class='text-success fa fa-check-circle'>";
              } else if($fData['user_status']==1 && $fData['user_token']=='') {
                echo "<i class='text-danger fa fa-times-circle'></i>";
              } else {
                echo "-";
              } ?></td>
           </tr>
           <?php } ?>
           
         </tbody>
       </table>
     </div>
     <?php } else {
      echo "<img width='250' src='img/no_data_found3.png'>";
     } ?>
     </div>
      <div class="tab-pane " id="parking111">
        <?php  $fq=$d->select("parking_master","unit_id='$unit_id'  AND parking_status=1");

        if(mysqli_num_rows($fq)>0) { ?>
        <div class="table-responsive">
          
        <table class="table align-items-center table-bordered table-flush">
         <thead>
          <tr>
           <th>#</th>
           <th>Name</th>
           <th>Type</th>
           <th>Vehicle number</th>
           <th>Action</th>
          </tr>
         </thead>
         <tbody>
          <?php 
          $i=1;
         
          while ($fData=mysqli_fetch_array($fq)) {
           ?>
           <tr>
             <td><?php echo $i++; ?></td>
            
             <td><?php echo $fData['parking_name'] ?></td>
              <td><?php if ($fData['parking_type']==1) {
                echo "Bike";
              } else {
                echo "Car";
              } ?></td>
             <td><?php echo $fData['vehicle_no']; ?></td>
            
              <td>
                <form action="controller/parkingController.php" method="post" accept-charset="utf-8">
                  <input type="hidden" name="removeUserlParking" value="removeUserlParking">
                  <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                  <input type="hidden" name="parking_id" value="<?php echo $fData['parking_id']; ?>">
                    <button class="btn form-btn btn-danger btn-sm" type=""><i class="fa fa-trash-o"></i></button>
                </form>
              </td>
           </tr>
           <?php } ?>
           
         </tbody>
       </table>
     </div>
     <?php } else {
      echo "<img width='250' src='img/no_data_found3.png'>";
     } ?>
     </div>
    <div class="tab-pane active" id="edit">
      <form id="addUser" action="controller/userController.php" method="post" enctype="multipart/form-data">
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">First Name <span class="required">*</span></label>
          <div class="col-lg-9">
            <input type="hidden" name="user_fcm" value="<?php echo $user_token; ?>">
            <input type="hidden" name="edit_user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>">
            <input class="form-control" name="user_first_name" type="text" value="<?php echo $user_first_name; ?>" required="">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Last Name <span class="required">*</span></label>
          <div class="col-lg-9">
            <input class="form-control" name="user_last_name" type="text" value="<?php echo $user_last_name; ?>" required="">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Mobile <span class="required">*</span></label>
          <div class="col-lg-9">
            <input required="" class="form-control" name="user_mobile" onblur="checkMobileUserEdit()" maxlength="10"  type="text" value="<?php echo $user_mobile; ?>" id="userMobile">
            <input class="form-control" name="user_mobile_old" maxlength="10"  type="hidden" value="<?php echo $user_mobile; ?>"  id="userMobileOld">
          </div>
        </div>
         <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Alternate Mobile </label>
          <div class="col-lg-9">
            <input class="form-control" name="alt_mobile"  maxlength="10"  type="text" value="<?php if($alt_mobile!=0) { echo $alt_mobile; } ?>" id="alt_mobile">
          </div>
        </div>
        
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Email </label>
          <div class="col-lg-9">
            <input class="form-control" type="email" name="user_email"  onblur="checkEmailUserEdit()"  value="<?php echo $user_email; ?>" id="userEmail">
            <input class="form-control" type="hidden" name="user_email_old" value="<?php echo $user_email; ?>"  id="userEmailOld">
          </div>
        </div>
        
         
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Change profile</label>
          <div class="col-lg-9">
            <input accept="image/*" class="form-control-file border" id="imgInp" name="user_profile_pic" type="file">
            <input class="form-control" name="user_profile_pic_old" type="hidden" value="<?php echo $user_profile_pic; ?>">
           
          </div>
        </div>
        
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label"></label>
          <div class="col-lg-9">
            <input type="submit" id="socAddBtn" class="btn btn-primary" name="updateUserProfile"  value="Update">
          </div>
        </div>
      </form>
    </div>

</div>
</div>
</div>
</div>

</div>
<?php  } else {
      echo "<img width='250' src='img/no_data_found3.png'>";
} ?>
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

 <div class="modal fade" id="addFamilyMember">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Add Family Member</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="addUserDiv">
          <form id="addUserMember" action="controller/userMemberController.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="parent_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="block_id" value="<?php echo $block_id; ?>">
            <input type="hidden" name="floor_id" value="<?php echo $floor_id; ?>">
            <input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>">
            <input type="hidden" name="device" value="<?php echo $device; ?>">
            <input type="hidden" name="user_token" value="<?php echo $user_token; ?>">
            <input type="hidden" name="user_type" value="<?php echo $user_type ?>">
            
            <div class="form-group row">
              <label for="input-21" class="col-sm-4 col-form-label">Member First Name *</label>
              <div class="col-sm-8">
                <input required="" type="text" class="form-control text-capitalize" id="input-21" name="user_first_name">
              </div>
            </div>
            <div class="form-group row">
               <label for="input-22" class="col-sm-4 col-form-label">Member Last Name *</label>
              <div class="col-sm-8">
                <input required="" type="text" class="form-control text-capitalize" id="input-22" name="user_last_name">
              </div>
            </div>
            <div class="form-group row">
              <label for="input-23" class="col-sm-4 col-form-label">Relation with Member</label>
              <div class="col-sm-8">
                <select class="form-control single-select" id="input-23" name="member_relation_name">
                  <option value="Dad">Dad</option>
                  <option value="Mom">Mom</option>
                  <option value="Wife">Wife</option>
                  <option value="Husband">Husband</option>
                  <option value="Brother">Brother</option>
                  <option value="Sister">Sister</option>
                  <option value="Grandpa">Grandpa</option>
                  <option value="Grandmother">Grandmother</option>
                  <option value="Son">Son</option>
                  <option value="Daughter">Daughter</option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <div class="icheck-material-primary ml-3">
                <input type="checkbox" id="user-checkbox" onclick="showloginMobile()" />
                <label for="user-checkbox">Create Login for Member</label>
              </div>
            </div>
            <div class="form-group row mobileShow">
               <label for="input-24" class="col-sm-4 col-form-label">Member Mobile *</label>
              <div class="col-sm-8">
                <input required="" type="text" class="form-control" maxlength="10" id="input-24" name="user_mobile">
              </div>
            </div>
          
           
            <div class="form-footer text-center">
                <button type="submit" id="socAddBtnTenat" class="btn btn-success"><i class="fa fa-check-square-o"></i> Add </button>
                <button type="button" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button>
            </div>
          </form>
      </div>
     
    </div>
  </div>
</div>


<div class="modal fade" id="parkingAdd">
  <div class="modal-dialog ">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Add New Parking</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="addUserDiv">
          <form id="addUser" action="controller/parkingController.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="allocateParking" value="<?php echo 'allocateParking';?>">
            <input type="hidden" name="user_id" value="<?php echo $id;?>">
            <input type="hidden" name="block_id" value="<?php echo $block_id;?>">
            <input type="hidden" name="floor_id" value="<?php echo $floor_id;?>">
            <input type="hidden" name="unit_id" value="<?php echo $unit_id;?>">
            
            <div class="form-group row">
              <label for="input-15" class="col-sm-3 col-form-label">Parking</label>
              <div class="col-sm-9">
                <select class="single-select form-control" name="parking_id">
                  <option value=""></option>
                  <?php $park = $d->select("parking_master,society_parking_master","parking_master.parking_status=0 AND society_parking_master.society_parking_id=parking_master.society_parking_id");
                    while($parkData = mysqli_fetch_array($park)){ ?>
                      <option value="<?php echo $parkData['parking_id'] ?>"><?php echo $parkData['socieaty_parking_name']." - ".$parkData['parking_name'] ?></option>
                  <?php  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="input-16" class="col-sm-3 col-form-label">Car/Bike Number </label>
                    <div class="col-sm-9" >
                      <input maxlength="50" type="text" id="input-16" name="vehicle_no" class="form-control text-uppercase">
                      (For Multiple Vehicle Number Use , Each Number)
                    </div>
            </div>
           
            <div class="form-footer text-center">
                <button type="submit" id="socAddBtn" class="btn btn-success "><i class="fa fa-check-square-o"></i> Allocate  </button>
            </div>
          </form>
      </div>
     
    </div>
  </div>
</div><!--End Modal -->

<script type="text/javascript">
  $(document).ready(function(){
    $(".mobileShow").hide();
  });
</script>
<script type="text/javascript">
  function showloginMobile() {
    $(".mobileShow").toggle();
  }
</script>