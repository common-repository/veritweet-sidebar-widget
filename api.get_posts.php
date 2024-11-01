<?php

$limit = "";
if (isset($_GET["limit"])) $limit = $_GET["limit"];

$channel_id = "";
if (isset($_GET["channel_id"])) $channel_id = $_GET["channel_id"];

$useragent = urlencode($_SERVER['HTTP_USER_AGENT']);
$ip = urlencode($_SERVER['REMOTE_ADDR']);

$curl = "http://www.veritweet.com/api/api.user_timeline.php?channel_id=".$channel_id."&limit=".$limit."&ip=".$ip."&useragent=".$useragent;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $curl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$ret = curl_exec ($ch);
curl_close ($ch);

print_r($ret);
?>