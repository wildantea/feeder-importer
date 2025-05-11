<?php
session_start();
include "../../inc/config.php";
if (isset($_GET['q'])) {
$gelar = $_GET['q'];
	if (strlen($gelar)>1) {
		$dosen = $db->fetch_custom("select * from satuan_pendidikan where nm_lemb like '%$gelar%' or npsn like '%$gelar%'");
	} else {
		$dosen = $db->fetch_custom("select * from satuan_pendidikan limit 5");
	}
		$results['results'] = array();
		foreach ($dosen as $dos) {
			$array_push = array(
				'id' => $dos->id_sp,
				'text' => $dos->nm_lemb
			);
			$results['results'][] = $array_push;
		}
		echo json_encode($results);
	
} else {
	$dosen = $db->fetch_custom("select * from satuan_pendidikan limit 5");
	$results['results'] = array();
	foreach ($dosen as $dos) {
		$array_push = array(
			'id' => $dos->id_sp,
			'text' => $dos->nm_lemb
		);
		$results['results'][] = $array_push;
	}
	echo json_encode($results);
}


?>