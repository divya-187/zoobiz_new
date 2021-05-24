  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">Business Houses</h4>
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Business Houses</li>
         </ol>
       </div>
       <div class="col-sm-3">
         <div class="btn-group float-sm-right">
          <a href="#" data-toggle="modal" data-target="#addCategory" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Add New </a>
       </div>
     </div>
   </div>

   <form action="" method="get">
      <div class="row pt-2 pb-2">
         
         <div class="col-sm-4">
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
            <table id="exampleList" class="table table-bordered">
              <thead>
                <tr>
                 
                  <th>#</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Company</th>
                   <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 


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

                $i=1;
              $q=$d->select("users_master,business_houses,user_employment_details,business_categories,business_sub_categories","    business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND business_houses.user_id= users_master.user_id $where ","ORDER BY business_houses.order_id ASC");
              $alredyAray=array();
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                array_push($alredyAray, $user_id);
                ?>
                <tr>
                
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $salutation.' '.$user_full_name; ?></td>
                  <td><?php echo $category_name; ?>-<?php echo $sub_category_name; ?></td>
                  <td><?php echo $company_name; ?></td>
                 <td>
                    <form action="controller/memberController.php" method="post">    
                          <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">    
                          <input type="hidden" name="business_houses_id" value="<?php echo $business_houses_id; ?>">    
                          <input type="hidden" name="removeBusinesHouses" value="removeBusinesHouses">                 
                          <button type="submit" name="" class="btn shadow-danger btn-danger btn-sm form-btn">Remove </button>
                        </form>
                 </td>
                

               </tr>

             <?php } ?> 
           </tbody>

         </table>
       </div>
     </div>
   </div>
 </div>
</div><!-- End Row-->

 
<!-- End container-fluid-->

</div><!--End content-wrapper-->
<!--Start Back To Top Button-->



<div class="modal fade" id="addCategory">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Add Business Houses</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="addHousesForm" action="controller/memberController.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Select Member <span class="required">*</span></label>
                    <div class="col-sm-8">
                       <select required="" type="text" name="user_id"  class="single-select form-control">
                        <option value="">-- Select --</option>
                         <?php
                         $ids = join("','",$alredyAray);   
                          $q=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","    business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.user_id NOT IN  ('$ids') ");
                        while($row=mysqli_fetch_array($q)){ ?> 
                        <option value="<?php echo $row['user_id']; ?>"><?php echo $row['user_full_name']; ?>-<?php echo $row['category_name']; ?></option>
                        <?php }?>
                      </select>
                    </div>
                </div>
               
         
                <div class="form-footer text-center">
                  <input type="hidden" name="addBusinessHouses" value="addBusinessHouses">
                  <button type="submit" name="" value="" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Add</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->

