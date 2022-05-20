<?php
session_start();
include "../../inc/config.php";


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

function stringInsert($str,$insertstr,$pos)
{
    $str = substr($str, 0, $pos) . $insertstr . substr($str, $pos);
    return $str;
}

function insert_data($data_array) {
  global $db;
  $salt = "XZO";
  $array_data = array($data_array);
  $dt = json_encode($data_array);
  $encode_json = base64_encode($dt);
  $json_after_salt = stringInsert($encode_json,$salt,3);

  return $json_after_salt;
}
session_check();
switch ($_GET["act"]) {
  case "up":
     //default port
    $port = $_POST['port'];

      $file_headers = @get_headers('http://'.$_POST["url"].':'.$port.'/ws/live2.php');


      if (!is_connected($_POST["url"],$port)) {
              $status = 'Server PDDIKTI tidak aktif';
      } else {
           if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
              $status = 'Tidak menemukan PDDIKTI Server/Url Salah';
            } else {

      $datas = array(
        'act' => 'GetToken',
        'username' => $_POST["username"],
        'password' => $_POST["password"]
      );
      $result = service_request($datas,'http://'.$_POST["url"].':'.$port.'/ws/live2.php'); // gunakan sandbox);
      if ($result->data) {
         $token = $result->data->token;
         //dump($token);
         //get profil pt
          $data_dic = array(
            'act' => 'GetProfilPT',
            'token' => $token,
            'filter' => "",
            'order' => "",
            'limit' => 3,
            'offset' => 0
          );

          $hasil = service_request($data_dic,'http://'.$_POST["url"].':'.$port.'/ws/live2.php');
          if ($hasil->data) {
              //dump($hasil->data);
              $data = array(
                "username"=> insert_data($_POST["username"]),
                "password"=> insert_data($_POST["password"]),
                "url"=>$_POST["url"],
                "port"=>$port,
                "kode_pt"=> $db->trimmer($hasil->data[0]->kode_perguruan_tinggi),
                "id_sp" => $hasil->data[0]->id_perguruan_tinggi,
                "live" => 'Y',
              );
          }

         $status = 'good';

         $up = $db->update("config_user",$data,"id",$_POST["id"]);

      } else {
         $status = "ERROR: ".$result->error_desc;
         //exit();
      }

    }
      
}

      echo $status;
    break;
  default:
    # code...
    break;
}

?>