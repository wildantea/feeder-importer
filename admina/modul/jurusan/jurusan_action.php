<?php
session_start();
include "../../inc/config.php";
session_check();
switch ($_GET["act"]) {
  case "in":
  
  
  
  $data = array(
    "kode_jurusan"=>$_POST["kode_jurusan"],
    "status"=>$_POST["status"],
    "jenjang"=>$_POST["jenjang"],
    "nama_jurusan"=>$_POST["nama_jurusan"]
    );
  
  
  
   
    $in = $db->insert("jurusan",$data);
    
    if ($in=true) {
      echo "good";
    } else {
      return false;
    }
    break;
  case "delete":
    
    
    
    $db->delete("jurusan","id",$_GET["id"]);
    break;
  case "up":
   $data = array(
    "kode_jurusan"=>$_POST["kode_jurusan"],
    "status"=>$_POST["status"],
    "jenjang"=>$_POST["jenjang"],
    "nama_jurusan"=>$_POST["nama_jurusan"]
    );
   
   
   

    
    $up = $db->update("jurusan",$data,"id",$_POST["id"]);
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