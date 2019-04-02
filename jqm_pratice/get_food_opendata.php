<?php
header("Access-Control-Allow-Origin:*");
$url="https://quality.data.gov.tw/dq_download_json.php?nid=6037&md5_url=a155732e5592d56f8d69165cc59f59e5";
$content=file_get_contents($url);
echo $content;
//echo json_encode($content);
?>