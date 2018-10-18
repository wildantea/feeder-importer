<?php
session_start();
include "../../inc/config.php";
include "../../lib/nusoap/nusoap.php";
$config = $db->fetch_single_row('config_user','id',1);

if ($config->live=='Y') {
  $url = 'http://'.$config->url.':'.$config->port.'/ws/live.php?wsdl'; // gunakan live
} else {
  $url = 'http://'.$config->url.':'.$config->port.'/ws/sandbox.php?wsdl'; // gunakan sandbox
}
$client = new nusoap_client($url, true);
$proxy = $client->getProxy();



# MENDAPATKAN TOKEN
$username = $config->username;
$password = $config->password;
$result = $proxy->GetToken($username, $password);
$token = $result;
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
  

          function myFilter($var){
        return ($var !== NULL && $var !== FALSE && $var !== '');
      }

      $data_mhs = $_POST;

      $data_mhs = array_filter($data_mhs, 'myFilter');

      unset($data_mhs['id_pd']);


      $key_mhs = array('id_pd' => $_POST['id_pd']);
      $data_update_pt = array('key' => $key_mhs , 'data' => $data_mhs);

      $up_mhs =  $proxy->UpdateRecord($token, 'mahasiswa', json_encode($data_update_pt));

                $msg = '';
        $msg =  "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\" >
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>";

        if ($up_mhs['result']['error_code']==0) {
            $msg .= "<font color=\"#3c763d\"> Data Mahasiswa Berhasil di Update</font><br />";
        } else {
           $msg .="<font color=\"#ce4844\" >Data tidak bisa Di Ubah </font>";
            $msg .= "<a data-toggle=\"collapse\" href=\"#collapseExample\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail error</a>";
            //echo "<br />Total: ".$i." baris data";
            $msg .= "<div class=\"collapse\" id=\"collapseExample\">";
          $msg .= "<div class=\"bs-callout bs-callout-danger\"> ".$up_mhs['result']['error_desc']."</div><br />";
            $msg .= "</div>
          </div>";
          }

     echo $msg;

    break;
  default:
    # code...
    break;
}

?>