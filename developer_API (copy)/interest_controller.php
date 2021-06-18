<?php
include_once 'lib.php';


if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));
		
		if ($_POST['bindInterest'] == "bindInterest") {


		   //$q_del=$d->delete("interest_relation_master","member_id='$user_id'");

			$selected=$d->select("interest_relation_master","member_id='$user_id'");
			if (mysqli_num_rows($selected)>5) {
				$response["message"] = "Maximum 5 Interests Allowed.";
				$response["status"] = "201";
				echo json_encode($response);
				exit;
			}

			$selected2=$d->select("interest_relation_master","member_id='$user_id' and interest_id='$interest_id'  ");
			if (mysqli_num_rows($selected2)>0) {
				$response["message"] = "Already Added.";
				$response["status"] = "201";
				echo json_encode($response);
				exit;
			}

		   /*	for ($l=0; $l < count($_POST['interest_id']) ; $l++) { 
		   		$a1= array (

				'interest_id'=> $_POST['interest_id'][$l], 
				'member_id'=> $user_id, 
				'created_at'=> date('Y-m-d H:i:s') 
			);
		   	 
			$q=$d->insert("interest_relation_master",$a1);
		}*/

		$a1= array (

			'interest_id'=> $interest_id, 
			'member_id'=> $user_id, 
			'created_at'=> date('Y-m-d H:i:s') 
		);

		$q=$d->insert("interest_relation_master",$a1);



		if($q==TRUE) {

			$response["message"] = "Interests Bind Successfully.";
			$response["status"] = "200";
			echo json_encode($response);
			exit;
		} else {
			$response["message"] = "Something Went Wrong.";
			$response["status"] = "201";
			echo json_encode($response);
			exit;
		}

	} else if ($_POST['unBindInterest'] == "unBindInterest") {


		$q_del=$d->delete("interest_relation_master","member_id='$user_id' and interest_id='$interest_id' ");


		if($q_del==TRUE) {

			$response["message"] = "Interests Removed.";
			$response["status"] = "200";
			echo json_encode($response);
			exit;
		} else {
			$response["message"] = "Something Went Wrong.";
			$response["status"] = "201";
			echo json_encode($response);
			exit;
		}

	}  else  if ($_POST['AddNewInterest'] == "AddNewInterest") {
		$interest_name= strtolower(trim(addslashes($interest_name)));

		$q=$d->select("interest_master","lower(interest_name)='$interest_name'  and status=0 ");
		if(mysqli_num_rows($q) >0 ){
			$response["message"] = "Interest Already Exists";
			$response["status"] = "201";
			echo json_encode($response);
			exit;
		}

		$interest_name= ucfirst($interest_name);
		$m->set_data('interest_name',$interest_name); 
		$a1= array (

			'interest_name'=> $m->get_data('interest_name'), 
			'added_by_member_id'=> $user_id, 
			'added_by'=> '0', 
			'int_status'=> 'User Added',
			'created_at' =>date("Y-m-d H:i:s")
		);
		$q=$d->insert("interest_master",$a1);


		if($q==TRUE) {


  //email to admin for approval start
			$zoobiz_admin_master = $d->selectRow("*","zoobiz_admin_master", "send_notification=1");
			$bcc_string = array();
			while ($zoobiz_admin_master_data = mysqli_fetch_array($zoobiz_admin_master)) {
				$bcc_string[] =  $zoobiz_admin_master_data['admin_email'];
			}

			$to = $bcc_string;

			$dashboardLink = $base_url."zooAdmin/welcome";
			$interest_name = $interest_name;

			$uquery=$d->select("users_master","user_id='$user_id'  and  active_status = 0 ");
			$uquery_data = mysqli_fetch_array($uquery);  

			$user_name = $uquery_data['user_full_name'];
			$subject ="Interest Approval Required";
			include('../mail/interestApprovalEmailToAdmin.php');
			include '../mail_front.php';


			$response["message"] = "Interest Approval Pending.";
			$response["status"] = "200";
			echo json_encode($response);
			exit;
		} else {
			$response["message"] = "Something Went Wrong.";
			$response["status"] = "201";
			echo json_encode($response);
			exit;
		}

	}  else  if ($_POST['getInterest'] == "getInterest") {

		$response["interests"] = array();

		$sel_int_array  = array('0');
		$selected_qry=$d->select("interest_relation_master","member_id='$user_id'   ");
		while ($selected_data=mysqli_fetch_array($selected_qry)) {
			$sel_int_array[] = $selected_data['interest_id'];
		}

		$sel_int_array = implode(",", $sel_int_array);

		$meq = $d->selectRow(" *
			","interest_master  ", "status=0 and (int_status !='User Added' and int_status !='Admin Rejected' ) and interest_id not in ($sel_int_array) ");
		if( mysqli_num_rows($meq) >0 ){ 
			while ($data_app=mysqli_fetch_array($meq)) {
				$interests = array();
				$interests["interest_id"] = $data_app["interest_id"];
				$interests["interest_name"] = html_entity_decode($data_app["interest_name"]) . '';

				array_push($response["interests"], $interests);
			}

			$response["message"] = "Interest Data.";
			$response["status"] = "200";
			echo json_encode($response);
			exit;
		} else {
			$response["message"] = "No Interests Found.";
			$response["status"] = "201";
			echo json_encode($response);
			exit;
		}

	}    else {
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