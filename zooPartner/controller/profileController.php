<?php 
 include '../common/objectController.php';

if(isset($_POST) && !empty($_POST) )
{
	if(isset($updateProfile)){

//9nov
     $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
      $uploadedFile = $_FILES['profile_image']['tmp_name'];
      $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
      if(file_exists($uploadedFile)) {
        if(in_array($ext,$extension)) {

          $sourceProperties = getimagesize($uploadedFile);
          $newFileName = rand().$user_id;
          $dirPath = "../img/profile/";
          $imageType = $sourceProperties[2];
          $imageHeight = $sourceProperties[1];
          $imageWidth = $sourceProperties[0];
          if ($imageWidth>400) {
            $newWidthPercentage= 400*100 / $imageWidth;  //for maximum 400 widht
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
                imagepng($tmp,$dirPath. $newFileName. "_user.". $ext);
                break;           

            case IMAGETYPE_JPEG:
                $imageSrc = imagecreatefromjpeg($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagejpeg($tmp,$dirPath. $newFileName. "_user.". $ext);
                break;
            
            case IMAGETYPE_GIF:
                $imageSrc = imagecreatefromgif($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagegif($tmp,$dirPath. $newFileName. "_user.". $ext);
                break;

            default:
               $_SESSION['msg1']="Invalid Image";
                header("Location: ../profile");
                exit;
                break;
            }
            $profile_image= $newFileName."_user.".$ext;
         } else {
          $_SESSION['msg1']="Invalid Photo";
          header("location:../profile");
          exit();
         }
        } else {
          $profile_image= $profile_image_old;
        }          
 $m->set_data("admin_profile",test_input($profile_image));
//9nov

    $m->set_data("full_name",test_input($full_name));
    $m->set_data("admin_email",test_input($admin_email));
    $a = array(
      'admin_name'=>$m->get_data('full_name'),
      'admin_email'=>$m->get_data('admin_email'),
       'admin_profile'=>$m->get_data('admin_profile'),
    ); 

    $q_temp=$d->update("zoobiz_admin_master",$a,"zoobiz_admin_id='$_SESSION[zoobiz_admin_id]'");
    if($q_temp>0){

      $_SESSION['full_name']= $full_name;  
      //9nov
      $_SESSION['admin_email']= $admin_email;   
      $_SESSION['admin_profile'] =  $profile_image;    
      $_SESSION['msg']=$full_name."'s Profile updated.";
       $d->insert_log("","$society_id","$_SESSION[bms_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../profile");
    } else{
      $_SESSION['msg1']="Something Wrong";
      header("location:../profile");
    }            
  }

  // Change Password
  if(isset($_POST["passwordChange"])) {
    extract(array_map("test_input" , $_POST));
    if ($password== $password2) {
      $q = $d->select("zoobiz_admin_master","zoobiz_admin_id='$_SESSION[zoobiz_admin_id]'");
      $data = mysqli_fetch_array($q);
      if (password_verify($old_password, $data['admin_password'])) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $m->set_data('password',$password);
        $a1= array (
          'admin_password'=> $m->get_data('password'),
        );
        $insert=$d->update('zoobiz_admin_master',$a1,"zoobiz_admin_id='$_SESSION[zoobiz_admin_id]'"); 
        if ($insert == true) {
          $_SESSION['msg']= $_SESSION['full_name']."'s Password Changed Successfully..!";
           $d->insert_log("","$society_id","$_SESSION[bms_admin_id]","$created_by",$_SESSION['msg']);
          session_start();
          session_destroy();
          header("location:index.php");
          header("location:../profile");
        }else{
          $_SESSION['msg1']= "Somthig wrong..";
          header("location:../profile");
        }
      }else{
        $_SESSION['msg1']= "Old Password is wrong!";
        header("location:../profile");
      }
    } else {
      $_SESSION['msg1']= "Comirm Password is wrong";
      header("location:../profile");
    }  
  }


  if (isset($updateAdvertisement)) {
    
     $file = $_FILES['advertisement_url']['tmp_name'];
       if(file_exists($file)) {
     // checking if main category value was changed
            $errors     = array();
            $maxsize    = 2097152;
            $acceptable = array(
                // 'application/pdf',
                'image/jpeg',
                'image/jpg',
                'image/gif',
                'image/png'
            );
            if(($_FILES['advertisement_url']['size'] >= $maxsize) || ($_FILES["advertisement_url"]["size"] == 0)) {
                 $_SESSION['msg1']=" Photo too large. File must be less than 2 MB.";
                 header("location:../sliderImages");
                 exit();
            }
            if(!in_array($_FILES['advertisement_url']['type'], $acceptable) && (!empty($_FILES["advertisement_url"]["type"]))) {
                $_SESSION['msg1']="Invalid Photo type. Only  JPG and PNG types are accepted.";
                 header("location:../sliderImages");
                 exit();
            }

            $image_Arr = $_FILES['advertisement_url'];   
            $temp = explode(".", $_FILES["advertisement_url"]["name"]);
            $advertisement_url = rand().'.' . end($temp);
            move_uploaded_file($_FILES["advertisement_url"]["tmp_name"], "../../img/sliders/".$advertisement_url);
       } else {
        $advertisement_url=$advertisement_url_old;
       }

        $m->set_data('active_status',$active_status);
        $m->set_data('view_status',$view_status);
        $m->set_data('advertisement_url',$advertisement_url);

         $a1= array (
            
          'advertisement_url'=> $m->get_data('advertisement_url'),
          'active_status'=> $m->get_data('active_status'),
          'view_status'=> $m->get_data('view_status'),
        );


    $q=$d->update("advertisement_master",$a1,"");
    if($q==TRUE) {
      $_SESSION['msg']="Advertisement Data Updated";
       $d->insert_log("","$society_id","$_SESSION[bms_admin_id]","$created_by",$_SESSION['msg']);
      header("Location: ../sliderImages");
    } else {
       $_SESSION['msg1']="Something Wrong";
      header("Location: ../sliderImages");
    }

  }


}
?>