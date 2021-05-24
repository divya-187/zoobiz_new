<?php 
if(!isset($_SESSION['partner_login_id']))
{
  $_SESSION['msg1']= "Login First.";
  header("location:index.php?LoginFirst");
}
$pageName=basename($_SERVER['PHP_SELF']);
 ?>