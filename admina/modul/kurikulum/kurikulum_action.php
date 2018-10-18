<?php
session_start();
include "../../inc/config.php";
session_check();
switch ($_GET["act"]) {
  case "in":
  
  $data = array("nama_kur"=>$_POST["nama_kur"],"mulai_berlaku"=>$_POST["mulai_berlaku"],"jml_sks_wajib"=>$_POST["jml_sks_wajib"],"jml_sks_pilihan"=>$_POST["jml_sks_pilihan"],"kode_jurusan"=>$_POST["kode_jurusan"],'total_sks'=>$_POST["total_sks"]);
  
  
  
   
    $in = $db->insert("kurikulum",$data);
    
    if ($in=true) {
      echo "good";
    } else {
      return false;
    }
    break;
  case "delete":
    
    
    
    $db->delete("kurikulum","id",$_GET["id"]);
    break;
  case "up":
   $data = array("nama_kur"=>$_POST["nama_kur"],"mulai_berlaku"=>$_POST["mulai_berlaku"],"jml_sks_wajib"=>$_POST["jml_sks_wajib"],"jml_sks_pilihan"=>$_POST["jml_sks_pilihan"],'total_sks'=>$_POST["total_sks"]);
   
   
   

    
    $up = $db->update("kurikulum",$data,"id",$_POST["id"]);
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