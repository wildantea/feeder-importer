<?php
session_start();
include "../../inc/config.php";

$columns = array(
	'nipd',
	'nm_pd',
	'mulai_smt',
	'jk',
	'nik',
	'tmpt_lahir',
	'tgl_lahir',
	'nm_ibu_kandung',
	'mulai_smt',
	'nama_jurusan',
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
			if ($_SESSION['jurusan']=='0') {
				$jurusan = '';
			}
		}
	} else {
		$jurusan = "and mhs.kode_jurusan='".$_POST['jurusan']."'";
	}

	if ($_POST['id_jns_daftar']=='all') {
		$id_jns_daftar = '';
	} else {
		$id_jns_daftar = " and id_jns_daftar='".$_POST['id_jns_daftar']."'";
	}


		$query = $new_table->get_custom("select mhs.*,concat(jenjang,' ',nama_jurusan) as nama_jurusan from mhs left join jurusan on mhs.kode_jurusan=jurusan.kode_jurusan where mhs.id is not null $jurusan $semester $id_jns_daftar $status",$columns);

}

 else {

 	if (isset($_POST['jurusan_user'])) {
 		$where_jurusan = "and jurusan.kode_jurusan='".$_POST['jurusan_user']."'";
 		if ($_SESSION['jurusan']=='0') {
				$where_jurusan = '';
			}
		$query = $new_table->get_custom("select mhs.*,concat(jenjang,' ',nama_jurusan) as nama_jurusan from mhs left join jurusan on mhs.kode_jurusan=jurusan.kode_jurusan where 1=1 $where_jurusan",$columns);
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
	$ResultData[] = $value->mulai_smt;
	$ResultData[] = $value->jk;
	$ResultData[] = $value->nik;
	$ResultData[] = $value->tmpt_lahir;
	$ResultData[] = tgl_indo($value->tgl_lahir);
	$ResultData[] = $value->nm_ibu_kandung;
	$ResultData[] = $value->nama_jurusan;
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



