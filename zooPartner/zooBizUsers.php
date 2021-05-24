<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title">All Users</h4>
           <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Users</li>
         </ol>
       </div>
         
     </div>


      <form action="" method="get">
      <div class="row pt-2 pb-2">
         
         <div class="col-sm-3">
          <div class="">
            <?php //echo "<pre>"; print_r($_GET); echo "</pre>";?>

             <select type="text"   id="filter_business_category_id" 
             onchange="getSubCategory2();"   class="form-control single-select" name="filter_business_category_id">


             
                            <option value="">-- Select --</option>
                            <option  <?php if( isset($_GET['filter_business_category_id']) &&   $_GET['filter_business_category_id'] == 0 ) { echo 'selected';} ?>  value="0">All</option>
                            <?php $qb=$d->select("business_categories"," category_status in (0,2)  ","");
                            while ($bData=mysqli_fetch_array($qb)) {?>
                              <option <?php if( isset($_GET['filter_business_category_id']) && $_GET['filter_business_category_id']== $bData['business_category_id']) { echo 'selected';} ?> value="<?php echo $bData['business_category_id']; ?>"><?php echo $bData['category_name']; ?></option>
                            <?php } ?> 
                          </select>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="">
             <select id="filter_business_categories_sub"  class="form-control single-select" name="filter_business_categories_sub" type="text"   >
                            <option value="">-- Select --</option>
                            <option <?php if( isset($_GET['filter_business_categories_sub']) &&   $_GET['filter_business_categories_sub'] == 0 ) { echo 'selected';} ?>  value="0">All</option>
                            <?php if(isset($_GET['filter_business_category_id']) && $_GET['filter_business_category_id'] !=0  ) {
                            $business_category_id =  $_GET['filter_business_category_id'];

                              $q3=$d->select("business_sub_categories","business_category_id='$business_category_id' and sub_category_status in (0,2) ","");
                              while ($blockRow=mysqli_fetch_array($q3)) {
                                ?>
                                <option <?php if( isset($_GET['filter_business_categories_sub']) &&  $blockRow['business_sub_category_id']== $_GET['filter_business_categories_sub']) { echo 'selected';} ?> value="<?php echo $blockRow['business_sub_category_id'];?>"><?php echo $blockRow['sub_category_name'];?></option>
                              <?php } } ?>
                            </select>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="">
             <select id="view_otp"  class="form-control single-select" name="view_otp" type="text"   >  <option <?php if( isset($_GET['view_otp']) &&   $_GET['view_otp'] == 0 ) { echo 'selected';} ?>  value="0">Hide OTP</option>
              <option <?php if( isset($_GET['view_otp']) &&   $_GET['view_otp'] ==1 ) { echo 'selected';} ?>  value="1">View OTP</option>
                            
                            </select>
          </div>
        </div>


        <div class="col-sm-2">
          <div class="">
             <select id="device"  class="form-control single-select" name="device" type="text"   >
                            <option value="">All</option>
                            <option <?php if( isset($_GET['device']) &&   $_GET['device'] == 0 ) { echo 'selected';} ?>  value="0">Android Users</option>
                             <option <?php if( isset($_GET['device']) &&   $_GET['device'] == 1 ) { echo 'selected';} ?>  value="1">iOS Users</option>
                        </select>  
          </div>
        </div>
      

         <div class="col-lg-2 col-3">
            <label  class="form-control-label"> </label>
              <input  class="btn btn-success" type="submit" name="getReport" class="form-control" value="Search">
          </div>
     </div>
   </form>
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
                 <th>ZOOBIZ ID</th>
                  <th>Name</th>
                   <th>Mobile Number</th>
                  <?php if(isset($_GET['view_otp']) && $_GET['view_otp']==1 ){?>
                  <th>OTP</th>
                  <?php }?>
                  <th>EMail</th>
                  <th>Category</th>
                  <th>Sub Category</th>
                   <th>Device</th>
                   <th>Registration Date</th>
                   <th>last Active Date</th>
                   <!-- <th>View Profile</th> -->
                   
                </tr>
              </thead>
              <tbody>
                <?php 

//24nov2020
$business_categories_qry=$d->select("business_categories"," category_status != 2  ");
     $business_categories_array = array();         
     $business_categories_ids =  array();         
while($business_categories_data=mysqli_fetch_array($business_categories_qry)) {
   $business_categories_array[$business_categories_data['business_category_id']] = $business_categories_data['category_name'];
   $business_categories_ids[]= $business_categories_data['business_category_id'];
}

$business_categories_ids = implode(",", $business_categories_ids);
$business_sub_categories_qry=$d->select("business_sub_categories","   business_category_id in ($business_categories_ids)   ");
     $business_sub_categories_array = array();         
       
while($business_sub_categories_data=mysqli_fetch_array($business_sub_categories_qry)) {
   $business_sub_categories_array[$business_sub_categories_data['business_sub_category_id']] = $business_sub_categories_data['sub_category_name'];
   
}

 $where="";
                  if(isset($_GET['filter_business_category_id']) && $_GET['filter_business_category_id'] !=0 ){
                    $filter_business_category_id = $_GET['filter_business_category_id'];
                    $where .=" and  user_employment_details.business_category_id ='$filter_business_category_id' ";
                  }
                  if(isset($_GET['filter_business_categories_sub']) && $_GET['filter_business_categories_sub'] != 0 ){
                    $filter_business_sub_category_id = $_GET['filter_business_categories_sub'];
                    $where .=" and user_employment_details.business_sub_category_id ='$filter_business_sub_category_id' ";
                  } 
//24nov2020

             if(isset($_GET['device']) && $_GET['device'] != '' ){
                    $device = $_GET['device'];
                    if($device==0){
                      $where .=" and lower(users_master.device) ='android' ";
                    } else {
                      $where .=" and lower(users_master.device) ='ios' ";
                    }
                    
                  } 
                  


                 $q3=$d->select("users_master,user_employment_details,business_categories,business_sub_categories"," business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id and users_master.office_member = 0 AND users_master.active_status=0  $where  ","");
                  


                $i=1;
               while ($data=mysqli_fetch_array($q3)) {
                extract($data);
                ?>
                <tr>
                  <!-- <td class='text-center'>
                    <input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $data['feedback_id']; ?>">
                  </td> -->
                  <td class="text-right"><?php echo $i++; ?></td>
                  <td><?php echo  $zoobiz_id; ?></td>
                   
                  <td><a  target="_blank"  title="View Profile"  href="viewMember?id=<?php echo $user_id; ?>" ><?php echo  $salutation.' '.$user_full_name; ?></a></td>
                  <td><?php echo  $user_mobile; ?></td>
                   <?php if(isset($_GET['view_otp']) && $_GET['view_otp']==1 ){?>
                  <td><?php echo  $otp; ?></td>
                  <?php } ?>
                    <td><?php echo  $user_email; ?></td>
                  <td><?php $cat_array = $business_categories_array[$business_category_id];
                      echo $cat_array; ?></td>
                      <td><?php $sub_cat_array = $business_sub_categories_array[$business_sub_category_id];
                      echo $sub_cat_array; ?></td>
                  <td><?php echo $device; ?></td>
                  <td data-order="<?php echo date("U",strtotime($register_date)); ?>" ><?php echo date("d-m-Y", strtotime($register_date)); ?></td>
                  <td data-order="<?php echo date("U",strtotime($last_login)); ?>" ><?php if($last_login=="0000-00-00 00:00:00"){ echo "-"; }else  echo date("d-m-Y h:i:s A", strtotime($last_login)); ?></td>
                    
                   <!-- <td>
                    <form action="viewMember" method="get">    
                          <input type="hidden" name="id" value="<?php echo $user_id; ?>">    
                          <button type="submit" name="" class="btn btn-danger btn-sm "> View Profile</button>
                        </form>
                    </div>
                 </td> -->
                  

                

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