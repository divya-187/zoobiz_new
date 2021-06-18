  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-6">
          <h4 class="page-title">Category Wise Users Details</h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           <li class="breadcrumb-item"><a href="categoryWiseUsersReport">Categories Wise Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Category Wise Users Details</li>
         </ol>
       </div>
       <div class="col-sm-6">
         
            <form action=""   method="post" accept-charset="utf-8">
        <?php 
        
   
         $qry=$d->select("business_categories","  category_status=0","ORDER BY category_name ASC");
          ?>
       
        <select name="business_category_id" onchange="this.form.submit();" class="form-control single-select">
          
           <option  value="0">All</option>
          <?php   
           while ($blockRow=mysqli_fetch_array($qry)) {
         ?>
          <option <?php if ( isset($_REQUEST['business_category_id']) &&  $blockRow['business_category_id']==$_REQUEST['business_category_id'] ) { echo 'selected';} ?> value="<?php echo $blockRow['business_category_id'];?>"><?php echo $blockRow['category_name'];?></option>
          <?php }?>
        </select>
      </form>

      
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
                 
                 <th>Category</th>
                  <th>User Name</th>
                   <!-- <th>User Profile</th> -->
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                extract($_REQUEST);
$where12="";
                   if(isset($_GET['filter_city_id']) && $_GET['filter_city_id'] !=0 ){
                    $filter_city_id = $_GET['filter_city_id'];
                    $where12 .=" and  users_master.city_id ='$filter_city_id' ";
                  }
                if( !isset($_REQUEST['business_category_id']) ||  $_REQUEST['business_category_id']==0 ){

                    $q=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","   business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.office_member=0 AND users_master.active_status=0 $where12     ","");
                } else {

                    $q=$d->select("users_master,user_employment_details,business_categories,business_sub_categories","     business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  AND user_employment_details.business_category_id='$_REQUEST[business_category_id]'  AND users_master.office_member=0 AND users_master.active_status=0   $where12 ","");


                  
                }
                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  
                  <td class="text-right"><?php echo $i++; ?></td>
                 <td><?php echo $category_name; ?></td> 
                  <td><a target="_blank"   title="View Profile"  href="viewMember?id=<?php echo $user_id; ?>" ><?php echo $user_full_name; ?></a></td>
                 <!-- <td>
                   <form action="viewMember" method="get">    
                          <input type="hidden" name="id" value="<?php echo $user_id; ?>">    
                          <button type="submit" name="" class="btn btn-secondary btn-sm "> View Profile</button>
                        </form>
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