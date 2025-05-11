<?php
session_start();
include "../../inc/config.php";
if (isset($_GET['q'])) {
$gelar = $_GET['q'];
	if (strlen($gelar)>1) {
		$dosen = $db->fetch_custom("SELECT 
    dwc.id_wil,CONCAT(dwc.nm_wil, ' - ', dw.nm_wil, ' - ', data_wilayah.nm_wil) AS wil 
FROM 
    data_wilayah
LEFT JOIN 
    data_wilayah dw ON data_wilayah.id_wil = dw.id_induk_wilayah
LEFT JOIN 
    data_wilayah dwc ON dw.id_wil = dwc.id_induk_wilayah
WHERE 
    data_wilayah.id_level_wil = '1' AND (data_wilayah.nm_wil LIKE '%$gelar%' OR dw.nm_wil LIKE '%$gelar%' OR dwc.nm_wil LIKE '%$gelar%' )

union all
SELECT 
    dw.id_wil,CONCAT( dw.nm_wil, ' - ', data_wilayah.nm_wil) AS wil 
FROM 
    data_wilayah
LEFT JOIN 
    data_wilayah dw ON data_wilayah.id_wil = dw.id_induk_wilayah
WHERE 
    data_wilayah.id_level_wil = '1' AND (data_wilayah.nm_wil LIKE '%$gelar%' OR dw.nm_wil LIKE '%$gelar%' )
LIMIT 100
");
	} else {
		$dosen = $db->fetch_custom("SELECT 
    dwc.id_wil,CONCAT(dwc.nm_wil, ' - ', dw.nm_wil, ' - ', data_wilayah.nm_wil) AS wil 
FROM 
    data_wilayah
LEFT JOIN 
    data_wilayah dw ON data_wilayah.id_wil = dw.id_induk_wilayah
LEFT JOIN 
    data_wilayah dwc ON dw.id_wil = dwc.id_induk_wilayah
WHERE 
    data_wilayah.id_level_wil = '1' 

union all
SELECT 
    dw.id_wil,CONCAT( dw.nm_wil, ' - ', data_wilayah.nm_wil) AS wil 
FROM 
    data_wilayah
LEFT JOIN 
    data_wilayah dw ON data_wilayah.id_wil = dw.id_induk_wilayah
WHERE 
    data_wilayah.id_level_wil = '1'
LIMIT 5
");
	}
		$results['results'] = array();
		foreach ($dosen as $dos) {
			$array_push = array(
				'id' => $dos->id_wil,
				'text' => $dos->wil
			);
			$results['results'][] = $array_push;
		}
		echo json_encode($results);
	
} else {
	$dosen = $db->fetch_custom("SELECT 
    dwc.id_wil,CONCAT(dwc.nm_wil, ' - ', dw.nm_wil, ' - ', data_wilayah.nm_wil) AS wil 
FROM 
    data_wilayah
LEFT JOIN 
    data_wilayah dw ON data_wilayah.id_wil = dw.id_induk_wilayah
LEFT JOIN 
    data_wilayah dwc ON dw.id_wil = dwc.id_induk_wilayah
WHERE 
    data_wilayah.id_level_wil = '1'

union all
SELECT 
    dw.id_wil,CONCAT( dw.nm_wil, ' - ', data_wilayah.nm_wil) AS wil 
FROM 
    data_wilayah
LEFT JOIN 
    data_wilayah dw ON data_wilayah.id_wil = dw.id_induk_wilayah
WHERE 
    data_wilayah.id_level_wil = '1'
LIMIT 5
");
	$results['results'] = array();
	foreach ($dosen as $dos) {
		$array_push = array(
			'id' => $dos->id_wil,
			'text' => $dos->wil
		);
		$results['results'][] = $array_push;
	}
	echo json_encode($results);
}
?>