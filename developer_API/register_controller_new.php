<?php
include_once 'lib.php';

if (isset($_POST) && !empty($_POST)) {
//echo "<pre>";print_r($_REQUEST);exit;
	if ($key == $keydb) {
		$response = array();
		extract(array_map("test_input", $_POST));
		$today = date('Y-m-d');


	if (isset($user_register_new) && $user_register_new == 'user_register_new' && filter_var($userMobile, FILTER_VALIDATE_INT) == true  /*&& filter_var($userMobile, FILTER_VALIDATE_INT) == true*/) {

		if(isset($amount)){
			$ios_transection_amount = $amount;
		} else {
			$ios_transection_amount = "0.00";
		}
		$con->autocommit(FALSE);

		$q = $d->selectRow("*","package_master", "package_id='$plan_id'", "");
		$row1 = mysqli_fetch_array($q);
		$package_name = $row1['package_name'];
		$no_month = $row1['no_of_month'];
		$package_amount = $row1['package_amount'];

			//3nov2020
		$package_amount_new= $row1['package_amount'];
		$coupon_amount = 0 ;
		if(isset($coupon_code) && $coupon_code !=""){ 
			$coupon_master=$d->selectRow("*","coupon_master, package_master","  package_master.package_id =coupon_master.plan_id and  coupon_master.coupon_code ='$coupon_code' and coupon_master.coupon_status = 0    ","");
			$coupon_master_data=mysqli_fetch_array($coupon_master); 


			$collect_amount = $coupon_master_data['package_amount'];
			if($coupon_master_data['coupon_amount'] > 0){
				$collect_amount = ($coupon_master_data['package_amount'] - $coupon_master_data['coupon_amount']);
				$coupon_amount = $coupon_master_data['coupon_amount'] ;
			} else if($coupon_master_data['coupon_per'] > 0){
				$per_dis = ( ($coupon_master_data['package_amount']*$coupon_master_data['coupon_per'])/100 );
				$collect_amount = ($coupon_master_data['package_amount'] - $per_dis);
				$coupon_amount = $per_dis ;
			}
			$package_amount_new = $collect_amount;
		}
//3nov2020


//plan_with_gst_amount anount with gst will come as a parameter
			 //9oct2020
		if($row1['gst_slab_id'] !="0"){
			$gst_slab_id = $row1['gst_slab_id'];
			$gst_master=$d->selectRow("slab_percentage","gst_master","slab_id = '$gst_slab_id'","");
			$gst_master_data=mysqli_fetch_array($gst_master);
			$gst_amount= (($package_amount_new*$gst_master_data['slab_percentage']) /100);
		} else {
			$gst_amount= 0 ;
		}
		$package_amount=number_format($package_amount_new+$gst_amount,2,'.','');

		      //9oct2020




		$lid = $d->select("zoobizlastid", "", "");
		$laisZooBizId = mysqli_fetch_array($lid);
		$lastZooId = $laisZooBizId['zoobiz_last_id'] + 1;

			//new 29oct2020
		$duration_cri = "months";
		if($row1['time_slab'] == 1){
			$duration_cri = " days";
		} else {
			$duration_cri = " months";
			}//new 29oct2020


			$plan_renewal_date = date('Y-m-d', strtotime(' +' . $no_month . $duration_cri));

//8march21
			/*$last_auto_id = $d->last_auto_id("users_master");
			$res = mysqli_fetch_array($last_auto_id);
			$user_id = $res['Auto_increment'];
			$zoobiz_id = "ZB2020" . $lastZooId;*/
$lid=$d->select("zoobizlastid","","");
        $laisZooBizId=mysqli_fetch_array($lid);
        $lastZooId= $laisZooBizId['zoobiz_last_id']+1;
         $zoobiz_id="ZB2020".$lastZooId;



			$q = $d->selectRow("*","users_master_temp", "user_mobile='$userMobile'");
			$dataTemp = mysqli_fetch_array($q);

			// $catArray = explode(":", $business_sub_category_id);

			$m->set_data('zoobiz_id', ucfirst($zoobiz_id));
			//$m->set_data('salutation', ucfirst($salutation));
			/*$m->set_data('user_first_name', ucfirst($user_first_name));
			$m->set_data('user_last_name', ucfirst($user_last_name));
			$m->set_data('user_full_name', ucfirst($user_first_name) . ' ' . ucfirst($user_last_name));*/

			$m->set_data('user_first_name', ucfirst($user_first_name));
			$m->set_data('user_last_name', ucfirst($user_last_name));
			$m->set_data('user_full_name', ucfirst($user_first_name) .' '.ucfirst($user_last_name) );
			$user_full_name = ucfirst($user_first_name) .' '.ucfirst($user_last_name);



			// $m->set_data('member_date_of_birth',$member_date_of_birth);
			$m->set_data('whatsapp_number', $whatsapp_number);
			$m->set_data('user_mobile', $userMobile);
			$m->set_data('user_email', $user_email);
			$m->set_data('company_id', $dataTemp['company_id']);
			$m->set_data('city_id', $dataTemp['city_id']);
			$m->set_data('gender', $gender);
			$m->set_data('user_email', $user_email);
			// $m->set_data('user_profile_pic',$user_profile_pic);
			$m->set_data('plan_renewal_date', $plan_renewal_date);
			$m->set_data('plan_id', $plan_id);

			$m->set_data('register_date', date("Y-m-d H:i:s"));
			//7oct2020

			$m->set_data('refer_by',$refer_type);

			$m->set_data('referred_by_user_id','0');
			$m->set_data('refere_by_name','');
			$m->set_data('refere_by_phone_number','');

			if($refer_type==2){
				$ref_u_qry=$d->selectRow("*","users_master"," user_id ='$refer_friend_id'","");
				$ref_u_data=mysqli_fetch_array($ref_u_qry);

				$m->set_data('referred_by_user_id',$refer_friend_id);
				$m->set_data('refere_by_name',$ref_u_data['user_full_name']);
				$m->set_data('refere_by_phone_number',$ref_u_data['user_mobile']);
			}


			if(isset($refer_remark) && trim($refer_remark)!=''){
				$m->set_data('remark',$refer_remark);
			} else {
				$m->set_data('remark','');
			}

			if(isset($country_code)){
				$m->set_data('country_code',$country_code);
			} else {
				$m->set_data('country_code','+91');
			}



$a = array(
				/*'coupon_id' => $m->get_data('coupon_id'),*/
				'zoobiz_id' => $m->get_data('zoobiz_id'),
				/*'salutation' => $m->get_data('salutation'),*/
				'user_first_name' => $m->get_data('user_first_name'),
				'country_code' => $m->get_data('country_code'),
				'user_last_name' => $m->get_data('user_last_name'),
				'user_full_name' => $m->get_data('user_full_name'),
				'company_id' => $m->get_data('company_id'),
				'city_id' => $m->get_data('city_id'),
				// 'member_date_of_birth'=> $m->get_data('member_date_of_birth'),
				'user_mobile' => $m->get_data('user_mobile'),
				'whatsapp_number' => $m->get_data('whatsapp_number'),
				'user_email' => $m->get_data('user_email'),
				'gender' => $m->get_data('gender'),
				'user_email' => $m->get_data('user_email'),
				// 'user_profile_pic'=> $m->get_data('user_profile_pic'),
				'register_date' => $m->get_data('register_date'),
				'plan_id' => $m->get_data('plan_id'),
				'plan_renewal_date' => $m->get_data('plan_renewal_date'),
				'refer_by' => $m->get_data('refer_by'),
				'referred_by_user_id' => $m->get_data('referred_by_user_id'),
				'refere_by_name' => $m->get_data('refere_by_name'),
				'refere_by_phone_number' => $m->get_data('refere_by_phone_number'),
				'remark' => $m->get_data('remark'),

			);
$q = $d->insert("users_master", $a);
$user_id  = $con->insert_id; 
			  //new 22oct start

			$coupon_id= 0; 
			/*&& isset($apply_coupon) && $apply_coupon*/
			if( isset($coupon_code) && $coupon_code !=''    ){
				$coupon_code = addslashes($coupon_code);
				$coupon_master=$d->selectRow("coupon_id","coupon_master"," coupon_code ='$coupon_code' and coupon_status = 0  ","");

				if (mysqli_num_rows($coupon_master) > 0 ) {
					$coupon_master_data=mysqli_fetch_array($coupon_master);
					$coupon_id = $coupon_master_data['coupon_id'];


					$payment_mode_new = "Coupon ";
			         //3nov 2020

			         //6nov2020
					if(isset($device)){
						$payment_mode_new .=" ".$device;
					}
					if($coupon_amount > 0 && $package_amount ==0){
						$m->set_data('is_paid','1');
					} else {
						$m->set_data('is_paid','0');
					}
					  //6nov2020

					if($coupon_amount > 0){
						$paymentAry = array(
							'user_id' => $user_id,
							'is_paid' => $m->get_data('is_paid'),
							'package_id' => $m->get_data('plan_id'),
							'coupon_id' => $coupon_id,
							'package_name' => $package_name,
							'user_mobile' => $m->get_data('user_mobile'),
							'payment_mode' => $payment_mode_new,
							'transection_amount' => $coupon_amount,
							'ios_transection_amount' =>"0.00",
							'transection_date' => date("Y-m-d H:i:s"),
							'payment_status' => "SUCCESS",
							'payment_firstname' => $m->get_data('user_first_name'),
							'payment_lastname' => $m->get_data('user_last_name'),
							'payment_phone' => $m->get_data('user_mobile'),
							'payment_email' => $m->get_data('user_email')

						);
						$q3 = $d->insert("transection_master", $paymentAry);
					}
			         //3nov 2020
				} else {
					$coupon_id = 0 ;
				}

				$m->set_data('razorpay_order_id', '');
				$m->set_data('razorpay_payment_id', '');
				$m->set_data('razorpay_signature','');

			} else {
				$m->set_data('razorpay_order_id', $razorpay_order_id);
				$m->set_data('razorpay_payment_id', $razorpay_payment_id);
				$m->set_data('razorpay_signature', $razorpay_signature);
			}  

			$m->set_data('razorpay_order_id', $razorpay_order_id);
			$m->set_data('razorpay_payment_id', $razorpay_payment_id);
			$m->set_data('razorpay_signature', $razorpay_signature);


			$m->set_data('coupon_id',$coupon_id);
           //new 22oct end
			//7oct2020
			

			//3nov 2020 if condition added
			if(!isset($payment_mode)){
				$payment_mode = "Razorpay App";
			}
			

			 //6nov2020
			if(isset($device)){
				$payment_mode .=" ".$device;
			}
			if($package_amount > 0 ){ 
				$paymentAry = array(
					'user_id' => $user_id,
					'package_id' => $m->get_data('plan_id'),

					'package_name' => $package_name,
					'user_mobile' => $m->get_data('user_mobile'),
					'payment_mode' => $payment_mode,
					'transection_amount' => $package_amount,
					'ios_transection_amount'=> $ios_transection_amount,
					'transection_date' => date("Y-m-d H:i:s"),
					'payment_status' => "SUCCESS",
					'payment_firstname' => $m->get_data('user_first_name'),
					'payment_lastname' => $m->get_data('user_last_name'),
					'payment_phone' => $m->get_data('user_mobile'),
					'payment_email' => $m->get_data('user_email'),
				// 'payment_address' => $m->get_data('adress'),
					'razorpay_payment_id' => $m->get_data('razorpay_payment_id'),
					'razorpay_order_id' => $m->get_data('razorpay_order_id'),
					'razorpay_signature' => $m->get_data('razorpay_signature'),
				);


				$q3 = $d->insert("transection_master", $paymentAry);
			} else {
				$q3 =1;
			}
		//3nov 2020

			$a11 = array(
				'zoobiz_last_id' => $lastZooId,
			);

			
			// $q1=$d->insert("user_employment_details",$compAry);
			// $q2=$d->insert("business_adress_master",$adrAry);
			
			$q4 = $d->update("zoobizlastid", $a11, "id='1'");

			if ($q and $q3 and $q4) {

				$d->delete("users_master_temp", "user_mobile='$user_mobile'");

				


				$con->commit();
				$user_full_name = $m->get_data('user_full_name');
				//10nov2020 send welcome email to user
				$androidLink = 'https://play.google.com/store/apps/details?id=com.silverwing.zoobiz';
				$iosLink = 'https://apps.apple.com/us/app/zoobiz/id1550560836';

				$to = $user_email;
				$subject ="Welcome To Zoobiz";
				


            /* if(isset($debug)  ){
	 
		include('../mail/welcomeUserMail.php');

            include '../mail_front.php';
		echo "innn";exit;
	 
  
	}*/
	include('../mail/welcomeUserMail.php');
	include '../mail_front.php';



				//10nov2020

				//6nov2020
	$company_master_qry = $d->selectRow("company_id,company_name","company_master", " city_id ='$city_id' and is_master = 0  ", "");

	if (mysqli_num_rows($company_master_qry) > 0) {
		$company_master_data = mysqli_fetch_array($company_master_qry);
		$company_id = $company_master_data['company_id'];
		$company_name_c = $company_master_data['company_name'];
	} else {
		$company_id = 1;
		$company_name_c = "Zoobiz India Pvt. Ltd.";
	}






	$ref_by_data ="Other ";
	if($refer_type==2){
	      /*$refere_by_phone_number = $refer_friend_no;
          $ref_users_master = $d->selectRow("user_mobile,user_token,device,user_full_name","users_master", "user_mobile = '$refere_by_phone_number'");
           
           if (mysqli_num_rows($ref_users_master) > 0) {
		    $ref_users_master_data = mysqli_fetch_array($ref_users_master);

		    $ref_by_data = ucfirst($ref_users_master_data['user_full_name']);
		   } else {
			$ref_by_data = ucfirst($refer_friend_name);
		}*/

		$ref_by_data =  $m->get_data('refere_by_name');
	}
	if($refer_type==1){ 
		$ref_by_data ="Social Media";
	} else if($refer_type==3){ 
		$ref_by_data ="Other ";
		if($refer_remark !=''){
			$ref_by_data .=" -".$refer_remark;
		}
	}


	/*$zoobiz_admin_master = $d->selectRow("admin_name,admin_mobile","zoobiz_admin_master", "send_notification = '1'    ");
	while ($zoobiz_admin_master_data = mysqli_fetch_array($zoobiz_admin_master)) {
		$adminname = $zoobiz_admin_master_data['admin_name'];
		$msg2 = $user_full_name.' Has Joined '.$company_name_c. ' Referred by "'.$ref_by_data.'"'; 

		//"New Member Registration in $company_name_c \nName: " . $m->get_data('user_full_name') . " \nThanks Team ZooBiz";

	//	$d->send_sms($zoobiz_admin_master_data['admin_mobile'], $msg2);
		$d->sms_to_admin_on_new_user_registration($zoobiz_admin_master_data['admin_mobile'], $user_full_name,$company_name_c,$ref_by_data );
	}*/
				//6nov2020

	$response["message"] = "Registration Successful, Please Login & Complete Your Profile";
	$d->insert_myactivity($user_id,"0","", "Registered in Zoobiz","activity.png");
	$response["status"] = "200";
	echo json_encode($response);
} else {
	mysqli_query("ROLLBACK");
	$response["message"] = "Something Wrong";
	$response["status"] = "201";
	echo json_encode($response);
}

}   else if ($_POST['get_cities'] == "get_cities") {

	$qA2 = $d->selectRow("cities.city_id, cities.city_name, states.state_name,states.state_id, states.state_name","cities,states", "states.state_id = cities.state_id and   cities.city_flag=1", "");

	if (mysqli_num_rows($qA2) > 0) {

		$response["cities"] = array();

		while ($data_app2 = mysqli_fetch_array($qA2)) {

			$cities = array();
			$cities["city_id"] = $data_app2["city_id"];
			$cities["city_name"] = $data_app2["city_name"].' - '.$data_app2["state_name"];

			$cities["state_id"] = $data_app2["state_id"];
			$cities["state_name"] = $data_app2["state_name"];
			array_push($response["cities"], $cities);

		}



		$response["message"] = "Cities";
		$response["status"] = "200";
		echo json_encode($response);
	} else {

		$response["message"] = "No Data Found";
		$response["status"] = "201";
		echo json_encode($response);
	}
} else   if (isset($user_register_temp_new) && $user_register_temp_new == 'user_register_temp_new' && filter_var($userMobile, FILTER_VALIDATE_INT) == true) {
			$userMobile = mysqli_real_escape_string($con, $userMobile);

			if (strlen($userMobile) < 8) {
				$response["message"] = "Please Enter Valid Mobile Number";
				$response["status"] = "201";
				echo json_encode($response);
				exit();
			}

			$q11 = $d->select("users_master", "user_mobile='$userMobile'");
			$data = mysqli_fetch_array($q11);
			if ($data > 0) {

				if($data['active_status'] == 1){
					$response["message"] = "Your Account Is Deactivated, Please Contact ZooBiz Support Team";
					$response["status"] = "201";
					echo json_encode($response);
					exit();
				} else {
					$response["message"] = "Number Already Registered";
					$response["status"] = "201";
					echo json_encode($response);
					exit();
				}



			}

			$company_master_qry = $d->selectRow("city_id,company_id","company_master", " city_id ='$city_id' and is_master = 0  ", "");
			if (mysqli_num_rows($company_master_qry) > 0) {
				$company_master_data = mysqli_fetch_array($company_master_qry);
				$company_id = $company_master_data['company_id'];
			} else {
				$company_id = 1;
			}

			$m->set_data('company_id', $company_id);

			$user_first_name = ucfirst($user_first_name);
			$user_last_name = ucfirst($user_last_name);
			$gst_number = strtoupper($gst_number);
			//$m->set_data('salutation', ucfirst($salutation));
			$m->set_data('user_first_name', ucfirst($user_first_name));
			$m->set_data('user_last_name', ucfirst($user_last_name));
			$m->set_data('user_full_name', ucfirst($user_first_name) .' '.ucfirst($user_last_name) );
			$user_full_name = ucfirst($user_first_name) .' '.ucfirst($user_last_name);


			$m->set_data('user_mobile', $userMobile);
			$m->set_data('city_id', $city_id);
			$m->set_data('user_email', $user_email);
			$m->set_data('gender', $gender);
			$m->set_data('plan_id', $plan_id);

			$m->set_data('register_date', date("Y-m-d H:i:s"));
			//7oct2020

			$m->set_data('refer_by',$refer_type);

			$m->set_data('referred_by_user_id','0');
			$m->set_data('refere_by_name','');
			$m->set_data('refere_by_phone_number','');

			if($refer_type==2){

				$ref_u_qry=$d->selectRow("*","users_master"," user_id ='$refer_friend_id'","");
				$ref_u_data=mysqli_fetch_array($ref_u_qry);

				$m->set_data('referred_by_user_id',$refer_friend_id);
				$m->set_data('refere_by_name',$ref_u_data['user_full_name']);
				$m->set_data('refere_by_phone_number',$ref_u_data['user_mobile']);
			}

			if(isset($refer_remark) && trim($refer_remark)!=''){
				$m->set_data('remark',$refer_remark);
			} else {
				$m->set_data('remark','');
			}

			  //new 22oct start

			$coupon_id= 0; 
			if(isset($coupon_code) && $coupon_code !='' && isset($apply_coupon) && $apply_coupon    ){
				$coupon_code = addslashes($coupon_code);


				$coupon_master=$d->selectRow("*","coupon_master, package_master","  package_master.package_id =coupon_master.plan_id and  coupon_master.coupon_code ='$coupon_code' and coupon_master.coupon_status = 0    ","");


				if (mysqli_num_rows($coupon_master) > 0 ) {
					$coupon_master_data=mysqli_fetch_array($coupon_master);
					$coupon_id = $coupon_master_data['coupon_id'];

			         //3nov2020
					$collect_amount = $coupon_master_data['package_amount'];
					if($coupon_master_data['coupon_amount'] > 0){
						$collect_amount = ($coupon_master_data['package_amount'] - $coupon_master_data['coupon_amount']);
					} else if($coupon_master_data['coupon_per'] > 0){
						$per_dis = ( ($coupon_master_data['package_amount']*$coupon_master_data['coupon_per'])/100 );
						$collect_amount = ($coupon_master_data['package_amount'] - $per_dis);
					}
						//3nov2020


				} else {
					$coupon_id = 0 ;
				}


			}    
			$m->set_data('coupon_id',$coupon_id);
			$m->set_data('state_id',$state_id);
           //new 22oct end
			if(isset($order_id)){
				$m->set_data('tracking_id',$order_id);
			} else {
				$m->set_data('tracking_id','');
			}
			

			if(isset($country_code)){
				$m->set_data('country_code',$country_code);
			} else {
				$m->set_data('country_code','+91');
			}
			//7oct2020
			$a = array(
				'coupon_id' => $m->get_data('coupon_id'),
				'state_id' => $m->get_data('state_id'),
				/*'salutation' => $m->get_data('salutation'),*/
				'country_code' => $m->get_data('country_code'),
				'tracking_id' => $m->get_data('tracking_id'),
				'user_first_name' => $m->get_data('user_first_name'),
				'user_last_name' => $m->get_data('user_last_name'),
				'user_full_name' => $m->get_data('user_full_name'),
				'user_mobile' => $m->get_data('user_mobile'),
				'user_email' => $m->get_data('user_email'),
				'city_id' => $m->get_data('city_id'),
				'gender' => $m->get_data('gender'),
				'user_email' => $m->get_data('user_email'),
				'register_date' => $m->get_data('register_date'),
				'plan_id' => $m->get_data('plan_id'),
				'company_id' => $m->get_data('company_id'),
				'refer_by' => $m->get_data('refer_by'),
				'referred_by_user_id' => $m->get_data('referred_by_user_id'),
				'refere_by_name' => $m->get_data('refere_by_name'),
				'refere_by_phone_number' => $m->get_data('refere_by_phone_number'),
				'remark' => $m->get_data('remark')

			);

			$q = $d->selectRow("user_mobile","users_master_temp", "user_mobile='$userMobile'");
			$data = mysqli_fetch_array($q);


			if ($data > 0) {  
				$q = $d->update("users_master_temp", $a, "user_mobile = '$userMobile'");
			} else {  
				$q = $d->insert("users_master_temp", $a);
			}

			if ($q > 0) {

				if (isset($city_id)) {

					$company_master_qry = $d->selectRow("city_id,company_id","company_master", " city_id ='$city_id' and is_master = 0  ", "");
$response["payment_gateway_array"] = array();
					if (mysqli_num_rows($company_master_qry) > 0) {
						$company_master_data = mysqli_fetch_array($company_master_qry);
						$company_id = $company_master_data['company_id'];
					} else {
						$company_id = 1;
					}

					$payment_getway_master_qry = $d->selectRow("*","payment_getway_master", " company_id ='$company_id' ", "");


					if (mysqli_num_rows($payment_getway_master_qry) > 0) {
						$payment_getway_master_data = mysqli_fetch_array($payment_getway_master_qry);
						$currency_id = $payment_getway_master_data['currency_id'];
						$currency_master_qry = $d->selectRow("currency_code,currency_id","currency_master", " currency_id ='$currency_id' ", "");
						$currency_master_data = mysqli_fetch_array($currency_master_qry);
						$keyId = $payment_getway_master_data['merchant_id'];
						$keySecret = $payment_getway_master_data['merchant_key'];
						$upi_id = $payment_getway_master_data['upi_id'];
						$upi_name = $payment_getway_master_data['upi_name'];
						$displayCurrency = $currency_master_data['currency_code'];

if($payment_getway_master_data['merchant_id']!=""){ 
$payment_gateway_array = array();
$payment_gateway_array['gateway_name'] ="Razorpay";
$payment_gateway_array['keyId'] = $payment_getway_master_data['merchant_id'];
$payment_gateway_array['keySecret'] = $payment_getway_master_data['merchant_key'];
$payment_gateway_array['is_upi'] =false;
$payment_gateway_array['logo_url'] =$base_url.'img/razor_pay_logo1.png';
$payment_gateway_array["displayCurrency"] = $displayCurrency;
 array_push($response["payment_gateway_array"], $payment_gateway_array);
}

if($payment_getway_master_data['paytm_merchant_id']!=""){ 
$payment_gateway_array = array();
$payment_gateway_array['gateway_name'] ='paytm';//$payment_getway_master_data['paytm_name'];

$payment_gateway_array['is_upi'] =false;
$payment_gateway_array['logo_url'] =$base_url.'img/PaytmLogo.png';
$payment_gateway_array["displayCurrency"] = $displayCurrency;

$zoobiz_settings_master_qry = $d->select("zoobiz_settings_master","","");
$zoobiz_settings_master_data=mysqli_fetch_array($zoobiz_settings_master_qry);
$payment_gateway_array['PaytmChecksumCode'] = $zoobiz_settings_master_data['PaytmChecksumCode'];

if($payment_getway_master_data['paytm_is_live_mode']=="Yes"){
	$payment_gateway_array["host_url"] = "https://securegw.paytm.in/";
    $payment_gateway_array["call_back_url"] = "https://securegw.paytm.in/theia/paytmCallback";
    $payment_gateway_array["show_payment_url"] = "https://securegw.paytm.in/theia/api/v1/showPaymentPage"; 

    $payment_gateway_array['paytm_merchant_id'] = $payment_getway_master_data['paytm_merchant_id'];
$payment_gateway_array['paytm_merrchant_key'] =html_entity_decode( $payment_getway_master_data['paytm_merrchant_key']);
$payment_gateway_array['paytm_is_live_mode'] = true;

} else {

$payment_gateway_array['paytm_is_live_mode'] = false;
	$payment_gateway_array["host_url"] = "https://securegw-stage.paytm.in/";
    $payment_gateway_array["call_back_url"] =   "https://securegw-stage.paytm.in/theia/paytmCallback"; 

    //$base_url.'/controller/successAndroid.php';//
     $payment_gateway_array["show_payment_url"] = "https://securegw-stage.paytm.in/theia/api/v1/showPaymentPage";

     $payment_gateway_array['paytm_merchant_id'] = $payment_getway_master_data['test_paytm_merchant_id'];
$payment_gateway_array['paytm_merrchant_key'] =html_entity_decode( $payment_getway_master_data['test_paytm_merrchant_key']);
}
 array_push($response["payment_gateway_array"], $payment_gateway_array);
 }


if($payment_getway_master_data['ccav_merchant_id'] !=""){ 
$payment_gateway_array = array();
$payment_gateway_array['gateway_name'] ="CCAvenue";
$payment_gateway_array['ccav_working_key'] = $payment_getway_master_data['ccav_working_key'];
$payment_gateway_array['ccav_access_code'] = $payment_getway_master_data['ccav_access_code'];
$payment_gateway_array['ccav_merchant_id'] = $payment_getway_master_data['ccav_merchant_id'];

$payment_gateway_array['logo_url'] =$base_url.'img/new.png';
$payment_gateway_array['redirect_url'] = $base_url.'/controller/ccavResponseHandlerAndroid.php';
$payment_gateway_array['cancel_url'] = $base_url.'/controller/ccavResponseHandlerAndroid.php'; 
if($payment_getway_master_data['ccav_live_mode']=="Yes"){
    $payment_gateway_array["ccav_mode_url"]=  "https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction";
    $payment_gateway_array["ccav_rsa_url"]=  $base_url.'/controller/GetRSA.php';
    $payment_gateway_array['trans_url'] ="https://secure.ccavenue.com/transaction/initTrans";
    $payment_gateway_array['ccav_live_mode'] = true;
} else {
    $payment_gateway_array["ccav_mode_url"]= "https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction";
    $payment_gateway_array["ccav_rsa_url"]=  $base_url.'/controller/GetRSA.php';
    $payment_gateway_array['trans_url'] ="https://test.ccavenue.com/transaction/initTrans";
    $payment_gateway_array['ccav_live_mode'] = false;
}


$payment_gateway_array['is_upi'] =false;

$payment_gateway_array["displayCurrency"] = $displayCurrency;
 array_push($response["payment_gateway_array"], $payment_gateway_array);
}


/*$payment_gateway_array = array();
$payment_gateway_array['gateway_name'] ="UPI";
$payment_gateway_array['upi_id'] = $payment_getway_master_data['upi_id'];
$payment_gateway_array['upi_name'] = $payment_getway_master_data['upi_name'];

$payment_gateway_array['is_upi'] =true;
$payment_gateway_array['logo_url'] =$base_url.'img/upi_logo2.png';
$payment_gateway_array["displayCurrency"] = $displayCurrency;
array_push($response["payment_gateway_array"], $payment_gateway_array);*/


						 
				//CCAvenue End

					} else {

						$payment_getway_master_qry = $d->selectRow("*","payment_getway_master", " company_id ='1' ", "");
						$payment_getway_master_data = mysqli_fetch_array($payment_getway_master_qry);
						$currency_id = $payment_getway_master_data['currency_id'];
						$currency_master_qry = $d->selectRow("currency_code,currency_id","currency_master", " currency_id ='$currency_id' ", "");
						$currency_master_data = mysqli_fetch_array($currency_master_qry);
						$keyId = $payment_getway_master_data['merchant_id'];
						$keySecret = $payment_getway_master_data['merchant_key'];

 
						$displayCurrency = 'INR';
						 
 
					}
				} else {
					$payment_getway_master_qry = $d->selectRow("*","payment_getway_master", " company_id ='1' ", "");
						$payment_getway_master_data = mysqli_fetch_array($payment_getway_master_qry);
						$currency_id = $payment_getway_master_data['currency_id'];
						$currency_master_qry = $d->selectRow("currency_code,currency_id","currency_master", " currency_id ='$currency_id' ", "");
						$currency_master_data = mysqli_fetch_array($currency_master_qry);
						$keyId = $payment_getway_master_data['merchant_id'];
						$keySecret = $payment_getway_master_data['merchant_key'];

 
						$displayCurrency = 'INR';
					 

					 
				}

$response["upiList"] = array();
$qA = $d->select("upi_app_master","active_status=0","");
if (mysqli_num_rows($qA) > 0) {
		while($data_app=mysqli_fetch_array($qA)) {
            $upiList=array();
            $upiList["app_id"] = $data_app['app_id'];
            $upiList["app_name"] = $data_app['app_name'];
            $upiList["app_package_name"] = $data_app['app_package_name'];
            $upiList['is_upi'] =true;
            array_push($response["upiList"], $upiList); 
        }
}
$zoobiz_settings_master_qry = $d->select("zoobiz_settings_master","","");
$zoobiz_settings_master_data=mysqli_fetch_array($zoobiz_settings_master_qry);
                $response['is_upi'] =filter_var($zoobiz_settings_master_data['is_upi'], FILTER_VALIDATE_BOOLEAN); 
				/*if(isset($coupon_code) && $coupon_code !='' && isset($apply_coupon) && $apply_coupon    ){
					$keyId=" ";
					$keySecret=" ";
					$displayCurrency=" ";
				}*/
				$response["keyId"] = $keyId;
				$response["keySecret"] = $keySecret;

				 

				
				$response["displayCurrency"] = $displayCurrency;
				$response["message"] = "Registration Successful";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something Went Wrong";
				$response["status"] = "201";
				echo json_encode($response);

			}

		} 
//18dec2020

//18dec2020

		else   if (isset($complete_profile) && $complete_profile == 'complete_profile' && filter_var($user_id, FILTER_VALIDATE_INT) == true) {
			$con->autocommit(FALSE);

$org_user_id= $user_id;
//add custom business category
			if(isset($custom_category_name) && $custom_category_name!='' && $business_category_id =='-1' && $business_sub_category_id =="-1"){
				$custom_category_name_new = strtolower($custom_category_name);
				$q_cat=$d->select("business_sub_categories"," lower(sub_category_name) ='$custom_category_name_new'  and sub_category_status=0 ");


				if(mysqli_num_rows($q_cat) >0 ){
					$response["message"] = ucfirst($custom_category_name_new)." Category Already Exists, Please Select it";
					$response["status"] = "201";
					echo json_encode($response);
					exit;
				}


				$customBusinessCategory = array(
					'business_category_id' => '-2',
					'incepted_user_id' => $user_id,
					'sub_category_name' => ucwords($custom_category_name_new),
					'sub_category_status' => 0
				);
				$q1 = $d->insert("business_sub_categories", $customBusinessCategory);
			}
			
			//add custom business category


			//add in original table

			$is_completed=$d->select("user_employment_details","user_id='$user_id'",""); 
			if (mysqli_num_rows($is_completed) > 0) {
				$response["message"] = "Your Profile Is Already Completed, Please Login To Zoobiz.";
				$response["status"] = "201";
				echo json_encode($response);
				exit;
			}


			$maxsize = 5000000;
			if (($_FILES['user_profile_pic']['size'] >= $maxsize) || ($_FILES["user_profile_pic"]["size"] == 0)) {
				$response["message"] = "Profile Pic is too large. Must be less than or equal to 5 MB.";
				$response["status"] = "201";
				echo json_encode($response);
				exit;
			}


			$extension = array("jpeg", "jpg", "png", "gif", "JPG", "jpeg", "JPEG", "PNG");
			$uploadedFile = $_FILES['user_profile_pic']['tmp_name'];
			$ext = pathinfo($_FILES['user_profile_pic']['name'], PATHINFO_EXTENSION);

			if (file_exists($uploadedFile)) {
				if (in_array($ext, $extension)) {
					$sourceProperties = getimagesize($uploadedFile);
					$newFileName = rand() . $user_id;
					$dirPath = "../img/users/members_profile/";
					$imageType = $sourceProperties[2];
					$imageHeight = $sourceProperties[1];
					$imageWidth = $sourceProperties[0];

					if ($imageWidth > 800) {
						$newWidthPercentage = 800 * 100 / $imageWidth; //for maximum 400 widht
						$newImageWidth = $imageWidth * $newWidthPercentage / 100;
						$newImageHeight = $imageHeight * $newWidthPercentage / 100;
					} else {
						$newImageWidth = $imageWidth;
						$newImageHeight = $imageHeight;
					}

					//7jan2021
					move_uploaded_file($_FILES["user_profile_pic"]["tmp_name"], "../img/users/members_profile/".$newFileName . "_profile." . $ext); 
					//7jan2021

					/*switch ($imageType) {

						case IMAGETYPE_PNG:
						$imageSrc = imagecreatefrompng($uploadedFile);
						$tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
						imagepng($tmp, $dirPath . $newFileName . "_profile." . $ext);
						break;

						case IMAGETYPE_JPEG:
						$imageSrc = imagecreatefromjpeg($uploadedFile);
						$tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
						imagejpeg($tmp, $dirPath . $newFileName . "_profile." . $ext);
						break;

						case IMAGETYPE_GIF:
						$imageSrc = imagecreatefromgif($uploadedFile);
						$tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
						imagegif($tmp, $dirPath . $newFileName . "_profile." . $ext);
						break;

						default:
						// $_SESSION['msg1']="Invalid Profile Photo";
						// header("Location: ../register");
						// exit;
						break;
					}*/
					$user_profile_pic = $newFileName . "_profile." . $ext;

				} else {
					// $_SESSION['msg1']="Invalid Profile Photo";
					// header("location:../register");
					// exit();
				}
			} else {
				$user_profile_pic = "";
			}

			$extension = array("jpeg", "jpg", "png", "gif", "JPG", "jpeg", "JPEG", "PNG");
			$uploadedFile = $_FILES['company_logo']['tmp_name'];
			$ext = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);

			if (file_exists($uploadedFile)) {
				if (in_array($ext, $extension)) {
					$sourceProperties = getimagesize($uploadedFile);
					$newFileName = rand() . $user_id;
					$dirPath = "../img/users/company_logo/";
					$imageType = $sourceProperties[2];
					$imageHeight = $sourceProperties[1];
					$imageWidth = $sourceProperties[0];

					if ($imageWidth > 800) {
						$newWidthPercentage = 800 * 100 / $imageWidth; //for maximum 400 widht
						$newImageWidth = $imageWidth * $newWidthPercentage / 100;
						$newImageHeight = $imageHeight * $newWidthPercentage / 100;
					} else {
						$newImageWidth = $imageWidth;
						$newImageHeight = $imageHeight;
					}


					move_uploaded_file($_FILES["company_logo"]["tmp_name"], "../img/users/company_logo/".$newFileName . "_c_logo." . $ext); 



					$company_logo = $newFileName . "_c_logo." . $ext;

				} else {

				}
			} else {
				$company_logo = "";
			}
			$m->set_data('company_logo', $company_logo);


			// $catArray = explode(":", $business_sub_category_id);
			//$m->set_data('salutation', ucfirst($salutation));

			/*$user_name = explode(" ", $user_name);
			$m->set_data('user_first_name', ucfirst($user_name[0]));
			if(isset($user_name[1])){
				$m->set_data('user_last_name', ucfirst($user_name[1]));
				$m->set_data('user_full_name', ucfirst($user_name[0]) . ' ' . ucfirst($user_name[1]));
			} else {
				$m->set_data('user_last_name', "");
				$m->set_data('user_full_name', ucfirst($user_name[0]) );
			}*/

			
			/*$m->set_data('user_first_name', ucfirst($user_first_name));
			$m->set_data('user_last_name', ucfirst($user_last_name));
			$m->set_data('user_full_name', ucfirst($user_first_name) . ' ' . ucfirst($user_last_name));*/
			if ($member_date_of_birth != "") {
				$member_date_of_birth = str_replace("/", "-",$member_date_of_birth);
				$m->set_data('member_date_of_birth', date("Y-m-d", strtotime($member_date_of_birth)));
			} else {
				$m->set_data('member_date_of_birth', "");
			}


			
			$m->set_data('whatsapp_number', $whatsapp_number);
			// $m->set_data('user_mobile',$userMobile);
			/*$m->set_data('user_email', $user_email);
			$m->set_data('gender', $gender);*/
			$m->set_data('user_profile_pic', $user_profile_pic);

			$m->set_data('company_name', $company_name);
			//$m->set_data('company_contact_number', $company_contact_number);
			$m->set_data('business_category_id', $business_category_id);
			$m->set_data('business_sub_category_id', $business_sub_category_id);
			$m->set_data('designation', $designation);
			$m->set_data('company_website', $company_website);
			$m->set_data('gst_number', strtoupper($gst_number));

			$m->set_data('adress', $adress);
			if(isset($adress2)){
				$m->set_data('adress2', $adress2);
			} else {
				$m->set_data('adress2', '');
			}
			$m->set_data('area_id', $area_id);
			$m->set_data('city_id', $city_id);
			$m->set_data('state_id', $state_id);
			$m->set_data('country_id', $country_id);
			$m->set_data('gender', $gender);
			$m->set_data('pincode', $pincode);
			$m->set_data('latitude', $latitude);
			$m->set_data('longitude', $longitude);
			$m->set_data('adress_type', $adress_type);
			$m->set_data('register_date', date("Y-m-d H:i:s"));

			$a = array(
				/*'salutation' => $m->get_data('salutation'),*/
				/*'user_first_name' => $m->get_data('user_first_name'),
				'user_last_name' => $m->get_data('user_last_name'),
				'user_full_name' => $m->get_data('user_full_name'),*/
				'member_date_of_birth' => $m->get_data('member_date_of_birth'),
				'whatsapp_number' => $m->get_data('whatsapp_number'),
				/*'user_email' => $m->get_data('user_email'),*/
				'gender' => $m->get_data('gender'),
				'user_profile_pic' => $m->get_data('user_profile_pic'),
				'is_profile_completed' => 1,
			);

			$compAry = array(
				'user_id' => $user_id,
				'company_name' => $m->get_data('company_name'),
				/*'company_contact_number' => $m->get_data('company_contact_number'),*/
				'business_category_id' => $m->get_data('business_category_id'),
				'business_sub_category_id' => $m->get_data('business_sub_category_id'),
				'designation' => $m->get_data('designation'),
				'company_website' => $m->get_data('company_website'),
				'gst_number' => $m->get_data('gst_number'),
				'company_logo'=> $m->get_data('company_logo'),
				'complete_profile_date' =>date('Y-m-d H:i:s')

			);



			$adrAry = array(
				'user_id' => $user_id,
				'adress' => $m->get_data('adress'),

				'adress2' => $m->get_data('adress2'),
				'area_id' => $m->get_data('area_id'),
				'city_id' => $m->get_data('city_id'),
				'state_id' => $m->get_data('state_id'),
				'country_id' => $m->get_data('country_id'),
				'pincode' => $m->get_data('pincode'),
				'add_latitude' => $m->get_data('latitude'),
				'add_longitude' => $m->get_data('longitude'),
				/*'adress_type' => $m->get_data('adress_type'),*/
			);

			$q = $d->update("users_master", $a, "user_id='$user_id'");
			$q1 = $d->insert("user_employment_details", $compAry);
			$q2 = $d->insert("business_adress_master", $adrAry);

			if ($q and $q1 and $q2) {

				 
				$con->commit();

				$androidLink = 'https://play.google.com/store/apps/details?id=com.silverwing.zoobiz';
				$iosLink = 'https://apps.apple.com/us/app/zoobiz/id1550560836';

				//2nov2020

				$users_master_qry = $d->select("users_master", " user_id='$user_id'", "");
				$users_master_data = mysqli_fetch_array($users_master_qry);
				$user_mobile = $users_master_data['user_mobile'];


				if($business_category_id =='-1' && $business_sub_category_id =="-1"){
					$ref_by_data ="";
				//refer by user start
					$main_users_master = $d->selectRow("*","users_master", "user_mobile = '$user_mobile' OR user_mobile ='$userMobile' or user_id='$user_id'   ");


					$main_users_master_data = mysqli_fetch_array($main_users_master);

					if($main_users_master_data['refer_by']==2){ 
						$refere_by_phone_number = $main_users_master_data['refere_by_phone_number'];
						$ref_users_master = $d->selectRow("*","users_master", "user_mobile = '$refere_by_phone_number'    ");

						$cities = $d->selectRow("city_name","cities", "city_id = '$city_id'    ");
						$cities_data = mysqli_fetch_array($cities);


						if (mysqli_num_rows($ref_users_master) > 0) {
							$ref_users_master_data = mysqli_fetch_array($ref_users_master);



							$d->sms_member_refferal($main_users_master_data['refere_by_phone_number'], ucfirst($main_users_master_data['user_full_name']),$cities_data['city_name'], ucfirst($ref_users_master_data['user_full_name']) );



						} else {

							$ref_by_data = ucfirst($main_users_master_data['refere_by_name']);

							$d->sms_member_refferal($main_users_master_data['refere_by_phone_number'], ucfirst($main_users_master_data['user_full_name']),$cities_data['city_name'], ucfirst($main_users_master_data['refere_by_name']) );
						}

					}
				} else {
					$ref_by_data ="";
				//refer by user start
					$main_users_master = $d->selectRow("*","users_master", "user_mobile = '$user_mobile' OR user_mobile ='$userMobile' or user_id='$user_id'   ");


					$main_users_master_data = mysqli_fetch_array($main_users_master);

					if($main_users_master_data['refer_by']==2){ 
						$refere_by_phone_number = $main_users_master_data['refere_by_phone_number'];
						$ref_users_master = $d->selectRow("*","users_master", "user_mobile = '$refere_by_phone_number'    ");

						$cities = $d->selectRow("city_name","cities", "city_id = '$city_id'    ");
						$cities_data = mysqli_fetch_array($cities);


						if (mysqli_num_rows($ref_users_master) > 0) {
							$ref_users_master_data = mysqli_fetch_array($ref_users_master);


							if($ref_users_master_data['user_token'] !=''){

								if($main_users_master_data['user_profile_pic']!=""){
									$img = $base_url . "img/users/members_profile/" . $main_users_master_data['user_profile_pic'];
								} else {
									$img ="";
								}


								$title=$main_users_master_data['user_full_name'];

								$msg3=ucfirst($main_users_master_data['user_full_name'])." Has Joined Zoobiz ".$cities_data['city_name'].". Big Thank you from Zoobiz. Keep Referring!";
								$ref_by_data = ucfirst($ref_users_master_data['user_full_name']);


								$title = $main_users_master_data['user_full_name'];
								$msg = $msg3;
								$notiAry = array(
									'user_id' => $ref_users_master_data['user_id'],
									'notification_title' => $title,
									'notification_desc' => $msg,
									'notification_date' => date('Y-m-d H:i'),
									'notification_action' => 'profile',
									'notification_logo' => 'profile.png',
									'notification_type' => '12',
									'other_user_id' => $main_users_master_data['user_id'] 
								);
								$d->insert("user_notification", $notiAry);


								if (strtolower($ref_users_master_data['device']) =='android') {

									$nResident->noti("refer","",0,$ref_users_master_data['user_token'],$title,$msg3,"0",1,$img);


								}  else if(strtolower($ref_users_master_data['device']) =='ios') {

									$nResident->noti_ios("refer","",0,$ref_users_master_data['user_token'],$title,$msg3,"0",1,$img);

								}


							}

							$d->sms_member_refferal($main_users_master_data['refere_by_phone_number'], ucfirst($main_users_master_data['user_full_name']),$cities_data['city_name'], ucfirst($ref_users_master_data['user_full_name']) );
						} else {

							$ref_by_data = ucfirst($main_users_master_data['refere_by_name']);

							$msg3=ucfirst($main_users_master_data['user_full_name'])." Has Joined Zoobiz ".$cities_data['city_name'].". Big Thank you from Zoobiz. Keep Referring!"; 


							$d->sms_member_refferal($main_users_master_data['refere_by_phone_number'], ucfirst($main_users_master_data['user_full_name']),$cities_data['city_name'], ucfirst($main_users_master_data['refere_by_name']) );
						}

					}
				}
				
	//refer by user end 


				//2nov2020
				$getData = $d->selectRow("fcm_content,share_within_city","custom_settings_master", " status = 0 and send_fcm=1 and flag = 0 ", "");


				$ref_by_data ="Other 1";
				if($users_master_data['refer_by']==2){
					$refere_by_phone_number = $users_master_data['refere_by_phone_number'];
					$refer_friend_id = $users_master_data['referred_by_user_id'];

					$ref_users_master = $d->selectRow("*","users_master", "user_mobile = '$refere_by_phone_number' or user_id = '$refer_friend_id' ");

					if (mysqli_num_rows($ref_users_master) > 0) {
						$ref_users_master_data = mysqli_fetch_array($ref_users_master);

						$ref_by_data = ucfirst($ref_users_master_data['user_full_name']);
					} else {
						$ref_by_data = ucfirst($users_master_data['refere_by_name']);
					}
				}
				if($users_master_data['refer_by'] ==1){ 
					$ref_by_data ="Social Media";
				} else if($users_master_data['refer_by']==3){ 
					$ref_by_data ="Other 2";
					if($remark !=''){
						$ref_by_data .=" -".$users_master_data['remark'];
					}
				}  
				if (mysqli_num_rows($getData) > 0 && $users_master_data['office_member'] == 0 ) {
					$custom_settings_master_data = mysqli_fetch_array($getData);
					/*$business_categories_qry = $d->select("business_categories", "  category_status = 0 and  business_category_id ='$business_category_id' ", "");
					$business_categories_data = mysqli_fetch_array($business_categories_qry);*/

					$title = "New Member Registered."; //" in ". $business_categories_data['category_name'] ." Category" ;
					$description = $custom_settings_master_data['fcm_content'];
					$description = str_replace("USER_NAME", $users_master_data['user_full_name'], $description);


					//5nov 2020
					$description = str_replace("COMPANY_NAME", $company_name, $description);

					$description =$users_master_data['user_full_name']." from ".$company_name." also says, I am Zoobiz! Referred by ".$ref_by_data;

					$where = "";
					if($custom_settings_master_data['share_within_city'] ==1 ){
						$where = " and  city_id ='$city_id'";
					}


					$user_employment_details_qry = $d->selectRow("user_id","users_master", " active_status=0 $where ", "");
					$user_ids_array = array('0');
					while ($user_employment_details_data = mysqli_fetch_array($user_employment_details_qry)) {
						$user_ids_array[] = $user_employment_details_data['user_id'];
					}
					$user_ids_array = implode(",", $user_ids_array);

 
 					

					$fcmArray = $d->get_android_fcm("users_master", "user_token!='' AND  lower(device) ='android' and user_id in ($user_ids_array) AND user_id != $user_id");

					$fcmArrayIos = $d->get_android_fcm("users_master ", " user_token!='' AND  lower(device) ='ios' and user_id in ($user_ids_array)   AND user_id != $user_id ");


					$fcm_data_array = array(
						'img' =>$base_url.'img/logo.png',
						'title' =>$title,
						'desc' => $description,
						'time' =>date("d M Y h:i A")
					);


					if($user_profile_pic!=""){
						$profile_u = $base_url . "img/users/members_profile/" . $user_profile_pic;
					} else {
						$profile_u ="https://zoobiz.in/zooAdmin/img/user.png";
					}

					$u_qry = $d->selectRow("*","users_master", "user_id='$user_id' ");
					$u_details = mysqli_fetch_array($u_qry);
//$office_mem_arr = array('7990247516', '8866489158');
					$office_mem_arr = array( '8866489158','7990247516','9099360078','7990032612');

					if($business_category_id !='-1' && $business_sub_category_id !="-1"){
						if(!in_array($u_details['user_mobile'], $office_mem_arr) ){

							$d->insertAllUserNotificationMemberSpecial($title,$description,"viewMemeber",$user_profile_pic,"active_status=0 and user_id in ($user_ids_array) AND user_id != $user_id",11,$user_id);
							
							$nResident->noti("viewMemeber","",0,$fcmArray,$title,$description,$user_id,1,$profile_u);
							$nResident->noti_ios("viewMemeber","",0,$fcmArrayIos,$title,$description,$user_id,1,$profile_u);
						}
					}


				}

				


				if($users_master_data['office_member'] == 0){ 
					$notiAry = array(
						'admin_id' => 0,
						'ref_id' =>$user_id,
						'notification_tittle' => "New Member Registered.",
						'notification_description' => $users_master_data['user_full_name'] . " registered in ZooBiz Referred by " . $ref_by_data,
						'notifiaction_date' => date('Y-m-d H:i'),
						'notification_action' => '',
						'admin_click_action ' => 'adminNotification',
					);
					$d->insert("admin_notification", $notiAry);
				}
				//6nov send message to admin at registration time
				/*$company_master_qry = $d->select("company_master", " city_id ='$city_id' ", "");

				if (mysqli_num_rows($company_master_qry) > 0) {
					$company_master_data = mysqli_fetch_array($company_master_qry);
					$company_id = $company_master_data['company_id'];
					$company_name_c = $company_master_data['company_name'];
				} else {
					$company_id = 1;
					$company_name_c = "Zoobiz India Pvt. Ltd.";
				}

				$zoobiz_admin_master = $d->select("zoobiz_admin_master", "send_notification = '1'    ");
				while ($zoobiz_admin_master_data = mysqli_fetch_array($zoobiz_admin_master)) {
					$adminname = $zoobiz_admin_master_data['admin_name'];
					$msg2 = "New Member Registration in $company_name_c \nName: " . ucfirst($user_first_name) . ' ' . ucfirst($user_last_name) . " \nCompany Name: $company_name \nThanks Team ZooBiz";

					$d->send_sms($zoobiz_admin_master_data['admin_mobile'], $msg2);

				}*/

				$getDataq = $d->selectRow("fcm_content","custom_settings_master", " status = 0 and send_fcm=1 and   flag = 1 ", "");

				if (mysqli_num_rows($getDataq) > 0 && $users_master_data['office_member'] == 0) {

					$custom_settings_master_data = mysqli_fetch_array($getDataq);

					$user_full_name =$users_master_data['user_full_name'];
					$description = $custom_settings_master_data['fcm_content'];
					$description = str_replace("USER_FULL_NAME", $user_full_name, $description);
					$description = str_replace("ANDROID_LINK", $androidLink, $description);
					$description = str_replace("IOS_LINK", $iosLink, $description);

					//$d->send_sms($user_mobile, htmlspecialchars_decode(addslashes($description)));
					if($business_category_id =='-1' && $business_sub_category_id =="-1"){
						//new SMS here
						$a1 = array(
							'user_token' => ''
						);
						$d->update("users_master", $a1, "user_mobile='$user_mobile'");
						$d->sms_to_user_on_account_approval_request($user_mobile,$user_full_name);


						
						 //email to admin for approval start
						$zoobiz_admin_master = $d->selectRow("*","zoobiz_admin_master", "send_notification=1");
						$bcc_string = array();
						while ($zoobiz_admin_master_data = mysqli_fetch_array($zoobiz_admin_master)) {
							$bcc_string[] =  $zoobiz_admin_master_data['admin_email'];
						}
	//$bcc_string = implode(",", $bcc_string);
						$to = $bcc_string;
						/*echo "<pre>";print_r($to);exit;*/
						$dashboardLink = $base_url."zooAdmin/welcome";
						$custom_category_name = $custom_category_name;
						$subject ="Category Approval Required";
						include('../mail/memberApprovalEmailToAdmin.php');
						include '../mail_front.php';



						$d->sms_to_admin_on_new_user_registration($zoobiz_admin_master_data['admin_mobile'], $user_full_name,$company_name_c,$ref_by_data );





					} else {
						$androidLink = 'https://play.google.com/store/apps/details?id=com.silverwing.zoobiz';
						$iosLink = 'https://apps.apple.com/us/app/zoobiz/id1550560836';
						$d->sms_to_member_on_registration($user_mobile,$user_full_name,$androidLink,$iosLink);
					}
					
				}




				$d->update("users_master", $a, "user_mobile='$user_mobile' AND user_mobile!='' AND user_mobile!='0'");




				if($business_category_id =='-1' && $business_sub_category_id =="-1"){
					$a11 = array(
						'user_token'=>''
					);
					$d->update("users_master", $a11, "user_id='$org_user_id'  ");

					$response["message"] = "Account Approval Pending......";
					$response["status"] = "202";
					echo json_encode($response);
					exit;
				}
				

				$full_data_query = $d->selectRow("users_master.user_mobile,users_master.alt_mobile,
					users_master.invoice_download,users_master.plan_renewal_date,users_master.facebook,users_master.instagram,users_master.linkedin,users_master.twitter,users_master.whatsapp_privacy,users_master.email_privacy,business_adress_master.adress,business_adress_master.add_latitude,business_adress_master.add_longitude,business_adress_master.pincode,business_adress_master.area_id,

					users_master.member_date_of_birth,users_master.gender, users_master.whatsapp_number, users_master.user_email,users_master.cllassified_mute,users_master.user_id,business_categories.business_category_id,business_sub_categories.business_sub_category_id,users_master.user_full_name,users_master.zoobiz_id,users_master.public_mobile,users_master.user_mobile,users_master.user_profile_pic,business_categories.category_name,business_sub_categories.sub_category_name,user_employment_details.company_email ,user_employment_details.company_name ,user_employment_details.designation,user_employment_details.company_contact_number,user_employment_details.company_website,user_employment_details.company_logo,user_employment_details.company_broucher,user_employment_details.company_profile,user_employment_details.gst_number,business_adress_master.state_id,business_adress_master.city_id , business_adress_master.country_id ","users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master",

					"  business_categories.category_status = 0 and  
					business_adress_master.user_id=users_master.user_id AND   users_master.user_id='$user_id'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  ", "");
				$data_app=mysqli_fetch_array($full_data_query);

				$response["area_id"] = $data_app["area_id"]; 
				$response["pincode"] = $data_app["pincode"];
				$response["add_longitude"] = $data_app["add_longitude"];
				$response["add_latitude"] = $data_app["add_latitude"];
				$response["adress"] = $data_app["adress"];
				$response["country_id"] = $data_app["country_id"]; 
				$response["state_id"] = $data_app["state_id"]; 
				$response["city_id"] = $data_app["city_id"]; 

				$response["company_email"] = $data_app["company_email"];
				$response["designation"] = html_entity_decode($data_app["designation"]);
				if($data_app["company_contact_number"]!=0){
					$response["company_contact_number"] = $data_app["company_contact_number"];
				} else {
					$response["company_contact_number"] = "";
				}
				$response["user_email"] = $data_app["user_email"];

				$response["user_mobile"] = $data_app["user_mobile"];
				$response["company_website"] = $data_app["company_website"];
				if($data_app['company_logo']!=""){
					$response["company_logo"] = $base_url . "img/users/company_logo/" . $data_app['company_logo'];  
				} else {
					$response["company_logo"] ="";
				}

				if($data_app['company_broucher']!=""){
					$response["company_broucher"] = $base_url . "img/users/company_broucher/" . $data_app['company_broucher'];  
				} else {
					$response["company_broucher"] ="";
				}

				if($data_app['company_profile']!=""){
					$response["company_profile"] = $base_url . "img/users/comapany_profile/" . $data_app['company_profile'];  
				} else {
					$response["company_profile"] ="";
				}
				if($data_app["gst_number"]!=""){
					$response["gst_number"] = $data_app["gst_number"];
				} else {
					$response["gst_number"] = "";
				}
				if($data_app["alt_mobile"]==0){
					$response["alt_mobile"] ="";
				}else{
					$response["alt_mobile"] = $data_app["alt_mobile"];
				}
				
				$response["user_id"] = $data_app["user_id"];
				$response["facebook"] = $data_app["facebook"];
				$response["instagram"] = $data_app["instagram"];
				$response["linkedin"] = $data_app["linkedin"];
				$response["twitter"] = $data_app["twitter"];

				if($data_app["cllassified_mute"]=="1"){
					$response["cllassified_mute"]=true;
				} else {
					$response["cllassified_mute"]=false;
				}

				if($data_app["whatsapp_privacy"]=="1"){
					$response["whatsapp_privacy"]=true;
				} else {
					$response["whatsapp_privacy"]=false;
				} 

				if($data_app["email_privacy"]=="1"){
					$response["email_privacy"]=true;
				} else {
					$response["email_privacy"]=false;
				}

				$response["user_email"] = $data_app["user_email"];
				if($data_app["member_date_of_birth"]!=""){
					$response["member_date_of_birth"] = date("d/m/Y", strtotime($data_app["member_date_of_birth"]));
				} else {
					$response["member_date_of_birth"] ="";
				}
				if($data_app["plan_renewal_date"]!=""){
					$response["plan_renewal_date"] = date("d/m/Y", strtotime($data_app["plan_renewal_date"]));
				} else {
					$response["plan_renewal_date"] ="";
				}

				$response["gender"] = $data_app["gender"];
				$response["whatsapp_number"] = $data_app["whatsapp_number"];
				$response["invoice_download"] = $data_app["invoice_download"];
				if($data_app["invoice_download"]=="1"){
					$data_app["invoice_download_url"]=$base_url."paymentReceipt.php?user_id=".$data_app["user_id"]."&download=true";
				} else {
					$data_app["invoice_download_url"]="";
				}

				if($data_app["invoice_download"]=="1"){
					$data_app["invoice_download"]=true;
				} else {
					$data_app["invoice_download"]=false;
				}


				$response["business_category_id"] = $data_app["business_category_id"];
				$response["business_sub_category_id"] = $data_app["business_sub_category_id"];
				$response["user_full_name"] = $data_app["user_full_name"];
				$response["zoobiz_id"] = $data_app["zoobiz_id"];

				if($data_app["public_mobile"]=="0"){
					$response["public_mobile"]=true;
				} else {
					$response["public_mobile"]=false;
				}

				$response["user_mobile"] = $data_app["user_mobile"];
				$response["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];


				if($data_app['user_profile_pic'] ==""){
					$response["user_profile_pic"] ="";
				} else {
					$response["user_profile_pic"] = $base_url . "img/users/members_profile/" . $data_app['user_profile_pic'];
				}


				$response["bussiness_category_name"] = html_entity_decode($data_app["category_name"]);
				$response["sub_category_name"] = html_entity_decode($data_app["sub_category_name"]) . '';
				$response["company_name"] = html_entity_decode($data_app["company_name"]) . '';




				$response["message"] = "Updated Successfully";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				mysqli_query("ROLLBACK");
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else {
			$response["message"] = "wrong tag..".$user_register_temp_new;
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