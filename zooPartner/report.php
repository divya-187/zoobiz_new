<?php
$zoobiz_admin_id = $_SESSION['zoobiz_admin_id'];
extract($_REQUEST);
error_reporting(0); ?>
<div class="content-wrapper">
	<div class="container-fluid">
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">Report</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="welcome"><i class="fa fa-home"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">Manage Report</li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="btn-group float-sm-right">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<form action="" method="get" accept-charset="utf-8">
							
						<div class="row">
							<label class="col-sm-2 col-form-label">Filter Date</label>
							<div class="col-sm-6">
								<div class="dateragne-picker">
									<div class="input-daterange input-group">
										<input value="<?php echo $startDate; ?>"  type="text" class="form-control" name="startDate" id="startDate"/>
										<div class="input-group-prepend">
											<span class="input-group-text">to</span>
										</div>
										<input name="endDate" value="<?php echo $endDate; ?>"  type="text" class="form-control" id="endDate"/>
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</div>
						</form>
					</div>
					<?php
					if (isset($startDate) && isset($endDate)) {
						$startDate = date("Y-m-d", strtotime($startDate));
						$endDate = date("Y-m-d", strtotime($endDate));
					?>
					<div class="card-body" id="setReport">
						<div class="table-responsive">
							<table class="table table-bordered" id="example1">
								<thead>
									<th colspan="2">#</th>
									<th>Unit Added</th>
									<th>Logged In User</th>
									<th>Not Logged In User</th>
								</thead>
								<tbody>
									<?php
									$j=1;?>
									<tr>
										<td colspan="2"><strong>Total</strong></td>
										<td><?php echo $d->count_data_direct("users_id","users_master","installed_by = '$zoobiz_admin_id' AND CAST(register_date as DATE) >= '$startDate' AND CAST(register_date as DATE) <= '$endDate'"); ?></td>
										<td><?php echo $d->count_data_direct("users_id","users_master","installed_by = '$zoobiz_admin_id' AND CAST(register_date as DATE) >= '$startDate' AND CAST(register_date as DATE) <= '$endDate' AND user_token != ''"); ?></td>
										<td><?php echo $d->count_data_direct("users_id","users_master","installed_by = '$zoobiz_admin_id' AND CAST(register_date as DATE) >= '$startDate' AND CAST(register_date as DATE) <= '$endDate' AND user_token = ''"); ?></td>
									</tr>
								</tbody>
							</table>

							<Br><br>
								<div class="table-responsive">
									<table class="table table-bordered" id="example1">
										<thead>
											<th colspan="2">#</th>
											<th>Unit </th>
											<th>User </th>
											<th>Registraion Date</th>
											<th>Last Login</th>
											<th>Remark</th>
										</thead>
										<tbody>
											<?php
											$q3=$d->select("users_master,unit_master,block_master,floors_master","block_master.block_id=floors_master.block_id AND users_master.floor_id=floors_master.floor_id AND users_master.unit_id=unit_master.unit_id AND block_master.block_id=unit_master.block_id AND unit_master.unit_status!=0 AND unit_master.unit_status!=4 AND users_master.installed_by = '$zoobiz_admin_id'  AND CAST(users_master.register_date as DATE) >= '$startDate' AND CAST(users_master.register_date as DATE) <= '$endDate'","ORDER BY unit_master.unit_id ASC");
											$i=1;
											while ($data=mysqli_fetch_array($q3)) {
											?>

											<tr>
												<td colspan="2"><strong><?php echo $i++;?></strong></td>
												<td><?php echo $data['block_name']; ?>-<?php echo $data['unit_name']; ?></td>
												 <td><?php 
								                if($data['user_type']=="0" && $data['member_status']=="0" ){
								                    echo "Owner";
								                } else  if($data['user_type']=="0" && $data['member_status']=="1" ){
								                    echo "Owner Family";
								                } else  if($data['user_type']=="1" && $data['member_status']=="0"  ){
								                    echo "Tenant";
								                }else  if($data['user_type']=="1" && $data['member_status']=="1"   ){
								                    echo "Tenant Family";
								                } else   {
								                  echo "Owner";
								                } 
								                 if ($data['member_status']==1) {
								                   echo '-'.$data['member_relation_name'];
								                 }
								                 ?></td>
												<td><?php echo $data['register_date']; ?></td>
												<td><?php 
												if ($data['last_login']!="0000-00-00 00:00:00") {
													echo  $data['last_login']; 
												} else {
													echo "Not Login Yet";
												}
												?></td>
												<td><?php echo $data['other_remark']; ?>-<?php echo $data['remark_type']; ?></td>
											</tr>
										<?php } ?>
										</tbody>
									</table>

									<Br><br>
								<div class="table-responsive">
									<table class="table table-bordered" id="example1">
										<thead>
											<th colspan="2">#</th>
											<th>Unit </th>
											<th>Remark</th>
										</thead>
										<tbody>
											<?php
											$q3=$d->select("unit_master,block_master","block_master.block_id=unit_master.block_id AND  unit_master.remark_by = '$zoobiz_admin_id' ","ORDER BY unit_master.unit_id ASC");
											$i=1;
											while ($data=mysqli_fetch_array($q3)) {
											?>

											<tr>
												<td colspan="2"><strong><?php echo $i++;?></strong></td>
												<td><?php echo $data['block_name']; ?>-<?php echo $data['unit_name']; ?></td>
												
												<td><?php echo $data['other_remark']; ?>-<?php echo $data['remark_type']; ?></td>
											</tr>
										<?php } ?>
										</tbody>
									</table>
						</div>
					</div>
				</div>
			<?php }  else {
				 echo "<div class='text-center'><h6>Please select date</h6></div>";
			} ?>
			</div>
		</div>
	</div>
</div>
<!-- <script src="../zooAdmin/assets/js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
$(document).on('change', '#startDate', function() {
getReport();
});
$(document).on('change', '#endDate', function() {
getReport();
});
});
</script>
<script type="text/javascript">
function getReport() {
var startDate = document.getElementById("startDate").value;
var endDate = document.getElementById("endDate").value;
$.ajax({
url:'getReport.php',
type:'POST',
beforeSend: function(){
swal({
title: "Loading...",
text: "Please wait",
button:false,
timer: 1000,
});
},
data:{startDate:startDate,endDate:endDate,installationReport:"installationReport"}
})
.done(function(response){
$('#setReport').html(response);
swal.close()
});
}
</script> -->