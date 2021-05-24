<?php 
include '../common/objectController.php';
// print_r($_POST);
if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{
  // add main menu


//front timeline delete start
  if(isset($feed_id_delete_new)) {
   $qqq=$d->select("timeline_photos_master","timeline_id='$feed_id_delete_new' ");
  
   while($iData=mysqli_fetch_array($qqq)) { 
    $abspath=$_SERVER['DOCUMENT_ROOT'];
    $path = $abspath."/img/users/recident_feed/".$iData['photo_name'];
    unlink($path);

    $abspath=$_SERVER['DOCUMENT_ROOT'];
    $path = $abspath."/img/timeline/".$iData['photo_name'];
    unlink($path);

    
  }

 
 $adm_data=$d->selectRow("timeline_text","timeline_master"," timeline_id='$feed_id_delete_new'");
        $data_q=mysqli_fetch_array($adm_data);

  $q=$d->delete("timeline_master","timeline_id='$feed_id_delete_new' ");
  $q=$d->delete("timeline_photos_master","timeline_id='$feed_id_delete_new' ");
  $q=$d->delete("timeline_comments","timeline_id='$feed_id_delete_new'");
  $q=$d->delete("timeline_like_master","timeline_id='$feed_id_delete_new'");
  
  $q=$d->delete("timeline_like_master","timeline_id='$feed_id_delete_new'");

  $q=$d->delete("user_notification"," notification_action ='timeline' and timeline_id='$feed_id_delete_new'");
   
  if($q>0) {
       
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id_new]","Mihir Mehta",$data_q['timeline_text']." News Feed Deleted- From Front");
    echo 1;
  } else {
    echo 0;
  }
}
//front timeline delete end


  if(isset($feed_id_delete)) {
   $qqq=$d->select("timeline_photos_master","timeline_id='$feed_id_delete' ");
  
   while($iData=mysqli_fetch_array($qqq)) { 
    $abspath=$_SERVER['DOCUMENT_ROOT'];
    $path = $abspath."/img/users/recident_feed/".$iData['photo_name'];
    unlink($path);

    $abspath=$_SERVER['DOCUMENT_ROOT'];
    $path = $abspath."/img/timeline/".$iData['photo_name'];
    unlink($path);


  }

 
 $adm_data=$d->selectRow("timeline_text","timeline_master"," timeline_id='$feed_id_delete'");
        $data_q=mysqli_fetch_array($adm_data);

  $q=$d->delete("timeline_master","timeline_id='$feed_id_delete' ");
  $q=$d->delete("timeline_photos_master","timeline_id='$feed_id_delete' ");
  $q=$d->delete("timeline_comments","timeline_id='$feed_id_delete'");
  $q=$d->delete("timeline_like_master","timeline_id='$feed_id_delete'");
  
  $q=$d->delete("timeline_like_master","timeline_id='$feed_id_delete'");

  $q=$d->delete("user_notification"," notification_action ='timeline' and timeline_id='$feed_id_delete'");
   
  if($q>0) {
        // $abspath=$_SERVER['DOCUMENT_ROOT'];
        // $path = $abspath."/fincasys/img/users/recident_feed/feed2019_08_1310141930.png";
        // unlink($path);
   // $_SESSION['msg'] = $data_q['timeline_text']." News Feed Deleted";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$data_q['timeline_text']." News Feed Deleted");
    echo 1;
  } else {
    echo 0;
  }
}


if(isset($comments_id_delete)) {
 $adm_data=$d->selectRow("*","timeline_comments"," comments_id='$comments_id_delete'");
 $data_q=mysqli_fetch_array($adm_data);



 $q=$d->delete("timeline_comments","comments_id='$comments_id_delete' ");

 if($q>0) {
$other_user_id = $data_q['user_id'];
$other_timeline_id = $data_q['timeline_id'];
$msg = $data_q['msg'];
 
  $user_notification=$d->delete("user_notification"," other_user_id ='$other_user_id' and timeline_id='$other_timeline_id' and notification_desc like '%".$msg."%'");


   //  $_SESSION['msg'] = $data_q['msg']." Timeline Comment Deleted";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$data_q['msg']." Timeline Comment Deleted");
  echo 1;
} else {
  echo 0;
}
}

if (isset($addFeed)) {

  $uploadedFile = $_FILES['image']['tmp_name']; 
  if(file_exists($uploadedFile)) {
    $sourceProperties = getimagesize($uploadedFile);
    $newFileName = time();
    $dirPath = "../../img/timeline/";
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageType = $sourceProperties[2];
    $imageHeight = $sourceProperties[1];
    $imageWidth = $sourceProperties[0];

        // less 30 % size 
    if ($imageWidth>1200) {
            $newWidthPercentage= 1200*100 / $imageWidth;  //for maximum 400 widht
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
            imagepng($tmp,$dirPath. $newFileName. "_feed.". $ext);
            break;           

            case IMAGETYPE_JPEG:
            $imageSrc = imagecreatefromjpeg($uploadedFile); 
            $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
            imagejpeg($tmp,$dirPath. $newFileName. "_feed.". $ext);
            break;
            
            case IMAGETYPE_GIF:
            $imageSrc = imagecreatefromgif($uploadedFile); 
            $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
            imagegif($tmp,$dirPath. $newFileName. "_feed.". $ext);
            break;

            default:
          //  echo "Invalid Image type.";
              $_SESSION['msg1']="Invalid Image type.";
         header("Location: ../timeline");
            exit;
            break;
          }
          $feed_img= $newFileName."_feed.".$ext;
          $feedType=1;
          $notiImg= $base_url.'img/timeline/'.$feed_img;
        // move_uploaded_file($uploadedFile, $dirPath. $newFileName. ".". $ext);
        }else {
          $feed_img= '';
          $feedType=0;
          $notiImg="";
        }

        $feed_msg = addslashes($feed_msg) ;
          $feed_msg = stripslashes(  html_entity_decode($feed_msg));


        $m->set_data('admin_id',$_SESSION['zoobiz_admin_id']);
        $m->set_data('feed_type',$feedType);
        $m->set_data('feed_msg',$feed_msg);
        $m->set_data('send_notification_to_user',$send_notification_to_user);

        $m->set_data('user_id',0);
        $m->set_data('modify_date',date('Y-m-d H:i:s'));

        $aMain = array(
           'admin_id'=>$m->get_data('admin_id'),
          'feed_type'=>$m->get_data('feed_type'),
          'timeline_text'=>$m->get_data('feed_msg'),
          'send_notification_to_user'=>$m->get_data('send_notification_to_user'),
          'user_id'=>$m->get_data('user_id'),
          'created_date'=>$m->get_data('modify_date'),
        );

       
//8march21
      /*  $last_auto_id=$d->last_auto_id("timeline_master");
        $res=mysqli_fetch_array($last_auto_id);
        $timeline_id=$res['Auto_increment'];*/

        $q=$d->insert("timeline_master",$aMain);
$timeline_id  = $con->insert_id;  
        if($q==TRUE) {
         

         $fcmArray=$d->get_android_fcm("users_master","user_token!='' AND lower(device)='android' and timeline_alert=0");
         $fcmArrayIos=$d->get_android_fcm("users_master","user_token!='' AND lower(device)='ios' and timeline_alert=0 ");

         //8march21
          /*$last_auto_id=$d->last_auto_id("timeline_master");
          $res=mysqli_fetch_array($last_auto_id);
          $new_timeline_id=$res['Auto_increment'];
          $new_timeline_id = ($new_timeline_id-1);*/
$new_timeline_id  = $timeline_id;  
            if ($feed_img!='') {
            # code...
           $a111 = array(
             
              'user_id'=>"0",
              'photo_name'=>$feed_img,
               'feed_img_height'=>$newImageHeight,
              'feed_img_width'=>$newImageWidth,
              'timeline_id' => $new_timeline_id
           );
            $d->insert("timeline_photos_master",$a111);
          }


//9dec2020
if($send_notification_to_user==1){ 
         $d->insertAllUserNotificationTimeline("ZooBiz",$feed_msg,"timeline",'',"active_status=0  and timeline_alert=0 ",'1',$new_timeline_id);

         

         $profile_u ="https://zoobiz.in/img/fav.png";
         $nResident->noti("timeline",$notiImg,0,$fcmArray,"ZooBiz",$feed_msg,$new_timeline_id,0,$profile_u);
         $nResident->noti_ios("timeline",$notiImg,0,$fcmArrayIos,"ZooBiz",$feed_msg,$new_timeline_id,0,$profile_u);
}
//9dec2020
         $_SESSION['msg']=$feed_msg. " new post added"; 
         $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
         header("Location: ../timeline");
       } else {
        header("Location: ../timeline");
      }

    }

//IS_248
    if (isset($addComment)) {
      $user_name = "ZooBiz";
      $block_name = "Admin";
      $users_master_qry=$d->select("users_master, floors_master , block_master "," users_master.block_id = block_master.block_id and users_master.floor_id = floors_master.floor_id and   users_master.user_id=".$user_id,""); 
      if(mysqli_num_rows($users_master_qry)>0){
       while($users_master_data=mysqli_fetch_array($users_master_qry)) {
        $user_name = $users_master_data['user_full_name'];
        $block_name = $users_master_data['block_name'].'-'.$users_master_data['unit_type'];
      }
    } else {
     $users_master_qry=$d->select("bms_admin_master ","  admin_id=".$user_id,""); 
     while($users_master_data=mysqli_fetch_array($users_master_qry)) {

       $user_name = $users_master_data['admin_name'];

     }
   }


   $m->set_data('society_id',$society_id);
   $m->set_data('feed_id',$feed_id);
   $m->set_data('msg',$msg);
   $m->set_data('user_id',$user_id);
   $m->set_data('user_name',$user_name);
   $m->set_data('block_name',$block_name);
   $m->set_data('modify_date',date('Y-m-d H:i:s'));

   $a1 = array(
    'society_id'=>$m->get_data('society_id'),
    'feed_id'=>$m->get_data('feed_id'),
    'msg'=>$m->get_data('msg'), 
    'user_id'=>$m->get_data('user_id'),
    'user_name'=>$m->get_data('user_name'),
    'block_name'=>$m->get_data('block_name'),
    'modify_date'=>$m->get_data('modify_date'),
  );

   $q=$d->insert("news_comments",$a1);

   if($q==TRUE) {

     $news_feed_qry=$d->select("news_feed"," feed_id=".$feed_id,""); 
     while($news_feed_data=mysqli_fetch_array($news_feed_qry)) {
      $feed_user_id = $news_feed_data['user_id'];
    }


    $fcmArray=$d->get_android_fcm("users_master"," user_token!='' AND lower(device)='android' and timeline_alert=0 and user_id=".$user_id);
$fcmArrayIos=$d->get_android_fcm("users_master"," user_token!='' AND lower(device)='ios' and timeline_alert=0  and user_id=".$user_id);


    $nResident->noti("$notiImg",$society_id,$fcmArray,"ZooBiz",$feed_msg,'announcement');
    $nResident->noti_ios("$notiImg",$society_id,$fcmArrayIos,"ZooBiz",$feed_msg,'announcement');


    $_SESSION['msg']=$msg. " New Comment Added";
    $d->insert_log("","$society_id","$_SESSION[bms_admin_id]","$created_by","New Comment Added by ".$user_name);
    header("Location: ../newsFeed");
  } else {
    header("Location: ../newsFeed");
  }

}
if (isset($likeVar)) {
  $user_name = "ZooBiz";
  $block_name = "Admin";


  if($likeVar=="unlike"){


   $q2 = $d->delete("news_like","society_id='$society_id' and feed_id='$feed_id' and user_id='$user_id'  ");
   if($q2==TRUE) {
    $_SESSION['msg']="Comment Unliked Successfully ";
    $d->insert_log("","$society_id","$_SESSION[bms_admin_id]","$created_by",$_SESSION['msg']);
    header("Location: ../newsFeed");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("Location: ../newsFeed");
  }


 

} else { 


  $users_master_qry=$d->select("users_master, floors_master , block_master "," users_master.block_id = block_master.block_id and users_master.floor_id = floors_master.floor_id and   users_master.user_id=".$user_id,""); 
  if(mysqli_num_rows($users_master_qry)>0){
   while($users_master_data=mysqli_fetch_array($users_master_qry)) {
    $user_name = $users_master_data['user_full_name'];
    $block_name = $users_master_data['block_name'].'-'.$users_master_data['unit_type'];
  }
} else {
 $users_master_qry=$d->select("bms_admin_master ","  admin_id=".$user_id,""); 
 while($users_master_data=mysqli_fetch_array($users_master_qry)) {

   $user_name = $users_master_data['admin_name'];

 }
}


$m->set_data('society_id',$society_id);
$m->set_data('feed_id',$feed_id); 
$m->set_data('user_id',$user_id);
$m->set_data('user_name',$user_name);
$m->set_data('block_name',$block_name);
$m->set_data('modify_date',date('Y-m-d H:i:s'));

$a1 = array(
  'society_id'=>$m->get_data('society_id'),
  'feed_id'=>$m->get_data('feed_id'),

  'user_id'=>$m->get_data('user_id'),
  'user_name'=>$m->get_data('user_name'),
  'block_name'=>$m->get_data('block_name'),
  'modify_date'=>$m->get_data('modify_date'),
);

$q=$d->insert("news_like",$a1);

if($q==TRUE) {

 $news_feed_qry=$d->select("news_feed"," feed_id=".$feed_id,""); 
 while($news_feed_data=mysqli_fetch_array($news_feed_qry)) {
  $feed_user_id = $news_feed_data['user_id'];
}


$fcmArray=$d->get_android_fcm("users_master"," user_token!='' AND lower(device)='android' and timeline_alert=0 and user_id=".$user_id);
$fcmArrayIos=$d->get_android_fcm("users_master"," user_token!='' AND lower(device)='ios' and timeline_alert=0 and user_id=".$user_id);

$nResident->noti("$notiImg",$society_id,$fcmArray,"ZooBiz",$feed_msg,'announcement');
$nResident->noti_ios("$notiImg",$society_id,$fcmArrayIos,"ZooBiz",$feed_msg,'announcement');


$_SESSION['msg']="Liked Successfully";
$d->insert_log("","$society_id","$_SESSION[bms_admin_id]","$created_by","Liked Successfully by ".$user_name);
header("Location: ../newsFeed");
} else {
  header("Location: ../newsFeed");
}
}

}
//IS_248

}
else{
  header('location:../');
}
?>
