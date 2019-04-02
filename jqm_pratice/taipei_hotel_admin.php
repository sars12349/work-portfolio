<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="device-width,initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css">
	<script src="js/jquery-2.1.0.min.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
	<script>
		var flag_hotelname=false;
		var flag_addr=false;
		var flag_tel=false;
		$(function(){
			//檢查店名
			$("#hotelname").bind("input propertychange", function(){
				if($("#hotelname").val().length<4){
					$("#error_hotelname").html("名稱字數不得少於4個字!!");
					$("#error_hotelname").css("background-color","red");
					$("#error_hotelname").css("color","white");
					flag_hotelname=false;
				}else{
					$("#error_hotelname").html("");
					flag_hotelname=true;
				}
			});

			// 檢查電話
			$("#tel").bind("input propertychange", function(){
				if($("#tel").val().length < 10){
					$("#error_tel").html("電話字數不得少於10個字!!");
					$("#error_tel").css("background-color", "red");
					$("#error_tel").css("color", "white");
					flag_tel = false;
				}else{
					$("#error_tel").html("");
					flag_tel = true;
				}
			});	

			//檢查住址
			$("#addr").bind("input propertychange", function(){
				if($("#addr").val().length < 10){
					$("#error_addr").html("住址字數不得少於8個字!!");
					$("#error_addr").css("background-color", "red");
					$("#error_addr").css("color", "white");
					flag_addr = false;
				}else{
					$("#error_addr").html("");
					flag_addr = true;
				}
			});	

			$("#ok_btn").bind("click",insert);
		});

		function insert(){
			if(flag_hotelname&&flag_addr&&flag_tel){
				$.ajax({
					type:"POST",
					url:"./taipei_hotel_admin_api.php",
					data:{hotelname:$("#hotelname").val(), category: $("#category").val()
					,tel:$("#tel").val(),addr: $("#addr").val()},
					success:function(data){
						alert(data);
					},
					error:function(){
						alert("error");
					}
				});
			}
		}
	</script>
</head>
<body>
	<div data-role="page" id="home">
		<div data-role="header">
			
		</div>

		<div data="main" class="ui-content">
			<div data-role="fieldcontain">
				<label for="hotelname">飯店名稱:</label>
				<input type="text" name="hotelname" id="hotelname">
			</div>
			<div id="error_hotelname"></div>
			<div data-role="fieldcontain">
				<label for="selectmenu">旅館類別:</label>
				<select name="selectmenu" id="selectmenu">
					<option value="sun">休閒農場</option>
					<option value="cloud">飯店</option>
					<option value="rain">商務旅館</option>
					<option value="snow">汽車旅館</option>
				</select>				
			</div>		
			<div data-role="fieldcontain">
				<label for="tel">電話:</label>
				<input type="tel" name="tel" id="tel">
			</div>		
			<div id="error_tel"></div>
			
			<div data-role="fieldcontain">
				<label for="addr">地址:</label>
				<input type="text" name="addr" id="addr">
			</div>
			<div id="error_addr"></div>
			<div class="ui-grid-a">
				<div class="ui-block-a" >
					<a href="#" data-role="button" data-theme="b">取消</a>
				</div>
				<div class="ui-block-b" >
					<a href="#" data-role="button" data-theme="b" id="ok_btn" >送出</a>
				</div>
			</div>		
		</div>

		<div data-role="footer" data-position="fixed">
			
		</div>
	</div>	
</body>
</html>