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

$base_url = $m->base_url();
extract($_POST);
// add new Notice Board
if(isset($_POST) && !empty($_POST) )

{


  //echo "<pre>";print_r($_REQUEST); //exit;
  if(isset($dealOfTheDay)) {
    
     $extension=array("jpeg","jpg","png","gif","JPG","jpeg","JPEG","PNG");
      $uploadedFile = $_FILES['deal_image']['tmp_name'];
      $ext = pathinfo($_FILES['deal_image']['name'], PATHINFO_EXTENSION);
      
      if(file_exists($uploadedFile)) {
        if(in_array($ext,$extension)) {
            $sourceProperties = getimagesize($uploadedFile);
          $newFileName = rand().$user_id;
          $dirPath = "../../img/deals/";
          $imageType = $sourceProperties[2];
          $imageHeight = $sourceProperties[1];
          $imageWidth = $sourceProperties[0];
          
           if ($imageWidth>800) {
            $newWidthPercentage= 800*100 / $imageWidth;  //for maximum 400 widht
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
                imagepng($tmp,$dirPath. $newFileName. "_deals.". $ext);
                break;           

            case IMAGETYPE_JPEG:
                $imageSrc = imagecreatefromjpeg($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagejpeg($tmp,$dirPath. $newFileName. "_deals.". $ext);
                break;
            
            case IMAGETYPE_GIF:
                $imageSrc = imagecreatefromgif($uploadedFile); 
                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1],$newImageWidth,$newImageHeight);
                imagegif($tmp,$dirPath. $newFileName. "_deals.". $ext);
                break;

            default:
               $_SESSION['msg1']="Invalid Logo";
                header("Location: ../welcome");
                exit;
                break;
            }
            $deal_image= $newFileName."_deals.".$ext;

          } else{
            $_SESSION['msg1']="Invalid image";
            header("location:../welcome");
            exit();
          }
        } else {
          $deal_image="";
        }
    
    $m->set_data('deal_image',$deal_image);
    $m->set_data('deal_title',$deal_title);
    $m->set_data('deal_desc',$deal_desc);
    $m->set_data('send_to',$send_to);
    if($_POST['send_to_details']){
      $send_to_details = implode(",", $send_to_details);
    }
    $m->set_data('send_to_details',$send_to_details);
    $m->set_data('created_at',date("Y-m-d H:i:s"));

     $a =array(
      'deal_image'=> $m->get_data('deal_image'),
      'deal_title'=> $m->get_data('deal_title'),
      'deal_desc'=> $m->get_data('deal_desc'),
      'send_to'=> $m->get_data('send_to'),
      'send_to_details'=> $m->get_data('send_to_details'),
      'created_at'=> $m->get_data('created_at') ,
      'created_by' =>$_SESSION[zoobiz_admin_id]
    
    );

      $res = $d->insert("deal_master",$a,"");
        



    $where= " ";
 $send_to_details2 = explode(",", $send_to_details);


    if($send_to =="0" || $send_to =="1"){
     if($send_to == 1){
         $where = " and active_status=0  and   user_id in ($send_to_details) ";
         if(in_array(0, $send_to_details2)){
           $where="  and active_status=0 ";
        }
      } else {
       $where=" and active_status=0 ";
      }
     
} else  if($send_to =="2"  ){

       
        $sub_where = " and  cities.city_id in ($send_to_details)";
        $user_ids = $send_to_details;
        if(in_array(0, $send_to_details2)){
           $sub_where =" ";
        }
      
     
  $users_master_qry = $d->select("users_master,cities"," cities.city_id =users_master.city_id and  users_master.active_status=0  $sub_where   ","");
            $user_ids_array = array('0');
             while ($users_master_data=mysqli_fetch_array($users_master_qry)) {
              $user_ids_array[] =$users_master_data['user_id'];
             }
             $user_ids_array = implode(",", $user_ids_array);
             $where= " and   user_id in ($user_ids_array) ";


} else  if($send_to =="3"  ){

      
           $sub_where = " and  user_employment_details.business_category_id in ($send_to_details)";
        $user_ids = $send_to_details;
        if(in_array(0, $send_to_details2)){
           $sub_where =" ";
        }
       
     
  $users_master_qry = $d->select(" user_employment_details,users_master , business_categories  ","
business_categories.category_status = 0 and 
    user_employment_details.business_category_id =business_categories.business_category_id AND 

     user_employment_details.user_id =users_master.user_id and    users_master.active_status=0  $sub_where   ","");
            $user_ids_array = array('0');
             while ($users_master_data=mysqli_fetch_array($users_master_qry)) {
              $user_ids_array[] =$users_master_data['user_id'];
             }
             $user_ids_array = implode(",", $user_ids_array);
             $where= " and   user_id in ($user_ids_array) ";


} else  if($send_to =="4"  ){

       
           $sub_where = " and  user_employment_details.business_sub_category_id in ($send_to_details)";
        $user_ids = $send_to_details;
        if(in_array(0, $send_to_details2)){
           $sub_where =" ";
        }
       
      
  $users_master_qry = $d->select("user_employment_details,users_master , business_sub_categories"," business_sub_categories.sub_category_status = 0 and   user_employment_details.business_sub_category_id =business_sub_categories.business_sub_category_id AND   user_employment_details.user_id =users_master.user_id and     users_master.active_status=0  $sub_where   ","");
            $user_ids_array = array('0');
             while ($users_master_data=mysqli_fetch_array($users_master_qry)) {
              $user_ids_array[] =$users_master_data['user_id'];
             }
             $user_ids_array = implode(",", $user_ids_array);
             $where= " and   user_id in ($user_ids_array) ";


} else  if($send_to =="5"  ){
   $users_master_qry = $d->select("user_employment_details,users_master , business_sub_categories"," business_sub_categories.sub_category_status = 0 and   user_employment_details.business_sub_category_id =business_sub_categories.business_sub_category_id AND   user_employment_details.user_id =users_master.user_id and     users_master.active_status=0   and users_master.gender='Male'  ","");
            $user_ids_array = array('0');
             while ($users_master_data=mysqli_fetch_array($users_master_qry)) {
              $user_ids_array[] =$users_master_data['user_id'];
             }
             $user_ids_array = implode(",", $user_ids_array);
             $where= " and   user_id in ($user_ids_array) ";


} else  if($send_to =="6"  ){
   $users_master_qry = $d->select("user_employment_details,users_master , business_sub_categories"," business_sub_categories.sub_category_status = 0 and   user_employment_details.business_sub_category_id =business_sub_categories.business_sub_category_id AND   user_employment_details.user_id =users_master.user_id and     users_master.active_status=0   and users_master.gender='Female'  ","");
            $user_ids_array = array('0');
             while ($users_master_data=mysqli_fetch_array($users_master_qry)) {
              $user_ids_array[] =$users_master_data['user_id'];
             }
             $user_ids_array = implode(",", $user_ids_array);
             $where= " and   user_id in ($user_ids_array) ";


}else  if($send_to =="7"  ){
   $users_master_qry = $d->select("user_employment_details,users_master , business_adress_master","     business_adress_master.user_id =users_master.user_id AND business_adress_master.adress_type = 0 and   user_employment_details.user_id =users_master.user_id and     users_master.active_status=0   and business_adress_master.pincode='$pincode'  ","");
            $user_ids_array = array('0');
             while ($users_master_data=mysqli_fetch_array($users_master_qry)) {
              $user_ids_array[] =$users_master_data['user_id'];
             }
             $user_ids_array = implode(",", $user_ids_array);
             $where= " and   user_id in ($user_ids_array) ";


}
 

      $title = ucfirst($deal_title);
      $description = ucfirst($deal_desc);
//notification_logo
        if(isset($_FILES['deal_image']['tmp_name']) && $_FILES['deal_image']['tmp_name'] !=""){
            $img2 =  $deal_image;
             $img =  $base_url.'img/deals/'.$deal_image;
          } else {
            $img2 = 'ic_business_card.png';
             $img =  $base_url.'img/app_icon/ic_business_card.png';
          }
/*echo "<pre>";print_r($_REQUEST);
          echo "active_status=0 $where";exit;*/
     $d->insertAllUserNotification($title,$description,"custom_notification",$img2,"active_status=0 $where",5);
  
 



         $fcmArray=$d->get_android_fcm("users_master","user_token!=''  AND lower(device)='android' $where");
         $fcmArrayIos=$d->get_android_fcm("users_master","user_token!=''  AND lower(device)='ios' $where ");

         


 
          $fcm_data_array = array(
            'img' =>$img,
            'title' =>$title,
            'desc' => $description,
            'time' =>date("d M Y h:i A")
          );

          if(isset($_FILES['deal_image']['tmp_name']) && $_FILES['deal_image']['tmp_name'] !=""){
            $notiUrl = $base_url.'img/deals/'.$deal_image;
          } else {
            $notiUrl = $base_url.'img/app_icon/ic_business_card.png';
          }
   
 
         $nResident->noti("custom_notification",$notiUrl,$society_id,$fcmArray,$title,$description,$fcm_data_array);
         $nResident->noti_ios("custom_notification",$notiUrl,$society_id,$fcmArrayIos,$title,$description,$fcm_data_array);
         // print_r($fcmArray);
        $dec= " All members";
        if($send_to==1){
        $dec =" selected members";
        } else if($send_to==2){
        $dec =" City members";
        } else if($send_to==3){
        $dec =" Category members";
        } else if($send_to==4){
        $dec =" Sub Category members";
        }
    
      $_SESSION['msg']=$deal_title." Deal Send to".$dec;
      $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("Location: ../welcome");
  
  }


}
 ?>