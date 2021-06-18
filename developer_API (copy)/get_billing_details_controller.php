<?php
include_once 'lib.php';

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));

		if ($_POST['get_billing_info'] == "get_billing_info" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$qA = $d->select("user_employment_details", "user_id='$user_id'", "");

			if (mysqli_num_rows($qA) > 0) {

				$data = mysqli_fetch_array($qA);

				$response["employment_id"] = html_entity_decode($data['employment_id']);
				$response["company_name"] = html_entity_decode($data['company_name']);
				$response["billing_address"] = html_entity_decode($data['billing_address']);
				$response["company_website"] = html_entity_decode($data['company_website']);

				if($data['company_contact_number']==0){
					$response["company_contact_number"] ="";
				} else {
					$response["company_contact_number"] = $data['company_contact_number'];
				}

				if($data['billing_contact_person']==0){
					$response["billing_contact_person"] ="";
				} else {
					$response["billing_contact_person"] = $data['billing_contact_person'];
				}
				
				$response["gst_number"] = html_entity_decode($data['gst_number']);
				if($data['billing_pincode']==0){
					$response["billing_pincode"] ="";
				} else {
					$response["billing_pincode"] = "" . $data['billing_pincode'];
				}
				
				$response["bank_name"] = "" . $data['bank_name'];
				if($data['bank_account_number']==0){
					$response["bank_account_number"] = "" ;
				} else {
					$response["bank_account_number"] = "" . $data['bank_account_number'];
				}
				
				$response["ifsc_code"] = $data['ifsc_code'] . '';
				 
				$response["billing_contact_person_name"] = "" . $data['billing_contact_person_name'];

				$response["message"] = "Billing Information";
				$response["status"] = "200";
				echo json_encode($response);
			} else {

				$response["message"] = "No Billing Information Found";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['add_billing_info'] == "add_billing_info" && filter_var($user_id, FILTER_VALIDATE_INT) == true) {

			$m->set_data('user_id', $user_id);
			$m->set_data('company_name', $company_name);
			$m->set_data('billing_address', $billing_address);
			$m->set_data('company_website', $company_website);
			$m->set_data('company_contact_number', $company_contact_number);
			$m->set_data('gst_number', $gst_number);
			$m->set_data('billing_pincode', $billing_pincode);
			$m->set_data('bank_name', $bank_name);
			$m->set_data('bank_account_number', $bank_account_number);
			$m->set_data('ifsc_code', $ifsc_code);
			$m->set_data('billing_contact_person', $billing_contact_person);
			$m->set_data('billing_contact_person_name', $billing_contact_person_name);

			$a = array(
				'user_id' => $m->get_data('user_id'),
				'company_name' => $m->get_data('company_name'),
				'billing_address' => $m->get_data('billing_address'),
				'company_website' => $m->get_data('company_website'),
				'company_contact_number' => $m->get_data('company_contact_number'),
				'gst_number' => $m->get_data('gst_number'),
				'billing_pincode' => $m->get_data('billing_pincode'),
				'bank_name' => $m->get_data('bank_name'),
				'bank_account_number' => $m->get_data('bank_account_number'),
				'ifsc_code' => $m->get_data('ifsc_code'),
				'billing_contact_person' => $m->get_data('billing_contact_person'),
				'billing_contact_person_name' => $m->get_data('billing_contact_person_name'),
			);

			if ($employment_id == 0) {
				$d->insert("user_employment_details", $a, "");
				$d->insert_myactivity($user_id,"0","", "Billing Detail Added","activity.png");
				$response["message"] = "Added Successfully";
			} else {
				$d->update("user_employment_details", $a, "employment_id='$employment_id'");
				$d->insert_myactivity($user_id,"0","", "Billing Detail Updated","activity.png");
				$response["message"] = "Updated Successfully";

			}

			if ($d == true) {
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}

		} else {

			$response["message"] = "Wrong tag";
			$response["status"] = "201";
			echo json_encode($response);
		}
	} else {
		$response["message"] = "wrong api key.";
		$response["status"] = "201";
		echo json_encode($response);
	}
}
