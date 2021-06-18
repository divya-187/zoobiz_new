<?php
include_once 'lib.php';


if(isset($_POST) && !empty($_POST)){
	extract(array_map("test_input" , $_POST));
	if (isset($addTraz) && $addTraz == 'addTraz' && filter_var($zoobiz_admin_id, FILTER_VALIDATE_INT) == true) {

			$file11=$_FILES["transaction_attachment"]["tmp_name"];
            if(file_exists($file11)) {
                $image_Arr = $_FILES['transaction_attachment'];   
                $temp = explode(".", $_FILES["transaction_attachment"]["name"]);
                $transaction_attachment = $zoobiz_admin_id.'_id_'.round(microtime(true)) . '.' . end($temp);
                move_uploaded_file($_FILES["transaction_attachment"]["tmp_name"], "../img/".$transaction_attachment);
            } else {
             $transaction_attachment='';
            }


		
			$m->set_data('zoobiz_admin_id', $zoobiz_admin_id);
			$m->set_data('description', $description);
			$m->set_data('transaction_date', $transaction_date);
			$m->set_data('transaction_amount', $transaction_amount);
			$m->set_data('transaction_type', $transaction_type);
			$m->set_data('transaction_attachment', $transaction_attachment);
			$m->set_data('expense_category_id', $expense_category_id);

			$a = array(
				'zoobiz_admin_id' => $m->get_data('zoobiz_admin_id'),
				'description' => $m->get_data('description'),
				'transaction_date' => $m->get_data('transaction_date'),
				'transaction_amount' => $m->get_data('transaction_amount'),
				'transaction_type' => $m->get_data('transaction_type'),
				'transaction_attachment' => $m->get_data('transaction_attachment'),
				'expense_category_id' => $m->get_data('expense_category_id'),
			);
			$q=$d->insert("transaction_master", $a);
			
			if($q>0) {
				$response["message"] = "Added Successfully";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		
		
	} else if (isset($updateTraz) && $updateTraz == 'updateTraz' && filter_var($transaction_id, FILTER_VALIDATE_INT) == true) {

			$file11=$_FILES["transaction_attachment"]["tmp_name"];
            if(file_exists($file11)) {
                $image_Arr = $_FILES['transaction_attachment'];   
                $temp = explode(".", $_FILES["transaction_attachment"]["name"]);
                $transaction_attachment = $zoobiz_admin_id.'_id_'.round(microtime(true)) . '.' . end($temp);
                move_uploaded_file($_FILES["transaction_attachment"]["tmp_name"], "../img/".$transaction_attachment);
            } else {
             $transaction_attachment=$transaction_attachment_name;
            }


		
			$m->set_data('zoobiz_admin_id', $zoobiz_admin_id);
			$m->set_data('description', $description);
			$m->set_data('transaction_date',$transaction_date);
			$m->set_data('transaction_amount', $transaction_amount);
			$m->set_data('transaction_type', $transaction_type);
			$m->set_data('transaction_attachment', $transaction_attachment);
			$m->set_data('expense_category_id', $expense_category_id);

			$a = array(
				'zoobiz_admin_id' => $m->get_data('zoobiz_admin_id'),
				'description' => $m->get_data('description'),
				'transaction_date' => $m->get_data('transaction_date'),
				'transaction_amount' => $m->get_data('transaction_amount'),
				'transaction_type' => $m->get_data('transaction_type'),
				'transaction_attachment' => $m->get_data('transaction_attachment'),
				'expense_category_id' => $m->get_data('expense_category_id'),
			);
			$q=$d->update("transaction_master", $a,"transaction_id='$transaction_id' AND zoobiz_admin_id='$zoobiz_admin_id'");
			
			if($q>0) {
				$response["message"] = "Updated Successfully";
				$response["status"] = "200";
				echo json_encode($response);
			} else {
				$response["message"] = "Something Wrong";
				$response["status"] = "201";
				echo json_encode($response);
			}
		
		
	}else if (isset($getTraz) && $getTraz == 'getTraz' && filter_var($zoobiz_admin_id, FILTER_VALIDATE_INT) == true) {

                if ($transaction_type!='') {
                	
                 $app_data=$d->select("transaction_master","zoobiz_admin_id='$zoobiz_admin_id'  AND zoobiz_admin_id!=0 AND transaction_type='$transaction_type'","ORDER BY transaction_id DESC");
                } else {
                 $app_data=$d->select("transaction_master","zoobiz_admin_id='$zoobiz_admin_id'  AND zoobiz_admin_id!=0","ORDER BY transaction_id DESC");

                }


               
                if(mysqli_num_rows($app_data)>0){

                    $response["transaction"] = array();


                    while($data_app=mysqli_fetch_array($app_data)) {

                    	$transaction=array();
                    	$transaction["transaction_id"]=$data_app["transaction_id"];
						$transaction["zoobiz_admin_id"]=$data_app["zoobiz_admin_id"];
						$transaction["transaction_type"]=$data_app["transaction_type"];
                        $transaction["description"]=$data_app["description"];
                        $transaction["transaction_date"]=date("d M Y", strtotime($data_app["transaction_date"]));
                        $transaction["transaction_amount"]=$data_app["transaction_amount"];
                        if ($data_app["transaction_attachment"]!="") {
                    	$transaction["transaction_attachment"]=$base_url."img/".$data_app["transaction_attachment"];
                        } else {
                    	$transaction["transaction_attachment"]="";

                        }
                    	$transaction["transaction_attachment_name"]=$data_app["transaction_attachment"];
                        $transaction["expense_category_id"]=$data_app["expense_category_id"].'';
                        if ($data_app['expense_category_id']!=0) {
                        	$ca=$d->select("expense_category_master","expense_category_id='$data_app[expense_category_id]' ");
                        	$catData=mysqli_fetch_array($ca);
                        	$expense_category_name= $catData['expense_category_name'];
                        }

                        $transaction["expense_category_name"]=$expense_category_name.'';
                    	
                    	array_push($response["transaction"], $transaction); 
                    }
                    
                     $response["message"]="Get Transactions Successfully.";
                     $response["status"]="200";
                     echo json_encode($response);
                }else{
                	 $response["message"]="No Data Found !";
                     $response["status"]="201";
                     echo json_encode($response); 
                }
		
			
		
		
	}else if (isset($getCategory) && $getCategory == 'getCategory') {

                
                 $app_data=$d->select("expense_category_master","active_status='0' ");


               
                if(mysqli_num_rows($app_data)>0){

                    $response["category"] = array();


                    while($data_app=mysqli_fetch_array($app_data)) {

                    	$category=array();
                    	$category["expense_category_id"]=$data_app["expense_category_id"];
						$category["expense_category_name"]=$data_app["expense_category_name"];
                        
                    	
                    	array_push($response["category"], $category); 
                    }
                    
                     $response["message"]="Get Category Successfully.";
                     $response["status"]="200";
                     echo json_encode($response);
                }else{
                	 $response["message"]="No Category Found !";
                     $response["status"]="201";
                     echo json_encode($response); 
                }
		
			
		
		
	}else if (isset($getDashboardData) && $getDashboardData == 'getDashboardData' && filter_var($zoobiz_admin_id, FILTER_VALIDATE_INT) == true) {

                
                 $q=$d->select("zoobiz_admin_master","zoobiz_admin_id='$zoobiz_admin_id'  AND zoobiz_admin_id!=0");


               
                if(mysqli_num_rows($q)>0){
                	$user_data = mysqli_fetch_array($q);

                     $response["zoobiz_admin_id"] = $user_data['zoobiz_admin_id'];
					 $response["company_id"] = $user_data['company_id'];
					 $response["role_id"] = $user_data['role_id'];
					 $response["admin_name"] = $user_data['admin_name'];
					 $response["admin_email"] = $user_data['admin_email'];
					 $response["mobile"] = $user_data['admin_mobile'];

					$count5=$d->sum_data("transaction_amount","transaction_master","transaction_type=1");
                 	$row=mysqli_fetch_array($count5);
                    $asif=$row['SUM(transaction_amount)'];
                    $totalIncome=number_format($asif,2,'.','');

                    $count1=$d->sum_data("transaction_amount","transaction_master","transaction_type=0");
                 	$row1=mysqli_fetch_array($count1);
                    $asif1=$row1['SUM(transaction_amount)'];
                    $totalExpense=number_format($asif1,2,'.','');

                    $avBlance= $totalIncome-$totalExpense;

                    $count2=$d->sum_data("transaction_amount","transaction_master","zoobiz_admin_id='$zoobiz_admin_id' AND transaction_type=1");
                 	$row2=mysqli_fetch_array($count2);
                    $asif2=$row2['SUM(transaction_amount)'];
                    $myIncome=number_format($asif2,2,'.','');

                    $count3=$d->sum_data("transaction_amount","transaction_master","zoobiz_admin_id='$zoobiz_admin_id'  AND transaction_type=0");
                 	$row3=mysqli_fetch_array($count3);
                    $asif3=$row3['SUM(transaction_amount)'];
                    $myExpense=number_format($asif3,2,'.','');

                    
                     $response["totalIncome"]=$totalIncome;
                     $response["totalExpense"]=$totalExpense;
                     $response["available_balance"]=$avBlance.'';
                     $response["myIncome"]=$myIncome;
                     $response["myExpense"]=$myExpense;
                     $response["message"]="Get Data Successfully.";
                     $response["status"]="200";
                     echo json_encode($response);
                }else{
                	 $response["message"]="No Category Found !";
                     $response["status"]="201";
                     echo json_encode($response); 
                }
		
			
		
		
	} else {
		$response["message"] = "Wrong Tag";
		$response["status"] = "201";
		echo json_encode($response);
	}
}else{
	$response["message"] = "Invalid Request";
	$response["status"] = "201";
	echo json_encode($response);
}

?>