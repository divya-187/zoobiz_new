<?php
include '../common/objectController.php';
if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{

   if(isset($addKeywordBtn)) {
    $m->set_data('business_sub_category_id',$business_sub_category_id);
$m->set_data('sub_category_keyword',ucwords($sub_category_keyword));


 $cat_qry=$d->selectRow("category_name, sub_category_name","business_sub_categories,business_categories","business_categories.business_category_id=business_sub_categories.business_category_id and  business_sub_categories.business_sub_category_id = $business_sub_category_id  ","");
 $cat_data=mysqli_fetch_array($cat_qry);


$a1= array (
  'business_sub_category_id'=> $m->get_data('business_sub_category_id'),
  'sub_category_keyword'=> $m->get_data('sub_category_keyword'),
  'created_by'=> $created_by,
  'created_at'=> date("Y-m-d H:i:s")
);
$q=$d->insert("sub_category_keywords_master",$a1);
if($q==TRUE) {
  $_SESSION['msg']=ucwords($category_images)." Keyword Added for ".html_entity_decode($cat_data['sub_category_name']).' - '. html_entity_decode($cat_data['category_name']);
  $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
  header("Location: ../manageSubCatKeywords?business_sub_category_id=$business_sub_category_id");
} else {
  header("Location: ../manageSubCatKeywords?business_sub_category_id=$business_sub_category_id");
}

   }


   if(isset($editKeywordBtn)) {
    
$m->set_data('sub_category_keyword',ucwords($sub_category_keyword));


 $cat_qry=$d->selectRow("category_name, sub_category_name","business_sub_categories,business_categories","business_categories.business_category_id=business_sub_categories.business_category_id and  business_sub_categories.business_sub_category_id = $business_sub_category_id  ","");
 $cat_data=mysqli_fetch_array($cat_qry);


$a1= array ( 
  'sub_category_keyword'=> $m->get_data('sub_category_keyword') 
);
$q=$d->update("sub_category_keywords_master",$a1,"sub_category_keywords_id = $sub_category_keywords_id");
if($q==TRUE) {
  $_SESSION['msg']=ucwords($category_images)." Keyword Updated for ".html_entity_decode($cat_data['sub_category_name']).' - '. html_entity_decode($cat_data['category_name']);
  $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
  header("Location: ../manageSubCatKeywords?business_sub_category_id=$business_sub_category_id");
} else {
  header("Location: ../manageSubCatKeywords?business_sub_category_id=$business_sub_category_id");
}

   }


  if(isset($addCategory)) {
    $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
    $uploadedFile = $_FILES['category_images']['tmp_name'];
    $ext = pathinfo($_FILES['category_images']['name'], PATHINFO_EXTENSION);
    if(file_exists($uploadedFile)) {
      if(in_array($ext,$extension)) {
        $sourceProperties = getimagesize($uploadedFile);
        $newFileName = rand();
        $dirPath = "../../img/category/";
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
  imagepng($tmp,$dirPath. $newFileName. "_category.". $ext);
  break;
  case IMAGETYPE_JPEG:
  $imageSrc = imagecreatefromjpeg($uploadedFile);
  $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
  imagejpeg($tmp,$dirPath. $newFileName. "_category.". $ext);
  break;
  case IMAGETYPE_GIF:
  $imageSrc = imagecreatefromgif($uploadedFile);
  $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
  imagegif($tmp,$dirPath. $newFileName. "_category.". $ext);
  break;
  default:
  $_SESSION['msg1']="Invalid Image";
  header("Location: ../mainCategories");
  exit;
  break;
}
$category_images= $newFileName."_category.".$ext;
} else {
  $_SESSION['msg1']="Invalid Photo";
  header("location:../mainCategories");
  exit();
}
} else {
  $category_images= "";
}
$category_name= ucfirst($category_name);
$m->set_data('category_name',$category_name);
$m->set_data('category_images',$category_images);
$extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
$uploadedFile = $_FILES['cat_icon']['tmp_name'];
$ext = pathinfo($_FILES['cat_icon']['name'], PATHINFO_EXTENSION);
if(file_exists($uploadedFile)) {
  if(in_array($ext,$extension)) {
    $sourceProperties = getimagesize($uploadedFile);
    $newFileName = rand();
    $dirPath = "../../img/category/icon/";
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
$newImageWidth = 134;
$newImageHeight = 152;
move_uploaded_file($_FILES["cat_icon"]["tmp_name"], $dirPath.$newFileName. "_icon.". $ext);
/*switch ($imageType) {
case IMAGETYPE_PNG:
//$imageSrc = imagecreatefrompng($uploadedFile);
$imageSrc = $uploadedFile;
$tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
// imagepng($tmp,$dirPath. $newFileName. "_icon.". $ext);
move_uploaded_file($tmp, $dirPath. $newFileName. "_icon.". $ext);
break;
case IMAGETYPE_JPEG:
$imageSrc = imagecreatefromjpeg($uploadedFile);
$tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
imagejpeg($tmp,$dirPath. $newFileName. "_icon.". $ext);
break;
case IMAGETYPE_GIF:
$imageSrc = imagecreatefromgif($uploadedFile);
$tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
imagegif($tmp,$dirPath. $newFileName. "_icon.". $ext);
break;
default:
$_SESSION['msg1']="Invalid Image";
header("Location: ../mainCategories");
exit;
break;
}*/
$menu_icon= $newFileName."_icon.".$ext;
} else {
  $_SESSION['msg1']="Invalid Photo";
  header("location:../mainCategories");
  exit();
}
} else {
  $menu_icon= "";
}
$m->set_data('menu_icon',$menu_icon);
$a1= array (
  'category_name'=> $m->get_data('category_name'),
  'category_images'=> $m->get_data('category_images'),
  'menu_icon'=> $m->get_data('menu_icon'),
);
$q=$d->insert("business_categories",$a1);
if($q==TRUE) {
  $_SESSION['msg']=$category_name." Business Category Added";
  $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
  header("Location: ../mainCategories");
} else {
  header("Location: ../mainCategories");
}
}
if(isset($editCategory)) {
  $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
  $uploadedFile = $_FILES['category_images']['tmp_name'];
  $ext = pathinfo($_FILES['category_images']['name'], PATHINFO_EXTENSION);
  if(file_exists($uploadedFile)) {
    if(in_array($ext,$extension)) {
      $sourceProperties = getimagesize($uploadedFile);
      $newFileName = rand();
      $dirPath = "../../img/category/";
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
  imagepng($tmp,$dirPath. $newFileName. "_category.". $ext);
  break;
  case IMAGETYPE_JPEG:
  $imageSrc = imagecreatefromjpeg($uploadedFile);
  $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
  imagejpeg($tmp,$dirPath. $newFileName. "_category.". $ext);
  break;
  case IMAGETYPE_GIF:
  $imageSrc = imagecreatefromgif($uploadedFile);
  $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
  imagegif($tmp,$dirPath. $newFileName. "_category.". $ext);
  break;
  default:
  $_SESSION['msg1']="Invalid Image";
  header("Location: ../mainCategories");
  exit;
  break;
}
$category_images= $newFileName."_category.".$ext;
} else {
  $_SESSION['msg1']="Invalid Photo";
  header("location:../mainCategories");
  exit();
}
} else {
  $category_images= $category_images_old;
}
$category_name= ucfirst($category_name_edit);
$m->set_data('category_name',$category_name);
$m->set_data('category_images',$category_images);
$extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
$uploadedFile = $_FILES['cat_icon']['tmp_name'];
$ext = pathinfo($_FILES['cat_icon']['name'], PATHINFO_EXTENSION);
if(file_exists($uploadedFile)) {
  if(in_array($ext,$extension)) {
    $sourceProperties = getimagesize($uploadedFile);
    $newFileName = rand();
    $dirPath = "../../img/category/icon/";
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
$newImageWidth = 134;
$newImageHeight = 152;
move_uploaded_file($_FILES["cat_icon"]["tmp_name"], $dirPath.$newFileName. "_icon.". $ext);
// switch ($imageType) {
//   case IMAGETYPE_PNG:
//       /*$imageSrc = imagecreatefrompng($uploadedFile);
//       $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
//       imagepng($tmp,$dirPath. $newFileName. "_icon.". $ext);
//       break;*/
//       //$imageSrc = imagecreatefrompng($uploadedFile);
//   $imageSrc = $uploadedFile;
//       $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
//      // imagepng($tmp,$dirPath. $newFileName. "_icon.". $ext);
//        move_uploaded_file($tmp, $dirPath. $newFileName. "_icon.". $ext);
//       break;
//   case IMAGETYPE_JPEG:
//       $imageSrc = imagecreatefromjpeg($uploadedFile);
//       $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
//       imagejpeg($tmp,$dirPath. $newFileName. "_icon.". $ext);
//       break;
//   case IMAGETYPE_GIF:
//       $imageSrc = imagecreatefromgif($uploadedFile);
//       $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
//       imagegif($tmp,$dirPath. $newFileName. "_icon.". $ext);
//       break;
//   default:
//      $_SESSION['msg1']="Invalid Image";
//       header("Location: ../mainCategories");
//       exit;
//       break;
//   }
$menu_icon= $newFileName."_icon.".$ext;
} else {
  $_SESSION['msg1']="Invalid Photo";
  header("location:../mainCategories");
  exit();
}
} else {
  $menu_icon= $cat_icon_old;
}
$m->set_data('menu_icon',$menu_icon);
$a1= array (
  'category_name'=> $m->get_data('category_name'),
  'category_images'=> $m->get_data('category_images'),
  'menu_icon'=> $m->get_data('menu_icon')
);
   //echo "<pre>";print_r($a1);exit;
$q=$d->update("business_categories",$a1,"business_category_id='$business_category_id'");
if($q==TRUE) {
  $_SESSION['msg']=$category_name. " Business Category Updated";
  $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
  header("Location: ../mainCategories");
} else {
  header("Location: ../mainCategories");
}
}
if(isset($addSubCategory)) {
  $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
  $uploadedFile = $_FILES['sub_category_images']['tmp_name'];
  $ext = pathinfo($_FILES['sub_category_images']['name'], PATHINFO_EXTENSION);
  if(file_exists($uploadedFile)) {
    if(in_array($ext,$extension)) {
      $sourceProperties = getimagesize($uploadedFile);
      $newFileName = rand();
      $dirPath = "../../img/sub_category/";
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
                      imagepng($tmp,$dirPath. $newFileName. "_category.". $ext);
                      break;           
                      case IMAGETYPE_JPEG:
                      $imageSrc = imagecreatefromjpeg($uploadedFile); 
                      $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                      imagejpeg($tmp,$dirPath. $newFileName. "_category.". $ext);
                      break;
                      
                      case IMAGETYPE_GIF:
                      $imageSrc = imagecreatefromgif($uploadedFile); 
                      $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                      imagegif($tmp,$dirPath. $newFileName. "_category.". $ext);
                      break;
                      default:
                      $_SESSION['msg1']="Invalid Image";
                      header("Location: ../subCategories");
                      exit;
                      break;
                    }
                    $sub_category_images= $newFileName."_category.".$ext;
                  } else {
                    $_SESSION['msg1']="Invalid Photo";
                    header("location:../subCategories");
                    exit();
                  }
                } else {
                  $sub_category_images= "";
                }      
                $sub_category_name= ucfirst($sub_category_name);
                
                $m->set_data('business_category_id',$business_category_id);
                $m->set_data('sub_category_name',$sub_category_name);
                $m->set_data('sub_category_images',$sub_category_images);
                
                $a1= array (
                  'business_category_id'=> $m->get_data('business_category_id'),
                  'sub_category_name'=> $m->get_data('sub_category_name'),
                  'sub_category_images'=> $m->get_data('sub_category_images'),
                );
                $q=$d->insert("business_sub_categories",$a1);
                if($q==TRUE) {
                  $_SESSION['msg']=$sub_category_name. " Sub Category Added";
                  $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
                //3dec2020
                  $last_auto_id=$d->last_auto_id("business_sub_categories");
                  $res=mysqli_fetch_array($last_auto_id);
                  $business_sub_category_id=($res['Auto_increment']-1);
                  header("Location: ../manageSubCategory?business_sub_category_id=".$business_sub_category_id);
                //3dec2020
              //header("Location: ../subCategories");
                } else {
                  header("Location: ../subCategories");
                }
              }
              if(isset($editSubCategory)) {
                $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
                $uploadedFile = $_FILES['sub_category_images']['tmp_name'];
                $ext = pathinfo($_FILES['sub_category_images']['name'], PATHINFO_EXTENSION);
                if(file_exists($uploadedFile)) {
                  if(in_array($ext,$extension)) {
                    $sourceProperties = getimagesize($uploadedFile);
                    $newFileName = rand();
                    $dirPath = "../../img/sub_category/";
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
                      imagepng($tmp,$dirPath. $newFileName. "_category.". $ext);
                      break;           
                      case IMAGETYPE_JPEG:
                      $imageSrc = imagecreatefromjpeg($uploadedFile); 
                      $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                      imagejpeg($tmp,$dirPath. $newFileName. "_category.". $ext);
                      break;
                      
                      case IMAGETYPE_GIF:
                      $imageSrc = imagecreatefromgif($uploadedFile); 
                      $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                      imagegif($tmp,$dirPath. $newFileName. "_category.". $ext);
                      break;
                      default:
                      $_SESSION['msg1']="Invalid Image";
                      header("Location: ../subCategories");
                      exit;
                      break;
                    }
                    $sub_category_images= $newFileName."_category.".$ext;
                  } else {
                    $_SESSION['msg1']="Invalid Photo";
                    header("location:../subCategories");
                    exit();
                  }
                } else {
                  $sub_category_images= $sub_category_images_old;
                }      
                $sub_category_name= ucfirst($sub_category_name);
                
                if(isset($business_category_id)){
                  $m->set_data('business_category_id',$business_category_id);
                  $a1= array (
                    'business_category_id'=> $m->get_data('business_category_id') 
                  );
                  $q=$d->update("business_sub_categories",$a1,"business_sub_category_id='$business_sub_category_id'");
                }
                
                $m->set_data('sub_category_name',$sub_category_name);
                $m->set_data('sub_category_images',$sub_category_images);
                
                $a1= array (
                  
                  'sub_category_name'=> $m->get_data('sub_category_name'),
                  'sub_category_images'=> $m->get_data('sub_category_images'),
                );
                $q=$d->update("business_sub_categories",$a1,"business_sub_category_id='$business_sub_category_id'");
                if($q==TRUE) {
                  $_SESSION['msg']=$sub_category_name." Sub Category Updated";
                  $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
                  header("Location: ../subCategories");
                } else {
                  header("Location: ../subCategories");
                }
              }
              if(isset($manageCategory)){
               $q2=$d->select("business_sub_ctagory_relation_master","business_sub_category_id ='$business_sub_category_id_val'");
               if(mysqli_num_rows($q2)>0) {
                $q=$d->delete("business_sub_ctagory_relation_master","business_sub_category_id='$business_sub_category_id_val'");
              }
              for ($i=0; $i < count($_POST['business_sub_category_id']) ; $i++) { 
                $a1= array (
                  'related_sub_category_id'=> $_POST['business_sub_category_id'][$i],
                  'business_sub_category_id'=> $business_sub_category_id_val,
                  'created_at'=> date("Y-m-d H:i:s")
                );
                $q=$d->insert("business_sub_ctagory_relation_master",$a1);
              }
              if($q==TRUE) {
               $adm_data=$d->selectRow("sub_category_name","business_sub_categories"," business_sub_category_id='$business_sub_category_id_val'");
               $data_q=mysqli_fetch_array($adm_data);
               $_SESSION['msg']=$data_q['sub_category_name']." Related Sub Category Updated";
               $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
               header("Location: ../subCategories");
             } else {
              header("Location: ../subCategories");
            }
          }
          //21jan21
          if(isset($manageCategory2)){
           $q2=$d->select("business_sub_ctagory_relation_master","business_sub_category_id ='$business_sub_category_id_val'");
           if(mysqli_num_rows($q2)>0) {
            $q=$d->delete("business_sub_ctagory_relation_master","business_sub_category_id='$business_sub_category_id_val'");
          }
          if(isset($_POST['business_category_id']) && !empty($_POST['business_category_id'])){
            if(empty($business_category_id)){
              $business_category_id = array('0');
            }
            $business_category_id = implode(",", $_POST['business_category_id']);
            
            $business_sub_categories=$d->select(" business_sub_categories ","  business_category_id in ($business_category_id) and  business_sub_categories.sub_category_status = 0    ");
            while ($business_sub_categories_data=mysqli_fetch_array($business_sub_categories)) {
              $a1= array (
                'related_sub_category_id'=> $business_sub_categories_data['business_sub_category_id'],
                'business_sub_category_id'=> $business_sub_category_id_val,
                'whole_main_category_id' =>$business_sub_categories_data['business_category_id'],
                'created_at'=> date("Y-m-d H:i:s")
              );
              $q=$d->insert("business_sub_ctagory_relation_master",$a1);
            }
          }
      /*echo "<pre>";print_r($_POST);
          print_r($business_category_id);exit;
                 for ($i=0; $i < count($_POST['business_sub_category_id']) ; $i++) { 
                  $a1= array (
                         
                          'related_sub_category_id'=> $_POST['business_sub_category_id'][$i],
                          'business_sub_category_id'=> $business_sub_category_id_val,
                          'created_at'=> date("Y-m-d H:i:s")
                      );
                $q=$d->insert("business_sub_ctagory_relation_master",$a1);
              }*/
              if($q==TRUE) {
               $adm_data=$d->selectRow("sub_category_name","business_sub_categories"," business_sub_category_id='$business_sub_category_id_val'");
               
               $data_q=mysqli_fetch_array($adm_data);
               $_SESSION['msg']=$data_q['sub_category_name']." Related Sub Category Updated";
               $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
               header("Location: ../subCategories");
             } else {
              header("Location: ../subCategories");
            }
          }
              //21jan21
              //22jan21
          if(isset($manageMainSubCategory)){
           if(isset($_POST['business_category_id_val'])){
           // $business_category_id_val = implode(",", $_POST['business_category_id_val']);
            $con -> autocommit(FALSE);
            $business_sub_categories2=$d->select(" business_sub_categories ","  business_category_id  = $business_category_id_val  and  business_sub_categories.sub_category_status = 0    ");
            $business_sub_category_id_array  = array('0');
            while ($business_sub_categories_data2=mysqli_fetch_array($business_sub_categories2)) {
              $business_sub_category_id_array[] = $business_sub_categories_data2['business_sub_category_id'];
            }
            
            $business_sub_category_id_array = implode(",", $business_sub_category_id_array);
            $q2=$d->select("business_sub_ctagory_relation_master","business_sub_category_id in ($business_sub_category_id_array) ");
            if(mysqli_num_rows($q2)>0) {
              $q=$d->delete("business_sub_ctagory_relation_master","business_sub_category_id in ($business_sub_category_id_array) ");
            }
            $business_sub_categories=$d->select(" business_sub_categories ","  business_category_id  = $business_category_id_val  and  business_sub_categories.sub_category_status = 0    ");
            while ($business_sub_categories_data=mysqli_fetch_array($business_sub_categories)) {
             for ($p=0; $p < count($_POST['business_sub_category_id']) ; $p++) { 
               $a1= array (
                'related_sub_category_id'=> $_POST['business_sub_category_id'][$p],
                'business_sub_category_id'=> $business_sub_categories_data['business_sub_category_id'] ,
                'whole_sub_category_id' =>$_POST['business_sub_category_id'][$p],
                'whole_main_sub_cat_id' =>$business_category_id_val,
                'created_at'=> date("Y-m-d H:i:s")
              );
               $q=$d->insert("business_sub_ctagory_relation_master",$a1);
             }
           }
         }
         if($q==TRUE) {
           $con -> commit();
           $adm_data=$d->selectRow("category_name","business_categories"," business_category_id='$business_category_id_val'");
           
           $data_q=mysqli_fetch_array($adm_data);
           $_SESSION['msg']=$data_q['category_name']." Related Sub Category Updated";
           $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
           header("Location: ../mainCategories");
         } else {
          header("Location: ../mainCategories");
        }
      }
      if(isset($manageMainMainCategory2)){
      //echo "<pre>";print_r($_POST);exit;
        //&& !empty($_POST['business_category_id'])
       if(isset($_POST['business_category_id_val']) ){
             // $business_category_id_val = implode(",", $_POST['business_category_id_val']);
        $con -> autocommit(FALSE);
        $business_sub_categories2=$d->select(" business_sub_categories ","  business_category_id  = $business_category_id_val  and  business_sub_categories.sub_category_status = 0    ");
        $business_sub_category_id_array  = array('0');
        while ($business_sub_categories_data2=mysqli_fetch_array($business_sub_categories2)) {
          $business_sub_category_id_array[] = $business_sub_categories_data2['business_sub_category_id'];
        }
        $business_sub_category_id_array = implode(",", $business_sub_category_id_array);
        $q2=$d->select("business_sub_ctagory_relation_master","business_sub_category_id in ($business_sub_category_id_array) ");
        if(mysqli_num_rows($q2)>0) {
          $q=$d->delete("business_sub_ctagory_relation_master","business_sub_category_id in ($business_sub_category_id_array) ");
        }
        $business_sub_categories_q=$d->select(" business_sub_categories ","  business_category_id  = '$business_category_id_val'  and  business_sub_categories.sub_category_status = 0    ");
        $dataArray = array();
        $counter = 0 ;
        foreach ($business_sub_categories_q as  $value) {
          foreach ($value as $key => $valueNew) {
            $dataArray[$counter][$key] = $valueNew;
          }
          $counter++;
        }
        
        $business_category_id_new = implode(",", $_POST['business_category_id']);
        if(empty($business_category_id_new)){
          $business_category_id_new = 0;
        }
        $business_sub_categories2=$d->select(" business_sub_categories ","  business_category_id  in  ($business_category_id_new)  and  business_sub_categories.sub_category_status = 0    ");
        
        
        $dataArray2 = array();
        $counter2 = 0 ;
        foreach ($business_sub_categories2 as  $value) {
          foreach ($value as $key => $valueNew) {
            $dataArray2[$counter2][$key] = $valueNew;
          }
          $counter2++;
        }
        $data_array = array();
        for ($b=0; $b < count($dataArray2) ; $b++) {
          $data_array[$dataArray2[$b]['business_category_id']][] = $dataArray2[$b];
        }
        
        for ($p=0; $p < count($_POST['business_category_id']) ; $p++) { 
         for ($l=0; $l < count($dataArray) ; $l++) {
           
           
           $dataA = $data_array[$_POST['business_category_id'][$p]];
           
           for ($v=0; $v < count($dataA) ; $v++) {
            
             $a1= array (
               'business_sub_category_id'=>$dataArray[$l]['business_sub_category_id'] ,
               'related_sub_category_id'=> $dataA[$v]['business_sub_category_id'],
               
               'whole_sub_category_id' => $dataA[$v]['business_sub_category_id'],
               'whole_main_sub_cat_id' =>$_POST['business_category_id'][$p],
               'main_cat_id' =>$business_category_id_val, 
               'created_at'=> date("Y-m-d H:i:s")
             );
             $q=$d->insert("business_sub_ctagory_relation_master",$a1);
           }
         }
       }
       
       
     }
     
     if($q==TRUE) {
       $con -> commit();
       $adm_data=$d->selectRow("category_name","business_categories"," business_category_id='$business_category_id_val'");
       $data_q=mysqli_fetch_array($adm_data);
       $_SESSION['msg']=$data_q['category_name']." Related Sub Category Updated";
       $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
       header("Location: ../mainCategories");
     } else {
      header("Location: ../mainCategories");
    }
  }
                //22jan21
}
?>