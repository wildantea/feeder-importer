<?php
session_start();
include "../../inc/config.php";
session_check();
 /** PHPExcel_IOFactory */
require_once '../../lib/PHPExcel/IOFactory.php';

switch ($_GET["act"]) {

  case 'delete_error':
    $db->query("delete from ajar_dosen where status_error=2 and kode_jurusan='".$_POST['id']."'");
    break;
    case 'delete_all':
    $db->query("delete from ajar_dosen where kode_jurusan='".$_POST['id']."'");
    break;
    
  case 'import':
     if (!is_dir("../../../upload/dosen_ajar")) {
              mkdir("../../../upload/dosen_ajar");
            }


   if (!preg_match("/.(xls|xlsx)$/i", $_FILES["semester"]["name"]) ) {

              echo "pastikan file yang anda pilih xls|xlsx";
              exit();

            } else {
              move_uploaded_file($_FILES["semester"]["tmp_name"], "../../../upload/dosen_ajar/".$_FILES['semester']['name']);
              $semester = array("semester"=>$_FILES["semester"]["name"]);

            }


$objPHPExcel = PHPExcel_IOFactory::load("../../../upload/dosen_ajar/".$_FILES['semester']['name']);


$data = $objPHPExcel->getActiveSheet()->toArray();


$error_count = 0;
$error = array();
$sukses = 0;



foreach ($data as $key => $val) {

    if ($key>0) {

      if ($val[0]!='') {
          
                $check = $db->check_exist('ajar_dosen',array('semester'=>filter_var($val[0], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),'nidn' => filter_var($val[1], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),'kode_mk'=>filter_var($val[3], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),'nama_kelas'=>filter_var($val[4], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),'kode_jurusan' => $_POST['jurusan']));
                  if ($check==true) {
                    $error_count++;
                    $error[] = $val[1]." ".$val[3]." Sudah Ada";
                  } else {
                      $sukses++;
                      if ($val[6]=="") {
                        $realisasi = $val[5];
                      } else {
                        $realisasi = $val[6];
                      }
                $data = array(
                          'semester'=>filter_var($val[0], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                          'nidn'=>filter_var($val[1], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                          'nama_dosen'=>filter_var($val[2], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                          'kode_mk'=>filter_var($val[3], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                          'nama_kelas'=>filter_var($val[4], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                          'rencana_tatap_muka'=>$val[5],
                          "tatap_muka_real" => $realisasi,
                          "sks_ajar" => $val[7],
                          'kode_jurusan' => $_POST['jurusan']
                              );

               $in = $db->insert("ajar_dosen",$data);
              }

      }
      
    }
   
}


    unlink("../../../upload/dosen_ajar/".$_FILES['semester']['name']);
        $msg = '';
if (($sukses>0) || ($error_count>0)) {
  $msg =  "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\" >
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
      <font color=\"#3c763d\">".$sukses." Data Ajar Dosen berhasil di import</font><br />
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
  case 'del_massal':
    $data_ids = $_REQUEST['data_ids'];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {
        foreach($data_id_array as $id) {
          $db->delete("ajar_dosen","id",$id);
         }
    }
    break;
  case "in":
  
  
  
  $data = array(
    "semester"=>$_POST["semester"],
    "nidn"=>$_POST["nidn"],
    "nama_dosen"=>$_POST["nama_dosen"],
    "kode_mk"=>$_POST["kode_mk"],
    "nama_kelas"=>$_POST["nama_kelas"],
    "rencana_tatap_muka" => $_POST['tatap_muka'],
    "tatap_muka_real" => $_POST['tatap_muka_real'],
    'kode_jurusan' => $_POST['jurusan']
    );
  
  
  
   
    $in = $db->insert("ajar_dosen",$data);
    
    if ($in=true) {
      echo "good";
    } else {
      return false;
    }
    break;
  case "delete":
    
    
    
    $db->delete("ajar_dosen","id",$_GET["id"]);
    break;
  case "up":
   $data = array("semester"=>$_POST["semester"],"nidn"=>$_POST["nidn"],"nama_dosen"=>$_POST["nama_dosen"],"kode_mk"=>$_POST["kode_mk"],"nama_kelas"=>$_POST["nama_kelas"],"rencana_tatap_muka" => $_POST['tatap_muka'],"tatap_muka_real" => $_POST['tatap_muka_real'],'kode_jurusan' => $_POST['jurusan']);
   
   
   

    
    $up = $db->update("ajar_dosen",$data,"id",$_POST["id"]);
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