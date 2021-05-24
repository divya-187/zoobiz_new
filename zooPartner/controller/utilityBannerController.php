<?php 
include '../common/objectController.php';
// add new Notice Board
if(isset($_POST) && !empty($_POST) )

{
  if(isset($addUtilityBannerImage)) {

     $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");

//echo count($_FILES["banner_image"]['name'])."<pre>"; print_r($_FILES);//exit;
    // foreach($_FILES["banner_image"]["tmp_name"] as $key=>$tmp_name) {
        for ($key=0; $key < count($_FILES["banner_image"]['name']) ; $key++) { 
           echo $_FILES["banner_image"]["name"][$key].'<br>';
            $file_name=$_FILES["banner_image"]["name"][$key];
            $file_tmp=$_FILES["banner_image"]["tmp_name"][$key];
            $uploadedFile=$_FILES["banner_image"]["tmp_name"][$key];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);
            $fileSize=$_FILES["banner_image"]["size"][$key];
            $KBSize = $fileSize/1024;
            $image_size = $KBSize/1024;
            $sourceProperties = getimagesize($uploadedFile);
            $newFileName = rand()+1;
            $dirPath = "../../img/utilityBanner/";
            $imageType = $sourceProperties[2];
            $imageHeight = $sourceProperties[1];
            $imageWidth = $sourceProperties[0];
            
            if ($imageWidth>800) {
                $newWidthPercentage= 800*100 / $imageWidth;  //for maximum 800 widht
                $newImageWidth = $imageWidth * $newWidthPercentage /100;
                $newImageHeight = $imageHeight * $newWidthPercentage /100;
            } else {
                $newImageWidth = $imageWidth;
                $newImageHeight = $imageHeight;
            }



            if(in_array($ext,$extension)) {
                       switch ($imageType) {

                        case IMAGETYPE_PNG:
                            $imageSrc = imagecreatefrompng($uploadedFile); 
                            $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                            imagepng($tmp,$dirPath. $newFileName. "_banner.". $ext);
                            break;           

                        case IMAGETYPE_JPEG:
                            $imageSrc = imagecreatefromjpeg($uploadedFile); 
                            $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                            imagejpeg($tmp,$dirPath. $newFileName. "_banner.". $ext);
                            break;
                        
                        case IMAGETYPE_GIF:
                            $imageSrc = imagecreatefromgif($uploadedFile); 
                            $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                            imagegif($tmp,$dirPath. $newFileName. "_banner.". $ext);
                            break;

                        
                        }
                        $newFileName= $newFileName."_banner.".$ext;
                        

                         

                         $m->set_data('banner_image', $newFileName);
                $m->set_data('frame_id', $frame_id);
                $a = array(
                            'frame_id' => $m->get_data('frame_id') ,
                            'banner_image' => $m->get_data('banner_image') 
                        );
                $q = $d->insert("utility_banner_master", $a);

                          
            }
            else {
                array_push($error,"$file_name, ");
            }
        }

        

    if($q==TRUE) {
       $_SESSION['msg']="Utility Banner Added";
       $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
       header("Location: ../utilityBanners");
    } else {
        $_SESSION['msg1']="Something Wrong";
      header("Location: ../utilityBanners");
    }


     /*$uploadedFile = $_FILES['banner_image']['tmp_name'];
     $ext = pathinfo($_FILES['banner_image']['name'], PATHINFO_EXTENSION);
      if(in_array($ext,$extension)) {

        $sourceProperties = getimagesize($uploadedFile);
        $newFileName = rand();
        $dirPath = "../../img/utilityBanner/";
        $imageType = $sourceProperties[2];
        $imageHeight = $sourceProperties[1];
        $imageWidth = $sourceProperties[0];
        
        // less 30 % size 
        if ($imageWidth>1800) {
            $newWidthPercentage= 1800*100 / $imageWidth;  //for maximum 1200 widht
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
                imagepng($tmp,$dirPath. $newFileName. "_banner.". $ext);
                break;           

            case IMAGETYPE_JPEG:
                $imageSrc = imagecreatefromjpeg($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagejpeg($tmp,$dirPath. $newFileName. "_banner.". $ext);
                break;
            
            case IMAGETYPE_GIF:
                $imageSrc = imagecreatefromgif($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagegif($tmp,$dirPath. $newFileName. "_banner.". $ext);
                break;

            default:
               $_SESSION['msg1']="Invalid Image";
                header("Location: ../utilityBanners");
                exit;
                break;
            }
            $banner_image= $newFileName."_banner.".$ext;
        //Make sure we have a file path
        } else {
          $_SESSION['msg1']="Invalid Image....";
          header("Location: ../utilityBanners");
        }

           
                $m->set_data('banner_image', $banner_image);
                $m->set_data('frame_id', $frame_id);
                $a = array(
                            'frame_id' => $m->get_data('frame_id') ,
                            'banner_image' => $m->get_data('banner_image') 
                        );
                $q = $d->insert("utility_banner_master", $a);
    if($q==TRUE) {
        $_SESSION['msg']="New Utility Banner Added...";
        header("Location: ../utilityBanners");
    } else {
      $_SESSION['msg1']="Something Went Wrong.";
      header("Location: ../utilityBanners");
    }*/
  }
///24sept
  if(isset($addPerUtilityBannerImage)) {

     $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");

//echo count($_FILES["banner_image"]['name'])."<pre>"; print_r($_FILES);//exit;
    // foreach($_FILES["banner_image"]["tmp_name"] as $key=>$tmp_name) {
        for ($key=0; $key < count($_FILES["banner_image"]['name']) ; $key++) { 
           echo $_FILES["banner_image"]["name"][$key].'<br>';
            $file_name=$_FILES["banner_image"]["name"][$key];
            $file_tmp=$_FILES["banner_image"]["tmp_name"][$key];
            $uploadedFile=$_FILES["banner_image"]["tmp_name"][$key];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);
            $fileSize=$_FILES["banner_image"]["size"][$key];
            $KBSize = $fileSize/1024;
            $image_size = $KBSize/1024;
            $sourceProperties = getimagesize($uploadedFile);
            $newFileName = rand()+1;
            $dirPath = "../../img/utilityBanner/";
            $imageType = $sourceProperties[2];
            $imageHeight = $sourceProperties[1];
            $imageWidth = $sourceProperties[0];
            
            if ($imageWidth>800) {
                $newWidthPercentage= 800*100 / $imageWidth;  //for maximum 800 widht
                $newImageWidth = $imageWidth * $newWidthPercentage /100;
                $newImageHeight = $imageHeight * $newWidthPercentage /100;
            } else {
                $newImageWidth = $imageWidth;
                $newImageHeight = $imageHeight;
            }



            if(in_array($ext,$extension)) {
                       switch ($imageType) {

                        case IMAGETYPE_PNG:
                            $imageSrc = imagecreatefrompng($uploadedFile); 
                            $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                            imagepng($tmp,$dirPath. $newFileName. "_banner.". $ext);
                            break;           

                        case IMAGETYPE_JPEG:
                            $imageSrc = imagecreatefromjpeg($uploadedFile); 
                            $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                            imagejpeg($tmp,$dirPath. $newFileName. "_banner.". $ext);
                            break;
                        
                        case IMAGETYPE_GIF:
                            $imageSrc = imagecreatefromgif($uploadedFile); 
                            $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                            imagegif($tmp,$dirPath. $newFileName. "_banner.". $ext);
                            break;

                        
                        }
                        $newFileName= $newFileName."_banner.".$ext;
                        

                         

                         $m->set_data('banner_image', $newFileName);
                $m->set_data('frame_id', $frame_id);
                $a = array(
                            'frame_id' => $m->get_data('frame_id') ,
                            'banner_image' => $m->get_data('banner_image') 
                        );
                $q = $d->insert("utility_banner_master", $a);

                          
            }
            else {
                array_push($error,"$file_name, ");
            }
        }

        

    if($q==TRUE) {
       $_SESSION['msg']="Utility Banner Added";
       $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
       header("Location: ../utilityBanners?frame_id=$frame_id&viewDetail=true");
    } else {
        $_SESSION['msg1']="Something Wrong";
      header("Location: ../utilityBanners");
    }

 
  }
//24sept
  if(isset($updateUtilityBanner)) {

     $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
     $uploadedFile = $_FILES['banner_image']['tmp_name'];
     $ext = pathinfo($_FILES['banner_image']['name'], PATHINFO_EXTENSION);
      if(in_array($ext,$extension)) {

        $sourceProperties = getimagesize($uploadedFile);
        $newFileName = rand();
        $dirPath = "../../img/utilityBanner/";
        $imageType = $sourceProperties[2];
        $imageHeight = $sourceProperties[1];
        $imageWidth = $sourceProperties[0];
        
        // less 30 % size 
        if ($imageWidth>1800) {
            $newWidthPercentage= 1800*100 / $imageWidth;  //for maximum 1200 widht
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
                imagepng($tmp,$dirPath. $newFileName. "_banner.". $ext);
                break;           

            case IMAGETYPE_JPEG:
                $imageSrc = imagecreatefromjpeg($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagejpeg($tmp,$dirPath. $newFileName. "_banner.". $ext);
                break;
            
            case IMAGETYPE_GIF:
                $imageSrc = imagecreatefromgif($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagegif($tmp,$dirPath. $newFileName. "_banner.". $ext);
                break;

            default:
               $_SESSION['msg1']="Invalid Image";
                header("Location: ../utilityBanners");
                exit;
                break;
            }
            $banner_image= $newFileName."_banner.".$ext;
        //Make sure we have a file path
        } else {
          $banner_image= $banner_image_old;
        }

            // 
                $m->set_data('banner_image', $banner_image); 
                $m->set_data('frame_id', $frame_id); 
                $a = array(
                    'frame_id' => $m->get_data('frame_id') ,
                            'banner_image' => $m->get_data('banner_image') 
                        );
                $q = $d->update("utility_banner_master", $a,"banner_id='$banner_id_edit'");
    if($q==TRUE) {
        $_SESSION['msg']="Utility Banner Updated...";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("Location: ../utilityBanners");
    } else {
      $_SESSION['msg1']="Something Went Wrong.";
      header("Location: ../utilityBanners");
    }
  }

  if(isset($deleteUtilityBannerImage)) {

     $q = $d->delete("utility_banner_master","banner_id='$banner_id'");
    if($q==TRUE) {
        $_SESSION['msg']="Utility Banner Deleted";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("Location: ../utilityBanners");
    } else {
      $_SESSION['msg1']="Something Went Wrong.";
      header("Location: ../utilityBanners");
    }
  }


  if(isset($delete_frame_id)  ) {
    
    $success= 0 ; 
       $eq = $d->select("utility_banner_master","   frame_id = '$delete_frame_id'   ");
        
       
                while ($pData = mysqli_fetch_array($eq)) {
                  $banner_path = "../../img/utilityBanner/".$pData['banner_image'];
                  $banner_id = $pData['banner_id'];
                  $q=$d->delete("utility_banner_master","banner_id='$banner_id'");
                  if($q){
                    $success= 1 ; 
                        unlink($banner_path);
                  }
                }
        if($success){     
              echo 1;
        } else {
             echo 0;
        }
}

if(isset($deleteGalleryPhoto)  ) {
    
    $success= 0 ; 
       $eq = $d->select("utility_banner_master","   banner_id = '$banner_id'   ");
        
       
                while ($pData = mysqli_fetch_array($eq)) {
                  $banner_path = "../../img/utilityBanner/".$pData['banner_image'];
                  $banner_id = $pData['banner_id'];
                  $q=$d->delete("utility_banner_master","banner_id='$banner_id' and frame_id='$frame_id' ");
                  if($q){
                    $success= 1 ; 
                        unlink($banner_path);
                  }
                }
       if($success) {
        $_SESSION['msg']="Utility Banner Image Deleted";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("Location: ../utilityBanners?frame_id=$frame_id&viewDetail=true");
    } else {
      $_SESSION['msg1']="Something Went Wrong.";
      header("Location: ../utilityBanners?frame_id=$frame_id&viewDetail=true");
    }
}

}

 ?>