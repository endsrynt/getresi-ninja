<?php
login:
$link = "https://api.cariresi.id/cariresi";
$header = array(
"Host: api.cariresi.id",
"accept: application/json, text/plain, */*",
"content-type: application/x-www-form-urlencoded",
"token-key: o6Z8VBuLlS19NuRMO9gMg2jncnV61zif",
"cookie: __cfduid=d83f4d7f209ef8520bc8ed228531df1a31617990632",
"user-agent: okhttp/3.12.12"
);

// curl get
function http_get($url){
global $header;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  return curl_exec($ch);
}

// curl post
function http_post($url, $data){
 $header = array(
"Host: api.cariresi.id",
"accept: application/json, text/plain, */*",
"content-type: application/x-www-form-urlencoded",
"token-key: o6Z8VBuLlS19NuRMO9gMg2jncnV61zif",
"cookie: __cfduid=d83f4d7f209ef8520bc8ed228531df1a31617990632",
"user-agent: okhttp/3.12.12"
);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  return curl_exec($ch);
}

function randomString($length)
{
    $str        = "";
    $characters = '1234567890';
    $max        = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}

$resi = 'TKNX'.randomString(10);

$data ="courier=ninja&awb=".$resi."&token=o6Z8VBuLlS19NuRMO9gMg2jncnV61zif";
$gas = http_post($link,$data);
$gas = json_decode($gas);
if($gas->cariresi->status->code == 400){
	$desc = $gas->cariresi->status->desc;
	echo  "\033[0;31m $resi $desc";
	echo "\n";
}else{
    $gas->cariresi->status->code == 200;
    $stat = $gas->cariresi->detail->status;
    $date = $gas->cariresi->detail->date;
    echo  "\033[0;32m $resi | $stat | $date";
    echo "\n";
    $file = fopen("live_ninja.txt","a");  
    fwrite($file,"".$resi." | ".$stat." | ".$date); 
    fwrite($file,"\n"); 
    fclose($file);  
}if($gas->cariresi->status->desc == "Blocked"){
	echo "IP Limit cok, ganti ip gidaaahh";
	exit;
}


goto login;
	
	

