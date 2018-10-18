<?php
session_start();
include "inc/config.php";
require_once "inc/fungsi.php";
if (isset($_SESSION['logins'])) {

//call header file
include  "header.php";

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

//fetch and decode
$data = $db->fetch_single_row('sys_system','id',1);
$replace_encode = substr_replace($data->data, '', 3 , 3);
$decode = base64_decode($replace_encode);
$json = json_decode($decode);
$check_config = $db->fetch_single_row("config_user","id",1);
$check_jurusan = $db->fetch_custom("select * from jurusan");
if ($json->redirect=='Y' and $check_config->id_sp!="" and $check_jurusan->rowCount()>0) {
	include "system/update/info.php";
} else {
		//switch for static menu 
switch ($path_url) {
	case '':
		include "modul/home/home.php";
		break;
	//begin case system menu
		//show only if user is admin 
	case 'modul':
		include "system/modul/modul.php";
		break;
	case 'update':
		include "system/update/update.php";
		break;
	case 'page':
		include "system/page/page.php";
		break;
	case 'menu-management':
		include "modul/menu_management/menu_management.php";
	break;
	case 'group-user':
		include "modul/group_user/group_user.php";
		break;
	case 'user-management':
		include "modul/user_management/user_management.php";
		break;
	//end case system menu
	case 'change-password':
		include "modul/change_password/change_pass.php";
		break;
	case 'profil':
		include "modul/profil/profil.php";
		break;
	
	/*default:
		include "modul/home/home.php";
		break;*/
	}

	
	 //dynamic menu sesuai dengan role user 
	//jika url yang di dipanggil ada di role user, include page  
	foreach ($db->fetch_all('sys_menu') as $isi) {
		if (in_array($isi->url, $role_user)) {

	           		if ($path_url!='' && $path_url==$isi->url) {
	           		
					include "modul/".$isi->nav_act."/".$isi->nav_act.".php";
					} 
	           } 
	}

}



	

include "footer.php";

} else {
	redirect(base_admin()."login.php");
}
?>
