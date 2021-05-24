<?php 
error_reporting(0);

 ?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <form action="" method="get">
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title">Member Details Report -Empty Data</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Member Details Report</li>
         </ol>
         
          <a class="btn btn-sm btn-secondary" href="userInfo"> View Not Empty Details</a>
       </div>
     </div>
<?php //echo "</pre>";print_r($_REQUEST['social_media']);echo "</pre>"; ?> 
      <div class="row pt-2 pb-2">
        <div class="col-sm-5"> 
          <div class="">

             <select multiple="multiple" name="social_media[]"  class="form-control single-select">
           <option  <?php if ( isset($_REQUEST['social_media']) &&   in_array("0", $_REQUEST['social_media'])   ) { echo 'selected';} ?>    value="0">EMPTY FACEBOOK URL</option>
           <option  <?php if ( isset($_REQUEST['social_media']) &&   in_array("1", $_REQUEST['social_media'])  ) { echo 'selected';} ?>    value="1">EMPTY INSTAGRAM URL</option>
           <option  <?php if ( isset($_REQUEST['social_media']) &&   in_array("2", $_REQUEST['social_media']) ) { echo 'selected';} ?>    value="2">EMPTY LINKEDIN URL</option>
           <option  <?php if ( isset($_REQUEST['social_media']) &&   in_array("3", $_REQUEST['social_media']) ) { echo 'selected';} ?>    value="3">EMPTY TWITTER URL </option>
           
          
           
        </select>
          </div>
        </div>

        <div class="col-sm-5"> 
          <div class="">

             <select multiple="multiple" name="company_info[]"  class="form-control single-select">
           <option  <?php if ( isset($_REQUEST['company_info']) &&     in_array("0", $_REQUEST['company_info'])   ) { echo 'selected';} ?>    value="0">EMPTY BUSINESS LOGO</option>
            <option  <?php if ( isset($_REQUEST['company_info']) &&       in_array("1", $_REQUEST['company_info'])   ) { echo 'selected';} ?>    value="1">EMPTY BUSINESS BROCHURE</option>
             <option  <?php if ( isset($_REQUEST['company_info']) &&       in_array("2", $_REQUEST['company_info'])   ) { echo 'selected';} ?>    value="2">EMPTY BUSINESS PROFILE</option>
           
          
           
        </select>
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
//echo "<pre>";print_r($_REQUEST);
            if ( (isset($_REQUEST['social_media']) && $_REQUEST['social_media'] !='' )  || (isset($_REQUEST['company_info']) && $_REQUEST['company_info'] !='' )  ||1   ) {  ?>
            <table id="example" class="table table-bordered">
              <thead>
                <tr>
                 
                  <th class="text-right">#</th>
                 
                  
                  <th>Name</th>
                  <th>City</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>BUSINESS Name</th>
                   <th>Date</th>
                     <th>Action</th>
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
                $nFrom= date_format($date,"Y-m-d 00:00:01");
                $nTo= date_format($dateTo,"Y-m-d 23:59:59");

 $where ="";
if (isset($_REQUEST['company_info'])!='' && $_REQUEST['company_info'] != 0 ) { 
                 extract(array_map("test_input" , $_REQUEST));

                 $company_info = implode(",", $_REQUEST['company_info']);
                if(in_array("0", $_REQUEST['company_info'])){
                   $where .=" and  user_employment_details.company_logo  = '' ";
                }
                if(in_array("1", $_REQUEST['company_info'])){
                   $where .=" and  user_employment_details.company_broucher  = '' ";
                }

                if(in_array("2", $_REQUEST['company_info'])){
                   $where .=" and  user_employment_details.company_profile  = '' ";
                }
                
}  

if (isset($_REQUEST['social_media'])!='' && $_REQUEST['social_media'] != 0 ) { 
                 extract(array_map("test_input" , $_REQUEST));

                  
                if(in_array("0", $_REQUEST['social_media'])){
                   $where .=" and  users_master.facebook  = '' ";
                }
                if(in_array("1", $_REQUEST['social_media'])){
                   $where .=" and  users_master.instagram  = '' ";
                }

                if(in_array("2", $_REQUEST['social_media'])){
                   $where .=" and  users_master.linkedin  = '' ";
                }
                if(in_array("3", $_REQUEST['social_media'])){
                   $where .=" and  users_master.twitter  = '' ";
                }
                
}  
 
 if($where==""){
   $where =" and  user_employment_details.company_logo  = '' and  user_employment_details.company_broucher  = '' and  user_employment_details.company_profile  = '' and  users_master.facebook  = '' and  users_master.instagram  = '' and  users_master.linkedin  = '' and  users_master.twitter  = ''  ";
 }

                $q3=$d->select("users_master,user_employment_details,cities","cities.city_id= users_master.city_id and  user_employment_details.user_id =users_master.user_id and  users_master.active_status= 0 AND users_master.office_member=0  $where ","");
               while ($data=mysqli_fetch_array($q3)) {
                extract($data);
               
/*$companyName="-";
$company_master_qry=$d->select("company_master","  company_id = '$company_id'   ","");
                 if(mysqli_num_rows($company_master_qry)>0) { 
                  $company_master_data=mysqli_fetch_array($company_master_qry);
                  $companyName=$company_master_data['company_name'];
                 }*/
              
                 
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                   
                  <td><a target="_blank"   title="View Profile"  href="viewMember?id=<?php echo $user_id; ?>" ><?php echo  $salutation.' '.$user_full_name; ?></a></td>
                  <td><?php echo $city_name ; ?></td>
                  <td><?php echo $user_email ; ?></td>
                  <td><?php echo $user_mobile; ?></td>
                  <td><?php  echo $company_name;
                   ?></td>
                  <td data-order="<?php echo date("U",strtotime($register_date)); ?>"><?php echo date("d-m-Y h:i:s A",strtotime($register_date));  ?></td>
                   <td>
                    <form action="viewMember" method="get">    
                          <input type="hidden" name="id" value="<?php echo $user_id; ?>" />    
                          <button type="submit" name="" class="btn btn-danger btn-sm "> View Profile</button>
                        </form>
                     
                 </td>
                
                

               </tr>

             <?php  } ?> 
           </tbody>

         </table>
       <?php }  ?>
       </div>
     </div>
   </div>
 </div>
</div><!-- End Row-->

</div>
<!-- End container-fluid-->

</div><!--End content-wrapper-->
<!--Start Back To Top Button-->