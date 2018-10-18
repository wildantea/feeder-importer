<?php
session_start();
include "../../inc/config.php";
session_check();
switch ($_GET["act"]) {
  case "in":
  
  
  
  $data = array("id_wil"=>$_POST["id_wil"],"nm_wil"=>$_POST["nm_wil"],"id_level_wil"=>$_POST["id_level_wil"],);
  
  
  
   
    $in = $db->insert("data_wilayah",$data);
    
    if ($in=true) {
      echo "good";
    } else {
      return false;
    }
    break;
  case "delete":
    
    
    
    $db->delete("data_wilayah","id",$_GET["id"]);
    break;
  case "up":
   $data = array("id_wil"=>$_POST["id_wil"],"nm_wil"=>$_POST["nm_wil"],"id_level_wil"=>$_POST["id_level_wil"],);
   
   
   

    
    $up = $db->update("data_wilayah",$data,"id",$_POST["id"]);
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