<?php $starttime = microtime(true); ?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">Bind Interests</h4>
          <ol class="breadcrumb"> 
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           <li class="breadcrumb-item"><a href="viewMember?id=<?php echo $_REQUEST['user_id']; ?>">View Member</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bind Interests</li>
         </ol>
         
       </div>
       
   </div>
    <!-- End Breadcrumb-->
    
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <form id="editInterestFrm" action="controller/commonController.php" method="post" >
               <input type="hidden" name="user_id" value="<?php echo $_REQUEST['user_id']; ?>">
              
              <h4 class="form-header text-uppercase">
              <i class="fa fa-lock"></i>
             Bind Interests
              </h4>
              
             
              
              <?php
              extract($_REQUEST);
              $selected_int = array('0');
              $interest_qry = $d->selectRow("*","interest_relation_master","member_id ='$user_id' ", "");
              while ($interest_data=mysqli_fetch_array($interest_qry)) { 
                $selected_int [] = $interest_data['interest_id'];
              }



               $q=$d->select("interest_master"," status=0 and int_status !='User Added' ","ORDER BY interest_name ASC");
             
              ?> 
              
              <?php
            
              $incounter=1;

              $my_counter =1;
              while ($data=mysqli_fetch_array($q)) {
              // echo "$incounter%3 =>".($incounter%3) ."<br>";
              if( ($incounter%4) ==1 || $incounter==1){ ?>
            <?php if($incounter > 1) { echo '</div>';} ?>
            <div class="form-group row">
              <?php  } ?>
              <div class="col-sm-4" >
                <?php
                $ischecked="";
               if(in_array($data['interest_id'], $selected_int)){
                $ischecked="checked";
                }  ?>
               <input type="checkbox" <?php echo $ischecked;?> class="pagePrivilege" value="<?php echo $data['interest_id']; ?>" name="interest_id[]"  id="<?php echo $data['interest_id']; ?>"/>  
                <label for="<?php echo $data['business_sub_category_id']; ?>"><?php echo $my_counter; $my_counter++;?>. <?php echo $data['interest_name']; ?> </label>
              </div>
              <?php
              $incounter++;
              if($incounter%4==0 && $incounter > 1){
              if($incounter==4) $incounter = 1;?>
            </div>
            
            <?php  }
            
            } ?>
            
            
            
          </div>
          <div id="chkError" class=""></div>
          <div class="form-footer text-center">
             
            <button type="submit" name="interestedBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> UPDATE</button>
           
            <button  type="reset" class="btn btn-danger"><i class="fa fa-times"></i> Reset</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div><!--End Row-->
</div>
<!-- End container-fluid-->

</div><!--End content-wrapper-->
<!--select icon modal -->
<script src="assets/js/jquery.min.js"></script>
<script type="text/javascript">
$(function() {
$('.chk_boxes').click(function() {
$('.pagePrivilege').prop('checked', this.checked);
});
});
</script>
<?php $end = microtime(true);

echo "Time Taken =".($end -$starttime); ?>