<?php
include "../../inc/config.php";

$email = $_POST['email'];
function stringInsert($str,$insertstr,$pos)
{
    $str = substr($str, 0, $pos) . $insertstr . substr($str, $pos);
    return $str;
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
$chek_finish = file_get_contents("https://wildantea.com/importer-free-up/check_survey.php?email=$email");
$dcode = json_decode($chek_finish);
if ($dcode->finish=='Y') {
	$data = array('redirect' => 'N','last_login' => '2018-10-17');
	insert_data($data);
	$db->action_response('');
} else {
	$db->action_response('Pastikan Semua Survey Sudah Diisi');
}
?>