<?php
	session_start();
	$ID=$_GET["id"];

	require_once("dbtools.inc.php");
	$link=create_connection();

	$sql= "SELECT * FROM member_test WHERE id= $ID";

	$result = execute_sql($link,"id7769590_jasondb",$sql);
	$row=mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="device-width,initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css">
	<script src="js/jquery-2.1.0.min.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
	<div data-role="page" id="home">
		<div data-role="header" data-theme="b">
			<h3>管理者修改使用者資料</h3>
		</div>

		<div data="main" class="ui-content">
			<div data-role="fieldcontain">
				<label for="username">帳號:</label>
				<input type="text" name="username" id="username" value="<?php echo $row["username"]?>">
			</div>	
			<div id="error_username"></div>

			<div data-role="fieldcontain">
				<label for="password">密碼:</label>
				<input type="text" name="password" id="password" value="<?php echo $row["password"]?>">
			</div>	
			<div id="error_password"></div>

			<div data-role="fieldcontain">
				<label for="password_check">密碼確認:</label>
				<input type="text" name="password_check" id="password_check" value="<?php echo $row["password"]?>">
			</div>		
			<div id="error_password_check"></div>

			<div data-role="fieldcontain">
				<label for="email">email:</label>
				<input type="text" name="email" id="email" value="<?php echo $row["email"]?>">
			</div>	
				
		<?php if($_SESSION['usertype']=="a"): ?>
			<div data-role="fieldcontain">
				<label for="usertype">使用者權限:</label>
				<select name="usertype" id="usertype" data-role="slider">
					<option value="a">admin</option>
					<option value="n">normal</option>
				</select>	
			</div>
		<?php endif; ?>


			<div class="ui-grid-a">
				<div class="ui-block-a">
					<a href="" data-role="button" data-theme="b" id="btn_cancel">Cancel</a>
				</div>
				<div class="ui-block-b">
					<a href="" data-role="button" data-theme="b" data-ajax="false" id="btn_update">修改</a>
				</div>
			</div>

		</div>

		<script>
			var flag_username=false;
			var flag_password=false;
			var flag_password_check=false;
			

			$(function(){

				var username = $("#username").val();
				var password = $("#password").val();
				var password_check = $("#password_check").val();

				$("#username").bind("input propertychange",function(){
					if($("#username").val().length<6){
						$("#error_username").html("帳號不得少於6個字數");
						$("#error_username").css("background-color", "red");
						$("#error_username").css("color", "white");
						flag_username=false;
					}else{
						$("#error_username").html("");
						flag_username=true;
					}
				});

				$("#password").bind("input propertychange",function(){
					if($("#password").val().length<6){
						$("#error_password").html("帳號不得少於6個字數");
						$("#error_password").css("background-color", "red");
						$("#error_password").css("color", "white");
						flag_password=false;
					}else{
						$("#error_password").html("");
						flag_password=true;
					}
				});

				$("#password_check").bind("input propertychange",function(){
					if($("#password_check").val()!=$("#password").val()){
						$("#error_password_check").html("密碼不相同");
						$("#error_password_check").css("background-color", "red");
						$("#error_password_check").css("color", "white");
						flag_password_check=false;
					}else{
						$("#error_password_check").html("");
						flag_password_check=true;
					}
				});

				$("#btn_update").bind("click",function(){
					if(username == $("#username").val()){flag_username = true}
					if(password == $("#password").val()){flag_password = true}
					if(password_check == $("#password_check").val()){flag_password_check = true}	

					if(flag_username&&flag_password&&flag_password_check){
							$.ajax({
								type: "POST",
								url: "memberAPI/tcnr_member_api.php?query_type=update",
								data:{username:$("#username").val(),password:$("#password").val(),email:$("#email").val(),usertype:$("#usertype").val(),id:<?php echo $ID ?>},
								success: show,
								error:function(){
									alert("連接資料庫失敗");
								}
							});
					}else{
						alert("if不成立");
					}
				});	

				$("#btn_cancel").bind("click",function(){
					location.href ="tcnr_member01.php";
				});							
			});
	
			function show(data){
				if(data==1)
				{
					location.href ="tcnr_member01.php";
				}else{
					alert("連接失敗");
				}
			}
		</script>
	</div>	
</body>
</html>