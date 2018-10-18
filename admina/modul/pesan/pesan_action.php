<?php
session_start();
include "../../inc/config.php";
session_check();
switch ($_GET["act"]) {
  case "in":
  
  
  
  $data = array("isi_pesan"=>$_POST["isi_pesan"],);
  
  
  
   
    $in = $db->insert("pesan",$data);
    
    if ($in=true) {
      echo "good";
    } else {
      return false;
    }
    break;
  case "delete":
    
    
    
    $db->delete("pesan","id",$_GET["id"]);
    break;
  case "up":
   $data = array("isi_pesan"=>$_POST["isi_pesan"],);
   
   
   

    
    $up = $db->update("pesan",$data,"id",$_POST["id"]);
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