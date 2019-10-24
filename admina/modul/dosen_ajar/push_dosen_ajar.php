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



# MENDAPATKAN TOKEN
$username = $config->username;
$password = $config->password;
$result = $proxy->GetToken($username, $password);
$token = $result;

//$token = 'acdbbc82c3b29f99e9096dab1d5eafb4';


	$id_sms = '';
	$id_mk = '';
	$id_reg_ptk = '';
	$nidn = '';
	$id_ptk = '';
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
	$temp_result = array();
	$error_tugas = "";

	$id_sp = $config->id_sp;

$table1 = 'kelas_kuliah';

	$arr_data = $db->query("select ajar_dosen.id as id_dosen_ajar,ajar_dosen.*,jurusan.kode_jurusan,jurusan.id_sms from ajar_dosen inner join jurusan on ajar_dosen.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and ajar_dosen.semester='".$_GET['sem']."' and status_error!=1 and nidn!=''");

	//print_r($arr_data);

/*	$arr_data = $db->query("select kelas_kuliah.*,jurusan.kode_jurusan from kelas_kuliah inner join jurusan on kelas_kuliah.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='705' and kelas_kuliah.semester='20141' limit 5,5");
*/



$options = array(
    'filename' => $_GET['jurusan'].'_progress.json',
    'autoCalc' => true,
    'totalStages' => 1
);
$pu = new Manticorp\ProgressUpdater($options);



$stageOptions = array(
    'name' => 'This AJAX process takes a long time',
    'message' => 'But this will keep the user updated on it\'s actual progress!',
    'totalItems' => $arr_data->rowCount(),
);


$pu->nextStage($stageOptions);



$i=1;



	foreach ($arr_data as $value) {

		//print_r($value);
		$nidn = trim($value->nidn);
		$kode_mk = trim($value->kode_mk);
		$kelas = trim($value->nama_kelas);
		$ren_tm = trim($value->rencana_tatap_muka);
		$rel_tm = trim($value->tatap_muka_real);
		$semester = trim($value->semester);
		$id_sms = $value->id_sms;
		$sks_ajar = trim($value->sks_ajar);

		$kode_prodi = $value->kode_jurusan;


		$filter_nidn = "nidn='".$nidn."'";
		$temp_nidn = $proxy->GetRecord($token,'dosen',$filter_nidn);

		if ($temp_nidn['result']) {
			$id_sdm = $temp_nidn['result']['id_sdm'];
			
		} else {
			$id_sdm = "";
		}

		if ($id_sdm=="") {
		++$error_count;
							$db->update('ajar_dosen',array('status_error' => 2, 'keterangan'=>"<b>NIDN tidak terdaftar di feeder</b>"),'id',$value->id_dosen_ajar);
							$error_msg[] = "<b>NIDN tidak terdaftar di feeder</b>";
		}

		else {

			$filter_ptk = "p.id_sdm='".$id_sdm."'";
			$temp_ptk = $proxy->GetRecordset($token,'dosen_pt',$filter_ptk,"id_thn_ajaran desc",1,0);
		if (!empty($temp_ptk['result'])) {
			$id_reg_ptk = $temp_ptk['result'][0]['id_reg_ptk'];
		} else {
				$error_tugas = "Tidak ada penugasan";
		}

		

		//Filter 
		$filter_mk = "p.id_sms='".$id_sms."' and trim(kode_mk)='".$kode_mk."'";
		$temp_mk = $proxy->GetRecord($token,'mata_kuliah',$filter_mk);
		if ($temp_mk['result']) {
			$id_mk = $temp_mk['result']['id_mk'];
			$sks_mk = $temp_mk['result']['sks_mk'];

		}

	

		//Filter kelas kuliah
		$filter_kls = "p.id_sms='$id_sms' and trim(kode_mk)='".$kode_mk."' AND trim(nm_kls)='".$kelas."' AND p.id_smt='".$semester."'";

		$temp_kls = $proxy->GetRecord($token,$table1,$filter_kls);

		if (empty($temp_kls['result'])) {
				++$error_count;
				$db->update('ajar_dosen',array('status_error' => 2, 'keterangan'=>"Error, Pastikan Kelas $kelas Sudah dibuat "),'id',$value->id_dosen_ajar);
				$error_msg[] = "Error, Pastikan Kelas $kelas Sudah dibuat ";
		} else {

			$id_kls = $temp_kls['result']['id_kls'];
				if($sks_ajar!=NULL or $sks_ajar!='') {
					$sks_mk = $sks_ajar;
				} else {
					$get_matkul = $proxy->GetRecord($token,'mata_kuliah',"id_mk='".$temp_kls['result']['id_mk']."'");
					
					$sks_mk = $get_matkul['result']['sks_mk'];
					
					$check_count = $db->query("select * from ajar_dosen where semester=? and kode_mk=? and nama_kelas=? and kode_jurusan=?",array('semester' => $value->semester,'kode_mk' => $value->kode_mk,'nama_kelas' => $value->nama_kelas,'kode_jurusan' => $kode_prodi));
					if ($check_count->rowCount()>1) {
						$sks_mk = $sks_mk/$check_count->rowCount();
					} else {
						$sks_mk = $get_matkul['result']['sks_mk'];
					}
				}

			$filter_check = "p.id_reg_ptk='".$id_reg_ptk."' and p.id_kls='".$id_kls."'";
			$check = $proxy->GetRecord($token,'ajar_dosen',$filter_check);

			if (empty($check['result'])) {

							$temp_data = array(
								'id_reg_ptk' => $id_reg_ptk,
								 'id_kls' => $id_kls,
						  'sks_subst_tot' => $sks_mk,
						   'sks_tm_subst' => 0,
				  		 'sks_prak_subst' => 0,
				  	 'sks_prak_lap_subst' => 0,
				  	 	  'sks_sim_subst' => 0,
				  	 		'jml_tm_renc' => $ren_tm,
				  	 		'jml_tm_real' => $rel_tm,
				  	 		'id_jns_eval' => 1
				);


				$temp_result = $proxy->InsertRecord($token, "ajar_dosen", json_encode($temp_data));

						if ($temp_result['result']['error_desc']==NULL) {
							++$sukses_count;
							$db->update('ajar_dosen',array('status_error'=>1,'keterangan'=>''),'id',$value->id_dosen_ajar);
						} else {
							++$error_count;
							$db->update('ajar_dosen',array('status_error' => 2, 'keterangan'=>"<b>Error, $kode_mk Kelas $kelas </b>".$temp_result['result']['error_desc']),'id',$value->id_dosen_ajar);
							$error_msg[] = "<b>Error, $kode_mk Kelas $kelas</b>".$temp_result['result']['error_desc'];
						}
				
			} else {
				++$error_count;
				$db->update('ajar_dosen',array('status_error' => 2, 'keterangan'=>"Dosen ini sudah ada dikelas"),'id',$value->id_dosen_ajar);
				$error_msg[] = "<b>Error</b>, Dosen ini sudah ada dikelas";

			}

		}


		}

		

		
$i++;
 $pu->incrementStageItems(1, true);


	}


$msg = '';
	$msg =  "<div class=\"alert alert-warning\" role=\"alert\">
			<font color=\"#3c763d\">".$sukses_count." data Dosen Ajar baru berhasil ditambah</font><br />
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


//echo $msg;

$pu->totallyComplete($msg);


