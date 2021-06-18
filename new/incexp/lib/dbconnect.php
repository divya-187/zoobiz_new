<?php
class dbconnect
{
    function connect()
    {
        $connection=mysqli_connect("localhost","bhavesh","Bhavesh@997.","zooBizincomeExpense");
		return $connection;
    }
}
?>