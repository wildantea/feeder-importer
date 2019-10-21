<?php
session_start();
//include "inc/config.php";
include "../../lib/nusoap/nusoap.php";

include "../../inc/config.php";


$requestData= $_REQUEST;


$sSearch = $requestData['search']['value'];

$data_sms = $db->query("select * from jurusan");
foreach ($data_sms as $dts) {
	$dts_sms[$dts->id_sms] = $dts->jenjang.' '.$dts->nama_jurusan;
	$dts_jur[$dts->kode_jurusan] = $dts->id_sms;
}

$angkatan = "";
$id_sms = "";
if (isset($_POST['angkatan'])) {
  
  if ($_POST['angkatan']=='all') {
    	$angkatan = "";
      	if ($_POST['jurusan']!='all') {
			$id_sms = "p.id_sms='".$dts_jur[$_POST['jurusan']]."'";
  		} 
  
  } else {
    $angkatan = "p.mulai_smt='".$_POST['angkatan']."'";
   		if ($_POST['jurusan']!='all') {
	 		$id_sms = "and p.id_sms='".$dts_jur[$_POST['jurusan']]."'";
  		} 
  
  }

  	$filter_kelas = "$angkatan $id_sms";
} else {
		if (isset($_POST['id_sms_user'])) {
			$filter_kelas = "p.id_sms='".$dts_jur[$_POST['id_sms_user']]."'";
		}
	
}




$semester = '';
$kode_mk = '';
$nama = "";
if ($sSearch) {

	if ($filter_kelas!="") {
		$filter_kelas .= "and (nipd like '%".$sSearch."%' or lower(nm_pd) like '%".strtolower($sSearch)."%')";
	} else {
		$filter_kelas .= "nipd like '%".$sSearch."%' or lower(nm_pd) like '%".strtolower($sSearch)."%'";
		$nama = "yes";
	
	}
}

//echo $filter_kelas;


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

		

		
		$order_by = "";

		//print_r($temp_total);
		
		if (trim($filter_kelas)!="") {
			if ($nama=="yes") {
				$temp_total = $proxy->GetCountRecordset($token,"mahasiswa",trim($filter_kelas));
				$totalData = $temp_total['result'];
				$totalFiltered = $totalData;

				$temp_rec = $proxy->GetListMahasiswa($token, trim($filter_kelas),$order_by, $temp_limit,$temp_offset);
			} else {
				$order_by = "mulai_smt DESC";
				$temp_total = $proxy->GetCountRecordset($token,"mahasiswa_pt",trim($filter_kelas));
				$totalData = $temp_total['result'];
				$totalFiltered = $totalData;
				$temp_rec = $proxy->GetRecordset($token,"mahasiswa_pt", trim($filter_kelas),$order_by, $temp_limit,$temp_offset);
			}

		} else {

				$temp_total = $proxy->GetCountRecordset($token,"mahasiswa",trim($filter_kelas));
				$totalData = $temp_total['result'];
				$totalFiltered = $totalData;
			$temp_rec = $proxy->GetListMahasiswa($token, trim($filter_kelas),$order_by, $temp_limit,$temp_offset);
		}

			
		
		//var_dump($temp_rec);
		$temp_error_code = $temp_rec['error_code'];
		$temp_error_desc = $temp_rec['error_desc'];

		if (($temp_error_code==0) && ($temp_error_desc=='')) {
			$temp_data = array();
			$i=0;

			$prodi = "";
			$angkat = "";
			$jenis_keluar = "";


			foreach ($temp_rec['result'] as $key) {


				

				if (trim($filter_kelas)!="") {
					if ($nama=="yes") {
						$prodi = $key['nm_lemb'];
						$angkat = $key['mulai_smt'];
						$jenis_keluar = $key['nm_stat_mhs'];
					} else {
						$prodi = $dts_sms[$key['id_sms']];
						$angkat = $key['mulai_smt'];
						if ( $key['fk__jns_keluar']=="") {
							$jenis_keluar = "Aktif";
						} else {
							$jenis_keluar = $key['fk__jns_keluar'];
						}
					}


				} else {
					$prodi = $key['nm_lemb'];
					$angkat = $key['mulai_smt'];
					$jenis_keluar = $key['nm_stat_mhs'];
				}
				

				$temps = array();
				$temps[] = ++$i+$temp_offset." <input type='checkbox'  class='deleteRow' value='".$key['id_pd']."'/>";

				$temps[] = $key['nm_pd'];
				$temps[] = $key['nipd'];
				$temps[] = $key['tgl_lahir'];
				$temps[] = $angkat;
				$temps[] = $jenis_keluar;
				$temps[] = $prodi;
				$temps[] = $key['id_pd'];
			
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