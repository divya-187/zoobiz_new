  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-6">
          <h4 class="page-title">Category Wise Users Details</h4>
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           <li class="breadcrumb-item"><a href="categorywiseFollow">Category Wise Follow</a></li>
            <li class="breadcrumb-item active" aria-current="page">Category Wise Users Details</li>
         </ol>
       </div>
       <div class="col-sm-6">
         
            <form action=""   method="post" accept-charset="utf-8">
        <?php 
        
   
          $qry=$d->select("business_categories","  category_status=0","ORDER BY category_name ASC");
          ?>
       
        <select name="business_category_id" onchange="this.form.submit();" class="form-control single-select">
          <option value="">-- Select Category --</option>
           <option  <?php if ( isset($_REQUEST['business_category_id']) &&  $_REQUEST['business_category_id']==0 ) { echo 'selected';} ?> value="0">All</option>
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
                  
                  <th>#</th>
                 
                  <th>Category Name</th>
                  <th>User Name</th>
                   
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                extract($_REQUEST);

                if( !isset($_REQUEST['business_category_id']) ||  $_REQUEST['business_category_id']==0 ){

                    $q=$d->select("category_follow_master,users_master,business_categories ","   users_master.user_id = category_follow_master.user_id and     business_categories.business_category_id =category_follow_master.category_id and   category_follow_master.category_id = business_categories.business_category_id AND users_master.office_member=0 AND users_master.active_status=0    "," ");
                } else {

                    
                  $q=$d->select("category_follow_master,users_master,business_categories ","  users_master.user_id = category_follow_master.user_id and     business_categories.business_category_id =category_follow_master.category_id and   category_follow_master.category_id = business_categories.business_category_id and category_follow_master.category_id=$_REQUEST[business_category_id] AND users_master.office_member=0 AND users_master.active_status=0    "," ");


                 // $q3=$d->select("category_follow_master"," category_id='$business_category_id'","");

                }
                  
              
               while ($data=mysqli_fetch_array($q)) {
                extract($data);
                ?>
                <tr>
                  
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $category_name; ?></td>
                  <td> <a href="viewMember?id=<?php echo $user_id; ?>"><?php echo $user_full_name; ?></a></td>
                  
                

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