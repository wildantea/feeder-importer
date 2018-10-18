<?php
//include "inc/config.php";
include "../../lib/nusoap/nusoap.php";

include "../../inc/config.php";

include "../../lib/prosesupdate/ProgressUpdater.php";


$semester = '';
$kode_mk = '';
if (isset($_POST['semester'])) {
  
  if ($_POST['semester']=='all') {
    $semester = '';
  } else {
    $semester = "and p.id_smt='".$_POST['semester']."'";
  }

  if ($_POST['kode_mk']=='all') {
    $kode_mk = '';
  } else {
    $kode_mk = "and p.id_mk='".$_POST['kode_mk']."'";
  }

}


$config = $db->fetch_single_row('config_user','id',1);

if ($config->live=='Y') {
	$url = 'http://'.$config->url.':'.$config->port.'/ws/live.php?wsdl'; // gunakan live
} else {
	$url = 'http://'.$config->url.':'.$config->port.'/ws/sandbox.php?wsdl'; // gunakan sandbox
}
//untuk coba-coba
// $url = 'http://pddikti.uinsgd.ac.id:8082/ws/live.php?wsdl'; // gunakan live bila

$client = new nusoap_client($url, true);
$proxy = $client->getProxy();


# MENDAPATKAN TOKEN
$username = $config->username;
$password = $config->password;
$result = $proxy->GetToken($username, $password);
$token = $result;

	$id_sp = $config->id_sp;

$id_sms = '';



		$requestData= $_REQUEST;

		$sSearch = $requestData['search']['value'];
		
		//$Data = $this->input->get('columns');
		//$orders = $requestData['order'];
		//$temp_order = 


		$iStart = $requestData['start'];
		$iLength = $requestData['length'];

		$temp_limit = $iLength;
		$temp_offset = $iStart?$iStart : 0;

		$filter = '';

		$kode_prodi = $requestData['jurusan'];

		$prodi = $db->fetch_single_row('jurusan','kode_jurusan',$kode_prodi);
		$id_sms = $prodi->id_sms;
		$filter_kelas = "p.id_sms='".$id_sms."' $semester $kode_mk";

		$temp_total = $proxy->GetCountRecordset($token,"kelas_kuliah",$filter_kelas);

		$totalData = $temp_total['result'];
		//var_dump($temp_total);
		//$totalData = $temp_total['result'];

		if ($semester!='') {
			$order_by = "nm_kls ASC";
		} else {
			$order_by = "id_smt DESC";
		}

		$totalFiltered = $totalData;
		$temp_rec = $proxy->GetRecordset($token,"kelas_kuliah", $filter_kelas,$order_by, $temp_limit,$temp_offset);
		//var_dump($temp_rec);
		$temp_error_code = $temp_rec['error_code'];
		$temp_error_desc = $temp_rec['error_desc'];

		if (($temp_error_code==0) && ($temp_error_desc=='')) {
			$temp_data = array();
			$i=0;
			foreach ($temp_rec['result'] as $key) {
				$temps = array();

				$filter_kelas_nilai = "p.id_kls='".$key['id_kls']."'";
				$jumlah_peserta = $proxy->GetCountRecordset($token,"nilai",$filter_kelas_nilai);
				$jumlah = $jumlah_peserta['result'];

				$filter_ajar_dosen = "p.id_kls='".$key['id_kls']."'";
				$jumlah_pengajar = $proxy->GetCountRecordset($token,"ajar_dosen",$filter_ajar_dosen);
				$jumlah_dosen = $jumlah_pengajar['result'];


				$filter_mat = "id_mk='".$key['id_mk']."'";
				$data_mat = $proxy->GetRecord($token,'mata_kuliah',$filter_mat);
				$kode_mk = '';
				if ($data_mat['result']) {
					$kode_mk = $data_mat['result']['kode_mk'];
					$nama_mk = $data_mat['result']['nm_mk'];
				}
				$temps[] = ++$i+$temp_offset." <input type='checkbox'  class='deleteRow' value='".$key['id_kls']."'/>";
				$temps[] = $key['id_smt'];
				$temps[] = $kode_mk;
				$temps[] = $nama_mk;
				$temps[] = $key['nm_kls'];
				$temps[] = $jumlah;
				$temps[] = $jumlah_dosen;
				$temps[] = $key['id_kls'];
				
				$temp_data[] = $temps;
			}
			$temp_output = array(
									'draw' => intval($requestData['draw']),
									'recordsTotal' => intval( $totalData ),
									'recordsFiltered' => intval( $totalFiltered ),
									'data' => $temp_data
				);
			echo json_encode($temp_output);
}