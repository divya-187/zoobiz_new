<?php 
$todayDate= date('Y-m-d'); 
$plan_expire_date = "2021-04-13";


$is_plan_expired =0;
    if (strtotime($todayDate)>strtotime($plan_expire_date)) {
       $is_plan_expired =1;
    }


echo "<pre>";print_r(getenv());echo "</pre>";
    echo '7777'.$is_plan_expired;exit;
?>