<?php
session_start();
include "../../inc/config.php";
include "../../lib/nusoap/nusoap.php";

 function is_connected($url,$port)
      {
       
        if(!$sock = @fsockopen($url, $port))
        {
           return false;
        }
        else
        {
            return true;
        }

      }
session_check();
switch ($_GET["act"]) {
  case "in":
  
  
  
  $data = array("username"=>$_POST["username"],"password"=>$_POST["password"],"url"=>$_POST["url"],"port"=>$_POST["port"],"kode_pt"=>$_POST["kode_pt"],);
  
  
  
   if(isset($_POST["live"])=="on")
    {
      $live = array("live"=>"Y");
      $data=array_merge($data,$live);
    } else { 
      $live = array("live"=>"N");
      $data=array_merge($data,$live);
    }
    $in = $db->insert("config_user",$data);
    
    if ($in=true) {
      echo "good";
    } else {
      return false;
    }
    break;
  case "delete":
    
    
    
    $db->delete("config_user","id",$_GET["id"]);
    break;
  case "up":

     

   $data = array("username"=>$_POST["username"],"password"=>$_POST["password"],"url"=>$_POST["url"],"port"=>$_POST["port"],"kode_pt"=>$_POST["kode_pt"]);
   
   
   

    if(isset($_POST["live"])=="on")
    {
      $live = array("live"=>"Y");
      $data=array_merge($data,$live);
    } else { 
      $live = array("live"=>"N");
      $data=array_merge($data,$live);
    }
    


         function isValidMd5($result)
        {
             return preg_match('/^[a-f0-9]{32}$/i', $result);
        }

     
        $url = 'http://'.$_POST["url"].':'.$_POST["port"].'/ws/live.php?wsdl'; // gunakan sandbox

     
            $file_headers = @get_headers('http://'.$_POST["url"].':'.$_POST["port"].'/ws/mahasiswa.php');


      if (!is_connected($_POST["url"],$_POST["port"])) {


              $status = 'Server PDDIKTI tidak aktif';

          

      } else {

           if($file_headers[0] == 'HTTP/1.1 404 Not Found') {


              $status = 'Tidak menemukan PDDIKTI Server/Url Salah';

            } else {


   
   
           //untuk coba-coba
        // $url = 'http://pddikti.uinsgd.ac.id:8082/ws/live.php?wsdl'; // gunakan live bila

        $client = new nusoap_client($url, true);
        $proxy = $client->getProxy();

        # MENDAPATKAN TOKEN
        $username = $_POST["username"];
        $password = $_POST["password"];
        $result = "";
        $result = $proxy->GetToken($username, $password);
        $token = $result;
       
        if (isValidMd5($result)) {
            $filter_sp = "npsn='".$_POST['kode_pt']."' and soft_delete='0'";
            $get_id_sp = $proxy->GetRecord($token,'satuan_pendidikan',$filter_sp);
            if (empty($get_id_sp['result'])) {
              $status = "Kode PT tidak ditemukan di feeder";
            } else {
              $status = 'good';
              $data_sp = array('id_sp' => $get_id_sp['result']['id_sp']);
              $db->update("config_user",$data_sp,"id",$_POST["id"]);
            }
        } else {
           $status = "ERROR: username/password salah";
        }

    

        }
      }
      $up = $db->update("config_user",$data,"id",$_POST["id"]);

      echo $status;
    break;
  default:
    # code...
    break;
}

?>