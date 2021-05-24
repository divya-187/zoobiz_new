<?php include'../common/objectController.php';

//echo "<pre>";print_r($_REQUEST);exit;
extract($_POST);
if(isset($_POST['AddLanguageKeyValue'])){


for ($a=0; $a <count($_POST['language_key_id']) ; $a++) {
		$nameuse = $KeyValue =  $_POST['language_key_id'][$a];
		$KeyValue =  explode("_", $KeyValue);


		$value_name = trim($_POST['ValueName'.$nameuse][0]);
		if(trim($value_name) !=""){
			$m->set_data('language_id',$KeyValue[0]);
			$m->set_data('language_key_id',$KeyValue[1]);
			$m->set_data('value_name',$value_name);


			$a1 = array(
				'language_id'=>$m->get_data('language_id'),
				'language_key_id'=>$m->get_data('language_key_id'),
				'value_name'=>$m->get_data('value_name') 
			);

			$q=$d->insert("language_key_value_master",$a1);
		}
		

	}


	/*for ($i1=0; $i1 <count($_POST['value_name']) ; $i1++) { 
	
		# code...
		$language_key_id = $_POST['language_key_id'][$i1];
		$key_value_id = $_POST['key_value_id'][$i1];
		$value_name = $_POST['value_name'][$i1];

		
		
		$m->set_data('language_id',$language_id);
		$m->set_data('language_key_id',$language_key_id);
		$m->set_data('value_name',$value_name);

		$a = array(
			'language_id'=>$m->get_data('language_id'),
			'language_key_id'=>$m->get_data('language_key_id'),
			'value_name'=>$m->get_data('value_name')
		);
		if (isset($key_value_id) && $key_value_id!='') {
				$q=$d->update("language_key_value_master",$a,"language_id='$language_id' AND key_value_id='$key_value_id'");
		} else {
			$valueName=mysqli_real_escape_string($con, $value_name);

			$qc=$d->select("language_key_value_master","language_id='$language_id' AND value_name='$valueName' AND key_value_id='$key_value_id'");
			if (mysqli_num_rows($qc)>0) {
				$q=$d->update("language_key_value_master",$a,"language_id='$language_id' AND value_name='$value_name'");
			} else {
				$q=$d->insert("language_key_value_master",$a);
			}

		}


	}*/
	if ($q === TRUE) {
        $_SESSION['msg']="Language Key Values Added Successfully";
		$d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
		header ("location:../language_key_master_value_list");
		
	}else {
		$_SESSION['msg1']="Please Provide value for Keys.";
		header ("Location:../language_key_master_value_list");
	}
}else if(isset($_POST['AddLanguageKeyValueAll'])){

	for ($i1=0; $i1 <count($_POST['value_name']) ; $i1++) { 
	
		# code...
		$language_key_id = $_POST['language_key_id'][$i1];
		$key_value_id = $_POST['key_value_id'][$i1];
		$value_name = $_POST['value_name'][$i1];
		$language_id = $_POST['language_id'][$i1];

		
		
		$m->set_data('language_id',$language_id);
		$m->set_data('language_key_id',$language_key_id);
		$m->set_data('value_name',$value_name);

		$a = array(
			'language_id'=>$m->get_data('language_id'),
			'language_key_id'=>$m->get_data('language_key_id'),
			'value_name'=>$m->get_data('value_name')
		);
		if (isset($key_value_id) && $key_value_id!='') {
				$q=$d->update("language_key_value_master",$a,"language_id='$language_id' AND key_value_id='$key_value_id'");
		} else {
			$valueName=mysqli_real_escape_string($con, $value_name);

			$qc=$d->select("language_key_value_master","language_id='$language_id' AND value_name='$valueName' AND key_value_id='$key_value_id'");
			if (mysqli_num_rows($qc)>0) {
				$q=$d->update("language_key_value_master",$a,"language_id='$language_id' AND value_name='$value_name'");
			} else {
				$q=$d->insert("language_key_value_master",$a);
			}

		}


	}
	if ($q === TRUE)
	{
           
		$_SESSION['msg']="Value Update Successfully";
		$d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
		header ("location:../manageLanguageValue?key_name=$key_name");
		
	}
}else if (isset($_POST['delete_key_value_id'])) {


	$q= $d->delete("language_key_value_master","key_value_id='$delete_key_value_id'");
	if ($q === TRUE) {

		$_SESSION['msg']="Language Key Value Deleted Successfully";
		$d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);

		header ("location:../manageLanguageValue");

	} else {
		$_SESSION['msg1']="Something Wrong";
		header ("location:../manageLanguageValue");
	}
}elseif (isset($_POST['UpdateLanguageKeyValue']))  {

	$m->set_data('value_name',$value_name);
	$a = array(
		'value_name'=>$m->get_data('value_name') 
	);
	$q=$d->update("language_key_value_master",$a,"key_value_id='$key_value_id'");

	if ($q === TRUE){

		$_SESSION['msg']="Language Key Value Updated Successfully";
		$d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);

		header ("location:../manageLanguageValue");

	} else {
		$_SESSION['msg1']="Something Wrong";
		header ("location:../manageLanguageValue");
	}
}else{
	$_SESSION['msg1']="Something Wrong";
	header ("location:../manageLanguageValue");
}
?>