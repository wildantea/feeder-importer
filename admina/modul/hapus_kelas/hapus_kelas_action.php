<?php
session_start();
include "../../inc/config.php";
session_check();
switch ($_GET["act"]) {
  case "in":
  
  
  
  $data = array("nim"=>$_POST["nim"],"nama"=>$_POST["nama"],);
  
  
  
   
    $in = $db->insert("krs",$data);
    
    if ($in=true) {
      echo "good";
    } else {
      return false;
    }
    break;
  case "delete":
    
    
    
    $db->delete("krs","id",$_GET["id"]);
    break;
  case "up":
   $data = array("nim"=>$_POST["nim"],"nama"=>$_POST["nama"],);
   
   
   

    
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