<?php 
include '../common/objectController.php'; 
// print_r($_POST);
if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{
  /*echo "<pre>";print_r($_POST);exit;*/
// add main menu
 // echo "<pre>";print_r($_POST);exit;
   if(isset($_POST['checkUserMobile'])){
    $q=$d->select("users_master","user_mobile='$userMobile'");
    $data=mysqli_fetch_array($q);
    if ($data>0) {
       echo 1;
       exit();
    } else {
      echo 0;
      exit();
    }

  }
  
  if(isset($_POST['updateProfessional'])){

      $extension=array("jpeg","jpg","png","gif","JPG","jpeg","JPEG","PNG");
      $uploadedFile = $_FILES['company_logo']['tmp_name'];
      $ext = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);
      
      if(file_exists($uploadedFile)) {
        
        if(in_array($ext,$extension)) {

          //9dec2020
          $maxsize = 3000000;
           if (($_FILES['company_logo']['size'] >= $maxsize) || ($_FILES["company_logo"]["size"] == 0)) {
               echo "Document too large. Must be less than or equal to 3 MB.";
                exit();
              }
          //9dec2020 


            $sourceProperties = getimagesize($uploadedFile);
          $newFileName = rand().$user_id;
          $dirPath = "../../img/users/company_logo/";
          $imageType = $sourceProperties[2];
          $imageHeight = $sourceProperties[1];
          $imageWidth = $sourceProperties[0];
          
          //9dec2020
           move_uploaded_file($_FILES["company_logo"]["tmp_name"], "../../img/users/company_logo/".$newFileName. "_logo.". $ext);
           
           /*if ($imageWidth>800) {
            $newWidthPercentage= 800*100 / $imageWidth;  //for maximum 400 widht
            $newImageWidth = $imageWidth * $newWidthPercentage /100;
            $newImageHeight = $imageHeight * $newWidthPercentage /100;
          } else {
            $newImageWidth = $imageWidth;
            $newImageHeight = $imageHeight;
          }*/

          /*switch ($imageType) {

            case IMAGETYPE_PNG:
                $imageSrc = imagecreatefrompng($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagepng($tmp,$dirPath. $newFileName. "_logo.". $ext);
                break;           

            case IMAGETYPE_JPEG:
                $imageSrc = imagecreatefromjpeg($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagejpeg($tmp,$dirPath. $newFileName. "_logo.". $ext);
                break;
            
            case IMAGETYPE_GIF:
                $imageSrc = imagecreatefromgif($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagegif($tmp,$dirPath. $newFileName. "_logo.". $ext);
                break;

            default:
               $_SESSION['msg1']="Invalid Logo";
                header("Location: ../viewMember?id=$user_id");
                exit;
                break;
            }*/
            $company_logo= $newFileName."_logo.".$ext;

          } else{
            $_SESSION['msg1']="Invalid Business Logo";
            header("location:../viewMember?id=$user_id");
            exit();
          }
        } else {

          $company_logo=$company_logo_old;
        }


         $file = $_FILES['company_broucher']['tmp_name'];
        if(file_exists($file)) {
          $extensionResume=array("pdf","doc","docx","png","jpg","jpeg","PNG","JPG","JPEG");
          $extId = pathinfo($_FILES['company_broucher']['name'], PATHINFO_EXTENSION);

           $errors     = array();
            $maxsize    = 10097152;
            
            if(($_FILES['company_broucher']['size'] >= $maxsize) || ($_FILES["company_broucher"]["size"] == 0)) {
                $_SESSION['msg1']="Company Broucher too large. Must be less than 10 MB.";
                header("location:../viewMember?id=$user_id");
                exit();
            }
            if(!in_array($extId, $extensionResume) && (!empty($_FILES["company_broucher"]["type"]))) {
                 $_SESSION['msg1']="Invalid Company Broucher File format, Only  JPG,PDF, PNG,Doc are allowed.";
                header("location:../viewMember?id=$user_id");
                exit();
            }
           if(count($errors) === 0) {
            $image_Arr = $_FILES['company_broucher'];   
            $temp = explode(".", $_FILES["company_broucher"]["name"]);
            $company_broucher = $emp_mobile.'_id_'.round(microtime(true)) . '.' . end($temp);
            move_uploaded_file($_FILES["company_broucher"]["tmp_name"], "../../img/users/company_broucher/".$company_broucher);
          } 
        } else{
          $company_broucher=$company_broucher_old;
        }

        $file11 = $_FILES['company_profile']['tmp_name'];
        if(file_exists($file11)) {
          $extensionResume=array("pdf","doc","docx","png","jpg","jpeg","PNG","JPG","JPEG");
          $extId = pathinfo($_FILES['company_profile']['name'], PATHINFO_EXTENSION);

           $errors     = array();
            $maxsize    = 10097152;
            
            if(($_FILES['company_profile']['size'] >= $maxsize) || ($_FILES["company_profile"]["size"] == 0)) {
                $_SESSION['msg1']="Company Profile too large. Must be less than 10 MB.";
                header("location:../viewMember?id=$user_id");
                exit();
            }
            if(!in_array($extId, $extensionResume) && (!empty($_FILES["company_profile"]["type"]))) {
                 $_SESSION['msg1']="Invalid Company Profile File format, Only  JPG,PDF, PNG,Doc are allowed.";
                header("location:../viewMember?id=$user_id");
                exit();
            }
           if(count($errors) === 0) {
            $image_Arr = $_FILES['company_profile'];   
            $temp = explode(".", $_FILES["company_profile"]["name"]);
            $company_profile =  'profile_'.round(microtime(true)) . '.' . end($temp);
            move_uploaded_file($_FILES["company_profile"]["tmp_name"], "../../img/users/comapany_profile/".$company_profile);
          } 
        } else{
          $company_profile=$company_profile_old;
        }
       
    $m->set_data('business_sub_category_id',$business_sub_category_id);
    $m->set_data('business_category_id',$business_category_id);
    $m->set_data('company_name',$company_name);
    $m->set_data('company_contact_number',$company_contact_number);
    $m->set_data('company_landline_number',$company_landline_number);
    $m->set_data('company_email',$company_email);
    $m->set_data('designation',$designation);
    $m->set_data('company_website',$company_website);
    $m->set_data('business_description',$business_description);
    $m->set_data('search_keyword',$search_keyword);
    $m->set_data('products_servicess',$products_servicess);
    $m->set_data('company_logo',$company_logo);
    $m->set_data('company_broucher',$company_broucher);
    $m->set_data('company_profile',$company_profile);


   
    $a =array(
      'business_category_id'=> $m->get_data('business_category_id'),
      'business_sub_category_id'=> $m->get_data('business_sub_category_id'),
      'company_name'=> $m->get_data('company_name'),
      'company_contact_number'=> $m->get_data('company_contact_number'),
      'company_landline_number'=> $m->get_data('company_landline_number'),
      'company_email'=> $m->get_data('company_email'),
      'designation'=> $m->get_data('designation'),
      'company_website'=> $m->get_data('company_website'),
      'business_description'=> $m->get_data('business_description'),
      'search_keyword'=> $m->get_data('search_keyword'),
      'products_servicess'=> $m->get_data('products_servicess'),
      'company_logo'=> $m->get_data('company_logo'),
      'company_broucher'=> $m->get_data('company_broucher'),
      'company_profile'=> $m->get_data('company_profile'),
   
    
    );

    $q=$d->update("user_employment_details",$a,"user_id='$user_id'");
    if($q>0) {
      $adm_data=$d->selectRow("user_full_name","users_master"," user_id='$user_id'");
        $data_q=mysqli_fetch_array($adm_data);
      $_SESSION['msg']=$data_q['user_full_name']."'s User Employment Data Updated";

        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../viewMember?id=$user_id");
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../viewMember?id=$user_id");
    }
  }

   if(isset($_POST['billingUpdate'])){
// echo "<pre>";print_r($_POST);exit;


    $m->set_data('company_name',$company_name);
    $m->set_data('company_contact_number',$company_contact_number);
    $m->set_data('billing_address',$billing_address);
    $m->set_data('gst_number',strtoupper($gst_number));
    $m->set_data('billing_pincode',$billing_pincode);
    $m->set_data('bank_name',$bank_name);
    $m->set_data('bank_account_number',$bank_account_number);
    $m->set_data('ifsc_code',$ifsc_code);
    $m->set_data('billing_contact_person',$billing_contact_person);
    $m->set_data('billing_contact_person_name',$billing_contact_person_name);


   
    $a =array(
      'company_name'=> $m->get_data('company_name'),
      'company_contact_number'=> $m->get_data('company_contact_number'),
      'billing_address'=> $m->get_data('billing_address'),
      'gst_number'=> $m->get_data('gst_number'),
      'billing_pincode'=> $m->get_data('billing_pincode'),
      'bank_name'=> $m->get_data('bank_name'),
      'bank_account_number'=> $m->get_data('bank_account_number'),
      'ifsc_code'=> $m->get_data('ifsc_code'),
      'billing_contact_person'=> $m->get_data('billing_contact_person'),
      'billing_contact_person_name'=> $m->get_data('billing_contact_person_name'),
   
    
    );

    $q=$d->update("user_employment_details",$a,"user_id='$user_id'");


if(isset($plan_renewal_date) && $plan_renewal_date !=""){

  $users_master=$d->select("users_master","user_id ='$user_id'  ","");
  $users_master_data=mysqli_fetch_array($users_master);

  $plan_renewal_date = date("Y-m-d", strtotime($plan_renewal_date));
  $plan_renewal_date_old = date("Y-m-d", strtotime($users_master_data['plan_renewal_date']));

   $m->set_data('plan_renewal_date',$plan_renewal_date);
   $m->set_data('plan_renewal_date_old',$plan_renewal_date_old);

   $user_array =array(
      'plan_renewal_date'=> $m->get_data('plan_renewal_date'),
      'plan_renewal_date_old'=> $m->get_data('plan_renewal_date_old') 
    );

    $q=$d->update("users_master",$user_array," user_id='$user_id'");
}
    


    if($q>0) {
     $adm_data=$d->selectRow("user_full_name","users_master"," user_id='$user_id'");
        $data_q=mysqli_fetch_array($adm_data);
      $_SESSION['msg']=$data_q['user_full_name']."'s Billing Data Updated";
       $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../viewMember?id=$user_id");
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../viewMember?id=$user_id");
    }

  }

//2nov2020
    if(isset($_POST['refer_user_id'])){
 $m->set_data('refer_by',$refer_by);
  
  if(isset($refere_by_name) && trim($refere_by_name)!=''){
    $m->set_data('refere_by_name',$refere_by_name);
  } else{
    $m->set_data('refere_by_name','');
  }
 
  if(isset($refere_by_phone_number) && trim($refere_by_phone_number)!=''){
     $m->set_data('refere_by_phone_number',$refere_by_phone_number);
  }else{
    $m->set_data('refere_by_phone_number','');
  }
  
  if(isset($remark) && trim($remark)!=''){
    $m->set_data('remark',$remark);
  } else {
    $m->set_data('remark','');
  }

    $a =array(
      'refer_by' => $m->get_data('refer_by'),
      'refere_by_name' => $m->get_data('refere_by_name'),
      'refere_by_phone_number' => $m->get_data('refere_by_phone_number'),
      'remark' => $m->get_data('remark')
    );
  

       $q=$d->update("users_master",$a,"user_id='$refer_user_id'");
    if($q>0) {
      $adm_data=$d->selectRow("user_full_name","users_master"," user_id='$refer_user_id'");
        $data_q=mysqli_fetch_array($adm_data);

      $_SESSION['msg']=$data_q['user_full_name']."'s Refer By Data Updated";
       $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../viewMember?id=$refer_user_id");
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../viewMember?id=$refer_user_id");
    }
    }
//2nov2020

   if(isset($_POST['basicInfo'])){

     $extension=array("jpeg","jpg","png","gif","JPG","jpeg","JPEG","PNG");
      $uploadedFile = $_FILES['user_profile_pic']['tmp_name'];
      $ext = pathinfo($_FILES['user_profile_pic']['name'], PATHINFO_EXTENSION);
      
      if(file_exists($uploadedFile)) {
        if(in_array($ext,$extension)) {
            $sourceProperties = getimagesize($uploadedFile);
          $newFileName = rand().$user_id;
          $dirPath = "../../img/users/members_profile/";
          $imageType = $sourceProperties[2];
          $imageHeight = $sourceProperties[1];
          $imageWidth = $sourceProperties[0];
          
          // less 30 % size 
          if ($imageWidth>800) {
            $newWidthPercentage= 800*100 / $imageWidth;  //for maximum 400 widht
            $newImageWidth = $imageWidth * $newWidthPercentage /100;
            $newImageHeight = $imageHeight * $newWidthPercentage /100;
          } else {
            $newImageWidth = $imageWidth;
            $newImageHeight = $imageHeight;
          }

          switch ($imageType) {

            case IMAGETYPE_PNG:
                $imageSrc = imagecreatefrompng($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagepng($tmp,$dirPath. $newFileName. "_profile.". $ext);
                break;           

            case IMAGETYPE_JPEG:
                $imageSrc = imagecreatefromjpeg($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagejpeg($tmp,$dirPath. $newFileName. "_profile.". $ext);
                break;
            
            case IMAGETYPE_GIF:
                $imageSrc = imagecreatefromgif($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagegif($tmp,$dirPath. $newFileName. "_profile.". $ext);
                break;

            default:
               $_SESSION['msg1']="Invalid Profile Photo";
                header("Location: ../viewMember?id=$user_id");
                exit;
                break;
            }
            $user_profile_pic= $newFileName."_profile.".$ext;

          } else{
            $_SESSION['msg1']="Invalid Profile Photo";
            header("location:../viewMember?id=$user_id");
            exit();
          }
        } else {
          $user_profile_pic=$user_profile_pic_old;
        }

    $m->set_data('salutation',ucfirst($salutation));
    $m->set_data('user_first_name',ucfirst($user_first_name));
    $m->set_data('user_last_name',ucfirst($user_last_name));
    $m->set_data('user_full_name',ucfirst($user_first_name).' '.ucfirst($user_last_name));
    $m->set_data('member_date_of_birth',$member_date_of_birth);
    $m->set_data('whatsapp_number',$whatsapp_number);
    $m->set_data('user_email',$user_email);
    $m->set_data('alt_mobile',$alt_mobile);
    
    $m->set_data('gender',$gender);

 
    $m->set_data('user_email',$user_email);
    $m->set_data('user_profile_pic',$user_profile_pic);
    $m->set_data('plan_renewal_date',$plan_renewal_date);
    $m->set_data('facebook',$facebook);
    $m->set_data('instagram',$instagram);
    $m->set_data('linkedin',$linkedin);
    $m->set_data('twitter',$twitter);
    $m->set_data('user_social_media_name',$user_social_media_name);
   
   
   
    $a =array(
      'salutation'=> $m->get_data('salutation'),
      'user_first_name'=> $m->get_data('user_first_name'),
      'user_last_name'=> $m->get_data('user_last_name'),
      'user_full_name'=> $m->get_data('user_full_name'),
      'member_date_of_birth'=> $m->get_data('member_date_of_birth'),
      'whatsapp_number'=> $m->get_data('whatsapp_number'),
      'user_email'=> $m->get_data('user_email'),
      'alt_mobile'=> $m->get_data('alt_mobile'),
      'gender'=> $m->get_data('gender'), 
      'user_email'=> $m->get_data('user_email'),
      'user_profile_pic'=> $m->get_data('user_profile_pic'),
      'plan_renewal_date'=> $m->get_data('plan_renewal_date'),
      'facebook'=> $m->get_data('facebook'),
      'instagram'=> $m->get_data('instagram'),
      'linkedin'=> $m->get_data('linkedin'),
      'twitter'=> $m->get_data('twitter'),
      'user_social_media_name'=> $m->get_data('user_social_media_name'),
    
    );




    $q=$d->update("users_master",$a,"user_id='$user_id'");
    if($q>0) {
      $adm_data=$d->selectRow("user_full_name","users_master"," user_id='$user_id'");
        $data_q=mysqli_fetch_array($adm_data);
      $_SESSION['msg']=$data_q['user_full_name']."'s User Basic Data Updated";
       $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../viewMember?id=$user_id");
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../viewMember?id=$user_id");
    }

  }

   if(isset($_POST['removeAddress'])){
/*AND adress_id!='$user_id'*/
     echo $totalAddress=  $d->count_data_direct("adress_id","business_adress_master","user_id='$user_id' AND adress_type=0 ");
     
         if ($totalAddress<1) {
              $response["message"] = "";
              $_SESSION['msg1']="Need at least 1 primary address";
               header("location:../viewMember?id=$user_id");
              exit();
         }
                    

    $q=$d->delete("business_adress_master","user_id='$user_id' AND adress_id='$adress_id'");
    if($q>0) {
      $adm_data=$d->selectRow("user_full_name","users_master"," user_id='$user_id'");
        $data_q=mysqli_fetch_array($adm_data);


      $_SESSION['msg']=$data_q['user_full_name']."'s User Address Deleted";
       $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../viewMember?id=$user_id");
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../viewMember?id=$user_id");
    }

  }

  if($_POST['addAddress'] == "addAddress" && filter_var($user_id, FILTER_VALIDATE_INT) == true ){

       $m->set_data('user_id', $user_id);
        $m->set_data('adress', $adress);
        $m->set_data('area_id', $area_id);
        $m->set_data('city_id', $city_id);
        $m->set_data('state_id', $state_id);
        $m->set_data('country_id', $country_id);
        $m->set_data('pincode', $pincode);
        $m->set_data('latitude', $latitude);
        $m->set_data('longitude', $longitude);
        $m->set_data('adress_type', $adress_type);
      

        $a = array(
            'user_id' => $m->get_data('user_id'), 
            'adress' => $m->get_data('adress'),
            'area_id' => $m->get_data('area_id'),
            'city_id' => $m->get_data('city_id'),
            'state_id' => $m->get_data('state_id'),
            'country_id' => $m->get_data('country_id'),
            'pincode' => $m->get_data('pincode'),
            'add_latitude' => $m->get_data('latitude'),
            'add_longitude' => $m->get_data('longitude'),
            'adress_type' => $m->get_data('adress_type')
        );

        if ($adress_id==0) {
            if ($adress_type==0) {
                 $a11 = array(
                    'adress_type' => 1
                );
                $d->update("business_adress_master",$a11,"user_id='$user_id'");
            }else if ($adress_type==1) {
               $totalAddress=  $d->count_data_direct("adress_id","business_adress_master","user_id='$user_id' AND adress_type=0 ");
               if ($totalAddress<1) {
                    $_SESSION['msg']="Need at least 1st primary address";
                    header("location:../viewMember?id=$user_id");
                    exit();
               }

            }

           $d->insert("business_adress_master",$a,"");
           $_SESSION['msg']="Add Sucessfully !";
        }else{
            if ($adress_type==0) {
                 $a11 = array(
                    'adress_type' => 1
                );
                $d->update("business_adress_master",$a11,"user_id='$user_id' AND adress_id!='$adress_id'");
            } else if ($adress_type==1) {
               $totalAddress=  $d->count_data_direct("adress_id","business_adress_master","user_id='$user_id' AND adress_type=0 AND adress_id!='$adress_id'");
               if ($totalAddress<1) {
                  
                    $_SESSION['msg']="Need at least 1st primary address";
                    header("location:../viewMember?id=$user_id");
                    exit();
               }

            }

          $d->update("business_adress_master",$a,"adress_id='$adress_id'");
         
        }

       if ($d==true) {
        $adm_data=$d->selectRow("user_full_name","users_master"," user_id='$user_id'");
        $data_q=mysqli_fetch_array($adm_data);

 $_SESSION['msg']=$data_q['user_full_name']."'s User Business Address Update Sucessfully !";
               $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
                    header("location:../viewMember?id=$user_id");
                    exit();

        }else{
              $_SESSION['msg1']="Update Not Done !";
                header("location:../viewMember?id=$user_id");
                exit();
        }




  } 



   if(isset($_POST['addNewMember'])){
     $con -> autocommit(FALSE);


    $q=$d->select("users_master","user_mobile='$user_mobile'");
    $data=mysqli_fetch_array($q);
    if ($data>0) {
         $_SESSION['msg1']="Mobile number alerady register";
            header("location:../member");
       exit();
    } 

     $extension=array("jpeg","jpg","png","gif","JPG","jpeg","JPEG","PNG");
      $uploadedFile = $_FILES['user_profile_pic']['tmp_name'];
      $ext = pathinfo($_FILES['user_profile_pic']['name'], PATHINFO_EXTENSION);
      
      if(file_exists($uploadedFile)) {
        if(in_array($ext,$extension)) {
            $sourceProperties = getimagesize($uploadedFile);
          $newFileName = rand().$user_id;
          $dirPath = "../../img/users/members_profile/";
          $imageType = $sourceProperties[2];
          $imageHeight = $sourceProperties[1];
          $imageWidth = $sourceProperties[0];
          
           if ($imageWidth>800) {
            $newWidthPercentage= 800*100 / $imageWidth;  //for maximum 400 widht
            $newImageWidth = $imageWidth * $newWidthPercentage /100;
            $newImageHeight = $imageHeight * $newWidthPercentage /100;
          } else {
            $newImageWidth = $imageWidth;
            $newImageHeight = $imageHeight;
          }

          switch ($imageType) {

            case IMAGETYPE_PNG:
                $imageSrc = imagecreatefrompng($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagepng($tmp,$dirPath. $newFileName. "_profile.". $ext);
                break;           

            case IMAGETYPE_JPEG:
                $imageSrc = imagecreatefromjpeg($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagejpeg($tmp,$dirPath. $newFileName. "_profile.". $ext);
                break;
            
            case IMAGETYPE_GIF:
                $imageSrc = imagecreatefromgif($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagegif($tmp,$dirPath. $newFileName. "_profile.". $ext);
                break;

            default:
               $_SESSION['msg1']="Invalid Profile Photo";
                header("Location: ../viewMember?id=$user_id");
                exit;
                break;
            }
            $user_profile_pic= $newFileName."_profile.".$ext;

          } else{
            $_SESSION['msg1']="Invalid Profile Photo";
            header("location:../viewMember?id=$user_id");
            exit();
          }
        } else {
          $user_profile_pic=$user_profile_pic_old;
        }


      $extension=array("jpeg","jpg","png","gif","JPG","jpeg","JPEG","PNG");
      $uploadedFile = $_FILES['company_logo']['tmp_name'];
      $ext = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);
      
      if(file_exists($uploadedFile)) {
        if(in_array($ext,$extension)) {
            $sourceProperties = getimagesize($uploadedFile);
          $newFileName = rand().$user_id;
          $dirPath = "../../img/users/company_logo/";
          $imageType = $sourceProperties[2];
          $imageHeight = $sourceProperties[1];
          $imageWidth = $sourceProperties[0];
          
           if ($imageWidth>800) {
            $newWidthPercentage= 800*100 / $imageWidth;  //for maximum 400 widht
            $newImageWidth = $imageWidth * $newWidthPercentage /100;
            $newImageHeight = $imageHeight * $newWidthPercentage /100;
          } else {
            $newImageWidth = $imageWidth;
            $newImageHeight = $imageHeight;
          }

          switch ($imageType) {

            case IMAGETYPE_PNG:
                $imageSrc = imagecreatefrompng($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagepng($tmp,$dirPath. $newFileName. "_logo.". $ext);
                break;           

            case IMAGETYPE_JPEG:
                $imageSrc = imagecreatefromjpeg($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagejpeg($tmp,$dirPath. $newFileName. "_logo.". $ext);
                break;
            
            case IMAGETYPE_GIF:
                $imageSrc = imagecreatefromgif($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagegif($tmp,$dirPath. $newFileName. "_logo.". $ext);
                break;

            default:
               $_SESSION['msg1']="Invalid Logo";
                header("Location: ../viewMember?id=$user_id");
                exit;
                break;
            }
            $company_logo= $newFileName."_logo.".$ext;

          } else{
            $_SESSION['msg1']="Invalid Company Logo";
            header("location:../viewMember?id=$user_id");
            exit();
          }
        } else {
          $company_logo=$company_logo_old;
        }

    $q=$d->select("package_master","package_id='$plan_id'","");
    $row1=mysqli_fetch_array($q);
    $package_name= $row1['package_name'];
    $no_month=$row1['no_of_month'];
    $package_amount=$row1['package_amount'];

    //9oct2020
     if($row1['gst_slab_id'] !="0"){
      $gst_slab_id = $row1['gst_slab_id'];
           $gst_master=$d->select("gst_master","slab_id = '$gst_slab_id'","");
           $gst_master_data=mysqli_fetch_array($gst_master);
           $gst_amount= (($row1["package_amount"]*$gst_master_data['slab_percentage']) /100);
    } else {
            $gst_amount= 0 ;
    }
     $package_amount=number_format($row1["package_amount"]+$gst_amount,2,'.','');
      //9oct2020


     //NEW
     if($row1["time_slab"] == 1){
       $plan_renewal_date=date('Y-m-d', strtotime(' +'.$no_month.' days'));
     } else {
       $plan_renewal_date=date('Y-m-d', strtotime(' +'.$no_month.' months'));
     }
     //NEW

   

    $last_auto_id=$d->last_auto_id("users_master");
    $res=mysqli_fetch_array($last_auto_id);
    $user_id=$res['Auto_increment'];
    $zoobiz_id="ZB2020".$user_id;

    $m->set_data('zoobiz_id',ucfirst($zoobiz_id));
    $m->set_data('salutation',ucfirst($salutation));
    $m->set_data('user_first_name',ucfirst($user_first_name));
    $m->set_data('user_last_name',ucfirst($user_last_name));
    $m->set_data('user_full_name',ucfirst($user_first_name).' '.ucfirst($user_last_name));
    $m->set_data('member_date_of_birth',$member_date_of_birth);
    $m->set_data('whatsapp_number',$whatsapp_number);
    $m->set_data('user_mobile',$user_mobile);
    $m->set_data('user_email',$user_email);
    $m->set_data('gender',$gender);
    $m->set_data('email_privacy',$email_privacy);
    $m->set_data('invoice_download',$invoice_download);

    $m->set_data('user_email',$user_email);
    $m->set_data('user_profile_pic',$user_profile_pic);
    $m->set_data('plan_renewal_date',$plan_renewal_date);
    $m->set_data('plan_id',$plan_id);

    $m->set_data('company_name',$company_name);
    $m->set_data('company_contact_number',$company_contact_number);
    $m->set_data('business_category_id',$business_category_id);
    $m->set_data('business_sub_category_id',$business_sub_category_id);
    $m->set_data('designation',$designation);
    $m->set_data('company_website',$company_website);
    $m->set_data('company_logo',$company_logo);

    $m->set_data('adress', $adress);
    $m->set_data('area_id', $area_id);
    $m->set_data('city_id', $city_id);
    $m->set_data('state_id', $state_id);
    $m->set_data('country_id', $country_id);
    $m->set_data('pincode', $pincode);
    $m->set_data('latitude', $latitude);
    $m->set_data('longitude', $longitude);
    $m->set_data('adress_type', $adress_type);
    $m->set_data('register_date', date("Y-m-d H:i:s"));
   
   $company_master_qry=$d->select("company_master","city_id ='$city_id' ","");
    if (mysqli_num_rows($company_master_qry) > 0 ) {
        $company_master_data=mysqli_fetch_array($company_master_qry);
         $company_id = $company_master_data['company_id'];
         $company_name_user =$company_master_data['company_name'];
       } else {
         $company_id = 1;
         $company_name_user ="Zoobiz India Pvt. Ltd.";
       }
       $m->set_data('company_id',$company_id);

//7oct2020
 
 //18jan2021
$m->set_data('office_member',$office_member);
 //18jan2021
  $m->set_data('refer_by',$refer_by);
  
  if(isset($refere_by_name) && trim($refere_by_name)!=''){
    $m->set_data('refere_by_name',$refere_by_name);
  } else{
    $m->set_data('refere_by_name','');
  }
 
  if(isset($refere_by_phone_number) && trim($refere_by_phone_number)!=''){
     $m->set_data('refere_by_phone_number',$refere_by_phone_number);
  }else{
    $m->set_data('refere_by_phone_number','');
  }
  
  if(isset($remark) && trim($remark)!=''){
    $m->set_data('remark',$remark);
  } else {
    $m->set_data('remark','');
  }
//7oct2020
       




    $a =array(
      
      'zoobiz_id'=> $m->get_data('zoobiz_id'),
      'company_id' => $m->get_data('company_id'),
      'city_id' => $m->get_data('city_id'),
      'office_member' =>$m->get_data('office_member'),
      'refer_by' => $m->get_data('refer_by'),
      'refere_by_name' => $m->get_data('refere_by_name'),
      'refere_by_phone_number' => $m->get_data('refere_by_phone_number'),
      'remark' => $m->get_data('remark'),


      'salutation'=> $m->get_data('salutation'),
      'user_first_name'=> $m->get_data('user_first_name'),
      'user_last_name'=> $m->get_data('user_last_name'),
      'user_full_name'=> $m->get_data('user_full_name'),
      'member_date_of_birth'=> $m->get_data('member_date_of_birth'),
      'user_mobile'=> $m->get_data('user_mobile'),
      'whatsapp_number'=> $m->get_data('whatsapp_number'),
      'user_email'=> $m->get_data('user_email'),
      'gender'=> $m->get_data('gender'),
      'email_privacy'=> $m->get_data('email_privacy'),
      'invoice_download'=> $m->get_data('invoice_download'),
      'user_email'=> $m->get_data('user_email'),
      'user_profile_pic'=> $m->get_data('user_profile_pic'),
      'register_date'=> $m->get_data('register_date'),
      'plan_id'=> $m->get_data('plan_id'),
      'plan_renewal_date'=> $m->get_data('plan_renewal_date'),
    );
  
   
    $compAry =array(
      'user_id'=> $user_id,
      'company_name'=> $m->get_data('company_name'),
      'business_category_id'=> $m->get_data('business_category_id'),
      'business_sub_category_id'=> $m->get_data('business_sub_category_id'),
      'designation'=> $m->get_data('designation'),
      'company_website'=> $m->get_data('company_website'),
      'company_logo'=> $m->get_data('company_logo'),
    
    );

      $adrAry = array(
          'user_id' => $user_id, 
          'adress' => $m->get_data('adress'),
          'area_id' => $m->get_data('area_id'),
          'city_id' => $m->get_data('city_id'),
          'state_id' => $m->get_data('state_id'),
          'country_id' => $m->get_data('country_id'),
          'pincode' => $m->get_data('pincode'),
          'add_latitude' => $m->get_data('latitude'),
          'add_longitude' => $m->get_data('longitude'),
          'adress_type' => $m->get_data('adress_type')
      );

//5nov2020
  if(isset($is_paid) && trim($is_paid) ==0 ){
    $m->set_data('is_paid',$is_paid);
    $m->set_data('amount_with_gst',$amount_with_gst);
  } else {
    $m->set_data('is_paid',$is_paid);
    $m->set_data('amount_with_gst',0);
  }
 
//5nov2020

       $paymentAry = array(
          'is_paid'=> $m->get_data('is_paid'),
          'paid_amount_with_gst' => $m->get_data('amount_with_gst'),
          'user_id' => $user_id, 
          'package_id' => $m->get_data('plan_id'),
          'package_name' => $package_name,
          'user_mobile' => $m->get_data('user_mobile'),
          'payment_mode' => "Backend Admin",
          'transection_amount' => $package_amount,
          'transection_date' => date("Y-m-d H:i:s"),
          'payment_status' => "SUCCESS",
          'payment_firstname' => $m->get_data('user_first_name'),
          'payment_lastname' => $m->get_data('user_last_name'),
          'payment_phone' => $m->get_data('user_mobile'),
          'payment_email' => $m->get_data('user_email'),
          'payment_address' => $m->get_data('adress')
      );

    $q=$d->insert("users_master",$a);
    $q1=$d->insert("user_employment_details",$compAry);
    $q2=$d->insert("business_adress_master",$adrAry);
    $q3=$d->insert("transection_master",$paymentAry);
     
    if($q and $q1 and $q2 and $q3) {
      $con -> commit();
      //send user a welcome mail start
      
       
      //send user a welcome mail start

      
$user_full_name = ucfirst($user_first_name).' '.ucfirst($user_last_name);
$to = $user_email;
      $subject ="Welcome To Zoobiz";
      include('../mail/welcomeUserMail.php');
      include '../mail.php';

//5nov 2020
      //send sms to user start
 $getData = $d->select("custom_settings_master"," status = 0 and send_fcm=1 and   flag = 1 ","");
        $base_url=$m->base_url();

         $last_auto_id=$d->last_auto_id("users_master");
          $res=mysqli_fetch_array($last_auto_id);
          $new_user_id=$res['Auto_increment'];

        $user_full_name = ucfirst($user_first_name).' '.ucfirst($user_last_name);

         if( mysqli_num_rows($getData) > 0){ 
            $custom_settings_master_data = mysqli_fetch_array($getData);
  
           $description = $custom_settings_master_data['fcm_content'];
           $description =  str_replace("USER_FULL_NAME",$user_full_name,$description);
           $description =  str_replace("ANDROID_LINK",$androidLink,$description);
           $description =  str_replace("IOS_LINK",$iosLink,$description);

 
           $d->send_sms($user_mobile,$description);

         }  
  //send sms to user end
       
//send fcm to other user start
$business_categories_qry_new = $d->select("business_categories"," business_category_id ='$business_category_id'  ","");
          $business_categories_data_new=mysqli_fetch_array($business_categories_qry_new);
if($business_categories_data_new['category_status'] == 0 && $office_member=="0" ){

$getData = $d->select("custom_settings_master"," status = 0 and send_fcm=1 and flag = 0 ","");
         if( mysqli_num_rows($getData) > 0){ 
          $custom_settings_master_data = mysqli_fetch_array($getData);
          $business_categories_qry = $d->select("business_categories"," business_category_id ='$business_category_id' ","");
          $business_categories_data=mysqli_fetch_array($business_categories_qry);
  
           $title= "New Member Registered.";//" in ". $business_categories_data['category_name'] ." Category" ;
           $description = $custom_settings_master_data['fcm_content'];
 
           $description =  str_replace("USER_NAME",$user_full_name,$description);

           $description =  str_replace("COMPANY_NAME",$company_name,$description);
           $description =  str_replace("CAT_NAME",$business_categories_data['category_name'],$description);
  
            $where = "";
            if($custom_settings_master_data['share_within_city'] ==1 ){
              $where = " and  city_id ='$city_id'";
            }
            
            $user_employment_details_qry = $d->select("users_master"," active_status=0 $where  ","");

            $user_ids_array = array('0');
             while ($user_employment_details_data=mysqli_fetch_array($user_employment_details_qry)) {
              $user_ids_array[] =$user_employment_details_data['user_id'];
             }
             $user_ids_array = implode(",", $user_ids_array);

            
         $fcmArray=$d->get_android_fcm("users_master","user_token!='' AND  lower(device)='android' and user_id in ($user_ids_array)  ");
         
        $fcmArrayIos=$d->get_android_fcm("users_master "," user_token!='' AND  lower(device)='ios' and user_id in ($user_ids_array)    ");

        
        $last_auto_id=$d->last_auto_id("users_master");
          $res=mysqli_fetch_array($last_auto_id);
          $new_user_id=$res['Auto_increment'];

          $new_user_id = ($new_user_id-1);
         
          
         $nResident->noti("viewMemeber","",0,$fcmArray,$title,$description,$new_user_id);
         $nResident->noti_ios("viewMemeber","",0,$fcmArrayIos,$title,$description,$new_user_id);
       }
     }
//send fcm to other user end





  //admin notification start            
        $notiAry = array(
                      'admin_id'=>0,
                      'notification_tittle'=>"New Member Registered.",
                      'notification_description'=>ucfirst($user_first_name).' '.ucfirst($user_last_name) ." registered in ZooBiz from ".$company_name_user,
                      'notifiaction_date'=>date('Y-m-d H:i'),
                      'notification_action'=>'',
                      'admin_click_action '=>'adminNotification'
                    );
         $d->insert("admin_notification",$notiAry);
//admin notification end
 //notification sms to admins start


        $zoobiz_admin_master=$d->select("zoobiz_admin_master","send_notification = '1'    ");

        while($zoobiz_admin_master_data = mysqli_fetch_array($zoobiz_admin_master)) {
           $adminname=$zoobiz_admin_master_data['admin_name'];
           $uname=ucfirst($user_first_name).' '.ucfirst($user_last_name);
 
           $category_name = $business_categories_data['category_name'];
           $msg2= "New Member Registration in $company_name_user \nName: $uname \nCompany Name: $company_name_user \n Category: $category_name \nThanks Team ZooBiz";
            
           $d->send_sms($zoobiz_admin_master_data['admin_mobile'],$msg2);
            
         }
   //notification sms to admins start       
  //5nov2020      


//18jan2021
       //refer by user start
        $main_users_master = $d->selectRow("user_id,refer_by,refere_by_phone_number,refere_by_name","users_master", "user_mobile = '$user_mobile'    ");


        $main_users_master_data = mysqli_fetch_array($main_users_master);

        if($refer_by==2){ 
          $refere_by_phone_number = $refere_by_phone_number;
          $ref_users_master = $d->selectRow("user_mobile,user_token,device,user_full_name","users_master", "user_mobile = '$refere_by_phone_number'    ");

          $cities = $d->selectRow("city_name","cities", "city_id = '$city_id'    ");
          $cities_data = mysqli_fetch_array($cities);

 
          if (mysqli_num_rows($ref_users_master) > 0) {
            $ref_users_master_data = mysqli_fetch_array($ref_users_master);


            if($ref_users_master_data['user_token'] !=''){

              if($user_profile_pic!=""){
                $img = $base_url . "img/users/members_profile/" . $user_profile_pic;
              } else {
                $img ="";
              }


              $title=ucfirst($user_full_name);

              $msg3=ucfirst($user_full_name).", is now a proud member of ZooBiz ".$cities_data['city_name']." region. Thank you ".ucfirst($ref_users_master_data['user_full_name'])." for referring.";
              if (strtolower($ref_users_master_data['device']) =='android') {
                $nResident->noti("viewMemeber",$img,0,$ref_users_master_data['user_token'],$title,$msg3,$main_users_master_data['user_id']);
              }  else if(strtolower($ref_users_master_data['device']) =='ios') {
                $nResident->noti_ios("viewMemeber",$img,0,$ref_users_master_data['user_token'],$title,$msg3,$main_users_master_data['user_id']);
              }
            }
             
            $d->send_sms($refere_by_phone_number, $msg3);
          } else {
            $msg3=ucfirst($user_full_name).", is now a proud member of ZooBiz ".$cities_data['city_name']." region. Thank you ".ucfirst($refere_by_name)." for referring.";
            $d->send_sms($refere_by_phone_number, $msg3);
          }

        }
  //refer by user end  
//18jan2021

      $_SESSION['msg']=ucfirst($user_first_name).' '.ucfirst($user_last_name)." New Member Added";
       $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../viewMember?id=$user_id");
    } else {
      mysqli_query("ROLLBACK");
      $_SESSION['msg1']="Something Wrong";
      header("location:../viewMember?id=$user_id");
    }

  }

//19jan2020
if (isset($active_user_id)) {

$gu=$d->select("users_master","user_id='$active_user_id'  ");
$userData=mysqli_fetch_array($gu);


$a1= array (
      'active_status'=>'0',
      'inactive_by' => $_SESSION['zoobiz_admin_id']
    );
$q=$d->update("users_master",$a1,"user_id='$active_user_id' ");
if($q>0) {
      $_SESSION['msg']=$userData['user_full_name']." Activated";
      $d->insert_log("0","0","$_SESSION[zoobiz_admin_id]","$created_by","User Activated");
        
      header("location:../viewMember?id=".$active_user_id);
} else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../manageMembers");
    }
}


if (isset($delete_user_id)) {

$gu=$d->select("users_master","user_id='$delete_user_id'  ");
$userData=mysqli_fetch_array($gu);
 
 
   $a1= array (
      'active_status'=>'1',
      'inactive_by' => $_SESSION['zoobiz_admin_id']
    );
$q=$d->update("users_master",$a1,"user_id='$delete_user_id' ");


    
    if($q>0) {


      $device=$userData['device'];
       
      if (strtolower($device) =='android') {
      $nResident->noti("Logout","",0,$userData['user_token'],"Logout","User Diactivated - Logout Forcefully",'');
      }  else if(strtolower($device) =='ios') {
        $nResident->noti_ios("Logout","",0,$userData['user_token'],"Logout","User Diactivated - Logout Forcefully",'');
      }

     
      // $d->delete("user_employment_details","user_id='$delete_user_id'");
      // $d->delete("business_adress_master","user_id='$delete_user_id'");
     
     //delete user timeline
      /*$qqq=$d->select("timeline_master","user_id='$delete_user_id' ");
        while($iData=mysqli_fetch_array($qqq)) { 
            $timeline_id = $iData['timeline_id'];
            $q=$d->delete("timeline_master","timeline_id='$timeline_id' OR user_id='$delete_user_id' ");

            $timeline_photos_master_qry=$d->select("timeline_photos_master","timeline_id='$timeline_id' ");
            while($timeline_photos_master_data=mysqli_fetch_array($timeline_photos_master_qry)) { 
              $abspath=$_SERVER['DOCUMENT_ROOT'];
              $path = $abspath."/img/users/recident_feed/".$timeline_photos_master_data['photo_name'];
              unlink($path);
            }
            
            $q=$d->delete("timeline_photos_master","timeline_id='$timeline_id' OR user_id='$delete_user_id' ");
            $q=$d->delete("timeline_comments","timeline_id='$timeline_id' OR user_id='$delete_user_id' ");
            $q=$d->delete("timeline_like_master","timeline_id='$timeline_id' OR user_id='$delete_user_id'");
        }*/
      //delete user timeline

      $_SESSION['msg']=$userData['user_full_name']." Deleted";
      $d->insert_log("0","0","$_SESSION[zoobiz_admin_id]","$created_by","User Diactivated - Logout Forcefully");
       $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../manageMembers");
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../manageMembers");
    }

  }

//   if (isset($delete_user_id)) {

// $gu=$d->select("users_master","user_id='$delete_user_id'  ");
// $userData=mysqli_fetch_array($gu);
 

//     $q=$d->delete("users_master","user_id='$delete_user_id'");
//     if($q>0) {


//       $device=$userData['device'];
       
//       if (strtolower($device) =='android') {
//       $nResident->noti("Logout","",0,$userData['user_token'],"Logout","User Diactivated - Logout Forcefully",'');
//       }  else if(strtolower($device) =='ios') {
//         $nResident->noti_ios("Logout","",0,$userData['user_token'],"Logout","User Diactivated - Logout Forcefully",'');
//       }

      
// /* $d->insert_myactivity("$delete_user_id","$_SESSION[zoobiz_admin_id]","$created_by", "User Diactivated - Logout Forcefully","activity.png");*/
//  // $d->insert_myactivity($delete_user_id,"$_SESSION[zoobiz_admin_id]","$created_by", "User Diactivated - Logout Forcefully","activity.png");

  
      
//       $d->delete("user_employment_details","user_id='$delete_user_id'");
//       $d->delete("business_adress_master","user_id='$delete_user_id'");
     
//      //delete user timeline
//       $qqq=$d->select("timeline_master","user_id='$delete_user_id' ");
//         while($iData=mysqli_fetch_array($qqq)) { 
//             $timeline_id = $iData['timeline_id'];
//             $q=$d->delete("timeline_master","timeline_id='$timeline_id' OR user_id='$delete_user_id' ");

//             $timeline_photos_master_qry=$d->select("timeline_photos_master","timeline_id='$timeline_id' ");
//             while($timeline_photos_master_data=mysqli_fetch_array($timeline_photos_master_qry)) { 
//               $abspath=$_SERVER['DOCUMENT_ROOT'];
//               $path = $abspath."/img/users/recident_feed/".$timeline_photos_master_data['photo_name'];
//               unlink($path);
//             }
            
//             $q=$d->delete("timeline_photos_master","timeline_id='$timeline_id' OR user_id='$delete_user_id' ");
//             $q=$d->delete("timeline_comments","timeline_id='$timeline_id' OR user_id='$delete_user_id' ");
//             $q=$d->delete("timeline_like_master","timeline_id='$timeline_id' OR user_id='$delete_user_id'");
//         }
//       //delete user timeline

//       $_SESSION['msg']=$userData['user_full_name']." Deleted";
//       $d->insert_log("0","0","$_SESSION[zoobiz_admin_id]","$created_by","User Diactivated - Logout Forcefully");
//        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
//       header("location:../manageMembers");
//     } else {
//       $_SESSION['msg1']="Something Wrong";
//       header("location:../manageMembers");
//     }

//   }


   if (isset($logoutDevice)) {

    if (strtolower($device) =='android') {
      $nResident->noti("Logout","",0,$user_token,"Logout","Manual Logout From Admin Panel",'');
    }  else if(strtolower($device) =='ios') {
      $nResident->noti_ios("Logout","",0,$user_token,"Logout","Manual Logout From Admin Panel",'');
    }

    

     $m->set_data('user_token','');
      
        $a = array(
            'user_token'=>$m->get_data('user_token')
        );

        $qdelete = $d->update("users_master",$a,"user_id='$user_id'");

         $adm_data=$d->selectRow("user_full_name","users_master"," user_id='$user_id'");
        $data_q=mysqli_fetch_array($adm_data);
    $_SESSION['msg']=$data_q['user_full_name']." Logout Forcefully From Web Portal";

 
  
$d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by","Manual Logout From Admin Panel");


     $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("location:../viewMember?id=$user_id");
    exit();

  }

  if (isset($renewPlan)) {
    $q=$d->select("package_master","package_id='$plan_id'","");
    $row1=mysqli_fetch_array($q);
    $package_name= $row1['package_name'];
    $no_month=$row1['no_of_month'];
    $package_amount=$row1['package_amount'];

    
      //9oct2020
     if($row1['gst_slab_id'] !="0"){
      $gst_slab_id = $row1['gst_slab_id'];
           $gst_master=$d->select("gst_master","slab_id = '$gst_slab_id'","");
           $gst_master_data=mysqli_fetch_array($gst_master);
           $gst_amount= (($row1["package_amount"]*$gst_master_data['slab_percentage']) /100);
    } else {
            $gst_amount= 0 ;
    }
     $package_amount=number_format($row1["package_amount"]+$gst_amount,2,'.','');
       
      //9oct2020


    $time = strtotime($plan_renewal_date_old);

    //NEW
    //$plan_renewal_date = date("Y-m-d", strtotime('+'.$no_month.' month', $time));
     if($row1["time_slab"] == 1){
       $plan_renewal_date=date('Y-m-d', strtotime(' +'.$no_month.' days',$time));
     } else {
       $plan_renewal_date=date('Y-m-d', strtotime(' +'.$no_month.' months',$time));
     }
     //NEW


    

    $paymentAry = array(
          'user_id' => $user_id, 
          'package_id' => $plan_id,
          'package_name' => $package_name.' (Renew)',
          'user_mobile' => $user_mobile,
          'payment_mode' => "Backend Admin",
          'transection_amount' => $package_amount,
          'transection_date' => date("Y-m-d H:i:s"),
          'payment_status' => "SUCCESS",
          'payment_firstname' => $user_first_name,
          'payment_lastname' => $user_last_name,
          'payment_phone' => $user_mobile,
          'payment_email' => $user_email,
      );

      $a =array(
      'plan_id'=> $plan_id,
      'plan_renewal_date'=> $plan_renewal_date,
      );

      $q=$d->update("users_master",$a,"user_id='$user_id'");
      $q3=$d->insert("transection_master",$paymentAry);
       
      if($q and $q3) {
        $con -> commit();
        $adm_data=$d->selectRow("user_full_name","users_master"," user_id='$user_id'");
        $data_q=mysqli_fetch_array($adm_data);

        $_SESSION['msg']=$data_q['user_full_name']."'s Plan renewed successfully !";
         $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../viewMember?id=$user_id");
      } else {
        mysqli_query("ROLLBACK");
        $_SESSION['msg1']="Something Wrong";
        header("location:../viewMember?id=$user_id");
      }


  }
 
}
else{
  header('location:../login');
}
?>