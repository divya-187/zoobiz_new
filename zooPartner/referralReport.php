<?php 
error_reporting(0);

 ?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
 

<h4 class="page-title">Referral  Report</h4>
 <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Referral  Report</li>
         </ol>
      <form action="" method="get">
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
           
       
        <select name="refer_by"  class="form-control single-select">
          
           <option  <?php if ( isset($_REQUEST['refer_by']) &&   $_REQUEST['refer_by'] ==0 ) { echo 'selected';} ?>  value="0">All</option>
            <option  <?php if ( isset($_REQUEST['refer_by']) &&   $_REQUEST['refer_by'] ==1 ) { echo 'selected';} ?> value="1">Social Media</option>
            <option  <?php if ( isset($_REQUEST['refer_by']) &&   $_REQUEST['refer_by'] ==2 ) { echo 'selected';} ?>  value="2">Member / Friend</option>
            <?php /* <option   <?php if ( isset($_REQUEST['refer_by']) &&   $_REQUEST['refer_by'] ==3 ) { echo 'selected';} ?> value="3">Other</option> */ ?>
           
        </select>
         
       </div>
        <div class="col-sm-6">
          <div class="">
            <div id="dateragne-picker">
                <div class="input-daterange input-group">
                <input readonly="" type="text" class="form-control" autocomplete="off"   placeholder="Start Date" name="from" value="<?php echo $_GET['from']; ?>" />
                <div class="input-group-prepend">
                 <span class="input-group-text">to</span>
                </div>
                <input readonly="" type="text" class="form-control" autocomplete="off"   placeholder="End Date" name="toDate" value="<?php echo $_GET['toDate']; ?>" />
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
           
            <table id="example" class="table table-bordered">
              <thead>
                <tr>
                 
                  <th class="text-right">#</th>
                 
                  <th>Business Name</th>
                  <th>City</th>
                  <th>User Name</th>
                   
                  <th>User Mobile</th>
                   <th>refer by</th>
                   <?php  if ( $_GET['refer_by'] != 1 ) {  ?>
                   <th>Refer Person Name</th>
                   <th>Refer Person Phone No.</th>
                 <?php } ?> 
                   <!--  <th>ReMark</th> -->
                   <th>Date</th>
                   <th>View Profile</th>
                    <th>Edit</th> 
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                $where ="";
  if ( isset($_GET['from']) && $_GET['from'] !='' && isset($_GET['toDate']) && $_GET['toDate'] !='' ) { 
                 extract(array_map("test_input" , $_GET));
                $from = date('Y-m-d', strtotime($from));
                $toDate = date('Y-m-d', strtotime($toDate));
                $date=date_create($from);
                $dateTo=date_create($toDate);
                $nFrom= date_format($date,"Y-m-d 00:00:01");
                $nTo= date_format($dateTo,"Y-m-d 23:59:59");
                $where .=" and  users_master.register_date  BETWEEN '$nFrom' AND '$nTo'";
}
 if (isset($_GET['refer_by'])!='' && $_GET['refer_by'] != 0 ) { 
                 extract(array_map("test_input" , $_GET));
                $where .=" and  users_master.refer_by  = '$refer_by' ";
}                
               
                $q6=$d->select("company_master,users_master","company_master.company_id =  users_master.company_id  and    users_master.active_status= 0  and users_master.refer_by!= 0  AND users_master.active_status=0 AND users_master.office_member=0   $where  ","");

                $user_id_array = array('0');
                 while ($data3=mysqli_fetch_array($q6)) {
                  $user_id_array[] = $data3['user_id'];
                 }
                  $user_id_array = implode(",", $user_id_array);
 
                 $q3= $d->select("company_master,users_master,user_employment_details, cities"," cities.city_id = users_master.city_id and   user_employment_details.user_id = users_master.user_id and   company_master.company_id =  users_master.company_id  and    users_master.active_status= 0  and users_master.refer_by!= 0 AND users_master.active_status=0 AND users_master.office_member=0   $where  ","");


                
                 $user_employment_details=$d->select("users_master,user_employment_details ","   user_employment_details.user_id=users_master.user_id and users_master.user_id in ($user_id_array) AND users_master.active_status=0  ","");
 
                 $user_employment_details_array = array();
                 while ($user_employment_details_data=mysqli_fetch_array($user_employment_details)) {
                  $user_employment_details_array[$user_employment_details_data['user_id']] = $user_employment_details_data;
                 }


                  
               while ($data=mysqli_fetch_array($q3)) {
                extract($data);
               
 
              
                 
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                   
                  <td><?php  echo $company_name; ?></td>
                  <td><?php echo $city_name; ?> </td>
                  <td><?php echo  $salutation.' '.$user_full_name; ?></td>
                  
                  <td><?php echo $user_mobile; ?></td>

                  <td><?php if($refer_by=="1") {echo "Social Media";} 
                  else if($refer_by=="2") {echo "Member / Friend";}
                  else if($refer_by=="3") {echo "Other";}
                   ?></td>
                   <?php  if ( $_GET['refer_by'] != 1 ) {  ?>
                  <td><?php echo wordwrap($refere_by_name,20,"<br>\n"); ?></td>
                  <td><?php echo  $refere_by_phone_number ; ?></td> 
                <?php } ?> 
                  <?php /* <td><?php echo wordwrap($remark,20,"<br>\n"); ?></td>   */ ?>
                  <td data-order="<?php echo date("U",strtotime($register_date)); ?>"><?php echo date("d-m-Y h:i:s A",strtotime($register_date));  ?></td>
                  <td>
                    <?php 
                    $isProfileComplete = $user_employment_details_array[$user_id];
                   if(!empty($isProfileComplete)) {?> 
                      <form action="viewMember" method="get">    
                          <input type="hidden" name="id" value="<?php echo $user_id; ?>">    
                          <button type="submit" name="" class="btn btn-secondary btn-sm "> View Profile</button>
                        </form>
                      <?php }  else {?>
                        <button type="button"  disabled="" class="btn btn-danger btn-sm ">Profile Incomplete</button>
                       <?php } ?> 
                  </td>
                  <td>

                      <a data-toggle="modal" data-target="#editRefModal" href="javascript:void();" onclick="editRef('<?php echo $user_id; ?>','<?php echo $_REQUEST['refer_by'];?>','<?php echo $_REQUEST['from'];?>','<?php echo $_REQUEST['toDate'];?>');" class="btn btn-sm btn-primary shadow-primary">Edit</a>
                  </td>

               </tr>

             <?php  } ?> 
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


  
 <div class="modal fade" id="editRefModal">
  <div class="modal-dialog custom-modal">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Edit Referral</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editReferFrm" action="controller/userController.php" method="post" enctype="multipart/form-data">
           <div id="data_ref"></div>
         </form>
      </div>
     
    </div>
  </div>
</div>