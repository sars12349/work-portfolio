<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css">
	<script src="js/jquery-2.1.0.min.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
	<script>
		var username_flag = false,  repassword_flag = false, password_flag = false ,email_flag=false; //用falg來記錄該欄位是否合乎規定
		var myfavorite = [];
		$(function(){
			$("#cancel").on("click",goBack);
			$("#username").bind("input propertychange", function(){
				if($("#username").val().length < 5){
					$("#error_username").html("帳號不得少於5個字數");
					$("#error_username").css("background-color", "red");
					$("#error_username").css("color", "white");
					username_flag = false;
				}else{
					$("#error_username").html("");
					username_flag = true;
				}
			});
			$("#password").bind("input propertychange", function(){
				if($("#password").val().length<10){
					$("#error_password").html("密碼不得少於10個字數");
					$("#error_password").css("background-color", "red");
					$("#error_password").css("color", "white");
					password_flag= false;
				}else{
					$("#error_password").html("");
					password_flag= true;
				}
			});
			$("#repassword").bind("input propertychange", function(){
				if($("#repassword").val()==$("#password").val()){
				$("#error-repassword").text("");
				$("#error-repassword").css("background-color","white");
				repassword_flag= true;
			}else {
				$("#error-repassword").text("密碼輸入不一致");
				$("#error-repassword").css("background-color","red");
				repassword_flag= false;
				}
			});
			$("#email").bind("input propertychange", function(){
				if($("#email").val().length<10){
					$("#error_email").html("信箱不得少於10個字數");
					$("#error_email").css("background-color", "red");
					$("#error_email").css("color", "white");
					email_flag=false;
				}else{
					$("#error_email").html("");
					email_flag=true;
				}
			});
			// ?query_type=register
			$("#reg_ok").bind("click", function(){
				$("#show_all_message").text("");//清空
				if(username_flag && repassword_flag && password_flag && email_flag){
					$.ajax({
					type: "POST",
					url: "./memberAPI/tcnr_member_api.php?query_type=register",
					data: {username: $("#username").val(), password: $("#password").val(), usertype: $("n").val(), email: $("#email").val() },
					success: reg,
					error:function(){
						alert("註冊api回傳失敗");
					}
				}); // end ajax
				}else{
					//提醒不正確
					if(!username_flag){
						alert("帳號不符規定!")
					}
					if(!password_flag){
						alert("密碼不符規定!")
					}
					if(!repassword_flag){
						alert("密碼不一致!")
					}
					if(!email_flag){
						alert("信箱不符規定!")
					}
				}
			});// end function()
		}); 
		function reg(data){
			if(data == "reg sucess"){
				location.href = "tcnr_login.php";
			}else{
				alert(data);
			}
		}

		function goBack(){
			history.back();
		}
	</script>
</head>
<body>
	<div data-role="page" id="home">
		<div data-role="header" data-position="fixed" id="home" data-theme="b">
			<h1>會員註冊</h1>
		</div>
		<div role="main" class="ui-content">
			<div data-role="fieldcontain">
				<label for="username">帳號</label>
				<input type="text" name="username" id="username">
			</div>
			<div id="error_username"></div>
			<div data-role="fieldcontain">
				<label for="password">密碼</label>
				<input type="password" name="password" id="password">
			</div>
			<div id="error_password"></div>
			<div data-role="fieldcontain">
				<label for="repassword">確認密碼</label>
				<input type="password" name="repassword" id="repassword">
			</div>
			<div id="error-repassword"></div>
			<div data-role="fieldcontain">
				<label for="repassword">信箱:</label>
				<input type="text" name="email" id="email">
			</div>
			<div id="error_email"></div>
			<div class="ui-grid-a">
				<div class="ui-block-a">
					<a href="#" data-role="button" data-theme="b" id="cancel">取消</a>		
				</div>
				<div class="ui-block-b">
					<a href="#" data-role="button" data-theme="b" id="reg_ok">註冊</a>		
				</div>
			</div>
		</div>
	</div>
</body>
</html>		