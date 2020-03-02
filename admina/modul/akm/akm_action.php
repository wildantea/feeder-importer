<?php
session_start();
include "../../inc/config.php";
session_check();

  /** PHPExcel_IOFactory */
require_once '../../lib/PHPExcel/IOFactory.php';

switch ($_GET["act"]) {

  case 'validasi':


  //SKS per semester > 30 sks
   $valids_smt = $db->query("select * from nilai_akm where kode_jurusan='".$_POST['jurusan']."' and semester='".$_POST['sem']."' and valid!=1 and sks_smt > 30");

    //check if ips is valid
    if ($valids_smt->rowCount()>0) {
       foreach ($valids_smt as $valid) {
       $ket_valids_smt = "SKS per semester > 30 sks";
      $data = array(
          'valid' => 2,
          'ket_sks_sem' => $ket_valids_smt,
          'ket_valid_ips' => "",
          'ket_valid_ipk' => "",
          'ket_valid_ips_ipk' => "",
          'ket_krs_ada' => ""
          );
        $db->update('nilai_akm',$data,'id',$valid->id);
        
      }
    }


    $valids = $db->query("select * from nilai_akm where kode_jurusan='".$_POST['jurusan']."' and semester='".$_POST['sem']."' and valid!=1 and ips > 4");

    //check if ips is valid
    if ($valids->rowCount()>0) {
       foreach ($valids as $valid) {
       $ket_valid_ips = "Nilai IPS > 4.00";
      $data = array(
          'valid' => 2,
          'ket_valid_ips' => $ket_valid_ips,
          );
        $db->update('nilai_akm',$data,'id',$valid->id);
        
      }
    }
    
    //check if ipk is valid
    $valids_ipk = $db->query("select * from nilai_akm where kode_jurusan='".$_POST['jurusan']."' and semester='".$_POST['sem']."' and valid!=1 and ipk > 4");

    if ($valids_ipk->rowCount()>0) {
         foreach ($valids_ipk as $val_ipk) {
      $ket_valid_ipk = "Nilai IPK > 4.00";
      $data = array(
          'valid' => 2,
          'ket_valid_ipk' => $ket_valid_ipk,
          );
        $db->update('nilai_akm',$data,'id',$val_ipk->id);
      }
    } 

    //check if ipk=0 but ips > 0
     $valids_ips_ipk = $db->query("select * from nilai_akm where kode_jurusan='".$_POST['jurusan']."' and semester='".$_POST['sem']."' and valid!=1 and ipk=0 and ips>0");
    if ($valids_ips_ipk->rowCount()>0) {
        foreach ($valids_ips_ipk as $valid_ips_ipk) {
       $ket_valid_ips_ipk = "NIlai IPK = 0 , tapi IPS > 0 ";
            $data = array(
          'valid' => 2,
          'ket_valid_ipk' => $ket_valid_ipk,
          );
        $db->update('nilai_akm',$data,'id',$valid_ips_ipk->id);

    }
  }

   //check if SKS semester = 0 , tapi KRS atau ips > 0
     $ket_krs_ada = $db->query("select * from nilai_akm where kode_jurusan='".$_POST['jurusan']."' and semester='".$_POST['sem']."' and valid!=1 and (sks_smt=0 or sks_total=0) and ips>0");
    if ($ket_krs_ada->rowCount()>0) {
        foreach ($ket_krs_ada as $ket_krs) {
       $ket_krsnya = "SKS semester = 0 , tapi KRS atau ips > 0";
            $data = array(
          'valid' => 2,
          'ket_valid_ipk' => $ket_krsnya,
          );
        $db->update('nilai_akm',$data,'id',$ket_krs->id);

    }
  }

    
    //othewise success all
     $sukses = $db->query("select * from nilai_akm where kode_jurusan='".$_POST['jurusan']."' and semester='".$_POST['sem']."' and valid!=1 and valid=0");
     foreach ($sukses as $su) {
       
        $data = array(
          'valid' => 1,
          );
        $db->update('nilai_akm',$data,'id',$su->id);

     }
    break;

    case 'delete_error':
    $db->query("delete from nilai_akm where status_error=2 and kode_jurusan='".$_POST['id']."'");
    break;
    case 'delete_all':
    if ($_POST['sem']=='all') {
      $db->query("delete from nilai_akm where kode_jurusan='".$_POST['id']."'");
    } else {
      $db->query("delete from nilai_akm where kode_jurusan='".$_POST['id']."' and semester='".$_POST['sem']."'");
    }
    
    break;


  case 'import':
     if (!is_dir("../../../upload/akm")) {
              mkdir("../../../upload/akm");
            }


   if (!preg_match("/.(xls|xlsx)$/i", $_FILES["semester"]["name"]) ) {

              echo "pastikan file yang anda pilih xls|xlsx";
              exit();

            } else {
              move_uploaded_file($_FILES["semester"]["tmp_name"], "../../../upload/akm/".$_FILES['semester']['name']);
              $semester = array("semester"=>$_FILES["semester"]["name"]);

            }


$objPHPExcel = PHPExcel_IOFactory::load("../../../upload/akm/".$_FILES['semester']['name']);
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
if ($val[1]!='') {
  $check = $db->check_exist('nilai_akm',array('nim'=>filter_var($val[1], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),'semester'=>filter_var($val[3], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)));
  if ($check==true) {
    $error_count++;
    $error[] = $val[1]." Sudah Ada";
  } else {
    $sukses++;
    $data = array(
            'nim'=>filter_var($val[1], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
            'nama'=>filter_var($val[2], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
            'semester'=>filter_var($val[3], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
            'sks_smt'=>filter_var($val[4], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
            'ips'=>str_replace(",", ".", filter_var($val[5], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)),
            'sks_total'=>filter_var($val[6], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
            'ipk'=>str_replace(",", ".", filter_var($val[7], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)),
            'status_kuliah'=>filter_var($val[8], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
            'biaya_smt'=>filter_var($val[9], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
            'kode_jurusan' => $_POST['jurusan']
                );

      $in = $db->insert("nilai_akm",$data);
  }
}


}

}


    unlink("../../../upload/akm/".$_FILES['semester']['name']);
    $msg = '';
if (($sukses>0) || ($error_count>0)) {
  $msg =  "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\" >
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
      <font color=\"#3c763d\">".$sukses." data Akm baru berhasil Di import</font><br />
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
          $db->delete("nilai_akm","id",$id);
         }
    }
    break;
  case "in":

 

  $data = array("semester"=>$_POST["semester"],"nim"=>$_POST["nim"],"nama"=>$_POST["nama"],"ips"=>$_POST["ips"],"ipk"=>$_POST["ipk"],"sks_smt"=>$_POST["sks_smt"],"sks_total"=>$_POST["sks_total"],"kode_jurusan"=>$_POST["kode_jurusan"],"status_error"=>$_POST["status"],"biaya_smt" => $_POST["biaya_smt"]);



   $in = $db->insert("nilai_akm",$data);

    if ($in=true) {
      echo "good";
    } else {
      return false;
    }
    break;
  case "delete":



    $db->delete("nilai_akm","id",$_GET["id"]);
    break;
  case "up":
 


   $data = array("semester"=>$_POST["semester"],"nim"=>$_POST["nim"],"nama"=>$_POST["nama"],"ips"=>$_POST["ips"],"ipk"=>$_POST["ipk"],"sks_smt"=>$_POST["sks_smt"],"sks_total"=>$_POST["sks_total"],"kode_jurusan"=>$_POST["kode_jurusan"],"status_kuliah"=>$_POST["status"],"biaya_smt" => $_POST["biaya_smt"]);
   
    $up = $db->update("nilai_akm",$data,"id",$_POST["id"]);

     $valids = $db->query("select * from nilai_akm where kode_jurusan='".$_POST['kode_jurusan']."' and semester='".$_POST['semester']."' and ips > 4 and id='".$_POST["id"]."'");

     //check if ipk is valid
    $valids_ipk = $db->query("select * from nilai_akm where kode_jurusan='".$_POST['kode_jurusan']."' and semester='".$_POST['semester']."' and ipk > 4 and id='".$_POST["id"]."'");

    //check if ipk=0 but ips > 0
     $valids_ips_ipk = $db->query("select * from nilai_akm where kode_jurusan='".$_POST['kode_jurusan']."' and semester='".$_POST['semester']."' and ipk=0 and ips>0  and id='".$_POST["id"]."'");


    //check if ips is valid
  if ($valids->rowCount()>0) {
    foreach ($valids as $valid) {
       $ket_valid_ips = "Nilai IPS > 4.00";
      $data = array(
          'ket_valid_ips' => $ket_valid_ips,
          );
        $db->update('nilai_akm',$data,'id',$_POST["id"]);

        
    }
  } else {
      $data = array(
          'ket_valid_ips' => "",
          );
        $db->update('nilai_akm',$data,'id',$_POST["id"]);
  }  
  if ($valids_ipk->rowCount()>0) {

    foreach ($valids_ipk as $val_ipk) {
      $ket_valid_ipk = "Nilai IPK > 4.00";
      $data = array(
          'ket_valid_ipk' => $ket_valid_ipk,
          );
        $db->update('nilai_akm',$data,'id',$_POST["id"]);
    }
  } else {
      $data = array(
          'valid' => 2,
          'ket_valid_ipk' => "",
          );
        $db->update('nilai_akm',$data,'id',$_POST["id"]);
  }
  if ($valids_ips_ipk->rowCount()>0) {
    foreach ($valids_ips_ipk as $valid_ips_ipk) {
       $ket_valid_ips_ipk = "NIlai IPK = 0 , tapi IPS > 0 ";
            $data = array(
          'ket_valid_ips_ipk' => $ket_valid_ips_ipk,
          );
        $db->update('nilai_akm',$data,'id',$_POST["id"]);

    }
  } else {
      $ket_valid_ips_ipk = "NIlai IPK = 0 , tapi IPS > 0 ";
            $data = array(
          'ket_valid_ips_ipk' => "",
          );
        $db->update('nilai_akm',$data,'id',$_POST["id"]);
  }

  if ($valids->rowCount()>0 || $valids_ipk->rowCount() > 0 || $valids_ips_ipk->rowCount()>0 ) {
      $data = array(
        'valid' => 2
      );
        $db->update('nilai_akm',$data,'id',$_POST["id"]);

  } else {
      $data = array(
        'valid' => 1
      );
        $db->update('nilai_akm',$data,'id',$_POST["id"]);
  }
  
    
     
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
