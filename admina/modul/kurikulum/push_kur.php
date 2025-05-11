<?php
include "../../inc/config.php";
include "../../lib/prosesupdate/ProgressUpdater.php";

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

		$filter_check = "id_prodi='".$id_sms."' and id_semester='".$mulai_berlaku."'";
				$data_param = array(
					'act' => 'GetListKurikulum',
					'token' => get_token(),
					'filter' => $filter_check
				);
				$temp_check = service_request($data_param);



			if (!empty($temp_check->data)) {
			$id_kur = $temp_check->data[0]->id_kurikulum;
			$error_msg_kur[] = "<b>Error Kurikulum ini Sudah Ada di Feeder</b>";
			$db->update('kurikulum',array('status_error' => 2, 'keterangan'=>"Kurikulum sudah ada di Feeder"),'id',$value->id);
				++$error_count_kur;
			} else {
					//var_dump($temp_kls['result']);
			$temp_data = array(
				'nama_kurikulum' => $nama_kurikulum,
				'jumlah_sks_wajib' => $jml_sks_wajib,
				'jumlah_sks_pilihan' => $jml_sks_pilihan,
				'jumlah_sks_lulus' => $jml_sks_wajib+$jml_sks_pilihan,
				'id_semester' => $mulai_berlaku,
				'id_prodi' => $id_sms,
				);

				//dump($temp_data);

				$data_param = array(
					'act' => 'InsertKurikulum',
					'record' => $temp_data,
					'token' => get_token()
				);
				$insert_kur = service_request($data_param);

				if (is_object($insert_kur)) {
					$value_data = addslashes($insert_kur->error_desc);
					if ($value_data!='') {
						$error_msg_kur[] = "<b>Error ".$value_data;
						$db->update('kurikulum',array('status_error' => 2, 'keterangan'=>"Error ".$value_data),'id',$value->id);
						++$error_count_kur;
					} else {
						$id_kur = $insert_kur->data->id_kurikulum;
						$db->update('kurikulum',array('status_error'=>1,'keterangan'=>''),'id',$value->id);
						++$sukses_count_kur;
					}
				} else {
					$error_msg_kur[] = "<b>Error ".$insert_kur;
					$db->update('kurikulum',array('status_error' => 2, 'keterangan'=>"Error ".$insert_kur),'id',$value->id);
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
				$filter_check = "id_prodi='".$dt->id_sms."' and trim(kode_mata_kuliah)='".trim($dt->kode_mk)."'";
				//get matkul
				$data_param = array(
					'act' => 'GetDetailMataKuliah',
					'token' => get_token(),
					'filter' => $filter_check
				);
				$temp_check = service_request($data_param);

			if (!empty($temp_check->data)) {
				$id_mk = $temp_check->data[0]->id_matkul;
				$jmlsks_mk= $temp_check->data[0]->sks_mata_kuliah;
				++$error_count;
				$error_msg[] = "Matakuliah $dt->kode_mk $dt->nama_mk sudah ada di Feeder";
				$db->update('mat_kurikulum',array('status_error' => 2, 'keterangan'=>"Matakuliah ini sudah ada di Feeder"),'id',$dt->id_mat);
				//check ke matakuliah kurikulum jika sudah ada pula
				$filter_check_mat = "id_kurikulum='".$id_kurikulum."' and id_matkul='".$id_mk."'";
				//get matkul kurikulum
				$data_param = array(
					'act' => 'GetMatkulKurikulum',
					'token' => get_token(),
					'filter' => $filter_check_mat
				);
				$temp_checks = service_request($data_param);

				if (empty($temp_checks->data)) {
					//insert to matkul kurikulum
					$in_mat_kur = array(
						'id_kurikulum' => $id_kurikulum,
						'id_matkul' => $id_mk,
						'semester' => $dt->semester,
						'sks_mata_kuliah' => $jmlsks_mk,
						'sks_tatap_muka' =>$dt->sks_tm,
					    'sks_praktek' =>  $dt->sks_prak,
				   		'sks_praktek_lapangan' =>$dt->sks_prak_lap,
						'sks_simulasi' => $dt->sks_sim,
						'apakah_wajib' => $wajib_mat
						);

				$data_param = array(
					'act' => 'InsertMatkulKurikulum',
					'token' => get_token(),
					'record' => $in_mat_kur
				);
				$insert_mat_kur = service_request($data_param);

						if ($insert_mat_kur->error_desc=='') {
							++$sukses_count_mat;
						} else {
							++$error_count_mat;
							$error_msg_mat[] = "Error, Matakuliah Kurikulum $dt->kode_mk ,".$insert_mat_kur->error_desc;
						}
				} 

			} else {
					
				$data = array(
				'id_prodi' => $dt->id_sms,
		        'kode_mata_kuliah' => $dt->kode_mk,
		        'nama_mata_kuliah' => $dt->nama_mk,
		        'id_jenis_mata_kuliah' => $wajib,
		        'sks_mata_kuliah' => $jmlsks_mk,
		        'sks_tatap_muka' => $dt->sks_tm,
		        'sks_praktek' => $dt->sks_prak,
		        'sks_praktek_lapangan' => $dt->sks_prak_lap,
		        'sks_simulasi' => $dt->sks_sim,
		        'metode_kuliah' => $dt->metode_pelaksanaan_kuliah,
		        'id_kelompok_mata_kuliah' => $dt->kelompok_mk,
			    'tanggal_mulai_efektif' => $dt->tgl_mulai_efektif,
				'tanggal_akhir_efektif' => $dt->tgl_akhir_efektif,
		        );


				$data_param = array(
					'act' => 'InsertMataKuliah',
					'token' => get_token(),
					'record' => $data
				);
				$in_mat = service_request($data_param);
				//dump($in_mat);

				//insert matakuliah
				if ($in_mat->error_desc=='') {
					$id_mk = $in_mat->data->id_matkul;
					++$sukses_count;
					$db->update('mat_kurikulum',array('status_error'=>1,'keterangan'=>''),'id',$dt->id_mat);
						//mat kur for second access
		        		$in_mat_kurs = array(
						'id_kurikulum' => $id_kurikulum,
						'id_matkul' => $id_mk,
						'semester' => $dt->semester,
						'sks_mata_kuliah' => $jmlsks_mk,
						'sks_tatap_muka' =>$dt->sks_tm,
					    'sks_praktek' =>  $dt->sks_prak,
				   		'sks_praktek_lapangan' =>$dt->sks_prak_lap,
						'sks_simulasi' => $dt->sks_sim,
						'apakah_wajib' => $wajib_mat
						);
					$data_param = array(
						'act' => 'InsertMatkulKurikulum',
						'token' => get_token(),
						'record' => $in_mat_kurs
					);
					$insert_mat_kur = service_request($data_param);
						if ($insert_mat_kur->error_desc=='') {
							++$sukses_count_mat;
						} else {
							++$error_count_mat;
							$error_msg_mat[] = "Error, Matakuliah Kurikulum $dt->kode_mk ,".$insert_mat_kur->error_desc;
						}
				} else {
					++$error_count_mat;
					$error_msg_mat[] = "Error, ".$in_mat->error_desc;
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


