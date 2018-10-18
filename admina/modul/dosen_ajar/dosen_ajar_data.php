<?php
session_start();
include "../../inc/config.php";


$columns = array(
	'semester',
	'nidn',
	'nama_dosen',
	'kode_mk',
	'nama_kelas',
	'rencana_tatap_muka',
	'status_error',
	'id'
	);

if (isset($_POST['semester'])) {
	
	if ($_POST['semester']=='all') {
		$semester = '';
	} else {
		$semester = "and semester='".$_POST['semester']."'";
	}

	if ($_POST['kode_mk']=='all') {
		$kode_mk = '';
	} else {
		$kode_mk = "and kode_mk='".$_POST['kode_mk']."'";
	}

	
	if ($_POST['status_filter']=='all') {
		$status = '';
	} else {
		$status = " and status_error='".$_POST['status_filter']."'";
	}
	$query = $new_table->get_custom("select * from ajar_dosen where kode_jurusan='".$_POST['jurusan']."' $semester $status $kode_mk ",$columns);
} else {
$query = $new_table->get_custom("select * from ajar_dosen where kode_jurusan='".$_POST['jurusan']."'",$columns);
}
$data = array();
foreach ($query	as $value) {
	$ResultData = array();
	$ResultData[] = "<input type='checkbox'  class='deleteRow' value='".$value->id."'  />";
	$ResultData[] = $value->semester;
	$ResultData[] = $value->nidn;
	$ResultData[] = $value->nama_dosen;
	$ResultData[] = $value->kode_mk;
	$ResultData[] = $value->nama_kelas;
	$ResultData[] = $value->rencana_tatap_muka;
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
