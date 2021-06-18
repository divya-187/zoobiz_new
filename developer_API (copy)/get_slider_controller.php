<?php
include_once 'lib.php';

if(isset($_POST) && !empty($_POST)){



    if ($key==$keydb) {
        
    $response = array();
    extract(array_map("test_input" , $_POST));
            if($_POST['getSlider']=="getSlider"){

                $qnotification=$d->selectRow("slider_id,slider_image,slider_description,slider_url,slider_mobile,slider_video_url,user_id","slider_master","status=0","order by RAND()");

                $response["slider"] = array();

                if(mysqli_num_rows($qnotification)>0){

                    while($data_notification=mysqli_fetch_array($qnotification)) {

                        // print_r($data_notification);

                        $slider = array(); 

                        $slider["app_slider_id"]=$data_notification['slider_id'];
                        $slider["slider_image_name"]=$base_url."img/sliders/".$data_notification['slider_image'];
                        $slider["slider_description"]=$data_notification['slider_description'];
                        $slider["slider_url"]=$data_notification['slider_url'].'';
                        if ($data_notification['slider_mobile']!=0) {
                            $slider["slider_mobile"]=$data_notification['slider_mobile'].'';
                        } else {
                            $slider["slider_mobile"]='';
                        }
                        $slider["slider_video_url"]=$data_notification['slider_video_url'].'';
                        $slider["user_id"]=$data_notification['user_id'].'';

                        array_push($response["slider"], $slider); 
                    }

                    $response["message"]="Slider Data.";
                    $response["status"]="200";
                    echo json_encode($response);

                }
            

            }else{
                $response["message"]="wrong tag.";
                $response["status"]="201";
                echo json_encode($response);

            }

        

    }else{

         $response["message"]="wrong api key.";
        $response["status"]="201";
        echo json_encode($response);

    }

}?>