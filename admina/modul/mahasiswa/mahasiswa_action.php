<?php
session_start();
$time_start = microtime(true); 
include "../../inc/config.php";

require('../../lib/php-excel-reader/excel_reader2.php');

require('../../lib/SpreadsheetReader.php');

session_check();
switch ($_GET["act"]) {
  case 'import':
  //$time1 = microtime(true);
     if (!is_dir("../../../upload/mahasiswa")) {
              mkdir("../../../upload/mahasiswa");
            }


   if (!preg_match("/.(xls|xlsx)$/i", $_FILES["semester"]["name"]) ) {

              echo "pastikan file yang anda pilih xls|xlsx";
              exit();

            } else {
              move_uploaded_file($_FILES["semester"]["tmp_name"], "../../../upload/mahasiswa/".$_FILES['semester']['name']);
              $semester = array("semester"=>$_FILES["semester"]["name"]);

            }


$error_count = 0;
$error = array();
$sukses = 0;
$values = "";

  $Reader = new SpreadsheetReader("../../../upload/mahasiswa/".$_FILES['semester']['name']);
  foreach ($Reader as $key => $val)
  {
    if ($key>0) {
      if ($val[0]!='') {

         $check = $db->check_exist('mhs',array('nipd' => filter_var($val[0], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)));
                if ($check==true) {
                  $error_count++;
                  $error[] = $val[0]." ".$val[1]." Sudah Ada";
                } else {
                  $sukses++;
                  $array_insert[] = array(
                  'nipd' => $db->trimmer($val[0]),
                  'nm_pd' => $db->trimmer($val[1]),
                  'tmpt_lahir' => $db->trimmer($val[2]),
                  'tgl_lahir' => $db->trimmer($val[3]),
                  'jk' => $db->trimmer($val[4]),
                  'nik' => $db->trimmer($val[5]),
                  'id_agama' => $db->trimmer($val[6]),
                  'nisn' => $db->trimmer($val[7]),
                  'id_jalur_masuk' => $db->trimmer($val[8]),
                  'npwp' => $db->trimmer($val[9]),
                  'kewarganegaraan' => $db->trimmer($val[10]),
                  'id_jns_daftar' => $db->trimmer($val[11]),
                  'tgl_masuk_sp' => $db->trimmer($val[12]),
                  'mulai_smt' => $db->trimmer($val[13]),
                  'jln' => $db->trimmer($val[14]),
                  'rt' => $db->trimmer($val[15]),
                  'rw' => $db->trimmer($val[16]),
                  'nm_dsn' => $db->trimmer($val[17]),
                  'ds_kel' => $db->trimmer($val[18]),
                  'id_wil' => $db->trimmer($val[19]),
                  'kode_pos' => $db->trimmer($val[20]),
                  'id_jns_tinggal' => $db->trimmer($val[21]),
                  'id_alat_transport' => $db->trimmer($val[22]),
                  'no_tel_rmh' => $db->trimmer($val[23]),
                  'no_hp' => $db->trimmer($val[24]),
                  'email' => $db->trimmer($val[25]),
                  'a_terima_kps' => $db->trimmer($val[26]),
                  'no_kps' => $db->trimmer($val[27]),
                  'nik_ayah' => $db->trimmer($val[28]),
                  'nm_ayah' => $db->trimmer($val[29]),
                  'tgl_lahir_ayah' => $db->trimmer($val[30]),
                  'id_jenjang_pendidikan_ayah' => $db->trimmer($val[31]),
                  'id_pekerjaan_ayah' => $db->trimmer($val[32]),
                  'id_penghasilan_ayah' => $db->trimmer($val[33]),
                  'nik_ibu' => $db->trimmer($val[34]),
                  'nm_ibu_kandung' => $db->trimmer($val[35]),
                  'tgl_lahir_ibu' => $db->trimmer($val[36]),
                  'id_jenjang_pendidikan_ibu' => $db->trimmer($val[37]),
                  'id_pekerjaan_ibu' => $db->trimmer($val[38]),
                  'id_penghasilan_ibu' => $db->trimmer($val[39]),
                  'nm_wali' => $db->trimmer($val[40]),
                  'tgl_lahir_wali' => $db->trimmer($val[41]),
                  'id_jenjang_pendidikan_wali' => $db->trimmer($val[42]),
                  'id_pekerjaan_wali' => $db->trimmer($val[43]),
                  'id_penghasilan_wali' => $db->trimmer($val[44]),
                  'kode_jurusan' => $_POST['jurusan'],
                  'id_pembiayaan' => $db->trimmer($val[45]),
                  'biaya_masuk_kuliah' => $db->trimmer($val[46]),
                  'id_kk' => 0
                  );

              }

      }

    }

  }

if (!empty($array_insert)) {
  $db->insertMulti('mhs',$array_insert);
  echo $db->getErrorMessage();
}

unlink("../../../upload/mahasiswa/".$_FILES['semester']['name']);
//$time2 = microtime(true);
$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
          $msg = '';
      if (($sukses>0) || ($error_count>0)) {
        $msg =  "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\" >
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            <font color=\"#3c763d\">".$sukses." data Mahasiswa baru berhasil di import</font><br />
            <font color=\"#ce4844\" >".$error_count." data tidak bisa ditambahkan </font>";
            if (!$error_count==0) {
              $msg .= "<a data-toggle=\"collapse\" href=\"#collapseExample\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail error</a>";
            }
            //echo "<br />Total: ".$i." baris data";
            $msg .= "<div class=\"collapse\" id=\"collapseExample\">";
                $i=1;
                foreach ($error as $pesan) {
                    $msg .= "<div class=\"bs-callout bs-callout-danger\">".$i.". ".$pesan."</div><br />";
                  $i++;
                  }
            $msg .= "</div>
          </div>";
           $msg .= "<p>Total Waktu Import : ". waktu_import($execution_time);
      }
     echo $msg;
          break;

  case "in":

  $check = $db->check_exist('mhs',array('nipd' => $_POST["nipd"]));
    if ($check==true) {
      echo "Error NIM ".$_POST["nipd"]." Sudah Ada";
      exit();
  } 

  $data_mhs = array(
    "nm_pd"=>$_POST["nm_pd"],
    "jk"=>$_POST["jk"],
    "nik"=>$_POST["nik"],
    "nisn" => $_POST['nisn'],
    "npwp" => $_POST['npwp'],
    "tmpt_lahir"=>$_POST["tmpt_lahir"],
    "tgl_lahir"=>$_POST["tgl_lahir"],
    "id_agama"=>$_POST["id_agama"],
    "jln"=>$_POST["jln"],
    "rt"=>$_POST["rt"],
    "rw"=>$_POST["rw"],
    "nm_dsn"=>$_POST["nm_dsn"],
    "kewarganegaraan"=>$_POST["kewarganegaraan"],
    "ds_kel"=>$_POST["ds_kel"],
    "kode_pos"=>$_POST["kode_pos"],
    "id_alat_transport"=>$_POST["id_alat_transport"],
    "id_jns_tinggal"=>$_POST["id_jns_tinggal"],
    "no_tel_rmh"=>$_POST["no_tel_rmh"],
    "no_hp"=>$_POST["no_hp"],
    "email"=>$_POST["email"],
    "a_terima_kps"=>$_POST["a_terima_kps"],
    "no_kps"=>$_POST["no_kps"],
    "nik_ayah" => $_POST["nik_ayah"],
    "nm_ayah"=>$_POST["nm_ayah"],
    "tgl_lahir_ayah"=>$_POST["tgl_lahir_ayah"],
    "id_jenjang_pendidikan_ayah"=>$_POST["id_jenjang_pendidikan_ayah"],
    "id_pekerjaan_ayah"=>$_POST["id_pekerjaan_ayah"],
    "id_penghasilan_ayah"=>$_POST["id_penghasilan_ayah"],
    "nik_ibu" => $_POST["nik_ibu"],
    "nm_ibu_kandung"=>$_POST["nm_ibu_kandung"],
    "tgl_lahir_ibu"=>$_POST["tgl_lahir_ibu"],
    "id_jenjang_pendidikan_ibu"=>$_POST["id_jenjang_pendidikan_ibu"],
    "id_penghasilan_ibu"=>$_POST["id_penghasilan_ibu"],
    "id_pekerjaan_ibu"=>$_POST["id_pekerjaan_ibu"],
    "nm_wali"=>$_POST["nm_wali"],
    "tgl_lahir_wali"=>$_POST["tgl_lahir_wali"],
    "id_jenjang_pendidikan_wali"=>$_POST["id_jenjang_pendidikan_wali"],
    "id_pekerjaan_wali"=>$_POST["id_pekerjaan_wali"],
    "id_penghasilan_wali"=>$_POST["id_penghasilan_wali"],
    "id_wil" => $_POST['id_wil'],
    "kode_jurusan"=>$_POST["kode_jurusan"],
    "id_jns_daftar"=>$_POST["id_jns_daftar"],
    "nipd"=>$_POST["nipd"],
    "tgl_masuk_sp"=>$_POST["tgl_masuk_sp"],
    "mulai_smt"=>$_POST["mulai_smt"],
    "id_pembiayaan"=>$_POST["id_pembiayaan"],
    "biaya_masuk_kuliah"=>$_POST["biaya_masuk_kuliah"],
    "id_jalur_masuk"=>$_POST["id_jalur_masuk"]
    );
 
   
    $in = $db->insert("mhs",$data_mhs);
    
    if ($in=true) {
      echo "good";
    } else {
      return false;
    }
    break;
  case "delete":
    
    $db->delete("mhs","id",$_GET['id']);
    break;
  case "up":
$data_mhs = array(
    "nm_pd"=>$_POST["nm_pd"],
    "jk"=>$_POST["jk"],
    "nik"=>$_POST["nik"],
    "nisn" => $_POST['nisn'],
    "npwp" => $_POST['npwp'],
    "tmpt_lahir"=>$_POST["tmpt_lahir"],
    "tgl_lahir"=>$_POST["tgl_lahir"],
    "id_agama"=>$_POST["id_agama"],
    "jln"=>$_POST["jln"],
    "rt"=>$_POST["rt"],
    "rw"=>$_POST["rw"],
    "nm_dsn"=>$_POST["nm_dsn"],
    "kewarganegaraan"=>$_POST["kewarganegaraan"],
    "ds_kel"=>$_POST["ds_kel"],
    "kode_pos"=>$_POST["kode_pos"],
    "id_alat_transport"=>$_POST["id_alat_transport"],
    "id_jns_tinggal"=>$_POST["id_jns_tinggal"],
    "no_tel_rmh"=>$_POST["no_tel_rmh"],
    "no_hp"=>$_POST["no_hp"],
    "email"=>$_POST["email"],
    "a_terima_kps"=>$_POST["a_terima_kps"],
    "no_kps"=>$_POST["no_kps"],
    "nik_ayah" => $_POST["nik_ayah"],
    "nm_ayah"=>$_POST["nm_ayah"],
    "tgl_lahir_ayah"=>$_POST["tgl_lahir_ayah"],
    "id_jenjang_pendidikan_ayah"=>$_POST["id_jenjang_pendidikan_ayah"],
    "id_pekerjaan_ayah"=>$_POST["id_pekerjaan_ayah"],
    "id_penghasilan_ayah"=>$_POST["id_penghasilan_ayah"],
    "nik_ibu" => $_POST["nik_ibu"],
    "nm_ibu_kandung"=>$_POST["nm_ibu_kandung"],
    "tgl_lahir_ibu"=>$_POST["tgl_lahir_ibu"],
    "id_jenjang_pendidikan_ibu"=>$_POST["id_jenjang_pendidikan_ibu"],
    "id_penghasilan_ibu"=>$_POST["id_penghasilan_ibu"],
    "id_pekerjaan_ibu"=>$_POST["id_pekerjaan_ibu"],
    "nm_wali"=>$_POST["nm_wali"],
    "tgl_lahir_wali"=>$_POST["tgl_lahir_wali"],
    "id_jenjang_pendidikan_wali"=>$_POST["id_jenjang_pendidikan_wali"],
    "id_pekerjaan_wali"=>$_POST["id_pekerjaan_wali"],
    "id_penghasilan_wali"=>$_POST["id_penghasilan_wali"],
    "id_wil" => $_POST['id_wil'],
    "kode_jurusan"=>$_POST["kode_jurusan"],
    "id_jns_daftar"=>$_POST["id_jns_daftar"],
    "nipd"=>$_POST["nipd"],
    "tgl_masuk_sp"=>$_POST["tgl_masuk_sp"],
    "mulai_smt"=>$_POST["mulai_smt"],
    "id_pembiayaan"=>$_POST["id_pembiayaan"],
    "biaya_masuk_kuliah"=>$_POST["biaya_masuk_kuliah"],
    "id_jalur_masuk"=>$_POST["id_jalur_masuk"]
    );
 

     $up_pt = $db->update("mhs",$data_mhs,"id",$_POST["id"]);
    if ($up=true) {
      echo "good";
    } else {
      return false; 
    }
    break;
       case 'del_massal':
    $data_ids = $_REQUEST['data_ids'];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {
        foreach($data_id_array as $id) {
          $db->delete("mhs","id",$id);
         }
    }
    break;

  default:
    # code...
    break;
}

?>