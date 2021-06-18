<?php 
 //mapView
$xmlContent ="";
 $xmlContent .= '<markers>'; 

$where="";
 if(isset($_GET['map_view_filter_city_id'])){
  $city_id =$_GET['map_view_filter_city_id'] ; 
  $where .=" and business_adress_master.city_id = '$city_id' ";
 }
  $queyNew=$d->select("users_master,business_adress_master,user_employment_details,area_master","area_master.area_id=business_adress_master.area_id and   
business_adress_master.adress_type = 0 and 
    user_employment_details.user_id =users_master.user_id and    business_adress_master.user_id =users_master.user_id and /*business_adress_master.add_latitude!='' and  business_adress_master.add_longitude!='' AND*/ users_master.active_status=0 AND users_master.office_member=0    $where    "); 

 while($row = mysqli_fetch_array($queyNew)) {
/*$company_id = $row['company_id'];
 	$company_master=$d->select("company_master","company_id = '$company_id'    ");

 	if(mysqli_num_rows($company_master)){
 		$company_master_data = mysqli_fetch_array($company_master);
	 	$company = $company_master_data ['company_name'];
	 } else {
	 	$company ="NA";
	 }*/
 	
 extract($row);
 
if($user_profile_pic=="" || !file_exists('../img/users/members_profile/'.$user_profile_pic )){
  $user_profile_pic = "img/user.png";
   
}  else {
 $user_profile_pic = '../img/users/members_profile/'.$user_profile_pic;
}                    
 $username= $salutation.' '.$user_full_name;
$xmlContent .='<marker id="'.$user_id.'" 
  company ="'.$company_name.'"  
 user_email ="'.$user_email.'" 
user_mobile ="'.$user_mobile.'" 
username ="'.$username.'" 
gender ="'.$gender.'" 
adress ="'.$adress.'" 
adress2 ="'.$adress2.'" 
 
lat="'.$latitude.'" 
lng="'.$longitude.'" 
type="restaurant" 

 
user_profile_pic="'.$user_profile_pic.'"   />';
}
$xmlContent .= '</markers>';      


 
 //echo $xmlContent;exit;
$fp = fopen('userLocationXML.xml', 'w');
fwrite($fp, $xmlContent);
fclose($fp);

?>