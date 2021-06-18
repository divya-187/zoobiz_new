<?php 
error_reporting(0);
include_once '../zooAdmin/lib/dao.php';
include '../zooAdmin/lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input" , $_POST)); 


if(isset($coupon_code) && $coupon_code !=''){



	$coupon_code = addslashes($coupon_code);

	$coupon_master=$d->select("coupon_master, package_master","  package_master.package_id =coupon_master.plan_id and  coupon_master.coupon_code ='$coupon_code' and coupon_master.coupon_status = 0    ","");


	if(mysqli_num_rows($coupon_master)  > 0    ){

		$coupon_master_data=mysqli_fetch_array($coupon_master); 


//3nov2020
		$collect_amount = $coupon_master_data['package_amount'];
		if($coupon_master_data['coupon_amount'] > 0){
			$collect_amount = ($coupon_master_data['package_amount'] - $coupon_master_data['coupon_amount']);
		} else if($coupon_master_data['coupon_per'] > 0){
			$per_dis = ( ($coupon_master_data['package_amount']*$coupon_master_data['coupon_per'])/100 );
			$collect_amount = ($coupon_master_data['package_amount'] - $per_dis);
		}

		if($collect_amount <1 && $collect_amount > 0 ){
			//because razorpay do not accept payment less then 1 rs.
		    $collect_amount =1;
		 }
//3nov2020

		if( $coupon_master_data['cpn_expiry'] == 1 && $coupon_master_data['is_unlimited'] == 1){
			$today= date("Y-m-d");
			$dateExpire=$d->count_data_direct("coupon_id","coupon_master"," coupon_code ='$coupon_code' and coupon_status = 0  and '$today' between start_date and end_date   ","");


			if($dateExpire){
				echo "1~".$coupon_master_data['package_name']."~".$coupon_master_data['package_id']."~".$collect_amount;exit;
 
			} else {
				echo "5~''";exit;
			}
		}   else if($coupon_master_data['cpn_expiry'] == 1 && $coupon_master_data['is_unlimited'] == 0     ){
			$coupon_id =  $coupon_master_data['coupon_id'];

			$alreadyUsedCounter=$d->count_data_direct("coupon_id","transection_master","  coupon_id= '$coupon_id' ","");

			$today= date("Y-m-d");
			$dateExpire=$d->count_data_direct("coupon_id","coupon_master"," coupon_code ='$coupon_code' and coupon_status = 0  and '$today' between start_date and end_date   ","");
 
             if(($alreadyUsedCounter+1) <= $coupon_master_data['coupon_limit']   && $dateExpire ){
    ////new
				echo "1~".$coupon_master_data['package_name'] ."~".$coupon_master_data['package_id']."~".$collect_amount;exit;
//new
			}   else {
				echo "4~''";exit;
			}


		}  else if( $coupon_master_data['cpn_expiry'] == 0 && $coupon_master_data['is_unlimited'] == 1   ){
			 echo "1~".$coupon_master_data['package_name'] ."~".$coupon_master_data['package_id']."~".$collect_amount;exit;
		} else if( $coupon_master_data['cpn_expiry'] == 0 && $coupon_master_data['is_unlimited'] == 0   ){
			$coupon_id =  $coupon_master_data['coupon_id'];

			$alreadyUsedCounter=$d->count_data_direct("coupon_id","transection_master","  coupon_id= '$coupon_id' ","");
 
              if(($alreadyUsedCounter+1) <= $coupon_master_data['coupon_limit']    ){
    ////new
				echo "1~".$coupon_master_data['package_name'] ."~".$coupon_master_data['package_id']."~".$collect_amount;exit;
//new
			}  else {
				echo "4~''";exit;
			}
		}  else {
			echo "1~".$coupon_master_data['package_name'] ."~".$coupon_master_data['package_id']."~".$collect_amount;exit;
		}

	} else { 
		echo "0~''";exit;
	}        

} else {
	echo "3~''";exit;
}?>




