<?php
session_start();
include "../../inc/config.php";

$columns = array(
	'nipd',
	'nm_pd',
	'jk',
	'tmpt_lahir',
	'status_error',
	'mhs.id',
	);

if (isset($_POST['semester'])) {

	if ($_POST['semester']=='all') {
		$semester = '';
	} else {
		$semester = "and mulai_smt='".$_POST['semester']."'";
	}
 

	if ($_POST['status_filter']=='all') {
		$status = '';
	} else {
		$status = " and status_error='".$_POST['status_filter']."'";
	}

	if ($_POST['jurusan']=='all') {
		$jurusan = '';
		if ($_SESSION['level']!=1) {
			$jurusan = "and mhs.kode_jurusan='".$_SESSION['jurusan']."'";
		}
	} else {
		$jurusan = "and mhs.kode_jurusan='".$_POST['jurusan']."'";
	}


		$query = $new_table->get_custom("select mhs.*,concat(jenjang,' ',nama_jurusan) as nama_jurusan from mhs left join jurusan on mhs.kode_jurusan=jurusan.kode_jurusan where mhs.id is not null $jurusan $semester $status",$columns);

}

 else {

 	if (isset($_POST['jurusan_user'])) {
		$query = $new_table->get_custom("select mhs.*,concat(jenjang,' ',nama_jurusan) as nama_jurusan from mhs left join jurusan on mhs.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_POST['jurusan_user']."' ",$columns);
	} else {

	$query = $new_table->get_custom("select mhs.*,concat(jenjang,' ',nama_jurusan) as nama_jurusan from mhs left join jurusan on mhs.kode_jurusan=jurusan.kode_jurusan ",$columns);
 	}
 }



$data = array();

foreach ($query	as $value) {
	$ResultData = array();
		$ResultData[] = "<input type='checkbox'  class='deleteRow' value='".$value->id."'/>";
	$ResultData[] = $value->nipd;
	$ResultData[] = $value->nm_pd;
	$ResultData[] = $value->jk;
	$ResultData[] = $value->tmpt_lahir;
		if ($value->status_error==1) {
		$ResultData[] = '<button rel="tooltip" type="button" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="left" title="" data-original-title="Sukses"><i class="fa fa-info-circle"></i></button> '.$value->status_error;
	} elseif ($value->status_error==0) {
		$ResultData[] = '<button rel="tooltip" type="button" class="btn btn-xs btn-warning tips" data-toggle="tooltip" data-placement="left" title="Belum diproses" data-original-title="Belum diproses"><i class="fa fa-info-circle"></i></button> '.$value->status_error;
	} else {
		$ResultData[] = '<button rel="tooltip" type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" title=\''.addslashes($value->keterangan).'\'" data-original-title=\''.addslashes($value->keterangan).'\'"><i class="fa fa-info-circle"></i></button> '.$value->status_error;
	}
	$ResultData[] = $value->id;

	$data[] = $ResultData;
	
}
//set data
$new_table->set_data($data);
//create our json
$new_table->create_data();



