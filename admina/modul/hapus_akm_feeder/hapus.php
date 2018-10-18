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

  $filter_nim = "id_smt='".$_POST['sem']."'";

  $data_kuliah = $proxy->GetRecordset($token,'kuliah_mahasiswa', $filter_nim,$order,$limit,$offset);

    foreach ($data_kuliah['result'] as $dt) {
       $hapus = array(
          'id_smt' => $dt['id_smt'],
          'id_reg_pd'=>$dt['id_reg_pd']
          );
       $temp_res = $proxy->DeleteRecord($token, 'kuliah_mahasiswa', json_encode($hapus));
     }

    break;
  case "delete":
  $id_akm_pd = $_GET["id"];

  $exp = explode("_", $id_akm_pd);

   $hapus = array(
      'id_smt' => $exp[0],
      'id_reg_pd'=>$exp[1]
      );

      
    //print_r($hapus);
    $temp_result = $proxy->DeleteRecord($token, 'kuliah_mahasiswa', json_encode($hapus));


  break;

  case 'del_massal':
     $data_ids = $_REQUEST['data_ids'];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {

      foreach($data_id_array as $id_kls) {

    $exp = explode("_", $id_kls);

    $hapus = array(
      'id_smt' => $exp[0],
      'id_reg_pd'=>$exp[1]
      );


   // print_r($hapus);

    $temp_result = $proxy->DeleteRecord($token, 'kuliah_mahasiswa', json_encode($hapus));



      }

    }
    break;

}