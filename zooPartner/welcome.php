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
       <?php if(in_array('payments', $allowedMenus)){ ?>  
        <div class="col-6 col-lg-6 col-xl-3">
          <div class="card gradient-blooker">
            <a href="payments">
            <div class="p-2">
              <div class="media align-items-center">
              <div class="media-body">
                <p class="text-white">Transactions</p>
               
             <?php //24nov2020  transection_master.coupon_id = 0 added to exclude coupon amount from transactions.
                // $count5=$d->sum_data("transection_amount","transection_master","payment_status='success' and is_paid = 0 ");

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
         <?php } ?> 
       <?php if(in_array('memberList', $allowedMenus)){ ?>  
        <div class="col-6 col-lg-6 col-xl-3">
          <div class="card gradient-ohhappiness">
            <?php //24nov2020 manageMembers to memberList?>
            <a href="memberList">
            <div class="p-2">
              <div class="media align-items-center">
              <div class="media-body">
                <p class="text-white">Users</p>
                <h4 class="text-white line-height-5"><?php 




              //  echo $d->count_data_direct("user_id","users_master, user_employment_details","users_master.active_status  = 0  AND user_employment_details.user_id=users_master.user_id ");
                  $q=$d->select("users_master,user_employment_details,business_categories,business_sub_categories"," business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.active_status=0 AND users_master.office_member=0   ","ORDER BY users_master.user_id DESC");
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
      
    </div>

    <?php /* ?>
    <div class="row ">

       <?php if(in_array('businesHouses', $allowedMenus)){ ?>  
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-bloody">
          <a href="businesHouses">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">Business Houses </p>
              <h4 class="text-white line-height-5"><?php

              // echo $d->count_data_direct("business_houses_id","business_houses"," active_status = 0 ");
              
                $h_q=$d->select("users_master,business_houses,user_employment_details,business_categories,business_sub_categories","    business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND business_houses.user_id= users_master.user_id ","ORDER BY business_houses.order_id ASC");
               echo mysqli_num_rows( $h_q);
                ?></h4>
            </div>
            <div class="w-circle-icon rounded-circle  border-white">
              <img class="myIcon" src="../zooAdmin/img/icons/owner.png"></div>
          </div>
          </div>
          </a>
        </div>
      </div>
    <?php } ?> 
      <?php if(in_array('payments', $allowedMenus)){ ?>  
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-scooter">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <a href="payments">
              <p class="text-white"> Earning in (<i class="fa fa-inr"></i>)</p>
             
                <?php //24nov2020  transection_master.coupon_id = 0 added to exclude coupon amount from transactions.
                // $count5=$d->sum_data("transection_amount","transection_master","payment_status='success' and is_paid = 0 ");

                 $count5=$d->select("transection_master,users_master","transection_master.user_id=users_master.user_id AND transection_master.payment_status='success'  and (  transection_master.coupon_id = 0  ) ");
$asif = 0 ;
                  while($row=mysqli_fetch_array($count5))
                 {
                      //$asif=$row['SUM(transection_amount)'];
                  $asif +=$row['transection_amount'];
                
                         
                  }
                  $totalMain=number_format($asif,2,'.','');
                  if(strlen($totalMain)> 7){

                   echo  ' <h4 class="text-white line-height-5">'.$totalMain.'</h4>'; 
                  } else {
                    echo  ' <h3 class="text-white line-height-5"> '.$totalMain.'</h3>'; 
                  }
               ?>
             
           </a>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
              <img class="myIcon" src="../zooAdmin/img/icons/cash-icon.png"></div>
          </div>
          </div>
        </div>
      </div>
 <?php } ?> 
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-blooker">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">SMS Credit Used</p>
              <h4 class="text-white line-height-5">
               <?php 
                $count5=$d->sum_data("used_credit","sms_log_master","");
                  while($row=mysqli_fetch_array($count5))
                 {  
                  if ($row['SUM(used_credit)']=='') {
                    echo "0";
                  } else {

                   echo   $asif=$row['SUM(used_credit)'];
                  }
                    
                  } ?>
              </h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
              <img class="myIcon" src="../zooAdmin/img/icons/sms.png"></div>
          </div>
          </div>
        </div>
      </div>
       
      <?php if(in_array('manageCirculars', $allowedMenus)){ ?>  
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-ohhappiness">
          <a href="manageCirculars">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">Circulars</p>
              <h4 class="text-white line-height-5">
                <?php echo $d->count_data_direct("circular_id","circulars_master",""); ?>
              </h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
               <img class="myIcon" src="../zooAdmin/img/icons/digital-marketing.png"></div>
          </div>
          </div>
        </a>
        </div>
      </div>
       <?php } ?> 
    </div>
    <?php */ ?>
    <div class="row ">
       
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
    <?php if(in_array('feedback', $allowedMenus)){ ?> 
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-ohhappiness">
          <a href="feedback">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">Feedback</p>
              <h4 class="text-white line-height-5">
                <?php echo $d->count_data_direct("feedback_id","feedback_master",""); ?>
              </h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
               <img class="myIcon" src="../zooAdmin/img/icons/chat-complain.png"></div>
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
     
    </div>
    <div class="row ">
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
<?php  

if($_SESSION['role_id'] == 1   ){  ?>
       <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-scooter">
          <a href="interestApproval">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">Interest Approval</p>
               <h4 class="text-white line-height-5"><?php 
                $nq2=$d->select("users_master,user_employment_details,interest_master","  interest_master.added_by_member_id=users_master.user_id and    user_employment_details.user_id=users_master.user_id and users_master.user_mobile!='0' AND users_master.active_status=0 and interest_master.int_status='User Added'   "," group by interest_master.interest_id  ORDER BY interest_master.created_at ASC  ");

                echo mysqli_num_rows($nq2);

                 ?></h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
              <img class="myIcon" src="../zooAdmin/img/icons/solution.png"></div>
          </div>
          </div>
        </a>
        </div>
      </div>
<?php } ?> 
    </div>
        <?php /* ?>
    <div class="row ">
       <?php if(in_array('areas', $allowedMenus)){ ?> 
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-bloody">
          <a href="areas">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">Areas </p>
              <h4 class="text-white line-height-5"><?php 
              //24nov 2020 Area count is wrong, load only active area of active city, state and country.

              

              echo $d->count_data_direct("area_id","area_master, states, countries , cities "," area_master.country_id = countries.country_id and area_master.state_id = states.state_id and area_master.city_id = cities.city_id and countries.flag = 1 and `states`.`state_flag` = 1 and cities.city_flag = 1");


               ?></h4>
            </div>
            <div class="w-circle-icon rounded-circle  border-white">
              <img class="myIcon" src="../zooAdmin/img/icons/covid.png"></div>
          </div>
          </div>
          </a>
        </div>
      </div>
        <?php } ?> 
         <?php if(in_array('countries', $allowedMenus)){ ?> 
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-scooter">
          <a href="countries">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white"> Countries</p>
               <h4 class="text-white line-height-5"><?php echo $d->count_data_direct("country_id","countries","flag = 1"); ?></h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
              <img class="myIcon" src="../zooAdmin/img/icons/flag.png"></div>
          </div>
          </div>
        </a>
        </div>
      </div>
        <?php } ?> 
         <?php if(in_array('states', $allowedMenus)){ ?> 
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-blooker">
          <a href="states">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">States</p>
              <h4 class="text-white line-height-5"><?php echo $d->count_data_direct("state_id","states,countries","countries.country_id =states.country_id and countries.flag = 1 and  states.state_flag = 1"); ?></h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
              <img class="myIcon" src="../zooAdmin/img/icons/house.png"></div>
          </div>
          </div>
          </a>
        </div>
      </div>
       <?php } ?> 
         <?php if(in_array('cities', $allowedMenus)){ ?>
      <div class="col-6 col-lg-6 col-xl-3">
        <div class="card gradient-ohhappiness">
          <a href="cities">
          <div class="p-2">
            <div class="media align-items-center">
            <div class="media-body">
              <p class="text-white">Cities</p>
              <h4 class="text-white line-height-5">
                <?php echo $d->count_data_direct("city_id","cities"," city_flag =1"); ?>
              </h4>
            </div>
            <div class="w-circle-icon rounded-circle border-white">
               <img class="myIcon" src="../zooAdmin/img/icons/antenna.png"></div>
          </div>
          </div>
        </a>
        </div>
      </div>
       <?php } ?> 
    </div>
   
     <div class="row">
       <div class="col-12 col-lg-12 col-xl-12">
         <div class="card">
           <div class="card-header border-0">
           Upcoming Member Plan Expire (2 Months)
          <div class="card-action">
           
           </div>
          </div>
          <div class="table-responsive">
           <table id="default-datatable" class="table align-items-center table-bordered table-flush">
             <thead>
              <tr>
               <th>No.</th>
               <th>Name</th>
               <th>Email</th>
               <th>Mobile Number</th>
               <th>PLan Expire Date</th>
               <th>Days Left</th>
              </tr>
             </thead>
             <tbody>
              <?php 
              $i=1;
              $difference_days =0 ;
             // $nq=$d->select("users_master","","ORDER BY plan_renewal_date ASC LIMIT 20");

              $today_date = date("Y-m-d");

              $nq=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","  business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id and users_master.user_mobile!='0' AND users_master.active_status=0 and users_master.plan_renewal_date >= '$today_date'    ","ORDER BY plan_renewal_date ASC LIMIT 20");


              while ($newUserData=mysqli_fetch_array($nq)) {

                $today= date('Y-m-d');
                  if ($today>$newUserData['plan_renewal_date']) {
                      //echo "<p class='text text-danger'>Expire</p>";
                  } else {

 

                         $date11 = new DateTime($today);
                            $date22 = new DateTime($newUserData['plan_renewal_date']);
                            $interval = $date11->diff($date22);
                            $difference_days= $interval->days; 
                  }

                  $difference_days= $d->plan_days_left($newUserData['plan_renewal_date']);
                  
                  if ($difference_days < 61) {
               ?>
               <tr>
                 <td><?php echo $i++; ?></td>
                 <td>
                  
                  <?php if($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2   ){ ?>
                  <a href="viewMember?id=<?php echo $newUserData['user_id']; ?>"><?php echo $newUserData['user_full_name']; ?></a></td>
                  <?php } else { ?> 
                    <a href="memberView?id=<?php echo $newUserData['user_id']; ?>"><?php echo $newUserData['user_full_name']; ?></a>
                   <?php } ?>


                 <td><?php echo $newUserData['user_email']; ?></td>
                 <td><?php echo $newUserData['user_mobile']; ?></td>
                 <td data-order="<?php echo date("U",strtotime($newUserData['plan_renewal_date'])); ?>" ><?php echo $newUserData['plan_renewal_date']; ?></td>
                 <td><?php  
                 if ($today>$newUserData['plan_renewal_date']) {
                      echo "<span class='text text-danger'>Expired</span>  ";
                  } else if($difference_days > -1 ){ 
                           echo  $difference_days. " days ";
                           } 
                          ?>
                 </td>
                 
               </tr>
              <?php } } ?>
             </tbody>
           </table>
         </div>
         </div>
       </div>
    </div>


    <div class="row">
       <div class="col-12 col-lg-12 col-xl-12">
         <div class="card">
           <div class="card-header border-0">
          Plan Expired Members
          <div class="card-action">
           
           </div>
          </div>
          <div class="table-responsive">
           <table id="example" class="table align-items-center table-bordered table-flush">
             <thead>
              <tr>
               <th>No.</th>
               <th>Name</th>
               <th>Email</th>
               <th>Mobile Number</th>
               <th>PLan Expire Date</th>
                
              </tr>
             </thead>
             <tbody>
              <?php 
              $i=1;
              $difference_days =0 ;
             // $nq=$d->select("users_master","","ORDER BY plan_renewal_date ASC LIMIT 20");

$today_date = date("Y-m-d");

              $nq=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","  business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id and users_master.user_mobile!='0' AND users_master.active_status=0 and users_master.plan_renewal_date < '$today_date'   ","ORDER BY plan_renewal_date ASC LIMIT 20");


              while ($newUserData=mysqli_fetch_array($nq)) {

                $today= date('Y-m-d');
                  if ($today>$newUserData['plan_renewal_date']) {
                      //echo "<p class='text text-danger'>Expire</p>";
                  } else {
                            $date11 = new DateTime($today);
                            $date22 = new DateTime($newUserData['plan_renewal_date']);
                            $interval = $date11->diff($date22);
                            $difference_days= $interval->days; 
                  }
                  if ($difference_days < 31) {
               ?>
               <tr>
                 <td><?php echo $i++; ?></td>
                 <td>
<?php if(  $_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2   ){ ?>
                  <a href="viewMember?id=<?php echo $newUserData['user_id']; ?>"><?php echo $newUserData['user_full_name']; ?></a>
                  <?php } else { ?> 
                    <a href="memberView?id=<?php echo $newUserData['user_id']; ?>"><?php echo $newUserData['user_full_name']; ?></a>
                   <?php } ?> </td>
                 <td><?php echo $newUserData['user_email']; ?></td>
                 <td><?php echo $newUserData['user_mobile']; ?></td>
                 <td data-order="<?php echo date("U",strtotime($newUserData['plan_renewal_date'])); ?>" ><?php echo $newUserData['plan_renewal_date']; ?></td>
                 
                 
               </tr>
              <?php } } ?>
             </tbody>
           </table>
         </div>
         </div>
       </div>
    </div>
 <?php  */ ?>
<?php  

if($_SESSION['role_id'] == 1   ){  ?>
     <div class="row">
       <div class="col-12 col-lg-12 col-xl-12">
         <div class="card">
           <div class="card-header border-0">
         Sub Category Approval Pending Members
          <div class="card-action">
           
           </div>
          </div>
          <div class="table-responsive">
           <table id="default-datatable1" class="table align-items-center table-bordered table-flush">
             <thead>
              <tr>
               <th>No.</th>
               <th>Name</th>
               <th>Email</th>
               <th>Mobile<br>Number</th>
               <th>Custom Sub<br>Category Name</th>
                
              </tr>
             </thead>
             <tbody>
              <?php 
              $i=1;
              
         
$today_date = date("Y-m-d");

              $nq=$d->select("users_master,user_employment_details,business_sub_categories","  business_sub_categories.incepted_user_id=user_employment_details.user_id and user_employment_details.business_category_id = '-1' and user_employment_details.business_sub_category_id = '-1'  AND   user_employment_details.user_id=users_master.user_id and users_master.user_mobile!='0' AND users_master.active_status=0 and business_sub_categories.business_category_id='-2'   "," group by users_master.user_mobile ORDER BY users_master.register_date ASC  ");


              while ($newUserData=mysqli_fetch_array($nq)) {

             
                 
               ?>
               <tr>
                 <td><?php echo $i++; ?></td>
                 <td><a href="approveMember?id=<?php echo $newUserData['user_id']; ?>"><?php echo $newUserData['user_full_name']; ?></a></td>
                 <td><?php echo $newUserData['user_email']; ?></td>
                 <td><?php echo $newUserData['user_mobile']; ?></td>
                 <td><?php echo html_entity_decode(  $newUserData['sub_category_name']); ?></td>

                 </tr>
              <?php  } ?>
             </tbody>
           </table>
         </div>
         </div>
       </div>
    </div>


    <div class="row">
       <div class="col-12 col-lg-12 col-xl-12">
         <div class="card">
           <div class="card-header border-0">
         Business Name Change Requests
          <div class="card-action">
           
           </div>
          </div>
          <div class="table-responsive">
           <table id="default-datatable2" class="table align-items-center table-bordered table-flush">
             <thead>
              <tr>
               <th>No.</th>
               <th>Name</th>
               <th>Email</th>
               <th>Mobile<br>Number</th>
               <th>Current<br>Business<br>Name</th>
               <th>Requested<br>Business<br>Name</th>
               <th>Requested<br>Date</th> 
              </tr>
             </thead>
             <tbody>
              <?php 
              $i=1;
              
         
$today_date = date("Y-m-d");

              $nq=$d->select("users_master,business_name_change_request_masater,user_employment_details"," user_employment_details.user_id = users_master.user_id and  business_name_change_request_masater.request_status = 'Pending'   AND   business_name_change_request_masater.user_id=users_master.user_id and users_master.user_mobile!='0' AND users_master.active_status=0    "," group by users_master.user_mobile ORDER BY business_name_change_request_masater.requested_at ASC  ");


              while ($newUserData=mysqli_fetch_array($nq)) {

             
          
               ?>
               <tr>
                 <td><?php echo $i++; ?></td>
                 <td><a href="approveBusinessName?id=<?php echo $newUserData['user_id']; ?>&business_name_change_request_id=<?php echo $newUserData['business_name_change_request_id']; ?>"><?php echo $newUserData['user_full_name']; ?></a></td>
                 <td><?php echo $newUserData['user_email']; ?></td>
                 <td><?php echo $newUserData['user_mobile']; ?></td>
                 <td><?php echo html_entity_decode(  $newUserData['company_name']); ?></td>
                 <td><?php echo  wordwrap(html_entity_decode(  $newUserData['requested_business_name']),15,"<br>\n");
  ?></td>
                 <td data-order="<?php echo date("U",strtotime($newUserData['requested_at'])); ?>" ><?php echo $newUserData['requested_at']; ?></td>
                 </tr>
              <?php  } ?>
             </tbody>
           </table>
         </div>
         </div>
       </div>
    </div>
<?php  /* ?>
     <div class="row">
       <div class="col-12 col-lg-12 col-xl-12">
         <div class="card">
           <div class="card-header border-0">
          Interest Approval Pending Members
          <div class="card-action">
           
           </div>
          </div>
          <div class="table-responsive">
           <table id="default-datatable2" class="table align-items-center table-bordered table-flush">
             <thead>
              <tr>
               <th>No.</th>
               <th>Name</th>
               <th>Email</th>
               <th>Mobile Number</th>
               <th>Interest</th>
                
              </tr>
             </thead>
             <tbody>
              <?php 
              $i=1;
              
         
$today_date = date("Y-m-d");

              $nq=$d->select("users_master,user_employment_details,interest_master","  interest_master.added_by_member_id=users_master.user_id and    user_employment_details.user_id=users_master.user_id and users_master.user_mobile!='0' AND users_master.active_status=0 and interest_master.int_status='User Added'   "," group by interest_master.interest_id  ORDER BY interest_master.created_at ASC  ");


              while ($newUserData=mysqli_fetch_array($nq)) { ?>
               <tr>
                 <td><?php echo $i++; ?></td>
                 <td><a href="approveInterest?id=<?php echo $newUserData['user_id']; ?>&interest_id=<?php echo $newUserData['interest_id']; ?>"><?php echo $newUserData['user_full_name']; ?></a></td>
                 <td><?php echo $newUserData['user_email']; ?></td>
                 <td><?php echo $newUserData['user_mobile']; ?></td>
                 <td><?php echo $newUserData['interest_name']; ?></td>
                 </tr>
              <?php  } ?>
             </tbody>
           </table>
         </div>
         </div>
       </div>
    </div>
    <?php  */ ?>
    <?php } ?> 