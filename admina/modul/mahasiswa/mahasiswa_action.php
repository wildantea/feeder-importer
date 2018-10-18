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
           $values .= '("'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[0], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            filter_var($val[1], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[2], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[3], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[4], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[5], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[6], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[7], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[8], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[9], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[10], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[11], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[12], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[13], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[14], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[15], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[16], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[17], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[18], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[19], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[20], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[21], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[22], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[23], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[24], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[25], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[26], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[27], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[28], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[29], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[30], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[31], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[32], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[33], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[34], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[35], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[36], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[37], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[38], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[39], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[40], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[41], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[42], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[43], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[44], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[45], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
           $_POST['jurusan'].'","'
            .',0"),';


              }

      }

    }

  }


if ($values!="") {
  $values = rtrim($values,",");

  $query = "insert into mhs (
nipd,
nm_pd,
tmpt_lahir,
tgl_lahir,
jk,       
nik,
id_agama,
nisn,
id_jalur_masuk,  
npwp,
kewarganegaraan,
id_jns_daftar,
tgl_masuk_sp,
mulai_smt,
jln,
rt, 
rw, 
nm_dsn,
ds_kel,
id_wil,
kode_pos,
id_jns_tinggal,
id_alat_transport,
no_tel_rmh,
no_hp,     
email,     
a_terima_kps,
no_kps,      
nik_ayah,    
nm_ayah,     
tgl_lahir_ayah,
id_jenjang_pendidikan_ayah,
id_pekerjaan_ayah,   
id_penghasilan_ayah, 
nik_ibu, 
nm_ibu_kandung,
tgl_lahir_ibu, 
id_jenjang_pendidikan_ibu,
 id_pekerjaan_ibu,    
id_penghasilan_ibu,  
nm_wali,             
tgl_lahir_wali,      
id_jenjang_pendidikan_wali,
id_pekerjaan_wali,   
id_penghasilan_wali,
id_pembiayaan,
kode_jurusan,
id_kk 
) values ".$values;
  //echo $query;
  $db->fetch_custom($query);
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

  $check = $db->check_exist('mhs_pt',array('nipd' => $_POST["nipd"]));
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
    "id_penghasilan_wali"=>$_POST["id_penghasilan_wali"],
    "id_wil" => $_POST['id_wil']
    );
 

   $data_mhs_pt = array(
    "kode_jurusan"=>$_POST["kode_jurusan"],
    "id_jns_daftar"=>$_POST["id_jns_daftar"],
    "nipd"=>$_POST["nipd"],
    "tgl_masuk_sp"=>$_POST["tgl_masuk_sp"],
    "mulai_smt"=>$_POST["mulai_smt"],
    "id_jalur_masuk"=>$_POST["id_jalur_masuk"]
    );
  
  
  
   
    $in = $db->insert("mhs",$data_mhs);
    $last_id = $db->get_last_id();
    $last = array('id_mhs' => $last_id);
    $data_mhs_pt = array_merge($data_mhs_pt,$last);

    $in_mhs_pt = $db->insert("mhs_pt",$data_mhs_pt);
    
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