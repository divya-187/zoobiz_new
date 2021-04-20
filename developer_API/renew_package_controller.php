<?php
include_once 'lib.php';

if (isset($_POST) && !empty($_POST)) {
//echo "<pre>";print_r($_REQUEST);exit;
	if ($key == $keydb) {
		$response = array();
		extract(array_map("test_input", $_POST));
		$today = date('Y-m-d');


		if (isset($renew_package) && $renew_package == 'renew_package' && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($plan_id, FILTER_VALIDATE_INT) == true ) {
			$con->autocommit(FALSE);
			$q = $d->selectRow("*","package_master", "package_id='$plan_id'", "");
			$row1 = mysqli_fetch_array($q);
			$no_month=$row1['no_of_month'];
			if($row1["time_slab"] == 1){
				$plan_renewal_date=date('Y-m-d', strtotime(' +'.$no_month.' days'));
			} else {
				$plan_renewal_date=date('Y-m-d', strtotime(' +'.$no_month.' months'));
			}

		 
			$package_name = $row1['package_name'];
			$no_month = $row1['no_of_month'];
			$package_amount = $row1['package_amount'];

			if($row1['gst_slab_id'] !="0"){
      $gst_slab_id = $row1['gst_slab_id'];
           $gst_master=$d->select("gst_master","slab_id = '$gst_slab_id'","");
           $gst_master_data=mysqli_fetch_array($gst_master);
           $gst_amount= (($row1["package_amount"]*$gst_master_data['slab_percentage']) /100);
    } else {
            $gst_amount= 0 ;
    }
     $package_amount=number_format($row1["package_amount"]+$gst_amount,2,'.','');

	
			$package_amount_new= $row1['package_amount'];
			$q_user = $d->selectRow("*","users_master", "user_id='$user_id'", "");
			$user_data = mysqli_fetch_array($q_user);

			$m->set_data('company_id', $user_data['company_id']);
			$m->set_data('user_mobile', $user_data['user_mobile']);
			$m->set_data('user_first_name', $user_data['user_first_name']);
			$m->set_data('user_last_name', $user_data['user_last_name']);
			$m->set_data('user_email', $user_data['user_email']);
			$m->set_data('razorpay_order_id', $razorpay_order_id);
			$m->set_data('razorpay_payment_id', $razorpay_payment_id);
			$m->set_data('razorpay_signature', $razorpay_signature);
			$m->set_data('plan_id', $plan_id);
			if(isset($amount)){
				$ios_transection_amount = $amount;
			} else {
				$ios_transection_amount = "0.00";
			}
			if(!isset($payment_mode) && $payment_mode !=''){
				$payment_mode = "Razorpay App";
			}

			if(isset($device)){
				$payment_mode .=" ".$device;
			}
			$paymentAry = array(
				'user_id' => $user_id,
				'company_id' =>$m->get_data('company_id'),
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
				'razorpay_payment_id' => $m->get_data('razorpay_payment_id'),
				'razorpay_order_id' => $m->get_data('razorpay_order_id'),
				'razorpay_signature' => $m->get_data('razorpay_signature'),
				'paid_amount_with_gst' => $package_amount
			);
			$q3 = $d->insert("transection_master", $paymentAry);
			$transaction_id = $con->insert_id;
			if (  $q3  ) {

				$historyAry = array(
				'user_id' => $user_id,
				'plan_id' => $m->get_data('plan_id'),
				'payment_mode' => $payment_mode,
				'device' => $device,
				'ios_renew_amount'=> $ios_transection_amount,
				'renew_date' => date("Y-m-d H:i:s"),
				'transaction_id' => $transaction_id,
				'renew_amount' => $package_amount
				);
				$q3 = $d->insert("plan_renew_master", $historyAry);

                $plan_renewal_date_old = date("Y-m-d", strtotime($user_data['plan_renewal_date']));
                $m->set_data('plan_renewal_date',$plan_renewal_date);
				$m->set_data('plan_renewal_date_old',$plan_renewal_date_old);
				$user_array =array(
					'plan_renewal_date'=> $m->get_data('plan_renewal_date'),
					'plan_renewal_date_old'=> $m->get_data('plan_renewal_date_old') 
				);
				$q=$d->update("users_master",$user_array," user_id='$user_id'"); 
				$con->commit();
				$response["message"] = "Payment Successful";
				$d->insert_myactivity($user_id,"0","", "Payment Successful","activity.png");
				$response["status"] = "200";
				echo json_encode($response);
			}
		} else {
			$response["message"] = "wrong tag..";
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