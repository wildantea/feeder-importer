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


$id_jur = $_POST['jurusan'];
$semester = $_POST['semester'];

 $prodi = $db->fetch_single_row('jurusan','kode_jurusan',$id_jur)->kode_jurusan_dikti;


  //get id npsn
  $filter_sp = "npsn='".$config->id_sp."'";
  $get_id_sp = $proxy->GetRecord($token,'satuan_pendidikan',$filter_sp);

  $id_sp = $get_id_sp['result']['id_sp'];

    $temp_sms = $proxy->GetRecord($token,'sms',$filter_sms);


    if ($temp_sms['result']) {
      $id_sms = $temp_sms['result']['id_sms'];
    }
    $filter_kelas = "p.id_sms='".$id_sms."' and p.id_smt='".$semester."'";

$kelas = $proxy->GetRecordset($token,"kelas_kuliah", $filter_kelas,"id_smt DESC", '','');

foreach ($kelas['result'] as $data_kelas) {
    $array_kode_mk[] = $data_kelas['id_mk'];
}
$kode_mk_group = array_unique($array_kode_mk);

  foreach ($kode_mk_group as $key) {
   

     $filter_mat = "id_mk='".$key."'";
        $data_mat = $proxy->GetRecord($token,'mata_kuliah',$filter_mat);

      $matkul[] = array(
        'id_mk' => $data_mat['result']['id_mk'],
        'nm_mk' => $data_mat['result']['nm_mk']
        );

  }

echo '<option value="all">Semua</option>';
foreach ($matkul as $isi) {
echo "<option value='".$isi['id_mk']."'>".$isi['nm_mk']."</option>";
} 
