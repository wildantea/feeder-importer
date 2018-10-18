<?php
session_start();
include "../../inc/config.php";

	
$columns = array(
	'kode_mk',
	'nama_mk',
	'semester',
	'jns_mk',
	'jns_mk',
	'status_error',
	'id'
	);

if (isset($_POST['semester'])) {
	
	if ($_POST['semester']=='all') {
		$semester = '';
	} else {
		$semester = "and semester='".$_POST['semester']."'";
	}

	if ($_POST['jns_mk']=='all') {
		$jns_mk = '';
	} else {
		$jns_mk = "and jns_mk='".$_POST['jns_mk']."'";
	}
	
	if ($_POST['status_filter']=='all') {
		$status = '';
	} else {
		$status = " and status_error='".$_POST['status_filter']."'";
	}
	$query = $new_table->get_custom("select * from mat_kurikulum where kode_jurusan='".$_POST['jurusan']."' $semester $status $jns_mk ",$columns);


} else {
	$query = $new_table->get_custom("select * from mat_kurikulum where kode_jurusan='".$_POST['jurusan']."' ",$columns);

}


$data = array();
foreach ($query	as $value) {
	$ResultData = array();
	$ResultData[] = "<input type='checkbox'  class='deleteRow' value='".$value->id."'/>";
	$ResultData[] = $value->kode_mk;
	$ResultData[] = $value->nama_mk;
	$ResultData[] = $value->semester;

	if ($value->jns_mk=='S') {
		$jns = 'Tugas akhir/Skripsi/Tesis/Disertasi';
	} elseif ($value->jns_mk=='A') {
		$jns = 'Wajib Program Studi';
	} elseif ($value->jns_mk=='B') {
		$jns = 'Pilihan';
	} elseif ($value->jns_mk=='C') {
		$jns = 'Peminatan';
	} elseif ($value->jns_mk=='W') {
		$jns = 'Wajib Nasional';
	}

	$ResultData[] = $jns;
	$jmlsks_mk=$value->sks_tm+$value->sks_prak+$value->sks_prak_lap+$value->sks_sim;
	$ResultData[] = $jmlsks_mk;
	if ($value->status_error==1) {
		$ResultData[] = '<button rel="tooltip" type="button" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="left" title="" data-original-title="Sukses"><i class="fa fa-info-circle"></i></button> '.$value->status_error;
	} elseif ($value->status_error==0) {
		$ResultData[] = '<button rel="tooltip" type="button" class="btn btn-xs btn-warning tips" data-toggle="tooltip" data-placement="left" title="Belum diproses" data-original-title="Belum diproses"><i class="fa fa-info-circle"></i></button> '.$value->status_error;
	} else {
		$ResultData[] = '<button rel="tooltip" type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" title="'.$value->keterangan.'" data-original-title="'.$value->keterangan.'"><i class="fa fa-info-circle"></i></button> '.$value->status_error;
	}
	$ResultData[] = $value->id;

	$data[] = $ResultData;
}
//set data
$new_table->set_data($data);
//create our json
$new_table->create_data();

