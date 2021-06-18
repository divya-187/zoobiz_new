<?php
include_once 'lib.php';

if(isset($_POST) && !empty($_POST)){


    if ($key==$keydb  ) {
        
    $response = array();
    extract(array_map("test_input" , $_POST));
            if($_POST['getCirculars']=="getCirculars" ){

               
               
                $nqBlock=$d->selectRow("circular_id,circular_title,circular_description,created_date,updated_at","circulars_master","" ,"ORDER BY updated_at  desc LIMIT 500");

                if(mysqli_num_rows($nqBlock)>0){
                $response["circular"] = array();

                    while($data=mysqli_fetch_array($nqBlock)) {

                            $circular = array(); 

                            $circular["circular_id"]=$data['circular_id'];
                            $circular["circular_title"]=html_entity_decode($data['circular_title']);
                            $circular["circular_description"]=html_entity_decode($data['circular_description']);
                             $circular["notice_time"]=date('d M Y h:i A',strtotime($data['updated_at']));
                            // if ($data['circular_attachment']!='') {
                            //     $circular["circular_attachment"]=$base_url.'img/circul/'.$data['circular_attachment'];
                            // }else {
                            //     $circular["circular_attachment"]="";

                            // }
                            
                            array_push($response["circular"], $circular);
                    }
                   
                    $response["message"]="Circulars";
                    $response["status"]="200";
                    echo json_encode($response);
                }else{
                    $response["message"]="No Circulars Found.";
                    $response["status"]="201";
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