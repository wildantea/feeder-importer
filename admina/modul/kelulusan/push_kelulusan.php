<?php
include "../../lib/nusoap/nusoap.php";

include "../../inc/config.php";

include "../../lib/prosesupdate/ProgressUpdater.php";

$options = array(
    'filename' => $_GET['jurusan'].'_progress.json',
    'autoCalc' => true,
    'totalStages' => 1
);

$pu = new Manticorp\ProgressUpdater($options);
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

//$token = 'acdbbc82c3b29f99e9096dab1d5eafb4';


  $id_sms = '';
  $id_mk = '';
  $sks_mk = '';
  $sks_tm = '';
  $sks_prak = '';
  $sks_prak_lap = '';
  $sks_sim = '';
  $temp_data = array();
  $sukses_count = 0;
  $sukses_msg = '';
  $error_count = 0;
  $error_msg = array();
  $data_id = array();
  $error_id = array();


  $id_sp = $config->id_sp;

  $jur = $_GET['jurusan'];

  $arr_data = $db->query("select * from kelulusan where kode_jurusan='$jur' and status_error!='1'");

$stageOptions = array(
    'name' => 'This AJAX process takes a long time',
    'message' => 'But this will keep the user updated on it\'s actual progress!',
    'totalItems' => $arr_data->rowCount(),
);


$pu->nextStage($stageOptions);



$i=1;

  foreach ($arr_data as $value) {


    $nim = $value->nim;
    $filter_npm = "nipd like '%".$nim."%'";
    $temp_npm = $proxy->GetRecord($token,'mahasiswa_pt',$filter_npm);

    if ($temp_npm['result']) {
     

      $id_reg_pd = $temp_npm['result']['id_reg_pd'];
      $array_key = array('id_reg_pd' => $id_reg_pd);
       if ($value->id_jenis_keluar==1) {
          $array_data = array(
            'id_jns_keluar' => $value->id_jenis_keluar,
            'tgl_keluar' => $value->tanggal_keluar,
            'sk_yudisium' => $value->sk_yudisium,
            'tgl_sk_yudisium' => $value->tgl_sk_yudisium,
            'ipk' => $value->ipk,
            'smt_yudisium' => $value->semester,
            'no_seri_ijazah' => $value->no_seri_ijasah
                );
      } else {
          $array_data = array(
            'id_jns_keluar' => $value->id_jenis_keluar,
            'tgl_keluar' => $value->tanggal_keluar,
            'sk_yudisium' => '',
            'tgl_sk_yudisium' => '',
            'ipk' => '',
            'smt_yudisium' => $value->semester,
            'no_seri_ijazah' => ''
                );
      }
           
      $final_up = array('key' => $array_key, 'data' => $array_data
        );
      $up_result = $proxy->UpdateRecord($token, 'mahasiswa_pt', json_encode($final_up));
      

      if ($up_result['result']['error_desc']==NULL) {
                  ++$sukses_count;
                  $db->update('kelulusan',array('status_error'=>1,'keterangan'=>''),'id',$value->id);
                } else {
                  ++$error_count;
                  $error_msg[] = "<b>Error $nim </b>".$up_result['result']['error_desc'];
                  $db->update('kelulusan',array('status_error' => 2, 'keterangan'=>$up_result['result']['error_desc']),'id',$value->id);
                }         

    } else {
             ++$error_count;
                  $error_msg[] = "<b>Error Mahasiswa dengan nim $nim tidak ada di feeder</b>";
                  $db->update('kelulusan',array('status_error' => 2, 'keterangan'=>"Error mahasiswa ini tidak ada di feeder"),'id',$value->id);
    }


      $i++;
   $pu->incrementStageItems(1, true);

 
          }



$msg = '';
if ((!$sukses_count==0) || (!$error_count==0)) {
  $msg =  "<div class=\"alert alert-warning \" role=\"alert\">
      <font color=\"#3c763d\">".$sukses_count." data Kelulusan baru berhasil di Upload</font><br />
      <font color=\"#ce4844\" >".$error_count." data tidak bisa diupload </font>";
      
      if (!$error_count==0) {
        $msg .= "<a data-toggle=\"collapse\" href=\"#collapseExample\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail error</a>";
      }
      //echo "<br />Total: ".$i." baris data";
      $msg .= "<div class=\"collapse\" id=\"collapseExample\">";
          $i=1;
          foreach ($error_msg as $pesan) {
              $msg .= "<div class=\"bs-callout bs-callout-danger\">".$i.". ".$pesan."</div><br />";
            $i++;
            }
      $msg .= "</div>
    </div>";
}

$pu->totallyComplete($msg);


//$pu->totallyComplete();

