<?php 
extract($_REQUEST);
if(filter_var($id, FILTER_VALIDATE_INT) != true){
  $_SESSION['msg1']='Invalid User';
  echo ("<script LANGUAGE='JavaScript'>
    window.location.href='manageMembers';
    </script>");
}
$qq=$d->selectRow("users_master.*, user_employment_details.*, business_sub_categories.business_category_id as realBcat , business_sub_categories.business_sub_category_id as realSubBcat, business_sub_categories.sub_category_name  ","users_master,business_sub_categories,user_employment_details","users_master.user_id='$id'  AND business_sub_categories.business_category_id='-2' and    business_sub_categories.incepted_user_id=user_employment_details.user_id AND    user_employment_details.user_id=users_master.user_id  ","");
$userData=mysqli_fetch_array($qq);
extract($userData);

 if($business_category_id !="-1" || $business_sub_category_id !="-1"){
  $_SESSION['msg1']='Already Approved';
  echo ("<script LANGUAGE='JavaScript'>
    window.location.href='viewMember?id=".$user_id."';
    </script>");
 }

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
        <img class="img-fluid" src="img/Free-hd-building-wallpaper.jpg" alt="Card image cap">
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
          <a href="javascript:void();" data-target="#Professional" data-toggle="pill" class="nav-link  active "><i class="fa fa-pencil"></i> <span class="hidden-xs">Business Category </span></a>
        </li>
 <li class="nav-item">
          <a href="javascript:void();" data-target="#exProfessional" data-toggle="pill" class="nav-link   "><i class="fa fa-pencil"></i> <span class="hidden-xs">Existing Business Category </span></a>
        </li>
                


              </ul>
              <div class="tab-content p-3">
                
               

  <div class="tab-pane " id="exProfessional">
      <form id="approveCustomCatFrm" action="controller/userController.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="isExisting" value="Yes">
        <div class="form-group row">
          <?php 
          $q1=$d->select("user_employment_details","user_id='$user_id'");
          $proData=mysqli_fetch_array($q1);
          ?>
        </div>
      

           <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Business Name</label>
        <div class="col-lg-9">
           
           <?php echo $company_name; ?>
        </div>
      </div>

  <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Business Website</label>
        <div class="col-lg-9">
           
         <?php if(trim($company_website) !=''){ echo $company_website;} else { echo "Not Provided";}  ?>
        </div>
      </div>
         
<div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Business Keywords</label>
        <div class="col-lg-9">
           
           <?php if(trim($search_keyword) !=''){ echo $search_keyword;} else { echo "Not Provided";}  ?>
        </div>
      </div>


      <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Products And Services</label>
        <div class="col-lg-9">
           <?php if(trim($products_servicess) !=''){ echo $products_servicess;} else { echo "Not Provided";}  ?>
      
        </div>
      </div>


          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Professional Category <span class="required">*</span></label>
            <div class="col-lg-9">
              <select id="business_categories" onchange="getSubCategory();" class="form-control single-select" name="business_category_id" type="text"  required="">
                <option value="">-- Select --</option>
                <?php $qb=$d->select("business_categories","category_status in (0,2)"," order by category_name asc");
                while ($bData=mysqli_fetch_array($qb)) {?>
                  <option <?php if($proData['business_category_id']== $bData['business_category_id']) { echo 'selected';} ?> value="<?php echo $bData['business_category_id']; ?>"><?php echo $bData['category_name']; ?></option>
                <?php } ?> 
              </select>
            </div>
          </div>
           <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Business Sub Category <span class="required">*</span></label>
                        <div class="col-lg-9">
                          <select id="business_categories_sub" class="form-control single-select" name="business_sub_category_id" type="text"  required="">
                            <option value="">-- Select --</option>
                             
                            </select>
                          </div>
</div>
         

   
          <div class="form-group row">
            <div class="col-lg-12 text-center">
              
              <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
              <input type="hidden" name="approveCustomCat" value="approveCustomCat">
              <input type="submit" id="approveCustomCatBtn" class="btn btn-primary" name=""  value="Submit">
            </div>
          </div>
        </form>
      </div>

    
    <div class="tab-pane active" id="Professional">
      <form id="approveCustomCatFrm" action="controller/userController.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="isExisting" value="No">
        <div class="form-group row">
          <?php 
          $q1=$d->select("user_employment_details","user_id='$user_id'");
          $proData=mysqli_fetch_array($q1);
          ?>
        </div>
        <div class="proExtDiv">

           <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Business Name</label>
        <div class="col-lg-9">
           
           <?php echo $company_name; ?>
        </div>
      </div>

         <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Business Website</label>
        <div class="col-lg-9">
           
         <?php if(trim($company_website) !=''){ echo $company_website;} else { echo "Not Provided";}  ?>
        </div>
      </div>
         
<div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Business Keywords</label>
        <div class="col-lg-9">
           
           <?php if(trim($search_keyword) !=''){ echo $search_keyword;} else { echo "Not Provided";}  ?>
        </div>
      </div>


      <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Products And Services</label>
        <div class="col-lg-9">
           <?php if(trim($products_servicess) !=''){ echo $products_servicess;} else { echo "Not Provided";}  ?>
      
        </div>
      </div>

          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Professional Category <span class="required">*</span></label>
            <div class="col-lg-9">
              <select id="business_categories"   class="form-control single-select" name="business_category_id_old" type="text"  required="">
                <option value="">-- Select --</option>
                <?php $qb=$d->select("business_categories","category_status in (0,2)"," order by category_name asc");
                while ($bData=mysqli_fetch_array($qb)) {?>
                  <option <?php if($proData['business_category_id']== $bData['business_category_id']) { echo 'selected';} ?> value="<?php echo $bData['business_category_id']; ?>"><?php echo $bData['category_name']; ?></option>
                <?php } ?> 
              </select>
            </div>
          </div>

          <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Custom Sub Name <span class="required">*</span></label>
        <div class="col-lg-9">
           
          <input class="form-control mem-alphanumeric" name="sub_category_name" type="text" value="<?php echo $sub_category_name ; ?>" required="">
        </div>
      </div>

   
          <div class="form-group row">
            <div class="col-lg-12 text-center">
              <input type="hidden" name="business_sub_category_id_old" value="<?php echo $realSubBcat;?>">
              <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
              <input type="hidden" name="approveCustomCat" value="approveCustomCat">
              <input type="submit" id="approveCustomCatBtn" class="btn btn-primary" name=""  value="Approve">
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
