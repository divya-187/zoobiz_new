<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <form action="" method="get">
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title">App Feature Clicked</h4>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">App Feature Clicked</li>
          </ol>
        </div>
      </div>
      <div class="row pt-2 pb-2">
        <div class="col-sm-5">
          <div class="">
            <select id="device"  class="form-control" name="device" type="text"   >
              <option value="">All</option>
              <option <?php if( isset($_GET['device']) &&   $_GET['device'] == 0 ) { echo 'selected';} ?>  value="0">Android Users</option>
              <option <?php if( isset($_GET['device']) &&   $_GET['device'] == 1 ) { echo 'selected';} ?>  value="1">iOS Users</option>
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
              
              <table id="example" class="table table-bordered">
                <thead>
                  <tr>
                    <th class="text-right">#</th>
                    <th>Feature</th>
                    <th class="text-right">Clicks</th>
                    
                  </tr>
                </thead>
                <tbody>
                  <?php
                  extract(array_map("test_input" , $_REQUEST));
                  if(!isset($from) && !isset($toDate)  ){
                  $from =date('Y-m-01');
                  $toDate =date('Y-m-t');
                  }
                  $office_members_qry=$d->selectRow("user_id","users_master"," office_member =1"," ");
                  $office_array = array('0');
                  while ($office_members_data=mysqli_fetch_array($office_members_qry)) {
                  $office_array[] =$office_members_data['user_id'];
                  }
                  $office_array = implode(",", $office_array);
                  
                  $i=1;
                  
                  $from = date('Y-m-d', strtotime($from));
                  $toDate = date('Y-m-d', strtotime($toDate));
                  $date=date_create($from);
                  $dateTo=date_create($toDate);
                  $nFrom= date_format($date,"Y-m-d 00:00:00");
                  $nTo= date_format($dateTo,"Y-m-d 23:59:59");
                  $where="";
                  
                  
                  $where="created_at  BETWEEN '$nFrom' AND '$nTo' and user_id not in ($office_array) ";
                  $device = "";
                  if(isset($_REQUEST['device'])){
                  $device =$_REQUEST['device'];
                  if($_REQUEST['device']==0){
                  $where .=" and lower(device)='android' ";
                  } else if($_REQUEST['device']==1) {
                  $where .=" and lower(device)='ios' ";
                  }
                  
                  }
                  ?>
                  <tr>
                    <td class="text-right">1</td>
                    <td>Members</td>
                    <?php
                    $totalMemberClicks =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 0 group by feature_used");
                    if($totalMemberClicks==""){
                    $totalMemberClicks = 0 ;
                    } ?>
                    <td class="text-right" data-order="<?php echo $totalMemberClicks;?>">
                      
                      <?php
                      if ($totalMemberClicks==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=0&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalMemberClicks;?>
                      </a>
                      <?php
                      }?>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-right">2</td>
                    <td>Geo Tags</td>
                    <?php $totalGeotagsClicks =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 1  group by feature_used");  if($totalGeotagsClicks==""){
                    $totalGeotagsClicks = 0 ;
                    } ?>
                    <td class="text-right" data-order="<?php echo $totalGeotagsClicks;?>"> <?php
                      if ($totalGeotagsClicks==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=1&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalGeotagsClicks;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>
                  <tr>
                    <td class="text-right">3</td>
                    <td>Classifieds Old</td>
                    <?php $totalClsClicks =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 3 group by feature_used"); if($totalClsClicks==""){
                    $totalClsClicks = 0 ;
                    }?>
                    <td class="text-right" data-order="<?php echo $totalClsClicks;?>"><?php
                      if ($totalClsClicks==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=3&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClsClicks;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>
                  <tr>
                    <td class="text-right">4</td>
                    <td>Classifieds New</td>
                    <?php $totalClsNewClicks =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 8  group by feature_used"); if($totalClsNewClicks==""){
                    $totalClsNewClicks = 0 ;
                    }?>
                    <td class="text-right" data-order="<?php echo $totalClsNewClicks;?>"><?php
                      if ($totalClsNewClicks==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=8&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClsNewClicks;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>
                  <tr>
                    <td class="text-right">5</td>
                    <td>Seasonal Greetings Old</td>
                    <?php $totalSGOClicks =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 3  group by feature_used"); if($totalSGOClicks==""){
                    $totalSGOClicks = 0 ;
                    }?>
                    <td class="text-right" data-order="<?php echo $totalSGOClicks;?>"><?php
                      if ($totalSGOClicks==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=3&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalSGOClicks;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>
                  <tr>
                    <td class="text-right">6</td>
                    <td>Seasonal Greetings New</td>
                    <?php $totalSGNClicks =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 9  group by feature_used"); if($totalSGNClicks==""){
                    $totalSGNClicks = 0 ;
                    }?>
                    <td class="text-right" data-order="<?php echo $totalSGNClicks;?>"><?php
                      if ($totalSGNClicks==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=9&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalSGNClicks;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>
                  <tr>
                    <td class="text-right">7</td>
                    <td>Timeline</td>
                    <?php $totalTimelineClicks =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 4  group by feature_used");if($totalTimelineClicks==""){
                    $totalTimelineClicks = 0 ;
                    } ?>
                    <td class="text-right" data-order="<?php echo $totalTimelineClicks;?>"><?php
                      if ($totalTimelineClicks==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=4&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalTimelineClicks;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>
                  <tr>
                    <td class="text-right">8</td>
                    <td>Chat</td>
                    <?php $totalChatClicks =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 5  group by feature_used"); if($totalChatClicks==""){
                    $totalChatClicks = 0 ;
                    }?>
                    <td class="text-right" data-order="<?php echo $totalChatClicks;?>"><?php
                      if ($totalChatClicks==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=5&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalChatClicks;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>
                  <tr>
                    <td class="text-right">9</td>
                    <td>Meetups</td>
                    <?php $totalMeetupClicks =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 6  group by feature_used");if($totalMeetupClicks==""){
                    $totalMeetupClicks = 0 ;
                    } ?>
                    <td class="text-right" data-order="<?php echo $totalMeetupClicks;?>"><?php
                      if ($totalMeetupClicks==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=6&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalMeetupClicks;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>
                  <tr>
                    <td class="text-right">10</td>
                    <td>Other User's Profile</td>
                    <?php $totalOtherUserClicks =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 7  group by feature_used"); if($totalOtherUserClicks==""){
                    $totalOtherUserClicks = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalOtherUserClicks;?>"><?php
                      if ($totalOtherUserClicks==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=7&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalOtherUserClicks;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>


                  <tr>
                    <td class="text-right">11</td>
                    <td>User's Profile</td>
                    <?php $totalClicks11 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 11  group by feature_used"); if($totalClicks11==""){
                    $totalClicks11 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks11;?>"><?php
                      if ($totalClicks11==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=11&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks11;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">12</td>
                    <td>Share Business Card</td>
                    <?php $totalClicks12 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 12  group by feature_used"); if($totalClicks12==""){
                    $totalClicks12 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks12;?>"><?php
                      if ($totalClicks12==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=12&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks12;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">13</td>
                    <td>Video Button Clicked</td>
                    <?php $totalClicks13 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 13  group by feature_used"); if($totalClicks13==""){
                    $totalClicks13 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks13;?>"><?php
                      if ($totalClicks13==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=13&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks13;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                   <tr>
                    <td class="text-right">14</td>
                    <td>Contact Us</td>
                    <?php $totalClicks14 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 14  group by feature_used"); if($totalClicks14==""){
                    $totalClicks14 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks14;?>"><?php
                      if ($totalClicks14==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=14&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks14;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">15</td>
                    <td>Share App</td>
                    <?php $totalClicks15 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 15  group by feature_used"); if($totalClicks15==""){
                    $totalClicks15 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks15;?>"><?php
                      if ($totalClicks15==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=15&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks15;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">16</td>
                    <td>Rate App</td>
                    <?php $totalClicks16 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 16  group by feature_used"); if($totalClicks16==""){
                    $totalClicks16 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks16;?>"><?php
                      if ($totalClicks16==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=16&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks16;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">17</td>
                    <td>Feedback</td>
                    <?php $totalClicks17 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 17  group by feature_used"); if($totalClicks17==""){
                    $totalClicks17 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks17;?>"><?php
                      if ($totalClicks17==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=17&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks17;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                   <tr>
                    <td class="text-right">18</td>
                    <td>Settings</td>
                    <?php $totalClicks18 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 18  group by feature_used"); if($totalClicks18==""){
                    $totalClicks18 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks18;?>"><?php
                      if ($totalClicks18==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=18&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks18;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">19</td>
                    <td>Circulars</td>
                    <?php $totalClicks19 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 19  group by feature_used"); if($totalClicks19==""){
                    $totalClicks19 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks19;?>"><?php
                      if ($totalClicks19==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=19&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks19;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">20</td>
                    <td>Social Media FB</td>
                    <?php $totalClicks20 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 20  group by feature_used"); if($totalClicks20==""){
                    $totalClicks20 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks20;?>"><?php
                      if ($totalClicks20==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=20&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks20;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                   <tr>
                    <td class="text-right">21</td>
                    <td>Social Media Instagram</td>
                    <?php $totalClicks21 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 21  group by feature_used"); if($totalClicks21==""){
                    $totalClicks21 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks21;?>"><?php
                      if ($totalClicks21==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=21&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks21;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>


                  <tr>
                    <td class="text-right">22</td>
                    <td>Social Media Linked In</td>
                    <?php $totalClicks22 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 22  group by feature_used"); if($totalClicks22==""){
                    $totalClicks22 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks22;?>"><?php
                      if ($totalClicks22==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=22&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks22;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">23</td>
                    <td>Website</td>
                    <?php $totalClicks23 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 23  group by feature_used"); if($totalClicks23==""){
                    $totalClicks23 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks23;?>"><?php
                      if ($totalClicks23==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=23&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks23;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">24</td>
                    <td>Recommended Mettups</td>
                    <?php $totalClicks24 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 24  group by feature_used"); if($totalClicks24==""){
                    $totalClicks24 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks24;?>"><?php
                      if ($totalClicks24==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=24&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks24;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>


                   <tr>
                    <td class="text-right">25</td>
                    <td>Ask ZooBiz</td>
                    <?php $totalClicks25 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 25  group by feature_used"); if($totalClicks25==""){
                    $totalClicks25 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks25;?>"><?php
                      if ($totalClicks25==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=25&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks25;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>


                  <tr>
                    <td class="text-right">26</td>
                    <td>Deal Of The Day</td>
                    <?php $totalClicks26 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 26  group by feature_used"); if($totalClicks26==""){
                    $totalClicks26 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks26;?>"><?php
                      if ($totalClicks26==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=26&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks26;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">27</td>
                    <td>Leads</td>
                    <?php $totalClicks27 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 27  group by feature_used"); if($totalClicks27==""){
                    $totalClicks27 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks27;?>"><?php
                      if ($totalClicks27==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=27&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks27;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">28</td>
                    <td>Member Incepted</td>
                    <?php $totalClicks28 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 28  group by feature_used"); if($totalClicks28==""){
                    $totalClicks28 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks28;?>"><?php
                      if ($totalClicks28==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=28&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks28;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">29</td>
                    <td>Homescreen Search</td>
                    <?php $totalClicks29 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 29  group by feature_used"); if($totalClicks29==""){
                    $totalClicks29 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks29;?>"><?php
                      if ($totalClicks29==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=29&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks29;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">30</td>
                    <td>Invoice Download</td>
                    <?php $totalClicks30 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 30  group by feature_used"); if($totalClicks30==""){
                    $totalClicks30 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks30;?>"><?php
                      if ($totalClicks30==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=30&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks30;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">31</td>
                    <td>Pay Click -Renewal</td>
                    <?php $totalClicks31 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 31  group by feature_used"); if($totalClicks31==""){
                    $totalClicks31 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks31;?>"><?php
                      if ($totalClicks31==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=31&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks31;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                   <tr>
                    <td class="text-right">32</td>
                    <td>Social Media FB- Other User</td>
                    <?php $totalClicks32 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 32  group by feature_used"); if($totalClicks32==""){
                    $totalClicks32 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks32;?>"><?php
                      if ($totalClicks32==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=32&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks32;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">33</td>
                    <td>Social Media Instagram- Other User</td>
                    <?php $totalClicks33 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 33  group by feature_used"); if($totalClicks33==""){
                    $totalClicks33 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks33;?>"><?php
                      if ($totalClicks33==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=33&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks33;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">34</td>
                    <td>Social Media Linkedin- Other User</td>
                    <?php $totalClicks34 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 34  group by feature_used"); if($totalClicks34==""){
                    $totalClicks34 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks34;?>"><?php
                      if ($totalClicks34==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=34&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks34;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>

                  <tr>
                    <td class="text-right">35</td>
                    <td>Notification</td>
                    <?php $totalClicks10 =  $d->count_data_direct("feature_usage_id","feature_usage_master"," $where and feature_used = 10  group by feature_used"); if($totalClicks10==""){
                    $totalClicks10 = 0 ;
                    } ?>
                    <td class="text-right"  data-order="<?php echo $totalClicks10;?>"><?php
                      if ($totalClicks10==0) {
                      echo "0";
                      } else {?>
                      <a href="clickUsersDetails?feature_used=10&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>"   target="_blank"> <?php
                        echo $totalClicks10;?>
                      </a>
                      <?php
                    }?></td>
                  </tr>
                  
                </tbody>
              </table>
              
            </div>
          </div>
        </div>
      </div>
      </div><!-- End Row-->
    </div>
    <!-- End container-fluid-->
    </div><!--End content-wrapper-->
    <!--Start Back To Top Button-->