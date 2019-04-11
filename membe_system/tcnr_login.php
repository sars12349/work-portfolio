<?php header("Access-Control-Allow-Origin:*"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet"  href="css/jquery.mobile-1.4.5.min.css">
	<script src="js/jquery-2.1.0.min.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
	<script>


		$(function(){
			// $("#username").bind("input propertychange",function(){
			// 	if($("#username").val().length <5){
			// 		$("#msgname").text(" 帳號不得少於5個字");
			// 		$("#msgname").css("background-color", "red");
			// 	}else {	
			// 		$("#msgname").text("");
			// 		$("#msgname").css("background-color", "white");
			// 	}
			// });
			//---password---
			// $("#password").bind("input propertychange",function(){
			// 	if($("#password").val().length <10){
			// 		$("#msgpassword").text(" 密碼不得少於10個字");
			// 		$("#msgpassword").css("background-color", "red");
			// 	}else {	
			// 		$("#msgpassword").text("");
			// 		$("#msgpassword").css("background-color", "white");
			// 	}
			// });			

				$("#ok_btn").bind("click",function(){
				$.ajax({
					type:"POST",
					url:"memberAPI/tcnr_member_api.php?query_type=login",
					data:{username:$("#username").val(),password:$("#password").val()},
					success:login,
					error:function(){
						alert("登入API回傳失敗");
					}
				});//end ajax
			});//end click function()
		});	

		function login(data){
			//alert(data);//測試是否成功
			if(data==1){
				location.href = "tcnr_member01.php";
			}else{
				alert(data);
			}
		}	
	</script>
</head>
<body>
	<div data-role="page" id="home" >
		<div data-role="header" data-theme="b">
			<h1>會員登入</h1>
		</div>
		<div role="main" class="ui-content">
			<div data-role="fieldcontain">
				<label for="username">帳號</label>
				<input type="text" name="username" id="username">
			</div>
			<div id="msgname"></div>
			<div data-role="fieldcontain">
				<label for="password">密碼</label>
				<input type="password" name="password" id="password">
			</div>
			<div id="msgpassword"></div>
			<div class="forget">
				<a href="mailto:<?php echo $row_Recordset1['Email']; ?>">忘記密碼?</a>
			</div>
			<div class="ui-grid-a">
				<div class="ui-block-a">
					<a href="tcnr-register.php" data-role="button" data-ajax="false" data-theme="b" id="btn">註冊</a>		
				</div>
				<div class="ui-block-b">
					<a href="#" data-role="button" data-theme="b" id="ok_btn">登入</a>	
				</div>
			</div>
		</div>
		<div data-role="footer" data-position="fixed" data-theme="b">
		</div>	
	</div>	
</body>
</html>		