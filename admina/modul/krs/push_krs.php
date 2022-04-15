<?php
include "../../inc/config.php";
include "../../lib/prosesupdate/ProgressUpdater.php";
$token = get_token();
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
	$error_nim="";
	$error_mk="";
	$error_kelas = "";

	$query_matkul = '';
	$query_kelas = '';

	$id_kls_update = "";
	$id_reg_pd_update = "";
	$error_krs = "";

	if ($_GET['matkul']!='all') {
		$query_matkul = "and kode_mk='".$_GET['matkul']."'";
	}
	if ($_GET['kelas']!='all') {
		$query_kelas  = "and nama_kelas='".$_GET['kelas']."'";
	}



	$count = $db->query("select *,krs.id as id_krs from krs inner join jurusan on krs.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and krs.semester='".$_GET['sem']."' and status_error!=1 $query_matkul $query_kelas");
	$jumlah = $count->rowCount();



	$sukses_count = 0;
	$sukses_msg = '';
	$error_count = 0;
	$error = array();

		$total = $jumlah;

		$options = array(
		    'filename' => $_GET['jurusan'].'_progress.json',
		    'autoCalc' => true,
		    'totalStages' => 1
		);
		$pu = new Manticorp\ProgressUpdater($options);
			$data = $db->query("select *,krs.id as id_krs from krs inner join jurusan on krs.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and krs.semester='".$_GET['sem']."' and status_error!=1 $query_matkul $query_kelas");

			//let's push first page
			$stageOptions = array(
			    'name' => 'Proses Upload',
			    'message' => 'Some Message',
			    'totalItems' => $total,
			);

			$pu->nextStage($stageOptions);

			foreach ($data as $value) {

				$nim = trim($value->nim);
				$kode_mk = trim($value->kode_mk);
				$kelas = trim($value->nama_kelas);
				$semester = $value->semester;
				$kode_prodi = trim($value->kode_jurusan);

		$id_sms = $value->id_sms;

		$filter_pd = "trim(nim)='".$nim."'";
			$data_req_mat = [
				'act' => 'GetListRiwayatPendidikanMahasiswa',
			    'token' => $token,
			    'filter' => $filter_pd,
			    'order' => "",
			    'limit' => "",
			    'offset' => ""

			];
		$temp_pd = service_request($data_req_mat);
			if (!empty($temp_pd->data)) {
				$id_reg_pd = $temp_pd->data[0]->id_registrasi_mahasiswa;

			$filter_kls = "id_prodi='$id_sms' and trim(kode_mata_kuliah)='".$kode_mk."' AND trim(nama_kelas_kuliah)='".$kelas."' AND id_semester='".$semester."'";
			$data_req_kelas = [
				'act' => 'GetDetailKelasKuliah',
			    'token' => $token,
			    'filter' => $filter_kls,
			    'order' => "",
			    'limit' => "",
			    'offset' => ""

			];
			$temp_kls = service_request($data_req_kelas);
				if (!empty($temp_kls->data)) {
					$id_kls = $temp_kls->data[0]->id_kelas_kuliah;
					$data_krs = array(
						'id_kelas_kuliah' => $id_kls,
						'id_registrasi_mahasiswa' => $id_reg_pd
					);
				  	$data_dic_krs = [
				      'act' => 'InsertPesertaKelasKuliah',
				        'token' => $token,
				        'record' => $data_krs,
				    ];
					$temp_result = service_request($data_dic_krs);
					//dump($temp_result);
					if ($temp_result->error_desc=='') {
						++$sukses_count;
						$db->update('krs',array('status_error'=>1,'keterangan'=>''),'id',$value->id_krs);
					} else {
						++$error_count;
						$error_msg[] = $temp_result->error_desc;
						$db->update('krs',array('status_error' => 2, 'keterangan'=> $temp_result->error_desc),'id',$value->id_krs);
					}
				} else {
					++$error_count;
					$error_msg[] = $temp_result->error_desc;
					$db->update('krs',array('status_error' => 2, 'keterangan'=> 'Pastikan Kelas Sudah Dibuat'),'id',$value->id_krs);
				}
			} else {
				++$error_count;
				$error_msg[] = 'Mahasiswa ini tidak ada di feeder';
				$db->update('krs',array('status_error' => 2, 'keterangan'=> 'Mahasiswa ini tidak ada di feeder'),'id',$value->id_krs);
			}
				$pu->incrementStageItems(1, true);


		}

		$msg = '';
		if ((!$sukses_count==0) || (!$error_count==0)) {
			$msg =  "<div class=\"alert alert-warning \" role=\"alert\">
					<font color=\"#3c763d\">".$sukses_count." data Krs baru berhasil ditambah</font><br />
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

