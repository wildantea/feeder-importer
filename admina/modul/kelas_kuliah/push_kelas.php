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


	$id_sms = "";
	$id_mk = "";
	$id_kls = "";
	$sks_mk = 0;
	$sks_tm = 0;
	$sks_prak = 0;
	$sks_prak_lap = 0;
	$sks_sim = 0;
	$temp_data = array();
	$sukses_count = 0;
	$sukses_msg = '';
	$error_count = 0;
	$error_msg = array();
	$data_id = array();
	$error_id = array();
	$error_mk = "";

	$matkul = '';
	$kelas = '';

	if ($_GET['matkul']!='all') {
		$matkul = "and kode_mk='".$_GET['matkul']."'";
	}
	if ($_GET['kelas']!='all') {
		$kelas  = "and nama_kelas='".$_GET['kelas']."'";
	}
	
	
	$id_sp = $config->id_sp;


	$count = $db->query("select * from kelas_kuliah where kode_jurusan='".$_GET['jurusan']."' and semester='".$_GET['sem']."' and status_error!=1 $matkul $kelas");
	$jumlah = $count->rowCount();



	$sukses_count = 0;
	$sukses_msg = '';
	$error_count = 0;
	$error = array();


$error_kelas= "";

		$options = array(
		    'filename' => $_GET['jurusan'].'_progress.json',
		    'autoCalc' => true,
		    'totalStages' => 1
		);
		$new_pu = new Manticorp\ProgressUpdater($options);
	

	$data = $db->query("select kelas_kuliah.id as id_kelas,kelas_kuliah.*,jurusan.kode_jurusan,jurusan.id_sms from kelas_kuliah inner join jurusan on kelas_kuliah.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and kelas_kuliah.semester='".$_GET['sem']."' and status_error!=1 $matkul $kelas limit 0,$jumlah");

			//let's push first page

			$stageOptions = array(
			    'name' => 'Page $i',
			    'message' => 'Some Message',
			    'totalItems' => $jumlah,
			);

			$new_pu->nextStage($stageOptions);

			foreach ($data as $value) {

		$kode_mk = trim($value->kode_mk);

		$semester = $value->semester;
		$kelas = trim($value->nama_kelas);
		$nama_mk = trim($value->nama_mk);
	
		
		$id_sms = $value->id_sms;


		$filter_mk = "p.id_sms='".$id_sms."' and trim(kode_mk)='".$kode_mk."'";

		$temp_mk = $proxy->GetRecord($token,'mata_kuliah',$filter_mk);

		$count_mk = $proxy->GetCountRecordset($token,'mata_kuliah',$filter_mk);

		if ($count_mk['result']<2) {
			$temp_mk = $proxy->GetRecord($token,'mata_kuliah',$filter_mk);
			if ($temp_mk['result']) {
				$id_mk = $temp_mk['result']['id_mk'];
				$sks_mk = $temp_mk['result']['sks_mk'];
				$sks_tm = $temp_mk['result']['sks_tm'];
				if ($temp_mk['result']['sks_prak']=="") {
					$sks_prak = 0;
				} else {
					$sks_prak = $temp_mk['result']['sks_prak'];
				}

				if ($temp_mk['result']['sks_prak_lap']=="") {
					$sks_prak_lap = 0;
				} else {
					$sks_prak_lap = $temp_mk['result']['sks_prak_lap'];
				}

				if ($temp_mk['result']['sks_tm']=="") {
					$sks_tm = 0;
				} else {
					$sks_tm = $temp_mk['result']['sks_tm'];
				}


				if ($temp_mk['result']['sks_sim']=="") {
					$sks_sim = 0;
				} else {
					$sks_sim = $temp_mk['result']['sks_sim'];
				}


			} else {
					$filter_mk = "trim(kode_mk)='".$kode_mk."'";
					$temp_mk = $proxy->GetRecord($token,'mata_kuliah',$filter_mk);
					if ($temp_mk['result']) {
							$id_mk = $temp_mk['result']['id_mk'];
							$sks_mk = $temp_mk['result']['sks_mk'];
							$sks_tm = $temp_mk['result']['sks_tm'];
							if ($temp_mk['result']['sks_prak']=="") {
								$sks_prak = 0;
							} else {
								$sks_prak = $temp_mk['result']['sks_prak'];
							}

							if ($temp_mk['result']['sks_prak_lap']=="") {
								$sks_prak_lap = 0;
							} else {
								$sks_prak_lap = $temp_mk['result']['sks_prak_lap'];
							}

							if ($temp_mk['result']['sks_tm']=="") {
								$sks_tm = 0;
							} else {
								$sks_tm = $temp_mk['result']['sks_tm'];
							}


							if ($temp_mk['result']['sks_sim']=="") {
								$sks_sim = 0;
							} else {
								$sks_sim = $temp_mk['result']['sks_sim'];
							}
					} else {
						$error_mk = "Kode MK $kode_mk tidak ditemukan di Feeder";
					}
					
			}
			
		} else {
			$sanitize_mk = addslashes($dt->nama_mk);
			$filter_mk2 = "p.id_sms='".$id_sms."' and trim(kode_mk)='".$kode_mk."' and nm_mk like E'%$sanitize_mk%'";
			$temp_mk = $proxy->GetRecord($token,'mata_kuliah',$filter_mk2);

			if ($temp_mk['result']) {
				$id_mk = $temp_mk['result']['id_mk'];
				$sks_mk = $temp_mk['result']['sks_mk'];
				$sks_tm = $temp_mk['result']['sks_tm'];
				if ($temp_mk['result']['sks_prak']=="") {
					$sks_prak = 0;
				} else {
					$sks_prak = $temp_mk['result']['sks_prak'];
				}

				if ($temp_mk['result']['sks_prak_lap']=="") {
					$sks_prak_lap = 0;
				} else {
					$sks_prak_lap = $temp_mk['result']['sks_prak_lap'];
				}

				if ($temp_mk['result']['sks_tm']=="") {
					$sks_tm = 0;
				} else {
					$sks_tm = $temp_mk['result']['sks_tm'];
				}


				if ($temp_mk['result']['sks_sim']=="") {
					$sks_sim = 0;
				} else {
					$sks_sim = $temp_mk['result']['sks_sim'];
				}


			} else {
					$sanitize_mk = addslashes($dt->nama_mk);
					$filter_mk2 = "trim(kode_mk)='".$kode_mk."' and nm_mk like E'%$sanitize_mk%'";
					$temp_mk = $proxy->GetRecord($token,'mata_kuliah',$filter_mk2);
					
					if ($temp_mk['result']) {
							$id_mk = $temp_mk['result']['id_mk'];
							$sks_mk = $temp_mk['result']['sks_mk'];
							$sks_tm = $temp_mk['result']['sks_tm'];
							if ($temp_mk['result']['sks_prak']=="") {
								$sks_prak = 0;
							} else {
								$sks_prak = $temp_mk['result']['sks_prak'];
							}

							if ($temp_mk['result']['sks_prak_lap']=="") {
								$sks_prak_lap = 0;
							} else {
								$sks_prak_lap = $temp_mk['result']['sks_prak_lap'];
							}

							if ($temp_mk['result']['sks_tm']=="") {
								$sks_tm = 0;
							} else {
								$sks_tm = $temp_mk['result']['sks_tm'];
							}


							if ($temp_mk['result']['sks_sim']=="") {
								$sks_sim = 0;
							} else {
								$sks_sim = $temp_mk['result']['sks_sim'];
							}
					} else {
						$error_mk = "Kode MK $kode_mk tidak ditemukan di Feeder";
					}
					
			}

/*			$error_mk = "Kode MK $kode_mk lebih dari satu di feeder. silakan hapus atau rename salah satu Kode MK ini di Feeder";*/
		}

if ($id_mk!="" && $error_mk=="" && $error_kelas=="") {
				$temp_data = array(
					'id_sms' => $id_sms,
					'id_smt' => $value->semester,
					'id_mk' => $id_mk,
					'nm_kls' => $value->nama_kelas,
					'sks_mk' => $sks_mk,
					'sks_tm' => $sks_tm,
				    'sks_prak' => $sks_prak,
			   		'sks_prak_lap' => $sks_prak_lap,
					'sks_sim' => $sks_sim,
					'bahasan_case' => $value->bahasan_case,
					'tgl_mulai_koas' => $value->tgl_mulai_koas,
					'tgl_selesai_koas' => $value->tgl_selesai_koas 
					);

	$temp_result = $proxy->InsertRecord($token, $table1, json_encode($temp_data));

	
	if ($temp_result['result']['error_desc']==NULL) {
		$sukses_count++;
		$db->update('kelas_kuliah',array('status_error'=>1,'keterangan'=>''),'id',$value->id_kelas);
	} else {
				++$error_count;
				$db->update('kelas_kuliah',array('status_error' => 2, 'keterangan'=>"Error ".$temp_result['result']['error_desc']),'id',$value->id_kelas);
				$error_msg[] = "Error ".$temp_result['result']['error_desc'];
			}

		} else {
				++$error_count;
				$db->update('kelas_kuliah',array('status_error' => 2, 'keterangan'=>"Error $error_kelas $error_mk"),'id',$value->id_kelas);
				$error_msg[] = "Error $error_kelas $error_mk";
		}

	$new_pu->incrementStageItems(1, true);
		$id_mk = "";
		$error_mk = "";

		}

$msg = '';
if ((!$sukses_count==0) || (!$error_count==0)) {
	$msg =  "<div class=\"alert alert-warning\" role=\"alert\">
			<font color=\"#3c763d\">".$sukses_count." data Kelas baru berhasil ditambah</font><br />
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
