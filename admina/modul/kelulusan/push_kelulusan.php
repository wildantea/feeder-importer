<?php
include "../../inc/config.php";
include "../../lib/prosesupdate/ProgressUpdater.php";
$options = array(
    'filename' => $_GET['jurusan'].'_progress.json',
    'autoCalc' => true,
    'totalStages' => 1
);

$pu = new Manticorp\ProgressUpdater($options);
$token = get_token();

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
  $jur = $_GET['jurusan'];

  $arr_data = $db->query("select kelulusan.*,id_sms from kelulusan inner join jurusan on kelulusan.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and status_error!='1'");

$stageOptions = array(
    'name' => 'This AJAX process takes a long time',
    'message' => 'But this will keep the user updated on it\'s actual progress!',
    'totalItems' => $arr_data->rowCount(),
);


$pu->nextStage($stageOptions);



$i=1;

  foreach ($arr_data as $value) {
    $nim = $value->nim;
    $id_sms = $value->id_sms;
    $filter_pd = "trim(nim)='".$nim."' and id_prodi='".$id_sms."'";
      $data_req_mat = [
        'act' => 'GetListRiwayatPendidikanMahasiswa',
          'token' => $token,
          'filter' => $filter_pd,
          'order' => "",
          'limit' => "",
          'offset' => ""

      ];
    $temp_npm = service_request($data_req_mat);
    if (!empty($temp_npm->data)) {
      $id_reg_pd = $temp_npm->data[0]->id_registrasi_mahasiswa;
      $array_key = array('id_reg_pd' => $id_reg_pd);
      $array_data = array(
        'id_registrasi_mahasiswa' => $id_reg_pd,
        'id_jenis_keluar' => $value->id_jenis_keluar,
        'tanggal_keluar' => $value->tanggal_keluar,
        'id_periode_keluar' => $value->semester,
        'keterangan' => $value->ket,
        'nomor_sk_yudisium' => $value->sk_yudisium,
        'tanggal_sk_yudisium' => $value->tgl_sk_yudisium,
        'ipk' => $value->ipk,
        'nomor_ijazah' => $value->no_seri_ijasah
            );
      $data_dic = [
          'act' => 'InsertMahasiswaLulusDO',
            'token' => $token,
            'record' => $array_data,
        ];
      $up_result = service_request($data_dic);
      if ($up_result->error_desc=='') {
          ++$sukses_count;
          $db->update('kelulusan',array('status_error'=>1,'keterangan'=>''),'id',$value->id);
      } else {
          ++$error_count;
          $error_msg[] = $up_result->error_desc;
          $db->update('kelulusan',array('status_error' => 2, 'keterangan'=> $up_result->error_desc),'id',$value->id);
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

