<?php
session_start();
include "../../inc/config.php";
session_check();
switch ($_GET["act"]) {
  case "in":
  
  
  
  $data = array("nm_wil"=>$_POST["nm_wil"],);
  
  
  
   
    $in = $db->insert("kewarganegaraan",$data);
    
    if ($in=true) {
      echo "good";
    } else {
      return false;
    }
    break;
  case "delete":
    
    
    
    $db->delete("kewarganegaraan","kewarganegaraan",$_GET["id"]);
    break;
  case "up":
   $data = array("nm_wil"=>$_POST["nm_wil"],);
   
   
   

    
    $up = $db->update("kewarganegaraan",$data,"kewarganegaraan",$_POST["id"]);
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