<?php
include_once 'lib.php';

if(isset($_POST) && !empty($_POST)){

    if ($key==$keydb) {
       
    $response = array();
    extract(array_map("test_input" , $_POST));
        
            if($_POST['getActivity']=="getActivity" && filter_var($user_id, FILTER_VALIDATE_INT) == true ) {

                //recident_user_id!='0'  AND
                $app_data=$d->selectRow("log_id,app_user_id,log_name,log_img,log_time","log_master"," app_user_id='$user_id' ","ORDER BY log_id DESC");


                if(mysqli_num_rows($app_data)>0){

                    $response["logname"] = array();


                    while($data_app=mysqli_fetch_array($app_data)) {

                    	$logname=array();
                    	$logname["log_id"]=$data_app["log_id"];
						$logname["user_id"]=$data_app["app_user_id"];
                        $logname["log_name"]=html_entity_decode(ucwords($data_app["log_name"]));
                        $logname["log_image"]= $base_url.'img/app_icon/'.$data_app["log_img"];
                        $logname["log_time"]=date('d M y h:i A',strtotime($data_app["log_time"]));

                    	array_push($response["logname"], $logname); 
                    }

                     $response["message"]="Log Get Successfully";
                     $response["status"]="200";
                     echo json_encode($response);
                }else{
                	 $response["message"]="No Activity Available";
                     $response["status"]="201";
                     echo json_encode($response); 
                }

       }else if($_POST['deleteAcitivity']=="deleteAcitivity"  && filter_var($user_id, FILTER_VALIDATE_INT) == true  ){

            $q=$d->delete("log_master","app_user_id!='0'  AND app_user_id='$user_id'  ");

             if($q>0){
                    $d->insert_myactivity($user_id,"0","","All Activities are cleared.","activity.png");
                     $response["message"]="Activity Cleared";
                     $response["status"]="200";
                     echo json_encode($response);
                }else{
                     $response["message"]="Something Wrong";
                     $response["status"]="201";
                     echo json_encode($response); 
                }


        }else {
                $response["message"]="wrong tag.";
                $response["status"]="201";
                echo json_encode($response);                  
            }
    }else{

         $response["message"]="wrong api key.";
        $response["status"]="201";
        echo json_encode($response);
    }
}
