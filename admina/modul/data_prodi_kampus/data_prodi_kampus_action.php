<?php
session_start();
include "../../inc/config.php";
session_check();
switch ($_GET["act"]) {
  case "in":
  
  
  
  $data = array("nm_lemb"=>$_POST["nm_lemb"],"kode_prodi"=>$_POST["kode_prodi"],);
  
  
  
   
    $in = $db->insert("sms",$data);
    
    if ($in=true) {
      echo "good";
    } else {
      return false;
    }
    break;
  case "delete":
    
    
    
    $db->delete("sms","id_sms",$_GET["id"]);
    break;
  case "up":
   $data = array("nm_lemb"=>$_POST["nm_lemb"],"kode_prodi"=>$_POST["kode_prodi"],);
   
   
   

    
    $up = $db->update("sms",$data,"id_sms",$_POST["id"]);
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