<?php 
error_reporting(0);

?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <form action="" method="get">
      <div class="row pt-2 pb-2">
        <div class="col-sm-3">
          <h4 class="page-title">Let's Meet Report</h4>
           <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Let's Meet Report</li>
         </ol>
         
           <a class="btn btn-sm btn-secondary" href="notUseLetsMeet">Not Use Let's Meet</a>
        </div>
         

       <div class="col-sm-5"  >


        <div class="input-daterange input-group">
                <input readonly="" type="text" class="form-control" autocomplete="off"   placeholder="Start Date" id="FromDate" name="from" value="<?php if ( !isset($_GET['from'])) { echo date('Y-m-01');} else {  echo $_GET['from']; } ?>"  />
                <div class="input-group-prepend">
                 <span class="input-group-text">to</span>
                </div>
                <input readonly="" type="text" class="form-control" autocomplete="off"   placeholder="End Date" id="ToDate" name="toDate" value="<?php if ( !isset($_GET['toDate'])) { echo date('Y-m-t');} else { echo $_GET['toDate'];  } ?>" />
               </div>


        

           
       </div>


       <div class="col-sm-2">
         <select name="meet_status"  class="form-control single-select">
           <option  <?php if ( $_REQUEST['meet_status'] =="0" ) { echo 'selected';} ?>  value="0">All</option>
            <option <?php if ( $_REQUEST['meet_status'] =="Pending" ) { echo 'selected';} ?> value="Pending">Pending</option>
            <option <?php if ( $_REQUEST['meet_status']  =="Approve" ) { echo 'selected';} ?> value="Approve">Approved</option>
            <option <?php if ( $_REQUEST['meet_status'] =="Reject" ) { echo 'selected';} ?> value="Reject">Rejected</option>
            <option <?php if (  $_REQUEST['meet_status']   =="Reschedule" ) { echo 'selected';} ?> value="Reschedule">Rescheduled</option>
             <option <?php if (  $_REQUEST['meet_status']   =="Deleted" ) { echo 'selected';} ?> value="Deleted">Deleted</option>  
          
        </select>
       </div>

       <div class="col-lg-2 col-3">
        <label  class="form-control-label"> </label>
        <input  class="btn btn-success" type="submit" name="getReport" class="form-control" value="Get Report">
      </div>
    </div>
  </div>
  <!-- End Breadcrumb-->
</form>


<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <!-- <div class="card-header"><i class="fa fa-table"></i> Data Exporting</div> -->
      <div class="card-body">
        <div class="table-responsive">
          <?php if ( !isset($_GET['from'])) {
            $_GET['from'] = date('Y-m-01');
            $_GET['toDate'] = date('Y-m-t');
           } 


          if ($_GET['from']!='') {  ?>
            <table id="example" class="table table-bordered">
              <thead>
                <tr>

                  <th class="text-right">#</th>
                  <th>From User</th>
                  <th>To User</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Place</th>
                  <th>agenda</th>
                  <th>status</th>
                  <th>reason</th> 
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;

                extract(array_map("test_input" , $_GET));
                $from = date('Y-m-d', strtotime($from));
                $toDate = date('Y-m-d', strtotime($toDate));
                $date=date_create($from);
                $dateTo=date_create($toDate);
                $nFrom= date_format($date,"Y-m-d");
                $nTo= date_format($dateTo,"Y-m-d");

                $where = "";


                if(isset($_GET['meet_status']) && $_GET['meet_status'] != "0"){

                  $meet_status = $_GET['meet_status'];
                  $where =" and meeting_master.status='$meet_status'";
                }

                $q3=$d->select("users_master,meeting_master"," meeting_master.user_id = users_master.user_id  and  meeting_master.date  BETWEEN '$nFrom' AND '$nTo' and users_master.user_mobile!='0' AND users_master.active_status=0    $where 
                  ","ORDER BY meeting_master.date desc ");
 
 
                $dataArray = array();
                $counter = 0 ;
                foreach ($q3 as  $value) {
                  foreach ($value as $key => $valueNew) {
                    $dataArray[$counter][$key] = $valueNew;
                  }
                  $counter++;
                }

                
                $member_id_array = array('0');
                for ($l=0; $l < count($dataArray) ; $l++) {
                  $member_id_array[] = $dataArray[$l]['member_id'];
                }
                $member_id_array = implode(",", $member_id_array);
 
                $member_qry=$d->selectRow("user_full_name,user_id","users_master"," user_id in($member_id_array) ");

                $BArray = array();
                $Bcounter = 0 ;
                foreach ($member_qry as  $value) {
                  foreach ($value as $key => $valueNew) {
                    $BArray[$Bcounter][$key] = $valueNew;
                  }
                  $Bcounter++;
                }
                $member_arr = array();
                for ($l=0; $l < count($BArray) ; $l++) {
                  $member_arr[$BArray[$l]['user_id']] = $BArray[$l]['user_full_name']; 
                }

                for ($l=0; $l < count($dataArray) ; $l++) {
                 $data= $dataArray[$l];
                 extract($data);

                 ?>
                 <tr>

                  <td class="text-right"><?php echo $i++; ?></td>

                  <td><a target="_blank"   title="View Profile"  href="viewMember?id=<?php echo $user_id; ?>" ><?php echo $user_full_name; ?></a></td>
                  <?php $mem = $member_arr[$member_id]; ?> 
                  <td><a target="_blank"   title="View Profile"  href="viewMember?id=<?php echo $member_id; ?>" ><?php echo $mem; ?></a></td>


                  <td><?php echo date("d-m-Y",strtotime($date)) ; ?></td>
                  <td><?php echo $time ; ?></td>
                  <td><?php echo $place; ?></td>
                  <td><?php  echo $agenda; ?></td>
                  <td><?php  echo $status; ?></td>
                  <td><?php  echo $reason; ?></td>
                  


                </tr>

              <?php  } ?> 
            </tbody>

          </table>
        <?php } else {

          echo "Select Date";
        }?>
      </div>
    </div>
  </div>
</div>
</div><!-- End Row-->

</div>
<!-- End container-fluid-->

</div> 