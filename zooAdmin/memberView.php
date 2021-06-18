<?php 
extract($_REQUEST);
if(filter_var($id, FILTER_VALIDATE_INT) != true){
  $_SESSION['msg1']='Invalid User';
  echo ("<script LANGUAGE='JavaScript'>
    window.location.href='manageMembers';
    </script>");
}
$qq=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","users_master.user_id='$id'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  ","");
$userData=mysqli_fetch_array($qq);
extract($userData);

$nqBlock=$d->select("business_houses","user_id='$user_id'" ,"");
$bData=mysqli_fetch_array($nqBlock);
error_reporting(0);

$tq22=$d->select("users_master,follow_master,user_employment_details,business_categories,business_sub_categories","business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_to=users_master.user_id AND follow_master.follow_by='$id'","ORDER BY users_master.user_full_name ASC");

$tq33=$d->select("users_master,follow_master,user_employment_details,business_categories,business_sub_categories","business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND follow_master.follow_by=users_master.user_id AND follow_master.follow_to='$id'","ORDER BY users_master.user_full_name ASC");
$following= mysqli_num_rows($tq22);
$followers= mysqli_num_rows($tq33);

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
          Account Status :  <?php if($userData['active_status']=="0"){
            echo "Active";
            ?>
           
          <?php } else  {  echo "Not-Active"; ?>
            
         <?php } ?>
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
        <img id="blah"  onerror="this.src='img/user.png'" src="../img/users/members_profile/<?php echo $user_profile_pic; ?>"  width="75" height="75"   src="#" alt="your image" class='profile' />
        <h5 class="card-title"><?php echo $salutation; ?> <?php echo $user_full_name; ?></h5>
        <p class="card-text">Zoobiz Id : <b> <?php echo  $zoobiz_id; ?></b></p>
        <div class="media align-items-center text-center">
          <?php if ($facebook!=''){  
            if(strpos($facebook, 'facebook.com') !== false){
              $facebook = $facebook;
            } else{
              $facebook = "https://www.facebook.com/".$facebook;
            }
            ?>
            <a target="_blank" href="<?php echo $facebook;?>"><i class="fa fa-facebook" title="Facebook"></i></a>
          <?php } ?>
          <?php if ($instagram!=''){ 
           if(strpos($instagram, 'instagram.com') !== false){
            $instagram = $instagram;
          } else{
            $instagram = "https://www.instagram.com/".$instagram;
          }
          ?>
          <a target="_blank" href="<?php echo $instagram;?>"><i class="fa fa-instagram" title="Instagram"></i></a>
        <?php } ?>
        <?php if ($linkedin!='') { 
          if(strpos($linkedin, 'linkedin.com') !== false){
            $linkedin = $linkedin;
          } else{
            $linkedin = "https://www.linkedin.com/".$linkedin;
          } ?>
          <a target="_blank" href="<?php echo $linkedin;?>"><i class="fa fa-linkedin" title="Linkedin"></i></a>
        <?php } ?>
        <?php if ($twitter!='') {
         if(strpos($twitter, 'twitter.com') !== false){
          $twitter = $twitter;
        } else{
          $twitter = "https://www.twitter.com/".$twitter;
        }
        ?>
        <a target="_blank" href="<?php echo $twitter;?>"><i class="fa fa-twitter" title="Twitter"></i></a>
      <?php } ?>
    </div>

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
    <?php if ($whatsapp_number!='0') { ?>
      <hr>
      <div class="media align-items-center">
        <div>
          <i class="fa fa-whatsapp"></i>
        </div>
        <div class="media-body text-left">
          <div class="progress-wrapper">
            <?php echo $whatsapp_number; ?>
          </div>                   
        </div>
      </div>
    <?php } ?>
    <?php if ($user_email!='') { ?>
      <hr>
      <div class="media align-items-center">
        <div>
          <i class="fa fa-envelope"></i>
        </div>
        <div class="media-body text-left">
          <div class="progress-wrapper">
            <marquee scrollamount="3"><?php echo $user_email; ?></marquee>
          </div>                   
        </div>
      </div> 


    <?php }?>
    <?php if ($gender!='') { ?>
      <hr>
      <div class="media align-items-center">
        <div>
          <i class="fa fa-user"></i>
        </div>
        <div class="media-body text-left">
          <div class="progress-wrapper">
            <?php echo $gender; ?>
          </div>                   
        </div>
      </div>
    <?php }?>
    <hr>
    <div class="media align-items-center">
      <div>
        <i class="fa fa-bars" title="Car Parking"></i>
      </div>
      <div class="media-body text-left">
        <div class="progress-wrapper">
         <?php echo $category_name; ?>
       </div>                   
     </div>

   </div>
   <hr> 

   <div class="media align-items-center">
    <div>
      <i class="fa fa-plus-circle" title="Car Parking"></i>
    </div>
    <div class="media-body text-left">
      <div class="progress-wrapper">
       <?php echo $followers;?> Followers
       <?php if($followers >0){ ?> 
       <a target="_blank"  href="memberFollowers?user_id=<?php echo $user_id;?>"   class="btn btn-secondary btn-sm" type="">View Details </a>
       <?php } ?> 
     </div>                   
   </div>

 </div>
 <hr>
 <div class="media align-items-center">
  <div>
    <i class="fa fa-plus-circle" title="Car Parking"></i>
  </div>
  <div class="media-body text-left">
    <div class="progress-wrapper">
     <?php echo $following;?>  Following  
     <?php if($following >0){ ?> 
     <a target="_blank"  href="memberFollowing?user_id=<?php echo $user_id;?>"   class="btn btn-secondary btn-sm" type="">View Details </a>
   <?php } ?> 
   </div>                   
 </div>

</div>
<hr> 
<div class="media align-items-center">
  <div>
    <i class="fa fa-calendar" title="Car Parking"></i>
  </div>
  <div class="media-body text-left">
    <div class="progress-wrapper"> 
      Plan Expire On : <?php

/*$qb=$d->select("package_master","package_id='$plan_id'","");
$row1=mysqli_fetch_array($q);
 if($row1["time_slab"] == 1){
 } else { */
   echo date("d M Y", strtotime($plan_renewal_date));
   $date11 = new DateTime($today);
   $date22 = new DateTime($plan_renewal_date);
   $interval = $date11->diff($date22);
   echo "<br>";

   echo  $difference_days= $interval->days . " days left"; 
                      //  }
   ?>
    
 </div>                   
</div>

</div>

<hr>
<div class="media align-items-center">
  <div>
    <i class="fa fa-clock-o" title="Car Parking"></i>
  </div>
  <div class="media-body text-left">
    <div class="progress-wrapper"> 
      Last App Access :<br>  <?php if ($last_login!='0000-00-00 00:00:00') {
        echo date("d M Y h:i A", strtotime($last_login)); 
      } ?>
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

          <?php if ($user_email!='') { ?>
           <hr>
           <div class="media align-items-center">
            <div>
             <i class="fa fa-lock" aria-hidden="true"></i>  
           </div>
           <div class="media-body text-left">
            <div class="progress-wrapper">Email Privacy: 
              <?php if($email_privacy=="1"){ echo "Yes"; ?>
               
             <?php } else {  echo "No"; ?>
              
            <?php } ?>
          </div>                   
        </div>
      </div>


    <?php }

//9nov2020
    $transection_master_qry_new=$d->select("transection_master","user_id='$user_id'" ,"");
    $transection_master_data_new=mysqli_fetch_array($transection_master_qry_new);
    if($transection_master_data_new['is_paid'] == 0){
      ?> 
      <hr>
      <div class="media align-items-center">
        <div>
         <i class="fa fa-download" aria-hidden="true"></i>  
       </div>
       <div class="media-body text-left">
        <div class="progress-wrapper">Invoice Download: 
          <?php if($invoice_download=="1"){  echo "Yes"; ?>
           
         <?php } else {   echo "No"; ?>
           
        <?php } ?>

        
      </div>                   
    </div>
  </div>

  <?php
 //9nov2020
}  else {

  ?>
  <hr>
  <div class="media align-items-center">
    <div>
     <i class="fa fa-info" aria-hidden="true"></i>  
   </div>
   <div class="media-body text-left">
    <div class="progress-wrapper"> 
      <?php 
      if($transection_master_data_new['coupon_id'] !=0){
        $cpn_id = $transection_master_data_new['coupon_id'];
        $coupon_master_qry_new=$d->select("coupon_master","coupon_id='$cpn_id'" ,"");
        $coupon_master_data_new=mysqli_fetch_array($coupon_master_qry_new);
        echo "Coupon: ".$coupon_master_data_new['coupon_name'];
      } else {
        echo "Backend Admin";
      }

      ?>

    </div>
  </div> 
</div>
<?php 


}
 //9nov2020



if ($refer_by!='0') { ?>
 <hr>
 <div class="media align-items-center">
  <div>
   <i class="fa fa-user-plus" aria-hidden="true"></i>  
 </div>
 <div class="media-body text-left">
  <div class="progress-wrapper">Refer By: 
    <?php if ($refer_by==1){ 
      echo "Social Media";
    } else  if ($refer_by==2){ 
      echo "Member / Friend".'<br>';
      echo $refere_by_name.' ('.$refere_by_phone_number.')';
    } else  if ($refer_by==3){ 
      echo "Other";
      if($remark !=""){
        echo '<br>'.$remark;
      }

    } ?>

  </div>                   
</div>
</div>


<?php }
          //7oct2020
?> 
<?php
 //7oct2020

$memberAdded=$d->count_data_direct("user_mobile"," users_master  "," refere_by_phone_number ='$user_mobile'");

if ($memberAdded > 0 ) { ?>
 <hr>
 <div class="media align-items-center">
  <div>
   <i class="fa fa-user-plus" aria-hidden="true"></i>  
 </div>
 <div class="media-body text-left">
  <div class="progress-wrapper">Member Added: 
    <?php  echo $memberAdded; ?>
    <a href="memberReferDetails?user_mobile=<?php echo $user_mobile;?>"   class="btn btn-secondary btn-sm" type="">View Details </a>
  </div>                   
</div>
</div>


<?php }
          //7oct2020

//22dec2020
if (isset($_SESSION['zoobiz_admin_id'])) { ?> 

 <hr>
 <div class="media align-items-center">
  <div>
   <i class="fa fa-cogs" aria-hidden="true"></i>  
 </div>
 <div class="media-body text-left">
  <div class="progress-wrapper">Is Office Member?: 
    <?php if($office_member=="1"){ echo "Yes"; ?>
     
   <?php } else { echo "No"; ?>
     
  <?php } ?>
</div>                   
</div>
</div>



<?php  
} 

 //7oct2020

?>     
 
 
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
          <a href="javascript:void();" data-target="#messages" data-toggle="pill" class="nav-link "><i class="fa fa-book"></i> <span class="hidden-xs">Billing Details </span></a>
        </li>
        <li class="nav-item">
          <a href="javascript:void();" data-target="#emergency" data-toggle="pill" class="nav-link "><i class="fa fa-map-marker"></i> <span class="hidden-xs">Address </span></a>
        </li>
        <li class="nav-item">
          <a href="javascript:void();" data-target="#Professional" data-toggle="pill" class="nav-link "><i class="fa fa-pencil"></i> <span class="hidden-xs">Professional </span></a>
        </li>

                <?php //2nov2020
                $today = date("Y-m-d");
                $validDateToEdit = date('Y-m-d', strtotime($register_date. ' + 3 days'));
                if(strtotime($today) <=   strtotime($validDateToEdit) || 1  ) { 
                  if ($refer_by!='0' ||1 ) { ?>
                    <li class="nav-item">
                      <a href="javascript:void();" data-target="#editRefer" data-toggle="pill" class="nav-link "><i class="fa fa-pencil"></i> <span class="hidden-xs">Refer By </span></a>
                    </li>
                  <?php } 
                } //2nov2020 ?>


              </ul>
              <div class="tab-content p-3">
                <div class="tab-pane " id="messages">
                 <form id="companyDetailFrm2" action="controller/userController.php" method="post" enctype="multipart/form-data">
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Business Name: </label>
                    <div class="col-lg-9"> <?php echo $company_name; ?>
                       
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Contact Number: </label>
                    <div class="col-lg-9"> <?php if($company_contact_number!=0) echo $company_contact_number; ?>
                      
                      
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Billing Address:  </label>
                    <div class="col-lg-9"> <?php echo $billing_address; ?>
                     
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">GST Number: </label>
                    <div class="col-lg-9"> <?php echo $gst_number; ?>
                      
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Pincode: </label>
                    <div class="col-lg-9"> <?php if($billing_pincode!=0) { echo $billing_pincode; } ?>
                      
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Bank Name: </label>
                    <div class="col-lg-9"> <?php echo $bank_name; ?>
                      
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Bank Account No.: </label>
                    <div class="col-lg-9"> <?php if($bank_account_number!=0) echo $bank_account_number; ?>
                       
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">IFSC Code: </label>
                    <div class="col-lg-9"> <?php echo $ifsc_code; ?>
                       
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Contact Person: </label>
                    <div class="col-lg-9"> <?php echo $billing_contact_person_name; ?>
                       
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Contact Person No.: </label>
                    <div class="col-lg-9"> <?php echo $billing_contact_person; ?>
                       
                    </div>
                  </div>

                  <?php //29 oct ?> 
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Plan Expiry Date: </label>
                    <div class="col-lg-9"> <?php echo date("Y-m-d", strtotime($plan_renewal_date)); ?>
                      
                    </div>
                  </div>

                  <?php //29 oct ?> 


                  
                  
                </form>

              </div>
              <div class="tab-pane" id="emergency">

                <?php  $fq11 = $d->select("business_adress_master,cities,states,countries,area_master", "business_adress_master.user_id='$user_id'
                  AND
                  business_adress_master.country_id = countries.country_id
                  AND
                  business_adress_master.state_id = states.state_id
                  AND
                  business_adress_master.city_id = cities.city_id
                  AND
                  business_adress_master.area_id = area_master.area_id","ORDER BY business_adress_master.adress_type ASC");
                  if(mysqli_num_rows($fq11)>0) { ?>
                    <div class="table-responsive">
                      <table class="table align-items-center table-bordered table-flush">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>House No./ Floor/ Building</th>
                            <th>landmamrk/ Street</th>
                            <th>City</th>
                            <th>Type</th>
                            
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $i=1;
                          while ($fData=mysqli_fetch_array($fq11)) {
                            ?>
                            <tr>
                              <td><?php echo $i++; ?></td>
                              <td><?php echo  custom_echo($fData['adress'],30) ?></td><td><?php echo  custom_echo($fData['adress2'],30) ?></td>
                              <td><?php echo $fData['city_name']; ?></td>
                              <td><?php if($fData['adress_type']==0) {
                                echo "Primary";
                              } else {
                                echo "Other";
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

<?php //2nov2020
$today = date("Y-m-d");
$validDateToEdit = date('Y-m-d', strtotime($register_date. ' + 3 days'));
if(strtotime($today) <=   strtotime($validDateToEdit) ||1 ) { 
  if ($refer_by!='0' ||1) {
   ?>
   <div class="tab-pane  " id="editRefer">
    <form id="editReferFrm" action="controller/userController.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="refer_user_id" value="<?php echo $user_id;?>">
      <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Refer By: </label>
        <div class="col-lg-9">
            <?php if($refer_by==1){ echo "Social Media";} ?> <?php if($refer_by==2){ echo "Member / Friend";}  ?><?php if($refer_by==3){ echo "Other";} ?>  
          </select>
        </div>

      </div>

      <div class="form-group row">
        <label  <?php if($refer_by==2){  }  else {?> style="display: none" <?php } ?>  id="refere_by_name_lbl" class="col-lg-3 col-form-label form-control-label">Refer By Name: </label>
        <div  <?php if($refer_by==2){  }  else {?> style="display: none"   <?php } ?> class="col-lg-3" id="refere_by_name_div"> <?php echo $refere_by_name;?>
         
          </div>

          <label <?php if($refer_by==2){  }  else {?> style="display: none"  <?php } ?> id="refere_by_phone_number_lbl" class="col-lg-3 col-form-label form-control-label">Refer Perosn Number: </label>
          <div <?php if($refer_by==2){  }  else {?> style="display: none" <?php } ?> class="col-lg-3" id="refere_by_phone_number_div"> <?php echo $refere_by_phone_number;?>
           
            </div>


            <label <?php if($refer_by==3){  }  else {?>  style="display: none" <?php }?>  id="remark_lbl" class="col-lg-3 col-form-label form-control-label">Remarks: </label>
            <div <?php if($refer_by==3){  }  else {?>  style="display: none" <?php }?>  class="col-lg-9" id="remark_div"> <?php echo $remark;?>
              
              </div>
            </div>
            <?php 

            if(strtotime($today) <=   strtotime($validDateToEdit)  ) { 
              if ($refer_by!='0'  ) { ?> 
                

              <?php }
            } ?> 
          </form>
        </div>
        <?php 
      }
    } //2nov2020?> 

    <div class="tab-pane active" id="edit">
      <form id="memberBasicFrm" action="controller/userController.php" method="post" enctype="multipart/form-data">
       <div class="form-group row">
         <label class="col-lg-3 col-form-label form-control-label">Salutation: </label>
         <div class="col-lg-9">
           <?php if($salutation== "Mr.") { echo 'Mr.';} ?>  

           <?php if($salutation== "Mrs.") { echo 'Mrs.';} ?> <?php if($salutation== "Miss") { echo 'Miss';} ?>  <?php if($salutation== "Ms") { echo 'Ms';} ?> <?php if($salutation== "Dr.") { echo 'Dr.';} ?>   <?php if($salutation== "Prof.") { echo 'Prof.';} ?>   <?php if($salutation== "Other") { echo 'Other';} ?> 
           
        </div>
      </div>
      <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">First Name: </label>
        <div class="col-lg-9"><?php echo $user_first_name ; ?>
           
        </div>
      </div>
      <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Last Name: </label>
        <div class="col-lg-9"><?php echo $user_last_name; ?>
           
        </div>
      </div>
      <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Date Of Birth: </label>
        <div class="col-lg-9">


         <?php 
          if($member_date_of_birth !=""){
            $member_date_of_birth= str_replace("/", "-",$member_date_of_birth);
            echo date("Y-m-d", strtotime($member_date_of_birth));
            } else {
              $member_date_of_birth=date("Y-m-d");
            }
            
            ?> 
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Mobile Number: </label>
          <div class="col-lg-9">
            
           <?php echo $user_mobile; ?> 
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Whatsapp No.: </label>
          <div class="col-lg-9"><?php if($whatsapp_number!=0) {  echo $whatsapp_number; }?>
           
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Alternate Mobile Number: </label>
          <div class="col-lg-9">
             <?php if($alt_mobile!=0) { echo $alt_mobile; } ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Gender:</label>
          <div class="col-lg-9"> <?php if($gender=='Male'){echo "Male";} else { echo "Female"; } ?>
             
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Email: </label>
          <div class="col-lg-9"><?php echo $user_email; ?>
            
          </div>
        </div>



      
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Plan Expired Date: </label>
          <div class="col-lg-9"><?php echo $plan_renewal_date; ?>
             
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Facebook Url: </label>
          <div class="col-lg-9"> <?php echo $facebook; ?>
           
          </div>
        </div>

        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Instagram Url: </label>
          <div class="col-lg-9"> <?php echo $instagram; ?>
            
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Linkedin Url: </label>
          <div class="col-lg-9"> <?php echo $linkedin; ?>
           
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Twitter Url: </label>
          <div class="col-lg-9"> <?php echo $twitter; ?>
            
          </div>
        </div>


         

        


        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Social Media Name: </label>
          <div class="col-lg-9"> <?php echo $user_social_media_name; ?>
            </div>
        </div>


         
      </form>
    </div>
    <div class="tab-pane " id="Professional">
      <form id="professionalInfoFrm" action="controller/userController.php" method="post" enctype="multipart/form-data">
        <div class="form-group row">
          <?php 
          $q1=$d->select("user_employment_details","user_id='$user_id'");
          $proData=mysqli_fetch_array($q1);
          ?>
        </div>
        <div class="proExtDiv">
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Professional Category: </label>
            <div class="col-lg-9">
              
                <?php $qb=$d->select("business_categories",""," order by category_name asc");
                while ($bData=mysqli_fetch_array($qb)) {?>
               <?php if($proData['business_category_id']== $bData['business_category_id']) { echo $bData['category_name'];} ?>  
                <?php } ?> 
              
            </div>
          </div>
          <div class="form-group row" id="ProfessionalOther" style="<?php if($proData['business_categories']!= "Other") { echo 'display: none';} ?>">
            <label class="col-lg-3 col-form-label form-control-label">Other Category: </label>
            <div class="col-lg-9">  <?php echo $business_categories_other; ?>
           
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Professional Type: </label>
            <div class="col-lg-9">
              
                <?php if($proData>0) { 
                  $q3=$d->select("business_sub_categories","business_category_id='$proData[business_category_id]'","");
                  while ($blockRow=mysqli_fetch_array($q3)) {
                    ?>
                    <?php if($blockRow['business_sub_category_id']== $proData['business_sub_category_id']) { echo $blockRow['sub_category_name'];} ?>  
                  <?php } } ?>
                
              </div>
            </div>
            <div class="form-group row" id="ProfessionalTypeOther" style="<?php if($proData['business_categories_sub']!= "Other") { echo 'display: none';} ?>" >
              <label class="col-lg-3 col-form-label form-control-label">Other: Professional</label>
              <div class="col-lg-9"> <?php echo $professional_other; ?>
               
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Business Name: </label>
              <div class="col-lg-9"> <?php echo $company_name; ?>
                 
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Business Contact Number: </label>
              <div class="col-lg-9"> <?php if($company_contact_number!=0) echo $company_contact_number; ?>
                
              </div>
            </div>

            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Business Landline Number: </label>
              <div class="col-lg-9"> <?php if($company_landline_number!='') echo $company_landline_number; ?>
                 
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Business Email: </label>
              <div class="col-lg-9"> <?php echo $company_email; ?>
                 
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Designation: </label>
              <div class="col-lg-9"> <?php echo $designation; ?>
                 
              </div>
            </div>


            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Website: </label>
              <div class="col-lg-9">
                <?php
                $url_prefix = "http://";

                if( strpos( $proData['company_website'], "https://" ) !== false || strpos( $proData['company_website'], "http://" ) !== false || trim($proData['company_website'])=="") {
                  $url_prefix = "";
                } ?> <?php echo $url_prefix.$proData['company_website']; ?>
               
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">About Business: </label>
            <div class="col-lg-9"> <?php echo $proData['business_description']; ?>
             
            </div>
          </div>

          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Search Keywords: </label>
            <div class="col-lg-9"> <?php echo $proData['search_keyword']; ?>
               
            </div>
          </div>

          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Products/Services: </label>
            <div class="col-lg-9"> <?php echo $proData['products_servicess']; ?>
              
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Business Logo: </label>
            
            <div class="col-lg-9">
              <?php if ($company_logo!='') { ?>
                <img width="50" height="50" src="../img/users/company_logo/<?php echo $company_logo;?>">
              <?php } else { echo "N/A"; } ?>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Business Brochure: </label>
            
            <div class="col-lg-9">
              <?php if ($company_broucher!='') { ?>
                <a class="btn btn-sm btn-danger" target="_blank" href="../img/users/company_broucher/<?php echo $company_broucher;?>">View Broucher</a>
              <?php }  else { echo "N/A"; } ?>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Business Profile: </label>
            
            <div class="col-lg-9">
              <?php if ($company_profile!='') { ?>
                <a class="btn btn-sm btn-danger" target="_blank" href="../img/users/comapany_profile/<?php echo $company_profile;?>">View Profile</a>
              <?php } else { echo "N/A"; } ?>
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
 
 
