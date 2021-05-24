<?php  

 /*  $q3=$d->select("users_master","refer_by='2' ","");

 
 while ($data=mysqli_fetch_array($q3)) {
                extract($data);

                 $org_user_id = $data['user_id'];

                 $users_master=$d->select("users_master"," user_mobile ='$refere_by_phone_number'     ","");
                 if(mysqli_num_rows($users_master) > 0  ){
                 $users_master_data=mysqli_fetch_array($users_master);
 

                   $a =array(
                  'referred_by_user_id'=> $users_master_data['user_id']
                 );
                 $q=$d->update("users_master",$a,"user_id='$org_user_id'");


                }

 
                
                 

                   
                
                
   }*/
 
/*
   $q3=$d->selectRow("count(*) as cnt, `area_name`,`area_id`,city_id ,state_id,country_id,pincode   ","area_master","area_flag=1","group by city_id,state_id,country_id,`area_name`,`pincode` having cnt >1");

 
 while ($data=mysqli_fetch_array($q3)) {
                extract($data);

                
               $q=$d->delete("area_master","area_name='$area_name' AND city_id='$city_id'  AND state_id='$state_id'  AND country_id='$country_id'  AND pincode='$pincode'  AND area_id !='$area_id' ");
 }*/

 

     /*$q3=$d->selectRow("count(*) as cnt, `city_id` , `city_name`, `state_id`, `country_id`   ","cities","`country_id` = 101 ","group by `city_name` having cnt > 1   ");
  

 $dele_city_arr = array();
 while ($data=mysqli_fetch_array($q3)) {
                extract($data);

               
                 $q_city=$d->selectRow("*","cities","country_id = 101 and city_name = '$city_name' ","");
                 while ($q_data=mysqli_fetch_array($q_city)) {
                  
                  $city_id_new = $q_data['city_id'];
                        $active_area_qry=$d->select("area_master","city_id='$city_id_new' and country_id = 101 ");

                      echo mysqli_num_rows($active_area_qry);
                        if (mysqli_num_rows($active_area_qry) == 0 ) {
                          
                          $dele_city_arr[] = $city_id_new;
                             // $q=$d->delete("cities","city_id='$city_id' and country_id = 101");
                       }


                 }
                 

                 
 }           
                 
              
                 $dele_city_arr = implode(",",$dele_city_arr);
                $q=$d->delete("cities","city_id in( $dele_city_arr) ");*/




                $q3=$d->selectRow("SUBSTRING_INDEX(`photo_name`,'.',-1) as ext,photo_name,timeline_photo_id ","timeline_photos_master","","having ext=''");
  

 $dele_city_arr = array();
 while ($data=mysqli_fetch_array($q3)) {
                extract($data);

            
           /* $a1 = array(
            'photo_name' =>photo_name+ "jpeg" ,
          );

          $d->update("timeline_photos_master", $a1, "timeline_photo_id = '$timeline_photo_id'");*/

         // echo strpos($photo_name, '.').'<br>';
          $name= explode(".", $photo_name);
echo $name[1].'<br>';
 if ($name[1] !='') {
  
  } else {
     $a1 = array(
            'photo_name' =>$photo_name. "jpeg" ,
          );
  
          $d->update("timeline_photos_master", $a1, "timeline_photo_id = '$timeline_photo_id'"); 
  }
                /* mysqli_query($d->conn, "update timeline_photos_master SET photo_name =photo_name+ 'jpeg' where timeline_photo_id = '$timeline_photo_id' ");*/
/*
                 echo "update timeline_photos_master SET photo_name =concat(photo_name, 'jpeg') where timeline_photo_id = '$timeline_photo_id' ";*/
 
                 
 }           
                 
              
               
      
                
  
 ?>