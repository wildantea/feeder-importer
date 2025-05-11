<?php
include "../../inc/config.php";
include "../../lib/prosesupdate/ProgressUpdater.php";
$token = get_token();

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
	$arr_data = $db->query("select ajar_dosen.id as id_dosen_ajar,left(ajar_dosen.semester,4) as tahun,ajar_dosen.*,jurusan.kode_jurusan,jurusan.id_sms from ajar_dosen inner join jurusan on ajar_dosen.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and ajar_dosen.semester='".$_GET['sem']."' and status_error!=1 and nidn!=''");
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
		$id_sdm = "";
		$id_reg_ptk = "";
		$id_kls = "";
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

      	$data_dic_dosen = [
	      'act' => 'GetListDosen',
	        'token' => $token,
	        'filter' => $filter_nidn,
	        'order' => '',
	        'limit' => '',
	        'offset' => ''
    	];
		$temp_nidn = service_request($data_dic_dosen);

		if (!empty($temp_nidn->data)) {
			$id_sdm = $temp_nidn->data[0]->id_dosen;
		}

		if ($id_sdm=="") {
			++$error_count;
			$db->update('ajar_dosen',array('status_error' => 2, 'keterangan'=>"NIDN tidak terdaftar di feeder</b>"),'id',$value->id_dosen_ajar);
			$error_msg[] = "NIDN tidak terdaftar di feeder</b>";
		} else {
			$filter_ptk = "id_dosen='".$id_sdm."' and id_tahun_ajaran='$value->tahun'";
          	$data_penugasan = [
		      'act' => 'GetListPenugasanSemuaDosen',
		        'token' => $token,
		        'filter' => $filter_ptk,
		        'order' => '',
		        'limit' => '',
		        'offset' => ''
	    	];
	    	$temp_ptk = service_request($data_penugasan);
/*	    	dump($data_penugasan);
	    	dump($temp_ptk);*/
			if (!empty($temp_ptk->data)) {
				$id_reg_ptk = $temp_ptk->data[0]->id_registrasi_dosen;
			} else {
				++$error_count;
				$db->update('ajar_dosen',array('status_error' => 2, 'keterangan'=>"Dosen belum ada penugasan di Semester ini</b>"),'id',$value->id_dosen_ajar);
				$error_msg[] = "Dosen belum ada penugasan di Semester ini</b>";
			}

		//Filter kelas kuliah
		$filter_kls = "id_prodi='$id_sms' and trim(kode_mata_kuliah)='".$kode_mk."' AND trim(nama_kelas_kuliah)='".$kelas."' AND id_semester='".$semester."'";

      	$data_dic_kelas = [
	      'act' => 'GetDetailKelasKuliah',
	        'token' => $token,
	        'filter' => $filter_kls,
	        'order' => '',
	        'limit' => '',
	        'offset' => ''
    	];
		$temp_kls = service_request($data_dic_kelas);
		if (empty($temp_kls->data)) {
				++$error_count;
				$db->update('ajar_dosen',array('status_error' => 2, 'keterangan'=>"Error, Pastikan Kelas $kelas Sudah dibuat "),'id',$value->id_dosen_ajar);
				$error_msg[] = "Error, Pastikan Kelas $kelas Sudah dibuat ";
		} else {
			$id_kls = $temp_kls->data[0]->id_kelas_kuliah;
				if($sks_ajar!=NULL or $sks_ajar!='') {
					$sks_mk = $sks_ajar;
				} else {
					$data_req_mat = [
						'act' => 'GetListMataKuliah',
					    'token' => $token,
					    'filter' => "id_matkul='".$temp_kls->data[0]->id_matkul."'"
					];
					$get_matkul = service_request($data_req_mat);
					$sks_mk = $get_matkul->data[0]->sks_mata_kuliah;
					
					$check_count = $db->query("select * from ajar_dosen where semester=? and kode_mk=? and nama_kelas=? and kode_jurusan=?",array('semester' => $value->semester,'kode_mk' => $value->kode_mk,'nama_kelas' => $value->nama_kelas,'kode_jurusan' => $kode_prodi));
					if ($check_count->rowCount()>1) {
						$sks_mk = $sks_mk/$check_count->rowCount();
					} else {
						$sks_mk = $get_matkul->data[0]->sks_mata_kuliah;
					}
				}

			if ($id_reg_ptk!='' && $id_kls!='') {
				//check dosen is already in kelas
						$data_dic_kelas_dosen = [
					      'act' => 'GetDosenPengajarKelasKuliah',
					        'token' => $token,
					        'filter' => "id_registrasi_dosen='$id_reg_ptk' and id_kelas_kuliah='$id_kls'"
				    	];
						$check_dosen_kelas = service_request($data_dic_kelas_dosen);
						if (!empty($check_dosen_kelas->data)) {
							++$error_count;
							$db->update('ajar_dosen',array('status_error' => 2, 'keterangan'=> "Error, Dosen kelas sudah ada"),'id',$value->id_dosen_ajar);
							$error_msg[] = "Error, Dosen kelas sudah ada";
						} else {
							$temp_data = array(
								'id_registrasi_dosen' => $id_reg_ptk,
								'id_kelas_kuliah' => $id_kls,
							  	'sks_substansi_total' => $sks_mk,
					  	 		'rencana_minggu_pertemuan' => $ren_tm,
					  	 		'realisasi_minggu_pertemuan' => $rel_tm,
					  	 		'id_jenis_evaluasi' => $value->id_jenis_evaluasi
					  	 	);
					  	 	
						  	$data_dic = [
						      'act' => 'InsertDosenPengajarKelasKuliah',
						        'token' => $token,
						        'record' => $temp_data,
						    ];
							$temp_result = service_request($data_dic);
							if ($temp_result->error_desc=='') {
								++$sukses_count;
								$db->update('ajar_dosen',array('status_error'=>1,'keterangan'=>''),'id',$value->id_dosen_ajar);
							} else {
								++$error_count;
								$db->update('ajar_dosen',array('status_error' => 2, 'keterangan'=> "Error, ".$temp_result->error_desc.""),'id',$value->id_dosen_ajar);
								$error_msg[] = "Error, ".$temp_result->error_desc."";
							}
						}

				
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
	$pu->totallyComplete($msg);


