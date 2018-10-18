<?php
session_start();
include "../../inc/config.php";


$columns = array(
	'semester',
	'nim',
	'nama',
	'status_kuliah',
	'ips',
	'ipk',
	'sks_smt',
	'sks_total',
	'status_error',
	'id'
	);

if (isset($_POST['semester'])) {
	
	if ($_POST['semester']=='all') {
		$semester = '';
	} else {
		$semester = "and semester='".$_POST['semester']."'";
	}
	if ($_POST['valid']=='all') {
		$valid = '';
	} else {
		$valid = "and valid='".$_POST['valid']."'";
	}
	//status kuliah
	if ($_POST['status_kuliah']=='all') {
		$status_kuliah = '';
	} else {
		$status_kuliah = "and status_kuliah='".$_POST['status_kuliah']."'";
	}

	
	if ($_POST['status_filter']=='all') {
		$status = '';
	} else {
		$status = " and status_error='".$_POST['status_filter']."'";
	}
	$query = $new_table->get_custom("select * from nilai_akm where kode_jurusan='".$_POST['jurusan']."' $semester $status $status_kuliah $valid ",$columns);
} else {
$query = $new_table->get_custom("select * from nilai_akm where kode_jurusan='".$_POST['jurusan']."'",$columns);
}
$data = array();
foreach ($query	as $value) {
	$ResultData = array();
	$ResultData[] = "<input type='checkbox'  class='deleteRow' value='".$value->id."'  />";
	$ResultData[] = $value->semester;
	$ResultData[] = $value->nim;
	$ResultData[] = $value->nama;
	
	if ($value->status_kuliah=='A') {
		$status_kuliah = "Aktif";
	} elseif ($value->status_kuliah=='C') {
		$status_kuliah= "Cuti";
	} elseif ($value->status_kuliah=='D') {
		$status_kuliah= "Drop Out";
	} elseif ($value->status_kuliah=='K') {
		$status_kuliah= "Keluar";
	} elseif ($value->status_kuliah=='L') {
		$status_kuliah= "Lulus";
	} elseif ($value->status_kuliah=='N') {
		$status_kuliah= "Non-aktif";
	}
	$ResultData[] = $status_kuliah;
	          
	$ResultData[] = $value->ips;
	$ResultData[] = $value->ipk;
	$ResultData[] = $value->sks_smt;
	$ResultData[] = $value->sks_total;
	if ($value->valid==1) {
		$ResultData[] = '<button rel="tooltip" type="button" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="left" title="" data-original-title="Valid"><i class="fa fa-check"></i></button> '.$value->valid;
	} elseif ($value->valid==0) {
		$ResultData[] = '<button rel="tooltip" type="button" class="btn btn-xs btn-warning tips" data-toggle="tooltip" data-placement="left" title="Belum Divalidasi" data-original-title="Belum Divalidasi"><i class="fa fa-info-circle"></i></button> '.$value->valid;
	} else {
		$sks_sem = "";
		if ($value->ket_sks_sem!='') {
			$sks_sem = $value->ket_sks_sem."<br>";
		}
		$ips_val = "";
		if ($value->ket_valid_ips!='') {
			$ips_val = $value->ket_valid_ips."<br>";
		}
		$ipk_val = "";
		if ($value->ket_valid_ipk!='') {
			$ipk_val = $value->ket_valid_ipk."<br>";
		}
		$ips_ipk = "";
		if ($value->ket_valid_ips_ipk!='') {
			$ips_ipk = $value->ket_valid_ips_ipk."<br>";
		}
		$krs_ada = "";
		if ($value->ket_krs_ada!='') {
			$krs_ada = $value->ket_krs_ada."<br>";
		}

		$ResultData[] = '<button rel="tooltip" type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="'.$sks_sem.$ips_val.$ipk_val.$ips_ipk.$krs_ada.'"><i class="fa fa-info-circle"></i></button> '.$value->valid;
	}
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

