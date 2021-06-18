<?php
include_once 'lib.php';


if(isset($_POST) && !empty($_POST)){
	extract(array_map("test_input" , $_POST));
	if(isset($_POST["loginUser"])) {
		$mobile=mysqli_real_escape_string($con, $mobile);
		if (strlen($mobile)<10) {
		  $response["message"]="Please Enter Valid Mobile Number";
		  $response["status"]="201";
		  echo json_encode($response);
		  exit();
		}
		$q=$d->select("zoobiz_admin_master","admin_mobile='$mobile'");
		$data = mysqli_fetch_array($q); 
		if ($data > 0) {
			$mobile=$data['admin_mobile'];
			$login_name=$data['admin_name'];
			$digits = 4;
	        $otp= rand(pow(10, $digits-1), pow(10, $digits)-1);
			$token = bin2hex(openssl_random_pseudo_bytes(16));
			$m->set_data('mobile',$mobile);
			$m->set_data('otp',$otp);
			$m->set_data('date',date('Y-m-d H:i:s'));

				$a1= array (
					'otp'=> $m->get_data('otp'),
					'date'=> $m->get_data('date'),
				);
				$d->update('zoobiz_admin_master',$a1,"admin_mobile='$mobile'");
			
	        $message = $otp." is your OTP to login ZooBiz App";
		    $d->send_otp($mobile,$otp);
			$response["message"]="OTP Send Successfully";
			$response["status"]="200";
			echo json_encode($response);
			exit();
		}else {
			 $response["message"]="Mobile Number Not Register";
	          $response["status"]="201";
	          echo json_encode($response);
	          exit();
		}
	} else if (isset($user_verify) && $user_verify == 'user_verify' && filter_var($otp, FILTER_VALIDATE_INT) == true && strlen($otp) == 4) {

		$mobile = mysqli_real_escape_string($con, $mobile);
		$otp = mysqli_real_escape_string($con, $otp);
		
		$o=$d->select("zoobiz_admin_master","admin_mobile='$mobile' AND otp='$otp'");
		if(mysqli_num_rows($o) == 1){
			$user_data = mysqli_fetch_array($o);
				if ($user_data == TRUE && mysqli_num_rows($o) == 1) {
						$m->set_data('fcm_token', $fcm_token);
						$a = array('otp' => "",
							'fcm_token' => $m->get_data('fcm_token')
						);
						$d->update("zoobiz_admin_master", $a, "admin_mobile='$mobile' ");
						$zoobiz_admin_id= $user_data['zoobiz_admin_id'];
						$response["zoobiz_admin_id"] = $user_data['zoobiz_admin_id'];
						$response["company_id"] = $user_data['company_id'];
						$response["role_id"] = $user_data['role_id'];
						$response["admin_name"] = $user_data['admin_name'];
						$response["admin_email"] = $user_data['admin_email'];
						$response["mobile"] = $user_data['admin_mobile'];

						$count5=$d->sum_data("transaction_amount","transaction_master","transaction_type=1");
	                 	$row=mysqli_fetch_array($count5);
	                    $asif=$row['SUM(transaction_amount)'];
	                    $totalIncome=number_format($asif,2,'.','');

	                    $count1=$d->sum_data("transaction_amount","transaction_master","transaction_type=0");
	                 	$row1=mysqli_fetch_array($count1);
	                    $asif1=$row1['SUM(transaction_amount)'];
	                    $totalExpense=number_format($asif1,2,'.','');

	                    $avBlance= $totalIncome-$totalExpense;

	                    $count2=$d->sum_data("transaction_amount","transaction_master","zoobiz_admin_id='$zoobiz_admin_id' AND transaction_type=1");
	                 	$row2=mysqli_fetch_array($count2);
	                    $asif2=$row2['SUM(transaction_amount)'];
	                    $myIncome=number_format($asif2,2,'.','');

	                    $count3=$d->sum_data("transaction_amount","transaction_master","zoobiz_admin_id='$zoobiz_admin_id'  AND transaction_type=0");
	                 	$row3=mysqli_fetch_array($count3);
	                    $asif3=$row3['SUM(transaction_amount)'];
	                    $myExpense=number_format($asif3,2,'.','');
	                    
	                     $response["totalIncome"]=$totalIncome;
	                     $response["totalExpense"]=$totalExpense;
	                     $response["available_balance"]=$avBlance.'';
	                     $response["myIncome"]=$myIncome;
	                     $response["myExpense"]=$myExpense;
						
						$response["message"] = "Login Successfully";
						$response["status"] = "200";
						echo json_encode($response);

				} else {
					$response["message"] = "Invalid User";
					$response["status"] = "201";
					echo json_encode($response);
				}
			
		}else{
			$response["message"] = "OTP not match, Please try again";
			$response["status"] = "201";
			echo json_encode($response);
		}
	}else if(isset($resendOtp) && $resendOtp == 'resendOtp') {
		$mobile=mysqli_real_escape_string($con, $mobile);
		if (strlen($mobile)<10) {
		  $response["message"]="Please Enter Valid Mobile Number";
		  $response["status"]="201";
		  echo json_encode($response);
		  exit();
		}
		$q=$d->select("zoobiz_admin_master","admin_mobile='$mobile'");
		$data = mysqli_fetch_array($q); 
		if ($data > 0 && $data['otp']!=null) {
			$otp = $data['otp'];
	        $message = $otp." is your OTP to login Zoobiz App";
		    $d->send_otp($mobile,$otp);
			$response["message"]="OTP Send Successfully";
			$response["status"]="200";
			echo json_encode($response);
			exit();
		}else{
			$response["message"]="OTP Expired. Please Login Again";
			$response["status"]="201";
			echo json_encode($response);
			exit();
		}
	}else if(isset($logout) && $logout == 'logout') {
		$updata['fcm_token'] = '';
		$d->update('zoobiz_admin_master',$updata,"admin_mobile='$mobile'");
		$response["message"] = "Logged Out Successfully.";
		$response["status"] = "200";
		echo json_encode($response);
	} else {
		$response["message"] = "Wrong Tag";
		$response["status"] = "201";
		echo json_encode($response);
	}
}else{
	$response["message"] = "Invalid Request";
	$response["status"] = "201";
	echo json_encode($response);
}

?>