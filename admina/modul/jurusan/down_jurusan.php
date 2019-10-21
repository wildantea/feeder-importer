<?php

include "../../lib/nusoap/nusoap.php";

include "../../inc/config.php";

include "../../lib/prosesupdate/ProgressUpdater.php";


$config = $db->fetch_single_row('config_user','id',1);

if ($config->live=='Y') {
	$url = 'http://'.$config->url.':'.$config->port.'/ws/live.php?wsdl'; // gunakan live
} else {
	$url = 'http://'.$config->url.':'.$config->port.'/ws/sandbox.php?wsdl'; // gunakan sandbox
}


$client = new nusoap_client($url, true);
$proxy = $client->getProxy();


$table = 'sms';
# MENDAPATKAN TOKEN
$username = $config->username;
$password = $config->password;
$token = $proxy->GetToken($username, $password);


	$sukses_count = 0;
	$sukses_msg = '';
	$error_count = 0;
	$error = array();

	$id_sp = $config->id_sp;

	$filter_sp = "p.id_sp='".$id_sp."'";

	$data_prodi = $proxy->GetCountRecordset($token,$table,$filter_sp);

	$total_prodi = $data_prodi['result'];


	$jumlah = $total_prodi;

		$options = array(
		    'filename' => 'progress.json',
		    'autoCalc' => true,
		    'totalStages' => 1
		);
		$new_pu = new Manticorp\ProgressUpdater($options);

		$filter_sms = "id_sp='".$id_sp."'";

		$prodi = $proxy->GetRecordset($token,"sms", $filter_sms,"", "","");



			//let's push first page
			$stageOptions = array(
			    'name' => 'Page $i',
			    'message' => 'Some Message',
			    'totalItems' => $jumlah,
			);

			$new_pu->nextStage($stageOptions);

			$db->query("truncate jurusan");
			
			foreach ($prodi['result'] as $data) {

			$filter_jenjang = "id_jenj_didik='".$data['id_jenj_didik']."'";
			$jenjang = $proxy->GetRecord($token,'jenjang_pendidikan',$filter_jenjang);

			$nama_jurusan = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $data['nm_lemb']);
			$kode_jurusan = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $data['kode_prodi']);

					$sukses_count++;
					$datas = array(
					'kode_jurusan' => $kode_jurusan,
					'nama_jurusan' => $nama_jurusan,
					'id_sms' => $data['id_sms'],
					'id_jenj_didik' => $data['id_jenj_didik'],
					'status' => $data['stat_prodi'],
					'jenjang' => $jenjang['result']['nm_jenj_didik']
					);
					$in = $db->insert('jurusan',$datas);
					$new_pu->incrementStageItems(1, true);

		}

		$msg = '';
		if ((!$sukses_count==0) || (!$error_count==0)) {
			$msg =  "<div class=\"alert alert-warning \" role=\"alert\">
					<font color=\"#3c763d\">".$sukses_count." data Jurusan/Prodi berhasil ditambah</font><br />
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

		$new_pu->totallyComplete($msg);



