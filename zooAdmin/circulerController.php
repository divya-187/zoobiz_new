<?php 
 include '../common/objectController.php';

if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{

   if(isset($circular_id_delete)) {
   
   //IS_1001
    $q=$d->delete("circulars_master","circular_id='$circular_id_delete' ");
    if($q==TRUE) {
      $_SESSION['msg']="Circuler Deleted Successfully";
      header("Location: ../manageCirculers");
    } else {
      $_SESSION['msg1']="manageCirculers Wrong";
      header("Location: ../Updated");
    }
  }


  if(isset($addNotice)) {
    
 
    $m->set_data('circular_description',$circular_description);
    $m->set_data('circular_title',$circular_title);
	$m->set_data('notice_time',date('d M Y H:i A'));

	 $a1= array (
	    'circular_description'=> $m->get_data('circular_description'),
	    'circular_title'=> $m->get_data('circular_title'),
	    'created_date'=> $m->get_data('notice_time')
	  );


              $notiAry = array(
              'society_id'=>$society_id,
              'user_id'=>0,
              'notification_title'=>'Circular',
              'notification_desc'=>"Added By Admin $created_by",    
              'notification_date'=>date('Y-m-d H:i'),
              'notification_action'=>'announcement',
              'notification_logo'=>'menu_circular.png',
              );
              $d->insert("user_notification",$notiAry);

           
          


         $fcmArray=$d->get_android_fcm("users_master","user_token!='' AND society_id='$society_id' AND device='android' $bl_qry ");
         $fcmArrayIos=$d->get_android_fcm("users_master","user_token!='' AND society_id='$society_id' AND device='ios' $bl_qry  ");
         $nResident->noti("circulars","",$society_id,$fcmArray,"Circular","Added By Admin $created_by",'circulars');
         $nResident->noti_ios("CircularVC","",$society_id,$fcmArrayIos,"Circular","Added By Admin $created_by",'circulars');

       
        $q=$d->insert("circulars_master",$a1);
    if($q==TRUE) {
      $_SESSION['msg']="Added Successfully";
      //IS_1210
      header("Location: ../manageCirculers");
    } else {
      header("Location: ../manageCirculers");
    }
  }



  if(isset($updateNotice)) {
   
   

     $m->set_data('circular_description',$circular_description);
    $m->set_data('circular_title',$circular_title);
	$m->set_data('notice_time',date('d M Y H:i A'));

	 $a1= array (
	    'circular_description'=> $m->get_data('circular_description'),
	    'circular_title'=> $m->get_data('circular_title'),
	    'created_date'=> $m->get_data('notice_time')
	  );
              $notiAry = array(
              'society_id'=>$society_id,
              'user_id'=>0,
              'notification_title'=>'Circular',
              'notification_desc'=>"Updated By Admin $created_by",    
              'notification_date'=>date('Y-m-d H:i'),
              'notification_action'=>'announcement',
              'notification_logo'=>'menu_circular.png',
              );
              $d->insert("user_notification",$notiAry);

        
         $fcmArray=$d->get_android_fcm("users_master","user_token!='' AND society_id='$society_id' AND device='android'  $bl_qry ");
         $fcmArrayIos=$d->get_android_fcm("users_master","user_token!='' AND society_id='$society_id' AND device='ios' $bl_qry ");
         $nResident->noti("Circulars","",$society_id,$fcmArray,"Circular","Updated By Admin $created_by",'circulars');
         $nResident->noti_ios("CircularVC","",$society_id,$fcmArrayIos,"Circular","Updated By Admin $created_by",'circulars');
         // print_r($fcmArrayIosay);
       
        $q=$d->update("circulars_master",$a1,"circular_id='$circular_id' ");
    if($q==TRUE) {
      $_SESSION['msg']="Updated Successfully";
      header("Location: ../manageCirculers");
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("Location: ../manageCirculers");
    }
  }
}

?>