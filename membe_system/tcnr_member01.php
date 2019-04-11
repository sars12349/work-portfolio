<?php 
	session_start();
	
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>會員資料</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<div class="text-center">
  		<h1>會員資料</h1>
  	</div>
  	<br>
  	<div class="container text-center">
  		<table class="table table-bordered table-condensed" id="t_table">
	    	<thead>
	    		<tr>
	    			<th></th>
		    		<th class="text-center">id</th>
		    		<th class="text-center">username</th>
		    		<th class="text-center">password</th>
		    		<th class="text-center">usertype</th>
		    		<th></th>
	    		</tr>
	    	</thead>
    	</table>
    	<div>
    		<a href="https://tcnr1621.000webhostapp.com/member_test/memberAPI/tcnr_member_api.php?query_type=logout" data-ajax="false" class="btn btn-primary" id="logout">登出</a>
    	</div>
  	</div>
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<script>
		$(function(){
			$.ajax({
				type:"get",
				url:"./memberAPI/tcnr_member_api.php?query_type=member",
				dataType:"json",
				success:showData,
				error:function(){
					alert("tcnr_member_api回傳失敗");
				}
			});
		});

		function showData(data){
			$("#t_table").empty();
			var usertype = "<?php echo $_SESSION['usertype']; ?>";

			if(usertype == "a"){
				for(var i=0; i<data.length ;i++){
					$("#t_table").append('<thead><tr><th></th><th class="text-center">id</th><th class="text-center">username</th><th class="text-center">password</th><th class="text-center">usertype</th><th></th></tr></thead><tbody><tr><td><a href="tcnr_update01.php?id='+data[i].id+'"><span class="glyphicon glyphicon-pencil"></span></a></td><td>'+data[i].id+'</td><td>'+data[i].username+'</td><td>'+data[i].password+'</td><td>'+data[i].usertype+'</td><td><a href="#" id="btn0'+data[i].id+'"><span class="glyphicon glyphicon-remove"></span></a></td></tr></tbody>');

					$("#btn0"+data[i].id).on("click",null,{id:data[i].id},check);
				}
			}else{
					$("#t_table").append('<thead><tr><th>id:</th><th>'+data[0].id+'</th></tr></thead><thead><tr><th>username:</th><th>'+data[0].username+'</th></tr></thead><thead><tr><th>password:</th><th>'+data[0].password+'</th></tr></thead><thead><tr><th>Email:</th><th>'+data[0].email+'</th></tr><tr></thead><th><a href="tcnr_update01.php?id='+data[0].id+'"><span class="glyphicon glyphicon-pencil"></span></a></th></tr>');
			}
			
			
		}

		function check(event){
			if(confirm("確定要刪除嗎?")){
				location.href = "memberAPI/tcnr_member_api.php?query_type=delete&id="+event.data.id;
			}
		}



	</script>
  </body>
</html>
