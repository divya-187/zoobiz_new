<?php 
session_start();
//session_destroy();


  unset($_SESSION['zoobiz_admin_id']); 
             


header("location:index.php");
 ?>