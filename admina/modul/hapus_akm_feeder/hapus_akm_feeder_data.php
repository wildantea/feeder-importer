<?php
session_start();
//include "inc/config.php";
include "../../inc/config.php";


$config = $db->fetch_single_row('config_user','id',1);

if ($config->live=='Y') {
	$url = 'http://'.$config->url.':'.$config->port.'/ws/live2.php'; // gunakan live
} else {
	$url = 'http://'.$config->url.':'.$config->port.'/ws/sandbox2.php'; // gunakan sandbox
}
//untuk coba-coba
// $url = 'http://pddikti.uinsgd.ac.id:8082/ws/live.php?wsdl'; // gunakan live bila

$data = array(
  'act' => 'GetToken',
  'username' => $config->username,
  'password' => $config->password
);
$result = json_decode($db->run($data,$url));
$token = $result->data->token;
$data_sms = $db->query("select * from jurusan");
foreach ($data_sms as $dts) {
	$dts_sms[$dts->id_sms] = $dts->jenjang.' '.$dts->nama_jurusan;
	$dts_jur[$dts->kode_jurusan] = $dts->id_sms;
}

$filter = "";
$semester = "";
$status = "";
$id_sms = "";
if (isset($_POST['semester'])) {

	  if ($_POST['semester']=='all') {
    $semester ="";
  } else {
    $semester = "id_semester='".$_POST['semester']."' and";
  }


	if ($_POST['jurusan']!='all') {
		
		$id_sms = "id_prodi='".$_POST['jurusan']."' and";
	} else {
		if ($_SESSION['level']!=1) {
			
			$id_sms = "id_prodi='".$_POST['jurusan']."' and";
		}
	}
  


  if ($_POST['status']=='all') {
    $status = "";
  } else {
    $status = "id_status_mahasiswa='".$_POST['status']."'";
  }


} else {
		if (isset($_POST['id_sms_user'])) {
			$id_sms = "id_prodi='".$dts_jur[$_POST['id_sms_user']]."'";
		}

}

  $filter = "$semester $id_sms $status";


$filter = trim($filter);
//echo $filter_kelulusan;

if ($filter!="") {
	$split = explode(" ", $filter);
	if (end($split)=='and') {
		array_pop($split);
	}
	$filter = implode(" ", $split);
}




		$requestData= $_REQUEST;

		$sSearch = $requestData['search']['value'];
		
		//$Data = $this->input->get('columns');
		//$orders = $requestData['order'];
		//$temp_order = 


		$iStart = $requestData['start'];
		$iLength = $requestData['length'];

		$temp_limit = $iLength;
		$temp_offset = $iStart?$iStart : 0;

$sSearch = addslashes($sSearch);

		if ($sSearch) {

	if ($filter!="") {
		$filter .= "and (nim like '%".$sSearch."%' or nama_mahasiswa like E'%".$sSearch."%')";
	} else {
		$filter .= "nim like '%".$sSearch."%' or nama_mahasiswa like E'%".$sSearch."%'";
	
	}
}

		
		$order_by = "id_semester desc";

				$temp_data_akm = [
			'act' => 'GetListPerkuliahanMahasiswa',
		    'token' => $token,
		    'filter' => $filter,
		    'order' => "",
		    'limit' => $temp_limit,
		    'offset' => $temp_offset

		];


		$temp_data = json_decode($db->run($temp_data_akm,$url));



		$count_akm = [
			'act' => 'GetCountPerkuliahanMahasiswa',
		    'token' => $token,
		    'filter' => $filter
		];

		
		$temp_recs = json_decode($db->run($count_akm,$url));

		$totalData = $temp_recs->data;
		$totalFiltered = $totalData;

		$temp_datas = array();
		$i=0;
		
		foreach ($temp_data->data as $dt) {
			
						$temps = array();
					$temps[] = ++$i+$temp_offset." <input type='checkbox'  class='deleteRow' value='".$dt->id_semester."_".$dt->id_registrasi_mahasiswa."'/>";
					$temps[] = $dt->nim;
					$temps[] = $dt->nama_mahasiswa;
					$temps[] = $dt->nama_semester;
					$temps[] = $dt->angkatan;
	                $temps[] = $dt->ips;
	                $temps[] = $dt->ipk;
	                $temps[] = $dt->sks_semester;
	                $temps[] = $dt->sks_total;
	                $temps[] = $dt->nama_status_mahasiswa;
	                $temps[] = $dt->nama_program_studi;
	                $temps[] = $dt->id_semester."_". $dt->id_registrasi_mahasiswa;
					
				$temp_datas[] = $temps;
			}
			$temp_output = array(
									'draw' => intval($requestData['draw']),
									'recordsTotal' => intval( $totalData ),
									'recordsFiltered' => intval( $totalFiltered ),
									'data' => $temp_datas
				);

			echo json_encode($temp_output);