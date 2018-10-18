<?php
session_start();
include "../../inc/config.php";


$columns = array(
	'nim',
	'nama',
	'id_jenis_keluar',
	'status_error',
	'id'
	);

if (isset($_POST['status_filter'])) {
	
	if ($_POST['status_filter']=='all') {
		$status = '';
	} else {
		$status = " and status_error='".$_POST['status_filter']."'";
	}
	
	
	$query = $new_table->get_custom("select * from kelulusan  left join jenis_keluar on kelulusan.id_jenis_keluar=jenis_keluar.id_jns_keluar where kode_jurusan='".$_POST['jurusan']."'$status ",$columns);
} else {

$query = $new_table->get_custom("select kelulusan.*,ket_keluar from kelulusan  left join jenis_keluar on kelulusan.id_jenis_keluar=jenis_keluar.id_jns_keluar where kode_jurusan='".$_POST['jurusan']."'",$columns);

}
$data = array();

foreach ($query	as $value) {
	$ResultData = array();
	$ResultData[] = "<input type='checkbox'  class='deleteRow' value='".$value->id."'/>";
	$ResultData[] = $value->nim;
	$ResultData[] = $value->nama;
	$ResultData[] = $value->ket_keluar;
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


