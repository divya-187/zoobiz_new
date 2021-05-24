<?php 
error_reporting(0);
 
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <form action="" method="get">
      <div class="row pt-2 pb-2">
        <div class="col-sm-4">
          <h4 class="page-title">Use  Seasonal Greetings Report</h4>
           <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           
            <li class="breadcrumb-item active" aria-current="page">Use  Seasonal Greetings Report</li>
         </ol>


           <a class="btn btn-sm btn-secondary" href="notUseSeasonalGreetingReport?promotion_id=<?php echo $_REQUEST['promotion_id'];?>">Seasonal Greeting Not Used</a>
        </div>
         
       <div class="col-sm-6">
         <?php 
        
   
          $qry=$d->select("promotion_master"," status=0","ORDER BY event_name ASC");
          //onchange="this.form.submit();"
          ?>

         <select name="promotion_id"  class="form-control single-select">
           <option     value="0">--Select--</option>
           <?php   
           while ($blockRow=mysqli_fetch_array($qry)) {
         ?>
            <option <?php if ( $_REQUEST['promotion_id'] ==$blockRow['promotion_id'] ) { echo 'selected';} ?> value="<?php echo $blockRow['promotion_id'];?>"><?php echo $blockRow['event_name'];?></option>
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


                if(isset($_GET['promotion_id']) && $_GET['promotion_id'] != "0"){

                  $promotion_id = $_GET['promotion_id'];
                  $where =" and seasonal_greeting_share_master.promotion_id='$promotion_id'";
                }

                $q3=$d->select("  user_employment_details, users_master, seasonal_greeting_share_master   " ," seasonal_greeting_share_master.user_id= users_master.user_id and seasonal_greeting_share_master.is_new = 0  and  user_employment_details.user_id = users_master.user_id   and users_master.user_mobile!='0'  AND users_master.active_status=0   $where
                  "," group by users_master.user_id ORDER BY users_master.user_full_name asc ");
 
 
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