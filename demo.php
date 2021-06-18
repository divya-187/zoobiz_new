<?php echo date("Y-m-d", strtotime('16/01/1969'));



$old_date_timestamp = strtotime("16/01/1969");
echo $date1 = str_replace("/", "-","16/01/1969");

$old_date_timestamp = strtotime($date1);
echo "<br>".$new_date = date('Y-m-d H:i:s', $old_date_timestamp);

 ?>