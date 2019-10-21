<?php
session_start();
$time_start = microtime(true); 
include "../../inc/config.php";
session_check();

require('../../lib/SpreadsheetReader.php');

switch ($_GET["act"]) {

  case 'delete_error':
    $db->query("delete from kelas_kuliah where status_error=2 and kode_jurusan='".$_POST['id']."'");
    break;
    case 'delete_all':
       if ($_POST['sem']=='all') {
      $db->query("delete from kelas_kuliah where kode_jurusan='".$_POST['id']."'");
    } else {
      $db->query("delete from kelas_kuliah where kode_jurusan='".$_POST['id']."' and semester='".$_POST['sem']."'");
    }
   
    break;
  case 'import':
     if (!is_dir("../../../upload/kelas_kuliah")) {
              mkdir("../../../upload/kelas_kuliah");
    
    }


   if (!preg_match("/.(xls|xlsx)$/i", $_FILES["semester"]["name"]) ) {

              echo "pastikan file yang anda pilih xls|xlsx";
              exit();

            } else {
              move_uploaded_file($_FILES["semester"]["tmp_name"], "../../../upload/kelas_kuliah/".$_FILES['semester']['name']);
              $semester = array("semester"=>$_FILES["semester"]["name"]);

            }



$error_count = 0;
$error = array();
$sukses = 0;
$values = "";

  $Reader = new SpreadsheetReader("../../../upload/kelas_kuliah/".$_FILES['semester']['name']);
  foreach ($Reader as $key => $val)
  {
    if ($key>0) {
      if ($val[0]!='') {
          $check = $db->check_exist('kelas_kuliah',array('kode_mk' => filter_var($val[1], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),'semester'=>filter_var($val[0], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),'nama_kelas'=>filter_var($val[3], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),'kode_jurusan' =>$_POST['kode_jurusan']));
            if ($check==true) {
              $error_count++;
              $error[] = $val[1]." Sudah Ada";
            } else {
              $sukses++;


       $values .= '("'.
      filter_var($val[0], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH).'","'.
      preg_replace( '/[^[:print:]]/', '',filter_var($val[1], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
      preg_replace( '/[^[:print:]]/', '',filter_var($val[2], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[3], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
            preg_replace( '/[^[:print:]]/', '',filter_var($val[4], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)).'","'.
      filter_var($val[5], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH).'","'.
      filter_var($val[6], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH).'","'.
      $_POST['kode_jurusan'].'"),';
              }
      }
    }
  }


if ($values!="") {
  $values = rtrim($values,",");

  $query = "insert into kelas_kuliah (semester,kode_mk,nama_mk,nama_kelas,bahasan_case,tgl_mulai_koas,tgl_selesai_koas,kode_jurusan) values ".$values;
  //echo $query;
  $db->query($query);
}

    unlink("../../../upload/kelas_kuliah/".$_FILES['semester']['name']);
    $msg = '';
$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
if (($sukses>0) || ($error_count>0)) {
  $msg =  "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\" >
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
      <font color=\"#3c763d\">".$sukses." data Kelas baru berhasil di import</font><br />
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
  
  $data = array(
    "semester"=>$_POST["semester"],
    "kode_mk"=>$_POST["kode_mk"],
    "nama_mk"=>$_POST["nama_mk"],
    "nama_kelas"=>$_POST["nama_kelas"],
    "kode_jurusan" => $_POST['jurusan']
    );
  
  
  
   
    $in = $db->insert("kelas_kuliah",$data);
    
    if ($in=true) {
      echo "good";
    } else {
      return false;
    }
    break;
  case "delete":
    
    
    
    $db->delete("kelas_kuliah","id",$_GET["id"]);
    break;

      case 'del_massal':
    $data_ids = $_REQUEST['data_ids'];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {
        foreach($data_id_array as $id) {
          $db->delete("kelas_kuliah","id",$id);
         }
    }
    break;
  case "up":
   $data = array(
    "semester"=>$_POST["semester"],
    "kode_mk"=>$_POST["kode_mk"],
    "nama_mk"=>$_POST["nama_mk"],
    "nama_kelas"=>$_POST["nama_kelas"],
    "kode_jurusan" => $_POST['jurusan'],
    "bahasan_case" => $_POST['bahasan_case'],
    "tgl_mulai_koas" => $_POST['tgl_mulai_koas'],
    "tgl_selesai_koas" => $_POST['tgl_selesai_koas']
    );
   

    
    $up = $db->update("kelas_kuliah",$data,"id",$_POST["id"]);
    if ($up=true) {
      echo "good";
    } else {
      return false; 
    }
    break;
  default:
    # code...
    break;
}

?>