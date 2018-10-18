<?php
include "../../inc/config.php";
include "../../lib/nusoap/nusoap.php";

$config = $db->fetch_single_row('config_user','id',1);
    //soap
    $client = new nusoap_client($db->get_service_url('soap'), true);
    $proxy = $client->getProxy();



  # MENDAPATKAN TOKEN
  $token = $db->get_token();


switch ($_GET["act"]) {
  case 'delete_all':
   $prodi = $_POST['jurusan'];
    //get id npsn
  $id_sp = $config->id_sp;

         $filter_sms = "id_sp='".$id_sp."' and trim(kode_prodi)='".trim($prodi)."'";
    $temp_sms = $proxy->GetRecord($token,'sms',$filter_sms);
    if ($temp_sms['result']) {
      $id_sms = $temp_sms['result']['id_sms'];
    }
  $filter_semester = "id_prodi='".$id_sms."' and id_periode='".$_POST['data_ids']."'";
  $all_kelas = $db->get_data_services('GetListMahasiswa',$filter_semester,'','','');
      foreach($all_kelas as $id) {
      $id_reg_pd = $id->id_registrasi_mahasiswa;
      $id_pd = $id->id_mahasiswa;

    $filter_nilai = "p.id_reg_pd='".$id_reg_pd."'";
    $temp_sms = $proxy->GetRecordset($token,'nilai',$filter_nilai,'','','');
    foreach ($temp_sms['result'] as $reg) {
      $hapus_nilai[] = array(
      'id_kls' => $reg['id_kls'],
      'id_reg_pd'=>$reg['id_reg_pd']
      );  
 
    }
        // print_r($hapus);
    $temp_result = $proxy->DeleteRecord($token, 'nilai', json_encode($hapus_nilai));
      print_r($temp_result);


  $filter_akm = "p.id_reg_pd='".$id_reg_pd."'";
    $temp_akm = $proxy->GetRecordset($token,'kuliah_mahasiswa',$filter_akm,'','','');
    foreach ($temp_akm['result'] as $reg) {
      $hapus[] = array(
      'id_smt' => $reg['id_smt'],
      'id_reg_pd'=>$reg['id_reg_pd']
      );
  //  print_r($hapus);
   
  }
   $temp_result = $proxy->DeleteRecord($token, 'kuliah_mahasiswa', json_encode($hapus));
    print_r($temp_result);




      $hapus = array(
        'id_reg_pd'=>$id_reg_pd
      );
  //  print_r($hapus);
    $temp_result = $proxy->DeleteRecord($token, 'mahasiswa_pt', json_encode($hapus));
    print_r($temp_result);
  
   $hapus = array(     
      'id_pd'=>$id_pd
      );
  $temp_result = $proxy->DeleteRecord($token, 'mahasiswa', json_encode($hapus));
  print_r($temp_result);

      }

    break;
  case "delete":


        $data_param = array(
            'act' => 'GetListMahasiswa',
            'filter' => "id_mahasiswa='".$_GET['id']."'"
        );
        $check_nim_exist = $db->get_data_service($data_param);

    if ($check_nim_exist) {
        $id_pd = $check_nim_exist->id_mahasiswa;
        $id_reg_pd = $check_nim_exist->id_registrasi_mahasiswa;
          $hapus = array(
            'id_reg_pd'=>$id_reg_pd
          );


    $filter_nilai = "p.id_reg_pd='".$id_reg_pd."'";
    $temp_nilai = $proxy->GetRecordset($token,'nilai',$filter_nilai,'','','');
    //hapus nilai
    if (!empty($temp_nilai['result'])) {
          foreach ($temp_nilai['result'] as $reg) {
            $hapus_nilai[] = array(
            'id_kls' => $reg['id_kls'],
            'id_reg_pd'=>$reg['id_reg_pd']
            );  
          }

          $temp_result = $proxy->DeleteRecordset($token, 'nilai', json_encode($hapus_nilai));
           print_r($temp_result);
    }

    $filter_trf = "p.id_reg_pd='".$id_reg_pd."'";
    $temp_nilai_trf = $proxy->GetRecordset($token,'nilai_transfer',$filter_trf,'','','');
    //hapus nilai
    if (!empty($temp_nilai_trf['result'])) {
          foreach ($temp_nilai_trf['result'] as $reg) {
            $hapus_nilai_trf[] = array(
            'id_ekuivalensi' => $reg['id_ekuivalensi'],
            'id_reg_pd'=>$reg['id_reg_pd']
            );  
          }

          $temp_result = $proxy->DeleteRecordset($token, 'nilai_transfer', json_encode($hapus_nilai_trf));
           print_r($temp_result);
    }




     
  $filter_akm = "p.id_reg_pd='".$id_reg_pd."'";
    $temp_akm = $proxy->GetRecordset($token,'kuliah_mahasiswa',$filter_akm,'','','');

      if (!empty($temp_akm['result'])) {

    foreach ($temp_akm['result'] as $reg) {
      $hapus_akm[] = array(
      'id_smt' => $reg['id_smt'],
      'id_reg_pd'=>$reg['id_reg_pd']
      );
 
   }


     print_r($hapus_akm);
    $temp_result = $proxy->DeleteRecordset($token, 'kuliah_mahasiswa', json_encode($hapus_akm));
    print_r($temp_result);

  }

    $filter_dosen = "p.id_reg_pd='".$id_reg_pd."'";
    $temp_akm = $proxy->GetRecordset($token,'dosen_pembimbing',$filter_dosen,'','','');

      if (!empty($temp_dosen['result'])) {

    foreach ($temp_dosen['result'] as $reg) {
      $hapus_dosen[] = array(
      'id_sdm' => $reg['id_sdm'],
      'id_reg_pd'=>$reg['id_reg_pd']
      );
 
   }

 
     print_r($hapus_dosen);
    $temp_result = $proxy->DeleteRecordset($token, 'kuliah_mahasiswa', json_encode($hapus_dosen));
    print_r($temp_result);

  }




          print_r($hapus);
        $temp_result = $proxy->DeleteRecord($token, 'mahasiswa_pt', json_encode($hapus));
        print_r($temp_result);


        $data_reg = $db->get_data_services('GetListAnggotaAktivitasMahasiswa',"id_registrasi_mahasiswa='$id_reg_pd'",'','','');
          
          foreach($data_reg as $id) {
          
          $id_anggota = $id->id_anggota;
          $hapus_anggota[] = array(
            'id_ang_akt_mhs' => $id_anggota
            );  
          }

          $temp_result = $proxy->DeleteRecordset($token, 'anggota_aktivitas_mahasiswa', json_encode($hapus_anggota));
           print_r($temp_result);


    }


 

  
   $hapus = array(     
      'id_pd'=>$_GET['id']
      );
  $temp_result = $proxy->DeleteRecord($token, 'mahasiswa', json_encode($hapus));
  print_r($temp_result);

  break;

  case 'del_massal':
     $data_ids = $_REQUEST['data_ids'];
    $data_id_array = explode(",", $data_ids);

    if(!empty($data_id_array)) {
      foreach($data_id_array as $id) {


      $id_pd = $id;


        $data_param = array(
            'act' => 'GetListMahasiswa',
            'filter' => "id_mahasiswa='".$id."'"
        );
        $check_nim_exist = $db->get_data_service($data_param);

    if ($check_nim_exist) {
      
      $id_reg_pd = $check_nim_exist->id_registrasi_mahasiswa;
      $hapus_mhs_pt[] = array(
        'id_reg_pd'=>$id_reg_pd
      );





    $filter_nilai = "p.id_reg_pd='".$id_reg_pd."'";
    $temp_sms = $proxy->GetRecordset($token,'nilai',$filter_nilai,'','','');
    if (!empty($temp_sms['result'])) {
            foreach ($temp_sms['result'] as $reg) {
          $hapus_nilai[] = array(
          'id_kls' => $reg['id_kls'],
          'id_reg_pd'=>$reg['id_reg_pd']
          );  

        }

          // print_r($hapus);
          $temp_result = $proxy->DeleteRecordset($token, 'nilai', json_encode($hapus_nilai));
          print_r($temp_result);
    }


    
    $filter_akm = "p.id_reg_pd='".$id_reg_pd."'";
    $temp_akm = $proxy->GetRecordset($token,'kuliah_mahasiswa',$filter_akm,'','','');

    if (!empty($temp_akm['result'])) {
         foreach ($temp_akm['result'] as $reg) {
      $hapus_akm[] = array(
      'id_smt' => $reg['id_smt'],
      'id_reg_pd'=>$reg['id_reg_pd']
      );

      }

        //  print_r($hapus);
    $temp_result = $proxy->DeleteRecordset($token, 'kuliah_mahasiswa', json_encode($hapus_akm));
    print_r($temp_result);

    }

        $filter_nilai_trf = "p.id_reg_pd='".$id_reg_pd."'";
    $temp_sms = $proxy->GetRecordset($token,'nilai_transfer',$filter_nilai_trf,'','','');
    if (!empty($temp_sms['result'])) {
            foreach ($temp_sms['result'] as $reg) {
          $hapus_nilai_trf[] = array(
          'id_ekuivalensi' => $reg['id_ekuivalensi'],
          'id_reg_pd'=>$reg['id_reg_pd']
          );  

        }

          // print_r($hapus);
          $temp_result = $proxy->DeleteRecordset($token, 'nilai_transfer', json_encode($hapus_nilai_trf));
          print_r($temp_result);
    }

 
    }
  
      $hapus_mhs_pd[] = array(     
      'id_pd'=>$id_pd
      );

        $data_reg = $db->get_data_services('GetListAnggotaAktivitasMahasiswa',"id_registrasi_mahasiswa='$id_reg_pd'",'','','');
    
    foreach($data_reg as $id) {
    $hapus_anggota[] = array(
      'id_ang_akt_mhs' => $id->id_anggota
      );  
    }

    $temp_result = $proxy->DeleteRecordset($token, 'anggota_aktivitas_mahasiswa', json_encode($hapus_anggota));
     print_r($temp_result);

 
      unset($hapus_nilai);
      unset($hapus_nilai_trf);
      unset($hapus_akm);
      unset($hapus_anggota);

      }

      if (!empty($hapus_mhs_pt)) {
        $temp_result = $proxy->DeleteRecordset($token, 'mahasiswa_pt', json_encode($hapus_mhs_pt));
        print_r($temp_result);
      }

      print_r($hapus_mhs_pd);

      $temp_result = $proxy->DeleteRecordset($token, 'mahasiswa', json_encode($hapus_mhs_pd));
        print_r($temp_result);





    }
    break;

}