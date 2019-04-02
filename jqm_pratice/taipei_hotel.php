<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="device-width,initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css">
	<link rel="stylesheet" href="css/listview-grid.css">
	<script src="js/jquery-2.1.0.min.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
	<!-- googlemap -->
	<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSnyMTQAIeclcmF-1y1ufEj3mzZb6sPx4" type="text/javascript"></script>
	<script>
		var regionTitle=new Array();
		var counter=new Array();
		var regionData=new Array();

		$(function(){
			$.ajax({
				type:'GET',
				url:'get_hotel_info.php',
				dataType:'json',
				success:show,
				error:function(){alert('Ajax request 發生錯誤');}
			});

			function show(data){
				console.log(data.length);
				for(var i=0,cnt=data.length;i<cnt;i++){
					var getRegion=data[i]["display_addr"].substring(0,data[i]["display_addr"].indexOf("區",0)+1);
					if(counter[getRegion]==undefined){
						counter[getRegion]=regionData.length;
						regionData.push(new Array());
						regionTitle[counter[getRegion]]=getRegion;
					}
					regionData[counter[getRegion]].push(data[i]);

				}//for end

				$("#list").empty();
					

				// listview主選單
				for(var i=0;i<regionData.length;i++){
					var hotel_name="";
					var hotel_addr="";
					var hotel_tel="";
					var map_x="";
					var map_y="";

					for(var j=0;j<regionData[i].length;j++){
						hotel_name+=regionData[i][j]["name"]+"|";
						hotel_addr+=regionData[i][j]["display_addr"]+"|";
						hotel_tel+=regionData[i][j]["tel"]+"|";
						map_x+=regionData[i][j]["X"]+"|";
						map_y+=regionData[i][j]["Y"]+"|";
					}
					


					if(regionTitle[i].length==0)
					{
						strHtml='<li data-icon="home"><a href="#hotel" regionTitle="'+regionTitle[i]+'" hotel_name="'+hotel_name+'" hotel_addr="'+hotel_addr+'" hotel_tel="'+hotel_tel+'" map_x="'+map_x+'" map_y="'+map_y+'" id="hotel">其他區旅館資料<span class="ui-li-count">'+regionData[i].length+'</span></a><a href="#map" data-icon="info" map_x="'+map_x+'" map_y="'+map_y+'" id="map">map</a></li>';
						$("#list").append(strHtml);
					}else{
						strHtml='<li data-icon="home"><a href="#hotel" regionTitle="'+regionTitle[i]+'" hotel_name="'+hotel_name+'" hotel_addr="'+hotel_addr+'" hotel_tel="'+hotel_tel+'" map_x="'+map_x+'" map_y="'+map_y+'" id="hotel">'+regionTitle[i]+'旅館資料<span class="ui-li-count">'+regionData[i].length+'</span></a><a href="#map" data-icon="info" regionTitle="'+regionTitle[i]+'" hotel_name="'+hotel_name+'" hotel_addr="'+hotel_addr+'" hotel_tel="'+hotel_tel+'" map_x="'+map_x+'" map_y="'+map_y+'" id="map">map</a></li>';
						$("#list").append(strHtml);
					}
					
				}

				$("a",$("#list")).bind("click",function(){
					if($(this).attr("id")=="hotel"){
				       getItem($(this).attr("regionTitle"),$(this).attr("hotel_name"),$(this).attr("hotel_addr"),$(this).attr("hotel_tel"),$(this).attr("map_x"),$(this).attr("map_y"))
				    }else if($(this).attr("id")=="map"){
				    	getmap($(this).attr("regionTitle"),$(this).attr("hotel_name"),$(this).attr("hotel_addr"),$(this).attr("hotel_tel"),$(this).attr("map_x"),$(this).attr("map_y"))
				    }
					
				});
				$("#list").listview("refresh");
			}//end function show()
			function getItem(regionTitle,hotel_name,hotel_addr,hotel_tel,map_x,map_y){
				console.log("regionTitle:"+regionTitle);
				console.log("hotel_name:"+hotel_name);
				console.log("hotel_addr:"+hotel_addr);
				console.log("hotel_tel:"+hotel_tel);
				// map
				console.log("X:"+map_x);
				console.log("Y:"+map_y);

				$("#hotel_title").html(regionTitle+"飯店列表");

				var hotel_namearray=hotel_name.split("|");
				var hotel_addrarray=hotel_addr.split("|");
				var hotel_telarray=hotel_tel.split("|");
				// map
				var map_xarray=map_x.split("|");
				var map_yarray=map_y.split("|");

				$("#list_hotel").empty();

				for(i=0;i<hotel_namearray.length-1;i++)
				{
					strHTML='<li data-icon="star"><a href="" data-addr="'+hotel_addrarray[i]+'"><h3>'+hotel_namearray[i]+'</h3><p>'+hotel_addrarray[i]+'</p><p>'+hotel_telarray[i]+'</p></a></li>';
					$("#list_hotel").append(strHTML);
				}
				$("a",$("#list_hotel")).bind("click",function(){
					searchFor($(this).attr("data-addr"));
				});

				$("#list_hotel").listview("refresh");

				
			}

			function getmap(regionTitle,hotel_name,hotel_addr,hotel_tel,map_x,map_y){


				var hotel_namearray=hotel_name.split("|");
				var hotel_addrarray=hotel_addr.split("|");
				var hotel_telarray=hotel_tel.split("|");
				// map
				var map_xarray=map_x.split("|");
				var map_yarray=map_y.split("|");
				// ---------------map----------------------
					// 計算地球上兩點的距離
					function getDistance(Lat1,Long1,Lat2,Long2){
						ConvertDegreeToRadians=function(degrees){
							return (Math.PI/180)*degrees;
						}
						var Lat1r=ConvertDegreeToRadians(Lat1);
						var Lat2r=ConvertDegreeToRadians(Lat2);
						var Long1r=ConvertDegreeToRadians(Long1);
						var Long2r=ConvertDegreeToRadians(Long2);

						var R=6371;//地球半徑(km)
						var d=Math.acos(Math.sin(Lat1r)*Math.sin(Lat2r)+
							Math.cos(Lat1r)*Math.cos(Lat2r)*Math.cos(Long2r-Long1r))*R;
						return d;// 兩點的距離 (KM)
					}				

					// 地圖實作
					$(function(){
						// 設定地圖中心點
						var map_div=document.getElementById("map_div");
						// 取得經緯度
						var lat=map_yarray[0];
						var lng=map_xarray[0];
							var latlng=new google.maps.LatLng(lat,lng);
						var gmap=new google.maps.Map(map_div,{
							zoom:12,
							center:latlng,
							mapTypeId:google.maps.MapTypeId.ROADMAP
						
						});
						var marker=[];

						for(i=0;i<map_x.length-1;i++)
						{											
							
								latlng=new google.maps.LatLng(map_yarray[i],map_xarray[i]);
								marker[i]=new google.maps.Marker({
									position:latlng,
									icon:"image/1.png",
									map:gmap,
									title:" MY Company!!"
								});
								// 地標事件，以 google.maps.event.addListener()建立觸碰地標的事件

								google.maps.event.addListener(marker[i],"click",function(event){
									// google.maps.InfoWindow: 彈出的訊息視窗 infowindow.open(): 在google map 開啟訊息視窗
									var lat=event.latLng.lat();
									var lng=event.latLng.lng();

									for(j=0;j<map_x.length-1;j++){
										// parray=data[j].Coordinate.split(",");
										var disp=getDistance(lat,lng,map_yarray[j],map_xarray[j]);//單位: 公里
										if(disp<0.001){
											var infowindow=new google.maps.InfoWindow({
												content:'<p style="text-align:center; color:orange;">'+hotel_namearray[j]+'</p><BR><p style="color:purple; text-align:center;;">'+hotel_addrarray[j]+'</p><p style="color:purple; text-align:center;;">'+hotel_telarray[j]+'</p>'
											});
											// 只能開啟一個視窗
											if($('.gm-style-iw').length) {   
								                 $('.gm-style-iw').parent().remove();   
								             }
											infowindow.open(gmap,marker[j]);
										}//if
										
									}//for
									
								});
									
						}//for map_x,map_y
					});
			}				

			function searchFor(addr){
				window.open("http://maps.google.com/maps?hl=zh-TW&q="+addr);
			}
		});
	</script>
	<style>
		#map_div{
			width: 300px;
			height: 600px;
			margin-top: 0;
			margin-bottom: 0;
			margin-left: auto;
			margin-right: auto;
			box-shadow: 2px 2px 2px 3px #ccc
			/*background-color: white;*/
		}
		.info{
			color:orange;
		}

	</style>
</head>
<body>
	<div data-role="page" id="home">
		<div data-role="header" data-theme="b">
			<h2>台北市旅館資訊</h2>
		</div>

		<div data="main" class="ui-content">
			<ul data-role="listview" data-inset="true" id="list">
				<li data-icon="home">
					<a href="#">旅館資料<span class="ui-li-count">10</span></a></li>
			</ul>
			
		</div>

		<div data-role="footer" data-position="fixed">
			
		</div>
	</div>	
	<!-- page-hotel -->
	<div data-role="page" id="hotel">
		<div data-role="header" data-theme="b">
			<h2 id="hotel_title">台北市旅館資訊</h2>
		</div>

		<div data="main" class="ui-content">
			<ul data-role="listview" data-filter="true" data-filter-placeholder="Find Hotel" data-inset="true" id="list_hotel">
				<li data-icon="home">
					<a href="" data-addr="">
						<h3></h3>
						<p></p>
						<p></p>
					</a>
					
				</li>	
			</ul>
			
		</div>

		<div data-role="footer" data-position="fixed">
			
		</div>
	</div>	

	<!-- map -->
	<div data-role="page" id="map">
		<div data-role="header" data-theme="b">
			<h2 id="hotel_title">map</h2>
		</div>

		<div data="main" class="ui-content">
			<div id="map_div"></div>
			
		</div>

		<div data-role="footer" data-position="fixed">
			
		</div>
	</div>	
</body>
</html>