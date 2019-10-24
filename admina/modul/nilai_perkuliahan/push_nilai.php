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
		$error_krs = "";

	$query_matkul = '';
	$query_kelas = '';

	if ($_GET['matkul']!='all') {
		$query_matkul = "and kode_mk='".$_GET['matkul']."'";
	}
	if ($_GET['kelas']!='all') {
		$query_kelas  = "and nama_kelas='".$_GET['kelas']."'";
	}
	
	
	$id_sp = $config->id_sp;


	$count = $db->query("select *,nilai.id as id_krs from nilai inner join jurusan on nilai.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and nilai.semester='".$_GET['sem']."' and status_error!=1 $query_matkul $query_kelas");
	$jumlah = $count->rowCount();



	$sukses_count = 0;
	$sukses_msg = '';
	$error_count = 0;
	$error = array();



	if ($jumlah>=500) {
		
		if ($jumlah%500==0) {
			$bagi = ($jumlah%500);
			$total = ceil($jumlah/500)+1;
		} else {
			$total = ceil($jumlah/500);
			$bagi = $jumlah%500;
		}


		$options = array(
		    'filename' => $_GET['jurusan'].'_progress.json',
		    'autoCalc' => true,
		    'totalStages' => $total
		);
		$pu = new Manticorp\ProgressUpdater($options);

		for ($i=0; $i <$total ; $i++) { 
		if ($i==0) {

			$data = $db->query("select *,nilai.id as id_krs from nilai inner join jurusan on nilai.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and nilai.semester='".$_GET['sem']."' and status_error!=1 $query_matkul $query_kelas limit $i,500");

			//let's push first page
			$stageOptions = array(
			    'name' => 'Page $i',
			    'message' => 'Some Message',
			    'totalItems' => 500,
			);

			$pu->nextStage($stageOptions);

			foreach ($data as $value) {

				$nim = trim($value->nim);
				$kode_mk = trim($value->kode_mk);
				$kelas = trim($value->nama_kelas);
		$nama_mk = trim($value->nama_mk); 
		$semester = $value->semester;

		$id_sms = $value->id_sms;

				$filter_pd = "trim(nipd)='".$nim."'";
		$temp_pd = $proxy->GetRecord($token,'mahasiswa_pt',$filter_pd);
		$tot_regpd = count($temp_pd['result']);
		if ($temp_pd['result']) {
			$id_reg_pd = $temp_pd['result']['id_reg_pd'];

			$filter_kls = "p.id_sms='$id_sms' and trim(kode_mk)='".$kode_mk."' AND trim(nm_kls)='".$kelas."' AND p.id_smt='".$semester."'";
				$temp_kls = $proxy->GetRecord($token,$table1,$filter_kls);
				if ($temp_kls['result']) {
					$id_kls = $temp_kls['result']['id_kls'];
					$error_kelas = "";
					$cek_krs = "p.id_kls='$id_kls' AND p.id_reg_pd='$id_reg_pd'";
					$temp_krs = $proxy->GetRecord($token,'nilai',$cek_krs);
					if (!empty($temp_krs['result'])) {
						$error_krs = "";
					} else {
						$error_krs = "Pastikan Mahasiswa ini sudah melakukan KRS";
					}

				} else {
					$id_kls = "";
					$error_kelas = "Pastikan Kelas sudah dibuat";
				}

		} else {
			$id_reg_pd = "";
			$error_nim = "Mahasiswa dengan Nim ini tidak ada di feeder";
		}



		if ($id_reg_pd!="" && $error_krs=="" && $id_kls!="") {
			$filter_check_exist = "p.id_kls='".$id_kls."' AND p.id_reg_pd='".$id_reg_pd."'";
			$check_krs = $proxy->GetRecord($token,'nilai',$filter_check_exist);
			if ($check_krs['result']) {
							//inisial data
				$temp_key = array(
					'id_kls' => $id_kls,
					'id_reg_pd' => $id_reg_pd
				);
				$temp_data = array(
					'nilai_angka' => $value->nilai_angka,
					'nilai_huruf' => $value->nilai_huruf,
					'nilai_indeks' => $value->nilai_indek
				);
				$array_nilai = array('key'=>$temp_key,'data'=>$temp_data);

				//Jika Kelas kuliah terdaftar.
				$temp_result = $proxy->UpdateRecord($token,'nilai',json_encode($array_nilai));

				if ($temp_result['result']['error_desc']==NULL) {
					++$sukses_count;
					$db->update('nilai',array('status_error'=>1,'keterangan'=>''),'id',$value->id_krs);
				} else {
					++$error_count;
					$error_msg[] = $temp_result['result']['error_desc'];
					$db->update('nilai',array('status_error' => 2, 'keterangan'=>$temp_result['result']['error_desc']),'id',$value->id_krs);
				}
			} else {
					++$error_count;
					$error_msg[] = "Pastikan Mahasiswa ini sudah melakukan krs";
					$db->update('nilai',array('status_error' => 2, 'keterangan'=>"Pastikan Mahasiswa ini sudah melakukan krs"),'id',$value->id_krs);
			}
		} else {
				++$error_count;
				$error_msg[] = "$error_nim $error_krs $error_kelas";
				$db->update('nilai',array('status_error' => 2, 'keterangan'=>"$error_nim $error_krs $error_kelas"),'id',$value->id_krs);
		}


				$pu->incrementStageItems(1, true);


	}

		} else if ($i == $total - 1) {
		
      
	 		$data = $db->query("select *,nilai.id as id_krs from nilai inner join jurusan on nilai.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and nilai.semester='".$_GET['sem']."' and status_error!=1 $query_matkul $query_kelas limit ".($i*500).",$bagi");
			//let's push first page
			$stageOptions = array(
			    'name' => 'Page $i',
			    'message' => 'Some Message',
			    'totalItems' => $bagi,
			);

			$pu->nextStage($stageOptions);

			foreach ($data as $value) {
				$nim = trim($value->nim);
				$kode_mk = trim($value->kode_mk);
				$kelas = trim($value->nama_kelas);
		
		$semester = $value->semester;

	
		$id_sms = $value->id_sms;

				$filter_pd = "trim(nipd)='".$nim."'";
		$temp_pd = $proxy->GetRecord($token,'mahasiswa_pt',$filter_pd);
		$tot_regpd = count($temp_pd['result']);
		if ($temp_pd['result']) {
			$id_reg_pd = $temp_pd['result']['id_reg_pd'];

			$filter_kls = "p.id_sms='$id_sms' and trim(kode_mk)='".$kode_mk."' AND trim(nm_kls)='".$kelas."' AND p.id_smt='".$semester."'";
				$temp_kls = $proxy->GetRecord($token,$table1,$filter_kls);
				if ($temp_kls['result']) {
					$id_kls = $temp_kls['result']['id_kls'];
					$error_kelas = "";
					$cek_krs = "p.id_kls='$id_kls' AND p.id_reg_pd='$id_reg_pd'";
					$temp_krs = $proxy->GetRecord($token,'nilai',$cek_krs);
					if (!empty($temp_krs['result'])) {
						$error_krs = "";
					} else {
						$error_krs = "Pastikan Mahasiswa ini sudah melakukan KRS";
					}

				} else {
					$id_kls = "";
					$error_kelas = "Pastikan Kelas sudah dibuat";
				}

		} else {
			$id_reg_pd = "";
			$error_nim = "Mahasiswa dengan Nim ini tidak ada di feeder";
		}



		if ($id_reg_pd!="" && $error_krs=="" && $id_kls!="") {
			$filter_check_exist = "p.id_kls='".$id_kls."' AND p.id_reg_pd='".$id_reg_pd."'";
			$check_krs = $proxy->GetRecord($token,'nilai',$filter_check_exist);
			if ($check_krs['result']) {
							//inisial data
				$temp_key = array(
					'id_kls' => $id_kls,
					'id_reg_pd' => $id_reg_pd
				);
				$temp_data = array(
					'nilai_angka' => $value->nilai_angka,
					'nilai_huruf' => $value->nilai_huruf,
					'nilai_indeks' => $value->nilai_indek
				);
				$array_nilai = array('key'=>$temp_key,'data'=>$temp_data);

				//Jika Kelas kuliah terdaftar.
				$temp_result = $proxy->UpdateRecord($token,'nilai',json_encode($array_nilai));

				if ($temp_result['result']['error_desc']==NULL) {
					++$sukses_count;
					$db->update('nilai',array('status_error'=>1,'keterangan'=>''),'id',$value->id_krs);
				} else {
					++$error_count;
					$error_msg[] = $temp_result['result']['error_desc'];
					$db->update('nilai',array('status_error' => 2, 'keterangan'=>$temp_result['result']['error_desc']),'id',$value->id_krs);
				}
			} else {
					++$error_count;
					$error_msg[] = "Pastikan Mahasiswa ini sudah melakukan krs";
					$db->update('nilai',array('status_error' => 2, 'keterangan'=>"Pastikan Mahasiswa ini sudah melakukan krs"),'id',$value->id_krs);
			}
		} else {
				++$error_count;
				$error_msg[] = "$error_nim $error_krs $error_kelas";
				$db->update('nilai',array('status_error' => 2, 'keterangan'=>"$error_nim $error_krs $error_kelas"),'id',$value->id_krs);
		}
				$pu->incrementStageItems(1, true);
				


		}

        	$total_record = ($i*500+$bagi);
    	}
  	  else if($i != $total - 1 && $i!=0) {
			
		
	 		$data = $db->query("select *,nilai.id as id_krs from nilai inner join jurusan on nilai.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and nilai.semester='".$_GET['sem']."' and status_error!=1 $query_matkul $query_kelas limit ".($i*500).",500");
			//let's push first page
			$stageOptions = array(
			    'name' => 'Page $i',
			    'message' => 'Some Message',
			    'totalItems' => 500,
			);

			$pu->nextStage($stageOptions);

			foreach ($data as $value) {

				$nim = trim($value->nim);
				$kode_mk = trim($value->kode_mk);
				$kelas = trim($value->nama_kelas);
		$semester = $value->semester;

		$id_sms = $value->id_sms;

		$filter_pd = "trim(nipd)='".$nim."'";
		$temp_pd = $proxy->GetRecord($token,'mahasiswa_pt',$filter_pd);
		$tot_regpd = count($temp_pd['result']);
		if ($temp_pd['result']) {
			$id_reg_pd = $temp_pd['result']['id_reg_pd'];

			$filter_kls = "p.id_sms='$id_sms' and trim(kode_mk)='".$kode_mk."' AND trim(nm_kls)='".$kelas."' AND p.id_smt='".$semester."'";
				$temp_kls = $proxy->GetRecord($token,$table1,$filter_kls);
				if ($temp_kls['result']) {
					$id_kls = $temp_kls['result']['id_kls'];
					$error_kelas = "";
					$cek_krs = "p.id_kls='$id_kls' AND p.id_reg_pd='$id_reg_pd'";
					$temp_krs = $proxy->GetRecord($token,'nilai',$cek_krs);
					if (!empty($temp_krs['result'])) {
						$error_krs = "";
					} else {
						$error_krs = "Pastikan Mahasiswa ini sudah melakukan KRS";
					}

				} else {
					$id_kls = "";
					$error_kelas = "Pastikan Kelas sudah dibuat";
				}

		} else {
			$id_reg_pd = "";
			$error_nim = "Mahasiswa dengan Nim ini tidak ada di feeder";
		}



		if ($id_reg_pd!="" && $error_krs=="" && $id_kls!="") {
			$filter_check_exist = "p.id_kls='".$id_kls."' AND p.id_reg_pd='".$id_reg_pd."'";
			$check_krs = $proxy->GetRecord($token,'nilai',$filter_check_exist);
			if ($check_krs['result']) {
							//inisial data
				$temp_key = array(
					'id_kls' => $id_kls,
					'id_reg_pd' => $id_reg_pd
				);
				$temp_data = array(
					'nilai_angka' => $value->nilai_angka,
					'nilai_huruf' => $value->nilai_huruf,
					'nilai_indeks' => $value->nilai_indek
				);
				$array_nilai = array('key'=>$temp_key,'data'=>$temp_data);

				//Jika Kelas kuliah terdaftar.
				$temp_result = $proxy->UpdateRecord($token,'nilai',json_encode($array_nilai));

				if ($temp_result['result']['error_desc']==NULL) {
					++$sukses_count;
					$db->update('nilai',array('status_error'=>1,'keterangan'=>''),'id',$value->id_krs);
				} else {
					++$error_count;
					$error_msg[] = $temp_result['result']['error_desc'];
					$db->update('nilai',array('status_error' => 2, 'keterangan'=>$temp_result['result']['error_desc']),'id',$value->id_krs);
				}
			} else {
					++$error_count;
					$error_msg[] = "Pastikan Mahasiswa ini sudah melakukan krs";
					$db->update('nilai',array('status_error' => 2, 'keterangan'=>"Pastikan Mahasiswa ini sudah melakukan krs"),'id',$value->id_krs);
			}
		} else {
				++$error_count;
				$error_msg[] = "$error_nim $error_krs $error_kelas";
				$db->update('nilai',array('status_error' => 2, 'keterangan'=>"$error_nim $error_krs $error_kelas"),'id',$value->id_krs);
		}
				$pu->incrementStageItems(1, true);


		}
		}
		
		}

		$msg = '';
		if ((!$sukses_count==0) || (!$error_count==0)) {
			$msg =  "<div class=\"alert alert-warning \" role=\"alert\">
					<font color=\"#3c763d\">".$sukses_count." data Nilai baru berhasil di kirim ke feeder</font><br />
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

		$pu->totallyComplete($msg);

	} else {

		$options = array(
		    'filename' => $_GET['jurusan'].'_progress.json',
		    'autoCalc' => true,
		    'totalStages' => 1
		);
		$new_pu = new Manticorp\ProgressUpdater($options);

	
	 	$data = $db->query("select *,nilai.id as id_krs from nilai inner join jurusan on nilai.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and nilai.semester='".$_GET['sem']."' and status_error!=1 $query_matkul $query_kelas limit 0,$jumlah");
			//let's push first page

			$stageOptions = array(
			    'name' => 'Page $i',
			    'message' => 'Some Message',
			    'totalItems' => $jumlah,
			);

			$new_pu->nextStage($stageOptions);

			foreach ($data as $value) {

				$nim = trim($value->nim);
				$kode_mk = trim($value->kode_mk);
				$kelas = trim($value->nama_kelas);
		$nama_mk = trim($value->nama_mk); 
		$semester = $value->semester;

		$id_sms = $value->id_sms;

			$filter_pd = "trim(nipd)='".$nim."'";
		$temp_pd = $proxy->GetRecord($token,'mahasiswa_pt',$filter_pd);
		$tot_regpd = count($temp_pd['result']);
		if ($temp_pd['result']) {
			$id_reg_pd = $temp_pd['result']['id_reg_pd'];

			$filter_kls = "p.id_sms='$id_sms' and trim(kode_mk)='".$kode_mk."' AND trim(nm_kls)='".$kelas."' AND p.id_smt='".$semester."'";
				$temp_kls = $proxy->GetRecord($token,$table1,$filter_kls);
				if ($temp_kls['result']) {
					$id_kls = $temp_kls['result']['id_kls'];
					$error_kelas = "";
					$cek_krs = "p.id_kls='$id_kls' AND p.id_reg_pd='$id_reg_pd'";
					$temp_krs = $proxy->GetRecord($token,'nilai',$cek_krs);
					if (!empty($temp_krs['result'])) {
						$error_krs = "";
					} else {
						$error_krs = "Pastikan Mahasiswa ini sudah melakukan KRS";
					}

				} else {
					$id_kls = "";
					$error_kelas = "Pastikan Kelas sudah dibuat";
				}

		} else {
			$id_reg_pd = "";
			$error_nim = "Mahasiswa dengan Nim ini tidak ada di feeder";
		}



		if ($id_reg_pd!="" && $error_krs=="" && $id_kls!="") {

			$filter_check_exist = "p.id_kls='".$id_kls."' AND p.id_reg_pd='".$id_reg_pd."'";
			$check_krs = $proxy->GetRecord($token,'nilai',$filter_check_exist);
			if ($check_krs['result']) {
							//inisial data
				$temp_key = array(
					'id_kls' => $id_kls,
					'id_reg_pd' => $id_reg_pd
				);
				$temp_data = array(
					'nilai_angka' => $value->nilai_angka,
					'nilai_huruf' => $value->nilai_huruf,
					'nilai_indeks' => $value->nilai_indek
				);
				$array_nilai = array('key'=>$temp_key,'data'=>$temp_data);

				//Jika Kelas kuliah terdaftar.
				$temp_result = $proxy->UpdateRecord($token,'nilai',json_encode($array_nilai));

				if ($temp_result['result']['error_desc']==NULL) {
					++$sukses_count;
					$db->update('nilai',array('status_error'=>1,'keterangan'=>''),'id',$value->id_krs);
				} else {
					++$error_count;
					$error_msg[] = $temp_result['result']['error_desc'];
					$db->update('nilai',array('status_error' => 2, 'keterangan'=>$temp_result['result']['error_desc']),'id',$value->id_krs);
				}
			} else {
					++$error_count;
					$error_msg[] = "Pastikan Mahasiswa ini sudah melakukan krs";
					$db->update('nilai',array('status_error' => 2, 'keterangan'=>"Pastikan Mahasiswa ini sudah melakukan krs"),'id',$value->id_krs);
			}


		} else {
				++$error_count;
				$error_msg[] = "$error_nim $error_krs $error_kelas";
				$db->update('nilai',array('status_error' => 2, 'keterangan'=>"$error_nim $error_krs $error_kelas"),'id',$value->id_krs);
		}

				$new_pu->incrementStageItems(1, true);


		}

		$msg = '';
		if ((!$sukses_count==0) || (!$error_count==0)) {
			$msg =  "<div class=\"alert alert-warning \" role=\"alert\">
					<font color=\"#3c763d\">".$sukses_count." data Nilai baru berhasil di kirim ke feeder</font><br />
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


	}

