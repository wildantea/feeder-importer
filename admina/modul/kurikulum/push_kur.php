<?php
//include "inc/config.php";
include "../../lib/nusoap/nusoap.php";

include "../../inc/config.php";

include "../../lib/prosesupdate/ProgressUpdater.php";

$url = $db->get_service_url('soap');
$token = $db->get_token();
$client = new nusoap_client($url, true);
$proxy = $client->getProxy();
//$token = 'acdbbc82c3b29f99e9096dab1d5eafb4';


	$id_sms = '';
	$id_mk = '';
	$nidn = '';
	$id_ptk = '';
	$sks_mk = '';
	$sks_tm = '';
	$sks_prak = '';
	$sks_prak_lap = '';
	$sks_sim = '';
	$temp_data = array();
	$sukses_count = 0;
	$sukses_count_mat = 0;
	$sukses_count_kur = 0;
	$sukses_msg = '';
	$error_count = 0;
	$error_count_mat = 0;
	$error_count_kur = 0;
	$error_msg = array();
	$error_msg_mat = array();
	$error_msg_kur = array();
	$in_mat_kurs = array();


	$arr_data = $db->query("select kurikulum.*,jurusan.kode_jurusan,jurusan.id_sms,id_jenj_didik from kurikulum inner join jurusan on kurikulum.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and kurikulum.id='".$_GET['tahun']."'");






$i=1;



	foreach ($arr_data as $value) {

		

	//	print_r($value);
		$nama_kurikulum = $value->nama_kur;
		$jml_sks_wajib = $value->jml_sks_wajib;
		$jml_sks_pilihan = $value->jml_sks_pilihan;
		$id_sms = $value->id_sms;
		$id_jenj_didik = $value->id_jenj_didik;
	
		$mulai_berlaku = $value->mulai_berlaku;
		$kode_prodi = $value->kode_jurusan;

		$filter_check = "id_sms='".$id_sms."' and id_jenj_didik='".$id_jenj_didik."' and id_smt='".$mulai_berlaku."' and soft_delete='0'";
			$temp_check = $proxy->GetRecord($token,'kurikulum',$filter_check);

			if ($temp_check['result']) {
			$id_kur = $temp_check['result']['id_kurikulum_sp'];
			$error_msg_kur[] = "<b>Error Kurikulum ini Sudah Ada di Feeder</b>";
			$db->update('kurikulum',array('status_error' => 2, 'keterangan'=>"Kurikulum sudah ada di Feeder"),'id',$value->id);
				++$error_count_kur;
			} else {
					//var_dump($temp_kls['result']);
			$temp_data = array(
				'nm_kurikulum_sp' => $nama_kurikulum,
				'jml_sks_wajib' => $jml_sks_wajib,
				'jml_sks_pilihan' => $jml_sks_pilihan,
				'jml_sks_lulus' => $jml_sks_wajib+$jml_sks_pilihan,
				'id_smt' => $mulai_berlaku,
				'id_jenj_didik' => $id_jenj_didik,
				'id_sms' => $id_sms,
				);

			$insert_kur = $proxy->InsertRecord($token, "kurikulum", json_encode($temp_data));

			if ($insert_kur['result']['error_desc']==NULL) {
				$id_kur = $insert_kur['result']['id_kurikulum_sp'];
				$db->update('kurikulum',array('status_error'=>1,'keterangan'=>''),'id',$value->id);
				++$sukses_count_kur;
			} else {
				$error_msg_kur[] = "<b>Error ".$insert_kur['result']['error_desc'];
				$db->update('kurikulum',array('status_error' => 2, 'keterangan'=>"Error ".$insert_kur['result']['error_desc']),'id',$value->id);
				++$error_count_kur;
			}
			
		}
		$id_kurikulum = $id_kur;

		$wajib = '';

		$mats = $db->query("select kurikulum.*,mat_kurikulum.*,mat_kurikulum.id as id_mat, jurusan.kode_jurusan,id_sms,id_jenj_didik from kurikulum 
inner join jurusan on kurikulum.kode_jurusan=jurusan.kode_jurusan 
inner join mat_kurikulum on kurikulum.id=mat_kurikulum.id_kurikulum where id_kurikulum='$value->id' and mat_kurikulum.status_error!=1");
		$options = array(
	    'filename' => $_GET['jurusan'].'_progress.json',
	    'autoCalc' => true,
	    'totalStages' => 1
		);
		$pu = new Manticorp\ProgressUpdater($options);




		
		$stageOptions = array(
		    'name' => 'This AJAX process takes a long time',
		    'message' => 'But this will keep the user updated on it\'s actual progress!',
		    'totalItems' => $mats->rowCount(),
		);


		$pu->nextStage($stageOptions);

		foreach ($mats as $dt) {

			$jmlsks_mk=$dt->sks_tm+$dt->sks_prak+$dt->sks_prak_lap+$dt->sks_sim;
			$wajib = $dt->jns_mk;
				//check if wajib 
				if ($dt->jns_mk=='A' or $dt->jns_mk=='W') {
					$wajib_mat = 1;
				} else {
					$wajib_mat = 0;
				}

if ($jmlsks_mk>9) {
			++$error_count;
			$db->update('mat_kurikulum',array('status_error' => 2, 'keterangan'=>"Error Jumlah SKS > 9"),'id',$dt->id_mat);
			$error_msg[] = "Jumlah SKS > 9";
		} elseif ($jmlsks_mk<1) {
			++$error_count;
			$db->update('mat_kurikulum',array('status_error' => 2, 'keterangan'=>"Error Total Jumlah SKS tidak boleh 0"),'id',$dt->id_mat);
			$error_msg[] = "Total Jumlah SKS tidak boleh 0";
		} else {
				$filter_check = "p.id_sms='".$dt->id_sms."' and p.id_jenj_didik='".$dt->id_jenj_didik."' and trim(p.kode_mk)='".trim($dt->kode_mk)."'";
				$temp_check = $proxy->GetRecord($token,'mata_kuliah',$filter_check);

			if ($temp_check['result']) {
				$id_mk = $temp_check['result']['id_mk'];
				$jmlsks_mk= $temp_check['result']['sks_mk'];
				++$error_count;
				$error_msg[] = "Matakuliah $dt->kode_mk $dt->nama_mk sudah ada di Feeder";
				$db->update('mat_kurikulum',array('status_error' => 2, 'keterangan'=>"Matakuliah ini sudah ada di Feeder"),'id',$dt->id_mat);
				//check ke matakuliah kurikulum jika sudah ada pula
				$filter_check_mat = "p.id_kurikulum_sp='".$id_kurikulum."' and p.id_mk='".$id_mk."'";
				$temp_checks = $proxy->GetRecord($token,'mata_kuliah_kurikulum',$filter_check_mat);

				if (empty($temp_checks['result'])) {
					//insert to matkul kurikulum
					$in_mat_kur = array(
						'id_kurikulum_sp' => $id_kurikulum,
						'id_mk' => $id_mk,
						'smt' => $dt->semester,
						'sks_mk' => $jmlsks_mk,
						'sks_tm' =>$dt->sks_tm,
					    'sks_prak' =>  $dt->sks_prak,
				   		'sks_prak_lap' =>$dt->sks_prak_lap,
						'sks_sim' => $dt->sks_sim,
						'a_wajib' => $wajib_mat
						);

					$insert_mat_kur = $proxy->InsertRecord($token, "mata_kuliah_kurikulum", json_encode($in_mat_kur));

						if ($insert_mat_kur['result']['error_desc']==NULL) {
							++$sukses_count_mat;
						} else {
							++$error_count_mat;
							$error_msg_mat[] = "Error, Matakuliah Kurikulum $dt->kode_mk ,".$insert_mat_kur['result']['error_desc'];
						}
				} 

			} else {
					
				$data = array(
				'id_sms' => $dt->id_sms,
				'id_jenj_didik' => $dt->id_jenj_didik,
		        'kode_mk' => $dt->kode_mk,
		        'nm_mk' => $dt->nama_mk,
		        'jns_mk' => $wajib,
		        'sks_mk' => $jmlsks_mk,
		        'sks_tm' => $dt->sks_tm,
		        'sks_prak' => $dt->sks_prak,
		        'sks_prak_lap' => $dt->sks_prak_lap,
		        'sks_sim' => $dt->sks_sim,
		        'metode_pelaksanaan_kuliah' => $dt->metode_pelaksanaan_kuliah,
			    'tgl_mulai_efektif' => $dt->tgl_mulai_efektif,
				'tgl_akhir_efektif' => $dt->tgl_akhir_efektif,
		        );



				//insert matakuliah
				$in_mat = $proxy->InsertRecord($token, "mata_kuliah", json_encode($data));
				if ($in_mat['result']['error_desc']==NULL) {
					$id_mk = $in_mat['result']['id_mk'];
					++$sukses_count;
					$db->update('mat_kurikulum',array('status_error'=>1,'keterangan'=>''),'id',$dt->id_mat);
						//mat kur for second access
		        		$in_mat_kurs = array(
						'id_kurikulum_sp' => $id_kurikulum,
						'id_mk' => $id_mk,
						'smt' => $dt->semester,
						'sks_mk' => $jmlsks_mk,
						'sks_tm' =>$dt->sks_tm,
					    'sks_prak' =>  $dt->sks_prak,
				   		'sks_prak_lap' =>$dt->sks_prak_lap,
						'sks_sim' => $dt->sks_sim,
						'a_wajib' => $wajib_mat
						);
					$insert_mat_kur = $proxy->InsertRecord($token, "mata_kuliah_kurikulum", json_encode($in_mat_kurs));

						if ($insert_mat_kur['result']['error_desc']==NULL) {
							++$sukses_count_mat;
						} else {
							++$error_count_mat;
							$error_msg_mat[] = "Error, Matakuliah Kurikulum $dt->kode_mk ,".$insert_mat_kur['result']['error_desc'];
						}
				} else {
					++$error_count_mat;
					$error_msg_mat[] = "Error, ".$in_mat['result']['error_desc'];
				}



		}

	}

			 $pu->incrementStageItems(1, true);
		}

	$i++;

	}


$msg_kur = '';
if ((!$sukses_count_kur==0) || (!$error_count_kur==0)) {
	$msg_kur =  "<div class=\"alert alert-warning\" role=\"alert\">
			<font color=\"#3c763d\">".$sukses_count_kur." data Kurikulum baru berhasil ditambah</font><br />
			<font color=\"#ce4844\" >".$error_count_kur." data tidak bisa ditambahkan </font>";
			if (!$error_count_kur==0) {
				$msg_kur .= "<a data-toggle=\"collapse\" href=\"#collapseExample\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail error</a>";
			}
			//echo "<br />Total: ".$i." baris data";
			$msg_kur .= "<div class=\"collapse\" id=\"collapseExample\">";
					$i=1;
					foreach ($error_msg_kur as $pesan) {
							$msg_kur .= "<div class=\"bs-callout bs-callout-danger\">".$i.". ".$pesan."</div><br />";
						$i++;
						}
			$msg_kur .= "</div>
		</div>";
}

$msg='';
if ((!$sukses_count==0) || (!$error_count==0)) {
	$msg =  "<div class=\"alert alert-warning\" role=\"alert\">
			<font color=\"#3c763d\">".$sukses_count." data Matakuliah baru berhasil ditambah</font><br />
			<font color=\"#ce4844\" >".$error_count." data tidak bisa ditambahkan </font>";
			if (!$error_count==0) {
				$msg .= "<a data-toggle=\"collapse\" href=\"#collapseExamples\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail error</a>";
			}
			//echo "<br />Total: ".$i." baris data";
			$msg .= "<div class=\"collapse\" id=\"collapseExamples\">";
					$i=1;
					foreach ($error_msg as $pesan) {
							$msg .= "<div class=\"bs-callout bs-callout-danger\">".$i.". ".$pesan."</div><br />";
						$i++;
						}
			$msg .= "</div>
		</div>";
}

$msg_mat = '';
if ((!$sukses_count_mat==0) || (!$error_count_mat==0)) {
	$msg_mat =  "<div class=\"alert alert-warning\" role=\"alert\">
			<font color=\"#3c763d\">".$sukses_count_mat." data Matakuliah baru berhasil ditambah ke kurikulum</font><br />
			<font color=\"#ce4844\" >".$error_count_mat." data tidak bisa ditambahkan </font>";
			if (!$error_count_mat==0) {
				$msg_mat .= "<a data-toggle=\"collapse\" href=\"#collapseExampled\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail error</a>";
			}
			//echo "<br />Total: ".$i." baris data";
			$msg_mat .= "<div class=\"collapse\" id=\"collapseExampled\">";
					$i=1;
					foreach ($error_msg_mat as $pesan) {
							$msg_mat .= "<div class=\"bs-callout bs-callout-danger\">".$i.". ".$pesan."</div><br />";
						$i++;
						}
			$msg_mat .= "</div>
		</div>";
}



$pu->totallyComplete($msg_kur.$msg.$msg_mat);


