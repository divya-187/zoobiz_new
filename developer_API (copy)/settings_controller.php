<?php
include_once 'lib.php';

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {


		 
		$response = array();
		extract(array_map("test_input", $_POST));
		$today = date('Y-m-d');


		
		  if ($_POST['changeMobilePrivacy'] == "changeMobilePrivacy" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$m->set_data('public_mobile', $public_mobile);
			$a = array('public_mobile' => $m->get_data('public_mobile'));
			$q = $d->update("users_master", $a, "user_id='$user_id'");

			if ($q == true) {
				if ($public_mobile == 1) {
					$response["message"] = "Mobile Number Public";
					$d->insert_myactivity($user_id,"0","", "Mobile Number Privacy set to public","activity.png");
				} else {
					$response["message"] = "Mobile Number Private";
					$d->insert_myactivity($user_id,"0","", "Mobile Number Privacy set to private","activity.png");
				}
				// $response["message"] = "Mobile Privacy Changed ";


				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else  if ($_POST['chatAlerts'] == "chatAlerts" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$m->set_data('chat_alerts', $chat_alerts);
			$a = array('chat_alerts' => $m->get_data('chat_alerts'));
			$q = $d->update("users_master", $a, "user_id='$user_id'");

			if ($q == true) {
				if ($chat_alerts == 'true') {
					$response["message"] = "Chat Alerts On";
					$d->insert_myactivity($user_id,"0","", "Chat Alerts On","activity.png");
				} else {
					$response["message"] = "Chat Alerts Off";
					$d->insert_myactivity($user_id,"0","", "Chat Alerts Off","activity.png");
				}
				// $response["message"] = "Mobile Privacy Changed ";


				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['changeOfficePrivacy'] == "changeOfficePrivacy" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$m->set_data('company_contact_number_privacy', $company_contact_number_privacy);
			$a = array('company_contact_number_privacy' => $m->get_data('company_contact_number_privacy'));
			$q = $d->update("user_employment_details", $a, "user_id='$user_id'");

			if ($q == true) {
				if ($company_contact_number_privacy == 1) {
					$response["message"] = "Office Number Private";
					$d->insert_myactivity($user_id,"0","", "Office Number Privacy set to Private","activity.png");
				} else {
					$response["message"] = "Office Number Public";
					$d->insert_myactivity($user_id,"0","", "Office Number Privacy set to Public","activity.png");
				}
				// $response["message"] = "Mobile Privacy Changed ";


				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['changeTimelineAlert'] == "changeTimelineAlert" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$m->set_data('timeline_alert', $timeline_alert);
			$a = array('timeline_alert' => $m->get_data('timeline_alert'));
			$q = $d->update("users_master", $a, "user_id='$user_id'");

			if ($q == true) {
				if ($timeline_alert == 1) {
					$response["message"] = "Timeline Notification Off";
					$d->insert_myactivity($user_id,"0","", "Timeline Notification set Off","activity.png");
				} else {
					$response["message"] = "Timeline Notification On";
					$d->insert_myactivity($user_id,"0","", "Timeline Notification set On","activity.png");
				}
				// $response["message"] = "Mobile Privacy Changed ";


				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else  if ($_POST['changeWahtasappPrivacy'] == "changeWahtasappPrivacy" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$m->set_data('whatsapp_privacy', $whatsapp_privacy);
			$a = array('whatsapp_privacy' => $m->get_data('whatsapp_privacy'));
			$q = $d->update("users_master", $a, "user_id='$user_id' ");

			if ($q == true) {
				if ($whatsapp_privacy == 0) {
					$response["message"] = "Whatsapp Number Public";
					$d->insert_myactivity($user_id,"0","", "Whatsapp Number Privacy set to public","activity.png");
				} else {
					$response["message"] = "Whatsapp Number Private";
					$d->insert_myactivity($user_id,"0","", "Whatsapp Number Privacy set to private","activity.png");
				}
				// $response["message"] = "Mobile Privacy Changed ";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['changeEmailIdPrivacy'] == "changeEmailIdPrivacy" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$m->set_data('email_privacy', $email_privacy);
			$a = array('email_privacy' => $m->get_data('email_privacy'));
			$q = $d->update("users_master", $a, "user_id='$user_id' ");

			if ($q == true) {
				if ($email_privacy == 0) {
					$response["message"] = "Email Public";
					$d->insert_myactivity($user_id,"0","", "Email ID Privacy set to public","activity.png");
				} else {
					$response["message"] = "Email Private";
					$d->insert_myactivity($user_id,"0","", "Email ID Privacy set to private","activity.png");
				}
				// $response["message"] = "Mobile Privacy Changed ";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['cllassifiedMuteStatus'] == "cllassifiedMuteStatus" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$m->set_data('cllassified_mute', $cllassified_mute);
			$a = array('cllassified_mute' => $m->get_data('cllassified_mute'));
			$q = $d->update("users_master", $a, "user_id='$user_id'  ");

			if ($q == true) {
				if ($cllassified_mute == 1) {
					$response["message"] = "Classified Notification Off";
					$d->insert_myactivity($user_id,"0","", "All Classified Muted","activity.png");
				} else {
					$response["message"] = "Classified Notification On";
					$d->insert_myactivity($user_id,"0","", "All Classified Un Muted","activity.png");
				}
				// $response["message"] = "Mobile Privacy Changed ";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		}   else {
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