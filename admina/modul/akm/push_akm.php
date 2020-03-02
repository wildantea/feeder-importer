<?php
//include "inc/config.php";
include "../../lib/nusoap/nusoap.php";

include "../../inc/config.php";

include "../../lib/prosesupdate/ProgressUpdater.php";

$options = array(
    'filename' => $_GET['jurusan'].'_progress.json',
    'autoCalc' => true,
    'totalStages' => 1
);

$pu = new Manticorp\ProgressUpdater($options);
$check = $db->query("select *,nilai_akm.id as id_akm from nilai_akm inner join jurusan on nilai_akm.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and nilai_akm.semester='".$_GET['sem']."' and (valid=0 or valid=2)");
$jumlah_error = $check->rowCount();
if ($jumlah_error>0) {
	$msg = "Pastikan Anda Sudah Melakukan validasi AKM dan semua data valid";

	$pu->totallyComplete($msg);
	exit();
}
$config = $db->fetch_single_row('config_user','id',1);

if ($config->live=='Y') {
	$url = 'http://'.$config->url.':'.$config->port.'/ws/live.php?wsdl'; // gunakan live
} else {
	$url = 'http://'.$config->url.':'.$config->port.'/ws/sandbox.php?wsdl'; // gunakan sandbox
}
//untuk coba-coba
// $url = 'http://pddikti.uinsgd.ac.id:8082/ws/live.php?wsdl'; // gunakan live bila

$client = new nusoap_client($url, true);
$proxy = $client->getProxy();



# MENDAPATKAN TOKEN
$username = $config->username;
$password = $config->password;
$result = $proxy->GetToken($username, $password);
$token = $result;

//$token = 'acdbbc82c3b29f99e9096dab1d5eafb4';


	$id_sms = '';
	$id_mk = '';
	$sks_mk = '';
	$sks_tm = '';
	$sks_prak = '';
	$sks_prak_lap = '';
	$sks_sim = '';
	$temp_data = array();
	$sukses_count = 0;
	$sukses_msg = '';
	$error_count = 0;
	$error_msg = array();
	$data_id = array();
	$error_id = array();

	$id_sp = $config->id_sp;

	$arr_data = $db->query("select *,nilai_akm.id as id_akm from nilai_akm inner join jurusan on nilai_akm.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and nilai_akm.semester='".$_GET['sem']."' and status_error!=1");






$stageOptions = array(
    'name' => 'This AJAX process takes a long time',
    'message' => 'But this will keep the user updated on it\'s actual progress!',
    'totalItems' => $arr_data->rowCount(),
);


$pu->nextStage($stageOptions);



$i=1;

$insert_data_akm = array();

	foreach ($arr_data as $value) {

		$nim = $value->nim;
		$filter_npm = "nipd like '%".$nim."%'";
		$temp_npm = $proxy->GetRecord($token,'mahasiswa_pt',$filter_npm);
		//var_dump($temp_npm);
		if ($temp_npm['result']) {
			$id_reg_pd = $temp_npm['result']['id_reg_pd'];
			if ($_GET['method']=='up') {
			$filter_akm = "id_reg_pd='".$id_reg_pd."' and id_smt='".$value->semester."'";
			$temp_akm = $proxy->GetRecord($token,'kuliah_mahasiswa',$filter_akm);
			$array_key = array('id_smt' => $value->semester, 'id_reg_pd' => $temp_npm['result']['id_reg_pd']);
			$array_data = array(
						  		'ips' => $value->ips,
						  	'sks_smt' => $value->sks_smt,
						  		'ipk' => $value->ipk,
						  'sks_total' => $value->sks_total,
						 'id_stat_mhs' => $value->status_kuliah,
						 'biaya_smt' => $value->biaya_smt
						);
			$final_up = array('key' => $array_key, 'data' => $array_data
				);
			$up_result = $proxy->UpdateRecord($token, 'kuliah_mahasiswa', json_encode($final_up));

			if ($up_result['result']['error_desc']==NULL) {
									++$sukses_count;

									$db->update('nilai_akm',array('status_error'=>1,'keterangan'=>''),'id',$value->id_akm);
								} else {
									++$error_count;
									$error_msg[] = "<b>Error $nim</b>".$up_result['result']['error_desc'];
									$db->update('nilai_akm',array('status_error' => 2, 'keterangan'=>$up_result['result']['error_desc']),'id',$value->id_akm);
								}
			$i++;
	 $pu->incrementStageItems(1, true);

		} else {


		$filter_nim = "id_reg_pd='".$id_reg_pd."' and id_smt='".$value->semester."' and soft_delete='1'";
		$check_delete = $proxy->GetRecord($token,'kuliah_mahasiswa',$filter_nim);

		if ($check_delete['result']) {
			$restore_data = array('id_reg_pd' => $check_delete['result']['id_reg_pd']);
			$restore = $proxy->RestoreRecord($token,'kuliah_mahasiswa',json_encode($restore_data));


			$array_key = array('id_smt' => $value->semester, 'id_reg_pd' => $check_delete['result']['id_reg_pd']);
			$array_data = array(
						  		'ips' => $value->ips,
						  	'sks_smt' => $value->sks_smt,
						  		'ipk' => $value->ipk,
						  'sks_total' => $value->sks_total,
						 'id_stat_mhs' => $value->status_kuliah,
						 'biaya_smt' => $value->biaya_smt
						);
					$final_up = array('key' => $array_key, 'data' => $array_data
				);
			$temp_result = $proxy->UpdateRecord($token, 'kuliah_mahasiswa', json_encode($final_up));


		} else {

					$temp_data = array('id_smt' => $value->semester,
						  'id_reg_pd' => $id_reg_pd,
						  		'ips' => $value->ips,
						  	'sks_smt' => $value->sks_smt,
						  		'ipk' => $value->ipk,
						  'sks_total' => $value->sks_total,
						 'id_stat_mhs' => $value->status_kuliah,
						 'biaya_smt' => $value->biaya_smt
						);
					$temp_result = $proxy->InsertRecord($token, 'kuliah_mahasiswa', json_encode($temp_data));

		}


				if ($temp_result['result']['error_desc']==NULL) {
									++$sukses_count;

									$db->update('nilai_akm',array('status_error'=>1,'keterangan'=>''),'id',$value->id_akm);
								} else {
									++$error_count;
									$error_msg[] = "<b>Error, </b>".$temp_result['result']['error_desc'];
									$db->update('nilai_akm',array('status_error' => 2, 'keterangan'=>$temp_result['result']['error_desc']),'id',$value->id_akm);
								}



		}

	} else {

			++$error_count;
			$error_msg[] = "<b>Error, mahasiswa dengan nim $nim</b> tidak ada di feeder";
			$db->update('nilai_akm',array('status_error' => 2, 'keterangan'=>"Error, mahasiswa dengan nim ini tidak ada di feeder"),'id',$value->id_akm);
		}

	 $pu->incrementStageItems(1, true);


	}

$msg = '';
if ((!$sukses_count==0) || (!$error_count==0)) {
	$msg =  "<div class=\"alert alert-warning \" role=\"alert\">
			<font color=\"#3c763d\">".$sukses_count." data Akm baru berhasil di Upload</font><br />
			<font color=\"#ce4844\" >".$error_count." data tidak bisa diupload </font>";

			if (!$error_count==0) {
				$msg .= "<a data-toggle=\"collapse\" href=\"#collapseExample\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail error</a>";
			}
			//echo "<br />Total: ".$i." baris data";
			$msg .= "<div class=\"collapse\" id=\"collapseExample\">";
					$i=1;
					foreach ($error_msg as $pesan) {
							$msg .= "<div class=\"bs-callout bs-callout-danger\">".$i.". ".$pesan."</div><br />";
						$i++;
						}
			$msg .= "</div>
		</div>";
}

$pu->totallyComplete($msg);


//$pu->totallyComplete();

