<?php
include "../../inc/config.php";
include "../../lib/nusoap/nusoap.php";

 $config = $db->fetch_single_row('config_user','id',1);


if ($config->live=='Y') {
  $url = 'http://'.$config->url.':'.$config->port.'/ws/live.php?wsdl'; // gunakan live
} else {
  $url = 'http://'.$config->url.':'.$config->port.'/ws/sandbox.php?wsdl'; // gunakan sandbox
}


  $client = new nusoap_client($url, true);
  $proxy = $client->getProxy();



  # MENDAPATKAN TOKEN
  $username = $config->username;
  $password = $config->password;
  $result = $proxy->GetToken($username, $password);
  $token = $result;




switch ($_GET["act"]) {
  case 'delete_all':
   $prodi = $db->fetch_single_row('jurusan','kode_jurusan',$_POST['id'])->kode_jurusan;
   $filter_sp = "npsn='".$config->id_sp."'";
	$get_id_sp = $proxy->GetRecord($token,'satuan_pendidikan',$filter_sp);

	$id_sp = $get_id_sp['result']['id_sp'];

  $filter_sms = "id_sp='".$id_sp."' and kode_prodi ilike '%".$prodi."%'";
    $temp_sms = $proxy->GetRecord($token,'sms',$filter_sms);
    if ($temp_sms['result']) {
      $id_sms = $temp_sms['result']['id_sms'];
    }
  $filter_semester = "p.id_sms='".$id_sms."' and p.id_smt='".$_POST['sem']."'";
  $all_kelas = $proxy->GetRecordset($token,'kelas_kuliah',$filter_semester,'','','');
      foreach($all_kelas['result'] as $id) {
        $id_kls = $id['id_kls'];
        //hapus dosen ajar
  $filter_dosen = "p.id_kls='".$id_kls."'";
    $temp_dosen = $proxy->GetRecordset($token,'ajar_dosen',$filter_dosen,'','','');
    foreach ($temp_dosen['result'] as $reg) {
      $hapus_ajar = array(
      'id_ajar' => $reg['id_ajar'],
      );
       $temp_res = $proxy->DeleteRecord($token, 'ajar_dosen', json_encode($hapus_ajar));
     }

  //hapus krs
  $filter_nilai = "p.id_kls='".$id_kls."'";
    $temp_sms = $proxy->GetRecordset($token,'nilai',$filter_nilai,'','','');
    foreach ($temp_sms['result'] as $reg) {
      $hapus = array(
      'id_kls' => $reg['id_kls'],
      'id_reg_pd'=>$reg['id_reg_pd']
      );
    //print_r($hapus);
    $temp_result = $proxy->DeleteRecord($token, 'nilai', json_encode($hapus));

   // print_r($temp_result);
    
    }
  //hapus kelas 
   $hapus = array(
      'id_kls' => $id_kls,
      );
    //print_r($hapus);
    $temp_result = $proxy->DeleteRecord($token, 'kelas_kuliah', json_encode($hapus));


      }

    break;
  case "delete":
  $id_kls = $_GET["id"];
  //hapus dosen ajar
  $filter_dosen = "p.id_kls='".$id_kls."'";
    $temp_dosen = $proxy->GetRecordset($token,'ajar_dosen',$filter_dosen,'','','');
    foreach ($temp_dosen['result'] as $reg) {
      $hapus_ajar[] = array(
      'id_ajar' => $reg['id_ajar'],
      );
     }
  $temp_res = $proxy->DeleteRecordset($token, 'ajar_dosen', json_encode($hapus_ajar));


  //hapus krs
  $filter_nilai = "p.id_kls='".$id_kls."'";
    $temp_sms = $proxy->GetRecordset($token,'nilai',$filter_nilai,'','','');
    foreach ($temp_sms['result'] as $reg) {
      $hapus[] = array(
      'id_kls' => $reg['id_kls'],
      'id_reg_pd'=>$reg['id_reg_pd']
      );
    //print_r($hapus);
   

   // print_r($temp_result);
    
    }
 $temp_result = $proxy->DeleteRecordset($token, 'nilai', json_encode($hapus));
  //hapus kelas 
   $hapus = array(
      'id_kls' => $id_kls,
      );
    //print_r($hapus);
    $temp_result = $proxy->DeleteRecord($token, 'kelas_kuliah', json_encode($hapus));
  break;

  case 'del_massal':
     $data_ids = $_REQUEST['data_ids'];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {

      foreach($data_id_array as $id_kls) {

        //hapus dosen ajar
  $filter_dosen = "p.id_kls='".$id_kls."'";
    $temp_dosen = $proxy->GetRecordset($token,'ajar_dosen',$filter_dosen,'','','');
    foreach ($temp_dosen['result'] as $reg) {
      $hapus_ajar[] = array(
      'id_ajar' => $reg['id_ajar'],
      );  
     }

$temp_res = $proxy->DeleteRecordset($token, 'ajar_dosen', json_encode($hapus_ajar));
  //hapus krs
  $filter_nilai = "p.id_kls='".$id_kls."'";
    $temp_sms = $proxy->GetRecordset($token,'nilai',$filter_nilai,'','','');
    foreach ($temp_sms['result'] as $reg) {
      $hapus[] = array(
      'id_kls' => $reg['id_kls'],
      'id_reg_pd'=>$reg['id_reg_pd']
      );
    //print_r($hapus);
   
   // print_r($temp_result);
    
    }
 $temp_result = $proxy->DeleteRecordset($token, 'nilai', json_encode($hapus));

  //hapus kelas 
   $hapus = array(
      'id_kls' => $id_kls,
      );
    //print_r($hapus);
    $temp_result = $proxy->DeleteRecord($token, 'kelas_kuliah', json_encode($hapus));


      }
 $hapus_ajar = array();
$hapus = array();
    }
    break;

}