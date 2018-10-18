<?php
session_start();
include "../../inc/config.php";

$columns = array(
	'nama_kur',
	'mulai_berlaku',
	'jml_sks_wajib',
	'jml_sks_pilihan',
	'total_sks',
	'id'
	);

$query = $new_table->get_custom("select * from kurikulum where kode_jurusan='".$_POST['jurusan']."'",$columns);


$data = array();

foreach ($query	as $value) {
	$ResultData = array();
	$ResultData[] = $value->nama_kur;
	$ResultData[] = $value->mulai_berlaku;
	$ResultData[] = $value->total_sks;
	$ResultData[] = $value->jml_sks_wajib;
	$ResultData[] = $value->jml_sks_pilihan;
	$ResultData[] = $value->id;

	$data[] = $ResultData;
	
}
//set data
$new_table->set_data($data);
//create our json
$new_table->create_data();



