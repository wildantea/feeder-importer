<?php
session_start();
include "../../inc/config.php";


$columns = array(
	'semester',
	'kode_mk',
	'nama_mk',
	'nama_kelas',
	'status_error',
	'id'
	);

if (isset($_POST['semester'])) {
	
	if ($_POST['semester']=='all') {
		$semester = '';
	} else {
		$semester = "and semester='".$_POST['semester']."'";
	}

	if ($_POST['matkul']=='all') {
		$matkul = '';
	} else {
		$matkul = "and kode_mk='".$_POST['matkul']."'";
	}
	
	if ($_POST['status_filter']=='all') {
		$status = '';
	} else {
		$status = " and status_error='".$_POST['status_filter']."'";
	}
	$query = $new_table->get_custom("select status_error,keterangan,semester,kode_mk,nama_mk,nama_kelas,id from kelas_kuliah where kode_jurusan='".$_POST['jurusan']."' $semester $status $matkul ",$columns);
} else {
	$query = $new_table->get_custom("select status_error,keterangan,semester,kode_mk,nama_mk,nama_kelas,id from kelas_kuliah where kode_jurusan='".$_POST['jurusan']."'",$columns);
}


$data = array();
foreach ($query	as $value) {

	$ResultData = array();
	$ResultData[] = "<input type='checkbox'  class='deleteRow' value='".$value->id."'/>";
	$ResultData[] = $value->semester;
	$ResultData[] = $value->kode_mk;
	$ResultData[] = $value->nama_mk;
	$ResultData[] = $value->nama_kelas;
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
