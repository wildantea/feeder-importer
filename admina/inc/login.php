<?php
session_start();
include "config.php";
	$data = array(
		'username'=>$_POST['username'],
		'password'=>md5($_POST['password'])
		);

		$dt=$db->fetch_single_row('sys_users','username',$_POST['username']);
		$check = $db->check_exist('sys_users',$data);
		if ($check==true) {
			if ($dt->id_group!=1) {
				//check again if not admin
				$data_user = array(
				'username'=>$_POST['username'],
				'password'=>md5($_POST['password'])
				);
				$checks = $db->check_exist('sys_users',$data_user);
					if ($checks==true) {
						$_SESSION['nama_lengkap'] = $dt->first_name." ".$dt->last_name;
						$_SESSION['level']=$dt->id_group;
						$_SESSION['id_user']=$dt->id;
						$_SESSION['jurusan'] = $dt->kode_jurusan;
						$_SESSION['logins']=1;
						$db->update('sys_users',array('last_login' => date('Y-m-d'),'stat_act' =>'N'),'id',$dt->id);
						echo "good";

					}
			} else {
				//if admin, just go on
				$_SESSION['nama_lengkap'] = $dt->first_name." ".$dt->last_name;
				$_SESSION['level']=$dt->id_group;
				$_SESSION['id_user']=$dt->id;
				$_SESSION['logins']=1;
				$db->update('sys_users',array('last_login' => date('Y-m-d'),'stat_act' =>'N'),'id',$dt->id);
				echo "good";
			}

		}
?>
