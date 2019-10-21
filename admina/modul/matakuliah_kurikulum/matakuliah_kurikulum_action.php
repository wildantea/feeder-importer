<?php
session_start();
include "../../inc/config.php";
session_check();

  /** PHPExcel_IOFactory */
require_once '../../lib/PHPExcel/IOFactory.php';


switch ($_GET["act"]) {
    case 'del_massal':
    $data_ids = $_REQUEST['data_ids'];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {
        foreach($data_id_array as $id) {
          $db->delete("mat_kurikulum","id",$id);
         }
    }
    break;
  case 'import':
     if (!is_dir("../../../upload/matakuliah")) {
              mkdir("../../../upload/matakuliah");
            }


   if (!preg_match("/.(xls|xlsx)$/i", $_FILES["semester"]["name"]) ) {

              echo "pastikan file yang anda pilih xls|xlsx";
              exit();

            } else {
              move_uploaded_file($_FILES["semester"]["tmp_name"], "../../../upload/matakuliah/".$_FILES['semester']['name']);
              $semester = array("semester"=>$_FILES["semester"]["name"]);

            }


      $objPHPExcel = PHPExcel_IOFactory::load("../../../upload/matakuliah/".$_FILES['semester']['name']);
      $error_count = 0;
      $error = array();
      $sukses = 0;
      foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
          $highestRow         = $worksheet->getHighestRow(); // e.g. 10
          $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);


          for ($row = 2; $row <= $highestRow; ++ $row) {
          $val=array();
        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
         $cell = $worksheet->getCellByColumnAndRow($col, $row);
         $val[] = $cell->getValue();

        }

        if ($val[0]!='') {

          $check = $db->check_exist('mat_kurikulum',array('kode_mk' => filter_var($val[0], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),'id_kurikulum' => $_POST['id_kur']));
          if ($check==true) {
            $error_count++;
            $error[] = $val[0]." Sudah Ada";
          } else {
            $sukses++;
            $data[] = array(
            "id_kurikulum"=>$_POST['id_kur'],
            "kode_mk"=>$db->trimmer($val[0]),
            "nama_mk"=>$db->trimmer($val[1]),
            "jns_mk"=>$db->trimmer($val[2]),
            "sks_tm"=>$db->trimmer($val[3]),
            "sks_prak"=>$db->trimmer($val[4]),
            "sks_prak_lap"=>$db->trimmer($val[5]),
            "sks_sim"=>$db->trimmer($val[6]),
            'metode_pelaksanaan_kuliah' => $db->trimmer($val[7]),
            "tgl_mulai_efektif"=>$db->trimmer($val[8]),
            "tgl_akhir_efektif"=>$db->trimmer($val[9]),
            "semester"=>$db->trimmer($val[10]),
            "kode_jurusan" =>$_POST["jurusan"]
            );

        }

      }

    }

      }

if (!empty($data)) {
  $db->insert_massal('mat_kurikulum',$data);
}

          unlink("../../../upload/matakuliah/".$_FILES['semester']['name']);
          $msg = '';
      if (($sukses>0) || ($error_count>0)) {
        $msg =  "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\" >
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            <font color=\"#3c763d\">".$sukses." data Matakuliah baru berhasil di import</font><br />
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

   case 'delete_all':
    $db->query("delete from mat_kurikulum where kode_jurusan='".$_POST['id']."' and id_kurikulum='".$_POST['tahun']."'");
    break;

  case "in":
  
  
   $data = array(
    "id_kurikulum"=>$_POST["id_kurikulum"],
    "kode_mk"=>$_POST["kode_mk"],
    "nama_mk"=>$_POST["nama_mk"],
    "jns_mk"=>$_POST["jns_mk"],
    "sks_tm"=>$_POST["sks_tm"],
    "sks_prak"=>$_POST["sks_prak"],
    "sks_prak_lap"=>$_POST["sks_prak_lap"],
    "sks_sim"=>$_POST["sks_sim"],
    "semester"=>$_POST["semester"],
    "kode_jurusan"=>$_POST["kode_jurusan"]);
  
  
  
   
    $in = $db->insert("mat_kurikulum",$data);
    
    if ($in=true) {
      echo "good";
    } else {
      return false;
    }
    break;
  case "delete":
    
    
    
    $db->delete("mat_kurikulum","id",$_GET["id"]);
    break;
  case "up":
   $data = array(
    "id_kurikulum"=>$_POST["id_kurikulum"],
    "kode_mk"=>$_POST["kode_mk"],
    "nama_mk"=>$_POST["nama_mk"],
    "jns_mk"=>$_POST["jns_mk"],
    "sks_tm"=>$_POST["sks_tm"],
    "sks_prak"=>$_POST["sks_prak"],
    "sks_prak_lap"=>$_POST["sks_prak_lap"],
    "sks_sim"=>$_POST["sks_sim"],
    "semester"=>$_POST["semester"],
    "kode_jurusan"=>$_POST["kode_jurusan"]);
   
   
   

    
    $up = $db->update("mat_kurikulum",$data,"id",$_POST["id"]);
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