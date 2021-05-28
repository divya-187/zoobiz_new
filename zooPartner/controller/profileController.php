<?php 
 include '../common/objectController.php';

if(isset($_POST) && !empty($_POST) )
{
	if(isset($updateProfile)){


     $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
      $uploadedFile = $_FILES['partner_profile']['tmp_name'];
      $ext = pathinfo($_FILES['partner_profile']['name'], PATHINFO_EXTENSION);
      if(file_exists($uploadedFile)) {
        if(in_array($ext,$extension)) {

          $sourceProperties = getimagesize($uploadedFile);
          $newFileName = rand().$zoobiz_partner_id;
          $dirPath = "../../zooAdmin/img/profile/";
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
                imagepng($tmp,$dirPath. $newFileName. "_partner.". $ext);
                break;           

            case IMAGETYPE_JPEG:
                $imageSrc = imagecreatefromjpeg($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagejpeg($tmp,$dirPath. $newFileName. "_partner.". $ext);
                break;
            
            case IMAGETYPE_GIF:
                $imageSrc = imagecreatefromgif($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagegif($tmp,$dirPath. $newFileName. "_partner.". $ext);
                break;

            default:
               $_SESSION['msg1']="Invalid Image";
                header("Location: ../profile");
                exit;
                break;
            }
            $partner_profile= $newFileName."_partner.".$ext;
         } else {
          $_SESSION['msg1']="Invalid Photo";
          header("location:../profile");
          exit();
         }
        } else {
          $partner_profile= $partner_profile_old;
        }          
 $m->set_data("partner_profile",test_input($partner_profile));
 

    $m->set_data("partner_name",test_input($partner_name)); 
    $a = array(
      'partner_name'=>$m->get_data('partner_name'),
      
       'partner_profile'=>$m->get_data('partner_profile'),
    ); 

    $q_temp=$d->update("zoobiz_partner_master",$a,"zoobiz_partner_id='$_SESSION[partner_login_id]'");
    if($q_temp>0){

      $_SESSION['partner_name']= $partner_name;  
      //9nov
    
      $_SESSION['admin_profile'] =  $partner_profile;    
      $_SESSION['msg']=$partner_name."'s Profile updated.";
       $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../profile");
    } else{
      $_SESSION['msg1']="Something Wrong";
      header("location:../profile");
    }            
  }

   


}
?>