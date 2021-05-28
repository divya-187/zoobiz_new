<?php  //$d->send_sms("7990247516","fffdemo"); 
//$d->send_sms_multiple("7990247516,7433053030","Zoobiz Dev Test");  
  
$accessPage=$d->select("master_menu","status=0 and menu_id in ($accessMenuId) ");
    $accessPageData=mysqli_fetch_array($accessPage);


$allowedMenus = array();
  while($row1=mysqli_fetch_array($accessPage)){ 
    $allowedMenus[] = $row1['menu_link'];
  }
   
?>
<div class="content-wrapper">
    <div class="container-fluid">

      
    <div class="row mt-3">


      <?php if(in_array('mainCategories', $allowedMenus)){ ?>  
        <div class="col-6 col-lg-6 col-xl-3">
          <div class="card gradient-bloody">
            <a href="mainCategories">
            <div class="p-2">
              <div class="media align-items-center">
              <div class="media-body">
                <p class="text-white">Category</p>
                <h4 class="text-white line-height-5"><?php echo $d->count_data_direct("business_category_id","business_categories","category_status=0 OR category_status =2 "); ?></h4>
              </div>
              <div class="w-circle-icon rounded-circle  border-white">
                <img class="myIcon" src="../zooAdmin/img/icons/block.png"></div>
            </div>
            </div>
            </a>
          </div>
        </div>
      <?php } ?> 
       <?php if(in_array('subCategories', $allowedMenus)){ ?>  
        <div class="col-6 col-lg-6 col-xl-3">
          <div class="card gradient-scooter">
            <a href="subCategories">
            <div class="p-2">
              <div class="media align-items-center">
              <div class="media-body">
                <p class="text-white"> Sub Category</p>
                <h4 class="text-white line-height-5"><?php 

                echo $d->count_data_direct("business_sub_category_id","business_sub_categories"," (sub_category_status = 0  OR sub_category_status=2) and  business_category_id >= 0 ");
                //"business_sub_categories","  ( business_sub_categories.sub_category_status=0 OR business_sub_categories.sub_category_status=2 ) and business_category_id >= 0   $where ","ORDER BY business_sub_categories.sub_category_name ASC"
                 ?></h4>
              </div>
              <div class="w-circle-icon rounded-circle border-white">
                <img class="myIcon" src="../zooAdmin/img/icons/block.png"></div>
            </div>
            </div>
            </a>
          </div>
        </div>
          <?php } ?> 
      <?php
//echo "<pre>";print_r($_SESSION);echo "</pre>";
    ?> 
       <?php if(in_array('payments', $allowedMenus)){ ?>  
        <div class="col-6 col-lg-6 col-xl-3">
          <div class="card gradient-blooker">
            <a href="paymentsMonthly">
            <div class="p-2">
              <div class="media align-items-center">
              <div class="media-body">
                <p class="text-white">Monthly Transactions</p>
               
             <?php 


             $selected_city_id = $_SESSION['city_id'];

               $y = date("Y");
             $m = date("m");
                 /*$count5=$d->selectRow("transection_amount","transection_master","payment_status='success' and is_paid = 0  and YEAR(transection_date) = '$y' and MONTH(`transection_date`) = '$m'  and payment_mode !='Backend Admin' ");*/

                   $qry=$d->select("users_master,company_master,transection_master"," users_master.company_id = company_master.company_id and transection_master.user_id=users_master.user_id   and  payment_status='success' and is_paid = 0  and YEAR(transection_date) = '$y' and MONTH(`transection_date`) = '$m'  and payment_mode !='Backend Admin'  and users_master.city_id='$selected_city_id' ","ORDER BY transection_master.transection_id DESC");

 
                 $trantotal = 0 ;
 while($row=mysqli_fetch_array($qry)) {
  if(  $row['coupon_id'] == 0){
                    $trantotal +=$row['transection_amount'];
                }
                         
                  }
                  $totalMain=number_format($trantotal,2,'.','');
                  if(strlen($totalMain)> 7){
                   echo  ' <h4 class="text-white line-height-5">'.$totalMain.'</h4>'; 
                  } else {
                    echo  ' <h3 class="text-white line-height-5"> '.$totalMain.'</h3>'; 
                  }
                 /*$count5=$d->select("transection_master,users_master","transection_master.user_id=users_master.user_id AND transection_master.payment_status='success'  and (  transection_master.coupon_id = 0  ) ");
$asif = 0 ;
                  while($row=mysqli_fetch_array($count5))
                 {
                      //$asif=$row['SUM(transection_amount)'];
                  $asif +=$row['transection_amount'];
                
                         
                  }
                  $totalMain=number_format($asif,2,'.','');
                  if(strlen($totalMain)> 7){

                   //echo  ' <h4 class="text-white line-height-5">'.$totalMain.'</h4>'; 
                  } else {
                   // echo  ' <h3 class="text-white line-height-5"> '.$totalMain.'</h3>'; 
                  }*/
               ?>
             
           </a>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
              <img class="myIcon" src="../zooAdmin/img/icons/cash-icon.png"></div>
            </div>
            </div>
            </a>
          </div>
        </div>
         <?php }

         // echo "<pre>";print_r($_SESSION);
          ?> 
       <?php if(in_array('onlyViewMember', $allowedMenus)){ ?>  
        <div class="col-6 col-lg-6 col-xl-3">
          <div class="card gradient-ohhappiness">
            <?php //24nov2020 manageMembers to memberList?>
            <a href="onlyViewMember">
            <div class="p-2">
              <div class="media align-items-center">
              <div class="media-body">
                <p class="text-white">Users</p>
                <h4 class="text-white line-height-5"><?php 



/*
              //  echo $d->count_data_direct("user_id","users_master, user_employment_details","users_master.active_status  = 0  AND user_employment_details.user_id=users_master.user_id ");

echo $selected_city_id;*/
                  $q=$d->select("users_master,user_employment_details,business_categories,business_sub_categories"," business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.active_status=0 AND users_master.office_member=0 and users_master.city_id='$selected_city_id'   ","ORDER BY users_master.user_id DESC");
              echo   mysqli_num_rows($q);
                 ?></h4>


              </div>
              <div class="w-circle-icon rounded-circle border-white">
                 <img class="myIcon" src="../zooAdmin/img/icons/comittee.png"></div>
            </div>
            </div>
            </a>
          </div>
        </div>
         <?php } ?> 



<?php if(in_array('classifieds', $allowedMenus)){ ?> 
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-scooter">
          <a href="classifieds">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">Classified</p>
               <h4 class="text-white line-height-5"><?php echo $d->count_data_direct("cllassified_id","cllassifieds_master"," active_status = 0 "); ?></h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
              <img class="myIcon" src="../zooAdmin/img/icons/solution.png"></div>
          </div>
          </div>
        </a>
        </div>
      </div>
       <?php } ?> 

          <?php if(in_array('timeline', $allowedMenus)){ ?> 
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-blooker">
          <a href="timeline">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">Timeline </p>
              <h4 class="text-white line-height-5"><?php echo $d->count_data_direct("timeline_id","timeline_master"," active_status = 0 "); ?></h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
              <img class="myIcon" src="../zooAdmin/img/icons/experience.png"></div>
          </div>
          </div>
        </a>
        </div>
      </div>
       <?php } ?> 



        <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-bloody">
          <a href="planExpiring">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">Plan Expiring in (2 Months)</p>
              <h4 class="text-white line-height-5"><?php 
              
              $i=1;
              $difference_days =0 ;
             // $nq=$d->select("users_master","","ORDER BY plan_renewal_date ASC LIMIT 20");

              $today_date = date("Y-m-d");

              $nq3=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","  business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id and users_master.user_mobile!='0' AND users_master.active_status=0 and users_master.plan_renewal_date >= '$today_date'    ","ORDER BY plan_renewal_date ASC  ");
              $toalExp = 0 ;
               while ($newUserData=mysqli_fetch_array($nq3)) {

                $today= date('Y-m-d');
                  if ($today>$newUserData['plan_renewal_date']) {
                   } else {
                            $date11 = new DateTime($today);
                            $date22 = new DateTime($newUserData['plan_renewal_date']);
                            $interval = $date11->diff($date22);
                            $difference_days= $interval->days; 
                  }

                  $difference_days= $d->plan_days_left($newUserData['plan_renewal_date']);
                  
                  if ($difference_days < 61) {
                    $toalExp++;
                  }
                }
              echo $toalExp;
               ?></h4>
            </div>
           <div class="w-circle-icon rounded-circle border-white">
                <img class="myIcon" src="../zooAdmin/img/icons/plan-icon.png">
              </div>
          </div>
          </div>
          </a>
        </div>
      </div>


         <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-bloody">
          <a href="planExpired">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">Plan Expired </p>
              <h4 class="text-white line-height-5"><?php 
              
              $i=1;
              $difference_days =0 ;
             // $nq=$d->select("users_master","","ORDER BY plan_renewal_date ASC LIMIT 20");

              $today_date = date("Y-m-d");

              $nq1=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","  business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id and users_master.user_mobile!='0' AND users_master.active_status=0 and users_master.plan_renewal_date < '$today_date'   ","ORDER BY plan_renewal_date ASC  ");
              echo mysqli_num_rows($nq1);
               ?></h4>
            </div>
           <div class="w-circle-icon rounded-circle border-white">
                <img class="myIcon" src="../zooAdmin/img/icons/plan-icon.png">
              </div>
          </div>
          </div>
          </a>
        </div>
      </div>
      
    </div>

    
     <div class="col-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    Last 12 Months Transaction Report
                  </div>
<?php



 $monthData11 = date("d-m-Y", strtotime("-11 months"));
$y11 = date("Y",strtotime($monthData11));
$m11 = date("m",strtotime($monthData11));
                  
 $qry11=$d->select("users_master,company_master,transection_master"," users_master.company_id = company_master.company_id and transection_master.user_id=users_master.user_id   and  payment_status='success' and is_paid = 0  and YEAR(transection_date) = '$y11' and MONTH(`transection_date`) = '$m11'  and payment_mode !='Backend Admin' and users_master.city_id='$selected_city_id'  ","ORDER BY transection_master.transection_id DESC");
 $trantotal11 = 0 ;
 while($row11=mysqli_fetch_array($qry11)) {
  if(  $row11['coupon_id'] == 0){
                    $trantotal11 +=$row11['transection_amount'];
                }
  }
 $trantotal11=number_format($trantotal11,2,'.','');

 $monthData10 = date("d-m-Y", strtotime("-10 months"));
$y10 = date("Y",strtotime($monthData10));
$m10 = date("m",strtotime($monthData10));
                  
 $qry10=$d->select("users_master,company_master,transection_master"," users_master.company_id = company_master.company_id and transection_master.user_id=users_master.user_id   and  payment_status='success' and is_paid = 0  and YEAR(transection_date) = '$y10' and MONTH(`transection_date`) = '$m10'  and payment_mode !='Backend Admin' and users_master.city_id='$selected_city_id'  ","ORDER BY transection_master.transection_id DESC");
 $trantotal10 = 0 ;
 while($row10=mysqli_fetch_array($qry10)) {
  if(  $row10['coupon_id'] == 0){
                    $trantotal10 +=$row10['transection_amount'];
                }
  }
 $trantotal10=number_format($trantotal10,2,'.','');


 $monthData9 = date("d-m-Y", strtotime("-9 months"));
$y9 = date("Y",strtotime($monthData9));
$m9 = date("m",strtotime($monthData9));
                  
 $qry9=$d->select("users_master,company_master,transection_master"," users_master.company_id = company_master.company_id and transection_master.user_id=users_master.user_id   and  payment_status='success' and is_paid = 0  and YEAR(transection_date) = '$y9' and MONTH(`transection_date`) = '$m9'  and payment_mode !='Backend Admin' and users_master.city_id='$selected_city_id'  ","ORDER BY transection_master.transection_id DESC");
 $trantotal9 = 0 ;
 while($row9=mysqli_fetch_array($qry9)) {
  if(  $row9['coupon_id'] == 0){
                    $trantotal9 +=$row9['transection_amount'];
                }
  }
 $trantotal9=number_format($trantotal9,2,'.','');


 $monthData8 = date("d-m-Y", strtotime("-8 months"));
$y8 = date("Y",strtotime($monthData8));
$m8 = date("m",strtotime($monthData8));
                  
 $qry8=$d->select("users_master,company_master,transection_master"," users_master.company_id = company_master.company_id and transection_master.user_id=users_master.user_id   and  payment_status='success' and is_paid = 0  and YEAR(transection_date) = '$y8' and MONTH(`transection_date`) = '$m8'  and payment_mode !='Backend Admin' and users_master.city_id='$selected_city_id'  ","ORDER BY transection_master.transection_id DESC");
 $trantotal8 = 0 ;
 while($row8=mysqli_fetch_array($qry8)) {
  if(  $row8['coupon_id'] == 0){
                    $trantotal8 +=$row8['transection_amount'];
                }
  }
 $trantotal8=number_format($trantotal8,2,'.','');

 $monthData7 = date("d-m-Y", strtotime("-7 months"));
$y7 = date("Y",strtotime($monthData7));
$m7 = date("m",strtotime($monthData7));
                  
 $qry7=$d->select("users_master,company_master,transection_master"," users_master.company_id = company_master.company_id and transection_master.user_id=users_master.user_id   and  payment_status='success' and is_paid = 0  and YEAR(transection_date) = '$y7' and MONTH(`transection_date`) = '$m7'  and payment_mode !='Backend Admin'  and users_master.city_id='$selected_city_id' ","ORDER BY transection_master.transection_id DESC");
 $trantotal7 = 0 ;
 while($row7=mysqli_fetch_array($qry7)) {
  if(  $row7['coupon_id'] == 0){
                    $trantotal7 +=$row7['transection_amount'];
                }
  }
 $trantotal7=number_format($trantotal7,2,'.','');

 $monthData6 = date("d-m-Y", strtotime("-6 months"));
$y6 = date("Y",strtotime($monthData6));
$m6 = date("m",strtotime($monthData6));
                  
 $qry6=$d->select("users_master,company_master,transection_master"," users_master.company_id = company_master.company_id and transection_master.user_id=users_master.user_id   and  payment_status='success' and is_paid = 0  and YEAR(transection_date) = '$y6' and MONTH(`transection_date`) = '$m6'  and payment_mode !='Backend Admin'  and users_master.city_id='$selected_city_id' ","ORDER BY transection_master.transection_id DESC");
 $trantotal6 = 0 ;
 while($row6=mysqli_fetch_array($qry6)) {
  if(  $row6['coupon_id'] == 0){
                    $trantotal6 +=$row6['transection_amount'];
                }
  }
 $trantotal6=number_format($trantotal6,2,'.','');

 $monthData5 = date("d-m-Y", strtotime("-5 months"));
$y5 = date("Y",strtotime($monthData5));
$m5 = date("m",strtotime($monthData5));
                  
 $qry5=$d->select("users_master,company_master,transection_master"," users_master.company_id = company_master.company_id and transection_master.user_id=users_master.user_id   and  payment_status='success' and is_paid = 0  and YEAR(transection_date) = '$y5' and MONTH(`transection_date`) = '$m5'  and payment_mode !='Backend Admin' and users_master.city_id='$selected_city_id'  ","ORDER BY transection_master.transection_id DESC");
 $trantotal5 = 0 ;
 while($row5=mysqli_fetch_array($qry5)) {
  if(  $row5['coupon_id'] == 0){
                    $trantotal5 +=$row5['transection_amount'];
                }
  }
 $trantotal5=number_format($trantotal5,2,'.','');


 $monthData4 = date("d-m-Y", strtotime("-4 months"));
$y4 = date("Y",strtotime($monthData4));
$m4 = date("m",strtotime($monthData4));
                  
 $qry4=$d->select("users_master,company_master,transection_master"," users_master.company_id = company_master.company_id and transection_master.user_id=users_master.user_id   and  payment_status='success' and is_paid = 0  and YEAR(transection_date) = '$y4' and MONTH(`transection_date`) = '$m4'  and payment_mode !='Backend Admin' and users_master.city_id='$selected_city_id'  ","ORDER BY transection_master.transection_id DESC");
 $trantotal4 = 0 ;
 while($row4=mysqli_fetch_array($qry4)) {
  if(  $row4['coupon_id'] == 0){
                    $trantotal4 +=$row4['transection_amount'];
                }
  }
 $trantotal4=number_format($trantotal4,2,'.','');

 $monthData3 = date("d-m-Y", strtotime("-3 months"));
$y3 = date("Y",strtotime($monthData3));
$m3 = date("m",strtotime($monthData3));
                  
 $qry3=$d->select("users_master,company_master,transection_master"," users_master.company_id = company_master.company_id and transection_master.user_id=users_master.user_id   and  payment_status='success' and is_paid = 0  and YEAR(transection_date) = '$y3' and MONTH(`transection_date`) = '$m3'  and payment_mode !='Backend Admin' and users_master.city_id='$selected_city_id'  ","ORDER BY transection_master.transection_id DESC");
 $trantotal3 = 0 ;
 while($row3=mysqli_fetch_array($qry3)) {
  if(  $row3['coupon_id'] == 0){
                    $trantotal3 +=$row3['transection_amount'];
                }
  }
 $trantotal3=number_format($trantotal3,2,'.','');

 $monthData2 = date("d-m-Y", strtotime("-2 months"));
$y2 = date("Y",strtotime($monthData2));
$m2 = date("m",strtotime($monthData2));
                  
 $qry2=$d->select("users_master,company_master,transection_master"," users_master.company_id = company_master.company_id and transection_master.user_id=users_master.user_id   and  payment_status='success' and is_paid = 0  and YEAR(transection_date) = '$y2' and MONTH(`transection_date`) = '$m2'  and payment_mode !='Backend Admin' and users_master.city_id='$selected_city_id'  ","ORDER BY transection_master.transection_id DESC");
 $trantotal2 = 0 ;
 while($row2=mysqli_fetch_array($qry2)) {
  if(  $row2['coupon_id'] == 0){
                    $trantotal2 +=$row2['transection_amount'];
                }
  }
 $trantotal2=number_format($trantotal2,2,'.','');

 $monthData1 = date("d-m-Y", strtotime("-1 months"));
$y1 = date("Y",strtotime($monthData1));
$m1 = date("m",strtotime($monthData1));
                  
 $qry1=$d->select("users_master,company_master,transection_master"," users_master.company_id = company_master.company_id and transection_master.user_id=users_master.user_id   and  payment_status='success' and is_paid = 0  and YEAR(transection_date) = '$y1' and MONTH(`transection_date`) = '$m1'  and payment_mode !='Backend Admin' and users_master.city_id='$selected_city_id'  ","ORDER BY transection_master.transection_id DESC");
 $trantotal1 = 0 ;
 while($row1=mysqli_fetch_array($qry1)) {
  if(  $row1['coupon_id'] == 0){
                    $trantotal1 +=$row1['transection_amount'];
                }
  }
 $trantotal1=number_format($trantotal1,2,'.','');

 $monthData0 = date("d-m-Y");
$y0 = date("Y",strtotime($monthData0));
$m0 = date("m",strtotime($monthData0));
                  
 $qry0=$d->select("users_master,company_master,transection_master"," users_master.company_id = company_master.company_id and transection_master.user_id=users_master.user_id   and  payment_status='success' and is_paid = 0  and YEAR(transection_date) = '$y0' and MONTH(`transection_date`) = '$m0'  and payment_mode !='Backend Admin' and users_master.city_id='$selected_city_id'  ","ORDER BY transection_master.transection_id DESC");
 $trantotal0 = 0 ;
 while($row0=mysqli_fetch_array($qry0)) {
  if(  $row0['coupon_id'] == 0){
                    $trantotal0 +=$row0['transection_amount'];
                }
  }
 $totalMain0=number_format($trantotal0,2,'.','');
 ?> 
                  <div class="card-body">
                    <canvas width="640" height="480" id="dashboard-chart-trans" style="display: block; width: 470px; height: 235px;"   class="chartjs-render-monitor" ></canvas>
                  </div>
                </div>
              </div>
    
    </div>
 <script type="text/javascript">
   var monthData0 = "<?php echo date("y-m",strtotime($monthData0)); ?>";
  var monthData11 = "<?php echo date("y-m",strtotime($monthData11)); ?>"; 
  var monthData10 = "<?php echo date("y-m",strtotime($monthData10)); ?>"; 
  var monthData9 = "<?php echo date("y-m",strtotime($monthData9)); ?>"; 
  var monthData8 = "<?php echo date("y-m",strtotime($monthData8)); ?>"; 
  var monthData7 = "<?php echo date("y-m",strtotime($monthData7)); ?>"; 
  var monthData6 = "<?php echo date("y-m",strtotime($monthData6)); ?>"; 
  var monthData5 = "<?php echo date("y-m",strtotime($monthData5)); ?>"; 
  var monthData4 = "<?php echo date("y-m",strtotime($monthData4)); ?>"; 
  var monthData3 = "<?php echo date("y-m",strtotime($monthData3)); ?>"; 
  var monthData2 = "<?php echo date("y-m",strtotime($monthData2)); ?>"; 
  var monthData1 = "<?php echo date("y-m",strtotime($monthData1)); ?>"; 


  var trantotal0 = "<?php echo $trantotal0; ?>";
  var trantotal11 = "<?php echo $trantotal11; ?>"; 
  var trantotal10 = "<?php echo $trantotal10; ?>"; 
  var trantotal9 = "<?php echo $trantotal9; ?>"; 
  var trantotal8 = "<?php echo $trantotal8; ?>"; 
  var trantotal7 = "<?php echo $trantotal7; ?>"; 
  var trantotal6 = "<?php echo $trantotal6; ?>"; 
  var trantotal5 = "<?php echo $trantotal5; ?>"; 
  var trantotal4 = "<?php echo $trantotal4; ?>"; 
  var trantotal3 = "<?php echo $trantotal3; ?>"; 
  var trantotal2 = "<?php echo $trantotal2; ?>"; 
  var trantotal1 = "<?php echo $trantotal1; ?>"; 
 </script>
 
    <script type="text/javascript" src="../zooAdmin/assets/js/jquery1.js"></script>
 <script src="../zooAdmin/assets/js/index_partner.js"></script> 