<?php 
extract($_REQUEST);

if(filter_var($id, FILTER_VALIDATE_INT) != true){
  $_SESSION['msg1']='Invalid User';
  echo ("<script LANGUAGE='JavaScript'>
    window.location.href='manageMembers';
    </script>");
}
/*if( ($_SESSION['role_id'] != 1 && $_SESSION['role_id'] != 2) ){
  // header('location:../memberView?id='.$id);exit;
   $_SESSION['msg1']='Invalid User';
   echo ("<script LANGUAGE='JavaScript'>
    window.location.href='memberView?id=".$id."';
    </script>");
}*/

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
          <?php /*
          Account Status :  <?php if($userData['active_status']=="0"){
            ?>
            <input disabled=""  type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $userData['user_id']; ?>','userDeactive');" data-size="small"/>
          <?php } else { ?>
           <input disabled="" type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $userData['user_id']; ?>','userActive');" data-size="small"/>
         <?php } ?>
         <?php */ ?>
       </div>

       

       <div class="col-sm-4">
        <div class="btn-group float-sm-right">
         <form action="address" method="post">
          <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
          <button  type="submit" class="btn btn-success btn-sm ">Add Address</button>
        </form>
        <!--  <a href="#"  class="btn btn-sm btn-warning waves-effect waves-light"><i class="fa fa-history mr-1"></i> View History</a> -->
        <?php if (mysqli_num_rows($nqBlock)) { ?>
         <form action="controller/memberController.php" method="post">    
          <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">    
          <input type="hidden" name="business_houses_id" value="<?php echo $bData['business_houses_id']; ?>">    
          <input type="hidden" name="removeBusinesHouses" value="removeBusinesHouses">                 
          <button type="submit" name="" class="btn shadow-danger btn-danger btn-sm form-btn"><i class="fa fa-trash-o mr-1"></i> Remove From Business Houses  </button>
        </form>
      <?php }  else { ?>
        <form action="controller/memberController.php" method="post">    
          <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">    
          <input type="hidden" name="addBusinessHouses" value="addBusinessHouses">            
          <button class="btn btn-sm btn-danger waves-effect waves-light"><i class="fa fa-exchange mr-1"></i> Add To Business Houses </button>
        </form>
      <?php } ?>
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
         <a href="mailto:<?php echo $user_email;?>"  > <i class="fa fa-envelope"></i></a>
        </div>
        <div class="media-body text-left">
         <div class="progress-wrapper">
            <marquee scrollamount="3"> <a href="mailto:<?php echo $user_email;?>"  >  <?php echo $user_email;?></a>   </marquee>
            
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

<?php

$selected=$d->select("interest_relation_master,interest_master"," interest_master.interest_id=interest_relation_master.interest_id and   interest_relation_master.member_id='$user_id'");
      if (mysqli_num_rows($selected)>0) {
        $arr = array();
                  while ($selected_new=mysqli_fetch_array($selected)) {
                    $arr[]= $selected_new['interest_name'];
                  }
                  $arr = implode(", ", $arr);

                   
                          ?>
                          <hr>

                           <div class="media align-items-center">
  <div>
    <i class="fa fa-plus-circle" title="Car Parking"></i>
  </div>
  <div class="media-body text-left">
    <div class="progress-wrapper">Interests: 
      <?php  if(strlen($arr) > 20 ||1) {
                          $data = substr($arr, 0, 20);
                       //   echo $data; 
                          ?>
                          <button class="btn btn-secondary btn-sm"  data-toggle="collapse" data-target="#demo<?php echo $h;?>">View</button>
                              <div id="demo<?php echo $h;?>" class="collapse">
                            <?php    echo  wordwrap($arr,25,"<br>\n") ;?>
                            </div>
                            <?php
                         }  ?>
   </div>                   
 </div>

</div>
 <?php   }  ?>


<hr> 
<div class="media align-items-center">
  <div>
    <i class="fa fa-calendar" title="Car Parking"></i>
  </div>
  <div class="media-body text-left">
    <div class="progress-wrapper"> 
      Plan Expire Date : <?php

/*$qb=$d->select("package_master","package_id='$plan_id'","");
$row1=mysqli_fetch_array($q);
 if($row1["time_slab"] == 1){
 } else { */
   echo date("d M Y", strtotime($plan_renewal_date));
   $date11 = new DateTime($today);
   $date22 = new DateTime($plan_renewal_date);
   $interval = $date11->diff($date22);
   echo "<br>";


$curDate = date("Y-m-d");
 

   //$difference_days= $interval->days;

$difference_days= $d->plan_days_left($plan_renewal_date);
                      //  }
 
   if(    $difference_days <= 0  ){ 
   // echo  $difference_days. " days left"; 
 
    if(0){ 
   ?>
   <button data-toggle="modal" data-target="#replyModal" class="btn btn-success btn-sm" type="">Renew </button>
 <?php  }

  }  else {
  echo  $difference_days  . " days left"; 
 }?> 
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

   


          <?php if ($user_email!='') { ?>
           <hr>
           <div class="media align-items-center">
            <div>
             <i class="fa fa-lock" aria-hidden="true"></i>  
           </div>
           <div class="media-body text-left">
            <div class="progress-wrapper">Email Privacy: 
              <?php if($email_privacy=="1"){ ?>
               <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $user_id; ?>','userPrivacyDeactive');" data-size="small"/>
             <?php } else { ?>
              <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $user_id; ?>','userPrivacyActive');" data-size="small"/>
            <?php } ?>
          </div>                   
        </div>
      </div>


    <?php }

//9nov2020
    $transection_master_qry_new=$d->select("transection_master","  user_id='$user_id' order by transection_id  desc" ,"");
    $transection_master_data_new=mysqli_fetch_array($transection_master_qry_new);


      $qp=$d->select("transection_master, user_employment_details ,business_adress_master,users_master,states,countries","countries.country_id=business_adress_master.country_id AND transection_master.user_id = users_master.user_id and
      user_employment_details.user_id = users_master.user_id and
      business_adress_master.user_id = users_master.user_id and
      states.state_id = business_adress_master.state_id and
      users_master.user_id='$user_id' and transection_master.is_paid = 0   group by DATE(transection_master.transection_date)  order by transection_master.transection_id asc    ");
    if($transection_master_data_new['is_paid'] == 0 && mysqli_num_rows($qp)  > 0 ){

      
   
      ?> 
      <hr>
      <div class="media align-items-center">
        <div>
         <i class="fa fa-download" aria-hidden="true"></i>  
       </div>
       <div class="media-body text-left">
        <div class="progress-wrapper">Invoice Download: 
          <?php if($invoice_download=="1"){ ?>
           <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $user_id; ?>','userDownloadInvoiceOff');" data-size="small"/>
         <?php } else { ?>
          <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $user_id; ?>','userDownloadInvoiceOn');" data-size="small"/>
        <?php } ?>

        <?php
 //23sept2020 

       
   if(mysqli_num_rows($qp) > 1){
    $invoice_no = 1;
  } else {
    $invoice_no = '';
  }

while ($transection_master_data_new2=mysqli_fetch_array($qp)) {
        if($invoice_download=="1"  ){

 //
          ?>



          <br>
          <a target="_blank"  href="../paymentReceipt.php?user_id=<?php echo $user_id; ?>&download=true&transection_date=<?php echo date("Y-m-d", strtotime($transection_master_data_new2['transection_date'])); ?>" class=" btn-sm btn-info"><i class="fa fa-download"></i>Download Invoice <?php echo $invoice_no;?> </a>

          <br>
          <a onclick="return popitup('../paymentReceipt.php?user_id=<?php echo $user_id; ?>&transection_date=<?php echo date("Y-m-d", strtotime($transection_master_data_new2['transection_date'])); ?>')" href="#" class=" btn-sm btn-warning"><i class="fa fa-print"></i>Print Invoice <?php echo $invoice_no;?> </a>
        <?php }
        $invoice_no++;
         } ?>
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
    <?php   if($office_member=="1"){ ?>
     <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $user_id; ?>','OfficeMemberDeactive');" data-size="small"/>
     <?php
     if($_SERVER['SERVER_NAME'] =="asif.zoobiz.in"){
       echo '<br> OTP: '.$otp;
     }
      ?>
   <?php } else { ?>
    <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $user_id; ?>','OfficeMemberActive');" data-size="small"/>
  <?php } ?>
</div>                   
</div>
</div>



<?php  
} 

 //7oct2020

?>  

<hr>
 <div class="media align-items-center">
  <div>
   <i class="fa fa-info" aria-hidden="true"></i>  
 </div>
 <div class="media-body text-left">
  <div class="progress-wrapper">Logs: 
    
    <a target="_blank"  href="logs?user_id=<?php echo $user_id;?>"   class="btn btn-secondary btn-sm" type="">Logs</a>
  </div>                   
</div>
</div>


<hr>
<div class="row">
  <div class="col-xs-6 col-12">
<?php if ($user_mobile =="8866489158" || $user_mobile == "9913393220" ||  $user_mobile == "7990032612" || $user_mobile == "9687271071" ||  $user_mobile =="1356786543" ||  $user_mobile =="9737175767" ||  $user_mobile =="9157146041" || $office_member=="1" ) { ?>

    <form action="controller/userController.php" method="post">
      <input type="hidden" name="force_delete_user_id" value="<?php echo $user_id; ?>">
      <input type="hidden" name="user_fcm" value="<?php echo $user_token; ?>">

      <button type="submit" class="btn form-btn btn-danger" >Force Delete User</button>
    </form>
<br>
<?php } ?> 
    <?php if ($active_status ==0 ) { ?>
    <form action="controller/userController.php" method="post">
      <input type="hidden" name="delete_user_id" value="<?php echo $user_id; ?>">
      <input type="hidden" name="user_fcm" value="<?php echo $user_token; ?>">

      <button type="submit" class="btn form-btn btn-danger" >Deactivate User</button>
    </form>
  <?php } else { ?>
 <form action="controller/userController.php" method="post">
      <input type="hidden" name="active_user_id" value="<?php echo $user_id; ?>">
      <input type="hidden" name="user_fcm" value="<?php echo $user_token; ?>">

      <button type="submit" class="btn form-btn btn-warning" >Activate User</button>
    </form>
 <?php } ?> 
  </div>
  <div class="col-xs-6 col-12">
    <br>

    <?php if ($user_token!='') { ?>
      <form  action="controller/userController.php" method="post" class="mt-4">
        <input type="hidden" name="user_token" value="<?php echo $user_token; ?>">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="bId" value="<?php echo $block_id; ?>">
        <input type="hidden" name="device" value="<?php echo $device; ?>">
        <input type="hidden" name="logoutDevice" value="logoutDevice">
        <button type="submit" class="btn form-btn btn-warning" >Logout From App</button>
      </form>
    <?php } ?>
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


               <?php //26april21
                 if ($_SESSION['role_id'] ==1 ) { ?>
                    <li class="nav-item">
                      <a href="javascript:void();" data-target="#superTab" data-toggle="pill" class="nav-link "><i class="fa fa-pencil"></i> <span class="hidden-xs">User Mobile </span></a>
                    </li>
                  <?php } //26april21  ?>

              </ul>
              <div class="tab-content p-3">
                <div class="tab-pane " id="messages">
                 <form id="companyDetailFrm2" action="controller/userController.php" method="post" enctype="multipart/form-data">
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Business Name <span class="required">*</span></label>
                    <div class="col-lg-9">
                      <input type="hidden" name="user_fcm" value="<?php echo $user_token; ?>">
                      <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                      <input type="hidden" name="billingUpdate" value="<?php echo "billingUpdate"; ?>">
                      <input minlength="3" maxlength="80"  class="form-control" name="company_name" type="text" value="<?php echo $company_name; ?>" required="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Contact Number </label>
                    <div class="col-lg-9">
                      <input   class="form-control onlyNumber" name="company_contact_number" minlength="6"  maxlength="12"  type="text" value="<?php if($company_contact_number!=0) echo $company_contact_number; ?>" id="company_contact_number">
                      <!-- <input required="" class="form-control" name="user_mobile" onblur="checkMobileUserEdit()" maxlength="10"  type="text" value="<?php echo $user_mobile; ?>" id="userMobile"> -->
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Billing Address  </label>
                    <div class="col-lg-9">
                      <textarea class="form-control" name="billing_address" type="text" value=""  ><?php echo $billing_address; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">GST Number </label>
                    <div class="col-lg-9">
                      <input class="form-control text-capitalize" minlength="15"  maxlength="15" id="gst" name="gst_number" type="text" value="<?php echo $gst_number; ?>" >
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Pincode </label>
                    <div class="col-lg-9">
                      <input class="form-control onlyNumber" name="billing_pincode"  maxlength="6"  type="text" value="<?php if($billing_pincode!=0) { echo $billing_pincode; } ?>" id="billing_pincode">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Bank Name </label>
                    <div class="col-lg-9">
                      <input class="form-control" type="text" minlength="3" maxlength="80"  name="bank_name"  value="<?php echo $bank_name; ?>" id="bank_name">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Bank Account No. </label>
                    <div class="col-lg-9">
                      <input class="form-control onlyNumber" type="text" name="bank_account_number"  value="<?php if($bank_account_number!=0) echo $bank_account_number; ?>" id="bank_account_number"   maxlength="80" >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">IFSC Code </label>
                    <div class="col-lg-9">
                      <input class="form-control" type="text" name="ifsc_code"  value="<?php echo $ifsc_code; ?>" id="ifsc_code" maxlength="80">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Contact Person </label>
                    <div class="col-lg-9">
                      <input class="form-control" minlength="3" maxlength="80" type="text" name="billing_contact_person_name"  value="<?php echo $billing_contact_person_name; ?>" id="billing_contact_person_name">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Contact Person No. </label>
                    <div class="col-lg-9">
                      <input class="form-control onlyNumber" minlength="6" maxlength="12" type="text" name="billing_contact_person"  value="<?php echo $billing_contact_person; ?>" id="billing_contact_person">
                    </div>
                  </div>

                  <?php /* 
                  //29 oct ?> 
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Plan Expiry Date </label>
                    <div class="col-lg-9">
                      <input class="form-control "  readonly=""  type="text" name="plan_renewal_date"  value="<?php echo date("Y-m-d", strtotime($plan_renewal_date)); ?>" id="autoclose-datepicker-evt">
                    </div>
                  </div>

                  <?php //29 oct
                  */ ?> 


                  <div class="form-group row">
                    <div class="col-lg-12 text-center">
                      <input type="submit" id="socAddBtn" class="btn btn-primary" name="updateUserProfile"  value="Update">
                    </div>
                  </div>
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
                            <th>House No./<br>Floor/<br>Building</th>
                            <th>landmark/<br>Street</th>
                            <th>City</th>
                            <th>Type</th>
                            <th>Action</th>
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
                                echo "Main Office";
                              } else {
                                echo "Sub Office";
                              } ?></td>
                              <td>
                                <form action="address" style="float: right;margin-left: 40px;" method="post">    
                                  <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">    
                                  <input type="hidden" name="adress_id" value="<?php echo $fData['adress_id']; ?>">    
                                  <input type="hidden" name="editAddress" value="editAddress">                 
                                  <button type="submit" name="" class="btn shadow-danger btn-warning btn-sm"><i class="fa fa-pencil"></i> </button>
                                </form>
                                <?php if($fData['adress_type'] == 1 ) {  ?>
                                  <form action="controller/userController.php" method="post">    
                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">    
                                    <input type="hidden" name="adress_id" value="<?php echo $fData['adress_id']; ?>">    
                                    <input type="hidden" name="removeAddress" value="removeAddress">                 
                                    <button type="submit" name="" class="btn shadow-danger btn-danger btn-sm form-btn"><i class="fa fa-trash-o"></i> </button>
                                  </form>
                                <?php } ?> 
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
        <label class="col-lg-3 col-form-label form-control-label">Refer By <span class="required">*</span></label>
        <div class="col-lg-9">
          <select <?php if(strtotime($today) >   strtotime($validDateToEdit) && 0   ) { 
            echo "disabled";  } ?>  id="refer_by" onchange="referBy();" class="form-control single-select" name="refer_by" required=""   >
            <option value="">-- Select --</option>
            <option <?php if($refer_by==1){ echo "selected";} ?> value="1">Social Media</option>
            <option  <?php if($refer_by==2){ echo "selected";} ?> value="2">Member / Friend</option>

            <?php /* <option   <?php if($refer_by==3){ echo "selected";} ?> value="3">Other</option> */ ?>
            
          </select>
        </div>

      </div>


        <div class="form-group row"  >
                             
                                <label  <?php if($refer_by==2){  }  else {?> style="display: none" <?php } ?>  id="refere_by_user_div" class="col-lg-3 col-form-label form-control-label" for="refere_by_name" >Referred Member <span class="required">*</span></label>
                                 <div   class="col-lg-9" <?php if($refer_by==2){  }  else {?> style="display: none" <?php } ?> id="refere_by_user_div2" >
                                <input maxlength="50" class="form-control" type="text" id="refer_friend_name" name="refer_friend_name"    placeholder="Type Member Name To Get Selections" autocomplete="off">
                             
                             <select   class="form-control multiple-select" name="refer_friend_id"   required=""    id="refer_friend_id">
                            <?php if($refer_by==2){ ?>   <?php 
                              $meq = $d->selectRow("users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_name,user_employment_details.designation,cities.city_name,area_master.area_name,users_master.public_mobile,users_master.user_mobile
    ","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master,cities,area_master", " 
    business_categories.category_status = 0 and
    area_master.area_id=business_adress_master.area_id AND cities.city_id=business_adress_master.city_id AND business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND users_master.office_member=0 AND users_master.active_status=0   and (users_master.user_id ='$referred_by_user_id' OR users_master.user_mobile='$refere_by_phone_number' ) ", "");
  if (mysqli_num_rows($meq) > 0) {
    while ($blockRow=mysqli_fetch_array($meq)) {
      ?>
      <option selected=""  value="<?php echo $blockRow['user_id'];?>"><?php echo $blockRow['user_full_name'];?>(<?php echo $blockRow['city_name'];?>)</option>

    <?php } 
  }?><?php } else {
    ?>
  <option value="">--Select--</option>

  <?php
  } ?> 
                            </select>
                          </div>
                        </div>



      <div class="form-group row">
        <?php /* ?> 
        <label  <?php if($refer_by==2){  }  else {?> style="display: none" <?php } ?>  id="refere_by_name_lbl" class="col-lg-3 col-form-label form-control-label">Refer By Name <span class="required">*</span></label>
        <div  <?php if($refer_by==2){  }  else {?> style="display: none"   <?php } ?> class="col-lg-3" id="refere_by_name_div">
          <input <?php if(strtotime($today) >   strtotime($validDateToEdit) && 0  ) { 
            echo "disabled";  } ?>    class="form-control" name="refere_by_name"  maxlength="60" minlength="3"  type="text" value="<?php echo $refere_by_name;?>" id="refere_by_name" >
          </div>

          <label <?php if($refer_by==2){  }  else {?> style="display: none"  <?php } ?> id="refere_by_phone_number_lbl" class="col-lg-3 col-form-label form-control-label">Refer Perosn Number <span class="required">*</span></label>
          <div <?php if($refer_by==2){  }  else {?> style="display: none" <?php } ?> class="col-lg-3" id="refere_by_phone_number_div">
            <input  <?php if(strtotime($today) >   strtotime($validDateToEdit)  && 0  ) { 
              echo "disabled";  } ?>   class="form-control onlyNumber" name="refere_by_phone_number"  maxlength="10" minlength="3"  type="text" value="<?php echo $refere_by_phone_number;?>" id="refere_by_phone_number">
            </div>
            <?php */ ?>

            <label <?php if($refer_by==3){  }  else {?>  style="display: none" <?php }?>  id="remark_lbl" class="col-lg-3 col-form-label form-control-label">Remarks</label>
            <div <?php if($refer_by==3){  }  else {?>  style="display: none" <?php }?>  class="col-lg-9" id="remark_div">
              <input  <?php if(strtotime($today) >   strtotime($validDateToEdit) && 0   ) { 
                echo "disabled";  } ?>   class="form-control" name="remark"  maxlength="100" minlength="3"  type="text" value="<?php echo $remark;?>" >
              </div>
            </div>
            <?php 

if($userData['active_status']=="0"){
            if(strtotime($today) <=   strtotime($validDateToEdit) || 1 ) { 
              if ($refer_by!='0'   || 1 ) { ?> 
                <div class="form-group row">
                  <div class="col-lg-12 text-center">
                    <input type="submit" id="socAddBtn" class="btn btn-primary" name=""  value="Update">
                  </div>
                </div>

              <?php }
            } 
          } ?> 
          </form>
        </div>
        <?php 
      }
    } //2nov2020?> 



 <div class="tab-pane  " id="superTab">
    <form id="editPrimaryNumberFrm" action="controller/commonController.php" method="post" enctype="multipart/form-data">
      <input type="hidden" id="primary_user_id" name="primary_user_id" value="<?php echo $user_id;?>">


       <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Mobile Number <span class="required">*</span></label>
          <div class="col-lg-9">
            <input required="" class="form-control onlyNumber"  name="primary_user_mobile"  maxlength="10"  type="text" value="<?php echo $user_mobile; ?>" id="primary_user_mobile">
         
            
          </div>
        </div>


      <div class="form-group row">
                  <div class="col-lg-12 text-center">
                    <input type="submit" id="editPrimaryNumberBtn" class="btn btn-primary " name=""  value="Update Primary Number">
                  </div>
                </div>

</form>
</div>



    <div class="tab-pane active" id="edit">
      <form id="memberBasicFrm" action="controller/userController.php" method="post" enctype="multipart/form-data">
       <div class="form-group row">
         <label class="col-lg-3 col-form-label form-control-label">Salutation  </label>
         <div class="col-lg-9">
          <select class="form-control" name="salutation" type="text" required="">
            <option value="">-- Select --</option>
            <option <?php if($salutation== "Mr.") { echo 'selected';} ?>  value="Mr.">Mr.</option>
            <option <?php if($salutation== "Mrs.") { echo 'selected';} ?>  value="Mrs.">Mrs.</option>
            <option <?php if($salutation== "Miss") { echo 'selected';} ?>  value="Miss">Miss</option>
            <option <?php if($salutation== "Ms") { echo 'selected';} ?>  value="Ms">Ms</option>
            <option <?php if($salutation== "Dr.") { echo 'selected';} ?>  value="Dr.">Dr.</option>
            <option <?php if($salutation== "Prof.") { echo 'selected';} ?>  value="Prof.">Prof.</option>
            <option <?php if($salutation== "Other") { echo 'selected';} ?>  value="Other">Other</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">First Name <span class="required">*</span></label>
        <div class="col-lg-9">
          <input type="hidden" name="user_fcm" value="<?php echo $user_token; ?>">
          <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
          <input type="hidden" name="basicInfo" value="<?php echo 'basicInfo'; ?>">
          <input class="form-control mem-alphanumeric" name="user_first_name" type="text" value="<?php echo $user_first_name ; ?>" required="">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Last Name <span class="required">*</span></label>
        <div class="col-lg-9">
          <input class="form-control mem-alphanumeric" name="user_last_name" type="text" value="<?php echo $user_last_name; ?>" required="">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Date Of Birth </label>
        <div class="col-lg-9">


          <input class="form-control" readonly="" id="autoclose-datepicker-dob" name="member_date_of_birth" type="text" value="<?php 
          if($member_date_of_birth !=""){
            $member_date_of_birth= str_replace("/", "-",$member_date_of_birth);
            echo date("Y-m-d", strtotime($member_date_of_birth));
            } else {
              $member_date_of_birth=date("Y-m-d");
            }
            
            ?>" >
          </div>
        </div>

        <div class="form-group row">
         <label class="col-lg-3 col-form-label form-control-label">Country Code <span class="required">*</span></label>
         <div class="col-lg-9">
           <select class="form-control single-select" name="country_code" type="text" required="">
                          <?php include '../common/country_code_option_list.php'; ?>
                        </select>
        </div>
      </div>

        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Mobile Number <span class="required">*</span></label>
          <div class="col-lg-9">
            <input required="" class="form-control" readonly="" name="user_mobile"  maxlength="10"  type="text" value="<?php echo $user_mobile; ?>" id="userMobile">
            <!-- <input required="" class="form-control" name="user_mobile" onblur="checkMobileUserEdit()" maxlength="10"  type="text" value="<?php echo $user_mobile; ?>" id="userMobile"> -->
            <input class="form-control" name="user_mobile_old" maxlength="10"  type="hidden" value="<?php echo $user_mobile; ?>"  id="userMobileOld">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Whatsapp No. </label>
          <div class="col-lg-9">
            <input class="form-control onlyNumber" maxlength="10" name="whatsapp_number"  maxlength="10"  type="text" value="<?php if($whatsapp_number!=0) {  echo $whatsapp_number; }?>" id="whatsapp_number">
            <!-- <input required="" class="form-control" name="user_mobile" onblur="checkMobileUserEdit()" maxlength="10"  type="text" value="<?php echo $user_mobile; ?>" id="userMobile"> -->
            <input class="form-control" name="user_mobile_old" maxlength="10"  type="hidden" value="<?php echo $user_mobile; ?>"  id="userMobileOld">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Alternate Mobile Number </label>
          <div class="col-lg-9">
            <input class="form-control" name="alt_mobile"  maxlength="10"  type="text" value="<?php if($alt_mobile!=0) { echo $alt_mobile; } ?>" id="alt_mobile">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Gender</label>
          <div class="col-lg-9">
            <div class="form-check-inline">
              <label class="form-check-label">
                <input type="radio" <?php if($gender=='Male'){echo "checked";} ?>  class="form-check-input" value="Male" name="gender"> Male
              </label>
            </div>
            <div class="form-check-inline">
              <label class="form-check-label">
                <input type="radio"  <?php if($gender=='Female'){echo "checked";} ?>  class="form-check-input" value="Female" name="gender"> Female
              </label>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Email </label>
          <div class="col-lg-9">
            <input class="form-control" type="email" name="user_email"  value="<?php echo $user_email; ?>" id="userEmail">

          </div>
        </div>



        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Change profile <?php   if($user_profile_pic =="" ) { ?> <span class="required">*</span> <?php } ?> </label>
          <div class="col-lg-9">
            <input accept="image/*" class="form-control-file border" id="imgInp" name="user_profile_pic" type="file">
            <input class="form-control" name="user_profile_pic_old" type="hidden" value="<?php echo $user_profile_pic; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Plan Expired Date </label>
          <div class="col-lg-9">
            <input class="form-control" readonly="" id="default-datepicker" name="plan_renewal_date" type="text" value="<?php echo $plan_renewal_date; ?>" >
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Facebook Url </label>
          <div class="col-lg-9">
            <input class="form-control" name="facebook"  maxlength="260"  type="text" value="<?php echo $facebook; ?>" id="facebook">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Instagram Url </label>
          <div class="col-lg-9">
            <input  class="form-control" name="instagram"  maxlength="260"  type="text" value="<?php echo $instagram; ?>" id="instagram">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Linkedin Url </label>
          <div class="col-lg-9">
            <input  class="form-control" name="linkedin"  maxlength="260"  type="text" value="<?php echo $linkedin; ?>" id="linkedin">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Twitter Url </label>
          <div class="col-lg-9">
            <input  class="form-control" name="twitter"  maxlength="260"  type="text" value="<?php echo $twitter; ?>" id="twitter">
          </div>
        </div>


        <input type="hidden" id="user_id_edit" value="<?php echo $user_id;?>">                        
        <input type="hidden" name="isedit" id="isedit" value="yes">

        <?php if( $user_social_media_name !=''){ ?>
          <input  id="user_social_media_name_valid" type="hidden"   value="1"   >
        <?php } else { ?> 
          <input  id="user_social_media_name_valid" type="hidden"   value="0"   >
        <?php } ?> 


        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Social Media Name</label>
          <div class="col-lg-8">
            <input     class="alphanumeric text-lowercase form-control"  class="form-control" name="user_social_media_name"  maxlength="260"  type="text" value="<?php echo $user_social_media_name; ?>" id="user_social_media_name">
          </div> <div class="col-lg-1" id="loader_cpn"></div>
        </div>


        <div class="form-group row">
          <div class="col-lg-12 text-center">
            <input type="submit" id="socAddBtn" class="btn btn-primary" name=""  value="Update">
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
            <label class="col-lg-3 col-form-label form-control-label">Business Category <span class="required">*</span></label>
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
          <div class="form-group row" id="ProfessionalOther" style="<?php if($proData['business_categories']!= "Other") { echo 'display: none';} ?>">
            <label class="col-lg-3 col-form-label form-control-label">Other Category </label>
            <div class="col-lg-9">
              <input value="<?php echo $proData['business_categories_other']; ?>" class="form-control text-capitalize" name="business_categories_other" minlength="1"  maxlength="80"  type="text" value="<?php echo $business_categories_other; ?>" id="professional_other">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Business Sub Category <span class="required">*</span></label>
            <div class="col-lg-9">
              <select id="business_categories_sub" onchange="otherCheck();" class="form-control single-select" name="business_sub_category_id" type="text"  required="">
                <option value="">-- Select --</option>
                <?php if($proData>0) { 
                  $q3=$d->select("business_sub_categories","business_category_id='$proData[business_category_id]' and sub_category_status in (0,2)","");
                  while ($blockRow=mysqli_fetch_array($q3)) {
                    ?>
                    <option <?php if($blockRow['business_sub_category_id']== $proData['business_sub_category_id']) { echo 'selected';} ?> value="<?php echo $blockRow['business_sub_category_id'];?>"><?php echo $blockRow['sub_category_name'];?></option>
                  <?php } } ?>
                </select>
              </div>
            </div>
            <div class="form-group row" id="ProfessionalTypeOther" style="<?php if($proData['business_categories_sub']!= "Other") { echo 'display: none';} ?>" >
              <label class="col-lg-3 col-form-label form-control-label">Other Professional</label>
              <div class="col-lg-9">
                <input value="<?php echo $proData['professional_other']; ?>" class="form-control text-capitalize" name="professional_other"  maxlength="100"  type="text" value="<?php echo $professional_other; ?>" id="professional_other">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Business Name <span class="required">*</span></label>
              <div class="col-lg-9">
                <input value="<?php echo $proData['company_name']; ?>" class="form-control" name="company_name"  maxlength="80"  minlength="3"  type="text" value="<?php echo $company_name; ?>" id="company_name">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Business Contact Number </label>
              <div class="col-lg-9">
                <input   class="form-control" name="company_contact_number" minlength="0" maxlength="12"  type="text" value="<?php if($company_contact_number!=0) echo $company_contact_number; ?>" id="company_contact_number">
                <!-- <input required="" class="form-control" name="user_mobile" onblur="checkMobileUserEdit()" maxlength="10"  type="text" value="<?php echo $user_mobile; ?>" id="userMobile"> -->
              </div>
            </div>

            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Business Landline Number </label>
              <div class="col-lg-9">
                <input   class="form-control onlyNumber" name="company_landline_number" minlength="0" maxlength="15"  type="text" value="<?php if($company_landline_number!='') echo $company_landline_number; ?>" id="company_landline_number">
                <!-- <input required="" class="form-control" name="user_mobile" onblur="checkMobileUserEdit()" maxlength="10"  type="text" value="<?php echo $user_mobile; ?>" id="userMobile"> -->
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Business Email </label>
              <div class="col-lg-9">
                <input    class="form-control" name="company_email" minlength="3"  maxlength="150"  type="text" value="<?php echo $company_email; ?>" id="company_email">
                <!-- <input required="" class="form-control" name="user_mobile" onblur="checkMobileUserEdit()" maxlength="10"  type="text" value="<?php echo $user_mobile; ?>" id="userMobile"> -->
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Designation <span class="required">*</span></label>
              <div class="col-lg-9">
                <input maxlength="80"  minlength="3"   value="<?php echo $proData['designation']; ?>"  class="form-control" type="text" name="designation"    value="<?php echo $designation; ?>" id="designation">
              </div>
            </div>


            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Website </label>
              <div class="col-lg-9">
                <?php
                $url_prefix = "http://";

                if( strpos( $proData['company_website'], "https://" ) !== false || strpos( $proData['company_website'], "http://" ) !== false || trim($proData['company_website'])=="") {
                  $url_prefix = "";
                } ?>
                <input  class="form-control" id="company_website" name="company_website"  maxlength="120" minlength="3" value="<?php echo $url_prefix.$proData['company_website']; ?>" type="url">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">About Business</label>
            <div class="col-lg-9">
              <textarea maxlength="300" class="form-control" name="business_description"  type="text" value=""><?php echo $proData['business_description']; ?></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Search Keywords</label>
            <div class="col-lg-9">
              <textarea maxlength="300" class="form-control" name="search_keyword"  type="text" value=""><?php echo $proData['search_keyword']; ?></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Products/Services</label>
            <div class="col-lg-9">
              <textarea maxlength="300" class="form-control" name="products_servicess"  type="text" value=""><?php echo $proData['products_servicess']; ?></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Business Logo</label>
            <div class="col-lg-6">
              <input accept="image/*" class="form-control-file border photoOnly" id="company_logo" name="company_logo" type="file">
              <input class="form-control" name="company_logo_old" type="hidden" value="<?php echo $company_logo; ?>">
            </div>
            <div class="col-lg-3">
              <?php if ($company_logo!='') { ?>
                <img width="50" height="50" src="../img/users/company_logo/<?php echo $company_logo;?>">
              <?php } ?>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Business Brochure </label>
            <div class="col-lg-6">
              <input  class="form-control-file border docOnly1" id="company_broucher" name="company_broucher" type="file">
              <input class="form-control" name="company_broucher_old" type="hidden" value="<?php echo $company_broucher; ?>">
            </div>
            <div class="col-lg-3">
              <?php if ($company_broucher!='') { ?>
                <a class="btn btn-sm btn-danger" target="_blank" href="../img/users/company_broucher/<?php echo $company_broucher;?>">View Broucher</a>
              <?php } ?>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Business Profile </label>
            <div class="col-lg-6">
              <input accept="image/*" class="form-control-file border docOnly1" id="company_profile" name="company_profile" type="file">
              <input class="form-control" name="company_profile_old" type="hidden" value="<?php echo $company_profile; ?>">
            </div>
            <div class="col-lg-3">
              <?php if ($company_profile!='') { ?>
                <a class="btn btn-sm btn-danger" target="_blank" href="../img/users/comapany_profile/<?php echo $company_profile;?>">View Profile</a>
              <?php } ?>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-lg-12 text-center">
              <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
              <input type="hidden" name="updateProfessional" value="updateProfessional">
              <input type="submit" id="socAddBtn" class="btn btn-primary" name=""  value="Update">
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
<div class="modal fade" id="replyModal">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Renew Plan</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="renewPlanFrm" action="controller/userController.php" method="post">
          <input type="hidden" id="user_id" name="user_id" value="<?php echo $id; ?>">
          <input type="hidden" id="user_mobile" name="user_mobile" value="<?php echo $user_mobile; ?>">
          <input type="hidden" id="user_first_name" name="user_first_name" value="<?php echo $user_first_name; ?>">
          <input type="hidden" id="user_last_name" name="user_last_name" value="<?php echo $user_last_name; ?>">
          <input type="hidden" id="user_email" name="user_email" value="<?php echo $user_email; ?>">
          <input type="hidden" id="plan_renewal_date_old" name="plan_renewal_date_old" value="<?php echo $plan_renewal_date; ?>">
          <input type="hidden" id="renewPlan" name="renewPlan">
          
          <div class="form-group row">
            <label class="col-lg-6 col-form-label form-control-label">Current Plan Expire On</label>
            <div class="col-lg-6">
              <?php echo date("d M Y", strtotime($plan_renewal_date)); ?>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Membership Plan</label>
            <div class="col-lg-9">
             <select id="plan_id" required=""  class="form-control single-select" name="plan_id" type="text" >
              <option value="">-- Select --</option>
              <?php $qb=$d->select("package_master","","");
              while ($bData=mysqli_fetch_array($qb)) {?>
                <option  value="<?php echo $bData['package_id']; ?>"><?php echo $bData['package_name']; ?>-<?php echo $bData['no_of_month']; ?>  <?php if($bData['time_slab'] == 1) echo "Days"; else echo "Month"; ?> (₹ <?php echo $bData['package_amount']; ?> )</option>
              <?php } ?> 
            </select>
            <!-- <input class="form-control" readonly="" id="default-datepicker" name="plan_renewal_date" type="text" value="<?php echo $plan_renewal_date; ?>" > -->
          </div>
        </div>


        <div class="form-footer text-center">
          <button type="submit" name="" value="" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Renew</button>
        </div>

      </form>
    </div>

  </div>
</div>
</div><!--End Modal -->
