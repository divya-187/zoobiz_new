<?php 
 session_start();
date_default_timezone_set('Asia/Calcutta');
$url=$_SESSION['url'] ; 
$activePage = basename($_SERVER['PHP_SELF'], ".php");
include_once '../lib/dao.php';
include '../lib/model.php';
include '../fcm_file/user_fcm.php';
$d = new dao();
$m = new model();
$nResident = new firebase_resident();
$con=$d->dbCon();
$created_by=$_SESSION['full_name'];
$updated_by=$_SESSION['full_name'];
extract($_POST);
$base_url=$m->base_url();
if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{

   if(isset($circular_id_delete)) {
   
   //IS_1001
     $adm_data=$d->selectRow("circular_title","circulars_master"," circular_id='$circular_id_delete'");
        $data_q=mysqli_fetch_array($adm_data);

    $q=$d->delete("circulars_master","circular_id='$circular_id_delete' ");
    if($q==TRUE) {
      $_SESSION['msg']=$data_q['circular_title']." Circular Deleted";
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("Location: ../manageCirculars");
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("Location: ../Updated");
    }
  }


  if(isset($addNotice)) {
    

    $m->set_data('circular_description',htmlspecialchars($circular_description));
    $m->set_data('circular_title',htmlspecialchars($circular_title));
	$m->set_data('notice_time',date('Y-m-d H:i:s'));
  $m->set_data('updated_at',date('Y-m-d H:i:s'));
 
	 $a1= array (
	    'circular_description'=> $m->get_data('circular_description'),
	    'circular_title'=> $m->get_data('circular_title'),
	    'created_date'=> $m->get_data('notice_time'),
      'updated_at'=> $m->get_data('updated_at')
	  );

//17SEPT2020
              /*$notiAry = array(
              'user_id'=>0,
              'notification_title'=>'Circular',
              'notification_desc'=>"Added By Admin $created_by",    
              'notification_date'=>date('Y-m-d H:i'),
              'notification_action'=>'circulars',
              'notification_logo'=>'menu_circular.png',
              );
              $d->insert("user_notification",$notiAry);
*/
           
 $title= "Circular" ;
          $description='"'.$circular_title.'" '. "Added By Admin $created_by";

          $d->insertAllUserNotification($title,$description,"circulars",'','');
            
//17SEPT2020
         $fcmArray=$d->get_android_fcm("users_master","user_token!='' AND  lower(device)='android'  ");
         $fcmArrayIos=$d->get_android_fcm("users_master","user_token!='' AND  lower(device) ='ios'   ");
       $nResident->noti("circulars","",0,$fcmArray,"Circular",'"'.$circular_title.'" '."Added By $created_by",'circulars');
         $nResident->noti_ios("circulars","",0,$fcmArrayIos,"Circular",'"'.$circular_title.'" '."Added By $created_by",'circulars');

       
        $q=$d->insert("circulars_master",$a1);
    if($q==TRUE) {
      $_SESSION['msg']=$circular_title." Circular Added";
      //IS_1210
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("Location: ../manageCirculars");
    } else {
      header("Location: ../manageCirculars");
    }
  }



  if(isset($updateNotice)) {
   
   

   $m->set_data('circular_description',htmlspecialchars($circular_description));
    $m->set_data('circular_title',htmlspecialchars($circular_title));
	 //  $m->set_data('notice_time',date('Y-m-d H:i:s'));

  $m->set_data('updated_at',date('Y-m-d H:i:s'));
	 $a1= array (
	    'circular_description'=> $m->get_data('circular_description'),
	    'circular_title'=> $m->get_data('circular_title'),
	    'updated_at'=> $m->get_data('updated_at')
	  );

   //17SEPT2020
              /*$notiAry = array(
              'user_id'=>0,
              'notification_title'=>'Circular',
              'notification_desc'=>"Updated By Admin $created_by",    
              'notification_date'=>date('Y-m-d H:i'),
              'notification_action'=>'circulars',
              'notification_logo'=>'menu_circular.png',
              );
              $d->insert("user_notification",$notiAry);*/
          $title= "Circular" ;
          $description='"'.$circular_title.'" '. "Updated By Admin $created_by";
          $d->insertAllUserNotification($title,$description,"circulars",'','');
            
//17SEPT2020
        
         $fcmArray=$d->get_android_fcm("users_master","user_token!='' AND  lower(device)='android'   ");
         $fcmArrayIos=$d->get_android_fcm("users_master","user_token!='' AND lower(device)='ios'  ");
         $nResident->noti("circulars","",0,$fcmArray,"Circular",'"'.$circular_title.'" '."Updated By $created_by",'circulars');
         $nResident->noti_ios("circulars","",0,$fcmArrayIos,"Circular",'"'.$circular_title.'" '."Updated By $created_by",'circulars');
         // print_r($fcmArrayIosay);
       
        $q=$d->update("circulars_master",$a1,"circular_id='$circular_id' ");
    if($q==TRUE) {
      $_SESSION['msg']=$circular_title. " Circular Updated";
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("Location: ../manageCirculars");
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("Location: ../manageCirculars");
    }
  }
}

?>