<?php 
error_reporting(0);
include_once '../zooAdmin/lib/dao.php';
include '../zooAdmin/lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input" , $_POST));
?>
<?php
if(isset($checkCPN) && $checkCPN =="yes" && isset($user_social_media_name)  ){
if($user_id_edit !=0){
    $coupon_master=$d->select("users_master"," user_social_media_name ='$user_social_media_name'  and user_id !=$user_id_edit   ","");
} else {
 $coupon_master=$d->select("users_master"," user_social_media_name ='$user_social_media_name     ","");
 }           
             if(mysqli_num_rows($coupon_master) > 0  ){
                echo "0";
             }   else {
                echo "1";
             }
 
 
}  
 
  ?> 