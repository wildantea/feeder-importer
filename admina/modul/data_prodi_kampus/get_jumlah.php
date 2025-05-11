<?php
header('Access-Control-Allow-Origin: *');
include "../../inc/config.php";

$jml_url = file_get_contents('http://103.183.74.106/services/get_jumlah_kampus.php');

$jml = json_decode($jml_url);

if ($jml->jumlah>0) {
   $json_response['jumlah'] = $jml->jumlah;
   $db->fetch_custom("truncate sms");
   $db->fetch_custom("truncate satuan_pendidikan");
} else {
  $json_response['jumlah'] = 0;
}

echo json_encode($json_response);
?>