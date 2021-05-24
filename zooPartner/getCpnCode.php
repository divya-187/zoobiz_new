<?php 
error_reporting(0);
include_once '../zooAdmin/lib/dao.php';
include '../zooAdmin/lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input" , $_POST));
?>
<?php
if(isset($cpn_cod) && $checkCPNVal =="Yes"){
    $cpn_cod = trim($cpn_cod);
     $coupon_master=$d->select("coupon_master"," coupon_code ='$cpn_cod'   and coupon_status = 0   ","");
            
            $cnt_val = 0 ;
            if($isedit == 'yes'){
                $cnt_val = 1 ;
            }
             if(mysqli_num_rows($coupon_master) > $cnt_val  ){
                echo 'false';
             } else {
                echo 'true';
             }
} else if(isset($checkCPN) && $checkCPN =="yes" && isset($cpn_cod)  ){
if($coupon_id !=0){
    $cpn_cod = trim($cpn_cod);
    $coupon_master=$d->select("coupon_master"," coupon_code ='$cpn_cod' and coupon_status = 0  and coupon_id !='$coupon_id'   ","");
} else {
 $coupon_master=$d->select("coupon_master"," coupon_code ='$cpn_cod' and coupon_status = 0    ","");
 }           
             if(mysqli_num_rows($coupon_master) > 0  ){
                echo "0";
             } else if(strlen($cpn_cod) <=3 || strlen($cpn_cod) >20  ){
                echo "2";
             } else {
                echo "1";
             }
 
 
} else if(isset($isGen) && $isGen =="yes"){
 echo   $coupon_code_gen = trim($d->cpn_code(8));
 
  } else if(isset($cpn_cod) && $checkCPN =="yes"){
    $cpn_cod = trim($cpn_cod);
	 $coupon_master=$d->select("coupon_master"," coupon_code ='$cpn_cod'   and coupon_status = 0   ","");
            
             if(mysqli_num_rows($coupon_master) > 0  ){
                echo "0";
             } else {
                echo "1";
             }
}   
  ?> 