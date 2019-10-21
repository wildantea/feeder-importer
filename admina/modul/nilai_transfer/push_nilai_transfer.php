<?php
//include "inc/config.php";
include "../../lib/nusoap/nusoap.php";

include "../../inc/config.php";

include "../../lib/prosesupdate/ProgressUpdater.php";


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


$table1 = 'kelas_kuliah';
# MENDAPATKAN TOKEN
$username = $config->username;
$password = $config->password;
$result = $proxy->GetToken($username, $password);
$token = $result;

//$token = 'acdbbc82c3b29f99e9096dab1d5eafb4';


	$id_sms = '';
	$id_mk = '';
	$id_kls = '';
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
	$error_nim = "";
	$error_mk = "";
	$error_kelas = "";

	$query_matkul = '';
	$query_kelas = '';

		//get id npsn
	$filter_sp = "npsn='".$config->id_sp."'";
	$get_id_sp = $proxy->GetRecord($token,'satuan_pendidikan',$filter_sp);

	$id_sp = $get_id_sp['result']['id_sp'];


	$count = $db->query("select *,nilai_transfer.id as id_krs from nilai_transfer inner join jurusan on nilai_transfer.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and status_error!=1");
	$jumlah = $count->rowCount();



	$sukses_count = 0;
	$sukses_msg = '';
	$error_count = 0;
	$error = array();


		$options = array(
		    'filename' => $_GET['jurusan'].'_progress.json',
		    'autoCalc' => true,
		    'totalStages' => 1
		);
		$new_pu = new Manticorp\ProgressUpdater($options);

	
	 	$data = $db->query("select *,nilai_transfer.id as id_krs from nilai_transfer inner join jurusan on nilai_transfer.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and status_error!=1");
			//let's push first page

			$stageOptions = array(
			    'name' => 'Page $i',
			    'message' => 'Some Message',
			    'totalItems' => $jumlah,
			);

			$new_pu->nextStage($stageOptions);

			foreach ($data as $value) {

			$nim = $value->nim;
			$kode_mk = $value->kode_mk;
			
				$kode_prodi = $value->kode_jurusan;

		$filter_ptk = "p.id_sp='".$id_sp."' and p.kode_prodi='".$kode_prodi."'";
		$temp_ptk = $proxy->GetRecord($token,'sms',$filter_ptk);
		if ($temp_ptk['result']) {
			$id_sms = $temp_ptk['result']['id_sms'];
		}

		$filter_pd = "nipd LIKE '%".$nim."%'";
		$temp_pd = $proxy->GetRecord($token,'mahasiswa_pt',$filter_pd);
		$tot_regpd = count($temp_pd['result']);
		if ($temp_pd['result']) {
			$id_reg_pd = $temp_pd['result']['id_reg_pd'];
			
			$filter_mk = "p.id_sms='".$id_sms."' and kode_mk='".$kode_mk."'";
			$temp_mk = $proxy->GetRecord($token,'mata_kuliah',$filter_mk);
			if ($temp_mk['result']) {
				$id_mk = $temp_mk['result']['id_mk'];
				$sks_mk = $temp_mk['result']['sks_mk'];


				$error_mk = "";
			} else {
				$id_mk = '';
				$sks_mk = "";
				$error_mk = "Kode Matakuliah tidak ditemukan di feeder";
			}

			$error_nim = "";
		} else {
			
			$id_reg_pd = "";
			$error_nim = "Mahasiswa dengan Nim ini tidak ada di feeder";
		}


		if ($id_reg_pd!="" && $id_mk!="") {

			$filter_check_exist = "p.id_mk='".$id_mk."' AND p.id_reg_pd='".$id_reg_pd."'";
			$check_krs = $proxy->GetRecord($token,'nilai_transfer',$filter_check_exist);
			if ($check_krs['result']) {

					++$error_count;
					$error_msg[] = "Nilai Transfer Mahasiswa ini sudah ada";
					$db->update('nilai',array('status_error' => 2, 'keterangan'=>"Nilai Transfer Mahasiswa ini sudah ada"),'id',$value->id_krs);

			} else {
				$temp_data = array(
					'id_reg_pd' => $id_reg_pd,
					'id_mk' => $id_mk,
					'kode_mk_asal' => $value->kode_mk_asal,
					'nm_mk_asal' => $value->nm_mk_asal,
					'sks_asal' => $value->sks_asal,
					'sks_diakui' => floatval($sks_mk),
					'nilai_huruf_asal' => $value->nilai_huruf_asal,
					'nilai_huruf_diakui' => $value->nilai_huruf_diakui,
					'nilai_angka_diakui' => $value->nilai_angka_diakui

				);
				//Jika Kelas kuliah terdaftar.
				$temp_result = $proxy->InsertRecord($token,'nilai_transfer',json_encode($temp_data));

				if ($temp_result['result']['error_desc']==NULL) {
					++$sukses_count;
					$db->update('nilai_transfer',array('status_error'=>1,'keterangan'=>''),'id',$value->id_krs);
				} else {
					++$error_count;
					$error_msg[] = $temp_result['result']['error_desc'];
					$db->update('nilai_transfer',array('status_error' => 2, 'keterangan'=>$temp_result['result']['error_desc']),'id',$value->id_krs);
				}
			}


		} else {
				++$error_count;
				$error_msg[] = "$error_nim $error_mk";
				$db->update('nilai',array('status_error' => 2, 'keterangan'=>"$error_nim $error_mk"),'id',$value->id_krs);
		}

				$new_pu->incrementStageItems(1, true);


		}

		$msg = '';
		if ((!$sukses_count==0) || (!$error_count==0)) {
			$msg =  "<div class=\"alert alert-warning \" role=\"alert\">
					<font color=\"#3c763d\">".$sukses_count." data Nilai Transfer baru berhasil di kirim ke feeder</font><br />
					<font color=\"#ce4844\" >".$error_count." data tidak bisa ditambahkan </font>";
					
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

		$new_pu->totallyComplete($msg);


