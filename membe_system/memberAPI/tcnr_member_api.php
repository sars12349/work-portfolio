<?php 
	session_start();
	if (isset($_SESSION['username'])) {
		$Username = $_SESSION['username'];
	}

	$query_type = $_GET['query_type'];

	require_once "../dbtools.inc.php";

	$link = create_connection();
	//$sql = "SELECT * FROM member ORDER BY id ASC";

	switch ($query_type) {
		case 'member':
			//抓一筆資料
			$sql = "SELECT * FROM member_test WHERE username = '$Username'";
			$result = execute_sql($link,"id7769590_jasondb",$sql);

			//確認有無資料
			if(mysqli_num_rows($result) > 0){
				$output = mysqli_fetch_assoc($result);
				switch ($output['usertype']) {
					case 'n':
						$_SESSION['usertype'] = $output['usertype'];
						$data[] = $output;
						echo json_encode($data);
						break;
					case 'a':
						$_SESSION['usertype'] = $output['usertype'];
						$sql = "SELECT * FROM member_test";
						$result = execute_sql($link,"id7769590_jasondb",$sql);
						while($output = mysqli_fetch_assoc($result)){
							$data[] = $output;
						}
						echo json_encode($data);
						break;
					
				}
			}else{
				echo "沒有資料";
			}
			break;
		
		case "login":
			$Username = $_POST["username"];
			$Password = $_POST["password"];

			//測試帳號密碼是否正確
			//$sql = "SELECT * FROM members_test WHERE username = 'owner01' AND password = '1234567890' ";
			$sql = "SELECT * FROM member_test WHERE username = '$Username' AND password = '$Password' ";

			$result=execute_sql($link, "id7769590_jasondb", $sql);
			if(mysqli_num_rows($result) ==1){
				$row = mysqli_fetch_assoc($result);
				$_SESSION['usertype'] =$row['usertype']; 
				$_SESSION["username"] =$Username;
				echo"1";//成功
			}else{
				echo "0";
			}
			break;

		case 'delete':
			$ID = $_GET['id'];

			require_once "../dbtools.inc.php";
			$link = create_connection();
			
			switch ($query_type) {
				case "delete":
					$sql = "DELETE FROM member_test WHERE id = '$ID'";
					break;
			}
			

			execute_sql($link,"id7769590_jasondb",$sql);
			header("Location: ../tcnr_member01.php");
			break;	

		case 'update':
			$id=$_POST["id"];
			$username=$_POST["username"];
			$password=$_POST["password"];
			if(isset($_POST["usertype"])){
				$usertype=$_POST["usertype"];
			}
			else{
				$usertype='n';
			}
			$email=$_POST["email"];

			require_once("../dbtools.inc.php");
			$link=create_connection();
			$sql = "UPDATE member_test SET username='$username', password='$password', usertype= '$usertype', email = '$email' WHERE id='$id'";

			if(execute_sql($link, "id7769590_jasondb", $sql)){
				//$_SESSION['usertype'] = $usertype;
				echo "1";//成功
			}else{
				echo "0";
			}
			break;

		case "register":
			$Username = $_POST["username"];
			$Password = $_POST["password"];
			$Email = $_POST["email"];

			require_once("../dbtools.inc.php");
			$link = create_connection();

			$sql = "INSERT INTO member_test (id, username, password, usertype, email) 
				Values('', '$Username', '$Password', 'n', '$Email')";
			if(execute_sql($link, "id7769590_jasondb", $sql)){
				echo "reg sucess";
			}else{
				echo "reg fail";
			}
			break;	

		case "logout":
			session_destroy();
			header("Location: ../tcnr_login.php");
			break;	
	}

	

	$link->close();
 ?>