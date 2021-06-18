<?php
include_once 'lib.php';
if (isset($_POST) && !empty($_POST)) {
if ($key == $keydb) {
$response = array();
extract(array_map("test_input", $_POST));
$today = date('Y-m-d');


if (isset($getEventData) && $getEventData == 'getEventData'   ) {

	if(isset($user_id)){
				$d->insert__feature_clicked_log('3',$user_id);
			}

$today = date("Y-m-d");
// /
$promotion_master=$d->select("promotion_master"," '$today' between `event_date` and `event_end_date` and  status = 0 order by order_date asc   ","");
if(mysqli_num_rows($promotion_master)  > 0    ){
$response["eventDetails"] = array();
while ($promotion_data = mysqli_fetch_array($promotion_master)) {


	$promotion_id = $promotion_data["promotion_id"];
	$eventDetails = array();
	$eventDetails["promotion_id"] = $promotion_data["promotion_id"];
	$eventDetails["event_name"] = $promotion_data["event_name"];
	$eventDetails["event_date"] = date("d M Y", strtotime($promotion_data["event_date"] )) ;
	$eventDetails["description"] = $promotion_data["description"];
	$eventDetails["event_status"] ="0"; // $promotion_data["event_status"];
	$eventDetails["text_color"] = $promotion_data["text_color"];
	$text_color = $promotion_data["text_color"];

	$event_status = $promotion_data["event_status"];
	$event_status_desc = "";
	if( strtotime($today) == strtotime($promotion_data["event_date"]) && $promotion_data["auto_expire"] == 0  ){
		$event_status_desc = "Running";
		 $eventDetails["event_status"] = "0";
		 $event_status ="0";
	} else 


	if($promotion_data["event_status"] == 0){
		$event_status_desc = "Running";
	} else if($promotion_data["event_status"] == 1){
		$event_status_desc = "Upcoming";
	} else if($promotion_data["event_status"] == 2){
		$event_status_desc = "Expired";
	}

	$event_status = $promotion_data["event_status"] = 0;


	$eventDetails["event_status_desc"] =$event_status_desc;
	$eventDetails["event_image"] =$base_url . "img/promotion/" . $promotion_data['event_image'];

	$eventDetails["event_frame"] =$base_url . "img/promotion/" . $promotion_data['event_frame'];

if($promotion_data['event_image']==""){
	$event_image  ="";
} else
	$event_image  =$base_url . "img/promotion/" . $promotion_data['event_image'];
if($promotion_data['event_frame']==""){
	$event_frame  ="";
} else
	$event_frame  =$base_url . "img/promotion/" . $promotion_data['event_frame'];
	$event_date = date("d M Y", strtotime($promotion_data["event_date"] )) ;



	$promotion_rel_frame_master=$d->select("promotion_rel_frame_master,promotion_frame_master "," 	promotion_frame_master.promotion_frame_id = promotion_rel_frame_master.promotion_frame_id and    promotion_rel_frame_master.promotion_id ='$promotion_id' and  promotion_rel_frame_master.status = 0   "," group by promotion_rel_frame_master.promotion_id");
 //$response["frameDetails"] = array();
	$frameDetails = array();
	$counter_data = 1;
	if(mysqli_num_rows($promotion_rel_frame_master)  > 0    ){
		
		while ($promotion_rel_frame_master_data = mysqli_fetch_array($promotion_rel_frame_master)) {
			
			if($counter_data==1){ 
				$counter_data++;
			$frameDetails["promotion_id"] = $promotion_id;
			$frameDetails["promotion_frame_id"] =$promotion_rel_frame_master_data['promotion_frame_id'];
			//$frameDetails["promotion_frame"] =$base_url . "img/promotion/promotion_frames/" . $promotion_rel_frame_master_data['promotion_frame'];
			$frameDetails["promotion_frame"] =$event_frame;


			$frameDetails["event_image"] =$event_image;
			$frameDetails["event_frame"] =$event_frame;
 			$frameDetails["event_date"] =$event_date;
 			$frameDetails["event_status"] = (string) $event_status;
 				$frameDetails["text_color"] =$text_color;

 				if($promotion_rel_frame_master_data['text_color']==""){
 				$centerImageDetails["text_color"] ="";
 			} else {
 				$centerImageDetails["text_color"] = $promotion_rel_frame_master_data['text_color'];
 			}

 			if($promotion_rel_frame_master_data['frame_title']==""){
 				$centerImageDetails["frame_title"] ="";
 			} else {
 				$centerImageDetails["frame_title"] = $promotion_rel_frame_master_data['frame_title'];
 			}
 			 
	//array_push($response["frameDetails"], $frameDetails);
			$eventDetails["frameDetails"][] =$frameDetails;
		}
	  }
	}

	array_push($response["eventDetails"], $eventDetails);

}


	$response["message"]="success.";
$response["status"]="200";
echo json_encode($response);

 
} else {
	$response["message"] = "No Seasonal Greetings Found.";
	$response["status"] = "201";
	echo json_encode($response);
}

} else  if (isset($getCenterImages) && $getCenterImages == 'getCenterImages' && isset($promotion_id)   ) {



 

$today = date("Y-m-d");
// /event_date>= '$today' and
$promotion_master=$d->select("promotion_master"," '$today' between `event_date` and `event_end_date`  and  status = 0 and promotion_id ='$promotion_id' order by order_date asc  ","");
if(mysqli_num_rows($promotion_master)  > 0    ){
 $response["centerImageDetails"] = array();
while ($promotion_data = mysqli_fetch_array($promotion_master)) {


	$promotion_id = $promotion_data["promotion_id"];
	//$eventDetails = array();
	/*$eventDetails["promotion_id"] = $promotion_data["promotion_id"];
	$eventDetails["event_name"] = $promotion_data["event_name"];
	$eventDetails["event_date"] = date("d M Y", strtotime($promotion_data["event_date"] )) ;
	$eventDetails["description"] = $promotion_data["description"];
	$eventDetails["event_status"] = $promotion_data["event_status"];
	$event_status = $promotion_data["event_status"];

	$event_status_desc = "";
	if($promotion_data["event_status"] == 0){
		$event_status_desc = "Running";
	} else if($promotion_data["event_status"] == 1){
		$event_status_desc = "Upcoming";
	} else if($promotion_data["event_status"] == 2){
		$event_status_desc = "Expired";
	}
	$eventDetails["event_status_desc"] =$event_status_desc;
	$eventDetails["event_image"] =$base_url . "img/promotion/" . $promotion_data['event_image'];*/
	if($promotion_data['event_image']==""){
	$event_image  ="";
} else
	$event_image  =$base_url . "img/promotion/" . $promotion_data['event_image'];


	if($promotion_data['event_frame']==""){
	$event_frame  ="";
} else
$event_frame  =$base_url . "img/promotion/" . $promotion_data['event_frame'];


	$event_date = date("d M Y", strtotime($promotion_data["event_date"] )) ;
$event_status = $promotion_data["event_status"];


 			 $text_color = $promotion_data["text_color"];

	$promotion_rel_center_master=$d->select("promotion_rel_center_master,promotion_center_image_master "," 	promotion_center_image_master.promotion_center_image_id = promotion_rel_center_master.promotion_center_image_id and    promotion_rel_center_master.promotion_id ='$promotion_id' and  promotion_rel_center_master.status = 0   ","");
 
	if(mysqli_num_rows($promotion_rel_center_master)  > 0    ){
		//$response["centerImageDetails"] = array();
		while ($promotion_rel_center_master_data = mysqli_fetch_array($promotion_rel_center_master)) {


//frame combination start
			$promotion_center_image_id = $promotion_rel_center_master_data['promotion_center_image_id'];
			$promotion_center_image = $base_url . "img/promotion/promotion_center_image/" . $promotion_rel_center_master_data['promotion_center_image'];


// promotion_rel_frame_master.promotion_frame_id='$promotion_frame_id' and 
$promotion_rel_frame_master=$d->select("promotion_rel_frame_master,promotion_frame_master "," 	promotion_frame_master.promotion_frame_id = promotion_rel_frame_master.promotion_frame_id and    promotion_rel_frame_master.promotion_id ='$promotion_id' and  
   promotion_rel_frame_master.status = 0   ","");

 $eventDetails = array();
if(mysqli_num_rows($promotion_rel_frame_master)  > 0    ){
		//$response["centerImageDetails"] = array();
		while ($promotion_rel_frame_master_data = mysqli_fetch_array($promotion_rel_frame_master)) {


$centerImageDetails = array();
			$centerImageDetails["promotion_id"] = $promotion_id;
			$centerImageDetails["promotion_center_image_id"] = $promotion_center_image_id;
			$centerImageDetails["promotion_frame_id"] = $promotion_rel_frame_master_data['promotion_frame_id'];
			$centerImageDetails["promotion_center_image"] =$promotion_center_image;
 			$centerImageDetails["promotion_frame"] =$base_url . "img/promotion/promotion_frames/" . $promotion_rel_frame_master_data['promotion_frame'];
 			//$centerImageDetails["event_image"] =$event_image;
 			//$centerImageDetails["event_frame"] =$event_frame;
 			$centerImageDetails["event_date"] =$event_date;
 			$centerImageDetails["event_status"] =$event_status;
 			$centerImageDetails["text_color"] =$text_color;

 			if($promotion_rel_frame_master_data['text_color']==""){
 				$centerImageDetails["text_color"] ="";
 			} else {
 				$centerImageDetails["text_color"] = $promotion_rel_frame_master_data['text_color'];
 			}

 			if($promotion_rel_frame_master_data['frame_title']==""){
 				$centerImageDetails["frame_title"] ="";
 			} else {
 				$centerImageDetails["frame_title"] = $promotion_rel_frame_master_data['frame_title'];
 			}
 			
 			 
$eventDetails  = $centerImageDetails;
array_push($response["centerImageDetails"], $eventDetails);
		}
	}
//frame combination end

			
		}
	}

	

}


	$response["message"]="success.";
$response["status"]="200";
echo json_encode($response);

 
} else {
	$response["message"] = "No Sesoanal Greetings Found.";
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