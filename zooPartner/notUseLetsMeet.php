<?php 
error_reporting(0);

?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <form action="" method="get">
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title">Not Use Let's Meet</h4>
           <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Not Use Let's Meet</li>
         </ol>
         
           <a class="btn btn-sm btn-secondary" href="meetingReport">Use Let's Meet</a>
        </div>
         
       <div class="col-sm-6">
          <div class="">
            <div id="dateragne-picker">
              <div class="input-daterange input-group">
                <input readonly="" type="text" class="form-control" autocomplete="off" required="" placeholder="Start Date" name="from" value="<?php if ( !isset($_GET['from'])) { echo date('Y-m-01');} else {  echo $_GET['from']; } ?>" />
                <div class="input-group-prepend">
                 <span class="input-group-text">to</span>
               </div>
               <input readonly="" type="text" class="form-control" autocomplete="off" required="" placeholder="End Date" name="toDate" value="<?php if ( !isset($_GET['toDate'])) { echo date('Y-m-t');} else { echo $_GET['toDate'];  } ?>" />
             </div>
           </div>
         </div>
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
                  <th>User Name</th>
                  <th>Mobile Number</th>
                  <th>Email</th> 
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


                /*$q3=$d->select("  user_employment_details, users_master a LEFT JOIN meeting_master s ON a.user_id = s.user_id and  s.date  BETWEEN '$nFrom' AND '$nTo'    " ,"user_employment_details.user_id = a.user_id and (s.user_id IS NULL or s.member_id IS NULL )    
                  "," group by a.user_id  ORDER BY a.user_full_name asc ");*/

                $q3=$d->selectRow("a.user_id,a.user_full_name,a.user_mobile,a.user_email","  user_employment_details, users_master a LEFT JOIN meeting_master s ON  (a.user_id = s.user_id OR a.user_id = s.member_id  ) and  s.date  BETWEEN '$nFrom' AND '$nTo'  AND a.active_status=0      " ,"user_employment_details.user_id = a.user_id and (s.user_id IS NULL or s.member_id IS NULL ) and a.user_mobile!='0' 
                  "," group by a.user_id  ORDER BY a.user_full_name asc ");
 
 
                 while ($data=mysqli_fetch_array($q3)) {

             
                  
                 extract($data);

                 ?>
                 <tr>

                  <td class="text-right"><?php echo $i++; ?></td>

                  <td><a target="_blank"   title="View Profile"  href="viewMember?id=<?php echo $user_id; ?>" ><?php echo $user_full_name; ?></a></td>
                   
                  


                  <td><?php echo $user_mobile ; ?></td>
                  <td><?php echo $user_email; ?></td> 


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