<?php
include_once 'lib.php';

if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {
		$response = array();
		extract(array_map("test_input", $_POST));
		$today = date("Y-m-d");
		if ($_POST['getCard'] == "getCard") {

			$q = $d->selectRow("card_id,card_empty,card_bg,is_logo","visiting_card_master", "active_status=0", "ORDER BY card_id ASC LIMIT 15");

			if (mysqli_num_rows($q) > 0) {

				$response["visit_card"] = array();

				while ($data = mysqli_fetch_array($q)) {
					$visit_card = array();
					$visit_card["card_id"] = $data['card_id'];
					$visit_card["card_bg"] = $base_url . 'img/visitcard/' . $data['card_empty'];
					$visit_card["card_empty"] = $base_url . 'img/visitcard/' . $data['card_bg'];
					if ($data['is_logo'] == 0) {
						$visit_card["is_logo"] = false;

					} else {
						$visit_card["is_logo"] = true;

					}

					array_push($response["visit_card"], $visit_card);

				}

				$response["message"] = "Visiting Cards";
				$response["status"] = "200";
				echo json_encode($response);

			} else {
				$response["message"] = "No Card Availble.";
				$response["status"] = "201";
				echo json_encode($response);

			}
		} else {
			$response["message"] = "wrong tag";
			$response["status"] = "201";
			echo json_encode($response);
		}
	} else {
		$response["message"] = "wrong api key";
		$response["status"] = "201";
		echo json_encode($response);

	}
}
