<?php
include_once 'lib.php';


if (isset($_POST) && !empty($_POST)) {

	if ($key == $keydb) {

		$response = array();
		extract(array_map("test_input", $_POST));
		
		if ($_POST['getSeasonalGreetings'] == "getSeasonalGreetings") {

			if(isset($user_id)){
            $d->insert__feature_clicked_log('9',$user_id);
        }

			$response["seasonalGreetings"] = array();



			$today = date("Y-m-d"); 

			$meq = $d->selectRow(" * ","seasonal_greet_master,seasonal_greet_image_master", "seasonal_greet_image_master.seasonal_greet_id =seasonal_greet_master.seasonal_greet_id AND   seasonal_greet_master.status='Active' AND  seasonal_greet_image_master.status='Active'  and ( seasonal_greet_master.is_expiry ='No' OR  seasonal_greet_master.end_date >= CURDATE() ) GROUP BY  seasonal_greet_master.seasonal_greet_id  order by order_date asc ");
			if( mysqli_num_rows($meq) >0 ){ 
				while ($data_app=mysqli_fetch_array($meq)) {
					$seasonalGreetings = array();
					$seasonalGreetings["seasonal_greet_id"] = $data_app["seasonal_greet_id"];
					$seasonalGreetings["title"] = html_entity_decode($data_app["title"]) . '';

					/*if($data_app["is_expiry"]=="Yes"){
						$seasonalGreetings["is_expiry"] =true;
					} else{
						$seasonalGreetings["is_expiry"] =false;
					}*/
					

					/*if($data_app["is_expiry"]=="Yes"){
						$seasonalGreetings["start_date"] =date("d-m-Y", strtotime($data_app["start_date"]));
						$seasonalGreetings["end_date"] = date("d-m-Y", strtotime($data_app["end_date"])); 
					} else {
						$seasonalGreetings["start_date"] ="";
						$seasonalGreetings["end_date"] = ""; 
					}*/




					$child_qry = $d->selectRow(" * ","seasonal_greet_image_master", "status='Active' and  seasonal_greet_id = '$data_app[seasonal_greet_id]'");
					$seasonalGreetings["image_array"] = array();
					if( mysqli_num_rows($child_qry) >0 ){ 
						while ($child_data=mysqli_fetch_array($child_qry)) {
							$image_array = array();

							$image_array["main_title"] = html_entity_decode($data_app["title"]) . '';

							$image_array['seasonal_greet_image_id'] = $child_data['seasonal_greet_image_id'] ;

							if($child_data['cover_image'] ==""){
								$image_array["cover_image"] ="";
							} else {
								$image_array["cover_image"] = $base_url . "img/promotion/" . $child_data['cover_image'];
							}

							$image_array['page_alignment'] = $child_data['page_alignment'] ;
							$image_array['logo_alignment'] = $child_data['logo_alignment'] ;
							$image_array['to_text_alignment'] = $child_data['to_text_alignment'] ;
							$image_array['from_text_alignment'] = $child_data['from_text_alignment'] ;
							$image_array['title_alignment'] = $child_data['title_alignment'] ;
							$image_array['description_alignment'] = $child_data['description_alignment'] ;
							$image_array['background_image'] = $child_data['background_image'] ;
							if($child_data['background_image'] ==""){
								$image_array["background_image"] ="";
							} else {
								$image_array["background_image"] = $base_url . "img/promotion/" . $child_data['background_image'];
							}


							$image_array['title_on_image'] = html_entity_decode($child_data['title_on_image']) ;
							$image_array['title_font_color'] = $child_data['title_font_color'] ;
							$image_array['title_font_name'] = $child_data['title_font_name'] ;
							$image_array['description_on_image'] = html_entity_decode($child_data['description_on_image']);
							$image_array['description_font_color'] = $child_data['description_font_color'] ;
							$image_array['description_font_name'] = $child_data['description_font_name'] ;
							$image_array['show_to_name'] = $child_data['show_to_name'] ;

							if($child_data['show_to_name']=="Yes"){
								$image_array['to_name_font_color'] = $child_data['to_name_font_color'] ;
								$image_array['to_name_font_name'] = $child_data['to_name_font_name'] ;
								$image_array['to_name_font_size'] = $child_data['to_name_font_size'] ;
							} else {
								$image_array['to_name_font_color'] = "";
								$image_array['to_name_font_name'] = "";
								$image_array['to_name_font_size'] = "";
							}

							if($child_data["show_to_name"]=="Yes"){
						$image_array["show_to_name"] =true;
					} else{
						$image_array["show_to_name"] =false;
					}



							$image_array['show_from_name'] = $child_data['show_from_name'] ;

							if($child_data['show_from_name']=="Yes"){
								$image_array['from_name_font_color'] = $child_data['from_name_font_color'] ;
								$image_array['from_name_font_name'] = $child_data['from_name_font_name'] ;
								$image_array['from_name_font_size'] = $child_data['from_name_font_size'] ;
							} else {
								$image_array['from_name_font_color'] = "";
								$image_array['from_name_font_name'] = "";
								$image_array['from_name_font_size'] ="";
							}

				    if($child_data["show_from_name"]=="Yes"){
						$image_array["show_from_name"] =true;
					} else{
						$image_array["show_from_name"] =false;
					}


							//$image_array['status'] = $child_data['status'] ;
							array_push($seasonalGreetings["image_array"], $image_array);
						}
					}

					array_push($response["seasonalGreetings"], $seasonalGreetings);
				}

				$response["message"] = "Seasonal Greetings Data.";
				$response["status"] = "200";
				echo json_encode($response);
				exit;
			} else {
				$response["message"] = "No Seasonal Greetings Found.";
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