<?php 
include '../common/objectController.php';
// add new Notice Board
if(isset($_POST) && !empty($_POST) )

{
  if(isset($addSliderImage)) {

     $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
     $uploadedFile = $_FILES['slider_image']['tmp_name'];
     $ext = pathinfo($_FILES['slider_image']['name'], PATHINFO_EXTENSION);
      if(in_array($ext,$extension)) {

        $sourceProperties = getimagesize($uploadedFile);
        $newFileName = rand();
        $dirPath = "../../img/sliders/";
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
                header("Location: ../sliderImages");
                exit;
                break;
            }
            $slider_image= $newFileName."_banner.".$ext;
        //Make sure we have a file path
        } else {
          $_SESSION['msg1']="Invalid Image....";
          header("Location: ../sliderImages");
        }

            // 
                $m->set_data('slider_image', $slider_image);
                $m->set_data('slider_description', $slider_description);
                $m->set_data('slider_url', $slider_url);
                $m->set_data('slider_mobile', $slider_mobile);
                $m->set_data('slider_video_url', $slider_video_url);
                $m->set_data('user_id', $user_id);
                $m->set_data('business_category_id', $business_category_id);
                $created_date= date("Y-m-d H:i:s");
                $m->set_data('created_date', $created_date);
                $a = array(
                            'slider_image' => $m->get_data('slider_image'),
                            'slider_description' => $m->get_data('slider_description'),
                            'slider_url' => $m->get_data('slider_url'),
                            'slider_mobile' => $m->get_data('slider_mobile'),
                            'slider_video_url' => $m->get_data('slider_video_url'),
                            'user_id' => $m->get_data('user_id'),
                            'business_category_id' => $m->get_data('business_category_id'),
                            'created_date' => $m->get_data('created_date'),
                        );
                $q = $d->insert("slider_master", $a);
    if($q==TRUE) {
        $_SESSION['msg']="New Slider Added...";
        $d->insert_log("","0","$_SESSION[partner_login_id]","$created_by",$_SESSION['msg']);
        header("Location: ../sliderImages");
    } else {
      $_SESSION['msg1']="Something Went Wrong.";
      header("Location: ../sliderImages");
    }
  }

  if(isset($updateSlider)) {

     $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
     $uploadedFile = $_FILES['slider_image']['tmp_name'];
     $ext = pathinfo($_FILES['slider_image']['name'], PATHINFO_EXTENSION);
      if(in_array($ext,$extension)) {

        $sourceProperties = getimagesize($uploadedFile);
        $newFileName = rand();
        $dirPath = "../../img/sliders/";
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
                header("Location: ../sliderImages");
                exit;
                break;
            }
            $slider_image= $newFileName."_banner.".$ext;
        //Make sure we have a file path
        } else {
          $slider_image= $slider_image_old;
        }

            // 
                $m->set_data('slider_image', $slider_image);
                $m->set_data('slider_description', $slider_description);
                $m->set_data('slider_url', $slider_url);
                $m->set_data('slider_mobile', $slider_mobile);
                $m->set_data('slider_video_url', $slider_video_url);
                $m->set_data('user_id', $user_id);
                
                $m->set_data('business_category_id', $business_category_id);
                $a = array(
                            'slider_image' => $m->get_data('slider_image'),
                            'slider_description' => $m->get_data('slider_description'),
                            'slider_url' => $m->get_data('slider_url'),
                            'slider_mobile' => $m->get_data('slider_mobile'),
                            'slider_video_url' => $m->get_data('slider_video_url'),
                            'user_id' => $m->get_data('user_id'),
                            'business_category_id' => $m->get_data('business_category_id'),
                        );
                $q = $d->update("slider_master", $a,"slider_id='$slider_id_edit'");
    if($q==TRUE) {
        $_SESSION['msg']="Slider Updated...";
        $d->insert_log("","0","$_SESSION[partner_login_id]","$created_by",$_SESSION['msg']);
        header("Location: ../sliderImages");
    } else {
      $_SESSION['msg1']="Something Went Wrong.";
      header("Location: ../sliderImages");
    }
  }

  if(isset($deleteSliderImage)) {

$gu=$d->select("slider_master","slider_id='$slider_id'");
$NewData=mysqli_fetch_array($gu);

$m->set_data('deleted_by', $_SESSION[full_name]);
$a = array(
                            'deleted_by' =>$m->get_data('deleted_by'),
                            'deleted_at' => date("Y-m-d H:i:s"),
                             'status'=>'1'
                        );
                $q = $d->update("slider_master", $a,"slider_id='$slider_id'");
     // $q = $d->delete("slider_master","slider_id='$slider_id'");
    if($q==TRUE) {

     //delete images
    /* $abspath=$_SERVER['DOCUMENT_ROOT'];
     $path_slider_image = $abspath."/img/sliders/".$NewData['slider_image'];
      unlink($path_slider_image);*/
     //delete images


        $_SESSION['msg']="Slider Deleted";
        
        $d->insert_log("","0","$_SESSION[partner_login_id]","$created_by",$_SESSION['msg']);
        header("Location: ../sliderImages");
    } else {
      $_SESSION['msg1']="Something Went Wrong.";
      header("Location: ../sliderImages");
    }
  }

}

 ?>