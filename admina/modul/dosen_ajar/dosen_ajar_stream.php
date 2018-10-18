<?php
session_start();
include "../../inc/config.php";

include "../../lib/prosesupdate/ProgressUpdater.php";




$options = array(
    'filename' => $_GET['jurusan'].'_progress.json',
    'autoCalc' => true,
    'totalStages' => 1
);
$pu = new Manticorp\ProgressUpdater($options);



$stageOptions = array(
    'name' => 'This AJAX process takes a long time',
    'message' => 'But this will keep the user updated on it\'s actual progress!',
    'totalItems' => $_GET['total'],
);


$pu->nextStage($stageOptions);


$data = file_get_contents('http://simak.uinsgd.ac.id/gtakademik/services/my_service/feeder_dosen_mengajar.php?prodi='.$_GET['jurusan'].'&semester='.$_GET['sem']);
	  $dta = json_decode($data);

$i=1;
$error_count = 0;
$error = array();
$sukses = 0;
foreach ($dta->data as $dt) {

	$check = $db->check_exist('ajar_dosen',array('nama_dosen'=>$dt->nama_dosen,'kode_mk' => $dt->kode_mk,'semester'=>$dt->semester,'nama_kelas'=>$dt->nama_kelas));
	if ($check==true) {
		$error_count++;
		$error[] = $dt->nama_dosen." ".$dt->kode_mk." Sudah Ada";
	} else {
		$sukses++;


	$data = array(
		'semester' => $dt->semester,
		'nidn' => $dt->nidn,
		'nama_dosen' => $dt->nama_dosen,
		'kode_mk' => $dt->kode_mk,
		'nama_mk' => $dt->nama_mk,
		'nama_kelas' => $dt->nama_kelas,
		'rencana_tatap_muka' => 16,
		'tatap_muka_real' => 16,
		'kode_jurusan' =>$_GET['jurusan'],
		);
	$in = $db->insert('ajar_dosen',$data);

	}
	 $pu->incrementStageItems(1, true);

$i++;

}



$msg = '';
if (($sukses>0) || ($error_count>0)) {
	$msg =  "<div class=\"alert alert-warning\" role=\"alert\">
			<font color=\"#3c763d\">".$sukses." data Dosen Ajar berhasil Diunduh</font><br />
			<font color=\"#ce4844\" >".$error_count." data tidak bisa ditambahkan </font>";
			if (!$error_count==0) {
				$msg .= "<a data-toggle=\"collapse\" href=\"#collapseExample\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail error</a>";
			}
			//echo "<br />Total: ".$i." baris data";
			$msg .= "<div class=\"collapse\" id=\"collapseExample\">";
					$i=1;
					foreach ($error as $pesan) {
							$msg .= "<div class=\"bs-callout bs-callout-danger\">".$i.". ".$pesan."</div><br />";
						$i++;
						}
			$msg .= "</div>
		</div>";
}

$pu->totallyComplete($msg);




