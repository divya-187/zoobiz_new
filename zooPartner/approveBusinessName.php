<?php 
extract($_REQUEST);



if(filter_var($id, FILTER_VALIDATE_INT) != true){
  $_SESSION['msg1']='Invalid User';
  echo ("<script LANGUAGE='JavaScript'>
    window.location.href='manageMembers';
    </script>");
}
$qq=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","users_master.user_id='$id'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id and users_master.city_id='$selected_city_id'   ","");
$userData=mysqli_fetch_array($qq);
extract($userData);

 

?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <?php if(mysqli_num_rows($qq)>0) { ?>
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title"> <?php echo $user_full_name; ?>-<?php echo $company_name; ?></h4>
        </div>
        <div class="col-sm-4">
           
       </div>

       

       <div class="col-sm-4">
        <div class="btn-group float-sm-right">
          
    </div>
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
        <img id="blah"  onerror="this.src='../zooAdmin/img/user.png'" src="../img/users/members_profile/<?php echo $user_profile_pic; ?>"  width="75" height="75"   src="#" alt="your image" class='profile' />
        <h5 class="card-title"><?php echo $salutation; ?> <?php echo $user_full_name; ?></h5>
        <p class="card-text">Zoobiz Id : <b> <?php echo  $zoobiz_id; ?></b></p>
        

  </div>
  <div class="card-body border-top">
    <div class="media align-items-center">
      <div>
        <i class="fa fa-mobile"></i>
      </div>
      <div class="media-body text-left">
        <div class="progress-wrapper">
          <?php echo $user_mobile; ?>
        </div>                   
      </div>
    </div>
    
     
    
 
              <?php //21sept2020
              if ($version_code!='') { ?>
               <hr>
               <div class="media align-items-center">
                <div>
                 <i class="fa fa-info" aria-hidden="true"></i>  
               </div>
               <div class="media-body text-left">
                <div class="progress-wrapper">Version Code: 
                  <?php echo $version_code;
                  if($device !=""){
                    echo ' - '.strtoupper($device);
                  }
                  ?>

                </div>                   
              </div>
            </div>


          <?php }?> 


<?php  if ($phone_brand!='') { ?>
               <hr>
               <div class="media align-items-center">
                <div>
                 <i class="fa fa-info" aria-hidden="true"></i>  
               </div>
               <div class="media-body text-left">
                <div class="progress-wrapper">Device Info: 
                  <?php echo $phone_brand.' - '.$phone_model; ?>  </div>                   
              </div>
            </div>
  <?php }?> 

      
 
 
</div>
</div>

</div>
<div class="col-lg-8">
  <div class="card">
    <div class="card-body">
      <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
        
        <li class="nav-item">
          <a href="javascript:void();" data-target="#Professional" data-toggle="pill" class="nav-link  active "><i class="fa fa-pencil"></i> <span class="hidden-xs">Business Name </span></a>
        </li>

            <?php
            $business_name_change_request_id = $_REQUEST['business_name_change_request_id'];
             $business_name_change_request_masater_qry = $d->selectRow("*","business_name_change_request_masater", "business_name_change_request_id = '$business_name_change_request_id' ");
   $business_name_change_request_masater_data = mysqli_fetch_array($business_name_change_request_masater_qry);
   ?>    


              </ul>
              <div class="tab-content p-3">
                
               

 
    <div class="tab-pane active" id="Professional">
      <form id="approveBusinessNameFrm" action="controller/commonController.php" method="post" enctype="multipart/form-data">
        <div class="form-group row">
          <?php 
       
          ?>
        </div>
        <div class="proExtDiv">

           <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Current Business Name</label>
        <div class="col-lg-9">
           
           <?php echo $company_name; ?>
        </div>
      </div>

         

          

          <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Requested Business Name<span class="required">*</span></label>
        <div class="col-lg-9">
           
          <input class="form-control mem-alphanumeric" name="requested_company_name" type="text" value="<?php echo $business_name_change_request_masater_data['requested_business_name'] ; ?>" required="">
        </div>
      </div>

   
          <div class="form-group row">
            <div class="col-lg-12 text-center">
              
              <input type="hidden" name="business_name_change_request_id" value="<?php echo $business_name_change_request_masater_data['business_name_change_request_id'];?>">
              <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
               <input type="submit" id="appBusinessName" class="btn btn-primary" name="appBusinessName"  value="Approve">
 
<a href="controller/commonController.php?rejBusinessName=Reject&user_id=<?php echo $user_id;?>&business_name_change_request_id=<?php echo $business_name_change_request_masater_data['business_name_change_request_id'];?>" class="btn btn-danger"  >Reject</a>
              
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
</div>
