<?php
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

$token = get_token();

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
		$id_sms = $value->id_sms;
		$filter_pd = "trim(nim)='".$nim."' and id_prodi='".$id_sms."'";
			$data_req_mat = [
				'act' => 'GetListRiwayatPendidikanMahasiswa',
			    'token' => $token,
			    'filter' => $filter_pd,
			    'order' => "",
			    'limit' => "",
			    'offset' => ""

			];
		$temp_npm = service_request($data_req_mat);
			if (!empty($temp_npm->data)) {
				$id_reg_pd = $temp_npm->data[0]->id_registrasi_mahasiswa;
				if ($_GET['method']=='up') {
					$filter_akm = "id_registrasi_mahasiswa='".$id_reg_pd."' and id_semester='".$value->semester."'";
					$data_req_akm = [
						'act' => 'GetAktivitasKuliahMahasiswa',
					    'token' => $token,
					    'filter' => $filter_akm,
					    'order' => "",
					    'limit' => "",
					    'offset' => ""

					];
					if (!empty(service_request($data_req_akm)->data)) {
						$key_input = array(
							'id_registrasi_mahasiswa' => $id_reg_pd,
							'id_semester' => $value->semester
						);
						$record = array(
							'id_semester' => $value->semester,
							  'id_registrasi_mahasiswa' => $id_reg_pd,
							  		'ips' => $value->ips,
							  	'sks_semester' => $value->sks_smt,
							  		'ipk' => $value->ipk,
							  'total_sks' => $value->sks_total,
							 'id_status_mahasiswa' => $value->status_kuliah,
							 'biaya_kuliah_smt' => $value->biaya_smt,
							 'id_pembiayaan' => $value->id_pembiayaan
							);
						  $data_dic = [
						      'act' => 'UpdatePerkuliahanMahasiswa',
						      'key' => $key_input,
						        'token' => $token,
						        'record' => $record,

						    ];
						$up_result = service_request($data_dic);
						if ($up_result->error_desc!='') {
							++$error_count;
							$error_msg[] = $up_result->error_desc;
							$db->update('nilai_akm',array('status_error' => 2, 'keterangan'=> $up_result->error_desc),'id',$value->id_akm);
						} else {
							++$sukses_count;
							$db->update('nilai_akm',array('status_error'=>1,'keterangan'=>''),'id',$value->id_akm);
						}
					} else {
						++$error_count;
						$error_msg[] = "Error, Akm tidak ditemukan di Feeder";
						$db->update('nilai_akm',array('status_error' => 2, 'keterangan'=> "Error, Akm tidak ditemukan di Feeder"),'id',$value->id_akm);
					}
				$i++;
		 		$pu->incrementStageItems(1, true);

			} else {

					$filter_akm = "id_registrasi_mahasiswa='".$id_reg_pd."' and id_semester='".$value->semester."'";
					$data_req_akm = [
						'act' => 'GetAktivitasKuliahMahasiswa',
					    'token' => $token,
					    'filter' => $filter_akm,
					    'order' => "",
					    'limit' => "",
					    'offset' => ""

					];
					if (!empty(service_request($data_req_akm)->data)) {
						++$error_count;
						$error_msg[] = "Error, Akm sudah ada di Feeder";
						$db->update('nilai_akm',array('status_error' => 2, 'keterangan'=> "Error, Akm sudah ada di Feeder"),'id',$value->id_akm);
					} else {
						$record = array(
							'id_semester' => $value->semester,
							  'id_registrasi_mahasiswa' => $id_reg_pd,
							  		'ips' => $value->ips,
							  	'sks_semester' => $value->sks_smt,
							  		'ipk' => $value->ipk,
							  'total_sks' => $value->sks_total,
							 'id_status_mahasiswa' => $value->status_kuliah,
							 'biaya_kuliah_smt' => $value->biaya_smt,
							 'id_pembiayaan' => $value->id_pembiayaan
							);
						$data_dic = [
					      'act' => 'InsertPerkuliahanMahasiswa',
					        'token' => $token,
					        'record' => $record,
					    ];
					    $temp_result = service_request($data_dic);
						if ($temp_result->error_desc=='') {
							++$sukses_count;
							$db->update('nilai_akm',array('status_error'=>1,'keterangan'=>''),'id',$value->id_akm);
						} else {
							++$error_count;
							$error_msg[] = $temp_result->error_desc;
							$db->update('nilai_akm',array('status_error' => 2, 'keterangan'=> $temp_result->error_desc),'id',$value->id_akm);
						}
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

