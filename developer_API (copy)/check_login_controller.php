<?php
include_once 'lib.php';

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));
		$today = date('Y-m-d');
		$todayTime = date('Y-m-d H:i:s');

		if (isset($check_login) && $check_login == 'check_login' && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($user_mobile, FILTER_VALIDATE_INT) == true) {

			$q = $d->select("users_master", "user_id='$user_id' AND user_mobile='$user_mobile' AND user_id!=0 AND office_member=0 AND active_status=0 ");

			if (mysqli_num_rows($q) > 0) {
				$data = mysqli_fetch_array($q);
				$plan_expire_date = $data['plan_renewal_date'];

				$qqq = $d->select("app_version_master", "");

				$dataqqq = mysqli_fetch_array($qqq);

				if (mysqli_num_rows($qqq) > 0) {

					if (strtolower($device) == 'android' && $dataqqq['version_code_android'] > $version_code) {
						$response["message"] = "Please Update Latest Verstion $dataqqq[version_code_android_view]";
						$response["status"] = "203";
						echo json_encode($response);
						exit();
					}
					if (strtolower($device) == 'ios' && $dataqqq['version_code_ios'] > $version_code) {
						$response["message"] = "Please Update Latest Verstion $dataqqq[version_code_ios_view]";
						$response["status"] = "203";
						echo json_encode($response);
						exit();
					}
				}

				if ($user_token != '') {
					$msg = "";
					if ($data['user_token'] == '') {
						$msg = "Login authentication faild, please try again";
					}
					if ($data['user_token'] != $user_token) {
						$msg = "Detected login already with other device please try login again";
					}
					if ($today > $plan_expire_date) {
						$msg = "Your Plan Has been Expired on $plan_expire_date, Please Contact ZooBiz Sales Team";
					}
					if ($data['active_status'] == 1) {
						$msg = "Your Account Is Deactive, Please Contact ZooBiz Support Team";
					}
					if ($msg != "") {
						$response["message"] = $msg;
						$response["status"] = "201";
						echo json_encode($response);
						exit();
					}
				}

				$a = array(
					'last_login' => $todayTime,
					'version_code' => $version_code,
				);

				$d->update("users_master", $a, "user_id='$user_id'");
				// /notification_type=0 AND
				$q2 = $d->select("user_notification", "user_id='$user_id' AND (notification_type=0 or notification_type=2  or notification_type=3)  AND   read_status=0  and status='Active' ");
				// /notification_type=1 AND
				$q3 = $d->select("user_notification", "user_id='$user_id' AND notification_type=1 AND   read_status=0  and status='Active'");
				//$q4 = $d->getRecentChatMemberNew("chat_master",$user_id); //$d->select("chat_master", "msg_for='$user_id' AND msg_status=0");

				  $chatCount=$d->count_data_direct("chat_id","chat_master","msg_for='$user_id'   AND msg_status='0'");


				$tq = $d->selectRow("timeline_id", "timeline_master", "active_status = 0 ", "ORDER BY timeline_id DESC ");
				$timelineData = mysqli_fetch_array($tq);
				if ($timelineData > 0) {
					$last_timeline_id = $timelineData['timeline_id'] . '';
				} else {
					$last_timeline_id = '0';
				}

				$qa = $d->select("advertisement_master", "");
				$advData = mysqli_fetch_array($qa);

				$response["view_status"] = $advData['view_status'];
				$response["active_status"] = $advData['active_status'];
				$response["advertisement_url"] = $base_url . "img/sliders/" . $advData['advertisement_url'];

				$response["unread_notification"] = mysqli_num_rows($q2) . '';
				$response["unread_timeline_notification"] = mysqli_num_rows($q3) . '';
				$response["unread_chat"] =$chatCount.'';// mysqli_num_rows($q4) . '';
				$response["message"] = "Login Successful.";
				$response["status"] = "200";
				$response["last_timeline_id"] = $last_timeline_id;
				echo json_encode($response);

			} else {

				$response["message"] = "No User Found.";
				$response["status"] = "201";
				echo json_encode($response);

			}

		} else {
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