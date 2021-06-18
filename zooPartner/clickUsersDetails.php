<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <?php
    extract(array_map("test_input" , $_REQUEST));
    if(!isset($from) && !isset($toDate)  ){
    $from =date('Y-m-01');
    $toDate =date('Y-m-t');
    }
    
    $i=1;
    
    $from = date('Y-m-d', strtotime($from));
    $toDate = date('Y-m-d', strtotime($toDate));
    $date=date_create($from);
    $dateTo=date_create($toDate);
    $nFrom= date_format($date,"Y-m-d 00:00:00");
    $nTo= date_format($dateTo,"Y-m-d 23:59:59");
    $where="";
    
    $office_members_qry=$d->selectRow("user_id","users_master"," office_member =1 and city_id='$selected_city_id' "," ");
    $office_array = array('0');
    while ($office_members_data=mysqli_fetch_array($office_members_qry)) {
    $office_array[] =$office_members_data['user_id'];
    }
    $office_array = implode(",", $office_array);
    
    
    $where="created_at  BETWEEN '$nFrom' AND '$nTo' and user_id not in ($office_array)  ";
    $device = "";
    if(isset($_REQUEST['device'])){
    $device =$_REQUEST['device'];
    if($_REQUEST['device']==0){
    $where .=" and lower(device)='android' ";
    } else if($_REQUEST['device']==1) {
    $where .=" and lower(device)='ios' ";
    }
    
    }
    $title= "";
    if($feature_used==0){
    $title= "Members Menu";
    } else if($feature_used==1){
    $title= "Geo Tags Menu";
    }else if($feature_used==2){
    $title= "Classifieds Old";
    }else if($feature_used==3){
    $title= "Seasonal Greetings Old";
    }else if($feature_used==4){
    $title= "Timeline";
    }else if($feature_used==5){
    $title= "Chat";
    }else if($feature_used==6){
    $title= "Meetups";
    }else if($feature_used==7){
    $title= "Other User's Profile";
    }else if($feature_used==8){
    $title= "Classifieds New";
    }else if($feature_used==9){
    $title= "Seasonal Greetings New";
    }
    ?>
    <div class="row pt-2 pb-2">
      <div class="col-sm-6">
        <h4 class="page-title">Users Details <?php echo $title; ?></h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="welcome">Home</a></li>
          <li class="breadcrumb-item"><a href="appFeatureClicked?&from=<?php echo $from;?>&toDate=<?php echo $toDate;?>&device=<?php echo $device;?>">App Feature Clicked</a></li>
          <li class="breadcrumb-item active" aria-current="page">Users Details <?php echo $title; ?></li>
        </ol>
      </div>
      <div class="col-sm-6">
        
        
        
      </div>
    </div>
    <!-- End Breadcrumb-->
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
                    
                    <th>User Name</th>
                    <th>Mobile Number</th>
                    <th>Company Name</th>
                    <th>Feature Clicked Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i=1;
                  $feature_usage_master_qry=$d->select("feature_usage_master"," $where and feature_used = $feature_used "," ");
                  $user_id_arr = array('0');
                  $dataArray = array();
                  $counter = 0 ;
                  foreach ($feature_usage_master_qry as  $value) {
                  foreach ($value as $key => $valueNew) {
                  $dataArray[$counter][$key] = $valueNew;
                  }
                  $counter++;
                  }
                  $user_id_array = array('0');
                  
                  for ($l=0; $l < count($dataArray) ; $l++) {
                  $user_id_array[] = $dataArray[$l]['user_id'];
                  }
                  $user_id_array = implode(",", $user_id_array);
                  
                  
                  $q=$d->select("users_master,user_employment_details"," users_master.user_id in($user_id_array)  and  user_employment_details.user_id=users_master.user_id  AND  users_master.active_status=0  and users_master.city_id='$selected_city_id'   ","");
                  $details_array = array();
                  while ($u_data=mysqli_fetch_array($q)) {
                  $details_array[$u_data['user_id']] =$u_data;
                  }
                  
                  for ($l=0; $l < count($dataArray) ; $l++) {
                  if(!empty($details_array[$dataArray[$l]['user_id']])) {
                  $user_data  = $details_array[$dataArray[$l]['user_id']];
                  }
                  ?>
                  <tr>
                    
                    <td class="text-right"><?php echo $i++; ?></td>
                    
                    
                    <td><a target="_blank"   title="View Profile"  href="memberView?id=<?php echo $user_data['user_id']; ?>" ><?php  echo $user_data['user_full_name'];  ?></a></td>
                    <td><?php echo $user_data['user_mobile']; ?></td>
                    <td><?php echo $user_data['company_name']; ?></td>
                    <td><?php echo date("d-m-Y H:i:s", strtotime($dataArray[$l]['created_at']));?></td>
                  </tr>
                  <?php } ?>
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