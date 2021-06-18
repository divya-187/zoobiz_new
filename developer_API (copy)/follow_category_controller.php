<?php
include_once 'lib.php';

 

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {
 
		$response = array();
		extract(array_map("test_input", $_POST));

		if ($_POST['followCategory'] == "followCategory") {

			/*$last_auto_id = $d->last_auto_id("category_follow_master");
			$res = mysqli_fetch_array($last_auto_id);
			$category_follow_id = $res['Auto_increment'];*/

			$m->set_data('category_id', $category_id);
			$m->set_data('user_id', $user_id);
			$m->set_data('created_at', date("Y-m-d H:i:s"));

			$a = array(
				'category_id' => $m->get_data('category_id'),
				'user_id' => $m->get_data('user_id'),
				'created_at' => $m->get_data('created_at'),
			);

			$q = $d->insert("category_follow_master", $a);
			$category_follow_id = $con->insert_id;
			if ($q > 0) {
				$d->insert_myactivity($user_id,"0","",html_entity_decode($category_name) ." Category Followed by you.","activity.png");
				$response["message"] = "Followed " . html_entity_decode($category_name) . ".";
				$response["status"] = "200";
				$response["category_follow_id"] = $category_follow_id;
				echo json_encode($response);
			} else {
				$response["message"] = "Something Went Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} else if ($_POST['unFollowCategory'] == "unFollowCategory") {

			$q = $d->delete("category_follow_master", "category_follow_id = '$category_follow_id'");

			if ($q == TRUE) {
				$d->insert_myactivity($user_id,"0","",html_entity_decode($category_name) ." Category Unfollowed by you.","activity.png");
				$response["message"] = "Unfollowed " . html_entity_decode($category_name) . ".";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something Went Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		} 

else {
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