<?php
include "../../inc/config.php";

$token = get_token();
$url = $db->get_service_url('rest');



switch ($_GET["act"]) {
  case 'delete_all':
  if ($_POST['jurusan']!='all') {
       $id_sms = "p.id_sms='".$_POST['jurusan']."' and ";
  } else {
    $id_sms = "";
  }

   
  $filter_semester = "$id_sms p.id_smt='".$_POST['sem']."'";
  $all_kelas = $proxy->GetRecordset($token,'kelas_kuliah',$filter_semester,'','','');
  if ($all_kelas['result']) {
    
 
      foreach($all_kelas['result'] as $id) {
        $id_kls = $id['id_kls'];
        //hapus dosen ajar
  $filter_dosen = "p.id_kls='".$id_kls."'";
    $temp_dosen = $proxy->GetRecordset($token,'ajar_dosen',$filter_dosen,'','','');
    foreach ($temp_dosen['result'] as $reg) {
      $hapus_ajar[] = array(
      'id_ajar' => $reg['id_ajar'],
      );
      
     }

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
  //hapus kelas 
   $hapus_kelas[] = array(
      'id_kls' => $id_kls,
      );
    //print_r($hapus);
  

      }
    $temp_res = $proxy->DeleteRecordset($token, 'ajar_dosen', json_encode($hapus_ajar));
    $temp_result = $proxy->DeleteRecordset($token, 'nilai', json_encode($hapus));
    $temp_result = $proxy->DeleteRecordset($token, 'kelas_kuliah', json_encode($hapus));

 }

    break;
  case "delete":
  $id_kls = $_GET["id"];
  //hapus dosen ajar
              $temp_data_kelas = [
                'act' => 'GetDosenPengajarKelasKuliah',
                  'token' => $token,
                  'filter' => "id_kelas_kuliah='$id_kls'",
                  'order' => '',
                  'limit' => '',
                  'offset' => ''
              ];

        $temp_rec = json_decode($db->run($temp_data_kelas,$url));
        if ($temp_rec->data) {
          foreach ($temp_rec->data as $key) {
                $temp_del_dosen = [
                'act' => 'DeleteDosenPengajarKelasKuliah',
                  'token' => $token,
                  'key' => array('id_aktivitas_mengajar' => $key->id_aktivitas_mengajar)
              ];

                  $temp_del = json_decode($db->run($temp_del_dosen,$url));
                  dump($temp_del);
          }
        }

  //hapus GetKRSMahasiswa
              $temp_data_kelas = [
                'act' => 'GetKRSMahasiswa',
                  'token' => $token,
                  'filter' => "id_kelas='$id_kls'",
                  'order' => '',
                  'limit' => '',
                  'offset' => ''
              ];

        $temp_rec = json_decode($db->run($temp_data_kelas,$url));
        if ($temp_rec->data) {
          foreach ($temp_rec->data as $key) {
                $temp_del_dosen = [
                'act' => 'DeletePesertaKelasKuliah',
                  'token' => $token,
                  'key' => array(
                    'id_kelas_kuliah' => $key->id_kelas,
                    'id_registrasi_mahasiswa' => $key->id_registrasi_mahasiswa)
              ];

                  $temp_del = json_decode($db->run($temp_del_dosen,$url));
                  dump($temp_del);
          }
        }
  //hapus kelas 
    $temp_data_kelas = [
      'act' => 'DeleteKelasKuliah',
        'token' => $token,
        'key' => array('id_kelas_kuliah' => $id_kls)
    ];

        $temp_del = json_decode($db->run($temp_data_kelas,$url));
        dump($temp_del);

  break;

  case 'del_massal':
     $data_ids = $_REQUEST['data_ids'];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {

      foreach($data_id_array as $id_kls) {
 //hapus dosen ajar
              $temp_data_kelas = [
                'act' => 'GetDosenPengajarKelasKuliah',
                  'token' => $token,
                  'filter' => "id_kelas_kuliah='$id_kls'",
                  'order' => '',
                  'limit' => '',
                  'offset' => ''
              ];



        $temp_rec = json_decode($db->run($temp_data_kelas,$url));
        if ($temp_rec->data) {
          foreach ($temp_rec->data as $key) {
                $temp_del_dosen = [
                'act' => 'DeleteDosenPengajarKelasKuliah',
                  'token' => $token,
                  'key' => array('id_aktivitas_mengajar' => $key->id_aktivitas_mengajar)
              ];

                  $temp_del = json_decode($db->run($temp_del_dosen,$url));
                  dump($temp_del);
          }
        }

  //hapus GetKRSMahasiswa
              $temp_data_krs = [
                'act' => 'GetPesertaKelasKuliah',
                  'token' => $token,
                  'filter' => "id_kelas_kuliah='$id_kls'",
                  'order' => '',
                  'limit' => '',
                  'offset' => ''
              ];

        $temp_rec_krs = service_request($temp_data_krs);
        dump($temp_data_krs);
           dump($temp_rec_krs);
        if (!empty($temp_rec_krs->data)) {
          foreach ($temp_rec_krs->data as $key_dt) {
                $temp_del_krs = [
                'act' => 'DeletePesertaKelasKuliah',
                  'token' => $token,
                  'key' => array(
                    'id_kelas_kuliah' => $key_dt->id_kelas_kuliah,
                    'id_registrasi_mahasiswa' => $key_dt->id_registrasi_mahasiswa)
              ];
                dump($temp_del_krs);
                  $temp_del = json_decode($db->run($temp_del_krs,$url));
                  dump($temp_del);
          }
        }
  //hapus kelas 
    $temp_data_kelas = [
      'act' => 'DeleteKelasKuliah',
        'token' => $token,
        'key' => array('id_kelas_kuliah' => $id_kls)
    ];

        $temp_del = json_decode($db->run($temp_data_kelas,$url));
        dump($temp_del);
      }

    }
    break;

}