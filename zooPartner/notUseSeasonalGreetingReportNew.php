<?php 
error_reporting(0);

?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <form action="" method="get">
      <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">Not Use Seasonal Greetings Report(New)</h4>
           <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Not Use Seasonal Greetings Report(New)</li>
         </ol>
           <a class="btn btn-sm btn-secondary" href="useSeasonalGreetingReportNew?seasonal_greet_id=<?php echo $_REQUEST['seasonal_greet_id'];?>">(New) Seasonal Greeting Used</a>
        </div>
      </div>
        <div class="row pt-2 pb-2">  
          <div class="col-sm-4"></div>
       <div class="col-sm-6">
         <?php 
        
   
          $qry=$d->select("seasonal_greet_master"," status='Active'","ORDER BY title ASC");
          //onchange="this.form.submit();"
          ?>

         <select name="seasonal_greet_id"  class="form-control single-select">
            <option     value="0">--Select--</option>
           <?php   
           while ($blockRow=mysqli_fetch_array($qry)) {
         ?>
            <option <?php if ( $_REQUEST['seasonal_greet_id'] ==$blockRow['seasonal_greet_id'] ) { echo 'selected';} ?> value="<?php echo $blockRow['seasonal_greet_id'];?>"><?php echo $blockRow['title'];?></option>
          <?php } ?> 
             
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

               

                $where = "";


                if(isset($_GET['seasonal_greet_id']) && $_GET['seasonal_greet_id'] != "0"){

                  $seasonal_greet_id = $_GET['seasonal_greet_id'];
                  $where =" and s.promotion_id='$seasonal_greet_id'";
                }

                $q3=$d->select("  user_employment_details, users_master a LEFT JOIN seasonal_greeting_share_master s ON a.user_id = s.user_id AND a.active_status=0  and s.is_new = 1   $where  " ,"user_employment_details.user_id = a.user_id and   s.user_id IS NULL  and a.user_mobile!='0'   
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
         
      </div>
    </div>
  </div>
</div>
</div><!-- End Row-->

</div>
<!-- End container-fluid-->

</div> 