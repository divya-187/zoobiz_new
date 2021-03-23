<?php
class dbconnect
{
    function connect()
    {
       // $connection=mysqli_connect("localhost","zoobiz_silver","3y!~Sb(s1i-C","zoobiz_2020");
    	 $connection=mysqli_connect("localhost","root","","zoobiz_2020");
    	 // /yM3sX1bP@187
    	 // /Silver_Zoobiz_New
		return $connection;
    }
}
?>