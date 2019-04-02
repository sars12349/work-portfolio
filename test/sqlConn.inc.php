<?php
$servername="localhost";
$username="id7769590_jason";
$password="123456";

$con=new mysqli($servername,$username,$password);

//check connection
if(mysqli_connect_error())
{
	echo "Connection Failed" .$con ->connection_error;
}
?>