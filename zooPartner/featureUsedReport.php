<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <form action="" method="get">
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title">Member Feature Used</h4>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Member Feature Used</li>
          </ol>
        </div>
      </div>
      <div class="row pt-2 pb-2">
        <div class="col-sm-5">
          <div class="">
            <select   name="feature_arr"  class="form-control single-select">
              <option    value="">--Select--</option>
              <option  <?php if ( isset($_REQUEST['feature_arr']) &&   $_REQUEST['feature_arr'] == 4   ) { echo 'selected';} ?>    value="4">All</option>
              <option  <?php if ( isset($_REQUEST['feature_arr']) &&   $_REQUEST['feature_arr'] == 0   ) { echo 'selected';} ?>    value="0">Timeline Used</option>
              <option  <?php if ( isset($_REQUEST['feature_arr']) &&  $_REQUEST['feature_arr'] == 1 ) { echo 'selected';} ?>    value="1">Classified Used</option>
              <option  <?php if ( isset($_REQUEST['feature_arr']) && $_REQUEST['feature_arr'] == 2 ) { echo 'selected';} ?>    value="2">Meetup Used</option>
              <option  <?php if ( isset($_REQUEST['feature_arr']) &&$_REQUEST['feature_arr'] == 3) { echo 'selected';} ?>    value="3">Chat Used</option>
              
              
              
            </select>
          </div>
        </div>
        <div class="col-sm-5">
          <div class="input-daterange input-group">
            <input readonly="" type="text" class="form-control" autocomplete="off"   placeholder="Start Date" id="FromDate" name="from" value="<?php if ( !isset($_GET['from'])) { echo date('Y-m-01');} else {  echo $_GET['from']; } ?>"  />
            <div class="input-group-prepend">
              <span class="input-group-text">to</span>
            </div>
            <input readonly="" type="text" class="form-control" autocomplete="off"   placeholder="End Date" id="ToDate" name="toDate" value="<?php if ( !isset($_GET['toDate'])) { echo date('Y-m-t');} else { echo $_GET['toDate'];  } ?>" />
          </div>
          
          
        </div>
        <div class="col-lg-2 col-3">
          <label  class="form-control-label"> </label>
          <input  class="btn btn-success" type="submit" name="getReport" class="form-control" value="Get Report">
        </div>
      </div>
      
    </form>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <!-- <div class="card-header"><i class="fa fa-table"></i> Data Exporting</div> -->
          <div class="card-body">
            <div class="table-responsive">
              <?php
                // echo "<pre>";print_r($_REQUEST);
                if ( (isset($_REQUEST['feature_arr']) && $_REQUEST['feature_arr'] !='' )   ) {  ?>
                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr>
                                       
                                        <th class="text-right">#</th>
                                        
                                        
                                        <th>Name</th>
                                        <th>Payment Details</th>
                                        <th>refer by</th>
                                        <th>Refer Person Name</th>
                                        <th>Refer Person Phone No.</th>
                                        <th>City</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>BUSINESS Name</th> 
                      <?php  if($_REQUEST['feature_arr'] == 4 || $_REQUEST['feature_arr'] ==3){ ?>
                                         <th>Chat<br>Added</th>
                      <?php } ?>
                      <?php  if($_REQUEST['feature_arr'] == 4 || $_REQUEST['feature_arr'] ==2){ ?>
                                         <th> Meetup<br>Pending</th>
                                         <th>Other<br>User's<br>Meetup<br>Accepted</th>
                                         <th> User's<br>Accepted</th>
                                         <th> Meetup<br>Rejected</th>
                                         <th> Meetup<br>Deleted</th>
                                         <th> Meetup<br>Rescheduled</th>
                                         
                      <?php } ?>
                      <?php  if($_REQUEST['feature_arr'] == 4 || $_REQUEST['feature_arr'] ==1){ ?>
                                         <th>Classified<br>Added</th>
                                         <th>Classifieds<br>Comments</th>
                      <?php } ?>
                      <?php  if($_REQUEST['feature_arr'] == 4 || $_REQUEST['feature_arr'] ==0){ ?>
                                         <th>Timeline<br>Added</th>
                                         <th>Timeline<br>Likes</th>
                                         <th>Timeline<br>Comments</th>
                      <?php } ?>
                                   </tr>
                               </thead>
                               <tbody>
                    <?php
                                  $i=1;
                                  extract(array_map("test_input" , $_REQUEST));
                                  $from = date('Y-m-d', strtotime($from));
                                  $toDate = date('Y-m-d', strtotime($toDate));
                                  $date=date_create($from);
                                  $dateTo=date_create($toDate);
                                  $nFrom= date_format($date,"Y-m-d 00:00:00");
                                  $nTo= date_format($dateTo,"Y-m-d 23:59:59");
                                  $where="";
                                  $leftJoin="";
                                  extract(array_map("test_input" , $_REQUEST));
                                  if (isset($_GET['feature_arr'])!=''  ) { 
                                    if( $_REQUEST['feature_arr'] == 0){
                                     $leftJoin .=" ,timeline_master  ";
                                     $where=" and timeline_master.user_id= users_master.user_id and  timeline_master.created_date  BETWEEN '$nFrom' AND '$nTo'";
                                   }
                                   if($_REQUEST['feature_arr'] == 1 ){
                                    $leftJoin .=" , cllassifieds_master  ";
                                    $where=" and cllassifieds_master.user_id= users_master.user_id  and  cllassifieds_master.created_date  BETWEEN '$nFrom' AND '$nTo'";
                                  }
                                  if($_REQUEST['feature_arr'] == 2){
                                    $leftJoin .="  , meeting_master    ";
                                          // /OR meeting_master.member_id= users_master.user_id
                                    $where=" and (meeting_master.user_id= users_master.user_id or meeting_master.action_user_id= users_master.user_id ) and  meeting_master.date  BETWEEN '$nFrom' AND '$nTo'";
                                  }
                                  if($_REQUEST['feature_arr'] == 3){
                                    $leftJoin .=" , chat_master ";
                                          //OR chat_master.msg_for= users_master.user_id
                                    $where=" and (chat_master.msg_by= users_master.user_id )  and  chat_master.msg_date  BETWEEN '$nFrom' AND '$nTo'";
                                  }
                                  if($_REQUEST['feature_arr'] == 4){
                                    $leftJoin ="  LEFT JOIN chat_master  ON (chat_master.msg_by= users_master.user_id )  and  chat_master.msg_date  BETWEEN '$nFrom' AND '$nTo'   LEFT JOIN meeting_master  ON (meeting_master.user_id= users_master.user_id or meeting_master.member_id= users_master.user_id ) and  meeting_master.date  BETWEEN '$nFrom' AND '$nTo'  LEFT JOIN cllassifieds_master  ON cllassifieds_master.user_id= users_master.user_id  and  cllassifieds_master.created_date  BETWEEN '$nFrom' AND '$nTo'   LEFT JOIN timeline_master  ON timeline_master.user_id= users_master.user_id and  timeline_master.created_date  BETWEEN '$nFrom' AND '$nTo'   ";
                                         /* //OR chat_master.msg_for= users_master.user_id
                                         $where=" and (chat_master.msg_by= users_master.user_id )  and  chat_master.msg_date  BETWEEN '$nFrom' AND '$nTo'";*/
                                       }


                                     }  
                                     
                      /*    echo "cities,user_employment_details,users_master  $leftJoin";
                      echo "cities.city_id= users_master.city_id and    user_employment_details.user_id =users_master.user_id and  users_master.active_status= 0 AND users_master.office_member=0  $where ";exit;*/
                        //echo "users_master,user_employment_details  $leftJoin";exit;
                      
                      $q3=$d->selectRow("users_master.user_id as MainUserId, users_master.salutation, users_master.user_full_name, users_master.refer_by, users_master.refere_by_name, users_master.refere_by_phone_number, users_master.user_email, users_master.user_mobile ,cities.city_name,user_employment_details.* ","cities,user_employment_details,users_master  $leftJoin","cities.city_id= users_master.city_id and    user_employment_details.user_id =users_master.user_id and  users_master.active_status= 0 AND users_master.office_member=0  $where "," group by users_master.user_id");
                      

                      $dataArray = array();
                      $counter = 0 ;
                      foreach ($q3 as  $value) {
                        foreach ($value as $key => $valueNew) {
                          $dataArray[$counter][$key] = $valueNew;
                        }
                        $counter++;
                      }
                      $user_id_array = array('0');
                      
                      for ($l=0; $l < count($dataArray) ; $l++) {
                        $user_id_array[] = $dataArray[$l]['MainUserId'];
                        
                      }
                      $user_id_array = implode(",",  $user_id_array);
                      if($_REQUEST['feature_arr'] == 4 || $_REQUEST['feature_arr'] ==3){
                       $chat_data_qry=$d->select(" chat_master"," msg_by in($user_id_array)","");
                       $chat_count_array = array();
                       while ($chat_data=mysqli_fetch_array($chat_data_qry)) {
                        $chat_count_array[$chat_data['msg_by']][] = $chat_data['msg_by'];
                      }
                    }
                    if($_REQUEST['feature_arr'] == 4 || $_REQUEST['feature_arr'] ==2){
                     $meet_data_qry=$d->select(" meeting_master"," ( (user_id in ($user_id_array) and status='Pending')  or (user_id = action_user_id and status='Reschedule')  ) and  meeting_master.date  BETWEEN '$nFrom' AND '$nTo'   ","");
                     $meet_count_array = array();
                     while ($meet_data=mysqli_fetch_array($meet_data_qry)) {
                      $meet_count_array[$meet_data['user_id']][] = $meet_data['user_id'];
                    }

                    
                    $meet_acc_data_qry=$d->select(" meeting_master","  user_id in ($user_id_array)   and  meeting_master.date  BETWEEN '$nFrom' AND '$nTo'  and status='Approve'  ","");
                    $meet_acc_count_array = array();
                    while ($meet_acc_data=mysqli_fetch_array($meet_acc_data_qry)) {
                      $meet_acc_count_array[$meet_acc_data['user_id']][] = $meet_acc_data['user_id'];
                    }
                    $meet_rej_data_qry=$d->select(" meeting_master"," user_id in ($user_id_array) and  meeting_master.date  BETWEEN '$nFrom' AND '$nTo' and status='Reject' ","");
                    $meet_rej_count_array = array();
                    while ($meet_rej_data=mysqli_fetch_array($meet_rej_data_qry)) {
                      $meet_rej_count_array[$meet_rej_data['user_id']][] = $meet_rej_data['user_id'];
                    }
                    $meet_del_data_qry=$d->select(" meeting_master"," user_id in ($user_id_array) and  meeting_master.date  BETWEEN '$nFrom' AND '$nTo' and status='Deleted' ","");
                    $meet_del_count_array = array();
                    while ($meet_del_data=mysqli_fetch_array($meet_del_data_qry)) {
                      $meet_del_count_array[$meet_del_data['user_id']][] = $meet_del_data['user_id'];
                    }
                    $meet_res_data_qry=$d->select(" meeting_master"," action_user_id in ($user_id_array) and  meeting_master.date  BETWEEN '$nFrom' AND '$nTo' and status='Reschedule' ","");
                    $meet_res_count_array = array();
                    while ($meet_res_data=mysqli_fetch_array($meet_res_data_qry)) {
                      $meet_res_count_array[$meet_res_data['action_user_id']][] = $meet_res_data['action_user_id'];
                    }
                    $meet_inv_data_qry=$d->select(" meeting_master"," member_id in ($user_id_array) and  meeting_master.date  BETWEEN '$nFrom' AND '$nTo' and status='Approve'  ","");
                    $meet_inv_count_array = array();
                    while ($meet_inv_data=mysqli_fetch_array($meet_inv_data_qry)) {
                      $meet_inv_count_array[$meet_inv_data['member_id']][] = $meet_inv_data['member_id'];
                    }
                    }
                    if($_REQUEST['feature_arr'] == 4 || $_REQUEST['feature_arr'] ==1){
                     $cls_data_qry=$d->select(" cllassifieds_master"," user_id in ($user_id_array) and created_date  BETWEEN '$nFrom' AND '$nTo' ","");
                     $cls_count_array = array();
                     while ($cls_data=mysqli_fetch_array($cls_data_qry)) {
                      $cls_count_array[$cls_data['user_id']][] = $cls_data['user_id'];
                    }
                    $cls_cmt_data_qry=$d->select(" cllassified_comment"," user_id in ($user_id_array) and created_date  BETWEEN '$nFrom' AND '$nTo' ","");
                    $cls_cmt_count_array = array();
                    while ($cls_cmt_data=mysqli_fetch_array($cls_cmt_data_qry)) {
                      $cls_cmt_count_array[$cls_cmt_data['user_id']][] = $cls_cmt_data['user_id'];
                    }
                    }
                    if($_REQUEST['feature_arr'] == 4 || $_REQUEST['feature_arr'] ==0){
                     $timeline_data_qry=$d->select(" timeline_master"," user_id in ($user_id_array) and created_date  BETWEEN '$nFrom' AND '$nTo' ","");
                     $timeline_count_array = array();
                     while ($timeline_data=mysqli_fetch_array($timeline_data_qry)) {
                      $timeline_count_array[$timeline_data['user_id']][] = $timeline_data['user_id'];
                    }
                    $timeline_like_data_qry=$d->select(" timeline_like_master"," user_id in ($user_id_array) and modify_date  BETWEEN '$nFrom' AND '$nTo' ","");
                    $timeline_like_count_array = array();
                    while ($timeline_like_data=mysqli_fetch_array($timeline_like_data_qry)) {
                      $timeline_like_count_array[$timeline_like_data['user_id']][] = $timeline_like_data['user_id'];
                    }
                    $timeline_cmt_data_qry=$d->select(" timeline_comments"," user_id in ($user_id_array) and modify_date  BETWEEN '$nFrom' AND '$nTo' ","");
                    $timeline_cmt_count_array = array();
                    while ($timeline_cmt_data=mysqli_fetch_array($timeline_cmt_data_qry)) {
                      $timeline_cmt_count_array[$timeline_cmt_data['user_id']][] = $timeline_cmt_data['user_id'];
                    }
                    }
                  //echo "<pre>"; print_r($dataArray);echo "</pre>";
                  for ($l=0; $l < count($dataArray) ; $l++) {
                  $data = $dataArray[$l];
                  /*  while ($data=mysqli_fetch_array($q3)) {*/
                  extract($data);
                  
                  ?>
                  <tr>
                    
                    <td class="text-right"><?php echo $i++; ?></td>
                    
                    <td><a target="_blank"   title="View Profile"  href="viewMember?id=<?php echo $user_id; ?>" ><?php echo  $salutation.' '.$user_full_name; ?></a></td>
                    <?php
                    $transection_master=$d->select("transection_master","user_id = '$user_id'  "," order by transection_id desc");
                    $transection_master_data=mysqli_fetch_array($transection_master);
                    ?>
                    <td><?php echo 'Plan: '.$transection_master_data['package_name'] ;
                      echo '<br>Payment Mode: '.$transection_master_data['payment_mode'] ;

                      if($transection_master_data['coupon_id'] !=0){
                      $coupon_master=$d->select("coupon_master","coupon_id = '$transection_master_data[coupon_id]'  ","");
                      $coupon_master_data=mysqli_fetch_array($coupon_master);
                      echo '<br>Coupon Name: '.$coupon_master_data['coupon_name'] ;
                      echo '<br>Coupon Code: '.$coupon_master_data['coupon_code'] ;
                      
                      }
                      
                    ?></td>
                    <td><?php if($refer_by=="1") {echo "Social Media";}
                      else if($refer_by=="2") {echo "Member / Friend";}
                      else   {echo "Other";}
                    ?></td>
                    
                    <td><?php echo wordwrap($refere_by_name,20,"<br>\n"); ?></td>
                    <td><?php echo  $refere_by_phone_number ; ?></td>
                    <td><?php echo $city_name ; ?></td>
                    <td><?php echo $user_email ; ?></td>
                    <td><?php echo $user_mobile; ?></td>
                    <td><?php  echo $company_name;
                    ?></td>
                    <?php  if($_REQUEST['feature_arr'] == 4 || $_REQUEST['feature_arr'] ==3){
                    $arr_new =array();
                    if(!empty($chat_count_array[$MainUserId])){
                    $arr_new = $chat_count_array[$MainUserId];
                    }
                    $totalChat = count($arr_new);
                    ?> <td data-order="<?php echo $totalChat;?>" ><?php  echo $totalChat;?></td>
                    
                    <?php } ?>
                    <?php  if($_REQUEST['feature_arr'] == 4 || $_REQUEST['feature_arr'] ==2){
                    
                    $arr_new1 =array();
                    if(!empty($meet_count_array[$MainUserId])){
                    $arr_new1 = $meet_count_array[$MainUserId];
                    }
                    $totalMeetupRequested = count($arr_new1);
                    $arr_new2 =array();
                    if(!empty($meet_inv_count_array[$MainUserId])){
                    $arr_new2 = $meet_inv_count_array[$MainUserId];
                    }
                    $totalMeetupAccepted = count($arr_new2);
                    $arr_newcc =array();
                    if(!empty($meet_acc_count_array[$MainUserId])){
                    $arr_newcc = $meet_acc_count_array[$MainUserId];
                    }
                    $totalMeetupAcceptedUser = count($arr_newcc);
                    $arr_newdd =array();
                    if(!empty($meet_rej_count_array[$MainUserId])){
                    $arr_newdd = $meet_rej_count_array[$MainUserId];
                    }
                    $totalMeetupRejected = count($arr_newdd);
                    $arr_newaa =array();
                    if(!empty($meet_del_count_array[$MainUserId])){
                    $arr_newaa = $meet_del_count_array[$MainUserId];
                    }
                    $totalMeetupDeleted = count($arr_newaa);
                    $arr_newkk =array();
                    if(!empty($meet_res_count_array[$MainUserId])){
                    $arr_newkk = $meet_res_count_array[$MainUserId];
                    }
                    $totalMeetupRes = count($arr_newkk);
                    
                    ?>
                    <td  data-order="<?php echo $totalMeetupRequested;?>"> <?php echo $totalMeetupRequested;?></td>
                    <td data-order="<?php echo $totalMeetupAccepted;?>"><?php echo $totalMeetupAccepted;?></td>
                    <td data-order="<?php echo $totalMeetupAcceptedUser;?>"><?php echo $totalMeetupAcceptedUser;?></td>
                    <td data-order="<?php echo $totalMeetupRejected;?>"><?php echo $totalMeetupRejected;?></td> <td data-order="<?php echo $totalMeetupDeleted;?>"><?php echo $totalMeetupDeleted;?></td>
                </td> <td data-order="<?php echo $totalMeetupRes;?>"><?php echo $totalMeetupRes;?></td>
              <?php } ?>
              <?php  if($_REQUEST['feature_arr'] == 4 || $_REQUEST['feature_arr'] ==1){
              $arr_new3 =array();
              if(!empty($cls_count_array[$MainUserId])){
              $arr_new3 = $cls_count_array[$MainUserId];
              }
              $totalClassifieds = count($arr_new3);
              $arr_new_cmt =array();
              if(!empty($cls_cmt_count_array[$MainUserId])){
              $arr_new_cmt = $cls_cmt_count_array[$MainUserId];
              }
              $totalClassifiedsCmt = count($arr_new_cmt);

              ?><td data-order="<?php echo $totalClassifieds;?>">
              <?php echo $totalClassifieds;?></td>
              <td data-order="<?php echo $totalClassifiedsCmt;?>">
                <?php echo $totalClassifiedsCmt;?>
              </td>
              <?php } ?>
              <?php  if($_REQUEST['feature_arr'] == 4 || $_REQUEST['feature_arr'] ==0){
              $arr_new4 =array();
              if(!empty($timeline_count_array[$MainUserId])){
              $arr_new4 = $timeline_count_array[$MainUserId];
              }
              $totalTimeline = count($arr_new4);
              $arr_new_like =array();
              if(!empty($timeline_like_count_array[$MainUserId])){
              $arr_new_like = $timeline_like_count_array[$MainUserId];
              }
              $totalTimelineLike = count($arr_new_like);
              $arr_new_cmt =array();
              if(!empty($timeline_cmt_count_array[$MainUserId])){
              $arr_new_cmt = $timeline_cmt_count_array[$MainUserId];
              }
              $totalTimelineCmt = count($arr_new_cmt);
              ?>
              <td data-order="<?php echo $totalTimeline;?>" ><?php echo $totalTimeline;?></td>
              <td data-order="<?php echo $totalTimelineLike;?>"> <?php echo $totalTimelineLike;?></td>
              <td data-order="<?php echo $totalTimelineCmt;?>"> <?php echo $totalTimelineCmt;?>
              </td>
              <?php } ?>
            </tr>
            <?php  } ?>
          </tbody>
        </table>
        <?php } else {
        echo "Please select Feature from drop down.";
        } ?>
      </div>
    </div>
  </div>
</div>
</div><!-- End Row-->
</div>
<!-- End container-fluid-->
</div><!--End content-wrapper-->
<!--Start Back To Top Button-->