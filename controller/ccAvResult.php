<?php
session_start();
error_reporting(0);

if($_SESSION['response_status']=="Success"){
	?>
<link rel="stylesheet" href="../css/bootstrap.min.css">  

 <script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<center>
  <div class="container-fluid">
 	<div class="col-xs-12">
 		<div class="alert alert-success">
		    <strong>Success!</strong> <?php  echo $_SESSION['msgTemp']; ?>
		</div>
 	</div>
 	<div class="col-xs-12">
 		<a href="successAndroid.php" class="btn btn-primary">Finish</a>
 	</div>
 	

 </div>
</center>
 <?php } else {  ?>
	 <link rel="stylesheet" href="../css/bootstrap.min.css">  

 <script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<center>
  <div class="container-fluid">
 	<div class="col-xs-12">
 		<div class="alert alert-danger">
		    <strong><?php echo $_SESSION['response_status'];?>!</strong> <?php  echo $_SESSION['msgTemp']; ?>
		</div>
 	</div>
 	<div class="col-xs-12"> 
 		<a href="failureAndroid.php" class="btn btn-primary">Finish</a>
 	</div>
 	

 </div>
</center>
<?php 
}
?>