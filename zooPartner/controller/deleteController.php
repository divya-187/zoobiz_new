<?php 
session_start();
date_default_timezone_set('Asia/Calcutta');
$url=$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
$activePage = basename($_SERVER['PHP_SELF'], ".php");
include_once '../lib/dao.php';
include '../lib/model.php';
include_once '../fcm_file/user_fcm.php';
$d = new dao();
$m = new model();
$nResident = new firebase_resident();

$created_by=$_SESSION['full_name'];
$updated_by=$_SESSION['full_name'];
$society_id=$_SESSION['society_id'];
extract($_POST);

if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{


//8may21
if($_POST['deleteValue']=="deleteKeywords") {
    $idCount = count($ids);
    for ($i=0; $i <$idCount ; $i++) { 
     $gu=$d->select("sub_category_keywords_master","sub_category_keywords_id='$ids[$i]' ");
     $NewData=mysqli_fetch_array($gu);

$business_sub_category_id = $NewData['business_sub_category_id'];
     $cat_qry=$d->selectRow("category_name, sub_category_name","business_sub_categories,business_categories","business_categories.business_category_id=business_sub_categories.business_category_id and  business_sub_categories.business_sub_category_id = $business_sub_category_id  ","");
 $cat_data=mysqli_fetch_array($cat_qry);


       $q=$d->delete("sub_category_keywords_master","sub_category_keywords_id ='$ids[$i]'");
       $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by",$NewData['sub_category_keyword']." Keyword Deleted for ".html_entity_decode($cat_data['sub_category_name']).' - '. html_entity_decode($cat_data['category_name']));
    }
      if($q>0) {
        echo 1;
         

      } else {
        echo 0;
        
      }
  }
//8may21

if($_POST['deleteValue']=="deleteSubscribe") {
    $idCount = count($ids);
    for ($i=0; $i <$idCount ; $i++) { 
     $gu=$d->select("subscribe_master","subscribe_id='$ids[$i]' ");
     $NewData=mysqli_fetch_array($gu);
       $q=$d->delete("subscribe_master","subscribe_id ='$ids[$i]'");
       $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by",$NewData['email']." Subscriber Deleted");
    }
      if($q>0) {
        echo 1;
        
        $_SESSION['msg']="Subscribers Deleted."; 

      } else {
        echo 0;
        $_SESSION['msg1']="Something Wrong"; 
      }
  }

//26april21
if($_POST['deleteValue']=="deleteHideNumber") {
     
    $idCount = count($ids);
    for ($i=0; $i <$idCount ; $i++) { 
     $a = array(
            'status' => 1,
          );
       $q=$d->update("hide_number_master",$a,"id ='$ids[$i]'");
    }
      if($q>0) {
        echo 1;
        $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by"," Hide Registration Number Deleted");
        $_SESSION['msg']="Hide Registration Number Deleted"; 

      } else {
        echo 0;
        $_SESSION['msg1']="Something Wrong"; 
      }
  
  }
//26april21
//16feb21
  if($_POST['deleteValue']=="deleteInterest") {
    $idCount = count($ids);
    for ($i=0; $i <$idCount ; $i++) { 
     $a = array(
            'status' => 1,
          );
       $q=$d->update("interest_master",$a,"interest_id ='$ids[$i]'");
    }
      if($q>0) {
        echo 1;
        $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by","Interests Deleted");
        $_SESSION['msg']="Interests Deleted."; 

      } else {
        echo 0;
        $_SESSION['msg1']="Something Wrong"; 
      }
  }
  //16feb21
  //22sept2020
  if($_POST['deleteValue']=="deleteAdminNotification") {
    $idCount = count($ids);
    for ($i=0; $i <$idCount ; $i++) { 
      $q=$d->delete("admin_notification","notification_id='$ids[$i]'");
    }
      if($q>0) {
        echo 1;
        $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by","Notification  Deleted");
        $_SESSION['msg']="Notification  Deleted."; 

      } else {
        echo 0;
        $_SESSION['msg1']="Something Wrong"; 
      }
  }
//22sept2020

  if($_POST['deleteValue']=="deleteFeedback") {
    $idCount = count($ids);

   
    for ($i=0; $i <$idCount ; $i++) { 
      $q=$d->delete("feedback_master","feedback_id='$ids[$i]' ");
    }
    //18march2020
      if($q>0) {
        echo 1;
        $_SESSION['msg']="Feedback  Deleted.";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by","Feedback Deleted");
        // header("location:../categories");
      } else {
        echo 0;
        $_SESSION['msg1']="Something Wrong";
        // header("location:../categories");
      }
  } 
  
  if($_POST['deleteValue']=="deleteClassifieds") {
    $idCount = count($ids);
    for ($i=0; $i <$idCount ; $i++) { 

//delete images
     $gu=$d->select("cllassifieds_master","cllassified_id='$ids[$i]' ");
     $NewData=mysqli_fetch_array($gu);
     $abspath=$_SERVER['DOCUMENT_ROOT'];
     $path_cllassified_photo = $abspath."/img/cllassified/".$NewData['cllassified_photo'];
     unlink($path_cllassified_photo);
//delete images

      $q=$d->delete("cllassifieds_master","cllassified_id='$ids[$i]'");
      $q=$d->delete("cllassified_comment","cllassified_id='$ids[$i]'");
      $q=$d->delete("cllassifieds_city_master","cllassified_id='$ids[$i]'");
    }
      if($q>0) {
        echo 1;
        $_SESSION['msg']="Classified  Deleted."; 
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by","Classified  Deleted");
      } else {
        echo 0;
        $_SESSION['msg1']="Something Wrong"; 
      }
  }


//delete images
  if($_POST['deleteValue']=="deleteFrmImg") {
    $idCount = count($ids);
    for ($i=0; $i <$idCount ; $i++) { 
      $q=$d->delete("promotion_frame_master","promotion_frame_id='$ids[$i]'");
       
    }
      if($q>0) {
        echo 1;
        $_SESSION['msg']="Frame Image Deleted."; 
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      } else {
        echo 0;
        $_SESSION['msg1']="Something Wrong"; 
      }
  }
  if($_POST['deleteValue']=="deleteCenterImg") {
    $idCount = count($ids);
    for ($i=0; $i <$idCount ; $i++) { 
      $q=$d->delete("promotion_center_image_master","promotion_center_image_id='$ids[$i]'");
       
    }
      if($q>0) {
        echo 1;
        $_SESSION['msg']="Center Image Deleted."; 
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      } else {
        echo 0;
        $_SESSION['msg1']="Something Wrong"; 
      }
  }
//delete images

  if($_POST['deleteValue']=="deletePackage") {
    $idCount = count($ids);
    $pack_name = array();
    for ($i=0; $i <$idCount ; $i++) { 
       $adm_data=$d->selectRow("package_name","package_master"," package_id='$ids[$i]'");
        $data_q=mysqli_fetch_array($adm_data);
        $pack_name[] = $data_q['package_name'];

       $q=$d->delete("package_master","package_id ='$ids[$i]'");
    }
      if($q>0) {
        echo 1;
        $pack_name = implode(", ", $pack_name);
        $_SESSION['msg']= $pack_name." Package(s)  Deleted.";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        // header("location:../categories");
      } else {
        echo 0;
        $_SESSION['msg1']="Something Wrong";
        // header("location:../categories");
      }
  }

  if($_POST['deleteValue']=="deleteCategory") {
    $idCount = count($ids);
    $cat_name = array();
    for ($i=0; $i <$idCount ; $i++) { 

       $adm_data=$d->selectRow("category_name","business_categories"," business_category_id='$ids[$i]'");
        $data_q=mysqli_fetch_array($adm_data);
        $cat_name[] = $data_q['category_name'];

          $a = array(
            'category_status' => 1,
          );
       $q=$d->update("business_categories",$a,"business_category_id ='$ids[$i]'");
    }
      if($q>0) {
        echo 1;
         $cat_name = implode(", ",  $cat_name);
        $_SESSION['msg']=$cat_name." Category/Categories  Deleted.";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        // header("location:../categories");
      } else {
        echo 0;
        $_SESSION['msg1']="Something Wrong";
        // header("location:../categories");
      }
  }

  if($_POST['deleteValue']=="deleteSubCategory") {
    $idCount = count($ids);
    $sub_cat_name = array();
    for ($i=0; $i <$idCount ; $i++) { 
       $adm_data=$d->selectRow("sub_category_name","business_sub_categories"," business_category_id='$ids[$i]'");
        $data_q=mysqli_fetch_array($adm_data);
        $sub_cat_name[] = $data_q['sub_category_name'];

          $a = array(
            'sub_category_status' => 1,
          );
       $q=$d->delete("business_sub_categories","business_sub_category_id ='$ids[$i]'");
       // $q=$d->update("business_sub_categories",$a,"business_sub_category_id ='$ids[$i]'");
    }
      if($q>0) {
        echo 1;
         $sub_cat_name = implode(", ",  $sub_cat_name);
        $_SESSION['msg']=$sub_cat_name. " Sub Category/Categories Deleted.";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        // header("location:../categories");
      } else {
        echo 0;
        $_SESSION['msg1']="Something Wrong";
        // header("location:../categories");
      }
  }

  if($_POST['deleteValue']=="deleteUser") {
    $idCount = count($ids);
    for ($i=0; $i <$idCount ; $i++) { 
      $q=$d->delete("students","studentId='$ids[$i]'");
    }
      if($q>0) {
        echo 1;
        $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by","User Deleted");
        $_SESSION['msg']="User Deleted.";
        // header("location:../categories");
      } else {
        echo 0;
        $_SESSION['msg1']="Something Wrong";
        // header("location:../categories");
      }
  }

 

  if($_POST['deleteValue']=="deleteSessionlog") {
    $idCount = count($ids);
    $a = array(
            'status' => 1,
            'update_by_admin_id' =>$_SESSION['zoobiz_admin_id'],
            'update_date'=> date("Y-m-d H:i:s")
          );
    for ($i=0; $i <$idCount ; $i++) { 
      //$q=$d->delete("session_log","sessionId='$ids[$i]'");
      $q=$d->update("session_log",$a,"sessionId='$ids[$i]'");
    }
      if($q>0) {
        echo 1;
        $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by","Session Log Deleted");
        $_SESSION['msg']="Session Log Deleted.";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by","Session Deleted");
        // header("location:../categories");
      } else {
        echo 0;
        $_SESSION['msg1']="Something Wrong";
        // header("location:../categories");
      }
  }


 if($_POST['deleteValue']=="deleteOtherlog") {
    $idCount = count($ids);
    for ($i=0; $i <$idCount ; $i++) { 
      $q=$d->delete("log_master","log_id='$ids[$i]'");
    }
      if($q>0) {
        echo 1;
        $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by","Other Log Deleted");
        $_SESSION['msg']="Other Log Deleted.";
        
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by","Other Log Deleted");
        // header("location:../categories");
      } else {
        echo 0;
        $_SESSION['msg1']="Something Wrong";
        // header("location:../categories");
      }
  }
  


  if($_POST['deleteValue']=="deleteNotification") {
    $idCount = count($ids);
    for ($i=0; $i <$idCount ; $i++) { 
      $q=$d->delete("notifcation_master","notification_id='$ids[$i]'");
    }
      if($q>0) {
        echo 1;
        $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by","Notification Deleted");
        $_SESSION['msg']="Notification Deleted.";
        // header("location:../categories");
      } else {
        echo 0;
        $_SESSION['msg1']="Something Wrong";
        // header("location:../categories");
      }
  }

 

}
else{
  header('location:../logout');
}
 ?>
