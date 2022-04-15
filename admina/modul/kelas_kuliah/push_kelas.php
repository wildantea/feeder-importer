<?php
include "../../inc/config.php";
include "../../lib/prosesupdate/ProgressUpdater.php";
$token = get_token();

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

				$id_matkul = "";

		$kode_mk = trim($value->kode_mk);

		$semester = $value->semester;
		$kelas = trim($value->nama_kelas);
		$nama_mk = trim($value->nama_mk);
		$sanitize_mk = addslashes($value->nama_mk);
		
		$id_sms = $value->id_sms;


		$filter_mk = "id_prodi='".$id_sms."' and trim(kode_mata_kuliah)='".$kode_mk."'";
			$data_req_mat = [
				'act' => 'GetListMataKuliah',
			    'token' => $token,
			    'filter' => $filter_mk,
			    'order' => "",
			    'limit' => "",
			    'offset' => ""

			];
		$temp_mk = service_request($data_req_mat);

		//dump($temp_mk);

		if (!empty($temp_mk->data)) {
			if (count($temp_mk->data)<2) {
				$id_matkul = $temp_mk->data[0]->id_matkul;
			} else {
				
				$filter_mk2 = "id_prodi='".$id_sms."' and trim(kode_mata_kuliah)='".$kode_mk."' and nama_mata_kuliah like E'%$sanitize_mk%'";
				$filter_mk = "id_prodi='".$id_sms."' and trim(kode_mata_kuliah)='".$kode_mk."'";
					$data_req_mat = [
						'act' => 'GetListMataKuliah',
					    'token' => $token,
					    'filter' => $filter_mk2,
					    'order' => "",
					    'limit' => "",
					    'offset' => ""

					];
				$temp_mks = service_request($data_req_mat);
				if(!empty($temp_mks->data)) {
					$id_matkul = $temp_mks->data[0]->id_matkul;
				}
			}
		} else {
				$filter_mk = "trim(kode_mata_kuliah)='".$kode_mk."'";
					$data_req_mat = [
						'act' => 'GetListMataKuliah',
					    'token' => $token,
					    'filter' => $filter_mk,
					    'order' => "",
					    'limit' => "",
					    'offset' => ""

					];
				$temp_mks = service_request($data_req_mat);
				if(!empty($temp_mks->data)) {
					$id_matkul = $temp_mks->data[0]->id_matkul;
				} else {
					$filter_mk2 = "trim(kode_mata_kuliah)='".$kode_mk."' and nama_mata_kuliah like E'%$sanitize_mk%'";
					$data_req_mat = [
						'act' => 'GetListMataKuliah',
					    'token' => $token,
					    'filter' => $filter_mk2,
					    'order' => "",
					    'limit' => "",
					    'offset' => ""

					];
					$temp_mkss = service_request($data_req_mat);
					if(!empty($temp_mkss->data)) {
						$id_matkul = $temp_mkss->data[0]->id_matkul;
					}
				}
		}

		if ($id_matkul!="") {
			$temp_data = array(
					'id_prodi' => $value->id_sms,
					'id_semester' => $value->semester,
					'id_matkul' => $id_matkul,
					'nama_kelas_kuliah' => $value->nama_kelas,
					'bahasan' => $value->bahasan_case,
					'lingkup' => $value->lingkup,
					'mode' => $value->mode_kuliah,
					'tanggal_mulai_efektif' => $value->tgl_mulai_koas,
					'tanggal_akhir_efektif' => $value->tgl_selesai_koas 
			);
			$param = [
				'act' => 'InsertKelasKuliah',
			    'token' => $token,
			    'record' => $temp_data
			];
			$temp_result = service_request($param);	
			if ($temp_result->error_desc=='') {
				$sukses_count++;
				$db->update('kelas_kuliah',array('status_error'=>1,'keterangan'=>''),'id',$value->id_kelas);
			} else {
				++$error_count;
				$db->update('kelas_kuliah',array('status_error' => 2, 'keterangan'=>"Error ".$temp_result->error_desc),'id',$value->id_kelas);
				$error_msg[] = "Error, ".$temp_result->error_desc;
			}

		} else {
				++$error_count;
				$db->update('kelas_kuliah',array('status_error' => 2, 'keterangan'=>"Kode Matakuliah tidak ditemukan di Feeder"),'id',$value->id_kelas);
				$error_msg[] = "Error Kode Matakuliah tidak ditemukan di Feeder";
		}

		$new_pu->incrementStageItems(1, true);
		$id_matkul = "";
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
