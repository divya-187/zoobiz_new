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

$created_by=$_SESSION['admin_name'];
$updated_by=$_SESSION['admin_name'];
$society_id=$_SESSION['society_id'];

$base_url = $m->base_url();
extract($_POST);
// add new Notice Board
if(isset($_POST) && !empty($_POST) )

{
  if(isset($title)) {
    
    //IS_1209
   
    //IS_1209

    $where= "";
if($business_category_id !="0"){
  $user_employment_details_qry = $d->select("user_employment_details"," business_category_id ='$business_category_id' ","");
            $user_ids_array = array('0');
             while ($user_employment_details_data=mysqli_fetch_array($user_employment_details_qry)) {
              $user_ids_array[] =$user_employment_details_data['user_id'];
             }
             $user_ids_array = implode(",", $user_ids_array);
             $where= " and   user_id in ($user_ids_array) ";


}
    



      $title = ucfirst($title);
      $description = ucfirst($description);

        
     
 
 $fcm_data_array = array(
            'img' =>$base_url.'img/logo.png',
            'title' =>$title,
            'desc' => $description,
            'time' =>date("d M Y h:i A")
          );

if($send_to==0){
  $d->insertAllUserNotification($title,$description,"custom_notification",'',"active_status=0 $where");
   $fcmArray=$d->get_android_fcm("users_master","user_token!=''  AND lower(device)='android' $where");
         $fcmArrayIos=$d->get_android_fcm("users_master","user_token!=''  AND lower(device)='ios' $where ");

           $nResident->noti("custom_notification","",$society_id,$fcmArray,$title,$description,$fcm_data_array);
         $nResident->noti_ios("custom_notification","",$society_id,$fcmArrayIos,$title,$description,$fcm_data_array);


       } else  if($send_to==1){
        $d->insertAllUserNotificationToIos($title,$description,"custom_notification",'',"active_status=0 $where");
        $fcmArrayIos=$d->get_android_fcm("users_master","user_token!=''  AND lower(device)='ios' $where ");

         $nResident->noti_ios("custom_notification","",$society_id,$fcmArrayIos,$title,$description,$fcm_data_array);


       } else if($send_to==2){
         $d->insertAllUserNotificationToAndroid($title,$description,"custom_notification",'',"active_status=0 $where");
        $fcmArray=$d->get_android_fcm("users_master","user_token!=''  AND lower(device)='android' $where");

           $nResident->noti("custom_notification","",$society_id,$fcmArray,$title,$description,$fcm_data_array);
       }

        

         
  

       
         // print_r($fcmArray);
        
    
      $_SESSION['msg']=$title." Notification Send";
      $d->insert_log("","$society_id","$_SESSION[bms_admin_id]","$created_by",$_SESSION['msg']);
      header("Location: ../welcome");
  
  }


}
 ?>