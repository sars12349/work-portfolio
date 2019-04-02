<?php
	require_once("dbtools.inc.php");
	$id=$_POST["id"];
	$name=$_POST["name"];
	$email=$_POST["email"];
	$image=$_POST["image"];
	$cover=$_POST["cover"];
	$url=$_POST["url"];


	$link=create_connection();

	$uni="SELECT * FROM googlelogin WHERE id=".$id;

	if(mysqli_num_rows($result) == 0){
		$sql='INSERT INTO googlelogin (id, name, email, image, cover, url)VALUES ("$id", "$name", "$email", "$image", "$cover", "$url")';

		if(excute_sql($link, "id7769590_jasondb", $sql))
			echo "新增會員成功";
		else
			echo "失敗";
	}else{
		echo "此google帳號已存在!";
	}
?>