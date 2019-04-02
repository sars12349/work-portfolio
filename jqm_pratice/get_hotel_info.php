<?php
	$servername="localhost";
	$username="id7769590_jason";
	$password="123456";
	$dbname="id7769590_jasondb";

	$link=mysqli_connect($servername,$username,$password,$dbname)
		or die("無法建立資料連接: ".mysqli_connect_error());

	mysqli_query($link, "SET NAMES UTF8");	

	$sql="SELECT * FROM hoteldata";

	$result=mysqli_query($link,$sql);
	$myArray=array();
	$rows=mysqli_fetch_assoc($result);

	if(mysqli_num_rows($result)>0){
		do{
			$myArray[]=$rows;
		}while($rows=mysqli_fetch_assoc($result));
			echo json_encode($myArray);
		}else{
			echo "0 results";
		}
		mysqli_close($link);

	
?>		