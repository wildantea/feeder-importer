<?php
session_start();
include "../../inc/config.php";
session_check();

 /** PHPExcel_IOFactory */
require_once '../../lib/PHPExcel/IOFactory.php';

switch ($_GET["act"]) {
   case 'delete_error':
    $db->query("delete from krs where status_error=2 and kode_jurusan='".$_POST['id']."'");
    break;
    case 'delete_all':
         if ($_POST['sem']=='all') {
      $db->query("delete from krs where kode_jurusan='".$_POST['id']."'");
    } else {
      $db->query("delete from krs where kode_jurusan='".$_POST['id']."' and semester='".$_POST['sem']."'");
    }
    break;

  case 'import':
     if (!is_dir("../../../upload/krs")) {
              mkdir("../../../upload/krs");
            }


   if (!preg_match("/.(xls|xlsx)$/i", $_FILES["semester"]["name"]) ) {

              echo "pastikan file yang anda pilih xls|xlsx";
              exit();

            } else {
              move_uploaded_file($_FILES["semester"]["tmp_name"], "../../../upload/krs/".$_FILES['semester']['name']);
              $semester = array("semester"=>$_FILES["semester"]["name"]);

            }


$objPHPExcel = PHPExcel_IOFactory::load("../../../upload/krs/".$_FILES['semester']['name']);

$data = $objPHPExcel->getActiveSheet()->toArray();



$error_count = 0;
$error = array();
$sukses = 0;

foreach ($data as $key => $val) {

    if ($key>0) {

      if ($val[1]!='') {
          
               if ($val[5]=='') {
                $nama_kelas = "01";
              } else {
                $nama_kelas = filter_var($val[5], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);
              }

              $check = $db->check_exist('krs',array('nim'=>filter_var($val[1], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),'kode_mk' => filter_var($val[4], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),'semester'=>filter_var($val[3], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),'nama_kelas'=>filter_var($val[5], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)));
              if ($check==true) {
                $error_count++;
                $error[] = $val[1]." ".$val[4]." Sudah Ada";
              } else {
                $sukses++;

              $data = array(
                        'nim'=>filter_var($val[1], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        'nama' => filter_var($val[2], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        'semester'=>filter_var($val[3], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        'kode_mk'=>filter_var($val[4], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        'nama_mk' => filter_var($val[5], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        'nama_kelas'=>filter_var($val[6], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        'kode_jurusan' => $_POST['jurusan']
                            );

                $in = $db->insert("krs",$data);
                } 

      }
      
    }
   
}


    unlink("../../../upload/krs/".$_FILES['semester']['name']);
    $msg = '';
if (($sukses>0) || ($error_count>0)) {
  $msg =  "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\" >
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
      <font color=\"#3c763d\">".$sukses." data Krs baru berhasil di import</font><br />
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
}
  echo $msg;
    break;
  case "in":



  $data = array("nim"=>$_POST["nim"],"nama"=>$_POST["nama"],"kode_mk"=>$_POST["kode_mk"],"nama_mk"=>$_POST["nama_mk"],"nama_kelas"=>$_POST["nama_kelas"],"semester"=>$_POST["semester"],"kode_jurusan"=>$_POST["kode_jurusan"],);




    $in = $db->insert("krs",$data);

    if ($in=true) {
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
          $db->delete("krs","id",$id);
         }
    }
    break;
  case "delete":



    $db->delete("krs","id",$_GET["id"]);
    break;
  case "up":
   $data = array("nim"=>$_POST["nim"],"nama"=>$_POST["nama"],"kode_mk"=>$_POST["kode_mk"],"nama_mk"=>$_POST["nama_mk"],"nama_kelas"=>$_POST["nama_kelas"],"semester"=>$_POST["semester"],"kode_jurusan"=>$_POST["kode_jurusan"],);





    $up = $db->update("krs",$data,"id",$_POST["id"]);
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
