<?php
include "../../inc/config.php";
include "../../lib/nusoap/nusoap.php";

 $config = $db->fetch_single_row('config_user','id',1);


  $url = 'http://'.$config->url.':8082/ws/live.php?wsdl'; // gunakan sandbox
  //untuk coba-coba
  // $url = 'http://pddikti.uinsgd.ac.id:8082/ws/live.php?wsdl'; // gunakan live bila

  $client = new nusoap_client($url, true);
  $proxy = $client->getProxy();



  # MENDAPATKAN TOKEN
  $username = $config->username;
  $password = $config->password;
  $result = $proxy->GetToken($username, $password);
  $token = $result;


$id_jur = $_POST['jurusan'];
$semester = $_POST['semester'];

 $prodi = $db->fetch_single_row('jurusan','kode_jurusan',$id_jur);

	$id_sp = $config->id_sp;
  $id_sms = $prodi->id_sms;
  
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
