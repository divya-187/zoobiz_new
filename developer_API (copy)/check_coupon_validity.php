	<?php
	include_once 'lib.php';
	if (isset($_POST) && !empty($_POST)) {
		if ($key == $keydb) {
			$response = array();
			extract(array_map("test_input", $_POST));
			$today = date('Y-m-d');
			if (isset($couponCodeValidity) && $couponCodeValidity == 'couponCodeValidity' && isset($coupon_code)  ) {

				if(isset($coupon_code) && $coupon_code !=''){
					$coupon_code = addslashes($coupon_code);

					

					$coupon_master=$d->selectRow("package_master.package_amount,package_master.package_amount,
						coupon_master.coupon_amount,coupon_master.coupon_per,package_master.gst_slab_id,coupon_master.cpn_expiry,coupon_master.is_unlimited,coupon_master.coupon_limit,
						coupon_master.coupon_code,coupon_master.coupon_id,package_master.package_name,
						package_master.package_id","coupon_master, package_master","  package_master.package_id =coupon_master.plan_id and  coupon_master.coupon_code ='$coupon_code' and coupon_master.coupon_status = 0    ","");


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

						if($coupon_master_data['gst_slab_id'] !="0"){
							$gst_slab_id = $coupon_master_data['gst_slab_id'];
							$gst_master=$d->select("gst_master","slab_id = '$gst_slab_id'","");
							$gst_master_data=mysqli_fetch_array($gst_master);
							$gst_amount= (($collect_amount*$gst_master_data['slab_percentage']) /100);
						} else {
							$gst_amount= 0 ;
						}
						$collect_amount=number_format($collect_amount+$gst_amount,2,'.','');

						if($collect_amount <1 && $collect_amount > 0 ){
							//because razorpay do not accept payment less then 1 rs.
							$collect_amount =1;
						}
						
	//3nov2020

						if( $coupon_master_data['cpn_expiry'] == 1 && $coupon_master_data['is_unlimited'] == 1 ){
							$today= date("Y-m-d");
							$dateExpire=$d->count_data_direct("coupon_id","coupon_master"," coupon_code ='$coupon_code' and coupon_status = 0  and '$today' between start_date and end_date   ","");

							if($dateExpire    ){
			//$response["message"] = "Valid Coupon Code.";
								$response["message"] = $coupon_master_data['package_name']." Applied Successfully";
								$response["package_id"] = $coupon_master_data['package_id'];
								$response["pay_amount"] = (string)$collect_amount;
								$response["validity"] = "1";
								$response["status"] = "200";
								$response["coupon_code"] = $coupon_master_data['coupon_code'];
								$response["coupon_id"] = $coupon_master_data['coupon_id'];
								echo json_encode($response);
							} else {
								$response["message"] = "Coupon Not Available";
								$response["validity"] = "0";
								$response["status"] = "201";
								echo json_encode($response);
							}
						} else if($coupon_master_data['cpn_expiry'] == 1 && $coupon_master_data['is_unlimited'] == 0     ){
							$coupon_id =  $coupon_master_data['coupon_id'];

							$alreadyUsedCounter=$d->count_data_direct("coupon_id","transection_master","  coupon_id= '$coupon_id' ","");

							$today= date("Y-m-d");
							$dateExpire=$d->count_data_direct("coupon_id","coupon_master"," coupon_code ='$coupon_code' and coupon_status = 0  and '$today' between start_date and end_date   ","");
							
							if(($alreadyUsedCounter+1) <= $coupon_master_data['coupon_limit']   && $dateExpire ){
								$response["message"] = $coupon_master_data['package_name']." Applied Successfully";
								$response["package_id"] = $coupon_master_data['package_id'];
								$response["pay_amount"] = (string)$collect_amount;
								$response["validity"] = "1";
								$response["status"] = "200";
								$response["coupon_code"] = $coupon_master_data['coupon_code'];
								$response["coupon_id"] = $coupon_master_data['coupon_id'];
								echo json_encode($response);

							}   else {
								$response["message"] = "Coupon Limit Exceeded, or Coupon Not Available";
								$response["validity"] = "0";
								$response["status"] = "201";
								echo json_encode($response);
							}
						}  else if( $coupon_master_data['cpn_expiry'] == 0 && $coupon_master_data['is_unlimited'] == 0   ){
							$coupon_id =  $coupon_master_data['coupon_id'];

							$alreadyUsedCounter=$d->count_data_direct("coupon_id","transection_master","  coupon_id= '$coupon_id' ","");
							
							if(($alreadyUsedCounter+1) <= $coupon_master_data['coupon_limit']    ){
								$response["message"] = $coupon_master_data['package_name']." Applied Successfully";
								$response["package_id"] = $coupon_master_data['package_id'];
								$response["pay_amount"] = (string)$collect_amount;
								$response["validity"] = "1";
								$response["status"] = "200";
								$response["coupon_code"] = $coupon_master_data['coupon_code'];
								$response["coupon_id"] = $coupon_master_data['coupon_id'];
								echo json_encode($response);

							}  else {
								$response["message"] = "Coupon Limit Exceeded";
								$response["validity"] = "0";
								$response["status"] = "201";
								echo json_encode($response);
							}
						} else {
							$response["coupon_code"] = $coupon_master_data['coupon_code'];
							$response["coupon_id"] = $coupon_master_data['coupon_id'];
		//$response["message"] = "Valid Coupon Code.";
							$response["message"] = $coupon_master_data['package_name'] ." Applied Successfully";
							$response["package_id"] = $coupon_master_data['package_id'];

							$response["validity"] = "1";
							$response["pay_amount"] = (string)$collect_amount;
							$response["status"] = "200";
							echo json_encode($response);
							
						}
					} else {
						$response["message"] = "Invalid Coupon Code";
						$response["validity"] = "0";
						$response["status"] = "201";
						echo json_encode($response);

					}
				} else {
					$response["message"] = "Invalid Coupon Code";
					$response["validity"] = "0";
					$response["status"] = "201";
					echo json_encode($response);

				}

			}     else {
				$response["message"] = "wrong tag.";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else {
			$response["message"] = "wrong api key.";
			$response["status"] = "201";
			echo json_encode($response);
		}
	}
	?>